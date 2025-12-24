<?php
// Pastikan sesi aktif
if (session_status() === PHP_SESSION_NONE) session_start();
// Muat koneksi database
require_once __DIR__ . '/../config/db.php';

// Proteksi login: wajib masuk untuk akses halaman
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// --- DATA USER & LOGIKA AVATAR ---
try {
    // Ambil detail profil pengguna
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: login.php");
        exit;
    }

    // Sanitasi data user (XSS protection)
    $nama    = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role    = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $initial = strtoupper(substr($nama, 0, 1));
    
    // Kelola warna avatar agar tetap sama selama sesi berlangsung
    $warna_map = [
        "bg-red-500" => "border-red-500", "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500", "bg-green-500" => "border-green-500",
        "bg-blue-500" => "border-blue-500", "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500", "bg-pink-500" => "border-pink-500"
    ];

    if (!isset($_SESSION['avatar_bg'])) {
        $bg_random = array_rand($warna_map);
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $warna_map[$bg_random];
    }
    $bg_random = $_SESSION['avatar_bg'];
    $border_random = $_SESSION['avatar_border'];

    // Atur path foto profil
    $foto = !empty($user['foto_profil']) ? "../" . htmlspecialchars($user['foto_profil']) : null;

} catch (PDOException $e) {
    header("Location: login.php?error=db_error");
    exit;
}

// Cek hak akses guru & generate link diskusi
$isGuru = $role === 'guru';

// --- CRUD PENGUMUMAN (HANYA GURU) ---

// 1. Hapus Pengumuman
if ($isGuru && isset($_GET['delete_id'])) {
    $delete_id = filter_input(INPUT_GET, 'delete_id', FILTER_VALIDATE_INT);
    if ($delete_id) {
        // Ambil path file sebelum data dihapus untuk menghapus file fisik
        $stmt_file = $pdo->prepare("SELECT file_attachment FROM pengumuman WHERE id = :id");
        $stmt_file->execute(['id' => $delete_id]);
        $file_data = $stmt_file->fetch();
        
        if ($file_data && !empty($file_data['file_attachment'])) {
            $physical_path = __DIR__ . '/../' . $file_data['file_attachment'];
            if (file_exists($physical_path)) {
                unlink($physical_path);
            }
        }

        $stmt = $pdo->prepare("DELETE FROM pengumuman WHERE id = :id");
        $stmt->execute(['id' => $delete_id]);
    }
    header("Location: pengumuman.php");
    exit;
}

// 2. Tambah Pengumuman Baru (Termasuk Upload File)
if ($isGuru && $_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['delete_id'])) {
    $judul = filter_input(INPUT_POST, 'judul', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $isi   = filter_input(INPUT_POST, 'isi', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $file_db_path = null;

    // Logika Upload File
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../uploads/pengumuman/';
        
        // Buat folder jika belum ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_original_name = basename($_FILES['attachment']['name']);
        $file_extension = strtolower(pathinfo($file_original_name, PATHINFO_EXTENSION));
        
        // Nama file unik untuk menghindari duplikasi
        $new_file_name = time() . '_' . bin2hex(random_bytes(4)) . '.' . $file_extension;
        $target_path = $upload_dir . $new_file_name;

        // Tipe file yang diizinkan
        $allowed_types = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip', 'txt'];

        if (in_array($file_extension, $allowed_types)) {
            if (move_uploaded_file($file_tmp, $target_path)) {
                $file_db_path = 'uploads/pengumuman/' . $new_file_name;
            }
        }
    }

    if ($judul && $isi) {
        $stmt = $pdo->prepare("INSERT INTO pengumuman (guru_id, judul, isi, file_attachment) VALUES (:guru_id, :judul, :isi, :file)");
        $stmt->execute([
            'guru_id' => $user_id, 
            'judul' => $judul, 
            'isi' => $isi,
            'file' => $file_db_path
        ]);
    }
    header("Location: pengumuman.php");
    exit;
}

// --- AMBIL DATA UNTUK DITAMPILKAN ---
try {
    $stmt = $pdo->prepare("SELECT p.*, u.nama as guru_nama FROM pengumuman p JOIN users u ON p.guru_id = u.id ORDER BY tanggal DESC");
    $stmt->execute();
    $pengumuman = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $pengumuman = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .form-container { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out; }
        .form-container.open { max-height: 1200px; padding-top: 20px; }
        .toggle-icon { transition: transform 0.3s ease; }
        .toggle-icon.open { transform: rotate(45deg); }
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

    <header class="fixed top-0 left-0 w-full h-12 bg-gray-800/75 backdrop-blur-md text-white shadow-xl z-40 md:hidden">
        <div class="h-full flex items-center justify-between px-3">
            <button id="sidebarToggle" class="p-1.5 text-gray-300 rounded-lg hover:bg-gray-700 focus:outline-none">
                <i class="fas fa-bars text-lg"></i>
            </button>
            <div class="flex items-center">
                <?php if ($foto): ?>
                    <img src="<?= htmlspecialchars($foto); ?>" class="w-7 h-7 rounded-full object-cover border <?= htmlspecialchars($border_random); ?>">
                <?php else: ?>
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-sm font-bold border <?= htmlspecialchars($bg_random); ?> <?= htmlspecialchars($border_random); ?>">
                        <?= htmlspecialchars($initial); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    
    <?php require_once __DIR__ . '/../private/sidebar.php';?>

    <main class="p-4 md:p-8 main-content overflow-y-auto md:ml-64 pt-16 md:pt-8 pb-24 md:pb-0 relative z-10"> 
        <div class="max-w-4xl mx-auto">
            
            <?php if($isGuru): ?>
            <div class="bg-white p-6 rounded-xl shadow-xl mb-10 border-t-4 border-indigo-500">
                <div class="flex justify-between items-center cursor-pointer" onclick="togglePengumumanForm()">
                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-plus-circle text-indigo-500 mr-3"></i>
                        Buat Pengumuman Baru
                    </h2>
                    <button type="button" class="p-2 bg-indigo-500 text-white rounded-full shadow-lg hover:bg-indigo-600 transition duration-300 w-10 h-10 flex items-center justify-center">
                        <i id="toggleIcon" class="fas fa-plus toggle-icon text-xl"></i>
                    </button>
                </div>
                <div id="pengumumanFormContainer" class="form-container">
                    <form method="POST" enctype="multipart/form-data" class="space-y-5">
                        <div>
                            <label for="judul" class="block mb-1 font-semibold text-gray-700">Judul Pengumuman</label>
                            <input type="text" id="judul" name="judul" required class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                        </div>
                        <div>
                            <label for="isi" class="block mb-1 font-semibold text-gray-700">Isi Pengumuman</label>
                            <textarea id="isi" name="isi" required rows="5" class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                        </div>
                        <div>
                            <label for="attachment" class="block mb-1 font-semibold text-gray-700">Lampiran File (Opsional)</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed border-gray-300 rounded-lg hover:bg-gray-50 hover:border-indigo-400 transition cursor-pointer">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                        <p class="text-sm text-gray-500">Klik untuk pilih file (PDF, Gambar, Word, Zip)</p>
                                    </div>
                                    <input type="file" id="attachment" name="attachment" class="hidden" />
                                </label>
                            </div>
                            <p id="file-name-display" class="text-xs text-indigo-600 mt-2 font-medium"></p>
                        </div>
                        <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 transition transform hover:scale-[1.01]">
                            <i class="fas fa-save mr-2"></i> Terbitkan Pengumuman
                        </button>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <h2 class="text-2xl font-extrabold mb-6 text-gray-800 border-b pb-2 border-gray-300">
                Semua Pengumuman
            </h2>
            
            <div class="space-y-6">
                <?php if($pengumuman): ?>
                    <?php foreach($pengumuman as $p): ?>
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 hover:shadow-xl transition duration-300">
                            <!-- Judul posting -->
                            <h3 class="font-extrabold text-xl mb-2 text-indigo-700">
                                <?php echo htmlspecialchars($p['judul'], ENT_QUOTES, 'UTF-8'); ?>
                            </h3>

                            <!-- Isi posting -->
                            <div class="text-gray-700 mt-3 mb-4 text-base leading-relaxed">
                                <?php echo nl2br(htmlspecialchars($p['isi'], ENT_QUOTES, 'UTF-8')); ?>
                            </div>

                            <!-- Jika ada lampiran -->
                            <?php if (!empty($p['file_attachment'])): ?>

                                <!-- Box lampiran -->
                                <div class="mb-5 p-3 bg-indigo-50 rounded-lg border border-indigo-100 flex items-center justify-between">

                                    <!-- Info file -->
                                    <div class="flex items-center text-indigo-800 overflow-hidden">
                                        <i class="fas fa-file-download mr-3 text-xl text-indigo-500"></i>
                                        <span class="text-sm font-semibold truncate">
                                            Lampiran: <?php echo htmlspecialchars(basename($p['file_attachment']), ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </div>

                                    <!-- Tombol unduh -->
                                    <a href="../<?php echo htmlspecialchars($p['file_attachment'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" download
                                    class="ml-4 flex-shrink-0 bg-indigo-600 text-white px-4 py-1.5 rounded-md text-xs font-bold hover:bg-indigo-700 transition shadow-sm">
                                        UNDUH
                                    </a>

                                </div>
                            <?php endif; ?>

                            <!-- Footer posting -->
                            <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center text-sm flex-wrap gap-2">

                                <!-- Nama guru -->
                                <span class="text-gray-500 font-medium flex items-center">
                                    <i class="fas fa-user-circle text-indigo-400 mr-2"></i>
                                    Oleh:
                                    <span class="text-indigo-600 ml-1 font-semibold">
                                        <?php echo htmlspecialchars($p['guru_nama'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                </span>

                                <!-- Tanggal posting -->
                                <span class="text-gray-500 flex items-center">
                                    <i class="fas fa-clock text-indigo-400 mr-2"></i>
                                    <?php echo date('d F Y, H:i', strtotime($p['tanggal'])); ?>
                                </span>

                                <!-- Tombol hapus (guru) -->
                                <?php if ($isGuru): ?>
                                    <button onclick="openDeleteModal(<?php echo (int)$p['id']; ?>)"
                                        class="ml-auto px-3 py-1 bg-red-500 text-white rounded-lg text-xs font-semibold hover:bg-red-600 shadow-md">
                                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                                    </button>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-white p-10 rounded-xl shadow-md border border-gray-200 text-center">
                        <i class="fas fa-bell-slash text-gray-300 text-5xl mb-4"></i>
                        <p class="text-gray-500 font-medium">Belum ada pengumuman untuk saat ini.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>

    <div id="deleteModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-6">
            <h3 class="text-xl font-bold text-red-600 mb-2 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i> Konfirmasi
            </h3>
            <p class="text-gray-600 mb-6 text-sm leading-relaxed">Hapus pengumuman ini? Lampiran file juga akan dihapus dari server selamanya.</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeDeleteModal()" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-700">Batal</button>
                <a id="confirmDeleteButton" href="#" class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-md">Ya, Hapus</a>
            </div>
        </div>
    </div>

    <script>
        const formContainer = document.getElementById('pengumumanFormContainer');
        const toggleIcon = document.getElementById('toggleIcon');
        const deleteModal = document.getElementById('deleteModal');
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');

        function togglePengumumanForm() {
            formContainer.classList.toggle('open');
            toggleIcon.classList.toggle('open');
        }

        function openDeleteModal(id) {
            confirmDeleteButton.href = `pengumuman.php?delete_id=${id}`;
            deleteModal.classList.replace('hidden', 'flex');
        }

        function closeDeleteModal() {
            deleteModal.classList.replace('flex', 'hidden');
        }

        // Tampilkan nama file saat dipilih
        document.getElementById('attachment').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "";
            document.getElementById('file-name-display').innerText = fileName ? "Terpilih: " + fileName : "";
        });
    </script>
</body>
</html>