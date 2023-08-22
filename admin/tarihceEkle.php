<?php
$sayfa = "Tarihçe";
include "inc/ahead.php";

if($_SESSION['yetki']!=1){
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>'.
             '<script>'.
             "Swal.fire({title:'Hata', text:'Yetkisiz Kullanıcı', icon:'error', confirmButtonText:'Kapat'}).then((result) => {".
             "if (result.isConfirmed) {".
             "window.location.href='tarihce.php'".
             "}".
             "});".
             '</script>';
             exit;
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hata = "";

    if (!empty($_POST["tarih"]) && !empty($_POST["baslik"]) && !empty($_POST["icerik"]) && !empty($_FILES["foto"]["name"])) {
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
        } elseif (file_exists("../assets/img/about/" . strtolower($dosyaAdi))) {
            $hata .= "Dosya mevcut";
        } elseif ($_FILES["foto"]["size"] > (1024 * 1024)) {
            $hata .= "Dosya boyutu 2 MB'den büyük olamaz!!";
        } elseif (!in_array($_FILES["foto"]["type"], ["image/png", "image/jpg", "image/jpeg"])) {
            $hata .= "Dosya türü kabul edilmiyor. Lütfen sadece geçerli dosya türlerini deneyiniz. (png, jpg, jpeg)";
        } else {
            $dosyaYolu = "../assets/img/about/" . $dosyaAdi;

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $dosyaYolu)) {
                $icerik = htmlspecialchars($_POST['icerik'], ENT_QUOTES);
                $ekleSorgu = $baglanti->prepare('INSERT INTO tarihce (foto, tarih, icerik, baslik) VALUES (:foto, :tarih, :icerik, :baslik)');
                $ekleSorgu->execute([
                    'foto' => $dosyaAdi,
                    'tarih' => htmlspecialchars($_POST['tarih'], ENT_QUOTES),
                    'icerik' => $icerik,
                    'baslik' => htmlspecialchars($_POST['baslik'], ENT_QUOTES)
                ]);

                if ($ekleSorgu) {
                    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                        '<script>' .
                        "Swal.fire({title:'Tebrikler', text:'Ekleme Başarılı', icon:'success', confirmButtonText:'Kapat'}).then((result) => {" .
                        "if (result.isConfirmed) {" .
                        "window.location.href='tarihce.php'" .
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
        <h1 class="mt-4">Tarihçe Ekle</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Tarihçe Ekle</li>
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
                        <label>Tarih</label>
                        <input type="text" name="tarih" required class="form-control" value="<?php echo @htmlspecialchars(@$_POST["tarih"]) ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Başlık</label>
                        <input type="text" name="baslik" required class="form-control" value="<?php echo @htmlspecialchars(@$_POST["baslik"]) ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <script src="js/CKEditor5/ckeditor5-build-classic/ckeditor.js"></script>
                        <label>İçerik</label>
                        <textarea name="icerik" id="icerik"><?php echo @htmlspecialchars(@$_POST["icerik"]) ?></textarea>
                        <script>
                            ClassicEditor
                                .create(document.querySelector('#icerik'))
                                .then(editor => {
                                    console.log(editor);
                                })
                                .catch(error => {
                                    console.error(error);
                                });
                        </script>
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
