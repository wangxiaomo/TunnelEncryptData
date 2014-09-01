<?php
ini_set('error_reporting', E_ERROR);

require_once('bootstrap.php');
require_once('utils.php');

// mock api
require_once('mock/api.php');

$all_cars = $manager->getRepository('Car')->findAll();
$all_drivers = $manager->getRepository('Driver')->findAll();

$user_data = merge_data($all_cars, $all_drivers);

foreach(array_values($user_data) as $user){
    $context = array();
    // 依次对用户数据进行接口查询
    foreach($user['cars'] as $car){
        $car_sms_val = array();
        list($hpzl, $hphm) = $car->getCarInfo();
        $mobile = $car->getMobile();
        $valid_date = check_vehicle_valid_date($mobile, $hpzl, $hphm);
        $abandoned_date = check_vehicle_abandoned_date($mobile, $hpzl, $hphm);
        $mistake = check_vehicle_mistake($mobile, $hpzl, $hphm);
        if($valid_date) $car_sms_val[] = "您的车辆${hphm}需要年检";
        if($abandoned_date) $car_sms_val[] = "您的车辆${hphm}马上报废";
        if($mistake) $car_sms_val[] = "${hphm}有违法未处理";

        if($car_sms_val){
            $context = array_merge($context, $car_sms_val);
            break;   
        }
        $car->refreshToken();
    }

    foreach($user['drivers'] as $driver){
        $driver_sms_val = array();
        $jszh = $driver->getDriverInfo();
        $mobile = $driver->getMobile();
        $valid_date = check_driver_valid_date($mobile, $jszh);
        $score = check_driver_score($mobile, $jszh);
        $mistake = check_driver_mistake($mobile, $jszh);
        if($valid_date) $driver_sms_val[] = "您的驾驶证${jszh}需要期满换证";
        if($score) $driver_sms_val[] = "您的驾驶证${jszh}积分" . $score;
        if($mistake) $driver_sms_val[] = "${jszh}有违法未处理";

        if($driver_sms_val){
            $context = array_merge($context, $driver_sms_val);
            break;   
        }
        $driver->refreshToken();
    }

    if($context){
        // 写入短信中
        $sms = new SMSLog;
        $sms->add($mobile, implode("", $context));
        $manager->persist($sms);
        echo "$mobile: " . implode("", $context) . "\n";
    }
    $manager->flush();
}
