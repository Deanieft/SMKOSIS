# 📚 SETUP DATABASE & KONFIGURASI

## LANGKAH 1: SETUP DATABASE

### Option A: Menggunakan phpMyAdmin
1. Buka `http://localhost/phpmyadmin`
2. Login dengan username: `root` dan password kosong (default XAMPP)
3. Klik tab "SQL"
4. Copy-paste seluruh isi file `database_setup.sql`
5. Klik tombol "Go" atau "Execute"
6. Database `osis_smkn1` akan terbuat otomatis

### Option B: Menggunakan MySQL Command Line
```bash
mysql -u root -p < database_setup.sql
```
Jika password kosong:
```bash
mysql -u root < database_setup.sql
```

### Option C: Menggunakan File Explore
1. Letakkan file `database_setup.sql` di folder XAMPP
2. Buka terminal/cmd
3. Navigate ke folder MySQL: `cd C:\xampp\mysql\bin`
4. Jalankan: `mysql -u root < path\to\database_setup.sql`

---

## LANGKAH 2: KONFIGURASI KONEKSI PHP

### Edit file `config.php`
Pastikan konfigurasi sesuai dengan setup MySQL Anda:

```php
define('DB_HOST', 'localhost');    // Ubah jika MySQL di server lain
define('DB_USER', 'root');         // Ubah sesuai username MySQL
define('DB_PASS', '');             // Ubah sesuai password MySQL
define('DB_NAME', 'osis_smkn1');   // Nama database
```

---

## LANGKAH 3: UPDATE JAVASCRIPT DI index.html

### A. Handle Form Pendaftaran
Tambahkan event listener untuk form pendaftaran:

```javascript
// Di bagian <script> di akhir index.html
document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(document.getElementById('register-form'));
    
    try {
        const response = await fetch('handle_forms.php?action=register', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            showToast('✅ ' + result.message, 'success');
            document.getElementById('register-form').reset();
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    } catch (error) {
        showToast('Terjadi kesalahan: ' + error.message, 'error');
    }
});
```

### B. Handle Form Feedback
Tambahkan event listener untuk form feedback:

```javascript
document.getElementById('feedback-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const formData = new FormData(document.getElementById('feedback-form'));
    formData.append('rating', selectedRating);
    
    try {
        const response = await fetch('handle_forms.php?action=feedback', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.status === 'success') {
            showToast('✅ ' + result.message, 'success');
            document.getElementById('feedback-form').reset();
            selectedRating = 0;
        } else {
            showToast('❌ ' + result.message, 'error');
        }
    } catch (error) {
        showToast('Terjadi kesalahan: ' + error.message, 'error');
    }
});
```

---

## LANGKAH 4: PERBARUI HTML FORM

### Update Form Pendaftaran ID (sesuaikan dengan HTML yang ada)
```html
<form id="register-form" class="..." style="...">
    <div>
        <label for="reg-name">Nama Lengkap</label>
        <input id="reg-name" name="nama_lengkap" type="text" required>
    </div>
    
    <div>
        <label for="reg-kelas">Kelas</label>
        <input id="reg-kelas" name="kelas" type="text" required>
    </div>
    
    <div>
        <label for="reg-email">Email</label>
        <input id="reg-email" name="email" type="email" required>
    </div>
    
    <div>
        <label for="reg-phone">No. Telepon</label>
        <input id="reg-phone" name="no_telepon" type="tel" required>
    </div>
    
    <div>
        <label for="reg-divisi">Divisi yang Diminati</label>
        <select id="reg-divisi" name="divisi_diminati" required>
            <option value="">Pilih divisi...</option>
            <option>Humas</option>
            <option>Seni & Budaya</option>
            <option>Olahraga</option>
            <option>Pendidikan</option>
            <option>Sosial</option>
            <option>Lingkungan</option>
            <option>Teknologi</option>
            <option>Kerohanian</option>
        </select>
    </div>
    
    <div>
        <label for="reg-motivasi">Motivasi</label>
        <textarea id="reg-motivasi" name="motivasi" rows="3" required></textarea>
    </div>
    
    <button type="submit" id="reg-submit">Kirim Pendaftaran</button>
</form>
```

### Update Form Feedback
```html
<form id="feedback-form" class="..." style="...">
    <div>
        <label for="fb-name">Nama (opsional)</label>
        <input id="fb-name" name="nama_pengirim" type="text">
    </div>
    
    <div>
        <label>Rating</label>
        <div id="star-rating" class="flex gap-2">
            <span class="star-btn text-2xl text-slate-300" data-star="1">★</span>
            <span class="star-btn text-2xl text-slate-300" data-star="2">★</span>
            <span class="star-btn text-2xl text-slate-300" data-star="3">★</span>
            <span class="star-btn text-2xl text-slate-300" data-star="4">★</span>
            <span class="star-btn text-2xl text-slate-300" data-star="5">★</span>
        </div>
    </div>
    
    <div>
        <label for="fb-category">Kategori Feedback</label>
        <select id="fb-category" name="kategori" required>
            <option value="">Pilih kategori...</option>
            <option>Aspirasi</option>
            <option>Keluhan</option>
            <option>Saran</option>
            <option>Pertanyaan</option>
            <option>Apresiasi</option>
            <option>Laporan</option>
        </select>
    </div>
    
    <div>
        <label for="fb-message">Pesan Feedback</label>
        <textarea id="fb-message" name="pesan" rows="4" required></textarea>
    </div>
    
    <button type="submit" id="fb-submit">Kirim Feedback</button>
</form>
```

---

## LANGKAH 5: VERIFIKASI

### Cek Database Telah Dibuat
```sql
-- Jalankan di phpMyAdmin
SHOW DATABASES;
USE osis_smkn1;
SHOW TABLES;
```

### Cek Koneksi PHP
Buat file `test_db.php`:
```php
<?php
include 'config.php';

// Test koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Test query
$result = $conn->query("SELECT COUNT(*) as total FROM users");
if ($result) {
    $row = $result->fetch_assoc();
    echo "✅ Database terhubung! Total users: " . $row['total'];
} else {
    echo "❌ Query gagal: " . $conn->error;
}

$conn->close();
?>
```

Akses di browser: `http://localhost/PAK%20AJI/test_db.php`

---

## 📊 STRUKTUR TABEL DATABASE

| Tabel | Fungsi |
|-------|--------|
| `users` | Menyimpan data login pengguna |
| `pendaftaran` | Menyimpan data formulir pendaftaran |
| `feedback` | Menyimpan data feedback & rating |
| `divisi` | Struktur organisasi divisi |
| `keuangan` | Laporan keuangan/budget |
| `kegiatan` | Berita & kegiatan OSIS |
| `foto_arsip` | Penyimpanan foto arsip |
| `notifikasi` | Notifikasi untuk pengguna |

---

## 🔒 KEAMANAN

1. **Password Hashing**: Gunakan `password_hash()` bukan `MD5()`
2. **SQL Injection**: Gunakan `prepared statements`
3. **CORS**: Jika frontend terpisah, setup CORS di header
4. **Validation**: Validasi input baik di frontend maupun backend

---

## 📞 TROUBLESHOOTING

| Masalah | Solusi |
|--------|--------|
| "Koneksi database gagal" | Cek MySQL sudah berjalan, DB_HOST, DB_USER, DB_PASS |
| "Tabel tidak ditemukan" | Jalankan `database_setup.sql` untuk membuat tabel |
| "SQLSTATE error" | Cek syntax SQL dan nama kolom sudah benar |
| "File tidak ditemukan" | Pastikan file PHP ada di folder yang sama |

---

✅ **SELESAI! Database siap digunakan.**
