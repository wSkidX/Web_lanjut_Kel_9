<?php
include 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        $query = "INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, semester, jenis_matakuliah, sks, jam, keterangan) 
                 VALUES (:kode_matakuliah, :nama_matakuliah, :semester, :jenis_matakuliah, :sks, :jam, :keterangan)";
        $stmt = $db->prepare($query);
        
        $stmt->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
        $stmt->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
        $stmt->bindParam(':semester', $_POST['semester']);
        $stmt->bindParam(':jenis_matakuliah', $_POST['jenis_matakuliah']);
        $stmt->bindParam(':sks', $_POST['sks']);
        $stmt->bindParam(':jam', $_POST['jam']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);
        
        $result = $stmt->execute();
        
        if ($result) {
            header('Location: index.php?p=matakuliah');
        }
    } 
    else if ($_GET['proses'] == 'edit') {
        $query = "UPDATE matakuliah SET 
                 kode_matakuliah = :kode_matakuliah,
                 nama_matakuliah = :nama_matakuliah,
                 semester = :semester,
                 jenis_matakuliah = :jenis_matakuliah,
                 sks = :sks,
                 jam = :jam,
                 keterangan = :keterangan 
                 WHERE id = :id";
        
        $stmt = $db->prepare($query);
        
        $stmt->bindParam(':kode_matakuliah', $_POST['kode_matakuliah']);
        $stmt->bindParam(':nama_matakuliah', $_POST['nama_matakuliah']);
        $stmt->bindParam(':semester', $_POST['semester']);
        $stmt->bindParam(':jenis_matakuliah', $_POST['jenis_matakuliah']);
        $stmt->bindParam(':sks', $_POST['sks']);
        $stmt->bindParam(':jam', $_POST['jam']);
        $stmt->bindParam(':keterangan', $_POST['keterangan']);
        $stmt->bindParam(':id', $_POST['id']);
        
        $result = $stmt->execute();
        
        if ($result) {
            header('Location: index.php?p=matakuliah');
        }
    } 
    else if ($_GET['proses'] == 'delete') {
        $query = "DELETE FROM matakuliah WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $_GET['id']);
        $result = $stmt->execute();
        
        if ($result) {
            header('Location: index.php?p=matakuliah');
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>