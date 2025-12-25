<?php
session_start();
// Harap pastikan path ke db.php sudah benar di lingkungan Anda
include '../../config/db.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Autentikasi dan ambil data pengguna
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../../auth/login.php");
        exit;
    }

    // SANITASI DATA
    $nama    = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $email   = htmlspecialchars($user['email'] ?? 'email@contoh.com');
    $role    = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan = htmlspecialchars($user['jurusan'] ?? 'Umum');

    // HURUF PERTAMA (INITIAL)
    $initial = strtoupper(substr($nama, 0, 1));

    // --- LOGIKA PERSISTENSI WARNA AVATAR ---
    // Mapping warna untuk avatar yang konsisten
    $warna_map = [
        "bg-red-500"    => "border-red-500",
        "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500",
        "bg-green-500"  => "border-green-500",
        "bg-blue-500"   => "border-blue-500",
        "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500",
        "bg-pink-500"   => "border-pink-500"
    ];

    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        // Gunakan hash nama untuk warna konsisten
        $color_keys = array_keys($warna_map);
        $hash = crc32($nama) % count($color_keys);
        $bg_random = $color_keys[$hash];
        $border_random = $warna_map[$bg_random];

        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $border_random;
    } else {
        $bg_random = $_SESSION['avatar_bg'];
        $border_random = $_SESSION['avatar_border'];
    }

    // FIX: FOTO PROFIL
    $foto = (!empty($user['foto_profil']))
        ? "../../" . htmlspecialchars($user['foto_profil']) 
        : null; 
    
    $linkDiskusi = "../diskusi/diskusi_" . strtolower($jurusan) . ".php";

} catch (PDOException $e) {
    // Tampilkan pesan error yang lebih aman di lingkungan produksi
    error_log("Database error: " . $e->getMessage()); 
    // Untuk debugging lokal, bisa tampilkan pesan error:
    echo "Terjadi kesalahan database: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>
    <link rel="shortcut icon" href="../../assets/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" xintegrity="sha512-z9U+Y3B70Zf2X1Wqlk8CgD0aQpJtK/5Gc0iPhwYUGNdpFCXL/fjHJ4gYdK3+3nI0d5XHn+E6pJ6Jr1+6M5Qnkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            /* Latar belakang dasar untuk kontras glass */
            background: linear-gradient(135deg, #e0e7ff 0%, #f0f4ff 100%);
            position: relative;
            overflow: auto; /* Memungkinkan scroll normal */
        }
        
        /* Glassmorphism Effect for the Profile Card */
        .profile-card {
            background-color: rgba(255, 255, 255, 0.7); /* Lebih transparan */
            border: 1px solid rgba(255, 255, 255, 0.5); /* Border lebih terang */
            box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
            position: relative; 
            z-index: 10; 
            backdrop-filter: blur(15px); /* Blur yang lebih kuat */
            -webkit-backdrop-filter: blur(15px);
        }
        
        /* Gaya untuk info data di dalam card agar lebih kontras */
        .data-info {
            background-color: rgba(249, 250, 251, 0.85); /* Background lebih solid */
            border: 1px solid rgba(230, 230, 230, 0.8);
        }
    </style>
</head>
<body class="pt-16 pb-20 md:py-10">

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
        <div class="h-full flex items-center justify-end px-3">
            <!-- FOTO PROFIL / INITIAL kanan -->
            <div class="flex items-center">
                <?php if ($foto): ?>
                    <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                        class="w-7 h-7 rounded-full object-cover border <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>"
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

    <!-- Ukuran card utama max-w-sm dan padding diperkecil sedikit untuk membuatnya lebih ringkas -->
    <div id="mainCard" class="max-w-sm w-full mx-auto profile-card rounded-3xl p-6 relative 
                            /* Kelas Glassmorphism Kustom */
                            bg-white/20 backdrop-blur-md border border-white/30 shadow-2xl">

        <div id="notification-area">
            <?php if (isset($_GET['success'])): ?>
                <div class="p-4 mb-6 bg-emerald-500 text-white rounded-xl text-center shadow-lg border border-emerald-400">
                    <p class="font-bold">🎉 Berhasil!</p>
                    <p class="text-sm">Profil berhasil diperbarui.</p>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['error'])): ?>
                <div class="p-4 mb-6 bg-red-500 text-white rounded-xl text-center shadow-lg border border-red-400">
                    <p class="font-bold">⚠️ Gagal!</p>
                    <p class="text-sm">
                        <?php 
                            switch($_GET['error']) {
                                case 'format':
                                    echo "Format foto tidak didukung. Gunakan JPG, PNG atau WEBP.";
                                    break;
                                case 'size':
                                    echo "Ukuran foto terlalu besar! Maksimal 2MB.";
                                    break;
                                case 'invalid':
                                    echo "File yang diunggah bukan gambar yang valid.";
                                    break;
                                default:
                                    echo "Terjadi kesalahan saat memperbarui profil.";
                            }
                        ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <div id="viewProfileContainer" class="space-y-6">
            <h2 class="text-2xl font-extrabold text-center text-gray-800 tracking-tight mb-6">
                Detail Profil
            </h2>

            <div class="flex flex-col items-center mb-6">
                <div class="relative">
                    <?php if ($foto): ?>
                        <!-- Foto user aman -->
                        <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                            class="w-24 h-24 rounded-full border-4 <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?> object-cover shadow-xl"
                            alt="Foto Profil">
                    <?php else: ?>
                        <!-- Placeholder inisial user aman -->
                        <div class="w-24 h-24 rounded-full flex items-center justify-center text-white 
                                    text-3xl font-extrabold shadow-xl
                                    <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?> border-4 <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>">
                            <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <p class="mt-4 text-gray-800 font-bold text-xl tracking-wide truncate">
                    <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?>
                </p>
                <p class="text-indigo-600 font-semibold text-sm">
                    <?= htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?>
                </p>
            </div>

            <div class="space-y-3 border-t border-gray-200 pt-4">
                <?php
                $profile_data = [
                    'Email'   => $email,
                    'Jurusan' => $jurusan,
                    'Role'    => $role,
                ];
                ?>

                <?php foreach ($profile_data as $label => $value): ?>
                    <div class="flex justify-between items-center p-3 rounded-xl shadow-md bg-white/50"> 
                        <!-- Label aman -->
                        <span class="text-sm font-semibold text-gray-600"><?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>:</span>
                        <!-- Value aman -->
                        <span class="text-sm font-medium text-gray-800 truncate"><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pt-4 space-y-3">
                <!-- Tombol Edit Profil -->
                <button type="button" onclick="toggleView('edit')"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold text-base
                        shadow-lg shadow-indigo-500/50 transition-colors duration-200 
                        active:scale-[0.98] focus:ring-4 focus:ring-indigo-300">
                    <!-- Icon Font Awesome -->
                    <i class="fas fa-pen h-4 w-4 inline mr-2"></i>
                    Edit Profil
                </button>

                <!-- Link Kembali -->
                <a href="../pengaturan.php"
                class="block w-full text-center bg-white/70 hover:bg-white text-gray-700 py-2.5 rounded-xl 
                        font-semibold shadow-md transition-colors duration-200 
                        active:scale-95 focus:ring-4 focus:ring-gray-300">
                    ← Kembali
                </a>
            </div>
        </div>

        <div id="editFormContainer" class="space-y-6 hidden w-full">
            <h2 class="text-2xl font-extrabold text-center text-indigo-700 tracking-tight mb-6">
                Perbarui Akun
            </h2>

            <form action="update_profil.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <div>
                    <!-- Nama Lengkap -->
                    <label class="block font-semibold text-gray-700 mb-1 text-sm">Nama Lengkap</label>
                    <input type="text" name="nama"
                        value="<?= htmlspecialchars($user['nama'], ENT_QUOTES, 'UTF-8'); ?>"
                        placeholder="Masukkan Nama Lengkap Anda"
                        class="w-full p-2.5 rounded-xl border border-gray-300 bg-white/70 text-sm
                                focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none 
                                shadow-sm hover:border-indigo-300">
                </div>

                <div>
                    <!-- Email (tidak bisa diubah) -->
                    <label class="block font-semibold text-gray-700 mb-1 text-sm">Email (Tidak dapat diubah)</label>
                    <input type="text"
                        value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>"
                        disabled
                        class="w-full p-2.5 rounded-xl bg-gray-200/50 border border-gray-300 cursor-not-allowed text-gray-500 text-sm shadow-inner">
                    <input type="hidden" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div>
                    <!-- Upload Foto Profil -->
                    <label class="block font-semibold text-gray-700 mb-1 text-sm">Ganti Foto Profil (JPG/PNG - Max 2MB)</label>
                    <input type="file" name="foto_profil"
                        class="w-full p-2 rounded-xl border border-gray-300 bg-white/70 shadow-sm text-sm
                                file:mr-3 file:py-1.5 file:px-3
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100 
                                focus:ring-2 focus:ring-indigo-400 focus:outline-none">
                    <?php if ($foto): ?>
                        <p class="text-xs text-gray-500 mt-1">Saat ini: <span class="font-medium text-indigo-500">Foto Tersimpan</span></p>
                    <?php endif; ?>
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold text-base
                            shadow-xl shadow-indigo-500/50 transition-colors duration-200 
                            active:scale-[0.98] active:shadow-md mt-6 focus:ring-4 focus:ring-indigo-300">
                    Simpan Perubahan
                </button>

                <button type="button" onclick="toggleView('view')"
                    class="block w-full text-center bg-gray-400 hover:bg-gray-500 text-white py-2.5 rounded-xl 
                            font-semibold shadow-md transition-colors duration-200 
                            active:scale-95 focus:ring-4 focus:ring-gray-300">
                    Batal
                </button>
            </form>
        </div>
    </div>

    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../../private/nav-bottom.php';?>

    <script>
        function toggleView(mode) {
            const viewContainer = document.getElementById('viewProfileContainer');
            const editContainer = document.getElementById('editFormContainer');

            if (mode === 'edit') {
                // Tampilkan Edit, Sembunyikan View (instan)
                viewContainer.classList.add('hidden');
                editContainer.classList.remove('hidden');
            } else {
                // Tampilkan View, Sembunyikan Edit (instan)
                editContainer.classList.add('hidden');
                viewContainer.classList.remove('hidden');
            }
        }

        // Panggil toggleView pada load jika ada pesan sukses (kembali dari update_profil.php)
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            
            // Cek jika ada parameter 'success' di URL
            if (urlParams.get('success')) {
                // Pastikan kita berada di tampilan 'view' setelah sukses
                toggleView('view'); 
            } else {
                // Defaultnya adalah tampilan 'view'
                toggleView('view');
            }
        });
    </script>

</body>
</html>
