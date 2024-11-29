<?php
include '../backend/koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Manajemen Matakuliah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Matakuliah</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Matakuliah
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="index.php?p=matakuliah&aksi=input" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Matakuliah
                    </a>
                </div>
                <table id="tabelMatakuliah" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Matakuliah</th>
                            <th>Semester</th>
                            <th>Jenis</th>
                            <th>SKS</th>
                            <th>Jam</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        $stmt = $dbh->query("SELECT * FROM matakuliah");
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
                            <td>
                                <a href="index.php?p=matakuliah&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="../backend/prosesMatakuliah.php?proses=delete&id=<?= $data['id'] ?>" 
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
        <h1 class="mt-4">Tambah Matakuliah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=matakuliah">Matakuliah</a></li>
            <li class="breadcrumb-item active">Tambah Matakuliah</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i>
                Form Tambah Matakuliah
            </div>
            <div class="card-body">
                <form action="../backend/prosesMatakuliah.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">Kode Matakuliah</label>
                        <input type="text" class="form-control" name="kode_matakuliah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" class="form-control" name="nama_matakuliah" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" class="form-control" name="semester" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Matakuliah</label>
                        <select name="jenis_matakuliah" class="form-select" required>
                            <option value="Wajib">Wajib</option>
                            <option value="Pilihan">Pilihan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" class="form-control" name="sks" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
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
            $stmt = $dbh->prepare("SELECT * FROM matakuliah WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $data_mk = $stmt->fetch(PDO::FETCH_ASSOC);
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Matakuliah</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=matakuliah">Matakuliah</a></li>
            <li class="breadcrumb-item active">Edit Matakuliah</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Form Edit Matakuliah
            </div>
            <div class="card-body">
                <form action="../backend/prosesMatakuliah.php?proses=edit" method="post">
                    <input type="hidden" name="id" value="<?= $data_mk['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Kode Matakuliah</label>
                        <input type="text" class="form-control" name="kode_matakuliah" value="<?= $data_mk['kode_matakuliah'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Matakuliah</label>
                        <input type="text" class="form-control" name="nama_matakuliah" value="<?= $data_mk['nama_matakuliah'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Semester</label>
                        <input type="number" class="form-control" name="semester" value="<?= $data_mk['semester'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Matakuliah</label>
                        <select name="jenis_matakuliah" class="form-select" required>
                            <option value="Wajib" <?= ($data_mk['jenis_matakuliah'] == 'Wajib') ? 'selected' : '' ?>>Wajib</option>
                            <option value="Pilihan" <?= ($data_mk['jenis_matakuliah'] == 'Pilihan') ? 'selected' : '' ?>>Pilihan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">SKS</label>
                        <input type="number" class="form-control" name="sks" value="<?= $data_mk['sks'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jam</label>
                        <input type="number" class="form-control" name="jam" value="<?= $data_mk['jam'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" name="keterangan" rows="3"><?= $data_mk['keterangan'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="index.php?p=matakuliah" class="btn btn-secondary">
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
        $('#tabelMatakuliah').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });
    });
</script>