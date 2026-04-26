<?php
// Test Database Connection
include 'config.php';

echo "<h1>🧪 TESTING DATABASE CONNECTION</h1>";

// Test koneksi
if ($conn->connect_error) {
    echo "<p style='color:red'>❌ Koneksi gagal: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color:green'>✅ Koneksi database berhasil!</p>";
}

// Test query
$result = $conn->query("SELECT COUNT(*) as total FROM users");
if ($result) {
    $row = $result->fetch_assoc();
    echo "<p>👥 Total users: " . $row['total'] . "</p>";
} else {
    echo "<p style='color:red'>❌ Query gagal: " . $conn->error . "</p>";
}

echo "<h2>📊 TESTING FORM SUBMISSION</h2>";

// Test data pendaftaran
$testData = [
    'nama_lengkap' => 'Test User',
    'kelas' => 'XII RPL 1',
    'email' => 'test@example.com',
    'no_telepon' => '08123456789',
    'divisi_diminati' => 'Humas',
    'motivasi' => 'Testing form submission'
];

$sql = "INSERT INTO pendaftaran (nama_lengkap, kelas, email, no_telepon, divisi_diminati, motivasi)
        VALUES (
            '".escape_string($testData['nama_lengkap'])."',
            '".escape_string($testData['kelas'])."',
            '".escape_string($testData['email'])."',
            '".escape_string($testData['no_telepon'])."',
            '".escape_string($testData['divisi_diminati'])."',
            '".escape_string($testData['motivasi'])."'
        )";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green'>✅ Data pendaftaran berhasil disimpan! ID: " . $conn->insert_id . "</p>";
} else {
    echo "<p style='color:red'>❌ Gagal menyimpan data: " . $conn->error . "</p>";
}

// Test data feedback
$feedbackData = [
    'nama_pengirim' => 'Test User',
    'rating' => 5,
    'kategori' => 'apresiasi',
    'pesan' => 'Website OSIS sangat bagus!'
];

$sql2 = "INSERT INTO feedback (nama_pengirim, rating, kategori, pesan)
         VALUES (
             '".escape_string($feedbackData['nama_pengirim'])."',
             ".$feedbackData['rating'].",
             '".escape_string($feedbackData['kategori'])."',
             '".escape_string($feedbackData['pesan'])."'
         )";

if ($conn->query($sql2) === TRUE) {
    echo "<p style='color:green'>✅ Data feedback berhasil disimpan! ID: " . $conn->insert_id . "</p>";
} else {
    echo "<p style='color:red'>❌ Gagal menyimpan feedback: " . $conn->error . "</p>";
}

echo "<h2>📋 DATA TERKINI</h2>";

// Cek data pendaftaran
$result = $conn->query("SELECT COUNT(*) as total FROM pendaftaran");
$row = $result->fetch_assoc();
echo "<p>📝 Total pendaftaran: " . $row['total'] . "</p>";

// Cek data feedback
$result = $conn->query("SELECT COUNT(*) as total FROM feedback");
$row = $result->fetch_assoc();
echo "<p>💬 Total feedback: " . $row['total'] . "</p>";

$conn->close();

echo "<p><a href='index.html'>← Kembali ke Website</a></p>";
?>