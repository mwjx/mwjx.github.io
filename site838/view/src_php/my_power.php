<?php
//------------------------------
//create time:2007-8-16
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ҵ�Ȩ��
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("lib/fun_global.php");
my_safe_include("class_man.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);

//$m_id = 200200067; //tests
//$m_id = 200307525;
//$m_id = -1;
//var_dump($arr);
if($m_id < 1)
	exit("�û�ID��Ч");
$m_man = new manbase_2($m_id);
if($m_man->get_id() < 1)
	exit("�û�������");


$m_arr = get_arr_power($m_id);
//var_dump($m_arr);
//exit();
$str_xml = power_arr2xml($m_arr,$m_man->get_name());
//echo "hello";

print_xml($str_xml);
//echo $m_html;
function get_arr_power($id = -1)
{
	//�����ҵ�Ȩ������
	//����:id(int)�û�ID
	//���:����,array(cid=>res=>array(1,2,3))
	$str_sql = "select * from authorize where run_class = '1' and (runer = '".$id."' or runer = '0');";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	//var_dump($arr);
	//exit();
	$arr_power = array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$cid = intval($arr[$i]["res_class"]);
		$res = intval($arr[$i]["res"]);
		$action = intval($arr[$i]["action"]);
		//var_dump($arr[$i]);
		//exit();
		if(!isset($arr_power[$cid]))
			$arr_power[$cid] = array();
		if(!isset($arr_power[$cid][$res]))
			$arr_power[$cid][$res] = array();		
		//if(isset($arr_power[$cid][$res]))
		$arr_power[$cid][$res][$action] = true;		
	}
	return $arr_power;
}
function power_arr2xml(&$arr,$name="")
{
	//��Ȩ������תΪxml�ַ���
	//����:arr(array)Ȩ������,name(string)�û���
	//���:xml�ַ���
	$arr_type = array(); //��Դ�����б�
	$arr_type[0] = "����";
	$arr_type[1] = "��վ";
	$arr_type[2] = "��Ŀ";
	$arr_type[3] = "����";
	$arr_res = array(); //��Դ�б�
	//$arr_res[1] = "���ľ�ѡ";
	$arr_res[1] = "838���";
	//�����б�array(��Դ����=>array(����ID=>������))
	$arr_action = array(); 
	$arr_action[1] = array();
	//$arr_action[1][1] = "��������";
	//$arr_action[1][2] = "��������";
	$arr_action[1][3] = "������Ŀ";
	$arr_action[1][4] = "ɾ����Ŀ";
	/*$arr_action[1][5] = "������ҳ������";
	$arr_action[1][6] = "���¹���";
	$arr_action[1][7] = "ȡ����������";
	$arr_action[1][8] = "ɾ������";
	$arr_action[1][9] = "���������������";
	$arr_action[1][10] = "���������Ǽ�";
	$arr_action[1][11] = "�Ƽ����µ���Ŀ��ҳ";
	$arr_action[1][12] = "�༭����";
	$arr_action[1][13] = "�������¾���";
	$arr_action[1][14] = "ɾ����������";
	$arr_action[1][15] = "������Ŀ";
	$arr_action[1][16] = "�������þ�������";
	$arr_action[1][17] = "��������";
	$arr_action[1][18] = "ȡ����Ŀ����";
	$arr_action[1][19] = "�������ı��޸�";
	*/
	$aa [0] = "����";
	$aa [24] = "�����Ŀ��Դ";
	$aa [25] = "��Ŀ����������"; //�������
	//----------
	$xml = "<?xml version=\"1.0\"  encoding=\"gb2312\"?>\n";
	$xsl_path = "../include/xsl/my_power.xsl";
	$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
	$xml .= $str_xsl;
	$xml .= "<listview>";
	$xml .= "<title>".$name."��Ȩ���б�</title>";
	//$len = count($arr);
	foreach($arr as $cid=>$res){
		$xml .= "<res_type>";
		$xml .= "<id>".$cid."</id>";
		$tname = $arr_type[$cid];
		$xml .= "<name>".$tname."</name>";
		foreach($res as $rid=>$row){
			$xml .= "<res>";
			$xml .= "<id>".$rid."</id>";
			$rname = "";
//			if(1 == $cid)
//				$rname = $arr_res[$rid];
//			else
//				$rname = $rid;
			if(0 == $rid)
				$rname = "����";
			else
				$rname = $rid;
			$xml .= "<name>".$rname."</name>";
			if(1 == $cid){
				foreach($arr_action[$cid] as $aid=>$aname){
					$xml .= "<action>";
					$xml .= "<id>".$aid."</id>";
					$xml .= "<name>".$aname."</name>";
					if($row[$aid])
						$xml .= "<enable>Y</enable>";
					$xml .= "</action>\n";
				}
			}
			else{
				foreach($row as $aid=>$val){
					$xml .= "<action>";
					$xml .= "<id>".$aid."</id>";
					$aname = (isset($aa[$aid])?$aa[$aid]:"δ֪");
					$xml .= "<name>".$aname."</name>";
					//if($row[$aid])
					$xml .= "<enable>Y</enable>";
					$xml .= "</action>\n";
				}
			}
			/*
			foreach($row as $val){
				$xml .= "<action>";
				$xml .= "<id>".$val."</id>";
				$xml .= "<name>".$val."</name>";
				$xml .= "</action>";
			}
			*/
			$xml .= "</res>\n";
		}
		//$xml .= "<res></res>";
		$xml .= "</res_type>\n";
	}
	$xml .= "</listview>";
	return $xml;
}
?>