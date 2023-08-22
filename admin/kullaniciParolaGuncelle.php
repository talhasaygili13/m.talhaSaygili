<?php
$sayfa = "Kullanıcılar";
include "inc/ahead.php";

if($_SESSION['yetki']!=1){
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>'.
             '<script>'.
             "Swal.fire({title:'Hata', text:'Yetkisiz Kullanıcı', icon:'error', confirmButtonText:'Kapat'}).then((result) => {".
             "if (result.isConfirmed) {".
             "window.location.href='anasayfa.php'".
             "}".
             "});".
             '</script>';
             exit;
}


$sorgu = $baglanti ->prepare('SELECT * FROM kullanici WHERE id=:id');
$sorgu ->execute(['id' => $_GET['id']]);
$sonuc = $sorgu->fetch();

if ($_POST) {
if (!empty($_POST["kadi"]) && !empty($_POST["parola"]) && !empty($_POST["pTekrar"]) && $_POST['parola'] == $_POST['pTekrar']) {
    $hata = "";

    function sanitize_file_name($isimTemizleme)
    {
        // İstenmeyen karakterlerin düzenli ifadeyle temizlenmesi
        $isimTemizleme = preg_replace("/[^a-zA-Z0-9_.-]/", "", $isimTemizleme);
        return $isimTemizleme;
    }
    $guncelleSorgu = $baglanti->prepare('UPDATE kullanici SET kadi=:kadi, parola=:parola WHERE id=:id');
            $guncelle = $guncelleSorgu->execute([
                'kadi'   =>@htmlspecialchars( $_POST['kadi']),
                'parola' =>@htmlspecialchars(md5("20".$_POST['parola']."03")),
                'id' => $_GET['id']
            ]);

            if ($guncelle) {
                echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                    '<script>' .
                    "Swal.fire({title:'Tebrikler', text:'Güncelleme Başarılı', icon:'success', confirmButtonText:'Kapat'}).then((result) => {" .
                    "if (result.isConfirmed) {" .
                    "window.location.href='kullanici.php'" .
                    "}" .
                    "});" .
                    '</script>';
            } else {
                echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                    '<script>' .
                    "Swal.fire({title:'Hata', text:'Bir hata oluştu.Verileri kontrol edip tekrar deneyiniz', icon:'error', confirmButtonText:'Kapat'})</script>";
            }
        } else {
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
        '<script>' .
        "Swal.fire({title:'Hata', text:'Verileri eksiksiz ve doğru girdiğinizden emin olunuz.', icon:'error', confirmButtonText:'Kapat'})</script>";
        }
} else {
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
        '<script>' .
        "Swal.fire({title:'Hata', text:'Verileri eksiksiz ve doğru girdiğinizden emin olunuz.', icon:'error', confirmButtonText:'Kapat'})</script>";
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Kullanıcı Güncelle</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Kullanıcı Güncelle</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Kullanıcı</label><br>
                        <input type="text" name="kadi" required class="form-control" value="<?php echo @htmlspecialchars($sonuc["kadi"]) ?>">
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
