<?php
require_once __DIR__ . '/../config/db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Cari user dengan token tersebut yang belum diverifikasi
    $stmt = $pdo->prepare("SELECT id FROM users WHERE token = ? AND is_verified = 0 LIMIT 1");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        // Update user: aktifkan akun dan hapus tokennya
        $update = $pdo->prepare("UPDATE users SET is_verified = 1, token = NULL WHERE id = ?");
        $update->execute([$user['id']]);
        
        $status = "success";
        $pesan = "Akun Anda berhasil diaktifkan! Silakan masuk.";
    } else {
        $status = "error";
        $pesan = "Link tidak valid atau akun sudah pernah diverifikasi.";
    }
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Verifikasi | Sistem Sekolah</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f9ff;
            background-image: 
                radial-gradient(at 0% 0%, hsla(199,100%,93%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(187,100%,92%,1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, hsla(199,100%,90%,1) 0, transparent 50%), 
                radial-gradient(at 0% 100%, hsla(187,100%,92%,1) 0, transparent 50%);
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
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-6 relative overflow-hidden">

    <div class="shape w-96 h-96 bg-cyan-300 top-[-10%] left-[-10%] rounded-full"></div>
    <div class="shape w-80 h-80 bg-blue-300 bottom-[-10%] right-[-10%] rounded-full" style="animation-delay: -5s;"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-6">
            <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                Sistem Verifikasi
            </span>
        </div>

        <div class="glass-card p-10 rounded-3xl text-center">
            
            <?php if ($status == "success"): ?>
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-green-400 to-emerald-600 text-white shadow-lg flex items-center justify-center">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Verifikasi Berhasil!</h2>
                <p class="text-slate-500 text-sm mb-10 leading-relaxed">
                    <?= htmlspecialchars($pesan) ?>
                </p>
                
                <a href="login.php" 
                   class="block w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-200 transform transition active:scale-[0.98]">
                    Masuk ke Kelas
                </a>

            <?php else: ?>
                <div class="flex justify-center mb-8">
                    <div class="w-20 h-20 rounded-2xl bg-gradient-to-tr from-red-400 to-rose-600 text-white shadow-lg flex items-center justify-center">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
                
                <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Verifikasi Gagal</h2>
                <p class="text-slate-500 text-sm mb-10 leading-relaxed">
                    <?= htmlspecialchars($pesan) ?>
                </p>
                
                <div class="space-y-4">
                    <a href="register.php" 
                       class="block w-full bg-gradient-to-r from-slate-600 to-slate-700 hover:from-slate-700 hover:to-slate-800 text-white font-bold py-4 rounded-2xl shadow-lg transform transition active:scale-[0.98]">
                        Daftar Ulang
                    </a>
                    <a href="login.php" class="block text-cyan-600 text-sm font-bold hover:underline transition-all">
                        Kembali ke Login
                    </a>
                </div>
            <?php endif; ?>

        </div>

        <p class="text-center text-slate-400 text-xs mt-8">
            2026 E-Learning SMK.
        </p>
    </div>

</body>
</html>