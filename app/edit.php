<?php
// app/edit.php
require_once 'db.php'; // Mengimpor file koneksi database

$id = $_GET['id'] ?? null;
$nama_kebiasaan = '';
$deskripsi = '';
$tanggal_mulai = '';
$errors = [];
$kebiasaan_ditemukan = false;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: index.php?status=gagal"); // ID tidak valid
    exit();
}

// Jika metode request adalah POST, proses update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_kebiasaan = trim($_POST['nama_kebiasaan']);
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_mulai = $_POST['tanggal_mulai'];

    // Validasi sederhana
    if (empty($nama_kebiasaan)) {
        $errors[] = "Nama kebiasaan tidak boleh kosong.";
    }
    if (empty($tanggal_mulai)) {
        $errors[] = "Tanggal mulai tidak boleh kosong.";
    } elseif (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $tanggal_mulai)) {
        $errors[] = "Format tanggal mulai tidak valid (YYYY-MM-DD).";
    }

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE kebiasaan SET nama_kebiasaan = ?, deskripsi = ?, tanggal_mulai = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("sssi", $nama_kebiasaan, $deskripsi, $tanggal_mulai, $id);
            if ($stmt->execute()) {
                header("Location: index.php?status=sukses_edit");
                exit();
            } else {
                $errors[] = "Gagal memperbarui data: " . $stmt->error;
            }
            $stmt->close();
        } else {
             $errors[] = "Gagal menyiapkan statement: " . $conn->error;
        }
    }
} else {
    // Jika metode request adalah GET, ambil data untuk ditampilkan di form
    $stmt = $conn->prepare("SELECT nama_kebiasaan, deskripsi, tanggal_mulai FROM kebiasaan WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $nama_kebiasaan = $row['nama_kebiasaan'];
            $deskripsi = $row['deskripsi'];
            $tanggal_mulai = $row['tanggal_mulai'];
            $kebiasaan_ditemukan = true;
        } else {
            // $errors[] = "Kebiasaan tidak ditemukan.";
            // Sebaiknya redirect jika tidak ditemukan
             header("Location: index.php?status=gagal");
             exit();
        }
        $stmt->close();
    } else {
        // $errors[] = "Gagal mengambil data: " . $conn->error;
        header("Location: index.php?status=gagal");
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kebiasaan - KINN</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input[type="text"], textarea, input[type="date"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea { resize: vertical; min-height: 80px; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            background-color: #ffc107; /* Warna edit */
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        .btn-back { background-color: #aaa; margin-left: 10px; }
        .errors { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .errors ul { margin: 0; padding-left: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Kebiasaan</h1>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <strong>Terjadi kesalahan:</strong>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($kebiasaan_ditemukan || $_SERVER["REQUEST_METHOD"] == "POST"): // Tampilkan form jika data ditemukan atau jika ada error POST ?>
            <form action="edit.php?id=<?php echo $id; ?>" method="post">
                <div>
                    <label for="nama_kebiasaan">Nama Kebiasaan:</label>
                    <input type="text" id="nama_kebiasaan" name="nama_kebiasaan" value="<?php echo htmlspecialchars($nama_kebiasaan); ?>" required>
                </div>
                <div>
                    <label for="deskripsi">Deskripsi (Opsional):</label>
                    <textarea id="deskripsi" name="deskripsi"><?php echo htmlspecialchars($deskripsi); ?></textarea>
                </div>
                <div>
                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo htmlspecialchars($tanggal_mulai); ?>" required>
                </div>
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-back">Kembali</a>
            </form>
        <?php elseif (!$kebiasaan_ditemukan && $_SERVER["REQUEST_METHOD"] == "GET"): ?>
             <p>Kebiasaan tidak ditemukan atau ID tidak valid.</p>
             <a href="index.php" class="btn btn-back">Kembali ke Daftar</a>
        <?php endif; ?>
    </div>
</body>
</html>
