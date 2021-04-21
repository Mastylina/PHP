<?php
$db = new PDO('pgsql:host=127.0.0.1;dbname=testdb','user','qwertyuiop');
$query = 'SELECT * FROM "user" WHERE "email" = :email';
$parametr = [ 
    ':email' => $_POST["email"]
];
$qw = $db->prepare($query);
$qw -> execute($parametr);
$data = $qw->fetchObject();
if(!$data) {//добавим данные в БД
    // Формируем массив для JSON ответа
    $result = array(
    	'name' => explode(" ",$_POST["name"]),
        'email' => $_POST["email"],
    	'phone' => $_POST["phone"],
        'comment' => $_POST["comment"],
        'error' => false,
        'message' => 'С вами свяжутся после  ' .  date("H:i:s d.m.Y", strtotime("+90 minutes")),
        'date_and_time' => date("H:i:s d.m.Y")
    ); 
    // Переводим массив в JSON
    mail("annyasotovii12345@gmail.com", "Заявка с сайта", $result['name'] . ' ' . $result['email'] . ' ' . $result['phone'] . ' ' . $result['comment'] . ' '. $result['date_and_time']);
    echo json_encode($result); 
    //добавление в БД
    $name = explode(" ",$_POST["name"]);
    $query = 'INSERT INTO "user"("first_name","last_name","patronymic","email","phone","comment", "date") VALUES(:first_name,:last_name,:patronymic,:email,:phone,:comment, :d)';
    $parametr = [ 
        ':first_name' => $name[1],
        ':last_name' => $name[0],
        ':patronymic' => $name[2],
        ':email' => $_POST["email"],
        ':phone' => $_POST["phone"],
        ':comment' => $_POST["comment"],
        ':d' => date("H:i:s d.m.Y")
    ];
        $qw = $db->prepare($query);
        $qw -> execute($parametr);
} elseif ($data && date("H:i:s d.m.Y",strtotime("+1 hours",strtotime($data->date))) <= date("H:i:s d.m.Y")) {
    $result = array(
    	'name' => explode(" ",$_POST["name"]),
        'email' => $_POST["email"],
    	'phone' => $_POST["phone"],
        'comment' => $_POST["comment"],
        'error' => false,
        'message' => 'С вами свяжутся после  ' .  date("H:i:s d.m.Y", strtotime("+90 minutes")),
        'date_and_time' => date("H:i:s d.m.Y")
    ); 
    // Переводим массив в JSON
    mail("annyasotovii12345@gmail.com", "Заявка с сайта", $result['name'] . ' ' . $result['email'] . ' ' . $result['phone'] . ' ' . $result['comment'] . ' '. $result['date_and_time']);
    echo json_encode($result); 
    //добавление в БД
    $name = explode(" ",$_POST["name"]);
    $query = 'UPDATE "user" SET "first_name"=:first_name,"last_name"=:last_name,"patronymic"=:patronymic,"email"=:email,"phone"=:phone,"comment"=:comment,"date"=:d WHERE "email"=:email';
    $parametr = [ 
        ':first_name' => $name[1],
        ':last_name' => $name[0],
        ':patronymic' => $name[2],
        ':email' => $_POST["email"],
        ':phone' => $_POST["phone"],
        ':comment' => $_POST["comment"],
        ':d' => date("H:i:s d.m.Y")
    ];
    $qw = $db->prepare($query);
    $qw -> execute($parametr);
} elseif ($data && date("H:i:s d.m.Y",strtotime("+1 hours",strtotime($data->date))) > date("H:i:s d.m.Y")) {
    $result = array(
        'error' => true,
        'time' => date('H:i:s', strtotime($data->date) - strtotime('02:00:00')) .' ' . date('d.m.Y', strtotime($data->date))
    );
    // Переводим массив в JSON
    echo json_encode($result);
}
?>