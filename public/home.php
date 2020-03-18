<?php
$router = new Apps_Libs_Router();
$identity = new Apps_Libs_UserIdentity();
if ($identity->isLogin()){
    $temp = "Yêu cầu đăng nhập.";
}
else {
    $temp = "";
}


?>

<html>
<head>
    <title>Login V1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/home.css">
    <!--===============================================================================================-->
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <?php if ($identity->isLogin()) { ?>
            <h4>Xin chào, <?= $identity->Get_Session_Name('username') ?>. Chúc bạn chơi vui vẻ!</h4>
        <?php } else{ ?>
        <h4>Chào mừng đến với Quiz World.</h4>
        <?php } ?>
        <div class="play animated fadeInLeft delay-2s">
            <a href="../admin/index.php">Quản lí câu hỏi</a>
            <br>
            <a href="<?= $router->createUrl("random_play") ?>">Chơi ngẫu nhiên</a>
            <br>
            <?php if ($identity->isLogin()) { ?>
                <a href="<?= $router->createUrl("play") ?>">Chơi lưu điểm</a>
                <br>
                <a href="../admin/index.php/?r=logout">Đăng xuất</a>
            <?php } else { ?>
                <a href="../admin/index.php">Chơi lưu điểm (yêu cầu đăng nhập)</a>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>
