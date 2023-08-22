<?php
include("../../inc/db.php");
if ($_POST) {
    $alan = $_POST['alan'];

    $deger = $_POST['deger'];
    $tablo = $_POST['tablo'];

    $deger = str_replace('{0}','+',$deger);

    $id = $_POST['id'];

    if ($baglanti->query("UPDATE $tablo SET $alan = '$deger' WHERE id =$id"))
    {
        echo true;
    }
    else
    {
        echo false;
    }
}



?>