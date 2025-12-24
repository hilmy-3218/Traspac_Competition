<?php
include __DIR__ . '/../../../private/dasar_materi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Materi Pembelajaran</title>
    <link rel="shortcut icon" href="../../../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Tambahkan Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../../../assets/css/materi_dasar.css">
</head>
<body class="bg-gray-100">
    <!-- Background Gradient Effects -->
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

    <!-- Mobile Navigation (Top Bar) -->
    <nav class="md:hidden sticky top-0 z-50 bg-white shadow-lg p-4 flex justify-between items-center border-b glass-effect">
        <h1 class="text-xl font-bold text-indigo-700">e-Learning</h1>
        <button id="hamburger-menu" class="text-gray-700 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </nav>

    <div id="sidebar-overlay" class="overlay md:hidden"></div>
    
    <div class="flex flex-col md:flex-row h-screen">

        <!-- Sidebar - Menggunakan Glass Effect dan Navigasi Materi -->
       <aside id="sidebar" class="fixed inset-y-0 left-0 w-64 p-6 pb-24 md:pb-6 shadow-xl border-r z-50 ransform -translate-x-full md:translate-x-0 transition-transform duration-300
            md:static md:w-64 glass-effect overflow-y-auto">
            
            <h2 class="text-xl font-bold mb-6 text-indigo-700 text-center">e-Learning</h2>

            <!-- Info Pengguna Singkat -->
            <div class="flex flex-col items-center mb-6 border-b pb-4">
                <?php if ($foto): ?>
                    <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8') ?>" 
                        alt="Foto Profil" 
                        class="w-16 h-16 rounded-full object-cover border-4 <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8') ?>">
                <?php else: ?>
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-white text-2xl font-bold border-4 <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8') ?>
                    </div>
                <?php endif; ?>
                <p class="mt-2 text-md font-semibold text-gray-800 text-center">
                    <i class="fas fa-user mr-1"></i> <?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?>
                </p>
                <p class="text-sm text-gray-600">
                    <i class="fas fa-graduation-cap mr-1"></i> Jurusan: <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>

            <!-- Daftar Materi sebagai Navigasi -->
            <h3 class="text-lg font-bold mb-4 text-gray-700">📚 Daftar Materi</h3>
            <nav class="space-y-2">
                <?php 
                    // Materi list tetap lengkap untuk penamaan internal dan content area
                    $materi_list = [
                        1 => "Pengenalan Komputer", 
                        2 => "Dasar Dasar jaringan Komputer", 
                        3 => "Konfigurasi Jaringan Dasar", 
                        4 => "Sistem Operasi Jaringan Dasar", 
                        5 => "Keselamatan dan Kesehatan Kerja"
                    ];
                ?>
                <?php foreach ($materi_list as $id => $judul): ?>
                    <a href="?mode=materi&materi_id=<?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>" 
                    class="nav-link <?= $materi_id_aktif === $id ? 'active' : '' ?>">
                    
                        <i class="fas fa-book-open mr-2"></i> 
                        Materi <?= htmlspecialchars($id, ENT_QUOTES, 'UTF-8') ?>
                    </a>
                <?php endforeach; ?>
            </nav>
            
            <hr class="my-6">
            
            <!-- Link Logout - Ditempatkan di bagian bawah sidebar -->
            <a href="../../materi.php" class="block w-full text-center py-2 px-4 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition duration-200">
                Kembali
            </a>
        </aside>

        <main class="flex-1 p-4 md:p-8 overflow-y-auto">
            
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 mt-4 md:mt-0">
                <?= $mode === 'materi' ? '📖 Halaman Materi Pembelajaran' : '📝 Halaman Tugas' ?>
            </h1>

            <!-- Area Materi (Tampilan Materi) -->
            <div id="materi-area" class="min-h-[400px] <?= $mode === 'tugas' ? 'hidden' : '' ?>">

                <!-- Konten Materi 1 -->
                <div id="materi-1" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 1) ? '' : 'hidden' ?>">
                    <h2 class="text-2xl font-bold text-indigo-700 mb-4">Materi 1: Pengenalan Komputer</h2>
                    <h3 class="text-2xl font-bold text-blue-700 mb-4">
                        Pengertian dan Fungsi Komputer
                    </h3>
                    <p class="text-gray-700 mb-4">
                        Komputer (dari bahasa Inggris <i>to compute</i>, yang berarti menghitung) adalah sebuah perangkat elektronik serbaguna yang dirancang untuk menerima data mentah (input), memprosesnya berdasarkan serangkaian instruksi (process), dan menghasilkan hasil yang bermakna (output), yang kemudian dapat disimpan (storage) untuk penggunaan di masa mendatang.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Fungsi utama komputer mencakup:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4">
                        <li>
                            <span class="font-semibold">Pengolahan Data (Processing):</span>
                            Melakukan perhitungan, perbandingan logis, dan manipulasi data. Central Processing Unit (CPU) adalah inti dari fungsi ini.
                        </li>
                        <li>
                            <span class="font-semibold">Penyimpanan Data (Storage):</span>
                            Menyimpan data dan program, baik sementara (RAM) maupun permanen (HDD/SSD).
                        </li>
                        <li>
                            <span class="font-semibold">Pemindahan Data (Moving):</span>
                            Mengirimkan data dari satu komponen ke komponen lain, atau dari komputer ke perangkat eksternal.
                        </li>
                        <li>
                            <span class="font-semibold">Pengendalian (Controlling):</span>
                            Mengatur dan mengelola semua komponen lain dalam sistem komputer.
                        </li>
                    </ul>
                    <p class="text-gray-700 mt-4">
                        Secara sederhana, komputer mengubah data (fakta mentah) menjadi informasi (data yang telah diolah dan memiliki makna) yang berguna bagi pengguna.
                    </p>
                    <!--  -->
                    <h3 class="text-2xl font-bold text-blue-700 mb-4">
                        Jenis-Jenis Komputer Berdasarkan Skala dan Fungsi
                    </h3>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        1. Komputer Pribadi (Personal Computer / PC)
                    </h4>
                    <p class="text-gray-700 mb-4">
                        Komputer pribadi dirancang untuk penggunaan oleh satu orang pada satu waktu. Mereka adalah jenis komputer yang paling umum dan dikenal masyarakat.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Tujuan:</span>
                        Untuk komputasi umum seperti browsing internet, pengolahan kata, gaming, dan multimedia.
                    </p>
                    <p class="text-gray-700 font-semibold mb-2">Varian:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4">
                        <li>
                            <span class="font-semibold">Desktop:</span>
                            Komputer stasioner dengan komponen terpisah (CPU case, monitor, keyboard). Menawarkan kinerja tinggi dan kemudahan upgrade.
                        </li>
                        <li>
                            <span class="font-semibold">Laptop/Notebook:</span>
                            Komputer portabel yang mengintegrasikan CPU, monitor, keyboard, dan baterai dalam satu unit ringkas.
                        </li>
                        <li>
                            <span class="font-semibold">Tablet:</span>
                            Komputer touchscreen nirkabel yang sangat portabel, seringkali tanpa keyboard fisik.
                        </li>
                        <li>
                            <span class="font-semibold">Smartphone:</span>
                            Meskipun sering dianggap sebagai perangkat komunikasi, smartphone modern adalah PC saku yang sangat canggih.
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mt-6 mb-2">
                        2. Server
                    </h4>
                    <div class="w-full flex justify-center pb-6">
                        <img 
                            src="../../../assets/images/server.webp" 
                            alt="Motherboard"
                            class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                        />
                    </div>
                    <p class="text-gray-700 mb-4">
                        Server adalah komputer berkinerja tinggi yang didedikasikan untuk mengelola sumber daya jaringan dan menyediakan layanan kepada komputer lain (klien) dalam jaringan.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Tujuan:</span>
                        Menyimpan data, mengelola website, menjalankan aplikasi bisnis, memproses email, dan mengontrol akses pengguna.
                    </p>
                    <p class="text-gray-700 font-semibold mb-2">Karakteristik:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4">
                        <li>Dirancang untuk beroperasi 24/7 (24 jam sehari, 7 hari seminggu).</li>
                        <li>Memiliki memori (RAM) dan penyimpanan besar.</li>
                        <li>Memiliki kemampuan redundancy (cadangan) untuk menjaga ketersediaan.</li>
                    </ul>
                    <p class="text-gray-700 font-semibold mt-4 mb-2">Contoh Fungsi:</p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4">
                        <li>Web Server (menyimpan halaman web)</li>
                        <li>Database Server (menyimpan basis data)</li>
                        <li>File Server (menyimpan file bersama)</li>
                    </ul>
                    <!--  -->
                    <h3 class="text-2xl font-bold text-blue-700 mb-4">
                        Komponen Utama Sistem Komputer (Hardware)
                    </h3>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        I. Komponen Pemrosesan Inti
                    </h4>
                    <p class="text-gray-700 mb-4">
                        Ini adalah komponen yang esensial untuk menjalankan instruksi dan mengelola daya sistem.
                    </p>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        1. CPU (Central Processing Unit) / Prosesor
                    </h5>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Sering disebut sebagai “otak” komputer. Bertanggung jawab untuk mengeksekusi instruksi program, melakukan perhitungan aritmatika dan logika, serta mengontrol operasi input/output.
                        </li>
                        <li>
                            <span class="font-semibold">Karakteristik Kunci:</span>
                            Kinerja diukur dalam GHz (Gigahertz) dan jumlah Core.
                        </li>
                        <li>
                            <span class="font-semibold">Lokasi:</span>
                            Diletakkan di socket khusus pada motherboard.
                        </li>
                    </ul>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        2. Motherboard (Papan Induk)
                    </h5>
                    <div class="w-full flex justify-center pb-6">
                        <img 
                            src="../../../assets/images/motherboard.webp" 
                            alt="Motherboard"
                            class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                        />
                    </div>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Papan sirkuit utama yang menjadi tulang punggung sistem, menghubungkan CPU, RAM, kartu grafis, dan komponen lainnya.
                        </li>
                        <li>
                            <span class="font-semibold">Karakteristik Kunci:</span>
                            Menyediakan jalur komunikasi (Bus) serta port dan slot untuk koneksi antar komponen.
                        </li>
                    </ul>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        3. PSU (Power Supply Unit)
                    </h5>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-6">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Mengubah arus listrik AC menjadi DC dengan voltase stabil untuk komponen komputer.
                        </li>
                        <li>
                            <span class="font-semibold">Penting:</span>
                            Kestabilan PSU sangat mempengaruhi umur dan kinerja komponen.
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        II. Komponen Penyimpanan dan Grafis
                    </h4>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        4. RAM (Random Access Memory)
                    </h5>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Memori kerja sementara untuk menyimpan data program yang sedang berjalan.
                        </li>
                        <li>
                            <span class="font-semibold">Karakteristik Kunci:</span>
                            Bersifat volatil dan kapasitas memengaruhi multitasking.
                        </li>
                    </ul>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        5. HDD/SSD (Hard Disk Drive / Solid State Drive)
                    </h5>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Media penyimpanan permanen untuk OS, software, dan file pengguna.
                        </li>
                        <li>
                            <span class="font-semibold">Perbedaan:</span>
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li><span class="font-semibold">HDD:</span> Menggunakan piringan magnetik, lebih lambat, rentan guncangan.</li>
                                <li><span class="font-semibold">SSD:</span> Menggunakan chip memori flash, lebih cepat dan tahan guncangan.</li>
                            </ul>
                        </li>
                    </ul>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        6. VGA (Video Graphics Array) / GPU (Graphics Processing Unit)
                    </h5>
                    <div class="w-full flex justify-center pb-6">
                        <img 
                            src="../../../assets/images/gpu.webp" 
                            alt="Motherboard"
                            class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                        />
                    </div>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-6">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Memproses data grafis dan menampilkannya ke monitor.
                        </li>
                        <li>
                            <span class="font-semibold">Penting:</span>
                            GPU khusus diperlukan untuk gaming, rendering, dan AI.
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        III. Komponen Periferal (Input/Output)
                    </h4>
                    <p class="text-gray-700 mb-4">
                        Ini adalah perangkat yang memungkinkan interaksi antara pengguna dan komputer.
                    </p>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        7. Monitor (Perangkat Output)
                    </h5>
                    <p class="text-gray-600 mb-4">
                        <span class="font-semibold">Fungsi:</span>
                        Menampilkan informasi visual hasil pemrosesan komputer.
                    </p>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        8. Keyboard (Perangkat Input)
                    </h5>
                    <p class="text-gray-600 mb-4">
                        <span class="font-semibold">Fungsi:</span>
                        Alat utama untuk memasukkan karakter dan perintah teks.
                    </p>
                    <h5 class="text-lg font-semibold text-blue-500 mb-2">
                        9. Mouse (Perangkat Input)
                    </h5>
                    <p class="text-gray-600 mb-4">
                        <span class="font-semibold">Fungsi:</span>
                        Perangkat penunjuk untuk menggerakkan kursor dan berinteraksi dengan antarmuka grafis (GUI).
                    </p>
                    <!--  -->
                    <h3 class="text-2xl font-bold text-blue-700 mb-4">
                        Perbedaan Hardware, Software, dan Brainware
                    </h3>
                    <p class="text-gray-700 mb-4">
                        Sistem komputer tidak dapat beroperasi hanya dengan satu komponen; ia memerlukan interaksi dan kerja sama dari ketiga elemen ini:
                    </p>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        1. Hardware (Perangkat Keras) 🧱
                    </h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Definisi:</span>
                            Hardware adalah semua komponen fisik dan elektronik komputer yang dapat disentuh dan dilihat secara nyata.
                        </li>
                        <li>
                            <span class="font-semibold">Sifat:</span>
                            Berwujud (Tangible) dan membutuhkan energi listrik.
                        </li>
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Melaksanakan tugas pemrosesan, input, output, serta penyimpanan data.
                        </li>
                        <li>
                            <span class="font-semibold">Contoh:</span>
                            CPU, RAM, Motherboard, Monitor, Keyboard, Printer, Mouse.
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        2. Software (Perangkat Lunak) ⚙️
                    </h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Definisi:</span>
                            Sekumpulan instruksi dan data untuk mengoperasikan komputer dan menjalankan tugas tertentu.
                        </li>
                        <li>
                            <span class="font-semibold">Sifat:</span>
                            Tidak berwujud (Intangible), berupa instruksi digital.
                        </li>
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Memberi tahu hardware apa yang harus dilakukan, mengelola sumber daya, dan menyediakan antarmuka untuk brainware.
                        </li>
                        <li>
                            <span class="font-semibold">Jenis Utama:</span>
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li><span class="font-semibold">Sistem Operasi (OS):</span> Windows, macOS, Android.</li>
                                <li><span class="font-semibold">Perangkat Lunak Aplikasi:</span> Word, Photoshop, Chrome, game.</li>
                            </ul>
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        3. Brainware (Pengguna) 👤
                    </h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Definisi:</span>
                            Manusia yang mengoperasikan, mengelola, dan berinteraksi dengan sistem komputer.
                        </li>
                        <li>
                            <span class="font-semibold">Sifat:</span>
                            Elemen manusia/intelektual yang memberikan tujuan dan instruksi.
                        </li>
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Merancang sistem, menulis software, memasukkan data, serta menganalisis output.
                        </li>
                        <li>
                            <span class="font-semibold">Contoh:</span>
                            Pengguna akhir, programmer, administrator jaringan.
                        </li>
                    </ul>
                    <!--  -->
                    <h3 class="text-2xl font-bold text-blue-700 mb-4">
                        Cara Kerja Komputer: Siklus Pemrosesan Informasi
                    </h3>
                    <p class="text-gray-700 mb-4">
                        Cara kerja komputer diatur dalam sebuah siklus yang berkelanjutan dan berulang, yang memastikan data mentah diubah menjadi informasi yang berguna. Siklus ini dikenal sebagai <span class="font-semibold">Siklus Pemrosesan Informasi</span> dan terdiri dari empat tahapan utama:
                    </p>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        1. Input (Masukan) 📥
                    </h4>
                    <p class="text-gray-700 mb-2">
                        Tahap awal di mana data mentah dan instruksi dimasukkan ke dalam sistem komputer.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Mengubah data atau instruksi dari manusia menjadi sinyal digital (kode biner 0 dan 1) yang dapat diproses komputer.
                        </li>
                        <li>
                            <span class="font-semibold">Perangkat Input:</span>
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li>Keyboard – Memasukkan karakter dan perintah.</li>
                                <li>Mouse – Memasukkan perintah klik dan navigasi.</li>
                                <li>Scanner – Memasukkan gambar atau teks dari dokumen fisik.</li>
                                <li>Mikrofon – Memasukkan data suara.</li>
                            </ul>
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        2. Process (Pemrosesan) 🧠
                    </h4>
                    <p class="text-gray-700 mb-2">
                        Setelah data diterima, tahap pemrosesan dilakukan untuk menghitung, membandingkan, dan memanipulasi data sesuai instruksi.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Mengolah data berdasarkan instruksi perangkat lunak.
                        </li>
                        <li>
                            <span class="font-semibold">Komponen Inti:</span>
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li>CPU – Melaksanakan instruksi utama.</li>
                                <li>RAM – Menyimpan data sementara selama pemrosesan.</li>
                            </ul>
                        </li>
                        <li>
                            <span class="font-semibold">Proses:</span>
                            CPU mengambil instruksi dari RAM → mengeksekusi → menyimpan hasil sementara kembali ke RAM.
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        3. Output (Keluaran) 📢
                    </h4>
                    <p class="text-gray-700 mb-2">
                        Tahap di mana hasil pemrosesan diubah menjadi bentuk yang dapat dipahami pengguna.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Menampilkan informasi hasil pemrosesan.
                        </li>
                        <li>
                            <span class="font-semibold">Perangkat Output:</span>
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li>Monitor – Menampilkan grafis dan teks.</li>
                                <li>Speaker/Headphone – Menghasilkan suara.</li>
                                <li>Printer – Menghasilkan salinan fisik (hard copy).</li>
                            </ul>
                        </li>
                        <li>
                            <span class="font-semibold">Hasil:</span>
                            Informasi seperti dokumen, perhitungan, atau gambar yang telah diproses.
                        </li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        4. Storage (Penyimpanan) 💾
                    </h4>
                    <p class="text-gray-700 mb-2">
                        Tahap yang menyimpan data dan informasi secara permanen untuk penggunaan di masa mendatang.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Fungsi:</span>
                            Menyimpan data secara permanen agar dapat diakses kembali setelah komputer dimatikan.
                        </li>
                        <li>
                            <span class="font-semibold">Perangkat Storage:</span>
                            <ul class="list-disc list-inside ml-5 space-y-1">
                                <li>HDD/SSD – Media penyimpanan internal utama.</li>
                                <li>Flash Drive, Cloud Storage – Media eksternal atau jarak jauh.</li>
                            </ul>
                        </li>
                        <li>
                            <span class="font-semibold">Penting:</span>
                            Sistem operasi dan aplikasi disimpan di media penyimpanan dan dimuat ke RAM saat komputer dinyalakan.
                        </li>
                    </ul>
                    <!-- REFERENSI VIDEO MATERI 1 TKJ -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="fas fa-video"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Referensi Video Pembelajaran
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Video berikut digunakan sebagai pendukung <b>Materi 1 TKJ – Pengenalan Komputer Dasar</b>
                            agar siswa lebih mudah memahami materi secara visual.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/XcYWilx8Wsk"
                                title="Belajar Komputer dari Nol"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/XcYWilx8Wsk"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                Tonton langsung di YouTube
                            </a>
                        </div>
                    </section>

                    <div class="mt-6 pt-4 border-t border-gray-200 text-right">
                        <a href="?mode=tugas&materi_id=1" class="inline-block px-6 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-200">
                            Kerjakan Tugas Materi 1
                        </a>
                    </div>
                </div>

                <!-- Konten Materi 2 -->
                <div id="materi-2" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 2) ? '' : 'hidden' ?>">
                    <h2 class="text-2xl font-bold text-indigo-700 mb-4">Materi 2: Struktur Data dan Algoritma</h2>
                    <h3 class="text-xl font-bold text-blue-700 mb-4">
                        Pengertian Jaringan Komputer
                    </h3>
                    <p class="text-gray-700 mb-4">
                        Jaringan Komputer adalah sebuah sistem yang terdiri dari dua atau lebih perangkat komputasi (seperti komputer, server, smartphone, atau printer) yang saling terhubung satu sama lain. Koneksi ini dapat terjalin melalui media transmisi berkabel (seperti kabel UTP atau Fiber Optic) maupun nirkabel (wireless seperti Wi-Fi atau Bluetooth).
                    </p>
                    <p class="text-gray-700 mb-4">
                        Tujuan utama dari jaringan komputer adalah untuk memungkinkan perangkat-perangkat tersebut berkomunikasi, berbagi data, dan berbagi sumber daya secara efisien dan aman. Mereka diatur oleh seperangkat aturan komunikasi yang disebut protokol.
                    </p>
                    <h4 class="text-xl font-semibold text-blue-600 mb-3">
                        ✅ Manfaat Jaringan Komputer
                    </h4>
                    <p class="text-gray-700 mb-4">
                        Jaringan komputer menawarkan berbagai manfaat yang sangat penting dalam lingkungan rumah tangga, bisnis, hingga skala global:
                    </p>
                    <h4 class="text-lg font-semibold text-blue-500 mb-2">
                        1. Berbagi Sumber Daya (Resource Sharing)
                    </h4>
                    <p class="text-gray-700 mb-2">
                        Ini adalah salah satu manfaat paling mendasar dan penting dari jaringan komputer.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Berbagi Perangkat Keras (Hardware):</span>
                            Beberapa pengguna dapat menggunakan satu perangkat keras secara bersamaan, misalnya satu printer atau scanner yang terhubung ke jaringan (network printer), sehingga menghemat biaya.
                        </li>
                        <li>
                            <span class="font-semibold">Berbagi Akses Internet:</span>
                            Semua perangkat dalam jaringan dapat menggunakan satu koneksi internet yang sama melalui router.
                        </li>
                    </ul>
                    <h4 class="text-lg font-semibold text-blue-500 mb-2">
                        2. Komunikasi dan Kolaborasi yang Efisien
                    </h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>
                            <span class="font-semibold">Media Komunikasi:</span>
                            Memungkinkan penggunaan email, chatting, panggilan suara (VoIP), dan video conference secara cepat dan real-time.
                        </li>
                        <li>
                            <span class="font-semibold">Kolaborasi:</span>
                            Tim kerja dapat mengerjakan proyek yang sama secara simultan, berbagi dokumen, dan mengakses informasi terbaru dari mana pun.
                        </li>
                    </ul>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">
                        Jenis-Jenis Jaringan Komputer Berdasarkan Cakupan Geografis
                    </h3>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        1. LAN (Local Area Network)
                    </h4>
                    <p class="text-gray-700 mb-2">
                        LAN adalah jenis jaringan komputer yang memiliki cakupan geografis paling kecil.
                    </p>
                    <div class="w-full flex justify-center pb-6">
                        <img 
                            src="../../../assets/images/lan.webp" 
                            alt="lan"
                            class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                        />
                    </div>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Definisi:</span>
                        Sebuah jaringan yang menghubungkan perangkat dalam area fisik yang terbatas, seperti kantor tunggal, rumah, gedung sekolah, atau kelompok beberapa bangunan yang berdekatan.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Cakupan:</span>
                        Lokal (beberapa meter hingga beberapa kilometer).
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Kecepatan Tinggi:</span> Menawarkan kecepatan transfer data yang sangat tinggi karena jarak yang pendek.</li>
                        <li><span class="font-semibold">Biaya Rendah:</span> Biaya instalasi relatif lebih murah.</li>
                        <li><span class="font-semibold">Kepemilikan Pribadi:</span> Biasanya dimiliki, dikelola, dan dikontrol oleh satu organisasi atau individu.</li>
                        <li><span class="font-semibold">Contoh:</span> Jaringan Wi-Fi di rumah, atau jaringan komputer dalam satu gedung perkantoran.</li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        2. MAN (Metropolitan Area Network)
                    </h4>
                    <p class="text-gray-700 mb-2">
                        MAN adalah jaringan yang cakupannya lebih besar daripada LAN tetapi lebih kecil dari WAN.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Definisi:</span>
                        Jaringan yang menghubungkan LAN yang tersebar di wilayah geografis yang lebih luas, seperti kota atau kampus besar.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Cakupan:</span>
                        Metropolitan (sekitar 5 hingga 50 kilometer).
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Kecepatan Menengah:</span> Kecepatan transfer data cenderung sedang.</li>
                        <li><span class="font-semibold">Kompleksitas:</span> Lebih kompleks daripada LAN dan sering menggunakan media transmisi berkecepatan tinggi seperti kabel serat optik.</li>
                        <li><span class="font-semibold">Kepemilikan:</span> Dapat dimiliki oleh entitas tunggal seperti universitas besar, ISP, atau pemerintah kota.</li>
                        <li><span class="font-semibold">Contoh:</span> Jaringan yang menghubungkan cabang-cabang bank dalam satu kota.</li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        3. WAN (Wide Area Network)
                    </h4>
                    <p class="text-gray-700 mb-2">
                        WAN adalah jaringan dengan cakupan geografis terluas.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Definisi:</span>
                        Jaringan yang membentang di area yang sangat luas, seperti antar kota, antar negara bagian, atau bahkan antar benua. WAN menghubungkan LAN dan MAN yang berbeda.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Cakupan:</span>
                        Luas (dari puluhan hingga ribuan kilometer).
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Kecepatan Rendah hingga Menengah:</span> Kecepatan dapat bervariasi karena melibatkan banyak teknologi dan infrastruktur pihak ketiga.</li>
                        <li><span class="font-semibold">Media Transmisi:</span> Menggunakan saluran komunikasi publik dan privat seperti jalur telepon, satelit, dan kabel serat optik bawah laut.</li>
                        <li><span class="font-semibold">Contoh Utama:</span> Internet adalah WAN terbesar di dunia.</li>
                        <li><span class="font-semibold">Contoh:</span> Jaringan kantor pusat perusahaan multinasional yang terhubung ke kantor cabang di seluruh dunia.</li>
                    </ul>
                    <h3 class="text-2xl font-bold text-blue-700 mb-4">
                        Jenis-Jenis Jaringan Komputer Berdasarkan Cakupan Geografis
                    </h3>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        1. LAN (Local Area Network)
                    </h4>
                    <p class="text-gray-700 mb-2">
                        LAN adalah jenis jaringan komputer yang memiliki cakupan geografis paling kecil.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Definisi:</span>
                        Sebuah jaringan yang menghubungkan perangkat dalam area fisik yang terbatas, seperti kantor tunggal, rumah, gedung sekolah, atau kelompok beberapa bangunan yang berdekatan.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Cakupan:</span>
                        Lokal (beberapa meter hingga beberapa kilometer).
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Kecepatan Tinggi:</span> Menawarkan kecepatan transfer data yang sangat tinggi karena jarak yang pendek.</li>
                        <li><span class="font-semibold">Biaya Rendah:</span> Biaya instalasi relatif lebih murah.</li>
                        <li><span class="font-semibold">Kepemilikan Pribadi:</span> Biasanya dimiliki, dikelola, dan dikontrol oleh satu organisasi atau individu.</li>
                        <li><span class="font-semibold">Contoh:</span> Jaringan Wi-Fi di rumah, atau jaringan komputer dalam satu gedung perkantoran.</li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        2. MAN (Metropolitan Area Network)
                    </h4>
                    <p class="text-gray-700 mb-2">
                        MAN adalah jaringan yang cakupannya lebih besar daripada LAN tetapi lebih kecil dari WAN.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Definisi:</span>
                        Jaringan yang menghubungkan LAN yang tersebar di wilayah geografis yang lebih luas, seperti kota atau kampus besar.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Cakupan:</span>
                        Metropolitan (sekitar 5 hingga 50 kilometer).
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Kecepatan Menengah:</span> Kecepatan transfer data cenderung sedang.</li>
                        <li><span class="font-semibold">Kompleksitas:</span> Lebih kompleks daripada LAN dan sering menggunakan media transmisi berkecepatan tinggi seperti kabel serat optik.</li>
                        <li><span class="font-semibold">Kepemilikan:</span> Dapat dimiliki oleh entitas tunggal seperti universitas besar, ISP, atau pemerintah kota.</li>
                        <li><span class="font-semibold">Contoh:</span> Jaringan yang menghubungkan cabang-cabang bank dalam satu kota.</li>
                    </ul>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">
                        3. WAN (Wide Area Network)
                    </h4>
                    <p class="text-gray-700 mb-2">
                        WAN adalah jaringan dengan cakupan geografis terluas.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Definisi:</span>
                        Jaringan yang membentang di area yang sangat luas, seperti antar kota, antar negara bagian, atau bahkan antar benua. WAN menghubungkan LAN dan MAN yang berbeda.
                    </p>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Cakupan:</span>
                        Luas (dari puluhan hingga ribuan kilometer).
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Kecepatan Rendah hingga Menengah:</span> Kecepatan dapat bervariasi karena melibatkan banyak teknologi dan infrastruktur pihak ketiga.</li>
                        <li><span class="font-semibold">Media Transmisi:</span> Menggunakan saluran komunikasi publik dan privat seperti jalur telepon, satelit, dan kabel serat optik bawah laut.</li>
                        <li><span class="font-semibold">Contoh Utama:</span> Internet adalah WAN terbesar di dunia.</li>
                        <li><span class="font-semibold">Contoh:</span> Jaringan kantor pusat perusahaan multinasional yang terhubung ke kantor cabang di seluruh dunia.</li>
                    </ul>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Pengertian Topologi Jaringan</h3>
                    <p class="text-gray-700 mb-2">
                        Topologi Jaringan adalah tata letak (layout) fisik maupun logis dari perangkat-perangkat yang terhubung dalam suatu jaringan komputer. 
                        Istilah ini menjelaskan bagaimana setiap perangkat (node) seperti komputer, server, dan printer saling berhubungan untuk membentuk sistem 
                        komunikasi data yang teratur.
                    </p>
                    <p class="text-gray-700 mb-2">
                        Ada dua jenis utama topologi jaringan:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Topologi Fisik (Physical Topology):</span> Menggambarkan bagaimana perangkat dan kabel benar-benar terhubung secara fisik.</li>
                        <li><span class="font-semibold">Topologi Logis (Logical Topology):</span> Menggambarkan bagaimana data bergerak di dalam jaringan tanpa memandang tata letak fisik.</li>
                    </ul>
                    <p class="text-gray-700 mb-2">
                        Pemilihan topologi yang tepat berpengaruh besar terhadap kecepatan, keandalan, biaya instalasi, dan kemudahan pemeliharaan jaringan.
                    </p>
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Jenis-Jenis Topologi Jaringan</h3>
                    <!-- Topologi Star -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. Topologi Star (Bintang) ⭐</h4>
                        <p class="text-gray-700 mb-2">
                            Semua perangkat terhubung ke satu titik pusat, biasanya berupa Hub atau Switch. Setiap komunikasi antar perangkat harus 
                            melewati titik pusat ini.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/star.webp" 
                                alt="star"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Keunggulan:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Kerusakan satu kabel tidak memengaruhi seluruh jaringan.</li>
                            <li>Mudah ditambah atau dikurangi perangkat.</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Kelemahan:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Jika perangkat pusat rusak, seluruh jaringan akan terputus.</li>
                        </ul>
                    </div>
                    <!-- Topologi Bus -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. Topologi Bus</h4>
                        <p class="text-gray-700 mb-2">
                            Semua perangkat terhubung pada satu kabel utama (Backbone) yang menjadi jalur komunikasi bersama. Kedua ujung kabel 
                            harus diberi Terminator.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/bus.webp" 
                                alt="bus"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Keunggulan:<span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Instalasi mudah dan hemat kabel.</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Kelemahan:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Jika backbone rusak, seluruh jaringan terganggu.</li>
                            <li>Sulit melacak kerusakan.</li>
                        </ul>
                    </div>
                    <!-- Topologi Ring -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">3. Topologi Ring (Cincin) 💍</h4>
                        <p class="text-gray-700 mb-2">
                            Setiap perangkat terhubung ke dua perangkat lain, membentuk lingkaran tertutup. Data mengalir searah seperti estafet.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/ring.webp" 
                                alt="ring"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Keunggulan:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Aliran data stabil dan tidak mudah terjadi tabrakan data.</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Kelemahan:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Jika satu perangkat rusak, seluruh jaringan bisa terputus.</li>
                            <li>Menambah perangkat baru cukup sulit.</li>
                        </ul>
                    </div>
                    <!-- Topologi Mesh -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">4. Topologi Mesh (Jala)</h4>
                        <p class="text-gray-700 mb-2">
                            Setiap perangkat terhubung langsung ke semua perangkat lain di jaringan. Biasanya digunakan pada sistem yang membutuhkan keandalan tinggi.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/mesh.webp" 
                                alt="mesh"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Keunggulan:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Sangat andal karena banyak jalur alternatif.</li>
                            <li>Keamanan tinggi karena komunikasi langsung antar perangkat.</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Kelemahan:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Biaya instalasi sangat mahal karena membutuhkan banyak kabel.</li>
                            <li>Konfigurasi dan pemeliharaan cukup rumit.</li>
                        </ul>
                    </div>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Perangkat Jaringan Komputer Utama</h3>
                    <p class="text-gray-700 mb-2">
                        Dalam jaringan komputer, berbagai perangkat keras digunakan untuk menghubungkan, mengatur, dan mengelola aliran data antar komputer. 
                        Berikut adalah beberapa perangkat jaringan utama beserta fungsi dan cara kerjanya:
                    </p>
                    <!-- 1. Hub -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. Hub</h4>
                        <p class="text-gray-700 mb-2">
                            Hub adalah perangkat sentral dalam topologi Star yang memiliki fungsi paling dasar. Bertindak sebagai titik koneksi utama 
                            untuk beberapa perangkat dalam jaringan LAN.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi:</span></p>
                        <p class="text-gray-700 mb-2">Menerima data dari satu port lalu menyebarkannya ke semua port lain tanpa memeriksa alamat tujuan.</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Kerja:</span></p>
                        <p class="text-gray-700 mb-2">Hub bekerja pada Layer Fisik (Layer 1) model OSI dan tidak menentukan arah data, sehingga disebut perangkat "bodoh" (dumb device).</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Kekurangan:</span></p>
                        <p class="text-gray-700 mb-2">Menyebarkan sinyal ke semua perangkat, sehingga dapat menimbulkan tabrakan data dan memperlambat jaringan.</p>
                    </div>
                    <!-- 2. Switch -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. Switch</h4>
                        <p class="text-gray-700 mb-2">
                            Switch adalah perangkat lebih cerdas dan efisien dibanding Hub karena mampu mengatur lalu lintas data secara selektif dalam jaringan LAN.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/switch.webp" 
                                alt="switch"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi:</span></p>
                        <p class="text-gray-700 mb-2">Menghubungkan beberapa perangkat dalam LAN dan mengirimkan data hanya ke perangkat tujuan.</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Kerja:</span></p>
                        <p class="text-gray-700 mb-2">
                            Bekerja pada Layer Data-Link (Layer 2) model OSI dan menggunakan tabel MAC Address untuk mengenali perangkat pada tiap port.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Keunggulan:</span></p>
                        <p>Mengurangi lalu lintas tidak perlu, mencegah tabrakan data, dan meningkatkan kecepatan jaringan.</p>
                    </div>
                    <!-- 3. Router -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">3. Router</h4>
                        <p class="text-gray-700 mb-2">
                            Router adalah perangkat penting yang menghubungkan dua atau lebih jaringan berbeda, misalnya jaringan rumah dengan Internet.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi:</span></p>
                        <p class="text-gray-700 mb-2">Mengatur dan mengarahkan paket data antar jaringan (inter-network) menggunakan IP Address.</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Kerja:</span></p>
                        <p class="text-gray-700 mb-2">
                            Router beroperasi pada Layer Jaringan (Layer 3) model OSI. Ia membaca alamat IP tujuan dari paket data dan memilih rute terbaik menggunakan tabel routing.
                        </p>
                        <p class="text-gray-700 mb-2">Penerapan:</p>
                        <p>Digunakan untuk menghubungkan LAN ke WAN atau Internet.</p>
                    </div>
                    <!-- 4. Access Point -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">4. Access Point (AP)</h4>
                        <p class="text-gray-700 mb-2">
                            Access Point (AP) adalah perangkat yang menciptakan jaringan lokal nirkabel (WLAN) sehingga perangkat Wi-Fi dapat terhubung.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/ap.webp" 
                                alt="ap"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi:</span></p>
                        <p class="mb-2">Menghubungkan perangkat nirkabel seperti laptop dan smartphone ke jaringan berkabel (LAN).</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Kerja:</span></p>
                        <p>Umum digunakan di sekolah, kantor, kampus, dan area publik untuk memperluas jangkauan Wi-Fi.</p>
                    </div>
                    <!-- 5. Kabel Jaringan -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">5. Kabel Jaringan</h4>
                        <p class="text-gray-700 mb-2">
                            Kabel jaringan adalah media fisik yang digunakan untuk mentransmisikan data antar perangkat dalam jaringan.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi:</span></p>
                        <p class="text-gray-700 mb-2">Memberikan jalur komunikasi cepat dan stabil antar perangkat.</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Jenis Utama:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Twisted Pair (UTP/STP):</span> Kabel tembaga paling umum dalam LAN.</li>
                            <li><span class="font-semibold">Fiber Optic:</span> Menggunakan cahaya untuk transfer data berkecepatan tinggi dan jarak jauh. Banyak digunakan di backbone dan WAN.</li>
                        </ul>
                    </div>
                    <!-- 6. Konektor -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">6. Konektor</h4>
                        <p class="text-gray-700 mb-2">
                            Konektor adalah antarmuka fisik yang digunakan untuk menghubungkan kabel ke perangkat jaringan seperti switch atau router.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi:</span></p>
                        <p class="text-gray-700 mb-2">Menjamin koneksi listrik atau optik yang aman antara kabel dan port.</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Jenis Utama:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">RJ-45:</span> Konektor standar untuk kabel UTP/STP pada port Ethernet.</li>
                            <li><span class="font-semibold">SC / LC / ST:</span> Konektor untuk kabel Fiber Optic.</li>
                        </ul>
                    </div>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Media Transmisi</h3>
                    <p class="text-gray-700 mb-2">
                        Media Transmisi adalah saluran fisik atau nirkabel yang digunakan untuk membawa informasi (data) dari satu perangkat jaringan ke perangkat lainnya. 
                        Media ini menentukan kecepatan, keandalan, dan jangkauan transmisi data.
                    </p>
                    <!-- 1. Kabel UTP -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. Kabel UTP (Unshielded Twisted Pair)</h4>
                        <p class="text-gray-700 mb-2">
                            Kabel UTP adalah media transmisi berkabel yang paling umum digunakan dalam jaringan LAN.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/utp.webp" 
                                alt="utp"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2">Deskripsi:</p>
                        <p class="text-gray-700 mb-2">
                            Terdiri dari empat pasang kawat tembaga yang dipilin (twisted) untuk mengurangi gangguan elektromagnetik (crosstalk).
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Konektor:</span></p>
                        <p class="text-gray-700 mb-2">Menggunakan konektor standar RJ-45.</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik Utama:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Kecepatan:</span> Hingga 1 Gbps (Gigabit Ethernet), dan hingga 10 Gbps untuk kategori seperti Cat 6a/Cat 7.</li>
                            <li><span class="font-semibold">Jarak Maksimal:</span> 100 meter sebelum sinyal melemah (attenuation).</li>
                            <li><span class="font-semibold">Biaya:</span> Murah dan mudah dipasang.</li>
                            <li><span class="font-semibold">Kategori Kabel:</span> Cat 5e, Cat 6, Cat 6a — semakin tinggi kategori, semakin baik performanya.</li>
                        </ul>
                    </div>
                    <!-- 2. Fiber Optic -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. Fiber Optic (Serat Optik)</h4>
                        <p class="text-gray-700 mb-2">
                            Fiber Optic adalah media transmisi canggih yang menggunakan cahaya untuk membawa data, bukan sinyal listrik.
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/fo.webp" 
                                alt="fo"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Deskripsi:</span></p>
                        <p class="text-gray-700 mb-2">
                            Memiliki inti kaca/plastik tipis (core) yang dikelilingi cladding. Data dikirim dalam bentuk pulsa cahaya.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik Utama:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Kecepatan:</span> Dapat mencapai ratusan Gbps hingga Tbps.</li>
                            <li><span class="font-semibold">Jarak:</span> Mentransmisikan data hingga puluhan kilometer tanpa penguat sinyal.</li>
                            <li><span class="font-semibold">Kekebalan Noise:</span> Tidak terpengaruh interferensi elektromagnetik.</li>
                        </ul>
                        <p class="text-gray-700 mb-2">Jenis Utama:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Single-Mode:</span> Inti sangat tipis, menggunakan laser, cocok untuk jarak jauh.</li>
                            <li><span class="font-semibold">Multi-Mode:</span> Inti lebih besar, menggunakan LED, cocok untuk jarak pendek.</li>
                        </ul>
                        <p class="text-gray-700 mb-2">Penerapan:</p>
                        <p>Digunakan untuk backbone jaringan, koneksi antar gedung, dan infrastruktur ISP.</p>
                    </div>
                    <!-- 3. Wireless -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">📶 3. Wireless (Nirkabel)</h4>
                        <p class="text-gray-700 mb-2">
                            Wireless adalah media transmisi tanpa kabel yang menggunakan gelombang elektromagnetik untuk membawa data melalui udara.
                        </p>
                        <p class="text-gray-700 mb-2">Fungsi:</p>
                        <p class="mb-2">Menawarkan konektivitas dan mobilitas bagi perangkat dalam jangkauan sinyal.</p>
                        <p class="text-gray-700 mb-2">Karakteristik Utama:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Media:</span> Menggunakan gelombang radio, mikro, atau inframerah.</li>
                            <li><span class="font-semibold">Mobilitas:</span> Tinggi, dapat digunakan dari mana saja selama dalam jangkauan.</li>
                            <li><span class="font-semibold">Jangkauan:</span> Dipengaruhi kekuatan sinyal, standar Wi-Fi, dan hambatan fisik.</li>
                            <li><span class="font-semibold">Keamanan:</span> Lebih rentan penyadapan, perlu enkripsi seperti WPA3.</li>
                        </ul>
                        <p class="text-gray-700 mb-2">Teknologi Umum:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Wi-Fi:</span> Standar jaringan lokal nirkabel (WLAN).</li>
                            <li><span class="font-semibold">Bluetooth:</span> Untuk koneksi jarak pendek (PAN).</li>
                            <li><span class="font-semibold">Seluler (4G/5G):</span> Untuk jaringan nirkabel jarak jauh (WAN).</li>
                        </ul>
                    </div>
                    <!-- REFERENSI VIDEO MATERI 2 TKJ -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-100 text-green-600">
                                <i class="fas fa-network-wired"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran Materi 2 – Jaringan Komputer
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Video berikut digunakan sebagai pendukung <b>Materi 2 TKJ – Dasar Jaringan Komputer</b>,
                            agar siswa lebih mudah memahami konsep jaringan secara visual.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/BO-QBVB3Glc"
                                title="Belajar Dasar Jaringan Komputer dari Nol"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/BO-QBVB3Glc"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                Tonton langsung di YouTube
                            </a>
                        </div>
                    </section>

                    <div class="mt-6 pt-4 border-t border-gray-200 text-right">
                        <a href="?mode=tugas&materi_id=2" class="inline-block px-6 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-200">
                            Kerjakan Tugas Materi 2
                        </a>
                    </div>
                </div>
                
                <!-- Konten Materi 3 -->
                <div id="materi-3" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 3) ? '' : 'hidden' ?>">
                    <h2 class="text-2xl font-bold text-blue-700 mb-4">3. Konfigurasi Jaringan Dasar</h2>
                    <h3 class="text-xl font-bold text-blue-700 mb-4">IP Address (Internet Protocol Address)</h3>
                    <p class="text-gray-700 mb-2">
                        IP Address adalah alamat numerik unik yang diberikan kepada setiap perangkat (seperti komputer, router, atau server) 
                        yang terhubung ke jaringan komputer berbasis protokol Internet. Fungsi utamanya adalah sebagai identitas perangkat 
                        dan untuk menentukan lokasinya dalam jaringan sehingga data dapat dikirimkan ke tujuan yang tepat.
                    </p>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Struktur IP Address</h4>
                    <p class="text-gray-700 mb-2">Saat ini terdapat dua versi utama dari IP Address:</p>
                    <!-- IPv4 -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. IPv4 (Internet Protocol version 4)</h4>
                        <p class="text-gray-700 mb-2">
                            IPv4 adalah versi yang paling banyak digunakan. Memiliki panjang 32 bit dan ditulis dalam empat angka desimal 
                            yang dipisahkan oleh titik, disebut octet.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Contoh:</span></p>
                        <p class="text-gray-700 mb-2">192.168.1.10</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Terdiri dari 32 bit.</li>
                            <li>Setiap octet memiliki nilai 0 – 255.</li>
                        </ul>
                        <p class="text-gray-700 mb-2">Fungsi utamanya terbagi menjadi dua bagian:</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Network ID:</span> Bagian alamat yang menunjukkan jaringan tempat perangkat berada.</li>
                            <li><span class="font-semibold">Host ID:</span> Bagian alamat yang menunjukkan perangkat tertentu di dalam jaringan tersebut.</li>
                        </ul>
                    </div>
                    <!-- IPv6 -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. IPv6 (Internet Protocol version 6)</h4>
                        <p class="text-gray-700 mb-2">
                            IPv6 memiliki panjang 128 bit dan ditulis dalam format heksadesimal yang dipisahkan oleh titik dua. 
                            IPv6 diciptakan untuk menggantikan IPv4 karena jumlah alamat IPv4 hampir habis.
                        </p>
                    </div>
                    <!-- Subnet Mask -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">🎭 Subnet Mask</h3>
                    <p class="text-gray-700 mb-2">
                        Subnet Mask adalah alamat 32-bit yang digunakan untuk memisahkan IP Address menjadi dua bagian utama: 
                        Network ID dan Host ID. Router menggunakan Subnet Mask untuk menentukan apakah suatu paket data 
                        harus tetap di jaringan lokal atau diteruskan ke jaringan lain.
                    </p>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Kerja Subnet Masks</span></p>
                    <p class="text-gray-700 mb-2">
                        Subnet Mask bekerja dengan melakukan operasi <b>AND</b> logis antara IP Address dan Subnet Mask untuk 
                        mendapatkan bagian Network ID.
                    </p>
                    <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik Subnet Mask standar:</span></p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">255</span> menunjukkan bagian Network ID.</li>
                        <li><span class="font-semibold">0</span> menunjukkan bagian Host ID (alamat yang dapat digunakan perangkat).</li>
                    </ul>
                    <p class="text-gray-700 mb-2">Contoh Subnet Mask umum: <span class="font-semibold">255.255.255.0</b></span>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Konfigurasi IP Statis & Dinamis</h3>
                    <!-- IP Statis -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. IP Statis (Static IP Address)</h4>
                        <p class="text-gray-700 mb-2">
                            IP Statis adalah alamat IP yang ditetapkan secara manual oleh administrator jaringan pada perangkat. 
                            Alamat ini bersifat permanen dan tidak akan berubah, kecuali diubah lagi secara manual.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik Utama:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Penetapan:</span> Dilakukan secara manual (menggunakan keyboard dan mouse) pada pengaturan jaringan perangkat.</li>
                            <li><span class="font-semibold">Permanensi:</span> Alamat IP, Subnet Mask, Gateway, dan DNS Server selalu sama dan tidak akan berubah.</li>
                            <li><span class="font-semibold">Contoh:</span> 192.168.1.10, Subnet Mask 255.255.255.0, Gateway 192.168.1.1</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Kapan Digunakan?</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Server: Server Web, Email, dan File.</li>
                            <li>Perangkat Jaringan: Printer Jaringan, Router, Access Point.</li>
                            <li>Keamanan: Membatasi akses hanya pada IP tertentu.</li>
                        </ul>
                    </div>
                    <!-- IP Dinamis -->
                    <div>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. IP Dinamis (Dynamic IP Address)</h4>
                        <p class="text-gray-700 mb-2">
                            IP Dinamis adalah alamat IP yang ditetapkan secara otomatis oleh server ketika perangkat terhubung ke jaringan. 
                            Proses ini diatur oleh protokol DHCP (Dynamic Host Configuration Protocol).
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik Utama:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Penetapan:</span> Dilakukan otomatis oleh DHCP Server.</li>
                            <li><span class="font-semibold">Sewa (Lease):</span> Alamat IP dipinjamkan untuk waktu tertentu.</li>
                            <li><span class="font-semibold">Contoh:</span> Menggunakan opsi "Obtain an IP address automatically".</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Kerja DHCP:</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Discovery:</span> Client meminta alamat IP.</li>
                            <li><span class="font-semibold">Offer:</span> DHCP Server menawarkan IP.</li>
                            <li><span class="font-semibold">Request:</span> Client meminta IP yang ditawarkan.</li>
                            <li><span class="font-semibold">Acknowledge:</span> DHCP Server memberikan IP secara resmi.</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Kapan Digunakan?</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Laptop & komputer desktop.</li>
                            <li>Smartphone & tablet.</li>
                            <li>Jaringan besar dengan banyak perangkat.</li>
                        </ul>
                    </div>
                    <!--  -->
                    <h3 class="text-2xl font-bold text-blue-700 mb-4">Cara Menghitung Subnet</h3>
                    <!-- Langkah 1 -->
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">🔢 Langkah 1: Tentukan Prefix (Notasi CIDR)</h4>
                        <p class="text-gray-700 mb-2">
                            Langkah pertama adalah menentukan alamat IP dan notasi prefix CIDR yang ingin Anda subnetting. 
                            Notasi CIDR (misalnya, /24, /26) menunjukkan jumlah bit yang didedikasikan untuk Network ID.
                        </p>

                        <p class="text-gray-700 mb-2">Contoh Soal:</p>
                        <ul class="list-disc list-inside ml-4 text-gray-700 space-y-1">
                            <li>Alamat jaringan dasar: <b>192.168.1.0/24</b></li>
                            <li>Alamat Jaringan: 192.168.1.0</li>
                            <li>Prefix Awal: /24 (24 bit untuk Network ID, 8 bit untuk Host ID)</li>
                            <li>Target subnetting menggunakan prefix <b>/26</b></li>
                        </ul>
                    </div>
                    <!-- Langkah 2 -->
                    <div class="mb-3">
                        <h4 class="text-xl font-bold text-blue-600 mb-2">Langkah 2: Hitung Subnet Mask Baru</h4>
                        <p class="text-gray-700 mb-2">
                            Dengan prefix target <span class="font-semibold">/26</span>, Anda dapat menghitung Subnet Mask baru.
                        </p>
                        <p class="text-gray-700 mb-2">Jumlah bit yang disetel menjadi 1 untuk Network ID adalah 26.</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Subnet Mask Baru (biner):</span></p>
                        <p class="text-gray-700 mb-2">11111111.11111111.11111111.11000000</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Nilai Desimal:</span></p>
                        <p class="text-gray-700 mb-2">255.255.255.192</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>11111111 = 255</li>
                            <li>11000000 = 192 (128 + 64 = 192)</li>
                        </ul>
                        <p class="text-gray-700 mt-2">Jadi, Subnet Mask baru untuk <b>/26</b> adalah <b>255.255.255.192</b>.</p>
                    </div>
                    <!-- Langkah 3 -->
                    <div class="mb-3">
                        <h4 class="text-xl font-bold text-blue-600 mb-2">🧮 Langkah 3: Hitung Jumlah Subnet dan Jumlah Host</h4>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">A. Jumlah Subnet</span></p>
                        <p class="text-gray-700 mb-2">
                            Bit Tambahan yang Dipinjam (Borrowed Bits): 26 - 24 = 2 bit.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Rumus:</span> 2^(jumlah bit yang dipinjam)</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Perhitungan:</span> 2² = 4 subnet</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">B. Jumlah Host per Subnet</span></p>
                        <p class="text-gray-700 mb-2">
                            Bit Host yang Tersisa: 32 - 26 = 6 bit.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Rumus:</span> 2^(bit Host) - 2</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Perhitungan:</span> 2⁶ - 2 = 64 - 2 = 62 host</p>
                        <p class="text-gray-700">Setiap subnet dapat menampung maksimal <span class="font-semibold">62 host</span>.</p>
                    </div>
                    <!-- Langkah 4 -->
                    <div class="mb-3">
                        <h4 class="text-xl font-bold text-blue-600 mb-2">Langkah 4: Hitung Alamat Subnet dan Rentang Host</h4>
                        <p class="text-gray-700 mb-2">
                            Langkah terakhir adalah menentukan Network Address dan Broadcast Address dari setiap subnet.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Block Size (Increment):</span></p>
                        <p class="text-gray-700 mb-2">256 - 192 = 64</p>
                        <p class="text-gray-700 mb-2">Block Size adalah <span class="font-semibold">64</span>.</p>
                    </div>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Test Koneksi dengan Perintah <i>ping</i></h3>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">📡 Pengertian & Fungsi Perintah <i>ping</i></h4>
                        <p class="text-gray-700 mb-2">
                            Perintah <b>ping (Packet Internet Groper)</b> adalah alat diagnostik jaringan yang digunakan untuk:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Menguji Konektivitas:</span> Memastikan apakah sebuah host dapat dijangkau melalui jaringan.</li>
                            <li><span class="font-semibold">Mengukur Waktu Tempuh (Latency):</span> Mengukur waktu paket data dari perangkat ke host tujuan dan kembali (RTT).</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">🔧 Cara Kerja <i>ping</i></h4>
                        <p class="text-gray-700 mb-2">
                            Perintah <i>ping</i> bekerja menggunakan protokol <span class="font-semibold">ICMP (Internet Control Message Protocol)</span>.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><b>Pengiriman:</b> Komputer mengirimkan paket ICMP Echo Request ke alamat IP atau host tujuan.</li>
                            <li><b>Penerimaan:</b> Jika tujuan aktif, ia mengirimkan ICMP Echo Reply.</li>
                            <li><b>Hasil:</b> Waktu respons dihitung dan ditampilkan sebagai latency.</li>
                        </ul>
                    </div>
                    <div class="mb-6">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">💻 Cara Menggunakan Perintah <i>ping</i></h4>
                        <p class="text-gray-700 mb-2">
                            Perintah ini dijalankan melalui Command Prompt (Windows) atau Terminal (Linux/macOS).
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Langkah-Langkah:</span>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>
                                <span class="font-semibold">Buka Terminal/CMD:</p><br>
                                Windows: Tekan <span class="font-semibold">Win + R</span>, ketik <span class="font-semibold">cmd</span>, Enter.<br>
                                Linux/macOS: Buka aplikasi Terminal.
                            </li>
                            <li>
                                <span class="font-semibold">Masukkan Perintah:</span> Ketik <code class="bg-gray-100 px-1 rounded">ping</code> diikuti alamat IP atau nama domain.
                            </li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Sintaks Dasar:</span></p>
                        <pre class="bg-gray-100 p-3 rounded text-gray-800 mb-3">ping [alamat IP atau nama host]</pre>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Contoh Penggunaan:</p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">1. Menguji Koneksi ke Router Lokal (Gateway)</span></p>
                        <pre class="bg-gray-100 p-3 rounded text-gray-800 mb-4">ping 192.168.1.1</pre>
                        <p class="text-gray-700 mb-1"><span>2. Menguji Koneksi ke Website</span></p>
                        <pre class="bg-gray-100 p-3 rounded text-gray-800">ping google.com</pre>
                    </div>
                    <!-- REFERENSI VIDEO MATERI 3 TKJ -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran Materi 3
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Berikut adalah video pendukung untuk <b>Materi 3 TKJ</b>.
                            <br>
                            Silakan klik play untuk menonton atau buka langsung di YouTube.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/Xbsi8nbEyZA"
                                title="Materi 3 TKJ – Video Pembelajaran"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/Xbsi8nbEyZA"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                Tonton langsung di YouTube
                            </a>
                        </div>
                    </section>

                    <div class="mt-6 pt-4 border-t border-gray-200 text-right">
                        <a href="?mode=tugas&materi_id=3" class="inline-block px-6 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-200">
                            Kerjakan Tugas Materi 3
                        </a>
                    </div>
                </div>

                <!-- Konten Materi 4 -->
                <div id="materi-4" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 4) ? '' : 'hidden' ?>">
                    <h2 class="text-2xl font-bold text-blue-700 mb-4">4. Sistem Operasi Jaringan Dasar</h2>
                    <h3 class="h3 = text-xl font-bold text-blue-700 mb-4">Sistem Operasi Client (OS Desktop)</h3>
                    <!-- OS Client -->
                    <div class="mb-3">
                        <p class="text-gray-700 mb-2">
                            Sistem Operasi Client dirancang khusus untuk digunakan pada perangkat komputasi pribadi seperti PC Desktop,
                            laptop, dan perangkat seluler. Tujuan utamanya adalah untuk memberikan pengalaman yang lancar dan intuitif
                            bagi satu pengguna tunggal dalam melakukan tugas-tugas sehari-hari.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fokus Desain</span></p>
                        <p class="text-gray-700 mb-2">
                            Fokus utama OS Client adalah Antarmuka Grafis (GUI) yang ramah pengguna, mudah dinavigasi, dan responsif.
                            OS ini dioptimalkan untuk menjalankan aplikasi pengguna akhir (end-user applications) seperti browser web,
                            word processor, aplikasi multimedia, dan game.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik Kinerja</span></p>
                        <p class="text-gray-700 mb-2">
                            Meskipun dapat mendukung beberapa koneksi jaringan, OS Client tidak dirancang untuk menangani ratusan
                            permintaan layanan secara bersamaan. Kinerjanya dioptimalkan untuk kecepatan respons bagi pengguna yang
                            berinteraksi langsung dengan desktop atau layar sentuh.
                        </p>
                        <p class="text-gray-700 mb-3">
                            Jumlah koneksi inbound sangat dibatasi, dan fitur-fitur jaringan tingkat lanjut seringkali dinonaktifkan
                            secara default. Contoh paling umum dari OS Client adalah <span class="font-semibold">Microsoft Windows (10/11)</span>, <span class="font-semibold">macOS</span>,
                            dan <span>Linux Desktop</span> seperti Ubuntu.
                        </p>
                    </div>
                    <!-- OS Server -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Sistem Operasi Server</h3>
                    <div class="mb-3">
                        <p class="text-gray-700 mb-2">
                            Sistem Operasi Server dirancang untuk berjalan pada server berkinerja tinggi. Tujuannya adalah untuk
                            menyediakan layanan dan sumber daya jaringan kepada banyak client secara simultan dan berkelanjutan
                            (operasi 24 jam sehari, 7 hari seminggu).
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fokus Desain</p>
                        <p class="text-gray-700 mb-2">
                            Fokus utama OS Server adalah Stabilitas, Keandalan (<i>Uptime</i>), dan Keamanan Jaringan.
                            OS Server biasanya memiliki antarmuka grafis yang minimalis atau bahkan hanya berbasis CLI
                            (Command Line Interface). Ini bertujuan mengurangi overhead dan membebaskan sumber daya agar digunakan
                            untuk layanan penting seperti Web Server, Database, DHCP/DNS, atau Virtualisasi.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Karakteristik Kinerja</span></p>
                        <p class="text-gray-700 mb-2">
                            OS Server memiliki kemampuan manajemen memori dan multitasking yang jauh lebih unggul. Mereka dioptimalkan
                            untuk memproses volume trafik dan permintaan jaringan yang tinggi dari ribuan client secara efisien.
                        </p>
                        <p class="text-gray-700 mb-2">
                            OS ini juga menyediakan alat keamanan tingkat lanjut untuk otentikasi pengguna, hak akses, dan mekanisme
                            redundansi agar sistem tetap berjalan tanpa hambatan. Contohnya adalah <b>Windows Server</b> dan berbagai
                            distribusi <b>Linux Server</b> seperti Red Hat atau Debian.
                        </p>
                    </div>
                    <!-- Inti Perbedaan -->
                    <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg">
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Inti Perbedaan</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">OS Client</span> adalah untuk interaksi dan pengalaman pengguna tunggal.</li>
                            <li><span class="font-semibold">OS Server</span> adalah untuk pelayanan dan manajemen sumber daya jaringan secara massal dan tanpa henti.</li>
                        </ul>
                    </div>
                    <!-- REFERENSI VIDEO MATERI 4 TKJ -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-100 text-red-600">
                                <i class="fas fa-server"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran Materi 4 – Sistem Operasi Jaringan
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Video ini menjelaskan pengertian, fungsi, dan peran Sistem Operasi Jaringan (Network Operating System)
                            dalam jaringan komputer, sebagai pendukung pembelajaran <b>Materi 4 TKJ</b>. 
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/xR3t7_InTug"
                                title="Network Operating System | Explanation, Definition, and Function"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/xR3t7_InTug"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                Tonton langsung di YouTube
                            </a>
                        </div>
                    </section>

                    <div class="mt-6 pt-4 border-t border-gray-200 text-right">
                        <a href="?mode=tugas&materi_id=4" class="inline-block px-6 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-200">
                            Kerjakan Tugas Materi 4
                        </a>
                    </div>
                </div>

                <!-- Konten Materi 5 -->
                <div id="materi-5" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 5) ? '' : 'hidden' ?>">
                    <h2 class="text-2xl font-bold text-blue-700 mb-4">5. Keselamatan dan Kesehatan Kerja</h2>
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Aturan Kerja di Laboratorium TKJ</h3>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">I. Aturan Umum dan Ketertiban</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Kehadiran dan Izin:</span> Wajib hadir tepat waktu sesuai jadwal yang ditentukan. Tidak diperbolehkan masuk atau menggunakan lab tanpa izin dari guru atau teknisi yang bertugas.</li>
                            <li><span class="font-semibold">Makanan dan Minuman:</span> Dilarang keras membawa makanan dan minuman ke dalam area lab. Cairan dapat merusak komponen elektronik dan keyboard.</li>
                            <li><span class="font-semibold">Kebersihan dan Kerapian:</span> Wajib menjaga kebersihan meja, kursi, dan lantai lab. Setelah selesai, rapikan kembali kursi, keyboard, dan perangkat lain ke posisi semula.</li>
                            <li><span class="font-semibold">Penggunaan Ponsel:</span> Gunakan ponsel dengan bijak. Hindari penggunaan ponsel untuk kegiatan yang tidak berhubungan dengan materi pelajaran saat jam praktikum.</li>
                            <li><span class="font-semibold">Akses Internet:</span> Gunakan koneksi internet hanya untuk keperluan praktikum dan pembelajaran yang relevan. Dilarang mengakses konten terlarang atau mengunduh file ilegal.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">II. Aturan Keselamatan Peralatan (Hardware)</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Perlakuan Hardware:</span> Jangan menyentuh, membongkar, atau memindahkan perangkat keras (hardware) seperti CPU, RAM, atau kabel internal tanpa instruksi atau pengawasan guru.</li>
                            <li><span class="font-semibold">Kabel dan Koneksi:</span> Pastikan semua kabel (listrik, jaringan, monitor) terpasang dengan benar dan tidak longgar. Tarik atau cabut kabel hanya pada bagian konektornya, bukan pada kabelnya. Hindari menjerat atau melilitkan kabel pada kaki kursi atau meja.</li>
                            <li><span class="font-semibold">Matikan Komputer:</span> Lakukan prosedur <span class="font-semibold">Shutdown yang benar</span> pada sistem operasi sebelum mematikan aliran listrik (melalui tombol power atau steker). Dilarang mematikan komputer dengan mencabut kabel secara langsung.</li>
                            <li><span class="font-semibold">Pelaporan Kerusakan:</span> Segera laporkan kepada guru atau teknisi jika menemukan ada perangkat yang rusak, mengeluarkan asap, atau berbau menyengat.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">III. Aturan Keselamatan Sistem (Software)</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Instalasi Program:</span> Dilarang menginstal, mengubah, menghapus, atau memodifikasi perangkat lunak (software) atau pengaturan sistem operasi tanpa izin.</li>
                            <li><span class="font-semibold">USB dan Media Eksternal:</span> Berhati-hatilah saat menggunakan USB flash drive atau media eksternal lainnya. Pindai terlebih dahulu menggunakan antivirus untuk menghindari penyebaran virus atau malware.</li>
                            <li><span class="font-semibold">Akses Sistem:</span> Dilarang mencoba mengakses berkas atau folder milik pengguna lain atau berkas sistem tanpa otorisasi. **Log Out** atau kunci sesi komputer Anda saat meninggalkan lab, meskipun hanya sebentar.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">IV. Aturan Khusus Praktikum Jaringan</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Perangkat Jaringan:</span> Berhati-hatilah saat menangani perangkat aktif jaringan seperti Switch, Router, dan Access Point. Letakkan di tempat yang aman dan stabil.</li>
                            <li><span class="font-semibold">Konfigurasi Jaringan:</span> Dilarang mengubah konfigurasi IP Address atau pengaturan jaringan lainnya di luar dari tugas praktikum yang diberikan.</li>
                            <li><span class="font-semibold">Keselamatan Penggunaan Listrik:</span> Perhatikan penggunaan kabel power dan stop kontak. Hindari pembebanan berlebih (overload) pada satu stop kontak.</li>
                        </ul>
                    </div>
                    <div class="bg-blue-50 border-l-4 border-blue-600 p-4 rounded-lg">
                        <p class="text-gray-700">
                            Dengan mengikuti aturan-aturan ini, lingkungan belajar di lab TKJ akan menjadi aman, nyaman, dan semua peralatan akan terjaga dengan baik.
                        </p>
                    </div>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Cara Menggunakan Alat Kerja Komputer dan Jaringan</h3>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. Multimeter (Multitester)</h4>
                        <p class="text-gray-700 mb-2">
                            Multimeter adalah alat ukur elektronik serbaguna yang digunakan untuk mengukur berbagai besaran listrik, paling umum adalah <b>Tegangan (Volt)</b>, <b>Arus (Ampere)</b>, dan <b>Resistansi (Ohm)</b>. 
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/multimeter.webp" 
                                alt="multimeter"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">A. Mengukur Tegangan DC (Direct Current, seperti Baterai)</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Pilih Mode:</span> Putar saklar selektor ke mode <span class="font-semibold">DCV (DC Voltage)</span>.</li>
                            <li><span class="font-semibold">Pilih Skala:</span> Pilih skala yang lebih tinggi dari perkiraan tegangan yang akan diukur (misalnya, jika mengukur baterai 9V, pilih skala 12V atau 20V jika menggunakan Multimeter Digital). Jika tidak yakin, selalu mulai dari skala tertinggi untuk menghindari kerusakan alat.</li>
                            <li><span class="font-semibold">Hubungkan Probe:</span> Hubungkan probe Merah ke terminal positif (+) dan probe Hitam ke terminal negatif (−) sumber tegangan. Polaritas tidak boleh terbalik pada pengukuran DC.</li>
                            <li><span class="font-semibold">Baca Hasil:</span> Baca nilai tegangan yang muncul di layar display.</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">B. Mengukur Resistansi (Ohm / Ω)</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Pilih Mode:</span> Putar saklar selektor ke mode <span class="font-semibold">Ohm (Ω)</span> atau Resistance.</li>
                            <li><span class="font-semibold">Siapkan Komponen:</span> Pastikan komponen yang diukur <span class="font-semibold">tidak terhubung dengan sumber tegangan</span> (listrik mati).</li>
                            <li><span class="font-semibold">Hubungkan Probe:</span> Hubungkan kedua probe (Merah dan Hitam) ke kedua ujung komponen yang akan diukur (misalnya, Resistor). Pengukuran resistansi tidak memiliki polaritas, jadi probe boleh terbalik.</li>
                            <li><span class="font-semibold">Baca Hasil:</span> Baca nilai resistansi. Multimeter juga sering digunakan untuk menguji <span class="font-semibold">Kontinuitas</span> (kabel putus atau tidak) di mode ini, di mana suara beeper menandakan sambungan utuh.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. LAN Tester (Pengecek Kabel Jaringan)</h4>
                        <p class="text-gray-700 mb-3">
                            LAN Tester adalah alat penting yang digunakan untuk memeriksa dan memverifikasi konektivitas dan susunan kabel jaringan UTP/STP, terutama setelah dipasang konektor RJ-45. 
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/lantester.webp" 
                                alt="lan"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi Utama</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Mendeteksi Kerusakan:</span> Mengidentifikasi masalah fisik pada kabel, seperti kabel putus (open), korsleting (short), atau kabel terbalik (crossed).</li>
                            <li><span class="font-semibold">Memverifikasi Susunan:</span> Memastikan urutan kabel (pin 1 hingga pin 8) yang telah di-crimping sesuai dengan standar yang benar (Straight-Through atau Crossover).</li>
                        </ul>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Penggunaan</span></p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Siapkan Alat:</span> Pastikan kabel UTP/STP sudah terpasang konektor RJ-45 di kedua ujungnya.</li>
                            <li><span class="font-semibold">Hubungkan:</span> Hubungkan satu ujung kabel ke unit utama (Main Unit) LAN Tester, dan ujung kabel lainnya ke unit jarak jauh (Remote Unit).</li>
                            <li><span class="font-semibold">Nyalakan:</span> Nyalakan LAN Tester. Alat akan memulai siklus pengujian.</li>
                            <li><span class="font-semibold">Baca Indikator LED:</span> Amati lampu indikator LED yang biasanya bernomor 1 hingga 8:
                                <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                                    <li><span class="font-semibold">Normal:</span> Jika kabel di-crimping dengan benar (misalnya Straight-Through), semua lampu LED pada Main Unit dan Remote Unit akan menyala secara berurutan dari 1 hingga 8.</li>
                                    <li><span class="font-semibold">Kerusakan:</span> Jika ada kesalahan (misalnya kabel putus), lampu pada nomor pin yang rusak akan tidak menyala atau menyala dengan urutan yang salah.</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">3. Crimping Tool (Tang Crimping)</h4>
                        <p class="text-gray-700 mb-2">
                            Crimping Tool adalah alat yang digunakan untuk menjepit konektor RJ-45 atau RJ-11 ke ujung kabel jaringan (UTP/STP) agar koneksi pin terbentuk secara permanen. 
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/crimping.webp" 
                                alt="Motherboard"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2">Langkah-Langkah Crimping Kabel UTP ke RJ-45</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Kupas Kulit Kabel:</span> Gunakan pisau yang ada pada Crimping Tool untuk mengupas kulit luar kabel UTP sepanjang sekitar 1,5 hingga 2 cm.</li>
                            <li><span class="font-semibold">Urai dan Susun:</span> Uraikan delapan kawat kecil yang dipilin di dalamnya. Susun kawat-kawat tersebut sesuai dengan standar warna yang dibutuhkan (misalnya, Straight-Through atau Crossover).</li>
                            <li><span class="font-semibold">Ratakan Ujung:</span> Luruskan dan ratakan ujung delapan kawat tersebut dengan memotongnya menggunakan pemotong agar semua ujung rata.</li>
                            <li><span class="font-semibold">Masukkan Konektor:</span> Masukkan delapan kawat yang sudah tersusun rapi ke dalam konektor RJ-45. Pastikan ujung kawat menyentuh bagian ujung konektor dan pembungkus kabel terpegang erat di dalam konektor.</li>
                            <li><span class="font-semibold">Jepit (Crimp):</span> Masukkan konektor RJ-45 yang sudah terisi kabel ke dalam slot yang sesuai pada Crimping Tool. Tekan dengan kuat hingga berbunyi "klik."</li>
                            <li><span class="font-semibold">Uji:</span> Gunakan LAN Tester untuk memverifikasi bahwa proses crimping berhasil.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">4. Cleaver (Fiber Cleaver)</h4>
                        <p class="text-gray-700 mb-2">
                            Cleaver, atau Pemotong Serat Optik, adalah alat presisi yang digunakan untuk memotong ujung helai serat optik agar siap untuk disambungkan. Ini adalah langkah pertama yang paling penting sebelum splicing. 
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/cleaver.webp" 
                                alt="cleaver"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi Utama</span></p>
                        <p class="text-gray-700 mb-2">
                            Fungsi Cleaver bukan hanya memotong, melainkan untuk menciptakan permukaan ujung serat optik yang sangat **rata (flat)** dan **tegak lurus (perpendicular)** sempurna terhadap sumbu serat. Kualitas potongan ini sangat menentukan seberapa baik sambungan yang akan dihasilkan oleh Fusion Splicer.
                        </p>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Cara Kerja</span></p>
                        <p class="text-gray-700 mb-2">
                            Cleaver menggunakan pisau berlian atau karbida yang sangat keras. Pisau ini hanya menggores permukaan serat optik. Goresan ini kemudian diimbangi dengan tekanan mekanis atau tarikan sehingga serat **terbelah (cleave)** dengan permukaan yang mulus dan bebas retakan.
                        </p>
                        <p class="text-gray-700 mb-2">
                            <b>Penting:</b> Potongan yang buruk akan menyebabkan kehilangan sinyal (attenuation) yang tinggi pada sambungan, sehingga mengurangi kualitas transmisi data.
                        </p>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">5. Fusion Splicer (Alat Penyambung Fusi)</h4>
                        <p class="text-gray-700 mb-2">
                            Fusion Splicer adalah perangkat elektomekanik berteknologi tinggi yang digunakan untuk menyambung dua ujung serat optik secara permanen dengan cara **meleburkan (fusi)** kedua ujung tersebut menggunakan busur listrik. 
                        </p>
                        <div class="w-full flex justify-center pb-6">
                            <img 
                                src="../../../assets/images/fusion.webp" 
                                alt="Motherboard"
                                class="w-full max-w-xs h-auto rounded-xl shadow-lg object-cover"
                            />
                        </div>
                        <p class="text-gray-700 mb-2"><span class="font-semibold">Fungsi Utama</span></p>
                        <p class="text-gray-700 mb-2">
                            Tujuan dari Fusion Splicer adalah untuk menciptakan sambungan yang sehalus mungkin antara dua helai serat optik agar cahaya (sinyal data) dapat melintas dengan hambatan minimal.
                        </p>
                        <p class="ttext-gray-700 mb-2">Cara Kerja</p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Persiapan:</span> Kedua ujung serat yang sudah di-cleave ditempatkan dan disejajarkan secara presisi di dalam splicer.</li>
                            <li><span class="font-semibold">Penyelarasan:</span> Splicer menggunakan kamera dan motor mikro untuk menyelaraskan inti (core) dari kedua serat secara otomatis (proses yang dikenal sebagai **Core Alignment**).</li>
                            <li><span class="font-semibold">Fusi (Peleburan):</span> Setelah sejajar, perangkat akan mengeluarkan **busur listrik (electric arc)** singkat yang sangat panas untuk melelehkan dan menggabungkan kedua ujung kaca menjadi satu helai tunggal.</li>
                            <li><span class="font-semibold">Pengujian:</span> Setelah fusi, Splicer akan memberikan hasil estimasi kerugian sambungan (**splice loss**) yang diukur dalam dB (Decibel). Sambungan yang baik memiliki kerugian sangat rendah (misalnya, $0.02 \text{ dB}$).</li>
                            <li><span class="font-semibold">Perlindungan:</span> Sambungan yang telah dilebur kemudian dilindungi menggunakan selongsong pelindung (splice protector sleeve) yang dipanaskan di dalam Splicer agar mengencang dan melindungi area sambungan dari kelembaban dan kerusakan fisik.</li>
                        </ul>
                    </div>
                    <!--  -->
                    <h3 class="text-xl font-bold text-blue-700 mb-4">Prinsip Keamanan dan Kerapian Kabel</h3>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">I. Pemilihan dan Perencanaan</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Gunakan Kabel yang Tepat:</span> Selalu gunakan kabel dengan panjang yang sesuai kebutuhan. Kabel yang terlalu panjang akan menyebabkan kekacauan, sementara kabel yang terlalu pendek akan tegang dan cepat rusak.</li>
                            <li><span class="font-semibold">Identifikasi:</span> Beri label (**labeling**) pada kedua ujung kabel (di perangkat dan di switch/stop kontak). Ini krusial untuk pemeliharaan dan pemecahan masalah (troubleshooting).</li>
                            <li><span class="font-semibold">Pemisahan Kabel:</span> Lakukan pemisahan jalur antara kabel data (misalnya kabel UTP, serat optik) dan kabel listrik (power). Hal ini dilakukan untuk mencegah **interferensi elektromagnetik (EMI)** yang dapat menurunkan kualitas sinyal data.</li>
                            <li><span class="font-semibold">Jalur Aman:</span> Rencanakan jalur kabel di area yang tidak terinjak atau terlalui oleh kaki, kursi, atau pintu, untuk mencegah kerusakan fisik dan risiko tersandung.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">II. Alat dan Teknik Kerapian</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Pengikat Kabel (Cable Ties):</span> Gunakan **Velcro/Strap Kabel** sebagai pengganti cable tie plastik di sebagian besar kasus. Velcro lebih mudah dibuka tutup untuk pemeliharaan dan tidak menekan kabel terlalu keras. Jika menggunakan cable tie plastik, jangan mengikatnya terlalu kencang, karena dapat merusak isolasi atau inti tembaga kabel, terutama pada kabel data.</li>
                            <li><span class="font-semibold">Jalur (Raceway) dan Pelindung (Conduit):</span> Gunakan Jalur Kabel atau Kanal plastik yang dipasang di bawah meja atau di sepanjang dinding untuk menyembunyikan dan melindungi kabel. Gunakan Pelindung Lantai (**Floor Cable Cover**) yang tebal jika kabel harus melintasi area lalu lintas.</li>
                            <li><span class="font-semibold">Manajemen Vertikal dan Horizontal:</span> Di rak server atau kabinet jaringan, gunakan **Panel Manajemen Kabel** (horizontal) dan D-Rings atau velcro (vertikal) untuk menjaga kerapian kabel yang masuk dan keluar dari switch. </li>
                            <li><span class="font-semibold">Sembunyikan dan Kumpulkan:</span> Gunakan **Kotak Manajemen Kabel** di bawah meja untuk menampung kelebihan panjang kabel dan menempatkan power strip (stop kontak ekstensi) agar tidak terlihat berantakan di lantai.</li>
                        </ul>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">III. Aspek Keamanan Penting</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Hindari Tekukan Tajam:</span> Jangan pernah menekuk kabel, terutama kabel serat optik, dengan sudut yang terlalu tajam (kurang dari jari kelingking Anda). Tekukan tajam pada kabel tembaga dapat merusak konduktor, sementara pada serat optik dapat menyebabkan **kerugian sinyal (signal loss)** parah.</li>
                            <li><span class="font-semibold">Amankan Stop Kontak:</span> Pastikan semua kabel power terhubung ke power strip atau stop kontak yang terpasang erat dan tidak menggantung. Stop kontak yang menggantung dapat menyebabkan korsleting atau kebakaran.</li>
                            <li><span class="font-semibold">Kabel Jaringan yang Diuji:</span> Pastikan semua kabel UTP/STP yang digunakan di jaringan sudah diuji menggunakan **LAN Tester** untuk memastikan tidak ada short atau open circuit yang dapat menyebabkan masalah konektivitas atau merusak port perangkat.</li>
                            <li><span class="font-semibold">Aliran Udara:</span> Di rak server, kelola kabel sedemikian rupa sehingga tidak menghalangi aliran udara panas keluar dan udara dingin masuk, untuk mencegah **overheating** pada perangkat.</li>
                            <li><span class="font-semibold">Grounding:</span> Pastikan semua perangkat jaringan dan kabinet terhubung ke sistem **grounding** yang baik untuk melindungi peralatan dari lonjakan listrik.</li>
                        </ul>
                    </div>
                    <!-- REFERENSI VIDEO MATERI 5 TKJ -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran Materi 5 – Alat & Fungsi Fiber Optic
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Video ini menjelaskan tentang berbagai tool atau alat yang digunakan dalam 
                            instalasi dan perawatan kabel fiber optic serta fungsi masing-masingnya, sebagai 
                            pendukung pembelajaran <b>Materi 5 TKJ</b>.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/aT8eog7kZ1M"
                                title="Fiber Optic Tools and Their Functions"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/aT8eog7kZ1M"
                                target="_blank"
                                class="text-blue-600 hover:underline font-medium">
                                Tonton langsung di YouTube
                            </a>
                        </div>
                    </section>

                    <div class="mt-6 pt-4 border-t border-gray-200 text-right">
                        <a href="?mode=tugas&materi_id=5" class="inline-block px-6 py-2 bg-green-500 text-white font-semibold rounded-lg hover:bg-green-600 transition duration-200">
                            Kerjakan Tugas Materi 5
                        </a>
                    </div>
                </div>

            </div>
            
            <!-- Area Tugas (Tampilan Tugas) -->
            <?php require_once __DIR__ . '/../../../private/tampilan_tugas.php';?>
        </main>
    </div>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../../../private/nav-bottom.php';?>

    <script src="../../../assets/js/materi_dasar.js"></script>
</body>
</html>