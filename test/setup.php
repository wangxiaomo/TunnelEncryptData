<?php
ini_set('error_reporting', E_ERROR);

!defined('APP_ROOT') && define('APP_ROOT', dirname(getcwd()) . '/');
require_once(APP_ROOT . 'bootstrap.php');

$CARS = array(
    array('A', '15296615321', 'A51231', '02'),
    array('B', '18123123123', 'A51232', '02'),
    array('A', '15296615321', 'A51233', '02'),
);

foreach($CARS as $v){
    list($name, $mobile, $hphm, $hpzl) = $v;
    
    $car = new Car();
    $car->setName($name);
    $car->setMobile($mobile);
    $car->setTime(new DateTime('now'));
    $car->setCarInfo($hpzl, $hphm);

    $manager->persist($car);
    $manager->flush();
    
    echo "car id: " . $car->getID() . " job done\n";
}

$DRIVERS = array(
    array('A', '15296615321', '123123123123'),
    array('C', '18123123123', '1234124141414'),
);

foreach($CARS as $v){
    list($name, $mobile, $jszh) = $v;
    
    $driver = new Driver();
    $driver->setName($name);
    $driver->setMobile($mobile);
    $driver->setTime(new DateTime('now'));
    $driver->setDriverInfo($jszh);

    $manager->persist($driver);
    $manager->flush();

    echo "driver id: " . $driver->getID() . " job done\n";
}
