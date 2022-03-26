<?php
require_once "getResult.php";
// Считываем данные тестов
$inputFiles = glob('tests/*.dat');
$outputFiles = glob('tests/*.ans');
$num=0;
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $readStr = fopen($output, 'r');
    $right_answer = trim(fgets($readStr), " \n\r\t");   //считываем правильный ответ и обрезаем перенос каретки
    $prog_answer = getResult($input); //получаем результат программы
    echo "\nТест $num: ";
    if ($right_answer == $prog_answer) { //сравниваем правильный и полученный результаты
        echo "Ок\n";
    } else {
        echo "Ошибка\nВерный ответ: $right_answer\nОтвет программы: $prog_answer\n";
    }
    $num++;
}