<?php
// session_start();
// if (!isset($_SESSION['email'])) {
//     header('location:../login.php');
// }
// include 'koneksi.php'; 
// $email = $_SESSION['email'];


// $query = mysqli_query($db, "SELECT * FROM user WHERE email='$email'");
// $user = mysqli_fetch_assoc($query);

// if ($user) {
//     $nama = $user['nama'];
//     $foto = $user['foto'];
// } else {
//     session_destroy();
//     header('location:../login.php');
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard | Teknologi Informasi</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?p=home" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='home') ? 'active' : '' ?>">Beranda</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?p=mhs" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='mhs') ? 'active' : '' ?>">Mahasiswa</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?p=matakuliah" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='matakuliah') ? 'active' : '' ?>">Matakuliah</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?p=dosen" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='dosen') ? 'active' : '' ?>">Dosen</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?p=prodi" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='prodi') ? 'active' : '' ?>">Program Studi</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.php?p=berita" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='berita') ? 'active' : '' ?>">Berita</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown user-menu">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo !empty($user['foto']) ? $user['foto'] : 'asset/default-profile.png'; ?>" class="user-image img-circle elevation-2" alt="User Image">
                        <span class="d-none d-md-inline"><?php echo $user['nama']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <li class="user-header bg-primary">
                            <img src="<?php echo !empty($user['foto']) ? $user['foto'] : 'asset/default-profile.png'; ?>" class="img-circle elevation-2" alt="User Image">
                            <p>
                                <?php echo $user['nama']; ?>
                                <small><?php echo $user['email']; ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <a href="index.php?p=akun" class="btn btn-default btn-flat">Settings</a>
                            <a href="../logout.php" class="btn btn-default btn-flat float-right">Sign out</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index.php" class="brand-link">
                <img src="asset/images.png" alt="TI Logo" class="brand-image img-circle elevation-2" style="opacity: .8; max-height: 35px; max-width: 45px; margin-left: auto; object-fit: cover; border-radius: 50%;">
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
                                <p>
                                    Beranda
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link <?= (isset($_GET['p']) && $_GET['p']=='mhs') ? 'active' : '' ?>">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>
                                    Mahasiswa
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="index.php?p=mhs&aksi=input" class="nav-link">
                                        <i class="far fa-plus-square nav-icon "></i>
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
                        <li class="nav-item">
                            <a href="index.php?p=akun" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>Pengaturan Akun</p>
                            </a>
                        </li>
                </nav>
               
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

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.js?v=3.2.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/plugins/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/pages/dashboard3.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>