<?php
// app/delete.php
require_once 'db.php'; // Mengimpor file koneksi database

$id = $_GET['id'] ?? null;

if (!$id || !filter_var($id, FILTER_VALIDATE_INT)) {
    header("Location: index.php?status=gagal"); // ID tidak valid
    exit();
}

// Konfirmasi penghapusan biasanya dilakukan di client-side (JavaScript)
// Di sini kita langsung proses jika ID valid.
$stmt = $conn->prepare("DELETE FROM kebiasaan WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: index.php?status=sukses_hapus");
        } else {
            // Tidak ada baris yang terhapus, mungkin ID tidak ada
            header("Location: index.php?status=gagal");
        }
        exit();
    } else {
        // Error saat eksekusi
        header("Location: index.php?status=gagal");
        exit();
    }
    $stmt->close();
} else {
    // Error saat menyiapkan statement
    header("Location: index.php?status=gagal");
    exit();
}

// Seharusnya tidak sampai sini jika redirect berfungsi
// closeConnection($conn);
?>
