<?php

//$a = [1, 2, 3, 4];
//$b = [1, 2, 3, 4, 5];
//$a_length = count($a);
//for ($i = 0; $i < count($b); $i++) {
//    if ($i > count($a)-1) {
//        array_push($a, "NULL");
//    }
//
//}
//var_dump($a);
//
?>

<html>
<body>
<div id="quiz">
    <h1 id="quiz-name">My Quiz</h1>

    <div id="question-0"><h2>Kích thước (đường kính) của mặt trăng bằng bao nhiêu lần so với kích thước Trái Đất (Lấy con số xấp xỉ)</h2>
        <input id="choices-0" type="radio" name="choices-0" value="10%"><label for="choices-0">10%</label><br>
        <input id="choices-1" type="radio" name="choices-0" value="20%"><label for="choices-1">20%</label><br>
        <input id="choices-2" type="radio" name="choices-0" value="27%"><label for="choices-2">27%</label><br>
        <input id="choices-3" type="radio" name="choices-0" value="30%"><label for="choices-3">30%</label>
        <p></p>
        <div id="hint-0"></div>

    </div>
    <br>
    <div id="question-1"><h2>Cầu Sông Hàn là biểu tượng của thành phố nào?</h2>
        <input id="choices-0" type="radio" name="choices-1" value="Tuy Hoà"><label for="choices-0">Tuy Hoà</label><br>
        <input id="choices-1" type="radio" name="choices-1" value="Hà Nội"><label for="choices-1">Hà Nội</label><br>
        <input id="choices-2" type="radio" name="choices-1" value="Đà Nẵng"><label for="choices-2">Đà Nẵng</label><br>
        <input id="choices-3" type="radio" name="choices-1" value="Lào Cai"><label for="choices-3">Lào Cai</label>
        <p></p>
        <div id="hint-1"></div>

    </div>
    <br>
    <input type="submit" name="submit" id="submit">
    <a href="/Quiz-Demo/public/index.php?r=random_play">Làm mới câu hỏi</a>
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script>
    $(document).ready(function() {

        $('#submit').one('click', function()
        {




            var Arr_Selected = new Array();

            var Arr_Unselected = new Array();

            var Arr_WrongAns = new Array();



            function getValueBox (rates){
                for (var j = 0; j < rates.length; j++) {
                    if (rates[j].checked) {
                        console.log(rates[j].value);
                        Arr_Selected.push(rates[j].value);
                        return true;
                    }
                }
                return false;
            }


            function GetWrongAns(a, b)
            {
                for (var i = 0; i < b.length; i++) {
                    if (a[i] != b[i]) {
                        Arr_WrongAns.push(i);
                    }
                }
            }
            for (var i =0; i < 2;) {
                var rates = document.getElementsByName('choices-' + i);
                if (getValueBox(rates)==false){
                    Arr_Selected.push('NULL');
                }
                i++;
            }
        console.log(Arr_Selected);
        });

    });



</script>



</script>
</script>


</body>
</html>
