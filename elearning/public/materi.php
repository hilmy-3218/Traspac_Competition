<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Variabel untuk progress
$progress_percent = 0;
$progress_message = "Progress: 0%";

// Ambil user
// Asumsi $pdo sudah tersedia dari db.php
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Jika user tidak ditemukan, arahkan kembali ke login
        header("Location: ../auth/login.php");
        exit;
    }

    // SANITASI DATA
    $nama      = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role      = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan   = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $email     = htmlspecialchars($user['email'] ?? 'email@contoh.com');

    // Huruf pertama nama
    $initial = strtoupper(substr($nama, 0, 1));

    // --- LOGIKA PERSISTENSI WARNA AVATAR MENGGUNAKAN SESSION ---
    // Pilihan warna yang tersedia (Mapping BG ke Border)
    $warna_map = [
        "bg-red-500" => "border-red-500",
        "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500",
        "bg-green-500" => "border-green-500",
        "bg-blue-500" => "border-blue-500",
        "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500",
        "bg-pink-500" => "border-pink-500"
    ];

    // Cek apakah warna sudah disimpan di session
    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        
        // Jika belum ada, pilih warna secara acak
        $bg_random = array_rand($warna_map);
        $border_random = $warna_map[$bg_random];

        // Simpan warna yang terpilih ke session agar persisten saat reload
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $border_random;
    } else {
        // Jika sudah ada di session, gunakan warna yang tersimpan
        $bg_random = $_SESSION['avatar_bg'];
        $border_random = $_SESSION['avatar_border'];
    }
    // --- AKHIR LOGIKA PERSISTENSI WARNA AVATAR ---

    // FIX: PATH FOTO PROFIL
    // Asumsi path foto profil relatif terhadap folder project utama,
    // maka kita tambahkan "../" untuk navigasi dari folder 'pages' (asumsi)
    $foto = !empty($user['foto_profil'])
        ? "../" . htmlspecialchars($user['foto_profil'])
        : null;

// =========================================================
// LOGIKA PROGRESS BAR (JUMLAH NILAI, BUKAN RATA-RATA)
// =========================================================

// Ambil NILAI TERAKHIR tiap materi (1–5)
    $stmt = $pdo->prepare("
        SELECT materi_id, nilai_persen
        FROM quiz_scores
        WHERE user_id = :user_id
        AND materi_id BETWEEN 1 AND 5
        ORDER BY tanggal_mengerjakan DESC
    ");
    $stmt->execute(['user_id' => $user_id]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Default nilai materi
    $nilaiMateri = [
        1 => null,
        2 => null,
        3 => null,
        4 => null,
        5 => null
    ];

    // Ambil nilai terakhir per materi
    foreach ($rows as $r) {
        $mid = (int)$r['materi_id'];

        if ($nilaiMateri[$mid] === null) {
            $nilaiMateri[$mid] = (float)$r['nilai_persen'];
        }
    }

    // Hitung total nilai & jumlah materi yang sudah dikerjakan
    $totalNilai = 0;
    $jumlahMateri = 0;

    foreach ($nilaiMateri as $nilai) {
        if ($nilai !== null) {
            $totalNilai += $nilai;
            $jumlahMateri++;
        }
    }

    // Hitung progress
    // Maksimal total nilai = 5 materi × 100 = 500
    $maxTotal = 5 * 100;

    if ($jumlahMateri > 0) {
        $progress_percent = round(($totalNilai / $maxTotal) * 100);
    } else {
        $progress_percent = 0;
    }

    // Pastikan 0–100%
    $progress_percent = max(0, min(100, $progress_percent));

    // Pesan progress
    $progress_message = "Progress: {$progress_percent}% (Total nilai: {$totalNilai}%)";

} catch (PDOException $e) {
    // Handle error koneksi/query
    echo "Terjadi kesalahan database: " . $e->getMessage();
    exit;
}

$link_materi_dasar = "materi/dasar/dasar_" . $jurusan . ".php";
$link_materi_lanjutan = "materi/lanjutan/lanjutan_" . $jurusan . ".php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Materi Interaktif</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .hover-bounce:hover {
            transform: translateY(-4px) scale(1.01);
            transition: all 0.3s ease-in-out; 
        }
        /* Gaya tambahan untuk efek neumorphism/depth */
        .card-depth {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen">
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

    <header class="block sm:hidden fixed top-0 left-0 w-full h-12 bg-gray-800/75 backdrop-blur-md text-white shadow-xl z-40">
        <div class="max-w-7xl mx-auto flex items-center justify-between h-full px-3">

            <button id="sidebarToggle" 
                class="p-1.5 text-gray-300 rounded-lg hover:bg-gray-700 
                focus:outline-none focus:ring-2 focus:ring-indigo-500 
                transition duration-150">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <h1 class="text-base font-extrabold tracking-wide text-center flex-1">
                <i class="fa-solid fa-book"></i> Materi <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?>
            </h1>

            <div class="flex items-center h-8 border-l border-gray-700 pl-3">
                <?php if ($foto): ?>
                    <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" 
                        class="w-8 h-8 rounded-full object-cover border-2 
                        <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?> shadow-md"
                        alt="Foto Profil">
                <?php else: ?>
                    <div class="w-8 h-8 rounded-full flex items-center justify-center 
                            text-white text-sm font-bold 
                            border-2 <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?> 
                            <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?> shadow-md">
                        <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </header>

    <!-- Sidebar (Desktop & Mobile Menu) -->
    <?php require_once __DIR__ . '/../private/sidebar.php';?>

    <div class="pt-12 pb-16 lg:py-14 lg:pb-20 px-4 sm:px-6 max-w-7xl mx-auto 
                grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 mt-4 
                md:ml-64 md:px-8">

        <div class="rounded-3xl shadow-2xl p-6 fade-in h-fit order-1 lg:order-2 lg:sticky lg:top-4
                    bg-white/20 backdrop-blur-md border border-white/30">
            <h2 class="text-xl sm:text-2xl font-bold mb-5 text-indigo-700 flex items-center gap-2 border-b pb-3 border-indigo-100">
                <span><i class="fas fa-star"></i></span> Jelajahi Materi
            </h2>

            <div class="space-y-4">
                <a href="<?php echo htmlspecialchars($link_materi_dasar, ENT_QUOTES, 'UTF-8'); ?>" class="block p-4 sm:p-5 rounded-xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white shadow-xl hover:shadow-2xl transition hover-bounce relative overflow-hidden card-depth">
                    <span class="absolute right-0 bottom-0 text-7xl opacity-20">💡</span>
                    <h3 class="font-bold text-lg sm:text-xl relative z-10">Materi Dasar</h3>
                    <p class="text-xs sm:text-sm opacity-95 mt-1 relative z-10">Pengenalan komputer & konsep fundamental.</p>
                </a>

                <a href="comingSoon.php" class="block p-4 sm:p-5 rounded-xl bg-gradient-to-br from-purple-600 to-pink-600 text-white shadow-xl hover:shadow-2xl transition hover-bounce relative overflow-hidden card-depth">
                    <span class="absolute right-0 bottom-0 text-7xl opacity-20">⚙️</span>
                    <h3 class="font-bold text-lg sm:text-xl relative z-10">Materi Lanjutan</h3>
                    <p class="text-xs sm:text-sm opacity-95 mt-1 relative z-10">Konsep mendalam, studi kasus, & proyek praktik.</p>
                </a>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6 lg:space-y-8 order-2 lg:order-1">
            
            <div class="rounded-3xl shadow-2xl p-6 sm:p-8 fade-in overflow-hidden relative
                        /* EFEK GLASS: Latar belakang transparan, blur, dan border */
                        bg-white/20 backdrop-blur-md border border-white/30">
                <div class="absolute inset-0 bg-indigo-50/50 -skew-y-3"></div>
                <div class="relative z-10">
                    <p class="text-lg font-semibold text-gray-600 mb-2">Selamat Datang di Modul Interaktif</p>
                    <h2 class="text-3xl font-extrabold text-indigo-700 mb-4">
                        Tingkatkan Skillmu Sekarang!
                    </h2>
                    <p class="text-gray-700 max-w-2xl text-sm">
                        Akses materi fundamental dan tingkatkan kemampuanmu dengan materi lanjutan yang dilengkapi latihan praktik.
                    </p>
                </div>
                <span class="absolute right-3 top-3 sm:right-6 sm:top-6 text-5xl sm:text-7xl opacity-30 text-indigo-400">🚀</span>
            </div>

            <div class="rounded-3xl shadow-2xl p-6 sm:p-8 fade-in
                        /* EFEK GLASS: Latar belakang transparan, blur, dan border */
                        bg-white/20 backdrop-blur-md border border-white/30">
                <h3 class="font-bold text-xl sm:text-2xl text-indigo-600 mb-5 flex items-center gap-2 border-b pb-3 border-gray-100">
                    <i class="fas fa-chart-line"></i> Progress Belajar Anda
                </h3>

                <div class="p-4 sm:p-6 rounded-xl shadow-inner text-center
                            bg-indigo-50/50 border border-indigo-200/50"> 
                    <p class="font-medium text-md sm:text-lg text-indigo-800 mb-3">
                        Pencapaian: <span class="text-xl sm:text-2xl font-extrabold"><?php echo htmlspecialchars($progress_percent, ENT_QUOTES, 'UTF-8'); ?>%</span>
                    </p>
                    
                    <div class="w-full bg-gray-300 rounded-full h-4 sm:h-5 overflow-hidden shadow-md mx-auto">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-blue-500 rounded-full transition-all duration-700 flex items-center justify-end pr-2" style="width: <?php echo $progress_percent; ?>%;">
                            <span class="text-white text-xs font-bold"><?php echo htmlspecialchars($progress_percent, ENT_QUOTES, 'UTF-8'); ?>%</span>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>
</body>
</html>