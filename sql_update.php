<?php

require_once 'connection.php';
require_once 'bootstrap.php';
/*
$config = new Config;
$pdo = $config->Connect_PDO();
*/
$data=[':id' =>$_GET['id']];

$result = $pdo->prepare("UPDATE `todo_list` SET `task_done`=1 WHERE `task_id`=:id ");

try
    {
    $result->execute($data);
    $log->debug('Запись обновлена - выполнение задачи ', ['message' => $data[':id']]);
    }
    catch(PDOException $e){
    
        $log->error('Ошибка обновления записи: ', ['message' => $e->getMessage()]);
        echo $e->getMessage();
    
    }

header('Location: /'); 