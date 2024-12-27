<?php
session_start();
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "INSERT INTO dosen (nik, nama_dosen, email, prodi_id, notelp, alamat) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                $_POST['nik'],
                $_POST['nama_dosen'],
                $_POST['email'],
                $_POST['prodi_id'],
                $_POST['notelp'],
                $_POST['alamat']
            ]);

            if ($result) {
                echo "<script>
                    alert('Data Berhasil Ditambahkan');
                    window.location.href='../frontend/index.php?p=dosen';
                </script>";
            }
        } catch(PDOException $e) {
            echo "<script>
                alert('Data Gagal Ditambahkan: " . $e->getMessage() . "');
                window.location.href='../frontend/index.php?p=dosen&aksi=input';
            </script>";
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $db->prepare("DELETE FROM dosen WHERE id = ?");
        $result = $stmt->execute([$_GET['id']]);
        
        if ($result) {
            echo "<script>
                alert('Data Berhasil Dihapus');
                window.location.href='../frontend/index.php?p=dosen';
            </script>";
        }
    } catch(PDOException $e) {
        echo "<script>
            alert('Data Gagal Dihapus: " . $e->getMessage() . "');
            window.location.href='../frontend/index.php?p=dosen';
        </script>";
    }
}

if ($_GET['proses'] == 'edit') {
    if (isset($_POST['submit'])) {
        try {
            $sql = "UPDATE dosen SET 
                    nik = ?, 
                    nama_dosen = ?, 
                    email = ?, 
                    prodi_id = ?, 
                    notelp = ?, 
                    alamat = ? 
                    WHERE id = ?";
            
            $stmt = $db->prepare($sql);
            $result = $stmt->execute([
                $_POST['nik'],
                $_POST['nama_dosen'],
                $_POST['email'],
                $_POST['prodi_id'],
                $_POST['notelp'],
                $_POST['alamat'],
                $_POST['id']
            ]);

            if ($result) {
                echo "<script>
                    alert('Data Berhasil Diperbarui');
                    window.location.href='../frontend/index.php?p=dosen';
                </script>";
            }
        } catch(PDOException $e) {
            echo "<script>
                alert('Data Gagal Diperbarui: " . $e->getMessage() . "');
                window.location.href='../frontend/index.php?p=dosen&aksi=edit&id=".$_POST['id']."';
            </script>";
        }
    }
}
?>
