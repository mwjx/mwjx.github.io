<?php
//------------------------------
//create time:2007-8-23
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��Ŀ��Ŀ����
//------------------------------
if("С��" != $_COOKIE['username']){
	$html = "������Դ���ƣ���������ʱ�رա�";	
	exit($html);
}
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_dir.php");
my_safe_include("mwjx/class_info.php");
$m_cd = new c_class_dir;
$m_search_id = intval(isset($_POST["search_cid"])?$_POST["search_cid"]:-1);
$m_dumpcid = intval(isset($_GET["dumpcid"])?$_GET["dumpcid"]:-1);
$m_editid = intval(isset($_GET["editid"])?$_GET["editid"]:-1);
//����˳��,asc,desc
$m_order = (isset($_GET["order"])?$_GET["order"]:"asc"); 
//�༭
$m_editcid = "";
$m_edittitle = "";
$m_editcontent = "";
if($m_editid > 0){ //�༭
	$arr_dir = $m_cd->get_dir($m_editid);
	if(1 == count($arr_dir)){
		$m_editcid = $arr_dir[0]["cid"];
		$m_edittitle = $arr_dir[0]["title"];	
		$m_editcontent = $arr_dir[0]["content"];
	}
}
//����
//$m_dumpcid = 16; //test
if($m_dumpcid > 0){
	$m_editcid = $m_dumpcid;
	$m_editcontent = get_cdata($m_dumpcid);	
}
//����
$html_ls = "";
if($m_search_id > 0){ //�г��������
	$arr_list = $m_cd->search($m_search_id);
	$len = count($arr_list);
	for($i = 0;$i < $len; ++$i){
		$id = $arr_list[$i]["id"];
		$cid = $arr_list[$i]["cid"];
		$title = $arr_list[$i]["title"];
		$html_ls .= "<tr><td>��ĿID��".$cid."&nbsp;&nbsp;���⣺".$title."&nbsp;&nbsp;<a href=\"./class_dir.php?editid=".$id."\">�༭</a></td></tr>\n";
	}
}
function get_cdata($id = -1)
{
	//����һ����Ŀ����Ŀ
	//����:id(int)��ĿID
	//���:�ַ���
	global $m_order;
	$obj = new c_class_info($id);
	if($obj->get_id() < 1)
		return "";
	$arr = $obj->son_article(2);
	$str = "";
	$len = count($arr);
	if(0 == $len)
		return "";
	$count = 0;
	if("asc" == $m_order){
		for($i = ($len-1);$i >= 0; --$i){
			$aid = $arr[$i][0];
			$title = $arr[$i][1];
			$str .= $aid."`|)".$title."\n";
			if(++$count > 300)
				break;
		}
	}
	else{
		for($i = 0;$i < $len; ++$i){
			$aid = $arr[$i][0];
			$title = $arr[$i][1];
			$str .= $aid."`|)".$title."\n";
			if(++$count > 300)
				break;
		}
	}
	return $str;
}
?>
<HTML>
<HEAD>
<TITLE> ��Ŀ��Ŀ���� </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<script language="javascript">
function commit()
{
	//�ύ
	//����:��
	//���:��
	//alert(document.all["txt_title"].value);
	if("" == document.all["txt_cid"].value)
		return alert("��ĿΪ��");
	if("" == document.all["txt_title"].value)
		return alert("����Ϊ��");
	//if("" == document.all["txt_content"].value)
	//	return alert("����Ϊ��");
	//return;
	//----------�ύ---------
	//document.all["hd_clist"].value = list;
	document.all["frmsubmit"].action = '../cmd.php';
	//alert(document.all["frmsubmit"].action);
	//submitframe
	//alert("��ʼ�ύ");
	document.all["frmsubmit"].submit();
}
function gotodump(order)
{
	//��ת������ҳ
	//����:order(string)˳��asc/desc
	//���:��
	window.location.href='./class_dir.php?dumpcid='+document.all["txt_cid"].value+"&order="+order;
}
function init()
{
	//��ʼ
	//run();
}
</script>
</HEAD>

<BODY onload="javascript:init();">
<table>
<tr><td>
<h1>��Ŀ��Ŀ�����ָ���(`|))</h1>
</td></tr>
<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">
<input name="fun" type="hidden" value="add_classdir"/>
<tr><td>
��ĿID:<input name="dir_id" type="text" size="5" value="<?=$m_editid;?>"/>
&nbsp;&nbsp;
��ĿID:<input type="text" name="txt_cid" value="<?=$m_editcid;?>" size="5"/>&nbsp;&nbsp;��Ŀ����:<input type="text" name="txt_title" value="<?=$m_edittitle;?>" size="35"/>
</td></tr>
<tr><td>
<textarea cols="80" name="txt_content" rows="17" style="FONT-SIZE: 9pt"><?=$m_editcontent;?></textarea>
</td></tr>
<tr><td>
<button onclick="javascript:commit();">�ύ</button>
<button onclick="javascript:gotodump('asc');">������Ŀ����(���300����˳��)</button><br/>
<button onclick="javascript:gotodump('desc');">������Ŀ����(���300��������)</button>

</td></tr>
</form>
<form id="frmsubmit_2" name="frmsubmit_2" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="./class_dir.php" method="POST" target="_self">
<tr><td>
<br/><br/>
��ĿID:<input type="text" name="search_cid" value="<?=$m_dumpcid;?>"/>
<input type="submit" value="����">
</td></tr>
</form>
<?=$html_ls;?>
<!--
<tr><td>
<br/><br/>
�۷��ύ��
</td></tr>

<tr><td>
��ĿID:<input type="text" name="clist" value="" size="5"/>&nbsp;&nbsp;&nbsp;����:<input type="text" name="title" value="" size="48"/>
</td></tr>
<tr><td>
<tr><td>
�����ύƬ��
</td></tr>
<tr><td>
<textarea cols=80 name="content" rows="7" style="FONT-SIZE: 9pt"></textarea>
</td></tr>//-->
</table>
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>
