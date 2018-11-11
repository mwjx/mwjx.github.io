<?php
//------------------------------
//create time:2007-1-15
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:发布文章
//------------------------------
function post_article($title = "",$content = "",$clist = "",$poster = "",$good="N")
{
	//发布文章
	//输入:title标题,content内容,clist放置类目ID列表,逗号分隔(1,2,3)
	//poster发表人帐号名,good是否精华Y/N
	//输出:成功返回新文章ID(int),失败返回小于0的整形
	if("" == $clist || "" == $title || "" == $content || "" == $poster){
		return -1;
	}
	my_safe_include("class_article.php");
	my_safe_include("mwjx/class_info.php");
	$obj = new articlebase;
	//return $obj->get_id();
	//addarticle($poster="",$title="",$txt="",$price="",$class_id="",$fatherid="",$author="",$enumgood="",$dtepost="")
	//writetofile("xxx.txt",$content);
	//return -3;
	$obj->addarticle($poster,$title,$content,"","0","","",$good,"");
	$aid = intval($obj->get_id());
	//return $aid;
	if($aid < 1)
		return -2;
	//链接到类目
	$arr = explode(",",$clist);
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]);
		if($id < 1)
			continue;
		$obj = new c_class_info($id);
		if($obj->get_id() < 1)
			continue;
		$obj->save_last();
		$obj->link_article($aid);					 	
	}
	return $aid;
}
function edit_article($id=-1,$title = "",$content = "")
{
	//编辑文章
	//输入:id(int)文章ID,title标题,content内容
	//输出:成功返回true,失败返回false
	if($id < 1 || "" == $title || "" == $content)
		return false;
	if(strlen($title) > 255 || strlen($content) > 999999)
		return false;
	my_safe_include("class_article.php");
	$obj = new articlebase($id,"","Y"); 
	if($obj->get_id() < 1)
		return false;
	//addslashes
	$obj->set_title(addslashes($title));
	$obj->set_txt(addslashes($content));
	$obj->update_last();
	return $obj->saveinfo($obj->get_id());			
	//return true;
}
/*
//-----------tests-----------
require("../../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) <= 0){
	exit("当前用户无效");
}
//---------发布文章--------
//var_dump(post_article("title","content","1,2,3,4,5,6,7,8,9",$obj_man->get_name()));
//---------编辑文章--------
var_dump(edit_article(6811,"title_aa","content_bb"));
*/
?>