<?php
$router = new Apps_Libs_Router();
//$account = $router->getPOST("account");
//$password = $router->getPOST("password");
$identity = new Apps_Libs_UserIdentity();
//if ($identity->isLogin()){
//    $router->homepage();
//}
//
//if ($router->getPOST("submit") && $account && $password){
//    $identity->username = $account;
//    $identity->password = $password;
//
//    //identity->check login condition.
//    if ($identity->login()==true){ //Đối chiếu trong CSDL.
//        $newURL = '../public/index.php';
//        header('Location: '.$newURL);
//    }
//    else{
//        echo "Wrong user";
//    }
//}
if ($identity->isLogin()){
    $router->homepage();
}
?>

<?php
// do php stuff

readfile("../html/login.html");


?>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
    $(document).ready(function() {

        $('#submit').click(function()
        {


            var user = document.getElementById('user').value;
            var pass = document.getElementById('pass').value;
            $.ajax({
                method: "POST",
                url: "login_confirm.php",
                data: {
                        user: user,
                        pass: pass
                },
                success: function(status) {
                    $('#result').html(status);

                }

            });
        });

    });



</script>