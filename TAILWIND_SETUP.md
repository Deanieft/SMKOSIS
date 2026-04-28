# 🚀 Tailwind CSS Setup - OSIS SMK Negeri 1

Setup hybrid Tailwind CSS (CDN untuk development + CLI untuk production) tanpa konflik.

## 📋 Status Setup

### ✅ CDN (Development)
- **Status:** ✅ Aktif
- **File:** `index.html`, `arsip.html`
- **Keuntungan:** Cepat, tanpa build process
- **Kekurangan:** Tidak optimal untuk production

### ✅ CLI (Production Ready)
- **Status:** ✅ Siap pakai
- **Files:** `package.json`, `tailwind.config.js`, `src/input.css`
- **Keuntungan:** Optimal, minified, customizable
- **Kekurangan:** Perlu build process

## 🛠️ Cara Penggunaan

### Development (CDN)
Website sudah menggunakan CDN secara default. Tidak perlu setup tambahan.

### Production (CLI)
1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Build CSS:**
   ```bash
   # Development (dengan watch)
   npm run build-css

   # Production (minified)
   npm run build-css-prod
   ```

3. **Ganti CDN dengan file build:**
   ```html
   <!-- Hapus baris ini dari HTML -->
   <script src="https://cdn.tailwindcss.com/3.4.17"></script>

   <!-- Tambahkan baris ini -->
   <link href="./dist/output.css" rel="stylesheet">
   ```

## 📁 File Structure

```
PAK AJI/
├── src/
│   └── input.css          # Input file dengan direktif Tailwind
├── dist/
│   └── output.css         # Output file hasil build (generated)
├── tailwind.config.js     # Konfigurasi Tailwind custom
├── package.json          # Dependencies dan scripts
└── *.html               # File HTML (menggunakan CDN)
```

## 🎯 Keuntungan Hybrid Setup

- **Development:** ⚡ Cepat tanpa build
- **Production:** 🚀 Optimal dengan build
- **Flexibility:** 🔄 Bisa switch kapan saja
- **No Conflict:** ✅ Tidak ada konflik antara CDN dan CLI

## 📝 Custom Configuration

File `tailwind.config.js` sudah dikonfigurasi dengan:
- Custom font family (Plus Jakarta Sans)
- Custom color palette
- Custom animations
- Content paths untuk semua HTML files

## 🔧 Scripts Available

```json
{
  "build-css": "tailwindcss -i ./src/input.css -o ./dist/output.css --watch",
  "build-css-prod": "tailwindcss -i ./src/input.css -o ./dist/output.css --minify"
}
```

## ⚠️ Catatan Penting

- **CDN vs CLI:** Gunakan CDN untuk development, CLI untuk production
- **File Size:** CLI build akan lebih kecil dan optimal
- **Customization:** Edit `tailwind.config.js` untuk tema custom
- **Dependencies:** Pastikan Node.js terinstall untuk CLI

## 🎉 Ready to Use!

Setup ini memungkinkan Anda menggunakan Tailwind CSS secara optimal:
- Development dengan CDN (cepat)
- Production dengan CLI build (optimal)
- Tanpa konflik atau masalah performa