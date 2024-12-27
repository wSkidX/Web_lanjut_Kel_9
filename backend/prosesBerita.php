<?php
session_start();
include 'koneksi.php';

$upload_dir = "uploads/";
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

try {
    if ($_GET['proses'] == 'insert') {
        if (empty($_POST['judul']) || empty($_POST['kategori_id']) || empty($_POST['isi_berita'])) {
            throw new Exception("Semua field harus diisi");
        }
        
        $file_upload = '';
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $target_dir = "uploads/";
            $file = basename($_FILES["fileToUpload"]["name"]);
            $file_upload = time() . "_" . $file;
            $target_file = $target_dir . $file_upload;
            
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                throw new Exception("Hanya file JPG, JPEG & PNG yang diizinkan");
            }
            
            if ($_FILES["fileToUpload"]["size"] > 5000000) {
                throw new Exception("File terlalu besar (max 5MB)");
            }
            
            if (!move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                throw new Exception("Gagal mengupload file");
            }
        }

        $stmt = $db->prepare("INSERT INTO berita (judul, kategori_id, isi_berita, file_upload, user_id) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$_POST['judul'], $_POST['kategori_id'], $_POST['isi_berita'], $file_upload, $_SESSION['user']['id']]);
        
        if ($result) {
            echo "<script>
                alert('Data Berhasil Ditambahkan');
                window.location.href='../frontend/index.php?p=berita';
            </script>";
        }
    }
    
    else if ($_GET['proses'] == 'edit') {
        $params = [
            $_POST['judul'],
            $_POST['kategori_id'],
            $_POST['isi_berita'],
            $_POST['id']
        ];
        
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            // Proses upload file baru
            $target_dir = "uploads/";
            $file = basename($_FILES["fileToUpload"]["name"]);
            $file_upload = time() . "_" . $file;
            $target_file = $target_dir . $file_upload;
            
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                // Hapus file lama jika ada
                if (!empty($_POST['old_file']) && file_exists("uploads/" . $_POST['old_file'])) {
                    unlink("uploads/" . $_POST['old_file']);
                }
                
                $stmt = $db->prepare("UPDATE berita SET 
                    judul = ?, 
                    kategori_id = ?, 
                    isi_berita = ?,
                    file_upload = ? 
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
            echo "<script>
                alert('Data Berhasil Diperbarui');
                window.location.href='../frontend/index.php?p=berita';
            </script>";
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
        
        $stmt = $db->prepare("DELETE FROM berita WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            echo "<script>
                alert('Data Berhasil Dihapus');
                window.location.href='../frontend/index.php?p=berita';
            </script>";
        }
    }

} catch(Exception $e) {
    echo "<script>
        alert('Error: " . $e->getMessage() . "');
        window.location.href='../frontend/index.php?p=berita';
    </script>";
}
?>
