<?php
$router = new Apps_Libs_Router();
$id = intval($router->getGET("id"));
$json_id = json_encode($id);
//
//$identity= new Apps_Libs_UserIdentity();
//
//if ($identity->isLogin()==true){
//    $users = new Apps_Models_users();
//    $router = new Apps_Libs_Router();
//    $id = intval($router->getGET("id"));
//
//    $query = $users->buildQueryParams([
//        "select" => "password",
//        "where" => "id=:id",
//        "params" => [
//            "id" => $id
//        ]
//    ])->select();
//
//
//
//if ($router->getPOST("submit")) {
//
//    if ((md5($router->getPOST("old_pass"))) == $query[0]["password"]) {
//        if (($router->getPOST("new_pass")) == $router->getPOST("retype_pass")) {
//            $params = [
//                ":id" => $id,
//                ":password" => md5($router->getPOST("new_pass"))
//            ];
//            $query2 = $users->buildQueryParams([
//                "value" => "password=:password",
//                "where" => "id=:id",
//                "params" => $params
//            ])->update();
//            echo "Đã đổi pass. Về trang chủ sau 3 giây.";
//            header( "refresh:5;url=index.php" );
//
//        } else {
//            echo "Mật khẩu không trùng khớp.";
//        }
//
//    }
//
//
//else {
//        echo "Mật khẩu cũ không đúng.";
//    }
//}
//}
//else{
//    $router->redirect('login');
//}
?>

<!--<html>-->
<!--<body>-->
<!--<form action="" method="post">-->
<!--Nhập pass cũ: <input type="password" name="old_pass">-->
<!--<br>-->
<!--Nhập pass mới: <input type="password" name="new_pass">-->
<!--<br>-->
<!--Nhập lại pass mới: <input type="password" name="retype_pass">-->
<!--    <br>-->
<!--    <input type="submit" name="submit">-->
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
						Thay đổi mật khẩu
					</span>

                <div class="wrap-input100 validate-input" data-validate = "Mật khẩu không trùng khớp">
                    <input class="input100" type="password" name="old_pass" placeholder="Old password" id = "old_pass">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Mật khẩu không trùng khớp">
                    <input class="input100" type="password" name="new_pass" placeholder="New password" id = "new_pass">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Mật khẩu không trùng khớp">
                    <input class="input100" type="password" name="retype_pass" placeholder="Retype" id = "retype_pass">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn" id="submit">
                        Xác nhận
                    </button>
                </div>
                <div class="text-center p-t-19" id="result">
                </div>
                <div id="result"></div>
                <div class="text-center p-t-12">
                    <a class="txt2" href="../public">
                        Trang chủ
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="../admin/index.php?r=registration">
                        Quên mật khẩu?
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

<script>
    $(document).ready(function() {

        $('#submit').click(function()
        {
            var id = <?php echo $json_id ?>;
            var old_pass = document.getElementById("old_pass").value;
            var new_pass = document.getElementById('new_pass').value;
            var retype_pass = document.getElementById('retype_pass').value;
            console.log(old_pass);

            $.ajax({
                method: "POST",
                url: "change_password_confirm.php",
                data: {
                    old_pass: old_pass,
                    new_pass: new_pass,
                    retype_pass: retype_pass,
                    id: id
                },
                success: function(status) {
                    $('#result').html(status);

                }

            });
        });

    });
</script>
</body>
</html>