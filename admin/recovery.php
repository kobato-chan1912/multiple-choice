<?php
$router = new Apps_Libs_Router();
$status = 0;

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

if ($router->getPOST("submit-recover")){

    if (checkUser($router->getPOST('user-recover'))==true) {
        $id_recover = GetIDUser($router->getPOST('user-recover'));
        $confirm  = $router->createUrl('confirm', ["id" => $id_recover]);
        header("Location: $confirm");

    }
    else {
        $status = 1;
    }
}

$json_status = json_encode($status);

?>
<?php readfile("../html/recovery.html");
?>
<!--<html>-->
<!--<body>-->
<!--<form action="--><?//echo $router->createUrl('recovery') ?><!--" method="post">-->
<!---->
<!--Nhập tên đăng nhập: <input type="text" name = "user-recover">-->
<!--    <input type="submit" name="submit-recover">-->
<!--</form>-->
<!--</body>-->
<!--</html>-->

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login V1</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="../images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">


            <div class="login100-form validate-form">
					<span class="login100-form-title">
						Xác nhận tài khoản
					</span>

                <form action="<?echo $router->createUrl('recovery') ?>" method="post">
                    <div class="wrap-input100 validate-input" data-validate = "Tên đăng nhập không tồn tại">
                        <input class="input100" type="text" name="user-recover" placeholder="Username" id = "user">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                    </div>


                    <div class="container-login100-form-btn">
                        <input type="submit" class="login100-form-btn" name="submit-recover" value="XÁC NHẬN">

                        <!--                        </input>-->
                    </div>
                </form>


                <div class="text-center p-t-19" id="result"></div>
                <div class="text-center p-t-12">
                    <a class="txt2" href="../admin/index.php?r=login">
                        Đăng nhập
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="../admin/index.php?r=registration">
                        Tạo tài khoản mới
                        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>




<!--===============================================================================================-->
<script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/bootstrap/js/popper.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="../vendor/tilt/tilt.jquery.min.js"></script>

<!--===============================================================================================-->
<!--<script src="../js/main.js"></script>-->
<script>
    var status = <?php echo $json_status ?>;
    if (status == 1){
        x = document.getElementById('result');
        x.innerHTML = "Tên đăng nhập không tồn tại.";
    }
</script>
</body>
</html>


