<?php
//------------------------------
//create time:2007-1-11
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:���¹���
//------------------------------
//���ļ�ʹ��ǰҪinclude�����������ļ������ݿ������ļ�

function article_reset($str = "")
{
	//���¹���,���������ӵ�������Ŀ
	//����:str(string)������Ϣ,��ʽ:
	//��ĿID_����ID_����ID,��ĿID_����ID...
	//���:true�ɹ�,����ȫ�ɹ������ַ���˵��
	//Ҫ���ǵ�����:��Ŀ�쳣
	//���²����ڻ��쳣
	//�����Ѿ�����Ŀ��

	$arr = explode(",",$str);
	if(($len = count($arr)) < 1)
		return "�ύ�б���Ϊ��";
	$arr_fail = array(); //ʧ�ܵ�����:��ĿID(int)=>array(����ID(int))
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
			if(!$obj->link_article($aid)){ //ʧ��
				if(!isset($arr_fail[$cid]))							
					$arr_fail[$cid] = array();
				$arr_fail[$cid][] = $aid;
			}
		}
		//link_article			
	}
	//return true;
	//���
	if(count($arr_fail) < 1)
		return true; //�ɹ�
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
//----------��������-------
$info = "53_7506";
var_dump(article_reset($info));
//exit("aaaa");
*/
?>