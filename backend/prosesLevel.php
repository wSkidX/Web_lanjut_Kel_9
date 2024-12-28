<?php
session_start();
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
                echo "<script>
                    alert('Data Berhasil Ditambahkan');
                    window.location.href='../frontend/index.php?p=level';
                </script>";
            }
        } catch(PDOException $e) {
            echo "<script>
                alert('Data Gagal Ditambahkan: " . $e->getMessage() . "');
                window.location.href='../frontend/index.php?p=level&aksi=input';
            </script>";
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $db->prepare("DELETE FROM level WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            echo "<script>
                alert('Data Berhasil Dihapus');
                window.location.href='../frontend/index.php?p=level';
            </script>";
        }
    } catch(PDOException $e) {
        echo "<script>
            alert('Data Gagal Dihapus: " . $e->getMessage() . "');
            window.location.href='../frontend/index.php?p=level';
        </script>";
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
                echo "<script>
                    alert('Data Berhasil Diperbarui');
                    window.location.href='../frontend/index.php?p=level';
                </script>";
            }
        } catch(PDOException $e) {
            echo "<script>
                alert('Data Gagal Diperbarui: " . $e->getMessage() . "');
                window.location.href='../frontend/index.php?p=level&aksi=edit&id=".$_POST['id']."';
            </script>";
        }
    }
}
?>