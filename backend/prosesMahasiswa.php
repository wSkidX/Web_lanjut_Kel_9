<?php
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
                    
                    $stmt->execute([
                        $_POST['nim'],
                        $_POST['nama'],
                        $tanggal,
                        $_POST['jenis_kelamin'],
                        $hobi,
                        $_POST['email'],
                        $_POST['no_telp'],
                        $_POST['alamat']
                    ]);

                    echo "<script>
                        alert('Data Berhasil Ditambahkan');
                        window.location.href='../frontend/index.php?p=mhs';
                    </script>";
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
                    
                    $stmt->execute([
                        $_POST['nama'],
                        $tanggal,
                        $_POST['jenis_kelamin'],
                        $hobi,
                        $_POST['email'],
                        $_POST['no_telp'],
                        $_POST['alamat'],
                        $_POST['nim']
                    ]);

                    echo "<script>
                        alert('Data Berhasil Diperbarui');
                        window.location.href='../frontend/index.php?p=mhs';
                    </script>";
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
                $stmt->execute([$_GET['nim']]);

                echo "<script>
                    alert('Data Berhasil Dihapus');
                    window.location.href='../frontend/index.php?p=mhs';
                </script>";
            } catch(PDOException $e) {
                echo "<script>
                    alert('Data Gagal Dihapus: " . $e->getMessage() . "');
                    window.location.href='../frontend/index.php?p=mhs';
                </script>";
            }
            break;
    }
}
?>



