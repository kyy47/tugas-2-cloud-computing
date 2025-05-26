<?php
// app/index.php
require_once 'db.php'; // Mengimpor file koneksi database

// Mengambil semua data kebiasaan dari database
$sql = "SELECT id, nama_kebiasaan, deskripsi, DATE_FORMAT(tanggal_mulai, '%d %M %Y') AS tanggal_mulai_formatted, DATE_FORMAT(created_at, '%d %M %Y %H:%i') AS created_at_formatted FROM kebiasaan ORDER BY created_at DESC";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelacak Kebiasaan - KINN</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        tr:hover { background-color: #ddd; }
        a { color: #4CAF50; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px 0;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            text-align: center;
        }
        .btn-edit { background-color: #ffc107; }
        .btn-delete { background-color: #f44336; }
        .btn-add { margin-bottom: 20px; }
        .message { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Daftar Kebiasaan Saya - M. RIZKI</h1>
        <a href="create.php" class="btn btn-add">Tambah Kebiasaan Baru</a>

        <?php
        // Menampilkan pesan sukses atau error jika ada dari operasi lain
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'sukses_tambah') {
                echo '<div class="message success">Kebiasaan baru berhasil ditambahkan!</div>';
            } elseif ($_GET['status'] == 'sukses_edit') {
                echo '<div class="message success">Kebiasaan berhasil diperbarui!</div>';
            } elseif ($_GET['status'] == 'sukses_hapus') {
                echo '<div class="message success">Kebiasaan berhasil dihapus!</div>';
            } elseif ($_GET['status'] == 'gagal') {
                echo '<div class="message error">Terjadi kesalahan. Silakan coba lagi.</div>';
            }
        }
        ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kebiasaan</th>
                        <th>Deskripsi</th>
                        <th>Tanggal Mulai</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_kebiasaan']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_mulai_formatted']); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at_formatted']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-edit">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus kebiasaan ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Belum ada kebiasaan yang dilacak. Silakan tambahkan kebiasaan baru.</p>
        <?php endif; ?>
    </div>
    <?php
    // Menutup koneksi (opsional)
    // closeConnection($conn);
    ?>
</body>
</html>
