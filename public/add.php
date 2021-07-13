<?php

# With composer we can autoload the Handlebars package
require_once 'bootstrap.php';
session_start();


//список пользователей
$result = $pdo->query("SELECT * from `users_list`");

$model_users =[];
while ($row = $result->fetch())
{
    $model_users[]=$row;
}



$model = ['title'=> "Новая задача", 'users'=>$model_users];
//var_dump($model);

// Авторизация пользователя
if (isset($_SESSION['user_id'])) {
    $result_user = $pdo->prepare("SELECT * FROM `users` WHERE `user_id`=?");
    $result_user->execute([$_SESSION['user_id']]);

    while ($row = $result_user->fetch()) {
        $user = array('user_name'=>$row['name'],'admin'=>$row['admin_rights'] );
    }
    $model += ['user'=>$user];
} else {
    $model += ['user'=>NULL];
}

echo $handlebars->render("new", $model);