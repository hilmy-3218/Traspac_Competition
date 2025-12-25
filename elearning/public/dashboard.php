<?php
// Memulai sesi jika belum aktif
if (session_status() === PHP_SESSION_NONE) session_start();
// Menghubungkan koneksi database
require_once __DIR__ . '/../config/db.php'; 

// Proteksi halaman: tendang user jika belum login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// --- LOGIC TAMBAHAN: HITUNG PENGUMUMAN BARU ---
$totalPengumumanBaru = 0;
try {
    // Ambil waktu terakhir user melihat halaman pengumuman
    $last_view = $_SESSION['last_announcement_view'] ?? '1970-01-01 00:00:00';

    // Hitung jumlah baris pengumuman yang lebih baru dari kunjungan terakhir
    $stmtPengumumanBaru = $pdo->prepare("
        SELECT COUNT(*) AS total
        FROM pengumuman
        WHERE tanggal > :last_view
    ");
    $stmtPengumumanBaru->execute(['last_view' => $last_view]);
    $totalPengumumanBaru = $stmtPengumumanBaru->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

} catch (PDOException $e) {
    // Tetapkan nol jika terjadi galat database
    $totalPengumumanBaru = 0;
}

try {
    // Ambil data profil lengkap pengguna aktif
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id=:id LIMIT 1");
    $stmt->execute(['id'=>$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Sanitasi output untuk keamanan XSS
    $nama    = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role    = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $email     = htmlspecialchars($user['email'] ?? 'email@contoh.com');

    // Ambil inisial huruf pertama nama
    $initial    = strtoupper(substr($nama, 0, 1));

    // Pemetaan warna latar dan border untuk avatar
    $warna_map = [
        "bg-red-500"=>"border-red-500","bg-yellow-500"=>"border-yellow-500",
        "bg-orange-500"=>"border-orange-500","bg-green-500"=>"border-green-500",
        "bg-blue-500"=>"border-blue-500","bg-indigo-500"=>"border-indigo-500",
        "bg-purple-500"=>"border-purple-500","bg-pink-500"=>"border-pink-500"
    ];
    // Set warna acak sesi jika belum ada
    if(!isset($_SESSION['avatar_bg'])){
        $bg_random = array_rand($warna_map);
        $_SESSION['avatar_bg']=$bg_random;
        $_SESSION['avatar_border']=$warna_map[$bg_random];
    } else {
        $bg_random = $_SESSION['avatar_bg'];
    }
    // Path foto profil atau null jika kosong
    $foto = !empty($user['foto_profil']) ? "../".$user['foto_profil'] : null;

    // --- CARD: HITUNG TOTAL TUGAS BELUM DIKUMPULKAN ---
    if($role==='siswa'){
        // Hitung tugas jurusan yang belum ada di tabel pengumpulan
        $stmtTugas = $pdo->prepare("
            SELECT COUNT(*) AS total
            FROM tugas t
            LEFT JOIN pengumpulan_tugas p 
            ON t.id = p.tugas_id AND p.siswa_id = :siswa_id
            WHERE t.jurusan=:jurusan AND t.deadline>NOW() AND p.id IS NULL
        ");
        $stmtTugas->execute(['siswa_id'=>$user_id,'jurusan'=>$jurusan]);
        $totalTugas = $stmtTugas->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    } else {
        // Hitung total tugas yang telah dibuat oleh guru tersebut
        $stmtTugas = $pdo->prepare("SELECT COUNT(*) AS total FROM tugas WHERE guru_id=:guru_id");
        $stmtTugas->execute(['guru_id'=>$user_id]);
        $totalTugas = $stmtTugas->fetch(PDO::FETCH_ASSOC)['total'] ?? 0; 
    }

    // --- LIST TUGAS DENGAN STATUS ---
    if($role==='siswa'){
        // Ambil tugas jurusan beserta status pengumpulannya
        $stmtList = $pdo->prepare("
            SELECT t.id, t.judul, t.deadline,
            CASE WHEN p.id IS NOT NULL THEN 1 ELSE 0 END AS sudah_dikumpulkan
            FROM tugas t
            LEFT JOIN pengumpulan_tugas p
            ON t.id = p.tugas_id AND p.siswa_id=:siswa_id
            WHERE t.jurusan=:jurusan
            ORDER BY t.deadline ASC
            LIMIT 10
        ");
        $stmtList->execute(['siswa_id'=>$user_id,'jurusan'=>$jurusan]);
    } else {
        // Ambil tugas terakhir yang dibuat oleh guru
        $stmtList = $pdo->prepare("
            SELECT t.id,t.judul,t.deadline,0 AS sudah_dikumpulkan 
            FROM tugas t 
            WHERE t.guru_id=:guru_id 
            ORDER BY t.deadline DESC 
            LIMIT 10
        ");
        $stmtList->execute(['guru_id'=>$user_id]);
    }
    $tugasList = $stmtList->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e){
    // Hentikan proses jika koneksi/query bermasalah
    echo "Terjadi kesalahan database: ".$e->getMessage();
    exit;
}

// --- HITUNG NILAI RATA-RATA UNTUK SISWA (CARD 1) ---
$nilaiRataRata = 0;
if ($role === 'siswa') {
    try {
        // Ambil riwayat skor kuis materi 1-5
        $stmtNilai = $pdo->prepare("
            SELECT materi_id, nilai_persen
            FROM quiz_scores
            WHERE user_id = :user_id
              AND materi_id BETWEEN 1 AND 5
            ORDER BY tanggal_mengerjakan DESC
        ");
        $stmtNilai->execute(['user_id' => $user_id]);
        $rows = $stmtNilai->fetchAll(PDO::FETCH_ASSOC);

        // Map nilai unik untuk tiap materi (ambil yang terbaru)
        $nilaiMateri = [1 => null, 2 => null, 3 => null, 4 => null, 5 => null];
        foreach ($rows as $r) {
            $mid = (int)$r['materi_id'];
            if ($nilaiMateri[$mid] === null) {
                $nilaiMateri[$mid] = (float)$r['nilai_persen'];
            }
        }

        // Kalkulasi rata-rata nilai dari materi yang sudah diisi
        $total = 0;
        $jumlahTerisi = 0;
        foreach ($nilaiMateri as $nilai) {
            if ($nilai !== null) {
                $total += $nilai;
                $jumlahTerisi++;
            }
        }
        if ($jumlahTerisi > 0) {
            $nilaiRataRata = round($total / $jumlahTerisi, 2);
        }

    } catch (PDOException $e) {
        $nilaiRataRata = 0;
    }
}

// --- HITUNG JUMLAH SISWA PER JURUSAN (CARD 1 - UNTUK GURU) ---
$totalSiswaJurusan = 0;
if ($role === 'guru') {
    try {
        // Hitung total populasi siswa dalam satu jurusan
        $stmtSiswa = $pdo->prepare("
            SELECT COUNT(*) AS total
            FROM users
            WHERE role = 'siswa'
            AND jurusan = :jurusan
        ");
        $stmtSiswa->execute(['jurusan' => $jurusan]);
        $totalSiswaJurusan = $stmtSiswa->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;
    } catch (PDOException $e) {
        $totalSiswaJurusan = 0;
    }
}

// --- LOGIC TAMBAHAN UNTUK CARD NILAI UJIAN TERAKHIR (CARD 3) ---
$judulUjianTerakhir = 'Belum Ada Ujian';
$nilaiAtauJumlah = '-';
$deskripsiUjian = 'Belum ada data ujian terakhir.';
$iconUjian = 'fa-file-alt'; 

if ($role === 'siswa') {
    // Cari nilai satu ujian paling baru milik siswa
    $stmtUjianSiswa = $pdo->prepare("
        SELECT hu.nilai, u.judul 
        FROM hasil_ujian hu
        JOIN ujian u ON hu.ujian_id = u.id
        WHERE hu.siswa_id = :user_id
        ORDER BY hu.tanggal_selesai DESC
        LIMIT 1
    ");
    $stmtUjianSiswa->execute(['user_id' => $user_id]);
    $ujianTerakhir = $stmtUjianSiswa->fetch(PDO::FETCH_ASSOC);

    if ($ujianTerakhir) {
        $judulUjianTerakhir = htmlspecialchars($ujianTerakhir['judul']);
        $nilaiAtauJumlah = round((float)$ujianTerakhir['nilai'], 2) . '%';
        $iconUjian = 'fa-award';
        // Tentukan pesan feedback berdasarkan ambang batas nilai 70
        if ((float)$ujianTerakhir['nilai'] < 70) {
             $deskripsiUjian = 'Perlu ditingkatkan lagi!';
        } else {
             $deskripsiUjian = 'Hasil yang memuaskan!';
        }
    }

} elseif ($role === 'guru') {
    // Cari satu ujian terbaru di jurusan guru tersebut
    $stmtUjianGuru = $pdo->prepare("
        SELECT id, judul 
        FROM ujian 
        WHERE jurusan = :jurusan 
        ORDER BY id DESC 
        LIMIT 1
    "); 
    $stmtUjianGuru->execute(['jurusan' => $jurusan]);
    $ujianTerakhirGuru = $stmtUjianGuru->fetch(PDO::FETCH_ASSOC);

    if ($ujianTerakhirGuru) {
        $ujian_id = $ujianTerakhirGuru['id'];
        $judulUjianTerakhir = htmlspecialchars($ujianTerakhirGuru['judul']);

        // Hitung berapa banyak siswa yang sudah setor hasil ujian tersebut
        $stmtHitungSiswa = $pdo->prepare("
            SELECT COUNT(DISTINCT hu.siswa_id) AS total_kumpul
            FROM hasil_ujian hu
            JOIN users u ON hu.siswa_id = u.id
            WHERE hu.ujian_id = :ujian_id
            AND u.role = 'siswa'
            AND u.jurusan = :jurusan
        ");
        $stmtHitungSiswa->execute(['ujian_id' => $ujian_id, 'jurusan' => $jurusan]);
        $jumlahSiswaKumpul = $stmtHitungSiswa->fetch(PDO::FETCH_ASSOC)['total_kumpul'] ?? 0;

        $nilaiAtauJumlah = $jumlahSiswaKumpul;
        $iconUjian = 'fa-clipboard-check';
        // Tampilkan info perbandingan jumlah pengerjaan
        if ($totalSiswaJurusan > 0) {
            $deskripsiUjian = "Dari $totalSiswaJurusan siswa di jurusan $jurusan.";
        }
    } else {
        $iconUjian = 'fa-file-alt';
    }
}

// --- LOGIC TAMBAHAN UNTUK LENCANA (BADGE) SISWA ---
$has_book_badge = false;
$has_fire_badge = false; // Rank Baru
$has_cap_badge = false;
$has_trophy_badge = false;
$has_king_badge = false; 

if ($role === 'siswa') {
    try {
        // Hitung materi unik (1-5) yang sudah dikerjakan kuisnya
        $stmtSelesaiMateri = $pdo->prepare("
            SELECT COUNT(DISTINCT materi_id) AS total_materi_selesai
            FROM quiz_scores
            WHERE user_id = :user_id
            AND materi_id BETWEEN 1 AND 5
        ");
        $stmtSelesaiMateri->execute(['user_id' => $user_id]);
        $totalMateriSelesai = $stmtSelesaiMateri->fetch(PDO::FETCH_ASSOC)['total_materi_selesai'] ?? 0;

        // --- CEK RANK API (BARU) ---
        // Syarat: Minimal 3 materi DAN rata-rata >= 78
        if ((int)$totalMateriSelesai >= 3 && $nilaiRataRata >= 78) {
            $has_fire_badge = true;
        }

        // Syarat hirarki badge yang sudah ada
        if ((int)$totalMateriSelesai >= 5) {
            $has_book_badge = true;
            
            if ($jumlahTerisi == 5 && $nilaiRataRata >= 80) {
                $has_cap_badge = true;

                if ($ujianTerakhir && (float)$ujianTerakhir['nilai'] >= 85) {
                    $has_trophy_badge = true;
                    
                    if ($nilaiRataRata >= 90 && (float)$ujianTerakhir['nilai'] >= 90) {
                        $has_king_badge = true;
                    }
                }
            }
        }
    } catch (PDOException $e) {
        // Diamkan error jika query gagal
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Tambahkan Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Gaya khusus untuk tab aktif */
        .tab-button.active {
            color: #4f46e5; 
            border-bottom-color: #4f46e5;
        }
        /* Gaya default untuk tab tidak aktif */
        .tab-button:not(.active) {
            color: #6b7280; 
            border-bottom-color: transparent;
        }

    </style>
</head>

<body class="bg-gray-100 min-h-screen">
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

    <!-- START NAVBAR (Header Atas) - HANYA MOBILE (md:hidden) -->
    <header class="fixed top-0 left-0 w-full h-12 bg-gray-800/75 backdrop-blur-md text-white shadow-xl z-40 md:hidden">
        <div class="h-full flex items-center justify-between px-3">

            <!-- Tombol Hamburger -->
            <button id="sidebarToggle" 
                class="p-1.5 text-gray-300 rounded-lg hover:bg-gray-700 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 
                    transition duration-150">
                <i class="fas fa-bars text-lg"></i>
            </button>

            <!-- FOTO PROFIL / INITIAL -->
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

    <!-- 2. MAIN CONTENT -->

    <main class="md:p-8 main-content overflow-y-auto md:ml-64 pt-0 md:pt-8 pb-24 md:pb-0">
                
        <header class="relative bg-white dark:bg-gray-900 
                    /* Mobile: Lengkung hanya di bawah */
                    rounded-none rounded-b-[15%] 
                    /* Desktop (md): Semua sudut sama (2xl) */
                    md:rounded-2xl 
                    p-6 sm:p-8 shadow-lg 
                    border border-gray-200 dark:border-gray-700 
                    md:mb-8 overflow-hidden">

            <!-- Background efek -->
            <div class="absolute inset-0 bg-gradient-to-br 
                        from-blue-500/10 via-purple-500/10 to-pink-500/10 
                        pointer-events-none"></div>

            <div class="absolute -top-10 right-10 w-40 h-40 
                        bg-purple-400/20 blur-3xl rounded-full"></div>

            <div class="absolute bottom-0 left-0 w-32 h-32 
                        bg-blue-400/20 blur-3xl rounded-full"></div>

            <!-- Lengkung lancip ke bawah -->
            <div class="absolute bottom-0 left-1/2 
                        -translate-x-1/2 translate-y-full 
                        w-0 h-0 
                        border-l-[35px] border-r-[35px] border-t-[35px]
                        border-transparent 
                        border-t-gray-200 dark:border-t-gray-700"></div>

            <div class="relative z-20 pt-4">

                <!-- Bagian atas: teks kiri & foto kanan -->
                <div class="flex items-center justify-between">

                    <!-- Teks kiri -->
                    <div class="mt-4">
                        <h1 class="text-2xl sm:text-3xl font-extrabold 
                            text-gray-900 dark:text-white tracking-wide">
                            
                            <?php echo htmlspecialchars($nama); ?> 
                            
                            <?php 
                                // Warna emas untuk badge prestasi tinggi
                                $gold_color = 'text-yellow-600'; 
                                
                                // Warna oranye khusus untuk badge API / aktif
                                $orange_color = 'text-orange-500'; 

                                // Icon default jika belum memiliki badge
                                $badge_icon = '👋'; 
                                
                                // Judul default badge
                                $badge_title = 'Selamat datang!';

                                // Mengecek apakah user adalah siswa
                                if ($role === 'siswa') {

                                    // Badge KING (peringkat tertinggi)
                                    if (isset($has_king_badge) && $has_king_badge) {
                                        $badge_icon = '<i class="fas fa-crown ' . $gold_color . ' ml-2" title="Predikat King: Materi Lengkap, Rata-rata >= 90 & Ujian >= 90"></i>';
                                        $badge_title = 'Predikat King';

                                    // Badge Elite (juara)
                                    } elseif (isset($has_trophy_badge) && $has_trophy_badge) {
                                        $badge_icon = '<i class="fas fa-trophy ' . $gold_color . ' ml-2" title="Predikat Elite: Materi 1-5 Rata-rata >= 80% & Ujian Akhir >= 85%"></i>';
                                        $badge_title = 'Predikat Elite';

                                    // Badge Sangat Baik
                                    } elseif (isset($has_cap_badge) && $has_cap_badge) {
                                        $badge_icon = '<i class="fas fa-graduation-cap ' . $gold_color . ' ml-2" title="Predikat Sangat Baik: Selesai Materi 1-5 & Rata-rata Kuis >= 80%"></i>';
                                        $badge_title = 'Predikat Sangat Baik';

                                    // Badge Selesai Materi
                                    } elseif (isset($has_book_badge) && $has_book_badge) {
                                        $badge_icon = '<i class="fas fa-book ' . $gold_color . ' ml-2" title="Predikat Selesai: Semua Materi 1-5 Telah Dikerjakan"></i>';
                                        $badge_title = 'Predikat Selesai';

                                    // Badge API (Aktif)
                                    } elseif (isset($has_fire_badge) && $has_fire_badge) {
                                        // Tampilan badge API untuk siswa aktif
                                        $badge_icon = '<i class="fas fa-fire ' . $orange_color . ' ml-2" title="Predikat Aktif: Selesai 3 Materi & Rata-rata >= 78"></i>';
                                        $badge_title = 'Predikat Aktif';
                                    }
                                }

                                // Menampilkan icon badge ke halaman
                                echo $badge_icon;
                            ?>

                        </h1>
                        <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                            <?php echo date('l, d F Y'); ?>
                        </p>

                    </div>
                    <!-- Foto kanan -->
                    <div class="mt-4 sm:mt-0">
                        <?php if ($foto): ?>
                            <img src="<?php echo $foto; ?>"
                                class="w-12 h-12 rounded-xl object-cover border-2 <?php echo $border_random; ?>"
                                alt="Foto Profil">
                        <?php else: ?>
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center 
                                        text-white text-lg font-semibold border-2 shadow-md
                                        <?php echo $bg_random; ?> <?php echo $border_random; ?>">
                                <?php echo $initial; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- info -->
                <div class="mt-6 flex items-center space-x-3 sm:space-x-5 
                            overflow-x-auto pb-1">

                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                bg-blue-500/10 text-blue-700 dark:text-blue-300 
                                border border-blue-500/20 backdrop-blur-sm flex-shrink-0">
                        <span class="font-bold">Role:</span> 
                        <?php echo htmlspecialchars($role); ?>
                    </span>

                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                bg-purple-500/10 text-purple-700 dark:text-purple-300 
                                border border-purple-500/20 backdrop-blur-sm flex-shrink-0">
                        <span class="font-bold">Jurusan:</span> 
                        <?php echo htmlspecialchars($jurusan); ?>
                    </span>

                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                bg-gray-800/10 text-gray-800 dark:text-gray-200 
                                border border-gray-500/10 backdrop-blur-sm 
                                hidden sm:inline-block flex-shrink-0">
                        <span class="font-bold">Email:</span> 
                        <?php echo htmlspecialchars($email); ?>
                    </span>

                </div>

            </div>
        </header>

        <div class="px-4 md:px-0 mt-4">
            <div class="mb-6">
                <div class="border-b border-gray-300">
                    <ul id="tab-nav" class="flex flex-wrap -mb-px text-sm sm:text-base font-semibold" role="tablist">
                        <!-- AKTIVITAS -->
                        <li class="mr-1 sm:mr-2">
                            <button id="aktivitas-tab" data-target="aktivitas" type="button" role="tab" aria-controls="aktivitas" aria-selected="true"
                                class="tab-button active inline-flex items-center px-3 pt-1 pb-2 sm:px-4 sm:pt-2 sm:pb-3 
                                text-indigo-600 border-b-2 border-indigo-500 rounded-t-lg font-semibold">
                                <i class="fas fa-chart-line mr-1 sm:mr-2"></i> Aktivitas
                            </button>
                        </li>
                        <!-- TUGAS -->
                        <li class="mr-1 sm:mr-2">
                            <button id="tugas-materi-tab" data-target="tugas-materi" type="button" role="tab" aria-controls="tugas-materi" aria-selected="false"
                                class="tab-button inline-flex items-center px-3 pt-1 pb-2 sm:px-4 sm:pt-2 sm:pb-3 
                                text-gray-500 border-b-2 border-transparent 
                                hover:text-indigo-600 hover:border-indigo-300 transition duration-200">
                                <i class="fas fa-layer-group mr-1 sm:mr-2"></i> Tugas
                            </button>
                        </li>
                        <!-- PESAN -->
                        <li class="mr-1 sm:mr-2">
                            <button id="pesan-tab" data-target="pesan" type="button" role="tab" aria-controls="pesan" aria-selected="false"
                                class="tab-button inline-flex items-center px-3 pt-1 pb-2 sm:px-4 sm:pt-2 sm:pb-3 
                                text-gray-500 border-b-2 border-transparent 
                                hover:text-indigo-600 hover:border-indigo-300 transition duration-200">
                                <i class="fas fa-bell mr-1 sm:mr-2"></i> Pesan
                            </button>
                        </li>
                    </ul>
                </div>
                <div id="tab-content" class="pt-4">

                    <div id="aktivitas" class="tab-panel" role="tabpanel" aria-labelledby="aktivitas-tab">
                        <section class="mb-4">
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-700 mb-3">Ringkasan Aktivitas</h2>
                            
                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                                
                                <div class="relative overflow-hidden rounded-xl px-4 py-2 sm:px-6 sm:py-4 shadow-md 
                                    border-b-4 border-pink-500 hover:shadow-xl transition duration-300 
                                    transform hover:scale-[1.01]"
                                    style="background: linear-gradient(135deg, #ffe3ec, #f9d1ff);">

                                    <div class="absolute right-2 bottom-2 opacity-20 text-pink-600">
                                        <i class="fa-solid <?= (isset($role) && $role === 'siswa') ? 'fa-chart-column' : 'fa-users'; ?> 
                                        text-[3rem] sm:text-[5rem]"></i>
                                    </div>

                                    <p class="text-xs sm:text-sm font-medium text-gray-700">
                                        <?= (isset($role) && $role === 'siswa') 
                                            ? 'Nilai Rata-rata' 
                                            : 'Jumlah Siswa'; ?>
                                    </p>

                                    <p class="text-xl sm:text-3xl font-extrabold text-gray-900 mt-1">
                                        <?= (isset($role) && $role === 'siswa') 
                                            ? htmlspecialchars((string)($nilaiRataRata ?? 0)) . '%' 
                                            : htmlspecialchars((string)($totalSiswaJurusan ?? 0)); ?>
                                    </p>

                                    <!-- DESKRIPSI (HILANG DI MOBILE) -->
                                    <p class="hidden sm:block text-xs text-gray-600 mt-2">
                                        <?= (isset($role) && $role === 'siswa') 
                                            ? 'Tingkatkan lagi belajarmu!' 
                                            : 'Siswa jurusan ' . htmlspecialchars((string)($jurusan ?? '')); ?>
                                    </p>
                                </div>

                                <div class="relative overflow-hidden rounded-xl px-4 py-3 sm:px-6 sm:py-4 shadow-md border-b-4 border-yellow-500
                                    hover:shadow-xl transition duration-300 transform hover:scale-[1.01]"
                                    style="background: linear-gradient(135deg, #fff4d1, #ffe2b5);">

                                    <div class="absolute right-2 bottom-2 opacity-20 text-yellow-600">
                                        <i class="fa-solid fa-list-check text-[3rem] sm:text-[5rem]"></i>
                                    </div>

                                    <p class="text-xs sm:text-sm font-medium text-gray-700">
                                        <?= htmlspecialchars(($role === 'siswa' ? 'Tugas Mendatang' : 'Total Tugas Dibuat'), ENT_QUOTES, 'UTF-8'); ?>
                                    </p>

                                    <p class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">
                                        <?= htmlspecialchars($totalTugas, ENT_QUOTES, 'UTF-8'); ?>
                                    </p>

                                    <p class="hidden sm:block text-xs text-gray-600 mt-2">
                                        <?= htmlspecialchars(
                                            ($role === 'siswa'
                                                ? 'Segera selesaikan sebelum deadline'
                                                : 'Total tugas yang pernah Anda buat'),
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </p>
                                </div>

                                <div class="col-span-2 lg:col-span-1 relative overflow-hidden rounded-xl px-4 py-3 sm:px-6 sm:py-4 shadow-md border-b-4 border-green-500
                                    hover:shadow-xl transition duration-300 transform hover:scale-[1.01]"
                                    style="background: linear-gradient(135deg, #e3fff3, #d1f9d1);">

                                    <div class="absolute right-2 bottom-2 opacity-20 text-green-600">
                                        <i class="fa-solid fa-clipboard-list text-[3rem] sm:text-[5rem]"></i>
                                    </div>

                                    <p class="text-xs sm:text-sm font-medium text-gray-700">
                                        <?= htmlspecialchars(
                                            ($role === 'siswa') ? 'Nilai Ujian Terakhir' : 'Siswa Mengerjakan Ujian',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </p>

                                    <p class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-1">
                                        <?= htmlspecialchars($nilaiAtauJumlah, ENT_QUOTES, 'UTF-8'); ?>
                                    </p>

                                    <p class="hidden sm:block text-xs text-gray-600 mt-2">
                                        <?= htmlspecialchars($judulUjianTerakhir, ENT_QUOTES, 'UTF-8'); ?>
                                    </p>
                                </div>

                            </div>
                        </section>
                        <!-- Section: Tugas Terbaru / Aktivitas Kelas -->
                        <section class="mb-8 bg-white p-4 sm:p-6 rounded-xl shadow-lg mt-6">

                            <!-- Judul section menyesuaikan role -->
                            <h2 class="text-xl sm:text-2xl font-semibold text-gray-700 mb-4">
                                <?= htmlspecialchars(
                                    ($role === 'siswa' ? 'Tugas Terbaru' : 'Aktivitas Kelas'),
                                    ENT_QUOTES,
                                    'UTF-8'
                                ); ?>
                            </h2>

                            <!-- List tugas -->
                            <ul class="divide-y divide-gray-200">
                                <?php
                                // Jika belum ada tugas
                                if (!$tugasList) {
                                    echo '<li class="py-3 text-sm text-gray-500">Belum ada tugas.</li>';
                                } else {
                                    // Loop setiap tugas
                                    foreach ($tugasList as $tugas) {

                                        // Hitung selisih hari deadline
                                        $deadline = new DateTime($tugas['deadline']);
                                        $today = new DateTime();
                                        $diff = $today->diff($deadline);
                                        $hariSisa = (int) $diff->format('%r%a');

                                        // Text deadline
                                        $deadlineText = ($hariSisa >= 0)
                                            ? $hariSisa . ' Hari Lagi'
                                            : 'Telah Lewat';

                                        // Status pengumpulan
                                        $sudah = (bool) $tugas['sudah_dikumpulkan'];
                                ?>
                                        <!-- Item tugas -->
                                        <li class="py-3 flex justify-between items-center hover:bg-gray-50 px-2 rounded-lg">
                                            <!-- Informasi tugas -->
                                            <div class="flex items-center">
                                                <i class="fas fa-tasks <?= $sudah ? 'text-green-500' : 'text-blue-500'; ?> text-lg mr-3"></i>

                                                <div>
                                                    <!-- Judul tugas -->
                                                    <p class="font-medium text-sm text-gray-800">
                                                        <?= htmlspecialchars($tugas['judul'], ENT_QUOTES, 'UTF-8'); ?>
                                                    </p>

                                                    <!-- Status deadline / pengumpulan -->
                                                    <p class="text-xs <?= $sudah ? 'text-green-500' : ($hariSisa < 0 ? 'text-red-500' : 'text-gray-500'); ?>">
                                                        <?= htmlspecialchars(
                                                            $sudah ? 'Sudah Dikumpulkan' : 'Deadline: ' . $deadlineText,
                                                            ENT_QUOTES,
                                                            'UTF-8'
                                                        ); ?>
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Tombol Kerjakan (khusus siswa, belum mengumpulkan, belum lewat deadline) -->
                                            <?php if ($role === 'siswa' && !$sudah && $hariSisa >= 0): ?>
                                                <a href="tugas.php"
                                                class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
                                                    Kerjakan
                                                </a>
                                            <?php endif; ?>

                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </section>

                    </div>

                    <div id="tugas-materi" class="tab-panel hidden" role="tabpanel" aria-labelledby="tugas-materi-tab">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

                            <!-- CARD MATERI -->
                            <a href="materi.php" class="block">
                                <div class="h-full p-5 sm:p-7 rounded-2xl shadow-xl border border-[#1f2a40]/50
                                            bg-gradient-to-br from-[#0d1117] via-[#142235] to-[#0c1624]
                                            hover:shadow-2xl transition duration-300">

                                    <div class="flex items-center space-x-3 sm:space-x-4">
                                        <div class="p-2 sm:p-3 rounded-xl bg-[#1b2a3c] text-blue-300 shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6 sm:w-8 sm:h-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v12m8-6H4m14 6V6a2 2 0 00-2-2H8a2 2 0 00-2 2v12" />
                                            </svg>
                                        </div>

                                        <div>
                                            <h3 class="text-base sm:text-xl font-semibold text-gray-100 leading-tight">
                                                Akses Materi
                                            </h3>
                                            <p class="text-xs sm:text-sm text-gray-400 leading-tight mt-1">
                                                Semua bahan ajar lengkap dan modul kuliah sesuai jurusanmu.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- CARD TUGAS -->
                            <a href="tugas.php" class="block">
                                <div class="h-full p-5 sm:p-7 rounded-2xl shadow-xl border border-[#1f2a40]/50
                                            bg-gradient-to-br from-[#0d1117] via-[#142235] to-[#0c1624]
                                            hover:shadow-2xl transition duration-300">
                                    <div class="flex items-center space-x-3 sm:space-x-4">
                                        <div class="p-2 sm:p-3 rounded-xl bg-[#1b2a3c] text-yellow-300 shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6 sm:w-8 sm:h-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 6h13M8 12h8M8 18h5M3 6h.01M3 12h.01M3 18h.01" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base sm:text-xl font-semibold text-gray-100 leading-tight">
                                                Kumpulkan Tugas
                                            </h3>
                                            <p class="text-xs sm:text-sm text-gray-400 leading-tight mt-1">
                                                Upload, pantau, dan cek nilai tugas.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <!-- CARD UJIAN -->
                            <a href="ujian.php" class="block">
                                <div class="h-full p-5 sm:p-7 rounded-2xl shadow-xl border border-[#1f2a40]/50
                                            bg-gradient-to-br from-[#0d1117] via-[#142235] to-[#0c1624]
                                            hover:shadow-2xl transition duration-300">
                                    <div class="flex items-center space-x-3 sm:space-x-4">
                                        <div class="p-2 sm:p-3 rounded-xl bg-[#1b2a3c] text-pink-300 shadow-inner">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6 sm:w-8 sm:h-8" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-base sm:text-xl font-semibold text-gray-100 leading-tight">
                                                Mulai Ujian
                                            </h3>
                                            <p class="text-xs sm:text-sm text-gray-400 leading-tight mt-1">
                                                Kerjakan ujian dan kuis yang aktif.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div id="pesan" class="tab-panel hidden" role="tabpanel" aria-labelledby="pesan-tab">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                            <!-- CARD PENGUMUMAN -->
                            <a href="pengumuman.php" class="block">
                                <div class="h-full p-6 sm:p-7 rounded-2xl shadow-xl border border-[#1f2a40]/50 
                                            bg-gradient-to-br from-[#0d1117] via-[#101b2d] to-[#0c1624]
                                            hover:shadow-2xl transition duration-300">

                                    <div class="flex items-center space-x-4">
                                        <!-- Icon -->
                                        <div class="p-3 rounded-xl bg-[#1b2a3c] text-blue-300 shadow-inner">
                                            <i class="fas fa-bullhorn text-xl sm:text-2xl"></i>
                                        </div>

                                        <!-- Text -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h3 class="text-lg sm:text-xl font-semibold text-gray-100">
                                                    Pengumuman
                                                </h3>
                                                <?php if ($totalPengumumanBaru > 0): ?>
                                                    <!-- Badge jumlah pengumuman baru -->
                                                    <span class="inline-flex items-center justify-center
                                                        px-2 py-0.5 text-xs font-semibold
                                                        text-white bg-red-500/90
                                                        rounded-full shadow-md backdrop-blur-sm">

                                                        <!-- Jumlah pengumuman baru -->
                                                        <?= htmlspecialchars($totalPengumumanBaru, ENT_QUOTES, 'UTF-8'); ?> Baru
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <p class="text-sm text-gray-400 mt-1">
                                                Cek informasi dan notifikasi penting dari sekolah.
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </a>


                            <!-- CARD DISKUSI -->
                            <a href="diskusi.php" class="block">
                                <div class="h-full p-6 sm:p-7 rounded-2xl shadow-xl border border-[#1f2a40]/50 
                                            bg-gradient-to-br from-[#0d1117] via-[#101b2d] to-[#0c1624]
                                            hover:shadow-2xl transition duration-300">

                                    <div class="flex items-center space-x-4">
                                        <div class="p-3 rounded-xl bg-[#1b2a3c] text-green-300 shadow-inner">
                                            <i class="fas fa-comments text-xl sm:text-2xl"></i>
                                        </div>

                                        <div>
                                            <h3 class="text-lg sm:text-xl font-semibold text-gray-100">Ruang Diskusi</h3>
                                            <p class="text-sm text-gray-400 mt-1">
                                                Gabung forum dan berinteraksi dengan rekan sekelas.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>

<script>
    // --- LOGIKA TAB ---
    document.addEventListener('DOMContentLoaded', () => {
        // Seleksi semua elemen tombol tab dan panel konten
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabPanels = document.querySelectorAll('.tab-panel');

        // Fungsi utama untuk perpindahan antar tab
        const switchTab = (targetId) => {
            // 1. Reset: Nonaktifkan semua gaya tombol dan sembunyikan semua panel
            tabButtons.forEach(button => {
                button.classList.remove('active', 'text-indigo-600', 'border-indigo-600');
                button.classList.add('text-gray-500', 'border-transparent');
                button.setAttribute('aria-selected', 'false');
            });
            tabPanels.forEach(panel => {
                panel.classList.add('hidden');
            });

            // 2. Aktivasi: Terapkan gaya aktif pada tombol yang dipilih
            const activeTab = document.querySelector(`.tab-button[data-target="${targetId}"]`);
            if (activeTab) {
                activeTab.classList.add('active'); 
                activeTab.classList.remove('text-gray-500', 'border-transparent');
                activeTab.setAttribute('aria-selected', 'true');
            }

            // 3. Visualisasi: Tampilkan panel konten yang sesuai dengan target
            const activePanel = document.getElementById(targetId);
            if (activePanel) {
                activePanel.classList.remove('hidden');
            }
        };

        // Pasang event listener klik pada setiap tombol tab
        tabButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                // Ambil ID target dari atribut data-target tombol
                const targetId = e.currentTarget.getAttribute('data-target');
                switchTab(targetId);
            });
        });

        // Inisialisasi: Set tab 'aktivitas' sebagai konten default
        switchTab('aktivitas');
    });

</script>
</body>

</html>
