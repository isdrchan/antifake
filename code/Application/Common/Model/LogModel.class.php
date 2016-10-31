<?php 
namespace Common\Model;
use Think\Model;

class LogModel extends Model {

    public function addLog($info_id = null, $ip = null, $gps = null, $location = null, $query_random = null) {
        $nowTimestamp = time();
//        //先更新info表相应id的查询时间
//        $infoModel = D("Info");
//        $infoModel -> updateQueryTimestamp($info_id, $nowTimestamp);
        
        $data = array(
            "info_id" => $info_id,
            "ip" => $ip,
            "gps" => $gps,
            "location" => $location,
            "query_random" => $query_random,
            "timestamp" => $nowTimestamp
        );
        return $this -> data($data) -> add();
    }

    public function selectLogByInfoId($id = null) {
        return $this -> where("info_id=$id") -> order('timestamp desc') -> limit(9) -> select();
    }

    public function selectLogByRandom($random = null) {
        return $this -> where('query_random="'.$random.'"') -> order('timestamp desc') ->  limit(9) ->find();
    }

    /**
     * 验证码是否被查询过（log表中是否有该random的记录）
     * @param $random
     */
    public function isQueryByRandom($random) {
        $result = $this -> where('query_random="'.$random.'"') -> find();
        if($result) {
            return true;
        } else {
            return false;
        }
    }

}