<?php

$user = new Apps_Libs_UserIdentity();
$package = new Apps_Models_Packages();
$GET_Select = $package->buildSelectBox($user->getID());
$router = new Apps_Libs_Router();
$session = new Apps_Libs_UserIdentity();
function checkUser ($name){
    $users = new Apps_Models_users();
    $query = $users->buildQueryParams([
        "select" => "*"

    ])->select();
    foreach ($query as $show){
        if ($show["username"] == $name) return true;
    }
    return false;
}
function GetIDUser ($name){
    $users = new Apps_Models_users();
    $query = $users->buildQueryParams([
        "select" => "id",
        "where" => 'username=:username',
        "params" => [
            "username" => $name
        ]
    ])->select();
    return $query[0]["id"];
}
$status = 0;
if ($router->getPOST("submit")){
    $pack = $package->getIDPack($router->getPOST("pack"));
    $pack_id = $pack;
    $sender_id = $session->getID();
    $receiver = $router->getPOST("user");
    if (checkUser($receiver) == false){
            $status = 1;
    }
    else{

        $receiver_id = GetIDUser($receiver);
        $request = new Apps_Models_request();
        $query = $request->buildQueryParams([
            "field" => "(id_sender, id_receiver, id_package) VALUES (?,?,?)",
            "value" => [$sender_id, $receiver_id, $pack_id]

        ])->insert();
//        var_dump($query);
        if ($query){
//            var_dump("Đã gửi thành công request.");
            $temp = $router->createUrl('request/index');
            header("Location: $temp");
        }
    }
}

$json_status = json_encode($status);

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
    <link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">


            <div class="login100-form validate-form">
					<span class="login100-form-title">
						Gửi câu hỏi đi
					</span>

                <form action="<?= $router->createUrl('request/send') ?>" method="post">
                    <div class="wrap-input100 validate-input animated fadeInUp delay-2s" data-validate = "Câu hỏi mới.">
                        Chọn gói câu hỏi:
                        <select name="pack">
                            <?php foreach ($GET_Select as $row) { ?>
                                <option value="<?= $row["package_name"] ?>"><?= $row["package_name"] ?></option>
                            <?php  } ?>
                        </select>
                    </div>

                    <div class="wrap-input100 validate-input animated fadeInUp delay-2s" data-validate = "Câu hỏi mới.">
                        <input class="input100" type="text" name="user" placeholder="Tên người nhận" id = "user">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-question" aria-hidden="true"></i>
						</span>
                    </div>


                    <div class="container-login100-form-btn animated fadeInUp delay-4s">
                        <input type="submit" class="login100-form-btn" name="submit" value="XÁC NHẬN">

                        <!--                        </input>-->
                    </div>
                </form>


                <div class="text-center p-t-19" id="result"></div>

            </div>
        </div>
    </div>
</div>







<!--<form action="--><?//= $router->createUrl('request/send') ?><!--" method="post">-->
<!--    Chọn gói câu gửi:-->
<!--    <select name="pack">-->
<!--        --><?php //foreach ($GET_Select as $row) { ?>
<!--            <option value="--><?//= $row["package_name"] ?><!--">--><?//= $row["package_name"] ?><!--</option>-->
<!--        --><?php // } ?>
<!--    </select>-->
<!--    <br>-->
<!--    Nhập username của người nhận: <input type="text" name="user">-->
<!--    <br>-->
<!--    <input type="submit" name="submit">-->
<!--    -->
<!--</form>-->
<script>
    var status = <?php echo $json_status ?>;
    if (status == 1){
        x = document.getElementById('result');
        x.innerHTML = "Tên người dùng không tồn tại.";
    }
</script>
</body>
</html>
