<?php
//------------------------------
//create time:2007-1-15
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��������
//------------------------------
function post_article($title = "",$content = "",$clist = "",$poster = "",$good="N")
{
	//��������
	//����:title����,content����,clist������ĿID�б�,���ŷָ�(1,2,3)
	//poster�������ʺ���,good�Ƿ񾫻�Y/N
	//���:�ɹ�����������ID(int),ʧ�ܷ���С��0������
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
	//���ӵ���Ŀ
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
	//�༭����
	//����:id(int)����ID,title����,content����
	//���:�ɹ�����true,ʧ�ܷ���false
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
	exit("��ǰ�û���Ч");
}
//---------��������--------
//var_dump(post_article("title","content","1,2,3,4,5,6,7,8,9",$obj_man->get_name()));
//---------�༭����--------
var_dump(edit_article(6811,"title_aa","content_bb"));
*/
?>