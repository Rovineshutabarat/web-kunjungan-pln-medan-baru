-- File: database_schema.sql
CREATE DATABASE IF NOT EXISTS pln_kunjungan;
USE pln_kunjungan;

-- Table petugas
CREATE TABLE petugas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    role ENUM('admin', 'petugas') DEFAULT 'petugas',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table kunjungan
CREATE TABLE kunjungan (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_pelanggan VARCHAR(100) NOT NULL,
    nik VARCHAR(16) NOT NULL,
    no_hp VARCHAR(15) NOT NULL,
    id_pelanggan VARCHAR(20),
    jam_masuk TIME NOT NULL,
    jam_keluar TIME,
    tujuan VARCHAR(100) NOT NULL,
    keterangan TEXT,
    petugas_id INT NOT NULL,
    status ENUM('Menunggu', 'Proses', 'Selesai') DEFAULT 'Menunggu',
    tanggal DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (petugas_id) REFERENCES petugas(id)
);

-- Insert default admin user (password: admin123)
INSERT INTO petugas (username, password, nama, role) VALUES
('admin', '$2y$10$YourHashedPasswordHere', 'Administrator', 'admin'),
('petugas1', '$2y$10$YourHashedPasswordHere', 'Petugas Satu', 'petugas');