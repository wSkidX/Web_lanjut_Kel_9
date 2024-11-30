<link rel="stylesheet" href="../asset/css/style.css">
<?php

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';

if ($aksi == 'password') {
    ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Ubah Password</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Ubah Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Ubah Password</h3>
                        </div>
                        <div class="card-body">
                            <form action="../backend/prosesAkun.php" method="POST">
                                <div class="form-group">
                                    <label><i class="fas fa-lock mr-2"></i>Password Lama</label>
                                    <input type="password" name="old_password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-key mr-2"></i>Password Baru</label>
                                    <input type="password" name="new_password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-check-circle mr-2"></i>Konfirmasi Password Baru</label>
                                    <input type="password" name="confirm_password" class="form-control" required>
                                </div>
                                <div class="text-right">
                                    <a href="index.php?p=akun" class="btn btn-secondary"><i class="fas fa-arrow-left mr-2"></i>Kembali</a>
                                    <button type="submit" name="ubah_password" class="btn btn-primary"><i class="fas fa-save mr-2"></i>Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
} else {
    ?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profil Saya</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profil Saya</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Kolom Kiri - Foto Profil -->
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="<?= !empty($_SESSION['user']['foto']) ? $_SESSION['user']['foto'] : '../asset/user.png' ?>"
                                     alt="User profile picture"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                            <h3 class="profile-username text-center"><?= $_SESSION['user']['nama'] ?></h3>
                            <p class="text-muted text-center">
                                <span class="badge badge-primary"><?= $_SESSION['user']['level'] ?></span>
                            </p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b><i class="fas fa-envelope mr-2"></i>Email</b>
                                    <a class="float-right"><?= $_SESSION['user']['email'] ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b><i class="fas fa-id-card mr-2"></i>ID User</b>
                                    <a class="float-right">#<?= $_SESSION['user']['id'] ?></a>
                                </li>
                            </ul>
                            <a href="index.php?p=akun&aksi=password" class="btn btn-primary btn-block">
                                <i class="fas fa-key mr-2"></i>Ubah Password
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Kolom Kanan - Form Edit Profil -->
                <div class="col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Profil</h3>
                        </div>
                        <div class="card-body">
                            <form action="../backend/prosesAkun.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label><i class="fas fa-user mr-2"></i>Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" value="<?= $_SESSION['user']['nama'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-envelope mr-2"></i>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $_SESSION['user']['email'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><i class="fas fa-image mr-2"></i>Foto Profil</label>
                                    <div class="custom-file">
                                        <input type="file" name="foto" class="custom-file-input" id="foto">
                                        <label class="custom-file-label" for="foto">Pilih file</label>
                                    </div>
                                    <small class="form-text text-muted">Format yang diizinkan: JPG, JPEG, PNG. Maksimal 2MB.</small>
                                </div>
                                <div class="text-right">
                                    <button type="submit" name="update_profil" class="btn btn-primary">
                                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
}
?>

<script src="../asset/scripts/script.js"></script>
