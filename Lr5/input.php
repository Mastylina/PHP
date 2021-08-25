<?php
require_once('connect.php');
global $db;
$query2 = 'SELECT "password" FROM "user" WHERE "login" = :login_us AND "password" = :password_us';
$qw2 = $db->prepare($query2);
$qw2->bindParam(':login_us', $_POST['login']);
$qw2->bindParam(':password_us', $_POST['password']);
$qw2->execute();
$password = $qw2->fetchAll();
if ($password) {
echo '<li>' . "Авторизация прошла успешно без sql инъекции" . '</li>' . "\n";
}
$l=$_POST['login'];
$query2 = 'SELECT "password" FROM "user" WHERE "password"='.$_POST['password'];
$qw2 = $db->prepare($query2);
$p=$qw2->execute();
$p = $qw2->fetchAll();
if ($p) {
    echo '<li>' . "Авторизация прошла успешно, возможна sql инъекция" . '</li>' . "\n"; 
}