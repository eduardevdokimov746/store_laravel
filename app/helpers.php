<?php

require __DIR__.'/../vendor/autoload.php';

function formatDateShow($date){
    $arrDate = [
        'Jan' => 'января',
        'Feb' => 'февраля',
        'Mar' => 'марта',
        'Apr' => 'апреля',
        'May' => 'мая',
        'Jun' => 'июня',
        'Jul' => 'июля',
        'Aug' => 'августа',
        'Sep' => 'сентября',
        'Oct' => 'октября',
        'Nov' => 'ноября',
        'Dec' => 'декабря'
    ];

    if (empty($date)) {
        return null;
    }

    $date = new DateTime($date);
    $month = $date->format('M');
    $finalDate = $date->format('j M Y');
    $item = str_replace($month, $arrDate[$month], $finalDate);
    return $item;
}
