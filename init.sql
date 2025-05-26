-- init.sql

-- Membuat Database (jika belum ada)
-- Dalam konteks MariaDB container, database biasanya dibuat melalui environment variable
-- atau akan dibuat jika belum ada saat koneksi pertama.
-- Namun, kita bisa memastikan database yang akan digunakan.
-- Untuk tugas ini, nama database akan diset di compose.yml, misal: habit_tracker_db

-- Tabel: kebiasaan
-- Tabel ini akan menyimpan daftar kebiasaan yang ingin dilacak.
CREATE TABLE IF NOT EXISTS kebiasaan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kebiasaan VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    tanggal_mulai DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Memasukkan minimal 2 (dua) record sebagai data awal (DML)
INSERT INTO kebiasaan (nama_kebiasaan, deskripsi, tanggal_mulai) VALUES
('Minum 2L Air Setiap Hari', 'Memastikan asupan cairan tubuh tercukupi untuk kesehatan.', '2024-05-01'),
('Baca Buku 30 Menit Sebelum Tidur', 'Meningkatkan pengetahuan dan membantu rileks sebelum tidur.', '2024-05-10');

-- (Opsional) Tabel: log_kebiasaan
-- Tabel ini bisa digunakan untuk mencatat progres harian dari setiap kebiasaan.
-- Untuk CRUD utama, tabel ini tidak wajib, tapi bisa jadi pengembangan menarik.
-- CREATE TABLE IF NOT EXISTS log_kebiasaan (
--     id_log INT AUTO_INCREMENT PRIMARY KEY,
--     id_kebiasaan INT NOT NULL,
--     tanggal_log DATE NOT NULL,
--     status_selesai BOOLEAN DEFAULT FALSE, -- TRUE jika selesai, FALSE jika belum/tidak
--     catatan_log TEXT,
--     created_at_log TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
--     FOREIGN KEY (id_kebiasaan) REFERENCES kebiasaan(id) ON DELETE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contoh DML untuk log_kebiasaan (jika tabel di atas diaktifkan)
-- INSERT INTO log_kebiasaan (id_kebiasaan, tanggal_log, status_selesai, catatan_log) VALUES
-- (1, '2024-05-26', TRUE, 'Berhasil minum 2.1L hari ini'),
-- (2, '2024-05-26', FALSE, 'Hanya sempat baca 10 menit');

