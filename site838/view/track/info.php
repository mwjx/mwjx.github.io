<?php
//------------------------------
//create time:2010-12-21
//creater:zll,liang_0735@21cn.com
//purpose:С˵��Ϣ
//------------------------------
if("" == $_COOKIE['username']){
	exit("δ��¼������<a href=\"http://www.fish838.com/site838/\">��838�Ķ�����</a>��ҳ��¼");
}
include("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/pagebase.php");
my_safe_include("mwjx/mybook.php");
my_safe_include("class_man.php");
require("../../key_fill/fd.php");
$fil = new fillter("../../key_fill/bw.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //��ĿID
//$m_id = 1387; //168; //tests
$m_mb = intval(isset($_GET["mb"])?$_GET["mb"]:-1); //����ID
$m_ctitle = ""; //����
$m_author = ""; //����

$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
$m_uid = $obj_man->get_id();
$m_atuoid = get_autoid($m_id); //�Զ������ԴID
//var_dump($m_atuoid);
//exit();
$str_sql = "select N.id,C.name,A.title from class_info C left join novels N on C.id=N.cid left join author A on A.id=N.author where C.id ='".$m_id."';";
//exit($str_sql);
$sql = new mysql;
$sql->query($str_sql);
$arr = $sql->get_array_array();
$sql->close();
if(1 != count($arr))
	exit("��Ŀ������");
$m_ctitle = $arr[0]["name"];
$m_author = $arr[0]["title"];
$m_nid = $arr[0]["id"];
$m_stat = 0; //״̬:0δ֪/1û�и����½�/2�и����½�/3��Ŀ�Ѿ����½�
//$m_nid = 25980;
$m_arr_site = arr_track_flag();
//var_dump($m_arr);
//exit();
$html_top = "";
$m_cnt = html_cnt($m_id,$m_nid,$m_uid);
$m_btn = html_btn($m_id,$m_uid,$m_nid,$m_ctitle);
//-------------����Ⱥ-----------

function write_js()
{
	global $m_nid;
	global $m_stat;
	global $m_id;
	//global $m_mb;
	$html = "";
	$html .= "<script language=\"javascript\">\n";
	$html .= "var m_nid=".$m_nid.";\n";
	$html .= "var m_cid=".$m_id.";\n";
	//$m_stat = 1;
	$html .= "var m_stat=".$m_stat.";\n";
	$html .= "</script>";
	return $html;
}
function get_autoid($cid=-1)
{
	//�Զ������ԴID
	//����:cid��ĿID
	//���:��ԴID/-1
	$str_sql = "select sid from auto_add where cid ='".$cid."' limit 1;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	$len = count($arr);
	$oid = -1;
	if(1 == $len)
		$oid = intval($arr[0][0]);
	return $oid;
}
function html_btn($cid=-1,$uid=-1,$nid=-1,$title="")
{
	//�ղذ�ť
	//����:cid��ĿID,uid�û�ID,nidС˵ID,titleС˵����
	//���:�ַ���
	global $m_mb;
	if($m_mb > 0){
		$oid = $m_mb;
	}
	else{
		$str_sql = "select id from my_book where cid ='".$cid."' and uid='".$uid."' limit 1;"; //9999
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
		$len = count($arr);
		$oid = -1;
		if(1 == $len){
			$oid = intval($arr[0][0]);
			$m_mb = $oid;
		}
	}
	$html = "";
	if(-1 == $oid){
		//add_book(".$nid.",'".$title."');
		$html .= "<LI class=\"bar_text\" style=\"margin:10px 0 0 60px;\"><A href=\"#\" target=\"_self\" onclick=\"javascript:auto_book(".$nid.",'".$title."');\">�����ղ�</A></LI>";
	}
	else{
		$html .= "<LI class=\"bar_text\" style=\"margin:10px 0 0 60px;\"><A href=\"#\" target=\"_self\" onclick=\"javascript:cancel_book(".$oid.");\">ȡ���ղ�</A></LI>";
	}
	return $html;
}
function html_cnt($cid=-1,$nid=-1,$uid=-1)
{
	//��������
	//����:cid��ĿID,nid�鼮ID
	//���:html�ַ���
	//$db = "fish838";
	global $fil;
	global $m_id;
	global $m_stat;
	//����½�ID
	//$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
	$obj_mb = new c_mybook;
	$aid = $obj_mb->get_flag($uid,$cid);

	$str_sql = "select * from article where cid ='".$cid."' order by id desc limit 10;"; //9999
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	$len = count($arr);
	if($len < 1){ //���������������У�
		return html_down($nid);
	}
	$m_stat = 3;
	//����5��
	$url_index = "index.php?id=".$m_id;
	$html = "<DIV id=\"div_articles\">�����½ڣ�<a href=\"".$url_index."\" target=\"_self\"><b>����...</b></a><br/><UL>";
	for($i = ($len-1);$i >= 0; --$i){
		$id = intval($arr[$i]["id"]);
		$url = "/site838/view/track/show.php?id=".$arr[$i]["id"];
		$title = $arr[$i]["title"];
		$title = $fil->fill($title);

		$color = "";
		if($aid == $id)
			$color = "style=\"color:red;\"";
		$html .= "<LI title=\"".$title."\" ><a href=\"".$url."\" target=\"_blank\" ".$color.">".$title."</a></LI>";
	}
	//$url = "index.php?id=".$m_id;
	$html .= "<LI style=\"text-align:right;\"><a href=\"".$url_index."\" target=\"_self\"><b>ȫ���½�...</b></a></LI>";
	$html .= "</UL></DIV>";
	return $html;
}
function html_down($nid=-1)
{
	//���ؽ���
	//����:nidС˵ID
	//���:�ַ���
	global $m_stat;
	//return "";
	$str_sql = "select count(*) from track_section TS inner join novels_links NL on TS.tid = NL.id where NL.novels ='".$nid."';"; 
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	$num = intval($arr[0][0]);
	
	$html = "";
	if($num > 0){
		$html = "<div style=\"width:250px;height:60px;margin:20px auto;\">������ɣ������Ա��������Դ��������½�</div>";
		$m_stat = 2;
	}
	else{
		$html = "<div style=\"width:250px;height:60px;margin:20px auto;\"><div style=\"width:248px;text-align:center;\">����������...<br/>�����ȥ��Ϣһ�£���10����ȫ���½���ɺ󼴿��Ķ�</div><img src=\"../../images/loading2.gif\"></div>";
		$m_stat = 1;
	}
	return $html;
}
function line_site($lid=-1,&$arrtitle,$site="")
{
	//һ����Դվ��
	//����:lid��ԴID,arrtitle�½ڱ�������array(array(oid,title))
	//���:�ַ���
	if(-1 == $lid)
		return "";
	global $m_atuoid;
	global $m_mb;
	$checked = "";
	$sty_td="listTd_live";
	if($m_atuoid==$lid){
		$checked = "checked=true";
		$sty_td="listtdliveb";
	}
	$url = "/site838/view/src_php/track_sou.php?sid=".$lid."&mb=".$m_mb;
	$last = "";
	for($i = 2;$i >=0;--$i){
		if(!isset($arrtitle[$i])){
			$last .= "<td width=\"20%\" class=\"".$sty_td."\">&nbsp;</td>";
			continue;
		}
		$last .= "<td width=\"20%\" class=\"".$sty_td."\"><a href=\"".$url."&ls=".$arrtitle[$i][0]."\" target=\"_blank\">".$arrtitle[$i][1]."</a></td>";
	}
	$html = "";
	//$checked = "checked=true";
	$html .= "<tr class=\"listTr_live_normal\" height=\"20\" align=\"center\" onmouseover=\"javascript:if('listTr_live_selected'!=this.className){this.className='listTr_live_over';}\" onmouseout=\"javascript:if('listTr_live_selected'!=this.className){this.className='listTr_live_normal';}\" style=\"background-color:red;\"><td width=\"10%\" class=\"".$sty_td."\"><input type=\"radio\" name=\"rdo_auto\" disabled=true ".$checked."/></td><td width=\"10%\" class=\"".$sty_td."\">".$site."</td>".$last."<td width=\"20%\" class=\"".$sty_td."\"><UL style=\"width:100%;height:100%;text-align:center;\"><LI class=\"bar_text\" style=\"margin:0px 10px 0 10px;\"><a href=\"#\" target=\"_self\" onclick=\"javascript:clear_section(m_cid,".$lid.");\">��Ϊ�Ѷ�</a></LI></UL></td></tr>";
	//<LI class=\"bar_text\" style=\"margin:0px 0 0 0px;\"><a href=\"".$url."\" target=\"_blank\">����½�</a></LI>
	return $html;
}
function sou_site($nid=-1,&$arrsite)
{
	//��Դվ�������½�
	//����:nidС˵ID,arrsiteվ���б�
	//���:html�ַ���
	$str_sql = "select NL.sou,NL.id,TS.id as oid,TS.title from track_section TS inner join novels_links NL on TS.tid = NL.id where NL.novels ='".$nid."' and TS.used='N' order by NL.id asc,TS.id desc;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$html = "";
	$nlid = -1;
	$sou = -1;
	$count = 0;
	$arr_last = array();
	while($row = $sql->fetch_array()){
		$id = intval($row["id"]);
		if($nlid != $id){
			//�����һ��
			$site = isset($arrsite[$sou])?$arrsite[$sou]:"δ֪";
			$line = line_site($nlid,$arr_last,$site);
			$html .= $line;
			//�����һ������
			$nlid = $id;
			$sou = intval($row["sou"]);
			$count = 0;
			$arr_last = array();
		}

		//$last .= "<td width=\"20%\" class=\"listTd_live\"><a href=\"#\">".$row["title"]."</a></td>";
		if($count >= 3)
			continue;
		++$count;
		$arr_last[] = array($row["oid"],$row["title"]);
		
	}
	$sql->close();
	//���һ��
	$site = isset($arrsite[$sou])?$arrsite[$sou]:"δ֪";
	$line = line_site($nlid,$arr_last,$site);
	$html .= $line;
	return $html;
}
function arr_track_flag()
{
	$str_sql = "select id,title from track_sou;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_rows();
	$sql->close();
	$len = count($arr);
	$re = array();
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i][0]);
		$title = $arr[$i][1];
		if($id < 1)
			assert(0);
		if("" == $title)
			continue;
		//echo $id.",".$title."<br/>";
		$re[$id] = $title;
	}
	return $re;
}
function ls_manager($cid=-1)
{
	//����Ա�б�
	//����:cid��ĿID
	//���:�ַ���
	$str_sql="select U.int_userid,U.str_username from tbl_user U inner join authorize AH on U.int_userid=AH.runer where AH.res_class=2 and AH.res='".$cid."' and AH.action=0 limit 12;";
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_rows();
	$sql->close();
	$len = count($arr);
	$html = "<UL>";
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i][0]);
		$title = $arr[$i][1];
		if($id < 1)
			assert(0);
		if("" == $title)
			continue;
		//echo $id.",".$title."<br/>";
		$html .= "<LI>".$id."��".$title."</LI>";
	}
	$html .= "<LI><a class=\"btn_color\" href=\"#\" onclick=\"make_manager(".$cid.");\">��Ϊ����Ա</a></LI>";
	$html .= "</UL>";
	return $html;
}
function ls_booker($cid=-1)
{
	//�����б�
	//����:cid��ĿID
	//���:�ַ���
	$str_sql="select U.int_userid,U.str_username from tbl_user U inner join my_book MB on U.int_userid=MB.uid where MB.cid='".$cid."' order by MB.aid desc limit 1024;";
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_rows();
	$sql->close();
	$len = count($arr);
	$html = "";
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i][0]);
		$title = $arr[$i][1];
		if($id < 1)
			assert(0);
		if("" == $title)
			continue;
		//echo $id.",".$title."<br/>";
		//".$id."��
		$html .= "<LI>".$title."</LI>";
	}
	return $html;
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE><?=$m_ctitle;?>|��838��ǡ� - ������ɫ����С˵վ��|www.fish838.com</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="����ɽׯ&�ƻ��Գ�" name="description"/>
<META content="����ɽׯ&�ƻ��Գ�,838���,����,��Ĭ��Ц,����,��ʷ,www.fish838.com" name="keywords"/>
<META NAME="Author" CONTENT="mwjx,С��"/>
<STYLE type=text/css media=screen>
@import url("/site838/view/css/tb_1.css");
@import url("/site838/view/css/tb_2i.css");
@import url("/site838/view/css/class_dir.css");
@import url("/site838/css/info.css");
</STYLE>
<META content="MSHTML 6.00.2900.2180" name=GENERATOR/>
<script type="text/javascript" src="/site838/view/include/script/cookie.js"></script>
<script language="javascript" src="../include/script/xmldom.js"></script>
<script language="javascript" src="../../include/info.js"></script>
<?=write_js();?>
</HEAD>
<BODY SCROLL="yes" class="W950" onload="init();">

<DIV id=Content><A name=main></A>
<DIV class="org_bd" style="float:left;width:180px;height:300px;">
<div class="org_bd" style="display:block;text-align:center;float:left;width:100%;height:80px;margin-left:0px;margin-top:0px;overflow:hidden;">
<UL style="width:100%;height:100%;text-align:center;">
<LI class="bar_text" style="margin:10px 0 0 60px;"><A href="index.php?id=<?=$m_id;?>" 
  target="_self">����Ķ�</A></LI>
  <?=$m_btn;?>
<!--<LI class="bar_text" style="margin:10px 0 0 60px;"><A href="#" 
  target="_self" onclick="javascript:uppage();">���԰�ť</A></LI>
  //-->
</UL>
</div>
</DIV>
<DIV class="org_bd" style="float:left;width:432px;height:300px;">
<div id="title_ad" style="width:100%;height:60px;">
<table width="100%" border="0" cellPadding="0" cellSpacing="0" align="center" valign="top">
<tr height="60" align="center">
<td>
<table border="0"><tr>
<td width="100%" align="center" style="color:red;"><H1>��<a href="/site838/view/track/index.php?id=<?=$m_id;?>"><?=$m_ctitle;?></a>��</H1>
&nbsp;&nbsp;���ߣ�<?=$m_author;?>
</td>
</tr></table>
</td>
</tr>
</table>
</div><!--end title_ad//-->
<div id="div_content" class="org_bd">
<?=$m_cnt;?>
</div>

</DIV>
<DIV class="org_bd" style="float:left;width:180px;height:300px;">
<div class="gray_bd"><p><IMG height=11 hspace=6 src="/site838/images/start_with.gif"  width=5><b>�������Ա</b>
</p>
<?=ls_manager($m_id);?>
</div>
</DIV>
<div class="org_bd" style="float:left;width:100%;"><IMG height=11 hspace=6 src="/site838/images/start_with.gif" 
      width=5>�������
<UL class="ls_booker"><?=ls_booker($m_id);?>
</UL>
</div>
<div class="org_bd" style="float:left;width:100%;"><IMG height=11 hspace=6 src="/site838/images/start_with.gif" 
      width=5>��Դվ��
<table class="bgcolor_white" border="0" width="100%" cellpadding="0" cellspacing="2" height="20">
			<thead>
			<tr class="listTr_live_normal" height="20" align="center">
	<td width="10%" class="listTableHead">�Զ����</td>
	<td width="10%" class="listTableHead">��Դվ��</td>
	<td width="20%" class="listTableHead">�����½�</td>
	<td width="20%" class="listTableHead">�����½�</td>
	<td width="20%" class="listTableHead">�����½�</td>
	<td width="20%" class="listTableHead">����</td>
			</tr>
			</thead>
			<tbody>
			<?=sou_site($m_nid,$m_arr_site);?>
			<!--<tr class="listTr_live_normal" height="20" align="center" onmouseover="javascript:if('listTr_live_selected'!=this.className){this.className='listTr_live_over';}" onmouseout="javascript:if('listTr_live_selected'!=this.className){this.className='listTr_live_normal';}">

	<td width="10%" class="listTd_live"><input type="radio" name="rdo_auto" disabled=true/></td>
	<td width="10%" class="listTd_live">��Դվ��</td>
	<td width="20%" class="listTd_live">�����½�</td>
	<td width="20%" class="listTd_live">�����½�</td>
	<td width="20%" class="listTd_live">�����½�</td>
	<td width="20%" class="listTd_live"><UL style="width:100%;height:100%;text-align:center;"><LI class="bar_text" style="margin:0px 10px 0 10px;"><a href="#">��Ϊ�Ѷ�</a></LI><LI class="bar_text" style="margin:0px 0 0 0px;"><a href="#">����½�</a></LI></UL></td>
			</tr>
			//-->
</tbody>
</table>
	  </div>
<!--<div class="org_bd" style="float:left;width:100%;height:60px;"><IMG height=11 hspace=6 src="/mwjx/images/start_with.gif" 
      width=5>��������</div>
//-->



</DIV>


<DIV id=Foot>
<DIV style="MARGIN: 0px auto; WIDTH: 380px; FONT-FAMILY: arial">


<br/>
<script type="text/javascript" src="../../count.js"></script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4899067-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>

<BR></DIV></DIV>
<!--//-->

<!--���ܱ�//-->
<form method="POST" name="frm_action" action="./down_txt.php" target="submitframe" accept-charset="GBK">
<input type="hidden" name="fun" value=""/>
<input type="hidden" name="id_ls" value=""/>
<input type="hidden" name="downtype" value=""/>
</form>
<div style="position:absolute;left: 315px; top: 283px; display: none;" id="ntcwin">
<table class="popupcredit" cellpadding="0" cellspacing="0"><tbody><tr><td class="pc_l">&nbsp;</td><td class="pc_c"><div id="div_title"  class="pc_inner"><span>���سɹ�<em>1</em>���ˢ�±�ҳ</span><img src="/site838/images/popupcredit_btn.gif" alt=""></div></td><td class="pc_r">&nbsp;</td></tr></tbody></table>
</div>
<iframe name="submitframe" width="1" height="1" src="about:blank"></iframe></BODY></HTML>
