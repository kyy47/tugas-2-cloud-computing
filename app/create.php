<?php
// app/create.php
require_once 'db.php'; // Mengimpor file koneksi database

$nama_kebiasaan = '';
$deskripsi = '';
$tanggal_mulai = '';
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
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
        // Siapkan statement SQL untuk insert data
        $stmt = $conn->prepare("INSERT INTO kebiasaan (nama_kebiasaan, deskripsi, tanggal_mulai) VALUES (?, ?, ?)");
        if ($stmt) {
            // Bind parameter ke statement
            // sss artinya tipe data string, string, string
            $stmt->bind_param("sss", $nama_kebiasaan, $deskripsi, $tanggal_mulai);

            // Eksekusi statement
            if ($stmt->execute()) {
                // Redirect ke halaman utama dengan pesan sukses
                header("Location: index.php?status=sukses_tambah");
                exit();
            } else {
                $errors[] = "Gagal menyimpan data ke database: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Gagal menyiapkan statement: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kebiasaan Baru - KINN</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); max-width: 600px; margin: auto; }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        label { display: block; margin-top: 15px; font-weight: bold; }
        input[type="text"], textarea, input[type="date"] {
            width: calc(100% - 22px); /* Adjust for padding and border */
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
            background-color: #4CAF50;
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
        <h1>Tambah Kebiasaan Baru</h1>

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

        <form action="create.php" method="post">
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
            <button type="submit" class="btn">Simpan Kebiasaan</button>
            <a href="index.php" class="btn btn-back">Kembali</a>
        </form>
    </div>
</body>
</html>
