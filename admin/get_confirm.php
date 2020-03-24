<?php
include "../Apps/Libs/encrypte.php";
include "../Apps/bootstrap.php";

require '../Apps/Libs/Exception.php';
require '../Apps/Libs/PHPMailer.php';
require '../Apps/Libs/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$router = new Apps_Libs_Router();
$users = new Apps_Models_users();
$id = $router->getPOST("id");
$OTP = decrypt($router->getPOST('OTP'), $private_secret_key);
$status = 0;


if (($router->getPOST('OTP_submit')) == $OTP) {
    if ($router->getPOST('pass') == $router->getPOST('retype')) {
        $params = [
            ":password" => md5($router->getPOST("pass"))
        ];
        // call the first id in params.
        $params [":id"] = $id;
        $query = $users->buildQueryParams([

                // can't get id here.

            "value" => "password=:password",
            "where" => "id=:id",
            "params" => $params
        ])->update();

        if ($query) {
            $status = 1;

            echo "Pass đã đổi thành công. Về trang chủ trong 3 giây sau.";

        }
    } else {
        $status = 2; //Wrong pass
    }

} else {
    $status = 3; //wrong OTP
}

$json_status = json_encode($status);

?>
<html>
<body>
<script>
    var status = <?php echo $json_status ?>;
    var x = document.getElementById('result');
    if (status == 1) {

        // setTimeOut function the password has been changed.
        // redirect to login page.

        setTimeout(function () {
            window.location.href = "http://192.168.64.2/Quiz-Demo/admin/index.php?r=login";
        }, 3000);
    }
    if (status == 2) {
        x.innerHTML = "Mật khẩu không trùng khớp";
    }
    if (status == 3) {
        x.innerHTML = "Mã OTP không chính xác";
    }


</script>
</body>
</html>
<html>
<body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    var status = <?php echo $json_status ?>;
    if (status == 1) {
        window.location.href = "http://192.168.64.2/Quiz-Demo/admin/index.php";
    }

    //
    //
    //
    //


    (function ($) {
        "use strict";


        /*==================================================================
        [ Validate ]*/
        var input = $('.validate-input .input100');


        var x = document.getElementsByClassName('wrap-input100 validate-input');


        if (status == 3) {
            x[0].classList.add("alert-validate");
        }
        if (status == 2) {
            x[1].classList.add("alert-validate");
        }


        $('.validate-form .input100').each(function () {
            $(this).focus(function () {
                hideValidate(this);
            });
        });


        function hideValidate(input) {
            var thisAlert = $(input).parent();

            $(thisAlert).removeClass('alert-validate');
        }


    })(jQuery);


</script>
</body>
</html>
