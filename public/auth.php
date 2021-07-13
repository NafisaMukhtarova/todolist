<?php

require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $model = ["header"=>"Авторизация"];
    echo $handlebars->render("auth_form", $model);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $login = filter_var(trim($_POST['login']),FILTER_SANITIZE_STRING);
    $pass = filter_var(trim($_POST['pass']),FILTER_SANITIZE_STRING);
    $pass = md5($pass);

    $result = $pdo->query("SELECT * FROM `users` WHERE `login`='$login' and `password`='$pass'");
    $user_id = $result->fetch(PDO::FETCH_LAZY);
    if (empty($user_id)) {
    echo "Такой пользователь не найден";
    $log->debug('Попытка входа пользователя: ', ['login' => $login]);
    exit();
    }
    
    session_start();
    $_SESSION['user_id']= $user_id['user_id'];
    $log->debug('Авторизация пользователя: ', ['user' => $user_id['name']]);

    header('Location: /');
}