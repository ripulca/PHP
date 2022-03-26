<?php
require_once "taskC.php";
// Считываем данные тестов
$inputFiles = glob('C/*.dat');
$outputFiles = glob('C/*.ans');
$num=0;
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $readOutStr = fopen($output, 'r');
    $readInStr = fopen($input, 'r');
    while((!feof($readOutStr)) && (!feof($readInStr))){
        $right_answer = trim(fgets($readOutStr), " \n\r\t");
        $prog_input = trim(fgets($readInStr), " \n\r\t");
        // $replace_arr=array("<",">");
        // $prog_input=str_replace($replace_arr, "'", $prog_input);
        if(!empty($prog_input) && !empty($right_answer)){
            echo "\nВходные данные: $prog_input\n";
            $prog_answer = taskC($prog_input);
            echo "\nТест $num: ";
            if ($right_answer == $prog_answer) {
                echo "Ок\n";
            } else {
                echo "Ошибка\nВерный ответ: $right_answer\nОтвет программы: $prog_answer\n";
            }
        }
    }
    $num++;
}