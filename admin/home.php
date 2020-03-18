<?php

$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$id = $user->getID();

?>


<?php if ($user->isLogin() == true) { ?>
    <html>
    <head>
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
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" type="text/css" href="../css/particular.css">
    <!--===============================================================================================-->
    </head>
    <body>


    <div class="container-login100">
        <h4>Trang quản lí câu hỏi</h4>
        <div class="play animated fadeInUp delay-2s">

        <a href="<?= $router->createUrl('questions/public_index') ?>">Câu hỏi công khai</a><br>
        <a href="<?= $router->createUrl('Packages/index') ?>">Quản lí gói câu hỏi</a><br>
        <a href="<?= $router->createUrl('request/index') ?>">Nhận/gửi câu hỏi</a><br>
        <a href="<?= $router->createUrl('change_password', ["id" => $id]) ?>">Thay đổi mật khẩu</a><br>
            <a href="<?= $router->createUrl("logout") ?>">Đăng xuất.</a>
        </div>
        <div class="router animated fadeInUp">
            <a class="inherit" href="../public/index.php">
            <i class="fa fa-home" aria-hidden="true"></i></a>
            <a class="inherit" href="<?= $router->createUrl('questions/public_index')?>">
                <i class="fa fa-themeisle" aria-hidden="true"></i></a>
            <a class="inherit" href="<?= $router->createUrl('Packages/index') ?>">
                <i class="fa fa-book" aria-hidden="true"></i></a>
            <a class="inherit" href="<?= $router->createUrl('request/index') ?>">
                <i class="fa fa-send" aria-hidden="true"></i></a>
            <a class="inherit" href="<?= $router->createUrl('change_password') ?>">
                <i class="fa fa-lock" aria-hidden="true"></i></a>
            <a class="inherit" href="<?= $router->createUrl('logout') ?>">
                <i class="fa fa-sign-out" aria-hidden="true"></i></a>
        </div>
    </div>



    </body>
    </html>
<?php } else {
    $router->redirect("login");
}

?>

