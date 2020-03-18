<?php
include "../Apps/bootstrap.php";

$router = new Apps_Libs_Router();
$account = $router->getPOST("user");
$password = $router->getPOST("pass");
$identity = new Apps_Libs_UserIdentity();
$status = 0;

function checkUser($name)
{
    $users = new Apps_Models_users();
    $query = $users->buildQueryParams([
        "select" => "*"

    ])->select();
    foreach ($query as $show) {
        if ($show["username"] == $name) return true;
    }
    return false;
}


if ($account && $password) {
    $identity->username = $account;
    $identity->password = $password;

    //identity->check login condition.
    if ($identity->login() == true) { //Đối chiếu trong CSDL.
        $status = 1;
//        $newURL = '../public/index.php';
//        header('Location: '.$newURL);

    } else {
        if (checkUser($identity->username) == true) {
            $status = 2; // wrong pass.
        } else {
            $status = 3; //can't find user.
        }
    }
}
$json_status = json_encode($status);
?>
<html>
<body>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    var status = <?php echo $json_status ?>;
    if (status == 1) {
        window.location.href = "../public/index.php";
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
