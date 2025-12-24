<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../../auth/login.php");
        exit;
    }

    $nama    = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role    = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $initial = strtoupper(substr($nama, 0, 1));

    // Avatar logic (dibiarkan tetap ada meskipun tidak digunakan di halaman ini)
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

    if (!isset($_SESSION['avatar_bg'])) {
        $bg_random = array_rand($warna_map);
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $warna_map[$bg_random];
    }

    $bg_random = $_SESSION['avatar_bg'];
    $border_random = $_SESSION['avatar_border'];

    $foto = !empty($user['foto_profil']) ? "../../" . $user['foto_profil'] : null;

    // 2. AMBIL DATA REAL DARI DATABASE
    $stmt_materi = $pdo->prepare("SELECT materi_id, nilai_persen FROM quiz_scores WHERE user_id = :id ORDER BY materi_id ASC");
    $stmt_materi->execute(['id' => $user_id]);
    $db_materi_scores = $stmt_materi->fetchAll(PDO::FETCH_ASSOC);

    $materi_stats = [];
    for ($i = 1; $i <= 5; $i++) {
        $found = false;
        foreach ($db_materi_scores as $ms) {
            if ($ms['materi_id'] == $i) {
                $materi_stats[] = ['id' => $i, 'completed' => true, 'score' => (float)$ms['nilai_persen']];
                $found = true;
                break;
            }
        }
        if (!$found) {
            $materi_stats[] = ['id' => $i, 'completed' => false, 'score' => 0];
        }
    }

    $stmt_exam = $pdo->prepare("SELECT MAX(nilai) as nilai_tertinggi FROM hasil_ujian WHERE siswa_id = :id");
    $stmt_exam->execute(['id' => $user_id]);
    $db_exam_score = (float)($stmt_exam->fetch(PDO::FETCH_ASSOC)['nilai_tertinggi'] ?? 0);

    // 3. LOGIKA PENENTUAN GELAR
    function getGelar($selesai, $avg, $exam) {
        if ($selesai >= 5 && $avg >= 90 && $exam >= 90) 
            return ['title' => 'KING', 'desc' => 'Penguasaan mutlak di segala bidang!', 'icon' => 'fa-crown', 'color' => 'text-amber-500', 'bg' => 'bg-amber-100'];
        if ($selesai >= 5 && $avg >= 80 && $exam >= 85) 
            return ['title' => 'Juara', 'desc' => 'Anda unggul dalam ujian akhir.', 'icon' => 'fa-trophy', 'color' => 'text-yellow-500', 'bg' => 'bg-yellow-50'];
        if ($selesai >= 5 && $avg >= 80) 
            return ['title' => 'Spesialis', 'desc' => 'Pemahaman materi Anda solid.', 'icon' => 'fa-graduation-cap', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'];
        if ($selesai >= 5) 
            return ['title' => 'Fondasi', 'desc' => 'Langkah awal yang hebat!', 'icon' => 'fa-book', 'color' => 'text-orange-500', 'bg' => 'bg-orange-50'];
        if ($selesai >= 3 && $avg >= 78) 
            return ['title' => 'API', 'desc' => 'Aktif & Konsisten menyelesaikan materi.', 'icon' => 'fa-fire', 'color' => 'text-orange-600', 'bg' => 'bg-orange-50'];
        
        return ['title' => 'Belum Ada Gelar', 'desc' => 'Selesaikan materi untuk membuka potensi Anda.', 'icon' => 'fa-lock', 'color' => 'text-slate-400', 'bg' => 'bg-slate-100'];
    }

    $materi_selesai_count = count(array_filter($materi_stats, fn($m) => $m['completed']));
    $avg_kuis_db = $materi_selesai_count > 0 ? array_sum(array_column($materi_stats, 'score')) / $materi_selesai_count : 0;
    $gelar_config = getGelar($materi_selesai_count, $avg_kuis_db, $db_exam_score);
    $nama = htmlspecialchars($user['nama'] ?? 'Pengguna');

} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress Pencapaian - <?= $nama ?></title>
    <link rel="shortcut icon" href="../../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-tap-highlight-color: transparent; }
        .glass-card { background-color: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.3); box-shadow: 0 4px 20px 0 rgba(31, 38, 135, 0.08); }
        .achievement-card { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); filter: grayscale(100%); opacity: 0.5; border: 2px solid #f3f4f6; }
        .achievement-card.unlocked { filter: grayscale(0%); opacity: 1; transform: scale(1.02); border-color: transparent; background: white; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .achievement-card.unlocked#achievement-king { background: linear-gradient(145deg, #ffffff, #fffbeb); border-color: #fbbf24; animation: pulse-gold 2s infinite; }
        @keyframes pulse-gold { 0% { box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.4); } 70% { box-shadow: 0 0 0 10px rgba(251, 191, 36, 0); } 100% { box-shadow: 0 0 0 0 rgba(251, 191, 36, 0); } }
    </style>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 overflow-x-hidden">

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

            <a href="../pengaturan.php"
            class="flex items-center gap-2 text-sm font-medium text-gray-200 
                   hover:text-white transition">
                <i class="fa-solid fa-arrow-left text-base"></i>
                Kembali
            </a>

            <div class="flex items-center h-8 sm:h-10 border-l border-gray-700 pl-3 sm:pl-4">
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
    <main class="max-w-6xl mx-auto px-4 pt-10 pb-16 md:py-6">

        <section class="mb-6 md:mb-10 p-5 md:p-8 rounded-2xl glass-card border border-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <!-- KIRI -->
                <div class="flex flex-col gap-6">

                    <div class="flex flex-col gap-3">
                        <!-- Tombol Kembali (Desktop Only) -->
                        <a href="../pengaturan.php"
                        class="hidden md:inline-flex w-fit items-center gap-1.5
                                px-3 py-1.5 rounded-md
                                bg-gray-100 hover:bg-gray-200
                                text-gray-600 text-sm font-medium
                                transition">
                            <i class="fas fa-arrow-left text-xs"></i>
                            Kembali
                        </a>

                        <div>
                            <h1 class="text-[10px] md:text-xs font-bold text-orange-600 uppercase tracking-[0.2em]">
                                Status Pencapaian (Real Data)
                            </h1>
                            <h2 class="text-xl md:text-3xl font-extrabold text-slate-800">
                                Gelar Akademik
                            </h2>
                        </div>
                    </div>

                    <!-- Card Gelar -->
                    <div class="flex items-center gap-4 bg-white/60 p-4 md:p-6 rounded-2xl
                                border-2 border-dashed border-slate-200">
                        <div class="flex-shrink-0 w-12 h-12 md:w-16 md:h-16 rounded-full
                                    <?= htmlspecialchars($gelar_config['bg'], ENT_QUOTES, 'UTF-8') ?>
                                    flex items-center justify-center shadow-inner">
                            <!-- Icon aman -->
                            <i class="fas <?= htmlspecialchars($gelar_config['icon'], ENT_QUOTES, 'UTF-8') ?> text-xl md:text-2xl <?= htmlspecialchars($gelar_config['color'], ENT_QUOTES, 'UTF-8') ?>"></i>
                        </div>

                        <div class="min-w-0">
                            <!-- Title aman -->
                            <p class="text-lg md:text-2xl font-black uppercase tracking-tight <?= htmlspecialchars($gelar_config['color'], ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($gelar_config['title'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                            <!-- Deskripsi aman -->
                            <p class="text-[10px] md:text-sm text-slate-500 italic leading-tight">
                                <?= htmlspecialchars($gelar_config['desc'], ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- KANAN -->
                <div class="bg-slate-800/5 rounded-2xl p-5 md:p-6 border border-slate-200">
                    <h3 class="text-xs font-bold text-slate-700 uppercase mb-4 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-500"></i>
                        Persyaratan
                    </h3>

                    <ul class="space-y-3 text-[11px] md:text-xs text-slate-600">
                        <li class="flex items-start gap-3">
                            <span class="font-bold text-orange-600 min-w-[80px]">API</span>
                            <span>3 materi, rata-rata diatas 78%</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="font-bold text-orange-500 min-w-[80px]">Fondasi</span>
                            <span>Semua (5) materi selesai</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="font-bold text-blue-600 min-w-[80px]">Spesialis</span>
                            <span>5 materi, rata-rata diatas 80%</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="font-bold text-yellow-600 min-w-[80px]">Juara</span>
                            <span>5 materi, rata-rata diatas 80% & ujian diatas 85%</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="font-bold text-amber-600 min-w-[80px]">KING</span>
                            <span>5 materi, rata-rata diatas 90% & ujian diatas 90%</span>
                        </li>
                    </ul>
                </div>

            </div>
        </section>

        <section class="mb-10">
            <h2 class="text-lg md:text-2xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="w-1.5 h-6 bg-orange-500 rounded-full"></span> Lencana Simulasi
                <span id="badge-count" class="ml-auto text-[10px] md:text-xs font-bold text-slate-400 bg-slate-200/50 px-3 py-1 rounded-full">0/5</span>
            </h2>
            <div id="achievements-container" class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                <div id="achievement-api" class="achievement-card p-6 rounded-2xl text-center"><i class="fas fa-fire text-3xl mb-3"></i><h3 class="text-sm font-bold">API</h3></div>
                <div id="achievement-book" class="achievement-card p-6 rounded-2xl text-center"><i class="fas fa-book text-3xl mb-3"></i><h3 class="text-sm font-bold">Fondasi</h3></div>
                <div id="achievement-cap" class="achievement-card p-6 rounded-2xl text-center"><i class="fas fa-graduation-cap text-3xl mb-3"></i><h3 class="text-sm font-bold">Spesialis</h3></div>
                <div id="achievement-trophy" class="achievement-card p-6 rounded-2xl text-center"><i class="fas fa-trophy text-3xl mb-3"></i><h3 class="text-sm font-bold">Juara</h3></div>
                <div id="achievement-king" class="achievement-card p-6 rounded-2xl text-center"><i class="fas fa-crown text-3xl mb-3"></i><h3 class="text-sm font-bold">KING</h3></div>
            </div>
        </section>

        <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 p-8 rounded-2xl glass-card">
                <div class="flex justify-between mb-6">
                    <h3 class="text-sm font-bold uppercase">Kontrol Materi</h3>
                    <button id="auto-fill" class="text-[10px] font-bold px-3 py-1 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors">SET SEMUA 100%</button>
                </div>
                <div id="materi-inputs" class="space-y-3"></div>
            </div>
            <div class="p-8 rounded-2xl glass-card">
                <h3 class="text-sm font-bold uppercase mb-4">Ujian Akhir</h3>
                <input type="number" id="exam-score-input" min="0" max="100" 
                    value="<?= htmlspecialchars((int)$db_exam_score, ENT_QUOTES, 'UTF-8') ?>" 
                    class="w-full p-4 bg-white border border-slate-200 rounded-xl font-black text-2xl text-orange-600 outline-none focus:ring-2 focus:ring-orange-500"
                    placeholder="Masukkan nilai ujian" />

                <div class="mt-8 pt-6 border-t">
                    <div class="flex justify-between mb-2"><span class="text-xs font-bold text-slate-500">RATA-RATA</span> <span id="avg-score-display" class="font-black">0%</span></div>
                    <div class="w-full bg-slate-100 h-3 rounded-full overflow-hidden">
                        <div id="avg-progress-bar" class="bg-blue-500 h-3 rounded-full transition-all duration-700"></div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../../private/nav-bottom.php';?>
    <script>
        // 1. Sinkronisasi data awal
        let progressData = {
            materi: <?= json_encode($materi_stats) ?>,
            examScore: <?= $db_exam_score ?>
        };
    </script>
    <script src="../../assets/js/pencapaian.js"></script>
</body>
</html>