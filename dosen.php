<h2>Data Dosen</h2>
<table id="example" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Dosen</th>
            <th>Email</th>
            <th>Prodi</th>
            <th>No Telp</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // Include the PDO connection
            include 'backend/koneksi.php';

            // Prepare the SQL query to fetch dosen data with prodi join
            $stmt = $pdo->prepare("SELECT dosen.nip, dosen.nama_dosen, dosen.email, prodi.nama_prodi, dosen.notelp, dosen.alamat
                                   FROM dosen 
                                   INNER JOIN prodi ON prodi.id = dosen.prodi_id");
            $stmt->execute();  // Execute the query

            $no = 1;
            while ($data_dosen = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?= $no++ ?> </td>
            <td><?= htmlspecialchars($data_dosen['nip']) ?> </td>
            <td><?= htmlspecialchars($data_dosen['nama_dosen']) ?> </td>
            <td><?= htmlspecialchars($data_dosen['email']) ?> </td>
            <td><?= htmlspecialchars($data_dosen['nama_prodi']) ?> </td>
            <td><?= htmlspecialchars($data_dosen['notelp']) ?> </td>
            <td><?= htmlspecialchars($data_dosen['alamat']) ?> </td>
        </tr>
        <?php
            }
        ?>
    </tbody>
</table>