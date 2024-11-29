<?php
include 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        try {
            // Format tanggal
            $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
            // Gabungkan array hobi
            $hobies = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';
            
            $sql = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, jekel, hobi, email, notelp, alamat, prodi_id) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute([
                $_POST['nim'],
                $_POST['nama'],
                $tgl,
                $_POST['jekel'],
                $hobies,
                $_POST['email'],
                $_POST['notelp'],
                $_POST['alamat'],
                $_POST['prodi_id']
            ]);

            if ($result) {
                echo "<script>alert('Data Berhasil Ditambahkan'); 
                      window.location.href='../index.php?p=mhs';</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Data Gagal Ditambahkan'); 
                  window.location.href='../index.php?p=mhs&aksi=input';</script>";
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $dbh->prepare("DELETE FROM mahasiswa WHERE nim = ?");
        $hapus = $stmt->execute([$_GET['nim']]);
        
        if ($hapus) {
            header("Location: ../index.php?p=mhs");
        }
    } catch(PDOException $e) {
        echo "<script>alert('Data Gagal Dihapus'); 
              window.location.href='../index.php?p=mhs';</script>";
    }
}

if ($_GET['proses'] == 'edit') {
    if (isset($_POST['submit'])) {
        try {
            // Format tanggal
            $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
            // Gabungkan array hobi
            $hobies = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';
            
            $sql = "UPDATE mahasiswa SET 
                    nama_mhs = ?, 
                    tgl_lahir = ?, 
                    jekel = ?, 
                    hobi = ?, 
                    email = ?, 
                    notelp = ?, 
                    alamat = ?, 
                    prodi_id = ? 
                    WHERE nim = ?";
            
            $stmt = $dbh->prepare($sql);
            $result = $stmt->execute([
                $_POST['nama'],
                $tgl,
                $_POST['jekel'],
                $hobies,
                $_POST['email'],
                $_POST['notelp'],
                $_POST['alamat'],
                $_POST['prodi_id'],
                $_POST['nim']
            ]);

            if ($result) {
                echo "<script>window.location.href='../index.php?p=mhs'</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Data Gagal Diperbarui'); 
                  window.location.href='../index.php?p=mhs&aksi=edit&nim=".$_POST['nim']."';</script>";
        }
    }
}
?>