<?php
# With composer we can autoload the Handlebars package
require_once ("./vendor/autoload.php");
require_once 'connection.php';
require_once 'bootstrap.php';

# If not using composer, you can still load it manually.
# require 'src/Handlebars/Autoloader.php';
# Handlebars\Autoloader::register();


//список контактов для левой части экрана
$result = $pdo->prepare("SELECT A.`task_date`, A.`task_name`, A.`task_priority`, A.`task_done`, A.`task_id`, B.`user_name`, B.`user_mail`FROM `todo_list`A, `users_list`B WHERE A.`user_id`=B.`user_id` ORDER BY A.`task_date`DESC,A.`task_priority` DESC ");

//???????????????????????????????????
//ВОПРОС ИСПОЛЬЗОВАНИЯ ЛОГИРОВАНИЯ
//Данный скрипт не отработал если не правильное имя таблицы


try {
    $result->execute();

    $log->debug('Удачное подключение ', ['message' => 'success']);
    
}
catch(PDOException $e){
    
    $log->error('Ошибка execute: ', ['message' => $e->getMessage()]);
    echo $e->getMessage();

}

    

$data =[];//подмассив с задачами 
$data_model =[];//массив дат
$task_date;
//var_dump($result);

while ($row = $result->fetch())
{
    $selected="";
    $text_del="";
    if($row['task_done']=='1')
    {
        $selected = 'checked';
        $text_del = 'text_del';
    }
    else 
    {
        $selected = '';
        $text_del='';
    }

    $data_row = ['task_date'=>$row['task_date'],'task_name'=>$row['task_name'],'task_priority'=>$row['task_priority'],'task_checkbox'=>$selected,'task_text'=>$text_del,'task_id'=>$row['task_id'],'user_name'=>$row['user_name'],'user_mail'=>$row['user_mail']];
    //echo $row['task_name'];
    //echo "<br>СТРОКА<br>";
    //var_dump($selected);
    //var_dump($data_row);
    //echo "<br>";
    if($task_date==$row['task_date'] )
    {
    
        //собираем подмассив
     $data[] = $data_row;
     

    }
    else
    {
        
        
        //var_dump($data);
        //предыдущий подмассив
        if($task_date!=Null)
        $data_model[] = ['date'=> $task_date,'tasks'=>$data];
        //обнуляем
        $data=[];
        //собираем новый подмассив
        $data[] = $data_row;
        //новая дата
        $task_date = $row['task_date'];
    }
}
//последний подмассив
$data_model[] = ['date'=> $task_date,'tasks'=>$data];

//var_dump($data);
//var_dump($data_model);
$model = ['list'=>$data_model];
//var_dump($model);
echo $handlebars->render("main", $model);
