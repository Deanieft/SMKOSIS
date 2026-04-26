# Elemen-Elemen yang Bisa Diklik (Clickable Elements)

## 1. NAVIGASI (Navigation Links)
| Elemen | Fungsi | ID/Class |
|--------|--------|----------|
| Beranda | Scroll ke section #beranda | Link href="#beranda" |
| Struktur | Scroll ke section #struktur | Link href="#struktur" |
| Berita | Scroll ke section #berita | Link href="#berita" |
| Pendaftaran | Scroll ke section #pendaftaran | Link href="#pendaftaran" |
| Feedback | Scroll ke section #feedback | Link href="#feedback" |
| Kontak | Scroll ke section #kontak | Link href="#kontak" |

## 2. TOMBOL UTAMA (Main Buttons)
| Tombol | Fungsi | ID | Handler |
|--------|--------|-----|---------|
| Login | Menampilkan/menyembunyikan akses pengguna | auth-button | handleAuthButton() |
| 🔔 Notifikasi | Buka panel notifikasi | notification-bell | toggleNotification() |
| ☰ Menu Mobile | Buka menu mobile | mobile-toggle | toggleMobileMenu() |
| Daftar Sekarang | Scroll ke formulir pendaftaran | - | href="#pendaftaran" |
| Lihat Struktur | Scroll ke struktur organisasi | - | href="#struktur" |

## 3. FORM DAN SUBMISSION
| Form | Input Fields | Tombol Submit | ID |
|------|------------|---------------|-----|
| **Pendaftaran** | Nama, Kelas, Email, No.Tel, Divisi, Motivasi | Kirim Pendaftaran | #register-form |
| **Feedback** | Nama (opsional), Rating (⭐), Kategori, Pesan | Kirim Feedback | #feedback-form |

### Form Input Details:
```
PENDAFTARAN:
- reg-name (required)
- reg-kelas (required)
- reg-email (required)
- reg-phone (required)
- reg-divisi (required, dropdown)
- reg-motivasi (required, textarea)
- reg-submit (button)

FEEDBACK:
- fb-name (optional)
- fb-rating (star rating 1-5)
- fb-category (required, dropdown)
- fb-message (required, textarea)
- fb-submit (button)
```

## 4. KARTU & DIVISI (Cards & Divisions)
| Elemen | Tipe | Interaksi | Class |
|--------|------|-----------|-------|
| Divisi Cards (8) | Card Hover | hover: translateY(-6px) | card-hover |
| News/Berita Cards (3) | Card Hover | hover: translateY(-6px) | card-hover |
| Struktur Cards (6) | Card Hover | hover: translateY(-6px) | card-hover |
| Contact Cards (3) | Card Hover | hover: translateY(-6px) | card-hover |

## 5. RATING STARS (Feedback Section)
| Elemen | Fungsi |
|--------|--------|
| ⭐ 1-5 Stars | Klik untuk rating (clickable via data-star attribute) |

## 6. SOCIAL MEDIA LINKS
| Link | Target | Icon |
|------|--------|------|
| Instagram | https://www.instagram.com/osis_smkn1tarumajaya/ | instagram |
| YouTube | # (link belum aktif) | youtube |
| Twitter | # (link belum aktif) | twitter |

## 7. SPECIAL ACCESS AREAS
| Area | Kondisi | ID |
|------|---------|-----|
| Ketua Divisi Access | Only for division leaders | #ketua-divisi-access |
| Finance Review Modal | Review financial reports | #finance-review-modal |

## 8. TOMBOL LAINNYA
| Tombol | Lokasi | Fungsi |
|--------|--------|--------|
| Buka Arsip | Arsip Foto section | Link ke arsip.html |
| Close Modal | Finance Modal | closeFinanceReview() |

---

## SUMMARY - JUMLAH CLICKABLE ELEMENTS
- ✅ Navigation Links: 6
- ✅ Main Buttons: 5
- ✅ Form Fields: 2 forms
- ✅ Cards with Hover: 17+
- ✅ Star Rating: 5 stars
- ✅ Social Media: 3 links
- ✅ Modal Controls: 2
- ✅ Archive Link: 1

**TOTAL: 40+ Clickable Elements**
