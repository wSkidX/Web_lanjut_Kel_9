<h1>Berita</h1>

<div class="row">
    <?php
        include 'backend/koneksi.php';

        // Prepare and execute the query to select berita ordered by ID descending
        $stmt = $pdo->prepare("SELECT * FROM berita ORDER BY id DESC");
        $stmt->execute();

        $select_berita = isset($_GET['id']) ? $_GET['id'] : null;

        // Loop through berita data
        while($berita = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // If there's no selected berita or the ID doesn't match the selected one, show the list
            if ($select_berita == null || $berita['id'] != $select_berita) {
    ?>
    <div class="col-4">
        <div class="card" style="width: 18rem;">
        <img src="admin/uploads/<?= htmlspecialchars($berita['file_upload']) ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
            <p class="card-text"><?= htmlspecialchars(substr($berita['isi_berita'], 0, 150)) ?>...</p>
            <a href="index.php?p=home&id=<?= $berita['id'] ?>" class="btn btn-primary">Readmore...</a>
        </div>
        </div>
    </div>
    <?php
            } else {
    ?>
    <div class="card">
        <img src="admin/uploads/<?= htmlspecialchars($berita['file_upload']) ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($berita['judul']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($berita['isi_berita']) ?></p>
            <a href="index.php?p=home" class="btn btn-primary">Back</a>
        </div>
    </div>
    <?php
            }
        }
    ?>
</div>