<?php
session_start();

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
