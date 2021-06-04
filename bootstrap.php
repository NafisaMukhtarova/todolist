<?php
use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once 'connection.php';


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



$config = new Config;
$pdo = $config->Connect_PDO($log);
