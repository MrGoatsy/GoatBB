<?php
    error_reporting(E_ALL);
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
    $mysqluser  = 'root';           //Mysql username
    $mysqlpass  = '';           //Mysql password

    try{
        $handler = new PDO('mysql:host=' . $mysqldb . ';dbname=' . $dbname, $mysqluser, $mysqlpass);
        $handler->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        //echo $e->getMessage();
        die('Something went wrong, please try again.');
    }

    $website_url = "http://$_SERVER[HTTP_HOST]/goatbb/";
    $contactemail = "noreply@ayy.pw";

    require_once'lang.php';
    require_once'init.php';
    require_once '/htmlpurifier/HTMLPurifier.auto.php';

    $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
?>
