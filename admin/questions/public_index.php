<?php

$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$questions = new Apps_Models_Question();

if ($user->isLogin()==false){
    $router->redirect("login");
}

//$cate_list = new Apps_Libs_DbConnection();
$query = $questions->buildQueryParams([
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
    <link rel="stylesheet" type="text/css" href="../css/quest_list2.css">
</head>
<body>
<div class="container-login100">
    <nav class="navbar fixed-top navbar-expand-md navbar-light bg-light">
    <h4 class="">Danh sách câu hỏi công khai</h4>
        <div class="router animated fadeInUp ">
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
    </nav>
    <div class="play animated fadeInUp delay-2s">
        <div class="row col-md-6 col-md-offset-2 custyle">
            <table class="table table-striped custab">
        <tr>
            <th>id</th>
            <th>name</th>
            <th>Đáp án A</th>
            <th>Đáp án B</th>
            <th>Đáp án C</th>
            <th>Đáp án D</th>
            <th>Đáp án câu hỏi</th>
            <th>Xoá</th>
        </tr>




        <?php foreach ($query as $row) { ?>

        <tr>

            <td><?= $row["id"] ?></td>
            <td><a href="<?= $router->createUrl('questions/public_detail',["id"=>$row["id"], "user" => $user->getID()]) ?>"><?= $row["name"] ?></a></td>
            <td><?= $row["A_ans"] ?></td>
            <td><?= $row["B_ans"] ?></td>
                <td><?= $row["C_ans"] ?></td>
                <td><?= $row["D_ans"] ?></td>
                <td><?= $row["answer"] ?></td>
            <td><a href="<?= $router->createUrl('questions/public_remove',["id"=>$row["id"], "user" => $user->getID()]) ?>">Delete</a></td>




        </tr>

        <?php } ?>
            </table>
        </div>
    </div>

</div>
</body>
</html>

</body>
</html>
