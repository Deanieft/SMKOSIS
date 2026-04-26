# 📊 DATABASE SCHEMA & RELATIONSHIPS

## ENTITY RELATIONSHIP DIAGRAM (ERD)

```
┌─────────────────────────────────────────────────────────────┐
│                         DATABASE OSIS                         │
└─────────────────────────────────────────────────────────────┘

                            ┌──────────────┐
                            │    USERS     │
                            ├──────────────┤
                            │ id_user (PK) │
                            │ nama_lengkap │
                            │ email        │
                            │ password     │
                            │ role         │
                            │ divisi       │
                            └──────────────┘
                                   │
                    ┌──────────────┴──────────────┐
                    │                             │
           ┌────────▼──────┐            ┌────────▼──────┐
           │     DIVISI     │            │    KEGIATAN    │
           ├────────────────┤            ├────────────────┤
           │ id_divisi (PK) │            │ id_kegiatan(PK)│
           │ nama_divisi    │            │ judul          │
           │ ketua_divisi(FK)           │ tanggal_kegiatan
           │ wakil_ketua(FK)            │ pembuat_id(FK) 
           └────────────────┘            └────────────────┘
                    │                             │
                    │                    ┌────────▼────────┐
                    │                    │  FOTO_ARSIP    │
                    │                    ├────────────────┤
                    │                    │ id_foto (PK)   │
                    │                    │ kegiatan_id(FK)│
                    │                    │ upload_oleh(FK)│
                    │                    └────────────────┘
                    │
        ┌───────────┴──────────┐
        │                      │
    ┌───▼──────────┐    ┌──────▼──────────┐
    │  KEUANGAN    │    │  PENDAFTARAN    │
    ├──────────────┤    ├─────────────────┤
    │id_keuangan   │    │id_pendaftaran   │
    │divisi_id(FK) │    │nama_lengkap     │
    │diajukan_oleh │    │email            │
    │(FK)          │    │divisi_diminati  │
    └──────────────┘    │status           │
                        └─────────────────┘
                        
                   ┌──────────────────┐
                   │    FEEDBACK      │
                   ├──────────────────┤
                   │ id_feedback (PK) │
                   │ nama_pengirim    │
                   │ rating (1-5)     │
                   │ kategori         │
                   │ pesan            │
                   │ status           │
                   └──────────────────┘
                        
                   ┌──────────────────┐
                   │  NOTIFIKASI      │
                   ├──────────────────┤
                   │id_notifikasi (PK)│
                   │user_id (FK)      │
                   │judul             │
                   │pesan             │
                   │sudah_dibaca      │
                   └──────────────────┘
```

---

## TABEL DETAIL

### 1️⃣ USERS
```
Menyimpan data login semua pengguna (admin, ketua, anggota, dll)

Kolom:
├─ id_user (INT, PK, AUTO_INCREMENT)
├─ nama_lengkap (VARCHAR 100)
├─ email (VARCHAR 100, UNIQUE)
├─ password (VARCHAR 255) - gunakan password_hash()
├─ no_telepon (VARCHAR 15)
├─ kelas (VARCHAR 20)
├─ role (ENUM: admin, ketua, wakil, sekretaris, bendahara, ketua_divisi, anggota)
├─ divisi (VARCHAR 50)
├─ status (ENUM: aktif, tidak_aktif, suspended)
├─ tanggal_daftar (TIMESTAMP)
└─ tanggal_update (TIMESTAMP)

Index:
├─ email (UNIQUE)
├─ role
└─ status
```

### 2️⃣ DIVISI
```
Menyimpan struktur organisasi divisi OSIS

Kolom:
├─ id_divisi (INT, PK, AUTO_INCREMENT)
├─ nama_divisi (VARCHAR 50, UNIQUE)
├─ deskripsi (TEXT)
├─ ketua_divisi (INT, FK → users.id_user)
├─ wakil_ketua_divisi (INT, FK → users.id_user)
├─ jumlah_anggota (INT)
└─ tanggal_dibuat (TIMESTAMP)

Data Default: 8 divisi
├─ Humas
├─ Seni & Budaya
├─ Olahraga
├─ Pendidikan
├─ Sosial
├─ Lingkungan
├─ Teknologi
└─ Kerohanian
```

### 3️⃣ PENDAFTARAN
```
Menyimpan data formulir registrasi anggota baru

Kolom:
├─ id_pendaftaran (INT, PK, AUTO_INCREMENT)
├─ nama_lengkap (VARCHAR 100)
├─ kelas (VARCHAR 20)
├─ email (VARCHAR 100)
├─ no_telepon (VARCHAR 15)
├─ divisi_diminati (VARCHAR 50)
├─ motivasi (LONGTEXT)
├─ status (ENUM: pending, diterima, ditolak)
├─ tanggal_pendaftaran (TIMESTAMP)
└─ tanggal_update (TIMESTAMP)

Index:
├─ status
├─ divisi_diminati
└─ tanggal_pendaftaran
```

### 4️⃣ FEEDBACK
```
Menyimpan data feedback & rating dari pengguna

Kolom:
├─ id_feedback (INT, PK, AUTO_INCREMENT)
├─ nama_pengirim (VARCHAR 100) - boleh kosong (anonim)
├─ rating (INT) - constraint: 1-5
├─ kategori (ENUM: aspirasi, keluhan, saran, pertanyaan, apresiasi, laporan)
├─ pesan (LONGTEXT)
├─ status (ENUM: baru, dibaca, diproses, selesai)
├─ tanggal_feedback (TIMESTAMP)
└─ tanggal_update (TIMESTAMP)

Index:
├─ status
├─ kategori
└─ tanggal_feedback
```

### 5️⃣ KEGIATAN
```
Menyimpan data kegiatan/berita OSIS

Kolom:
├─ id_kegiatan (INT, PK, AUTO_INCREMENT)
├─ judul (VARCHAR 255)
├─ deskripsi (LONGTEXT)
├─ tanggal_kegiatan (DATE)
├─ lokasi (VARCHAR 255)
├─ status (ENUM: upcoming, ongoing, selesai)
├─ pembuat_id (INT, FK → users.id_user)
├─ gambar (VARCHAR 255)
├─ tanggal_dibuat (TIMESTAMP)
└─ tanggal_update (TIMESTAMP)

Index:
├─ status
└─ tanggal_kegiatan
```

### 6️⃣ FOTO_ARSIP
```
Menyimpan data foto arsip kegiatan

Kolom:
├─ id_foto (INT, PK, AUTO_INCREMENT)
├─ judul (VARCHAR 255)
├─ deskripsi (TEXT)
├─ file_path (VARCHAR 255)
├─ kegiatan_id (INT, FK → kegiatan.id_kegiatan)
├─ tanggal_upload (TIMESTAMP)
└─ upload_oleh (INT, FK → users.id_user)

Folder: Aset Gambar/ atau uploads/
```

### 7️⃣ KEUANGAN
```
Menyimpan data laporan keuangan OSIS

Kolom:
├─ id_keuangan (INT, PK, AUTO_INCREMENT)
├─ tanggal_transaksi (DATE)
├─ keterangan (VARCHAR 255)
├─ nominal (DECIMAL 12,2)
├─ tipe (ENUM: pemasukan, pengeluaran)
├─ divisi_id (INT, FK → divisi.id_divisi)
├─ diajukan_oleh (INT, FK → users.id_user)
├─ bukti_file (VARCHAR 255)
├─ status (ENUM: pending, disetujui, ditolak)
├─ tanggal_dibuat (TIMESTAMP)
└─ tanggal_update (TIMESTAMP)

Index:
├─ tipe
├─ status
└─ tanggal_transaksi
```

### 8️⃣ NOTIFIKASI
```
Menyimpan notifikasi untuk pengguna

Kolom:
├─ id_notifikasi (INT, PK, AUTO_INCREMENT)
├─ user_id (INT, FK → users.id_user)
├─ judul (VARCHAR 255)
├─ pesan (TEXT)
├─ tipe (ENUM: info, warning, error, success)
├─ sudah_dibaca (BOOLEAN)
└─ tanggal_notifikasi (TIMESTAMP)

Index:
├─ user_id
└─ sudah_dibaca
```

---

## RELASI ANTAR TABEL

```
USERS (1) ─────────── (Many) KEGIATAN
  │ (pembuat_id)

USERS (1) ─────────── (Many) FOTO_ARSIP
  │ (upload_oleh)

USERS (1) ─────────── (Many) KEUANGAN
  │ (diajukan_oleh)

USERS (1) ─────────── (Many) NOTIFIKASI
  │ (user_id)

DIVISI (1) ─────────── (Many) KEUANGAN
  │ (divisi_id)

KEGIATAN (1) ─────────── (Many) FOTO_ARSIP
  │ (kegiatan_id)
```

---

## QUERY CONTOH

### Get Pending Registrations
```sql
SELECT * FROM pendaftaran 
WHERE status = 'pending' 
ORDER BY tanggal_pendaftaran DESC;
```

### Get Feedback Statistics
```sql
SELECT 
  kategori,
  COUNT(*) as total,
  ROUND(AVG(rating), 2) as rata_rating
FROM feedback 
GROUP BY kategori;
```

### Get Total Finance by Division
```sql
SELECT 
  d.nama_divisi,
  SUM(CASE WHEN k.tipe = 'pemasukan' THEN k.nominal ELSE 0 END) as total_masuk,
  SUM(CASE WHEN k.tipe = 'pengeluaran' THEN k.nominal ELSE 0 END) as total_keluar
FROM divisi d
LEFT JOIN keuangan k ON d.id_divisi = k.divisi_id
WHERE k.status = 'disetujui'
GROUP BY d.id_divisi;
```

### Get Division Members
```sql
SELECT 
  d.nama_divisi,
  COUNT(u.id_user) as jumlah_anggota
FROM divisi d
LEFT JOIN users u ON d.id_divisi = (SELECT id_divisi FROM divisi WHERE id_divisi = u.id_user)
GROUP BY d.id_divisi;
```

---

## 🔑 PRIMARY KEY vs FOREIGN KEY

- **Primary Key (PK)**: Mengidentifikasi unik setiap record dalam tabel
- **Foreign Key (FK)**: Menghubungkan tabel dengan tabel lain

Contoh:
```sql
-- users.id_user adalah PK
-- kegiatan.pembuat_id adalah FK yang merujuk ke users.id_user
```

---

✅ **Diagram ini membantu memahami struktur database dan hubungan antar tabel**
