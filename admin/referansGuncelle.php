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
$id=$_GET['id'];
$sorgu = $baglanti->prepare("SELECT * FROM referans WHERE id=:id ");
$sorgu->execute(['id'=>$id]);
$sonuc = $sorgu->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $aktif = 0;
    if (isset($_POST["aktif"])) {
        $aktif = 1;
    }

    $hata = "";
    $foto = "";

    if (!empty($_POST["link"]) && !empty($_POST["sira"]) && !empty($_FILES["foto"]["name"])) {
        $hata = "";

        function sanitize_file_name($isimTemizleme)
        {
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
            if (file_exists($dosyaYolu)) {
                unlink($dosyaYolu);
            }
            $foto = $dosyaAdi;

            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $dosyaYolu)) {
                $ekleSorgu = $baglanti->prepare('INSERT INTO referans (foto, link, sira, aktif) VALUES (:foto, :link, :sira, :aktif)');
                $ekle = $ekleSorgu->execute([
                    'foto' => $dosyaAdi,
                    'link' => htmlspecialchars($_POST['link']),
                    'sira' => htmlspecialchars($_POST['sira']),
                    'aktif' => $aktif
                ]);
            }
        }
    } else {
        $foto = $sonuc['foto'];
    }

    if (!empty($_POST["link"]) && !empty($_POST["sira"]) && $hata == '') {
        $sorgu = $baglanti->prepare('UPDATE referans SET foto=:foto, link=:link, sira=:sira, aktif=:aktif WHERE id=:id');
        $guncelle = $sorgu->execute([
            'foto' => $foto,
            'link' => htmlspecialchars($_POST['link']),
            'sira' => htmlspecialchars($_POST['sira']),
            'aktif' => $aktif,
            'id' => $id
        ]);
        if ($guncelle) {
            echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                '<script>' .
                "Swal.fire({title:'Tebrikler', text:'Güncelleme işlemi başarılı', icon:'success', confirmButtonText:'Kapat'})</script>";
        }
    }

    if ($hata != '') {
        echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
            '<script>' .
            "Swal.fire({title:'Hata', text:'" . htmlspecialchars($hata, ENT_QUOTES) . "', icon:'error', confirmButtonText:'Kapat'})</script>";
    }
}


?>

<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Referans Güncelle</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active">Referans Güncelle</li>
        </ol>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <img width="200" src="../assets/img/logos/<?php echo @htmlspecialchars($sonuc['foto']) ?> "><br>
                        <label>Fotoğraf</label>
                        <input type="file" name="foto"  class="form-control-file">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Link</label>
                        <input type="text" name="link" required class="form-control" value="<?php echo @htmlspecialchars($sonuc["link"]) ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Sıra</label>
                        <input type="text" name="sira" required class="form-control" value="<?php echo @htmlspecialchars($sonuc["sira"]) ?>">
                    </div>
                    <div class="form-group form-check" style="margin-top:20px;">
                        <label>
                        <input type="checkbox" name="aktif"  class="form-check-input" <?php echo $sonuc['aktif']==1? 'checked':'' ?>  >Aktiflik Durumu</label>
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
