<?php
$sayfa="Anasayfa";
include 'inc/db.php';
include 'inc/head.php';

$sorgu = $baglanti->prepare("SELECT * FROM anasayfa");
$sorgu->execute();
$sonuc = $sorgu->fetch();


?>

        <!-- Masthead-->
        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading"><?php echo $sonuc["ustBaslik"] ?></div>
                <div class="masthead-heading text-uppercase"><?php echo $sonuc["altBaslik"] ?></div>
                <a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="<?php echo $sonuc["link"] ?>"><?php echo $sonuc["linkMetin"] ?></a>
            </div>
        </header>
        <!-- Clients-->
        <div class="py-5">
            <div class="container">
                <div class="row">
                        <?php

                            $sorguReferans = $baglanti->prepare("SELECT * FROM referans WHERE aktif=1 ORDER BY sira");
                            $sorguReferans->execute();
                            while($sonucReferans = $sorguReferans->fetch())
                            {
                        ?>
                    <div class="col-md-3 col-sm-6 my-3">
                        <a href="<?php echo $sonucReferans["link"] ?>"><img class="img-fluid d-block mx-auto" src="assets/img/logos/<?php echo $sonucReferans["foto"] ?>" alt="" /></a>
                    </div>
                        <?php
                            }
                        ?>
                </div>
            </div>
        </div>
<?php
include 'inc/footer.php';
?>