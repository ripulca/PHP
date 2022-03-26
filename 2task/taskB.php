<?php
if($argc>1){
    // var_dump($argv);
    $ip=$argv[1];
    taskB($ip);
}

function taskB($ip){
    $result="";
    $all_blocks_amount=8;
    $full_blocks_amount=0;
    $first_check_ip=explode("::",$ip); //сразу определяем возможные участки с ::. если есть, выделяем блоки до :: и после
    foreach($first_check_ip as $second_check_ip){
        $blocks=explode(":",$second_check_ip);
        $full_blocks_amount+=count($blocks); //считаем количество блоков без ::
    }
    $empty_blocks_amount=$all_blocks_amount-$full_blocks_amount;
    if($ip[0]==":" && $ip[1]==":"){  //отдельный случай если :: в начале, тогда сразу добавляем в итоговую строку блоки с 0
        for($i=0;$i<$empty_blocks_amount;$i++){
            $result.="0000:";
        }
        $empty_blocks_amount=0; //при этом обнуляем количество блоков для дозаполнения
    }
    foreach($first_check_ip as $second_check_ip){
        $blocks=explode(":",$second_check_ip);
        foreach($blocks as $block){
            for($i=0;$i<(4-strlen($block));$i++){ //определяем сколько 0 не хватает до полного блока и добавляем столько
                $result.="0";
            }
            $result.=$block.":"; //дописываем числа
        }
        while($empty_blocks_amount>0){ //заполняем ::
            $result.="0000:";
            $empty_blocks_amount--;
        }
    }
    $result=substr($result, 0, -1); //убираем лишний : на конце
    return $result;
}