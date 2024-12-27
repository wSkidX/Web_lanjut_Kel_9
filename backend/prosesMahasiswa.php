<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

error_log("POST Data: " . print_r($_POST, true));
error_log("GET Data: " . print_r($_GET, true));

include 'koneksi.php';

if (isset($_GET['proses'])) {
    $proses = $_GET['proses'];
    
    switch ($proses) {
        case 'insert':
            try {
                if (isset($_POST['submit'])) {
                    // Format tanggal
                    $tanggal = $_POST['thn'].'-'.$_POST['bln'].'-'.$_POST['tgl'];
                    // Format hobi
                    $hobi = isset($_POST['hobi']) ? implode(", ", $_POST['hobi']) : '';

                    $stmt = $db->prepare("INSERT INTO mahasiswa (nim, nama, tgl_lahir, jenis_kelamin, hobi, email, no_telp, alamat) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    
                    $result = $stmt->execute([
                        $_POST['nim'],
                        $_POST['nama'],
                        $tanggal,
                        $_POST['jenis_kelamin'],
                        $hobi,
                        $_POST['email'],
                        $_POST['no_telp'],
                        $_POST['alamat']
                    ]);

                    if ($result) {
                        echo "<script>
                            alert('Data Berhasil Ditambahkan');
                            window.location.href='../frontend/index.php?p=mhs';
                        </script>";
                    }
                }
            } catch(PDOException $e) {
                echo "<script>
                    alert('Data Gagal Ditambahkan: " . $e->getMessage() . "');
                    window.location.href='../frontend/index.php?p=mhs&aksi=input';
                </script>";
            }
            break;

        case 'edit':
            try {
                if (isset($_POST['submit'])) {
                    // Format tanggal
                    $tanggal = $_POST['thn'].'-'.$_POST['bln'].'-'.$_POST['tgl'];
                    // Format hobi
                    $hobi = isset($_POST['hobi']) ? implode(", ", $_POST['hobi']) : '';

                    $stmt = $db->prepare("UPDATE mahasiswa SET 
                        nama = ?, 
                        tgl_lahir = ?, 
                        jenis_kelamin = ?, 
                        hobi = ?, 
                        email = ?, 
                        no_telp = ?, 
                        alamat = ? 
                        WHERE nim = ?");
                    
                    $result = $stmt->execute([
                        $_POST['nama'],
                        $tanggal,
                        $_POST['jenis_kelamin'],
                        $hobi,
                        $_POST['email'],
                        $_POST['no_telp'],
                        $_POST['alamat'],
                        $_POST['nim']
                    ]);

                    if ($result) {
                        echo "<script>
                            alert('Data Berhasil Diperbarui');
                            window.location.href='../frontend/index.php?p=mhs';
                        </script>";
                    }
                }
            } catch(PDOException $e) {
                echo "<script>
                    alert('Data Gagal Diperbarui: " . $e->getMessage() . "');
                    window.location.href='../frontend/index.php?p=mhs';
                </script>";
            }
            break;

        case 'delete':
            try {
                $stmt = $db->prepare("DELETE FROM mahasiswa WHERE nim = ?");
                $result = $stmt->execute([$_GET['nim']]);
                
                if ($result) {
                    echo "<script>
                        alert('Data Berhasil Dihapus');
                        window.location.href='../frontend/index.php?p=mhs';
                    </script>";
                }
            } catch(PDOException $e) {
                echo "<script>
                    alert('Data Gagal Dihapus: " . $e->getMessage() . "');
                    window.location.href='../frontend/index.php?p=mhs';
                </script>";
            }
            break;
    }
}

// Jika tidak ada proses yang valid
$_SESSION['error'] = "Aksi tidak valid";
header('Location: ../frontend/index.php?p=mhs');
exit;
?>



