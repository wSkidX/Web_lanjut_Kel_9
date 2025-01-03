<?php
session_start();
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "INSERT INTO kategori (nama_kategori, keterangan) 
                    VALUES (?, ?)";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                $_POST['nama_kategori'],
                $_POST['keterangan']
            ]);

            if ($result) {
                echo "<script>
                    alert('Data Berhasil Ditambahkan');
                    window.location.href='../frontend/index.php?p=kategori';
                </script>";
            }
        } catch(PDOException $e) {
            echo "<script>
                alert('Data Gagal Ditambahkan: " . $e->getMessage() . "');
                window.location.href='../frontend/index.php?p=kategori&aksi=input';
            </script>";
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $db->prepare("DELETE FROM kategori WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            echo "<script>
                alert('Data Berhasil Dihapus');
                window.location.href='../frontend/index.php?p=kategori';
            </script>";
        }
    } catch(PDOException $e) {
        echo "<script>
            alert('Data Gagal Dihapus: " . $e->getMessage() . "');
            window.location.href='../frontend/index.php?p=kategori';
        </script>";
    }
}

if ($_GET['proses'] == 'edit') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "UPDATE kategori SET 
                    nama_kategori = ?, 
                    keterangan = ? 
                    WHERE id = ?";
            
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                $_POST['nama_kategori'],
                $_POST['keterangan'],
                $_POST['id']
            ]);

            if ($result) {
                echo "<script>
                    alert('Data Berhasil Diperbarui');
                    window.location.href='../frontend/index.php?p=kategori';
                </script>";
            }
        } catch(PDOException $e) {
            echo "<script>
                alert('Data Gagal Diperbarui: " . $e->getMessage() . "');
                window.location.href='../frontend/index.php?p=kategori&aksi=edit&id=".$_POST['id']."';
            </script>";
        }
    }
}
?>