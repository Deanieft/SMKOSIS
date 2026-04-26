-- ===================================================
-- DATABASE OSIS SMKN 1 TARUMAJAYA
-- ===================================================
-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS osis_smkn1;
USE osis_smkn1;

-- ===================================================
-- 1. TABEL USERS (Admin, Ketua, Wakil, Anggota)
-- ===================================================
CREATE TABLE IF NOT EXISTS users (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    no_telepon VARCHAR(15),
    kelas VARCHAR(20),
    role ENUM('admin', 'ketua', 'wakil', 'sekretaris', 'bendahara', 'ketua_divisi', 'anggota') NOT NULL DEFAULT 'anggota',
    divisi VARCHAR(50),
    status ENUM('aktif', 'tidak_aktif', 'suspended') DEFAULT 'aktif',
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_status (status)
);

-- ===================================================
-- 2. TABEL PENDAFTARAN (Form Registrasi)
-- ===================================================
CREATE TABLE IF NOT EXISTS pendaftaran (
    id_pendaftaran INT PRIMARY KEY AUTO_INCREMENT,
    nama_lengkap VARCHAR(100) NOT NULL,
    kelas VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    no_telepon VARCHAR(15) NOT NULL,
    divisi_diminati VARCHAR(50) NOT NULL,
    motivasi LONGTEXT NOT NULL,
    status ENUM('pending', 'diterima', 'ditolak') DEFAULT 'pending',
    tanggal_pendaftaran TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_divisi (divisi_diminati),
    INDEX idx_tanggal (tanggal_pendaftaran)
);

-- ===================================================
-- 3. TABEL FEEDBACK
-- ===================================================
CREATE TABLE IF NOT EXISTS feedback (
    id_feedback INT PRIMARY KEY AUTO_INCREMENT,
    nama_pengirim VARCHAR(100),
    rating INT CHECK (rating >= 1 AND rating <= 5),
    kategori ENUM('aspirasi', 'keluhan', 'saran', 'pertanyaan', 'apresiasi', 'laporan') NOT NULL,
    pesan LONGTEXT NOT NULL,
    status ENUM('baru', 'dibaca', 'diproses', 'selesai') DEFAULT 'baru',
    tanggal_feedback TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_kategori (kategori),
    INDEX idx_tanggal (tanggal_feedback)
);

-- ===================================================
-- 4. TABEL DIVISI (Struktur Divisi)
-- ===================================================
CREATE TABLE IF NOT EXISTS divisi (
    id_divisi INT PRIMARY KEY AUTO_INCREMENT,
    nama_divisi VARCHAR(50) UNIQUE NOT NULL,
    deskripsi TEXT,
    ketua_divisi INT,
    wakil_ketua_divisi INT,
    jumlah_anggota INT DEFAULT 0,
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ketua_divisi) REFERENCES users(id_user),
    FOREIGN KEY (wakil_ketua_divisi) REFERENCES users(id_user)
);

-- ===================================================
-- 5. TABEL KEUANGAN (Finance/Budget)
-- ===================================================
CREATE TABLE IF NOT EXISTS keuangan (
    id_keuangan INT PRIMARY KEY AUTO_INCREMENT,
    tanggal_transaksi DATE NOT NULL,
    keterangan VARCHAR(255) NOT NULL,
    nominal DECIMAL(12, 2) NOT NULL,
    tipe ENUM('pemasukan', 'pengeluaran') NOT NULL,
    divisi_id INT,
    diajukan_oleh INT NOT NULL,
    bukti_file VARCHAR(255),
    status ENUM('pending', 'disetujui', 'ditolak') DEFAULT 'pending',
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (divisi_id) REFERENCES divisi(id_divisi),
    FOREIGN KEY (diajukan_oleh) REFERENCES users(id_user),
    INDEX idx_tipe (tipe),
    INDEX idx_status (status),
    INDEX idx_tanggal (tanggal_transaksi)
);

-- ===================================================
-- 6. TABEL KEGIATAN/BERITA (Events & News)
-- ===================================================
CREATE TABLE IF NOT EXISTS kegiatan (
    id_kegiatan INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    deskripsi LONGTEXT NOT NULL,
    tanggal_kegiatan DATE NOT NULL,
    lokasi VARCHAR(255),
    status ENUM('upcoming', 'ongoing', 'selesai') NOT NULL,
    pembuat_id INT NOT NULL,
    gambar VARCHAR(255),
    tanggal_dibuat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pembuat_id) REFERENCES users(id_user),
    INDEX idx_status (status),
    INDEX idx_tanggal (tanggal_kegiatan)
);

-- ===================================================
-- 7. TABEL FOTO ARSIP (Photo Archive)
-- ===================================================
CREATE TABLE IF NOT EXISTS foto_arsip (
    id_foto INT PRIMARY KEY AUTO_INCREMENT,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT,
    file_path VARCHAR(255) NOT NULL,
    kegiatan_id INT,
    tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    upload_oleh INT NOT NULL,
    FOREIGN KEY (kegiatan_id) REFERENCES kegiatan(id_kegiatan),
    FOREIGN KEY (upload_oleh) REFERENCES users(id_user)
);

-- ===================================================
-- 8. TABEL NOTIFIKASI
-- ===================================================
CREATE TABLE IF NOT EXISTS notifikasi (
    id_notifikasi INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    judul VARCHAR(255) NOT NULL,
    pesan TEXT NOT NULL,
    tipe ENUM('info', 'warning', 'error', 'success') DEFAULT 'info',
    sudah_dibaca BOOLEAN DEFAULT FALSE,
    tanggal_notifikasi TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id_user),
    INDEX idx_user (user_id),
    INDEX idx_dibaca (sudah_dibaca)
);

-- ===================================================
-- DATA SEED (Optional - untuk testing)
-- ===================================================

-- Insert Divisi
INSERT INTO divisi (nama_divisi, deskripsi) VALUES
('Humas', 'Divisi Hubungan Masyarakat'),
('Seni & Budaya', 'Divisi Seni dan Budaya'),
('Olahraga', 'Divisi Olahraga'),
('Pendidikan', 'Divisi Pendidikan'),
('Sosial', 'Divisi Sosial'),
('Lingkungan', 'Divisi Lingkungan'),
('Teknologi', 'Divisi Teknologi'),
('Kerohanian', 'Divisi Kerohanian');

-- Insert Admin User
INSERT INTO users (nama_lengkap, email, password, role, status) VALUES
('Admin OSIS', 'admin@osis.com', MD5('admin123'), 'admin', 'aktif'),
('Ahmad Rizky', 'ahmad@osis.com', MD5('password123'), 'ketua', 'aktif'),
('Siti Nurhaliza', 'siti@osis.com', MD5('password123'), 'wakil', 'aktif');

-- ===================================================
-- SELESAI - Database siap digunakan!
-- ===================================================
