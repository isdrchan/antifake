<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index($id = null) {
        if($id) {
            $infoModel = D('Info');
            $result = $infoModel -> selectInfoByWineId($id);
            if($result) {
                $randStr = randStr(8);
                $infoModel -> insertRandom($result['id'], $randStr);
//                echo "请将以下验证码复制到微信公众号mrhelper以完成验证";
//                echo '<br>';
//                echo $randStr;
//                echo '<br>';
//                echo $_SERVER['REMOTE_ADDR'];
//                echo '<br>';
//                print_r($result);
                $this -> assign("rand", $randStr);
                $this -> assign("ip", $_SERVER['REMOTE_ADDR']);
                $this -> display();
            } else {
                $this -> display("query_false");
            }
        } else {
            $this -> error("非法访问");
        }
    }

    /**
     * 获取位置的API，把查询记录insert到log表
     * @param null $id
     * @param null $location
     */
    public function getLocation($random = null, $location = null) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $locationFlg = false; //经纬度查询成功的标记，成功就不用进行ip查询
        $locationStr = "未知";
        if($location) {
            //有经纬度信息，进行经纬度查询
            $locationArray = json_decode(getLocationInfo(null, $location), true);
            if($locationArray['status'] == 1) {
                //返回成功
                $locationFlg = true;
                $locationStr = $locationArray['regeocode']['formatted_address'];
            }
        }
        if(!$locationFlg) {
            //经纬度查询失败，用ip查询
            if($ip == "127.0.0.1") $ip = "113.74.76.136";  //测试用
            $locationArray = json_decode(getLocationInfo($ip), true);
            if($locationArray['status'] == 1) {
                $locationStr = $locationArray['province'].$locationArray['city'];
            }
        }
        //根据random select info表中的数据，写入Log表
        $infoModel = D("Info");
        $logModel = D("Log");
        //随机验证码不超时并且未被查询过才写入Log表
        if(($infoModel -> queryByRandom($random)) == 0 && !($logModel -> isQueryByRandom($random))) {
            //根据随机数获取info表中对于行的记录
            $infoResult = $infoModel -> selectInfoByRandom($random);
            if ($infoResult) {
                $logModel -> addLog($infoResult['id'], $ip, $location, $locationStr, $random);
            }
            $infoModel -> where("id=".$infoResult['id'])->setInc("query_times");  //查询次数+1
        }
        echo json_encode(
            array(
                "location_str" => $locationStr
            ), true);
        exit;
    }
    
    public function query($random = null) {
        if($random) {
            //参数有随机字符串
            $infoModel = D('Info');
            $resultFlg = $infoModel -> queryByRandom($random);
            if($resultFlg == 0) {
                //找到提示正品
                $logModel = D("Log");
                $infoResult = $infoModel -> selectInfoByRandom($random);
                $logResult = $logModel -> selectLogByInfoId($infoResult['id']);
                $this -> assign("log", $logResult);
                $this -> assign("ip", $_SERVER['REMOTE_ADDR']);
                $this -> assign("info", $infoResult);
                $this -> assign("nowtime", time());
                $this -> assign("random", $random);
                $this -> display("query");
            } elseif($resultFlg == -1) {
                //赝品
                $this -> display("query_false");
            } else {
                //超时
                $this -> display("query_overtime");
            }
        } else {
            //参数无随机字符串，提示赝品
            $this -> display("query_false");
        }

    }

}