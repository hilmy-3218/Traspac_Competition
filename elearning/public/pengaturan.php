<?php
// Mulai sesi jika belum aktif
if (session_status() === PHP_SESSION_NONE) session_start();
// Hubungkan ke file konfigurasi database
require_once __DIR__ . '/../config/db.php';

// Proteksi akses: wajib login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Ambil data user dari database berdasarkan ID sesi
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validasi keberadaan akun
    if (!$user) {
        header("Location: ../auth/login.php");
        exit;
    }

    // Sanitasi data user untuk keamanan tampilan (XSS)
    $nama      = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role      = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan   = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $email     = htmlspecialchars($user['email'] ?? 'email@contoh.com');
    $initial   = strtoupper(substr($nama, 0, 1));

    // --- LOGIKA WARNA AVATAR ---
    $warna_map = [
        "bg-red-500" => "border-red-500", "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500", "bg-green-500" => "border-green-500",
        "bg-blue-500" => "border-blue-500", "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500", "bg-pink-500" => "border-pink-500"
    ];

    // Simpan warna di sesi agar tidak berubah saat halaman dimuat ulang
    if (!isset($_SESSION['avatar_bg'])) {
        $bg_random = array_rand($warna_map);
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $warna_map[$bg_random];
    }
    $bg_random = $_SESSION['avatar_bg'];
    $border_random = $_SESSION['avatar_border'];

    // Atur path foto profil atau null jika kosong
    $foto = !empty($user['foto_profil']) ? "../" . htmlspecialchars($user['foto_profil']) : null;

} catch (PDOException $e) {
    // Tangani error database
    die("Kesalahan Database: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-gray-100 to-gray-200 min-h-screen font-['Inter',sans-serif]">
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

    <!-- Sidebar (Desktop & Mobile Menu) -->
    <?php require_once __DIR__ . '/../private/sidebar.php';?>

    <main class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto pb-20 md:ml-64">

        <div class="min-h-screen p-4 sm:p-8 pt-20 sm:pt-10 flex flex-col items-center">

            <div class="w-full max-w-3xl lg:max-w-3xl">
                <div class="backdrop-blur-xl bg-white/20 border border-white/30 shadow-2xl 
                            rounded-3xl p-6 sm:p-8 transition duration-300 transform hover:shadow-[0_0_25px_rgba(255,255,255,0.25)]">

                    <!-- START MODIFIED SECTION -->
                    <div class="flex items-center mb-6 sm:mb-8">

                        <!-- Foto / avatar -->
                        <div class="mr-4 sm:mr-6">

                            <!-- Jika ada foto -->
                            <?php if (isset($foto) && $foto): ?>

                                <!-- Foto profil aman -->
                                <img src="<?php echo htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                                    class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl object-cover border-4 border-indigo-50 shadow-xl"
                                    alt="Foto Profil"
                                    onerror="this.onerror=null; this.src='https://placehold.co/96x96/7c3aed/ffffff?text=<?php echo htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>'">

                            <!-- Jika tidak ada foto -->
                            <?php else: ?>

                                <!-- Avatar inisial -->
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl flex items-center justify-center
                                    text-white text-3xl font-bold border-4 border-indigo-50 shadow-xl
                                    <?php echo htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo isset($initial) ? htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') : 'U'; ?>
                                </div>

                            <?php endif; ?>
                        </div>

                        <!-- Informasi user -->
                        <div class="flex-1 min-w-0">

                            <!-- Nama -->
                            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight truncate">
                                <?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?>
                            </h1>

                            <!-- Email -->
                            <p class="text-base text-gray-500 mt-1 truncate">
                                <?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>
                            </p>

                            <!-- Badge -->
                            <div class="mt-2 flex flex-wrap text-xs sm:text-sm font-medium">

                                <!-- Role -->
                                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full capitalize mr-3 mb-2">
                                    Role: <?php echo htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?>
                                </span>

                                <!-- Jurusan -->
                                <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded-full capitalize mb-2">
                                    Jurusan: <?php echo htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?>
                                </span>

                            </div>
                        </div>
                    </div>

                    <!-- END MODIFIED SECTION -->

                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 text-sm font-semibold">

                        <a href="pengaturan/profil.php"
                        class="btn-hover-scale flex-1 flex items-center justify-center px-4 py-3 bg-white/30 backdrop-blur-lg
                                text-gray-800 rounded-xl hover:bg-white/40 transition duration-150 border border-white/20">
                            <svg class="icon-svg mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            Lihat Detail Profil
                        </a>

                        <a href="pengaturan/ganti_pw.php"
                        class="btn-hover-scale flex-1 flex items-center justify-center px-4 py-3 bg-violet-600/70 backdrop-blur-lg
                                text-white rounded-xl hover:bg-violet-700/80 transition duration-150 border border-white/20">
                            <svg class="icon-svg mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            Ganti Kata Sandi
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-3xl mt-6 sm:mt-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-6 space-y-4 lg:space-y-0">

                    <div class="bg-white p-6 lg:p-8 rounded-3xl shadow-xl border border-gray-100 space-y-2">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi & Bantuan</h2>

                        <!-- Bantuan & FAQ -->
                        <a href="pengaturan/faq.php"
                        class="item-hover-lift flex items-center py-3 px-3 -mx-3 rounded-xl group transition duration-150 ease-in-out">
                            <i class="fas fa-circle-question text-indigo-500 mr-4 text-xl lg:text-2xl"></i>
                            <p class="flex-1 font-medium text-gray-800 text-sm lg:text-base">
                                Bantuan & FAQ
                            </p>
                            <i class="fas fa-chevron-right text-gray-400 text-sm lg:text-base group-hover:text-indigo-500"></i>
                        </a>

                        <!-- Pengaturan Akun -->
                        <a href="pengaturan/profil.php"
                        class="item-hover-lift flex items-center py-3 px-3 -mx-3 rounded-xl group border-t border-gray-100 pt-4 transition duration-150 ease-in-out">
                            <i class="fas fa-user-gear text-indigo-500 mr-4 text-xl lg:text-2xl"></i>
                            <p class="flex-1 font-medium text-gray-800 text-sm lg:text-base">
                                Pengaturan Akun & Profil
                            </p>
                            <i class="fas fa-chevron-right text-gray-400 text-sm lg:text-base group-hover:text-indigo-500"></i>
                        </a>

                        <!-- Perjalanan Rank -->
                        <a href="pengaturan/pencapaian.php"
                        class="item-hover-lift flex items-center py-3 px-3 -mx-3 rounded-xl group border-t border-gray-100 pt-4 transition duration-150 ease-in-out">
                            <i class="fas fa-award text-indigo-500 mr-4 text-xl lg:text-2xl"></i>
                            <p class="flex-1 font-medium text-gray-800 text-sm lg:text-base">
                                Pencapaian Anda
                            </p>
                            <i class="fas fa-chevron-right text-gray-400 text-sm lg:text-base group-hover:text-indigo-500"></i>
                        </a>
                    </div>

                    <div class="bg-white p-6 lg:p-8 rounded-3xl shadow-xl border border-gray-100 space-y-2">
                        <h2 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Sistem</h2>

                        <!-- Keamanan & Privasi -->
                        <a href="pengaturan/ganti_pw.php"
                        class="item-hover-lift flex items-center py-3 px-3 -mx-3 rounded-xl group transition duration-150 ease-in-out">
                            <i class="fas fa-shield-halved text-indigo-500 mr-4 text-xl lg:text-2xl"></i>
                            <p class="flex-1 font-medium text-gray-800 text-sm lg:text-base">
                                Keamanan & Privasi
                            </p>
                            <i class="fas fa-chevron-right text-gray-400 text-sm lg:text-base group-hover:text-indigo-500"></i>
                        </a>

                        <!-- Tema & Tampilan -->
                        <a href="comingSoon.php"
                        class="item-hover-lift flex items-center py-3 px-3 -mx-3 rounded-xl group border-t border-gray-100 pt-4 transition duration-150 ease-in-out">
                            <i class="fas fa-palette text-indigo-500 mr-4 text-xl lg:text-2xl"></i>
                            <p class="flex-1 font-medium text-gray-800 text-sm lg:text-base">
                                Tema & Tampilan
                            </p>
                            <i class="fas fa-chevron-right text-gray-400 text-sm lg:text-base group-hover:text-indigo-500"></i>
                        </a>

                        <!-- Integrasi Layanan -->
                        <a href="comingSoon.php"
                        class="item-hover-lift flex items-center py-3 px-3 -mx-3 rounded-xl group border-t border-gray-100 pt-4 transition duration-150 ease-in-out">
                            <i class="fas fa-plug text-indigo-500 mr-4 text-xl lg:text-2xl"></i>
                            <p class="flex-1 font-medium text-gray-800 text-sm lg:text-base">
                                Integrasi Layanan
                            </p>
                            <i class="fas fa-chevron-right text-gray-400 text-sm lg:text-base group-hover:text-indigo-500"></i>
                        </a>
                    </div>
                    <button id="logoutButton"
                        class="btn-hover-scale col-span-1 lg:col-span-2 flex items-center justify-center w-full
                            bg-white p-4 lg:p-6 rounded-2xl text-rose-600 font-bold text-lg
                            hover:bg-rose-50 transition duration-200 shadow-xl mt-6 lg:mt-0">

                        <i class="fas fa-right-from-bracket mr-3 text-xl lg:text-2xl"></i>
                        Keluar Akun
                    </button>
                </div>
            </div>
        </div>
    </main>

    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white p-6 rounded-xl shadow-2xl w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Konfirmasi Keluar</h3>
            <p class="text-gray-600 mb-6">Apakah kamu yakin ingin keluar dari akun ini?</p>
            <div class="flex justify-end space-x-3">
                <button onclick="closeModal()" class="px-4 py-2 text-gray-700 bg-gray-200 rounded-lg font-semibold hover:bg-gray-300 transition duration-150">Batal</button>
                <a href="../auth/logout.php" class="px-4 py-2 text-white bg-rose-600 rounded-lg font-semibold hover:bg-rose-700 transition duration-150">Keluar</a>
            </div>
        </div>
    </div>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>
</body>

</html>
