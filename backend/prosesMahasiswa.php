<?php
session_start();
include 'koneksi.php';

try {
    if ($_GET['proses'] == 'insert') {
        // Validasi input
        if (empty($_POST['nim']) || empty($_POST['nama']) || empty($_POST['email'])) {
            throw new Exception("NIM, Nama, dan Email wajib diisi!");
        }

        // Validasi email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format email tidak valid!");
        }

        // Format tanggal
        $tgl = $_POST['thn'] . '-' . sprintf("%02d", $_POST['bln']) . '-' . sprintf("%02d", $_POST['tgl']);
        
        // Validasi tanggal
        if (!strtotime($tgl)) {
            throw new Exception("Format tanggal tidak valid!");
        }

        // Gabungkan array hobi
        $hobies = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';

        // Cek duplikasi NIM
        $stmt = $db->prepare("SELECT COUNT(*) FROM mahasiswa WHERE nim = ?");
        $stmt->execute([$_POST['nim']]);
        if ($stmt->fetchColumn() > 0) {
            throw new Exception("NIM sudah terdaftar!");
        }
        
        $stmt = $db->prepare("INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, jekel, hobi, email, notelp, alamat, prodi_id) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $result = $stmt->execute([
            trim($_POST['nim']),
            trim($_POST['nama']),
            $tgl,
            $_POST['jekel'],
            $hobies,
            trim($_POST['email']),
            trim($_POST['notelp']),
            trim($_POST['alamat']),
            $_POST['prodi_id']
        ]);

        if ($result) {
            header('Location: ../frontend/index.php?p=mhs&status=success&message=Data berhasil ditambahkan');
            exit;
        }
    } 
    
    else if ($_GET['proses'] == 'edit') {
        // Validasi input
        if (empty($_POST['nama']) || empty($_POST['email'])) {
            throw new Exception("Nama dan Email wajib diisi!");
        }

        // Validasi email
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Format email tidak valid!");
        }

        // Format tanggal
        $tgl = $_POST['thn'] . '-' . sprintf("%02d", $_POST['bln']) . '-' . sprintf("%02d", $_POST['tgl']);
        
        // Validasi tanggal
        if (!strtotime($tgl)) {
            throw new Exception("Format tanggal tidak valid!");
        }

        // Gabungkan array hobi
        $hobies = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';
        
        $stmt = $db->prepare("UPDATE mahasiswa SET 
                            nama_mhs = ?, 
                            tgl_lahir = ?, 
                            jekel = ?, 
                            hobi = ?, 
                            email = ?, 
                            notelp = ?, 
                            alamat = ?, 
                            prodi_id = ? 
                            WHERE nim = ?");
        
        $result = $stmt->execute([
            trim($_POST['nama']),
            $tgl,
            $_POST['jekel'],
            $hobies,
            trim($_POST['email']),
            trim($_POST['notelp']),
            trim($_POST['alamat']),
            $_POST['prodi_id'],
            $_POST['nim']
        ]);

        if ($result) {
            header('Location: ../frontend/index.php?p=mhs&status=success&message=Data berhasil diupdate');
            exit;
        }
    } 
    
    else if ($_GET['proses'] == 'delete') {
        if (empty($_GET['nim'])) {
            throw new Exception("NIM tidak ditemukan!");
        }

        $stmt = $db->prepare("DELETE FROM mahasiswa WHERE nim = ?");
        $result = $stmt->execute([$_GET['nim']]);
        
        if ($result) {
            header('Location: ../frontend/index.php?p=mhs&status=success&message=Data berhasil dihapus');
            exit;
        }
    }

} catch(PDOException $e) {
    header('Location: ../frontend/index.php?p=mhs&status=error&message=' . urlencode($e->getMessage()));
    exit;
} catch(Exception $e) {
    header('Location: ../frontend/index.php?p=mhs&status=error&message=' . urlencode($e->getMessage()));
    exit;
}
?>