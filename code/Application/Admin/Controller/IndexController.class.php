<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function login() {
        $this -> display();
    }

    public function index() {
        $this -> redirect('login');
    }

    public function main() {
        $infoModel = D('Info');
        $result = $infoModel -> selectInfo();
        $this -> assign("info", $result);
        $this -> display();
    }

    public function add($wine_id = 0, $product_timestamp = 0, $express = "") {
        if($_POST) {
            $infoModel = D('Info');
            $product_timestamp = strtotime($product_timestamp); //转时间戳
            $result = $infoModel -> insertInfo($wine_id, $product_timestamp, $express);
            if($result) {
                $this -> success("添加成功", U("main"));
            } else {
                $this -> success("添加失败", "javascript:window.history.go(-1);");
            }
        } else {
            $this -> display();
        }
    }

    public function base() {
        $this -> display();
    }
}