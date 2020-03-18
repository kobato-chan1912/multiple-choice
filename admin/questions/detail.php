<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$package = new Apps_Models_Packages();
$questions = new Apps_Models_Question();
$pack = intval($router->getGET("pack"));
$GET_Select = $package->buildSelectBox($user->getID());
$GET_Select2 = $package->buildSelectBoxLimit($user->getID(), $pack);
$status = new Apps_Models_Status();
$Get_Status = $status->buildSelectBox();
// Get any id in URL.
$user_id = intval($router->getGET("user"));

$id_pack = intval($router->getGET("pack"));


//var_dump($GET_Select2);

if ($user->isLogin()==false){
    $router->redirect("login");
}



$id = intval($router->getGET("id")); //get id from question in URL.
if ($id) {
    $ques = $questions->buildQueryParams([
        "where" => "id=:id",
        "params" => [
            ":id" => $id
        ]
    ])->select();

    // When questions varible is error, echo an error page.

    if (!$ques) {
        echo "Page not found";
    }
} else {

    // an empty array.
    $ques = array(
        array(
            "name" => "",
            "id" => ""
        )
    );
}

if ($router->getPOST("submit") && $router->getPOST("name")) {
    $pack_id = $package->getIDPack($router->getPOST("pack"));
    $status_id = $status->getIDStatus($router->getPOST("status"));
    if ($router->getPOST('answer') == $router->getPOST('A_ans') ||
        $router->getPOST('answer') == $router->getPOST('B_ans') ||
        $router->getPOST('answer') == $router->getPOST('C_ans') ||
        $router->getPOST('answer') == $router->getPOST('D_ans')) {

        $params = [
            ":name" => $router->getPOST("name"),
            ":A_ans" => $router->getPOST("A_ans"),
            ":B_ans" => $router->getPOST("B_ans"),
            ":C_ans" => $router->getPOST("C_ans"),
            ":D_ans" => $router->getPOST("D_ans"),
            ":answer" => $router->getPOST("answer"),
            ":id_package" => $pack_id,
            ":Detail" => $router->getPOST("Detail"),

            ":id_status" => $status_id[0]["id"]
        ];
//        var_dump($pack_id);
        if ($id) {
            // When found id in URL -> That means the client clicked the "Edit" button.
            $params [":id"] = $id;
            $result = $questions->buildQueryParams([
                "value" => "name=:name, A_ans=:A_ans, B_ans=:B_ans, C_ans=:C_ans, D_ans=:D_ans,
            answer=:answer, Detail=:Detail, id_package=:id_package, id_status=:id_status",
                "where" => "id=:id",
                "params" => $params
            ])->update();

        } else {

            // insert when not found id in url $=> that means the client clicked the "Add new" Button.
            $result = $questions->buildQueryParams([
                "field" => "(name, A_ans, B_ans, C_ans, D_ans,
            answer, Detail, created_by, id_package, id_status) VALUES (?,?,?,?,?,?,?,?,?,?)",
                "value" => [$params[":name"], $params[":A_ans"], $params[":B_ans"], $params[":C_ans"], $params[":D_ans"],
                    $params[":answer"], $params[":Detail"], $user->getID(), $pack_id[0]["id"], $status_id[0]["id"]]
            ])->insert();

        }
        if ($result) {
           $url = $router->createUrl('Packages/detail', ["id" => $id_pack, "created_by" => $user->getID()]);
           header("Location: $url");
//            if ($router->getGET("id")==0){
//                var_dump("Đây r");
//            }

        } else {
            echo "Error";
        }
    } else {
        echo "Đáp án không trùng khớp với 4 đáp án trắc nghiệm.";
    }
}


?>

<html>
<h1>Questions Managers</h1>
<div>
    Welcome, <?php echo $user->Get_Session_Name("username") ?>. <a href="<?= $router->createUrl("logout") ?>">Logout</a>
</div>
<form action="<?= $router->createUrl('questions/detail',["id"=>$ques[0]["id"], "pack" => $id_pack]) ?>" method="POST">
    <div>
        <?php if ($router->getGET("id")){ ?>
        <?php if ($user->getID() != $ques[0]["created_by"]){

            echo "Bạn không được truy cập trang này.";
        } else { ?>
        Câu hỏi: <input type="text" name="name" value="<?= $ques[0]["name"] ?>"></div>
    <div>Đáp án A: <input type="text" name="A_ans" value="<?= $ques[0]["A_ans"] ?>"></div>
    <div>Đáp án B: <input type="text" name="B_ans" value="<?= $ques[0]["B_ans"] ?>"></div>
    <div>Đáp án C: <input type="text" name="C_ans" value="<?= $ques[0]["C_ans"] ?>"></div>
    <div>Đáp án D: <input type="text" name="D_ans" value="<?= $ques[0]["D_ans"] ?>"></div>
    <div>Đáp án: <input type="text" name="answer" value="<?= $ques[0]["answer"] ?>"></div>
    <div>Giải thích đáp án: <input type="text" name="Detail" value="<?= $ques[0]["Detail"] ?>"></div>

    <select name="pack">
        <?php foreach ($GET_Select as $row) { ?>
            <option value="<?= $row["package_name"] ?>"><?= $row["package_name"] ?></option>
        <?php  } ?>
    </select>
    <select name="status">
        <?php foreach ($Get_Status as $row) { ?>
            <option value="<?= $row["status_name"] ?>"><?= $row["status_name"] ?></option>
        <?php  } ?>
    </select>


    <input type="submit" name="submit" value="Post">
    <a href="<?= $router->createUrl('Packages/detail', ["id" => $id_pack, "created_by" => $user->getID()]) ?>">CANCEL</a>
    <?php  } ?>
    <?php  } ?>
    <?php if (!$router->getGET("id")){ ?>
        Câu hỏi: <input type="text" name="name" value=""></div>
        <div>Đáp án A: <input type="text" name="A_ans" value=""></div>
        <div>Đáp án B: <input type="text" name="B_ans" value=""></div>
        <div>Đáp án C: <input type="text" name="C_ans" value=""></div>
        <div>Đáp án D: <input type="text" name="D_ans" value=""></div>
        <div>Đáp án: <input type="text" name="answer" value=""></div>
        <div>Giải thích đáp án: <input type="text" name="Detail" value=""></div>

        <select name="pack">
            <?php foreach ($GET_Select2 as $row) { ?>
                <option value="<?= $row["package_name"] ?>"><?= $row["package_name"] ?></option>
            <?php  } ?>
        </select>
        <select name="status">
            <?php foreach ($Get_Status as $row) { ?>
                <option value="<?= $row["status_name"] ?>"><?= $row["status_name"] ?></option>
            <?php  } ?>
        </select>


        <input type="submit" name="submit" value="Post">
        <a href="<?= $router->createUrl('Packages/detail', ["id" => $id_pack, "created_by" => $user->getID()])  ?>">CANCEL</a>
        <?php  } ?>

</form>
</html>

