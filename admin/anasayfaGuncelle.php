<?php
$sayfa = "Anasayfa";
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



$sorgu = $baglanti->prepare("SELECT * FROM anasayfa WHERE id=:id");
$sorgu->execute(['id' => (int)$_GET['id']]);
$sonuc = $sorgu->fetch();

if ($_POST) {
    $guncelleSorgu = $baglanti->prepare("UPDATE anasayfa SET ustBaslik=:ustBaslik, altBaslik=:altBaslik, linkMetin=:linkMetin, link=:link WHERE id=:id");
    $guncelle = $guncelleSorgu->execute([
        'ustBaslik' => htmlspecialchars($_POST['ustBaslik']),
        'altBaslik' => htmlspecialchars($_POST['altBaslik']),
        'linkMetin' => htmlspecialchars($_POST['linkMetin']),
        'link'      => htmlspecialchars($_POST['link']),
        'id'        => (int)$_GET['id']
    ]);

    if ($guncelle) {
        echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>'.
             '<script>'.
             "Swal.fire({title:'Tebrikler', text:'Güncelleme Başarılı', icon:'success', confirmButtonText:'Kapat'}).then((result) => {".
             "if (result.isConfirmed) {".
             "window.location.href='anasayfa.php'".
             "}".
             "});".
             '</script>';
    }

}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Anasayfa Güncelle</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Anasayfa Güncelle</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label>Üst Başlık</label>
                        <input type="text" name="ustBaslik" required class="form-control" value="<?php echo @htmlspecialchars($sonuc["ustBaslik"]); ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Alt Başlık</label>
                        <input type="text" name="altBaslik" required class="form-control" value="<?php echo @htmlspecialchars($sonuc["altBaslik"]); ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Link Metin</label>
                        <input type="text" name="linkMetin" required class="form-control" value="<?php echo @htmlspecialchars($sonuc["linkMetin"]); ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Link</label>
                        <input type="text" name="link" required class="form-control" value="<?php echo @htmlspecialchars($sonuc["link"]); ?>">
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
