<?php
ini_set('error_reporting', E_ERROR);

!defined('APP_ROOT') && define('APP_ROOT', dirname(getcwd()) . '/');
require_once(APP_ROOT . 'bootstrap.php');

$all_sms = $manager->getRepository('SMSLog')->findAll();
foreach($all_sms as $sms){
    echo $sms->getMobile() . ":" . $sms->getContent() . "\n";
}
