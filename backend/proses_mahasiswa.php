<?php
require_once 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
        $hobies = implode(",", $_POST['hobi']);
        
        $sql = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, jekel, hobi, email, notelp, alamat, prodi_id) 
                VALUES (:nim, :nama, :tgl, :jekel, :hobi, :email, :notelp, :alamat, :prodi_id)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nim', $_POST['nim']);
        $stmt->bindParam(':nama', $_POST['nama']);
        $stmt->bindParam(':tgl', $tgl);
        $stmt->bindParam(':jekel', $_POST['jekel']);
        $stmt->bindParam(':hobi', $hobies);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':notelp', $_POST['notelp']);
        $stmt->bindParam(':alamat', $_POST['alamat']);
        $stmt->bindParam(':prodi_id', $_POST['prodi_id']);
        
        if ($stmt->execute()) {
            header('Location: index.php?p=mhs');
            exit;
        }
    }

    if ($_GET['proses'] == 'edit') {
        $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
        $hobies = implode(",", $_POST['hobi']);
        
        $sql = "UPDATE mahasiswa SET 
                nama_mhs = :nama,
                tgl_lahir = :tgl,
                jekel = :jekel,
                hobi = :hobi,
                email = :email,
                notelp = :notelp,
                alamat = :alamat,
                prodi_id = :prodi_id 
                WHERE nim = :nim";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nim', $_POST['nim']);
        $stmt->bindParam(':nama', $_POST['nama']);
        $stmt->bindParam(':tgl', $tgl);
        $stmt->bindParam(':jekel', $_POST['jekel']);
        $stmt->bindParam(':hobi', $hobies);
        $stmt->bindParam(':email', $_POST['email']);
        $stmt->bindParam(':notelp', $_POST['notelp']);
        $stmt->bindParam(':alamat', $_POST['alamat']);
        $stmt->bindParam(':prodi_id', $_POST['prodi_id']);
        
        if ($stmt->execute()) {
            header('Location: index.php?p=mhs');
            exit;
        }
    }

    if ($_GET['proses'] == 'delete') {
        $sql = "DELETE FROM mahasiswa WHERE nim = :nim";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':nim', $_GET['nim']);
        
        if ($stmt->execute()) {
            header('Location: index.php?p=mhs');
            exit;
        }
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>