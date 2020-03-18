<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
$questions = new Apps_Models_Question();
if ($user->isLogin()==false){
    $router->redirect("login");
}

$id = intval($router->getGET("id"));

if ($id) {
    $remover = $questions->buildQueryParams([
        "where" => "id=:id",
        "params" => [
            ":id" => $id
        ]
    ])->Delete();
}
$router->redirect('questions/index');
