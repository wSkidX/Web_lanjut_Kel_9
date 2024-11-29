<?php
include '../backend/koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Manajemen Dosen</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Dosen</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Dosen
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="index.php?p=dosen&aksi=input" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Tambah Dosen
                    </a>
                </div>
                <table id="tabelDosen" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIP</th>
                            <th>Nama Dosen</th>
                            <th>Email</th>
                            <th>Prodi</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        $stmt = $dbh->query("SELECT dosen.*, prodi.nama_prodi 
                                            FROM dosen 
                                            JOIN prodi ON prodi.id = dosen.prodi_id");
                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['nik']) ?></td>
                            <td><?= htmlspecialchars($data['nama_dosen']) ?></td>
                            <td><?= htmlspecialchars($data['email']) ?></td>
                            <td><?= htmlspecialchars($data['nama_prodi']) ?></td>
                            <td><?= htmlspecialchars($data['notelp']) ?></td>
                            <td><?= htmlspecialchars($data['alamat']) ?></td>
                            <td class="text-center" style="white-space: nowrap;">
                                <div class="btn-group" role="group">
                                    <a href="index.php?p=dosen&aksi=edit&id=<?= $data['id'] ?>" 
                                       class="btn btn-warning btn-sm me-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="../backend/prosesDosen.php?proses=delete&id=<?= $data['id'] ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')"
                                       data-bs-toggle="tooltip" 
                                       title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                        }
                    } catch(PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php
    break;

    case 'input':
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Dosen</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=dosen">Dosen</a></li>
            <li class="breadcrumb-item active">Tambah Dosen</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i>
                Form Tambah Dosen
            </div>
            <div class="card-body">
                <form action="../backend/prosesDosen.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" name="nik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Dosen</label>
                        <input type="text" class="form-control" name="nama_dosen" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">-Pilih Prodi-</option>
                            <?php
                            try {
                                $stmt = $dbh->query("SELECT * FROM prodi");
                                while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $data_prodi['id'] . "'>" . 
                                         htmlspecialchars($data_prodi['nama_prodi']) . "</option>";
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" class="form-control" name="notelp" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-save"></i> Submit</button>
                        <button type="reset" class="btn btn-secondary" name="reset"><i class="fas fa-undo"></i> Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    break;

    case 'edit':
        try {
            $stmt = $dbh->prepare("SELECT * FROM dosen WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $data_dosen = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Dosen</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=dosen">Dosen</a></li>
            <li class="breadcrumb-item active">Edit Dosen</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-edit me-1"></i>
                Form Edit Dosen
            </div>
            <div class="card-body">
                <form action="../backend/prosesDosen.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= $data_dosen['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">NIP</label>
                        <input type="text" class="form-control" name="nik" value="<?= $data_dosen['nik'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Dosen</label>
                        <input type="text" class="form-control" name="nama_dosen" value="<?= $data_dosen['nama_dosen'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $data_dosen['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">-Pilih Prodi-</option>
                            <?php
                            try {
                                $stmt = $dbh->query("SELECT * FROM prodi");
                                while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($data_prodi['id'] == $data_dosen['prodi_id']) ? 'selected' : '';
                                    echo "<option value='" . $data_prodi['id'] . "' $selected>" . 
                                         htmlspecialchars($data_prodi['nama_prodi']) . "</option>";
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" class="form-control" name="notelp" value="<?= $data_dosen['notelp'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required><?= $data_dosen['alamat'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-save"></i> Update</button>
                        <a href="index.php?p=dosen" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    break;
}
?>

<script>
    $(document).ready(function() {
        $('#tabelDosen').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
