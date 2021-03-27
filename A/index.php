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
$array_id=[];
$array_sum=[];
$array_command=[];

for ($i=0; $i<$number_of_beats; $i++) {//считываем в лист и записываем в массивы идентификатор игры, сумму ставки и результат игры
list ($id,$sum,$command)=explode(" ",fgets($f));
$array_id[$i]=$id;
$array_sum[$i]=$sum;
$array_command[$i]=$command;

}

$array_id_game=[];
$array_coefficient_L=[];
$array_coefficient_R=[];
$array_coefficient_D=[];
$result=[];
$count_game=fgets($f);

for ($i=0; $i<$count_game; $i++) {
list ($id_game,$coefficient_L,$coefficient_R,$coefficient_D,$res)=explode(" ",fgets($f));//считываем в лист и записываем в массивы атрибуты из файла
$array_id_game[$i]=$id_game;
$array_coefficient_L[$i]=$coefficient_L;
$array_coefficient_R[$i]=$coefficient_R;
$array_coefficient_D[$i]=$coefficient_D;
$result[$i]=$res;

}
$balance=0;//текущий баланс игрока
for ($i=0; $i<$number_of_beats; $i++) {
    $j=array_search($array_id[$i], $array_id_game);
        if ($array_id[$i]==$array_id_game[$j]) {
            if ($array_command[$i]==$result[$j]) {   
                if (strcasecmp($result[$j],"L\n")==0) {
                   $balance+=$array_coefficient_L[$j]*$array_sum[$i]-$array_sum[$i];

                }
                if (strcasecmp($result[$j],"R\n")==0) {
                    $balance+=$array_coefficient_R[$j]*$array_sum[$i]-$array_sum[$i];
                    
                }
                if (strcasecmp($result[$j],"D\n")==0) {
                    $balance+=$array_coefficient_D[$j]*$array_sum[$i]-$array_sum[$i];
                   
                }
            } else {
                $balance-=$array_sum[$i];

            }
        }

}
return $balance;
}
