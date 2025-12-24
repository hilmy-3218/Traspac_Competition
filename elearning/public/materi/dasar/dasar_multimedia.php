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
                        1 => "Dasar Desain Grafis", 
                        2 => "Fotografi dan Editing Foto", 
                        3 => "Desain Video dan Animasi", 
                        4 => "Audio dan Musik Digital", 
                        5 => "Etika dan Hak Cipta"
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
                        Dasar Desain Grafis
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Desain Grafis adalah <span class="font-semibold">seni dan praktik mengomunikasikan ide atau informasi secara visual</span> melalui kombinasi teks, gambar, warna, dan elemen visual lainnya.
                    </p>
                    
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Prinsip Desain
                    </h2>
                    <p class="text-gray-700 mb-2">
                        Prinsip desain membantu menciptakan karya yang <span class="font-semibold">estetis, harmonis, dan mudah dipahami</span>.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">1. Keseimbangan (Balance)</h3>
                    <p class="text-gray-700 mb-2">
                        Distribusi visual elemen-elemen desain agar terlihat <span class="font-semibold">stabil dan tidak berat sebelah</span>.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Simetris</span>: Sama rata di kedua sisi (formal, stabil).</li>
                        <li><span class="font-semibold">Asimetris</span>: Seimbang secara visual meskipun elemennya tidak identik (dinamis, modern).</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Kontras (Contrast)</h3>
                    <p class="text-gray-700 mb-2">
                        Menciptakan <span class="font-semibold">perbedaan yang menonjol</span> antar elemen untuk menarik perhatian dan meningkatkan keterbacaan.
                    </p>
                    <blockquote class="border-l-4 border-gray-400 pl-4 py-2 my-4 bg-gray-100 text-gray-700 italic">
                        Contoh: Warna terang vs gelap, Teks tebal vs tipis, Ukuran besar vs kecil.
                    </blockquote>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">3. Ritme (Rhythm)</h3>
                    <p class="text-gray-700 mb-4">
                        <span class="font-semibold">Pengulangan elemen visual</span> (pola garis, titik, atau warna) untuk menciptakan aliran yang menyenangkan mata dan memberikan rasa konsistensi.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">4. Kesatuan (Unity)</h3>
                    <p class="text-gray-700 mb-4">
                        Memastikan semua elemen desain terlihat sebagai <span class="font-semibold">satu kesatuan yang harmonis</span> dan profesional (konsisten warna, gaya, dan spasi).
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">5. Proporsi (Proportion)</h3>
                    <p class="text-gray-700 mb-4">
                        <span class="font-semibold">Perbandingan ukuran</span> antara elemen-elemen untuk menciptakan hierarki visual, membantu pembaca tahu mana yang penting.
                    </p>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Teori Warna
                        </h2>
                        <p class="text-gray-700 mb-4">
                            Panduan tentang bagaimana warna bekerja bersama, memengaruhi suasana, dan menciptakan harmoni visual.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Jenis Warna Berdasarkan Teori Warna</h3>
                        <ul class="list-disc list-inside space-y-3 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Warna Primer</span>: Tidak bisa dibuat dari pencampuran warna lain (Merah, Biru, Kuning).</li>
                            <li><span class="font-semibold">Warna Sekunder</span>: Hasil pencampuran dua warna primer (Oranye, Hijau, Ungu).</li>
                            <li><span class="font-semibold">Warna Komplementer</span>: Berlawanan di roda warna. Menciptakan <span class="font-semibold">kontras kuat</span> (Merah $\leftrightarrow$ Hijau).</li>
                            <li><span class="font-semibold">Warna Analog</span>: Berdekatan di roda warna. Memberikan kesan <span class="font-semibold">harmonis dan lembut</span> (Biru, Biru-Hijau, Hijau).</li>
                            <li><span class="font-semibold">Warna Triadik</span>: Tiga warna yang sama jauh di roda warna. Memberikan keseimbangan yang dinamis.</li>
                        </ul>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Tipografi
                        </h2>
                        <p class="text-gray-700 mb-4">
                            Seni dan teknik <span class="font-semibold">mengatur teks</span> agar mudah dibaca, menarik, dan sesuai dengan pesan yang ingin disampaikan.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Elemen Tipografi</h3>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. Jenis Font (Typefaces)</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Serif</span>: Ada garis kecil di ujung huruf. Kesan <span class="font-semibold">klasik dan formal</span> (Times New Roman).</li>
                            <li><span class="font-semibold">Sans Serif</span>: Tanpa garis kecil. Kesan <span class="font-semibold">modern dan bersih</span> (Arial, Helvetica).</li>
                            <li><span class="font-semibold">Script</span>: Meniru tulisan tangan. Kesan elegan atau personal.</li>
                        </ul>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. Ukuran Font (Font Size)</h4>
                        <p class="text-gray-700 mb-4">
                            Menentukan <span class="font-semibold">hierarki visual</span>. Judul $>$ Subjudul $>$ Isi Teks. Harus mudah dibaca di semua media.
                        </p>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">3. Spasi (Spacing)</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Kerning</span>: Jarak antar huruf.</li>
                            <li><span class="font-semibold">Leading / Line Height</span>: Jarak antar baris.</li>
                            <li><span class="font-semibold">Tracking</span>: Jarak antar kata atau seluruh blok teks.</li>
                        </ul>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Software Desain Grafis
                        </h2>
                        
                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Adobe Photoshop</h3>
                        <p class="text-gray-700 mb-2">
                            Fungsi utama: Mengedit dan memanipulasi gambar berbasis <span class="font-semibold">raster (pixel)</span>.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Cocok untuk:</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Retouching foto</span> dan manipulasi foto realistis.</li>
                            <li>Membuat poster, banner, dan konten media sosial.</li>
                            <li>Desain dengan efek visual kompleks.</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Adobe Illustrator / CorelDRAW</h3>
                        <p class="text-gray-700 mb-2">
                            Fungsi utama: Membuat desain <span class="font-semibold">vector graphics</span> (berbasis garis dan bentuk).
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Cocok untuk:</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Logo, ikon, dan ilustrasi</span> vektor.</li>
                            <li>Desain cetak (brosur, kartu nama).</li>
                            <li>Gambar yang <span class="font-semibold">perlu diubah ukurannya</span> tanpa kehilangan kualitas.</li>
                        </ul>

                        <blockquote class="border-l-4 border-indigo-500 pl-4 py-2 my-4 bg-indigo-50 text-indigo-800 italic">
                            <p><span class="font-semibold">Kesimpulan:</span> Photoshop untuk foto/pixel, Illustrator/CorelDRAW untuk logo/vektor.</p>
                        </blockquote>
                    </div>
                    <!-- REFERENSI VIDEO MULTIMEDIA – MATERI 1 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                <i class="fas fa-film"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Materi 1 Multimedia
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut sebagai penunjang pembelajaran <b>Multimedia Materi 1</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/-5Tpw5fXeVo"
                                title="Video Pembelajaran Multimedia Materi 1"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/-5Tpw5fXeVo"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Fotografi dan Editing Foto
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Fotografi adalah <span class="font-semibold">seni menangkap momen atau objek dengan kamera</span>. Dalam desain grafis, fotografi dan Editing Foto digunakan untuk <span class="font-semibold">mendukung visual</span> agar lebih menarik dan komunikatif.
                    </p>
                    
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Teknik Fotografi Dasar
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">1. Komposisi (Composition)</h3>
                    <p class="text-gray-700 mb-2">
                        Menentukan <span class="font-semibold">penempatan elemen visual</span> dalam frame agar terlihat seimbang dan menarik.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Rule of Thirds</span>: Menempatkan objek penting di garis atau titik pertemuan 3x3.</li>
                        <li><span class="font-semibold">Leading Lines</span>: Menggunakan garis alami untuk mengarahkan mata ke fokus utama.</li>
                        <li><span class="font-semibold">Framing</span>: Menggunakan elemen di sekitar objek untuk “membingkai” fokus.</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Pencahayaan (Lighting)</h3>
                    <p class="text-gray-700 mb-2">
                        Cahaya memengaruhi <span class="font-semibold">mood, warna, dan kualitas</span> foto.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Natural Light</span>: Cahaya matahari, sering dicari saat *golden hour* (pagi/sore).</li>
                        <li><span class="font-semibold">Artificial Light</span>: Lampu studio, flash, LED.</li>
                        <li><span class="font-semibold">Backlight / Silhouette</span>: Cahaya dari belakang objek, menghasilkan siluet dramatis.</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">3. Sudut Pengambilan Gambar (Angle)</h3>
                    <p class="text-gray-700 mb-2">
                        Sudut kamera memengaruhi <span class="font-semibold">pesan dan perspektif</span> objek.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Eye Level</span>: Sudut mata $\rightarrow$ natural dan realistis.</li>
                        <li><span class="font-semibold">High Angle</span>: Dari atas $\rightarrow$ objek terlihat lebih kecil/lemah.</li>
                        <li><span class="font-semibold">Low Angle</span>: Dari bawah $\rightarrow$ objek terlihat kuat/dominan.</li>
                    </ul>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Format File Gambar
                        </h2>
                        <p class="text-gray-700 mb-4">
                            Memilih format yang tepat sangat penting agar hasil desain tetap optimal, karena setiap format memiliki kelebihan dan kekurangan.
                        </p>

                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelebihan Utama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kekurangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">JPG/JPEG</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap">Raster (Pixel)</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Ukuran kecil, cocok untuk foto realistis.</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Tidak mendukung transparansi, kualitas menurun (lossy).</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">PNG</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap">Raster (Pixel)</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Mendukung <span class="font-semibold">transparansi</span>, kualitas baik untuk web.</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Ukuran file lebih besar dari JPG.</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">GIF</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap">Raster (Pixel)</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Mendukung <span class="font-semibold">animasi sederhana</span>.</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Warna terbatas (hanya 256).</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">SVG</span></td>
                                        <td class="px-6 py-4 whitespace-nowrap">Vector</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Bisa <span class="font-semibold">diperbesar tanpa kehilangan kualitas</span>.</td>
                                        <td class="px-6 py-4 whitespace-nowrap">Tidak cocok untuk foto realistis.</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Teknik Editing Foto
                        </h2>
                        <p class="text-gray-700 mb-4">
                            Editing foto adalah proses memodifikasi foto agar lebih menarik, <span class="font-semibold">sesuai tema</span>, dan siap digunakan dalam desain.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Retouching</h3>
                        <p class="text-gray-700 mb-2">
                            Fungsi: Memperbaiki <span class="font-semibold">bagian foto yang tidak sempurna</span>.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Menghilangkan noda, jerawat, atau objek yang mengganggu.</li>
                            <li>Memperhalus kulit atau detail tertentu. (Tools: Clone Stamp, Healing Brush).</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Cropping (Pemotongan)</h3>
                        <p class="text-gray-700 mb-4">
                            Memotong atau menyesuaikan ukuran foto untuk <span class="font-semibold">fokus pada objek utama</span> dan membantu komposisi lebih rapi.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Color Correction (Koreksi Warna)</h3>
                        <p class="text-gray-700 mb-2">
                            Fungsi: Menyesuaikan <span class="font-semibold">warna, kontras, dan pencahayaan</span> agar foto terlihat natural atau sesuai tema desain.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Mengatur kecerahan, saturasi, dan kontras.</li>
                            <li>Mengubah *tone* warna (Tools: Levels, Curves).</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">4. Masking</h3>
                        <p class="text-gray-700 mb-4">
                            Fungsi: Memilih atau <span class="font-semibold">menyembunyikan bagian tertentu</span> dari foto agar bisa diedit secara terpisah (teknik *non-destructive*). Contoh: memisahkan objek dari latar belakang.
                        </p>

                        <blockquote class="border-l-4 border-indigo-500 pl-4 py-2 my-4 bg-indigo-50 text-indigo-800 italic">
                            <p>Intinya, editing foto bukan hanya membuat foto terlihat bagus, tapi juga <span class="font-semibold">meningkatkan kualitas visual</span> untuk mendukung desain grafis.</p>
                        </blockquote>
                    </div>
                    <!-- REFERENSI VIDEO MULTIMEDIA – MATERI 2 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="fas fa-film"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Multimedia Materi 2
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Silakan tonton video berikut sebagai penunjang pembelajaran <b>Multimedia Materi 2</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/HnkK9XuimhA"
                                title="Video Pembelajaran Multimedia Materi 2"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/HnkK9XuimhA"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Desain Video dan Animasi 🎥
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Desain Video dan Animasi memadukan <span class="font-semibold">gambar bergerak, suara, dan teks</span> untuk menyampaikan pesan secara visual.
                    </p>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Pengenalan Video (Aspek Teknis)
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">1. Resolusi Video</h3>
                    <p class="text-gray-700 mb-2">
                        Menunjukkan jumlah <span class="font-semibold">pixel</span> dalam video, memengaruhi kualitas gambar. Semakin tinggi resolusi, semakin tajam gambar.
                    </p>
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resolusi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pixel (W x H)</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kualitas</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr><td class="px-6 py-4 whitespace-nowrap">720p (HD)</td><td class="px-6 py-4 whitespace-nowrap">1280 x 720 px</td><td class="px-6 py-4 whitespace-nowrap">Sedang</td></tr>
                                <tr><td class="px-6 py-4 whitespace-nowrap">1080p (Full HD)</td><td class="px-6 py-4 whitespace-nowrap">1920 x 1080 px</td><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Tinggi</span></td></tr>
                                <tr><td class="px-6 py-4 whitespace-nowrap">4K (Ultra HD)</td><td class="px-6 py-4 whitespace-nowrap">3840 x 2160 px</td><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Sangat Tinggi</span></td></tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Frame Rate (FPS)</h3>
                    <p class="text-gray-700 mb-2">
                        Menunjukkan <span class="font-semibold">jumlah frame atau gambar per detik</span>. Frame rate yang lebih tinggi membuat gerakan terlihat lebih halus.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">24 fps</span>: Standar sinematik (film).</li>
                        <li><span class="font-semibold">30 fps</span>: Standar video web atau TV.</li>
                        <li><span class="font-semibold">60 fps</span>: Gerakan halus, cocok untuk game atau olahraga.</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">3. Format File Video</h3>
                    <p class="text-gray-700 mb-2">
                        Menentukan cara video dikodekan dan disimpan.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">MP4</span>: Paling populer, <span class="font-semibold">kompatibel luas</span>, ukuran kecil.</li>
                        <li><span class="font-semibold">AVI</span>: Kualitas tinggi, ukuran besar.</li>
                        <li><span class="font-semibold">MOV</span>: Cocok untuk editing di Mac (QuickTime).</li>
                    </ul>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Editing Video
                    </h2>
                    <p class="text-gray-700 mb-2">
                        Proses mengolah rekaman video mentah agar menjadi video yang menarik dan profesional.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">Teknik Editing Video</h3>
                    <ul class="list-disc list-inside space-y-3 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Cutting (Pemotongan)</span>: Menghapus bagian yang tidak perlu agar video lebih ringkas dan fokus.</li>
                        <li><span class="font-semibold">Transisi</span>: Menghubungkan dua klip video agar perpindahan lebih halus (Fade, Dissolve).</li>
                        <li><span class="font-semibold">Efek Visual (VFX)</span>: Menambahkan elemen kreatif (slow motion, filter, animasi teks) untuk memperkuat pesan.</li>
                        <li><span class="font-semibold">Penambahan Audio</span>: Menambahkan musik, suara latar, atau *voice-over*. Pastikan audio seimbang.</li>
                    </ul>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Software Video dan Animasi
                    </h2>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">1. Adobe Premiere Pro</h3>
                    <p class="text-gray-700 mb-2">
                        Fungsi utama: <span class="font-semibold">Editing video profesional</span> berbasis timeline.
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>Kegunaan: Memotong, menyusun klip, menambahkan transisi, menyunting audio dan warna.</li>
                        <li>Kelebihan: Fitur lengkap, kompatibel dengan software Adobe lain (After Effects).</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Adobe After Effects / Blender</h3>
                    <div class="space-y-4">
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Adobe After Effects</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4">
                            <li>Fungsi utama: Membuat <span class="font-semibold">animasi 2D, motion graphics, dan efek visual</span>.</li>
                            <li>Cocok untuk: Animasi teks, logo, dan infografis bergerak.</li>
                        </ul>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Blender</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4">
                            <li>Fungsi utama: Membuat <span class="font-semibold">animasi dan rendering 3D</span>.</li>
                            <li>Kelebihan: <span class="font-semibold">Gratis</span> dan open-source, mendukung animasi 2D dan 3D.</li>
                        </ul>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Dasar Animasi
                    </h2>
                    <p class="text-gray-700 mb-2">
                        Seni membuat gambar atau objek bergerak seolah hidup. Konsep ini penting agar animasi berjalan lancar dan profesional.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">1. Keyframe</h3>
                    <p class="text-gray-700 mb-2">
                        <span class="font-semibold">Titik penting</span> yang menentukan posisi, ukuran, atau properti objek pada waktu tertentu. Keyframe menandai <span class="font-semibold">awal dan akhir sebuah gerakan</span>.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Timeline</h3>
                    <p class="text-gray-700 mb-4">
                        <span class="font-semibold">Garis waktu</span> yang menampilkan urutan frame dan durasi animasi. Digunakan untuk mengatur kapan objek muncul atau bergerak, serta menyusun keyframe.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">3. Motion Graphics</h3>
                    <p class="text-gray-700 mb-4">
                        Animasi yang menggabungkan <span class="font-semibold">grafik, teks, dan elemen visual</span> untuk menyampaikan pesan secara dinamis (Infografis animasi, Judul bergerak).
                    </p>
                    <!-- REFERENSI VIDEO MULTIMEDIA – MATERI 3 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-100 text-red-600">
                                <i class="fas fa-photo-video"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Multimedia Materi 3
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Silakan tonton video berikut sebagai penunjang pembelajaran <b>Multimedia Materi 3</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/ku_h6T7R8vs"
                                title="Video Pembelajaran Multimedia Materi 3"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/ku_h6T7R8vs"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Audio dan Musik Digital 🎧
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Audio Digital adalah suara yang direkam, disimpan, dan diputar melalui perangkat digital. Dalam multimedia, audio digunakan untuk menambah <span class="font-semibold">efek, narasi, atau suasana</span> pada video dan animasi.
                    </p>
                    

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Pengenalan Format File Audio
                    </h2>
                    <p class="text-gray-700 mb-4">
                        Pemilihan format memengaruhi kualitas suara dan ukuran file.
                    </p>

                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Format</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelebihan Utama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kekurangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">MP3</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap">Lossy</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Ukuran file <span class="font-semibold">kecil</span>, kompatibilitas luas.</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Kualitas suara menurun (terkompresi).</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">WAV</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap">Lossless</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Kualitas suara tinggi</span> (mendekati asli).</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Ukuran file sangat besar.</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">AAC</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap">Lossy</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Kualitas lebih efisien dari MP3.</td>
                                    <td class="px-6 py-4 whitespace-nowrap">Kompatibilitas sedikit terbatas.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Teknik Audio
                    </h2>
                    <p class="text-gray-700 mb-4">
                        Proses mengolah suara agar terdengar <span class="font-semibold">profesional, seimbang, dan sesuai</span> dengan kebutuhan media.
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">Teknik Dasar Audio</h3>
                    <ul class="list-disc list-inside space-y-3 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Mixing (Pencampuran Audio)</span>: Menggabungkan berbagai track (musik, efek, narasi) menjadi satu kesatuan yang harmonis.</li>
                        <li><span class="font-semibold">Mastering</span>: Tahap akhir untuk memperbaiki kualitas audio secara <span class="font-semibold">keseluruhan</span> (menyesuaikan volume akhir agar konsisten).</li>
                        <li><span class="font-semibold">Pengaturan Volume (Leveling)</span>: Menyesuaikan tingkat suara setiap track agar seimbang (Narasi harus lebih jelas dari musik latar).</li>
                        <li><span class="font-semibold">Efek Suara (Audio Effects)</span>: Memberikan karakter atau nuansa (Reverb, Echo, Equalizer) agar audio lebih menarik.</li>
                    </ul>
                    <blockquote class="border-l-4 border-yellow-500 pl-4 py-2 my-4 bg-yellow-50 text-yellow-800 italic">
                        <p>Tujuan utama: Audio harus mendukung visual secara optimal tanpa menutupi dialog atau mengganggu penonton.</p>
                    </blockquote>


                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 mt-8">
                        Software Audio/Musik Digital
                    </h2>

                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-green-500">
                            <h3 class="text-xl font-bold text-green-700 mb-2">Audacity</h3>
                            <p class="text-gray-600 mb-3 text-sm">Fungsi utama: Editing audio <span class="font-semibold">gratis dan open-source</span>.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2">
                                <li>Cocok untuk pemula.</li>
                                <li>Merekam, memotong, dan efek sederhana.</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-red-500">
                            <h3 class="text-xl font-bold text-red-700 mb-2">Adobe Audition</h3>
                            <p class="text-gray-600 mb-3 text-sm">Fungsi utama: Editing audio <span class="font-semibold">profesional</span>.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2">
                                <li>Mixing, mastering, dan menghilangkan *noise*.</li>
                                <li>Integrasi mudah dengan Premiere Pro.</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-5 rounded-lg shadow-lg border-t-4 border-purple-500">
                            <h3 class="text-xl font-bold text-purple-700 mb-2">FL Studio</h3>
                            <p class="text-gray-600 mb-3 text-sm">Fungsi utama: <span class="font-semibold">Produksi musik digital (DAW)</span>.</p>
                            <ul class="list-disc list-inside text-gray-500 text-sm ml-2">
                                <li>Membuat musik dari awal (beats, instrumen virtual).</li>
                                <li>Mixing dan mastering musik profesional.</li>
                            </ul>
                        </div>
                    </div>
                    <!-- REFERENSI VIDEO MULTIMEDIA – MATERI 4 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-100 text-green-600">
                                <i class="fas fa-photo-video"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Multimedia Materi 4
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Silakan tonton video berikut sebagai penunjang pembelajaran <b>Multimedia Materi 4</b>.  
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/0xGRBVUNVv4"
                                title="Video Pembelajaran Multimedia Materi 4"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/0xGRBVUNVv4"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Etika dan Hak Cipta Digital ⚖️
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Penting untuk memahami Hak Cipta dan Etika Kreatif agar terhindar dari pelanggaran hukum dan tetap menghargai karya orang lain di dunia digital.
                    </p>

                    <h3 class="text-2xl font-bold text-gray-800 mb-6 mt-8">1. Hak Cipta Digital</h3>
                    
                    <p class="text-gray-700 mb-2">
                        Hak Cipta adalah <span class="font-semibold">hak eksklusif yang dimiliki pencipta</span> untuk mengontrol penggunaan karyanya (gambar, audio, video, dll.).
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Aturan Dasar</span>: Tidak boleh menggunakan karya orang lain tanpa izin.</li>
                        <li>Memahami <span class="font-semibold">Lisensi</span> adalah kunci untuk penggunaan yang legal.</li>
                    </ul>
                    

                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Jenis Lisensi Dasar</h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">All Rights Reserved</span>: Semua hak dilindungi, harus meminta izin tertulis untuk digunakan.</li>
                        <li><span class="font-semibold">Free / Public Domain</span>: Bebas digunakan tanpa batasan (karya lama atau dilepas hak ciptanya).</li>
                        <li><span class="font-semibold">Creative Commons (CC)</span>: Lisensi fleksibel dengan syarat tertentu.</li>
                    </ul>

                    <h3 class="text-2xl font-bold text-gray-800 mb-6 mt-8">2. Etika Kreatif</h3>

                    <p class="text-gray-700 mb-2">
                        Etika Kreatif adalah norma dan prinsip moral dalam pembuatan dan penggunaan karya.
                    </p>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Praktik Etika Baik:</h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>Tidak menjiplak atau menyalin karya orang lain.</li>
                        <li><span class="font-semibold">Memberikan kredit (atribusi)</span> jika menggunakan karya orang lain.</li>
                        <li>Menghormati karya, baik online maupun offline.</li>
                    </ul>
                    <blockquote class="border-l-4 border-yellow-500 pl-4 py-2 my-4 bg-yellow-50 text-yellow-800 italic">
                        <p>Manfaatnya: Mencegah konflik hukum, menjaga reputasi profesional, dan mendukung ekosistem kreatif yang sehat.</p>
                    </blockquote>

                    <h3 class="text-2xl font-bold text-gray-800 mb-6 mt-8">3. Kebijakan Penggunaan</h3>
                    
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Creative Commons (CC)</h4>
                    <p class="text-gray-700 mb-2">
                        Lisensi yang memungkinkan penggunaan karya dengan syarat yang jelas, misal:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">CC BY</span>: Boleh digunakan asalkan <span class="font-semibold">memberi atribusi</span> (kredit).</li>
                        <li><span class="font-semibold">CC BY-NC</span>: Boleh digunakan untuk <span class="font-semibold">non-komersial</span> dengan atribusi.</li>
                        <li><span class="font-semibold">CC BY-SA</span>: Boleh digunakan asalkan hasil turunan menggunakan <span class="font-semibold">lisensi yang sama</span> (Share Alike).</li>
                    </ul>
                    
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Royalty-Free Resources</h4>
                    <p class="text-gray-700 mb-4">
                        Karya yang bisa digunakan <span class="font-semibold">tanpa membayar royalti setiap kali digunakan</span> (biaya hanya dibayar di awal, atau bahkan gratis).
                    </p>
                    <p class="text-gray-700 mb-4">
                        Contoh: Gambar, musik, atau video dari situs *stock* bebas royalti. Penting untuk selalu cek batasan lisensi spesifik dari setiap situs.
                    </p>
                    <!-- REFERENSI VIDEO MULTIMEDIA – MATERI 5 -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-yellow-100 text-yellow-600">
                                <i class="fas fa-video"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Multimedia Materi 5: Etika di Dunia Digital
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami pentingnya <b>etika berinternet</b> dan perilaku yang baik saat berinteraksi di dunia digital — materi ini mendukung pembelajaran <b>Multimedia Materi 5</b>.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/qNskX8A5I90"
                                title="Pesan si Juki: Etika di Dunia Digital"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/qNskX8A5I90"
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
            <?php require_once __DIR__ . '/../../../private/tampilan_tugas.php';?>
        </main>
    </div>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <!-- START BOTTOM NAVIGATION BAR (Mobile Only) -->
    <?php require_once __DIR__ . '/../../../private/nav-bottom.php';?>


    <script src="../../../assets/js/materi_dasar.js"></script>
</body>
</html>