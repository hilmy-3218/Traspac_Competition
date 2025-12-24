<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Sanitize & Validasi
    $nama = filter_input(INPUT_POST, 'nama', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $jurusan = filter_input(INPUT_POST, 'jurusan', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $guru_password = filter_input(INPUT_POST, 'guru_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (empty($nama)) $errors[] = "Nama wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email tidak valid.";
    if (strlen($password) < 6) $errors[] = "Password minimal 6 karakter.";
    if (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors[] = "Password harus mengandung kombinasi huruf dan angka.";
    }
    if ($password !== $konfirmasi_password) $errors[] = "Konfirmasi password tidak cocok.";
    if ($role == "guru" && $guru_password !== "merdeka") $errors[] = "Password khusus guru salah.";

    // 2. Cek duplikasi email
    if (empty($errors)) {
        $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email=:email");
        $stmt_check->execute(['email'=>$email]);
        if ($stmt_check->fetchColumn() > 0) $errors[] = "Email sudah digunakan.";
    }

    // 3. Simpan ke DB & Kirim Email
    if (empty($errors)) {
        try {
            $pdo->beginTransaction();

            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(32)); 

            $stmt = $pdo->prepare("INSERT INTO users (nama, jurusan, email, password, role, token, is_verified) VALUES (?, ?, ?, ?, ?, ?, 0)");
            $stmt->execute([$nama, $jurusan, $email, $hashed, $role, $token]);

            // KONFIGURASI MAIL
            $mail = new PHPMailer(true);
            
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kediriumkm82@gmail.com'; 
            $mail->Password   = 'mbaykuboatdeduox'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom('kediriumkm82@gmail.com', 'Admin Sekolah');
            $mail->addAddress($email, $nama);
            $mail->isHTML(true);

            $verif_link = "http://localhost/elearning/auth/verifikasi.php?token=" . $token;

            $mail->Subject = 'Verifikasi Akun - Sistem Sekolah';
            // Desain Email HTML yang lebih menarik
            $mail->Body    = "
            <div style='font-family: sans-serif; background-color: #f0f9ff; padding: 40px; text-align: center;'>
                <div style='max-width: 500px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'>
                    <h2 style='color: #1e293b; margin-bottom: 10px;'>Halo, $nama! 👋</h2>
                    <p style='color: #64748b; font-size: 16px; line-height: 1.6;'>
                        Terima kasih telah mendaftar di <strong>SMK Learn</strong>. <br>
                        Silakan konfirmasi email Anda untuk mengaktifkan akun.
                    </p>
                    <div style='margin-top: 30px;'>
                        <a href='$verif_link' style='
                            display: inline-block;
                            padding: 14px 32px;
                            background: linear-gradient(to bottom right, #0891b2, #1d4ed8);
                            color: #ffffff;
                            text-decoration: none;
                            font-weight: bold;
                            font-size: 14px;
                            border-radius: 12px;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                            box-shadow: 0 4px 6px -1px rgba(8, 145, 178, 0.4);
                        '>Verifikasi Akun Sekarang</a>
                    </div>
                    <p style='color: #94a3b8; font-size: 12px; margin-top: 30px;'>
                        Jika Anda tidak merasa mendaftar, abaikan email ini. <br>
                        &copy; 2026 SMK Learn System
                    </p>
                </div>
            </div>";

            $mail->send();
            $pdo->commit();
            $success_message = "Registrasi berhasil! Silakan cek email Anda untuk verifikasi.";
            
        } catch (Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            $errors[] = "Gagal mengirim email: " . $mail->ErrorInfo;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning SMK | Daftar Akun</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f9ff;
            background-image: 
                radial-gradient(at 0% 0%, hsla(199,100%,93%,1) 0px, transparent 70%), 
                radial-gradient(at 100% 0%, hsla(187,100%,92%,1) 0px, transparent 70%), 
                radial-gradient(at 100% 100%, hsla(199,100%,90%,1) 0px, transparent 70%), 
                radial-gradient(at 0% 100%, hsla(187,100%,92%,1) 0px, transparent 70%);
            background-attachment: fixed;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.05);
        }

        .shape {
            position: fixed;
            z-index: -1;
            filter: blur(100px);
            opacity: 0.5;
            pointer-events: none;
            animation: move 25s infinite alternate ease-in-out;
        }

        @keyframes move {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(80px, 40px) scale(1.1); }
        }

        .input-focus-effect {
            transition: all 0.2s ease-in-out;
        }
        .input-focus-effect:focus {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 md:p-8 relative overflow-x-hidden">
    <!-- loader -->
    <div id="top-loader" class="fixed top-0 left-0 h-[3px] w-0 bg-blue-600 z-[9999] transition-all duration-300"></div>

    <div class="shape w-[500px] h-[500px] bg-cyan-200 top-[-10%] left-[-10%] rounded-full"></div>
    <div class="shape w-[400px] h-[400px] bg-blue-200 bottom-[-10%] right-[-10%] rounded-full" style="animation-delay: -7s;"></div>

    <div class="w-full max-w-2xl my-6"> 
        <div class="text-center mb-8">
            <span class="bg-white/60 backdrop-blur-sm text-cyan-700 text-[10px] font-extrabold px-4 py-1.5 rounded-full uppercase tracking-[0.2em] shadow-sm border border-white">
                Registrasi Siswa & Guru
            </span>
        </div>

        <div class="glass-card p-6 md:p-12 rounded-[2.5rem] relative">
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Daftar Akun Baru</h1>
                <p class="text-slate-500 text-sm mt-2 font-medium">Bergabunglah dengan ribuan siswa cerdas lainnya</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-50/80 border-red-500 text-red-700 p-4 mb-6 rounded-r-xl text-sm backdrop-blur-sm">
                    <ul class="list-none list-inside space-y-1">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
                <div class="bg-emerald-50/80 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-xl text-sm backdrop-blur-sm flex items-center">
                    <svg class="w-5 h-5 mr-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="font-bold"><?php echo htmlspecialchars($success_message); ?></p>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php" enctype="multipart/form-data" class="space-y-5">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 ml-1 uppercase tracking-wider">Nama</label>
                        <input type="text" name="nama" required placeholder="Nama"
                            class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/40 border border-slate-200/60 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none"
                            value="<?= $_POST['nama'] ?? '' ?>">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 ml-1 uppercase tracking-wider">Daftar Sebagai</label>
                        <div class="relative">
                            <select name="role" id="role" onchange="toggleGuruField(this.value)"
                                class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/40 border border-slate-200/60 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none appearance-none cursor-pointer">
                                <option value="siswa" <?= (($_POST['role'] ?? '') == 'siswa') ? 'selected' : '' ?>>Siswa</option>
                                <option value="guru" <?= (($_POST['role'] ?? '') == 'guru') ? 'selected' : '' ?>>Guru</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 ml-1 uppercase tracking-wider">Jurusan</label>
                        <div class="relative">
                            <select name="jurusan" required
                                class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/40 border border-slate-200/60 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none appearance-none cursor-pointer">
                                <option value="">Pilih Jurusan</option>
                                <?php
                                $jurusan_list = ['RPL','TKJ','Akuntansi','Multimedia','Pemasaran'];
                                foreach ($jurusan_list as $j) {
                                    $sel = (isset($_POST['jurusan']) && $_POST['jurusan'] == $j) ? "selected" : "";
                                    echo "<option value='$j' $sel>$j</option>";
                                }
                                ?>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 ml-1 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" required placeholder="email@gmail.com"
                            class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/40 border border-slate-200/60 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none"
                            value="<?= $_POST['email'] ?? '' ?>">
                    </div>
                </div>

                <div id="guru-password-field" class="<?= (($_POST['role'] ?? '') == 'guru') ? '' : 'hidden' ?> transition-all duration-300">
                    <label class="block text-xs font-bold text-red-600 mb-2 ml-1 uppercase tracking-wider">Kode Guru</label>
                    <input type="password" id="guru_password" name="guru_password" placeholder="Masukkan kode otorisasi pengajar"
                        class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-red-50/30 border border-red-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 ml-1 uppercase tracking-wider">Kata Sandi</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/40 border border-slate-200/60 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-2 ml-1 uppercase tracking-wider">Ulangi Sandi</label>
                        <input type="password" name="konfirmasi_password" required placeholder="••••••••"
                            class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/40 border border-slate-200/60 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-br from-cyan-600 to-blue-700 hover:shadow-xl hover:shadow-cyan-200/50 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-200 transform transition active:scale-[0.98] tracking-widest uppercase text-[13px] mt-4">
                    Buat Akun Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-200/60 text-center">
                <p class="text-slate-500 text-sm">
                    Sudah punya akun? 
                    <a href="login.php" class="text-cyan-600 font-extrabold hover:text-cyan-700 ml-1 transition-colors">Masuk di sini</a>
                </p>
            </div>
        </div>

        <p class="text-center text-slate-400 text-[10px] mt-8 uppercase tracking-[0.3em] font-medium">
            2026 SMK Learn
        </p>
    </div>

    <script>
        function toggleGuruField(role) {
            const field = document.getElementById('guru-password-field');
            if (role === 'guru') {
                field.classList.remove('hidden');
                field.style.opacity = '0';
                setTimeout(() => field.style.opacity = '1', 10);
            } else {
                field.classList.add('hidden');
            }
        }
        
        document.addEventListener('DOMContentLoaded', () => {
            toggleGuruField(document.getElementById('role').value);
        });

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
