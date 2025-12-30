<?php
require_once __DIR__ . '/../config/db.php';

// 1. Ambil token dari URL
$token = isset($_GET['token']) ? trim($_GET['token']) : '';
$errors = [];
$success = false;
$is_link_valid = true;

if (empty($token)) {
    $is_link_valid = false;
} else {
    // 2. Validasi Token (Cek apakah token ada di database)
    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        $is_link_valid = false;
    }
}

// 3. Proses ganti password jika form disubmit dan link valid
if ($is_link_valid && $_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];

    if (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter.";
    }
    if ($password !== $konfirmasi) {
        $errors[] = "Konfirmasi password tidak cocok.";
    }

    if (empty($errors)) {
        try {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            
            // Ini membuat link tidak bisa dipakai untuk kedua kalinya
            $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expired = NULL WHERE id = ?");
            $update->execute([$hashed, $user['id']]);
            
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Kesalahan sistem: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setel Ulang Kata Sandi</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body class="flex items-center justify-center min-h-screen p-6 py-12 relative overflow-y-auto">
    <div class="shape w-96 h-96 bg-cyan-300 top-[-10%] left-[-10%] rounded-full"></div>
    <div class="shape w-80 h-80 bg-blue-300 bottom-[-10%] right-[-10%] rounded-full" style="animation-delay: -5s;"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-6">
            <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                Keamanan Akun
            </span>
        </div>

        <div class="glass-card p-10 rounded-3xl relative overflow-hidden">
            
            <?php if (!$is_link_valid): ?>
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 rotate-3">
                        <i class="fa-solid fa-link-slash text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 mb-3">Link Kedaluwarsa</h2>
                    <p class="text-slate-500 text-sm leading-relaxed mb-8">
                        Link ini sudah tidak berlaku atau sudah digunakan. Silakan ajukan permintaan reset baru.
                    </p>
                    <div class="space-y-3">
                        <a href="lupa-password.php" class="block w-full bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-200 transition active:scale-95">
                            Minta Link Baru
                        </a>
                        <a href="login.php" class="block w-full text-slate-500 font-semibold py-3 hover:text-cyan-600 transition text-sm">
                            Kembali ke Login
                        </a>
                    </div>
                </div>

            <?php elseif ($success): ?>
                <div class="text-center">
                    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 animate-bounce">
                        <i class="fa-solid fa-check-double text-3xl"></i>
                    </div>
                    <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Berhasil!</h2>
                    <p class="text-slate-500 text-sm mb-8">Kata sandi Anda telah diperbarui. Silakan login kembali dengan sandi baru.</p>
                    <a href="login.php" class="block w-full bg-gradient-to-r from-cyan-600 to-blue-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-200 transition active:scale-95">
                        Masuk Sekarang
                    </a>
                </div>

            <?php else: ?>
                <div class="mb-8">
                    <h2 class="text-2xl font-extrabold text-slate-800">Sandi Baru</h2>
                    <p class="text-slate-500 text-sm mt-1">Buat kata sandi yang kuat dan mudah diingat.</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="bg-red-50 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg text-sm flex items-start shadow-sm">
                        <i class="fa-solid fa-circle-exclamation mr-2 mt-1"></i>
                        <div>
                            <?php foreach ($errors as $error) echo htmlspecialchars($error) . "<br>"; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Kata Sandi Baru</label>
                        <input type="password" name="password" required 
                            placeholder="••••••••"
                            class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/50 border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">Konfirmasi Sandi</label>
                        <input type="password" name="konfirmasi_password" required 
                            placeholder="••••••••"
                            class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/50 border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all">
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-200 transition active:scale-[0.98]">
                        Simpan Perubahan
                    </button>
                </form>
            <?php endif; ?>

        </div>

        <p class="text-center text-slate-400 text-xs mt-8">
            2026 E-Learning SMK System.
        </p>
    </div>
</body>
</html>