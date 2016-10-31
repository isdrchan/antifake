<?php

function randStr($len = 8, $format = 'ALL') {
    $is_abc = $is_numer = 0;
    $password = $tmp ='';
    switch($format){
        case 'ALL':
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            break;
        case 'CHAR':
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            break;
        case 'NUMBER':
            $chars='0123456789';
            break;
        default :
            $chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            break;
    }
    mt_srand((double)microtime()*1000000*getmypid());
    while(strlen($password)<$len){
        $tmp =substr($chars,(mt_rand()%strlen($chars)),1);
        if(($is_numer <> 1 && is_numeric($tmp) && $tmp > 0 )|| $format == 'CHAR'){
            $is_numer = 1;
        }
        if(($is_abc <> 1 && preg_match('/[a-zA-Z]/',$tmp)) || $format == 'NUMBER'){
            $is_abc = 1;
        }
        $password.= $tmp;
    }
    if($is_numer <> 1 || $is_abc <> 1 || empty($password) ){
        $password = randStr($len,$format);
    }
    return $password;
}

/**
 * 获取完整URL地址
 */
function getRootUrl() {
    $url = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["SERVER_NAME"].$_SERVER['SCRIPT_NAME'];
    $url = substr ($url, 0, -9);
    return $url;
}

/**
 * 调用高德获取位置
 * @param null $ip
 * @param null $location
 */
function getLocationInfo($ip = null, $location = null) {
    $AMAP_KEY = "";
    $IP_URL = "http://restapi.amap.com/v3/ip";
    $LOCATION_URL = "http://restapi.amap.com/v3/geocode/regeo";

    //有ip则用ip查询，无则用经纬度查询
    if(!is_null($ip)) {
        $url = $IP_URL."?key=".$AMAP_KEY."&ip=".$ip;
    } else {
        $url = $LOCATION_URL."?key=".$AMAP_KEY."&location=".$location;
    }
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    //执行并获取HTML文档内容
    $result = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    return $result;
}
