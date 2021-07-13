<?php

require_once 'bootstrap.php';
/*
# With composer we can autoload the Handlebars package
require_once 'connection.php';

# If not using composer, you can still load it manually.
# require 'src/Handlebars/Autoloader.php';
# Handlebars\Autoloader::register();

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

# Set the partials files
$partialsDir = __DIR__."/templates";
$partialsLoader = new FilesystemLoader($partialsDir,
    [
        "extension" => "html"
    ]
);

# We'll use $handlebars throughout this the examples, assuming the will be all set this way
$handlebars = new Handlebars([
    "loader" => $partialsLoader,
    "partials_loader" => $partialsLoader
]);
*/

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $model = ['title'=> "Новый исполнитель"];
    //var_dump($model);

    echo $handlebars->render("new_user", $model);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //$config = new Config;
    //$pdo = $config->Connect_PDO();
    
    $data=[];

    $data=[
    ':uname'=>$_POST['UserName'],
    ':umail'=>$_POST['UserEmail']];
    
    $result = $pdo->prepare("INSERT INTO `users_list` (`user_name`,`user_mail`) VALUES (:uname,:umail)");
    
    try {
    $result->execute($data);
    $log->debug('Добавлен исполнитель ', ['uname' => $_POST['UserName'],'umail'=>$_POST['UserEmail'] ]);
    } catch(PDOException $e) {
            $log->error('Ошибка добавления исполнителя ', ['message' => $e->getMessage()]);
            echo $e->getMessage();
    }

    //header('Location: /.php');
    header('Location: /add.php');
}