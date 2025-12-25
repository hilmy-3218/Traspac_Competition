<?php
// Cek status sesi dan mulai jika belum aktif
if (session_status() === PHP_SESSION_NONE) session_start();
// Hubungkan ke file konfigurasi database
require_once __DIR__ . '/../config/db.php';

// --- LOGIKA PENGHAPUSAN OTOMATIS (>= 30 HARI) ---
try {
    // Tentukan batas waktu pembersihan data 30 hari yang lalu
    $thirty_days_ago = date('Y-m-d H:i:s', strtotime('-30 days'));

    // Cari ID diskusi utama yang sudah melewati batas waktu
    $stmt_old_ids = $pdo->prepare("SELECT id FROM diskusi WHERE created_at < :thirty_days_ago");
    $stmt_old_ids->execute(['thirty_days_ago' => $thirty_days_ago]);
    $old_diskusi_ids = $stmt_old_ids->fetchAll(PDO::FETCH_COLUMN, 0);

    if (!empty($old_diskusi_ids)) {
        // Buat placeholder (?) sesuai jumlah ID untuk query IN
        $ids_placeholder = implode(',', array_fill(0, count($old_diskusi_ids), '?'));
        
        // Hapus semua balasan yang terikat pada diskusi lama tersebut
        $stmt_delete_replies = $pdo->prepare("DELETE FROM diskusi_reply WHERE diskusi_id IN ($ids_placeholder)");
        $stmt_delete_replies->execute($old_diskusi_ids);
    
        // Hapus diskusi utama yang usianya sudah lebih dari 30 hari
        $stmt_delete_main = $pdo->prepare("DELETE FROM diskusi WHERE created_at < :thirty_days_ago");
        $stmt_delete_main->execute(['thirty_days_ago' => $thirty_days_ago]);
    }
} catch (PDOException $e) {
    // Catat error pembersihan ke log sistem tanpa mengganggu user
    error_log("Error during automatic chat cleanup: " . $e->getMessage());
}

// --- PROTEKSI LOGIN ---
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// --- AMBIL DATA PROFIL & LOGIKA AVATAR ---
try {
    // Ambil detail data pengguna berdasarkan ID sesi
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Tendang jika user tidak ditemukan di database
    if (!$user) {
        header("Location: ../auth/login.php");
        exit;
    }

    // Sanitasi data user untuk keamanan output (XSS)
    $nama    = htmlspecialchars($user['nama']);
    $jurusan = htmlspecialchars($user['jurusan']); 
    $role    = htmlspecialchars($user['role']);
    $email   = htmlspecialchars($user['email']);
    
    // Ambil inisial nama untuk avatar default
    $initial = strtoupper(substr($nama, 0, 1));

    // Definisi pasangan warna background dan border avatar
    $warna_map = [
        "bg-red-500" => "border-red-500", "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500", "bg-green-500" => "border-green-500",
        "bg-blue-500" => "border-blue-500", "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500", "bg-pink-500" => "border-pink-500"
    ];

    // Simpan warna avatar di sesi agar tetap sama saat refresh halaman
    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        $bg_random = array_rand($warna_map);
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $warna_map[$bg_random];
    } else {
        $bg_random = $_SESSION['avatar_bg'];
        $border_random = $_SESSION['avatar_border'];
    }

    // Tentukan path foto profil atau null jika tidak menggunakan foto
    $foto = !empty($user['foto_profil']) ? "../" . htmlspecialchars($user['foto_profil']) : null;

} catch (PDOException $e) {
    echo "Terjadi kesalahan database: " . $e->getMessage();
    exit;
}

// --- KIRIM PESAN BARU ---
if (isset($_POST['kirim_pesan'])) {
    $pesan = trim($_POST['pesan']);

    if (!empty($pesan)) {
        $pesan = htmlspecialchars($pesan);
        // Simpan pesan baru ke database sesuai jurusan user
        $insert = $pdo->prepare("INSERT INTO diskusi (user_id, isi, jurusan) VALUES (?, ?, ?)");
        $insert->execute([$user_id, $pesan, $jurusan]); 
    }
    // Segarkan halaman untuk menghindari pengiriman ganda (PRG Pattern)
    header("Location: diskusi.php");
    exit;
}

// --- KIRIM BALASAN (REPLY) ---
if (isset($_POST['kirim_reply'])) {
    $reply = trim($_POST['pesan']); 
    $diskusi_id = $_POST['diskusi_id_reply'];

    if (!empty($reply) && is_numeric($diskusi_id)) {
        $reply = htmlspecialchars($reply);
        // Validasi: pastikan pesan yang dibalas berasal dari jurusan yang sama
        $stmt_check_jurusan = $pdo->prepare("SELECT jurusan FROM diskusi WHERE id = ?");
        $stmt_check_jurusan->execute([$diskusi_id]);
        $diskusi_jurusan = $stmt_check_jurusan->fetchColumn();

        if ($diskusi_jurusan === $jurusan) {
            // Simpan balasan ke tabel reply
            $insertReply = $pdo->prepare("INSERT INTO diskusi_reply (diskusi_id, user_id, isi, jurusan) VALUES (?, ?, ?, ?)");
            $insertReply->execute([$diskusi_id, $user_id, $reply, $jurusan]); 
        }
    }
    header("Location: diskusi.php");
    exit;
}

// --- HAPUS PESAN UTAMA ---
if (isset($_POST['hapus_pesan_utama'])) {
    $diskusi_id = $_POST['diskusi_id'];

    if (is_numeric($diskusi_id)) {
        // Cek otoritas: hanya pemilik pesan di jurusan yang sama yang boleh menghapus
        $stmt_check = $pdo->prepare("SELECT user_id, jurusan FROM diskusi WHERE id = ?");
        $stmt_check->execute([$diskusi_id]);
        $discussion = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($discussion && $discussion['user_id'] == $user_id && $discussion['jurusan'] == $jurusan) {
            // Hapus semua komentar terkait sebelum menghapus pesan utama
            $pdo->prepare("DELETE FROM diskusi_reply WHERE diskusi_id = ?")->execute([$diskusi_id]);
            $pdo->prepare("DELETE FROM diskusi WHERE id = ?")->execute([$diskusi_id]);
        }
    }
    header("Location: diskusi.php");
    exit;
}

// --- AMBIL DATA KONTEN & SIDEBAR ---
// Ambil daftar diskusi utama yang sesuai dengan jurusan user
$stmt = $pdo->prepare("SELECT d.*, u.nama FROM diskusi d JOIN users u ON d.user_id = u.id WHERE d.jurusan = :jurusan_user ORDER BY d.created_at ASC");
$stmt->execute(['jurusan_user' => $jurusan]); 
$pesan = $stmt->fetchAll();

// Ambil daftar Guru dalam jurusan yang sama
$stmtGuru = $pdo->prepare("SELECT nama, email FROM users WHERE jurusan = :jurusan_user AND role = 'guru' ORDER BY nama ASC");
$stmtGuru->execute(['jurusan_user' => $jurusan]);
$guru_jurusan = $stmtGuru->fetchAll(PDO::FETCH_ASSOC);

// Ambil daftar Siswa lain dalam jurusan yang sama
$stmtSiswa = $pdo->prepare("SELECT nama, email FROM users WHERE jurusan = :jurusan_user AND role = 'siswa' AND id != :current_user_id ORDER BY nama ASC");
$stmtSiswa->execute(['jurusan_user' => $jurusan, 'current_user_id' => $user_id]);
$siswa_jurusan = $stmtSiswa->fetchAll(PDO::FETCH_ASSOC);

// Set variabel navigasi sidebar
$linkDiskusi = basename($_SERVER['PHP_SELF']); 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diskusi Jurusan <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Menambahkan kelas untuk efek glassmorphism */
        .glass-effect {
            background-color: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        /* Ubah warna latar belakang chat panel agar background bisa terlihat */
        #chat-panel {
            background-color: transparent;
        }
        .bubble-white {
            background-color: rgba(255, 255, 255, 0.6); 
            border: 1px solid rgba(229, 231, 235, 0.5); 
        }
        .input-glass {
            background-color: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(5px);
        }
        /* Mengatur ulang posisi fixed header/footer untuk mengatasi tumpang tindih dengan background blur */
        .fixed-glass {
            position: fixed;
            z-index: 50;
            width: 100%;
        }
        #chat-feed {
            height: calc(100vh - 120px); /* Memaksa container punya tinggi yang jelas */
            overflow-y: scroll !important; /* Memaksa scrollbar aktif di sini */
            display: flex;
            flex-direction: column;
            scroll-behavior: auto; /* Matikan smooth saat load pertama agar tidak delay */
        }

    </style>   
</head>
<body class="bg-gray-50 min-h-screen">
    
    <!-- Background glow dekoratif -->
    <div class="fixed top-0 left-0 w-[400px] h-[400px] bg-blue-500/20 blur-3xl rounded-full 
                transform -translate-x-1/2 -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-purple-500/20 blur-3xl rounded-full 
                transform translate-x-1/2 translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed top-1/2 left-0 w-[300px] h-[300px] bg-green-500/20 blur-3xl rounded-full 
                transform -translate-x-full -translate-y-1/2 pointer-events-none z-0 hidden lg:block"></div>
    <div class="fixed top-10 left-1/2 w-[250px] h-[250px] bg-yellow-400/20 blur-3xl rounded-full 
                transform -translate-x-1/2 pointer-events-none z-0 hidden sm:block"></div>
    <div class="fixed top-0 right-0 w-[350px] h-[350px] bg-pink-500/15 blur-3xl rounded-full 
                transform translate-x-1/3 -translate-y-1/3 pointer-events-none z-0"></div>

    <!-- loader -->
    <div id="top-loader" class="fixed top-0 left-0 h-[3px] w-0 bg-blue-600 z-[9999] transition-all duration-300"></div>

    <!-- header hanya di mobile -->
    <header class="fixed top-0 left-0 w-full h-12 bg-gray-800/75 backdrop-blur-md text-white shadow-xl z-50 md:hidden">
        <div class="h-full flex items-center justify-between px-3">

            <button id="sidebarToggle" 
                class="p-1.5 text-gray-300 rounded-lg hover:bg-gray-700 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 
                    transition duration-150">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <div class="flex-1 text-center">
                <h1 class="text-xl font-extrabold tracking-tight">
                    Diskusi <span class="text-indigo-200"><?= $jurusan ?></span>
                </h1>
            </div>

            <button id="toggle-sidebar-kanan-btn" class="lg:hidden text-white hover:text-indigo-100 focus:outline-none p-2">
                <i class="fas fa-users h-5 w-5"></i>
            </button>

        </div>
    </header>

    <div class="flex flex-1 overflow-hidden pt-12 md:pt-0">

        <!-- Sidebar (Desktop & Mobile Menu) -->
        <?php require_once __DIR__ . '/../private/sidebar.php';?>

        <div id="chat-panel" class="flex flex-col flex-1 relative overflow-hidden pb-24 md:pb-6">

            <main id="chat-feed" class="p-4 md:p-8 main-content overflow-y-auto pt-16 md:pt-8 md:ml-64 lg:mr-72">

                <?php if (empty($pesan)): ?>
                    <!-- Tidak ada diskusi -->
                    <div class="flex flex-col items-center justify-center h-full text-center text-gray-500 pt-16">
                        <i class="fas fa-comments text-4xl mb-3 text-indigo-300"></i>
                        <p class="text-lg font-medium">Belum ada diskusi.</p>
                        <p class="text-sm">
                            Jadilah yang pertama memulai topik diskusi di jurusan
                            <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?>.
                        </p>
                    </div>
                <?php endif; ?>

                <?php foreach ($pesan as $row): 
                    // Cek pemilik pesan
                    $is_current_user = ($row['user_id'] == $user_id);

                    // Ambil balasan pesan
                    $replyStmt = $pdo->prepare("
                        SELECT r.*, u.nama, u.role 
                        FROM diskusi_reply r
                        JOIN users u ON r.user_id = u.id
                        WHERE r.diskusi_id = ?
                        ORDER BY r.created_at ASC
                    ");
                    $replyStmt->execute([$row['id']]);
                    $replies = $replyStmt->fetchAll();
                ?>
                
                <!-- Posisi pesan (kanan/kiri) -->
                <div class="flex <?= htmlspecialchars($is_current_user ? 'justify-end' : 'justify-start', ENT_QUOTES, 'UTF-8'); ?> mb-4">

                    <div class="w-full sm:max-w-3/4 md:max-w-[70%] lg:max-w-[60%] flex flex-col">
                        
                        <!-- Bubble pesan (user / non-user) -->
                        <div class="rounded-xl p-3 shadow-lg relative 
                            <?= htmlspecialchars(
                                $is_current_user
                                    ? 'bg-indigo-600/90 text-white rounded-br-md ml-auto'
                                    : 'bubble-white text-gray-800 rounded-tl-md mr-auto',
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>">
                            
                            <!-- Wrapper tombol aksi (posisi kiri/kanan) -->
                            <div class="absolute top-0 p-2 z-20 
                                <?= htmlspecialchars($is_current_user ? 'right-0' : 'left-0', ENT_QUOTES, 'UTF-8'); ?>"> 

                                <!-- Tombol titik tiga -->
                                <button 
                                    id="action-btn-<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>"
                                    onclick="toggleActionsMenu(<?= (int)$row['id']; ?>)"
                                    class="p-1 rounded-full transition duration-150 inline-flex items-center 
                                    <?= htmlspecialchars(
                                        $is_current_user 
                                            ? 'text-indigo-200 hover:text-white hover:bg-indigo-700' 
                                            : 'text-gray-400 hover:text-gray-700 hover:bg-gray-100/50',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ); ?>">
                                    <i class="fas fa-ellipsis-v h-4 w-4"></i>
                                </button>

                                <!-- Menu aksi -->
                                <div id="actions-menu-<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                                    class="hidden absolute mt-1 w-36 bg-white rounded-xl shadow-2xl border z-30 overflow-hidden text-left 
                                    <?= htmlspecialchars($is_current_user ? 'right-0' : 'left-0', ENT_QUOTES, 'UTF-8'); ?>">
                                    
                                    <!-- Tombol balas -->
                                    <button 
                                        onclick="handleReplySelection(
                                            <?= (int)$row['id']; ?>, 
                                            '<?= htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?>'
                                        ); toggleActionsMenu(<?= (int)$row['id']; ?>);"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 transition duration-150">
                                        <i class="fas fa-reply w-4 mr-2"></i>
                                        Balas (<span class="font-bold"><?= htmlspecialchars(count($replies), ENT_QUOTES, 'UTF-8'); ?></span>)
                                    </button>

                                    <?php if ($is_current_user): ?>
                                        <!-- Tombol hapus -->
                                        <button 
                                            id="delete-btn-<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>"
                                            onclick="confirmDelete(<?= (int)$row['id']; ?>);"
                                            data-confirm="false"
                                            class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition duration-150">
                                            <i class="fas fa-trash-alt w-4 mr-2"></i> Hapus
                                        </button>

                                        <!-- Form hapus (hidden) -->
                                        <form method="POST" id="delete-form-<?= htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>" class="hidden">
                                            <input type="hidden" name="diskusi_id" value="<?= (int)$row['id']; ?>">
                                            <input type="hidden" name="hapus_pesan_utama" value="1">
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Konten pesan -->
                            <div class="
                                <?= htmlspecialchars($is_current_user ? 'pr-5 pl-1' : 'pl-5 pr-1', ENT_QUOTES, 'UTF-8'); ?>">

                                <!-- Nama pengirim -->
                                <p class="font-semibold text-xs mb-1 
                                    <?= htmlspecialchars($is_current_user ? 'text-indigo-200' : 'text-indigo-600', ENT_QUOTES, 'UTF-8'); ?>">
                                    <?= $is_current_user ? 'Anda' : htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?>
                                </p>

                                <!-- Isi pesan -->
                                <p class="text-sm break-words leading-relaxed">
                                    <?= nl2br(htmlspecialchars($row['isi'], ENT_QUOTES, 'UTF-8')); ?>
                                </p>

                                <!-- Waktu kirim -->
                                <div class="text-right mt-1">
                                    <small class="text-xs opacity-70">
                                        <?= htmlspecialchars(date("H:i", strtotime($row['created_at'])), ENT_QUOTES, 'UTF-8'); ?>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <?php if ($replies): ?>
                        <!-- Wrapper balasan -->
                        <div class="mt-1.5 ml-4 border-l-2 border-gray-300/50 pl-3 space-y-2 max-w-full sm:max-w-[85%]">

                            <!-- Judul balasan -->
                            <p class="text-xs font-bold text-gray-500 mb-1 flex items-center">
                                <i class="fas fa-comments text-xs mr-1"></i>
                                Balasan (<?= htmlspecialchars(count($replies), ENT_QUOTES, 'UTF-8'); ?>)
                            </p>

                            <?php foreach ($replies as $rp): 
                                // Cek pemilik balasan
                                $is_reply_user = ($rp['user_id'] == $user_id);

                                // Tentukan icon role
                                $role_icon = ($rp['role'] === 'guru')
                                    ? 'fas fa-chalkboard-teacher text-indigo-500'
                                    : 'fas fa-user-graduate text-green-500';
                            ?>
                                <!-- Bubble balasan -->
                                <div class="relative p-2 rounded-lg glass-effect shadow-md transition duration-150 ease-in-out hover:shadow-xl w-full">
                                    <!-- Header balasan -->
                                    <div class="flex justify-between items-start mb-1">
                                        <p class="font-semibold text-xs flex items-center flex-1 
                                            <?= htmlspecialchars($is_reply_user ? 'text-gray-700' : 'text-indigo-700', ENT_QUOTES, 'UTF-8'); ?>">
                                            
                                            <!-- Icon role -->
                                            <i class="<?= htmlspecialchars($role_icon, ENT_QUOTES, 'UTF-8'); ?> w-3.5 mr-1.5"></i>

                                            <!-- Nama pengirim -->
                                            <?= $is_reply_user ? 'Anda' : htmlspecialchars($rp['nama'], ENT_QUOTES, 'UTF-8'); ?>

                                            <!-- Badge guru -->
                                            <?php if ($rp['role'] === 'guru'): ?>
                                                <span class="ml-2 text-[10px] font-normal text-white bg-indigo-500 px-1.5 py-0.5 rounded-full">
                                                    Guru
                                                </span>
                                            <?php endif; ?>
                                        </p>

                                        <!-- Waktu balasan -->
                                        <small class="text-gray-700 text-[10px] flex-shrink-0 ml-2 opacity-80">
                                            <?= htmlspecialchars(date("H:i", strtotime($rp['created_at'])), ENT_QUOTES, 'UTF-8'); ?>
                                        </small>
                                    </div>

                                    <!-- Isi balasan -->
                                    <p class="text-sm text-gray-900 break-words leading-snug">
                                        <?= nl2br(htmlspecialchars($rp['isi'], ENT_QUOTES, 'UTF-8')); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php endforeach; ?>

            </main>
            <!-- input -->
            <footer class="fixed bottom-12 md:bottom-0 z-[55]
                        w-full p-2 border-t shadow-2xl
                        md:left-64 md:right-0 md:w-auto md:p-4
                        lg:right-72 lg:w-auto lg:p-4
                        bg-white/20 backdrop-blur-lg flex-shrink-0">
                
                <div id="reply-bar" class="hidden bg-indigo-100/80 border-l-4 border-indigo-600 p-1.5 mb-1 rounded-lg text-xs transition-all duration-300">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-indigo-800">
                            Membalas: <span id="reply-to-name" class="font-bold"></span>
                        </p>
                        <button type="button" onclick="cancelReply()" class="text-indigo-600 hover:text-indigo-800 p-1 rounded-full hover:bg-indigo-200">
                            <i class="fas fa-times h-3 w-3"></i>
                        </button>
                    </div>
                </div>

                <form method="POST" id="main-message-form" class="flex items-center space-x-1">
                    <!-- ID diskusi untuk balasan -->
                    <input type="hidden" name="diskusi_id_reply" id="diskusi-id-reply" value="">

                    <!-- Input pesan (dibatasi & aman) -->
                    <input type="text"
                        name="pesan"
                        required
                        maxlength="500"
                        autocomplete="off"
                        placeholder="Ketik pesan..."
                        class="input-glass flex-1 border-2 border-gray-300 rounded-full px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-indigo-400">

                    <!-- Tombol kirim -->
                    <button type="submit"
                            name="kirim_pesan"
                            id="kirim-pesan-btn"
                            class="bg-indigo-600 text-white px-2 py-1 rounded-full shadow-md hover:bg-indigo-700 transition duration-150 flex items-center justify-center min-w-[32px] min-h-[32px]">
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </form>

            </footer>         
        </div>

        <aside id="sidebar-kanan" 
            class="fixed inset-y-0 right-0 w-72 glass-effect border-l p-4 overflow-y-auto shadow-2xl z-[60] transform translate-x-full 
            lg:translate-x-0 lg:block lg:h-screen transition-transform duration-300 ease-in-out flex-shrink-0">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <!-- Judul anggota -->
                <h2 class="text-lg font-bold text-indigo-700">Anggota <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?></h2>
                <button id="close-sidebar-kanan-btn" class="lg:hidden text-gray-500 hover:text-gray-800">
                    <i class="fas fa-times h-5 w-5"></i>
                </button>
            </div>

            <div class="mb-6 pb-4 border-b border-indigo-100 bg-white/60 p-3 rounded-lg shadow-sm">
                <div class="flex flex-col items-center text-center">

                    <!-- Avatar foto / inisial -->
                    <?php if ($foto): ?>
                        <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" 
                            alt="<?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?> Avatar" 
                            class="h-16 w-16 rounded-full object-cover border-4 <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?> shadow-md">
                    <?php else: ?>
                        <div class="h-16 w-16 flex items-center justify-center rounded-full text-xl font-bold text-white border-4 
                            <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?> 
                            <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?> shadow-md">
                            <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Nama user -->
                    <h3 class="text-lg font-bold text-gray-900 mt-3 mb-1">
                        <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?>
                        <span class="text-sm text-indigo-600 font-normal">(Anda)</span>
                    </h3>
                    
                    <!-- Info role & jurusan -->
                    <div class="text-sm text-gray-600 space-y-0.5">
                        <p class="capitalize">
                            <span class="font-semibold text-indigo-600">
                                <?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </p>
                        <p><?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <!-- Judul & jumlah guru -->
                <h3 class="text-md font-semibold text-gray-700 mb-2 border-b pb-1 flex justify-between items-center">
                    Guru Jurusan
                    <span class="text-xs font-normal text-indigo-500 bg-indigo-50/50 px-2 py-0.5 rounded-full">
                        <?= htmlspecialchars(count($guru_jurusan), ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                </h3>

                <!-- List guru -->
                <ul class="space-y-2">
                    <?php if (empty($guru_jurusan)): ?>
                        <!-- Jika kosong -->
                        <li class="text-sm text-gray-500 italic">Tidak ada guru terdaftar.</li>
                    <?php else: ?>
                        <?php foreach ($guru_jurusan as $guru): ?>
                            <!-- Item guru -->
                            <li class="p-2 bg-white/70 rounded-lg text-sm truncate flex items-center hover:bg-white/90 transition duration-100"
                                title="<?= htmlspecialchars($guru['email'], ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="fas fa-chalkboard-teacher text-indigo-500 mr-2 flex-shrink-0"></i>
                                <span class="font-medium text-gray-800">
                                    <?= htmlspecialchars($guru['nama'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div>
                <!-- Judul & jumlah siswa -->
                <h3 class="text-md font-semibold text-gray-700 mb-2 border-b pb-1 flex justify-between items-center">
                    Siswa Jurusan
                    <span class="text-xs font-normal text-green-500 bg-green-50/50 px-2 py-0.5 rounded-full">
                        <?= htmlspecialchars(count($siswa_jurusan), ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                </h3>

                <!-- List siswa -->
                <ul class="space-y-2">
                    <?php if (empty($siswa_jurusan)): ?>
                        <!-- Jika kosong -->
                        <li class="text-sm text-gray-500 italic">Tidak ada siswa lain terdaftar.</li>
                    <?php else: ?>
                        <?php foreach ($siswa_jurusan as $siswa): ?>
                            <!-- Item siswa -->
                            <li class="p-2 bg-white/70 rounded-lg text-sm truncate flex items-center hover:bg-white/90 transition duration-100"
                                title="<?= htmlspecialchars($siswa['email'], ENT_QUOTES, 'UTF-8'); ?>">
                                <i class="fas fa-user-graduate text-green-500 mr-2 flex-shrink-0"></i>
                                <span class="font-medium text-gray-800">
                                    <?= htmlspecialchars($siswa['nama'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </aside>

        <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
        <?php require_once __DIR__ . '/../private/nav-bottom.php';?>

        <div id="overlay-kanan" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden" onclick="closeSidebarKanan()"></div>
    </div>

    <script src="../assets/js/diskusi.js"></script>
</body>

</html>
