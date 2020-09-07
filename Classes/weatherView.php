<?php

class WeatherView extends Weather {

    public function showWeather($cityName) {
        $this->title = "天氣預報";
        
        $today = $this->getTodayWeather($cityName);
        $todayDayOrNight = ($today['hour'] >= 18) ? '晚上' : '早上' ;

        # hour would be 06 or 18
        $twoday = $this->getTwoDayWeather($cityName,'06');
        $week = $this->getWeekWeather($cityName,'06');
       
        require_once('./views/weatherView.page.php');
    }

    function __construct() {
        $this->citylist = array('嘉義縣','新北市','嘉義市','新竹縣','新竹市','臺北市','臺南市','宜蘭縣','苗栗縣','雲林縣','花蓮縣',
                                '臺中市','臺東縣','桃園市','南投縣','高雄市','金門縣','屏東縣','基隆市','澎湖縣','彰化縣','連江縣');
    }
   
    function createImg($code) {

        if ($code == 1) return 'icon-2.svg';
        else if ($code == 11) return 'icon-4.svg';
        else if ($code == 21) return 'icon-11.svg';
        else if ($code == 2 || $code == 3) return 'icon-3.svg';
        else if ($code >= 4 && $code <= 7) return 'icon-6.svg';
        else return 'icon-10.svg';
    }



}

?>