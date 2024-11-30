<?php
session_start();
require_once 'koneksi.php';

// Fungsi untuk upload foto
function uploadFoto($foto) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $file_extension = strtolower(pathinfo($foto["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_filename;
    
    // Cek ukuran file (max 2MB)
    if ($foto["size"] > 2000000) {
        throw new Exception("File terlalu besar. Maksimal 2MB");
    }
    
    // Cek tipe file
    if (!in_array($file_extension, ["jpg", "jpeg", "png"])) {
        throw new Exception("Hanya file JPG, JPEG & PNG yang diizinkan");
    }
    
    if (move_uploaded_file($foto["tmp_name"], $target_file)) {
        return $target_file;
    } else {
        throw new Exception("Gagal mengupload file");
    }
}

try {
    // Update Profil
    if (isset($_POST['update_profil'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $user_id = $_SESSION['user']['id'];
        
        // Cek email unik
        $stmt = $db->prepare("SELECT id FROM user WHERE email = ? AND id != ?");
        $stmt->execute([$email, $user_id]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("Email sudah digunakan");
        }
        
        // Jika ada foto yang diupload
        if (!empty($_FILES['foto']['name'])) {
            $foto_path = uploadFoto($_FILES['foto']);
            
            // Hapus foto lama jika ada
            if (!empty($_SESSION['user']['foto']) && file_exists($_SESSION['user']['foto'])) {
                unlink($_SESSION['user']['foto']);
            }
            
            $stmt = $db->prepare("UPDATE user SET nama = ?, email = ?, foto = ? WHERE id = ?");
            $stmt->execute([$nama, $email, $foto_path, $user_id]);
            
            $_SESSION['user']['foto'] = $foto_path;
        } else {
            $stmt = $db->prepare("UPDATE user SET nama = ?, email = ? WHERE id = ?");
            $stmt->execute([$nama, $email, $user_id]);
        }
        
        // Update session
        $_SESSION['user']['nama'] = $nama;
        $_SESSION['user']['email'] = $email;
        
        $_SESSION['success'] = "Profil berhasil diperbarui";
        header('Location: ../frontend/index.php?p=akun');
        exit;
    }
    
    // Ubah Password
    if (isset($_POST['ubah_password'])) {
        $old_password = md5($_POST['old_password']);
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $user_id = $_SESSION['user']['id'];
        
        // Validasi password lama
        $stmt = $db->prepare("SELECT id FROM user WHERE id = ? AND password = ?");
        $stmt->execute([$user_id, $old_password]);
        if ($stmt->rowCount() == 0) {
            throw new Exception("Password lama salah");
        }
        
        // Validasi password baru
        if (strlen($new_password) < 6) {
            throw new Exception("Password minimal 6 karakter");
        }
        
        if ($new_password !== $confirm_password) {
            throw new Exception("Konfirmasi password tidak cocok");
        }
        
        // Update password
        $new_password_hash = md5($new_password);
        $stmt = $db->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->execute([$new_password_hash, $user_id]);
        
        $_SESSION['success'] = "Password berhasil diubah";
        header('Location: ../frontend/index.php?p=akun');
        exit;
    }

} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: ../frontend/index.php?p=akun');
    exit;
}

// Jika tidak ada aksi yang valid
$_SESSION['error'] = "Aksi tidak valid";
header('Location: ../frontend/index.php?p=akun');
exit;
?>
