<?php
$sayfa = "Kullanıcılar";
include "inc/ahead.php";


if ($_POST) {
    if (!empty($_POST["guncelParola"]) && !empty($_POST["parola"]) && !empty($_POST["pTekrar"]) && $_POST['parola'] == $_POST['pTekrar']) {

        $sorgu = $baglanti->prepare("SELECT parola FROM kullanici WHERE kadi=:kadi");
        $sorgu->execute(['kadi' => $_SESSION['kadi']]);
        $sonuc = $sorgu->fetch();

        if ($sonuc['parola'] == md5("20" . $_POST['guncelParola'] . "03")) {
            $guncelleSorgu = $baglanti->prepare('UPDATE kullanici SET parola=:parola WHERE kadi=:kadi');
            $guncelle = $guncelleSorgu->execute([
                'kadi' => @htmlspecialchars($_SESSION['kadi']),
                'parola' => @htmlspecialchars(md5("20" . $_POST['parola'] . "03")),
            ]);

            if ($guncelle) {
                echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                    '<script>' .
                    "Swal.fire({title:'Tebrikler', text:'Güncelleme Başarılı', icon:'success', confirmButtonText:'Kapat'});" .
                    '</script>';
            } else {
                echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                    '<script>' .
                    "Swal.fire({title:'Hata', text:'Bir hata oluştu.Verileri kontrol edip tekrar deneyiniz', icon:'error', confirmButtonText:'Kapat'})</script>";
            }
        }else {
            echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                '<script>' .
                "Swal.fire({title:'Hata', text:'Parolanız Yanlış.', icon:'error', confirmButtonText:'Kapat'})</script>";

        }
    } else {
        echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
            '<script>' .
            "Swal.fire({title:'Hata', text:'Verileri eksiksiz ve doğru girdiğinizden emin olunuz.', icon:'error', confirmButtonText:'Kapat'})</script>";

    }

}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Kullanıcı Parola Güncelle</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Kullanıcı Parola Güncelle</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group" style="margin-top:20px;">
                        <label>Güncel Parola</label>
                        <input type="password" name="guncelParola" required class="form-control">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Parola</label>
                        <input type="password" name="parola" required class="form-control">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Parola Tekrar</label>
                        <input type="password" name="pTekrar" required class="form-control">
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <input type="submit" value="Güncelle" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include "inc/afooter.php";
?>
