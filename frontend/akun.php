<?php
require_once '../backend/session_check.php';
checkSession();
checkSessionTimeout();

if (!isset($_SESSION['email'])) {
    header('location:../login.php');
    exit();
}

include '../backend/koneksi.php';

try {
    // Ambil data user
    $stmt = $db->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->execute([$_SESSION['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $error = '';
    $success = '';

    // Jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = isset($_POST['nama']) ? $_POST['nama'] : $user['nama'];
        $new_email = isset($_POST['email']) ? $_POST['email'] : $user['email'];
        $current_password = isset($_POST['current_password']) ? $_POST['current_password'] : '';
        $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
        $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

        $update_fields = [];
        $params = [];

        // Update nama jika berubah
        if ($nama != $user['nama']) {
            $update_fields[] = "nama = ?";
            $params[] = $nama;
        }

        // Update email jika berubah
        if ($new_email != $user['email']) {
            if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
                $error = "Format email tidak valid.";
            } else {
                $update_fields[] = "email = ?";
                $params[] = $new_email;
            }
        }

        // Update password jika diisi
        if (!empty($new_password)) {
            if ($new_password !== $confirm_password) {
                $error = "Password baru dan konfirmasi password tidak cocok.";
            } else {
                // Verifikasi password lama
                if (password_verify($current_password, $user['password'])) {
                    $update_fields[] = "password = ?";
                    $params[] = password_hash($new_password, PASSWORD_DEFAULT);
                } else {
                    $error = "Password lama tidak sesuai.";
                }
            }
        }

        // Proses upload foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
            $target_dir = "../backend/uploads/";
            $file = $_FILES["foto"];
            $file_name = time() . '_' . basename($file["name"]);
            $target_file = $target_dir . $file_name;
            
            // Validasi file
            $allowed_types = ["jpg", "jpeg", "png", "gif"];
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            
            if (!in_array($file_type, $allowed_types)) {
                $error = "Hanya file JPG, JPEG, PNG & GIF yang diizinkan.";
            } else if ($file["size"] > 500000) {
                $error = "Ukuran file terlalu besar (max 500KB).";
            } else if (move_uploaded_file($file["tmp_name"], $target_file)) {
                // Hapus foto lama jika ada
                if (!empty($user['foto']) && file_exists($user['foto'])) {
                    unlink($user['foto']);
                }
                $update_fields[] = "foto = ?";
                $params[] = $target_file;
            } else {
                $error = "Gagal mengupload file.";
            }
        }

        // Eksekusi update jika ada perubahan dan tidak ada error
        if (!empty($update_fields) && empty($error)) {
            $sql = "UPDATE user SET " . implode(", ", $update_fields) . " WHERE id = ?";
            $params[] = $user['id'];
            
            $stmt = $db->prepare($sql);
            if ($stmt->execute($params)) {
                $success = "Perubahan berhasil disimpan.";
                if ($new_email != $user['email']) {
                    $_SESSION['email'] = $new_email;
                }
                // Refresh data user
                $stmt = $db->prepare("SELECT * FROM user WHERE id = ?");
                $stmt->execute([$user['id']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                $error = "Terjadi kesalahan saat menyimpan perubahan.";
            }
        }
    }
} catch(PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pengaturan Akun</h1>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <?php if($error != ''): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($error) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <?php if($success != ''): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="row">
            <!-- Kolom Foto Profil -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?= !empty($user['foto']) ? $user['foto'] : '../asset/user.png' ?>" 
                             class="rounded-circle mb-3" 
                             alt="Foto Profil"
                             style="width: 150px; height: 150px; object-fit: cover;">
                        <h5 class="card-title"><?= htmlspecialchars($user['nama']) ?></h5>
                        <p class="text-muted"><?= htmlspecialchars($user['email']) ?></p>
                        
                        <form method="post" enctype="multipart/form-data" id="foto-form">
                            <div class="mb-3">
                                <label for="foto" class="form-label d-block">
                                    <div class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-camera me-2"></i>Ubah Foto
                                    </div>
                                </label>
                                <input type="file" class="form-control d-none" id="foto" name="foto" 
                                       accept="image/*" onchange="previewImage(this);">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolom Form -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="post" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" name="nama" 
                                           value="<?= htmlspecialchars($user['nama']) ?>">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" 
                                           value="<?= htmlspecialchars($user['email']) ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="my-4">
                                <h5>Ubah Password</h5>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Password Lama</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    <input type="password" class="form-control" name="current_password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Password Baru</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    <input type="password" class="form-control" name="new_password">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-check"></i></span>
                                    <input type="password" class="form-control" name="confirm_password">
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('img.rounded-circle').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
        // Auto submit form when file selected
        document.getElementById('foto-form').submit();
    }
}

// Show filename in custom file input
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    const fileName = e.target.files[0].name;
    const nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>
