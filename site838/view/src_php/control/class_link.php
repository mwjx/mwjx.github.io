<?php
//------------------------------
//create time:2007-7-19
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:������Ŀ
//------------------------------
//���ļ�ʹ��ǰҪinclude�����������ļ������ݿ������ļ�

function link_class($str = "")
{
	//������Ŀ
	//����:str(string)������Ϣ,��ʽ:
	//��ĿID_����ID_����ID,��ĿID_����ID...
	//���:true�ɹ�,����ȫ�ɹ������ַ���˵��
	//return true;
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
		if(($fid = intval($arr_a[0])) < 1)
			continue;
		$obj = new c_class_info($fid);
		if($obj->get_id() < 1)
			continue;											
		for($j = 1;$j < $len2; ++$j){
			$cid = intval($arr_a[$j]);
			if(!$obj->add_link_class($cid)){ //ʧ��
				//exit("ʧ��");
				if(!isset($arr_fail[$cid]))							
					$arr_fail[$fid] = array();
				$arr_fail[$fid][] = $cid;
			}
			//exit("�ɹ�");
		}
		//link_article			
	}
	//return true;
	//���
	if(count($arr_fail) < 1)
		return true; //�ɹ�
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
//----------��������-------
$info = "77_168";
var_dump(link_class($info));
//exit("aaaa");
*/
?>