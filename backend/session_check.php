<?php
function checkSession() {
    // Cek jika session belum dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Cek jika user belum login
    if (!isset($_SESSION['user'])) {
        $_SESSION['error'] = "Silakan login terlebih dahulu";
        header('location: ../login.php');
        exit;
    }

    // Perbarui waktu terakhir aktivitas
    $_SESSION['last_activity'] = time();
}

function checkSessionTimeout() {
    $timeout = 30 * 60; // 30 menit dalam detik
    
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity'] > $timeout)) {
        // Jika timeout, logout user
        session_start();
        $_SESSION = array();
        session_destroy();
        
        // Redirect ke login dengan pesan
        session_start();
        $_SESSION['error'] = "Sesi Anda telah berakhir. Silakan login kembali.";
        header('location: ../login.php');
        exit;
    }
}
