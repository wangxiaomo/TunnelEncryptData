<?php

function getDrivingLicenseScore($jszh, $score=0){
    return $score;
}

function getDrivingLicenseViolation($jszh, $records=null){
    if($records) return $records;

    return array(
        'wfsj'  =>  '2014-08-21 12:00:00',
        'wfdz'  =>  '山西太原',
        'wfxw'  =>  '醉驾',
        'wfms'  =>  '醉驾',
        'wfjfs' =>  12,
        'fkje'  =>  200,
        'fxjg'  =>  'fxjg',
        'fxjgmc'=>  'fxjgmc',
        'cljg'  =>  'cljg',
        'cljgmc'=>  'cljgmc',
        'clsj'  =>  '2014-08-23 12:00:00',
        'jkbj'  =>  0,
    );
}

function getDrivingLicenseValidDate($jszh, $date='2014-10-01'){
    return $date;
}

function getVehicleValidDate($hpzl, $hphm, $date='2014-10-01'){
    return $date;
}

function getVehicleAbandonedDate($hpzl, $hphm, $date='2014-10-01'){
    return $date;
}

function getVehicleViolation($hpzl, $hphm, $records=null){
    if($records) return $records;

    return array(
        'wfsj'  =>  '2014-08-21 12:00:00',
        'wfdz'  =>  '山西太原',
        'wfxw'  =>  '醉驾',
        'wfms'  =>  '醉驾',
        'wfjfs' =>  12,
        'fkje'  =>  200,
        'fxjg'  =>  'fxjg',
        'fxjgmc'=>  'fxjgmc',
        'cljg'  =>  'cljg',
        'cljgmc'=>  'cljgmc',
        'clsj'  =>  '2014-08-23 12:00:00',
        'jkbj'  =>  0,
    );
}

function generate_sms_content($content=null){
    if(!$content) $content = '测试短信';
    return $content;
}
