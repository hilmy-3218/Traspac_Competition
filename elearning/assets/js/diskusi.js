// Inisialisasi elemen utama feed chat dan sidebar
const chatFeed = document.getElementById('chat-feed');
const sidebarKanan = document.getElementById('sidebar-kanan');
const overlayKanan = document.getElementById('overlay-kanan');
const toggleBtnKanan = document.getElementById('toggle-sidebar-kanan-btn');
const closeBtnKanan = document.getElementById('close-sidebar-kanan-btn');

// Inisialisasi elemen untuk fitur balasan (reply)
const mainForm = document.getElementById('main-message-form');
const replyBar = document.getElementById('reply-bar');
const replyToName = document.getElementById('reply-to-name');
const diskusiIdReply = document.getElementById('diskusi-id-reply');
const kirimPesanBtn = document.getElementById('kirim-pesan-btn');

// Fungsi otomatis scroll ke pesan paling bawah

function scrollToBottom() {
    if (chatFeed) {
        // Eksekusi instan
        chatFeed.scrollTop = chatFeed.scrollHeight;

        // Eksekusi ulang setelah jeda singkat untuk memastikan 
        // gambar avatar sudah terhitung dalam tinggi total
        setTimeout(() => {
            chatFeed.scrollTo({
                top: chatFeed.scrollHeight,
                behavior: 'smooth' // Efek scroll halus
            });
        }, 150);
    }
}

// Jalankan saat struktur HTML siap
document.addEventListener('DOMContentLoaded', scrollToBottom);

// Jalankan saat semua aset (gambar/avatar) selesai dimuat
window.addEventListener('load', scrollToBottom);

// Jalankan scroll otomatis saat halaman selesai dimuat
document.addEventListener('DOMContentLoaded', scrollToBottom);

// --- LOGIKA REPLY SINGLE FORM ---

// Mengaktifkan mode balas: set ID pesan dan ubah UI form
function handleReplySelection(diskusiId, senderName) {
    diskusiIdReply.value = diskusiId;
    replyToName.textContent = senderName === 'Anda' ? 'Pesan Anda' : senderName;
    replyBar.classList.remove('hidden');
    
    // Ubah nama atribut tombol agar dikenali PHP sebagai reply
    kirimPesanBtn.name = 'kirim_reply'; 
    const inputField = mainForm.querySelector('input[name="pesan"]');
    inputField.placeholder = `Tulis balasan untuk ${replyToName.textContent}...`;
    inputField.focus();
}

// Membatalkan mode balas dan mengembalikan form ke status normal
function cancelReply() {
    diskusiIdReply.value = '';
    replyBar.classList.add('hidden');
    kirimPesanBtn.name = 'kirim_pesan'; 
    mainForm.querySelector('input[name="pesan"]').placeholder = 'Ketik pesan baru...';
}

// --- MANAJEMEN MENU AKSI PESAN ---

// Menampilkan/menyembunyikan menu titik tiga pada tiap pesan
function toggleActionsMenu(diskusiId) {
    const menu = document.getElementById(`actions-menu-${diskusiId}`);
    menu.classList.toggle('hidden');
    
    // Tutup semua menu aksi lainnya yang sedang terbuka
    document.querySelectorAll('[id^="actions-menu-"]').forEach(otherMenu => {
        if (otherMenu.id !== `actions-menu-${diskusiId}`) {
            otherMenu.classList.add('hidden');
        }
    });

    // Reset tombol hapus ke status awal jika menu lain dibuka
    document.querySelectorAll('[id^="delete-btn-"]').forEach(deleteBtn => {
        const id = deleteBtn.id.split('-').pop();
        if (id != diskusiId) {
            deleteBtn.innerHTML = '<i class="fas fa-trash-alt w-4 mr-2"></i> Hapus';
            deleteBtn.classList.add('text-red-600', 'hover:bg-red-50');
            deleteBtn.classList.remove('text-white', 'bg-red-500', 'hover:bg-red-600');
            deleteBtn.setAttribute('data-confirm', 'false');
        }
    });
}

// Sistem konfirmasi hapus dua langkah tanpa pop-up browser
function confirmDelete(diskusiId) {
    const deleteBtn = document.getElementById(`delete-btn-${diskusiId}`);
    const deleteForm = document.getElementById(`delete-form-${diskusiId}`);

    if (deleteBtn.getAttribute('data-confirm') !== 'true') {
        // Klik pertama: ubah tampilan tombol jadi konfirmasi
        deleteBtn.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i> Yakin Hapus?';
        deleteBtn.classList.remove('text-red-600', 'hover:bg-red-50');
        deleteBtn.classList.add('text-white', 'bg-red-500', 'hover:bg-red-600');
        deleteBtn.setAttribute('data-confirm', 'true');
    } else {
        // Klik kedua: kirim formulir penghapusan
        deleteForm.submit();
    }
}

// Klik global: menutup menu dropdown jika klik di luar elemen
document.addEventListener('click', function(e) {
    document.querySelectorAll('[id^="actions-menu-"]').forEach(menu => {
        const id = menu.id.split('-').pop();
        const btn = document.getElementById(`action-btn-${id}`);
        if (btn && !menu.contains(e.target) && !btn.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
    
    // Tutup dropdown menu profil global
    const globalMenuDropdown = document.getElementById('global-menu-dropdown');
    const globalBtn = document.getElementById('global-menu-btn');
    if (globalMenuDropdown && globalBtn) {
        if (!globalMenuDropdown.contains(e.target) && !globalBtn.contains(e.target)) {
            globalMenuDropdown.classList.add('hidden');
        }
    }
});

// --- KONTROL SIDEBAR KANAN (MOBILE) ---

// Membuka sidebar kanan dan menampilkan overlay gelap
function openSidebarKanan() {
    sidebarKanan.classList.remove('translate-x-full');
    sidebarKanan.classList.add('translate-x-0');
    overlayKanan.classList.remove('hidden');
}

// Menutup sidebar kanan dan menyembunyikan overlay
function closeSidebarKanan() {
    sidebarKanan.classList.remove('translate-x-0');
    sidebarKanan.classList.add('translate-x-full');
    overlayKanan.classList.add('hidden');
}

// Event listener untuk tombol buka, tutup, dan klik overlay
toggleBtnKanan.addEventListener('click', openSidebarKanan);
closeBtnKanan.addEventListener('click', closeSidebarKanan);
overlayKanan.addEventListener('click', closeSidebarKanan);

// Menutup sidebar secara otomatis jika area di luarnya diklik
document.addEventListener('click', function(e) {
    const isClickInsideSidebar = sidebarKanan.contains(e.target);
    const isClickOnToggle = toggleBtnKanan.contains(e.target);
    if (!isClickInsideSidebar && !isClickOnToggle) {
        closeSidebarKanan();
    }
});

