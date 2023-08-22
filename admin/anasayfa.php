<?php
$sayfa = "Anasayfa";
include "inc/ahead.php";
$sorgu = $baglanti->prepare("SELECT * FROM anasayfa");
$sorgu->execute();
$sonuc=$sorgu->fetch();
?>
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4"><?php echo $sayfa ?></h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active"><?php echo $sayfa ?></li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>Üst Başlık</th>
                                            <th>Alt Başlık</th>
                                            <th>Link Metin</th>
                                            <th>Link</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td contenteditable="true" onBlur="veriKaydet(this,'ustBaslik','<?php echo  @htmlspecialchars($sonuc["id"]) ?>')"
                                                onClick="duzenle(this);"><?php echo @htmlspecialchars($sonuc["ustBaslik"])?></td>
                                            <td contenteditable="true" onBlur="veriKaydet(this,'altBaslik','<?php echo  @htmlspecialchars($sonuc["id"]) ?>')"
                                                onClick="duzenle(this);"><?php echo @htmlspecialchars($sonuc["altBaslik"])?></td>
                                            <td contenteditable="true" onBlur="veriKaydet(this,'linkMetin','<?php echo  @htmlspecialchars($sonuc["id"]) ?>')"
                                                onClick="duzenle(this);"><?php echo @htmlspecialchars($sonuc["linkMetin"]) ?></td>
                                            <td contenteditable="true" onBlur="veriKaydet(this,'link','<?php echo  @htmlspecialchars($sonuc["id"]) ?>')"
                                                onClick="duzenle(this);"><?php echo @htmlspecialchars($sonuc["link"])?></td>
                                            <td class="text-center">

                                            <?php
                                            if($_SESSION['yetki']==1){
                                            ?>
                                                <a href="anasayfaGuncelle.php?id=<?php echo @htmlspecialchars($sonuc["id"])?>">
                                                    <div class="d-flex justify-content-center">
                                                        <span class="fa fa-edit fa-2x"></span>
                                                    </div>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>


<?php
include "inc/afooter.php";
?>

<script>
    function duzenle(deger) {
        $(deger).css("background", "#d5c218");
    }

    function veriKaydet(deger, alan, id) {
        $(deger).css("background", "#FFF url(yukleniyor.gif) no-repeat right");

        $.ajax({
            url: "inc/duzenleKaydet.php",
            type: "POST",
            data: 'tablo=anasayfa&alan=' + alan + '&deger=' + deger.innerHTML.split('+').join('{0}')+ '&id=' + id,
            success: function (data) {
                if (data == true) {
                    $(deger).css("background", "#fff");
                }

                else {
                    $(deger).css("background", "#f00");
                    $("#sonuc").text("Hata veri düzenlenmedi");
                }
            }
        });
    }
</script>