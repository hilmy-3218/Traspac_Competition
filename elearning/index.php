<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Learning SMK</title>
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <!-- Memuat Tailwind CSS dari CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/index.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <!-- Memuat Font Awesome (untuk ikon profesional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <!-- loader -->
    <div id="top-loader" class="fixed top-0 left-0 h-[3px] w-0 bg-blue-600 z-[9999] transition-all duration-300"></div>

    <!-- HEADER/NAVIGASI (Tetap Sticky) -->
    <header class="p-4 sticky top-0 z-50 
        bg-white/70 backdrop-blur-md 
        shadow-md border-b border-white/30">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <!-- Logo -->
            <div class="text-xl font-extrabold text-gray-800 cursor-pointer" onclick="scrollToSection('home-page')">
            SMK <span class="text-indigo-600">Learn</span>
            </div>
            <!-- Navigation (Desktop) - Menggunakan data-section dan nav-link-desktop -->
            <nav class="hidden md:flex flex-1 justify-center space-x-8">
                <a href="#home-page" data-section="home-page" class="nav-link-desktop text-gray-600 hover:text-indigo-600 font-medium transition active">Beranda</a>
                <a href="#about-page" data-section="about-page" class="nav-link-desktop text-gray-600 hover:text-indigo-600 font-medium transition">Tentang</a>
            </nav>
            <!-- Tombol Masuk -->
            <div class="hidden md:block">
                <a href="auth/login.php" class="btn-primary px-4 py-2 rounded-full text-white bg-indigo-600 hover:bg-indigo-700">Masuk</a>
            </div>
            <!-- Hamburger Menu (Mobile) -->
            <button id="menu-button" class="md:hidden p-2 text-gray-600 hover:text-indigo-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden mt-3 space-y-2 pb-2 bg-white border-t border-gray-100">
            <a href="#" onclick="scrollToSection('home-page')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-indigo-50">Beranda</a>
            <a href="#" onclick="scrollToSection('about-page')" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:bg-indigo-50">Tentang Kami</a>
            <a href="auth/login.php" class="block w-full text-center px-3 py-2 rounded-full text-white bg-indigo-600 hover:bg-indigo-700 font-medium mt-2">Masuk</a>
        </div>
    </header>
    <!-- KONTEN UTAMA APLIKASI (Sekarang mengalir secara vertikal) -->
    <main> 
        <!-- BAGIAN 1: BERANDA-->
        <!-- Tambahkan ID ke section agar dapat dilacak IntersectionObserver -->
        <section id="home-page" class="bg-white">
            <!-- HERO SECTION (Latar Belakang Terang) -->
            <div class="min-h-[92vh] py-28 px-4 md:py-40 relative overflow-hidden bg-cover bg-center"
                style="background-image: url('assets/images/siswa.webp');">
                <!-- Overlay putih transparan -->
                <div class="absolute inset-0 bg-white/25"></div>
                <div class="max-w-7xl mx-auto text-center relative z-10">
                    <h1 class="hero-text-animation text-4xl sm:text-5xl md:text-6xl font-extrabold text-gray-800 leading-tight mb-4" style="animation-delay: 0.1s;">
                        <span class="block">Masa Depanmu,</span>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-pink-600">Mulai Dari Sini!</span>
                    </h1>
                    <p class="hero-text-animation text-lg sm:text-xl text-gray-600 mb-8 max-w-3xl mx-auto" style="animation-delay: 0.3s;">
                        Belajar keahlian siap kerja, kapan saja, di mana saja. Platform e-learning SMK paling interaktif dan modern.
                    </p>
                    <div class="hero-text-animation" style="animation-delay: 0.5s;">
                        <button onclick="location.href='auth/login.php'" class="btn-primary inline-block px-8 py-3 bg-indigo-600 text-white font-bold text-lg rounded-full shadow-lg hover:bg-indigo-700">
                            <i class="fa-solid fa-right-to-bracket"></i> Login
                        </button>
                    </div>
                </div>
                <!-- Dekorasi Latar Belakang -->
                <div class="absolute top-1/4 left-1/4 w-8 h-8 md:w-16 md:h-16 bg-pink-400 rounded-full opacity-60 float-icon z-0"></div>
                <div class="absolute bottom-1/4 right-1/4 w-12 h-12 md:w-24 md:h-24 bg-indigo-400 rounded-full opacity-60 spin-icon z-0" style="animation-delay: 2s;"></div>
                <div class="absolute top-10 right-1/2 w-6 h-6 md:w-10 md:h-10 bg-indigo-400 rounded-full opacity-70 float-icon z-0" style="animation-delay: 1s;"></div>
                <div class="absolute bottom-1/3 left-1/4 w-10 h-10 md:w-20 md:h-20 bg-pink-400 rounded-full opacity-50 float-icon z-0" style="animation-delay: 3s;"></div>
                <div class="absolute top-1/3 right-1/4 w-10 h-10 md:w-20 md:h-20 bg-pink-400 rounded-full opacity-60 spin-icon z-0" style="animation-delay: 0.5s;"></div>
                <div class="absolute bottom-5 left-10 w-8 h-8 md:w-16 md:h-16 bg-indigo-400 rounded-full opacity-70 spin-icon z-0" style="animation-delay: 2.5s;"></div>
                <!-- Wave Bottom SVG -->
                <svg 
                    class="absolute bottom-0 left-0 right-0 w-full h-auto z-0"
                    viewBox="0 0 1440 200" 
                    fill="none" 
                    xmlns="http://www.w3.org/2000/svg">
                    <g transform="translate(720, 100) rotate(180) translate(-720, -100)">
                        <path d="M0 140C0 140 157.5 70 350.5 85C543.5 100 642.5 140 828.5 140C1014.5 140 1113.5 100 1276 85C1438.5 70 1440 140 1440 140V0H0V140Z" fill="#111827"/>
                    </g>
                </svg>
            </div>

  
            <section id="fitur" class="py-16 px-4 bg-gray-900 text-gray-100">
                <div class="max-w-7xl mx-auto">

                    <h2 class="text-3xl font-extrabold text-white mb-12 text-center w-full">
                        Fitur Unggulan SMK Learn
                    </h2>

                    <!-- KONTAINER BARU UNTUK MEMUSATKAN KARTU -->
                    <!-- max-w-5xl membatasi lebar blok kartu agar tidak terlalu melebar, dan mx-auto memusatkannya -->
                    <div class="max-w-5xl mx-auto">

                        <!-- Kontainer Kartu -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            
                            <!-- CARD 1: Modul Lengkap -->
                            <div class="p-8 bg-gray-800 rounded-2xl shadow-2xl border-t-4 border-indigo-600 hover:shadow-indigo-700/50 transform hover:scale-[1.02] transition duration-300">
                                <div class="text-indigo-400 mb-4 w-16 h-16 flex justify-center items-center rounded-full bg-gray-700/50 mx-auto">
                                    <i class="fas fa-book-open text-3xl"></i>
                                </div>
                                <h3 class="font-bold text-2xl text-white mb-2 text-center">Modul Lengkap</h3>
                                <p class="text-gray-400 text-base text-center">
                                    Akses ratusan modul kompetensi kejuruan dari TKJ, RPL, Multimedia, dan lain-lain.
                                </p>
                            </div>

                            <!-- CARD 2: Forum Diskusi -->
                            <div class="p-8 bg-gray-800 rounded-2xl shadow-2xl border-t-4 border-pink-600 hover:shadow-pink-700/50 transform hover:scale-[1.02] transition duration-300">
                                <div class="text-pink-400 mb-4 w-16 h-16 flex justify-center items-center rounded-full bg-gray-700/50 mx-auto">
                                    <i class="fas fa-comments text-3xl"></i>
                                </div>
                                <h3 class="font-bold text-2xl text-white mb-2 text-center">Forum Diskusi</h3>
                                <p class="text-gray-400 text-base text-center">
                                    Tempat bertanya, berdiskusi, dan berbagi pengetahuan antara siswa dan guru.
                                </p>
                            </div>

                            <!-- CARD 3: Tropi / Reward - Span 2 kolom agar tetap di tengah dengan 3 item -->
                            <div class="sm:col-span-2 p-8 bg-gray-800 rounded-2xl shadow-2xl border-t-4 border-yellow-600 hover:shadow-yellow-700/50 transform hover:scale-[1.02] transition duration-300 md:max-w-md md:mx-auto">
                                <div class="text-yellow-400 mb-4 w-16 h-16 flex justify-center items-center rounded-full bg-gray-700/50 mx-auto">
                                    <i class="fas fa-trophy text-3xl"></i>
                                </div>
                                <h3 class="font-bold text-2xl text-white mb-2 text-center">Reward & Tropi</h3>
                                <p class="text-gray-400 text-base text-center">
                                    Kumpulkan poin, dapatkan badge, dan raih tropi sebagai motivasi belajar yang menyenangkan.
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </section>
            
            <!-- JURUSAN POPULER SECTION (Latar Belakang Gelap) -->
            <section id="jurusan" class="py-16 px-4 bg-gray-900 text-gray-100 border-t border-gray-800">
                <div class="max-w-7xl mx-auto">
                    <!-- HEADING JURUSAN POPULER -->
                    <div class="text-center mb-12">
                         <h2 class="text-3xl font-bold text-white border-b-2 border-pink-500 pb-2 inline-block scroll-animate slide-in-right">Jurusan Populer</h2>
                        <!-- Petunjuk Scroll Mobile -->
                        <p class="text-sm text-gray-500 mt-2 md:hidden scroll-animate slide-in-left"> Geser ke samping untuk melihat semua jurusan &rarr;</p>
                    </div>
                    
                    <!-- CONTAINER KARTU JURUSAN (5 jurusan) -->
                    <div class="flex overflow-x-auto snap-x md:grid md:grid-cols-5 gap-6 pb-4 horizontal-scroll-snap">
                        
                        <!-- Jurusan 1: Kiri -->
                        <div class="bg-gray-800 p-6 rounded-xl shadow-xl hover:shadow-indigo-500/20 transition duration-300 scroll-animate slide-in-left w-72 flex-shrink-0 snap-center md:w-auto">
                            <div class="text-indigo-400 text-3xl mb-3">
                                <i class="fa-solid fa-server"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">TKJ (Teknik Komputer & Jaringan)</h3>
                            <p class="text-gray-400 text-sm">Fokus pada instalasi dan pemeliharaan perangkat keras (hardware) dan infrastruktur jaringan komputer. Siap menjadi Network Engineer.</p>
                            <a href="#" onclick="openCourseModal(event, 'tkj')" class="text-indigo-500 hover:text-indigo-400 text-sm font-medium mt-3 inline-block">Lihat Modul &rarr;</a>
                        </div>

                        <!-- Jurusan 2: Kiri -->
                        <div class="bg-gray-800 p-6 rounded-xl shadow-xl hover:shadow-pink-500/20 transition duration-300 scroll-animate slide-in-left w-72 flex-shrink-0 snap-center md:w-auto">
                            <div class="text-pink-400 text-3xl mb-3">
                                <i class="fa-solid fa-code"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">RPL (Rekayasa Perangkat Lunak)</h3>
                            <p class="text-gray-400 text-sm">Fokus pada pengembangan aplikasi perangkat lunak berbasis web, mobile, dan desktop. Belajar bahasa pemrograman modern.</p>
                            <a href="#" onclick="openCourseModal(event, 'rpl')" class="text-pink-500 hover:text-pink-400 text-sm font-medium mt-3 inline-block">Lihat Modul &rarr;</a>
                        </div>
                        
                        <!-- Jurusan 3: Kanan -->
                        <div class="bg-gray-800 p-6 rounded-xl shadow-xl hover:shadow-green-500/20 transition duration-300 scroll-animate slide-in-right w-72 flex-shrink-0 snap-center md:w-auto">
                            <div class="text-green-400 text-3xl mb-3">
                                <i class="fa-solid fa-palette"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Multimedia</h3>
                            <p class="text-gray-400 text-sm">Penguasaan desain grafis, animasi 2D/3D, videografi, dan produksi konten digital kreatif untuk media sosial.</p>
                            <a href="#" onclick="openCourseModal(event, 'mm')" class="text-green-500 hover:text-green-400 text-sm font-medium mt-3 inline-block">Lihat Modul &rarr;</a>
                        </div>

                        <!-- Jurusan 4: Kanan -->
                        <div class="bg-gray-800 p-6 rounded-xl shadow-xl hover:shadow-yellow-500/20 transition duration-300 scroll-animate slide-in-right w-72 flex-shrink-0 snap-center md:w-auto">
                            <div class="text-yellow-400 text-3xl mb-3">
                                <i class="fa-solid fa-chart-column"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Akuntansi</h3>
                            <p class="text-gray-400 text-sm">Fokus pada pencatatan, penggolongan, dan pelaporan transaksi keuangan menggunakan software akuntansi modern.</p>
                            <a href="#" onclick="openCourseModal(event, 'akuntansi')" class="text-yellow-500 hover:text-yellow-400 text-sm font-medium mt-3 inline-block">Lihat Modul &rarr;</a>
                        </div>
                        
                        <!-- Jurusan 5: Kanan -->
                        <div class="bg-gray-800 p-6 rounded-xl shadow-xl hover:shadow-red-500/20 transition duration-300 scroll-animate slide-in-right w-72 flex-shrink-0 snap-center md:w-auto">
                            <div class="text-red-400 text-3xl mb-3">
                                <i class="fa-solid fa-bullhorn"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">Pemasaran</h3>
                            <p class="text-gray-400 text-sm">Mempelajari strategi penjualan, riset pasar, dan teknik promosi digital untuk membangun merek dan meningkatkan omset.</p>
                            <a href="#" onclick="openCourseModal(event, 'pemasaran')" class="text-red-500 hover:text-red-400 text-sm font-medium mt-3 inline-block">Lihat Modul &rarr;</a>
                        </div>
                    </div>
                </div>
            </section>
        </section>

        <!-- BAGIAN 2: TENTANG KAMI -->
        <section id="about-page" class="py-20 px-4 bg-gray-900 text-gray-100 dark-scroll border-t border-gray-800">
            <div class="max-w-5xl mx-auto pt-8">
                <div class="flex flex-col md:flex-row items-center gap-12 mb-16">
                    <!-- Teks: Kiri -->
                    <div class="w-full md:w-1/2 scroll-animate slide-in-left">

                        <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-6 leading-tight">
                            Tentang <span class="text-indigo-400">Kami</span>
                        </h2>

                        <p class="text-gray-400 text-base sm:text-lg mb-6 leading-relaxed">
                            SMK Learn adalah sebuah platform pembelajaran digital yang dirancang 
                            khusus untuk mendukung kegiatan belajar mengajar di lingkungan Sekolah 
                            Menengah Kejuruan (SMK).
                        </p>

                        <p class="text-gray-400 text-base sm:text-lg mb-6 scroll-animate slide-in-right">
                            Platform ini hadir sebagai bentuk inovasi sekolah dalam menghadapi perkembangan teknologi 
                            dan kebutuhan pendidikan era modern. Melalui SMK Learn, proses pembelajaran menjadi lebih 
                            terstruktur, efektif, dan mudah diakses oleh seluruh warga sekolah.
                        </p>

                        <!-- Bagian Tujuan -->
                        <h3 class="text-2xl sm:text-3xl font-bold text-white mb-4">Tujuan</h3>

                        <ul class="text-gray-400 text-base sm:text-lg leading-relaxed 
                                grid grid-cols-2 gap-3">

                            <li class="flex items-start scroll-animate slide-in-left">
                                <span class="text-indigo-400 mr-2">•</span>
                                Meningkatkan kualitas pembelajaran berbasis teknologi di lingkungan SMK.
                            </li>

                            <li class="flex flex-row-reverse items-start text-end scroll-animate slide-in-right">
                                <span class="text-indigo-400 ml-2">•</span>
                                Menyediakan akses pembelajaran yang mudah, cepat, dan fleksibel bagi siswa maupun guru.
                            </li>

                            <li class="flex items-start scroll-animate slide-in-left">
                                <span class="text-indigo-400 mr-2 ">•</span>
                                Mendukung proses belajar mandiri dan kolaboratif melalui fitur yang interaktif.
                            </li>

                            <li class="flex flex-row-reverse items-start text-end scroll-animate slide-in-right">
                                <span class="text-indigo-400 ml-2">•</span>
                                Menyelaraskan kegiatan pembelajaran dengan standar industri dan kebutuhan dunia kerja.
                            </li>

                        </ul>
                    </div>

                    <!-- Card Visi/Misi: Kanan -->
                    <div class="w-full md:w-1/2 relative">
                        <div class="absolute inset-0 bg-indigo-500 blur-3xl opacity-20 rounded-full"></div>

                        <div class="relative bg-gray-800 border border-gray-700 p-8 rounded-2xl shadow-2xl">
                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 scroll-animate slide-in-left">Visi Kami</h3>

                            <p class="text-gray-400 text-base sm:text-lg scroll-animate slide-in-left">
                                “Menjadi platform pembelajaran digital terpercaya yang mendukung pembentukan generasi 
                                SMK yang kompeten, mandiri, inovatif, dan berdaya saing di era digital."
                            </p>

                            <hr class="border-gray-700 my-4">

                            <h3 class="text-xl sm:text-2xl font-bold text-white mb-4 scroll-animate slide-in-right">Misi Kami</h3>

                            <ul class="space-y-2 text-gray-400 text-base sm:text-lg scroll-animate slide-in-right">
                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                                    Menyediakan layanan pembelajaran digital lengkap dan interaktif
                                </li>

                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                                    Mendorong budaya belajar mandiri dan kolaboratif
                                </li>

                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                                    Meningkatkan kualitas pendidikan kejuruan sesuai standar industri
                                </li>

                                <li class="flex items-center">
                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                                    Memfasilitasi evaluasi pembelajaran yang cepat dan akurat
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                    <!-- Tombol Pembuka Chatbot -->
                <button id="elcOpenChatBtn" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 scroll-animate slide-in-left">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16l3-3m0 0l3 3m-3-3v8m0 0a3 3 0 00-3-3H6m12 0h-3m0 0a3 3 0 00-3 3v3h-3a3 3 0 01-3-3v-3m0-3h12a3 3 0 003-3V6a3 3 0 00-3-3H6a3 3 0 00-3 3v6a3 3 0 003 3h3" />
                    </svg>
                    Buka Asisten E-Learning
                </button>

                <!-- Jendela Glassmorphism Chatbot (Hidden by default) -->
                <div id="elcChatWindow" class="elc-window hidden flex flex-col">
                    
                    <!-- Header Jendela (Area Drag) -->
                    <div id="elcChatHeader" class="p-3 border-b border-white/20 flex justify-between items-center cursor-move rounded-t-xl bg-black/10">
                        <h2 class="text-white text-lg font-semibold select-none">Asisten E-Learning</h2>
                        <button id="elcCloseChatBtn" class="text-white/80 hover:text-white transition duration-150 p-1 rounded-full hover:bg-red-600/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Area Pesan Chat -->
                    <div id="elcChatArea" class="elc-chat-area flex flex-col space-y-3 flex-grow">
                        <!-- Pesan dari Bot (System) - Pesan Sambutan Awal -->
                        <div class="elc-message-system p-3 shadow-md">
                            Halo! Saya adalah Asisten E-Learning Anda. Saya bisa membantu Anda memahami topik pelajaran, memberikan ringkasan, atau tes singkat.
                        </div>
                        <!-- BLOK REKOMENDASI AWAL AKAN DITAMBAHKAN OLEH JAVASCRIPT SAAT JENDELA DIBUKA -->
                    </div>
                    
                    <!-- Catatan: Area Input Chat telah dihapus -->

                    <!-- FOOTER (Baru) -->
                    <div id="elcChatFooter" class="h-8 p-1 text-center text-xs text-white/50 border-t border-white/20 bg-black/10 flex items-center justify-center select-none"></div>

                    <!-- Pegangan Resize (Resizer Handle) -->
                    <div class="elc-resize-handle" id="elcResizeHandle"></div>

                </div>
            </div>

        </section>
    </main> 
    <!-- AKHIR KONTEN UTAMA -->
    
    <!-- FOOTER: Kanan -->
    <footer class="bg-gray-900 py-6 text-center text-gray-400 border-t border-gray-800 mt-auto">
        <p class="text-sm">SMK Learn 2026</p>
    </footer>

    <!-- MODAL DETAIL JURUSAN (GLASS MORPHISM)         -->
    <div id="course-modal" class="glass-modal-overlay fixed inset-0 z-[100] hidden flex items-center justify-center p-4" onclick="closeCourseModal(event)">
        
        <!-- Konten Modal -->
        <div id="modal-content-box" class="glass-modal-content w-full max-w-2xl text-gray-100 p-6 md:p-10 max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            
            <!-- Tombol Tutup -->
            <button onclick="closeCourseModal()" class="absolute top-4 right-4 text-gray-300 hover:text-white transition">
                <i class="fa-solid fa-xmark fa-xl"></i>
            </button>
            
            <h3 id="modal-title" class="text-3xl font-extrabold text-white mb-4">Judul Jurusan</h3>
            <div class="h-1 bg-indigo-500 w-16 mb-6 rounded-full"></div>
            
            <div id="modal-body" class="space-y-6 text-gray-300 text-base">
                <!-- Konten Detail akan diisi di sini oleh JavaScript -->
            </div>
            <div class="mt-8 pt-4 border-t border-gray-600">
                <button 
                    class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition"
                    onclick="window.location.href='auth/login.php'">
                    Daftar Sekarang &rarr;
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript Navigasi, Form Handling, Modal, Scroll Animation dan chat bot -->
    <script src="assets/js/index.js"></script>
</body>

</html>

