<?php
require_once '../backend/session_check.php';
checkSession();
checkSessionTimeout();

include '../backend/koneksi.php';

try {
    $user = $_SESSION['user'];
    $stmt = $db->prepare("SELECT user.*, level.nama_level 
                         FROM user 
                         JOIN level ON level.id = user.level_id 
                         WHERE user.id = ?");
    $stmt->execute([$user['id']]);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user_data) {
        // Update session dengan data terbaru
        $_SESSION['user'] = [
            'id' => $user_data['id'],
            'nama' => $user_data['nama'],
            'email' => $user_data['email'],
            'level_id' => $user_data['level_id'],
            'foto' => $user_data['foto'],
            'level' => $user_data['nama_level']
        ];
    } else {
        // Jika user tidak ditemukan, logout
        header('location: ../logout.php');
        exit;
    }
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | Teknologi Informasi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css?v=3.2.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../asset/css/style.css" rel="stylesheet">
   
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                        <img src="<?php echo !empty($user['foto']) ? $user['foto'] : '../asset/user.png'; ?>" 
                             class="img-circle" alt="User Image" 
                             style="width: 30px; height: 30px; object-fit: cover;">
                        <span class="d-none d-md-inline ml-1"><?php echo $user['nama']; ?></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="index.php?p=akun" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2"></i> Pengaturan Akun
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="../logout.php" method="POST" class="dropdown-item">
                            <button type="submit" class="btn btn-link text-danger p-0" 
                                    onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index.php" class="brand-link">
                <img src="../asset/images.png" alt="TI Logo" 
                     class="brand-image img-circle elevation-2" 
                     style="opacity: .8; max-height: 35px;">
                <span class="brand-text font-weight-light">TI Admin</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?php echo !empty($user['foto']) ? $user['foto'] : 'asset/default-profile.png'; ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?php echo $user['nama']; ?></a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link <?= (!isset($_GET['p']) || $_GET['p']=='home') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a>
                        </li>

                        <li class="nav-item <?= (isset($_GET['p']) && $_GET['p']=='mhs') ? 'menu-open' : '' ?>">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='mhs') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>
                                    Mahasiswa
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=mhs&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Tambah Mahasiswa</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?p=mhs" class="nav-link">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Data Mahasiswa</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='matakuliah') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-book"></i>
                                <p>
                                    Mata kuliah
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=matakuliah&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Tambah Mata kuliah</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?p=matakuliah" class="nav-link">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Data Matakuliah</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='prodi') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-graduation-cap"></i>
                                <p>
                                    Program Studi
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=prodi&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Tambah Prodi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?p=prodi" class="nav-link">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Data Prodi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='dosen') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                                <p>
                                    Dosen
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=dosen&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Tambah Dosen</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?p=dosen" class="nav-link">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Data Dosen</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='kategori') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-tags"></i>
                                <p>
                                    Kategori
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=kategori&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Tambah Kategori</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?p=kategori" class="nav-link">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Data Kategori</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='berita') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-newspaper"></i>
                                <p>
                                    Berita
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=berita&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Tambah Berita</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?p=berita" class="nav-link">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Data Berita</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='level') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Level
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=level&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon"></i>
                                        <p>Tambah Level</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="index.php?p=level" class="nav-link">
                                        <i class="far fa-list-alt nav-icon"></i>
                                        <p>Data Level</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item mt-4">
                            <div class="user-panel py-2 d-flex justify-content-center">
                                <form action="../logout.php" method="POST" class="w-100">
                                    <button type="submit" class="btn btn-logout w-100" 
                                            onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span class="ml-2">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <?php
            $page = isset($_GET['p']) ? $_GET['p'] : 'home';
            if ($page == 'home') include 'home.php';
            if ($page == 'mhs') include 'mahasiswa.php';
            if ($page == 'prodi') include 'prodi.php';
            if ($page == 'dosen') include 'dosen.php';
            if ($page == 'kategori') include 'kategori.php';
            if ($page == 'berita') include 'berita.php';
            if ($page == 'detail') include 'detail.php';
            if ($page == 'akun') include 'akun.php';
            if ($page == 'matakuliah') include 'matakuliah.php';
            if ($page == 'level') include 'level.php';
            ?>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.js?v=3.2.0"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/pages/dashboard3.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>