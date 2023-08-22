<?php
$sayfa = "Referanslar";
include "inc/ahead.php";

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
                <a href="referansEkle.php" class="btn btn-primary">Referans Ekle</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <!-- <th>id</th> -->
                            <th>Fotoğraf</th>
                            <th>Link</th>
                            <th>Sıra</th>
                            <th>Aktif</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sorgu = $baglanti->prepare("SELECT * FROM referans");
                            $sorgu->execute();
                            while($sonuc=$sorgu->fetch()){
                        ?>
                        <tr>
                            <td><?php echo $sonuc["id"]?></td>
                            <td><img width="200" src="../assets/img/logos/<?php echo $sonuc["foto"]?>"
                                    alt=""></td>
                            <td><?php echo @htmlspecialchars($sonuc["link"])?></td>
                            <td><?php echo @htmlspecialchars($sonuc["sira"])?></td>
                            <td>
                                <link href="css/switch.css" rel="stylesheet"/>
                                <label class="switch">
                                    <input type="checkbox" id='<?php echo @htmlspecialchars($sonuc['id']) ?>' class="aktifPasif" <?php echo $sonuc['aktif']==1?'checked':'' ?>  />
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-center">
                                <?php
                                            if($_SESSION['yetki']==1){
                                            ?>
                                <a
                                    href="referansGuncelle.php?id=<?php echo $sonuc["id"]?>">
                                    <div class="d-flex justify-content-center">
                                        <span class="fa fa-edit fa-2x"></span>
                                    </div>
                                </a>
                                <?php
                                            }
                                            ?>
                            </td>
                            <td class="text-center">
                                <?php
                                            if($_SESSION['yetki']==1){
                                            ?>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#silModal<?php echo $sonuc["id"]?>">
                                    <div class="d-flex justify-content-center">
                                        <span
                                            class="fa fa-trash fa-2x text-danger">
                                    </div>
                                </a>
                                <div class="modal fade"
                                    id="silModal<?php echo $sonuc["id"]?>"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="exampleModalLabel">
                                                    Sil</span></h5>
                                                <button class="close"
                                                    type="button"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span
                                                        aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <img width="200" src="../assets/img/logos/<?php echo $sonuc["foto"]?>"
                                                    alt="">
                                                Silmek istediğinizden emin
                                                misiniz?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">İptal</button>
                                                <a href="sil.php?id=<?php echo $sonuc["id"] ?>&tablo=referans"
                                                    class="btn btn-danger">Sil</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                            }
                                            ?>
                            </td>
                        </tr>
                        <?php
                                            }
                                        ?>
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
    $(document).ready(function () {
        $('.aktifPasif').click(function (event) {
            var id = $(this).attr("id");

            var durum = ($(this).is(':checked')) ? '1' : '0';

            $.ajax({
                type: 'POST',
                url: 'inc/aktifPasif.php',
                data: { id:id,tablo:'referans', durum: durum },
                success: function (result) {
                    $('#sonuc').text(result);
                },
                error: function () {
                    alert('Hata');
                }
            });
        });
    });
</script>