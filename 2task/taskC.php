<?php
if($argc>1){
    // var_dump($argv);
    $input=$argv[1];
    $valid_type=$argv[2];
    $low_lim=$argv[3];
    $high_lim=$argv[4];
    taskC($input, $valid_type, $low_lim, $high_lim);
}

function taskC($input){
    $data=explode("<",$input);
    $data=explode(">",$data[1]); //избавляемся от треугольных скобок
    $parameters=explode(" ",$data[1]); //выделяем параметры: тип валидации и ограничения, если есть
    unset($parameters[0]); //убираем пустое поле(появляется в следствии explode)
    $data=$data[0];
    if($parameters[1]=='S') { //запускаем нужную нам валидацию
		$result = S($data, $parameters[2], $parameters[3]);
	}
	else if($parameters[1]=='N') {
		$result = N($data, $parameters[2], $parameters[3]);
	}
	else if($parameters[1]=='P') {
		$result = P($data);
	}
	else if($parameters[1]=='D') {
		$result = D($data);
	}
	else if($parameters[1]=='E') {
		$result = E($data);
	}
	else { //если нет совпадений, значит валидация не пройдена
		return "FAIL";
	}

	if ($result === 1 or $result === true) //все функции возвращают bool
		return "OK";
	else
		return "FAIL";
}

function S( $data, $n, $m) { 
	$pattern = "/^[a-zA-Z _']{" . $n . "," . $m . "}$/";
	return preg_match($pattern, $data);
}

function N( $data, $n, $m ) { 
	$pattern = "/^[-0-9][0-9']{0,10}$/"; 
	if (preg_match($pattern, $data) === 1) {
		$val = intval($data);
		return $n <= $val and $val <= $m; 
	}
	return false;
}

function P( $data) {
	$pattern = "/^[+][7][ ][(][0-9]{3}[)][ ][0-9]{3}[-][0-9]{2}[-][0-9]{2}$/";
	return preg_match($pattern, $data);
}

function D($data) {
	$pattern = "^[0-9]{1,2}.[0-9]{1,2}.[0-9]{4} [0-9]{1,2}:[0-9]{1,2}^";
	if (preg_match($pattern, $data) === 1){ 
		
		$date = explode(" ", $data)[0];
		$time = explode(" ", $data)[1];
		$date = explode(".", $date);
		$time = explode(":", $time);

		if ( checkdate($date[1], $date[0], $date[2]) == false )
			return false; 
		if ( intval($time[0]) >= 24 )
			return false;
		if ( intval($time[1]) >= 60 )
			return false;

		return true;
	}
	return false;
	
}

function E($data) {
	$pattern = "/^[a-zA-Z][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}[.][a-z]{2,10}$/";
	return preg_match($pattern, $data);
}