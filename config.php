<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    /**
     * @author Tom Heek
     * @copyright 2014
     */

    session_start();
    ob_start();

    header('Content-Type: text/html; charset=utf-8');
    $path = str_replace($_SERVER['DOCUMENT_ROOT'], $_SERVER['SERVER_NAME'] . '/', dirname(__FILE__));
    $mysqldb    = 'localhost';  //Mysql database
    $dbname     = 'goatbb';           //Mysql database name
    $mysqluser  = '';           //Mysql username
    $mysqlpass  = '';           //Mysql password

    try{
        $handler = new PDO('mysql:host=' . $mysqldb . ';dbname=' . $dbname, $mysqluser, $mysqlpass);
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo $e->getMessage();
        //die('Something went wrong, please try again.');
    }

    $website_url = "http://$_SERVER[HTTP_HOST]/goatbb/";
    $contactemail = "";

    require_once'lang.php';
    require_once'init.php';
    require_once'htmlpurifier/HTMLPurifier.auto.php';
    require'phpmailer/PHPMailerAutoload.php';
    $mailer = '1';

    $mail = new PHPMailer;
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = '';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = '';                 // SMTP username
    $mail->Password = '';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 2525;                                    // TCP port to connect to

    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>
