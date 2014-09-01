<?php

require_once('vendor/autoload.php');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array('./schema');
$debug = false;

$db_config = array(
    'driver'        =>  'pdo_mysql',
    'host'          =>  'localhost',
    'dbname'        =>  'app_test',
    'user'          =>  'root',
    'password'      =>  'root',
    'port'          =>  '3306',
    'driverOptions' =>  array(
        1002        =>  'SET NAMES utf8',
    ),
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $debug);
$manager = EntityManager::create($db_config, $config);

// load schema references
!defined('APP_ROOT') && define('APP_ROOT', getcwd() . '/');
define('SCHEMA_PATH', APP_ROOT . 'schema/');
require_once(SCHEMA_PATH . 'common.php');

function autoload_user_class($classname){
    $file = SCHEMA_PATH . $classname . '.php';
    if(is_file($file)){
        require_once($file);
        return true;
    }
    return false;
}
spl_autoload_register('autoload_user_class', $throw=true, $prepend=true);
