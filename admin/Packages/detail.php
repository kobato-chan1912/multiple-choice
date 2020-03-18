<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$questions = new Apps_Models_Question();

if ($user->isLogin() == false) {
    $router->redirect("login");
}
$id = intval($router->getGET("id"));
$created = intval($router->getGET("created_by"));
//var_dump($id);
$query = $questions->buildQueryParams([
    "select" => "*",
    "where" => "id_package=:id",
    "params" => [
        ":id" => $id
    ]
])->select();

//$cate_list_result  =$cate_list->buildQueryParams([
//        "select" => "categories.name",
//        "inner" => "categories, questions",
//        "where" => "categories.id = questions.cate_id",
//        "other" => "questions.id"
//])->inner();

//var_dump(count($query));

$pack = intval($router->getGET("id"));
?>

<?php if ($user->getID() != $created){
    echo "Bạn không thể truy cập trang này.";
} else { ?>

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
<h1>POST Manager</h1>
<div class="container-login100">
    <nav class="navbar fixed-top navbar-expand-md navbar-light bg-light">
        <h4 class="">Danh sách câu hỏi trong gói</h4>
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
        <a href="<?= $router->createUrl('questions/detail', ["pack" => $id]) ?>"><div class="btn btn-outline-primary">Add new</div></a>
    </nav>
    <div class="play animated fadeInUp delay-2s">
        <div class="row col-md-6 col-md-offset-2 custyle">
            <table class="table table-striped custab">

            <tr>
            <td>id</td>
            <td>name</td>
            <td>Đáp án A</td>
            <td>Đáp án B</td>
            <td>Đáp án C</td>
            <td>Đáp án D</td>
            <td>Đáp án câu hỏi</td>
            <td>Xoá</td>
        </tr>


        <?php foreach ($query as $row) { ?>

            <tr>

                <td><?= $row["id"] ?></td>
                <td>
                    <a href="<?= $router->createUrl('questions/detail', ["id" => $row["id"], "user" => $user->getID(), "pack" => $pack]) ?>"><?= $row["name"] ?></a>
                </td>
                <td><?= $row["A_ans"] ?></td>
                <td><?= $row["B_ans"] ?></td>
                <td><?= $row["C_ans"] ?></td>
                <td><?= $row["D_ans"] ?></td>
                <td><?= $row["answer"] ?></td>
                <td><a href="<?= $router->createUrl('questions/remove', ["id" => $row["id"], "user" => $user->getID(), "pack" => $pack]) ?>">Delete</a></td>


            </tr>

        <?php } ?>
            </table>
        </div>
    </div>

</div>
        <?php } ?>
</body>
</html>
