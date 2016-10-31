<?php 
namespace Common\Model;
use Think\Model;

class InfoModel extends Model {

	/**
	 * 添加数据
	 * @param int $wine_id
	 * @param int $product_timestamp
	 * @param string $express
	 * @return mixed
	 */
	public function insertInfo($wine_id = 0, $product_timestamp = 0, $express = "") {
		$data = array(
			"wine_id" => $wine_id,
			"product_timestamp" => $product_timestamp,
			"express" => $express
		);
		return $this -> data($data) -> add();
	}

	/**
	 * 添加随机数
	 * @param null $id
	 * @param null $random
	 * @return bool
	 */
	public function insertRandom($id = null, $random = null) {
		$data = array(
			"query_random" => $random,
			"query_timestamp" => time()
		);
		return $this -> where("id=$id") -> save($data);
//		$this -> where("id=$id") -> setInc("query_times");
	}

	/**
	 * select数据
	 * @return mixed
	 */
	public function selectInfo($id = null) {
		if(is_numeric($id)) {
			return $this -> where("id=$id") -> find();
		} else {
			return $this -> select();
		}
	}

	/**
	 * select数据ByWine_id
	 * @param null $id
	 * @return mixed
	 */
	public function selectInfoByWineId($id = null) {
		return $this -> where("wine_id='$id'") -> find();
	}

	/**
	 * 使用验证码查询，0->正品 -1-> 赝品 -2->超时
	 * @param null $random
	 * @return int
	 */
	public function queryByRandom($random = null) {
		$infoResult = $this -> where('query_random="'.$random.'"') -> find();
		if($infoResult) {
			$nowTimestamp = time();
//			echo $nowTimestamp.'</br>';
//			echo $infoResult['query_timestamp']."</br>";
//			echo $nowTimestamp - $infoResult['query_timestamp'];
			if($nowTimestamp - $infoResult['query_timestamp'] <= 300) { //5分钟
				//不超时，查询次数+1返回成功0
//				$this -> where("id=".$infoResult['id']) -> setInc("query_times");	//查询次数+1
				return 0;
			} else {
				//超时返回-2
				return -2;
			}
		} else {
			//找不到到log表查询random是否被查询过，查询过返回-2超时标记，否则返回-1赝品标记
			$logModel = D("Log");
			$result = $logModel -> isQueryByRandom($random);
			if($result) {
				return -2;
			} else {
				return -1;
			}
		}
	}

	public function selectInfoByRandom($random = null) {
		return $this -> where('query_random="'.$random.'"') -> find();
	}

	/**
	 * 更新最后查询时间
	 * @param null $id
	 * @param null $timestamp
	 */
	public function updateQueryTimestamp($id = null, $timestamp = null) {
		$infoModel = D("Info");
		return $infoModel -> where("id=$id") -> setField('query_timestamp', $timestamp);
	}

}