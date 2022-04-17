<?php
if($argc>1){
    // var_dump($argv);
    $file=$argv[1];
    getResult($file);
}

function getResult($file_path){
    error_reporting(E_ERROR | E_PARSE);
    $read=fopen($file_path, 'r');
    $all_data=array();
    $array_lvl=-1;
    $num=1;
    $result_array=array();
    $result="";
    $last_node=null;

    while(!feof($read)){
        $str=trim(fgets($read), " \n\r"); //считываем 1 строку
        // var_dump($str);
        if(!empty($str)){
            $node_data=explode(" ",$str);
            $node_id=$node_data[0];
            $node_name=$node_data[1];
            $node_enter=$node_data[2];
            $node_exit=$node_data[3];
            // echo $node_enter." ".$node_exit."\n";
            // echo $node_enter." ".$last_node[3]."\n";

            if($num<=$node_enter){
                if($array_lvl!=-1){
                    for($i=0;$i<count($all_data[$array_lvl]);$i++){
                        if($all_data[$array_lvl][$i][2]==($node_enter-1)){
                            $node_data['parent_node']=$all_data[$array_lvl][$i][1];
                            break;
                        }
                    }
                }
                else{
                    $node_data['parent_node']=NULL;
                }
                $array_lvl++;
                if(gettype($all_data[$array_lvl])!="array"){
                    $all_data[$array_lvl]=array();
                }
                array_push($all_data[$array_lvl], $node_data);
                $num+=(($node_enter-$num)+1);
            }
            else if($num==$node_exit){
                $array_lvl--;
                if($array_lvl!=-1){
                    for($i=0;$i<count($all_data[$array_lvl]);$i++){
                        if($all_data[$array_lvl][$i][3]==($node_exit+1)){
                            $node_data['parent_node']=$all_data[$array_lvl][$i][1];
                            break;
                        }
                    }
                }
                else{
                    $node_data['parent_node']=NULL;
                }
                array_push($all_data[$array_lvl], $node_data);
                $num++;
            }
            else if($last_node[3]==($node_enter-1)){
                if($array_lvl>0){
                    $node_data['parent_node']=$last_node[1];
                }
                else{
                    $node_data['parent_node']=NULL;
                }
                array_push($all_data[$array_lvl], $node_data);
            }
            $last_node=$node_data;
        }
    }
    var_dump($all_data);
    for($i=0;$i<count($all_data);$i++){
        foreach($all_data[$i] as $data){
            $new_str="";
            for($j=0;$j<$i;$j++){
                $new_str.="-";
            }
            $new_str.=$data[1]."\n";
            if($i>0){
                $after=$data['parent_node']."\n";
                // echo "AFTER= ".$after."\n";
                // echo "NEW= ".$new_str."\n";
                for($j=0;$j<count($result_array);$j++){
                    if(str_contains($result_array[$j],$after)){
                        array_splice($result_array, $j+1, 0, $new_str);
                        break;
                    }
                }
            }
            else if($i==0){
                array_push($result_array, $data[1]."\n");
            }
        }
    }
        var_dump($result_array);
    // for($i=0;$i<count($result_array);$i++){
    //     $result.=$result_array[$i];
    // }
    // print_r($result);
    // return $result;
}