<?php
include 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        // Handle file upload
        $photo = '';
        if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == 0) {
            $target_dir = "upload/";
            $file = basename($_FILES["fileToUpload"]["name"]);
            $photo = time() . "_" . $file;
            $target_file = $target_dir . $photo;
            
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

        $query = "INSERT INTO berita (judul, kategori_id, file_upload, isi_berita, user_id) 
                 VALUES (:judul, :kategori_id, :file_upload, :isi_berita, :user_id)";
        $stmt = $db->prepare($query);
        
        $stmt->bindParam(':judul', $_POST['judul']);
        $stmt->bindParam(':kategori_id', $_POST['kategori_id']);
        $stmt->bindParam(':file_upload', $photo);
        $stmt->bindParam(':isi_berita', $_POST['isi_berita']);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        
        $result = $stmt->execute();
        
        if ($result) {
            header('Location: index.php?p=berita');
        }
    } 
    else if ($_GET['proses'] == 'edit') {
        $id = $_POST['id'];
        
        // Jika ada file baru yang diupload
        if (!empty($_FILES['fileToUpload']['name'])) {
            $target_dir = "upload/";
            $file = $_FILES['fileToUpload']['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            
            $newFileName = time() . "_" . $file;
            $path_filename_ext = $target_dir . $newFileName;
            
            move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $path_filename_ext);
            
            $query = "UPDATE berita SET 
                     judul = :judul,
                     kategori_id = :kategori_id,
                     file_upload = :file_upload,
                     isi_berita = :isi_berita 
                     WHERE id = :id";
            
            $stmt = $db->prepare($query);
            $stmt->bindParam(':file_upload', $newFileName);
        } else {
            $query = "UPDATE berita SET 
                     judul = :judul,
                     kategori_id = :kategori_id,
                     isi_berita = :isi_berita 
                     WHERE id = :id";
            
            $stmt = $db->prepare($query);
        }
        
        $stmt->bindParam(':judul', $_POST['judul']);
        $stmt->bindParam(':kategori_id', $_POST['kategori_id']);
        $stmt->bindParam(':isi_berita', $_POST['isi_berita']);
        $stmt->bindParam(':id', $id);
        
        $result = $stmt->execute();
        
        if ($result) {
            header('Location: index.php?p=berita');
        }
    } 
    else if ($_GET['proses'] == 'delete') {
        $id = $_GET['id'];
        $file = $_GET['file'];
        
        // Hapus file fisik
        if (!empty($file)) {
            $file_path = "upload/" . $file;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Hapus record dari database
        $query = "DELETE FROM berita WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        
        if ($result) {
            header('Location: index.php?p=berita');
        }
    }
} catch(PDOException $e) {
    echo "Database Error: " . $e->getMessage();
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
