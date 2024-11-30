<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "INSERT INTO level (nama_level, keterangan) 
                    VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                $_POST['nama_level'],
                $_POST['keterangan']
            ]);

            if ($result) {
                echo "<script>alert('Data Berhasil Ditambahkan'); 
                      window.location.href='../frontend/index.php?p=level';</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Data Gagal Ditambahkan'); 
                  window.location.href='../frontend/index.php?p=level&aksi=input';</script>";
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $db->prepare("DELETE FROM level WHERE id = ?");
        $hapus = $stmt->execute([$_GET['id']]);
        
        if ($hapus) {
            header("Location: ../frontend/index.php?p=level");
        }
    } catch(PDOException $e) {
        echo "<script>alert('Data Gagal Dihapus'); 
              window.location.href='../frontend/index.php?p=level';</script>";
    }
}

if ($_GET['proses'] == 'edit') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "UPDATE level SET 
                    nama_level = ?, 
                    keterangan = ? 
                    WHERE id = ?";
            
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                $_POST['nama_level'],
                $_POST['keterangan'],
                $_POST['id']
            ]);

            if ($result) {
                echo "<script>window.location.href='../frontend/index.php?p=level'</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Data Gagal Diperbarui'); 
                  window.location.href='../frontend/index.php?p=level&aksi=edit&id=".$_POST['id']."';</script>";
        }
    }
}
?>