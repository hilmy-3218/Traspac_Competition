<?php

$currentPage = basename($_SERVER['PHP_SELF']);

// Cegah akses langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit('File ini tidak boleh diakses langsung');
}
?>

<nav class="fixed bottom-0 left-0 right-0 h-12 bg-gray-800/90 backdrop-blur-md shadow-2xl md:hidden z-50 rounded-tl-3xl rounded-tr-3xl">
    <div class="h-full flex justify-around items-center max-w-xl mx-auto px-2">
        <?php 
            $navItems = [
                ['name' => 'Beranda', 'icon' => 'fas fa-home', 'file' => 'dashboard.php'],
                ['name' => 'Diskusi', 'icon' => 'fas fa-comments', 'file' => 'diskusi.php'],
                ['name' => 'Pengumuman', 'icon' => 'fas fa-bullhorn', 'file' => 'pengumuman.php'], 
                ['name' => 'Profil', 'icon' => 'fas fa-user-cog ', 'file' => 'pengaturan.php'] 
            ];
        ?>

        <?php foreach ($navItems as $item): 
            $isActive = ($currentPage === $item['file']);
        ?>
            <a href="<?= htmlspecialchars(BASE_URL . $item['file'], ENT_QUOTES, 'UTF-8'); ?>" 
               class="w-1/4 h-full flex flex-col items-center justify-center transition-colors duration-200
               <?= htmlspecialchars($isActive ? 'text-blue-400' : 'text-gray-300 hover:text-white', ENT_QUOTES, 'UTF-8'); ?>">
                <!-- Icon -->
                <i class="text-base mb-0.5 <?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8'); ?>"></i>
                <!-- Nama -->
                <span class="text-xs font-medium <?= htmlspecialchars($isActive ? 'font-semibold' : '', ENT_QUOTES, 'UTF-8'); ?>">
                    <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</nav>

<!-- loader js -->
<script>
  const loader = document.getElementById("top-loader");
  let progress = 0;
  let interval;
  let isBackNavigation = false; // 🔹 flag untuk tombol back

  function startLoading() {
    // ⛔ Jangan aktifkan loader jika navigasi dari back()
    if (isBackNavigation) return;

    clearInterval(interval);
    loader.style.opacity = "1";
    progress = 5;
    loader.style.width = progress + "%";

    interval = setInterval(() => {
      if (progress < 90) {
        progress += (90 - progress) * 0.08; // adaptif & lambat
        loader.style.width = progress + "%";
      }
    }, 200);
  }

  function finishLoading() {
    clearInterval(interval);
    loader.style.width = "100%";

    setTimeout(() => {
      loader.style.opacity = "0";
    }, 300);

    setTimeout(() => {
      loader.style.width = "0%";
      progress = 0;
    }, 600);
  }

  // 🔹 MUNCUL SAAT PAGE LOAD
  document.addEventListener("DOMContentLoaded", startLoading);
  window.addEventListener("load", finishLoading);

  // 🔹 HANDLE BACK/FORWARD CACHE (BFCache)
  window.addEventListener("pageshow", () => {
    isBackNavigation = false; // reset flag
    finishLoading();
  });

  // 🔹 MUNCUL SAAT KLIK LINK (KECUALI BACK)
  document.querySelectorAll("a[href]").forEach(link => {
    link.addEventListener("click", () => {
      startLoading();
    });
  });

  // 🔹 FETCH TRACKING (WAJIB pakai ini kalau AJAX)
  async function trackedFetch(url, options = {}) {
    startLoading();
    try {
      return await fetch(url, options);
    } finally {
      finishLoading();
    }
  }

  // 🔹 FUNGSI TOMBOL KEMBALI (PAKAI INI)
  function goBack() {
    isBackNavigation = true;
    history.back();
  }
</script>

