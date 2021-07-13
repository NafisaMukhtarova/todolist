<?php

require 'bootstrap.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

$host = $_ENV['MAIL_HOST'];
$username = $_ENV['MAIL_USERNAME'];
$pass = $_ENV['MAIL_PASSWORD'];

try {
    //Server settings
    $mail->CharSet = "utf-8";
    $mail->SMTPDebug = 0;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $host;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $username;                     //SMTP username
    $mail->Password   = $pass;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail_address = $_GET['mail'];


    $mail->setFrom('nafisa@ufa-lanka.com', 'BOSS');
    $mail->addAddress($mail_address);     //Add a recipient
     

    

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Сообщение для :'. $_GET['name'];
    $mail->Body    = $_GET['name'].'!!! Вам назначено задание: '.$_GET['task']. ' Дата выполнения:  '.$_GET['date'];
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

    $log->debug('Message has been sent ', ['message' => $_GET['task'],'mail' => $_GET['mail']]);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            //$log = new Logger('send_mail.php');
            // $log->pushHandler(new StreamHandler(__DIR__ .'/logs/debug/log', Logger::DEBUG));
            
            $log->error('Message could not be sent. Mailer Error: ', ['message' => $mail->ErrorInfo]);
}