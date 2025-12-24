<?php
// Mulai sesi jika belum ada sesi yang aktif
if (session_status() === PHP_SESSION_NONE) session_start();

// Memanggil file konfigurasi database
require_once __DIR__ . '/../config/db.php';

// Proteksi halaman: user wajib login
if (!isset($_SESSION['user_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: ../auth/login.php");
    exit;
}

// Mengambil ID user dari sesi
$user_id = $_SESSION['user_id'];

try {
    // Menyiapkan query untuk mengambil data user berdasarkan ID
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    
    // Menjalankan query dengan parameter ID user
    $stmt->execute(['id' => $user_id]);
    
    // Mengambil data user dalam bentuk array asosiatif
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika data user tidak ditemukan, redirect ke login
    if (!$user) {
        header("Location: ../auth/login.php");
        exit;
    }

    // Sanitasi data user untuk mencegah XSS
    $nama      = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role      = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan   = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $email     = htmlspecialchars($user['email'] ?? 'email@contoh.com');
    
    // Mengambil huruf pertama dari nama sebagai inisial avatar
    $initial   = strtoupper(substr($nama, 0, 1));

    // Peta warna avatar (background dan border)
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

    // Jika warna avatar belum disimpan di sesi
    if (!isset($_SESSION['avatar_bg'])) {
        // Memilih warna secara acak
        $bg_random = array_rand($warna_map);
        
        // Menyimpan warna background avatar ke sesi
        $_SESSION['avatar_bg'] = $bg_random;
        
        // Menyimpan warna border avatar ke sesi
        $_SESSION['avatar_border'] = $warna_map[$bg_random];
    }

    // Mengambil warna avatar dari sesi
    $bg_random = $_SESSION['avatar_bg'];
    $border_random = $_SESSION['avatar_border'];

    // Mengecek apakah user memiliki foto profil
    $foto = !empty($user['foto_profil']) 
        ? "../" . htmlspecialchars($user['foto_profil']) 
        : null;

    // Query untuk mengambil data ranking siswa berdasarkan jurusan
    $queryRank = "SELECT 
                    u.id, 
                    u.nama, 
                    u.foto_profil, 
                    COALESCE(MAX(h.nilai), 0) as nilai_ujian, 
                    COALESCE(AVG(q.nilai_persen), 0) as avg_kuis, 
                    COUNT(DISTINCT q.materi_id) as kuis_selesai 
                  FROM users u 
                  LEFT JOIN hasil_ujian h ON u.id = h.siswa_id 
                  LEFT JOIN quiz_scores q ON u.id = q.user_id 
                  WHERE u.role = 'siswa' AND u.jurusan = :jurusan 
                  GROUP BY u.id 
                  ORDER BY nilai_ujian DESC, avg_kuis DESC 
                  LIMIT 10";

    // Menyiapkan query ranking
    $stmtRank = $pdo->prepare($queryRank);
    
    // Menjalankan query ranking dengan parameter jurusan
    $stmtRank->execute(['jurusan' => $user['jurusan']]);
    
    // Mengambil seluruh hasil ranking
    $rankings = $stmtRank->fetchAll(PDO::FETCH_ASSOC);

    // Fungsi untuk menentukan gelar siswa berdasarkan performa
    function getGelar($selesai, $avg, $exam) {
        // Gelar KING
        if ($selesai >= 5 && $avg >= 90 && $exam >= 90) 
            return ['title' => 'KING', 'icon' => 'fa-crown', 'color' => 'text-amber-500', 'bg' => 'bg-amber-100'];
        
        // Gelar Juara
        if ($selesai >= 5 && $avg >= 80 && $exam >= 85) 
            return ['title' => 'Juara', 'icon' => 'fa-trophy', 'color' => 'text-yellow-500', 'bg' => 'bg-yellow-50'];
        
        // Gelar Spesialis
        if ($selesai >= 5 && $avg >= 80) 
            return ['title' => 'Spesialis', 'icon' => 'fa-graduation-cap', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'];
        
        // Gelar Fondasi
        if ($selesai >= 5) 
            return ['title' => 'Fondasi', 'icon' => 'fa-book', 'color' => 'text-orange-500', 'bg' => 'bg-orange-50'];
        
        // Gelar API
        if ($selesai >= 3 && $avg >= 78) 
            return ['title' => 'API', 'icon' => 'fa-fire', 'color' => 'text-orange-600', 'bg' => 'bg-orange-50'];
        
        // Jika tidak memenuhi syarat gelar
        return null;
    }

} catch (PDOException $e) {
    // Menampilkan pesan error jika terjadi kesalahan database
    die("Kesalahan Database: " . $e->getMessage());
}

// Mengambil nama file halaman yang sedang dibuka
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Ranking - <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up { animation: slideInUp 0.4s ease-out forwards; }
    </style>
</head>
<body class="min-h-screen flex overflow-x-hidden bg-[#fdfdff] scroll-smooth">
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
            <button id="sidebarToggle" 
                class="p-1.5 text-gray-300 rounded-lg hover:bg-gray-700 
                    focus:outline-none focus:ring-2 focus:ring-indigo-500 
                    transition duration-150">
                <i class="fas fa-bars text-lg"></i>
            </button>
            <div class="flex items-center h-8 sm:h-10 pl-3 sm:pl-4">
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
    <!-- sidebar -->
    <?php require_once __DIR__ . '/../private/sidebar.php';?>

    <div class="flex-1 overflow-y-auto pt-10 md:pt-0 pb-12 md:ml-64">
        <main class="p-4 md:p-8 max-w-5xl mx-auto">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4">
                <div>
                    <h1 class="font-poppins font-semibold text-2xl md:text-3xl text-slate-900 tracking-tight">Papan <span class="text-indigo-600">Peringkat</span></h1>
                    <p class="text-slate-500 text-sm font-medium mt-1">Kompetisi sehat, prestasi hebat!</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                <?php 
                $top3 = array_slice($rankings, 0, 3);
                $others = array_slice($rankings, 3);
                
                foreach($top3 as $index => $row):
                    $rankNo = $index + 1;
                    $isCurrentUser = ($row['id'] == $user_id);
                    $gelar = getGelar($row['kuis_selesai'], $row['avg_kuis'], $row['nilai_ujian']);
                    $uFoto = !empty($row['foto_profil']) && file_exists("../".$row['foto_profil']) ? "../".$row['foto_profil'] : null;
                    
                    $bgColor = $rankNo == 1 ? 'bg-gradient-to-br from-[#fffbeb] to-[#fef3c7] border-[#fde68a]' : 
                              ($rankNo == 2 ? 'bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9] border-[#e2e8f0]' : 
                                             'bg-gradient-to-br from-[#fff7ed] to-[#ffedd5] border-[#fed7aa]');
                    $iconColor = $rankNo == 1 ? 'text-amber-500' : ($rankNo == 2 ? 'text-slate-400' : 'text-orange-500');
                    $badgeColor = $rankNo == 1 ? 'bg-amber-500' : ($rankNo == 2 ? 'bg-slate-400' : 'bg-orange-500');
                ?>
                <div class="animate-slide-up <?= $bgColor ?> border rounded-2xl p-4 flex items-center gap-4 shadow-sm">
                    <!-- Avatar & badge ranking -->
                    <div class="relative flex-shrink-0">
                        <!-- Foto / inisial -->
                        <div class="w-14 h-14 rounded-xl overflow-hidden ring-2 ring-white shadow-sm">

                            <!-- Jika ada foto -->
                            <?php if ($uFoto): ?>
                                <img src="<?= htmlspecialchars($uFoto, ENT_QUOTES, 'UTF-8'); ?>" class="w-full h-full object-cover">
                            <?php else: ?>

                                <!-- Inisial user -->
                                <div class="w-full h-full flex items-center justify-center
                                    <?= htmlspecialchars($isCurrentUser ? $bg_random : 'bg-indigo-500', ENT_QUOTES, 'UTF-8'); ?>
                                    text-white text-xl font-black">
                                    <?= htmlspecialchars(strtoupper(substr($row['nama'], 0, 1)), ENT_QUOTES, 'UTF-8'); ?>
                                </div>

                            <?php endif; ?>
                        </div>

                        <!-- Badge peringkat -->
                        <div class="absolute -top-2 -left-2 w-6 h-6 rounded-full flex items-center justify-center
                            text-[10px] font-black text-white shadow-md
                            <?= htmlspecialchars($badgeColor, ENT_QUOTES, 'UTF-8'); ?>">
                            <?= (int)$rankNo; ?>
                        </div>
                    </div>

                    <!-- Nama & gelar -->
                    <div class="min-w-0 flex-1">
                        <!-- Nama user -->
                        <h3 class="font-bold text-slate-800 text-sm truncate">
                            <?= htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?>
                        </h3>

                        <!-- Gelar -->
                        <div class="flex items-center gap-1.5 mt-0.5">
                            <i class="fas <?= htmlspecialchars($gelar['icon'] ?? 'fa-star', ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars($iconColor, ENT_QUOTES, 'UTF-8'); ?> text-[10px]"></i>
                            <span class="text-[9px] font-bold text-slate-500 uppercase truncate">
                                <?= htmlspecialchars($gelar['title'] ?? 'Siswa Aktif', ENT_QUOTES, 'UTF-8'); ?>
                            </span>
                        </div>
                    </div>

                    <!-- Skor -->
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Skor</p>
                        <p class="text-lg font-black text-slate-800 leading-none">
                            <?= (int) round($row['avg_kuis'], 0); ?>
                        </p>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

            <div class="bg-white/70 backdrop-blur-md border border-white/40 rounded-2xl overflow-hidden shadow-[0_4px_20px_-2px_rgba(0,0,0,0.03)]">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50/50">
                                <th class="py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest w-16">Pos</th>
                                <th class="py-3 px-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Siswa</th>
                                <th class="py-3 px-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center hidden sm:table-cell">Progres</th>
                                <th class="py-3 px-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Skor</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php foreach ($others as $index => $row): 
                                $rankNo = $index + 4;
                                $isUser = ($row['id'] == $user_id);
                                $gelar = getGelar($row['kuis_selesai'], $row['avg_kuis'], $row['nilai_ujian']);
                                $rowInitial = strtoupper(substr($row['nama'], 0, 1));
                                $perf = ($row['avg_kuis'] / 100) * 100;
                            ?>
                            <tr class="rank-row transition-none <?= $isUser ? 'bg-indigo-50/30' : '' ?>">
                                <td class="py-3 px-6">
                                    <!-- Nomor ranking -->
                                    <span class="text-sm font-extrabold text-slate-300">#<?= (int)$rankNo ?></span>
                                </td>
                                <td class="py-2 px-2">
                                    <div class="flex items-center gap-3">
                                        <!-- Avatar ranking -->
                                        <div class="relative flex-shrink-0">

                                            <!-- Container avatar -->
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center font-bold text-sm overflow-hidden
                                                <?= htmlspecialchars($isUser ? 'ring-2 ring-indigo-100' : 'bg-slate-100 text-slate-500', ENT_QUOTES, 'UTF-8'); ?>">

                                                <!-- Ambil foto profil -->
                                                <?php
                                                $uFoto = !empty($row['foto_profil']) && file_exists("../" . $row['foto_profil'])
                                                    ? "../" . $row['foto_profil']
                                                    : null;
                                                ?>

                                                <!-- Jika ada foto -->
                                                <?php if ($uFoto): ?>
                                                    <img src="<?= htmlspecialchars($uFoto, ENT_QUOTES, 'UTF-8'); ?>" class="w-full h-full object-cover">
                                                <?php else: ?>

                                                    <!-- Inisial user -->
                                                    <div class="w-full h-full flex items-center justify-center
                                                        <?= htmlspecialchars($isUser ? $bg_random : 'bg-slate-200 text-slate-500', ENT_QUOTES, 'UTF-8'); ?>">
                                                        <?= htmlspecialchars($rowInitial, ENT_QUOTES, 'UTF-8'); ?>
                                                    </div>

                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Nama & gelar user -->
                                        <div class="min-w-0">
                                            <!-- Nama & icon user saat ini -->
                                            <div class="flex items-center gap-1.5">
                                                <h4 class="text-xs font-bold text-slate-700 truncate">
                                                    <?= htmlspecialchars($row['nama'], ENT_QUOTES, 'UTF-8'); ?>
                                                </h4>
                                                <?php if ($isUser): ?>
                                                    <i class="fas fa-check-circle text-indigo-500 text-[10px]"></i>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Gelar / status -->
                                            <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-tight">
                                                <?= htmlspecialchars($gelar['title'] ?? 'Siswa Aktif', ENT_QUOTES, 'UTF-8'); ?>
                                            </p>

                                        </div>
                                    </div>
                                </td>
                                <!-- Progress bar performa -->
                                <td class="py-2 px-4 hidden sm:table-cell">
                                    <div class="flex items-center justify-center gap-2">

                                        <!-- Bar visual -->
                                        <div class="h-[6px] w-[60px] bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full bg-indigo-500" style="width: <?= (float)$perf ?>%"></div>
                                        </div>

                                        <!-- Persentase performa -->
                                        <span class="text-[9px] font-bold text-slate-400"><?= (int) round($perf); ?>%</span>
                                    </div>
                                </td>

                                <!-- Skor rata-rata -->
                                <td class="py-2 px-6 text-right">
                                    <span class="text-sm font-black text-slate-700"><?= (int) round($row['avg_kuis'], 0); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-4 justify-center md:justify-start">
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-nowrap">Master</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-nowrap">Siswa Pro</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest text-nowrap">Pemula</span>
                </div>
            </div>
        </main>
    </div>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>

</body>
</html>