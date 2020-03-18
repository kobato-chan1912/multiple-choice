<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$categories = new Apps_Models_categories();

if ($user->isLogin()==false){
    $router->redirect("login");
}


$query = $categories->buildQueryParams([

    "select" => "*",
])->select();
?>
<html>
    <h1>Categories Manager</h1>
    <div>
        Welcome, <?php echo $user->Get_Session_Name("username") ?>. <a href="<?= $router->createUrl("logout") ?>">Logout</a>
    </div>
    <a href="<?= $router->createUrl('categories/detail') ?>">Add new</a>
    <div class="show data">
        <table style="width: 100%" border="1">
            <tr>
                    <td>id</td>
                    <td>name</td>
                    <td>user</td>
                    <td>date</td>
                    <td>delete</td>
            </tr>
            <?php foreach ($query as $row) { ?>
            <tr>

                <td><?= $row["id"] ?></td>
                <td><a href="<?= $router->createUrl('categories/detail',["id"=>$row["id"]]) ?>"><?= $row["name"] ?></a></td>
                <td><?= $row["created_by"] ?></td>
                <td><?= $row["created_time"] ?></td>
                <td><a href="<?= $router->createUrl('categories/remove',["id"=>$row["id"]]) ?>">Delete</a></td>
            </tr>
            <?php  } ?>

        </table>
    </div>
</html>
