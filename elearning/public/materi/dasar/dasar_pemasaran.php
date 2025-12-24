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
                        1 => "Pengertian dan Konsep Dasar Pemasaran", 
                        2 => "Bauran Pemasaran (Marketing Mix – 4P)", 
                        3 => "Segmentasi, Targeting, dan Positioning (STP)", 
                        4 => "Perilaku Konsumen", 
                        5 => "Strategi Pemasaran Modern (Digital Marketing)"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-red-500 pb-2">
                        Pengantar Pemasaran 📢
                    </h2>

                    <h3 class="text-2xl font-bold text-red-700 mb-4 mt-6">1. Pengertian Pemasaran</h3>
                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Pemasaran adalah rangkaian kegiatan yang dilakukan oleh individu atau organisasi untuk mengenal, menciptakan, dan menyampaikan nilai kepada pelanggan serta membangun hubungan yang saling menguntungkan.
                    </p>
                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Pemasaran mencakup riset pasar, perencanaan produk, penetapan harga, promosi, distribusi, pelayanan purna jual, dan manajemen hubungan pelanggan. Tujuan akhirnya adalah <span class="font-semibold">memenuhi kebutuhan konsumen sambil mencapai tujuan organisasi</span>, seperti penjualan, profit, atau pertumbuhan pasar.
                    </p>
                    <blockquote class="border-l-4 border-red-400 pl-4 py-2 my-4 bg-red-50 text-red-800 italic">
                        Intinya: pemasaran bukan sekadar menjual — tetapi proses memahami pelanggan, merancang solusi (produk/jasa), dan menyampaikannya dengan cara yang membuat pelanggan puas dan mau kembali.
                    </blockquote>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        2. Kebutuhan, Keinginan, dan Permintaan
                    </h2>
                    <p class="text-gray-700 mb-4">
                        Ini tiga konsep dasar yang membentuk dasar pemasaran.
                    </p>

                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">Kebutuhan (Needs)</h4>
                            <p class="text-sm text-gray-700">
                                Kondisi dasar yang diperlukan manusia untuk bertahan hidup atau merasa nyaman (mis. pangan, sandang, papan, rasa aman). Kebutuhan bersifat fundamental dan universal.
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">Keinginan (Wants)</h4>
                            <p class="text-sm text-gray-700">
                                Bentuk kebutuhan yang dipengaruhi budaya, pribadi, dan lingkungan (mis. seseorang butuh makanan — keinginannya makan pizza). Keinginan lebih bersifat spesifik dan variatif antar individu.
                            </p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-md border-l-4 border-indigo-400">
                            <h4 class="font-semibold text-indigo-700 mb-1">Permintaan (Demands)</h4>
                            <p class="text-sm text-gray-700">
                                Keinginan yang <span class="font-semibold">didukung kemampuan membeli</span>. Jika banyak orang menginginkan produk dan mampu membelinya, terbentuk permintaan pasar (mis. permintaan *smartphone* tertentu).
                            </p>
                        </div>
                    </div>
                    <p class="text-gray-700 mt-4 italic font-semibold">
                        Hubungan singkat: kebutuhan $\rightarrow$ keinginan (bentuk) $\rightarrow$ permintaan (keinginan + daya beli).
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        3. Nilai, Kepuasan, dan Loyalitas Pelanggan
                    </h2>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div class="bg-yellow-50 p-4 rounded-lg shadow-sm border-t-4 border-yellow-500">
                            <h4 class="text-lg font-bold text-yellow-700 mb-2">Nilai (Value)</h4>
                            <p class="text-sm text-gray-700">
                                Persepsi pelanggan tentang <span class="font-semibold">manfaat yang diterima dibandingkan biaya yang dikeluarkan</span>. Nilai = manfaat / biaya (termasuk waktu, tenaga, risiko).
                            </p>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg shadow-sm border-t-4 border-green-500">
                            <h4 class="text-lg font-bold text-green-700 mb-2">Kepuasan (Satisfaction)</h4>
                            <p class="text-sm text-gray-700">
                                Tingkat perasaan pelanggan setelah membandingkan <span class="font-semibold">kinerja produk/jasa dengan harapannya</span>. Jika kinerja $\ge$ harapan $\rightarrow$ puas.
                            </p>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg shadow-sm border-t-4 border-blue-500">
                            <h4 class="text-lg font-bold text-blue-700 mb-2">Loyalitas (Loyalty)</h4>
                            <p class="text-sm text-gray-700">
                                Keputusan pelanggan untuk <span class="font-semibold">tetap memilih/ membeli merek yang sama berulang kali</span>. Pelanggan loyal sering menjadi promotor merek.
                            </p>
                        </div>
                    </div>

                    <blockquote class="border-l-4 border-gray-400 pl-4 py-2 my-4 bg-gray-100 text-gray-700 italic">
                        Catatan praktis: strategi pemasaran yang efektif fokus pada menciptakan nilai sehingga menghasilkan kepuasan, yang pada akhirnya membangun loyalitas.
                    </blockquote>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        4. Produk sebagai Pemenuhan Kebutuhan
                    </h2>
                    <p class="text-gray-700 mb-2">
                        Produk di pemasaran tidak hanya barang fisik, tetapi juga jasa, ide, pengalaman, atau kombinasi dari itu. Fungsi utama produk adalah <span class="font-semibold">memecahkan masalah atau memenuhi kebutuhan/keinginan konsumen</span>.
                    </p>

                    <h4 class="text-xl font-semibold text-red-600 mb-2 mt-4">Elemen Penting Produk:</h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Manfaat inti (core benefit)</span>: alasan utama orang membeli (mis. kenyamanan transportasi).</li>
                        <li><span class="font-semibold">Produk nyata (actual product)</span>: fitur, desain, kualitas, merek, kemasan.</li>
                        <li><span class="font-semibold">Produk tambahan (augmented product)</span>: layanan purna jual, garansi, pengiriman, layanan pelanggan.</li>
                    </ul>
                    <p class="text-gray-700 mb-4">
                        Dalam pengembangan produk, perusahaan perlu mempertimbangkan segmentasi pasar dan preferensi pengguna agar produk relevan.
                    </p>
                    <div class="bg-red-50 p-3 rounded-lg text-sm text-red-800">
                        Contoh: sepeda sebagai produk: <br>
                        - Core benefit: transportasi dan olahraga.<br>
                        - Actual product: frame, gear, warna, merek.<br>
                        - Augmented: garansi, service gratis, aksesori.
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        5. Tujuan Utama Pemasaran
                    </h2>

                    <p class="text-gray-700 mb-2">
                        Tujuan pemasaran bisa bersifat komersial maupun non-komersial, antara lain:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-700 ml-4 mb-4">
                        <li><span class="font-semibold">Memenuhi kebutuhan dan keinginan pelanggan</span>: Menyediakan produk/jasa yang relevan dan bernilai.</li>
                        <li><span class="font-semibold">Menciptakan nilai dan membangun kepuasan pelanggan</span>: Menjaga kualitas dan pengalaman pelanggan agar terpuaskan.</li>
                        <li><span class="font-semibold">Meningkatkan penjualan dan pangsa pasar</span>: Strategi produk, harga, promosi, distribusi diarahkan untuk meningkatkan penjualan.</li>
                        <li><span class="font-semibold">Mencapai keuntungan dan pertumbuhan bisnis</span>: Pemasaran yang efektif mendorong profitabilitas dan ekspansi.</li>
                        <li><span class="font-semibold">Membangun merek (brand) dan reputasi</span>: Citra merek yang kuat memudahkan pemasaran jangka panjang.</li>
                        <li><span class="font-semibold">Menciptakan hubungan jangka panjang dengan pelanggan</span>: Fokus pada retensi pelanggan, bukan hanya transaksi sekali beli.</li>
                        <li><span class="font-semibold">Menghasilkan diferensiasi kompetitif</span>: Menonjolkan keunikan agar tidak mudah ditiru pesaing.</li>
                        <li><span class="font-semibold">Memberikan kontribusi sosial / edukasi</span>: Untuk organisasi non-profit atau kampanye publik: tujuan bisa edukasi, perubahan perilaku, dll.</li>
                    </ul>
                    <!-- REFERENSI VIDEO PEMASARAN – MATERI 1 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Manajemen Pemasaran: Definisi & Proses
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami pengertian pemasaran dan proses yang terlibat dalam manajemen pemasaran.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/m4vn21468oQ"
                                title="MANAJEMEN PEMASARAN : Definisi & Proses"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/m4vn21468oQ"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-yellow-500 pb-2">
                        Bauran Pemasaran (Marketing Mix – 4P) 🤝
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Bauran pemasaran adalah <span class="font-semibold">kombinasi strategi pemasaran</span> yang digunakan perusahaan untuk mempengaruhi keputusan konsumen. Konsep 4P terdiri dari Product, Price, Place, dan Promotio. Keempatnya saling berhubungan dan harus dirancang secara seimbang agar sebuah produk dapat diterima oleh pasar.
                    </p>

                    <div class="space-y-8 mt-8">
                        
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-500">
                            <h3 class="text-2xl font-bold text-blue-700 mb-4">1. Product (Produk) 🎁</h3>
                            <p class="text-gray-700 mb-4">
                                Produk adalah segala sesuatu yang ditawarkan untuk memenuhi kebutuhan atau keinginan pelanggan. Produk tidak hanya berupa barang fisik, tetapi juga jasa, layanan, pengalaman, atau kombinasi dari semuanya.
                            </p>

                            <h4 class="text-lg font-semibold text-blue-600 mb-2">Unsur penting dalam Product:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-2">
                                <li><span class="font-semibold">Kualitas</span>: Menunjukkan tingkat keawetan, kenyamanan, kinerja, dan kepercayaan terhadap produk. Kualitas yang baik akan meningkatkan nilai dan kepuasan pelanggan.</li>
                                <li><span class="font-semibold">Desain</span>: Meliputi bentuk, warna, ergonomi, estetika, dan kenyamanan penggunaan. Desain yang menarik dapat membuat produk lebih mudah dikenali dan diingat.</li>
                                <li><span class="font-semibold">Fitur</span>: Fungsi atau kemampuan tambahan yang membuat produk berbeda dengan produk lain. Semakin relevan fitur, semakin tinggi daya tarik produk.</li>
                                <li><span class="font-semibold">Kemasan</span>: Bagian luar produk yang melindungi isi sekaligus berfungsi sebagai identitas visual. Kemasan yang baik juga bisa memberikan pengalaman *unboxing* yang lebih menyenangkan.</li>
                            </ul>
                            <p class="text-gray-800 italic mt-3">
                                Tujuan Product: memberikan solusi terbaik bagi konsumen dan membangun identitas yang kuat.
                            </p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500">
                            <h3 class="text-2xl font-bold text-green-700 mb-4">2. Price (Harga) 💰</h3>
                            <p class="text-gray-700 mb-4">
                                Harga adalah sejumlah nilai atau uang yang harus dibayar oleh konsumen untuk mendapatkan produk atau jasa. Harga sangat memengaruhi keputusan pembelian karena berhubungan langsung dengan daya beli pelanggan.
                            </p>

                            <h4 class="text-lg font-semibold text-green-600 mb-2">Komponen Price:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-2">
                                <li><span class="font-semibold">Strategi Harga</span>: Menentukan cara penetapan harga seperti harga premium, harga ekonomis, harga psikologis, atau harga penetrasi pasar.</li>
                                <li><span class="font-semibold">Diskon</span>: Potongan harga untuk menarik perhatian, meningkatkan penjualan, atau menghabiskan stok barang tertentu. Diskon juga dapat digunakan untuk strategi musiman atau *event* tertentu.</li>
                                <li><span class="font-semibold">Harga Kompetitif</span>: Menyesuaikan harga dengan kompetitor agar produk tetap bersaing di pasar. Biasanya dilakukan dengan riset harga pesaing dan segmentasi pasar.</li>
                            </ul>
                            <p class="text-gray-800 italic mt-3">
                                Tujuan Price: mendapatkan keuntungan sekaligus tetap terjangkau bagi target pasar.
                            </p>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-red-500">
                            <h3 class="text-2xl font-bold text-red-700 mb-4">3. Place (Tempat/Distribusi) 📍</h3>
                            <p class="text-gray-700 mb-4">
                                Place berkaitan dengan bagaimana produk sampai ke tangan konsumen. Distribusi yang tepat akan memudahkan pelanggan menemukan dan membeli produk.
                            </p>

                            <h4 class="text-lg font-semibold text-red-600 mb-2">Bagian dari Place:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-2">
                                <li><span class="font-semibold">Distribusi</span>: Proses menyalurkan produk melalui agen, toko, *reseller*, distributor, atau pengiriman langsung. Distribusi yang baik membuat produk tersedia tepat waktu.</li>
                                <li><span class="font-semibold">Lokasi Penjualan</span>: Menentukan tempat yang strategis dan mudah dijangkau, seperti toko fisik, pusat perbelanjaan, kios, atau area yang ramai.</li>
                                <li><span class="font-semibold">Marketplace</span>: Di era digital, tempat penjualan juga mencakup platform seperti Tokopedia, Shopee, Lazada, atau *website* toko sendiri. *Marketplace* memudahkan transaksi *online* dan memperluas jangkauan pasar.</li>
                            </ul>
                            <p class="text-gray-800 italic mt-3">
                                Tujuan Place: mempermudah konsumen menemukan dan membeli produk dengan cepat dan nyaman.
                            </p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-500">
                            <h3 class="text-2xl font-bold text-yellow-700 mb-4">4. Promotion (Promosi) 📣</h3>
                            <p class="text-gray-700 mb-4">
                                Promosi adalah upaya untuk menginformasikan, menarik perhatian, dan membujuk konsumen agar tertarik membeli produk.
                            </p>

                            <h4 class="text-lg font-semibold text-yellow-600 mb-2">Bentuk-bentuk Promotion:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-2">
                                <li><span class="font-semibold">Iklan</span>: Bisa melalui TV, radio, brosur, *billboard*, atau iklan digital seperti Google Ads dan *banner website*.</li>
                                <li><span class="font-semibold">Media Sosial</span>: Menggunakan platform seperti Instagram, TikTok, Facebook, dan YouTube untuk membangun interaksi dengan audiens, membuat konten menarik, dan memperluas eksposur.</li>
                                <li><span class="font-semibold">Branding</span>: Upaya menciptakan identitas, karakter, warna, logo, dan citra produk agar mudah dikenali dan dipercaya.</li>
                                <li><span class="font-semibold">Event Promosi</span>: Kegiatan seperti *launching* produk, bazar, pameran, *giveaway*, atau *live shopping* untuk meningkatkan minat dan penjualan.</li>
                            </ul>
                            <p class="text-gray-800 italic mt-3">
                                Tujuan Promotion: meningkatkan kesadaran, menarik pembeli baru, serta mempertahankan pelanggan lama.
                            </p>
                        </div>

                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 mt-10 border-t pt-4">Kesimpulan</h3>
                    <p class="text-gray-700 mb-2">
                        Marketing Mix (4P) merupakan strategi yang saling melengkapi:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 ml-4 mb-4 font-semibold space-y-1">
                        <li><span class="text-blue-600">Product</span> menentukan apa yang ditawarkan.</li>
                        <li><span class="text-green-600">Price</span> menentukan nilai dan daya beli pelanggan.</li>
                        <li><span class="text-red-600">Place</span> menentukan di mana dan bagaimana produk dijual.</li>
                        <li><span class="text-yellow-600">Promotion</span> membantu menarik dan mempertahankan pelanggan.</li>
                    </ul>
                    <!-- REFERENSI VIDEO PEMASARAN – MATERI 2 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Materi 2 Pemasaran
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut sebagai penunjang pembelajaran <b>Materi 2 Pemasaran</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/ulMvQ7qT8Is"
                                title="Video Pembelajaran Materi 2 Pemasaran"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/ulMvQ7qT8Is"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-indigo-500 pb-2">
                        Segmentasi, Targeting, dan Positioning (STP) 🎯
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        STP adalah pendekatan pemasaran yang digunakan untuk <span class="font-semibold">memahami pasar secara lebih spesifik, memilih sasaran yang tepat, dan membentuk citra produk yang kuat di benak konsumen</span>. Dengan STP, perusahaan dapat menyusun strategi pemasaran yang lebih terarah dan efektif.
                    </p>

                    <div class="space-y-8 mt-8">
                        
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-indigo-500">
                            <h3 class="text-2xl font-bold text-indigo-700 mb-4">1. Segmentasi Pasar (Market Segmentation)</h3>
                            <p class="text-gray-700 mb-4">
                                Segmentasi pasar adalah proses <span class="font-semibold">membagi pasar yang luas menjadi kelompok-kelompok kecil</span> berdasarkan karakteristik tertentu. Tujuannya agar perusahaan dapat memahami kebutuhan setiap kelompok dengan lebih detail.
                            </p>

                            <h4 class="text-lg font-semibold text-indigo-600 mb-3">Segmen pasar dapat dibagi berdasarkan:</h4>
                            <ul class="list-disc list-inside text-gray-700 ml-4 space-y-3">
                                <li><span class="font-semibold">a. Usia</span>: Contoh segmen: anak-anak, remaja, dewasa, lansia. Setiap usia punya kebutuhan dan selera berbeda (misalnya mainan untuk anak, *skincare* untuk remaja, vitamin untuk lansia).</li>
                                <li><span class="font-semibold">b. Lokasi (Geografis)</span>: Berdasarkan wilayah: kota/desa, provinsi, negara, iklim. Misalnya pakaian hangat cocok untuk daerah dingin; produk pedas laris di wilayah tertentu.</li>
                                <li><span class="font-semibold">c. Minat (Psikografis)</span>: Berdasarkan gaya hidup, hobi, preferensi, atau kepribadian. Contoh: pecinta olahraga, penggemar teknologi, penyuka musik, *traveler*.</li>
                                <li><span class="font-semibold">d. Pendapatan (Ekonomi)</span>: Berdasarkan kemampuan membeli: rendah, menengah, menengah-ke-atas. Mempengaruhi penentuan harga: produk premium untuk konsumen *high-end*, produk ekonomis untuk segmen menengah.</li>
                            </ul>
                            <p class="text-gray-800 italic mt-4">
                                Inti segmentasi: memecah pasar besar menjadi kelompok yang lebih kecil agar strategi bisa disesuaikan.
                            </p>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-green-500">
                            <h3 class="text-2xl font-bold text-green-700 mb-4">2. Targeting (Menentukan Target Pasar)</h3>
                            <p class="text-gray-700 mb-4">
                                Targeting adalah proses <span class="font-semibold">memilih salah satu atau beberapa segmen pasar yang paling potensial</span> untuk dilayani oleh perusahaan.
                            </p>

                            <h4 class="text-lg font-semibold text-green-600 mb-3">Cara memilih target pasar:</h4>
                            <ul class="list-disc list-inside text-gray-700 ml-4 space-y-1">
                                <li>Ukuran segmen: apakah cukup besar untuk menguntungkan?</li>
                                <li>Pertumbuhan: apakah segmen tersebut berkembang?</li>
                                <li>Daya beli: apakah mereka mampu membeli produk?</li>
                                <li>Kompetisi: apakah kompetitornya sedikit atau banyak?</li>
                                <li>Kecocokan dengan sumber daya perusahaan: apakah perusahaan mampu melayani segmen tersebut?</li>
                            </ul>

                            <h4 class="text-lg font-semibold text-green-600 mb-3 mt-4">Tujuan Targeting:</h4>
                            <p class="text-gray-700 mb-2">
                                Memusatkan sumber daya pemasaran pada kelompok konsumen yang paling menguntungkan dan mudah dijangkau.
                            </p>
                            <div class="bg-green-100 p-3 rounded-md text-sm text-green-800 italic">
                                Contoh: Jika kamu menjual kopi premium, target pasarnya mungkin: usia 20–35, tinggal di kota, suka nongkrong di kafe, dan memiliki pendapatan menengah–atas.
                            </div>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-red-500">
                            <h3 class="text-2xl font-bold text-red-700 mb-4">3. Positioning (Posisi Merek di Mata Konsumen)</h3>
                            <p class="text-gray-700 mb-4">
                                Positioning adalah upaya untuk <span class="font-semibold">menanamkan citra, kesan, dan identitas produk di benak konsumen</span> sehingga mereka melihatnya berbeda dari produk pesaing.
                            </p>

                            <h4 class="text-lg font-semibold text-red-600 mb-3">Cara melakukan positioning:</h4>
                            <ul class="list-disc list-inside text-gray-700 ml-4 space-y-1">
                                <li>Membangun keunggulan (*differentiation*): fitur unik, kualitas tinggi, harga murah, pelayanan lebih baik, atau desain menarik.</li>
                                <li>Menyampaikan pesan jelas: melalui slogan, desain kemasan, iklan, dan *branding*.</li>
                                <li>Konsisten: citra produk harus sama di semua media dan interaksi.</li>
                            </ul>

                            <h4 class="text-lg font-semibold text-red-600 mb-3 mt-4">Tujuan Positioning:</h4>
                            <p class="text-gray-700 mb-2">
                                Membuat konsumen punya persepsi tertentu tentang produk, misalnya:
                            </p>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>“Rasanya premium”</li>
                                <li>“Harganya terjangkau”</li>
                                <li>“Paling awet dan berkualitas”</li>
                                <li>“Produk khusus untuk anak muda”</li>
                            </ul>
                            <div class="bg-red-100 p-3 rounded-md text-sm text-red-800 italic mt-3">
                                Contoh: Aqua memposisikan diri sebagai air minum paling aman dan terpercaya. Xiaomi memposisikan diri sebagai *smartphone* “harga terjangkau dengan spesifikasi tinggi”.
                            </div>
                        </div>

                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 mt-10 border-t pt-4">Kesimpulan STP</h3>
                    
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Konsep</th>
                                    <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Penjelasan Singkat</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap font-semibold text-indigo-600">Segmentasi</td>
                                    <td class="px-4 py-4">Membagi pasar berdasarkan usia, lokasi, minat, pendapatan, dll.</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap font-semibold text-green-600">Targeting</td>
                                    <td class="px-4 py-4">Memilih segmen yang paling potensial untuk dijadikan target.</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap font-semibold text-red-600">Positioning</td>
                                    <td class="px-4 py-4">Menanamkan citra dan keunggulan produk di benak konsumen.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="text-gray-700 mb-4">
                        Dengan menerapkan STP, perusahaan dapat:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 ml-4 mb-4 font-semibold space-y-1">
                        <li>mengenal pelanggan lebih dalam,</li>
                        <li>menggunakan anggaran pemasaran lebih efektif,</li>
                        <li>dan membuat produk lebih sesuai kebutuhan pasar.</li>
                    </ul>
                    <!-- REFERENSI VIDEO PEMASARAN – MATERI 3 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-pink-100 text-pink-600">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Materi 3 Pemasaran
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut sebagai penunjang pembelajaran <b>Materi 3 Pemasaran</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/Cwh2bJBq3hs?si=A2MPSkDpH982hynM"
                                title="Video Pembelajaran Materi 3 Pemasaran"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/kpq0_7Lu7cc"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-purple-500 pb-2">
                    Perilaku Konsumen (Consumer Behavior) 🧠
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Perilaku konsumen adalah <span class="font-semibold">studi mengenai bagaimana individu atau kelompok memilih, membeli, menggunakan, dan mengevaluasi produk atau jasa</span> untuk memenuhi kebutuhan dan keinginannya. Memahami perilaku konsumen sangat penting bagi perusahaan agar dapat merancang strategi pemasaran yang tepat.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        1. Faktor yang Mempengaruhi Keputusan Membeli
                    </h2>
                    <p class="text-gray-700 mb-4">
                        Keputusan membeli dipengaruhi oleh beberapa faktor utama, yaitu budaya, sosial, pribadi, dan psikologis. Faktor-faktor ini memengaruhi bagaimana seseorang melihat produk, membandingkan, dan akhirnya memutuskan untuk membeli.
                    </p>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-purple-500">
                            <h4 class="text-xl font-bold text-purple-700 mb-2">A. Faktor Budaya (Cultural)</h4>
                            <p class="text-sm text-gray-700 mb-2">
                                Budaya adalah nilai, norma, kebiasaan, dan kepercayaan yang dipelajari seseorang sejak kecil. Budaya sangat berpengaruh pada apa yang dianggap penting, pantas, atau berharga.
                            </p>
                            <h5 class="text-sm font-semibold text-gray-600">Pengaruh budaya dalam pembelian:</h5>
                            <ul class="list-disc list-inside text-xs text-gray-600 ml-4">
                                <li>Makanan yang dikonsumsi berdasarkan adat atau tradisi.</li>
                                <li>Gaya berpakaian yang menyesuaikan norma daerah.</li>
                                <li>Preferensi warna dan simbol (misal warna tertentu dianggap membawa keberuntungan).</li>
                                <li>Perayaan tertentu seperti Lebaran, Natal, atau Tahun Baru memengaruhi peningkatan pembelian.</li>
                            </ul>
                            <p class="text-xs font-bold text-gray-800 italic mt-2">
                                Intinya: budaya membentuk cara pandang konsumen terhadap produk.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-purple-500">
                            <h4 class="text-xl font-bold text-purple-700 mb-2">B. Faktor Sosial (Social)</h4>
                            <p class="text-sm text-gray-700 mb-2">
                                Faktor sosial berkaitan dengan lingkungan sekitar konsumen dan interaksi dengan orang lain.
                            </p>
                            <h5 class="text-sm font-semibold text-gray-600">Elemen faktor sosial:</h5>
                            <ul class="list-disc list-inside text-xs text-gray-600 ml-4">
                                <li>Keluarga: keputusan membeli sering dipengaruhi oleh orang tua, pasangan, atau anak.</li>
                                <li>Teman sebaya: rekomendasi teman bisa memengaruhi selera, terutama remaja.</li>
                                <li>Kelompok referensi: komunitas atau kelompok yang dijadikan panutan (misal komunitas *gamers*, komunitas sepeda).</li>
                                <li>Status sosial: orang dengan status tertentu cenderung memilih produk yang sesuai dengan citra diri mereka.</li>
                            </ul>
                            <p class="text-xs text-gray-800 italic mt-2">
                                Contoh: seseorang membeli *smartphone* tertentu karena digunakan oleh teman-temannya.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-purple-500">
                            <h4 class="text-xl font-bold text-purple-700 mb-2">C. Faktor Pribadi (Personal)</h4>
                            <p class="text-sm text-gray-700 mb-2">
                                Faktor pribadi bersifat unik pada setiap individu.
                            </p>
                            <h5 class="text-sm font-semibold text-gray-600">Yang termasuk faktor pribadi:</h5>
                            <ul class="list-disc list-inside text-xs text-gray-600 ml-4">
                                <li>Usia dan tahap kehidupan: kebutuhan anak muda berbeda dengan orang tua.</li>
                                <li>Pekerjaan: pekerja kantor butuh laptop kerja; teknisi butuh alat kerja khusus.</li>
                                <li>Keadaan ekonomi: tingkat pendapatan memengaruhi pilihan harga produk.</li>
                                <li>Gaya hidup: aktif, minimalis, glamor, atau sporty akan menentukan jenis produk yang dibeli.</li>
                                <li>Kepribadian dan konsep diri: orang percaya diri, introvert, atau perfeksionis memiliki preferensi berbeda.</li>
                            </ul>
                            <p class="text-xs text-gray-800 italic mt-2">
                                Contoh: orang berpenghasilan tinggi cenderung memilih produk premium.
                            </p>
                        </div>

                        <div class="bg-white p-5 rounded-lg shadow-md border-l-4 border-purple-500">
                            <h4 class="text-xl font-bold text-purple-700 mb-2">D. Faktor Psikologis (Psychological)</h4>
                            <p class="text-sm text-gray-700 mb-2">
                                Faktor psikologis berhubungan dengan cara seseorang memandang dan memproses informasi tentang produk.
                            </p>
                            <h5 class="text-sm font-semibold text-gray-600">Elemen faktor psikologis:</h5>
                            <ul class="list-disc list-inside text-xs text-gray-600 ml-4">
                                <li>Motivasi: dorongan dalam diri untuk memenuhi kebutuhan (misal ingin tampil rapi, ingin sehat).</li>
                                <li>Persepsi: bagaimana seseorang menilai produk berdasarkan pengalaman dan informasi.</li>
                                <li>Pembelajaran: pengalaman positif membuat konsumen mengulangi pembelian.</li>
                                <li>Sikap (attitude): perasaan, keyakinan, dan preferensi terhadap suatu produk atau merek.</li>
                            </ul>
                            <p class="text-xs text-gray-800 italic mt-2">
                                Contoh: konsumen membeli merek yang sama berulang kali karena pengalaman sebelumnya baik.
                            </p>
                        </div>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        2. Proses Pembelian Konsumen
                    </h2>
                    <p class="text-gray-700 mb-4">
                        Proses pembelian terjadi dalam beberapa tahap. Setiap tahap dilalui konsumen sebelum dan sesudah membeli produk.
                    </p>

                    <ol class="list-decimal list-inside space-y-3 text-gray-700 ml-4 mb-4">
                        <li><span class="font-semibold">Pengenalan Kebutuhan (Need Recognition)</span>
                            <p class="text-sm italic ml-6 mt-1">Konsumen menyadari adanya kebutuhan atau masalah yang harus dipenuhi. Contoh: merasa haus $\rightarrow$ butuh minuman.</p>
                        </li>
                        <li><span class="font-semibold">Pencarian Informasi (Information Search)</span>
                            <p class="text-sm italic ml-6 mt-1">Konsumen mencari informasi mengenai produk yang bisa memenuhi kebutuhannya. Sumber informasi bisa dari internet, teman, keluarga, iklan, atau pengalaman sebelumnya.</p>
                        </li>
                        <li><span class="font-semibold">Keputusan Membeli (Purchase Decision)</span>
                            <p class="text-sm italic ml-6 mt-1">Konsumen memilih produk yang paling sesuai dari berbagai pilihan. Dipengaruhi harga, merek, kualitas, ketersediaan stok, serta rekomendasi.</p>
                        </li>
                        <li><span class="font-semibold">Evaluasi Setelah Pembelian (Post-purchase Evaluation)</span>
                            <p class="text-sm italic ml-6 mt-1">Setelah membeli, konsumen menilai apakah produk tersebut memuaskan atau mengecewakan. Jika puas, konsumen kemungkinan membeli lagi dan merekomendasikan. Jika tidak puas, konsumen mungkin berpindah ke produk lain.</p>
                        </li>
                    </ol>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 mt-8 border-t pt-4">Kesimpulan</h3>
                    
                    <p class="text-gray-700 mb-2 font-semibold">
                        Perilaku konsumen dipengaruhi oleh:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 ml-4 mb-4 space-y-1">
                        <li>Budaya: nilai dan kebiasaan yang dianut.</li>
                        <li>Sosial: keluarga, teman, kelompok referensi.</li>
                        <li>Pribadi: usia, pekerjaan, gaya hidup, pendapatan.</li>
                        <li>Psikologis: motivasi, persepsi, pembelajaran, dan sikap.</li>
                    </ul>

                    <p class="text-gray-700 mb-2 font-semibold">
                        Sementara itu, proses pembelian meliputi:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 ml-4 mb-4 space-y-1">
                        <li>Pengenalan kebutuhan</li>
                        <li>Pencarian informasi</li>
                        <li>Keputusan membeli</li>
                        <li>Evaluasi setelah pembelian</li>
                    </ul>

                    <p class="text-gray-700 italic">
                        Semua faktor dan proses ini membantu pemasar memahami bagaimana konsumen berpikir dan bertindak, sehingga strategi pemasaran dapat disusun lebih tepat sasaran.
                    </p>
                    <!-- REFERENSI VIDEO PEMASARAN – MATERI 4 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-orange-100 text-orange-600">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Materi 4 Pemasaran
                            </h2>
                        </div>
                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut sebagai penunjang pembelajaran <b>Materi 4 Pemasaran</b>.  
                        </p>
                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/pJ1STDLi3Yo"
                                title="Video Pembelajaran Materi 4 Pemasaran"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/pJ1STDLi3Yo"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-teal-500 pb-2">
                        Strategi Pemasaran Modern (Digital Marketing) 💻
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Digital marketing adalah strategi pemasaran yang <span class="font-semibold">memanfaatkan internet dan teknologi digital</span> untuk mempromosikan produk atau layanan. Strategi ini sangat efektif karena dapat menjangkau audiens yang lebih luas, cepat, dan biaya yang lebih fleksibel dibanding *marketing* tradisional.
                    </p>

                    <div class="space-y-8 mt-8">
                        
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-teal-500">
                            <h3 class="text-2xl font-bold text-teal-700 mb-4">1. Media Sosial Marketing (Instagram, TikTok) 🤳</h3>
                            <p class="text-gray-700 mb-3">
                                Media sosial adalah salah satu alat pemasaran yang paling kuat saat ini. Platform seperti Instagram dan TikTok sangat populer dan dapat memengaruhi keputusan membeli terutama di kalangan anak muda.
                            </p>

                            <h4 class="text-lg font-semibold text-teal-600 mb-2">Keunggulan Media Sosial Marketing:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Menciptakan kedekatan dengan pelanggan melalui konten harian.</li>
                                <li>Cocok untuk *brand awareness* dan membangun citra.</li>
                                <li>Mudah *viral* melalui fitur Reels/TikTok.</li>
                                <li>Biaya rendah, jangkauan besar.</li>
                            </ul>
                            <h4 class="text-lg font-semibold text-teal-600 mb-2 mt-3">Contoh strategi:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>*Upload* konten rutin (foto produk, video pendek, testimoni).</li>
                                <li>Menggunakan *hashtag* yang relevan.</li>
                                <li>Membuat kampanye *challenge* di TikTok.</li>
                                <li>Mengatur jadwal *posting* agar konsisten.</li>
                            </ul>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-500">
                            <h3 class="text-2xl font-bold text-blue-700 mb-4">2. Marketplace Strategy (Shopee, Tokopedia) 🛒</h3>
                            <p class="text-gray-700 mb-3">
                                Marketplace adalah tempat jual beli *online* yang sudah menyediakan fitur lengkap, mulai dari etalase toko hingga sistem pembayaran.
                            </p>

                            <h4 class="text-lg font-semibold text-blue-600 mb-2">Keuntungan berjualan di *marketplace*:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Jangkauan pembeli besar dan aktif.</li>
                                <li>Ada fitur promosi otomatis seperti Flash Sale, Voucher, Gratis Ongkir.</li>
                                <li>Sistem pembayaran aman dan mudah.</li>
                            </ul>
                            <h4 class="text-lg font-semibold text-blue-600 mb-2 mt-3">Strategi *marketplace* yang efektif:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Optimasi foto produk dan deskripsi.</li>
                                <li>Menggunakan fitur iklan seperti Shopee Ads / Tokopedia Ads.</li>
                                <li>Memberikan *rating* bagus melalui pelayanan cepat.</li>
                                <li>Menyediakan variasi harga dan *bundling* produk.</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-yellow-500">
                            <h3 class="text-2xl font-bold text-yellow-700 mb-4">3. Content Marketing ✍️</h3>
                            <p class="text-gray-700 mb-3">
                                Content marketing adalah strategi membuat dan membagikan konten yang bermanfaat untuk menarik dan mempertahankan pelanggan.
                            </p>

                            <h4 class="text-lg font-semibold text-yellow-600 mb-2">Jenis konten:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Artikel edukasi</li>
                                <li>Video tutorial</li>
                                <li>Tips penggunaan produk</li>
                                <li>Review dan testimoni</li>
                                <li>Infografis</li>
                            </ul>
                            <p class="text-gray-800 italic mt-3 font-semibold">
                                Tujuan: bukan langsung menjual, tetapi membangun kepercayaan sehingga konsumen tertarik membeli secara alami.
                            </p>
                            <div class="bg-yellow-100 p-3 rounded-md text-sm text-yellow-800 italic mt-3">
                                Contoh: Brand *skincare* membuat konten edukasi “cara merawat kulit berminyak”.
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-red-500">
                            <h3 class="text-2xl font-bold text-red-700 mb-4">4. SEO dan Google Search 🔍</h3>
                            <p class="text-gray-700 mb-3">
                                Search Engine Optimization (SEO) adalah teknik untuk membuat website tampil di halaman pertama Google agar mudah ditemukan oleh calon konsumen.
                            </p>

                            <h4 class="text-lg font-semibold text-red-600 mb-2">Manfaat SEO:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Mendapatkan pengunjung secara gratis (organik).</li>
                                <li>Meningkatkan kepercayaan karena *ranking* tinggi.</li>
                                <li>Promosi 24 jam tanpa biaya iklan.</li>
                            </ul>
                            <h4 class="text-lg font-semibold text-red-600 mb-2 mt-3">Komponen SEO:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Kata kunci (*keyword*) yang tepat.</li>
                                <li>Konten berkualitas dan relevan.</li>
                                <li>Kecepatan *website* yang baik.</li>
                                <li>Struktur *website* yang rapi.</li>
                            </ul>
                            <div class="bg-red-100 p-3 rounded-md text-sm text-red-800 italic mt-3">
                                Contoh: Website jual sepatu menggunakan *keyword* “sepatu running murah”.
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-pink-500">
                            <h3 class="text-2xl font-bold text-pink-700 mb-4">5. Influencer & Endorse ✨</h3>
                            <p class="text-gray-700 mb-3">
                                Menggunakan *influencer* berarti mempromosikan produk melalui orang yang memiliki banyak pengikut dan dipercaya oleh audiens.
                            </p>

                            <h4 class="text-lg font-semibold text-pink-600 mb-2">Keuntungan *influencer marketing*:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Produk cepat dikenal.</li>
                                <li>Citra *brand* meningkat.</li>
                                <li>Mampu menjangkau target tertentu (misal ibu rumah tangga, *gamers*, remaja).</li>
                            </ul>
                            <h4 class="text-lg font-semibold text-pink-600 mb-2 mt-3">Jenis Influencer:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Mega *influencer*: jutaan *followers* (mahal, cocok untuk *brand* besar).</li>
                                <li>Micro *influencer*: 10k–100k *followers* (lebih efektif dan terjangkau).</li>
                                <li>Nano *influencer*: 1k–10k *followers* (lebih dekat dengan audiens).</li>
                            </ul>
                        </div>

                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-indigo-500">
                            <h3 class="text-2xl font-bold text-indigo-700 mb-4">6. Data Analytics untuk Optimasi Promosi 📊</h3>
                            <p class="text-gray-700 mb-3">
                                Data analytics adalah proses mengumpulkan dan menganalisis data dari berbagai *platform* untuk meningkatkan strategi pemasaran.
                            </p>

                            <h4 class="text-lg font-semibold text-indigo-600 mb-2">Data yang dianalisis:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Jumlah pengunjung *website*</li>
                                <li>*Engagement* Instagram/TikTok</li>
                                <li>Konversi iklan (CTR, CPC)</li>
                                <li>Produk paling laris</li>
                                <li>Waktu terbaik *posting*</li>
                            </ul>
                            <h4 class="text-lg font-semibold text-indigo-600 mb-2 mt-3">Tujuannya:</h4>
                            <ul class="list-disc list-inside text-gray-600 ml-4 space-y-1">
                                <li>Mengetahui strategi mana yang paling efektif</li>
                                <li>Mengurangi biaya promosi</li>
                                <li>Memaksimalkan penjualan</li>
                                <li>Memahami perilaku pelanggan</li>
                            </ul>
                            <div class="bg-indigo-100 p-3 rounded-md text-sm text-indigo-800 italic mt-3">
                                Contoh: Jika data menunjukkan *posting* jam 19.00 mendapatkan *engagement* tertinggi, maka jadwal *posting* harus disesuaikan ke jam tersebut.
                            </div>
                        </div>

                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 mt-10 border-t pt-4">Kesimpulan</h3>
                    
                    <p class="text-gray-700 mb-2">
                        Strategi pemasaran modern meliputi:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 ml-4 mb-4 font-semibold space-y-1">
                        <li>Media sosial: membangun citra dan kedekatan.</li>
                        <li>Marketplace: memudahkan transaksi dan memperluas jangkauan.</li>
                        <li>Content marketing: menciptakan nilai dan edukasi.</li>
                        <li>SEO: mendatangkan pengunjung gratis dari Google.</li>
                        <li>Influencer: mempercepat penyebaran informasi produk.</li>
                        <li>Data analytics: membantu pengambilan keputusan yang lebih cerdas.</li>
                    </ul>

                    <p class="text-gray-700 italic">
                        Semua strategi ini saling melengkapi dan sangat penting untuk diterapkan di era digital.
                    </p>
                    <!-- REFERENSI VIDEO PEMASARAN – MATERI 5 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-purple-100 text-purple-600">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Materi 5 Pemasaran
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut sebagai penunjang pembelajaran <b>Materi 5 Pemasaran</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/cUMnxepKxUk"
                                title="Video Pembelajaran Materi 5 Pemasaran"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/cUMnxepKxUk"
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