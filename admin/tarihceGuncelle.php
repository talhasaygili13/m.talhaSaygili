<?php
$sayfa = "Referanslar";
include "inc/ahead.php";

if ($_SESSION['yetki'] != 1) {
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
        '<script>' .
        "Swal.fire({title:'Hata', text:'Yetkisiz Kullanıcı', icon:'error', confirmButtonText:'Kapat'}).then((result) => {" .
        "if (result.isConfirmed) {" .
        "window.location.href='referans.php';" .
        "}" .
        "});" .
        '</script>';
    exit;
}

$id = $_GET['id'];
$sorgu = $baglanti->prepare("SELECT * FROM tarihce WHERE id=:id");
$sorgu->execute(['id' => $id]);
$sonuc = $sorgu->fetch();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $hata = "";
    $foto = "";

    if (!empty($_POST["tarih"]) && !empty($_POST["baslik"])) {
        $hata = "";

        if (!empty($_FILES["foto"]["name"])) {
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
            } elseif ($_FILES["foto"]["size"] > (2 * 1024 * 1024)) {
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
                    $icerik = @htmlspecialchars($_POST['icerik'], ENT_QUOTES);
                    $ekleSorgu = $baglanti->prepare('UPDATE tarihce SET foto=:foto, tarih=:tarih, icerik=:icerik, baslik=:baslik WHERE id=:id');
                    $ekle = $ekleSorgu->execute([
                        'foto' => $dosyaAdi,
                        'tarih' => htmlspecialchars($_POST['tarih'], ENT_QUOTES),
                        'icerik' => $icerik,
                        'baslik' => htmlspecialchars($_POST['baslik'], ENT_QUOTES),
                        'id' => $id
                    ]);

                    if (!$ekle) {
                        $hata .= "Güncelleme işlemi sırasında bir hata oluştu!";
                    }
                } else {
                    $hata .= "Dosya yüklenirken bir hata oluştu!";
                }
            }
        } else {
            $foto = $sonuc['foto'];
        }

        if ($hata == '') {
            $guncelleSorgu = $baglanti->prepare('UPDATE tarihce SET foto=:foto, tarih=:tarih, baslik=:baslik WHERE id=:id');
            $guncelle = $guncelleSorgu->execute([
                'foto' => $foto,
                'tarih' => htmlspecialchars($_POST['tarih'], ENT_QUOTES),
                'baslik' => htmlspecialchars($_POST['baslik'], ENT_QUOTES),
                'id' => $id
            ]);

            if ($guncelle) {
                echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>' .
                    '<script>' .
                    "Swal.fire({title:'Tebrikler', text:'Güncelleme Başarılı', icon:'success', confirmButtonText:'Kapat'}).then((result) => {" .
                    "if (result.isConfirmed) {" .
                    "window.location.href='tarihce.php'" .
                    "}" .
                    "});" .
                    '</script>';
            }
        }
    } else {
        $hata = "Tarih, başlık ve fotoğraf alanları boş bırakılamaz.";
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
                        <img width="200" src="../assets/img/logos/<?php echo htmlspecialchars($sonuc['foto'], ENT_QUOTES); ?>"><br>
                        <label>Fotoğraf</label>
                        <input type="file" name="foto" class="form-control-file">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Tarih</label>
                        <input type="text" name="tarih" required class="form-control" value="<?php echo htmlspecialchars($sonuc["tarih"], ENT_QUOTES); ?>">
                    </div>
                    <div class="form-group" style="margin-top:20px;">
                        <label>Başlık</label>
                        <input type="text" name="baslik" required class="form-control" value="<?php echo htmlspecialchars($sonuc["baslik"], ENT_QUOTES); ?>">
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
