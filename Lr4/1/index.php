<?php
$all_text = file_get_contents('input.txt'); //считывание данных из файла
$regular_expression = '/\'[0-9]+\'/'; //регулярное выражение
$all_text = preg_replace_callback ($regular_expression, function ($items) {
    preg_match('/[0-9]+/', $items[0], $item);
    return '\'' . $item[0] * 2 . '\'';
}, $all_text);

echo $all_text;
$file = fopen ('output.txt',w); //открываем файл
fwrite ($file, $all_text); //запись в файл
fclose ($file); //закрываем файл
