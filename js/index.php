<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="sweetalert2.all.min.js"></script>
</head>
<body>
<form action="index.php" method="post">
    <input type="text" name="a">
    <input type="submit" value="Gönder">

</form>
<?php
if($_POST)
{
    echo '<script>Swal.fire("Başarılı", "Mesajınız bize ulaştı", "success"); </script>';
}
?>
</body>
</html>