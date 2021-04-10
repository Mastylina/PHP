<?php
$xml_file=simplexml_load_file('input.xml');//Преобразуем правильно сформированный XML-документ в указанном файле в объект.
$db=new PDO('pgsql:host=127.0.0.1;dbname=testdb','user','qwertyuiop');
$query='INSERT INTO "user"("login","password","name") VALUES(:login_us,:password_us,:name_us)';
foreach($xml_file as $us) {
    $parametr=[ 
        ':login_us'=>$us->login,
        ':password_us'=>$us->password,
        ':name_us'=>$us->name
    ];
        $qw=$db->prepare($query);
        $qw->execute($parametr);
}
$query='SELECT * FROM "user"';
$qw=$db->prepare($query);
$qw->execute();
$_use=$qw->fetchAll(PDO::FETCH_ASSOC);
$json_file = json_encode($_use);
file_put_contents('output.json', $json_file);
