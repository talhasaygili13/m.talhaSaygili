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
                <a href="kullaniciEkle.php" class="btn btn-primary">Kullanıcı Ekle</a>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kullanıcı adı </th>
                            <th>Yetki</th>
                            <th>E-mail</th>
                            <th>Aktif</th>
                            <th>Parola<br>Güncelle</th>
                            <th>Güncelle</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sorgu = $baglanti->prepare("SELECT * FROM kullanici");
                            $sorgu->execute();
                            while($sonuc=$sorgu->fetch()){
                        ?>
                        <tr>
                            <td><?php echo @htmlspecialchars($sonuc["kadi"])?></td>
                            <td><?php echo @htmlspecialchars($sonuc["yetki"] == "1" ? "Admin":"Normal kullanıcı")?></td>
                            <td><?php echo @htmlspecialchars($sonuc["email"])?></td>
                            <td>
                                <link href="css/switch.css" rel="stylesheet"/>
                                <label class="switch">
                                    <input type="checkbox" id='<?php echo @htmlspecialchars($sonuc['id']) ?>' class="aktifPasif" <?php echo $sonuc['aktif']==1?'checked':'' ?>  />
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-center">
                                <a
                                    href="kullaniciParolaGuncelle.php?id=<?php echo $sonuc["id"]?>">
                                    <div class="d-flex justify-content-center">
                                        <span class="fa fa-key fa-2x"></span>
                                    </div>
                                </a>
                            </td><td class="text-center">
                                <a
                                        href="kullaniciGuncelle.php?id=<?php echo $sonuc["id"]?>">
                                    <div class="d-flex justify-content-center">
                                        <span class="fa fa-edit fa-2x"></span>
                                    </div>
                                </a>
                            </td>

                            <td class="text-center">

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

                                                Silmek istediğinizden emin
                                                misiniz?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">İptal</button>
                                                <a href="sil.php?id=<?php echo $sonuc["id"] ?>&tablo=kullanici"
                                                    class="btn btn-danger">Sil</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                data: { id:id,tablo:'kullanici', durum: durum },
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
