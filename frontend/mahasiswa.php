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
                <div class="mb-3 btn-group-responsive">
                    <a href="index.php?p=mhs&aksi=input" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Tambah Mahasiswa
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="dataMahasiswa" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Hobi</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        try {
                            $stmt = $db->query("SELECT * FROM mahasiswa");
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
                    <div class="form-grid">
                        <div class="mb-3">
                            <label class="form-label">NIM</label>
                            <input type="number" class="form-control" name="nim" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <div class="input-group-custom">
                                <div class="mb-3">
                                    <select class="form-select" name="tgl" required>
                                        <option value="">Tgl</option>
                                        <?php for ($i = 1; $i <= 31; $i++) echo "<option value='$i'>$i</option>"; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="bln" required>
                                        <option value="">Bln</option>
                                        <?php
                                        $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                        foreach ($bulan as $indexbulan => $namabulan) {
                                            echo "<option value='$indexbulan'>$namabulan</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" name="thn" required>
                                        <option value="">Thn</option>
                                        <?php for ($i = date('Y'); $i >= 1900; $i--) echo "<option value='$i'>$i</option>"; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="form-check-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" required>
                                    <label class="form-check-label">Laki-laki</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" required>
                                    <label class="form-check-label">Perempuan</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hobi</label>
                            <div class="form-check-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="Membaca">
                                    <label class="form-check-label">Membaca</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="Olahraga">
                                    <label class="form-check-label">Olahraga</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="hobi[]" value="Travelling">
                                    <label class="form-check-label">Travelling</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Telp</label>
                                <input type="tel" class="form-control" name="no_telp" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control" rows="3" name="alamat" required></textarea>
                        </div>
                        <div class="btn-group-responsive">
                            <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-save"></i> Simpan</button>
                            <button type="reset" class="btn btn-secondary" name="reset"><i class="fas fa-undo"></i> Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    break;

    case 'edit' :
        include '../backend/koneksi.php';
        $stmt = $db->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
        $stmt->execute([$_GET['nim']]);
        $data_mhs = $stmt->fetch(PDO::FETCH_ASSOC);
        $tgl = explode("-", $data_mhs['tgl_lahir']);
        $hobies = explode(",", $data_mhs['hobi']);
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
                        <div class="form-grid">
                            <div class="mb-3">
                                <label class="form-label">NIM</label>
                                <input type="number" class="form-control" name="nim" value="<?= $data_mhs['nim'] ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?= $data_mhs['nama'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <div class="input-group-custom">
                                    <div class="mb-3">
                                        <select class="form-select" name="tgl" required>
                                            <?php
                                            for ($i = 1; $i <= 31; $i++) {
                                                $selected = ($tgl[2] == $i) ? 'selected' : '';
                                                echo "<option value='$i' $selected>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" name="bln" required>
                                            <?php
                                            $bulan = [1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                                            foreach ($bulan as $indexbulan => $namabulan) {
                                                $selected = ($tgl[1] == $indexbulan) ? 'selected' : '';
                                                echo "<option value='$indexbulan' $selected>$namabulan</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <select class="form-select" name="thn" required>
                                            <?php
                                            for ($i = date('Y'); $i >= 1900; $i--) {
                                                $selected = ($tgl[0] == $i) ? 'selected' : '';
                                                echo "<option value='$i' $selected>$i</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="form-check-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="L" <?= ($data_mhs['jenis_kelamin'] == 'L') ? 'checked' : '' ?> required>
                                        <label class="form-check-label">Laki-laki</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" value="P" <?= ($data_mhs['jenis_kelamin'] == 'P') ? 'checked' : '' ?> required>
                                        <label class="form-check-label">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Hobi</label>
                                <div class="form-check-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="hobi[]" value="Membaca" <?php if (in_array('Membaca', $hobies)) echo 'checked' ?>>
                                        <label class="form-check-label">Membaca</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="hobi[]" value="Olahraga" <?php if (in_array('Olahraga', $hobies)) echo 'checked' ?>>
                                        <label class="form-check-label">Olahraga</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="hobi[]" value="Travelling" <?php if (in_array('Travelling', $hobies)) echo 'checked' ?>>
                                        <label class="form-check-label">Travelling</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-grid">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" value="<?= $data_mhs['email'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">No Telp</label>
                                    <input type="tel" class="form-control" name="no_telp" value="<?= $data_mhs['no_telp'] ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <textarea class="form-control" rows="3" name="alamat" required><?= $data_mhs['alamat'] ?></textarea>
                            </div>
                            <div class="btn-group-responsive">
                                <button type="submit" class="btn btn-primary" name="submit"><i class="fas fa-save"></i> Update</button>
                                <a href="index.php?p=mhs" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php 
    break;
}
?>

<script>
    $(document).ready(function() {
        $('#dataMahasiswa').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            },
            columnDefs: [
                { responsivePriority: 1, targets: [1, 2] },  // NIM & Nama
                { responsivePriority: 2, targets: -1 }       // Aksi
            ]
        });
    });
</script>
