<?php
session_start();

// Jika user sudah login, redirect ke dashboard
if (isset($_SESSION['user'])) {
    header('location: frontend/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome | Teknologi Informasi</title>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <style>
        .welcome-page {
            height: 100vh;
            background: linear-gradient(135deg, #00c6fb 0%, #005bea 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .welcome-content {
            text-align: center;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }
        
        .welcome-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        .welcome-subtitle {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        .welcome-buttons .btn {
            margin: 0.5rem;
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .welcome-buttons .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .logo-img {
            max-width: 150px;
            margin-bottom: 2rem;
        }
        
        .features {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }
        
        .feature-item {
            margin: 0 1rem;
            text-align: center;
        }
        
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>
    <div class="welcome-page">
        <div class="welcome-content">
            <img src="asset/img/logo.png" alt="Logo" class="logo-img">
            
            <h1 class="welcome-title">Selamat Datang</h1>
            <p class="welcome-subtitle">Sistem Informasi Teknologi Informasi</p>
            
            <div class="features">
                <div class="feature-item">
                    <i class="fas fa-graduation-cap feature-icon"></i>
                    <p>Akademik</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-newspaper feature-icon"></i>
                    <p>Berita</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-users feature-icon"></i>
                    <p>Komunitas</p>
                </div>
            </div>
            
            <div class="welcome-buttons">
                <a href="login.php" class="btn btn-light btn-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </a>
                <a href="register.php" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-user-plus mr-2"></i> Register
                </a>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Animasi fade in untuk konten
        $('.welcome-content').hide().fadeIn(1000);
        
        // Hover effect untuk feature items
        $('.feature-item').hover(
            function() {
                $(this).find('.feature-icon').addClass('fa-bounce');
            },
            function() {
                $(this).find('.feature-icon').removeClass('fa-bounce');
            }
        );
    });
    </script>
</body>
</html>
