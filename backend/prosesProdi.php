<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "INSERT INTO prodi (nama_prodi, jenjang_prodi) VALUES (?, ?)";
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute([
                $_POST['nama_prodi'],
                $_POST['jenjang']
            ]);

            if ($result) {
                echo "<script>alert('Data Berhasil Ditambahkan'); 
                      window.location.href='../index.php?p=prodi';</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Data Gagal Ditambahkan'); 
                  window.location.href='../index.php?p=prodi&aksi=input';</script>";
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $dbh->prepare("DELETE FROM prodi WHERE id = ?");
        $hapus = $stmt->execute([$_GET['id']]);
        
        if ($hapus) {
            header("Location: ../index.php?p=prodi");
        }
    } catch(PDOException $e) {
        echo "<script>alert('Data Gagal Dihapus'); 
              window.location.href='../index.php?p=prodi';</script>";
    }
}

if ($_GET['proses'] == 'edit') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "UPDATE prodi SET 
                    nama_prodi = ?, 
                    jenjang_prodi = ? 
                    WHERE id = ?";
            
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute([
                $_POST['nama_prodi'],
                $_POST['jenjang'],
                $_POST['id']
            ]);

            if ($result) {
                echo "<script>window.location.href='../index.php?p=prodi'</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Data Gagal Diperbarui'); 
                  window.location.href='../index.php?p=prodi&aksi=edit&id=".$_POST['id']."';</script>";
        }
    }
}
?>