<?php
// Pastikan sesi dimulai
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/db.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

/* =======================
    AMBIL DATA USER
======================= */
try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../../auth/login.php");
        exit;
    }

    $nama    = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $email   = htmlspecialchars($user['email'] ?? '-');
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

} catch (PDOException $e) {
    // Di lingkungan produksi, ini bisa diganti dengan logging error
    die("Error database: " . $e->getMessage()); 
}

/* =======================
    PROSES GANTI PASSWORD
======================= */
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password_lama = $_POST['password_lama'] ?? '';
    $password_baru = $_POST['password_baru'] ?? '';
    $konfirmasi    = $_POST['konfirmasi_password'] ?? '';

    if (empty($password_lama) || empty($password_baru) || empty($konfirmasi)) {
        $error = "Semua field wajib diisi.";
    } elseif (strlen($password_baru) < 6) {
        $error = "Password baru minimal 6 karakter.";
    } elseif ($password_baru !== $konfirmasi) {
        $error = "Konfirmasi password tidak cocok.";
    } elseif (!password_verify($password_lama, $user['password'])) {
        $error = "Password lama salah.";
    } else {
        $hash = password_hash($password_baru, PASSWORD_DEFAULT);
        try {
            $update = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
            $update->execute([
                'password' => $hash,
                'id' => $user_id
            ]);
            $success = "Password berhasil diperbarui.";
            // Clear inputs after success
            unset($_POST);
        } catch (PDOException $e) {
             $error = "Gagal memperbarui password di database.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="shortcut icon" href="../../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Custom styles for the light theme and font */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Ensure eye icon color changes on focus-within (lighter theme adjustment) */
        .input-group:focus-within .eye-icon {
            color: #4f46e5; /* Indigo-600 for focus */
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    
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
                    <!-- Escape URL & class untuk keamanan -->
                    <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                        class="w-7 h-7 rounded-full object-cover border <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>"
                        alt="Foto Profil">
                <?php else: ?>
                    <!-- Escape semua data yang di-render -->
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

    <!-- FORM CONTAINER - Updated classes for stronger glassmorphism and increased mobile padding -->
    <div class="bg-white/80 w-full max-w-lg rounded-2xl shadow-2xl px-8 py-12 backdrop-blur-xl 
                 transform transition-all hover:shadow-indigo-400/80 border border-white/50 z-10 md:py-8">
        
        <div class="mb-8 text-center">
            <!-- Icon keamanan diganti Font Awesome -->
            <i class="fas fa-lock w-12 h-12 mx-auto text-indigo-600 text-3xl"></i>
            <h2 class="text-3xl font-bold text-gray-800 mt-3">Perbarui Keamanan</h2>
            <!-- Output email aman dari XSS -->
            <p class="text-gray-600 text-sm">Anda akan mengubah password untuk akun: 
                <span class="text-indigo-600 font-semibold"><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></span>
            </p>
        </div>

        <?php if ($error): ?>
            <!-- Notifikasi error aman dan icon diganti Font Awesome -->
            <div class="bg-red-100 text-red-800 border border-red-400 p-4 rounded-xl mb-6 flex items-center space-x-3 transition-all duration-300">
                <i class="fas fa-exclamation-circle w-5 h-5"></i>
                <span class="font-medium"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <!-- Notifikasi sukses aman dan icon diganti Font Awesome -->
            <div class="bg-green-100 text-green-800 border border-green-400 p-4 rounded-xl mb-6 flex items-center space-x-3 transition-all duration-300">
                <i class="fas fa-check-circle w-5 h-5"></i>
                <span class="font-medium"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            
            <div class="input-group relative">
                <!-- Label password lama -->
                <label for="password_lama" class="block text-sm font-medium text-gray-700 mb-1">Password Lama</label>
                <input type="password" name="password_lama" id="password_lama" required
                    class="w-full pl-4 pr-12 py-3 bg-gray-50 text-gray-800 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 placeholder-gray-400"
                    placeholder="Masukkan password lama Anda" autocomplete="current-password" />
                <!-- Toggle visibility -->
                <button type="button" onclick="togglePasswordVisibility('password_lama', this)"
                        class="eye-icon absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-500 hover:text-indigo-600 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <div class="input-group relative">
                <!-- Label password baru -->
                <label for="password_baru" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password_baru" id="password_baru" required
                    class="w-full pl-4 pr-12 py-3 bg-gray-50 text-gray-800 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 placeholder-gray-400"
                    placeholder="Minimal 6 karakter" autocomplete="new-password" minlength="6" />
                <button type="button" onclick="togglePasswordVisibility('password_baru', this)"
                        class="eye-icon absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-500 hover:text-indigo-600 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <div class="input-group relative">
                <!-- Label konfirmasi password baru -->
                <label for="konfirmasi_password" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" required
                    class="w-full pl-4 pr-12 py-3 bg-gray-50 text-gray-800 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-200 placeholder-gray-400"
                    placeholder="Ulangi password baru" autocomplete="new-password" />
                <button type="button" onclick="togglePasswordVisibility('konfirmasi_password', this)"
                        class="eye-icon absolute inset-y-0 right-0 top-6 pr-3 flex items-center text-gray-500 hover:text-indigo-600 transition duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                
                <!-- Tombol Kembali (Desktop Only) -->
                <a href="../pengaturan.php"
                class="hidden md:inline-flex items-center gap-2 
                        text-gray-600 hover:text-indigo-600 
                        font-medium transition">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>

                <!-- Tombol Simpan -->
                <button type="submit"
                        class="w-full md:w-auto flex items-center justify-center 
                            bg-indigo-600 hover:bg-indigo-700 
                            text-white font-semibold 
                            px-6 py-3 rounded-xl 
                            shadow-lg shadow-indigo-500/50 
                            transition duration-300 
                            transform hover:scale-[1.02] active:scale-[0.98]">
                    <i class="fa-solid fa-floppy-disk mr-2"></i>
                    Simpan Password
                </button>

            </div>

        </form>

    </div>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../../private/nav-bottom.php';?>
    <script>

        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('svg');

            if (input.type === 'password') {
                input.type = 'text';
                // Change icon to 'eye-slash' (showing password)
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.59-3.237l.008-.016M16 12a4 4 0 01-8 0m.74-5.385l1.637 1.637m4.298 4.298L16 12a4 4 0 01-3.66 4.673"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.513 18.514A10.038 10.038 0 0021.542 12c-1.274-4.057-5.064-7-9.542-7a10.038 10.038 0 00-6.529 2.458"></path>';
            } else {
                input.type = 'password';
                // Change icon back to 'eye' (hiding password)
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }
    </script>
</body>
</html>