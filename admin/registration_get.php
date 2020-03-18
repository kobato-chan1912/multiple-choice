<?php
include "../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$status = 0;
if (checkUser($router->getPOST('user')) == true) {
    if (checkEmail($router->getPOST('email')) == true) {
        if (checkPass($router->getPOST("pass"), $router->getPOST("retype")) == true)


                    $users = new Apps_Models_users();
        $query = $users->buildQueryParams([
            "field" => "(username, password, email) VALUES (?,?,?)",
            "value" => [$router->getPOST('user'), md5($router->getPOST('pass')), $router->getPOST("email")]
        ])->insert();
        if ($query){
            $status = 1;
            echo "Bạn đã đăng kí thành công. Chuyển sang trang đăng nhập sau 3 giây.";
        }

    }
}

else {
//var_dump(checkPass($router->getPOST("pass"), $router->getPOST("retype")));
//var_dump( checkUser($router->getPOST('user')));
//var_dump(checkEmail($router->getPOST("email")));

    if (checkUser($router->getPOST('user')) == false) {
        $status = 2; //user duplicated.
    } else {
        if (checkEmail($router->getPOST('email')) == false) {
            $status = 3;
            if (checkPass($router->getPOST("pass"), $router->getPOST("retype")) == false) {
                $status = 4; //wrong pass retype.
            }
        }

    }
}

function checkUser($name)
{
    $users = new Apps_Models_users();
    $query = $users->buildQueryParams([
        "select" => "*"

    ])->select();
    foreach ($query as $show) {
        if ($show["username"] == $name) return false;
    }
    return true;
}

function checkPass($pass, $retype)
{
    if ($pass == $retype) {
        return true;
    }
    return false;
}

function checkEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    return true;
}

$json_status = json_encode($status);
?>
<html>
<body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    var status = <?php echo $json_status ?>;
    // console.log(status);
    if (status == 1) {
        setTimeout(function(){
            window.location.href = "http://192.168.64.2/Quiz-Demo/admin/index.php";
        }, 3000);
    }

    (function ($) {
        "use strict";


        /*==================================================================
        [ Validate ]*/
        var input = $('.validate-input .input100');


        var x = document.getElementsByClassName('wrap-input100 validate-input');

        // console.log(status);
        if (status == 2) {
            x[0].classList.add("alert-validate");
        }
        if (status == 3) {
            x[1].classList.add("alert-validate");
        }

        if (status == 4) {
            x[3].classList.add("alert-validate");
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

