<?php

require_once 'bootstrap.php';

//Добавление контакта
$data=[];

$data=[
    ':task_date'=>$_POST['task_date'],
    ':task_name'=>$_POST['task_name'],
    ':task_priority'=>$_POST['task_priority'],
    ':task_user'=>$_POST['user']
    
    ];

var_dump($data);    


$result = $pdo->prepare("INSERT INTO `todo_list`(`task_date`, 
                                                `task_name`,
                                                `task_priority`,
                                                `user_id`
                                                ) 
                                                VALUES  (:task_date, 
                                                        :task_name,  
                                                        :task_priority,
                                                        :task_user) ");
try
    {
    $result->execute($data);
    $log->debug('Добавлена запись в лист ', ['message' => $data[':task_name']]);
    }
catch(PDOException $e)
    {
    
        $log->error('Ошибка добавления записи в лист ', ['message' => $e->getMessage()]);
        echo $e->getMessage();
    
    }
//print_r($_FILES['image']);

header('Location: /');
