<?php
// app/db.php

// Konfigurasi database akan diambil dari environment variables
// yang akan diset di file compose.yml untuk service php-apache.
$host = getenv('DB_HOST') ?: 'mariadb-kinn'; // Nama service MariaDB
$dbname = getenv('DB_NAME') ?: 'habit_tracker_db';
$username = getenv('DB_USER') ?: 'user_kinn';
$password = getenv('DB_PASSWORD') ?: 'pass_kinn';
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
