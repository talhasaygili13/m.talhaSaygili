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
    $aktif=0;
    if (isset($_POST["aktif"])) $aktif=1;

if (!empty($_POST["kadi"]) && !empty($_POST["email"])&& !empty($_POST["yetki"])) {
    $hata = "";

    function sanitize_file_name($isimTemizleme)
    {
        // İstenmeyen karakterlerin düzenli ifadeyle temizlenmesi
        $isimTemizleme = preg_replace("/[^a-zA-Z0-9_.-]/", "", $isimTemizleme);
        return $isimTemizleme;
    }
    $guncelleSorgu = $baglanti->prepare('UPDATE kullanici SET kadi=:kadi,email=:email, aktif=:aktif, yetki=:yetki WHERE id=:id');
            $ekle = $guncelleSorgu->execute([
                'kadi'   =>@htmlspecialchars( $_POST['kadi']),
                'email'  =>@htmlspecialchars( $_POST['email']),
                'yetki'  =>@htmlspecialchars( $_POST['yetki']),
                'aktif'  => $aktif,
                'id'     => $_GET['id']
            ]);

            if ($guncelleSorgu) {
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
                    "Swal.fire({title:'Hata', text:'Bir hata oluştu', icon:'error', confirmButtonText:'Kapat'})</script>";
            }
        } else {
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
        '<script>' .
        "Swal.fire({title:'Hata', text:'Bir hata oluştu', icon:'error', confirmButtonText:'Kapat'})</script>";
        }
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
                        <label>Email</label>
                        <input type="email" name="email" required class="form-control"  value="<?php echo @htmlspecialchars($sonuc["email"]) ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Yetki</label><br>
                        <label><input type="radio" name="yetki" value="1" <?php echo $sonuc['yetki']=='1'?'checked': '' ?> > Admin</label><br>
                        <label><input type="radio" name="yetki" value="2" <?php echo $sonuc['yetki']=='2'?'checked': '' ?> > Normal kullanıcı</label>
                    </div>
                    <div class="form-group form-check" style="margin-top:20px;">
                        <label>
                        <input type="checkbox" name="aktif" <?php echo $sonuc['aktif']=='1'?'checked': '' ?> class="form-check-input">Aktiflik Durumu</label>
                    </div>
                    <div class="form-group" style="margin-top:10px;">
                        <input type="submit" value="Ekle" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
include "inc/afooter.php";
?>
