<?php
// Mendapatkan halaman saat ini untuk active link
$currentPage = basename($_SERVER['PHP_SELF']);

// Cegah akses langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit('File ini tidak boleh diakses langsung');
}
?>

<!-- 1. SIDEBAR (RESPONSIVE - DESKTOP/TABLET) -->
<style>
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1; /* gray-300 */
        border-radius: 2px;
    }
    .sidebar-link:hover {
        background-color: #374151; /* gray-700 */
    }

    /* Kontainer navigasi agar bisa di-scroll */
    .nav-scroll-area {
        scrollbar-width: thin; 
        scrollbar-color: #4b5563 transparent; 
    }

    /* Scrollbar Styling untuk Chrome, Safari, dan Edge */
    .nav-scroll-area::-webkit-scrollbar {
        width: 5px; 
    }

    .nav-scroll-area::-webkit-scrollbar-track {
        background: transparent; 
    }

    .nav-scroll-area::-webkit-scrollbar-thumb {
        background: #4b5563; 
        border-radius: 10px;
        transition: background 0.3s ease;
    }

    .nav-scroll-area::-webkit-scrollbar-thumb:hover {
        background: #6366f1;
    }

    .sidebar-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
    }
</style>
<aside id="sidebar" 
    class="w-64 bg-gray-900/50 backdrop-blur-md text-white flex-shrink-0 flex flex-col shadow-2xl 
        fixed inset-y-0 left-0 transform -translate-x-full 
        md:bg-gray-800 md:backdrop-blur-none md:translate-x-0 md:flex md:h-screen md:shadow-2xl
        transition duration-300 ease-in-out z-[65]">

    <!-- Logo/Header Sidebar -->
    <div class="p-6 border-b border-gray-700">
        <h2 class="text-xl font-bold tracking-wider uppercase text-indigo-400">
            E-Learning App
        </h2>
    </div>

    <!-- Profil Mini di Sidebar -->
    <div class="p-4 flex items-center border-b border-gray-700">
        <?php if ($foto): ?>
            <img
                src="<?php echo htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                class="w-10 h-10 rounded-full object-cover border-2"
                alt="Foto Profil"
            >
        <?php else: ?>
            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-lg font-bold border-2 <?php echo htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?>">
                <?php echo htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
            </div>
        <?php endif; ?>

        <div class="ml-3">
            <p class="text-sm font-semibold truncate">
                <?php echo htmlspecialchars($nama, ENT_QUOTES, 'UTF-8'); ?>
            </p>
            <p class="text-xs text-gray-400 capitalize">
                <?php echo htmlspecialchars($role, ENT_QUOTES, 'UTF-8'); ?>
            </p>
        </div>
    </div>

    <!-- Navigasi Sidebar -->
    <?php 
        $activeClass = 'bg-blue-200/20 backdrop-blur-lg text-indigo-300 font-semibold';
        $inactiveClass = 'text-gray-300 hover:bg-white/10 hover:backdrop-blur-sm transition-colors duration-300';
    ?>
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto overflow-x-hidden nav-scroll-area">

        <a href="dashboard.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'dashboard.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-home fa-icon-sm mr-3"></i>
            Dashboard
        </a>

        <a href="diskusi.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'diskusi.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-comments fa-icon-sm mr-3"></i>
            Diskusi
        </a>

        <a href="pengumuman.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'pengumuman.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-bullhorn fa-icon-sm mr-3"></i>
            Pengumuman
        </a>

        <a href="materi.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'materi.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-book-open fa-icon-sm mr-3"></i>
            Materi
        </a>

        <a href="tugas.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'tugas.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-clipboard-list fa-icon-sm mr-3"></i>
            Tugas
        </a>

        <?php if ($role === 'guru'): ?>
        <a href="manajemen_kelas.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'manajemen_kelas.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-school fa-icon-sm mr-3"></i>
            Manajemen Kelas
        </a>
        <?php endif; ?>

        <a href="rank.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'rank.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-trophy fa-icon-sm mr-3"></i>
            Peringkat
        </a>

        <a href="pengaturan.php" class="sidebar-link flex items-center p-3 rounded-lg text-sm <?= htmlspecialchars(($currentPage === 'pengaturan.php') ? $activeClass : $inactiveClass, ENT_QUOTES, 'UTF-8'); ?>">
            <i class="fas fa-user-cog fa-icon-sm mr-3"></i>
            Pengaturan
        </a>

    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-gray-700">
        <a href="../auth/logout.php"
        class="flex items-center justify-center w-full px-4 py-3 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition duration-150">
            <i class="fas fa-sign-out-alt fa-icon-sm mr-2"></i>
            Logout
        </a>
    </div>
</aside>

<!-- Overlay untuk mobile -->
<div id="overlay" class="fixed inset-0 bg-black opacity-50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

<script>
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const sidebarToggle = document.getElementById('sidebarToggle');

    function toggleSidebar() {
        const isHidden = sidebar.classList.contains('-translate-x-full');
        if (isHidden) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    }

    sidebarToggle.addEventListener('click', toggleSidebar);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
        }
    });

    // ======================== Logika Klik di Luar Sidebar ========================
    document.addEventListener('click', (e) => {
        const isClickInsideSidebar = sidebar.contains(e.target);
        const isClickOnToggleBtn = sidebarToggle.contains(e.target);

        // Jika klik di luar sidebar dan tombol toggle, sembunyikan sidebar
        if (!isClickInsideSidebar && !isClickOnToggleBtn) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }
    });

    // Jika overlay diklik, tutup sidebar
    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

</script>

