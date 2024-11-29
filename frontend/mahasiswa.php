<?php
require_once '../backend/session_check.php';
checkSession();
checkSessionTimeout();

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
                        $stmt = $db->query("SELECT mahasiswa.*, prodi.nama_prodi 
                                           FROM mahasiswa 
                                           JOIN prodi ON prodi.id = mahasiswa.prodi_id");
                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['nim'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['tgl_lahir'] ?></td>
                            <td><?= $data['jenis_kelamin'] ?></td>
                            <td><?= $data['hobi'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['no_telp'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['nama_prodi'] ?></td>
                            <td class="text-center" style="white-space: nowrap;">
                                <div class="btn-group" role="group">
                                    <a href="index.php?p=mhs&aksi=edit&nim=<?= $data['nim'] ?>" 
                                       class="btn btn-warning btn-sm me-1" 
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="../backend/prosesMahasiswa.php?proses=delete&nim=<?= $data['nim'] ?>" 
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
                        <input type="text" class="form-control" name="nim" maxlength="20" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="">-Pilih Jenis Kelamin-</option>
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
                        <input type="email" class="form-control" name="email" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No Telp</label>
                        <input type="text" class="form-control" name="no_telp" maxlength="20" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program Studi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">-Pilih Program Studi-</option>
                            <?php
                            try {
                                $stmt = $db->query("SELECT * FROM prodi ORDER BY nama_prodi");
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
                        <button type="submit" class="btn btn-primary" name="submit">
                            <i class="fas fa-save"></i> Simpan
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
    break;

    case 'edit':
        try {
            $stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
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
                    <input type="hidden" name="nim" value="<?= htmlspecialchars($data_mhs['nim']) ?>">
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($data_mhs['nim']) ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data_mhs['nama']) ?>" maxlength="100" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir" value="<?= htmlspecialchars($data_mhs['tgl_lahir']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select" required>
                            <option value="L" <?= ($data_mhs['jenis_kelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= ($data_mhs['jenis_kelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
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
                        <input type="text" class="form-control" name="no_telp" value="<?= $data_mhs['no_telp'] ?>" required>
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
                                $stmt = $db->query("SELECT * FROM prodi");
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
        
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
