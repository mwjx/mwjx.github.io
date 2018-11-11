<?php
//------------------------------
//create time:2010-4-16
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�ҵĲ���
//------------------------------
require("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/mybook.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
my_safe_include("mwjx/track.php");

$m_id = intval(isset($_GET["id"])?$_GET["id"]:0); //����ID
$m_t = (isset($_GET["t"])?$_GET["t"]:""); //�Ƿ����ģʽ:m��
//$m_id = 4; //tests
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
$obj_mb = new c_mybook($m_id);
$m_mycid = $obj_mb->get_cid();
if($m_mycid > 0 && "m"!=$m_t){
	//header("Location:track/index.php?id=".$m_mycid);
	$url = "cache/cpage/".$m_mycid.".html";
	$dir = get_dir_root();
	//exit($url);
	if(file_exists($dir.$url)){
		header("Location:/".$url);
		exit();
	}
	if(init_book($m_mycid)) //�Ѿ���ʼ��
		header("Location:/".$url);
//	else
//		header("Location:track/info.php?id=".$m_mycid."&mb=".$m_id);
	exit();
}
exit("���鲻����");
function init_book($cid=-1)
{
	//��ʼ����
	//����:cid��Ŀ
	//���:true��ת/false����ת
	//var_dump($cid);
	//exit();
	$sql = new mysql;
	if(had_init($sql,$cid)){
		//exit("had");
		$sql->close();
		return true;
	}
	//exit("none");
	//ȡ��Դ�б�
	$str_sql = "select NL.id,NL.sou,NL.val from novels N inner join novels_links NL on N.id=NL.novels where N.cid=".$cid.";";
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$len = count($arr);
	echo "=>-----------��ʼ��ȡ����".$len."����Դ-----------<br/>\r\n";
	flush();
	$count = 0;
	for($i=0;$i<$len;++$i){
		++$count;
		echo "=>".$count."����ʼ��ȡ��".$count."����Դ�����Ժ�...<br/>\r\n";
		flush();
		$nlid = intval($arr[$i][0]);
		$site = intval($arr[$i][1]);
		if(deal_sou($sql,$nlid,$site,$arr[$i][2]))
			echo "��Դ".$site."��ȡ�ɹ���<br/>\r\n";
		else
			echo "��Դ".$site."��ȡʧ�ܡ�<br/>\r\n";
		flush();
		set_time_limit(360);
	}
	$sql->close();
//	echo "=>������ʼ��ȡ�ڣ�����Դ�����Ժ�...<br/>\r\n";
//	echo "�ڣ�����Դ��ȡ��ɡ�<br/>\r\n";
	echo "=>-----------�����ʼ��ɣ�<a href=\"/cache/cpage/".$cid.".html\">�򿪱���</a>-----------<br/>\r\n";
	flush();
	return false;
}
function had_init(&$osql,$cid=-1)
{
	//�����Ƿ��Ѿ���ʼ
	//����:osql���ݿ�,cid��Ŀ
	//���:true/false
	//$str_sql = "select TS.* from track_section TS inner join novels_links NL on TS.tid=NL.id where NL.novels=".$cid." limit 1;";
	$str_sql = "select TS.* from track_section TS inner join novels_links NL on TS.tid=NL.id inner join novels N on NL.novels=N.id where N.cid=".$cid." limit 1;";
	//exit($str_sql);
	$osql->query($str_sql);
	return ($osql->get_num_rows()>0);
}
function deal_sou(&$osql,$sid=-1,$site=-1,$val="")
{
	//����һ����Դ����
	//����:osql���ݿ�,sid��Դ����ID,siteվ��,val������ַ�ؼ�ֵ
	//���:true/false
	//echo $site.":".$val."<br/>";
	//var_dump($arr_t);
	//var_dump(effective_url($arr_t,"http://me.qidian.com/BookCase/2/1","�ҵ����"));
	//return false;
	$url = val2url($site,$val);
	if(false===($arr_u = parseurl($url)))
		return false; //����ԭʼurlʧ��
	if(!($txt=readurl($url)))
		return false; //����ʧ��
	$arr_t = array(); //����[[t,val]]
	load_rules($osql,$site,$arr_t);
	$utf8 = is_utf8($arr_t); //�Ƿ�utf8����
	//��ȡ����
	preg_match_all("|<a.*?href=\s*?[\"'](.*?)[\"'].*?>(.*?)<\/a>|is",$txt,$out);

	//var_dump($out);
	$len = count($out[1]);
	$count = 0;
	$str_sql = "";
	$url_key = array(); //url�Ƿ����,url=>true
	for($i=0;$i < $len;++$i){
		$title = $out[2][$i];
		$url = $out[1][$i];
		if(""==$title || ""==$url)
			continue;
		if(!effective_url($arr_t,$url,$title))
			continue; //���ϸ�
		if(false===($url=smart_url($arr_u,$url)))
			continue; //�����ַʧ��
		if(isset($url_key[$url])){
			echo "�½��ظ�:".$title."<br/>\r\n";
			continue;
		}
		$url_key[$url] = true;
		//echo $title.":".$url."<br/>\r\n";
		//�������ݿ�
		if(""!=$str_sql)
			$str_sql .= ",";
		$str_sql .= ("('".$sid."','");
		//���������utf8,תΪgb
		if($utf8)
			$title = iconv('UTF-8','GB2312//IGNORE',$title);
		$str_sql .= (addslashes($title)."','".$url."')");
	}
	//return true;
	if("" ==$str_sql)
		return true;
	$str_sql = ("insert into track_section (tid,title,url)values".$str_sql.";");
	//echo $str_sql."<br/>";
	$osql->query($str_sql);
	return true;
}
function is_utf8(&$arrt)
{
	//�Ƿ�utf8
	//����:arrt����
	//���:true/false
	for($i=0;$i < $len;++$i){
		if(14!=$arrt[$i][0])
			continue;
		if("utf8" == $arrt[$i][1])
			return true;
		return false;
	}
	return false;
}
function smart_url(&$arru,$val="")
{
	//������Ͼ���url
	//����:arru��������,val������ַ
	//���:��ַ/false
	if(strlen($val) < 1)
		return false;
	if("#" == $val)
		return false;
	$f = substr($val,0,1);
	if('/' == $f) //��Ŀ¼
		$ph = $arru[0].$val;
	else if("http" == substr($val,0,4)) //���Ե�ַ
		$ph = $val;
	else //���Ŀ¼
		$ph = $arru[1].$val;
	return $ph;
}
function parseurl($url = "")
{
	//����url
	//����:urlԭʼ��ַ
	//���:[dm,root]/false
	$matches = parse_url($url);
	$path = $matches['path'] ? $matches['path'].(isset($matches['query']) ? '?'.$matches['query'] : '') : '/';
	$pos = strrpos($path,'/');
	if(false===$pos)
		return false;
	$dir = substr($path,0,$pos+1);
	$root = $matches['scheme']."://".$matches['host'].$dir;
	$dm = $matches['scheme']."://".$matches['host'];
	return array($dm,$root);
}
function effective_url(&$arrt,$url="",$title="")
{
	//�Ƿ���Ч�б�ҳ
	//����:arrtվ�����,Ҫ����url,title����
	//���:true��Ч��false��Ч
	//cerr << "url:" << url << endl;
	//cerr << "count 5:" << mp_us.count(5) << ":" << site << endl;
	if(($len=count($arrt)) < 1){
		//cerr << "������" << endl;
		return true; //�޹���
	}
	for($i=0;$i < $len;++$i){
		$t = $arrt[$i][0];
		$val = $arrt[$i][1];
		//cerr << "t=" << t << endl;
		switch($t){
			case 1:	  //url����
				if(false !== strpos($url,$val)){
					//cerr << "pass,val:" << val << endl;
					return false;
				}
				break;
			case 2:	  //url������
				if(false === strpos($url,$val))
					return false;
				break;
			case 7:	  //title����
				if(false !== strpos($title,$val))
					return false;
				break;
			case 8:	  //title������
				if(false === strpos($title,$val))
					return false;
				break;
			case 9:	  //title����С��
				if(strlen($title) < intval($val))
					return false;
				break;
			case 10: //title���ȴ���
				if(strlen($title) > intval($val))
					return false;
				break;
			default:
				break;
			
		}
	}
	return true;
}

function load_rules(&$osql,$site=-1,&$arrt)
{
	//װ�ع���
	//����:osql���ݿ�,siteվ��,arrt��������[t=>val]
	//���:��
	$str_sql = "select t,val from track_pass  where site = '".$site."';";
	$osql->query($str_sql);
	while($row=$osql->fetch_array()){
		$t = intval($row["t"]);
		$arrt[] = array($t,$row["val"]);
	}
}
//������Ŀ
if($m_id > 0 && $m_mycid < 1)
	$obj_mb->auto_link($m_id,$obj_man->get_id());
$m_kw = (isset($_GET["kw"])?$_GET["kw"]:""); //�����ؼ���
$m_kw = $obj_mb->get_title();
$m_cid = -1;
$m_author = ""; //����
$m_lists = html_class($m_kw);
$m_store = html_store($m_kw);
//$m_id = 1; //tests

function js_track_domain()
{
	//��Դ������־
	//����:��
	//���:html�ַ���
	global $m_id;
	global $m_mycid;
	$js = "<script language=\"javascript\">\n";
	$js .= "var m_id = ".$m_id.";\n";
	$js .= "var m_cid = ".$m_mycid.";\n";
	$js .= "var m_arr_td = Array();\n";
	$arr = arr_track_domain();
	$ls = "";
	foreach($arr as $key=>$row){
		$ls = "";
		$len = count($row);
		for($i = 0;$i < $len; ++$i){
			if("" != $ls)
				$ls .= ",";
			$ls .= "'".$row[$i]."'";
		}
		$js .= "m_arr_td['".$key."']=Array(".$ls.");\n";
	}
	$js .= "</script>\n";
	return $js;
}
function html_sonclass()
{
	//�����ƻ�����Ŀ
	//����:��
	//���:html�ַ���
	$novels = new c_class_info(4); //�����ƻ�
	$arr_tmp = $novels->get_son_link();
	$ls = "<div id=\"div_slbrand\" style=\"display:block;\"><ul>";
	foreach($arr_tmp as $row){
		$obj = new c_class_info(intval($row[0]));
		$arr = $obj->get_son_link();
		if(count($arr) < 1)
			continue;
		$id= $row[0];
		$name= $row[1];
		$ls .= "<li onclick=\"javascript:chk_fid('".$id."','".$name."');\"><span>".$name."</span></li>";
	}
	$ls .= "</ul></div>";
	return $ls;
}
function html_flag()
{
	//��Ŀ�б�
	//����:��
	//���:html�ַ���
	$arr = arr_track_flag(); //flag=>title

	$html = "";
	$html .= "<select name=\"flag_id\">";
	$len = count($arr);
	$html .= "<option value=\"-1\">��ѡ��</option>";
	foreach($arr as $flag=>$title){
		$html .= "<option value=\"".$flag."\">".$title."</option>";
	}
	$html .= "</select>";
	return $html;
}
function html_store($kw="")
{
	//����С˵
	//����:kw(string)�����ؼ���
	//���:html�ַ���
	global $m_cid;
	global $m_author;
	//������Դ
	$arr = array();
	if("" != $kw){
		//$str_sql = "select id,name,memo from class_info where name like '%".$kw."%';";
		$str_sql = "select id,name,memo from class_info where name = '".$kw."';";
		//exit($str_sql);
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	$len = count($arr);
	if($len > 0){
		$ls = "";
		for($i = 0;$i < $len; ++$i){
			if("" != $ls)
				$ls .= ",";
			$ls .= $arr[$i]["id"];
		}
		$arr_track = arr_track_flag(); //flag=>title
		$str_sql = "select * from update_track  where cid in (".$ls.");";
		//exit($str_sql);
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	else{
		$arr = array();
	}
	//var_dump($arr);
	//exit();
	$html = "";
	$js = "";
	//$js = "<script language=\"javascript\">\n";
	//$js .= "var m_arr_author = Array();\n";
	$html .= "������Դ��<select name=\"exists_track\" style=\"width:400px;\" SIZE=\"4\" MULTIPLE onchange=\"javascript:ck_exists();\">";
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i]["id"];
		$cid = $arr[$i]["cid"];
		$site = intval($arr[$i]["flag"]);
		$title = $cid.":".$arr_track[$site];
		$url = $arr[$i]["url"];
		//if($m_cid < 1){
		//	$m_cid = intval($id);
		//	$m_author = $arr[$i][2];
		//}
		//$title = $arr[$i][1];
		//$js .= "m_arr_author['".$id."'] = '".$arr[$i][2]."';\n";
		$html .= "<option value=\"".$url."\" id=\"".$id."\" site=\"".$site."\">".$title."</option>";
	}
	$html .= "</select>";	
	$html .= "<br/>";
	//�������		
	$arr = array();
	if("" != $kw){
		$str_sql = "select N.id,N.title,NL.sou,NL.val from novels N left join novels_links NL on N.id=NL.novels where N.title like '%".$kw."%' limit 512;";
		//$str_sql = "select N.id,N.title,NL.sou,NL.val from novels N left join novels_links NL on N.id=NL.novels where N.title = '".$kw."';";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	//var_dump($arr);
	//exit();
	//$html = "";
	$js = "";
	//$js = "<script language=\"javascript\">\n";
	//$js .= "var m_arr_author = Array();\n";
	$html .= "���������<select name=\"store_name\" style=\"width:400px;\" SIZE=\"4\" MULTIPLE onchange=\"javascript:ck_store();\">";
	$arr_flag = arr_track_flag(); //flag=>title
	$len = count($arr);
	//$m_author = "aa:".$len;
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i][0];
		$site = intval($arr[$i]["sou"]);
		$val = $arr[$i]["val"];
		//if($m_cid < 1){
		//	$m_cid = intval($id);
		//	$m_author = $arr[$i][2];
		//}
		//if(0 == $i)
		//	$m_author = $arr[$i][4];
		$title = $arr[$i][1];
		if(isset($arr_flag[$site]))
			$title = "[".$arr_flag[$site]."]".$title;
		//$js .= "m_arr_author['".$id."'] = '".$arr[$i][2]."';\n";
		$html .= "<option value=\"".$val."\" id=\"".$site."\">".$title."</option>";
	}
	$html .= "</select>";
	//����
	$str_sql = "select A.title from novels N left join author A on N.author=A.id where N.title = '".$kw."' limit 1;";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	if(count($arr) > 0)
		$m_author = $arr[0][0];
	/**/
	//$js .= "</script>\n";
	return $js.$html;
}
function html_class($kw="")
{
	//��Ŀ�б�
	//����:kw(string)�����ؼ���
	//���:html�ַ���
	global $m_cid;
	global $m_author;
	$arr = array();
	if("" != $kw){
		$str_sql = "select id,name,memo from class_info where name like '%".$kw."%' limit 999;";
		//$str_sql = "select id,name,memo from class_info where name ='".$kw."' limit 999;";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	$html = "";
	$js = "<script language=\"javascript\">\n";
	$js .= "var m_arr_author = Array();\n";
	$html .= "<select name=\"class_name\" style=\"width:200px;\" onchange=\"javascript:ck_cname();\">";
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i][0];
		if($m_cid < 1){
			$m_cid = intval($id);
			$m_author = $arr[$i][2];
		}
		$title = $arr[$i][1];
		$js .= "m_arr_author['".$id."'] = '".$arr[$i][2]."';\n";
		$html .= "<option value=\"".$id."\">".$title."</option>";
	}
	$html .= "</select>";
	$js .= "</script>\n";
	return $js.$html;

}
function get_cid($id = -1)
{
	//ȡ����Դ����ĿID
	//����:id(int)��ԴID
	//���:��ĿID���Σ��쳣����-1
	$str_sql = "select cid from update_track where id='".$id."';";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	if(1 != count($arr))
		return -1;
	return intval($arr[0][0]);
}


function arr_sou()
{
	//��Դ����
	//����:��
	//���:���飬��ʽ��cid=>array(array(id,title,url));
	$re = array();
	$str_sql = "select * from update_track;";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$cid = intval($arr[$i]["cid"]);
		$title = $arr[$i]["title"];
		$url = $arr[$i]["url"];
		if(!isset($re[$cid]))
			$re[$cid] = array();
		$re[$cid][] = array($id,$title,$url);
	}
	return $re;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> �����Դ </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<style>
<!--
	a:link { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:visited { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:active { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:hover { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #FF0000; font-weight: normal; text-decoration: none; }

	#content {width:100%}

-->
</style>
<style>
a:link,a:visited,a:hover,a:active{color:#0000ff;cursor:hand;}body,table,div,ul,li{font-size:10px;margin:0px;padding:0px}body{font-family:arial,sans-serif;height:100%}

/*��������*/
.h2-note         {font-weight:bold;font-size:14px;LINE-HEIGHT:150%;padding:8px 8px 3px 8px; border-bottom:1px solid #CCCCEE;}
.note        {font-size: 12px;LINE-HEIGHT:130%;padding:6px 3px 3px 8px;}
.lh15 {LINE-HEIGHT:150%;}
.box-note   {LINE-HEIGHT:150%; padding:6px 8px 6px 8px;   border:1px solid #CCCCEE; background:#EEEEFF;}

#div_slbrand{
	float:left;
	margin-left:0px;
	width:100%;
	height:100%px;
	overflow:hidden;
	/*background-color:red;*/
}
#div_slbrand ul li{
	float:left;
	margin-left:0px;
	position:relative;
	width:125px;
	height:20px;
	overflow:hidden;
	cursor:hand;
	/*background:#EEEEFF;*/
	padding:0px 0px 0px 8px;   border:1px solid #CCCCEE;

}

</style>
<?=js_track_domain();?>
<script language="javascript" src="./include/script/xmldom.js"></script>
<script language="javascript" src="./script/val2url.php"></script>
<script language="javascript">
function go_search(str)
{
	//��תҳ���ѯ
	//����:str(string)��ѯ�طּ���
	//���:��
	var url = "./track_add.php?kw="+str;
	document.location.href = url;
	//alert(str);
}
function change_url()
{
	//����url�Զ�ʶ����Դ
	//����:url��Դ��ַ
	//���:��
	//return;
	var url = window.clipboardData.getData("Text");
	//alert(url);
	//return;
	if("" == url)
		return;
	//return alert(m_arr_td);
	auto_site(url);
}
function auto_site(url)
{
	//����url�Զ�����վ��
	//����:url��Դ·��
	//���:��
	//return;
	try{
	var key = "";
	for(var sou in m_arr_td){
		if(null == m_arr_td[sou])
			continue;
		//alert(sou);
		for(var i = 0;i < m_arr_td[sou].length;++i){
			key = m_arr_td[sou][i];
			if(-1 != url.indexOf(key)){ //�ҵ�
				//alert("oo");
				//document.all["flag_id"].selectedIndex = parseInt(key,10);
				//alert(document.all["flag_id"]);
				var obj = document.all["flag_id"];
				//alert(typeof(obj.options[1].value));
				//alert(sou==obj.options[13].value);
				var j;
				for(j=0;j<obj.length;++j){
					if(sou != obj.options[j].value)
						continue;
					//alert(key);
					obj.options[j].selected = true;
					break;
				}
				return; 
			}
		}
		/**/
	}
	}
	catch(err){
		alert("auto_site"+err.message);
	}
}
function del_class()
{
	//ɾ����Ŀ
	//����:��
	//���:��
	var cid = parseInt(document.all["cid"].value,10);
	if(cid < 1)
		return alert("ɾ��ʧ�ܣ���ĿID��Ч");
	//return alert();
	var url = "./cmd.php?fun=del_class&id="+cid;
	var xmlDoc= new_xmldom();
	xmlDoc.async=false;
	xmlDoc.load(url);
	var nodes=xmlDoc.documentElement.childNodes
	return alert(nodes[0].text);
}
function up_url()
{
	//���µ�ַ
	//����:��
	//���:��
	if("" == document.all["frm_action"]["id_ls"].value)
		return alert("����ʧ�ܣ���ԴID����Ϊ��");
	if("" == document.all["frm_action"]["txt_url"].value)
		return alert("����ʧ�ܣ���ԴURL����Ϊ��");
	//return alert();
	document.all["frm_action"]["fun"].value = "save_trackurl";
	document.all["frm_action"].submit();
}
function add()
{
	//��ӵ���Ŀ
	//����:��
	//���:��
	var sou = parseInt(document.all["flag_id"].value,10);
	//return alert("��ӵ���Ŀ:"+typeof(sou));
	if("" == document.all["frm_action"]["cid"].value)
		return alert("���ʧ�ܣ���ĿID����Ϊ��");
	if("" == document.all["frm_action"]["txt_url"].value)
		return alert("���ʧ�ܣ���ԴURL����Ϊ��");
	if(sou < 1)
		return alert("���ʧ�ܣ���Դ��Ч��"+sou);
	document.all["frm_action"]["fun"].value = "add_track";
	document.all["frm_action"].submit();
	//if(!window.confirm("�Ƿ���Ҫ���ύ�ɹ���������Ϊ�Ѷ���"))
	//	return;
	//reset_used();
}
function update_author()
{
	var cid = parseInt(document.all["frm_action"]["cid"].value,10);
	if(cid < 1)
		return alert("����ʧ�ܣ���ĿID����Ϊ��");
	document.all["frm_action"]["fun"].value = "update_author";
	document.all["frm_action"].submit();
}
function link_mybook()
{
	//����Ŀ����������
	//����:��
	//���:��
	var cid = parseInt(document.all["frm_action"]["cid"].value,10);
	if(cid < 1)
		return alert("����ʧ�ܣ���ĿID����Ϊ��:"+cid);
	if(m_id < 1)
		return alert("����ʧ�ܣ�����ID����Ϊ��:"+m_id);
	document.all["frm_action"]["fun"].value = "link_mybook";
	document.all["frm_action"]["content"].value = m_id;
	document.all["frm_action"].submit();
}
function rm_book()
{
	//ɾ����ǰ����
	//����:��
	//���:��
	if(m_id < 1)
		return;
	document.all["frm_action"]["fun"].value = "rm_mybook";
	document.all["frm_action"]["content"].value = m_id;
	document.all["frm_action"].submit();
}
function init()
{
	//��ʼ
	//����:��
	//���:��
	if(m_cid < 1)
		document.getElementById("btn_create").style.display = "block";
	else
		document.getElementById("btn_rmbook").style.display = "block";
	//alert("aaa");
}
function tests_dom()
{
	return;
	try{
	var obj = document.all["flag_id"];
	//alert(typeof(obj.options[1].value));
	//alert(sou==obj.options[13].value);
	var sou = 3;
	var j;
	for(j=0;j<obj.length;++j){
		if(sou != obj.options[j].value)
			continue;
		//alert(key);
		obj.options[j].selected = true;
		break;
	}
	}
	catch(err){
		alert(err.message);
	}
	return;
	//alert("tests_dom");
	var xmldoc = new_xmldom();
	if(false === xmldoc)
		return alert("����xmldom����ʧ��");
	var url = "./cmd.php?fun=new_class&fid=0&name=aa";
	//var url = "../../fc_client/map/1.xml";
	//var url = "http://localhost/fc_client/map/1.xml";
	//url += "&cdir=Y"; //�½���Ŀ
	//alert(url);
	//return;
	xmldoc.async=false;
	xmldoc.load(url);
	//alert(xmldoc.documentElement);
	try{
//		if("ie" == m_agent)
//			str = xmldoc.documentElement.childNodes[0].nodeValue;
//		else
//			str = xmldoc.documentElement.childNodes[1].text;
		alert(xmldoc.documentElement.childNodes[0].nodeValue);
	}
	catch(err){
		alert("llk.js,loadmap,err:"+err.message);
	}
	//alert(str);
	//var arr = str.split("\n");
	//alert(arr);
}
function chk_fid(fid,fname)
{
	//ѡ��һ������Ŀ
	//����:fid(string)����ĿID,fname(string)����Ŀ����
	//���:��
	//alert(fid);
	var name = document.all["search_title"].value;
	if("" == fid)
		return alert("����ĿID��Ч");
	if("" == name)
		return alert("������Ŀ������Ϊ�գ�������������������Ŀ����");
	//alert(fid+":"+name);
	
	document.all["tbl_detail"].style.display = "none";
		
	if(!window.confirm("ȷ��Ҫ����Ŀ��"+fname+"���´�������Ŀ��"+name+"����"))
		return alert("��������");
	var xmldoc = new_xmldom();
	if(false === xmldoc)
		return alert("����xmldom����ʧ��");
	var url = "./cmd.php?fun=new_class&fid="+fid+"&name="+name;
	//url += "&cdir=Y"; //�½���Ŀ
	//alert(url);
	//return;
	xmldoc.async=false;
	xmldoc.load(url);
	var str_confrim = "������Ŀʧ��";
	//alert(xmldoc);
	if(null != xmldoc.documentElement.childNodes[0]){
		if(!document.all){ //firefox
			str_confrim = xmldoc.documentElement.childNodes[0].nodeValue;
		}
		else{
			str_confrim = xmldoc.documentElement.childNodes[0].text;
		}
	}
	alert(str_confrim);
	//window.location.reload();
	window.location.href="./mybook.php?id="+m_id+"&t=m";
	/**/
}
function ck_cname()
{
	//ѡ��һ����Ŀ
	//����:��
	//���:��
	var obj = document.all["class_name"];
	var id = obj.options[obj.selectedIndex].value;
	document.all["cid"].value = id;
	var author = m_arr_author[id];
	document.all["txt_author"].value = author;
}
function rm_sou(tid)
{
	//ɾ��һ����Դ
	//����:tid(string)��ԴID
	//���:��
	//�ύ����
	//return alert(tid);
	if(!window.confirm("���������ɻָ���ȷ����"))
		return;
	document.all["frm_action"]["fun"].value = "rm_sou";
	document.all["frm_action"]["content"].value = tid;
	document.all["frm_action"].submit();
}
function ck_exists()
{
	//ѡ��һ��������Դ
	//return alert();
	var obj = document.all["exists_track"];
	var url = obj.options[obj.selectedIndex].value;
	var site = parseInt(obj.options[obj.selectedIndex].site,10);
	//alert(site);
	var sid = obj.options[obj.selectedIndex].id;
	document.all["id_ls"].value = sid;
	document.all["txt_url"].value = url;
	auto_site(url);
}
function ck_store()
{
	//ѡ��һ��������Դ
	//����:��
	//���:��
	var obj = document.all["store_name"];
	var val = obj.options[obj.selectedIndex].value;
	//var site = parseInt(obj.options[obj.selectedIndex].id,10);
	var site = obj.options[obj.selectedIndex].id;
	//alert(site);
	//return;
	//alert(g_arr_v2u);
	//alert(g_arr_v2u[site]+":"+val);
	var url = "";
	url = val2url(site,val);
	//return;
	document.all["txt_url"].value = url;
	auto_site(url);
	//window.clipboardData.getData("Text",url);
	//window.clipboardData.getData("Url",url);
	
	//alert(window.clipboardData.getData("Text"));
	//change_url();
	//alert(url);
	//document.all["cid"].value = id;
	//var author = m_arr_author[id];
	//document.all["txt_author"].value = author;
}
</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" onload="javascript:init();">
<?php
//echo $m_js;
//echo $m_htmltitle;
?>
<h2>1.����δ��������ʼ��������</h2>
<table border=0 cellspacing=0 cellpadding=0 style="width:100%;">
	<tr>
	<td style="width:30%;"></td>
		<td>
������<input type="text" name="search_title" size="15" value="<?=$m_kw;?>" disabled onclick="javascript:this.value='';"/>

		</td>
<td>
<!--<button onclick="javascript:tests_dom();" style="display:block;">tests</button>
//-->
<button id="btn_create" onclick="javascript:document.all['tbl_detail'].style.display = 'block';" style="display:none;">��ʼ����</button>
</td><td>
<button id="btn_rmbook" onclick="javascript:rm_book();" style="display:block;">ɾ��������</button>
</td>
	<td style="width:30%;"></td>
	</tr>
</table>
<div style="height:70px;width:100%;">˵����<br/>��.�������δ���������ȵ�����ġ���ʼ��������ť����һ�����顣<br/>��.���鴴���ɹ��󣬾Ϳ���Ϊ����ѡ��һ����Դ��վ���㡰�����Դ����ť��������½ڽ�������Դ��վ�Զ�ͬ����</div>
<!--���ܱ�//-->
<form method="POST" name="frm_action" action="./cmd.php" target="submitframe" accept-charset="GBK">
<table border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top">
��ĿID��&nbsp;&nbsp;&nbsp;<input type="text" name="cid" size="8" value="<?=$m_cid;?>"/>&nbsp;&nbsp;&nbsp;
<?php
echo $m_lists;
?>
<button onclick="javascript:link_mybook();">��Ŀ��������ǰ����</button>&nbsp;&nbsp;&nbsp;���ߣ�<input type="text" name="txt_author" size="8" value="<?=$m_author;?>"/><button onclick="javascript:update_author();">��������</button>
<br/>
<h2>2.Ϊ����ѡ��������Դ��վ</h2>(ѡ����Դ��վ��ϵͳ��Ϊ�����Դ��վ�Զ����������½���ӵ����飬��Դ��վ��ѡ��һ�������)
<br/>
��ԴURL��<input type="text" name="txt_url" size="50" value="" onbeforepaste="javascript:change_url();"/>&nbsp;
<?php
echo html_flag();
?>
<br/>
</td>
	</tr>
	<tr>
		<td valign="top" align="center">
<button onclick="javascript:if(''==document.all['id_ls'].value){alert('������������Դ�б���ѡ��һ����Դ');return false;}window.open('/site838/view/src_php/track_sou.php?sid='+document.all['id_ls'].value);return false;">����Դ</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(''==document.all['id_ls'].value){alert('������������Դ�б���ѡ��һ����Դ');return false;}rm_sou(document.all['id_ls'].value);">ɾ����Դ</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(m_cid < 1){alert('ɾ��ʧ�ܣ���ĿID��Ч');return false;}del_class();">ɾ����Ŀ</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(''==document.all['txt_url'].value){alert('��������ԴURL����д�µ���Դ');return false;}up_url();">������Դ</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(''==document.all['txt_url'].value){alert('����ѡ��һ��������Դ');return false;}add();">�����Դ</button>
<span style="width:100px;"></span>
		</td>
	</tr>
	<tr>
		<td valign="top">
<?php
echo $m_store;
?>
		</td>
	<tr>
		<td valign="top" id="td_empty">
		</td>
	</tr>
<table>

<input type="hidden" name="fun" value="add_track"/>
<input type="hidden" name="id_ls" value=""/>
<input type="hidden" name="clist" value=""/>
<input type="hidden" name="ref" value=""/>
<input type="hidden" name="content" value=""/>
</form>

<!--��������//-->
<table border="0" cellspacing="0" cellpadding="0" id="tbl_detail"  style="display:none;left:350px;width:430px;height:200px;top:0px;position:absolute;z-index:10;">
<tr><td valign=top class="box-note" id="td_detail">
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="h2-note"><img src="./images/icon_timealert32.gif" align=absmiddle>Ϊ����ѡ��һ��������Ŀ</td><td><img style='cursor:hand;position:absolute;right:5px;top:5px;display:block' src="./images/cha.gif" onclick="javascript:this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';" alt="�ر�"/></td></tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class=note align="center"><?=html_sonclass();?></td></tr></table>
<table width="100%" border="0" cellspacing="2" cellpadding="0"><tr><td class=note><span class=lh15></td></tr></table>


</td>
</tr>
</table>

<iframe name="submitframe" width="1" height="1"></iframe>
</BODY>
</HTML>
