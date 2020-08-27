<?php

    require_once('ConfigDb.php') ;

    require_once('UpdateAction.php') ;

    require_once('Update-Week.php') ;

    update($command,$obj) ;

    require_once('Update-TwoDay.php') ;

    update($command,$obj) ;
    
    # 36小時的資料格式不一樣，無法用update function，所以內建執行
    require_once('Update-OneDayHalf.php') ;
    

?>