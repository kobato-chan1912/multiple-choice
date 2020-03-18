<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$questions = new Apps_Models_Question();
$packages = new Apps_Models_Packages();

if ($user->isLogin()==false){
    $router->redirect("login");
}

//$cate_list = new Apps_Libs_DbConnection();
$query = $packages->buildQueryParams([
    "select" => "*",
    "where" => "created_by=:id",
    "params" => [
        "id" => $user->getID()
    ]
])->select();

//$cate_list_result  =$cate_list->buildQueryParams([
//        "select" => "categories.name",
//        "inner" => "categories, questions",
//        "where" => "categories.id = questions.cate_id",
//        "other" => "questions.id"
//])->inner();
//
//var_dump(($query));



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
    <link rel="stylesheet" type="text/css" href="../css/packages.css">
</head>
<body>
<div class="container-login100">
    <h4>Quản lí gói câu hỏi</h4>
    <div class="play animated fadeInUp delay-2s">
        <a href="<?= $router->createUrl('Packages/create') ?>"><button type="button" class="btn btn-outline-primary">Thêm gói mới</button></a>
        <div class="row col-md-6 col-md-offset-2 custyle">
<!--            <div class="table-wrapper-scroll-y my-custom-scrollbar">-->
            <table class="table table-striped custab">

                <tr>
                    <th>Tên gói</th>
                    <th>Xoá</th>
                </tr>
<?php foreach ($query as $row) { ?>
<tr>

    <td><a href="<?= $router->createUrl('Packages/detail',["id"=>$row["id"], "created_by" => $query[0]["created_by"]]) ?>"><?= $row["package_name"] ?></a></td>
    <td><a href="<?= $router->createUrl('Packages/delete',["id"=>$row["id"], "created_by" => $query[0]["created_by"]]) ?>">Xoá</a></td>
</tr>
<?php  } ?>
            </table>
<!--                </div>-->
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
