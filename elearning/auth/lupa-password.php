<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Format email tidak valid.";
    } else {
        $stmt = $pdo->prepare("SELECT id, nama FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $expired = date("Y-m-d H:i:s", strtotime("+1 hour")); // Berlaku 1 jam

            $update = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expired = ? WHERE email = ?");
            if ($update->execute([$token, $expired, $email])) {
                
                $mail = new PHPMailer(true);
                try {
                    // Konfigurasi SMTP (Sama dengan register)
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'kediriumkm82@gmail.com'; 
                    $mail->Password   = 'mbaykuboatdeduox'; 
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom('kediriumkm82@gmail.com', 'Admin SMK Learn');
                    $mail->addAddress($email, $user['nama']);
                    $mail->isHTML(true);

                    $reset_link = "http://localhost/elearning/auth/reset-password.php?token=" . $token;

                    $mail->Subject = 'Reset Kata Sandi - SMK Learn';
                    $mail->Body    = "
                    <div style='font-family: \"Plus Jakarta Sans\", sans-serif, Arial; background-color: #f0f9ff; padding: 40px; text-align: center;'>
                        <div style='max-width: 500px; margin: 0 auto; background-color: #ffffff; padding: 40px; border-radius: 24px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);'>
                            
                            <div style='margin-bottom: 20px;'>
                                <div style='display: inline-block; width: 64px; height: 64px; background-color: #ecfeff; border-radius: 16px; line-height: 64px;'>
                                    <span style='font-size: 32px;'>🔐</span>
                                </div>
                            </div>
                            
                            <h2 style='color: #1e293b; margin-bottom: 10px; font-weight: 800;'>Reset Kata Sandi</h2>
                            
                            <p style='color: #64748b; font-size: 16px; line-height: 1.6;'>
                                Halo <strong>{$user['nama']}</strong>, <br>
                                Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di <strong>SMK Learn</strong>. 
                            </p>
                            
                            <div style='background-color: #fff7ed; border-radius: 12px; padding: 12px; margin: 20px 0;'>
                                <p style='color: #c2410c; font-size: 13px; font-weight: 600; margin: 0;'>
                                    ⚠️ Link ini hanya berlaku selama 1 jam.
                                </p>
                            </div>

                            <div style='margin-top: 30px;'>
                                <a href='$reset_link' style='
                                    display: inline-block;
                                    padding: 16px 32px;
                                    background: linear-gradient(to bottom right, #0891b2, #1d4ed8);
                                    color: #ffffff !important;
                                    text-decoration: none;
                                    font-weight: bold;
                                    font-size: 14px;
                                    border-radius: 12px;
                                    text-transform: uppercase;
                                    letter-spacing: 1px;
                                    box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3);
                                '>Atur Ulang Kata Sandi</a>
                            </div>

                            <div style='margin-top: 40px; padding-top: 25px; border-top: 1px solid #f1f5f9;'>
                                <p style='color: #94a3b8; font-size: 12px; line-height: 1.5;'>
                                    Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini dengan aman. Akun Anda tetap terlindungi.<br><br>
                                    &copy; 2026 <strong>E-Learning SMK System</strong>
                                </p>
                            </div>
                        </div>
                    </div>";

                    $mail->send();
                    $success_message = "Instruksi reset kata sandi telah dikirim ke email Anda.";
                } catch (Exception $e) {
                    $errors[] = "Gagal mengirim email: " . $mail->ErrorInfo;
                }
            }
        } else {
            // Untuk keamanan, jangan beri tahu jika email tidak ada, tapi di sini kita buat simpel
            $errors[] = "Email tidak terdaftar di sistem kami.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body class="flex items-center justify-center min-h-screen p-6 py-12 relative overflow-y-auto">
    <div class="shape w-96 h-96 bg-cyan-300 top-[-10%] left-[-10%] rounded-full"></div>
    <div class="shape w-80 h-80 bg-blue-300 bottom-[-10%] right-[-10%] rounded-full" style="animation-delay: -5s;"></div>

    <div class="w-full max-w-md relative z-10">
        <div class="text-center mb-6">
            <span class="bg-cyan-100 text-cyan-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                Pemulihan Akun
            </span>
        </div>

        <div class="glass-card p-10 rounded-3xl relative overflow-hidden">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-cyan-500 to-blue-600 text-white shadow-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-800">Lupa Kata Sandi?</h1>
                <p class="text-slate-500 text-sm mt-1">Masukkan email Anda untuk menerima link reset password.</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="bg-red-50 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg text-sm flex items-start shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <div>
                        <?php foreach ($errors as $e) echo htmlspecialchars($e) . "<br>"; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (isset($success_message) && $success_message): ?>
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-lg text-sm flex items-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <?= htmlspecialchars($success_message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2 ml-1">
                        Email Akun
                    </label>
                    <input type="email" name="email" required
                        placeholder="nama@gmail.com"
                        class="input-focus-effect w-full px-5 py-3.5 rounded-2xl bg-white/50 border border-slate-200 focus:border-cyan-500 focus:ring-4 focus:ring-cyan-500/10 outline-none transition-all placeholder:text-slate-400">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-700 hover:to-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-cyan-200 transition active:scale-[0.98]">
                    Kirim Link Reset
                </button>
            </form>

            <div class="mt-10 pt-6 border-t border-slate-200/50 text-center">
                <p class="text-slate-600 text-sm">
                    Ingat kata sandi? 
                    <a href="login.php" class="text-cyan-600 font-bold hover:underline ml-1">Kembali ke Login</a>
                </p>
            </div>
        </div>

        <p class="text-center text-slate-400 text-xs mt-8">
            2026 E-Learning SMK.
        </p>
    </div>
</body>
</html>