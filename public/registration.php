<?php

require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

$model = ["header"=>"Регистрация"];
echo $handlebars->render("reg_form", $model); 

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $name = filter_var(trim($_POST['name']),FILTER_SANITIZE_STRING);
$login = filter_var(trim($_POST['login']),FILTER_SANITIZE_STRING);
$pass = filter_var(trim($_POST['pass']),FILTER_SANITIZE_STRING);



if(mb_strlen($name) < 3 || mb_strlen($name)>90)
{
    echo "Недопустимая длина логина";
    exit();
} 
elseif(mb_strlen($login) < 3 || mb_strlen($login)>90)
{
    echo "Недопустимая длина имени";
    exit();
} 
elseif(mb_strlen($pass) < 2 || mb_strlen($pass)>50)
{
    echo "Недопустимая длина пароля";
    exit();
} 



$pass = md5($pass);

$data = [':login'=>$login,':name'=>$name,':pass'=>$pass];

$result = $pdo->prepare("INSERT INTO `users`(`login`,`name`,`password`) VALUES (:login,:name,:pass)");

try {
    $result->execute($data);
    $log->debug('Добавлен пользователь', ['name' => $data[':name'], 'id'=>$pdo->lastInsertId()]);
} catch(PDOException $e) {
        $log->error('Ошибка добавления пользователя', ['message' => $e->getMessage()]);
        echo $e->getMessage();
    }

header('Location: /');

}
