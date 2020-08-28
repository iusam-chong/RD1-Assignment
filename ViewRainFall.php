<?php



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
        <li><a data-toggle="tab" ><span class="caret"></span></a></li>
    </ul>
    
    
    

    </div>
</div>


</body>
</html>