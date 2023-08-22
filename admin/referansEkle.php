<?php
$sayfa = "Referanslar";
include "inc/ahead.php";

if($_SESSION['yetki']!=1){
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>'.
             '<script>'.
             "Swal.fire({title:'Hata', text:'Yetkisiz Kullanıcı', icon:'error', confirmButtonText:'Kapat'}).then((result) => {".
             "if (result.isConfirmed) {".
             "window.location.href='referans.php'".
             "}".
             "});".
             '</script>';
             exit;
}




if ($_POST) {
    $aktif=0;
    if (isset($_POST["aktif"])) $aktif=1;

    $hata = "";

if (!empty($_POST["link"]) && !empty($_POST["sira"]) && !empty($_FILES["foto"]["name"])) {
    $hata = "";

    function sanitize_file_name($isimTemizleme)
    {
        // İstenmeyen karakterlerin düzenli ifadeyle temizlenmesi
        $isimTemizleme = preg_replace("/[^a-zA-Z0-9_.-]/", "", $isimTemizleme);
        return $isimTemizleme;
    }

    $dosyaAdi = basename(sanitize_file_name($_FILES["foto"]["name"]));

    if ($_FILES["foto"]["error"] != 0) {
        $hata .= "Dosya yüklenirken hata gerçekleşti!!";
    } elseif (file_exists("../assets/img/logos/" . strtolower($dosyaAdi))) {
        $hata .= "Dosya mevcut";
    } elseif ($_FILES["foto"]["size"] > (1024 * 1024)) {
        $hata .= "Dosya boyutu 2 MB'den büyük olamaz!!";
    } elseif (!in_array($_FILES["foto"]["type"], ["image/png", "image/jpg", "image/jpeg"])) {
        $hata .= "Dosya türü kabul edilmiyor. Lütfen sadece geçerli dosya türlerini deneyiniz. (png, jpg, jpeg)";
    } else {
        $dosyaYolu = "../assets/img/logos/" . $dosyaAdi;

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $dosyaYolu)) {
            $ekleSorgu = $baglanti->prepare('INSERT INTO referans (foto, link, sira, aktif) VALUES (:foto, :link, :sira, :aktif)');
            $ekle = $ekleSorgu->execute([
                'foto' => $dosyaAdi,
                'link' =>htmlspecialchars( $_POST['link']),
                'sira' => htmlspecialchars($_POST['sira']),
                'aktif' => $aktif
            ]);

            if ($ekle) {
                echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                    '<script>' .
                    "Swal.fire({title:'Tebrikler', text:'Ekleme Başarılı', icon:'success', confirmButtonText:'Kapat'}).then((result) => {" .
                    "if (result.isConfirmed) {" .
                    "window.location.href='referans.php'" .
                    "}" .
                    "});" .
                    '</script>';
            } else {
                $hata .= "Veritabanına ekleme sırasında bir hata oluştu.";
            }
        } else {
            $hata .= "Dosya yüklenirken bir hata oluştu.";
        }
    }

    if ($hata != '') {
        echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
            '<script>' .
            "Swal.fire({title:'Hata', text:'" . htmlspecialchars($hata, ENT_QUOTES) . "', icon:'error', confirmButtonText:'Kapat'})</script>";
    }
}
}
?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Referans Ekle</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Referans Ekle</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Fotoğraf</label>
                        <input type="file" name="foto" required class="form-control-file">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Link</label>
                        <input type="text" name="link" required class="form-control" value="<?php echo @htmlspecialchars(@$_POST["link"]) ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Sıra</label>
                        <input type="text" name="sira" required class="form-control" value="<?php echo @htmlspecialchars(@$_POST["sira"]) ?>">
                    </div>
                    <div class="form-group form-check" style="margin-top:20px;">
                        <label>
                        <input type="checkbox" name="aktif"  class="form-check-input">Aktiflik Durumu</label>
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
