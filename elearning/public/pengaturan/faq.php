<?php
session_start();
include '../../config/db.php'; 

// Cek user sudah login?
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

    $nama = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $initial = strtoupper(substr($nama, 0, 1));

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

    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        $bg_random = array_rand($warna_map);
        $border_random = $warna_map[$bg_random];
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $border_random;
    } else {
        $bg_random = $_SESSION['avatar_bg'];
        $border_random = $_SESSION['avatar_border'];
    }

    $foto = !empty($user['foto_profil']) ? "../../" . htmlspecialchars($user['foto_profil']) : null;

} catch (PDOException $e) {
    echo "Terjadi kesalahan database: " . $e->getMessage();
    exit;
}

$faq_list = [
    ['id' => 'faq1', 'keywords' => 'tidak bisa login, gagal masuk, error', 'question' => 'Kenapa saya tidak bisa login ke platform?', 'answer' => 'Pastikan kata sandi yang Anda masukkan sudah benar. Periksa juga koneksi internet Anda.'],
    ['id' => 'faq2', 'keywords' => 'materi, modul, pembelajaran', 'question' => 'Di mana saya bisa melihat materi pembelajaran?', 'answer' => 'Materi pembelajaran dapat diakses melalui menu Materi pada sidebar atau dashboard.'],
    ['id' => 'faq3', 'keywords' => 'tugas, pengumpulan, upload', 'question' => 'Bagaimana cara mengumpulkan tugas?', 'answer' => 'Buka menu Tugas, pilih tugas yang tersedia, lalu unggah file sesuai instruksi guru.'],
    ['id' => 'faq4', 'keywords' => 'deadline, terlambat, batas waktu', 'question' => 'Apa yang terjadi jika saya terlambat?', 'answer' => 'Tugas dapat ditandai sebagai terlambat atau tidak dapat dikumpulkan tergantung kebijakan guru.'],
    ['id' => 'faq5', 'keywords' => 'pengumuman, informasi', 'question' => 'Di mana saya bisa melihat pengumuman?', 'answer' => 'Pengumuman terbaru dapat dilihat pada menu Pengumuman di dashboard.'],
    ['id' => 'faq6', 'keywords' => 'profil, data diri, foto', 'question' => 'Bagaimana cara mengubah data profil?', 'answer' => 'Anda dapat mengubah data profil melalui menu Pengaturan Akun.'],
    ['id' => 'faq7', 'keywords' => 'hp, android, mobile', 'question' => 'Apakah platform bisa diakses melalui HP?', 'answer' => 'Ya, platform dapat diakses melalui HP, tablet, maupun komputer.'],
    ['id' => 'faq8', 'keywords' => 'bantuan, admin, kontak', 'question' => 'Siapa yang harus saya hubungi?', 'answer' => 'Silakan hubungi administrator sekolah atau guru melalui kontak yang tersedia.']
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan & FAQ SMK Learn</title>
    <link rel="shortcut icon" href="../../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen font-['Inter'] bg-[#eef3f8] [background-image:radial-gradient(#d3e0f0_1px,transparent_1px)] [background-size:20px_20px]">
    
    <div class="fixed top-0 left-0 w-[400px] h-[400px] bg-blue-500/20 blur-3xl rounded-full -translate-x-1/2 -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-[500px] h-[500px] bg-purple-500/20 blur-3xl rounded-full translate-x-1/2 translate-y-1/2 pointer-events-none z-0"></div>

    <div id="top-loader" class="fixed top-0 left-0 h-[3px] w-0 bg-blue-600 z-[9999] transition-all duration-300"></div>

    <header class="fixed top-0 left-0 w-full h-12 bg-gray-800/75 backdrop-blur-md text-white shadow-xl z-40 md:hidden">
        <div class="h-full flex items-center justify-between px-3">
            <a href="../pengaturan.php" class="flex items-center gap-2 text-sm font-medium text-gray-200 hover:text-white transition">
                <i class="fa-solid fa-arrow-left text-base"></i> Kembali
            </a>
            <div class="flex items-center h-8 border-l border-gray-700 pl-3">
                <?php if ($foto): ?>
                    <!-- Tampilkan foto pengguna, aman dengan htmlspecialchars -->
                    <img src="<?= htmlspecialchars($foto); ?>" 
                        class="w-7 h-7 rounded-full object-cover border <?= htmlspecialchars($border_random); ?>" 
                        alt="Foto">
                <?php else: ?>
                    <!-- Tampilkan inisial jika foto tidak ada, aman dengan htmlspecialchars -->
                    <div class="w-7 h-7 rounded-full flex items-center justify-center text-white text-sm font-bold border <?= htmlspecialchars($bg_random); ?> <?= htmlspecialchars($border_random); ?>">
                        <?= htmlspecialchars($initial); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <header class="shadow-2xl p-6 md:p-10 bg-blue-600 dark:bg-gray-900 text-white relative overflow-hidden w-full rounded-b-[15%] lg:mt-8 lg:mx-auto lg:w-[96%] lg:max-w-7xl lg:rounded-t-xl lg:rounded-b-2xl"> 
        <div class="absolute inset-0 bg-gradient-to-br from-blue-700/50 via-purple-700/50 to-pink-700/50 pointer-events-none opacity-50"></div>
        <div class="flex flex-col md:flex-row items-center justify-between z-10 relative pt-6 md:pt-0">
            <div class="hidden lg:block">
                <a href="../pengaturan.php" class="inline-flex items-center justify-center bg-white/20 backdrop-blur-sm text-white w-10 h-10 rounded-full transition duration-200 hover:bg-white/40 hover:scale-105 ring-2 ring-white/50">
                    <i class="fa-solid fa-arrow-left text-lg"></i>
                </a>
            </div>
            <div class="text-white text-center w-full md:w-auto mt-4 md:mt-0 lg:mx-auto">
                <h1 class="text-3xl sm:text-4xl font-extrabold mb-2">Pusat Bantuan & FAQ</h1>
                <p class="text-base sm:text-xl font-light opacity-90">E-Learning SMK Hebat - Kami siap membantu Anda.</p>
            </div>
            <div class="mt-6 md:mt-0 flex-shrink-0">
                <i class="fa-solid fa-circle-question text-white opacity-90 text-6xl md:text-7xl"></i>
            </div>
        </div>
    </header>
    
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <section class="mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-8 text-center">Pertanyaan yang Sering Diajukan (FAQ)</h2>
            <div id="faq-container" class="space-y-4 max-w-4xl mx-auto">
                <?php foreach ($faq_list as $faq): ?>
                <div class="rounded-xl overflow-hidden shadow-md transition duration-300 hover:-translate-y-0.5 hover:shadow-xl bg-white/60 backdrop-blur-[10px] border border-white/50" 
                    data-keywords="<?= htmlspecialchars($faq['keywords']); ?>"> <!-- Escape keywords untuk keamanan -->
                    
                    <div class="cursor-pointer py-5 px-6 flex justify-between items-center hover:bg-blue-50/50 transition duration-150" 
                        onclick="toggleAccordion('<?= htmlspecialchars($faq['id']); ?>')"> <!-- Escape ID -->
                        
                        <h3 class="text-base lg:text-lg font-semibold text-gray-800">
                            <?= htmlspecialchars($faq['question']); ?> <!-- Escape pertanyaan -->
                        </h3>
                        
                        <i id="arrow<?= substr(htmlspecialchars($faq['id']), -1); ?>" class="fa-solid fa-chevron-down text-blue-500 text-xl transition-transform duration-300"></i>
                    </div>
                    
                    <div id="<?= htmlspecialchars($faq['id']); ?>" class="max-h-0 overflow-hidden transition-[max-height,padding] duration-500 ease-in-out px-6 text-gray-600">
                        <div class="pt-2 pb-6 border-t border-blue-200/30">
                            <!-- Jika jawaban mengandung HTML, pastikan aman, bisa pakai strip_tags atau purify -->
                            <p><?= htmlspecialchars($faq['answer']); ?></p> 
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="max-w-4xl mx-auto text-center p-8 rounded-xl shadow-2xl border-t-4 border-blue-600/70 bg-white/60 backdrop-blur-[10px] border border-white/50">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Butuh Bantuan Lebih Lanjut?</h2>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="https://wa.me/6282143441168" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition duration-300 shadow-xl hover:scale-[1.02]">
                    Hubungi Dukungan Teknis
                </a>
            </div>
        </section>
    </div>

    <?php require_once __DIR__ . '/../../private/nav-bottom.php';?>

    <script>
        function toggleAccordion(id) {
            const content = document.getElementById(id);
            const arrowIcon = document.getElementById('arrow' + id.slice(-1));
            const item = content.closest('div[data-keywords]'); 

            const isActive = content.style.maxHeight && content.style.maxHeight !== '0px';

            // Close all
            document.querySelectorAll('[id^="faq"]').forEach(el => {
                el.style.maxHeight = '0px';
                el.closest('div[data-keywords]').classList.remove('bg-white/90', 'ring-4', 'ring-blue-300/50', 'shadow-2xl');
                el.closest('div[data-keywords]').classList.add('bg-white/60');
            });
            document.querySelectorAll('.fa-chevron-down').forEach(arrow => arrow.classList.remove('rotate-180'));

            if (!isActive) {
                content.style.maxHeight = '500px';
                item.classList.add('bg-white/90', 'ring-4', 'ring-blue-300/50', 'shadow-2xl');
                item.classList.remove('bg-white/60');
                arrowIcon.classList.add('rotate-180');
            }
        }
    </script>
</body>
</html>