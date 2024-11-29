<?php
include '../backend/koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Manajemen Mahasiswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Mahasiswa</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Mahasiswa
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="index.php?p=mhs&aksi=input" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Tambah Mahasiswa
                    </a>
                </div>
                <table id="tabelMahasiswa" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Tanggal Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>Hobi</th>
                            <th>Email</th>
                            <th>No Telp</th>
                            <th>Alamat</th>
                            <th>Prodi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        $stmt = $dbh->query("SELECT mahasiswa.*, prodi.nama_prodi 
                                           FROM mahasiswa 
                                           JOIN prodi ON prodi.id = mahasiswa.prodi_id");
                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nim'] ?></td>
                            <td><?= $data['nama_mhs'] ?></td>
                            <td><?= $data['tgl_lahir'] ?></td>
                            <td><?= $data['jekel'] ?></td>
                            <td><?= $data['hobi'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['notelp'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['nama_prodi'] ?></td>
                            <td>
                                <a href="index.php?p=mhs&aksi=edit&nim=<?= $data['nim'] ?>" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="../backend/prosesMahasiswa.php?proses=delete&nim=<?= $data['nim'] ?>" 
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
        <h1 class="mt-4">Tambah Mahasiswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=mhs">Mahasiswa</a></li>
            <li class="breadcrumb-item active">Tambah Mahasiswa</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i>
                Form Tambah Mahasiswa
            </div>
            <div class="card-body">
                <form action="../backend/prosesMahasiswa.php?proses=insert" method="post">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" name="nim" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <div class="row">
                            <div class="col">
                                <select name="tgl" class="form-select" required>
                                    <?php for($i=1; $i<=31; $i++) { ?>
                                        <option value="<?= sprintf("%02d", $i) ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="bln" class="form-select" required>
                                    <?php for($i=1; $i<=12; $i++) { ?>
                                        <option value="<?= sprintf("%02d", $i) ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="thn" class="form-select" required>
                                    <?php for($i=date('Y')-30; $i<=date('Y'); $i++) { ?>
                                        <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jekel" class="form-select" required>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hobi</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobi[]" value="Membaca">
                                <label class="form-check-label">Membaca</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobi[]" value="Olahraga">
                                <label class="form-check-label">Olahraga</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobi[]" value="Traveling">
                                <label class="form-check-label">Traveling</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
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
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">-Pilih Prodi-</option>
                            <?php
                            try {
                                $stmt = $dbh->query("SELECT * FROM prodi");
                                while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $data_prodi['id'] . "'>" . 
                                         $data_prodi['nama_prodi'] . "</option>";
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </select>
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
            $stmt = $dbh->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
            $stmt->execute([$_GET['nim']]);
            $data_mhs = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Memecah tanggal
            $tgl_lahir = explode('-', $data_mhs['tgl_lahir']);
            $hobi_array = explode(',', $data_mhs['hobi']);
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Mahasiswa</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=mhs">Mahasiswa</a></li>
            <li class="breadcrumb-item active">Edit Mahasiswa</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-edit me-1"></i>
                Form Edit Mahasiswa
            </div>
            <div class="card-body">
                <form action="../backend/prosesMahasiswa.php?proses=edit" method="post">
                    <input type="hidden" name="nim" value="<?= $data_mhs['nim'] ?>">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" value="<?= $data_mhs['nim'] ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Mahasiswa</label>
                        <input type="text" class="form-control" name="nama" value="<?= $data_mhs['nama_mhs'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <div class="row">
                            <div class="col">
                                <select name="tgl" class="form-select" required>
                                    <?php for($i=1; $i<=31; $i++) { 
                                        $selected = ($i == intval($tgl_lahir[2])) ? 'selected' : '';
                                    ?>
                                        <option value="<?= sprintf("%02d", $i) ?>" <?= $selected ?>><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="bln" class="form-select" required>
                                    <?php for($i=1; $i<=12; $i++) { 
                                        $selected = ($i == intval($tgl_lahir[1])) ? 'selected' : '';
                                    ?>
                                        <option value="<?= sprintf("%02d", $i) ?>" <?= $selected ?>><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <select name="thn" class="form-select" required>
                                    <?php for($i=date('Y')-30; $i<=date('Y'); $i++) { 
                                        $selected = ($i == intval($tgl_lahir[0])) ? 'selected' : '';
                                    ?>
                                        <option value="<?= $i ?>" <?= $selected ?>><?= $i ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jekel" class="form-select" required>
                            <option value="L" <?= ($data_mhs['jekel'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= ($data_mhs['jekel'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hobi</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobi[]" value="Membaca"
                                       <?= in_array('Membaca', $hobi_array) ? 'checked' : '' ?>>
                                <label class="form-check-label">Membaca</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobi[]" value="Olahraga"
                                       <?= in_array('Olahraga', $hobi_array) ? 'checked' : '' ?>>
                                <label class="form-check-label">Olahraga</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="hobi[]" value="Traveling"
                                       <?= in_array('Traveling', $hobi_array) ? 'checked' : '' ?>>
                                <label class="form-check-label">Traveling</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $data_mhs['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" class="form-control" name="notelp" value="<?= $data_mhs['notelp'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required><?= $data_mhs['alamat'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Prodi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">-Pilih Prodi-</option>
                            <?php
                            try {
                                $stmt = $dbh->query("SELECT * FROM prodi");
                                while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($data_prodi['id'] == $data_mhs['prodi_id']) ? 'selected' : '';
                                    echo "<option value='" . $data_prodi['id'] . "' $selected>" . 
                                         $data_prodi['nama_prodi'] . "</option>";
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary" name="submit">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="index.php?p=mhs" class="btn btn-secondary">
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
        $('#tabelMahasiswa').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });
    });
</script>
