<html>
    
<?php
require_once('header.page.php');
?>

<body>
   
<div class="container text-center">
<div class="row h-75">
<div class="col-sm-12 my-auto">
    
<div class="row" style="padding-top:15px;">
        <div class="col-12">
        
        <div class="card " style="border:none;">
            <div class="card-body">
                <img src="./views/image/<?= $headerImage?>" style="height: auto;max-width: 100%;"/>
            </div> 
        </div>

        </div>
    </div>
    
    <div class="row"> 
    <div class="col-3">
        <div class="card border-primary " style="height: 16rem;">
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
        <div class="card border-primary " style="height: 16rem;">
            <div class="card-body">
                <h5 class="card-title">今日<?= $todayDayOrNight?></h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="border: none">
                        <img src="./views/icon/<?= $this->createImg($today['wx'])?>" style="height:60px;width:auto;"/>
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
        <div class="card border-primary">
            <div class="row">
                <div class="col-6">
                    <div class="card" style="height: 16rem; border: none;">
                        <div class="card-body">
                            <h5 class="card-title">明天天氣</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" style="border: none">
                                    <img src="./views/icon/<?= $this->createImg($twoday[0]['wx'])?>" style="height:60px;width:auto;"/>
                                </li>
                                <li class="list-group-item" style="border: none">
                                    <?= $twoday[0]['t']."°" ?>
                                </li>
                                <li class="list-group-item" style="border: none">
                                    <div class="row">
                                        <div class="col-6 float-right" style="text-align:right">
                                            <img src="./views/icon/icon-umberella.png" width=30/>
                                        </div>
                                        <div class="col-6 float-left" style="text-align:left">
                                            <?= $twoday[0]['pop6h']."%" ?>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card" style="height: 16rem; border: none;">
                        <div class="card-body">
                            <h5 class="card-title">後天天氣</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" style="border: none">
                                    <img src="./views/icon/<?= $this->createImg($twoday[1]['wx'])?>" style="height:60px;width:auto;"/>
                                </li>
                                <li class="list-group-item" style="border: none">
                                    <?= $twoday[1]['t']."°" ?>
                                </li>
                                <li class="list-group-item" style="border: none">
                                    <div class="row">
                                        <div class="col-6 float-right" style="text-align:right">
                                            <img src="./views/icon/icon-umberella.png" width=30/>
                                        </div>
                                        <div class="col-6 float-left" style="text-align:left">
                                            <?= $twoday[1]['pop6h']."%" ?>
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
        
    </div>
    <!-- row end -->

    <div class="row" style="padding-top:25px;">
        <div class="col-12">
        
        <div class="card border-info " style="height: 20rem;">
            <div class="card-body">
                <h5 class="card-title">未來一週天氣</h5>
                <div class="row seven-cols">
                    <?php foreach ($week as $w) {
                        $day = substr($w['day'],5,5);
                        $wx = $this->createImg($w['wx']);
                        $mint = $w['mint'];
                        $maxt = $w['maxt'];
                        echo '<div class="col-md-1">
                                <div class="card" style="border: none;">
                                    <div class="card-body">
                                        <h5 class="card-title">'.$day.'</h5>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item" style="border: none">
                                                <img src="./views/icon/'.$wx.'" style="height:60px;width:auto;"/>
                                            </li>
                                            <li class="list-group-item" style="border: none;">
                                            '.$mint.'-'.$maxt.'°
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                    } ?>
                </div>
            </div> 
        </div>

        </div>
    </div>

    <div class="row" style="padding-top:25px;padding-bottom:25px;">
        <div class="col-12">
        
        <div class="card border-success">
            <div class="card-body">
                <h5 class="card-title">觀測站累積雨量數據</h5>
                <div class="row seven-cols">
                    <table class="table table-striped text-center">
                        <tr>
                            <th>地區名稱</th>
                            <th>1小時累積雨量</th>
                            <th>24小時累積雨量</th>
                        </tr>
                    <?php foreach ($rain as $r) {
                        $location = $r['location'];
                        $hour = $r['hour'];
                        $day = $r['day'];

                        echo '<tr>
                            <td>'.$location.'</td>
                            <td>'.$hour.'</td>
                            <td>'.$day.'</td>
                            </tr>';
                    } ?>
                    </table>
                </div>
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