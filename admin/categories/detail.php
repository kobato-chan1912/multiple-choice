<?php
$categories = new Apps_Models_categories();
$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
if ($user->isLogin()==false){
    $router->redirect("login");
}

// Get ID in URL.
$id = intval($router->getGET("id"));

// Check data in MySQL.

if ($id){
    $cate = $categories->buildQueryParams([

        "where"=>"id=:id",
        "params"=>[
            ":id"=> $id
        ]
    ])->select();
    if (!$cate){
        echo "Page not found";
    }
}
else{
    $cate = array(
        array(
            "name" => "",
            "id" => ""
        )
    );
}



// Submission Condition Checker.

if ($router->getPOST("submit")&&$router->getPOST("name")){
    $params = [
        ":name" => $router->getPOST("name"),
    ];
    if ($id){
        // Tiến hành Update.
        $params [":id"] = $id;
        $result = $categories->buildQueryParams([
            "value" => "name=:name",
            "where" => "id=:id",
            "params" => $params
        ])->update();
    } else {
        //Add new.
        $result = $categories ->buildQueryParams([
            "field" => "(name, created_by, created_time) VALUES (?,?, now())",
            "value" => [$params[":name"], $user->getID()]
        ])->insert();
    }

    if ($result){
        $router->redirect('categories/index');
//        var_dump($result);
    }
    else{
        echo "Error";
    }
}


?>

<html>
<h1>Categories Editor</h1>
<div>
    Welcome, <?php echo $user->Get_Session_Name("username") ?>. <a href="<?= $router->createUrl("logout") ?>">Logout</a>
</div>
<form action="<?= $router->createUrl('categories/detail',["id"=>$cate[0]["id"]]) ?>" method="POST">
    <input type="text" name="name" value="">
    <input type="submit" name="submit" value="Post">
    <a href="<?= $router->createUrl('categories/index') ?>">CANCEL</a>
</form>
</html>


