<?php

if (substr($_SERVER['DOCUMENT_ROOT'], -1) != '/')
{
    $_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT'].'/';
}

define("PROTECTED_PATH", $_SERVER["DOCUMENT_ROOT"] . "protected/");
define("MODULES_PATH", $_SERVER["DOCUMENT_ROOT"] . "protected/modules/");
define("LIBRARY_PATH", PROTECTED_PATH . "libs/");

$yii = LIBRARY_PATH . 'yii/yii.php';

defined('YII_DEBUG') || define('YII_DEBUG',true);

defined('YII_TRACE_LEVEL') || define('YII_TRACE_LEVEL',3);

ini_set("display_errors", 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Moscow');

require_once($yii);

$session = new CHttpSession;
$session->open();

$config = $_SERVER['DOCUMENT_ROOT'] . 'protected/config/development.php';

Yii::createWebApplication($config)->run();


function p($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function v($data)
{
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}

?>



