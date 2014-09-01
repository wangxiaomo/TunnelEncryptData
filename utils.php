<?php

function &merge_data(&$cars, &$drivers){
    static $user_data = array();
    // 合并数据
    foreach($cars as $car){
        $key = '_' . $car->getMobile();
        if(!isset($user_data[$key])){
            $user_data[$key] = array(
                'cars'      =>  array(),
                'drivers'   =>  array(),
            );
        }
        $user_data[$key]['cars'][] = $car;
    }
    foreach($drivers as $driver){
        $key = '_' . $driver->getMobile();
        if(!isset($user_data[$key])){
            $user_data[$key] = array(
                'cars'      =>  array(),
                'drivers'   =>  array(),
            );
        }
        $user_data[$key]['drivers'][] = $driver;
    }
    return $user_data;
}

function check_vehicle_valid_date($mobile, $hpzl, $hphm){
    $valid_date = getVehicleValidDate($hpzl, $hphm);
    $valid_date_timestamp = strtotime($valid_date);
    $delta = $valid_date_timestamp - time();
    $days = (int)($delta/60/60/24);
    if($days > 0 && $days < 90){
        $context = sprintf("%s#%s#%s#%s#%s",
                        $mobile, 'vehicle_valid_date', $hpzl, $hphm, $valid_date);
        $hash = md5($context);
        // 判断是否发送过
        global $manager;
        $hash_log = $manager->getRepository('SMSHash')->findBy(array('hash'=>$hash));
        if(!$hash_log){
            $hash_log = new SMSHash;
            $hash_log->add('vehicle_valid_date', $mobile, $hash);

            $manager->persist($hash_log);
            $manager->flush();
            return $valid_date;
        }
    }
}

function check_vehicle_abandoned_date($mobile, $hpzl, $hphm){
    $abandoned_date = getVehicleAbandonedDate($hpzl, $hphm);
    $abandoned_date_timestamp = strtotime($abandoned_date);
    $delta = $abandoned_date_timestamp - time();
    $days = (int)($delta/60/60/24);
    if($days > 0 && $days < 90){
        $context = sprintf("%s#%s#%s#%s#%s",
                        $mobile, 'vehicle_abandoned_date', $hpzl, $hphm, $abandoned_date);
        $hash = md5($context);
        // 判断是否发送过
        global $manager;
        $hash_log = $manager->getRepository('SMSHash')->findBy(array('hash'=>$hash));
        if(!$hash_log){
            $hash_log = new SMSHash;
            $hash_log->add('vehicle_abandoned_date', $mobile, $hash);

            $manager->persist($hash_log);
            $manager->flush();
            return $abandoned_date;
        }
    }
}

function check_driver_valid_date($mobile, $jszh){
    $valid_date = getDrivingLicenseValidDate($jszh);
    $valid_date_timestamp = strtotime($valid_date);
    $delta = $valid_date_timestamp - time();
    $days = (int)($delta/60/60/24);
    if($days > 0 && $days < 90){
        $context = sprintf("%s#%s#%s#%s",
                        $mobile, 'driver_valid_date', $jszh, $valid_date);
        $hash = md5($context);
        // 判断是否发送过
        global $manager;
        $hash_log = $manager->getRepository('SMSHash')->findBy(array('hash'=>$hash));
        if(!$hash_log){
            $hash_log = new SMSHash;
            $hash_log->add('driver_valid_date', $mobile, $hash);

            $manager->persist($hash_log);
            $manager->flush();
            return $valid_date;
        }
    }
}

function check_driver_score($mobile, $jszh){
    $score = getDrivingLicenseScore($jszh);
    if($score < 6) return;

    if($score > 6 && $score < 9) $status = '6-9';
    if($score > 9) $status = '9-12';

    $context = sprintf("%s#%s#%s#%s",
                    $mobile, 'driver_score', $jszh, $status);
    $hash = md5($context);
    // 判断是否发送过
    global $manager;
    $hash_log = $manager->getRepository('SMSHash')->findBy(array('hash'=>$hash));
    if(!$hash_log){
        $hash_log = new SMSHash;
        $hash_log->add('driver_score', $mobile, $hash);

        $manager->persist($hash_log);
        $manager->flush();
        return $score;
    }
}

function check_vehicle_mistake($mobile, $hpzl, $hphm){
    $record = getVehicleViolation($hpzl, $hphm);
    if(!$record) return;

    $context = sprintf("%s#%s#%s#%s#%s#%s",
                    $mobile, 'vehicle_mistake', $hpzl, $hphm, $record['wfsj'], $record['wfxw']);
    $hash = md5($context);
    // 判断是否发送过
    global $manager;
    $hash_log = $manager->getRepository('SMSHash')->findBy(array('hash'=>$hash));
    if(!$hash_log){
        $hash_log = new SMSHash;
        $hash_log->add('vehicle_mistake', $mobile, $hash);

        $manager->persist($hash_log);
        $manager->flush();
        return $record;
    }
}

function check_driver_mistake($mobile, $jszh){
    $record = getDrivingLicenseViolation($jszh);
    if(!$record) return;

    $context = sprintf("%s#%s#%s#%s#%s",
                    $mobile, 'driver_mistake', $jszh, $record['wfsj'], $record['wfxw']);
    $hash = md5($context);
    // 判断是否发送过
    global $manager;
    $hash_log = $manager->getRepository('SMSHash')->findBy(array('hash'=>$hash));
    if(!$hash_log){
        $hash_log = new SMSHash;
        $hash_log->add('driver_mistake', $mobile, $hash);

        $manager->persist($hash_log);
        $manager->flush();
        return $record;
    }
}
