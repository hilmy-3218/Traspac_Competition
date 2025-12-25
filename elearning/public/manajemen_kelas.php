<?php
// Pastikan sesi aktif untuk mengelola data login
if (session_status() === PHP_SESSION_NONE) session_start();
// Muat koneksi database dari file konfigurasi
require_once __DIR__ . '/../config/db.php';

// Validasi login: tendang pengguna jika belum ada sesi user_id
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil profil lengkap pengguna berdasarkan ID dari database
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Keamanan: pastikan data user benar-benar ada di database
    if (!$user) {
        header("Location: ../auth/login.php");
        exit;
    }

    // --- PROTEKSI ROLE: Hanya izinkan pengguna dengan role 'guru' ---
    if ($user['role'] !== 'guru') {
        $_SESSION['error_message'] = "Anda tidak memiliki izin akses ke halaman ini.";
        header("Location: ../index.php"); 
        exit;
    }

    // Sanitasi data string untuk mencegah celah keamanan XSS
    $nama      = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role      = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan   = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $email     = htmlspecialchars($user['email'] ?? 'email@contoh.com');

    // Ambil huruf depan nama untuk tampilan inisial avatar
    $initial = strtoupper(substr($nama, 0, 1));

    // Skema warna Tailwind untuk styling dinamis elemen UI
    $warna_map = [
        "bg-red-500" => "border-red-500", "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500", "bg-green-500" => "border-green-500",
        "bg-blue-500" => "border-blue-500", "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500", "bg-pink-500" => "border-pink-500"
    ];

    // Simpan warna avatar di sesi agar tetap konsisten saat halaman dimuat ulang
    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        $bg_random = array_rand($warna_map);
        $border_random = $warna_map[$bg_random];
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $border_random;
    } else {
        $bg_random = $_SESSION['avatar_bg'];
        $border_random = $_SESSION['avatar_border'];
    }

    // Tentukan path foto profil atau gunakan nilai null jika tidak ada
    $foto = !empty($user['foto_profil']) ? "../" . htmlspecialchars($user['foto_profil']) : null;

    // --- FUNGSI UTILITY: Generate warna avatar konsisten berdasarkan string nama ---
    function generate_siswa_avatar_color($student_name) {
        $color_classes = ["bg-red-500", "bg-yellow-500", "bg-orange-500", "bg-green-500", "bg-blue-500", "bg-indigo-500", "bg-purple-500", "bg-pink-500"];
        $hash = crc32($student_name);
        $index = $hash % count($color_classes);
        $bg_class = $color_classes[$index];
        return ['bg' => $bg_class, 'border' => str_replace('bg-', 'border-', $bg_class)];
    }

    // Ambil data nilai kuis siswa yang satu jurusan dengan guru tersebut
    $jurusan_guru = $user['jurusan'] ?? 'N/A';
    $sql_scores = "SELECT u.nama AS nama_siswa, u.jurusan AS jurusan_siswa, u.foto_profil AS foto_profil_siswa, qs.materi_id, qs.skor, qs.total_soal, qs.nilai_persen, qs.tanggal_mengerjakan FROM quiz_scores qs JOIN users u ON qs.user_id = u.id WHERE qs.jurusan = :jurusan_guru AND u.role = 'siswa' ORDER BY u.nama ASC, qs.tanggal_mengerjakan DESC";
    $stmt_scores = $pdo->prepare($sql_scores);
    $stmt_scores->execute(['jurusan_guru' => $jurusan_guru]);
    $student_scores = $stmt_scores->fetchAll(PDO::FETCH_ASSOC);

    // Strukturkan ulang data nilai (grouping) berdasarkan identitas tiap siswa
    $grouped_scores = [];
    foreach ($student_scores as $score) {
        $siswa_key = $score['nama_siswa'];
        if (!isset($grouped_scores[$siswa_key])) {
            $grouped_scores[$siswa_key] = ['nama' => $score['nama_siswa'], 'jurusan' => $score['jurusan_siswa'], 'foto' => $score['foto_profil_siswa'], 'nilai' => []];
        }
        // Tambahkan detail riwayat pengerjaan kuis ke dalam array siswa terkait
        $grouped_scores[$siswa_key]['nilai'][] = ['materi_id' => $score['materi_id'], 'skor' => $score['skor'], 'total_soal' => $score['total_soal'], 'persen' => number_format($score['nilai_persen'], 2) . '%', 'tanggal' => date('d M Y', strtotime($score['tanggal_mengerjakan']))];
    }
} catch (PDOException $e) {
    // Tangani jika terjadi kegagalan pada query atau koneksi database
    $error_message = "Terjadi kesalahan saat memuat data nilai.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Siswa | <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen font-sans"> 

    <!-- Background glow dekoratif -->
    <div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-purple-500/20 blur-3xl rounded-full transform translate-x-1/2 translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed top-1/2 left-0 w-[300px] h-[300px] bg-green-500/20 blur-3xl rounded-full transform -translate-x-full -translate-y-1/2 pointer-events-none z-0 hidden lg:block"></div>
    <div class="fixed top-10 left-1/2 w-[250px] h-[250px] bg-yellow-400/20 blur-3xl rounded-full transform -translate-x-1/2 pointer-events-none z-0 hidden sm:block"></div>
    <div class="fixed top-0 right-0 w-[350px] h-[350px] bg-pink-500/15 blur-3xl rounded-full transform translate-x-1/3 -translate-y-1/3 pointer-events-none z-0"></div>

    <!-- loader -->
    <div id="top-loader" class="fixed top-0 left-0 h-[3px] w-0 bg-blue-600 z-[9999] transition-all duration-300"></div>

    <!-- navbar hanya di mobile -->
    <header class="fixed top-0 left-0 w-full h-12 bg-gray-800/75 backdrop-blur-md text-white shadow-xl z-40 md:hidden flex items-center justify-between px-3">
        <button id="sidebarToggle" class="p-1.5 text-gray-300 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150">
            <i class="fas fa-bars text-lg"></i>
        </button>
        <div class="flex items-center h-8 sm:h-10 border-gray-700 pl-3">
            <?php if ($foto): ?>
                <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" class="w-7 h-7 rounded-full object-cover border <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>">
            <?php else: ?>
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-sm font-bold border <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?> <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <div class="flex min-h-screen w-full">

        <!-- sidebar -->
        <?php require_once __DIR__ . '/../private/sidebar.php';?>

        <main class="flex-grow px-3 sm:px-4 lg:px-6 pt-16 pb-24 md:pt-6 md:pb-12 md:ml-64 w-full">
            <div class="max-w-7xl mx-auto"> 
                
                <header class="mb-5 md:mb-6 bg-white/50 backdrop-blur-[15px] border border-white/70 shadow-[0_8px_32px_0_rgba(0,0,0,0.15)] p-4 md:p-6 rounded-xl border-t-2 md:border-t-4 border-t-indigo-500/50">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center mb-1 md:mb-2">
                                <h1 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-gray-900 flex items-center">
                                    <i class="fas fa-chart-line text-indigo-600 mr-2 md:mr-3 text-2xl md:text-3xl"></i> 
                                    Dashboard Nilai Siswa
                                </h1>
                            </div>
                            <!-- Deskripsi jurusan -->
                            <p class="mt-1 text-sm sm:text-md md:text-lg text-indigo-600">
                                Data nilai quiz untuk Jurusan <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?>.
                            </p>
                        </div>
                        
                        <div class="hidden md:flex flex-col items-end"> 
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold text-white bg-indigo-600 shadow-md mb-3">
                                <i class="fas fa-user-tie mr-1"></i> Guru
                            </span>
                            <!-- Info user -->
                            <div class="text-sm font-medium text-gray-700 flex items-center justify-end">
                                <div class="w-8 h-8 rounded-full border-2 border-indigo-500
                                    <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?>
                                    flex items-center justify-center text-white font-bold text-xs shadow-md overflow-hidden">

                                    <!-- Foto / inisial -->
                                    <?php if ($foto): ?>
                                        <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>" alt="Foto" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                                    <?php endif; ?>
                                </div>

                                <!-- Nama user -->
                                <span class="ml-1 font-semibold text-gray-900 truncate">
                                    <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </header>

                <?php if (isset($error_message)): ?>
                    <!-- Pesan error -->
                    <div class="bg-red-100/80 backdrop-blur-sm border border-red-300 text-red-800 px-3 py-2 rounded relative mb-4 shadow-xl text-sm"
                        role="alert">
                        <strong>Error:</strong>
                        <?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>

                <!-- Pencarian siswa -->
                <div class="mb-4 md:mb-6 flex justify-start md:justify-end">
                    <div class="relative w-full max-w-xs md:max-w-sm">

                        <!-- Input pencarian (aman & dibatasi) -->
                        <input type="text"
                            id="searchInput"
                            placeholder="Cari Siswa..."
                            autocomplete="off"
                            maxlength="50"
                            class="w-full pl-9 pr-3 py-1.5 md:py-2 bg-white/50 backdrop-blur-[15px] border border-indigo-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition text-sm text-gray-800 placeholder-gray-500 shadow-sm"
                            onkeyup="filterTable()">

                        <!-- Icon search -->
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm"></i>
                    </div>
                </div>

                <div class="bg-white/50 backdrop-blur-[15px] border border-white/70 shadow-[0_8px_32px_0_rgba(0,0,0,0.15)] overflow-hidden rounded-xl p-0 md:p-6">
                    <?php if (empty($grouped_scores)): ?>
                        <!-- Jika data nilai kosong -->
                        <div class="p-10 text-center">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-5xl mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900">
                                Tidak Ada Data Nilai
                            </h3>
                        </div>
                    <?php else: ?>
                        <div class="overflow-x-auto max-h-[70vh] md:max-h-full">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="hidden md:table-header-group sticky top-0 bg-white/90 backdrop-blur-md z-10 shadow-sm">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Jurusan</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Rincian Nilai (5 Terbaru)</th>
                                    </tr>
                                </thead>
                                <tbody id="table-body" class="divide-y divide-gray-200 md:divide-y-0">
                                    <?php foreach ($grouped_scores as $siswa): 
                                        // Warna avatar siswa
                                        $siswa_color = generate_siswa_avatar_color($siswa['nama']);

                                        // Path foto siswa (jika ada)
                                        $siswa_foto = !empty($siswa['foto']) ? "../" . htmlspecialchars($siswa['foto'], ENT_QUOTES, 'UTF-8') : null;
                                    ?>
                                        <tr class="block md:table-row bg-white/60 backdrop-blur-md md:bg-transparent border md:border-none border-white/80 m-3 md:m-0 p-4 md:p-0 rounded-xl md:rounded-none shadow-sm md:shadow-none hover:bg-indigo-50/50 transition duration-150">
                                            
                                            <!-- Kolom siswa -->
                                            <td class="block md:table-cell py-1 md:px-6 md:py-4">
                                                <div class="flex items-center">

                                                    <!-- Avatar siswa -->
                                                    <div class="w-10 h-10 rounded-full border-2
                                                        <?= htmlspecialchars($siswa_color['border'], ENT_QUOTES, 'UTF-8'); ?>
                                                        <?= htmlspecialchars($siswa_color['bg'], ENT_QUOTES, 'UTF-8'); ?>
                                                        flex items-center justify-center text-white font-bold text-sm shadow-inner overflow-hidden">

                                                        <?php if ($siswa_foto): ?>
                                                            <img src="<?= $siswa_foto; ?>" class="w-full h-full object-cover">
                                                        <?php else: ?>
                                                            <?= htmlspecialchars(strtoupper(substr($siswa['nama'], 0, 1)), ENT_QUOTES, 'UTF-8'); ?>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Nama siswa -->
                                                    <div class="ml-3">
                                                        <div class="text-sm font-semibold text-gray-900">
                                                            <?= htmlspecialchars($siswa['nama'], ENT_QUOTES, 'UTF-8'); ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                            
                                            <td class="block md:table-cell py-1 md:px-6 md:py-4">
                                                <span class="md:hidden text-[0.8rem] font-bold text-indigo-600 mr-2 uppercase">
                                                    Jurusan:
                                                </span>

                                                <span class="px-2 py-0.5 inline-flex text-[0.65rem] md:text-xs font-semibold rounded-full bg-indigo-500 text-white shadow-sm">
                                                    <?= htmlspecialchars($siswa['jurusan'], ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                            </td>
                                            
                                            <td class="block md:table-cell py-2 md:px-6 md:py-4 border-t border-dashed border-gray-200 mt-2 md:mt-0 md:border-none">
                                                <span class="md:hidden text-[0.8rem] font-bold text-indigo-600 block mb-2 uppercase">Rincian Nilai:</span>
                                                <ul class="space-y-2"> 
                                                <?php 
                                                    $latest_scores = array_slice($siswa['nilai'], 0, 5); 
                                                    foreach ($latest_scores as $nilai): 

                                                        // Pastikan persen aman & numerik
                                                        $raw_persen = htmlspecialchars($nilai['persen'], ENT_QUOTES, 'UTF-8');
                                                        $score_value = (float) str_replace(['%', ','], '', $raw_persen);

                                                        // Warna berdasarkan nilai
                                                        $text_color = ($score_value >= 80) 
                                                            ? 'text-green-600' 
                                                            : (($score_value >= 60) 
                                                                ? 'text-yellow-600' 
                                                                : 'text-red-600'
                                                            );
                                                ?>
                                                    <li class="flex flex-col md:flex-row justify-between items-start md:items-center p-2 bg-indigo-50/70 rounded-lg shadow-sm">
                                                        <div class="flex items-center truncate">
                                                            <i class="fas fa-book-open text-indigo-500 mr-2 text-[10px] md:text-xs"></i>
                                                            <span class="font-medium text-gray-700 text-xs">
                                                                Materi ID <?= (int)$nilai['materi_id']; ?>
                                                            </span> 
                                                        </div>

                                                        <div class="flex justify-between md:justify-end items-center w-full md:w-auto mt-1 md:mt-0">
                                                            <span class="font-extrabold text-sm <?= $text_color ?> md:mr-2">
                                                                <?= $raw_persen ?>
                                                            </span>

                                                            <span class="text-[10px] md:text-xs text-gray-500">
                                                                (
                                                                <?= (int)$nilai['skor']; ?>/<?= (int)$nilai['total_soal']; ?> -
                                                                <?= htmlspecialchars($nilai['tanggal'], ENT_QUOTES, 'UTF-8'); ?>
                                                                )
                                                            </span>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        <?php require_once __DIR__ . '/../private/nav-bottom.php';?>
    </div>

    <script>
        function filterTable() {
            // Ambil input pencarian dalam huruf kecil
            const filter = document.getElementById('searchInput').value.toLowerCase();
            
            // Ambil semua baris di body tabel
            const rows = document.querySelectorAll('#table-body tr'); 
            
            rows.forEach(row => {
                // Ambil teks nama dari kolom yang relevan
                const name = row.querySelector('.text-sm.font-semibold').textContent.toLowerCase();
                
                // Tampilkan baris jika cocok, sembunyikan jika tidak
                row.style.display = name.includes(filter) ? "" : "none";
            });
        }
    </script>
</body>

</html>
