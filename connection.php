<?php 


require_once ("./vendor/autoload.php");


use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class Config
{
    private $user = 'my_dbuser'; // пользователь

    private $password = 'Mba25fly!'; // пароль
    
    private $db = 'my_db'; // название бд
    
    private $host = 'localhost'; // хост
    
    private $charset = 'utf8'; // кодировка

    private $log_con;
    

    public function Connect_PDO($log_con)
    {
        $this->log_con = $log_con;
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->user, $this->password,
            array (PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
                );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $e) {
                echo "ОШИБКА Connect.php";
                //die($e->getMessage());
        
                $this->log_con->debug('Ошибка Connect.php: ', ['message' => $e->getMessage()]);
            }

        $pdo->query("SET NAMES 'utf8'");

        $pdo->query("SET CHARACTER SET 'utf8';");
        $pdo->query("SET SESSION collation_connection = 'utf8_general_ci';");


        return $pdo;
    }


}