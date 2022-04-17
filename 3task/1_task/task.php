<?php
if($argc>1){
    // var_dump($argv);
    $file=$argv[1];
    getResult($file);
}

function getResult($file_path){
    $read=fopen($file_path, 'r');
    $all_banners_data=array();
    $banners_num=0;
    $result="";

    while(!feof($read)){
        $str=trim(fgets($read), " \n\r"); //считываем 1 строку
        if(!empty($str)){
            $banner_data=explode("\t",$str);
            $banner_id=$banner_data[0];
            $banner_datetime=explode(" ", $banner_data[1]);
            $mark=0;
            foreach($all_banners_data as &$banner){
                if($banner['id']==$banner_id){
                    $banner['count']++;
                    $another_datetime=$banner['datetime'][0]." ".$banner['datetime'][1];
                    if($banner_datetime>$another_datetime){
                        $banner['datetime']=$banner_datetime;
                    }
                    $mark=1;
                }
            }
            if($mark==0){
                $all_banners_data[$banners_num]['count']=1;
                $all_banners_data[$banners_num]['id']=$banner_id;
                $all_banners_data[$banners_num]['datetime']=$banner_datetime;
                $mark=1;
                $banners_num++;
            }
        }
    }
    foreach($all_banners_data as &$banner){
        $result.=$banner['count']." ".$banner['id']." ".$banner['datetime'][0]." ".$banner['datetime'][1]."\n";
    }
    // $result=substr($result, 0, -1);
    return $result;
}