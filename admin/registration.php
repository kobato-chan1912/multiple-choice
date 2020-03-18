<?php
//$router = new Apps_Libs_Router();
//if ($router->getPOST("submit")){
//    if(checkPass($router->getPOST("pass"), $router->getPOST("retype"))==true &&
//    checkUser($router->getPOST('user'))==true){
//        $users = new Apps_Models_users();
//        $query = $users->buildQueryParams([
//            "field" => "(username, password, email) VALUES (?,?,?)",
//            "value" => [$router->getPOST('user'), md5($router->getPOST('pass')), $router->getPOST("email")]
//        ])->insert();
//        $router->redirect('login');
//    }
//
//    else{
//        echo "Tên tài khoản đã tồn tại hoặc mật khẩu không trùng khớp.";
//    }
//
//}
//
//function checkUser ($name){
//    $users = new Apps_Models_users();
//    $query = $users->buildQueryParams([
//        "select" => "*"
//
//    ])->select();
//    foreach ($query as $show){
//        if ($show["username"] == $name) return false;
//    }
//    return true;
//}
//
//function checkPass ($pass, $retype){
//    if ($pass == $retype) {
//        return true;
//    }
//    return false;
//}



?>



<!--<html>-->
<!--<form action="--><?php //echo $router->createUrl('registration') ?><!--" method="post">-->
<!--<div>username<input type="text" name="user" value=""></div>-->
<!--<div>email<input type="text" name="email" value=""></div>-->
<!--<div>password<input type="password" name="pass" value=""></div>-->
<!--<div>retype password<input type="password" name="retype" value=""></div>-->
<!--<input type="submit" name = 'submit'>-->
<!--</form>-->
<!---->
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
						Đăng kí tài khoản
					</span>

                <div class="wrap-input100 validate-input" data-validate = "Tên đăng nhập đã tồn tại">
                    <input class="input100" type="text" name="user" placeholder="Username" id = "user">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Không phải dạng email">
                    <input class="input100" type="text" name="email" placeholder="Email" id = "email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                </div>
                <div class="wrap-input100 validate-input" data-validate = "Mật khẩu không trùng khớp">
                    <input class="input100" type="password" name="pass" placeholder="Password" id = "pass">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Mật khẩu không trùng khớp">
                    <input class="input100" type="password" name="retype" placeholder="Password" id = "retype">
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

            var user = document.getElementById("user").value;
            var email = document.getElementById('email').value;
            var pass = document.getElementById('pass').value;
            var retype = document.getElementById('retype').value;

            $.ajax({
                method: "POST",
                url: "registration_get.php",
                data: {
                    user: user,
                    email: email,
                    pass: pass,
                    retype: retype
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