<?php
/**
 * Handle Form Submissions
 * - Pendaftaran (Registration)
 * - Feedback
 */

header('Content-Type: application/json');
include 'config.php';

$action = $_GET['action'] ?? '';

// ========== HANDLE PENDAFTARAN ==========
if ($action === 'register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = sanitize_input($_POST['nama_lengkap'] ?? '');
    $kelas = sanitize_input($_POST['kelas'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $no_telepon = sanitize_input($_POST['no_telepon'] ?? '');
    $divisi_diminati = sanitize_input($_POST['divisi_diminati'] ?? '');
    $motivasi = sanitize_input($_POST['motivasi'] ?? '');

    // Validasi input
    if (empty($nama_lengkap) || empty($kelas) || empty($email) || empty($no_telepon) || 
        empty($divisi_diminati) || empty($motivasi)) {
        show_error('Semua field harus diisi!');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        show_error('Format email tidak valid!');
    }

    // Cek email sudah terdaftar atau belum
    $check_email = $conn->query("SELECT id_pendaftaran FROM pendaftaran WHERE email = '".escape_string($email)."'");
    if ($check_email->num_rows > 0) {
        show_error('Email sudah terdaftar sebelumnya!');
    }

    // Insert ke database
    $sql = "INSERT INTO pendaftaran (nama_lengkap, kelas, email, no_telepon, divisi_diminati, motivasi) 
            VALUES (
                '".escape_string($nama_lengkap)."',
                '".escape_string($kelas)."',
                '".escape_string($email)."',
                '".escape_string($no_telepon)."',
                '".escape_string($divisi_diminati)."',
                '".escape_string($motivasi)."'
            )";

    if ($conn->query($sql) === TRUE) {
        show_success('Pendaftaran berhasil! Terima kasih telah mendaftar OSIS.', [
            'id_pendaftaran' => $conn->insert_id,
            'email' => $email
        ]);
    } else {
        show_error('Gagal menyimpan data: ' . $conn->error);
    }
}

// ========== HANDLE FEEDBACK ==========
else if ($action === 'feedback' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pengirim = sanitize_input($_POST['nama_pengirim'] ?? 'Anonim');
    $rating = intval($_POST['rating'] ?? 0);
    $kategori = sanitize_input($_POST['kategori'] ?? '');
    $pesan = sanitize_input($_POST['pesan'] ?? '');

    // Validasi input
    if (empty($kategori) || empty($pesan)) {
        show_error('Kategori dan pesan feedback harus diisi!');
    }

    if ($rating < 1 || $rating > 5) {
        show_error('Rating harus antara 1-5!');
    }

    if (strlen($pesan) < 10) {
        show_error('Pesan feedback minimal 10 karakter!');
    }

    // Profanity filter (optional)
    $badwords = ['anjing', 'tolol', 'goblok']; // Tambah kata-kata tidak pantas
    $pesan_lower = strtolower($pesan);
    foreach ($badwords as $word) {
        if (strpos($pesan_lower, $word) !== false) {
            show_error('Pesan mengandung kata tidak pantas!');
        }
    }

    // Insert ke database
    $sql = "INSERT INTO feedback (nama_pengirim, rating, kategori, pesan) 
            VALUES (
                '".escape_string($nama_pengirim)."',
                $rating,
                '".escape_string($kategori)."',
                '".escape_string($pesan)."'
            )";

    if ($conn->query($sql) === TRUE) {
        show_success('Feedback berhasil dikirim! Terima kasih atas masukan Anda.', [
            'id_feedback' => $conn->insert_id,
            'rating' => $rating
        ]);
    } else {
        show_error('Gagal menyimpan feedback: ' . $conn->error);
    }
}

// ========== GET STATISTICS ==========
else if ($action === 'stats') {
    $stats = [];

    // Total Pendaftaran
    $result = $conn->query("SELECT COUNT(*) as total FROM pendaftaran WHERE status = 'pending'");
    $stats['pendaftaran_pending'] = $result->fetch_assoc()['total'];

    // Total Feedback
    $result = $conn->query("SELECT COUNT(*) as total FROM feedback WHERE status = 'baru'");
    $stats['feedback_baru'] = $result->fetch_assoc()['total'];

    // Rating Rata-rata
    $result = $conn->query("SELECT AVG(rating) as rata_rata FROM feedback");
    $stats['rating_rata'] = round($result->fetch_assoc()['rata_rata'], 2);

    // Total Feedback by Kategori
    $result = $conn->query("SELECT kategori, COUNT(*) as total FROM feedback GROUP BY kategori");
    $stats['feedback_by_kategori'] = [];
    while ($row = $result->fetch_assoc()) {
        $stats['feedback_by_kategori'][] = $row;
    }

    show_success('Statistik berhasil diambil', $stats);
}

// ========== GET PENDING REGISTRATIONS (For Admin) ==========
else if ($action === 'get_pendaftaran' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    $status = $_GET['status'] ?? 'pending';
    
    $sql = "SELECT * FROM pendaftaran WHERE status = '".escape_string($status)."' ORDER BY tanggal_pendaftaran DESC";
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    show_success('Data pendaftaran berhasil diambil', $data);
}

// ========== UPDATE PENDAFTARAN STATUS (For Admin) ==========
else if ($action === 'update_pendaftaran' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pendaftaran = intval($_POST['id_pendaftaran'] ?? 0);
    $status = sanitize_input($_POST['status'] ?? '');

    if (!in_array($status, ['pending', 'diterima', 'ditolak'])) {
        show_error('Status tidak valid!');
    }

    $sql = "UPDATE pendaftaran SET status = '".escape_string($status)."' WHERE id_pendaftaran = $id_pendaftaran";

    if ($conn->query($sql) === TRUE) {
        show_success('Status pendaftaran berhasil diupdate');
    } else {
        show_error('Gagal update status: ' . $conn->error);
    }
}

else {
    show_error('Action tidak valid atau method tidak diizinkan');
}

$conn->close();
?>
