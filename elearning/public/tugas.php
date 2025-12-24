<?php
/**
 * SISTEM MANAJEMEN TUGAS
 * Menangani autentikasi, manajemen tugas (Guru), 
 * dan pengumpulan tugas (Siswa).
 */

if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';

$success = "";
$error = "";

// Mengambil feedback pesan dari URL (Post-Redirect-Get pattern)
if (isset($_GET['success'])) {
    $success = htmlspecialchars(urldecode($_GET['success']));
}
if (isset($_GET['error'])) {
    $error = htmlspecialchars(urldecode($_GET['error']));
}

// Validasi status login pengguna
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Fetch data profil pengguna
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: login.php");
        exit;
    }

    // Inisialisasi identitas dan tampilan avatar
    $nama    = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role    = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $initial = strtoupper(substr($nama, 0, 1));
    
    $warna_map = [
        "bg-red-500" => "border-red-500", "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500", "bg-green-500" => "border-green-500",
        "bg-blue-500" => "border-blue-500", "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500", "bg-pink-500" => "border-pink-500"
    ];

    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        $bg_random = array_rand($warna_map);
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $warna_map[$bg_random];
    }
    $bg_random = $_SESSION['avatar_bg'];
    $border_random = $_SESSION['avatar_border'];

    $foto = !empty($user['foto_profil']) ? "../" . htmlspecialchars($user['foto_profil']) : null;

} catch (PDOException $e) {
    header("Location: login.php?error=db_error");
    exit;
}

// === LOGIKA GURU: TAMBAH TUGAS BARU ===
if ($role === "guru" && isset($_POST['tambah_tugas'])) {
    $judul    = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    $deadline  = $_POST['deadline'];
    $jurusan_tugas = $jurusan;

    if (empty($judul) || empty($deskripsi) || empty($deadline)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        $gambar_files_json = [];
        $all_uploads_successful = true;

        // Proses upload multi-file lampiran tugas
        if (isset($_FILES['gambar']) && !empty(array_filter($_FILES['gambar']['name']))) {
            $file_count = count(array_filter($_FILES['gambar']['name']));
            $folder = __DIR__ . "/../uploads/tugas/";
            
            if (!is_dir($folder)) mkdir($folder, 0777, true);

            for ($i = 0; $i < $file_count; $i++) {
                if ($_FILES['gambar']['error'][$i] === UPLOAD_ERR_OK) {
                    $file_name = $_FILES['gambar']['name'][$i];
                    $filename_safe = time() . "_" . $i . "_" . basename($file_name);
                    $path = $folder . $filename_safe;

                    if (move_uploaded_file($_FILES['gambar']['tmp_name'][$i], $path)) {
                        $gambar_files_json[] = [
                            'name' => $file_name,
                            'path' => "uploads/tugas/" . $filename_safe,
                            'mime' => $_FILES['gambar']['type'][$i]
                        ];
                    } else {
                        $all_uploads_successful = false;
                        $error = "Gagal mengupload: " . $file_name;
                        break;
                    }
                }
            }
        }
        
        // Simpan data tugas ke database
        if ($all_uploads_successful) {
            try {
                $stmt = $pdo->prepare("INSERT INTO tugas (guru_id, jurusan, judul, deskripsi, gambar, deadline) 
                                     VALUES (:guru_id, :jurusan, :judul, :deskripsi, :gambar, :deadline)");
                $stmt->execute([
                    'guru_id' => $user_id,
                    'jurusan' => $jurusan_tugas,
                    'judul' => $judul,
                    'deskripsi' => $deskripsi,
                    'gambar' => json_encode($gambar_files_json),
                    'deadline' => $deadline
                ]);
                
                header("Location: tugas.php?success=" . urlencode("Tugas berhasil ditambahkan!"));
                exit;
            } catch (PDOException $e) {
                $error = "Gagal menyimpan tugas: " . $e->getMessage();
            }
        }
        
        // Cleanup file jika database gagal
        if (!$all_uploads_successful && !empty($gambar_files_json)) {
            foreach ($gambar_files_json as $f) { if (file_exists(__DIR__ . "/../" . $f['path'])) unlink(__DIR__ . "/../" . $f['path']); }
        }
    }
}

// === LOGIKA SISWA: PENGUMPULAN TUGAS ===
if ($role === "siswa" && isset($_POST['kumpulkan'])) {
    $tugas_id = $_POST['tugas_id'];

    // Validasi duplikasi pengumpulan
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM pengumpulan_tugas WHERE tugas_id = :tugas_id AND siswa_id = :siswa_id");
    $stmt_check->execute(['tugas_id' => $tugas_id, 'siswa_id' => $user_id]);
    
    $submitted_files_names = array_filter($_FILES['file_tugas']['name']);

    if ($stmt_check->fetchColumn() > 0) {
        $error = "Anda sudah mengumpulkan tugas ini.";
    } elseif (empty($submitted_files_names)) {
        $error = "Pilih minimal satu file.";
    } else {
        $uploaded_files_json = [];
        $all_uploads_successful = true;
        $folder = __DIR__ . "/../uploads/pengumpulan/";

        if (!is_dir($folder)) mkdir($folder, 0777, true);

        // Upload file jawaban siswa
        foreach ($_FILES['file_tugas']['name'] as $i => $file_name) {
            if (!empty($file_name) && $_FILES['file_tugas']['error'][$i] === UPLOAD_ERR_OK) {
                $filename_safe = time() . "_" . $i . "_" . basename($file_name);
                if (move_uploaded_file($_FILES['file_tugas']['tmp_name'][$i], $folder . $filename_safe)) {
                    $uploaded_files_json[] = [
                        'name' => $file_name,
                        'path' => "uploads/pengumpulan/" . $filename_safe,
                        'mime' => $_FILES['file_tugas']['type'][$i]
                    ];
                } else {
                    $all_uploads_successful = false; break;
                }
            }
        }
        
        if ($all_uploads_successful) {
            try {
                $stmt = $pdo->prepare("INSERT INTO pengumpulan_tugas (tugas_id, siswa_id, jurusan, file_tugas, dikumpulkan_pada) 
                                     VALUES (:tugas_id, :siswa_id, :jurusan, :files, NOW())");
                $stmt->execute([
                    'tugas_id' => $tugas_id, 'siswa_id' => $user_id,
                    'jurusan' => $jurusan, 'files' => json_encode($uploaded_files_json)
                ]);
                header("Location: tugas.php?success=" . urlencode("Tugas dikumpulkan."));
                exit;
            } catch (PDOException $e) { $error = "DB Error: " . $e->getMessage(); }
        }
    }
}

// === LOGIKA SISWA: BATALKAN PENGUMPULAN ===
if ($role === "siswa" && isset($_POST['batal_kumpul'])) {
    $submission_id = $_POST['submission_id'];
    try {
        $stmt = $pdo->prepare("SELECT file_tugas FROM pengumpulan_tugas WHERE id = :id AND siswa_id = :siswa_id");
        $stmt->execute(['id' => $submission_id, 'siswa_id' => $user_id]);
        $sub = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($sub) {
            // Hapus file fisik dan record DB
            $files = json_decode($sub['file_tugas'], true) ?? [];
            foreach ($files as $f) { if (file_exists(__DIR__ . "/../" . $f['path'])) unlink(__DIR__ . "/../" . $f['path']); }
            
            $pdo->prepare("DELETE FROM pengumpulan_tugas WHERE id = :id")->execute(['id' => $submission_id]);
            header("Location: tugas.php?success=" . urlencode("Pengumpulan dibatalkan."));
            exit;
        }
    } catch (PDOException $e) { $error = "Error: " . $e->getMessage(); }
}

// === LOGIKA GURU: HAPUS TUGAS & SEMUA SUBMISI ===
if ($role === "guru" && isset($_POST['delete_tugas'])) {
    $tugas_id = $_POST['tugas_id'];
    try {
        // Hapus file lampiran tugas guru
        $stmt = $pdo->prepare("SELECT gambar FROM tugas WHERE id = :id AND guru_id = :guru_id");
        $stmt->execute(['id' => $tugas_id, 'guru_id' => $user_id]);
        $tugas = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tugas) {
            $t_files = json_decode($tugas['gambar'], true) ?? [];
            foreach ($t_files as $f) { if (file_exists(__DIR__ . "/../" . $f['path'])) unlink(__DIR__ . "/../" . $f['path']); }

            // Hapus file jawaban semua siswa terkait tugas ini
            $stmt_s = $pdo->prepare("SELECT file_tugas FROM pengumpulan_tugas WHERE tugas_id = :tid");
            $stmt_s->execute(['tid' => $tugas_id]);
            foreach ($stmt_s->fetchAll() as $s) {
                foreach (json_decode($s['file_tugas'], true) as $f) { if (file_exists(__DIR__ . "/../" . $f['path'])) unlink(__DIR__ . "/../" . $f['path']); }
            }

            // Hapus data dari database
            $pdo->prepare("DELETE FROM pengumpulan_tugas WHERE tugas_id = :tid")->execute(['tid' => $tugas_id]);
            $pdo->prepare("DELETE FROM tugas WHERE id = :id")->execute(['id' => $tugas_id]);
            
            header("Location: tugas.php?success=" . urlencode("Tugas dihapus permanen."));
            exit;
        }
    } catch (PDOException $e) { $error = "Error: " . $e->getMessage(); }
}

// === PENGAMBILAN DATA UNTUK UI ===
// Ambil list semua tugas sesuai jurusan
$stmt = $pdo->prepare("SELECT t.*, u.nama as nama_guru FROM tugas t JOIN users u ON t.guru_id = u.id WHERE t.jurusan = :j ORDER BY t.created_at DESC");
$stmt->execute(['j' => $jurusan]);
$list_tugas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Map status pengumpulan untuk tampilan siswa
$user_submissions = [];
$submitted_tasks = [];
if ($role === 'siswa') {
    $stmt_status = $pdo->prepare("SELECT id, tugas_id FROM pengumpulan_tugas WHERE siswa_id = :sid");
    $stmt_status->execute(['sid' => $user_id]);
    foreach($stmt_status->fetchAll() as $sub) {
        $submitted_tasks[] = (int)$sub['tugas_id'];
        $user_submissions[(int)$sub['tugas_id']] = $sub['id']; 
    }
}

// Kelompokkan data pengumpulan siswa untuk tampilan guru
$submissions_by_tugas = [];
if ($role === 'guru') {
    $stmt_guru = $pdo->prepare("SELECT pt.*, u.nama as nama_siswa, u.email as email_siswa FROM pengumpulan_tugas pt JOIN users u ON pt.siswa_id = u.id WHERE pt.jurusan = :j");
    $stmt_guru->execute(['j' => $jurusan]);
    foreach ($stmt_guru->fetchAll() as $s) {
        $submissions_by_tugas[$s['tugas_id']][] = $s;
    }
}

/**
 * Helper: Menampilkan icon berdasarkan tipe file
 */
function getFileIcon(string $path, string $mime): string {
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    if (str_starts_with($mime, 'image/')) return '🖼️';
    if (in_array($ext, ['doc', 'docx'])) return '📄';
    if ($ext === 'pdf') return '📕';
    if (in_array($ext, ['zip', 'rar'])) return '📦';
    return '📁';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tugas | <?= $jurusan ?></title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Mengatur font Inter */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #c5d9e8 100%);
        }
        /* Kelas untuk scrollbar horizontal pada file lampiran (mobile/small screen) */
        .file-scroller {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        .file-scroller::-webkit-scrollbar {
            display: none; 
        }
        /* Glassmorphism Input/Textarea/Select Style */
        .glass-input {
            /* bg-white/30 backdrop-blur-sm */
            background-color: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.5); /* Ring tipis */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }
        .glass-input:focus {
            outline: none;
            border-color: rgba(99, 102, 241, 0.7); /* focus:border-indigo-500 */
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3); /* focus:ring-indigo-500 */
        }
        .sidebar-link:hover {
            background-color: #374151; /* gray-700 */
        }
        /* Gaya khusus untuk tab aktif */
        .tab-button.active {
            color: #4f46e5; /* indigo-600 */
            border-bottom-color: #4f46e5; /* indigo-600 */
        }
        /* Gaya default untuk tab tidak aktif */
        .tab-button:not(.active) {
            color: #6b7280; /* gray-500 */
            border-bottom-color: transparent;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen"> <div class="fixed top-0 left-0 w-[400px] h-[400px] bg-blue-500/20 blur-3xl rounded-full 
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
            <button id="sidebarToggle" 
                class="p-1.5 text-gray-300 rounded-lg hover:bg-gray-700 
                focus:outline-none focus:ring-2 focus:ring-indigo-500 
                transition duration-150">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <div class="flex items-center">
                <?php if ($foto): ?>
                    <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                        class="w-7 h-7 rounded-full object-cover border 
                            <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>"
                        alt="Foto Profil">
                <?php else: ?>
                    <div class="w-7 h-7 rounded-full flex items-center justify-center 
                                text-white text-sm font-bold border 
                                <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?> 
                                <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>">
                        <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </header>

    <!-- Sidebar (Desktop & Mobile Menu) -->
    <?php require_once __DIR__ . '/../private/sidebar.php';?>

    <div class="flex-1 overflow-y-auto pt-12 md:pt-0 pb-16 md:ml-64"> 
        
        <div id="deleteModal" class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden items-center justify-center z-50 transition-opacity duration-300 opacity-0" aria-modal="true" role="dialog">
            <div class="bg-white/90 backdrop-blur-lg p-6 sm:p-8 rounded-xl shadow-2xl max-w-sm w-11/12 transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
                <h3 class="text-xl font-bold text-red-600 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.427 2.67-1.427 3.434 0L15.65 10.5c.765 1.427-.246 3-1.892 3H6.242c-1.646 0-2.657-1.573-1.892-3L8.257 3.099zM10 16a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    Konfirmasi Hapus
                </h3>
                <p class="mb-6 text-gray-700">Apakah Anda yakin ingin menghapus tugas ini? Tindakan ini akan menghapus **semua file dan pengumpulan siswa yang terkait** secara permanen.</p>

                <form method="POST" id="deleteForm">
                    <input type="hidden" name="tugas_id" id="tugasIdToDelete">
                    <input type="hidden" name="delete_tugas" value="1">
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition duration-150 font-medium">Batal</button>
                        <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700 transition duration-150 font-medium shadow-md shadow-red-300">Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="max-w-4xl xl:max-w-5xl mx-auto py-6 sm:py-10 px-4 sm:px-6 lg:px-8">

            <!-- Header halaman -->
            <header class="mb-8 p-4 bg-white/50 backdrop-blur-md shadow-lg rounded-xl ring-1 ring-white/70">

                <!-- Judul -->
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900">
                    Tugas Kelas
                </h1>

                <!-- Deskripsi jurusan & user -->
                <p class="text-lg text-gray-600 mt-1">
                    Jurusan <span class="text-indigo-600 font-semibold"><?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?></span>
                    — <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?> (<?= htmlspecialchars(ucfirst($role), ENT_QUOTES, 'UTF-8'); ?>)
                </p>
            </header>

            <!-- Pesan sukses -->
            <?php if (!empty($success)): ?>
                <div class="p-4 mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg shadow-sm font-medium" role="alert">
                    <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <!-- Pesan error -->
            <?php if (!empty($error)): ?>
                <div class="p-4 mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg shadow-sm font-medium" role="alert">
                    <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

            <?php if ($role === "guru"): ?>
            
            <div id="toggleButton" class="mb-8 p-5 sm:p-6 bg-white/50 backdrop-blur-md rounded-xl shadow-lg ring-1 ring-white/70 cursor-pointer transition duration-300 hover:bg-white/80 hover:shadow-xl"
                onclick="toggleTaskForm()">
                <div class="flex items-center justify-between">
                    <span class="text-xl sm:text-2xl font-bold text-gray-800">
                        Buat Tugas Baru
                    </span>
                    <span id="toggleIcon" class="text-indigo-600 transition-transform duration-300 transform rotate-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
            </div>
            <div id="taskFormContainer" class="hidden bg-white/50 backdrop-blur-lg p-6 sm:p-8 rounded-xl shadow-2xl ring-1 ring-white/70 mb-10">
                <!-- Form tambah tugas -->
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="tambah_tugas" value="1">

                    <!-- Judul & deadline -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Judul tugas -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas</label>
                            <input type="text" id="judul" name="judul" class="w-full glass-input rounded-lg p-3" required
                                value="<?= isset($_POST['judul']) ? htmlspecialchars($_POST['judul'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                        </div>

                        <!-- Deadline -->
                        <div>
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-1">Batas Waktu Pengumpulan</label>
                            <input type="datetime-local" id="deadline" name="deadline" class="w-full glass-input rounded-lg p-3" required
                                value="<?= isset($_POST['deadline']) ? htmlspecialchars($_POST['deadline'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-6">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Tugas</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full glass-input rounded-lg p-3" required><?= isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi'], ENT_QUOTES, 'UTF-8') : ''; ?></textarea>
                    </div>

                    <!-- Upload file -->
                    <div class="mt-6">
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 10-2 0v4a3 3 0 11-6 0V7a3 3 0 013-3h3.28a1 1 0 00.948-.684l1.498-4.507A.5.5 0 0014 1.5h-3.28a1 1 0 00-.948.684l-1.498 4.507A.5.5 0 008 7.5z" clip-rule="evenodd" />
                            </svg>
                            Upload File Materi
                        </label>
                        <input type="file" id="gambar" name="gambar[]" multiple accept="image/*,.pdf,.doc,.docx,.zip,.rar" class="block w-full text-sm text-gray-600
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100 transition duration-150
                        ">
                        <p class="text-xs text-gray-500 mt-2">Format yang didukung: Gambar, PDF, Dokumen, ZIP/RAR.</p>
                    </div>

                    <!-- Submit -->
                    <div class="mt-8">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-6 py-3 rounded-xl hover:bg-indigo-700 transition duration-150 font-semibold shadow-lg shadow-indigo-300 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 -mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Publikasikan Tugas
                        </button>
                    </div>
                </form>
            </div>
            <?php endif; ?>

            <h2 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">Daftar Tugas Aktif</h2>

            <div class="space-y-6 pb-4">
                <!-- Cek apakah ada tugas -->
                <?php if (empty($list_tugas)): ?>
                    <!-- Pesan kosong -->
                    <div class="p-6 text-center bg-white/50 backdrop-blur-md rounded-xl shadow-lg ring-1 ring-white/70 border-2 border-dashed border-gray-300">
                        <p class="text-gray-500 text-lg">
                            Belum ada tugas yang dipublikasikan untuk jurusan <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?> saat ini.
                        </p>
                    </div>
                <?php else: ?>
            <?php foreach ($list_tugas as $t): ?>
                <div class="bg-white/50 backdrop-blur-lg p-5 sm:p-6 rounded-xl shadow-2xl border-t-4 border-indigo-500 transition duration-300 hover:shadow-3xl ring-1 ring-white/70">

                    <!-- Header tugas -->
                    <div class="flex justify-between items-start mb-4">
                        <!-- Judul & guru -->
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-900 leading-snug">
                                <?= htmlspecialchars($t['judul'], ENT_QUOTES, 'UTF-8'); ?>
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Guru: <span class="font-medium text-indigo-600">
                                    <?= htmlspecialchars($t['nama_guru'], ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </p>
                        </div>

                        <!-- Tombol hapus (hanya guru yang membuat tugas) -->
                        <?php if ($role === "guru" && (int)$t['guru_id'] === (int)$user_id): ?>
                            <button 
                                onclick="showModal(<?= (int)$t['id']; ?>)" 
                                class="text-red-500 hover:text-red-700 p-2 rounded-full transition duration-150 flex-shrink-0"
                                title="Hapus Tugas">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        <?php endif; ?>
                    </div>

                    <!-- Deskripsi tugas -->
                    <div class="text-gray-700 text-base mt-2 pb-4 border-b border-gray-100">
                        <?= nl2br(htmlspecialchars($t['deskripsi'], ENT_QUOTES, 'UTF-8')); ?>
                    </div>

                    <!-- Deadline -->
                    <div class="flex justify-between items-center mt-4">
                        <p class="text-sm font-semibold text-red-600 bg-red-50/70 backdrop-blur-sm p-2 rounded-lg shadow-inner flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            Deadline: <?= htmlspecialchars(date('d M Y H:i', strtotime($t['deadline'])), ENT_QUOTES, 'UTF-8'); ?>
                        </p>
                    </div>

                    <?php
                    // Ambil daftar file tugas
                    $task_files = json_decode($t['gambar'], true) ?? [];
                    if (!empty($task_files)):
                    ?>
                        <!-- Lampiran tugas -->
                        <div class="mt-4 pt-4 border-t">
                            <!-- Judul lampiran -->
                            <p class="font-semibold text-gray-700 mb-2 flex items-center text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-indigo-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 5h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                </svg>
                                Lampiran Tugas (<?= (int) count($task_files); ?> File)
                            </p>

                            <!-- List file -->
                            <div class="file-scroller flex gap-2 pb-2">
                                <?php foreach ($task_files as $file): ?>
                                    <a href="../<?= htmlspecialchars($file['path'], ENT_QUOTES, 'UTF-8'); ?>" 
                                    target="_blank" 
                                    class="flex-shrink-0 text-xs bg-indigo-50/70 backdrop-blur-sm text-indigo-700 hover:bg-indigo-100 px-3 py-1 rounded-full transition duration-150 font-medium flex items-center border border-indigo-200/50 shadow-sm">
                                    
                                    <!-- Icon file -->
                                    <?= getFileIcon(htmlspecialchars($file['path'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($file['mime'], ENT_QUOTES, 'UTF-8')); ?>
                                    
                                    <!-- Nama file -->
                                    <span class="ml-1">
                                        <?= strlen($file['name']) > 20 ? htmlspecialchars(substr($file['name'], 0, 17), ENT_QUOTES, 'UTF-8') . '...' : htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($role === "siswa"): ?>
                        <!-- Tentukan ID tugas dan status pengiriman -->
                        <?php 
                            $tugas_id_int = (int)$t['id'];
                            $is_submitted = in_array($tugas_id_int, $submitted_tasks);
                            $submission_id = $user_submissions[$tugas_id_int] ?? null;
                        ?>

                        <!-- Container tugas siswa -->
                        <div class="mt-6 border-t pt-4">
                            <!-- Jika tugas sudah dikirim -->
                            <?php if ($is_submitted): ?>
                                <!-- Blok tampilan tugas terkirim -->
                                <div class="p-4 bg-green-50/70 backdrop-blur-sm border border-green-200/50 rounded-lg flex flex-col sm:flex-row justify-between items-start sm:items-center shadow-md">

                                    <!-- Status terkirim -->
                                    <span class="flex items-center text-green-700 font-semibold mb-2 sm:mb-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                        Tugas Sudah Terkirim
                                    </span>

                                    <!-- Form batal pengiriman -->
                                    <form method="POST">
                                        <input type="hidden" name="submission_id" value="<?= htmlspecialchars($submission_id, ENT_QUOTES, 'UTF-8') ?>"> 
                                        <input type="hidden" name="batal_kumpul" value="1">
                                        <button type="submit" 
                                            onclick="return confirm('Apakah Anda yakin ingin membatalkan pengiriman tugas ini? File akan dihapus permanen.')"
                                            class="bg-red-500 text-white text-sm px-4 py-2 rounded-lg hover:bg-red-600 transition duration-150 font-medium flex items-center shadow-md shadow-red-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-1.414 1.414L10 8.586v4.414h4v-1.414l-4-4z" />
                                            </svg>
                                            Batalkan Pengiriman
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="tugas_id" value="<?= htmlspecialchars($t['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <!-- Kumpulkan default -->
                                    <input type="hidden" name="kumpulkan" value="1">

                                    <div class="space-y-3">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Upload File Tugas Anda (Dapat upload banyak file)</label>
                                        <input type="file" name="file_tugas[]" multiple required 
                                            accept="image/*,.pdf,.doc,.docx,.zip,.rar" 
                                            class="block w-full text-sm text-gray-600
                                            file:mr-4 file:py-2 file:px-4
                                            file:rounded-full file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-green-50 file:text-green-700
                                            hover:file:bg-green-100 transition duration-150
                                        ">

                                        <button type="submit" class="w-full bg-green-600 text-white px-5 py-2.5 rounded-lg hover:bg-green-700 transition duration-150 font-semibold shadow-md shadow-green-300 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2 -mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L6.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                            </svg>
                                            Kumpulkan Tugas
                                        </button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($role === "guru"): ?>
                        <?php 
                        // Pastikan ID integer
                        $tugas_id_int = (int)$t['id']; 
                        // Ambil submission tugas
                        $current_submissions = $submissions_by_tugas[$tugas_id_int] ?? [];
                        // Hitung jumlah submission
                        $submission_count = count($current_submissions);
                        ?>
                        <div class="mt-6 border-t pt-4">
                            <!-- Tombol toggle submission -->
                            <button class="w-full text-left font-semibold text-indigo-600 flex justify-between items-center p-3 bg-indigo-50/70 backdrop-blur-sm rounded-lg hover:bg-indigo-100 transition duration-150 shadow-md ring-1 ring-indigo-200/50"
                                    onclick="toggleSubmissions(this, 'submissions-<?= $tugas_id_int ?>')">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    <!-- Tampilkan jumlah submission -->
                                    Pengumpulan Siswa (<?= $submission_count ?>)
                                </span>
                                <svg id="arrow-<?= $tugas_id_int ?>" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 transform transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div id="submissions-<?= $tugas_id_int ?>" class="mt-4 space-y-4 border border-indigo-200/50 bg-gray-50/50 backdrop-blur-sm p-4 rounded-lg hidden">
                                <?php if ($submission_count > 0): ?>
                                    <?php foreach ($current_submissions as $sub): ?>
                                        <?php 
                                        // Ambil file tugas, pastikan array
                                        $files = json_decode($sub['file_tugas'], true) ?? [];
                                        $has_valid_file = is_array($files) && count($files) > 0;
                                        ?>
                                        <div class="p-3 bg-white/70 backdrop-blur-sm rounded-lg shadow-md border border-white/50 ring-1 ring-gray-100/50">
                                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b pb-2 mb-2">
                                                <div class="flex-1 min-w-0">
                                                    <!-- Nama siswa aman -->
                                                    <p class="font-bold text-gray-800 truncate"><?= htmlspecialchars($sub['nama_siswa'], ENT_QUOTES, 'UTF-8') ?></p>
                                                    <!-- Email siswa aman -->
                                                    <p class="text-xs text-gray-500 truncate"><?= htmlspecialchars($sub['email_siswa'], ENT_QUOTES, 'UTF-8') ?></p>
                                                </div>
                                                <!-- Tanggal dikumpulkan -->
                                                <p class="text-xs text-indigo-500 font-medium sm:ml-4 flex-shrink-0 mt-1 sm:mt-0">
                                                    Dikumpulkan: <?= date('d M Y H:i', strtotime($sub['submission_date'])) ?>
                                                </p>
                                            </div>
                                            
                                            <?php if ($has_valid_file): ?>
                                                <!-- Jumlah lampiran -->
                                                <p class="text-sm font-semibold mb-2 text-green-700 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                                    Lampiran (<?= count($files) ?> file):
                                                </p>
                                                <div class="file-scroller flex flex-wrap gap-2">
                                                    <?php foreach ($files as $file): ?>
                                                        <a href="../<?= htmlspecialchars($file['path'], ENT_QUOTES, 'UTF-8') ?>" 
                                                        target="_blank" 
                                                        class="flex-shrink-0 text-xs text-white bg-indigo-600/90 hover:bg-indigo-700 transition duration-150 px-3 py-1 rounded-full flex items-center shadow-md">
                                                            <!-- Ikon file aman -->
                                                            <?= getFileIcon(htmlspecialchars($file['path'], ENT_QUOTES, 'UTF-8'), htmlspecialchars($file['mime'], ENT_QUOTES, 'UTF-8')) ?>
                                                            <span class="ml-1"><?= strlen($file['name']) > 15 ? substr(htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8'), 0, 12) . '...' : htmlspecialchars($file['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                                        </a>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <!-- Pesan tidak ada file valid -->
                                                <p class="text-sm text-red-600 flex items-center font-semibold">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                    Tidak ada file yang valid dilampirkan.
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-gray-500 text-center py-2 text-sm">Belum ada siswa yang mengumpulkan tugas ini.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>
            <?php endif; ?>
            </div>

        </div>

    </div>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <!-- START BOTTOM NAVIGATION BAR (Mobile Only) -->
    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>

    <script src="../assets/js/tugas.js"></script>
</body>
</html>