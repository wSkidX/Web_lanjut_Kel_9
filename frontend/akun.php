<?php

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
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <?php if($success != ''): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($success) ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Akun</h3>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" 
                                       value="<?= htmlspecialchars($user['nama']) ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="current_password">Password Lama</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto Profil</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="foto" name="foto" onchange="previewImage(this);">
                                        <label class="custom-file-label" for="foto">Pilih file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <img id="preview" src="#" alt="Preview" class="img-thumbnail" style="max-width: 200px; display: none;">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function previewImage(input) {
    var preview = document.getElementById('preview');
    var file = input.files[0];
    var reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = '';
        preview.style.display = 'none';
    }
}
</script>
