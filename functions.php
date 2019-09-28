<?php

function chem_char($text)
{
    preg_match_all('/@(.*?)@/i', $text, $matches, PREG_OFFSET_CAPTURE);
    //debug($matches);
    //echo strlen($task['var1']);
    for ($i = 0; $i < strlen($text); $i ++)
    {

        foreach ($matches as $item_text)
        {
            $item_m = count($item_text);
        }
        for ($a = 0; $a < $item_m; $a ++)
        {
            if ($item_text[$a][1] - 1 == $i)
            {
                echo "<span class=\"echem-formula\">" . $item_text[$a][0] . "</span>";
                $i = $i + strlen($item_text[$a][0])+1;
                continue 2;
            }
        }
        echo $text[$i];

    }
}

function debug($arr){
    echo '<pre>' . print_r($arr, true) . '</pre>';
}

function exp_list($arr){
    foreach ($arr as $item)
    {
        echo $item['title'];
        echo '<br>';
    }
}

function getAge($y, $m, $d) { // в качестве параметров будут год, месяц и день
    if($m > date('m') || $m == date('m') && $d > date('d'))
        return (date('Y') - $y - 1); // если ДР в этом году не было, то ещё -1
    else
        return (date('Y') - $y); // если ДР в этом году был, то отнимаем от этого года год рождения
}

function real_date_diff($date1, $date2 = NULL){
    $diff = array();
 
    //Если вторая дата не задана принимаем ее как текущую
    if(!$date2) {
        $cd = getdate();
        $date2 = $cd['year'].'-'.$cd['mon'].'-'.$cd['mday'].' '.$cd['hours'].':'.$cd['minutes'].':'.$cd['seconds'];
    }
     
    //Преобразуем даты в массив
    $pattern = '/(\d+)-(\d+)-(\d+)(\s+(\d+):(\d+):(\d+))?/';
    preg_match($pattern, $date1, $matches);
    $d1 = array((int)$matches[1], (int)$matches[2], (int)$matches[3], (int)$matches[5], (int)$matches[6], (int)$matches[7]);
    preg_match($pattern, $date2, $matches);
    $d2 = array((int)$matches[1], (int)$matches[2], (int)$matches[3], (int)$matches[5], (int)$matches[6], (int)$matches[7]);
 
    //Если вторая дата меньше чем первая, меняем их местами
    for($i=0; $i<count($d2); $i++) {
        if($d2[$i]>$d1[$i]) break;
        if($d2[$i]<$d1[$i]) {
            $t = $d1;
            $d1 = $d2;
            $d2 = $t;
            break;
        }
    }
 
    //Вычисляем разность между датами (как в столбик)
    $md1 = array(31, $d1[0]%4||(!($d1[0]%100)&&$d1[0]%400)?28:29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $md2 = array(31, $d2[0]%4||(!($d2[0]%100)&&$d2[0]%400)?28:29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $min_v = array(NULL, 1, 1, 0, 0, 0);
    $max_v = array(NULL, 12, $d2[1]==1?$md2[11]:$md2[$d2[1]-2], 23, 59, 59);
    for($i=5; $i>=0; $i--) {
        if($d2[$i]<$min_v[$i]) {
            $d2[$i-1]--;
            $d2[$i]=$max_v[$i];
        }
        $diff[$i] = $d2[$i]-$d1[$i];
        if($diff[$i]<0) {
            $d2[$i-1]--;
            $i==2 ? $diff[$i] += $md1[$d1[1]-1] : $diff[$i] += $max_v[$i]-$min_v[$i]+1;
        }
    }
     
    //Возвращаем результат
    return $diff;
}