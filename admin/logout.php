<?php
$user = new Apps_Libs_UserIdentity();
$user->logout();
$router = new Apps_Libs_Router();
$url = "../public/index.php";
header("Location:$url");

