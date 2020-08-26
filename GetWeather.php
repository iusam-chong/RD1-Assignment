<?php

require_once('configdb.php') ;
@$db = setupDb() ;

?>

<!DOCTYPE html>
<html>
<head>
  <title>天氣</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>天氣預報</h2>
  <p>我是說明</p>
  <div class="dropdown dropright">
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    地區
    </button>
    <div class="dropdown-menu">
      <a class="dropdown-item" href="#">Link 1</a>
      <a class="dropdown-item" href="#">Link 2</a>
      <a class="dropdown-item" href="#">Link 3</a>
    </div>
  </div>
</div>

</body>

<script>

    // $.get("OneDayHalf-Update.php") ;

</script>

</html>