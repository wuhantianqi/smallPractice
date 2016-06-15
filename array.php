<?php
	/**
	 * 数组常用操作函数
	 */
	/**
	 * 递归将多维数组转成一维数组
	 * @param  array $arr [description]
	 * @return array      [description]
	 */
	function manyArrayToOneArray($arr){
		// static $result_array=array();
		// foreach($arr as $k=>$v){
		// 	if(is_array($v)){
		// 		manyArrayToOneArray($v);
		// 	}else{
		// 		$result_array[]=$v;
		// 	}
		// }
		// return $result_array;
		
	}


	$array=array("1"=>array("A","B","C",array("D","E")),"2"=>array("F","G","H","I"));
	var_dump(manyArrayToOneArray($array));