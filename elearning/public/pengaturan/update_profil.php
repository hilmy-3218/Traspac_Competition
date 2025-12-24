<?php
session_start();
include '../../config/db.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    // Ambil foto lama
    $stmt = $pdo->prepare("SELECT foto_profil FROM users WHERE id = :id LIMIT 1");
    $stmt->execute(['id' => $user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $fotoLama = $user['foto_profil'] ?? null;

    // Data dari form
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);

    // Default foto lama
    $fotoBaru = $fotoLama;

    // Jika user upload foto baru
    if (!empty($_FILES['foto_profil']['name'])) {

        $fileName = $_FILES['foto_profil']['name'];
        $tmpName = $_FILES['foto_profil']['tmp_name'];
        $fileSize = $_FILES['foto_profil']['size'];

        // Ekstensi yang diperbolehkan
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'heic', 'heif'];

        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Cek tipe file
        if (!in_array($ext, $allowed)) {
            die("Format foto tidak didukung. Gunakan JPG, PNG, WEBP, GIF, HEIC/HEIF.");
        }

        // Cegah file palsu (cek mime)
        $checkMime = mime_content_type($tmpName);
        $allowedMime = [
            'image/jpeg',
            'image/png',
            'image/webp',
            'image/gif',
            'image/heic',
            'image/heif',
        ];

        if (!in_array($checkMime, $allowedMime)) {
            die("File yang diupload bukan gambar valid!");
        }

        // Cek ukuran file
        if ($fileSize > 2000000) {
            die("Ukuran foto maksimal 2MB!");
        }

        // Generate nama unik
        $namaFileBaru = "profil_" . $user_id . "_" . time() . "." . $ext;
        $targetPath = "../../uploads/profiles/" . $namaFileBaru;

        move_uploaded_file($tmpName, $targetPath);

        // Hapus foto lama jika bukan default
        if (!empty($fotoLama) && $fotoLama !== "uploads/profiles/default.png") {
            $oldFoto = "../../" . $fotoLama;
            if (file_exists($oldFoto)) unlink($oldFoto);
        }

        // Simpan nama file baru
        $fotoBaru = "uploads/profiles/" . $namaFileBaru;
    }


    // Update Database
    $update = $pdo->prepare("
        UPDATE users
        SET nama = :nama, email = :email, foto_profil = :foto
        WHERE id = :id
    ");
    $update->execute([
        'nama' => $nama,
        'email' => $email,
        'foto' => $fotoBaru,
        'id' => $user_id
    ]);

    header("Location: profil.php?success=1");
    exit;

} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>
