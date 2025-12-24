<?php
// Cegah akses langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit('File ini tidak boleh diakses langsung');
}
?>

<!-- Area Tugas (Tampilan Tugas) -->
<div id="tugas-area" class="p-8 rounded-lg shadow-xl min-h-[400px] <?= $mode === 'tugas' ? '' : 'hidden' ?> glass-effect">
    <h1 class="text-3xl font-extrabold text-indigo-700 mb-6">
        <i class="fas fa-tasks"></i> Tugas Materi <?= htmlspecialchars($materi_id_tugas, ENT_QUOTES, 'UTF-8') ?>
    </h1>

    <a href="?" class="inline-block mb-4 text-indigo-600 hover:text-indigo-800 font-medium">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Materi
    </a>

    <hr class="mb-6">
    <!-- Cek apakah quiz sudah disubmit & siapkan hasil -->
    <?php if ($quiz_submitted): 
        // TAMPILAN HASIL SETELAH SUBMIT
        $skor_display = (int) $submission_result['skor']; // Cast aman
        $total_display = (int) $submission_result['total']; // Cast aman
        $persen = isset($nilai_persen) ? (float) $nilai_persen : ($total_display > 0 ? round(($skor_display / $total_display) * 100, 2) : 0); // Hitung aman
        $status_color = $persen >= 70 ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700'; // Status warna
    ?>

    <!-- Container hasil -->
    <div class="p-6 rounded-lg border-2 border-dashed <?= $status_color ?> glass-effect">
        <!-- Judul -->
        <h2 class="text-2xl font-bold mb-4">🎉 Hasil Tugas Anda!</h2>

        <!-- Skor -->
        <p class="text-lg font-semibold">
            Skor Anda:
            <span class="text-3xl font-extrabold"><?= htmlspecialchars($skor_display, ENT_QUOTES, 'UTF-8') ?></span>
            dari <?= htmlspecialchars($total_display, ENT_QUOTES, 'UTF-8') ?> soal.
        </p>

        <!-- Persentase -->
        <p class="text-lg font-semibold mt-2">
            Nilai Persentase:
            <span class="text-3xl font-extrabold"><?= htmlspecialchars($persen, ENT_QUOTES, 'UTF-8') ?>%</span>
        </p>

        <!-- Pesan kelulusan -->
        <?php if ($persen < 70): ?>
            <p class="mt-4 text-sm">Anda belum mencapai batas minimal kelulusan (70%). Silakan ulangi materi atau coba lagi nanti.</p>
        <?php else: ?>
            <p class="mt-4 text-sm">Hebat! Anda berhasil menyelesaikan tugas ini.</p>
        <?php endif; ?>

        <!-- Data jurusan -->
        <p class="mt-2 text-xs text-gray-500">
            Data Jurusan yang disimpan: <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8') ?>
        </p>
    </div>
    
    <!-- Tombol ulangi tugas -->
    <div class="mt-6">
        <a href="?mode=tugas&materi_id=<?= urlencode($materi_id_tugas) ?>" class="w-full inline-block text-center py-2 px-4 bg-yellow-500 text-white font-semibold rounded-lg hover:bg-yellow-600 transition duration-200">
            Ulangi Tugas Ini
        </a>
    </div>

    <!-- Tampilkan pesan error tugas -->
    <?php elseif ($error_tugas): ?>

    <!-- Alert error -->
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline"><?= htmlspecialchars($error_tugas, ENT_QUOTES, 'UTF-8') ?></span>
    </div>

    <!-- Cek jika soal tugas tersedia -->
    <?php elseif (!empty($soal_tugas)): ?>
    
    <!-- Form pengiriman tugas -->
    <form action="?mode=tugas&materi_id=<?= urlencode($materi_id_tugas) ?>" method="POST" id="form-tugas">

        <!-- Hidden materi ID -->
        <input type="hidden" name="materi_id" value="<?= htmlspecialchars($materi_id_tugas, ENT_QUOTES, 'UTF-8') ?>">
        
        <!-- Inisialisasi nomor soal -->
        <?php $nomor_soal = 1; ?>

        <!-- Loop soal tugas -->
        <?php foreach ($soal_tugas as $soal): ?>
            <div class="mb-8 border-b pb-4">

                <!-- Pertanyaan -->
                <p class="text-lg font-semibold mb-3">
                    Soal <?= $nomor_soal++ ?>. <?= htmlspecialchars($soal['pertanyaan'], ENT_QUOTES, 'UTF-8') ?>
                </p>
                
                <!-- Grup pilihan jawaban -->
                <div class="custom-radio-group space-y-2 text-gray-700">
                    <?php 
                        $opsi_labels = ['A', 'B', 'C', 'D']; // Label opsi
                        $opsi_keys = ['opsi_a', 'opsi_b', 'opsi_c', 'opsi_d']; // Key opsi
                        foreach ($opsi_keys as $value => $key):
                    ?>

                        <!-- Input radio -->
                        <input type="radio" 
                            id="soal_<?= (int)$soal['id'] ?>_opsi_<?= (int)$value ?>" 
                            name="jawaban_<?= (int)$soal['id'] ?>" 
                            value="<?= (int)$value ?>" 
                            <?= $value === 0 ? 'required' : '' ?>>

                        <!-- Label radio -->
                        <label for="soal_<?= (int)$soal['id'] ?>_opsi_<?= (int)$value ?>" class="text-sm md:text-base">
                            <span class="font-bold mr-2 text-indigo-600">
                                <?= htmlspecialchars($opsi_labels[$value], ENT_QUOTES, 'UTF-8') ?>.
                            </span> 
                            <?= htmlspecialchars($soal[$key], ENT_QUOTES, 'UTF-8') ?>
                        </label>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <!-- Tombol submit -->
        <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition duration-200">
            Kirim Jawaban
        </button>

    </form>

    <?php else: ?>
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">Tidak ada soal yang ditemukan untuk materi ini.</span>
        </div>
    <?php endif; ?>
</div>