<?php
    require_once('Select.php') ;
    
    function setName($elementName) {
        switch ($elementName) {
            case "PoP6h":
                $elementName ="降雨機率";
                break;
            case "PoP12h":
                $elementName ="降雨機率";
                break;
            case "Wx":
                $elementName ="天氣現象";
                break;
            case "MinT":
                $elementName ="最低溫度";
                break;
            case "MaxT":
                $elementName ="最高溫度";
                break;
            case "T":
                $elementName ="溫度";
                break;
        }
        return $elementName ;
    }

    function valueChk($chkValue, $elementName){
        // if ($chkValue == null)
        //     return $chkValue ;

        switch ($elementName) {
            case "降雨機率":
                if(intval($chkValue))
                    $chkValue .= "%";
                break;
            case "最低溫度":
                $chkValue .= "°C";
                break;
            case "最高溫度":
                $chkValue .= "°C";
                break;
            case "溫度":
                $chkValue .= "°C";
                break;
            case "天氣現象":
                break;
        }
        return $chkValue ;
    }

    # this function only can use for week model
    function setDayOrNight($time){
        $date = substr($time,6,5) ;
        $time = substr($time,11,2) ;
            $time = ($time > 12) ? "夜晚" : "白天" ;
        $arr = array("date" => $date, "time" => $time) ;
        return $arr ;
    }

    # this function only can use for week model
    function setTime($time){
        $date = substr($time,6,5) ;
        $time = substr($time,11,2)."時" ;
        $arr = array("date" => $date, "time" => $time) ;
        return $arr ;
    }
?>


<!doctype html>
<html lang="en">
<head>
    <title>Weather</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function(){
            $("#臺中市").addClass("in active");
        });
    </script>
    <style>
        
        table{
            table-layout: fixed;
            text-align: center ;
        }
        
        h3 {
            text-align: center ;
        }
        h4 {
            text-align: center ;
        }
        
        .th-Color {
            border: none;
            background-color: #12CEFA ;
        }
        
        .td-Color {
            border: none;
            background-color: #00ff9f ;
        }

    </style>
</head>
<body>

<div class="container">
    <div class="row">
    <h2>天氣預報</h2>
    <ul class="nav nav-tabs">
        <!--
        <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
        <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
        <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
        <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
        -->
        <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">查看縣市<span class="caret"></span></a>
        <ul class="dropdown-menu">

            <?php 
                foreach($modelWeek as $m) {
                    echo "<li><a data-toggle='tab' href=#".$m->locationName.">".$m->locationName."</a></li>" ;
                } 
            ?>     

        </ul>
        </li>
    </ul>
    
    <div class="col">
    <div class="tab-content">
        <?php 
            foreach ($modelTwoDay as $m){
                echo $HtmlText = <<< locationBody
                    <div id="$m->locationName" class="tab-pane fade">
                    <h3>$m->locationName</h3></div>
                locationBody ;
            }

            foreach ($modelTwoDay as $m){
                #div tab pane location
                echo $HtmlText = <<< locationBody
                    <div id="$m->locationName" class="tab-pane fade">
                    <h4>未來兩日預報</h4>
                locationBody ;

                #table twoday upper row
                echo $HtmlText = <<< tableContainer
                    <div class="row"><div class="col">
                    <table class="table table-borderless"><thead class="th-Color"> <tr> <th scope="col"></th>
                tableContainer ;

                # table twoday th 
                foreach ($m->element as $e) {
                    $count = 0 ;
                    foreach ($e->time as $t) {
                        // 資料庫的日期格式是統一的
                        $timeTh = setTime($t["startTime"]) ;
                        $date = $timeTh["date"] ;
                        $time = $timeTh["time"] ;

                        echo $HtmlText = <<< tableTh
                        <th scope="col">$date $time</th>
                        tableTh ;
                        // 一個欄位3小時，8個為一天，程式只要2天=16
                        if ($count > 16) {
                            break ; 
                        }$count++ ;
                    }
                    break ;
                }
                echo "</tr></thead> " ; 
                echo "<tbody>" ;

                foreach ($m->element as $e){
                    $elementName = setName($e->elementName) ; 
                    echo "<tr><th scope='row' class='td-Color'>$elementName</th>" ;
                    $count = 0 ;
                    foreach ($e->time as $t) {
                        $value = valueChk($t["value"],$elementName) ;
                        echo "<td>$value</td>" ;

                        if ($count > 16) {
                            break ; 
                        }$count++ ;
                    }
                    echo "</tr>" ;
                }

                # table tbody, table week end , col, row, tab-pane end
                echo "</tbody></table></div></div></div>" ;
            }

            foreach ($modelWeek as $m){
                #div tab pane location
                echo $HtmlText = <<< locationBody
                    <div id="$m->locationName" class="tab-pane fade">
                    <h4>一週預報</h4>
                locationBody ;
                
                # table week row
                echo $HtmlText = <<< tableContainer
                    <div class="row"><div class="col">
                    <table class="table table-borderless"><thead class="th-Color"> <tr><th scope="col"></th>
                tableContainer ;

                # table week th 
                foreach ($m->element as $e) {
                    foreach ($e->time as $t) {
                        // 資料庫的日期格式是統一的
                        $timeTh = setDayOrNight($t["startTime"]) ;
                        $date = $timeTh["date"] ;
                        $time = $timeTh["time"] ;

                        echo $HtmlText = <<< tableTh
                        <th scope="col">$date $time</th>
                        tableTh ;
                    }
                    break ;
                }

                echo "</tr></thead> " ; 
                echo "<tbody>" ;
                # table week tr 
                foreach ($m->element as $e){
                    $elementName = setName($e->elementName) ; 
                    echo "<tr><th scope='row' class='td-Color'>$elementName</th>" ;
                    
                    foreach ($e->time as $t) {
                        $value = valueChk($t["value"],$elementName) ;
                        echo "<td>$value</td>" ;
                    }
                    echo "</tr>" ;
                }

                # table tbody, table week end , col, row, tab-pane end
                echo "</tbody></table></div></div></div>" ;
                
            }
        ?>
    </div>
    </div>

    </div>
</div>


</body>
</html>