<?php
    require_once('Select.php') ;
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
   
</head>
<body>

<div class="container">
  <h2>weather</h2>
  <ul class="nav nav-tabs">
    <!--
    <li class="active"><a data-toggle="tab" href="#home">Home</a><<?php
    require_once('Select.php') ;

    function setName($elementName) {
        switch ($elementName) {
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
        }
        return $elementName ;
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
        table {
            width: 100%;
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
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">選擇天氣<span class="caret"></span></a>
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
            foreach ($modelWeek as $m){
                #div location
                echo $HtmlText = <<< locationBody
                    <div id="$m->locationName" class="tab-pane fade">
                    <h3>$m->locationName</h3>
                    <h3>啊 我是內容</h3>
                locationBody ;
                
                # table
                echo $HtmlText = <<< tableContainer
                    <table class="table">
                    <thead> <tr> <th scope="col">#</th>
                tableContainer ;

                # table th 
                foreach ($m->element as $e) {
                    foreach ($e->time as $t) {
                        // 資料庫的日期格式是統一的
                        $timeTh = substr($t["startTime"],5,6) ;
                        echo $HtmlText = <<< tableTh
                        <th scope="col">$timeTh</th>
                        tableTh ;
                    }
                    break ;
                }

                echo "</tr></thead> " ; 
                echo "<tbody>" ;
                # table tr 
                foreach ($m->element as $e){
                    $elementName = setName($e->elementName) ; 
                    echo "<tr><th scope='row'>$elementName</th>" ;
                    
                    foreach ($e->time as $t) {
                        $value = $t["value"] ;
                        echo "<td>$value</td>" ;
                    }
                    echo "</tr>" ;
                }

                # element div / table end below
                echo "</tbody>" ;
                echo "</table>" ;
                echo "</div>" ;
            }
        ?>
    </div>
    </div>

    </div>
</div>
 
</body>
</html>/li>
    <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
    -->
    <li class="dropdown">
      <a class="dropdown-toggle" data-toggle="dropdown" href="#">選擇天氣<span class="caret"></span></a>
      <ul class="dropdown-menu">

        <?php foreach($modelWeek as $m) { ?>
        <?php echo "<li><a data-toggle='tab' href=#".$m->locationName.">".$m->locationName."</a></li>" ;?>
        <?php } ?>     

      </ul>
    </li>
  </ul>

  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>
</div>
 
</body>
</html>