<?php
session_start();
if(!(isset($_SESSION["oturum"]) && $_SESSION["oturum"] == "1359")){
    header("Location: login.php");
}
include "../inc/db.php";
?>

<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php echo $sayfa ?> - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Yönetim Paneli</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="kullaniciParolaGuncelleGenel.php">Parola Değiştir</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#" i><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Çıkış</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"  aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Çıkış</h5>
                        <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Çıkış yapmak istediğinize emin misiniz?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                        <a href="logout.php" class="btn btn-danger">Çıkış</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link <?php echo ($sayfa == "Dashboard" ? "active" :"")  ?>" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Sayfalar</div>
                            <a class="nav-link collapsed <?php echo ( $sayfa== "Anasayfa" || $sayfa== "Referanslar" ?"active" :"")  ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Anasayfa
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?php echo ($sayfa== "Anasayfa" ? "active" :"")  ?>" href="anasayfa.php">Anasayfa</a>
                                    <a class="nav-link <?php echo ($sayfa== "Referanslar" ? "active" :"")  ?>" href="referans.php">Referanslar</a>
                                </nav>
                            </div>
                            <?php
                            $sorguOkundu = $baglanti->prepare('SELECT COUNT(*) AS sayi FROM iletisimformu WHERE okundu = :okundu');
                            $sorguOkundu->bindParam(':okundu', $okundu, PDO::PARAM_INT);
                            $okundu = 0;
                            $sorguOkundu->execute();
                            $sonucOkundu = $sorguOkundu->fetch();
                            ?>

                            <a class="nav-link <?php echo ($sayfa== "İletişim Formu" ? "active" :"")  ?>" href="iletisimformu.php">İletişim Formu <span id="okunmaSayisi" class="badge badge-success"> <?php echo @htmlspecialchars(@$sonucOkundu['sayi']) ?> </span> </a>

                            <a class="nav-link collapsed <?php echo ( $sayfa== "Hakkımızda" || $sayfa== "Tarihçe" ?"active" :"")  ?>" href="#" data-bs-toggle="collapse" data-bs-target="#hakkimizda" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Hakkımızda
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="hakkimizda" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link <?php echo ($sayfa== "Hakkımızda" ? "active" :"")  ?>" href="hakkimizda.php">Hakkımızda</a>
                                    <a class="nav-link <?php echo ($sayfa== "Tarihçe" ? "active" :"")  ?>" href="tarihce.php">Tarihçe</a>
                                </nav>
                            </div>
                            <?php if ($_SESSION['yetki'] == '1'){ ?>
                            <a class="nav-link <?php echo ($sayfa== "Kullanıcılar" ? "active" :"")  ?>" href="kullanici.php">Kullanıcılar</a>
                            <?php }?>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Giriş yapan kullanıcı:</div>
                        <?php echo $_SESSION["kadi"]   ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">