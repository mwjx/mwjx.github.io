<?php
//------------------------------
//create time:2007-7-19
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:链接类目
//------------------------------
//本文件使用前要include基本函数库文件，数据库连接文件

function link_class($str = "")
{
	//链接类目
	//输入:str(string)归类信息,格式:
	//类目ID_文章ID_文章ID,类目ID_文章ID...
	//输出:true成功,不完全成功返回字符串说明
	//return true;
	//要考虑的问题:类目异常
	//文章不存在或异常
	//文章已经在类目中

	$arr = explode(",",$str);
	if(($len = count($arr)) < 1)
		return "提交列表不能为空";
	$arr_fail = array(); //失败的文章:类目ID(int)=>array(文章ID(int))
	my_safe_include("mwjx/class_info.php");
	for($i = 0;$i < $len; ++$i){
		if("" == $arr[$i])
			continue;
		$arr_a = explode("_",$arr[$i]);
		$len2 = count($arr_a);
		if($len2 < 2)
			continue;
		if(($fid = intval($arr_a[0])) < 1)
			continue;
		$obj = new c_class_info($fid);
		if($obj->get_id() < 1)
			continue;											
		for($j = 1;$j < $len2; ++$j){
			$cid = intval($arr_a[$j]);
			if(!$obj->add_link_class($cid)){ //失败
				//exit("失败");
				if(!isset($arr_fail[$cid]))							
					$arr_fail[$fid] = array();
				$arr_fail[$fid][] = $cid;
			}
			//exit("成功");
		}
		//link_article			
	}
	//return true;
	//结果
	if(count($arr_fail) < 1)
		return true; //成功
	$result = "";
	foreach($arr_fail as $fid=>$row){
		$len = count($row);
		if($len < 1)
			continue;
		if("" != $result)
			$result .= (",".strval($fid)."_");
		else
			$result .= (strval($fid)."_");
		$tmp = "";		
		for($i =0;$i < $len; ++$i){
			if("" != $tmp)
				$tmp .= "_";
			$tmp .= strval($row[$i]);
		}
		if("" != $tmp)
			$result .= $tmp;
	}
	return $result;
}

/*
//-------------tests-----------
require("../../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//----------归类文章-------
$info = "77_168";
var_dump(link_class($info));
//exit("aaaa");
*/
?>