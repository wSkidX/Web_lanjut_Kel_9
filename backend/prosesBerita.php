<?php
session_start();
include 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        // Handle file upload
        $file_upload = '';
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $target_dir = "uploads/";
            $file = basename($_FILES["fileToUpload"]["name"]);
            $file_upload = time() . "_" . $file;
            $target_file = $target_dir . $file_upload;
            
            // Validasi tipe file
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                throw new Exception("Hanya file JPG, JPEG & PNG yang diizinkan");
            }
            
            // Validasi ukuran file (max 5MB)
            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                throw new Exception("File terlalu besar (max 5MB)");
            }
            
            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                throw new Exception("Gagal mengupload file");
            }
        }

        $stmt = $db->prepare("INSERT INTO berita (user_id, kategori_id, judul, file_upload, isi_berita, created_at) 
                             VALUES (?, ?, ?, ?, ?, NOW())");
        
        $result = $stmt->execute([
            $_SESSION['user']['id'],
            $_POST['kategori_id'],
            $_POST['judul'],
            $file_upload,
            $_POST['isi_berita']
        ]);
        
        if ($result) {
            header('Location: ../frontend/index.php?p=berita');
            exit;
        }
    } 
    
    else if ($_GET['proses'] == 'edit') {
        $file_upload = '';
        $params = [
            $_POST['judul'],
            $_POST['kategori_id'],
            $_POST['isi_berita'],
            $_POST['id']
        ];
        
        // Jika ada file baru yang diupload
        if (!empty($_FILES['fileToUpload']['name'])) {
            $target_dir = "uploads/";
            $file = basename($_FILES["fileToUpload"]["name"]);
            $file_upload = time() . "_" . $file;
            $target_file = $target_dir . $file_upload;
            
            // Validasi dan upload file
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                throw new Exception("Hanya file JPG, JPEG & PNG yang diizinkan");
            }
            
            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                throw new Exception("File terlalu besar (max 5MB)");
            }
            
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // Hapus file lama jika ada
                if (!empty($_POST['old_file'])) {
                    $old_file = "uploads/" . $_POST['old_file'];
                    if (file_exists($old_file)) {
                        unlink($old_file);
                    }
                }
                
                $stmt = $db->prepare("UPDATE berita SET 
                                    judul = ?, 
                                    kategori_id = ?, 
                                    file_upload = ?,
                                    isi_berita = ? 
                                    WHERE id = ?");
                array_splice($params, 3, 0, $file_upload);
            }
        } else {
            $stmt = $db->prepare("UPDATE berita SET 
                                judul = ?, 
                                kategori_id = ?, 
                                isi_berita = ? 
                                WHERE id = ?");
        }
        
        $result = $stmt->execute($params);
        
        if ($result) {
            header('Location: ../frontend/index.php?p=berita');
            exit;
        }
    } 
    
    else if ($_GET['proses'] == 'delete') {
        // Hapus file fisik
        if (!empty($_GET['file'])) {
            $file_path = "uploads/" . $_GET['file'];
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Hapus record dari database
        $stmt = $db->prepare("DELETE FROM berita WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            header('Location: ../frontend/index.php?p=berita');
            exit;
        }
    }

} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
