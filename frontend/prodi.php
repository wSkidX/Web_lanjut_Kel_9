<?php 
require_once '../backend/session_check.php';
checkSession();
checkSessionTimeout();

require_once '../backend/koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Program Studi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Program Studi</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Program Studi
        </div>
        <div class="card-body">
            <div class="mb-3">
                <a href="index.php?p=prodi&aksi=input" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Program Studi
                </a>
            </div>
            <table id="tabelProdi" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Program Studi</th>
                        <th>Jenjang</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                try {
                    $stmt = $db->query("SELECT * FROM prodi");
                    $no = 1;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $row['nama_prodi'] ?></td>
                        <td><?= $row['jenjang'] ?></td>
                        <td>
                            <a href="index.php?p=prodi&aksi=edit&id=<?= $row['id'] ?>" 
                               class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="../backend/prosesProdi.php?proses=delete&id=<?= $row['id'] ?>" 
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
    <h1 class="mt-4">Tambah Program Studi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?p=prodi">Program Studi</a></li>
        <li class="breadcrumb-item active">Tambah Program Studi</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
            Form Tambah Program Studi
        </div>
        <div class="card-body">
            <form action="../backend/prosesProdi.php?proses=insert" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Program Studi</label>
                    <input type="text" class="form-control" name="nama_prodi" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <select class="form-select" name="jenjang" required>
                        <option value="">~ Pilih Jenjang ~</option>
                        <?php
                        $jenjang = ['D3','D4','S1','S2'];
                        foreach($jenjang as $jenjangprodi){
                            echo "<option value='".htmlspecialchars($jenjangprodi)."'>".htmlspecialchars($jenjangprodi)."</option>";
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
        $stmt = $dbh->prepare("SELECT * FROM prodi WHERE id = ?");
        $stmt->execute([$_GET['id']]);
        $data_prodi = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Prodi</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?p=prodi">Prodi</a></li>
        <li class="breadcrumb-item active">Edit Prodi</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Form Edit Program Studi
        </div>
        <div class="card-body">
            <form action="../backend/prosesProdi.php?proses=edit" method="post">
                <input type="hidden" name="id" value="<?= htmlspecialchars($data_prodi['id']) ?>">
                <div class="mb-3">
                    <label class="form-label">Nama Prodi</label>
                    <input type="text" class="form-control" name="nama_prodi" 
                           value="<?= htmlspecialchars($data_prodi['nama_prodi']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Jenjang</label>
                    <select class="form-select" name="jenjang" required>
                        <option value="">~ Pilih Jenjang ~</option>
                        <?php
                        $jenjang = ['D3','D4','S1','S2'];
                        foreach($jenjang as $jenjangprodi){
                            $selected = ($data_prodi['jenjang_prodi'] == $jenjangprodi) ? 'selected' : ''; 
                            echo "<option value='".htmlspecialchars($jenjangprodi)."' $selected>".htmlspecialchars($jenjangprodi)."</option>";
                        }
                        ?>
                    </select> 
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="index.php?p=prodi" class="btn btn-secondary">
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
        $('#tabelProdi').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/id.json"
            }
        });
    });
</script>
        

