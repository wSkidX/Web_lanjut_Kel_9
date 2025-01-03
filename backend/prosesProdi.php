<?php
session_start();
include 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        $stmt = $db->prepare("INSERT INTO prodi (nama_prodi, jenjang) VALUES (?, ?)");
        $result = $stmt->execute([
            $_POST['nama_prodi'],
            $_POST['jenjang']
        ]);

        if ($result) {
            echo "<script>
                alert('Data Berhasil Ditambahkan');
                window.location.href='../frontend/index.php?p=prodi';
            </script>";
        }
    }
    
    else if ($_GET['proses'] == 'edit') {
        $stmt = $db->prepare("UPDATE prodi SET nama_prodi = ?, jenjang = ? WHERE id = ?");
        $result = $stmt->execute([
            $_POST['nama_prodi'],
            $_POST['jenjang'],
            $_POST['id']
        ]);

        if ($result) {
            echo "<script>
                alert('Data Berhasil Diperbarui');
                window.location.href='../frontend/index.php?p=prodi';
            </script>";
        }
    }
    
    else if ($_GET['proses'] == 'delete') {
        $stmt = $db->prepare("DELETE FROM prodi WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            echo "<script>
                alert('Data Berhasil Dihapus');
                window.location.href='../frontend/index.php?p=prodi';
            </script>";
        }
    }

} catch(PDOException $e) {
    echo "<script>
        alert('Error: " . $e->getMessage() . "');
        window.location.href='../frontend/index.php?p=prodi';
    </script>";
}
?>