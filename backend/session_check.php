<?php
function checkSession() {
    // Cek jika session belum dimulai
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Cek jika user belum login
    if (!isset($_SESSION['user'])) {
        $_SESSION['error'] = "Silakan login terlebih dahulu";
        if (!headers_sent()) {
            header('Location: ../login.php');
            exit;
        } else {
            echo "<script>window.location.href='../login.php';</script>";
            exit;
        }
    }
}

function checkSessionTimeout() {
    $timeout = 30 * 60; // 30 menit dalam detik
    
    if (isset($_SESSION['last_activity']) && 
        (time() - $_SESSION['last_activity'] > $timeout)) {
        // Jika timeout, logout user
        $_SESSION = array();
        session_destroy();
        
        // Redirect ke login dengan pesan
        session_start();
        $_SESSION['error'] = "Sesi Anda telah berakhir. Silakan login kembali.";
        if (!headers_sent()) {
            header('Location: ../login.php');
            exit;
        } else {
            echo "<script>window.location.href='../login.php';</script>";
            exit;
        }
    }
    
    // Update last activity
    $_SESSION['last_activity'] = time();
}
