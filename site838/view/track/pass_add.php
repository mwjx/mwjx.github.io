<?php
//------------------------------
//create time:2008-5-7
//creater:zll,liang_0735@21cn.com
//purpose:�½ڹ����������
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
my_safe_include("mwjx/track.php");

$m_site = intval(isset($_GET["site"])?$_GET["site"]:-1); //վ��
$m_t = intval(isset($_GET["t"])?$_GET["t"]:-1); //����
$m_arrflag = arr_track_flag(); //flag=>title
$m_lists = ""; //�����б�
$m_title = ""; //վ������
if(isset($m_arrflag[$m_site])){ //��������
	$m_title = $m_arrflag[$m_site];
	$m_lists = html_pass($m_site,$m_t);
}
//$m_cid = -1;
//$m_author = ""; //����
//$m_id = 1; //tests

function js_track_domain()
{
	//��Դ������־
	//����:��
	//���:html�ַ���
	global $m_site;
	global $m_t;
	$js = "<script language=\"javascript\">\n";
	//$js .= "var m_arr_td = Array();\n";
	$js .= "var m_site = '".$m_site."';\n";
	$js .= "var m_t = '".$m_t."';\n";
	/*$arr = arr_track_domain();
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
	}*/
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
		$title = $flag.".".$title;
		$html .= "<option value=\"".$flag."\">".$title."</option>";
	}
	$html .= "</select>";
	return $html;
}
function html_pass($site=-1,$type = -1)
{
	//ĳվ�������б�
	//����:siteվ��,type����
	//���:html�ַ���
	//����
	$str_sql = "select * from track_pass where site='".$site."' order by id asc;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	//�γ��ַ���
	$html = "";
	$html .= "�����б�<select name=\"st_passlists\" style=\"width:400px;\" SIZE=\"8\" MULTIPLE onchange=\"javascript:ck_store();\">\n";
	//$arr_flag = arr_track_flag(); //flag=>title
	$len = count($arr);
	//var_dump($arr);
	//exit();
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i]["id"];
		$site = intval($arr[$i]["site"]);
		$t = intval($arr[$i]["t"]);
		$val = $arr[$i]["val"];
		
		$title = $id.".[".$t."],".htmlspecialchars($val);
		$html .= "<option value=\"".htmlspecialchars($val)."\" id=\"".$id."\" t=\"".$t."\">".($title)."</option>\n";
	}
	$html .= "</select>";
	if($type < 1)
		return $html;
	$txt = "";
	for($i = 0;$i < $len; ++$i){
		$t = intval($arr[$i]["t"]);
		if($t != $type)
			continue;
		$id = $arr[$i]["id"];
		$site = intval($arr[$i]["site"]);
		$val = $arr[$i]["val"];
		if("" != $txt)
			$txt .= "\n";
		$txt .= htmlspecialchars($val);
		
		
		//$title = $id.".[".$t."],".htmlspecialchars($val);
		//$html .= "<option value=\"".htmlspecialchars($val)."\" id=\"".$id."\" t=\"".$t."\">".($title)."</option>\n";
	}
	$html .= "<br/>�����б�<TEXTAREA STYLE=\"width:800px;height:130px;\" name=\"txt_rules\">";
	$html .= $txt;
	$html .= "</TEXTAREA><br/>";
	$html .= "�����ļ���<input type=\"text\" name=\"txt_file\" size=\"50\" value=\"\"/><button onclick=\"javascript:debug();\">��ʼ���Թ���</button>&nbsp;&nbsp;�ļ�����:2/03bdc69e5c9a8980c2d386c1ab2a0f42.html";
	//var_dump($html);
	//exit();
	return $html;
}
function html_class($kw="")
{
	//��Ŀ�б�
	//����:kw(string)�����ؼ���
	//���:html�ַ���
	global $m_cid;
	global $m_author;
	$str_sql = "select id,name,memo from class_info where name like '%".$kw."%';";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	
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
	$sql = new mysql;
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
	$sql = new mysql;
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
<TITLE> ��ӹ������� </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<link rel="icon" href="favicon.ico" type=""/>
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
a:link,a:visited,a:hover,a:active{color:#0000ff;cursor:hand;}body,table,div,ul,li{font-size:10px;margin:0px;padding:0px}body{background-color:;font-family:arial,sans-serif;height:100%}

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
<script language="javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
function go_search(str)
{
	//��תҳ���ѯ
	//����:str(string)��ѯ�طּ���
	//���:��
	//return alert(str);
	var url = "./pass_add.php?site="+str;
	document.location.href = url;
	//alert(str);
}
function t_lists()
{
	//��ʾ�����б�
	//����:��
	//���:��
	var t = parseInt(document.all["st_t"].value,10);
	if(t < 1)
		return alert("��ѡ������");
	var url = "./pass_add.php?site="+m_site+"&t="+t;
	document.location.href = url;
	//alert(url);
}
function change_url()
{
	//����url�Զ�ʶ����Դ
	//����:url��Դ��ַ
	//���:��
	var url = window.clipboardData.getData("Text");
	//alert(url);
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
				var obj = document.all["flag_id"].options;
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
function commit_rules()
{
	//�����ύ����
	//����:��
	//���:��
	var site = parseInt(document.all["hd_site"].value,10);
	var t = parseInt(document.all["st_t"].value,10);
	if(site < 1)
		return alert("�ύʧ�ܣ�վ����Ч");
	if(t < 1)
		return alert("�ύʧ�ܣ�������Ч");
	//alert(site);
	document.all["frm_action"]["fun"].value = "commit_rules";
	document.all["frm_action"].submit();

}
function debug()
{
	//���Թ���
	//����:��
	//���:��
	var url = "./rules_debug.php?site="+m_site;
	var t = parseInt(document.all["st_t"].value,10);
	var file = document.all["txt_file"].value;
	url += "&t="+t;
	url += "&file="+file;
	window.open(url);
}
function add()
{
	//�������
	//����:��
	//���:��
	var site = parseInt(document.all["hd_site"].value,10);
	var t = parseInt(document.all["st_t"].value,10);
	//return alert("��ӵ���Ŀ:"+typeof(sou));
	//if("" == document.all["frm_action"]["cid"].value)
	//	return alert("���ʧ�ܣ���ĿID����Ϊ��");
	if("" == document.all["frm_action"]["txt_val"].value)
		return alert("���ʧ�ܣ���������Ϊ��");
	if(site < 1)
		return alert("���ʧ�ܣ�վ����Ч��"+site);
	if(t < 1)
		return alert("���ʧ�ܣ�������Ч��"+t);
	document.all["frm_action"]["fun"].value = "add_pass";
	document.all["frm_action"].submit();
	//if(!window.confirm("�Ƿ���Ҫ���ύ�ɹ���������Ϊ�Ѷ���"))
	//	return;
	//reset_used();
}
function del()
{
	//ɾ������
	//����:��
	//���:��
	var id = parseInt(document.all["hd_id"].value,10);
	if(id < 1)
		return alert("ɾ��ʧ�ܣ�ID��Ч��"+id);
	document.all["frm_action"]["fun"].value = "del_pass";
	document.all["frm_action"].submit();
}
function rm_emptysou()
{
	//ɾ������Դ
	//����:��
	//���:��
	//return alert();
	document.all["frm_action"]["fun"].value = "rm_emptysou";
	document.all["frm_action"].submit();
}
function create_static()
{
	//����������Ŀ��̬�ļ�
	//����:��
	//���:��
	document.all["frm_action"]["fun"].value = "static_all";
	document.all["frm_action"].submit();
}
function add_sou(title,flag)
{
	//���վ��
	//����:title����,flag����
	//���:��
	//var id = parseInt(document.all["hd_id"].value,10);
	//if(id < 1)
	//	return alert("ɾ��ʧ�ܣ�ID��Ч��"+id);
	if("" == title)
		return alert("���Ʋ���Ϊ��");
	//return alert(title+":"+flag);
	document.all["frm_action"]["fun"].value = "add_sou";
	document.all["frm_action"]["hd_id"].value = title;
	document.all["frm_action"]["hd_site"].value = flag;
	document.all["frm_action"].submit();
}

function update_author()
{
	if("" == document.all["frm_action"]["cid"].value)
		return alert("����ʧ�ܣ���ĿID����Ϊ��");
	document.all["frm_action"]["fun"].value = "update_author";
	document.all["frm_action"].submit();
}
function init()
{
	//��ʼ
	//����:��
	//���:��
	//if(m_t < 1)
	//	return;
	var obj = document.all["st_t"];
	for(var i = 0;i < obj.options.length; ++i){
		if(m_t == obj.options[i].value){
			obj.options[i].selected = true;			
			break;
		}
	}
	var sites = document.all["flag_id"];
	for(var i = 0;i < sites.options.length; ++i){
		if(m_site == sites.options[i].value){
			sites.options[i].selected = true;			
			break;
		}
	}
	//alert("aaa");
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
	var url = "../cmd.php?fun=new_class&fid="+fid+"&name="+name;
	url += "&cdir=Y"; //�½���Ŀ
	xmldoc.async="false";
	xmldoc.load(url);
	var str_confrim = "������Ŀʧ��";
	//alert(xmldoc.xml);
	if(null != xmldoc.documentElement.childNodes[0])
		str_confrim = xmldoc.documentElement.childNodes[0].text;
	alert(str_confrim);
	window.location.reload();
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
function ck_exists()
{
	var obj = document.all["exists_track"];
	var val = obj.options[obj.selectedIndex].value;
	alert(val);
}
function ck_store()
{
	//ѡ��һ��������Դ
	//����:��
	//���:��
	var obj = document.all["st_passlists"];
	var id = obj.options[obj.selectedIndex].id;
	var t = obj.options[obj.selectedIndex].t;
	var val = obj.options[obj.selectedIndex].value;
	//var site = parseInt(obj.options[obj.selectedIndex].id,10);
	//alert(site+":"+val);
	var objt = document.all["st_t"];
	for(var i = 0;i < objt.options.length; ++i){
		if(t == objt.options[i].value){
			objt.options[i].selected = true;
			break;
		}
	}
	document.all["hd_id"].value = id;
	document.all["txt_val"].value = val;
	//auto_site(url);
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
echo $m_js;
//echo $m_htmltitle;
?>
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top" align="center">
����<button onclick="javascript:rm_emptysou();" title="ɾ��û����Ŀ����Դ">ɾ������Դ</button>
&nbsp;&nbsp;<button onclick="javascript:create_static();" title="����������Ŀ�ľ�̬�ļ�����ָ��">������Ŀ��̬</button>
<br/>

��ǰվ�㣺<?=$m_title;?>&nbsp;&nbsp;
<?php
echo html_flag();
?>
&nbsp;<button onclick="javascript:go_search(flag_id.value);">��������</button>	&nbsp;&nbsp;<!--&nbsp;&nbsp;<button onclick="javascript:	document.all['tbl_detail'].style.display = 'block';">������Ŀ</button>//-->	
���ƣ�<input type="text" name="txt_soutitle" value="" size="12"/>&nbsp;&nbsp;
������ʶ(�������|�ŷָ�)��<input type="text" name="txt_souflag" value="" size="8"/>&nbsp;<button onclick="javascript:add_sou(txt_soutitle.value,txt_souflag.value);">���վ��</button>
<br/>
	
<br/><br/>
<?php
//echo $m_htmltitle;
?>

		</td>
	</tr>
</table>
<!--���ܱ�//-->
<form method="POST" name="frm_action" action="../cmd.php" target="submitframe" accept-charset="GBK">
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top">
���ͣ�&nbsp;&nbsp;&nbsp;
<select name="st_t" onchange="javascript:hd_id.value='-1';">
<option value="-1">--ѡ���������--</option>
<option value="1">1.��[�½�]URL�д�������</option>
<option value="2">2.��[�½�]URL�в���������</option>
<!--<option value="5">5.[��Դ]URL�д�������</option>
<option value="6">6.[��Դ]URL�в���������</option>
//-->
<option value="7">7.[�½�]�����д�������</option>
<option value="8">8.[�½�]�����в���������</option>
<option value="9">9.[�½�]���ⳤ��С������</option>
<option value="10">10.[�½�]���ⳤ�ȴ�������</option>
<option value="11">11.��[�½�]�������</option>
<option value="12">12.��[�½�]���ݹ���</option>
<option value="13">13.[�½�]���߹���</option>
<option value="14">14.[�½�]����:utf8,gb2312</option>
<option value="15">15.[�½�]������ַ����:ǰ��`|��</option>

<option value="21">21.��[����]�б���ʼҳ</option>
<option value="22">22.[����]�б�򿪷�ʽget(Ĭ�ϲ�д)/post</option>
<option value="23">23.��[����]URL�д�������</option>
<option value="24">24.��[����]URL�в���������</option>
<option value="25">25.[����]�����ҵ�����</option>
<option value="26">26.[����]�����Ҳ�������</option>
<option value="27">27.��[����]��ȡ����Դ�б�</option>
<option value="28">28.��[����]��ȡ����Դ��¼</option>
<option value="29">29.[����]ȥ��URL�еĲ���</option>
<option value="41">41.[����]�б���ʼҳ</option>
<option value="42">42.[����]�б�򿪷�ʽget(Ĭ�ϲ�д)/post</option>
<option value="43">43.[����]URL�д�������</option>
<option value="44">44.[����]URL�в���������</option>
<option value="45">45.[����]�����ҵ�����</option>
<option value="46">46.[����]�����Ҳ�������</option>
<option value="47">47.[����]��ȡ����Դ�б�</option>
<option value="48">48.[����]��ȡ����Դ��¼</option>
<option value="49">49.[����]ȥ��URL�еĲ���</option>
</select>
&nbsp;&nbsp;&nbsp;

&nbsp;&nbsp;&nbsp;
������<input type="text" name="txt_val" size="50" value=""/>&nbsp;

<br/>
</td>
	</tr>
	<tr>
		<td valign="top" align="center">
<button onclick="javascript:del();">ɾ������</button>
&nbsp;&nbsp;
<button onclick="javascript:add();">��������</button>
&nbsp;&nbsp;
<button onclick="javascript:t_lists();">�����б�</button>
&nbsp;&nbsp;
<button onclick="javascript:commit_rules();">�����ύ</button>
		</td>
	</tr>
	<tr>
		<td valign="top">
<?php
//echo html_store($m_kw);
echo $m_lists;
?>
		</td>
	</tr>
<table>

<input type="hidden" name="fun" value="add_pass"/>
<input type="hidden" name="hd_id" value="-1"/>
<input type="hidden" name="hd_site" value="<?=$m_site;?>"/>
<input type="hidden" name="ref" value=""/>
</form>

<!--��������
<table border="0" cellspacing="0" cellpadding="0" id="tbl_detail"  style="display:none;left:550px;width:430px;height:200px;top:40px;position:absolute;z-index:10;">
<tr><td valign=top class="box-note" id="td_detail">
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="h2-note"><img src="../images/icon_timealert32.gif" align=absmiddle>ѡ����Ŀ</td><td><img style='cursor:hand;position:absolute;right:5px;top:5px;display:block' src="../images/cha.gif" onclick="javascript:this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';" alt="�ر�"/></td></tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class=note align="center"><?=html_sonclass();?></td></tr></table>
<table width="100%" border="0" cellspacing="2" cellpadding="0"><tr><td class=note><span class=lh15></td></tr></table>
//-->

</td>
</tr>
</table>

<iframe name="submitframe" width="1" height="1"></iframe>
</BODY>
</HTML>
