<?php
require_once 'koneksi.php'; // karena koneksi.php berada di folder yang sama (backend)

if (isset($_GET['proses'])) {
    try {
        switch ($_GET['proses']) {
            case 'insert':
                // Format tanggal
                $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
                // Gabungkan array hobi menjadi string
                $hobies = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';
                
                // Query insert data
                $sql = "INSERT INTO mahasiswa (nim, nama_mhs, tgl_lahir, jekel, hobi, email, notelp, alamat, prodi_id) 
                        VALUES (:nim, :nama, :tgl, :jekel, :hobi, :email, :notelp, :alamat, :prodi_id)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([
                    ':nim' => $_POST['nim'],
                    ':nama' => $_POST['nama'],
                    ':tgl' => $tgl,
                    ':jekel' => $_POST['jekel'],
                    ':hobi' => $hobies,
                    ':email' => $_POST['email'],
                    ':notelp' => $_POST['notelp'],
                    ':alamat' => $_POST['alamat'],
                    ':prodi_id' => $_POST['prodi_id']
                ]);

                header('location:../index.php?p=mhs');
                break;

            case 'edit':
                // Format tanggal
                $tgl = $_POST['thn'] . '-' . $_POST['bln'] . '-' . $_POST['tgl'];
                // Gabungkan array hobi menjadi string
                $hobies = isset($_POST['hobi']) ? implode(",", $_POST['hobi']) : '';
                
                // Query update data
                $sql = "UPDATE mahasiswa SET 
                        nama_mhs = :nama,
                        tgl_lahir = :tgl,
                        jekel = :jekel,
                        hobi = :hobi,
                        email = :email,
                        notelp = :notelp,
                        alamat = :alamat,
                        prodi_id = :prodi_id 
                        WHERE nim = :nim";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([
                    ':nama' => $_POST['nama'],
                    ':tgl' => $tgl,
                    ':jekel' => $_POST['jekel'],
                    ':hobi' => $hobies,
                    ':email' => $_POST['email'],
                    ':notelp' => $_POST['notelp'],
                    ':alamat' => $_POST['alamat'],
                    ':prodi_id' => $_POST['prodi_id'],
                    ':nim' => $_POST['nim']
                ]);

                header('location:../index.php?p=mhs');
                break;

            case 'delete':
                // Query delete data
                $sql = "DELETE FROM mahasiswa WHERE nim = :nim";
                $stmt = $dbh->prepare($sql);
                $stmt->execute([':nim' => $_GET['nim']]);

                header('location:../index.php?p=mhs');
                break;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
