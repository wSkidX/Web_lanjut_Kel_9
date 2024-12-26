<h2>Data Mahasiswa</h2>
<table id="example" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Alamat</th>
            <th>Prodi_id</th>
        </tr>
    </thead>
    <tbody>
<?php
// Include koneksi
include 'backend/koneksi.php';

try {
    // Query menggunakan PDO
    $stmt = $db->prepare("SELECT * FROM mahasiswa");
    $stmt->execute();
    $no = 1;

    // Fetch data dan tampilkan di tabel
    while ($data_mhs = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?= $no ?></td>
            <td><?= htmlspecialchars($data_mhs['nim']) ?></td>
            <td><?= htmlspecialchars($data_mhs['nama_mhs']) ?></td>
            <td><?= htmlspecialchars($data_mhs['email']) ?></td>
            <td><?= htmlspecialchars($data_mhs['notelp']) ?></td>
            <td><?= htmlspecialchars($data_mhs['alamat']) ?></td>
            <td><?= htmlspecialchars($data_mhs['prodi_id']) ?></td>
        </tr>
        <?php
        $no++;
    }
} catch (PDOException $e) {
    // Tangani kesalahan
    echo "Error: " . $e->getMessage();
}
?>
</tbody>
</table>
