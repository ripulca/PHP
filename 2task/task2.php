<?php
if($argc>1){
    // var_dump($argv);
    $input=$argv[1];
    task2($input);
}

function task2($input){
    $pattern = "/http:\/\/asozd.duma.gov.ru\/main.nsf\/\(Spravka\)\?OpenAgent&RN=[0-9]{1,10}[-][0-9]{1,10}&[0-9]{1,10}/";
	preg_match_all($pattern, $input, $matches);  //ищем совпадения в строке с помощью регулярки
    $new_res=$matches[0]; //копируем совпавший участок
	
	foreach($new_res as &$element) {  //превращаем копию в регулярку для последующей замены с помощью функции
		$element = str_replace("/", "\/", $element);
		$element = str_replace("?", "\?", $element);
		$element = str_replace("(", "\(", $element);
		$element = str_replace(")", "\)", $element);
		$element = "/" . $element . "/";
	}

	foreach ($matches[0] as &$element) {  //ищем номер указа и подставляем в новую ссылку
		$lil_pattern = "/[0-9]{1,10}[-][0-9]{1,10}/";
	    preg_match($lil_pattern, $element, $match);
	    $element="http://sozd.parlament.gov.ru/bill/" . $match[0];
	}
	echo preg_replace($new_res, $matches[0], $input); //производим поиск нужного элемента строки по регулярке и заменяем на новый
} 
