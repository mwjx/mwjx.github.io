<?php
//------------------------------
//create time:2008-3-7
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:������Ʒ�б�
//------------------------------
//����Ҫcd�����Ŀ¼�²�ִ�����������
//cd /usr/home/mwjx/fish838.com/site838/view/track/
///usr/local/php/bin/php /usr/home/mwjx/fish838.com/site838/view/track/mwjx2838.php
exit();
$_SERVER["PHP_SELF"] = "/site838/view/track/mwjx2838.php";
//require("novels_info.php");
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/track.php");
//var_dump(olddir_from_id(2001));
//exit();
$arr = load_cid();
//var_dump($arr);
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	$cid = intval($arr[$i][0]);
	//��ҵ�����ڣ����棬����
	if($cid < 10 || 427 == $cid || 426 == $cid || 64 == $cid)
		continue;
	//if(126 != $cid)
	//	continue;
	//var_dump($cid);
	//exit();
	mv_article($cid);
	//break;
	
}
echo "OVER!";
//var_dump($files);

//-------------����Ⱥ-----------
function mv_article($cid=-1)
{
	//ת������
	//����:cid��ĿID
	//���:��
	//$str_sql = "insert into article (cid,click,title,last)";
	//$str_sql = "select A.int_id,A.int_click,A.str_title,A.dtt_change from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid='".$cid."' and A.enum_active='Y' order by A.int_id ASC;";
	//2008-6-13,��ȱ
	$str_sql = "select A.int_id,A.int_click,A.str_title,A.dtt_change from class_article CA left join tbl_article A on CA.aid = A.int_id where CA.cid='".$cid."' and A.enum_active='N' order by A.int_id ASC;";
	//$str_sql = "select int_id,int_click,str_title,dtt_change from tbl_article where int_class_id='".$cid."' and enum_father='Y' and enum_active='Y' order by int_id ASC;";
	//exit($str_sql);
	$sql = new mysql("db_mwjx");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	$len = count($arr);
	if($len < 1)
		return;
	if(82 == $cid)
		return; //�����Ŀ���ݲ�ѯʱ����
	flush();
	echo $cid."<br/>\n";
	echo "len=".$len."<br/>\n";
	return;
	$scid = strval($cid);
	$db = "fish838";
	$dbold = "tbl_data";
	$int_max = 20000;  //3����������һ�����ݱ�
	$ls = "";
	//���
	for($i = 0;$i < $len;++$i){

		$str_sql = "insert into article (cid,click,title,last)values('".$cid."','".$arr[$i][1]."','".$arr[$i][2]."','".$arr[$i][3]."');";
		//exit($str_sql);
		$sql = new mysql($db);
		$sql->query($str_sql);
		$sql->close();
		$newid = $sql->get_insert_id();
		if($newid < 1)
			break;
		$oldid = intval($arr[$i][0]);
		$int_name = intval(($oldid-1)/$int_max);
		if(0 == $int_name){
			$result = "tbl_data";
		}
		else{
			$result = "tbl_data_".strval($int_name);
		}
		$str_sql = "select str_txt from ".$result." where int_id='".$oldid."';";
		$sql = new mysql("db_mwjx");
		$sql->query($str_sql);
		$sql->close();
		$row = $sql->get_array_rows();
		$content = $row[0][0];
		//var_dump($content);
		//exit();
		//if("" == $content)

		$tbl = intval(($newid-1)/100000)+1;
		$str_sql = "insert into a_data_".$tbl." (aid,txt)values('".$newid."','".addslashes($content)."');";
		$sql = new mysql($db);
		$sql->query($str_sql);
		$sql->close();
		if("" != $ls)
			$ls .= ",";
		$ls .= $oldid;
	}
	//�Ƴ�class_article��,����tbl_article��
	$str_sql = "delete from class_article where cid='".$cid."';";
	$sql = new mysql("db_mwjx");
	$sql->query($str_sql);
	$sql->close();
	if("" == $ls)
		return;
	$str_sql = "update tbl_article set enum_active='N' where int_id in(".$ls.");";
	$sql = new mysql("db_mwjx");
	$sql->query($str_sql);
	$sql->close();

	//var_dump($arr);
	//exit();	
}
function load_cid()
{
	//װ�ؾ�����
	//����:��
	//���:��
	//����
	//$str_sql = "select cid from update_track group by cid order by cid ASC;";
	$str_sql = "select id from class_info order by id ASC;";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	//var_dump($arr);
	//exit();
	return $arr;
}
function get_arr_files($dir="")
{
	//���Ҷ�Ӧ�������ļ�
	//���룺��
	//������ļ��б�����,�쳣����false
	if("" == $dir)
		return array();
	if(!file_exists($dir))
		return array();
	if(intval($int_dir = opendir($dir)) < 0)
		return array();
	$result = array();
	while(($file = readdir($int_dir))!== false) {
		if(is_dir($dir.$file) || ("." == $file) || (".." == $file))
			continue;
		$result[] = $file;
	} //level 1
	return $result;
}
function deal_file($path,$sou=4)
{
	//����һ���ļ��������������ļ�¼��������������
	//���룺path���ļ�·��,sou��Դ��־����track.php
	//�����true,false
	//if(!file_exists($path))
	//	return false;
	global $m_author;
	global $m_novels;
	global $m_links;
	echo($path."<br/>\n");
	$shtml = readfromfile($path);
	if("" == $shtml)
		return false;
	//echo $shtml;
	//exit();
	preg_match_all("|\<script language=javascript>putlist(.*?)\<\/script>|s",$shtml,$out);
	$txt = $out[1][0];
	if("" == $txt)
		return false;
	$arr = explode("\n",$txt);
	$len = count($arr);
	$info = array();
	$sql = new mysql;
	for($i = 0;$i < $len; ++$i){
		$info = array();
		deal_line($arr[$i],$info);
		if(count($info) < 1)
			continue;
		//continue;
		//var_dump($info);
		//exit();
		if(!isset($m_author[$info[1]])){
			$str_sql = "insert into author (title)values('".$info[1]."');";
			$sql->query($str_sql);
			$m_author[$info[1]] = intval($sql->get_insert_id());
		}
		$author = isset($m_author[$info[1]])?$m_author[$info[1]]:0;
		if(!isset($m_novels[$info[0]])){

			$str_sql = "insert into novels (title,author,over)values('".$info[0]."','".$author."','".$info[3]."');";
			$sql->query_ignore($str_sql);

			$m_novels[$info[0]] = intval($sql->get_insert_id());
		}
		if(!isset($m_novels[$info[0]]))
			continue;
		$nid = $m_novels[$info[0]];
		if(!isset($m_links[$nid]))
			$m_links[$nid] = array();
		if(!isset($m_links[$nid][$sou])){
			$str_sql = "insert into novels_links (novels,sou,val)values('".$nid."','".$sou."','".$info[2]."');";
			$sql->query($str_sql);
			$m_links[$nid][$sou] = true;
		}
		//var_dump($info);
		//exit();
	}
	$sql->close();
	//var_dump($m_author);
	//exit();
	return true;
}
function deal_line($line="",&$out)
{
	//����һ��
	//����:lineһ��,out�������array(��Ʒ,����,��ƷID,״̬)
	//���:��
	//echo $line;
	//var_dump(!strpos($line,"(",0));
	//exit();
	if(false === ($pos = strpos($line,"(",0)))
		return;
	//exit("aa");
	$str = substr($line,++$pos);
	if(!($pos = strpos($str,")",0)))
		return;
	$str = substr($str,0,$pos);
	//('75387','����','��ħ¼','2006��9��1��','���� �ڶ��� ����','������','61493','����','2013760')
	//��ƷID,����,��Ʒ,����,�����½�,״̬,����ID,���,�½�ID
	//exit($str);
	$arr = explode(",",$str);
	if(9 != count($arr))
		return;
	//'
	$title = trim(str_replace("'","",$arr[2]));
	$author = trim(str_replace("'","",$arr[1]));
	$nid = trim(str_replace("'","",$arr[0]));
	$st = trim(str_replace("'","",$arr[5]));
	$s = "S"; //ֹͣ
	if("�����" == $st)
		$s = "O";
	if("������" == $st)
		$s = "I";
	//exit("|".$author."|");
	$out = array($title,$author,$nid,$s);
	//var_dump($out);
	//exit();
	//echo $arr[2]."|".$arr[1]."|".$arr[5]."|".$s."<br/>\n";
	//return true;
}
?>