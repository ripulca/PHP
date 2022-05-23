<?php
if($argc>1){
    // var_dump($argv);
    $file=$argv[1];
    getResult($file);
}

function getResult($file_path){
    $readStr=fopen($file_path, 'r');

    $bet_amount=fgets($readStr); //считываем 1 строку с количеством ставок

    $bets=array(); //создаем массив ставок
    for($i=0;$i<$bet_amount;$i++){
        list($id, $bet_sum, $bet_result)=explode(' ', fgets($readStr));
        $bets[$id]['bet_sum']=(int)$bet_sum;
        $bets[$id]['bet_result']=trim($bet_result, " \n\r\t");
    }

    $games_amount=fgets($readStr); //считываем строку с кол-вом игр
    $games=array(); //создаем массив игр
    for($i=0;$i<$games_amount;$i++){ //распределяем инфу по массиву
        list($id, $l_coeff, $r_coeff, $d_coeff, $result)=explode(' ', fgets($readStr));
        $games[$id]['L_coeff']=(float)$l_coeff;
        $games[$id]['R_coeff']=(float)$r_coeff;
        $games[$id]['D_coeff']=(float)$d_coeff;
        $games[$id]['result']=trim($result," \n\r\t");
    }
    $result_sum=0;
    foreach($bets as $id=>$bet){
        if($bet['bet_result']==$games[$id]['result']){
            $start_sum=$bet['bet_sum'];
            $result_sum+=(($bet['bet_sum']*$games[$id][$bet['bet_result'].'_coeff'])-$start_sum);   //высчитываем разницу по каждой ставке
        }
        else{
            $result_sum-=$bet['bet_sum'];  //иначе вычитаем проигрыш
        }
    }
    echo "Ответ: $result_sum";
    return $result_sum;
}
