<?php
$inputs = glob("repos/*.dat");
$outputs =  glob("repos/*.ans");
$number_test = 1;//порядковый номер теста
foreach (array_combine($inputs, $outputs) as $input => $output) {
    $fs = fopen($output, 'r');
    $rightAnswer = fgets($fs);
    $my_Answer = Get_vallue($input);
    echo "<p>Test $number_test: ";
    if ($my_Answer == $rightAnswer) {
        echo  "Ok</p>";
    } else {
        echo "Wrong</p>";

    }
    $number_test++;
}
function Get_vallue($file_dat)//функция нахождения итогового баланса игрока
{
$f=fopen($file_dat,'r');//открываем файл для чтения
$number_of_beats = fgets($f);//считываем кол-во ставок
$array_bets=[];
for ($i=0; $i<$number_of_beats; $i++) {//считываем в лист и записываем в массив  сумму ставки и результат игры
list ($id,$sum,$command)=explode(" ",fgets($f));
$array_bets[$id][0]=$sum;
$array_bets[$id][1]=$command;

}
$array_games=[];
$count_games=fgets($f);
for ($i=0; $i<$count_games; $i++) {
list ($id_game,$coefficient_L,$coefficient_R,$coefficient_D,$res)=explode(" ",fgets($f));//считываем в лист и записываем в массив атрибуты из файла
$array_games[$id_game][0]=(float)$coefficient_L;
$array_games[$id_game][1]=(float)$coefficient_R;
$array_games[$id_game][2]=(float)$coefficient_D;
$array_games[$id_game][3]=$res;
}
$balance=0;//текущий баланс игрока
foreach($array_bets as $key=>$value) {
 if($value[1]==$array_games[$key][3]) {
     if (strcasecmp($array_games[$key][3],"L\n")==0){
        $balance+=$array_games[$key][0]*$value[0]-$value[0];
     }
     if (strcasecmp($array_games[$key][3],"R\n")==0){
        $balance+=$array_games[$key][1]*$value[0]-$value[0];
    }
    if (strcasecmp($array_games[$key][3],"D\n")==0){
        $balance+=$array_games[$key][2]*$value[0]-$value[0];
    } 
 } else {
    $balance-=$value[0];
 }
}
return $balance;
}
