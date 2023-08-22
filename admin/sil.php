<?php
$sayfa = "";
include "inc/ahead.php";

if($_SESSION['yetki']!=1){
    echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>'.
             '<script>'.
             "Swal.fire({title:'Hata', text:'Yetkisiz Kullanıcı', icon:'error', confirmButtonText:'Kapat'}).then((result) => {".
             "if (result.isConfirmed) {".
             "window.location.href='index.php'".
             "}".
             "});".
             '</script>';
             exit;
}

if($_GET){
    $tablo=$_GET['tablo'];
    $id = (int)$_GET['id'];

    $sorgu = $baglanti->prepare("DELETE FROM $tablo WHERE id=:id");
    $sonuc = $sorgu->execute(["id"=>$id]);
    if($sonuc){
        echo '<script type="text/javascript" src="../js/sweetalert2.all.min.js"></script>'.
        '<script>'.
        "Swal.fire({title:'Başarılı', text:'Silme işlemi başarılı', icon:'success', confirmButtonText:'Kapat'}).then((result) => {".
        "if (result.isConfirmed) {".
        "window.location.href='$tablo.php'".
        "}".
        "});".
        '</script>';
    }

}

include "inc/afooter.php";

?>