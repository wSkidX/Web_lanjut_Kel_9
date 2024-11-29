<?php
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>

            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Berita</h1>
            </div>

            <div class="col-2 mb-3">
                <a href="index.php?p=berita&aksi=input" class="btn btn-primary">Tambah Berita</a>
            </div>
            <div class="table-responsive small">
                <table class="table table-bordered table-striped table-sm" id="example">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>User</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $query = "SELECT berita.*, kategori.nama_kategori, user.email 
                                     FROM berita 
                                     INNER JOIN kategori ON kategori.id = berita.kategori_id
                                     INNER JOIN user ON user.user_id = berita.user_id";
                            $stmt = $db->prepare($query);
                            $stmt->execute();
                            $no = 1;
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['judul'] ?></td>
                                    <td><?= $data['nama_kategori'] ?></td>
                                    <td><?= $data['email'] ?></td>
                                    <td><?= $data['created_at'] ?></td>
                                    <td>
                                        <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="proses_berita.php?proses=delete&id=<?= $data['id'] ?>&file=<?= $data['file_upload'] ?>" 
                                           class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">
                                            <i class="bi bi-x-circle"></i> Delete
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

        <?php
        break;

    case 'input':
    ?>
        <div class="col-6 mx-auto">
            <br>
            <h2>Tambah Berita</h2>
            <form action="proses_berita.php?proses=insert" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" class="form-control" name="judul">
                </div>
                <div class="mb-3">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select">
                            <option value="">Pilih Kategori</option>
                            <?php
                            try {
                                $stmt = $db->query("SELECT * FROM kategori");
                                while ($data_kategori = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='" . $data_kategori['id'] . "'>" . $data_kategori['nama_kategori'] . "</option>";
                                }
                            } catch(PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">File Upload</label>
                    <input type="file" class="form-control" name="fileToUpload" id="file-upload">
                </div>

                <img src="#" alt="Preview Uploaded Image" id="file-preview" class="img-fluid mt-2" style="max-width: 300px; display: none;">

                <div class="mb-3">
                    <label class="form-label">Isi Berita</label>
                    <textarea class="form-control" name="isi_berita" rows="5"></textarea>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                </div>
                <hr>
            </form>
        </div>

    <?php
    break;

    case 'edit':
        try {
            $query = "SELECT * FROM berita WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $_GET['id']);
            $stmt->execute();
            $data_berita = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
            <div class="row">
                <div class="col-6 mx-auto">
                    <br>
                    <h2>Edit Berita</h2>
                    <form action="proses_berita.php?proses=edit" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                        <input type="hidden" name="id" value="<?= $data_berita['id'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" value="<?= $data_berita['judul'] ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select">
                                <option value="">Pilih Kategori</option>
                                <?php
                                $stmt_kategori = $db->query("SELECT * FROM kategori");
                                while ($data_kategori = $stmt_kategori->fetch(PDO::FETCH_ASSOC)) {
                                    $selected = ($data_kategori['id'] == $data_berita['kategori_id']) ? 'selected' : '';
                                    echo "<option value='" . $data_kategori['id'] . "' $selected>" . 
                                         $data_kategori['nama_kategori'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">File Upload</label>
                            <input type="file" class="form-control" name="fileToUpload" id="file-upload">
                        </div>
                        <img src="upload/<?= $data_berita['file_upload'] ?>" alt="Preview Uploaded Image" id="file-preview" width="300">

                        <div class="mb-3">
                            <label class="form-label">Isi Berita</label>
                            <textarea class="form-control" name="isi_berita" rows="5"><?= $data_berita['isi_berita'] ?></textarea>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>
                        <hr>
                    </form>
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
        const input = document.getElementById('file-upload');
        const preview = document.getElementById('file-preview');
        
        const previewPhoto = () => {
            const file = input.files;
            if (file) {
                preview.style.display = 'block';
                const fileReader = new FileReader();
                fileReader.onload = function(event) {
                    preview.setAttribute('src', event.target.result);
                }
                fileReader.readAsDataURL(file[0]);
            }
        }
        input.addEventListener("change", previewPhoto);
    </script>

    <script>
        function validateForm() {
            const judul = document.querySelector('input[name="judul"]').value;
            const kategori = document.querySelector('select[name="kategori_id"]').value;
            const isi = document.querySelector('textarea[name="isi_berita"]').value;
            
            if (judul.trim() === '') {
                alert('Judul tidak boleh kosong');
                return false;
            }
            if (kategori === '') {
                alert('Pilih kategori terlebih dahulu');
                return false;
            }
            if (isi.trim() === '') {
                alert('Isi berita tidak boleh kosong');
                return false;
            }
            return true;
        }
    </script>