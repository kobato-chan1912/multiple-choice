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

var_dump(count($query));



?>



<html>
<h1>Các câu hỏi đang công khai</h1>
<div>
    Welcome, <?php echo $user->Get_Session_Name("username") ?>. <a href="<?= $router->createUrl("logout") ?>">Logout</a>
</div>

<div class="show data">
    <table style="width: 100%" border="1">
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
            <td><a href="<?= $router->createUrl('questions/detail',["id"=>$row["id"], "user" => $user->getID()]) ?>"><?= $row["name"] ?></a></td>
            <td><?= $row["A_ans"] ?></td>
            <td><?= $row["B_ans"] ?></td>
                <td><?= $row["C_ans"] ?></td>
                <td><?= $row["D_ans"] ?></td>
                <td><?= $row["answer"] ?></td>
            <td><a href="<?= $router->createUrl('questions/remove',["id"=>$row["id"], "user" => $user->getID()]) ?>">Delete</a></td>




        </tr>

        <?php } ?>

</html>
