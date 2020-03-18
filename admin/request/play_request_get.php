<?php
include "../../Apps/Libs/encrypte.php";
include "../../Apps/bootstrap.php";
$router = new Apps_Libs_Router();

function CheckAns($a = [], $b = [])
{
    $point = 0;
    for ($i = 0; $i < count($a); $i++) {
        if ($a[$i] == $b[$i]) {
            $point++;
        }
    }
    return $point;
}


function GetWrongAns($a = [], $b = [])
{
    $answer_wrong = [];
    for ($i = 0; $i < count($a); $i++) {
        if ($a[$i] != $b[$i]) {
//                    echo ($i);
            array_push($answer_wrong, $i);
        }
    }
    return $answer_wrong;
}

function decrypte_arr($a = [])
{
    $private_secret_key = '1f4276388ad3214c873428dbef42243f';
    $temp = [];
    for ($i = 0; $i < count($a); $i++) {
        $text = decrypt($a[$i], $private_secret_key);
        array_push($temp, $text);
    }
    return $temp;
}

function AddToDB($point)
{
    $identity = new Apps_Libs_UserIdentity();
    $router = new Apps_Libs_Router();
    $sender = intval($router->getGET("sender"));
    $package = intval($router->getGET("pack"));
    $point_query = new Apps_Models_result();
    if ($identity->isLogin()) {
        echo "Đã lưu điểm.";

        $query = $point_query->buildQueryParams([
            "field" => "(id_sender, id_receiver, id_package, points) VALUES (?,?,?,?)",
            "value" => [$router->getPOST("sender"), $identity->getID(), $router->getPOST("pack"), $point]
        ])->insert();
        if ($query) {
            echo "Đã lưu vào dữ liệu.";
        }
    }
}

if (isset($_POST['select'])) {
    $select_arr = $_POST['select'];
    $result_arr = decrypte_arr($_POST['answer']);
    $wrong_arr = GetWrongAns($select_arr, $result_arr);
    $detail_arr = decrypte_arr($_POST['detail']);
    $json_wrong = json_encode($wrong_arr);
    $json_detail = json_encode($detail_arr);
    $json_selected = json_encode($select_arr);

    $point = CheckAns($select_arr, $result_arr);
    echo "<h2> Bạn trả lời đúng $point câu </h2>";

    AddToDB($point);

}

$json_points = json_encode($point);
?>
<html>
<body>
<script>
    var Arr_WrongAns = <?php echo $json_wrong ?>;
    var Arr_Detail = <?php echo $json_detail ?>;
    var Arr_Selected = <?php echo $json_selected ?>;
    var Point = <?php echo $json_points ?>;
    var Point = <?php echo $json_points ?>;

    for (var i = 0; i < Arr_WrongAns.length; i++) {

        var changeElement = document.getElementById("question-" + Arr_WrongAns[i]);
        changeElement.style.color = "red";
    }

    for (var i = 0; i < Arr_Selected.length; i++) {
        if (Arr_Selected[i] == 'NULL') {
            var changeElement = document.getElementById("question-" + i);
            changeElement.style.color = "red";
        }
    }

    function GetHint (){
        for (var i = 0; i < Arr_Detail.length; i++){
            var element = document.getElementById("hint-"+i);
            element.classList.add("alert", "alert-warning");
            var att = document.createAttribute("role");
            att.value = "alert";
            console.log(att);
            element.innerHTML = Arr_Detail[i];

        }
    }

    GetHint();
    var result = document.getElementById("result");
    result.classList.add("alert", "alert-danger");
    result.innerHTML = "Bạn trả lời đúng " + Point + " câu";

</script>
</body>
</html>