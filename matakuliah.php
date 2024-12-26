<h2>Data Matakuliah</h2>
<table id="example" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>Semester</th>
            <th>Jenis Matakuliah</th>
            <th>SKS</th>
            <th>Jam</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
    <?php
    include 'admin/koneksi.php';
    try {
        $query = "SELECT * FROM matakuliah";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $no = 1;
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['kode_matakuliah'] ?></td>
                <td><?= $data['nama_matakuliah'] ?></td>
                <td><?= $data['semester'] ?></td>
                <td><?= $data['jenis_matakuliah'] ?></td>
                <td><?= $data['sks'] ?></td>
                <td><?= $data['jam'] ?></td>
                <td><?= $data['keterangan'] ?></td>
            </tr>
            <?php
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>
