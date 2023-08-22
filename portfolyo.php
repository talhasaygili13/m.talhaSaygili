<?php
$sayfa="Portfolyo";
include 'inc/db.php';
include 'inc/head.php';

$sorguPortfolyo = $baglanti->prepare("SELECT * FROM portfolyo");
$sorguPortfolyo->execute();
$sonucPortfolyo = $sorguPortfolyo->fetch();
?>

        <!-- Portfolio Grid-->
        <section class="page-section bg-light " id="portfolio">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase mt-3"><?php echo $sonucPortfolyo["baslik"]  ?></h2>
                    <h3 class="section-subheading text-muted"><?php echo $sonucPortfolyo["altBaslik"]  ?></h3>
                </div>
                <div class="row">
                <?php

                    $sorguCalismalar = $baglanti->prepare("SELECT * FROM calismalar WHERE aktif=1 ORDER BY sira");
                    $sorguCalismalar->execute();
                    while($sonucCalismalar = $sorguCalismalar->fetch())
                    {
                ?>
                    <div class="col-lg-4 col-sm-6 mb-4">
                        <div class="portfolio-item">
                            <a class="portfolio-link" data-toggle="modal" href="#portfolioModal<?php echo $sonucCalismalar["id"]  ?>">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="img-fluid" style="width: 350px; height: 300px; " src="assets/img/portfolio/<?php echo $sonucCalismalar["kFoto"]  ?>" alt="" />
                            </a>
                            <div class="portfolio-caption">
                                <div class="portfolio-caption-heading"><?php echo $sonucCalismalar["baslik"]  ?></div>
                                <div class="portfolio-caption-subheading text-muted"><?php echo $sonucCalismalar["kategori"]  ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="portfolio-modal modal fade" id="portfolioModal<?php echo $sonucCalismalar["id"]  ?>" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="close-modal" data-dismiss="modal"><img src="assets/img/close-icon.svg" alt="Close modal" /></div>
                                <div class="container">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-8">
                                            <div class="modal-body">
                                                <!-- Project Details Go Here-->
                                                <h2 class="text-uppercase"><?php echo $sonucCalismalar["baslik"]  ?></h2>
                                                <p class="item-intro text-muted"><?php echo $sonucCalismalar["aciklama"]  ?></p>
                                                <img class="img-fluid d-block mx-auto" src="assets/img/portfolio/<?php echo $sonucCalismalar["bFoto"]  ?>" alt="" />
                                                <p><?php echo $sonucCalismalar["icerik"]  ?></p>
                                                <ul class="list-inline">
                                                    <li>Tarih: <?php echo $sonucCalismalar["tarih"]  ?></li>
                                                    <li>Kategori: <?php echo $sonucCalismalar["kategori"]  ?></li>
                                                </ul>
                                                <button class="btn btn-primary" data-dismiss="modal" type="button">
                                                    <i class="fas fa-times mr-1"></i>
                                                    Projeyi Kapat
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                ?>
                </div>
            </div>
        </section>

        <!-- Footer-->


<?php
include 'inc/footer.php';
?>
