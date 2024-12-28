<?php
session_start();
include 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        $stmt = $db->prepare("INSERT INTO matakuliah (kode_matakuliah, nama_matakuliah, semester, jenis_matakuliah, sks, jam, keterangan) 
                             VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        $result = $stmt->execute([
            $_POST['kode_matakuliah'],
            $_POST['nama_matakuliah'],
            $_POST['semester'],
            $_POST['jenis_matakuliah'],
            $_POST['sks'],
            $_POST['jam'],
            $_POST['keterangan']
        ]);

        if ($result) {
            echo "<script>
                alert('Data Berhasil Ditambahkan');
                window.location.href='../frontend/index.php?p=matakuliah';
            </script>";
        }
    }
    
    else if ($_GET['proses'] == 'edit') {
        $stmt = $db->prepare("UPDATE matakuliah SET 
                             kode_matakuliah = ?,
                             nama_matakuliah = ?,
                             semester = ?,
                             jenis_matakuliah = ?,
                             sks = ?,
                             jam = ?,
                             keterangan = ?
                             WHERE id = ?");
                             
        $result = $stmt->execute([
            $_POST['kode_matakuliah'],
            $_POST['nama_matakuliah'],
            $_POST['semester'],
            $_POST['jenis_matakuliah'],
            $_POST['sks'],
            $_POST['jam'],
            $_POST['keterangan'],
            $_POST['id']
        ]);

        if ($result) {
            echo "<script>
                alert('Data Berhasil Diperbarui');
                window.location.href='../frontend/index.php?p=matakuliah';
            </script>";
        }
    }
    
    else if ($_GET['proses'] == 'delete') {
        $stmt = $db->prepare("DELETE FROM matakuliah WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            echo "<script>
                alert('Data Berhasil Dihapus');
                window.location.href='../frontend/index.php?p=matakuliah';
            </script>";
        }
    }

} catch(PDOException $e) {
    echo "<script>
        alert('Error: " . $e->getMessage() . "');
        window.location.href='../frontend/index.php?p=matakuliah';
    </script>";
}
?>