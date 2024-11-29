<?php
include '../backend/koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Manajemen Level</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Level</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Level
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="index.php?p=level&aksi=input" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Level
                    </a>
                </div>
                <table id="tabelLevel" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Level</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        $stmt = $dbh->query("SELECT * FROM level");
                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['nama_level']) ?></td>
                            <td><?= htmlspecialchars($data['keterangan']) ?></td>
                            <td>
                                <a href="index.php?p=level&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="../backend/prosesLevel.php?proses=delete&id=<?= $data['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
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
        <h1 class="mt-4">Tambah Level</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=level">Level</a></li>
            <li class="breadcrumb-item active">Tambah Level</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i>
                Form Tambah Level
            </div>
            <div class="card-body">
                <form action="../backend/prosesLevel.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama Level</label>
                        <input type="text" class="form-control" name="nama_level" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">
                            <i class="fas fa-save"></i> Submit
                        </button>
                        <button type="reset" class="btn btn-secondary" name="reset">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php
    break;

    case 'edit':
    try {
        $stmt = $dbh->prepare("SELECT * FROM level WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $data_level = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Level</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=level">Level</a></li>
            <li class="breadcrumb-item active">Edit Level</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Form Edit Level
            </div>
            <div class="card-body">
                <form action="../backend/prosesLevel.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data_level['id']) ?>">
                    <div class="mb-3">
                        <label class="form-label">Nama Level</label>
                        <input type="text" class="form-control" name="nama_level" 
                               value="<?= htmlspecialchars($data_level['nama_level']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" 
                               value="<?= htmlspecialchars($data_level['keterangan']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="index.php?p=level" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
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
        $('#tabelLevel').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });
    });
</script>