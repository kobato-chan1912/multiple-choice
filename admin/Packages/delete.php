<?php


$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
$questions = new Apps_Models_Question();
$package = new Apps_Models_Packages();
$pack = intval($router->getGET("id"));
if ($user->isLogin() == false) {
    $router->redirect("login");
}

$pack = intval($router->getGET("id"));

if ($pack) {
    $remover = $questions->buildQueryParams([
        "where" => "id_package=:pack",
        "params" => [
            ":pack" => $pack
        ]
    ])->Delete();
    $remove2 = $package->buildQueryParams([
        "where" => "id=:id",
        "params" => [
            ":id" => $pack
        ]


    ])->Delete();
}

echo "Đã xoá";

$router->redirect('Packages/index');
