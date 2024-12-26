<h2>Data Prodi</h2>
<table id="example" class="table table-striped table bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Prodi ID</th>
            <th>Nama Program Studi</th>
            <th>Jenjang Studi</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include 'admin/koneksi.php';
    try {
        $query = "SELECT * FROM prodi";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $no = 1;
        while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data_prodi['id'] ?></td>
                <td><?= $data_prodi['nama_prodi'] ?></td>
                <td><?= $data_prodi['jenjang_studi'] ?></td>
            </tr>
            <?php
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
    </tbody>
</table>