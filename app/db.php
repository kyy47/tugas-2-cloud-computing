<?php
// app/db.php

// Konfigurasi database akan diambil dari environment variables
// yang akan diset di file compose.yml untuk service php-apache.
$host = getenv('DB_HOST') ?: 'sql200.infinityfree.com-kinn'; // Nama service MariaDB
$dbname = getenv('DB_NAME') ?: 'if0_39081664_habit_tracker_db';
$username = getenv('DB_USER') ?: 'if0_39081664';
$password = getenv('DB_PASSWORD') ?: 'sNOXI1tEf8hbo9O';
$port = getenv('DB_PORT') ?: '3306'; // Port default MariaDB

// Membuat koneksi menggunakan mysqli
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Cek koneksi
if ($conn->connect_error) {
    // Sebaiknya jangan menampilkan error detail di produksi
    // tapi untuk development ini cukup membantu.
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Set charset ke utf8mb4 untuk mendukung berbagai karakter
if (!$conn->set_charset("utf8mb4")) {
    // printf("Error loading character set utf8mb4: %s\n", $conn->error);
}

// Fungsi untuk menutup koneksi (opsional, PHP biasanya menutup otomatis di akhir script)
function closeConnection(mysqli $connection) {
    $connection->close();
}
?>
