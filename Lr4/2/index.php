<?php
require ('connect.php');
global $db;
$qwery = 'SELECT * FROM php4_2';
$request = $db->prepare($qwery);
$request->execute();
$all_data = $request->fetchAll();//запрос на вывод всех данных из бд
$regular_expression = '/(http:\/\/asozd\.duma\.gov\.ru\/main\.nsf\/\(Spravka\)\?OpenAgent&RN=)((\d+)-(\d+))&(\d+)/';// регулярное выражение
for ($i=0;$i<count($all_data);$i++) {
    if (preg_match($regular_expression, $all_data[$i]['link'])) {
        
        $all_data[$i]['link'] = preg_replace_callback($regular_expression, function ($texts) {
            preg_match('/((\d+)-(\d+))/', $texts[0], $text);
            return 'http://sozd.parlament.gov.ru/bill/' . $text[0];
        }, $all_data[$i]['link']);
                echo $all_data[$i]['link'];
        global $db;
        $qwery = 'UPDATE php4_2 SET link=:link WHERE id=:id';
        $request = $db->prepare($qwery);
        $params = [
        ':id' => $all_data[$i]['id'],
        ':link' => $all_data[$i]['link']
        ];
        $request->execute($params);// запрос на обновление данных
    }
}