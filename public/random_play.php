<?php


include "../Apps/Libs/encrypte.php";


$question = new Apps_Models_Question();
$router = new Apps_Libs_Router();
$query = $question->buildQueryParams([
    "select" => "answer",

])->select();
//var_dump($query[0]["answer"]);

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

//"SELECT * FROM Questions
//ORDER BY RAND ()
//LIMIT 1"

$show = $question->buildQueryParams([
    "select" => "*",
    "other" => "ORDER BY RAND () LIMIT 10"
])->select();


$answer_selected = [];
$answer_result = [];
$answer_detail = [];
foreach ($show as $row) {
    $encrypted = encrypt($row["answer"], $private_secret_key);
    array_push($answer_result, $encrypted);
    $encrypted2 = encrypt($row["Detail"], $private_secret_key);
    array_push($answer_detail, $encrypted2);
}
//var_dump($answer_result);


$json_result = json_encode($answer_result);
$json_detail = json_encode($answer_detail);


//if ($router->getPOST("submit")) {

$number_ques = count($answer_result);


//    var_dump($answer_result);
//    var_dump($answer_selected);

//    var_dump($answer);

//    if ($answer_result == $answer_selected){
//        echo "You got correct all.";
//
//    }
//    else{
//        $point = CheckAns($answer_result, $answer_selected);
//        echo "You Got Right $point/$number_ques";
//
//    }

//}


$i = 0;
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
    <link rel="stylesheet" type="text/css" href="../css/play12.css">
</head>
<body>

<div class="container">
    <!-- partial:index.partial.html -->

    <div id="quiz">
        <nav class="navbar fixed-top navbar-expand-md">
        <h3 id="quiz-name" class="animated fadeInUp delay-2s">Thời gian còn lại: <span id="time">03:00</span></h3><br>
            <div class="router animated fadeInUp">
                <a class="inherit" href="../public/index.php">
                    <i class="fa fa-home" aria-hidden="true"></i></a>
                <a class="inherit" href="<?= $router->createUrl('questions/public_index')?>">
                    <i class="fa fa-themeisle" aria-hidden="true"></i></a>
                <a class="inherit" href="<?= $router->createUrl('Packages/index') ?>">
                    <i class="fa fa-book" aria-hidden="true"></i></a>
                <a class="inherit" href="<?= $router->createUrl('request/index') ?>">
                    <i class="fa fa-send" aria-hidden="true"></i></a>
                <a class="inherit" href="<?= $router->createUrl('change_password') ?>">
                    <i class="fa fa-lock" aria-hidden="true"></i></a>
                <a class="inherit" href="<?= $router->createUrl('logout') ?>">
                    <i class="fa fa-sign-out" aria-hidden="true"></i></a>
            </div>


        </nav>
        <div id="result-out">
            <div id="result" role="alert"></div>
        </div>
        <?php foreach ($show as $row) { ?>
            <div id="question-<?= $i ?>">

                <div class="alert alert-success" role="alert">
                    <?= $row["name"] ?>
                </div>
                <input id="<?= $row["A_ans"] ?>" type="radio" name="choices-<?= $i ?>" value="<?= $row["A_ans"] ?>"><label
                        for="<?= $row["A_ans"] ?>"><?= $row["A_ans"] ?></label><br>
                <input id="<?= $row["B_ans"] ?>" type="radio" name="choices-<?= $i ?>" value="<?= $row["B_ans"] ?>"><label
                        for="<?= $row["B_ans"] ?>"><?= $row["B_ans"] ?></label><br>
                <input id="<?= $row["C_ans"] ?>" type="radio" name="choices-<?= $i ?>" value="<?= $row["C_ans"] ?>"><label
                        for="<?= $row["C_ans"] ?>"><?= $row["C_ans"] ?></label><br>
                <input id="<?= $row["D_ans"] ?>" type="radio" name="choices-<?= $i ?>" value="<?= $row["D_ans"] ?>"><label
                        for="<?= $row["D_ans"] ?>"><?= $row["D_ans"] ?></label>
                <p></p>


                <div id="hint-<?= $i ?>"></div>
            </div>

            <br>
            <?php $i++; ?>
        <?php } ?>
        <div class="button-div">
            <input type="submit" name="submit" id="submit" class="btn btn-success">
            <button type="button" class="btn btn-outline-primary">
                <a href="<?= $router->createUrl("random_play") ?>">Làm mới câu hỏi</a>
            </button>
        </div>
    </div>

    <!-- partial -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>


</div>

</body>

<script type="text/javascript">






    var time_status = 0;
    var click = 0;
    var count = 0;
    // var counter = document.getElementById("counter");
    // counter.innerHTML = count;

        // for (var i =0; i < 10; i++) {
        //     var rates = document.getElementsByName('choices-' + i);
        //     for (var j = 0; j < rates.length; j++) {
        //         rates[j].onclick = function () {
        //             console.log('hi');
        //
        //         }
        //     }
        // }

    function ShowAll() {
        $('#submit').hide();
        document.body.scrollTop = 0;

        var Arr_Result = <?php echo $json_result ?>;

        var Arr_Selected = new Array();

        var Arr_Unselected = new Array();

        var Arr_WrongAns = new Array();

        var Arr_DetailAns = <?php echo $json_detail ?>;

        function getValueBox(rates) {
            for (var j = 0; j < rates.length; j++) {
                if (rates[j].checked) {
                    console.log(rates[j].value);
                    Arr_Selected.push(rates[j].value);
                    return true;
                }
            }
            return false;
        }


        function GetWrongAns(a, b) {
            for (var i = 0; i < b.length; i++) {
                if (a[i] != b[i]) {
                    Arr_WrongAns.push(i);
                }
            }
        }

        for (var i = 0; i < Arr_Result.length;) {
            var rates = document.getElementsByName('choices-' + i);
            if (getValueBox(rates) == false) {
                Arr_Selected.push('NULL');
            }
            i++;
        }
        var unselect_count = 0;
        for (var i = 0; i < Arr_Selected.length; i++) {
            if (Arr_Selected[i] == 'NULL') {
                Arr_Unselected.push(i);
                unselect_count++;
            }
        }
        $.ajax({
            method: "POST",
            url: "random_result.php",
            data: {
                select: Arr_Selected,
                answer: Arr_Result,
                // wrong: Arr_WrongAns,
                detail: Arr_DetailAns

            },
            success: function (status) {
                $('#result').html(status);

            }

        });
    }


    function startTimer(duration, display) {
        var timer = duration, minutes, seconds;
        var time = setInterval(function () {
            minutes = parseInt(timer / 60, 10)
            seconds = parseInt(timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(minutes + ":" + seconds);

            if (--timer < 0) {
                timer = duration;
            }
            if (seconds == 0 && minutes == 0) {
                clearInterval(time);
                time_status = 1;
                $(document).ready(function () {

                    ShowAll();

                });

            }
            if (click == 1){
                clearInterval(time);
            }


        }, 1000);

    }

    jQuery(function ($) {
        var fiveMinutes = 60 * 3,
            display = $('#time');
        startTimer(fiveMinutes, display);

    });


    $(document).ready(function () {


        $('#submit').one('click', function () {
            click = 1;
            ShowAll();


        });


    });


</script>

</body>
</html>