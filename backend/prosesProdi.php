<?php
include 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        $stmt = $db->prepare("INSERT INTO prodi (nama_prodi, jenjang) VALUES (?, ?)");
        $result = $stmt->execute([
            $_POST['nama_prodi'],
            $_POST['jenjang']
        ]);

        if ($result) {
            header('Location: ../frontend/index.php?p=prodi');
            exit;
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
            header('Location: ../frontend/index.php?p=prodi');
            exit;
        }
    }
    
    else if ($_GET['proses'] == 'delete') {
        $stmt = $db->prepare("DELETE FROM prodi WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            header('Location: ../frontend/index.php?p=prodi');
            exit;
        }
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>