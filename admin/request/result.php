<?php

$user = new Apps_Libs_UserIdentity();
$id_session = $user->getID();
$request = new Apps_Models_result();
$query = $request->buildQueryParams([
    "select" => "users.username, Packages.package_name, request_result.points",
    "inner" => "users, Packages, request_result",
    "where" => "users.id = request_result.id_receiver 
    AND Packages.id = request_result.id_package 
    AND request_result.id_sender = $id_session"
])->inner();
$router = new Apps_Libs_Router();


?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../css/result2.css">
</head>
<body>

<div class="container-login100">
    <h4>Kết quả của người nhận</h4>
<div class="play animated fadeInUp delay-2s">
<div class="row col-md-6 col-md-offset-2 custyle">
    <table class="table table-striped custab">
<tr>
    <th>Người nhận</th>
    <th>Gói câu hỏi</th>
    <th>Điểm</th>

</tr>
    <?php foreach ($query as $row) { ?>
<tr>
    <td><?php echo $row["username"] ?></td>
    <td><?php echo $row["package_name"] ?></td>
    <td><?php echo $row["points"] ?></td>

</tr>
    <?php } ?>
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
