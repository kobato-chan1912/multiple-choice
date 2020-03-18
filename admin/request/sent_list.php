<?php

$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$questions = new Apps_Models_Question();
$packages = new Apps_Models_Packages();

if ($user->isLogin()==false){
    $router->redirect("login");
}

$sender = $user->getID();

$query  =$packages->buildQueryParams([
    "select" => "package_name",
    "inner" => "Packages, request",
    "where" => "request.id_sender= $sender AND request.id_package = Packages.id",

])->inner();

$query2  =$packages->buildQueryParams([
    "select" => "users.username",
    "inner" => "users, request",
    "where" => "request.id_sender = $sender AND users.id = request.id_receiver",

])->inner();


?>



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
    <link rel="stylesheet" type="text/css" href="../css/result2.css">
</head>
<body>
<div class="container-login100">
    <h4>Danh sách gói câu hỏi đã gửi</h4>
    <div class="play animated fadeInUp delay-2s">
        <div class="row col-md-6 col-md-offset-2 custyle">
            <table class="table table-striped custab">
                <tr>
                    <th>Tên gói</th>
                    <th>Người nhận</th>
                </tr>
                <?php for ($i = 0; $i < count($query2);) { ?>
                    <?php foreach ($query as $row) { ?>

                        <tr>
                            <td><?= $row["package_name"] ?></td>
                            <td><?php echo $query2[$i++]["username"] ?></td>
                        </tr>

                    <?php  } ?>
                <?php  } ?>
            </table>
        </div>
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
