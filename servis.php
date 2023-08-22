<?php
$sayfa="Servis";
include 'inc/db.php';
include 'inc/head.php';

$sorguCalisma = $baglanti->prepare("SELECT * FROM servis");
$sorguCalisma->execute();
$sonucCalisma = $sorguCalisma->fetch();
?>

        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase mt-3"><?php echo $sonucCalisma["baslik"]  ?></h2>
                    <h3 class="section-subheading text-muted"><?php echo $sonucCalisma["altBaslik"]  ?></h3>
                </div>
                <div class="row text-center">
                <?php

                    $sorguCalisma = $baglanti->prepare("SELECT * FROM calismalarim WHERE aktif=1 ORDER BY sira");
                    $sorguCalisma->execute();
                    while($sonucCalisma = $sorguCalisma->fetch())
                    {
                ?>
                    <div class="col-md-4">
                        <span class="fa-stack fa-4x">
                            <i class="fas fa-circle fa-stack-2x text-primary"></i>
                            <i class="fas <?php echo $sonucCalisma["foto"]  ?> fa-stack-1x fa-inverse"></i>
                        </span>
                        <h4 class="my-3"><?php echo $sonucCalisma["baslik"]  ?></h4>
                        <p class="text-muted"><?php echo $sonucCalisma["icerik"]  ?></p>
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