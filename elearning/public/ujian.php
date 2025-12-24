<?php 

// Memulai sesi jika belum aktif
if (session_status() === PHP_SESSION_NONE) session_start();
// Memuat konfigurasi koneksi database
require_once __DIR__ . '/../config/db.php'; 

// Proteksi halaman: arahkan ke login jika sesi tidak ditemukan
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$action = $_GET['action'] ?? 'dashboard'; 
$error_msg = null;
$success_msg = null;

try {
    // Mengambil data profil pengguna berdasarkan ID sesi
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validasi keberadaan user di database
    if (!$user) {
        header("Location: ../auth/login.php");
        exit;
    }

    // Sanitasi data output untuk mencegah XSS
    $nama      = htmlspecialchars($user['nama'] ?? 'Pengguna');
    $role      = htmlspecialchars($user['role'] ?? 'Tidak Diketahui');
    $jurusan   = htmlspecialchars($user['jurusan'] ?? 'Umum');
    $email     = htmlspecialchars($user['email'] ?? 'email@contoh.com');

    // Mengambil inisial nama untuk avatar
    $initial = strtoupper(substr($nama, 0, 1));

    // --- LOGIKA PERSISTENSI WARNA AVATAR MENGGUNAKAN SESSION ---
    // Daftar pilihan warna Tailwind untuk background dan border
    $warna_map = [
        "bg-red-500" => "border-red-500",
        "bg-yellow-500" => "border-yellow-500",
        "bg-orange-500" => "border-orange-500",
        "bg-green-500" => "border-green-500",
        "bg-blue-500" => "border-blue-500",
        "bg-indigo-500" => "border-indigo-500",
        "bg-purple-500" => "border-purple-500",
        "bg-pink-500" => "border-pink-500"
    ];

    // Menetapkan warna acak sekali per sesi agar konsisten saat refresh
    if (!isset($_SESSION['avatar_bg']) || !isset($_SESSION['avatar_border'])) {
        $bg_random = array_rand($warna_map);
        $border_random = $warna_map[$bg_random];
        $_SESSION['avatar_bg'] = $bg_random;
        $_SESSION['avatar_border'] = $border_random;
    } else {
        $bg_random = $_SESSION['avatar_bg'];
        $border_random = $_SESSION['avatar_border'];
    }
    // --- AKHIR LOGIKA PERSISTENSI WARNA AVATAR ---

    // Menentukan path gambar profil (default null jika kosong)
    $foto = !empty($user['foto_profil'])
        ? "../" . htmlspecialchars($user['foto_profil'])
        : null;

} catch (PDOException $e) {
    // Menangkap dan menampilkan error database
    echo "Terjadi kesalahan database: " . $e->getMessage();
    exit;
}

// Menangani pesan notifikasi berdasarkan status URL parameter
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success_create_with_soal') {
         $count = (int)($_GET['count'] ?? 0);
         $success_msg = "Ujian dan $count soal berhasil dibuat! Anda bisa menambahkan atau mengedit soal lain di halaman kelola soal.";
    } elseif ($_GET['status'] === 'success_add') {
         $success_msg = "Soal berhasil ditambahkan ke ujian.";
    } elseif ($_GET['status'] === 'success_delete') {
         $success_msg = "Ujian berhasil dihapus beserta semua soal dan hasilnya.";
    }
}

// Menyiapkan variabel untuk menyimpan input form jika terjadi error
$temp_form_data = [
    'judul' => '',
    'durasi' => 60,
];
$temp_soal_data = []; 
$initial_soal_count = 10; 


if ($role === 'guru') {
    
    // Logika G.1: Proses pembuatan ujian baru beserta kumpulan soalnya
    if ($action === 'buat_ujian' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $judul = $_POST['judul'] ?? '';
        $durasi = (int)($_POST['durasi'] ?? 60);
        $jurusan_ujian = $jurusan; 
        
        $soal_data = $_POST['soal'] ?? [];
        $jumlah_soal_dibuat = count($soal_data);

        // Retensi data form untuk pengisian ulang jika gagal
        $temp_form_data = [
            'judul' => htmlspecialchars($judul),
            'durasi' => $durasi,
        ];
        $temp_soal_data = $soal_data; 
        $initial_soal_count = $jumlah_soal_dibuat;

        // Validasi minimal data judul dan keberadaan soal
        if (!empty($judul) && $jumlah_soal_dibuat > 0) {
            
            $validasi_ok = true;
            $error_soal_index = null;

            // Validasi setiap baris soal (kelengkapan kolom dan kunci jawaban)
            foreach ($soal_data as $index => $soal) {
                if (empty($soal['pertanyaan']) || empty($soal['opsi_a']) || empty($soal['opsi_b']) || empty($soal['opsi_c']) || empty($soal['opsi_d']) || empty($soal['kunci_jawaban']) || !in_array(strtoupper($soal['kunci_jawaban']), ['A', 'B', 'C', 'D'])) {
                    $validasi_ok = false;
                    $error_soal_index = $index; 
                    break;
                }
            }

            if ($validasi_ok) {
                try {
                    // Menggunakan transaksi agar data ujian dan soal tersimpan serentak
                    $pdo->beginTransaction();
                    
                    // 1. Simpan data header ujian
                    $stmt = $pdo->prepare("INSERT INTO ujian (judul, jurusan, guru_id, durasi_menit) VALUES (:judul, :jurusan, :guru_id, :durasi)");
                    $stmt->execute([
                        'judul' => $judul,
                        'jurusan' => $jurusan_ujian,
                        'guru_id' => $user_id,
                        'durasi' => $durasi
                    ]);
                    $ujian_id = $pdo->lastInsertId();

                    // 2. Loop dan simpan semua soal yang diinput
                    $insert_soal_sql = "INSERT INTO soal (ujian_id, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, kunci_jawaban) VALUES (:u_id, :tanya, :a, :b, :c, :d, :kunci)";
                    $stmt_soal = $pdo->prepare($insert_soal_sql);
                    
                    foreach ($soal_data as $soal) {
                        $stmt_soal->execute([
                            'u_id' => $ujian_id,
                            'tanya' => $soal['pertanyaan'],
                            'a' => $soal['opsi_a'] ?? '',
                            'b' => $soal['opsi_b'] ?? '',
                            'c' => $soal['opsi_c'] ?? '',
                            'd' => $soal['opsi_d'] ?? '',
                            'kunci' => strtoupper($soal['kunci_jawaban'])
                        ]);
                    }

                    $pdo->commit();
                    header("Location: ujian.php?status=success_create_with_soal&count=$jumlah_soal_dibuat");
                    exit;
                } catch (PDOException $e) {
                    $pdo->rollBack(); // Batalkan jika ada error database
                    $error_msg = "Gagal membuat ujian dan soal: " . $e->getMessage();
                }
            } else {
                $error_msg = "Gagal membuat ujian. Soal #" . ($error_soal_index + 1) . " memiliki kolom yang kosong atau Kunci Jawaban tidak valid (harus A, B, C, atau D). Harap periksa kembali semua isian.";
            }
        } else {
            $error_msg = "Judul, Durasi, dan minimal satu set soal harus diisi.";
        }
    }
    
    // Logika G.2: Proses penambahan satu soal baru ke ujian yang sudah ada
    if ($action === 'tambah_soal' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $ujian_id = (int)($_POST['ujian_id'] ?? 0);
        $pertanyaan = $_POST['pertanyaan'] ?? '';
        $opsi_a = $_POST['opsi_a'] ?? '';
        $opsi_b = $_POST['opsi_b'] ?? '';
        $opsi_c = $_POST['opsi_c'] ?? '';
        $opsi_d = $_POST['opsi_d'] ?? '';
        $kunci_jawaban = strtoupper($_POST['kunci_jawaban'] ?? '');

        // Validasi input form soal tunggal
        if (!empty($ujian_id) && !empty($pertanyaan) && !empty($opsi_a) && !empty($opsi_b) && !empty($opsi_c) && !empty($opsi_d) && in_array($kunci_jawaban, ['A', 'B', 'C', 'D'])) {
            try {
                // Pastikan guru memiliki hak akses atas ujian tersebut
                $stmt_check = $pdo->prepare("SELECT id FROM ujian WHERE id = :ujian_id AND guru_id = :guru_id");
                $stmt_check->execute(['ujian_id' => $ujian_id, 'guru_id' => $user_id]);

                if ($stmt_check->rowCount() > 0) {
                    $stmt = $pdo->prepare("INSERT INTO soal (ujian_id, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, kunci_jawaban) VALUES (:u_id, :tanya, :a, :b, :c, :d, :kunci)");
                    $stmt->execute([
                        'u_id' => $ujian_id,
                        'tanya' => $pertanyaan,
                        'a' => $opsi_a,
                        'b' => $opsi_b,
                        'c' => $opsi_c,
                        'd' => $opsi_d,
                        'kunci' => $kunci_jawaban
                    ]);
                    header("Location: ujian.php?action=edit_soal&ujian_id=$ujian_id&status=success_add");
                    exit;
                } else {
                     $error_msg = "Akses ditolak. Ujian bukan milik Anda.";
                }

            } catch (PDOException $e) {
                $error_msg = "Gagal menambahkan soal: " . $e->getMessage();
            }
        } else {
            $error_msg = "Semua kolom Soal harus diisi lengkap, dan kunci jawaban harus valid (A, B, C, D).";
        }
    }
    
    // Logika G.3: Proses menghapus ujian beserta seluruh data relasinya (Cascade Manual)
    if ($action === 'hapus_ujian' && isset($_GET['ujian_id'])) {
        $ujian_id_to_delete = (int)($_GET['ujian_id']);
        
        try {
            $pdo->beginTransaction();
            // Verifikasi kepemilikan sebelum menghapus
            $stmt_check = $pdo->prepare("SELECT id FROM ujian WHERE id = :ujian_id AND guru_id = :guru_id");
            $stmt_check->execute(['ujian_id' => $ujian_id_to_delete, 'guru_id' => $user_id]);

            if ($stmt_check->rowCount() > 0) {
                // Hapus data terkait: soal, hasil ujian, lalu data ujian induk
                $pdo->prepare("DELETE FROM soal WHERE ujian_id = :ujian_id")->execute(['ujian_id' => $ujian_id_to_delete]);
                $pdo->prepare("DELETE FROM hasil_ujian WHERE ujian_id = :ujian_id")->execute(['ujian_id' => $ujian_id_to_delete]);
                $pdo->prepare("DELETE FROM ujian WHERE id = :ujian_id")->execute(['ujian_id' => $ujian_id_to_delete]);

                $pdo->commit();
                header("Location: ujian.php?status=success_delete");
                exit;
            } else {
                $error_msg = "Akses ditolak. Ujian tidak ditemukan atau bukan milik Anda.";
                $pdo->rollBack();
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            $error_msg = "Gagal menghapus ujian: " . $e->getMessage();
        }
    }
    
    // Logika G.4: Mengambil data hasil ujian seluruh siswa untuk dilihat guru
    if ($action === 'lihat_hasil' && isset($_GET['ujian_id'])) {
        $ujian_id_to_view = (int)($_GET['ujian_id']);
        $ujian_data_guru = null;
        $daftar_hasil_siswa = [];
        
        try {
            // Validasi kepemilikan ujian
            $stmt_ujian = $pdo->prepare("SELECT id, judul, jurusan FROM ujian WHERE id = :ujian_id AND guru_id = :guru_id");
            $stmt_ujian->execute(['ujian_id' => $ujian_id_to_view, 'guru_id' => $user_id]);
            $ujian_data_guru = $stmt_ujian->fetch(PDO::FETCH_ASSOC);

            if ($ujian_data_guru) {
                $target_jurusan = $ujian_data_guru['jurusan'];
                
                // Query JOIN untuk mendapatkan nilai siswa atau status 'belum mengerjakan' (LEFT JOIN)
                $stmt_siswa = $pdo->prepare("
                    SELECT 
                        u.id AS siswa_id, 
                        u.nama, 
                        h.nilai, 
                        h.jumlah_benar, 
                        h.jumlah_salah
                    FROM users u 
                    LEFT JOIN hasil_ujian h 
                        ON u.id = h.siswa_id AND h.ujian_id = ?
                    WHERE 
                        u.role = 'siswa' AND (u.jurusan = ? OR ? = 'N/A')
                    ORDER BY u.nama ASC
                ");
                
                // Menjalankan query dengan 3 parameter posisi
                $stmt_siswa->execute([
                    $ujian_id_to_view, 
                    $target_jurusan,   
                    $target_jurusan    
                ]);
                $daftar_hasil_siswa = $stmt_siswa->fetchAll(PDO::FETCH_ASSOC);
                
            } else {
                 $error_msg = "Akses ditolak. Ujian tidak ditemukan atau bukan milik Anda.";
                 $action = 'dashboard';
            }
        } catch (PDOException $e) {
            $error_msg = "Gagal memuat hasil ujian siswa: " . $e->getMessage();
            $action = 'dashboard';
        }
    }

    // Mengambil daftar semua ujian yang pernah dibuat oleh guru ini
    try {
        $stmt = $pdo->prepare("SELECT id, judul, jurusan, durasi_menit, created_at FROM ujian WHERE guru_id = :guru_id ORDER BY created_at DESC");
        $stmt->execute(['guru_id' => $user_id]);
        $daftar_ujian_guru = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $daftar_ujian_guru = [];
        $error_ujian = "Gagal memuat daftar ujian: " . $e->getMessage();
    }
}


if ($role === 'siswa') {
    
    // Logika S.1 & S.2: Mengambil daftar ujian yang tersedia untuk jurusan siswa
    try {
        $stmt = $pdo->prepare("
            SELECT 
                u.id, u.judul, u.durasi_menit,
                h.id AS hasil_id, h.nilai
            FROM ujian u
            LEFT JOIN hasil_ujian h 
                ON u.id = h.ujian_id AND h.siswa_id = :siswa_id
            WHERE 
                u.jurusan = :jurusan OR u.jurusan = 'N/A' 
            ORDER BY u.created_at DESC
        ");
        $stmt->execute([
            'siswa_id' => $user_id,
            'jurusan' => $jurusan
        ]);
        $daftar_ujian_siswa = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $daftar_ujian_siswa = [];
        $error_ujian = "Gagal memuat daftar ujian: " . $e->getMessage();
    }
    
    // Inisialisasi data ujian saat siswa menekan tombol mulai
    $ujian_data_siswa = null;
    if ($action === 'mulai_ujian') {
        $ujian_id_to_start = (int)($_GET['ujian_id'] ?? 0);
        
        try {
            // Pastikan ujian sesuai jurusan
            $stmt_ujian = $pdo->prepare("SELECT id, judul, durasi_menit FROM ujian WHERE id = :id AND (jurusan = :jurusan OR jurusan = 'N/A')");
            $stmt_ujian->execute(['id' => $ujian_id_to_start, 'jurusan' => $jurusan]);
            $ujian_data_siswa = $stmt_ujian->fetch(PDO::FETCH_ASSOC);

            if (!$ujian_data_siswa) {
                $error_msg = 'Ujian tidak ditemukan atau Anda tidak berhak mengaksesnya.';
                $action = 'dashboard';
            } else {
                // Cegah pengerjaan ulang jika sudah ada nilai
                $stmt_cek = $pdo->prepare("SELECT id FROM hasil_ujian WHERE ujian_id = :ujian_id AND siswa_id = :siswa_id");
                $stmt_cek->execute(['ujian_id' => $ujian_id_to_start, 'siswa_id' => $user_id]);

                if ($stmt_cek->rowCount() > 0) {
                     $error_msg = 'Anda sudah mengerjakan ujian ini. Silakan lihat nilai Anda.';
                     $action = 'dashboard';
                }
            }
        } catch (PDOException $e) {
            $error_msg = "Terjadi kesalahan saat memuat detail ujian: " . $e->getMessage();
            $action = 'dashboard';
        }
    }


    if ($action === 'selesai_ujian' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $ujian_id_submitted = (int)($_POST['ujian_id'] ?? 0);
        $jawaban_siswa = $_POST['jawaban'] ?? []; 
        
        if (!$ujian_id_submitted) {
            $error_msg = "ID Ujian tidak valid.";
        } else {
            try {
                // Hitung total soal yang ada di database untuk ujian ini
                $stmt_ujian = $pdo->prepare("SELECT COUNT(s.id) AS total_soal FROM ujian u JOIN soal s ON u.id = s.ujian_id WHERE u.id = :id");
                $stmt_ujian->execute(['id' => $ujian_id_submitted]);
                $total_soal_row = $stmt_ujian->fetch(PDO::FETCH_ASSOC);
                $total_soal = (int)($total_soal_row['total_soal'] ?? 0);

                // Cek ganda untuk keamanan pengerjaan
                $stmt_cek = $pdo->prepare("SELECT id FROM hasil_ujian WHERE ujian_id = :ujian_id AND siswa_id = :siswa_id");
                $stmt_cek->execute(['ujian_id' => $ujian_id_submitted, 'siswa_id' => $user_id]);

                if ($stmt_cek->rowCount() > 0) {
                     $error_msg = 'Anda sudah mengerjakan ujian ini.';
                } else {
                    // 1. Ambil seluruh Kunci Jawaban yang benar dari database
                    $soal_ids = array_keys($jawaban_siswa);
                    
                    if (count($soal_ids) > 0) {
                         $placeholders = implode(',', array_fill(0, count($soal_ids), '?'));
                         $stmt_kunci = $pdo->prepare("SELECT id, kunci_jawaban FROM soal WHERE id IN ($placeholders)");
                         $stmt_kunci->execute($soal_ids);
                         $kunci_jawaban_db = $stmt_kunci->fetchAll(PDO::FETCH_KEY_PAIR);
                    } else {
                        $kunci_jawaban_db = [];
                    }

                    // 2. Bandingkan jawaban siswa dengan kunci untuk menghitung skor benar
                    $score = 0;
                    foreach ($jawaban_siswa as $soal_id => $jawaban) {
                        $soal_id = (int)$soal_id;
                        $jawaban = strtoupper(trim($jawaban));
                        if (isset($kunci_jawaban_db[$soal_id]) && $kunci_jawaban_db[$soal_id] === $jawaban) {
                            $score++;
                        }
                    }

                    // 3. Kalkulasi data statistik hasil ujian
                    $jumlah_benar = $score;
                    $jumlah_salah = $total_soal - $jumlah_benar; 
                    $nilai_persen = ($total_soal > 0) ? round(($jumlah_benar / $total_soal) * 100, 2) : 0; 
                    
                    // 4. Masukkan data hasil akhir ke tabel hasil_ujian
                    $stmt_insert = $pdo->prepare("INSERT INTO hasil_ujian (ujian_id, siswa_id, nilai, jumlah_benar, jumlah_salah) VALUES (:u_id, :s_id, :nilai, :benar, :salah)");
                    $stmt_insert->execute([
                        'u_id' => $ujian_id_submitted,
                        's_id' => $user_id,
                        'nilai' => $nilai_persen, 
                        'benar' => $jumlah_benar,
                        'salah' => $jumlah_salah
                    ]);
                    
                    header("Location: ujian.php?action=lihat_nilai&ujian_id=$ujian_id_submitted&status=selesai");
                    exit;
                }

            } catch (PDOException $e) {
                $error_msg = "Gagal memproses ujian: " . $e->getMessage();
            }
        }
        $action = 'dashboard';
    }


    if ($action === 'lihat_nilai') {
        $ujian_id_to_view = (int)($_GET['ujian_id'] ?? 0);
        $hasil_data = null;
        $ujian_detail = null;

        if ($ujian_id_to_view > 0) {
             try {
                // Ambil data nilai, benar, dan salah dari database
                $stmt_hasil = $pdo->prepare("SELECT nilai, jumlah_benar, jumlah_salah FROM hasil_ujian WHERE ujian_id = :u_id AND siswa_id = :s_id");
                $stmt_hasil->execute(['u_id' => $ujian_id_to_view, 's_id' => $user_id]);
                $hasil_data = $stmt_hasil->fetch(PDO::FETCH_ASSOC);

                // Ambil judul ujian untuk informasi tampilan
                $stmt_detail = $pdo->prepare("SELECT judul, durasi_menit FROM ujian WHERE id = :id");
                $stmt_detail->execute(['id' => $ujian_id_to_view]);
                $ujian_detail = $stmt_detail->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                 $error_msg = "Gagal memuat hasil ujian: " . $e->getMessage();
            }
        }
        
        if (isset($_GET['status']) && $_GET['status'] === 'selesai') {
             $success_msg = 'Selamat! Ujian telah berhasil dikumpulkan. Berikut adalah hasilnya.';
        }
    }
}

// Mengubah data soal menjadi format JSON untuk diproses JavaScript di front-end
$initial_soal_json = json_encode($temp_soal_data);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Ujian</title>
    <link rel="shortcut icon" href="../assets/images/logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzLcl98jS290e2D91X3wR50wU138Vz1N1K/2T0M7Cg+lqj2Q/9Zf+A5I9+Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* BASE STYLING untuk tema E-Learning */
        body {
            font-family: 'Inter', sans-serif;
        }
        .card { 
            /* Hapus shadow bawaan untuk digantikan oleh glass-card */
            transition: transform 0.3s ease-in-out; 
            border-radius: 0.75rem; /* Default rounded-xl from tailwind */
        }

        /* Efek Glassmorphism Utama - HAPUS BORDER */
        .glass-card {
            background-color: rgba(255, 255, 255, 0.75); /* Transparan 75% Putih */
            /* border: 1px solid rgba(255, 255, 255, 0.2); <--- HAPUS BORDER */
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.15); /* Shadow kuat tapi transparan */
            backdrop-filter: blur(12px); /* Efek Blur yang lebih kuat */
            -webkit-backdrop-filter: blur(12px);
            transition: all 0.3s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.5); /* Tambah border putih transparan halus */
        }

        /* Efek Glassmorphism Sekunder (Untuk elemen di dalam card/form) - HAPUS BORDER */
        .glass-sub-card {
            background-color: rgba(255, 255, 255, 0.9); /* Lebih solid */
            /* border: 1px solid rgba(255, 255, 255, 0.4); <--- HAPUS BORDER */
            box-shadow: 0 4px 10px 0 rgba(0, 0, 0, 0.08); /* Shadow sedikit diperkuat */
            backdrop-filter: blur(8px); 
            -webkit-backdrop-filter: blur(8px);
            border-radius: 0.5rem; /* rounded-lg */
            transition: all 0.3s ease-in-out;
            border: 1px solid rgba(255, 255, 255, 0.7); /* Tambah border putih transparan halus */
        }

        /* Navigasi Khusus (untuk menghilangkan border-radius) */
        .nav-glass-card {
            background-color: rgba(255, 255, 255, 0.85); /* Sedikit lebih solid untuk nav */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.7); /* Border bawah halus */
        }

        .btn-primary { 
            /* Modern, Shadowed Button */
            @apply bg-indigo-600 text-white hover:bg-indigo-700 font-bold py-2 px-4 rounded-xl transition duration-300 ease-in-out shadow-lg shadow-indigo-500/50 hover:shadow-xl; 
        }
        .btn-secondary { 
                /* Ghost/Outline Button */
            @apply bg-transparent text-gray-700 hover:bg-gray-100 border border-gray-300 font-bold py-2 px-4 rounded-xl transition duration-300 ease-in-out; 
        }
        /* New: Green Primary Button for 'View Score' */
        .btn-success { 
            @apply bg-green-600 text-white hover:bg-green-700 font-bold py-2 px-4 rounded-xl transition duration-300 ease-in-out shadow-lg shadow-green-500/50 hover:shadow-xl; 
        }
            .btn-danger { 
            @apply bg-red-600 text-white hover:bg-red-700 font-bold py-2 px-4 rounded-xl transition duration-300 ease-in-out shadow-lg shadow-red-500/50 hover:shadow-xl; 
        }


        .form-input { 
            /* Desain input agar tidak polos: border, shadow, focus ring */
            @apply shadow-inner appearance-none border border-gray-200 rounded-xl w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-400 transition duration-150; 
            background-color: rgba(255, 255, 255, 0.95); /* Efek glass ringan */
        }

        /* Gaya Radio Button Kustom (Opsi Jawaban Siswa) */
        .opsi-label:hover {
            background-color: rgba(165, 180, 252, 0.1); /* indigo-300/10 */
        }
        .opsi-label input:checked + .opsi-content {
            background-color: #EEF2FF; /* indigo-50 */
            border-color: #6366F1; /* indigo-600 */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        /* Animasi Modal Dropdown */
        .modal-enter {
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
            opacity: 0;
            transform: translateY(-20px);
        }
        .modal-enter-active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="min-h-screen">
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

    <header class="fixed top-0 left-0 w-full h-12 bg-gray-800/75 backdrop-blur-md text-white shadow-xl z-[99] md:hidden">
        <div class="h-full flex items-center justify-between px-3">

            <!-- Tombol Kembali -->
            <a href="dashboard.php"
            class="flex items-center gap-2 text-sm font-medium text-gray-200 
                    hover:text-white transition">
                <i class="fa-solid fa-arrow-left text-base"></i>
                Kembali
            </a>

            <!-- Foto Profil / Inisial -->
            <div class="flex items-center h-8 sm:h-10 border-l border-gray-700 pl-3 sm:pl-4">
                <?php if ($foto): ?>
                    <img src="<?= htmlspecialchars($foto, ENT_QUOTES, 'UTF-8'); ?>"
                        class="w-7 h-7 rounded-full object-cover border 
                                <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>"
                        alt="Foto Profil">
                <?php else: ?>
                    <div class="w-7 h-7 rounded-full flex items-center justify-center 
                                text-white text-sm font-bold border 
                                <?= htmlspecialchars($bg_random, ENT_QUOTES, 'UTF-8'); ?> 
                                <?= htmlspecialchars($border_random, ENT_QUOTES, 'UTF-8'); ?>">
                        <?= htmlspecialchars($initial, ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </header>
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 mt-16">
    <?php if ($error_msg): ?>
        <!-- Alert error -->
        <div class="bg-red-50 border border-red-300 border-l-4 border-red-500 text-red-700 p-4 rounded-xl relative mb-8 card glass-card shadow-lg" role="alert">
            <p class="font-bold flex items-center">
                <i class="fa-solid fa-circle-exclamation mr-2"></i> Gagal!
            </p>
            <p class="text-sm mt-1"><?= htmlspecialchars($error_msg, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endif; ?>

    <?php if ($success_msg): ?>
        <!-- Alert sukses -->
        <div class="bg-green-50 border border-green-300 border-l-4 border-green-500 text-green-700 p-4 rounded-xl relative mb-8 card glass-card shadow-lg" role="alert">
            <p class="font-bold flex items-center">
                <i class="fa-solid fa-circle-check mr-2"></i> Berhasil!
            </p>
            <p class="text-sm mt-1"><?= htmlspecialchars($success_msg, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    <?php endif; ?>

        <?php if ($role === 'guru'): ?>
            
            <?php if ($action === 'dashboard'): ?>
            
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div class="mb-4 md:mb-0">
                        <!-- Link kembali -->
                        <a href="dashboard.php" 
                            class="hidden md:flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-indigo-600 transition duration-150 group mb-2">   
                            <i class="fa-solid fa-arrow-left text-base group-hover:scale-105 transition-transform"></i> 
                            Kembali
                        </a>
                        <div>
                            <!-- Judul dashboard -->
                            <h2 class="text-3xl font-extrabold text-indigo-700 mb-1 border-b border-indigo-100 pb-2">
                                <i class="fa-solid fa-chalkboard-user mr-2 text-indigo-500"></i> Dashboard Guru
                            </h2>
                            <!-- Deskripsi jurusan aman -->
                            <p class="text-gray-500 text-sm italic"> Kelola ujian untuk jurusan: 
                                <span class="font-bold text-gray-700"><?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?></span>. 
                            </p>
                        </div>
                    </div>
                    <!-- Tombol buat ujian, ikon diubah ke Font Awesome -->
                    <button id="open-create-modal" class="btn-primary flex items-center">
                        <i class="fa-solid fa-plus mr-1"></i> Buat Ujian 
                    </button>
                </div>
                
                <div id="modal-create" class="fixed inset-0 bg-gray-900 bg-opacity-40 overflow-y-auto h-full w-full hidden z-[40] p-4 sm:p-8 transition-opacity duration-300">
                    <div class="modal-content relative mx-auto top-5 w-full max-w-sm sm:max-w-xl md:max-w-3xl glass-card shadow-2xl rounded-xl p-6 pb-16 sm:p-8 modal-enter">
                        <div class="flex justify-between items-center border-b border-indigo-200 pb-3 mb-4">
                            <!-- Judul modal -->
                            <h3 class="text-xl font-extrabold text-indigo-700">Formulir Ujian Baru</h3>
                            <!-- Tombol tutup modal -->
                            <button type="button" onclick="closeModal('modal-create')" class="text-gray-400 hover:text-gray-600 transition duration-150">
                                <i class="fa-solid fa-xmark h-6 w-6"></i>
                            </button>
                        </div>
                        <!-- Informasi jurusan ujian -->
                        <p class="mb-4 text-sm text-gray-600">
                            Ujian ini akan otomatis ditujukan untuk Jurusan <?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?>.
                        </p>
                        <form method="POST" action="ujian.php?action=buat_ujian" id="form-buat-ujian">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <!-- Input judul ujian aman -->
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="judul">Judul Ujian</label>
                                    <input type="text" name="judul" id="judul" required 
                                        value="<?= htmlspecialchars($temp_form_data['judul'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
                                        class="form-input border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" 
                                        placeholder="Contoh: Ujian Tengah Semester">
                                </div>
                                
                                <div>
                                    <!-- Input durasi aman -->
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="durasi">Durasi (Menit)</label>
                                    <input type="number" name="durasi" id="durasi" required min="1" max="360" 
                                        value="<?= htmlspecialchars($temp_form_data['durasi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
                                        class="form-input border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                </div>
                            </div>
                            
                            <div class="mb-8 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                                    <label class="block text-base font-semibold text-gray-800 mb-2 sm:mb-0">Tentukan Jumlah Soal Awal</label>
                                    
                                    <div class="w-full sm:w-auto">
                                        <!-- Select jumlah soal aman -->
                                        <select id="jumlah_soal" 
                                            class="border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full text-base py-2 px-3">
                                            <?php for($i=5; $i<=30; $i+=5): ?>
                                                <option value="<?= htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>" 
                                                    <?php if ($i == ($temp_form_data['jumlah_soal'] ?? 20)) echo 'selected'; ?>>
                                                    <?= htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?> Soal
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 italic mt-2">
                                    <i class="fas fa-info-circle mr-1"></i> Jumlah ini akan menentukan berapa banyak input soal yang muncul di bawah.
                                </p>
                            </div>
                            
                            <div id="soal_container" class="space-y-6 mb-8 border-t pt-6">
                                <h3 class="text-xl font-semibold text-gray-800">Daftar Soal (Akan dimuat di sini)</h3>
                            </div>
                            <!-- Tombol submit buat ujian -->
                            <button type="submit" class="w-full flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition duration-150 ease-in-out text-lg">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Buat Ujian & Simpan Soal
                            </button>
                        </form>
                    </div>
                </div>
                
                <div class="card glass-card p-6 rounded-xl shadow-lg">
                    <!-- Judul daftar ujian -->
                    <h3 class="text-xl font-bold mb-4 text-indigo-700 border-b border-indigo-200 pb-2">Daftar Ujian Anda</h3>
                    <?php if (isset($error_ujian)): ?>
                        <!-- Pesan error aman -->
                        <p class="text-red-500 text-sm"><?= htmlspecialchars($error_ujian, ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php elseif (empty($daftar_ujian_guru)): ?>
                        <!-- Pesan belum ada ujian -->
                        <p class="text-gray-500 text-center py-8 bg-gray-50 rounded-lg">Anda belum membuat ujian apa pun.</p>
                    <?php else: ?>
                        <div class="overflow-x-auto shadow-md rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-indigo-50/80">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Judul</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Jurusan</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Durasi (Min)</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Dibuat</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="glass-sub-card divide-y divide-gray-100">
                                <?php foreach ($daftar_ujian_guru as $ujian): ?>
                                    <tr class="hover:bg-indigo-50/50 transition duration-150">
                                        <!-- Judul ujian aman -->
                                        <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($ujian['judul'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <!-- Jurusan aman -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 shadow-sm">
                                                <?= htmlspecialchars($ujian['jurusan'], ENT_QUOTES, 'UTF-8'); ?>
                                            </span>
                                        </td>
                                        <!-- Durasi aman -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($ujian['durasi_menit'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <!-- Tanggal aman -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= htmlspecialchars(date('d M Y', strtotime($ujian['created_at'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <!-- Aksi aman -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="ujian.php?action=edit_soal&ujian_id=<?= htmlspecialchars($ujian['id'], ENT_QUOTES, 'UTF-8'); ?>" class="text-indigo-600 hover:text-indigo-800 hover:underline transition duration-150">Edit Soal</a>
                                            <a href="ujian.php?action=lihat_hasil&ujian_id=<?= htmlspecialchars($ujian['id'], ENT_QUOTES, 'UTF-8'); ?>" class="text-green-600 hover:text-green-800 hover:underline transition duration-150">Lihat Hasil</a>
                                            <a href="ujian.php?action=hapus_ujian&ujian_id=<?= htmlspecialchars($ujian['id'], ENT_QUOTES, 'UTF-8'); ?>" class="text-red-600 hover:text-red-800 hover:underline transition duration-150 btn-delete-confirm" data-ujian-title="<?= htmlspecialchars($ujian['judul'], ENT_QUOTES, 'UTF-8'); ?>">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>

            <?php elseif ($action === 'edit_soal' && isset($_GET['ujian_id'])): 
                $current_ujian_id = (int)($_GET['ujian_id']);
                // (Kelola Soal) 
            ?>
            <div class="mb-6 flex items-center justify-between">
                <!-- Link kembali ke dashboard ujian -->
                <a href="ujian.php" class="text-sm font-semibold text-indigo-500 hover:text-indigo-600 transition duration-150 group flex items-center">
                    <i class="fa-solid fa-arrow-left mr-1 group-hover:scale-105 transition-transform"></i> Kembali ke Dashboard Ujian
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1">
                    <div class="card glass-card p-6 sticky top-20 rounded-xl shadow-lg">
                        <h3 class="text-xl font-bold mb-4 text-indigo-700 border-b border-indigo-200 pb-2">Tambah Soal Baru</h3>
                        <form method="POST" action="ujian.php?action=tambah_soal" class="space-y-4">
                            <!-- Input ujian_id aman -->
                            <input type="hidden" name="ujian_id" value="<?= htmlspecialchars($current_ujian_id, ENT_QUOTES, 'UTF-8'); ?>">
                            
                            <div>
                                <!-- Textarea pertanyaan -->
                                <label class="block text-gray-700 text-sm font-semibold mb-1" for="pertanyaan">Pertanyaan</label>
                                <textarea name="pertanyaan" id="pertanyaan" required class="form-input" rows="3" placeholder="Masukkan teks pertanyaan..."></textarea>
                            </div>
                            
                            <div>
                                <!-- Pilih kunci jawaban -->
                                <label class="block text-gray-700 text-sm font-semibold mb-1" for="kunci_jawaban">Kunci Jawaban Benar</label>
                                <select name="kunci_jawaban" id="kunci_jawaban" required class="form-input">
                                    <option value="">Pilih Kunci</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Input opsi jawaban -->
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-1" for="opsi_a">Opsi A</label>
                                    <input type="text" name="opsi_a" id="opsi_a" required class="form-input text-sm">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-1" for="opsi_b">Opsi B</label>
                                    <input type="text" name="opsi_b" id="opsi_b" required class="form-input text-sm">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-1" for="opsi_c">Opsi C</label>
                                    <input type="text" name="opsi_c" id="opsi_c" required class="form-input text-sm">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-1" for="opsi_d">Opsi D</label>
                                    <input type="text" name="opsi_d" id="opsi_d" required class="form-input text-sm">
                                </div>
                            </div>

                            <!-- Tombol tambah soal -->
                            <button type="submit" class="btn-primary w-full mt-4">Tambah Soal</button>
                        </form>

                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="card glass-card p-6 rounded-xl shadow-lg">
                        <h3 class="text-xl font-bold mb-4 text-indigo-700 border-b border-indigo-200 pb-2">Daftar Soal Ujian</h3>
                        <p class="text-gray-500 text-center py-8 bg-gray-50 rounded-lg">Fitur Edit Soal (daftar soal) akan tersedia di versi selanjutnya. Silakan tambahkan soal menggunakan formulir di samping.</p>
                    </div>
                </div>
            </div>

            <?php elseif ($action === 'lihat_hasil' && isset($ujian_data_guru)): ?>
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-indigo-200 pb-4">
                    <div class="mb-3 sm:mb-0">
                        <!-- Judul ujian aman -->
                        <h2 class="text-2xl font-extrabold text-indigo-700">Hasil Ujian: <?= htmlspecialchars($ujian_data_guru['judul'], ENT_QUOTES, 'UTF-8'); ?></h2>
                        <!-- Jurusan aman -->
                        <p class="text-gray-500 text-sm italic">Jurusan: <span class="font-bold text-gray-700"><?= htmlspecialchars($ujian_data_guru['jurusan'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                    </div>
                    <!-- Link kembali ke dashboard -->
                    <a href="ujian.php" class="group btn-secondary font-semibold transition duration-150 flex items-center">
                        <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Dashboard Ujian
                    </a>
                </div>
                
                <div class="card glass-card p-6 rounded-xl shadow-lg">
                    <!-- Judul daftar hasil siswa aman -->
                    <h3 class="text-xl font-bold mb-4 text-indigo-700 border-b border-indigo-200 pb-2">
                        Daftar Hasil Siswa (Total: <?= htmlspecialchars(count($daftar_hasil_siswa), ENT_QUOTES, 'UTF-8'); ?>)
                    </h3>
                    <?php if (empty($daftar_hasil_siswa)): ?>
                        <p class="text-gray-500 text-center py-8 bg-gray-50 rounded-lg">Tidak ada siswa terdaftar untuk jurusan ini atau terjadi kesalahan data.</p>
                    <?php else: ?>
                        <div class="overflow-x-auto shadow-md rounded-xl">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-indigo-50/80">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-indigo-700 uppercase tracking-wider">Nama Siswa</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider">Nilai (%)</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-indigo-700 uppercase tracking-wider">Benar / Salah</th>
                                    </tr>
                                </thead>
                                <tbody class="glass-sub-card divide-y divide-gray-100">
                                    <?php foreach ($daftar_hasil_siswa as $hasil): ?>
                                        <?php 
                                            // Hitung status dan nilai
                                            $is_done = !empty($hasil['nilai']) || $hasil['nilai'] === 0.00; // 0.00 juga dianggap selesai
                                            $status_text = $is_done ? 'Sudah Mengerjakan' : 'Belum Mengerjakan';
                                            $status_class = $is_done ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
                                            $nilai_display = $is_done ? number_format((float)$hasil['nilai'], 2) : '-';
                                            $jumlah_benar = (int)($hasil['jumlah_benar'] ?? 0);
                                            $jumlah_salah = (int)($hasil['jumlah_salah'] ?? 0);
                                            $benar_salah_display = $is_done ? "$jumlah_benar / $jumlah_salah" : '- / -';
                                        ?>
                                        <tr class="hover:bg-gray-50/50 transition duration-150">
                                            <!-- Nama siswa aman -->
                                            <td class="px-6 py-4 font-medium text-gray-900"><?= htmlspecialchars($hasil['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <!-- Status pengerjaan -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full <?= $status_class; ?> shadow-sm">
                                                    <?= htmlspecialchars($status_text, ENT_QUOTES, 'UTF-8'); ?>
                                                </span>
                                            </td>
                                            <!-- Nilai aman -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-bold text-indigo-600"><?= htmlspecialchars($nilai_display, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <!-- Jumlah benar/salah aman -->
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700"><?= htmlspecialchars($benar_salah_display, ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                
            <?php endif; ?>

        <?php elseif ($role === 'siswa'): ?>

            <?php if ($action === 'mulai_ujian' && $ujian_data_siswa): 
                // Ambil semua soal untuk ujian yang dipilih
                try {
                    $stmt_soal = $pdo->prepare("SELECT id, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d FROM soal WHERE ujian_id = :ujian_id ORDER BY id ASC");
                    $stmt_soal->execute(['ujian_id' => $ujian_data_siswa['id']]);
                    $daftar_soal = $stmt_soal->fetchAll(PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    $error_msg = "Gagal memuat soal ujian: " . $e->getMessage();
                    $daftar_soal = [];
                }
            ?>
            <div class="mb-6 flex items-center justify-between border-b border-indigo-200 pb-4">
                <!-- Judul ujian aman -->
                <h2 class="text-3xl font-extrabold text-indigo-700">
                    <i class="fa-solid fa-file-signature mr-2 text-indigo-500"></i>
                    Mulai Ujian: <?= htmlspecialchars($ujian_data_siswa['judul'], ENT_QUOTES, 'UTF-8'); ?>
                </h2>
                <!-- Tombol kembali -->
                <a href="ujian.php" class="group btn-secondary text-sm font-semibold transition duration-150 flex items-center">
                    <i class="fa-solid fa-arrow-left text-base group-hover:scale-105 transition-transform mr-1"></i> Batal / Kembali
                </a>
            </div>
            
            <div class="card glass-card p-6 rounded-xl shadow-lg">
                <?php if (empty($daftar_soal)): ?>
                    <!-- Pesan jika soal kosong -->
                    <p class="text-gray-500 text-center py-8 bg-gray-50 rounded-lg">Belum ada soal tersedia untuk ujian ini.</p>
                <?php else: ?>
                    <!-- Info durasi ujian -->
                    <p class="mb-4 text-gray-600 font-medium">
                        Jawab semua pertanyaan di bawah ini. Durasi ujian: 
                        <strong><?= (int)$ujian_data_siswa['durasi_menit']; ?> menit</strong>.
                    </p>
                    <form method="POST" action="ujian.php?action=selesai_ujian" id="ujian_form" onsubmit="return validateJawaban(this)">
                        <input type="hidden" name="ujian_id" value="<?= (int)$ujian_data_siswa['id']; ?>">
                        <div class="space-y-8">
                            <?php foreach ($daftar_soal as $index => $soal): ?>
                            <div class="glass-sub-card p-5 rounded-xl soal-item" data-soal-id="<?= (int)$soal['id']; ?>">
                                <p class="font-extrabold text-lg mb-4 text-indigo-800 border-b border-indigo-100 pb-2">Soal <?= $index + 1; ?>.</p>
                                <!-- Pertanyaan aman -->
                                <p class="font-medium text-gray-800 mb-4"><?= htmlspecialchars($soal['pertanyaan'], ENT_QUOTES, 'UTF-8'); ?></p>
                                <div class="space-y-3">
                                    <?php foreach (['a', 'b', 'c', 'd'] as $opsi_key): ?>
                                        <?php $opsi_value = $soal['opsi_' . $opsi_key]; ?>
                                        <label class="opsi-label flex items-start p-3 rounded-lg cursor-pointer transition duration-150 border border-transparent">
                                            <input type="radio" name="jawaban[<?= (int)$soal['id']; ?>]" value="<?= strtoupper($opsi_key); ?>" class="form-radio text-indigo-600 mt-1 h-5 w-5 opacity-0 absolute">
                                            <div class="opsi-content flex-1 flex items-start p-3 rounded-lg border-2 border-gray-200 transition duration-150 hover:border-indigo-400">
                                                <span class="text-sm font-extrabold text-indigo-600 w-6 flex-shrink-0"><?= strtoupper($opsi_key); ?>.</span>
                                                <span class="ml-2 text-base text-gray-700"><?= htmlspecialchars($opsi_value, ENT_QUOTES, 'UTF-8'); ?></span>
                                            </div>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn-primary mt-6 w-full text-lg">Selesaikan dan Kumpulkan Ujian</button>
                    </form>
                <?php endif; ?>
            </div>
            
            <?php elseif ($action === 'lihat_nilai'): 
                if ($hasil_data && $ujian_detail): 
                    // Konversi tipe data untuk keamanan
                    $nilai_persen = (float)$hasil_data['nilai'];
                    $jumlah_benar = (int)$hasil_data['jumlah_benar'];
                    $jumlah_salah = (int)$hasil_data['jumlah_salah'];
                    $total_soal = $jumlah_benar + $jumlah_salah; // Total soal untuk display
                    $nilai_status = ($nilai_persen >= 75) ? 'LULUS' : 'REMIDI';
                    $border_color = ($nilai_persen >= 75) ? '#10B981' : '#EF4444'; // Warna border sesuai status
                    $bg_color = ($nilai_persen >= 75) ? 'bg-green-100' : 'bg-red-100';
            ?>
            <div class="mb-6 flex items-center justify-between border-b border-indigo-200 pb-4">
                <h2 class="text-3xl font-extrabold text-indigo-700">
                    <i class="fa-solid fa-square-poll-vertical mr-2 text-indigo-500"></i>
                    <?= htmlspecialchars($ujian_detail['judul'], ENT_QUOTES, 'UTF-8'); ?>
                </h2>
            </div>
            
            <div class="card glass-card p-4 sm:p-6 rounded-xl shadow-lg pb-6">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 mb-6">
                    
                    <div class="glass-sub-card p-5 text-center border-4 rounded-xl shadow-lg" style="border-color: <?= htmlspecialchars($border_color, ENT_QUOTES, 'UTF-8'); ?>">
                        <!-- Label nilai -->
                        <p class="text-sm font-semibold text-gray-500">Nilai Akhir (Persen)</p>
                        <!-- Tampilkan nilai dengan format aman -->
                        <p class="text-5xl sm:text-6xl font-extrabold text-indigo-700 mt-2">
                            <?= number_format((float)$nilai_persen, 2); ?>%
                        </p>
                    </div>
                    
                    <div class="glass-sub-card p-5 rounded-xl shadow-md space-y-3 md:col-span-2">
                        <p class="text-lg font-bold text-indigo-700 border-b border-indigo-100 pb-2">Statistik Hasil Ujian</p>
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div>
                                <!-- Jawaban benar aman -->
                                <p class="text-2xl font-extrabold text-green-600"><?= (int)$jumlah_benar; ?></p>
                                <p class="text-xs sm:text-sm text-gray-500">Jawaban Benar</p>
                            </div>
                            
                            <div>
                                <!-- Jawaban salah aman -->
                                <p class="text-2xl font-extrabold text-red-600"><?= (int)$jumlah_salah; ?></p>
                                <p class="text-xs sm:text-sm text-gray-500">Jawaban Salah</p>
                            </div>
                            
                            <div>
                                <!-- Total soal aman -->
                                <p class="text-2xl font-extrabold text-gray-700"><?= (int)$total_soal; ?></p>
                                <p class="text-xs sm:text-sm text-gray-500">Total Soal</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="glass-sub-card p-4 rounded-xl text-center <?= htmlspecialchars($bg_color, ENT_QUOTES, 'UTF-8'); ?> border-2 mb-4" style="border-color: <?= htmlspecialchars($border_color, ENT_QUOTES, 'UTF-8'); ?>">
                    <!-- Label status -->
                    <p class="text-sm font-semibold text-gray-500">Status Kelulusan</p>
                    <!-- Teks status aman -->
                    <p class="text-3xl font-extrabold <?= ($nilai_persen >= 75) ? 'text-green-800' : 'text-red-800'; ?>">
                        <?= htmlspecialchars($nilai_status, ENT_QUOTES, 'UTF-8'); ?>
                    </p>
                </div>
                
                <a href="ujian.php" 
                class="
                        w-full block text-center
                        bg-indigo-600 text-white font-semibold py-3 px-4 rounded-lg 
                        shadow-lg hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 
                        transition duration-150 ease-in-out text-base
                    ">
                    Kembali ke Daftar Ujian
                </a>
            </div>
            
            <?php else: ?>
            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg card glass-card">
                <p class="text-sm">Hasil ujian tidak ditemukan atau Anda belum mengerjakannya.</p>
                <a href="ujian.php" class="text-xs text-yellow-800 underline mt-2 inline-block">Kembali ke Dashboard</a>
            </div>
            <?php endif; ?>

            <?php else: ?>
            <div class="card glass-card p-6 mb-6 rounded-xl shadow-lg border border-white/10 backdrop-blur-sm">
                <a href="dashboard.php" 
                    class="hidden md:flex items-center gap-2 text-sm font-semibold text-indigo-500 hover:text-indigo-600 transition mb-4 group">
                    <i class="fa-solid fa-arrow-left text-base group-hover:scale-105 transition-transform"></i> 
                    Kembali
                </a>
                <h2 class="text-3xl font-extrabold text-indigo-700 mb-2 border-b border-indigo-100 pb-2">
                    <i class="fa-solid fa-graduation-cap mr-2 text-indigo-500"></i> Dashboard Siswa
                </h2>
                <p class="text-gray-500 text-sm italic"> Daftar ujian yang tersedia untuk jurusan Anda: <span class="font-bold text-gray-700"><?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8'); ?></span>. </p>
            </div>
            
            <div class="card glass-card p-6 rounded-xl shadow-lg">
                <h3 class="text-xl font-bold mb-4 text-indigo-700 border-b border-indigo-200 pb-2">Daftar Ujian Tersedia</h3>
                
                <?php if (isset($error_ujian)): ?>
                    <p class="text-red-500 text-sm"><?= htmlspecialchars($error_ujian, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php elseif (empty($daftar_ujian_siswa)): ?>
                    <p class="text-gray-500 text-center py-8 bg-gray-50 rounded-lg">Tidak ada ujian tersedia saat ini.</p>
                <?php else: ?>
                    <div class="space-y-4">
                        <?php foreach ($daftar_ujian_siswa as $ujian): ?>
                        <?php
                            $is_done = !empty($ujian['hasil_id']); 
                            $nilai_display = $is_done ? number_format((float)$ujian['nilai'], 2) : '-';
                        ?>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between 
                                    glass-sub-card p-4 rounded-xl shadow-sm border border-gray-100 
                                    hover:bg-indigo-50/50 transition duration-150 space-y-3 sm:space-y-0">
                            
                            <div>
                                <p class="font-bold text-lg text-indigo-700"><?php echo htmlspecialchars($ujian['judul']); ?></p>
                                <p class="text-sm text-gray-500">Durasi: <?php echo $ujian['durasi_menit']; ?> Menit</p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                                
                                <div class="sm:text-right w-full sm:w-auto">
                                    <span class="text-sm font-semibold text-gray-600">
                                        Nilai: <span class="text-xl font-bold <?php echo ($is_done && (float)$ujian['nilai'] >= 75) ? 'text-green-600' : 'text-indigo-600'; ?>"><?php echo $nilai_display; ?></span>
                                    </span>
                                </div>
                                
                                <?php if ($is_done): ?>
                                    <a href="ujian.php?action=lihat_nilai&ujian_id=<?php echo $ujian['id']; ?>" 
                                    class="btn-success w-full sm:w-auto text-center py-2 px-4 rounded-lg font-semibold bg-green-500 text-white hover:bg-green-600 transition">
                                        <i class="fa-solid fa-square-poll-vertical mr-1"></i> Lihat Nilai
                                    </a>
                                <?php else: ?>
                                    <a href="ujian.php?action=mulai_ujian&ujian_id=<?php echo $ujian['id']; ?>" 
                                    class="btn-primary w-full sm:w-auto text-center py-2 px-4 rounded-lg font-semibold bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                        <i class="fa-solid fa-play-circle mr-1"></i> Mulai Ujian
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        <?php endif; ?>
    </main>
    <!-- BOTTOM NAVIGATION BAR (Hanya di Mobile) -->
    <?php require_once __DIR__ . '/../private/nav-bottom.php';?>
    <script>
        // Gunakan json_encode untuk mencegah XSS
        let retainedSoalData = <?= json_encode($initial_soal_json, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); ?>; 
        const initialSoalCount = <?= (int)$initial_soal_count; ?>;
    </script>

    <script src="../assets/js/ujian.js"></script>
</body>
</html>