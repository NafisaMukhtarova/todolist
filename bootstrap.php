<?php

require_once ("./vendor/autoload.php");

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$log = new Logger('index.php');
$log->pushHandler(new StreamHandler(__DIR__ .'/logs/debug/log', Logger::DEBUG));

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



class Config
{
    private $user = ''; // пользователь

    private $password = ''; // пароль
    
    private $db = ''; // название бд
    
    private $host = ''; // хост
    
    private $charset = 'utf8'; // кодировка
    
    private $log;

    public function __construct($db,$user,$pass,$host)
    {
        $this->db = $db;
        $this->user = $user;
        $this->password = $pass;
        $this->host = $host;
        
    }


    public function Connect_PDO($log) 
    {
        $this->log = $log;
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset",
                        $this->user, 
                        $this->password,
                        array (PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
                        );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->log->debug('Подключение bootstrap.php: ', ['message' => 'успешно']);
            $pdo->query("SET NAMES 'utf8'");
            $pdo->query("SET CHARACTER SET 'utf8';");
            $pdo->query("SET SESSION collation_connection = 'utf8_general_ci';");
        } catch (PDOException $e) {
            echo "ОШИБКА Connect.php";
            $this->log->debug('Ошибка bootstrap.php: ', ['message' => $e->getMessage()]);
        }
        
        return $pdo;
    }


}
//var_dump($_ENV);
$config = new Config(getenv('CONFIG_DB'),getenv('CONFIG_USER'),getenv('CONFIG_PASSWORD'),getenv('CONFIG_HOST'));
$pdo = $config->Connect_PDO($log);
