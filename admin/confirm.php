<?php
include "../Apps/Libs/encrypte.php";
require '../Apps/Libs/Exception.php';
require '../Apps/Libs/PHPMailer.php';
require '../Apps/Libs/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;



$router = new Apps_Libs_Router();
$users = new Apps_Models_users();
$id = intval($router->getGET("id"));

$query2 = $users->buildQueryParams([
   "select" => "email",
   "where" => "id=:id",
   "params" => [
           ":id" => "$id"
   ]

])->select();
$email = $query2[0]["email"];


function generateRandomString($length = 6) {
    return substr(str_shuffle(str_repeat($x='1234567890', ceil($length/strlen($x)) )),1,$length);
}

$OTP =  generateRandomString();  // OR: generateRandomString(24)

$encrypted_OTP = encrypt($OTP, $private_secret_key);
$json_OTP = json_encode($encrypted_OTP);
$json_id = json_encode($id);

$mail = new PHPMailer(true);
try {
    //Server settings
//    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'gamequizz959@gmail.com';                     // SMTP username
    $mail->Password   = 'mediafire';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('systemtest@gmail.com', 'Quiz Game');
    $mail->addAddress("$email", 'kobato');     // Add a recipient

// Mailer is subject in front.\
    // Joe User is user

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = utf8_encode('Recovery password in Quiz Game');
    $mail->Body    = "Mã xác thực của bạn là: <b>$OTP</b>.";
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Mã xác thực đã được gửi đến mail bạn đăng kí. Vui lòng kiểm tra.';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//if ($router->getPOST("submit")) {
//    if(($router->getPOST('OTP'))==$OTP){
//        if($router->getPOST('pass')==$router->getPOST('retype')){
//            $params = [
//                ":password" => md5($router->getPOST("pass"))
//            ];
//            $params [":id"] = $id;
//            $query = $users->buildQueryParams([
//                    "value" => "password=:password",
//                    "where" => "id=:id",
//                    "params" => $params
//            ])->update();
//            if ($query){
//                echo "Pass đã đổi thành công. Về trang chủ trong 3 giây sau.";
//                header( "refresh:3;url=index.php" );
//            }
//        }
//        else{
//            echo "Pass không trùng";
//        }
//
//    }
//    else{
//        echo "Sai mã OTP.";
//    }
//}
?>

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
						Xác thực tài khoản
					</span>

                <div class="wrap-input100 validate-input" data-validate = "Sai mã OTP">
                    <input class="input100" type="text" name="account" placeholder="Authorization Code" id = "OTP">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Mật khẩu không trùng khớp">
                    <input class="input100" type="password" name="password" placeholder="Password" id = "pass">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Mật khẩu không trùng khớp">
                    <input class="input100" type="password" name="password" placeholder="Password" id = "retype">
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
                <div class="text-center p-t-19" id="result">Mã xác thực đã được gửi đến mail bạn đăng kí. Vui lòng kiểm tra.
                </div>
                <div id="result"></div>
                <div class="text-center p-t-12">
                    <a class="txt2" href="../public">
                        Trang chủ
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
    $(document).ready(function() {

        $('#submit').click(function()
        {

            var OTP = <?php echo $json_OTP ?>;
            var OTP_submit = document.getElementById('OTP').value;
            var pass = document.getElementById('pass').value;
            var retype = document.getElementById('retype').value;
            var id = <?php echo $json_id ?>;
            $.ajax({
                method: "POST",
                url: "get_confirm.php",
                data: {
                    OTP: OTP,
                    pass: pass,
                    retype: retype,
                    OTP_submit: OTP_submit,
                    id: id,
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