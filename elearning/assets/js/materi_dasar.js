const hamburgerMenu = document.getElementById('hamburger-menu');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebar-overlay');
const body = document.body;

// --- Fungsionalitas Hamburger Menu dan Sidebar ---
function toggleSidebar() {
    // Mengubah class visibility
    sidebar.classList.toggle('-translate-x-full'); 
    // Menggunakan class pada body untuk mengontrol overlay
    body.classList.toggle('show-sidebar'); 
}

hamburgerMenu.addEventListener('click', toggleSidebar);
sidebarOverlay.addEventListener('click', toggleSidebar); // Tutup sidebar saat overlay diklik

// Menutup sidebar jika di-resize ke desktop (>= 768px)
window.addEventListener('resize', () => {
    if (window.innerWidth >= 768 && body.classList.contains('show-sidebar')) {
        toggleSidebar();
    }
});