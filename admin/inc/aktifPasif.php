<?php
if ($_POST){
    include "../../inc/db.php";
}
$id = (int)$_POST['id'];
$durum=(int)$_POST['durum'];
$tablo=$_POST['tablo'];


$sorgu = $baglanti->query("UPDATE $tablo SET aktif=$durum WHERE id=$id");
echo $id . "nolu kayıt değiştirildi"



?>

