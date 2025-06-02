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
