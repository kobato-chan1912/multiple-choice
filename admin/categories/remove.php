<?php
$categories = new Apps_Models_categories();
$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
if ($user->isLogin()==false){
    $router->redirect("login");
}

$id = intval($router->getGET("id"));
if ($id) {
    $remover = $categories->buildQueryParams([
        "where" => "id=:id",
        "params" => [
            ":id" => $id
        ]
    ])->Delete();
}
$router->redirect('categories/index');
