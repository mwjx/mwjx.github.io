<?php
//------------------------------
//create time:2007-1-11
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:文章归类
//------------------------------
//本文件使用前要include基本函数库文件，数据库连接文件

function article_reset($str = "")
{
	//文章归类,将文章链接到其它类目
	//输入:str(string)归类信息,格式:
	//类目ID_文章ID_文章ID,类目ID_文章ID...
	//输出:true成功,不完全成功返回字符串说明
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
		if(($cid = intval($arr_a[0])) < 1)
			continue;
		$obj = new c_class_info($cid);
		if($obj->get_id() < 1)
			continue;											
		for($j = 1;$j < $len2; ++$j){
			$aid = intval($arr_a[$j]);
			if(!$obj->link_article($aid)){ //失败
				if(!isset($arr_fail[$cid]))							
					$arr_fail[$cid] = array();
				$arr_fail[$cid][] = $aid;
			}
		}
		//link_article			
	}
	//return true;
	//结果
	if(count($arr_fail) < 1)
		return true; //成功
	$result = "";
	foreach($arr_fail as $cid=>$row){
		$len = count($row);
		if($len < 1)
			continue;
		if("" != $result)
			$result .= (",".strval($cid)."_");
		else
			$result .= (strval($cid)."_");
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
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//----------归类文章-------
$info = "53_7506";
var_dump(article_reset($info));
//exit("aaaa");
*/
?>