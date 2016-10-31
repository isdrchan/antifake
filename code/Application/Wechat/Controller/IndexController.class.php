<?php
namespace Wechat\Controller;
use Think\Controller;

class IndexController extends Controller {

	public function _initialize() {
		//公众号配置
		define("TOKEN", "");
		define("APP_ID", "");
		define("APP_SECRET", "");
		define("ROOT_URL", getRootUrl());
	}

    public function index() {
		//判断请求是验证接口还是请求回复
		if(isset($_GET['echostr'])) {
			$this -> valid();
			exit;
		} else {
			$this -> responseMsg();
		}
    }
    
    /**
	* 收到文本信息时
	*/
	private function onText($textTpl, $fromUsername, $toUsername, $time, $msgType, $content) {
	    if(strlen($content) == 8) {
	        $tpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[news]]></MsgType>
					<ArticleCount>1</ArticleCount>
					<Articles>";
			$tpl .= "<item>
    				<Title><![CDATA[%s]]></Title> 
    				<Description><![CDATA[%s]]></Description>
    				<PicUrl><![CDATA[%s]]></PicUrl>
    				<Url><![CDATA[%s]]></Url>
    				</item>";
			$tpl .= "</Articles>
					</xml> ";
	        $infoModel = D("Info");
	        $result = $infoModel -> queryByRandom($content);
	        if($result == 0) {
	            //不超时
    	        $title = "恭喜您!您的防伪码".$content."为茅台官方出品。";
    	        $description = "茅台酒产于中国西南贵州省仁怀市茅台镇，同英国苏格兰威士忌和法国柯涅克白兰地并称为“世界三大名酒”。";
    	        $picUrl = ROOT_URL."Public/pic/wechat_pic1.png";
    	        $url = ROOT_URL.u("Home/Index/query", array("random" => $content));
	        } else {
	            //超时和不通过
	            $title = "请注意!您的防伪码".$content."验证失败!";
	            $description = "点击查看详情";
	            $picUrl = "";
	            $url = ROOT_URL.u("Home/Index/query", array("random" => $content));
	        }
	        echo sprintf($tpl, $fromUsername, $toUsername, $time, $title, $description, $picUrl, $url);
	    } else if($content == "url") {
	        $str = "http://mt.chenyuning.cn/?id=DRCHAN9405\nhttp://mt.chenyuning.cn/?id=ABC123ABC\nhttp://mt.chenyuning.cn/?id=OKOK12312";
		    echo sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $str);
	    } else {
	        $str = '请输入8位数的动态防伪码';
		    echo sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $str);
	    }
	    exit;
	}

	private function responseMsg()
	{
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		//extract post data
		if (!empty($postStr)){
			/* libxml_disable_entity_loader is to prevent XML eXternal Entity Injection,
               the best way is to check the validity of xml by yourself */
			libxml_disable_entity_loader(true);
			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$msgType = $postObj->MsgType;	//消息类型
			$event = $postObj->Event;
			$content = trim($postObj->Content);
			$time = time();
			$textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
// 			$ok = $postStr;
//             @file_put_contents("test1.txt", $ok);
			//事件处理
			switch($msgType) {
				case 'event':
					switch ($event) {
						//有新关注
						case 'subscribe': $this -> onSubscribe($textTpl, $fromUsername, $toUsername, $time); break;
						//有取消关注
						case 'unsubscribe': $this -> onUnsubscribe(); break;
						case 'CLICK' :
							switch ($postObj -> EventKey) {
								case "DISCOUNT": $this -> onClickDISCOUNT($textTpl, $fromUsername, $toUsername, $time, "text"); break;
							}
							switch ($postObj -> EventKey) {
								case "SEARCH": $this -> onClickSEARCH($textTpl, $fromUsername, $toUsername, $time, "text"); break;
							}
					}
					break;
				case 'text': $this -> onText($textTpl, $fromUsername, $toUsername, $time, $msgType, $content); break;
			}
			
		}else {
			echo "";
			exit;
		}
	}
	
	/**
	* 用户关注时
	*/
	private function onSubscribe($textTpl, $fromUsername, $toUsername, $time) {
        $str = "你好，欢迎关注茅台防伪查询！\n输入动态验证码即可查询真伪";
        // $ok = $str;
        //     @file_put_contents("test1.txt", $ok);
		echo sprintf($textTpl, $fromUsername, $toUsername, $time, "text", $str);
		exit;
	}

	/**
	 * 验证接口时调用valid()
	 */
	private function valid() {
		$echoStr = $_GET["echostr"];

		//valid signature , option
		if($this->checkSignature()){
			echo $echoStr;
			exit;
		}
	}

	private function checkSignature() {
		$signature = $_GET["signature"];
		$timestamp = $_GET["timestamp"];
		$nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);

		if ($tmpStr == $signature) {
			return true;
		} else {
			return false;
		}
	}
    
}
