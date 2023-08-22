<?php
$sayfa="Hakkımızda";
include 'inc/db.php';
include 'inc/head.php';

$sorguHakkimda = $baglanti->prepare("SELECT * FROM hakkimizda");
$sorguHakkimda->execute();
$sonucHakkimda = $sorguHakkimda->fetch();?>

        <!-- About-->
        <section class="page-section" id="about">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase mt-3"><?php echo $sonucHakkimda["baslik"]   ?></h2>
                    <h3 class="section-subheading text-muted"><?php echo $sonucHakkimda["icerik"]   ?></h3>
                </div>
                <ul class="timeline">
                <?php

                    $sorguTrihce = $baglanti->prepare("SELECT * FROM tarihce");
                    $sorguTrihce->execute();
                    $yon= false;
                    while($sonucTarihce = $sorguTrihce->fetch())
                    {
                ?>
                    <li <?php if($yon==true) echo' class="timeline-inverted"'; ?> >
                        <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/<?php echo $sonucTarihce["foto"]   ?>" alt="" /></div>
                        <div class="timeline-panel">
                            <div class="timeline-heading">
                                <h4><?php echo $sonucTarihce["tarih"]   ?></h4>
                                <h4 class="subheading"><?php echo $sonucTarihce["baslik"]   ?></h4>
                            </div>
                            <div class="timeline-body"><p class="text-muted"><?php echo $sonucTarihce["icerik"]   ?></p></div>
                        </div>
                    </li>
                <?php
                    $yon =! $yon;
                    }
                ?>




                    <li class="timeline-inverted">
                        <div class="timeline-image">
                            <h4>
                                Öğrenmeye
                                <br />
                                Devam
                                <br />
                                Ediyorum
                            </h4>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- Team-->
        <section class="page-section bg-light" id="team">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-heading text-uppercase"><?php echo $sonucHakkimda["altBaslik"]   ?></h2>
                    <h3 class="section-subheading text-muted"><?php echo $sonucHakkimda["altIcerik"]   ?></h3>
                </div>
                <div class="row">
                    <?php
                    $sorguBen = $baglanti->prepare("SELECT * FROM ben");
                    $sorguBen->execute();
                    $sonucBen = $sorguBen->fetch();
                    ?>
                    <div class="col-lg-4">
                        <a href="portfolyo">
                            <div class="team-member" style="text-decoration:none; ">
                                <img class="mx-auto rounded-circle" src="assets/img/team/<?php echo $sonucBen["foto"]   ?>" alt="" />
                                <h4> <?php echo $sonucBen["isim"] ?> </h4>
                                <p class="text-muted"><?php echo $sonucBen["gorev"]   ?></p>
                                <a class="btn btn-dark btn-social mx-2"  target=_blank href="<?php echo $sonucBen["twitter"]   ?>"><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-dark btn-social mx-2"  target=_blank href="<?php echo $sonucBen["instagram"]   ?>"><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-dark btn-social mx-2"  target=_blank href="<?php echo $sonucBen["linkedin"]   ?>"><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </a>
                    </div>

                </div>
                <div class="row">
                </div>
            </div>
        </section>


        <!-- Footer-->
<?php
include 'inc/footer.php';
?>
