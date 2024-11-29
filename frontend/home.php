<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4 text-primary mb-3">Selamat Datang di Halaman Home</h1>
            <p class="lead text-muted">Nama : Zaki Ramadhan</p>
            <p class="lead text-muted">NIM : 2301082020</p>

        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="info-box bg-gradient-info elevation-3">
                <span class="info-box-icon"><i class="fas fa-users fa-2x"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mahasiswa</span>
                    <span class="info-box-number">
                        <?php
                        $stmt = $db->query("SELECT COUNT(*) as total FROM mahasiswa");
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo number_format($data['total']);
                        ?>
                    </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="info-box bg-gradient-success elevation-3">
                <span class="info-box-icon"><i class="fas fa-graduation-cap fa-2x"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Dosen</span>
                    <span class="info-box-number">
                        <?php
                        $stmt = $db->query("SELECT COUNT(*) as total FROM dosen");
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo number_format($data['total']);
                        ?>
                    </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="info-box bg-gradient-warning elevation-3">
                <span class="info-box-icon"><i class="fas fa-book fa-2x"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Prodi</span>
                    <span class="info-box-number">
                        <?php
                        $stmt = $db->query("SELECT COUNT(*) as total FROM prodi");
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo number_format($data['total']);
                        ?>
                    </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="info-box bg-gradient-danger elevation-3">
                <span class="info-box-icon"><i class="fas fa-newspaper fa-2x"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Berita</span>
                    <span class="info-box-number">
                        <?php
                        $stmt = $db->query("SELECT COUNT(*) as total FROM berita");
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                        echo number_format($data['total']);
                        ?>
                    </span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-gradient-primary text-white">
                    <h3 class="card-title"><i class="fas fa-newspaper mr-2"></i>Berita Terkini</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php
                        $stmt = $db->query("SELECT * FROM berita ORDER BY id DESC LIMIT 6");
                        while ($berita = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm hover-card">
                                    <img src="uploads/<?= $berita['file_upload'] ?>" class="card-img-top" alt="<?= $berita['judul'] ?>" style="height: 200px; object-fit: cover;">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title text-primary"><?= $berita['judul'] ?></h5>
                                        <p class="card-text flex-grow-1"><?= substr($berita['isi_berita'], 0, 100) ?>...</p>
                                        <a href="index.php?p=detail&id=<?= $berita['id'] ?>" class="btn btn-outline-primary mt-auto stretched-link">Baca Selengkapnya</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    .info-box {
        transition: all 0.3s ease;
    }
    .info-box:hover {
        transform: translateY(-5px);
    }
    .progress {
        height: 5px;
        margin-top: 5px;
    }
    .card-img-top {
        transition: all 0.3s ease;
    }
    .hover-card:hover .card-img-top {
        filter: brightness(1.1);
    }
</style>

<script>
    $(document).ready(function() {
        $('.info-box').hover(
            function() {
                $(this).addClass('elevation-5');
            },
            function() {
                $(this).removeClass('elevation-5');
            }
        );

        $('.hover-card').hover(
            function() {
                $(this).find('.btn-outline-primary').removeClass('btn-outline-primary').addClass('btn-primary');
            },
            function() {
                $(this).find('.btn-primary').removeClass('btn-primary').addClass('btn-outline-primary');
            }
        );
    });
</script>

