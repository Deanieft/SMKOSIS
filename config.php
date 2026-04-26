<?php
/**
 * Database Configuration File
 * Koneksi ke database OSIS SMKN 1 Tarumajaya
 */

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Ubah sesuai password MySQL Anda
define('DB_NAME', 'osis_smkn1');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Set charset
$conn->set_charset("utf8");

// Optional: Set timezone
date_default_timezone_set('Asia/Jakarta');

// Function untuk escape input
function escape_string($str) {
    global $conn;
    return $conn->real_escape_string($str);
}

// Function untuk sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function untuk show error
function show_error($message) {
    echo json_encode([
        'status' => 'error',
        'message' => $message
    ]);
    exit;
}

// Function untuk show success
function show_success($message, $data = null) {
    $response = [
        'status' => 'success',
        'message' => $message
    ];
    if ($data) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

?>
