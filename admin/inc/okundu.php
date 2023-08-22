<?php
if ($_POST){
    include "../../inc/db.php";
    $id=(int)$_POST['id'];
    $tablo=$_POST['tablo'];

    $sorgu=$baglanti->query("UPDATE $tablo SET okund =1 WHERE id=$id");

    if ($sorgu) echo true;
    else echo false;
}


?>