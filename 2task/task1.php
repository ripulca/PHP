<?php
if($argc>1){
    // var_dump($argv);
    $input=$argv[1];
    task1($input);
}

function task1($input){
    $pattern = "/'[0-9]'/"; 
	$matches = array();
	preg_match_all($pattern, $input, $matches); //ищем совпадения в строке с помощью регулярки
    $new_res=$matches[0]; //копируем совпавший участок
    foreach($new_res as &$val){
        $val=trim($val, "'"); //убираем одинарные кавычки
        $val=intval($val)*2; //домножаем
        $val="'".$val."'"; //добавляем кавычки обратно
    }
	foreach ($matches[0] as &$element) { //из первой копии делаем регулярку
		$element = "/" . $element . "/";
	}
	echo preg_replace($matches[0], $new_res, $input); //производим поиск нужного элемента строки по регулярке и заменяем на новый
}