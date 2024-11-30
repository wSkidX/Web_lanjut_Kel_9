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
        <h1 class="mt-4">Manajemen Berita</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Berita</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Berita
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="index.php?p=berita&aksi=input" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Berita
                    </a>
                </div>
                <table id="tabelBerita" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    try {
                        // Cek apakah user sudah login
                        if (!isset($_SESSION['user'])) {
                            header('Location: ../login.php');
                            exit;
                        }

                        // Ambil level user dari database
                        $stmt = $db->prepare("SELECT l.nama_level 
                                             FROM user u 
                                             JOIN level l ON l.id = u.level_id 
                                             WHERE u.id = ?");
                        $stmt->execute([$_SESSION['user']['id']]);
                        $user_level = $stmt->fetch(PDO::FETCH_ASSOC);
                        
                        // Query untuk menampilkan berita
                        if ($user_level['nama_level'] == 'admin') {
                            $stmt = $db->prepare("SELECT b.*, u.nama as penulis, k.nama_kategori 
                                                FROM berita b 
                                                JOIN user u ON u.id = b.user_id 
                                                JOIN kategori k ON k.id = b.kategori_id 
                                                ORDER BY b.created_at DESC");
                            $stmt->execute();
                        } else {
                            $stmt = $db->prepare("SELECT b.*, u.nama as penulis, k.nama_kategori 
                                                FROM berita b 
                                                JOIN user u ON u.id = b.user_id 
                                                JOIN kategori k ON k.id = b.kategori_id 
                                                WHERE b.user_id = ?
                                                ORDER BY b.created_at DESC");
                            $stmt->execute([$_SESSION['user']['id']]);
                        }

                        $no = 1;
                        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= htmlspecialchars($data['judul']) ?></td>
                                <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
                                <td><?= htmlspecialchars($data['penulis']) ?></td>
                                <td><?= date('d/m/Y H:i', strtotime($data['created_at'])) ?></td>
                                <td class="text-center">
                                    <?php if(!empty($data['file_upload'])): ?>
                                        <img src="../backend/uploads/<?= htmlspecialchars($data['file_upload']) ?>" 
                                             alt="<?= htmlspecialchars($data['judul']) ?>"
                                             class="img-thumbnail"
                                             style="max-width: 100px; height: auto;">
                                    <?php else: ?>
                                        <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center" style="white-space: nowrap;">
                                    <div class="btn-group" role="group">
                                        <?php if($user_level['nama_level'] == 'admin' || $_SESSION['user']['id'] == $data['user_id']): ?>
                                            <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" 
                                               class="btn btn-warning btn-sm me-1" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="../backend/prosesBerita.php?proses=delete&id=<?= $data['id'] ?>&file=<?= $data['file_upload'] ?>" 
                                               class="btn btn-danger btn-sm"
                                               onclick="return confirm('Yakin ingin menghapus berita ini?')"
                                               data-bs-toggle="tooltip" 
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        <?php endif; ?>
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
        <h1 class="mt-4">Tambah Berita</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=berita">Berita</a></li>
            <li class="breadcrumb-item active">Tambah Berita</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i>
                Form Tambah Berita
            </div>
            <div class="card-body">
                <form action="../backend/prosesBerita.php?proses=insert" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            try {
                                $stmt = $db->query("SELECT * FROM kategori ORDER BY nama_kategori");
                                while ($kategori = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $kategori['id'] . "'>" . 
                                         htmlspecialchars($kategori['nama_kategori']) . "</option>";
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Gambar</label>
                        <input type="file" class="form-control" name="fileToUpload" accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG. Max: 5MB</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Berita <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="isi_berita" rows="5" required></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="index.php?p=berita" class="btn btn-secondary">
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
            $stmt = $db->prepare("SELECT * FROM berita WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $data_berita = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data_berita) {
                echo "Berita tidak ditemukan";
                exit;
            }
?>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Edit Berita</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="index.php?p=berita">Berita</a></li>
            <li class="breadcrumb-item active">Edit Berita</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Form Edit Berita
            </div>
            <div class="card-body">
                <form action="../backend/prosesBerita.php?proses=edit" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $data_berita['id'] ?>">
                    <input type="hidden" name="old_file" value="<?= $data_berita['file_upload'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" name="judul" 
                               value="<?= htmlspecialchars($data_berita['judul']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <?php
                            try {
                                $stmt = $db->query("SELECT * FROM kategori ORDER BY nama_kategori");
                                while ($kategori = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($kategori['id'] == $data_berita['kategori_id']) ? 'selected' : '';
                                    echo "<option value='" . $kategori['id'] . "' $selected>" . 
                                         htmlspecialchars($kategori['nama_kategori']) . "</option>";
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">File Upload</label>
                        <input type="file" class="form-control" name="fileToUpload" id="file-upload" accept="image/*">
                        <div id="preview-container" class="mt-2">
                            <?php if(!empty($data_berita['file_upload'])): ?>
                                <img src="../backend/uploads/<?= htmlspecialchars($data_berita['file_upload']) ?>" 
                                     alt="Current Image" 
                                     id="file-preview" 
                                     class="img-thumbnail"
                                     style="max-width: 300px;">
                            <?php else: ?>
                                <img src="#" alt="Preview" id="file-preview" style="max-width: 300px; display: none;">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea class="form-control" name="isi_berita" rows="5" required><?= 
                            htmlspecialchars($data_berita['isi_berita']) 
                        ?></textarea>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="index.php?p=berita" class="btn btn-secondary">
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
        $('#tabelBerita').DataTable({
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

    // Preview image before upload
    document.getElementById('file-upload').addEventListener('change', function(e) {
        const preview = document.getElementById('file-preview');
        const file = e.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    });
</script>
