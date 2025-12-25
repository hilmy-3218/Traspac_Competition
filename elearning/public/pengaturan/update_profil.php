<?php
session_start();
include '../../config/db.php';

// 1. Proteksi Halaman: Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // 2. Ambil data lama dari database untuk referensi foto lama
    $stmt = $pdo->prepare("SELECT foto_profil FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Pengguna tidak ditemukan.");
    }

    $fotoLama = $user['foto_profil'] ?? null;

    // 3. Ambil dan Sanitasi data dari form
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']); // Biasanya email tidak diubah, tapi tetap diproses jika diperlukan

    // Default foto adalah foto lama jika tidak ada upload baru
    $fotoBaru = $fotoLama;

    // 4. Logika Pengunggahan Foto Profil
    if (!empty($_FILES['foto_profil']['name'])) {

        $fileName = $_FILES['foto_profil']['name'];
        $tmpName  = $_FILES['foto_profil']['tmp_name'];
        $fileSize = $_FILES['foto_profil']['size'];
        $error    = $_FILES['foto_profil']['error'];

        // Cek jika ada error pada sistem upload PHP
        if ($error !== 0) {
            header("Location: profil.php?error=system");
            exit;
        }

        // Ekstensi yang diperbolehkan
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validasi: Cek Ekstensi
        if (!in_array($ext, $allowed)) {
            header("Location: profil.php?error=format");
            exit;
        }

        // Validasi: Cek Ukuran File (2.000.000 Bytes = 2MB)
        if ($fileSize > 2000000) {
            header("Location: profil.php?error=size");
            exit;
        }

        // Validasi: Cek Mime Type (Cegah file palsu/berbahaya)
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $checkMime = $finfo->file($tmpName);
        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif'
        ];

        if (!in_array($checkMime, $allowedMime)) {
            header("Location: profil.php?error=invalid");
            exit;
        }

        // 5. Proses Pemindahan File
        // Generate nama unik untuk menghindari konflik nama file yang sama
        $namaFileBaru = "profil_" . $user_id . "_" . time() . "." . $ext;
        $folderTujuan = "../../uploads/profiles/";
        $targetPath   = $folderTujuan . $namaFileBaru;

        // Pastikan folder tujuan ada, jika tidak buat foldernya
        if (!is_dir($folderTujuan)) {
            mkdir($folderTujuan, 0755, true);
        }

        if (move_uploaded_file($tmpName, $targetPath)) {
            // Hapus foto lama dari server jika ada dan bukan file default
            if (!empty($fotoLama) && $fotoLama !== "uploads/profiles/default.png") {
                $pathFotoLama = "../../" . $fotoLama;
                if (file_exists($pathFotoLama)) {
                    unlink($pathFotoLama);
                }
            }
            // Simpan path yang akan masuk ke DB (relatif dari root web/index)
            $fotoBaru = "uploads/profiles/" . $namaFileBaru;
        } else {
            header("Location: profil.php?error=upload");
            exit;
        }
    }

    // 6. Update Database
    $update = $pdo->prepare("
        UPDATE users 
        SET nama = :nama, email = :email, foto_profil = :foto 
        WHERE id = :id
    ");
    
    $update->execute([
        'nama'  => $nama,
        'email' => $email,
        'foto'  => $fotoBaru,
        'id'    => $user_id
    ]);

    // Berhasil, kembali ke profil
    header("Location: profil.php?success=1");
    exit;

} catch (PDOException $e) {
    // Log error secara internal dan tampilkan pesan umum
    error_log("Database Error: " . $e->getMessage());
    header("Location: profil.php?error=db");
    exit;
}
?>
