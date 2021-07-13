<?php

require_once 'bootstrap.php';

//var_dump($result);
//print $_GET['id'];

$data=[':id' =>$_GET['id']]; //id записи

try
    {
    $result = $pdo->prepare("DELETE FROM `todo_list`WHERE `task_id`=:id ");
    $log->debug('Удаление записи ', ['message' => $data[':id']]);
    }
    catch(PDOException $e){
    
        $log->error('Ошибка удаления записи: ', ['message' => $e->getMessage()]);
        echo $e->getMessage();
    
    }

if($result->execute($data))

header('Location: /'); 