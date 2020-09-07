<html>
    
<?php
require_once('header.page.php');
?>

<body>
   
<div class="container text-center">
<div class="row h-50">
<div class="col-sm-12 my-auto">
    <div class="row">

    <div class="col-3">
        <div class="card border-primary " style="height: 18rem;">
            <div class="card-body">
                <h5 class="card-title">選擇縣市</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="border: none">
                        <?= $today['day']?>
                    </li>
                    <form id="form" method="post">
                        <li class="list-group-item" style="border: none">
                            <select form="form" class="form-control " name="city">
                                <?php foreach($this->citylist as $key => $value) { ?>
                                    <option value="<?=$value?>" <?php if ($value == $cityName)echo "selected";?>><?=$value?>
                                    </option>
                                <?php } ?>
                            </select>
                        </li>
                        <li class="list-group-item" style="border: none">
                            <button class="btn btn-success form-control" type="submit" form="form" name="submit" value="1">確認</button>
                        </li>
                    </form>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-3">
        <div class="card border-primary " style="height: 18rem;">
            <div class="card-body">
                <h5 class="card-title">今日<?= $todayDayOrNight?></h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="border: none">
                        <img src="./views/icon/<?= $this->createImg($today['wx'])?>" width=90/>
                    </li>
                    <li class="list-group-item" style="border: none">
                        <?= $today['mint']."° - ".$today['maxt']."°" ?>
                    </li>
                    <li class="list-group-item" style="border: none">
                        <div class="row">
                            <div class="col-6 float-right" style="text-align:right">
                                <img src="./views/icon/icon-umberella.png" width=30/>
                            </div>
                            <div class="col-6 float-left" style="text-align:left">
                                <?= $today['pop']."%" ?>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card border-primary " style="height: 18rem;">
            <div class="card-body">
                <h5 class="card-title">未來2天天氣</h5>
                <div class="row">
                    <div class="col-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" style="border: none">
                                <?= $twoDayOne->day ?>
                            </li>
                            <li class="list-group-item" style="border: none">
                                <img src="./views/icon/<?= $this->createImg($twoDayOne->wx)?>" width=90/>
                            </li>
                            <li class="list-group-item" style="border: none">
                                <?= $twoDayOne->t."°"?>
                            </li>
                            <li class="list-group-item" style="border: none">
                                <div class="row">
                                    <div class="col-6 float-right" style="text-align:right">
                                        <img src="./views/icon/icon-umberella.png" width=30/>
                                    </div>
                                    <div class="col-6 float-left" style="text-align:left">
                                        <?= $twoDayOne->pop6h."%" ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item" style="border: none">
                                <?= $twoDayTwo->day ?>
                            </li>
                            <li class="list-group-item" style="border: none">
                                <img src="./views/icon/<?= $this->createImg($twoDayTwo->wx)?>" width=50/>
                            </li>
                            <li class="list-group-item" style="border: none">
                                <?= $twoDayTwo->t."°"?>
                            </li>
                            <li class="list-group-item" style="border: none">
                                <div class="row">
                                    <div class="col-6 float-right" style="text-align:right">
                                        <img src="./views/icon/icon-umberella.png" width=30/>
                                    </div>
                                    <div class="col-6 float-left" style="text-align:left">
                                        <?= $twoDayTwo->pop6h."%" ?>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    </div>
    <!-- row end -->

    <div class="row" style="padding-top:25px;">
        <div class="col-12">
            
        <div class="card border-info " style="height: 18rem;">
            <div class="card-body">
                <h5 class="card-title">未來1週天氣</h5>
                    <div class="row">
                        <div class="col">
                                </div>
                    </div>
                </ul>
            </div>
        </div>

        </div>
    </div>

</div>
</div>
</div>

<?php
    require_once('script.page.php');
?>

</body>
</html>