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
                        1 => "Pengantar Akuntansi", 
                        2 => "Persamaan Dasar Akuntansi", 
                        3 => "Akun dan Kelompok Akun", 
                        4 => "Jurnal Umum", 
                        5 => "Buku Besar dan Neraca Saldo"
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
            
            <!-- Judul halaman berdasarkan mode -->
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 mt-4 md:mt-0">
                <?= $mode === 'materi' ? '📖 Halaman Materi Pembelajaran' : '📝 Halaman Tugas' ?>
            </h1>

            <!-- Area materi (disembunyikan saat mode tugas) -->
            <div id="materi-area" class="min-h-[400px] <?= $mode === 'tugas' ? 'hidden' : '' ?>">

                <!-- Konten materi 1 (ditampilkan jika materi aktif) -->
                <div id="materi-1" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 1) ? '' : 'hidden' ?>">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Pengantar Akuntansi 🧾
                    </h2>

                    <h3 class="text-2xl font-bold text-blue-700 mb-4 mt-6">1. Pengertian Akuntansi</h3>
                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Akuntansi adalah proses <span class="font-semibold">mencatat, mengklasifikasi, meringkas, dan melaporkan</span> semua transaksi keuangan suatu perusahaan. Tujuannya adalah untuk mengetahui kondisi keuangan secara jelas.
                    </p>

                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Proses Akuntansi (Siklus)</h4>
                    <ol class="list-decimal list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Mencatat (Recording)</span>: Semua transaksi dicatat di jurnal (buku harian).</li>
                        <li><span class="font-semibold">Mengklasifikasi (Classifying)</span>: Setiap transaksi dimasukkan ke kelompok akun yang sesuai (Kas, Beban, Utang, dll.).</li>
                        <li><span class="font-semibold">Meringkas (Summarizing)</span>: Data diringkas menjadi neraca saldo dan laporan keuangan.</li>
                        <li><span class="font-semibold">Melaporkan (Reporting)</span>: Hasil akhir berupa Laporan Keuangan (Laba Rugi, Neraca) untuk pengambilan keputusan.</li>
                    </ol>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Fungsi, Manfaat, dan Pengguna Akuntansi
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">Fungsi Utama Akuntansi</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Alat Pencatatan (Recording)</span>: Mencatat semua transaksi secara sistematis.</li>
                        <li><span class="font-semibold">Alat Pengendalian (Controlling)</span>: Mengawasi aktivitas keuangan, mendeteksi kesalahan atau pemborosan.</li>
                        <li><span class="font-semibold">Alat Perencanaan (Planning)</span>: Dasar untuk membuat anggaran (*budget*) dan strategi bisnis di masa depan.</li>
                        <li><span class="font-semibold">Alat Pelaporan (Reporting)</span>: Menghasilkan Laporan Keuangan (Neraca, Laba Rugi).</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">Pengguna Informasi Akuntansi</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-lg font-semibold text-blue-600 mb-2">Pengguna Internal</h4>
                            <ul class="list-disc list-inside space-y-1 text-gray-600 ml-4">
                                <li><span class="font-semibold">Manajemen</span>: Untuk perencanaan, pengendalian, dan pengambilan keputusan operasional.</li>
                                <li><span class="font-semibold">Karyawan</span>: Untuk mengetahui kestabilan perusahaan, keamanan pekerjaan, dan bonus.</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-lg font-semibold text-blue-600 mb-2">Pengguna Eksternal</h4>
                            <ul class="list-disc list-inside space-y-1 text-gray-600 ml-4">
                                <li><span class="font-semibold">Investor/Pemilik</span>: Menilai laba, risiko, dan kelayakan investasi.</li>
                                <li><span class="font-semibold">Bank/Kreditur</span>: Menilai kemampuan perusahaan membayar pinjaman.</li>
                                <li><span class="font-semibold">Pemerintah</span>: Untuk perpajakan (PPh, PPN) dan pengawasan ekonomi.</li>
                            </ul>
                        </div>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Bidang-Bidang Spesialisasi Akuntansi
                    </h2>

                    <ul class="list-disc list-inside space-y-4 text-gray-700 ml-4 mb-4">
                        <li><span class="font-semibold text-blue-700">Akuntansi Keuangan (Financial Accounting)</span>: Berfokus pada pelaporan ke pihak <span class="font-semibold">eksternal</span> (Neraca, Laba Rugi).</li>
                        <li><span class="font-semibold text-blue-700">Akuntansi Biaya (Cost Accounting)</span>: Menghitung <span class="font-semibold">biaya produksi</span>, bahan baku, dan tenaga kerja untuk menentukan HPP.</li>
                        <li><span class="font-semibold text-blue-700">Akuntansi Manajemen (Management Accounting)</span>: Memberikan informasi untuk <span class="font-semibold">pengambilan keputusan internal</span> (Anggaran, Analisis Biaya).</li>
                        <li><span class="font-semibold text-blue-700">Akuntansi Perpajakan (Tax Accounting)</span>: Mengatur perhitungan, pelaporan, dan pembayaran <span class="font-semibold">pajak</span> (PPh, PPN).</li>
                        <li><span class="font-semibold text-blue-700">Audit / Pemeriksaan (Auditing)</span>: Memeriksa laporan keuangan oleh pihak <span class="font-semibold">independen</span> untuk memastikan kebenaran dan kejujuran.</li>
                    </ul>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Jenis-Jenis Perusahaan dalam Akuntansi
                    </h2>
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-green-500">
                            <h3 class="text-xl font-bold text-green-700 mb-2">1. Jasa</h3>
                            <p class="text-gray-600 mb-3 text-sm">Menjual layanan/jasa, bukan barang.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2">
                                <li>Tidak ada persediaan barang dagang.</li>
                                <li>Contoh: Bengkel, Salon, Konsultan.</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-red-500">
                            <h3 class="text-xl font-bold text-red-700 mb-2">2. Dagang</h3>
                            <p class="text-gray-600 mb-3 text-sm">Membeli barang jadi, lalu dijual kembali tanpa produksi.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2">
                                <li>Memiliki persediaan barang dagang.</li>
                                <li>Menghitung Harga Pokok Penjualan (HPP).</li>
                                <li>Contoh: Minimarket, Distributor.</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-purple-500">
                            <h3 class="text-xl font-bold text-purple-700 mb-2">3. Manufaktur</h3>
                            <p class="text-gray-600 mb-3 text-sm">Mengolah <span class="font-semibold">bahan baku menjadi barang jadi</span>.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2">
                                <li>Memiliki 3 jenis persediaan (Bahan Baku, Dalam Proses, Barang Jadi).</li>
                                <li>Proses akuntansi biaya lebih kompleks.</li>
                                <li>Contoh: Pabrik Roti, Pabrik Sepatu.</li>
                            </ul>
                        </div>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Dokumen Sumber / Bukti Transaksi
                    </h2>
                    <p class="text-gray-700 mb-2">
                        Bukti tertulis yang menjadi <span class="font-semibold">dasar pencatatan yang valid</span> dalam akuntansi.
                    </p>

                    <ul class="list-disc list-inside space-y-3 text-gray-700 ml-4 mb-4">
                        <li><span class="font-semibold">Nota Kontan</span>: Bukti pembelian/penjualan <span class="font-semibold">tunai</span>.</li>
                        <li><span class="font-semibold">Faktur (Invoice)</span>: Bukti pembelian/penjualan secara <span class="font-semibold">kredit (tempo)</span>.</li>
                        <li><span class="font-semibold">Kwitansi</span>: Bukti bahwa seseorang telah <span class="font-semibold">menerima sejumlah uang</span> (misal: pembayaran sewa).</li>
                        <li><span class="font-semibold">Bukti Setoran Bank</span>: Bukti penyetoran kas ke rekening perusahaan.</li>
                        <li><span class="font-semibold">Bukti Kas Masuk (BKM)</span>: Mencatat penerimaan uang tunai (misal: pelanggan bayar tagihan).</li>
                        <li><span class="font-semibold">Bukti Kas Keluar (BKK)</span>: Mencatat pengeluaran uang tunai (misal: membayar gaji, listrik).</li>
                    </ul>
                    <!-- REFERENSI VIDEO AKUNTANSI – MATERI 1 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Pengantar Akuntansi 1: Persamaan Akuntansi
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami persamaan dasar akuntansi sebagai landasan awal dalam belajar akuntansi — bagian dari <b>Akuntansi Materi 1</b>.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/AEugo9zDPfk"
                                title="Pengantar Akuntansi 1 – Persamaan Akuntansi"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/AEugo9zDPfk"
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

                <!-- Konten materi 2 (ditampilkan jika materi aktif) -->
                <div id="materi-2" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 2) ? '' : 'hidden' ?>">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Persamaan Dasar Akuntansi ⚖️
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Persamaan Dasar Akuntansi adalah rumus utama yang menunjukkan bahwa <span class="font-semibold">setiap transaksi keuangan harus seimbang</span>. Rumus ini menjadi dasar dalam penyusunan laporan keuangan.
                    </p>
                    
                    <div class="equation">
                        Aset = Kewajiban + Modal
                    </div>
                    
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Makna Rumus Ini</h4>
                    <p class="text-gray-700 mb-4">
                        Semua Aset (harta) yang dimiliki perusahaan harus bisa dijelaskan <span class="font-semibold">dari mana asalnya</span>, yaitu dari Kewajiban (utang) atau Modal (hak pemilik).
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Komponen Utama Persamaan
                    </h2>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-green-500">
                            <h3 class="text-xl font-bold text-green-700 mb-2">Aset (Harta)</h3>
                            <p class="text-gray-600 mb-3 text-sm font-semibold">Semua kekayaan yang dimiliki perusahaan.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2 space-y-1">
                                <li>Kas (Uang tunai)</li>
                                <li>Persediaan (Stok barang)</li>
                                <li>Perlengkapan (Habis pakai: ATK)</li>
                                <li>Peralatan (Tahan lama: Komputer, Mesin)</li>
                                <li>Piutang (Hak terima uang dari pelanggan)</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-red-500">
                            <h3 class="text-xl font-bold text-red-700 mb-2">Kewajiban (Utang)</h3>
                            <p class="text-gray-600 mb-3 text-sm font-semibold">Utang perusahaan kepada pihak lain.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2 space-y-1">
                                <li>Utang Usaha (Kepada supplier)</li>
                                <li>Utang Bank (Pinjaman)</li>
                                <li>Utang Gaji (Gaji yang belum dibayar)</li>
                                <li>Utang Pajak (Pajak yang terutang)</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-purple-500">
                            <h3 class="text-xl font-bold text-purple-700 mb-2">Modal (Ekuitas)</h3>
                            <p class="text-gray-600 mb-3 text-sm font-semibold">Hak pemilik atas aset perusahaan.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2 space-y-1">
                                <li>Investasi Awal Pemilik</li>
                                <li>Tambahan Investasi</li>
                                <li><span class="font-semibold">Laba</span> (Menambah Modal)</li>
                                <li><span class="font-semibold">Prive</span> (Mengurangi Modal)</li>
                            </ul>
                        </div>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Pengaruh Transaksi terhadap Persamaan
                    </h2>

                    <p class="text-gray-700 mb-4">
                        Setiap transaksi selalu mempengaruhi <span class="font-semibold">minimal dua elemen</span> akuntansi dan harus menjaga keseimbangan persamaan.
                    </p>

                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">1. Menerima Pendapatan Jasa</h4>
                            <p class="text-sm text-gray-600">
                                Kas Aset dan Pendapatan Modal
                                <span class="font-bold text-green-600">(Aset dan Modal)</span>
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">2. Membayar Beban Listrik</h4>
                            <p class="text-sm text-gray-600">
                                Kas (Aset) dan Beban Modal 
                                <span class="font-bold text-red-600">(Aset) dan Modal</span>
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">3. Pinjam Uang dari Bank</h4>
                            <p class="text-sm text-gray-600">
                                Kas Aset dan Hutang Bank (Kewajiban)
                                <span class="font-bold text-green-600">Aset dan Kewajiban </span>
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">4. Membeli Peralatan Tunai</h4>
                            <p class="text-sm text-gray-600">
                                Peralatan (Aset) dan Kas (Aset) 
                                <span class="font-bold text-yellow-600">(Aset dan Aset)</span>
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">5. Membayar Utang Usaha</h4>
                            <p class="text-sm text-gray-600">
                                Kas Aset dan Hutang Usaha (Kewajiban)
                                <span class="font-bold text-red-600">Aset dan Kewajiban</span>
                            </p>
                        </div>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Pendapatan dan Beban pada Modal
                    </h2>

                    <p class="text-gray-700 mb-4">
                        Pendapatan dan Beban adalah unsur yang mengubah saldo Modal (Ekuitas) dalam persamaan:
                    </p>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-green-50 p-4 rounded-lg shadow-md">
                            <h4 class="text-xl font-bold text-green-700 mb-2">Pendapatan 📈</h4>
                            <p class="text-gray-700">Hasil dari aktivitas utama perusahaan (penjualan jasa/barang).</p>
                            <p class="mt-2 font-semibold text-green-600">Pengaruh: Pendapatan Modal (bertambah).</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg shadow-md">
                            <h4 class="text-xl font-bold text-red-700 mb-2">Beban 📉</h4>
                            <p class="text-gray-700">Biaya yang dikeluarkan untuk menjalankan kegiatan usaha (gaji, listrik).</p>
                            <p class="mt-2 font-semibold text-red-600">Pengaruh: Beban Modal (berkurang).</p>
                        </div>
                    </div>

                    <blockquote class="border-l-4 border-indigo-500 pl-4 py-2 my-6 bg-indigo-50 text-indigo-800 italic">
                        <p><span class="font-semibold">Inti Keseimbangan:</span> Walaupun transaksi terus terjadi, total Aset selalu harus sama dengan total Kewajiban + Modal.</p>
                    </blockquote>
                    <!-- REFERENSI VIDEO AKUNTANSI – MATERI 2 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Persamaan Dasar Akuntansi
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami persamaan dasar akuntansi sebagai landasan 
                            penting dalam pencatatan transaksi — materi ini cocok sebagai <b>Akuntansi Materi 2</b>.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/d982EK-lC0o"
                                title="Basic Accounting Equations"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/d982EK-lC0o"
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
                <!-- Konten materi 3 (ditampilkan jika materi aktif) -->
                <div id="materi-3" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 3) ? '' : 'hidden' ?>">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Akun dan Saldo Normal Akuntansi 📊
                    </h2>

                    <h3 class="text-2xl font-bold text-blue-700 mb-4 mt-6">1. Pengertian Akun</h3>
                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Akun adalah <span class="font-semibold">tempat untuk mencatat semua perubahan</span> yang terjadi akibat transaksi keuangan pada suatu perusahaan. Akun digunakan sebagai wadah untuk <span class="font-semibold">mengelompokkan transaksi sesuai jenisnya</span>, sehingga pencatatan keuangan menjadi lebih rapi, sistematis, dan mudah dianalisis.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Dalam praktiknya, akun dicatat dalam buku besar (ledger) dan biasanya disajikan dalam bentuk T-account yang terdiri dari sisi Debet dan Kredit. Dari akun inilah nantinya laporan keuangan seperti neraca, laporan laba rugi, dan perubahan modal dapat disusun secara benar.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Pengelompokan Akun dan Sifatnya
                    </h2>
                    
                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Pengelompokan Akun</h3>
                    <p class="text-gray-700 mb-2">
                        Akun dibagi menjadi lima kelompok besar yang merupakan dasar dari penyusunan laporan keuangan:
                    </p>
                    <ul class="list-disc list-inside space-y-1 font-semibold text-gray-800 ml-4 mb-4">
                        <li>Aset (Harta)</li>
                        <li>Kewajiban (Hutang)</li>
                        <li>Modal (Ekuitas)</li>
                        <li>Pendapatan</li>
                        <li>Beban (Biaya)</li>
                    </ul>

                    <div class="grid md:grid-cols-2 gap-6 mt-6">
                        <div class="bg-green-50 p-5 rounded-lg shadow-md border-l-4 border-green-600">
                            <h4 class="text-lg font-bold text-green-700 mb-2">3. Akun Aset (Harta)</h4>
                            <p class="text-sm text-gray-700">Kekayaan yang dimiliki perusahaan. Contoh: Kas, Piutang, Peralatan.</p>
                            <p class="text-sm font-bold text-green-800 mt-2">Ciri Penting: Bertambah di sisi <span class="font-extrabold">Debet</span> dan berkurang di Kredit.</p>

                            <h4 class="text-lg font-bold text-green-700 mb-2 mt-4">7. Akun Beban (Biaya)</h4>
                            <p class="text-sm text-gray-700">Pengorbanan untuk operasional (mengurangi laba). Contoh: Beban Gaji, Beban Sewa.</p>
                            <p class="text-sm font-bold text-green-800 mt-2">Ciri Penting: Bertambah di sisi <span class="font-extrabold">Debet</span> dan berkurang di Kredit.</p>
                        </div>

                        <div class="bg-red-50 p-5 rounded-lg shadow-md border-l-4 border-red-600">
                            <h4 class="text-lg font-bold text-red-700 mb-2">4. Akun Kewajiban (Hutang)</h4>
                            <p class="text-sm text-gray-700">Tanggungan perusahaan kepada pihak lain. Contoh: Hutang Usaha, Hutang Bank.</p>
                            <p class="text-sm font-bold text-red-800 mt-2">Ciri Penting: Bertambah di sisi <span class="font-extrabold">Kredit</span> dan berkurang di Debet.</p>

                            <h4 class="text-lg font-bold text-red-700 mb-2 mt-4">5. Akun Modal (Ekuitas)</h4>
                            <p class="text-sm text-gray-700">Hak kepemilikan pemilik. Contoh: Modal Pemilik, Prive.</p>
                            <p class="text-sm font-bold text-red-800 mt-2">Ciri Penting: Bertambah di sisi <span class="font-extrabold">Kredit</span> dan berkurang di Debet.</p>

                            <h4 class="text-lg font-bold text-red-700 mb-2 mt-4">6. Akun Pendapatan</h4>
                            <p class="text-sm text-gray-700">Pemasukan dari kegiatan operasional (meningkatkan modal). Contoh: Pendapatan Jasa, Pendapatan Penjualan.</p>
                            <p class="text-sm font-bold text-red-800 mt-2">Ciri Penting: Bertambah di sisi <span class="font-extrabold">Kredit</span> dan berkurang di Debet.</p>
                        </div>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Fungsi Akun dan Kode Akun
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">8. Fungsi Akun</h3>
                    <p class="text-gray-700 mb-2">
                        Akun berfungsi sangat penting dalam dunia akuntansi, yaitu:
                    </p>
                    <ul class="list-disc list-inside space-y-1 text-gray-600 ml-4 mb-4">
                        <li>Mengelompokkan transaksi sesuai jenisnya</li>
                        <li>Membantu pencatatan lebih terstruktur dan mempermudah analisis</li>
                        <li>Menjadi dasar penyusunan laporan keuangan</li>
                        <li>Menyediakan informasi rinci mengenai perubahan keuangan perusahaan</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">9. Kode Akun (Chart of Accounts)</h3>
                    <p class="text-gray-700 mb-2">
                        Chart of Accounts adalah daftar lengkap dari seluruh akun yang digunakan perusahaan, masing-masing memiliki <span class="font-semibold">nomor atau kode akun</span> agar mudah ditemukan dan dicatat dalam sistem.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Pola umum pengkodean: <code>1xxx</code> Aset, <code>2xxx</code> Kewajiban, <code>3xxx</code> Modal, <code>4xxx</code> Pendapatan, <code>5xxx</code>Beban.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        10. Saldo Normal Akun
                    </h2>
                    <p class="text-gray-700 mb-4">
                        Saldo Normal adalah posisi di mana akun tersebut secara normal <span class="font-semibold">bertambah</span>. Pemahaman ini menjadi dasar utama dalam pencatatan jurnal.
                    </p>
                    
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Kelompok Akun</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 uppercase tracking-wider">Posisi Bertambah</th>
                                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">Bertambah di Sisi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">Aset</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">Bertambah</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center bg-green-50 font-extrabold">Debet</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">Beban</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600 font-bold">Bertambah</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center bg-green-50 font-extrabold">Debet</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">Kewajiban</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-red-600 font-bold">Bertambah</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center bg-red-50 font-extrabold">Kredit</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">Modal</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-red-600 font-bold">Bertambah</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center bg-red-50 font-extrabold">Kredit</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold">Pendapatan</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-red-600 font-bold">Bertambah</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center bg-red-50 font-extrabold">Kredit</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-gray-700 italic mt-2">
                        Ringkasan: Aset dan Beban bertambah di Debet Kewajiban, Modal, dan Pendapatan bertambah di Kredit.
                    </p>
                    <!-- REFERENSI VIDEO AKUNTANSI – MATERI 3 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-100 text-green-600">
                                <i class="fas fa-balance-scale"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Saldo Normal Akun (Akuntansi Materi 3)
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami saldo normal akun dalam akuntansi — termasuk cara menentukan
                            debit dan kredit pada setiap jenis akun — bagian dari <b>Akuntansi Materi 3</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/YVHjvsacw2A"
                                title="Memahami Saldo Normal Akun dalam Akuntansi"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/YVHjvsacw2A"
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
                <!-- Konten materi 4 (ditampilkan jika materi aktif) -->
                <div id="materi-4" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 4) ? '' : 'hidden' ?>">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Jurnal Umum Akuntansi 📝
                    </h2>

                    <h3 class="text-2xl font-bold text-blue-700 mb-4 mt-6">1. Pengertian Jurnal Umum</h3>
                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Jurnal Umum adalah tempat pertama untuk mencatat semua transaksi keuangan yang terjadi dalam perusahaan. Pencatatan di jurnal umum dilakukan secara kronologis, artinya berdasarkan urutan waktu terjadinya transaksi.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Jurnal Umum berfungsi sebagai buku harian perusahaan yang berisi catatan awal sebelum transaksi tersebut diposting ke buku besar.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Setiap transaksi yang terjadi—baik pembelian, penjualan, pembayaran, maupun penerimaan uang—harus masuk terlebih dahulu ke dalam jurnal umum untuk memastikan tidak ada transaksi yang terlewat.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        2. Fungsi Jurnal Umum
                    </h2>

                    <p class="text-gray-700 mb-4">
                        Jurnal umum memiliki beberapa fungsi penting, yaitu:
                    </p>
                    
                    <ol class="list-alpha list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>Mencatat transaksi secara sistematis
                            <p class="text-sm italic ml-6 mt-1">Semua transaksi perusahaan dicatat lengkap dengan tanggal, akun yang terlibat, nominal, dan keterangan.</p>
                        </li>
                        <li>Menyediakan catatan rinci
                            <p class="text-sm italic ml-6 mt-1">Setiap transaksi dijelaskan secara lengkap sehingga memudahkan pemeriksaan atau audit.</p>
                        </li>
                        <li>Menjadi dasar untuk posting ke Buku Besar
                            <p class="text-sm italic ml-6 mt-1">Setelah dicatat di jurnal umum, transaksi akan dipindahkan (posting) ke Buku Besar agar setiap akun terupdate dengan benar.</p>
                        </li>
                        <li>Menghindari kesalahan pencatatan
                            <p class="text-sm italic ml-6 mt-1">Karena semua transaksi masuk ke tempat yang sama sebelum diposting, jurnal umum membantu mencegah data keuangan hilang atau tercatat ganda.</p>
                        </li>
                    </ol>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        3. Prinsip Debet dan Kredit
                    </h2>
                    
                    <p class="text-gray-700 mb-2">
                        Dalam akuntansi, setiap transaksi selalu melibatkan dua sisi:
                    </p>
                    <ul class="list-disc list-inside font-semibold text-gray-800 ml-4 mb-4">
                        <li>Debet (Dr)</li>
                        <li>Kredit (Cr)</li>
                    </ul>
                    <p class="text-gray-700 mb-2">
                        Prinsip ini disebut double-entry system, yang berarti setiap transaksi akan mempengaruhi minimal dua akun.
                    </p>
                    <p class="text-gray-700 mb-2">
                        Contohnya:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-6 mb-4">
                        <li>Ketika membeli perlengkapan secara tunai: perlengkapan bertambah (debet), kas berkurang (kredit).</li>
                        <li>Ketika menerima pendapatan tunai: kas bertambah (debet), pendapatan bertambah (kredit).</li>
                    </ul>
                    <div class="bg-indigo-50 p-4 rounded-lg shadow-md my-4">
                        <p class="font-bold text-indigo-700 text-center">
                            Prinsip utama yang harus diingat: Total Debet selalu harus sama dengan total Kredit setiap transaksi.
                        </p>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        4. Format Jurnal Umum dan 6. Aturan Penulisan Akun
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">4. Format Jurnal Umum</h3>
                    <p class="text-gray-700 mb-2">
                        Jurnal umum memiliki format standar yang berisi:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Tanggal transaksi</li>
                        <li>Nama Akun yang didebet</li>
                        <li>Nama Akun yang dikredit</li>
                        <li>Nominal debet dan kredit</li>
                        <li>Keterangan transaksi</li>
                    </ul>
                    
                    <h3 class="text-xl font-bold text-blue-700 mb-4">6. Aturan Penulisan Akun</h3>
                    <p class="text-gray-700 mb-2">
                        Ada aturan khusus dalam menulis akun di jurnal umum:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Akun Debet ditulis terlebih dahulu tanpa indent.</li>
                        <li>Akun Kredit ditulis di bawahnya dengan indent atau menjorok ke kanan.</li>
                        <li>Nominal debet dan kredit ditulis pada kolom masing-masing.</li>
                        <li>Keterangan ditulis di bagian bawah atau samping sesuai format.</li>
                    </ul>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-inner">
                        <h4 class="font-semibold text-gray-700 mb-2">Contoh Penulisan (dengan Indent):</h4>
                        <pre class="bg-white p-3 rounded text-sm overflow-x-auto">
                            Tanggal: 01 Januari 2025
                            Perlengkapan ...................... 500.000   (Debet)
                                Kas ........................... 500.000   (Kredit)
                            (Pembelian perlengkapan tunai)
                        </pre>
                        <p class="text-sm text-gray-600 mt-2">Indent pada akun kredit ini membedakan kedua posisi sehingga mudah dilihat oleh pembaca.</p>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        5. Pencatatan Bertanggal (Kronologis)
                    </h2>
                    
                    <p class="text-gray-700 mb-2">
                        Dalam jurnal umum, pencatatan harus dilakukan berdasarkan urutan waktu atau kronologis.
                    </p>
                    <p class="text-gray-700 mb-2">
                        Tujuannya:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>memudahkan pelacakan transaksi,</li>
                        <li>melihat aktivitas keuangan harian perusahaan,</li>
                        <li>menjaga laporan tetap rapi dan terstruktur.</li>
                    </ul>
                    <p class="text-gray-700 mb-4">
                        Tidak boleh ada pencatatan yang disusun acak karena akan membingungkan saat proses posting dan penyusunan laporan.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        7. Transaksi yang Dicatat & 8. Dokumen Sumber
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">7. Transaksi yang Dicatat di Jurnal Umum</h3>
                    <p class="text-gray-700 mb-2">
                        Semua jenis transaksi keuangan dicatat ke jurnal umum, antara lain:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Pembelian barang atau perlengkapan</li>
                        <li>Penjualan barang atau jasa</li>
                        <li>Pembayaran kas (gaji, listrik, hutang, sewa)</li>
                        <li>Penerimaan kas (pendapatan, pelunasan piutang)</li>
                        <li>Transaksi beban operasional</li>
                        <li>Penambahan modal</li>
                        <li>Pengambilan pribadi (prive)</li>
                    </ul>
                    <p class="text-gray-700 mb-4">
                        Tidak ada transaksi keuangan yang boleh langsung masuk ke buku besar tanpa melalui jurnal umum terlebih dahulu.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">8. Dokumen Sumber</h3>
                    <p class="text-gray-700 mb-2">
                        Sebelum mencatat transaksi ke jurnal umum, akuntan harus melihat bukti transaksi asli yang disebut dokumen sumber.
                    </p>
                    <p class="text-gray-700 mb-2">
                        Dokumen ini menjadi dasar dan bukti bahwa transaksi benar-benar terjadi.
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Nota / kwitansi</li>
                        <li>Faktur penjualan atau pembelian</li>
                        <li>Bukti kas masuk</li>
                        <li>Bukti kas keluar</li>
                        <li>Bukti setoran bank</li>
                        <li>Bukti memorial</li>
                        <li>Bukti transfer</li>
                    </ul>
                    <p class="text-gray-700 mb-4">
                        Dokumen sumber memastikan pencatatan tidak dilakukan secara sembarangan.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        9. Manfaat Jurnal Umum & 10. Contoh Pencatatan
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">9. Manfaat Jurnal Umum</h3>
                    <p class="text-gray-700 mb-2">
                        Jurnal umum memiliki sejumlah manfaat penting bagi perusahaan:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Menjadi bukti pertama bahwa suatu transaksi telah dicatat.</li>
                        <li>Memudahkan proses posting ke buku besar.</li>
                        <li>Memberikan catatan transaksi yang lengkap, jelas, dan kronologis.</li>
                        <li>Mempermudah proses audit, pengecekan, dan pembuatan laporan.</li>
                        <li>Membantu akuntan memahami alur transaksi secara logis.</li>
                    </ul>
                    <p class="text-gray-700 mb-4">
                        Tanpa jurnal umum, pencatatan akuntansi akan kacau dan sulit ditelusuri.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">10. Contoh Pencatatan Sederhana</h3>
                    <div class="bg-green-50 p-4 rounded-lg shadow-md">
                        <h4 class="font-semibold text-green-700 mb-2">Transaksi:</h4>
                        <p class="text-green-800 italic mb-3">Pembelian perlengkapan tunai sebesar Rp500.000.</p>
                        
                        <h5 class="font-bold text-green-700">Pencatatan Jurnal Umum:</h5>
                        <pre class="bg-white p-3 rounded text-sm overflow-x-auto mt-2">
                            01 Januari 2025
                            Perlengkapan .................... 500.000
                                Kas .................................. 500.000
                            (Pembelian perlengkapan secara tunai)
                        </pre>
                        <h5 class="font-bold text-green-700 mt-3">Penjelasan:</h5>
                        <p class="text-sm text-gray-700">
                            Perlengkapan bertambah Debet<br>
                            Kas berkurang Kredit
                        </p>
                    </div>
                    <!-- REFERENSI VIDEO AKUNTANSI – MATERI 4 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-100 text-red-600">
                                <i class="fas fa-book"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Penyusunan Jurnal Umum (Akuntansi Materi 4)
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk belajar cara menyusun jurnal umum — langkah awal dalam pencatatan transaksi akuntansi yang benar dan sistematis, cocok untuk <b>Akuntansi Materi 4</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/yQTKIDDHtAg"
                                title="Latihan Menyusun Jurnal Umum Akuntansi"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/yQTKIDDHtAg"
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
                <!-- Konten materi 5 (ditampilkan jika materi aktif) -->
                <div id="materi-5" class="materi-content p-8 rounded-lg shadow-xl glass-effect <?= ((int)$materi_id_aktif === 5) ? '' : 'hidden' ?>">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Buku Besar (Ledger) dan Neraca Saldo 📚
                    </h2>

                    <h3 class="text-2xl font-bold text-blue-700 mb-4 mt-6">1. Pengertian Buku Besar</h3>
                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Buku Besar adalah <span class="font-semibold">kumpulan seluruh akun</span> yang digunakan perusahaan, yang berisi ringkasan transaksi yang sudah dipindahkan (diposting) dari jurnal umum.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Jika jurnal umum adalah buku harian, maka buku besar adalah buku induk yang merangkum semua transaksi berdasarkan jenis akunnya.
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Setiap akun dalam buku besar menunjukkan:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>perubahan yang terjadi,</li>
                        <li>posisi debet/kredit, dan</li>
                        <li>saldo akhir yang digunakan untuk laporan keuangan.</li>
                    </ul>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        2. Fungsi dan 6. Tujuan Buku Besar
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">Fungsi Utama Buku Besar:</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Mengetahui saldo akhir setiap akun</span>: Misalnya saldo kas berapa, saldo hutang berapa, saldo perlengkapan tersisa berapa.</li>
                        <li><span class="font-semibold">Mengelompokkan transaksi berdasarkan akun</span>: Sehingga lebih mudah menganalisis perubahan pada tiap unsur keuangan.</li>
                        <li><span class="font-semibold">Menjadi dasar dalam membuat laporan keuangan</span>: Contohnya Neraca, Laba Rugi, dan Perubahan Modal.</li>
                        <li><span class="font-semibold">Mengecek keakuratan posting dari jurnal umum</span>: Jika ada kesalahan pencatatan di jurnal umum, biasanya terlihat pada saldo akun.</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">Tujuan Utama Buku Besar:</h3>
                    <p class="text-gray-700 mb-2">
                        Tujuan utama buku besar adalah membuat perusahaan lebih mudah:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>melihat total debet dan kredit setiap akun,</li>
                        <li>mengetahui saldo akhir setiap akun,</li>
                        <li>menyiapkan data untuk penyusunan laporan keuangan,</li>
                        <li>memastikan setiap akun tercatat rapi dan tidak bercampur.</li>
                    </ul>
                    <p class="text-gray-700 italic">
                        Tanpa buku besar, pencatatan perusahaan akan berantakan dan sulit diperiksa.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        3. Posting dan 4. Bentuk Buku Besar
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">3. Posting</h3>
                    <p class="text-gray-700 mb-2">
                        Posting adalah proses <span class="font-semibold">memindahkan transaksi dari jurnal umum ke akun masing-masing di buku besar</span>.
                    </p>
                    <p class="text-gray-700 mb-2">
                        Misalnya di jurnal tertulis:
                    </p>
                    <blockquote class="border-l-4 border-indigo-400 pl-4 py-2 my-2 bg-indigo-50 text-indigo-800 italic">
                        Perlengkapan (Debet) <br>
                        Kas (Kredit)
                    </blockquote>
                    <p class="text-gray-700 mb-4">
                        Maka postingnya:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Di akun Perlengkapan $\rightarrow$ catat di sisi Debet</li>
                        <li>Di akun Kas $\rightarrow$ catat di sisi Kredit</li>
                    </ul>
                    <p class="text-gray-700 font-semibold italic">
                        Posting harus dilakukan dengan hati-hati karena salah memindah akan menyebabkan saldo akun mendadak salah.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">4. Bentuk Buku Besar</h3>
                    <p class="text-gray-700 mb-2">
                        Ada beberapa bentuk tampilan Buku Besar, namun yang paling umum:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4 space-y-2">
                        <li><span class="font-semibold">T-Account (bentuk huruf T)</span>: Sederhana dan cocok untuk belajar dasar.
                            <pre class="bg-white p-2 rounded text-sm overflow-x-auto mt-1">
                            Perlengkapan
                            Debet | Kredit
                            </pre>
                        </li>
                        <li><span class="font-semibold">Bentuk Skontro (dua kolom seimbang)</span>: Digunakan pada pembukuan nyata di perusahaan.
                            <pre class="bg-white p-2 rounded text-sm overflow-x-auto mt-1">Tanggal | Keterangan | Ref | Debet | Kredit | Saldo</pre>
                        </li>
                        <li><span class="font-semibold">Bentuk Running Balance</span>: Saldo dihitung setiap transaksi.</li>
                    </ul>
                    <p class="text-gray-700 italic">
                        Semua bentuk pada dasarnya memiliki fungsi sama: menunjukkan posisi debet dan kredit dari setiap akun.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">5. Isi Buku Besar</h3>
                    <p class="text-gray-700 mb-2">
                        Buku besar memiliki kolom sebagai berikut:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Tanggal kapan transaksi diposting</li>
                        <li>Keterangan ringkasan transaksi</li>
                        <li>Ref (Referensi) nomor halaman jurnal (J1, J2, dst)</li>
                        <li>Debet jumlah yang masuk sisi debet</li>
                        <li>Kredit jumlah yang masuk sisi kredit</li>
                        <li>Saldo hasil perhitungan akhir setelah transaksi</li>
                    </ul>
                    <p class="text-gray-700">
                        Dengan data ini, perusahaan dapat mengetahui secara akurat posisi keuangannya.
                    </p>

                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 mt-8 border-b-4 border-red-500 pb-2">
                        Neraca Saldo (Trial Balance) 📝
                    </h2>

                    <h3 class="text-xl font-bold text-red-700 mb-4">1. Pengertian Neraca Saldo</h3>
                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Neraca Saldo adalah <span class="font-semibold">daftar seluruh akun yang terdapat di Buku Besar beserta saldonya</span> (baik saldo debet maupun kredit).
                    </p>
                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Neraca saldo digunakan untuk memastikan bahwa total debet dan total kredit adalah sama sebagai hasil dari sistem pencatatan berpasangan (*double entry*).
                    </p>
                    
                    <h3 class="text-xl font-bold text-red-700 mb-4 mt-6">2. Tujuan Neraca Saldo</h3>
                    <p class="text-gray-700 mb-2">
                        Tujuan utama neraca saldo yaitu:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Memastikan jumlah Debet = Kredit</span>: Jika tidak seimbang, berarti ada kesalahan dalam proses pencatatan di jurnal umum, posting ke buku besar, atau perhitungan saldo akun.</li>
                        <li><span class="font-semibold">Menjadi dasar penyusunan laporan keuangan</span>: Laporan seperti Laporan Laba Rugi, Neraca, dan Laporan Perubahan Modal bersumber dari neraca saldo.</li>
                    </ul>

                    <h3 class="text-xl font-bold text-red-700 mb-4 mt-6">3. Waktu Penyusunan</h3>
                    <p class="text-gray-700 mb-2">
                        Neraca saldo dibuat <span class="font-semibold">setelah semua transaksi bulan tersebut diposting ke Buku Besar</span>.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Biasanya disusun: di akhir periode (bulanan), atau menjelang penyusunan laporan keuangan.
                    </p>

                    <h3 class="text-xl font-bold text-red-700 mb-4 mt-6">4. Isi Neraca Saldo</h3>
                    <p class="text-gray-700 mb-2">
                        Neraca saldo terdiri dari:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Nama Akun</li>
                        <li>Nomor Kode Akun</li>
                        <li>Saldo Debet</li>
                        <li>Saldo Kredit</li>
                    </ul>
                    <div class="bg-red-100 p-4 rounded-lg shadow-inner">
                        <h4 class="font-semibold text-red-700 mb-2">Contoh isi sederhana:</h4>
                        <pre class="bg-white p-3 rounded text-sm overflow-x-auto">
                        Kas ...................... 10.000.000   (Debet)
                        Hutang Usaha ............  2.000.000   (Kredit)
                        Modal ....................  5.000.000   (Kredit)
                        </pre>
                    </div>

                    <h3 class="text-xl font-bold text-red-700 mb-4 mt-6">5. Fungsi Utama</h3>
                    <p class="text-gray-700 mb-2">
                        Neraca saldo memiliki beberapa fungsi penting:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Dasar untuk jurnal penyesuaian</span>: Tanpa neraca saldo, akuntan tidak bisa menentukan akun mana yang perlu disesuaikan.</li>
                        <li><span class="font-semibold">Mendeteksi kesalahan teknis</span>: Misalnya: posting terbalik, jumlah salah hitung, akun tidak terposting, salah menempatkan debet atau kredit.</li>
                        <li><span class="font-semibold">Mempermudah penyusunan laporan keuangan</span>: Karena semua saldo akun sudah terkumpul dalam satu tabel.</li>
                    </ul>

                    <h3 class="text-xl font-bold text-red-700 mb-4 mt-6">6. Manfaat Neraca Saldo</h3>
                    <p class="text-gray-700 mb-2">
                        Beberapa manfaat penting neraca saldo:
                    </p>
                    <ul class="list-disc list-inside text-gray-600 ml-4 mb-4">
                        <li>Mengetahui posisi keuangan perusahaan sebelum disesuaikan.</li>
                        <li>Menjadi alat pengecekan sederhana apakah sistem *double entry* bekerja dengan benar.</li>
                        <li>Mempermudah proses audit dan pemeriksaan.</li>
                        <li>Menyajikan data akun lengkap kepada akuntan.</li>
                    </ul>
                    <!-- REFERENSI VIDEO AKUNTANSI – MATERI 5 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Siklus Akuntansi Lengkap (Akuntansi Materi 5)
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami seluruh siklus akuntansi — dimulai dari jurnal umum, buku besar, neraca saldo, 
                            jurnal penyesuaian, neraca lajur (work sheet), hingga penyusunan laporan keuangan — sebagai bagian dari <b>Akuntansi Materi 5</b>.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/hD9jHl9bY4w"
                                title="Jurnal Umum, Buku Besar, Neraca Saldo, Jurnal Penyesuaian, Work Sheet"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/hD9jHl9bY4w"
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
    <!-- START BOTTOM NAVIGATION BAR (Mobile Only) -->
    <?php require_once __DIR__ . '/../../../private/nav-bottom.php';?>


    <script src="../../../assets/js/materi_dasar.js"></script>
</html>