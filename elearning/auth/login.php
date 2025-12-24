<?php
// Mulai sesi
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';

$login_error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Ambil dan Sanitasi Input
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password']; 

    if (empty($email) || empty($password)) {
        $login_error = "Email dan password wajib diisi.";
    } else {
        // 2. Cari User di Database
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // 3. Verifikasi Password
                if (password_verify($password, $user['password'])) {
                    
                    // --- TAMBAHAN LOGIKA VERIFIKASI EMAIL ---
                    if ($user['is_verified'] == 0) {
                        $login_error = "Akun Anda belum aktif. Silakan cek email Anda untuk melakukan verifikasi.";
                    } else {
                        // Login Berhasil
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['user_nama'] = htmlspecialchars($user['nama']);
                        $_SESSION['user_role'] = htmlspecialchars($user['role']);
                        
                        header("Location: ../public/dashboard.php");
                        exit();
                    }
                    // ----------------------------------------
                } else {
                    // Password salah
                    $login_error = "Email atau Password salah.";
                }
            } else {
                // Email tidak ditemukan di DB
                $login_error = "Akun Anda belum terdaftar.";
            }

        } catch (PDOException $e) {
            $login_error = "Terjadi kesalahan database. Silakan coba lagi.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning SMK | Login</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f9ff;
            background-image: 
                radial-gradient(at 0% 0%, hsla(199,100%,93%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(187,100%,92%,1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, hsla(199,100%,90%,1) 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(187,100%,92%,1) 0, transparent 50%);
            /* Pastikan background menutupi seluruh tinggi konten saat scroll */
            background-attachment: fixed;
        }

        /* Glassmorphism Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }

        /* Perubahan: Menggunakan position fixed agar elemen hiasan tidak lari saat scroll */
        .shape {
            position: fixed;
            z-index: -1;
            filter: blur(80px);
            opacity: 0.4;
            animation: move 20s infinite alternate;
        }

        @keyframes move {
            from { transform: translate(0, 0); }
            to { transform: translate(100px, 50px); }
        }

        .input-focus-effect {
            transition: all 0.3s ease;
        }
        .input-focus-effect:focus {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-1px);
        }

        /* Opsional: Mempercantik Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #0891b2; 
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0e7490;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6 py-12 relative overflow-y-auto">
    <!-- loader -->
    <div id="top-loader" class="fixed top-0 left-0 h-[3px] w-0 bg-blue-600 z-[9999] transition-all duration-300"></div>

    <div class="shape w-96 h-96 bg-cyan-300 top-[-10%] left-[-10%] rounded-full"></div>
    <div class="shape w-80 h-80 bg-blue-300 bottom-[-10%] right-[-10%] rounded-full" style="animation-delay: -5s;"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-6">
            <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                Pembelajaran Digital
            </span>
        </div>

        <div class="glass-card p-10 rounded-3xl relative overflow-hidden">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500 to-blue-600 text-white shadow-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-800">E-learning SMK</h1>
                <p class="text-slate-500 text-sm mt-1">Silahkan masuk untuk memulai belajar</p>
            </div>

            <?php if (isset($login_error) && $login_error): ?>
                <div class="bg-red-50 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg text-sm flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <?php echo htmlspecialchars($login_error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Email Siswa / Guru</label>
                    <input type="email" name="email" required 
                        placeholder="nama@gmail.com"
                        class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/50 border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all placeholder:text-slate-400"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div>
                    <div class="mb-2 ml-1">
                        <label class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                    </div>
                    <input type="password" name="password" required 
                        placeholder="••••••••"
                        class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/50 border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all placeholder:text-slate-400">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-200 transform transition active:scale-[0.98]">
                    Masuk ke Kelas
                </button>
            </form>

            <div class="mt-10 pt-6 border-t border-slate-200/50 text-center">
                <p class="text-slate-600 text-sm">
                    Baru di sini? 
                    <a href="register.php" class="text-cyan-600 font-bold hover:underline ml-1">Daftar Akun Siswa</a>
                </p>
            </div>
        </div>

        <p class="text-center text-slate-400 text-xs mt-8">
            2026 E-Learning SMK Pintar.
        </p>
    </div>
    <script>
        // loader js
        const loader = document.getElementById("top-loader");
        let progress = 0;
        let interval;
        let isBackNavigation = false; // 🔹 flag untuk tombol back

        function startLoading() {
            // ⛔ Jangan aktifkan loader jika navigasi dari back()
            if (isBackNavigation) return;

            clearInterval(interval);
            loader.style.opacity = "1";
            progress = 5;
            loader.style.width = progress + "%";

            interval = setInterval(() => {
            if (progress < 90) {
                progress += (90 - progress) * 0.08; // adaptif & lambat
                loader.style.width = progress + "%";
            }
            }, 200);
        }

        function finishLoading() {
            clearInterval(interval);
            loader.style.width = "100%";

            setTimeout(() => {
            loader.style.opacity = "0";
            }, 300);

            setTimeout(() => {
            loader.style.width = "0%";
            progress = 0;
            }, 600);
        }

        // 🔹 MUNCUL SAAT PAGE LOAD
        document.addEventListener("DOMContentLoaded", startLoading);
        window.addEventListener("load", finishLoading);

        // 🔹 HANDLE BACK/FORWARD CACHE (BFCache)
        window.addEventListener("pageshow", () => {
            isBackNavigation = false; // reset flag
            finishLoading();
        });

        // 🔹 MUNCUL SAAT KLIK LINK (KECUALI BACK)
        document.querySelectorAll("a[href]").forEach(link => {
            link.addEventListener("click", () => {
            startLoading();
            });
        });

        // 🔹 FETCH TRACKING (WAJIB pakai ini kalau AJAX)
        async function trackedFetch(url, options = {}) {
            startLoading();
            try {
            return await fetch(url, options);
            } finally {
            finishLoading();
            }
        }

        // 🔹 FUNGSI TOMBOL KEMBALI (PAKAI INI)
        function goBack() {
            isBackNavigation = true;
            history.back();
        }
    </script>
</body>
</html>