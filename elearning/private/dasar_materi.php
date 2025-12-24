<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../config/db.php'; 

// Cegah akses langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
    header("HTTP/1.1 403 Forbidden");
    exit('File ini tidak boleh diakses langsung');
}
// CEK LOGIN USER
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
$user_id = $_SESSION['user_id'];
$pdo_available = isset($pdo); // Asumsi $pdo tersedia dari db.php

try {
    if (!$pdo_available) {
        throw new Exception("Koneksi database (\$pdo) tidak tersedia.");
    }
    
    // Ambil user dari database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        header("Location: ../auth/login.php");
        exit;
    }

    // Sanitasi data
    $nama      = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role      = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan   = htmlspecialchars($user['jurusan'] ?? 'Umum'); 
    $email     = htmlspecialchars($user['email'] ?? 'email@contoh.com');

    // Inisial avatar dan Warna (LOGIKA WARNA TETAP DARI KODE ASLI)
    $initial = strtoupper(substr($nama, 0, 1));
    $warna_map = [
        "bg-red-500" => "border-red-500", "bg-yellow-500" => "border-yellow-500", 
        "bg-orange-500" => "border-orange-500", "bg-green-500" => "border-green-500", 
        "bg-blue-500" => "border-blue-500", "bg-indigo-500" => "border-indigo-500", 
        "bg-purple-500" => "border-purple-500", "bg-pink-500" => "border-pink-500"
    ];
    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        $bg_random = array_rand($warna_map);
        $border_random = $warna_map[$bg_random];
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $border_random;
    } else {
        $bg_random = $_SESSION['avatar_bg'];
        $border_random = $warna_map[$_SESSION['avatar_bg']] ?? "border-gray-500";
    }
    $foto = !empty($user['foto_profil']) ? "../../../" . htmlspecialchars($user['foto_profil']) : null;

} catch (PDOException $e) {
    echo "Terjadi kesalahan database: " . $e->getMessage();
    exit;
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
    exit;
}

// 2. KODE PHP UNTUK MENANGANI TAMPILAN MATERI VS TUGAS

$mode = $_GET['mode'] ?? 'materi';
$materi_id_tugas = (int)($_GET['materi_id'] ?? 0); // ID Materi untuk mode Tugas/Quiz

// Menentukan ID materi yang aktif berdasarkan parameter URL. Jika tidak ada, nilainya null.
$materi_id_aktif = isset($_GET['materi_id']) ? (int) $_GET['materi_id'] : null;

// Pastikan ID Materi aktif valid (antara 1 dan 5)
if ($materi_id_aktif < 1 || $materi_id_aktif > 5) {
    $materi_id_aktif = 1;
}

$quiz_submitted = false; // Flag untuk menandai apakah kuis baru saja disubmit
$submission_result = ['skor' => 0, 'total' => 0];

$soal_tugas = [];
$error_tugas = null;


// 3. LOGIKA PENANGANAN SUBMISI FORMULIR (POST) 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pdo_available) {
    
    $mode = 'tugas';
    $submitted_materi_id = (int)($_POST['materi_id'] ?? 0);

    if ($submitted_materi_id > 0) {
        $materi_id_tugas = $submitted_materi_id;
        $quiz_submitted = true;
        
        $skor = 0;
        $total_soal = 0;
        $jawaban_user = $_POST;

        try {
            // 1. Ambil Kunci Jawaban
            $stmt_kunci = $pdo->prepare("
                SELECT id, jawaban 
                FROM bank_soal 
                WHERE materi_id = :materi_id AND (jurusan = :jurusan OR jurusan = 'N/A') 
                ORDER BY RAND() 
                LIMIT 20
            ");
            $stmt_kunci->execute([
                'materi_id' => $submitted_materi_id,
                'jurusan' => $jurusan
            ]);
            $kunci_jawaban = $stmt_kunci->fetchAll(PDO::FETCH_KEY_PAIR);
            $total_soal = count($kunci_jawaban); // sekarang = 20


            // 2. Bandingkan Jawaban User dengan Kunci 
            foreach ($kunci_jawaban as $soal_id => $jawaban_benar) {
                // Periksa apakah jawaban untuk soal ini ada di POST data
                if (isset($jawaban_user["jawaban_{$soal_id}"])) {
                    
                    // Ambil jawaban user dan pastikan nilainya adalah integer 0, 1, 2, atau 3
                    $jawaban_pilihan_user = (int)$jawaban_user["jawaban_{$soal_id}"]; 
                    
                    // Bandingkan Jawaban User (0-3) dengan Kunci Jawaban DB (0-3)
                    if ($jawaban_pilihan_user === (int)$jawaban_benar) {
                        $skor++;
                    }
                }
            }
            
            // Hitung nilai persen
            $nilai_persen = $total_soal > 0 ? round(($skor / $total_soal) * 100, 2) : 0;
            $submission_result = ['skor' => $skor, 'total' => $total_soal];

            // 3. HAPUS SKOR LAMA JIKA ADA
            $stmt_delete = $pdo->prepare("DELETE FROM quiz_scores WHERE user_id = :user_id AND materi_id = :materi_id");
            $stmt_delete->execute([
                'user_id' => $user_id,
                'materi_id' => $submitted_materi_id
            ]);
            
            // 4. Simpan Skor BARU
        $sql_insert = "
            INSERT INTO quiz_scores (user_id, materi_id, skor, total_soal, jurusan, tanggal_mengerjakan)
            VALUES (:user_id, :materi_id, :skor, :total_soal, :jurusan, NOW())
        ";

        $stmt_simpan = $pdo->prepare($sql_insert);
        $stmt_simpan->execute([
            'user_id' => $user_id,
            'materi_id' => $submitted_materi_id,
            'skor' => $skor,
            'total_soal' => $total_soal,
            'jurusan' => $jurusan
        ]);

            
        } catch (PDOException $e) {
            $error_tugas = "Gagal memproses skor dan menyimpannya ke database: " . $e->getMessage();
            $quiz_submitted = false;
        }
    } else {
         $error_tugas = "ID Materi tidak valid untuk submsisi tugas.";
    }
}

// 4. PENGAMBILAN SOAL UNTUK TAMPILAN TUGAS (mode='tugas' DAN BELUM SUBMIT) (TETAP SAMA)


if ($mode === 'tugas' && !$quiz_submitted && $materi_id_tugas > 0 && $pdo_available) {
    try {
        $jurusan_user = $jurusan; 
        
        // Query untuk mengambil semua soal random berdasarkan materi_id dan jurusan user
        $stmt_soal = $pdo->prepare("SELECT id, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d FROM bank_soal WHERE materi_id = :materi_id AND (jurusan = :jurusan OR jurusan = 'N/A') ORDER BY RAND()");
        
        $stmt_soal->execute([
            'materi_id' => $materi_id_tugas,
            'jurusan' => $jurusan_user 
        ]);
        
        $soal_tugas = $stmt_soal->fetchAll(PDO::FETCH_ASSOC);

        if (empty($soal_tugas)) {
            $error_tugas = "Maaf, belum ada soal tugas untuk Materi ID {$materi_id_tugas} dan Jurusan {$jurusan_user}.";
        }

    } catch (PDOException $e) {
        $error_tugas = "Terjadi kesalahan database saat mengambil soal: " . $e->getMessage();
    }
}
?>