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
                        1 => "Algoritma & Logika Pemrograman", 
                        2 => "Pemrograman Dasar", 
                        3 => "Pemrograman Web Dasar", 
                        4 => "Basis Data (Database)", 
                        5 => "Pengembangan Web Lanjutan"
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
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-8 border-b-4 border-blue-500 pb-2">
                        Algoritma & Logika Pemrograman
                    </h2>

                    <p class="text-gray-700 mb-6 leading-relaxed">
                        Algoritma dan logika pemrograman adalah dasar paling penting dalam dunia Rekayasa Perangkat Lunak (RPL). Sebelum seseorang mampu menulis kode menggunakan bahasa apa pun—baik JavaScript, PHP, Python, maupun bahasa lainnya—ia harus memahami cara berpikir terstruktur dan sistematis. Materi ini membantu kita memecahkan masalah secara runtut, efisien, dan mudah dipahami.
                    </p>

                    <div class="mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            1. Algoritma
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Algoritma adalah langkah-langkah terurut yang digunakan untuk menyelesaikan suatu masalah. Ibarat resep masakan, algoritma memberi tahu kita urutan apa yang harus dilakukan agar hasil akhirnya sesuai.
                        </p>
                        <p class="text-gray-700 mb-4 italic">
                            Contoh sederhana algoritma membuat kopi:
                        </p>
                        <ol class="list-decimal list-inside space-y-1 text-gray-600 ml-6 mb-4">
                            <li>Panaskan air.</li>
                            <li>Masukkan kopi ke dalam gelas.</li>
                            <li>Tambahkan gula.</li>
                            <li>Tuangkan air panas.</li>
                            <li>Aduk hingga rata.</li>
                            <li>Kopi siap diminum.</li>
                        </ol>
                        <p class="text-gray-700 mb-2">
                            Sama halnya dalam pemrograman, kita harus memikirkan langkah-langkah penyelesaian sebelum mulai menulis kode.
                        </p>
                    </div>

                    <hr class="border-gray-300 my-8">

                    <div class="mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            2. Flowchart (Diagram Alir)
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Flowchart adalah diagram visual yang menunjukkan langkah-langkah dalam sebuah proses atau algoritma. Ini seperti peta jalan yang menggambarkan alur program dari awal sampai selesai.
                        </p>
                        <p class="text-gray-700 mb-2">
                            Flowchart menggunakan simbol-simbol khusus untuk mempermudah pembacaan.
                        </p>                        
                        <h4 class="text-xl font-semibold text-blue-600 mb-2 mt-4">Mengapa Flowchart itu Penting?</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Mempermudah memahami <span class="font-semibold">alur logika program</span></li>
                            <li>Membantu programmer menjelaskan ide ke orang lain</li>
                            <li>Mengurangi kesalahan saat menulis kode</li>
                            <li>Memudahkan <span class="font-semibold">debugging</span> (mencari error)</li>
                            <li>Cocok untuk merancang fitur program pada tahap perencanaan</li>
                        </ul>
                    </div>

                    <hr class="border-gray-300 my-8">

                    <div class="mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Percabangan (if/else)
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Percabangan adalah salah satu konsep logika pemrograman yang digunakan untuk mengambil keputusan. Program perlu bisa memilih tindakan tertentu berdasarkan <span class="font-semibold">kondisi</span>—persis seperti manusia mengambil keputusan dalam kehidupan sehari-hari.
                        </p>
                        <blockquote class="border-l-4 border-yellow-500 pl-4 py-2 my-4 bg-yellow-50 text-yellow-800 italic">
                            <p>Jika hujan → pakai payung</p>
                            <p>Jika lapar → makan</p>
                        </blockquote>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Apa itu Percabangan?</h3>
                        <p class="text-gray-700 mb-2">
                            Percabangan adalah struktur logika yang memungkinkan program menjalankan perintah tertentu hanya jika kondisi terpenuhi.
                        </p>
                        <p class="text-gray-700 mb-2">
                            Kondisi biasanya berupa perbandingan, seperti: <span class="font-semibold">></span> (lebih besar), <span class="font-semibold"><</span> (lebih kecil), <span class="font-semibold">==</span> (sama dengan), <span class="font-semibold">!=</span> (tidak sama dengan).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Bentuk Percabangan Dasar</h3>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">a. if (hanya 1 kondisi benar)</h4>
                        <p class="text-gray-700 mb-2">
                            Digunakan jika hanya ada satu kemungkinan keputusan yang akan dieksekusi.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>if (nilai >= 75) {
                                console.log("Lulus");
                            }</code>
                        </pre>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">b. if / else (dua pilihan)</h4>
                        <p class="text-gray-700 mb-2">
                            Digunakan jika hanya ada <span class="font-semibold">dua kemungkinan</span> hasil: benar atau salah.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>if (nilai >= 75) {
                                console.log("Lulus");
                            } else {
                                console.log("Tidak Lulus");
                            }</code>
                        </pre>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">c. if / else if / else (lebih dari dua pilihan)</h4>
                        <p class="text-gray-700 mb-2">
                            Digunakan jika ada <span class="font-semibold">banyak kondisi</span> berbeda yang perlu dicek secara berurutan.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>if (nilai >= 90) {
                                console.log("A");
                            } else if (nilai >= 80) {
                                console.log("B");
                            } else if (nilai >= 70) {
                                console.log("C");
                            } else {
                                console.log("D");
                            }</code>
                        </pre>
                        <p class="text-gray-700 mb-2">
                            Program akan mengecek dari atas ke bawah sampai kondisi yang cocok ditemukan.
                        </p>
                    </div>

                    <hr class="border-gray-300 my-8">
                    <div class="mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Perulangan (Looping)
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Perulangan atau looping adalah konsep pemrograman yang digunakan untuk <span class="font-semibold">mengulang suatu proses berkali-kali</span> tanpa menulis kode berulang.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Mengapa Perulangan Itu Penting?</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Menghemat kode (<span class="font-semibold">DRY</span>)</li>
                            <li>Menjalankan proses berulang (misal: hitung 1 sampai 100)</li>
                            <li>Memproses data dalam <span class="font-semibold">array</span> atau database</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Jenis-Jenis Perulangan Dasar</h3>
                        <p class="text-gray-700 mb-2">
                            Dua perulangan dasar yang paling sering dipakai: for dan while.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Perulangan FOR</h3>
                        <p class="text-gray-700 mb-2">
                            Perulangan <span class="font-semibold">for</span> digunakan ketika <span class="font-semibold">jumlah pengulangan sudah diketahui</span> atau sudah ditentukan.
                        </p>
                        <p class="text-gray-700 mb-2">
                            Biasanya memiliki tiga bagian: <span class="font-semibold">Inisialisasi</span>, <span class="font-semibold">Kondisi</span>, dan <span class="font-semibold">Increment/Decrement</span>.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Perulangan FOR (JavaScript)</h4>
                        <p class="text-gray-700 mb-2">
                            Menampilkan angka 1 sampai 5:
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>
                            for (let i = 1; i <= 5; i++) {
                                console.log(i);
                            }</code>
                        </pre>
                        <h3 class="text-xl font-bold text-blue-700 mb-4">4. Perulangan WHILE</h3>
                        <p class="text-gray-700 mb-2">
                            Perulangan <span class="font-semibold">while</span> digunakan ketika <span class="font-semibold">jumlah pengulangan belum pasti</span>, tetapi bergantung pada kondisi. Selama kondisi TRUE, perulangan akan terus berjalan.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Struktur dasar</h4>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>
                                while (kondisi) {
                                     // kode yang diulang
                                    }
                            </code>
                            </pre>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Perulangan WHILE</h4>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                        <code>
                            let i = 1;
                                while (i <= 5) {
                                    console.log(i);
                                    i++; // PENTING: harus ada increment/decrement agar tidak menjadi infinite loop
                                }
                        </code>
                        </pre>

                    </div>

                    <hr class="border-gray-300 my-8">

                    <div class="mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            ARRAY
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Array adalah struktur data yang digunakan untuk <span class="font-semibold">menyimpan banyak nilai dalam satu variabel</span>.
                        </p>
                        <blockquote class="border-l-4 border-indigo-500 pl-4 py-2 my-4 bg-indigo-50 text-indigo-800 italic">
                            <p>Dengan array: <span class="font-semibold">let siswa = ["Hilmiy", "Budi", "Siti"];</span></p>
                        </blockquote>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Mengapa Array Itu Penting?</h3>
                        <p class="text-gray-700 mb-2">
                            Array adalah pondasi membuat aplikasi modern, terutama web. Digunakan untuk:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Menyimpan daftar nama atau nilai.</li>
                            <li>Menampung data yang diambil dari <span class="font-semibold">database</span>.</li>
                            <li>Melakukan <span class="font-semibold">looping data</span> dalam jumlah besar.</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Index pada Array</h3>
                        <p class="text-gray-700 mb-2">
                            Setiap data di dalam array punya nomor urut yang disebut index. <span class="font-semibold">Index selalu mulai dari 0</span>.
                        </p>
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Index</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Isi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-4 whitespace-nowrap">0</td><td class="px-6 py-4 whitespace-nowrap">"apel"</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap">1</td><td class="px-6 py-4 whitespace-nowrap">"mangga"</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap">2</td><td class="px-6 py-4 whitespace-nowrap">"pisang"</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">4. Cara Mengakses & Mengubah Data</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Mengambil 1 data: <span class="font-semibold">console.log(buah[0]);</span> // apel</li>
                            <li>Mengubah isi array: <span class="font-semibold">buah[1] = "jeruk";</span></li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">5. Menambah & Menghapus Data</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">.push()</span>: Menambah di belakang</li>
                            <li><span class="font-semibold">.unshift()</span>: Menambah di depan</li>
                            <li><span class="font-semibold">.pop()</span>: Menghapus data paling belakang</li>
                            <li><span class="font-semibold">.shift()</span>: Menghapus data paling depan</li>
                        </ul>
                    </div>

                    <hr class="border-gray-300 my-8">

                    <div class="mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Fungsi (Function)
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Fungsi adalah sebuah <span class="font-semibold">blok kode</span> yang dibuat untuk melakukan tugas tertentu dan bisa <span class="font-semibold">dipanggil berkali-kali</span> tanpa perlu menulis ulang kodenya.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Mengapa Fungsi Penting?</h3>
                        <p class="text-gray-700 mb-2">
                            Fungsi membantu kita membuat program lebih rapi, terstruktur, dan efisien.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Menghindari pengulangan kode (<span class="font-semibold">DRY — Don't Repeat Yourself</span>)</li>
                            <li>Mempermudah perawatan dan perbaikan (<span class="font-semibold">Maintenance</span>)</li>
                            <li>Membuat program lebih terstruktur</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Struktur Dasar Fungsi</h3>
                        <p class="text-gray-700 mb-2">
                            Terdiri dari <span class="font-semibold">Nama fungsi</span>, <span class="font-semibold">Parameter</span> (opsional), <span class="font-semibold">Proses/blok kode</span>, dan <span class="font-semibold">Return value</span> (opsional).
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>
                                fungsi nama_fungsi(parameter1, parameter2, ...) {
                                    // isi kode
                                    return hasil;
                                }
                            </code>
                        </pre>
                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Jenis-jenis Fungsi</h3>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">A. Fungsi Tanpa Parameter</h4>
                        <p class="text-gray-700 mb-2">
                            Tidak menerima input apa pun. Hanya menjalankan tugas yang sama setiap kali dipanggil.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>
                                function sapa():
                                    print("Halo, selamat belajar RPL!")
                            </code>
                        </pre>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">B. Fungsi Dengan Parameter</h4>
                        <p class="text-gray-700 mb-2">
                            Menerima input (argumen) untuk diolah. Membuat fungsi menjadi <span class="font-semibold">fleksibel</span>.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>
                            function hitungLuasPersegi(sisi) {
                                let luas = sisi * sisi;
                                return luas;
                            }

                            // Pemanggilan:
                            let hasil = hitungLuasPersegi(5);
                            </code>
                        </pre>
                    </div>

                    <hr class="border-gray-300 my-8">

                    <div class="mb-10">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            LOGIKA & PENYELESAIAN MASALAH DALAM PEMROGRAMAN
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Logika pemrograman adalah kemampuan untuk berpikir terstruktur, <span class="font-semibold">runtut</span>, dan <span class="font-semibold">masuk akal</span> dalam menyelesaikan suatu masalah.
                        </p>
                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Apa Itu Logika Pemrograman?</h3>
                        <p class="text-gray-700 mb-2">
                            Logika pemrograman adalah cara berpikir seperti komputer: jelas, <span class="font-semibold">tepat</span>, <span class="font-semibold">tidak ambigu</span>, dan berurutan. Logika ini ditulis dalam bentuk Percabangan, Perulangan, dan Operasi.
                        </p>
                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Apa Itu Penyelesaian Masalah (Problem Solving)?</h3>
                        <p class="text-gray-700 mb-2">
                            Problem solving adalah proses memahami masalah, menganalisis kebutuhan, lalu <span class="font-semibold">membuat solusi yang efektif</span> (algoritma/flowchart) sebelum coding. Programmer yang hebat adalah yang kuat di logika & penyelesaian masalah.
                        </p>
                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Tahapan Penyelesaian Masalah</h3>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">A. Memahami Masalah</h4>
                        <p class="text-gray-700 mb-2">
                            Tentukan <span class="font-semibold">Input</span>, <span class="font-semibold">Output</span>, dan <span class="font-semibold">Rumus/Proses</span> yang dibutuhkan. Tanpa ini, coding akan salah.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">B. Menganalisis & Menentukan Langkah (Algoritma)</h4>
                        <p class="text-gray-700 mb-2">
                            Tentukan langkah-langkah rinci (algoritma) sebelum menulis kode. Contoh untuk menghitung rata-rata:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Masukkan 3 angka.</li>
                            <li>Jumlahkan ketiganya.</li>
                            <li>Bagi hasilnya dengan 3.</li>
                            <li>Tampilkan rata-ratanya.</li>
                        </ul>
                    </div>
                    <!-- REFERENSI VIDEO MATERI 1 – ALGORITMA PEMROGRAMAN -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                <i class="fas fa-code"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran Materi 1 – Algoritma dalam Pemrograman
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Video ini menjelaskan pengertian dan pentingnya algoritma sebagai dasar
                            dalam menyusun program komputer sebelum menulis kode nyata — pendukung
                            pembelajaran.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/uqVJc9lLknA"
                                title="Algoritma dalam Pemrograman"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/uqVJc9lLknA"
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
                        Apa Itu Pemrograman Dasar?
                    </h2>

                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Pemrograman Dasar (PD) adalah mata pelajaran yang mengajarkan <span class="font-semibold">pondasi pertama</span> untuk menjadi seorang programmer.
                    </p>

                    <p class="text-gray-700 mb-4">
                        Di dalamnya, kita belajar bagaimana:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>komputer bekerja</li>
                        <li>cara memberi instruksi yang benar</li>
                        <li>membuat program sederhana</li>
                        <li>memahami logika dan algoritma</li>
                        <li>mengenal bahasa pemrograman</li>
                    </ul>

                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Pemrograman adalah <span class="font-semibold">seni memberi perintah kepada komputer</span> agar melakukan sesuatu sesuai langkah-langkah yang kita pikirkan.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Materi ini tidak fokus pada satu bahasa saja, tetapi fokus pada <span class="font-semibold">konsep universal</span> yang berlaku untuk semua bahasa pemrograman (C, Java, Python, Javascript, Pascal, dll.).
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">Tujuan Pemrograman Dasar</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>Membentuk pola pikir <span class="font-semibold">logis dan sistematis</span></li>
                        <li>Membiasakan siswa melakukan problem solving</li>
                        <li>Mengajarkan cara membuat algoritma</li>
                        <li>Mengajarkan dasar-dasar bahasa pemrograman</li>
                        <li>Menjadi bekal untuk mata pelajaran lanjutan seperti PBO, Basis Data, Web Programming, dll.</li>
                    </ul>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            1. Apa Itu Variabel?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Variabel adalah <span class="font-semibold">wadah atau tempat penyimpanan data</span> di dalam program. Komputer tidak bisa mengingat informasi tanpa variabel.
                        </p>
            
                        <h4 class="text-xl font-semibold text-blue-600 mb-2 mt-4">Contoh Nyata Variabel</h4>
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Variabel</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe Data</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-4 whitespace-nowrap">umur</td><td class="px-6 py-4 whitespace-nowrap">18</td><td class="px-6 py-4 whitespace-nowrap">Angka</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap">nama</td><td class="px-6 py-4 whitespace-nowrap">"Hilmiy"</td><td class="px-6 py-4 whitespace-nowrap">Teks/String</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap">status_login</td><td class="px-6 py-4 whitespace-nowrap">true</td><td class="px-6 py-4 whitespace-nowrap">Boolean</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Cara Kerja Variabel</h3>
                        <p class="text-gray-700 mb-2">
                            Saat kamu menulis <span class="font-semibold">umur = 18</span>, komputer akan:
                        </p>
                        <ol class="list-decimal list-inside space-y-1 text-gray-600 ml-6 mb-4">
                            <li>Menyediakan ruang di memori.</li>
                            <li>Memberi label ruang itu dengan nama <span class="font-semibold">umur</span>.</li>
                            <li>Menyimpan angka <span class="font-semibold">18</span> ke dalamnya.</li>
                        </ol>
                        <p class="text-gray-700 mb-2">
                            Untuk memanggil nilainya, cukup gunakan:
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>print(umur)</code></pre>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Aturan Penamaan Variabel</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Harus diawali huruf atau underscore</span> ($\checkmark$ nama1, $\checkmark$ \_nilai, $\times$ 1nama).</li>
                            <li><span class="font-semibold">Tidak boleh ada spasi</span> ($\checkmark$ total\_harga, $\times$ total harga).</li>
                            <li>Gunakan nama yang jelas (<span class="font-semibold">nilai\_siswa</span> lebih baik daripada <span class="font-semibold">x</span>).</li>
                            <li>Bersifat <span class="font-semibold">case-sensitive</span> (nama, Nama, dan NAMA dianggap berbeda).</li>
                        </ul>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            4. Tipe Data
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Tipe data adalah <span class="font-semibold">jenis nilai</span> yang disimpan di variabel. Tipe data membantu komputer mengelola memori dan operasi yang bisa dilakukan pada nilai tersebut.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">A. Tipe Data Angka (Number)</h3>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. Integer (int)</h4>
                        <p class="text-gray-700 mb-2">
                            Angka <span class="font-semibold">bulat tanpa koma</span>. (Contoh: 5, -10, 2024).
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. Float / Double</h4>
                        <p class="text-gray-700 mb-4">
                            Angka <span class="font-semibold">berkoma/desimal</span>. (Contoh: 10.5, 3.14, 99.99).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">B. Tipe Data Teks (String)</h3>
                        <p class="text-gray-700 mb-4">
                            Menyimpan kalimat atau tulisan. (Contoh: <span class="font-semibold">"Hilmiy"</span>, <span class="font-semibold">"Teknik Komputer"</span>).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">C. Tipe Data Karakter (Char)</h3>
                        <p class="text-gray-700 mb-4">
                            Menyimpan <span class="font-semibold">satu huruf saja</span>. (Contoh: 'A', 'B', '9').
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">D. Tipe Data Boolean</h3>
                        <p class="text-gray-700 mb-2">
                            Hanya punya dua nilai: <span class="font-semibold">true</span> (benar) atau <span class="font-semibold">false</span> (salah). Sangat berguna untuk <span class="font-semibold">percabangan (if/else)</span>.
                        </p>
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bahasa</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contoh (Boolean)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-4 whitespace-nowrap">C</td><td class="px-6 py-4 whitespace-nowrap">bool status = true;</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap">Java</td><td class="px-6 py-4 whitespace-nowrap">boolean login = false;</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap">Python</td><td class="px-6 py-4 whitespace-nowrap">login = True</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Operator dalam Pemrograman Dasar
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Operator adalah simbol atau tanda khusus yang digunakan untuk melakukan suatu proses pada data atau variabel. Anggap operator sebagai <span class="font-semibold">“alat kerja”</span> komputer.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Operator Aritmatika</h3>
                        <p class="text-gray-700 mb-2">
                            Digunakan untuk operasi matematika dasar.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">+</span> $\rightarrow$ penjumlahan</li>
                            <li><span class="font-semibold">-</span> $\rightarrow$ pengurangan</li>
                            <li><span class="font-semibold">*</span> $\rightarrow$ perkalian</li>
                            <li><span class="font-semibold">/</span> $\rightarrow$ pembagian</li>
                            <li><span class="font-semibold">%</span> $\rightarrow$ <span class="font-semibold">modulus</span> (menghasilkan sisa pembagian)</li>
                        </ul>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>let x = 10;
                                    let y = 3;
                                    console.log(x % y); // hasil: 1 (sisa bagi)
                            </code>
                        </pre>
                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Operator Penugasan (Assignment)</h3>
                        <p class="text-gray-700 mb-2">
                            Berfungsi untuk memberikan nilai ke variabel.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">=</span> $\rightarrow$ memberi nilai (contoh: a = 5;)</li>
                            <li><span class="font-semibold">+=</span> $\rightarrow$ penugasan gabungan (a += 3; sama dengan a = a + 3;)</li>
                            <li><span class="font-semibold">-=</span>, <span class="font-semibold">*=</span>, <span class="font-semibold">/=</span> $\rightarrow$ pengurangan, perkalian, pembagian gabungan.</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Operator Perbandingan</h3>
                        <p class="text-gray-700 mb-2">
                            Digunakan untuk membandingkan dua nilai, hasilnya selalu <span class="font-semibold">true</span> atau <span class="font-semibold">false</span>.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">==</span> $\rightarrow$ sama dengan</li>
                            <li><span class="font-semibold">!=</span> $\rightarrow$ tidak sama dengan</li>
                            <li><span class="font-semibold">></span>, <span class="font-semibold"><</span>, <span class="font-semibold">>=</span>, <span class="font-semibold"><=</span> $\rightarrow$ perbandingan ukuran</li>
                        </ul>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>let umur = 17;
                                    console.log(umur >= 17); // true
                            </code>
                        </pre>
                        <h3 class="text-xl font-bold text-blue-700 mb-4">4. Operator Logika</h3>
                        <p class="text-gray-700 mb-2">
                            Digunakan untuk menggabungkan atau memeriksa kondisi yang lebih kompleks.
                        </p>
                        
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">&& (AND)</span> $\rightarrow$ benar jika <span class="font-semibold">keduanya benar</span>.</li>
                            <li><span class="font-semibold">|| (OR)</span> $\rightarrow$ benar jika <span class="font-semibold">salah satu benar</span>.</li>
                            <li><span class="font-semibold">! (NOT)</span> $\rightarrow$ membalik nilai logika (true jadi false).</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">5. Operator Increment & Decrement</h3>
                        <p class="text-gray-700 mb-2">
                            Sering digunakan dalam perulangan untuk menambah atau mengurangi nilai variabel sebanyak 1.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">++</span> $\rightarrow$ menaikkan nilai 1 (angka++;)</li>
                            <li><span class="font-semibold">--</span> $\rightarrow$ menurunkan nilai 1 (angka--;)</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">6. Operator untuk String (Konkatenasi)</h3>
                        <p class="text-gray-700 mb-4">
                            Operator <span class="font-semibold">+</span> sering dipakai untuk <span class="font-semibold">menggabungkan dua teks</span> (string).
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>let nama = "Hilmiy";
                                    let pesan = "Halo " + nama; // menggabungkan teks
                                    console.log(pesan); // Halo Hilmiy
                            </code>
                        </pre>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Input & Output dalam Pemrograman Dasar
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Input dan Output adalah pondasi penting agar program bisa <span class="font-semibold">interaktif</span>.
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Input</span> $\rightarrow$ data yang dimasukkan <span class="font-semibold">pengguna</span> ke program.</li>
                            <li><span class="font-semibold">Output</span> $\rightarrow$ hasil yang ditampilkan <span class="font-semibold">program</span> ke pengguna.</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Apa itu Input?</h3>
                        <p class="text-gray-700 mb-2">
                            Input adalah proses mengambil data dari pengguna (nama, umur, pilihan menu, dll.) agar bisa diproses. Setiap bahasa pemrograman memiliki fungsi input yang berbeda, namun <span class="font-semibold">konsepnya sama</span>.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Input Berdasarkan Bahasa:</h4>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>// Python
                                nama = input("Masukkan nama Anda: ")

                                // JavaScript (Browser)
                                let nama = prompt("Masukkan nama Anda:");

                                // Java
                                Scanner input = new Scanner(System.in);
                                String nama = input.nextLine();
                            </code>
                        </pre>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Apa itu Output?</h3>
                        <p class="text-gray-700 mb-2">
                            Output adalah informasi (teks, angka, hasil perhitungan) yang ditampilkan program kepada pengguna.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Output Berdasarkan Bahasa:</h4>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>// Python
                            print("Halo,", nama)

                            // JavaScript
                            console.log("Halo " + nama);

                            // Java
                            System.out.println("Halo " + nama);
                            </code>
                        </pre>

                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Struktur Data Sederhana
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Struktur data adalah cara mengatur, menyimpan, dan mengelola data agar program bisa bekerja lebih efisien. Ini adalah fondasi sebelum mempelajari struktur data kompleks.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Variabel (Menyimpan Satu Data)</h3>
                        <p class="text-gray-700 mb-4">
                            Tempat untuk menyimpan <span class="font-semibold">satu nilai</span> saja. (Contoh: `let nama = "Hilmiy";`).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Array (Menyimpan Banyak Nilai)</h3>
                        <p class="text-gray-700 mb-2">
                            Digunakan untuk menyimpan <span class="font-semibold">banyak nilai</span> yang sejenis atau berhubungan dalam satu tempat.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>let nilai = [80, 75, 90, 88];</code></pre>
        
                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Object (Struktur Berpasangan: Key–Value)</h3>
                        <p class="text-gray-700 mb-2">
                            Digunakan untuk menyimpan data yang lebih kompleks dan memiliki <span class="font-semibold">atribut (key)</span>. Cocok untuk informasi detail tentang satu entitas (1 siswa, 1 produk, dll.).
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>let i = 1;
                            while (i <= 5) {
                                console.log(i);
                                i++; // PENTING: harus ada increment/decrement agar tidak menjadi infinite loop
                            }
                            </code>
                        </pre>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">4. Map / Dictionary (Pasangan Key $\rightarrow$ Value)</h3>
                        <p class="text-gray-700 mb-2">
                            Mirip Object, berisi pasangan kunci dan nilai. Sangat berguna untuk data berpasangan secara rapi. (Umum di Python dan Java).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">5. List (di Python) & Tuple (di Python)</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">List</span>: Mirip array, tetapi bisa berisi tipe data campuran (fleksibel).</li>
                            <li><span class="font-semibold">Tuple</span>: Mirip List, tetapi <span class="font-semibold">nilainya tidak bisa diubah</span> (Immutable).</li>
                        </ul>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa itu Error Handling?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Error Handling adalah teknik untuk <span class="font-semibold">menangani kesalahan</span> yang terjadi saat program berjalan (runtime). Tujuannya agar program <span class="font-semibold">tidak berhenti mendadak</span> dan user mendapatkan pesan yang jelas.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Jenis-Jenis Error dalam Pemrograman</h3>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. Syntax Error</h4>
                        <p class="text-gray-700 mb-2">
                            Kesalahan pada <span class="font-semibold">penulisan kode</span> (kurang titik koma, salah tanda kurung, dll.). Program tidak akan bisa berjalan.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. Runtime Error</h4>
                        <p class="text-gray-700 mb-2">
                            Error yang muncul <span class="font-semibold">saat program sedang dijalankan</span>. (Contoh: membagi angka dengan nol, mengakses array yang tidak ada). Ini bisa membuat program *crash* jika tidak ditangani.
                        </p>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">3. Logical Error</h4>
                        <p class="text-gray-700 mb-4">
                            Kode tidak error, tetapi <span class="font-semibold">hasilnya salah</span> karena menggunakan rumus atau logika yang keliru. Ini error paling sulit dideteksi.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Kenapa Error Handling Penting?</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Melindungi dari input pengguna yang salah.</li>
                            <li>Menjaga program tetap berjalan meski server *timeout* atau file tidak ditemukan.</li>
                            <li>Membuat aplikasi terlihat <span class="font-semibold">stabil dan profesional</span>.</li>
                        </ul>
                    </div>
                    <!-- REFERENSI VIDEO MATERI 2 RPL -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-teal-100 text-teal-600">
                                <i class="fas fa-video"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran Materi 2 RPL
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Silakan tonton video berikut sebagai media pembelajaran untuk Materi 2 RPL.
                            Kamu bisa menambahkan judul materi yang sesuai jika sudah tahu isinya dari video ini.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/1oN7JxLTVzA"
                                title="Video Pembelajaran Materi 2 RPL"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/1oN7JxLTVzA"
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
                        Apa Itu Pemrograman Web?
                    </h2>

                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Pemrograman Web adalah proses membuat sebuah website agar bisa tampil di browser (<span class="font-semibold">Chrome, Firefox, Edge</span>) dan dapat digunakan oleh pengguna.
                    </p>
                    <p class="text-gray-700 mb-4">
                        Dalam pemrograman web, kita membuat dua hal utama:
                    </p>
                    

                    <h3 class="text-xl font-bold text-blue-700 mb-4 mt-6">1. Bagian Tampilan (Frontend)</h3>
                    <p class="text-gray-700 mb-2">
                        Ini adalah bagian yang <span class="font-semibold">langsung dilihat dan digunakan oleh user</span> (Client-side).
                    </p>
                    <p class="text-gray-700 mb-2">
                        Tugas frontend adalah mengatur:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>Teks, gambar, warna, dan layout</li>
                        <li>Tombol, form, menu navigasi</li>
                        <li><span class="font-semibold">Interaksi</span> yang terjadi di halaman (klik, animasi, pop up)</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Bagian Logika & Server (Backend)</h3>
                    <p class="text-gray-700 mb-2">
                        Ini adalah bagian <span class="font-semibold">"di belakang layar"</span> (Server-side) yang tidak dilihat user.
                    </p>
                    <p class="text-gray-700 mb-2">
                        Tugas backend adalah mengatur:
                    </p>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>Penyimpanan data ke <span class="font-semibold">database</span></li>
                        <li>Login, register, dan keamanan data</li>
                        <li>Proses perhitungan, pengiriman data, validasi</li>
                        <li>Menghubungkan website dengan server dan API</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">Bahasa yang Dipakai dalam Pemrograman Web</h3>
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bagian</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas Utama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bahasa Populer</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Frontend</span></td><td class="px-6 py-4 whitespace-nowrap">Struktur, Desain, Interaksi</td><td class="px-6 py-4 whitespace-nowrap">HTML, CSS, JavaScript</td></tr>
                                <tr><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Backend</span></td><td class="px-6 py-4 whitespace-nowrap">Logika, Database, Keamanan</td><td class="px-6 py-4 whitespace-nowrap">PHP, Node.js, Python, Java</td></tr>
                                <tr><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Database</span></td><td class="px-6 py-4 whitespace-nowrap">Penyimpanan Data</td><td class="px-6 py-4 whitespace-nowrap">MySQL, PostgreSQL, MongoDB</td></tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu HTML?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            HTML (<span class="font-semibold">HyperText Markup Language</span>) adalah bahasa dasar untuk membuat <span class="font-semibold">struktur</span> sebuah halaman website.
                        </p>
                        <blockquote class="border-l-4 border-yellow-500 pl-4 py-2 my-4 bg-yellow-50 text-yellow-800 italic">
                            <p>Bayangkan HTML seperti <span class="font-semibold">rangka bangunan</span> (tulang), CSS seperti dekorasinya, dan JavaScript seperti mesin otomatisnya.</p>
                        </blockquote>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Fungsi Utama HTML</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Membuat struktur halaman web (<span class="font-semibold">header, konten, footer</span>).</li>
                            <li>Menampilkan teks, gambar, tombol, dan form.</li>
                            <li>Menyusun dokumen web agar browser bisa membacanya.</li>
                            <li>Menjadi dasar untuk semua teknologi web lain.</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Struktur Dasar HTML</h3>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>&lt;!DOCTYPE html>
                            &lt;html>
                            &lt;head>
                                &lt;title>Judul Halaman&lt;/title>
                            &lt;/head>
                            &lt;body>
                                &lt;h1>Halo Dunia!&lt;/h1>
                            &lt;/body>
                            &lt;/html></code>
                        </pre>
                        <p class="text-gray-700 mb-2">
                            Konten yang terlihat di layar harus berada di dalam tag <span class="font-semibold">`&lt;body>`</span>.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Elemen Penting HTML (Tag)</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">`&lt;h1>` - `&lt;h6>`</span>: Judul dan sub judul.</li>
                            <li><span class="font-semibold">`&lt;p>`</span>: Paragraf teks.</li>
                            <li><span class="font-semibold">`&lt;img src="...">`</span>: Gambar.</li>
                            <li><span class="font-semibold">`&lt;a href="...">`</span>: Link (tautan).</li>
                            <li>Struktur Semantik: <span class="font-semibold">`&lt;header>`, `&lt;footer>`, `&lt;nav>`, `&lt;main>`</span> untuk pembagian halaman yang jelas.</li>
                            <li><span class="font-semibold">`&lt;input>`</span>: Untuk form input user.</li>
                        </ul>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu CSS?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            CSS (<span class="font-semibold">Cascading Style Sheets</span>) adalah bahasa untuk mengatur <span class="font-semibold">tampilan, warna, layout, dan desain</span> pada website.
                        </p>
                        <p class="text-gray-700 mb-4">
                            Website tanpa CSS akan terlihat polos seperti dokumen biasa. CSS membuat halaman terlihat <span class="font-semibold">menarik dan profesional</span>.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Fungsi Utama CSS</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Mengatur warna teks, background, dan tombol.</li>
                            <li>Mengatur ukuran dan jenis font (<span class="font-semibold">Typography</span>).</li>
                            <li>Membuat <span class="font-semibold">layout</span> (misalnya membagi halaman 2 kolom).</li>
                            <li>Membuat desain <span class="font-semibold">responsif</span> (tampilan bagus di HP & laptop).</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Dasar Penulisan CSS</h3>
                        <p class="text-gray-700 mb-2">
                            Format dasar: <span class="font-semibold">`selector { property: value; }`</span>
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>p {
                                color: red;        /* property: color, value: red */
                                font-size: 18px;   /* property: font-size, value: 18px */
                            }</code></pre>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Bagian Penting Dalam CSS</h4>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Selector</span>: Memilih elemen yang ingin didesain (`p`, `.judul`, `#header`).</li>
                            <li><span class="font-semibold">Box Model</span>: Konsep bahwa setiap elemen adalah kotak yang memiliki <span class="font-semibold">margin</span> (jarak luar), <span class="font-semibold">border</span> (garis), dan <span class="font-semibold">padding</span> (jarak dalam). </li>
                            <li><span class="font-semibold">Layout</span>: Pengaturan tata letak modern (menggunakan Flexbox & Grid).</li>
                            <li><span class="font-semibold">Efek Hover</span>: Mengubah desain saat mouse diarahkan (`button:hover`).</li>
                        </ul>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu JavaScript?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            JavaScript adalah bahasa pemrograman yang digunakan untuk membuat website <span class="font-semibold">interaktif dan dinamis</span>.
                        </p>
                        <p class="text-gray-700 mb-4">
                            JavaScript adalah <span class="font-semibold">mesin</span> yang membuat website bisa bergerak, merespons, dan berinteraksi dengan user.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Fungsi Utama JavaScript</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Merespons <span class="font-semibold">klik tombol</span> dan *event* user lainnya.</li>
                            <li>Memvalidasi form input user.</li>
                            <li>Mengubah konten halaman secara <span class="font-semibold">dinamis</span> tanpa *reload*.</li>
                            <li>Membuat efek animasi dan pop-up.</li>
                            <li>Dasar untuk Frontend Framework modern (React, Vue, Angular).</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Cara Menghubungkan JavaScript ke HTML</h3>
                        <p class="text-gray-700 mb-2">
                            Cara paling disarankan adalah <span class="font-semibold">Eksternal</span>:
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>&lt;script src="script.js">&lt;/script></code></pre>
                        <p class="text-gray-700 mb-2">
                            Contoh *inline* (jarang dipakai):
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>&lt;button onclick="alert('Halo!')">Klik Aku&lt;/button></code></pre>
                    </div>


                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Layouting & Responsive Design
                        </h2>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Apa Itu Layouting?</h3>
                        <p class="text-gray-700 mb-2">
                            Layouting adalah cara menyusun elemen-elemen di halaman web agar terlihat <span class="font-semibold">rapi, terstruktur, dan mudah dibaca</span> (header, menu, konten, sidebar, footer).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Apa Itu Responsive Web Design?</h3>
                        <p class="text-gray-700 mb-2">
                            Responsive design membuat website tampil baik di <span class="font-semibold">semua perangkat</span> (HP, tablet, laptop).
                        </p>
                        <blockquote class="border-l-4 border-indigo-500 pl-4 py-2 my-4 bg-indigo-50 text-indigo-800 italic">
                            <p>Contoh: website 3 kolom di desktop $\rightarrow$ otomatis menjadi 1 kolom di HP.</p>
                        </blockquote>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Flexbox dan Grid (Alat Layout Modern)</h3>
                        <p class="text-gray-700 mb-2">
                            Keduanya adalah teknik CSS modern untuk membuat layout yang terstruktur dan responsif.
                        </p>
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fitur</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Flexbox</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grid</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-4 whitespace-nowrap">Dimensi</td><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Satu dimensi</span> (baris / kolom)</td><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Dua dimensi</span> (baris + kolom)</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap">Kelebihan</td><td class="px-6 py-4 whitespace-nowrap">Sederhana, mudah meratakan item</td><td class="px-6 py-4 whitespace-nowrap">Mengatur layout kompleks (dashboard)</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Intinya:</h3>
                        <p class="text-gray-700 mb-2">
                            Kombinasi <span class="font-semibold">HTML + CSS + JavaScript</span> menghasilkan website fungsional.
                        </p>
                        <p class="text-gray-700 mb-4">
                            Kombinasi <span class="font-semibold">Flexbox + Grid + Responsive</span> menghasilkan website yang rapi dan nyaman diakses di HP maupun laptop.
                        </p>
                    </div>
                    <!-- REFERENSI VIDEO MATERI 3 RPL -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-indigo-100 text-indigo-600">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran Materi 3 RPL
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut sebagai penunjang pembelajaran.  
                            Jika tahu judul atau topik video ini, kamu boleh menyesuaikannya di sini.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/t8Nxs7F4qEM"
                                title="Video Pembelajaran Materi 3 RPL"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/t8Nxs7F4qEM"
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
                        Apa Itu Database?
                    </h2>

                    <p class="text-gray-700 mb-2 leading-relaxed">
                        Database adalah tempat menyimpan data secara <span class="font-semibold">terstruktur</span> sehingga bisa dikelola, dicari, dan diperbarui dengan mudah.
                    </p>
                    <blockquote class="border-l-4 border-yellow-500 pl-4 py-2 my-4 bg-yellow-50 text-yellow-800 italic">
                        <p>Bayangkan database seperti <span class="font-semibold">lemari arsip digital</span>: Laci $\rightarrow$ Tabel, Folder $\rightarrow$ Record, Label $\rightarrow$ Kolom.</p>
                    </blockquote>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">1. Fungsi Database</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Menyimpan & Mengelola data</span> (menambah, mengubah, menghapus, mencari).</li>
                        <li>Memastikan keamanan data.</li>
                        <li>Mendukung aplikasi (website, mobile, sistem informasi).</li>
                    </ul>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Komponen Utama Database</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Tabel</span>: Tempat menyimpan data (contoh: siswa, produk).</li>
                        <li><span class="font-semibold">Baris / Record</span>: Satu data lengkap (contoh: satu siswa).</li>
                        <li><span class="font-semibold">Kolom / Field</span>: Jenis data tertentu (contoh: nama, umur).</li>
                        <li><span class="font-semibold">Primary Key (PK)</span>: Kolom unik yang membedakan setiap record (contoh: id\_siswa).</li>
                        <li><span class="font-semibold">Relasi</span>: Hubungan antar tabel agar data terintegrasi.</li>
                    </ul>      

                    <h3 class="text-xl font-bold text-blue-700 mb-4">3. Jenis Database</h3>
                    <h4 class="text-xl font-semibold text-blue-600 mb-2">A. Berdasarkan Struktur</h4>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li><span class="font-semibold">Relasional (RDBMS)</span>: Data tersimpan dalam tabel dan bisa berelasi. (Contoh: MySQL, PostgreSQL).</li>
                        <li><span class="font-semibold">Non-relasional (NoSQL)</span>: Data lebih fleksibel, tidak tersusun tabel. (Contoh: MongoDB, Firebase).</li>
                    </ul>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu ERD?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            ERD (<span class="font-semibold">Entity Relationship Diagram</span>) adalah diagram yang digunakan untuk <span class="font-semibold">memodelkan hubungan antar data</span> dalam sebuah sistem atau database.
                        </p>
                        <p class="text-gray-700 mb-4">
                            ERD membantu kita merancang database <span class="font-semibold">sebelum</span> membuat tabel di sistem (MySQL, dsb).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Komponen Utama ERD</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Entity</span>: Objek nyata yang datanya disimpan (digambarkan kotak). Contoh: <code class="font-semibold">Siswa</code>, <code class="font-semibold">Guru</code>.</li>
                            <li><span class="font-semibold">Attribute</span>: Informasi atau properti dari entity (oval). Contoh: <code class="font-semibold">nama</code>, <code class="font-semibold">umur</code>.</li>
                            <li><span class="font-semibold">Relationship</span>: Hubungan antar entity (garis).</li>
                        </ul>
                        

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Kardinalitas (Jenis Hubungan)</h4>
                        <p class="text-gray-700 mb-2">
                            Hubungan antar entity memiliki jenis kardinalitas:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">One-to-One (1:1)</span>: Satu A dengan satu B.</li>
                            <li><span class="font-semibold">One-to-Many (1:N)</span>: Satu A dengan banyak B (Paling umum).</li>
                            <li><span class="font-semibold">Many-to-Many (M:N)</span>: Banyak A dengan banyak B.</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Manfaat ERD</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Membantu <span class="font-semibold">merancang database secara jelas</span>.</li>
                            <li>Memudahkan komunikasi dan dokumentasi sistem.</li>
                            <li>Mengurangi kesalahan saat membuat tabel dan relasi.</li>
                        </ul>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu SQL?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            SQL (<span class="font-semibold">Structured Query Language</span>) adalah bahasa yang digunakan untuk <span class="font-semibold">mengelola dan mengambil data</span> dari database relasional (RDBMS).
                        </p>
                        <p class="text-gray-700 mb-4">
                            Semua database relasional (MySQL, PostgreSQL, Oracle) menggunakan bahasa ini.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Perintah Dasar SQL (CRUD)</h3>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">1. SELECT – Menampilkan Data (Read)</h4>
                        <p class="text-gray-700 mb-2">
                            Mengambil data dari tabel. Gunakan <code class="font-semibold">*</code> untuk semua kolom.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>SELECT nama, umur FROM siswa; SELECT * FROM siswa;</code></pre>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">2. INSERT – Menambahkan Data (Create)</h4>
                        <p class="text-gray-700 mb-2">
                            Menambah record baru ke tabel.
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>INSERT INTO siswa (nama, umur) VALUES ('Andi', 17);</code></pre>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">3. UPDATE – Mengubah Data (Update)</h4>
                        <p class="text-gray-700 mb-2">
                            Mengubah data yang sudah ada. Wajib pakai <code class="font-semibold">WHERE</code> agar tidak semua data berubah!
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>UPDATE siswa SET umur = 18 WHERE nama = 'Andi';</code></pre>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">4. DELETE – Menghapus Data (Delete)</h4>
                        <p class="text-gray-700 mb-2">
                            Menghapus record. Wajib pakai <code class="font-semibold">WHERE</code> agar tidak semua data terhapus!
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4"><code>DELETE FROM siswa WHERE nama = 'Andi';</code></pre>
                    </div>

                    ---

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu Relasi Tabel?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Relasi tabel adalah <span class="font-semibold">hubungan antara dua tabel</span> di database agar data terkoneksi dengan benar, membuat database lebih rapi dan efisien.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. One-to-One (1:1)</h3>
                        <p class="text-gray-700 mb-4">
                            Setiap record A berhubungan dengan <span class="font-semibold">satu record B</span>, dan sebaliknya. (Contoh: Tabel Siswa dengan Tabel Biodata Tambahan).
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. One-to-Many (1:N)</h3>
                        <p class="text-gray-700 mb-2">
                            Setiap record di tabel A bisa berhubungan dengan <span class="font-semibold">banyak record di tabel B</span>. (Contoh: Satu Kelas $\rightarrow$ Banyak Siswa).
                        </p>
                        <p class="text-gray-700 mb-2">
                            Ini dicapai dengan:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Tabel "Satu" memiliki <span class="font-semibold">Primary Key (PK)</span>. (Contoh: <code class="font-semibold">Kelas.id_kelas</code>)</li>
                            <li>Tabel "Banyak" memiliki <span class="font-semibold">Foreign Key (FK)</span> yang merujuk ke PK tabel pertama. (Contoh: <code class="font-semibold">Siswa.id_kelas</code>)</li>
                        </ul>
                        
                    </div>

                    ---

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            MySQL & MariaDB
                        </h2>
                        <p class="text-gray-700 mb-2">
                            MySQL dan MariaDB adalah sistem manajemen basis data <span class="font-semibold">relasional (RDBMS)</span> yang paling populer, menggunakan SQL untuk mengelola data.
                        </p>
                        <p class="text-gray-700 mb-4">
                            MariaDB adalah versi lanjutan (*fork*) yang bersifat <span class="font-semibold">100% open source</span> dan sering dianggap lebih cepat.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">1. Fungsi Utama</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li>Menyimpan dan mengelola data aplikasi web/sistem informasi.</li>
                            <li>Menangani query CRUD (SELECT, INSERT, UPDATE, DELETE).</li>
                            <li>Mendukung <span class="font-semibold">multi-user access</span>, backup, dan keamanan.</li>
                            <li>Dapat dihubungkan dengan PHP, Python, Java, Node.js, dll.</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">2. Kelebihan Singkat</h3>
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RDBMS</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelebihan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">MySQL</span></td><td class="px-6 py-4 whitespace-nowrap">Populer, banyak tutorial, stabil di industri.</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">MariaDB</span></td><td class="px-6 py-4 whitespace-nowrap">Gratis, lebih cepat, kompatibel dengan MySQL.</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">3. Cara Akses</h3>
                        <p class="text-gray-700 mb-2">
                            Database ini dapat diakses melalui:
                        </p>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Command Line</span> (terminal).</li>
                            <li><span class="font-semibold">GUI Tool</span> (phpMyAdmin, HeidiSQL, DBeaver).</li>
                            <li>Kode aplikasi (melalui konektor PHP, Python, dll.).</li>
                        </ul>
                    </div>
                    <!-- REFERENSI VIDEO DATABASE – MATERI RPL -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                                <i class="fas fa-database"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Apa Itu Database?
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami pengertian dan konsep dasar database.  
                            Video ini cocok sebagai tambahan materi pembelajaran agar siswa RPL lebih paham tentang database.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/rKaq-WeHRqE"
                                title="Apa Itu Database? – Materi RPL"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/rKaq-WeHRqE"
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
                        Apa Itu Backend Web?
                    </h2>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        Backend adalah bagian dari website yang <span class="font-semibold">tidak terlihat langsung oleh user</span>, tapi mengatur <span class="font-semibold">semua logika, penyimpanan data, dan interaksi dengan database</span>.
                    </p>
                    
                    <h3 class="text-xl font-bold text-blue-700 mb-4">2. Apa Itu PHP Native?</h3>
                    <p class="text-gray-700 mb-2">
                        PHP Native artinya menggunakan <span class="font-semibold">PHP murni tanpa framework</span>. Kode ditulis langsung di file <code class="font-semibold">.php</code>, cocok untuk latihan membuat aplikasi web sederhana (CRUD, login, dll).
                    </p>

                    <h3 class="text-xl font-bold text-blue-700 mb-4">3. Fungsi PHP di Web</h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                        <li>Memproses form user (login, pendaftaran).</li>
                        <li>Menghubungkan ke database (MySQL/MariaDB).</li>
                        <li>Membuat <span class="font-semibold">CRUD</span> (Create, Read, Update, Delete).</li>
                        <li>Membuat <span class="font-semibold">Session & Login System</span> (autentikasi).</li>
                    </ul>

                    <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Dasar PHP Native:</h4>
                    <p class="text-gray-700 mb-2">
                        Contoh koneksi database sederhana:
                    </p>
                    <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                        <code>&lt;?php
                        $host = "localhost";
                        $user = "root";
                        $database = "sekolah";
                        $conn = mysqli_connect($host, $user, "", $database);
                        if (!$conn) {
                            die("Koneksi gagal: " . mysqli_connect_error());
                        }
                        echo "Koneksi berhasil!";
                        ?></code>
                    </pre>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu Framework PHP?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Framework adalah <span class="font-semibold">kerangka kerja atau struktur siap pakai</span> (berbasis aturan) untuk mempermudah pembuatan aplikasi web.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Keuntungan Menggunakan Framework</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Efisiensi waktu</span> (fitur bawaan seperti *routing* dan *database*).</li>
                            <li>Struktur project lebih <span class="font-semibold">rapi dan mudah dikelola</span>.</li>
                            <li><span class="font-semibold">Meningkatkan keamanan</span> (proteksi SQL Injection, CSRF).</li>
                        </ul>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Laravel dan CodeIgniter</h3>
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Laravel (Modern & Kompleks)</h4>
                        <p class="text-gray-700 mb-2">
                            Framework modern berbasis MVC (Model-View-Controller). Fitur andalan: Eloquent ORM (memudahkan database) dan Blade (*template engine*).
                        </p>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>// Contoh Routing Laravel
                                Route::get('/siswa', [SiswaController::class, 'index']);</code></pre>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">CodeIgniter (Ringan & Pemula)</h4>
                        <p class="text-gray-700 mb-4">
                            Framework berbasis MVC yang lebih <span class="font-semibold">ringan dan mudah dipelajari</span>. Cocok untuk pemula dan proyek sederhana.
                        </p>
                        
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Perbandingan:</h4>
                        <div class="overflow-x-auto mb-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-blue-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Framework</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelebihan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cocok Untuk</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">Laravel</span></td><td class="px-6 py-4 whitespace-nowrap">Modern, fitur lengkap, Eloquent ORM.</td><td class="px-6 py-4 whitespace-nowrap">Aplikasi besar & kompleks.</td></tr>
                                    <tr><td class="px-6 py-4 whitespace-nowrap"><span class="font-semibold">CodeIgniter</span></td><td class="px-6 py-4 whitespace-nowrap">Ringan, mudah dipelajari, cepat.</td><td class="px-6 py-4 whitespace-nowrap">Pemula & aplikasi sederhana.</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Apa Itu REST API?
                        </h2>
                        <p class="text-gray-700 mb-2">
                            REST API (Representational State Transfer – Application Programming Interface) adalah <span class="font-semibold">cara aplikasi saling berkomunikasi</span> (mengirim dan menerima data) melalui internet. Data biasanya dalam format JSON atau XML.
                        </p>
                        
                        <h3 class="text-xl font-bold text-blue-700 mb-4">Konsep Dasar REST API</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">Resource</span>: Data yang bisa diakses (misal: <code class="font-semibold">siswa</code>, <code class="font-semibold">produk</code>).</li>
                            <li><span class="font-semibold">Endpoint/URL</span>: Alamat akses resource (misal: <code class="font-semibold">/api.sekolah.com/siswa</code>).</li>
                            <li><span class="font-semibold">HTTP Method</span>: Jenis aksi yang dilakukan:
                                <ul class="list-circle list-inside ml-6">
                                    <li>GET: Mengambil data (Read)</li>
                                    <li>POST: Menambah data baru (Create)</li>
                                    <li>PUT: Mengubah data (Update)</li>
                                    <li>DELETE: Menghapus data (Delete)</li>
                                </ul>
                            </li>
                        </ul>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Response JSON:</h4>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>[
                            { "id": 1, "nama": "Hilmiy", "umur": 18 },
                            { "id": 2, "nama": "Budi", "umur": 17 }
                            ]</code></pre>
                    </div>

                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            Autentikasi & Session
                        </h2>
                        <p class="text-gray-700 mb-2">
                            Autentikasi adalah proses <span class="font-semibold">memastikan identitas pengguna</span> (melalui login) sebelum diberikan akses ke sistem.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Apa Itu Session?</h3>
                        <p class="text-gray-700 mb-4">
                            Session adalah mekanisme PHP untuk <span class="font-semibold">menyimpan data sementara di server</span> tentang user yang sedang aktif (status login, level user). Data ini hilang saat *logout* atau browser ditutup.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Alur Session di PHP Native</h3>
                        <ol class="list-decimal list-inside space-y-1 text-gray-600 ml-6 mb-4">
                            <li>User login $\rightarrow$ PHP cek database.</li>
                            <li>Jika cocok $\rightarrow$ PHP membuat session (<code class="font-semibold">session_start()</code>).</li>
                            <li>Data status login disimpan di <code class="font-semibold">$_SESSION</code>.</li>
                            <li>Setiap halaman memverifikasi <code class="font-semibold">$_SESSION</code> untuk izin akses.</li>
                            <li>Saat logout, session dihapus (<code class="font-semibold">session_destroy()</code>).</li>
                        </ol>
                        
                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh Cek Session (Dashboard):</h4>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>&lt;?php
                            session_start();
                            if (!isset($_SESSION['user_id'])) {
                                // Redirect jika belum login
                                header("Location: login.php");
                                exit;
                            }
                            echo "Selamat datang, " . $_SESSION['username'];
                            ?></code></pre>
                    </div>
                    
                    <div class="mb-10 pt-4">
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">
                            CRUD – Pengertian Singkat
                        </h2>
                        <p class="text-gray-700 mb-2">
                            CRUD adalah singkatan dari Create, Read, Update, Delete — <span class="font-semibold">empat operasi dasar</span> yang harus ada untuk mengelola data di database.
                        </p>

                        <h3 class="text-xl font-bold text-blue-700 mb-4">Alur CRUD dengan Database (PHP Native)</h3>
                        <ul class="list-disc list-inside space-y-2 text-gray-600 ml-4 mb-4">
                            <li><span class="font-semibold">C (Create)</span>: <code class="font-semibold">INSERT INTO ...</code> (Menambah data baru).</li>
                            <li><span class="font-semibold">R (Read)</span>: <code class="font-semibold">SELECT * FROM ...</code> (Menampilkan data).</li>
                            <li><span class="font-semibold">U (Update)</span>: <code class="font-semibold">UPDATE ... SET ... WHERE ...</code> (Mengubah data).</li>
                            <li><span class="font-semibold">D (Delete)</span>: <code class="font-semibold">DELETE FROM ... WHERE ...</code> (Menghapus data).</li>
                        </ul>

                        <h4 class="text-xl font-semibold text-blue-600 mb-2">Contoh SQL Dasar (Read):</h4>
                        <pre class="bg-gray-800 text-white p-3 rounded text-sm overflow-x-auto mb-4">
                            <code>$data = mysqli_query($conn, "SELECT * FROM siswa");
                            while($row = mysqli_fetch_assoc($data)){
                                echo $row['nama']; // Tampilkan nama per baris
                            }</code></pre>
                    </div>
                    <!-- REFERENSI VIDEO: Apa Itu Frontend & Backend Developer? -->
                    <section class="mt-10">
                        <!-- Judul -->
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-100 text-green-600">
                                <i class="fas fa-laptop-code"></i>
                            </div>
                            <h2 class="text-lg md:text-xl font-semibold text-gray-800">
                                Video Pembelajaran – Frontend & Backend Developer
                            </h2>
                        </div>

                        <!-- Deskripsi -->
                        <p class="text-gray-600 text-sm md:text-base mb-6">
                            Tonton video berikut untuk memahami apa itu Frontend dan Backend Developer serta
                            perbedaannya — cocok sebagai tambahan materi pembelajaran bagi siswa RPL.
                        </p>

                        <!-- Video YouTube -->
                        <div class="relative w-full aspect-video rounded-xl overflow-hidden border">
                            <iframe
                                class="w-full h-full"
                                src="https://www.youtube.com/embed/Cwh2bJBq3hs"
                                title="Apa Itu Frontend & Backend Developer?"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>

                        <!-- Link YouTube -->
                        <div class="mt-5 flex items-center gap-2 text-sm">
                            <i class="fab fa-youtube text-red-600 text-lg"></i>
                            <a
                                href="https://youtu.be/Cwh2bJBq3hs"
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