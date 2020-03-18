<?php
include "../Apps/bootstrap.php";

$identity= new Apps_Libs_UserIdentity();
$status = 0;
//if ($identity->isLogin()==true){

    $users = new Apps_Models_users();
    $router = new Apps_Libs_Router();
    $id = $router->getPOST("id");

    $query = $users->buildQueryParams([
        "select" => "password",
        "where" => "id=:id",
        "params" => [
            "id" => $id
        ]
    ])->select();


    if (md5($router->getPOST("old_pass")) == $query[0]["password"]) {
        if (($router->getPOST("new_pass")) == $router->getPOST("retype_pass")) {
            $params = [
                ":id" => $id,
                ":password" => md5($router->getPOST("new_pass"))
            ];
            $query2 = $users->buildQueryParams([
                "value" => "password=:password",
                "where" => "id=:id",
                "params" => $params
            ])->update();
            echo "Đổi mật khẩu thành công. Về trang chủ sau 3 giây.";
//            header( "refresh:5;url=index.php" );
            $status = 1;
        }
        else {
            echo "Mật khẩu không trùng khớp.";
        }

    }


else {
        echo "Mật khẩu cũ không đúng.";
    }

//}
//else{
//    $router->redirect('login');
//}

$json_status = json_encode($status);

?>
<html>
<body>
<script>
    var status = <?php echo $json_status ?>;
    if (status == 1) {
        setTimeout(function(){
            window.location.href = "index.php";
        }, 3000);
    }
</script>
</body>
</html>
