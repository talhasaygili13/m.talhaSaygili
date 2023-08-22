<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>CAPTCHA</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
    </style>

</head>
<body>

<br>

<strong>
    Robot olmadığınızı kanıtlamak için görseldeki metni yazın
</strong>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div style='margin:15px'>
        <img src="captcha.php" id="capt">
        <input type=button onClick=reload(); value='Tekrar Yükle'>
    </div>


    <input type="text" name="deger"/>
    <input type="submit" value="Giriş" name="submit"/>
</form>

<div style='margin-top:5px'>
    <?php

    session_start();
    // Kullanıcı bir captcha verdiyse!
    if (isset($_POST['deger']))

        // Captcha geçerliyse
        if ($_POST['deger'] == $_SESSION['captcha'])
            echo '<span style="color:green">BAŞARILI</span>';
        else
            echo '<span style="color:red">CAPTCHA BAŞARISIZ!!!</span>';
    ?>
</div>


<script type="text/javascript">
    function reload() {
        img = document.getElementById("capt");
        img.src = "captcha.php"
    }
</script>

</body>
</html>