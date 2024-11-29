<?php
session_start();

// Cek metode request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 403 Forbidden');
    exit('Akses ditolak');
}

// Hapus semua data session
$_SESSION = array();

// Hapus cookie session
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}

// Hancurkan session
session_destroy();

// Redirect ke halaman login dengan pesan
session_start();
$_SESSION['success'] = "Anda telah berhasil logout";
header('location: login.php');
exit;
?>
