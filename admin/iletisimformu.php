<?php
$sayfa = "İletişim Formu";
include "inc/ahead.php";

if (isset($_POST['sil']) && $_SESSION['yetki'] == 1) {
    $silinecekler = implode(', ', $_POST['sil']);
    $sorgu = $baglanti->prepare('DELETE FROM iletisimformu WHERE id IN (' . $silinecekler . ')');
    $sorgu->execute();
}

?>
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4"><?php echo $sayfa ?></h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item active"><?php echo $sayfa ?></li>
        </ol>
        <form action="" method="post">
            <div class="card mb-4">
                <div class="card-header">
                    <?php
                    if ($_SESSION['yetki'] == 1) {
                        ?>
                        <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                           data-bs-target="#silModal">
                            <div class="d-flex justify-content-center">
                                <span style="margin-top: 4px; margin-right: 3px;" class="fa fa-trash"> </span>Seçilenleri
                                Sil
                            </div>
                        </a>
                        <div class="modal fade"
                             id="silModal"
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
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Silmek istediğinizden emin
                                        misiniz?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">İptal
                                        </button>
                                        <button type="submit" class="btn btn-danger  my-3">Seçilenleri Sil</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="tumunuSec" onclick="TumunuSec();" value="">
                            </th>
                            <th>No</th>
                            <th>Ad</th>
                            <th>Email</th>
                            <th>Mesaj</th>
                            <th>Tarih</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sorgu = $baglanti->prepare("SELECT * FROM iletisimformu ORDER BY okundu");
                        $sorgu->execute();
                        while ($sonuc = $sorgu->fetch()) {
                            ?>
                            <tr <?php if ($sonuc['okundu']==0) echo 'class="font-weight-bold"'?>>
                                <td>
                                    <input class="cbSil" type="checkbox" name="sil[]" value="<?= $sonuc['id']; ?>">
                                </td>
                                <td><?php echo @htmlspecialchars($sonuc["id"]) ?></td>
                                <td><?php echo @htmlspecialchars($sonuc["ad"]) ?></td>
                                <td><?php echo @htmlspecialchars($sonuc["mail"]) ?></td>
                                <td>

                                    <a id="<?php echo $sonuc["id"] ?>" class="oku" href="#" data-bs-toggle="modal"
                                       data-bs-target="#okuModal<?php echo $sonuc["id"] ?>">
                                        <div class="d-flex justify-content-center">
                                            <span class="btn btn-outline-primary"> Mesaj için tıklayın</span>
                                        </div>
                                    </a>
                                    <div class="modal fade"
                                         id="okuModal<?php echo $sonuc["id"] ?>"
                                         tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalLabel"
                                         aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLabel">
                                                        Mesaj</span></h5>
                                                    <button class="close"
                                                            type="button"
                                                            data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    <span
                                                            aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php echo $sonuc["mesaj"] ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Kapat
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $sonuc["tarih"] ?></td>
                                <td class="text-center">
                                    <?php
                                    if ($_SESSION['yetki'] == 1) {
                                        ?>
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#silModal<?php echo $sonuc["id"] ?>">
                                            <div class="d-flex justify-content-center">
                                        <span
                                                class="fa fa-trash fa-2x text-danger">
                                            </div>
                                        </a>
                                        <div class="modal fade"
                                             id="silModal<?php echo $sonuc["id"] ?>"
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
                                                                data-bs-dismiss="modal">İptal
                                                        </button>
                                                        <a href="sil.php?id=<?php echo $sonuc["id"] ?>&tablo=iletisimformu"
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
        </form>
    </div>
</main>
<?php
include "inc/afooter.php";
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#tumunuSec').on('click', function () {
            if ($('#tumunuSec:checked').length == $('#tumunuSec').length) {
                $('input.cbSil:checkbox').prop('checked', true);
            } else {
                $('input.cbSil:checkbox').prop('checked', false);

            }
        });
        $('.oku').click(function (event){
            var id   = $(this).attr('id');
            var veri = $(this);
            var sayi = parseInt($('#okunmaSayisi').text());

            $.ajax({
                type:'POST',
                url:'inc/okundu.php',
                data:{id:id, tablo:'iletisimformu'},
                success: function (result){
                    if (result==true){
                        veri.closest('tr').removeClass('font-weight-bold');
                        if (sayi>0)$("#okunmaSayisi").text(sayi-1);
                    }
                }
            })

        })
    });
</script>
