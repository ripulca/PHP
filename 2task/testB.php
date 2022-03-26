<?php
require_once "taskB.php";
// Считываем данные тестов
$inputFiles = glob('B/*.dat');
$outputFiles = glob('B/*.ans');
$num=0;
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $readOutStr = fopen($output, 'r');
    $readInStr = fopen($input, 'r');
    while((!feof($readOutStr)) && (!feof($readInStr))){
        $right_answer = trim(fgets($readOutStr), " \n\r\t");
        $prog_input = trim(fgets($readInStr), " \n\r\t");
        if(!empty($prog_input) && !empty($right_answer)){
            echo "\nВходные данные: $prog_input\n";
            $prog_answer = taskB($prog_input);
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