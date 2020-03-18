<?php

$package = new Apps_Models_Packages();
$router = new Apps_Libs_Router();
$indentity = new Apps_Libs_UserIdentity();

function checkUser ($name){
    $package = new Apps_Models_Packages();
    $query = $package->buildQueryParams([
        "select" => "*"

    ])->select();
    foreach ($query as $show){
        if ($show["package_name"] == $name) return false;
    }
    return true;
}
$status = 0;
if ($router->getPOST("submit")){

    if (checkUser($router->getPOST("package"))==false){
//        echo "Gói câu hỏi mới không được trùng gói sẵn có.";
        $status = 1;
    }
    else {
        $query = $package->buildQueryParams([
            "field" => "(package_name, created_by) VALUES (?,?)",
            "value" => [$router->getPOST("package"), $indentity->getID()]

        ])->insert();
        if ($query) {
            $router->redirect('Packages/index');
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
    <link rel="stylesheet" type="text/css" href="../css/create.css">
</head>
<body>
<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">


            <div class="login100-form validate-form">
					<span class="login100-form-title">
						Tạo gói câu mới
					</span>

                <form action="<?= $router->createUrl('Packages/create') ?>" method="post">
                    <div class="wrap-input100 validate-input animated fadeInUp delay-2s" data-validate = "Câu hỏi mới.">
                        <input class="input100" type="text" name="package" placeholder="Tên gói câu" id = "user">
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






<!--<form action="--><?//= $router->createUrl('Packages/create') ?><!--" method="post">-->
<!--Nhập tên gói câu hỏi: <input type="text" name="package">-->
<!--<input type="submit" name="submit">-->
<!--</form>-->
<script>
    var status = <?php echo $json_status ?>;
    if (status == 1){
        x = document.getElementById('result');
        x.innerHTML = "Gói câu đã tồn tại.";
    }
</script>


</body>
</html>
