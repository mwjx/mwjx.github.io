<?php
//------------------------------
//create time:2008-1-23
//creater:zll,liang_0735@21cn.com
//purpose:׷��Դչʾ
//------------------------------
if("" == $_COOKIE['username']){
	exit("��Ȩ��");
}
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
my_safe_include("mwjx/track.php");
my_safe_include("mwjx/rules.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/authorize.php");
require("../../key_fill/fd.php");
$fil = new fillter("../../key_fill/bw.php");
$m_ls = (isset($_GET["ls"])?$_GET["ls"]:""); //ѡ��ID�б�
//�Զ����,Y/N/A(�ͻ����Զ�/���Զ�/������Զ�)
$m_autoadd = isset($_GET["autoadd"])?$_GET["autoadd"]:"N"; 
$m_id = intval(isset($_GET["sid"])?$_GET["sid"]:-1); //��ԴID
$m_mb = intval(isset($_GET["mb"])?$_GET["mb"]:-1); //��ԴID
$m_cover = isset($_GET["cover"])?$_GET["cover"]:""; //�Ƿ񸲸�
//����,���ķ�ҳʱ��Ч
$m_author = isset($_GET["author"])?$_GET["author"]:"";
$m_read = isset($_GET["read"])?$_GET["read"]:"N"; //Y/N(�Ѷ�δ��)
$m_838 = false; //�Ƿ�838
//$m_id = 3; //tests
//$m_read = "Y";
//$m_autoadd = "A";
$m_arr_track = arr_track($m_id);
//var_dump($m_arr_track);
//exit();
//if(count($m_arr_track) < 1)
//	exit("��Դ��Ч");
$m_arr_site = arr_track_flag();
$m_flag = intval($m_arr_track[0]["flag"]);
$m_sitename = $m_arr_site[$m_flag]; 
$m_cid = get_track_cid($m_id);
if(-1 == $m_cid)
	exit("��Դ��Ч");
$m_autoadd_id = auto_add_id($m_cid);
$m_cinfo = new c_class_info($m_cid);
if($m_cinfo->get_id() < 1)
	exit("��Ŀ��Ч��".$m_cid);
$m_htmlselect=(html_lastlists($m_cid)); 
//$fil->fill

$m_author = $m_cinfo->get_author();
/*if("A" == $m_autoadd){ //����
	$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
	if($obj_man->get_id() < 1)
		exit("δ��¼");
	//exit("00");
	//��Ȩ
	$obj = new c_authorize;		
	//�༭����
	if(!$obj->can_do($obj_man,1,1,12))
		exit("��Ȩ����,eidt");
	//��������
	if(!$obj->can_do($obj_man,1,1,1))
		exit("��Ȩ����,add");
	//����
	set_time_limit(720);
	track_autoadd($m_id,$m_flag,$m_cid,$obj_man->get_name());
	$m_autoadd = "N"; //ֹͣ�Զ����
}*/
if("A838" == $m_autoadd){
	$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
	if($obj_man->get_id() < 1)
		exit("δ��¼");
	//exit("00");
	//��Ȩ
	$obj = new c_authorize;		
//	//�༭����
//	if(!$obj->can_do($obj_man,1,1,12))
//		exit("��Ȩ����,eidt");
//	//��������
//	if(!$obj->can_do($obj_man,1,1,1))
//		exit("��Ȩ����,add");
	//��Ŀ����Ա
	if(!$obj->can_do($obj_man,2,$m_cid,0))
		exit("��Ȩ����,���ǹ���Ա");
	$cover = isset($_GET["cover"])?intval($_GET["cover"]):-1;
	//var_dump($cover);
	//exit();
	//����
	set_time_limit(720);
	track_autoadd838($m_id,$m_flag,$m_cid,$obj_man->get_name(),$cover);
	$m_autoadd = "N"; //ֹͣ�Զ����
}
/**/
$m_htmltitle .= "<a href=\"/site838/view/track/index.php?id=".$m_cid."\" target=\"_blank\"><font size=\"5\">��".$m_cinfo->get_name()."��</font></a>&nbsp;&nbsp;";
$m_htmltitle .= "<select id=\"st_cid\" name=\"st_cid\">";
$m_htmltitle .= "<option value=\"".$m_cid."\">".$m_cinfo->get_name()."</option>\n";
//$m_htmltitle .= "<option value=\"1\">�������</option>\n";
//$m_htmltitle .= "<option value=\"2\">����һЦ</option>\n";
//$m_htmltitle .= "<option value=\"3\">��Ʒ�ղ�</option>\n";
//$m_htmltitle .= "<option value=\"6\">����Ц��</option>\n";
//$m_htmltitle .= "<option value=\"427\">����ʱ��</option>\n";
//$m_htmltitle .= "<option value=\"427\">����ʱ��</option>\n";
//$m_htmltitle .= "<option value=\"426\">��ҵ</option>\n";
//$m_htmltitle .= "<option value=\"64\">����</option>\n";
//$m_htmltitle .= "<option value=\"26\">�ֲ������</option>\n";
$m_htmltitle .= "</select>&nbsp;&nbsp;";
$m_lasttitle = "�����½ڣ�";
$arr_last = html_last($m_cid,$m_flag);
$m_lasttitle .= ($arr_last[0]."<br/>");
$m_htmllast = "";
//if(8 == $m_flag){
//	$m_htmllast = "��һ�θ������ݣ�<br/><textarea cols=\"65\" rows=\"16\">".$arr_last[1]."</textarea>";
//}
//exit("111");
//exit($m_ls);
//echo "aaa<br/>";
$m_arr = (text_content($m_id,$m_ls,$m_flag));
//exit("222");
$m_kw = $m_arr[0];
$m_ls = $m_arr[2];
if("" != $m_arr[3]){
	$m_htmltitle .= "<br/>������ͼƬ���쳣�½ڣ�";
	$m_htmltitle .= "<br/>".$m_arr[3];
}
//-----����б�Ϊ����-------
$arr = explode(",",$m_ls);
$len = count($arr);
$m_arr_id = array(); //id=>true
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i]);
	if($id < 1)
		continue;
	$m_arr_id[$id] = true;
}
//----end ����б�Ϊ����----
//js��Ϣ
$m_js = "";
$m_js .= "<script language=\"javascript\">\n";
$m_js .= "var m_souid=".$m_id.";\n";
$m_js .= "var m_cid=".$m_cid.";\n";
$m_js .= "var m_autoadd='".$m_autoadd."';\n";
$m_js .= "var m_cover='".$m_cover."';\n";
$m_js .= "</script>\n";
$m_dir = html_dir($m_cid);
//var_dump($m_arr);
//exit();
//31
$m_html = html_unused($m_id,intval($m_arr_track[0]["flag"]),$m_read);
function lastarticles838($id = -1)
{
	//��Ŀ�����½�
	//����:id(int)��ĿID
	//���:html�ַ���
	global $m_838;
	global $fil;
	$m_838 = true;
	$str_sql = "select id,title from article where cid='".$id."' order by id DESC limit 965;";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	$len = count($arr);
	//if($len < 1)
	//	return "";
	$html = "";
	$html .= "<select id=\"hd_aid\" name=\"hd_aid\">";
	$html .= "<option value=\"-1\">--����838--</option>";
	$ls = "";
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$title = ($arr[$i]["title"]);
		$title = $fil->fill($title);
		//exit($title);
		//$title = togbk_dolt($title);
		$ls .= "<option value=\"".$id."\">".$title."</option>";
	}
	//$ls = $fil->fill($ls);
	$html .= $ls;
	$html .= "</select>";
	return $html;
}
function html_lastlists($id=-1)
{
	//��Ŀ�����½�
	//����:id(int)��ĿID
	//���:html�ַ���
	return lastarticles838($id);
	/*$str_sql = "select C.aid,A.str_title from class_article C left join tbl_article A on C.aid = A.int_id where C.cid='".$id."' and A.enum_active='Y' order by A.int_id DESC limit 965;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	if($len < 1)
		return lastarticles838($id);
	$html = "";
	$html .= "<select name=\"hd_aid\">";
	$html .= "<option value=\"-1\">--����--</option>";
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["aid"]);
		$title = $arr[$i]["str_title"];
		//exit($title);
		//$title = togbk_dolt($title);
		$html .= "<option value=\"".$id."\">".$title."</option>";
	}
	$html .= "</select>";
	return $html;
	*/
}

function html_last($id=-1,$flag=-1)
{
	//��Ŀ�����½�
	//����:id(int)��ĿID,flag��Դ��־
	//���:array(title,coment)
	global $m_838;
	if($m_838){
		$str_sql = "select id,title from article where cid='".$id."' order by id DESC limit 1;";
		//exit($str_sql);
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
		if(count($arr) < 1)
			return "";
		$id = intval($arr[0][0]);
		$title = $arr[0][1];
		if("" == $title)
			$title = "�ޱ���";
		//$dir = g_dir_from_id($id);
		$url = "/site838/view/track/show.php?id=".$id;
		$str = "<a href=\"".$url."\" target=\"_blank\">".$title."</a>";
		$con = "";
		if(8 == $flag){ //���ķ�ҳ
			$tbl = intval(($id-1)/100000)+1;

			$str_sql = "select txt from a_data_".$tbl." where aid='".$id."';";
			//exit($str_sql);
			$sql = new mysql("fish838");
			$sql->query($str_sql);
			$arr = $sql->get_array_rows();
			$sql->close();
			$con = $arr[0][0];
		}		
		return array($str,$con);
	}
	exit("err,function:html_last");
	/*
	$str_sql = "select C.aid,A.str_title from class_article C left join tbl_article A on C.aid = A.int_id where cid='".$id."' and A.enum_active='Y' order by A.int_id DESC limit 1;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	if(count($arr) < 1)
		return "";
	$id = intval($arr[0][0]);
	$title = $arr[0][1];
	if("" == $title)
		$title = "�ޱ���";
	$dir = g_dir_from_id($id);
	$url = "/bbs/html/".$dir.$id.".html";
	$str = "<a href=\"".$url."\" target=\"_blank\">".$title."</a>";
	$con = "";
	if(8 == $flag){ //���ķ�ҳ
		my_safe_include("class_article.php");		
		$obj_article = new articlebase($id,"","Y"); 
		if($obj_article->get_id() > 0)
			$con = $obj_article->get_txt();

	}
	return array($str,$con);
	*/
}
function html_dir($id=-1)
{
	return "";
	//��Ŀ�б�
	//����:id(int)��ĿID
	//���:html�ַ���
	$obj = new c_class_dir;
	$arr = ($obj->search($id));
	
	$html = "";
	$html .= "<select name=\"dir_id\">";
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$title = $arr[$i]["title"];
		$html .= "<option value=\"".$id."\">".$title."</option>";
	}
	$html .= "</select>";
	return $html;
}
function html_unused($id=-1,$flag=0,$r='N')
{
	//δ���½��б�
	//����:id(int)��ԴID,flag(int)��Դ��վ����
	//���:html�ַ���
	global $m_arr_id;
	global $fil;
	global $m_mb;
	$str_sql = "select * from track_section where tid='".$id."' and used='".$r."' order by id ASC limit 2000;";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	if(count($arr) < 1)
		return "";
	
	$html = "";
	$html .= "<div id=\"title_index\"><ul>";
	$len = count($arr);
	$dir = "../../../data/update_track/".$id."/";
	$url_open = "./track_sou.php?sid=".$id."&mb=".$m_mb;
	$line = 0;
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		if(isutf8($flag)){ //utf8 to gb
			$title = strip_tags(togbk_dolt($arr[$i]["title"]));
		}
		else{
			$title = strip_tags($arr[$i]["title"]);
		}
		$title = $fil->fill($title);
		$url_sou = $arr[$i]["url"];
		//$url = $dir.md5($url_sou).".html";
		$url = $url_open."&ls=".$id;
		$check = "";
		if(isset($m_arr_id[$id]))
			$check = "checked=\"true\"";
		$ch_line = "";
		if(0 == $i%3){
			++$line;
			$ch_line = "<img src=\"/site838/view/image/bsall4.gif\" style=\"cursor:hand;\"  alt=\"ѡ�б���\" onclick=\"javascript:ck_line(".$line.");\"/>&nbsp;";
		}
		$html .= "<li>".$ch_line."&#149;<input id=\"ck_section_".$id."\" line=\"".$line."\" name=\"line_".$line."\" type=\"checkbox\" ".$check."/><a href=\"".$url_sou."\" target=\"_blank\"><img src=\"/site838/view/images/navigation.gif\" border=\"0\"/></a>&nbsp;<a href=\"".$url."\" target=\"_self\">".$title." </a>&nbsp;</li>";
	}
	$html .= "</ul></div>";
	return $html;
}
function arr_track($id = -1)
{
	//ȡ����Դ����Ϣ
	//����:id(int)��ԴID
	//���:��Ϣ���飬�쳣���ؿ�����
	//$str_sql = "select * from update_track where id='".$id."';";
	$str_sql = "select sou as flag from novels_links where id='".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	if(1 != count($arr))
		return array();
	return $arr;
}
function auto_add_id($cid=-1)
{
	//������Ŀ���Զ������ԴID
	//����:cid��ĿID
	//���:��ԴID,û����Դ����-1
	$str_sql = "select sid from auto_add where cid='".$cid."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_rows();
	$sql->close();
	if(count($arr) < 1)
		return -1;
	return intval($arr[0][0]);
}
/*
function html_lists($id=-1)
{
	//С˵��Ŀ�б�
	//����:id(int)����׷�ٸ���ĿID
	//���:html�ַ���
	$obj = new c_class_info($id);
	if($obj->get_id() < 1)
		return "";
	$arr = $obj->son_link_class();
	$html = "";
	$sou = arr_sou();
	//var_dump($sou);
	//exit();
	$ls = "";
	foreach($sou as $row){
		$len = count($row);
		for($i = 0;$i < $len; ++$i){
			if("" != $ls)
				$ls .= ",";
			$ls .= $row[$i][0];
		}
	}
	$js_ls = "<script language=\"javascript\">\n"; //��ԴID�б�,js����
	$js_ls .= "var m_arr_ls = Array(".$ls.");\n";
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$cid = intval($arr[$i][0]);
		$title = $arr[$i][1];
		$html .= "<dl class=\"dl_book\">";
		$html .= "<dt><a href=\"/data/".$cid.".html\" target=\"_blank\">".$title."</a></dt>";
		$html .= "<dd><ul>";
		if(isset($sou[$cid])){
			$len2 = count($sou[$cid]);
			for($j = 0;$j < $len2; ++$j){
				$id = $sou[$cid][$j][0];
				$html .= "<li><a href=\"".$sou[$cid][$j][2]."\" target=\"_blank\">".$sou[$cid][$j][1]."</a>&nbsp;<span id=\"spn_new_".$id."\"></span><span id=\"spn_load_".$id."\"></span></li>";
			}
		}
		$html .= "</ul></dd>";
		$html .= "</dl>";

	}
	$js_ls .= "</script>\n";
	return $js_ls.$html;
}
*/
function arr_sou()
{
	//��Դ����
	//����:��
	//���:���飬��ʽ��cid=>array(array(id,title,url));
	$re = array();
	$str_sql = "select * from update_track;";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
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

function track_autoadd($id=-1,$flag=-1,$cid=-1,$poster="")
{
	//�Զ���Ӹ�������
	//����:id(int)��ԴID,flag(int)��Դ���ͱ�־,cid��ĿID
	//poster������
	//���:��
	//exit("kk");
	include_once("./control/article_post.php");
	$limit = 1; //ÿ�η�������ƪ��
	$scid = strval($cid);
	$obj = new c_class_dir;
	$arr = ($obj->search($cid));
	$dirid = -1;
	if(count($arr) > 0)
		$dirid = intval($arr[(count($arr)-1)][0]);
	//var_dump($dirid);
	//exit();
	//δ���б�
	$str_sql = "select * from track_section where tid='".$id."' and used='N' order by id ASC;";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	if(count($arr) < 1)
		return;
	$len = count($arr);
	$count = 0;
	$ls = "";
	for($i = 0;$i < $len; ++$i){
		++$count;
		if("" != $ls)
			$ls .= ",";
		$ls .= $arr[$i]["id"];
		if((0 == $count%$limit) || ($count==$len)){
			//echo $ls.",";
			//if(0 == $count%20)
			//	echo "<br/>\r\n";
			//flush();
			$arr_post = (text_content($id,$ls,$flag,$limit));
			//����,���ǣ�
			//var_dump($arr_post);
			//exit();
			if(!post_track(-1,$scid,trim($arr_post[0]),trim($arr_post[1]),$dirid,$poster))
				return;
			//��Ϊ�Ѷ�
			$str_sql = "update track_section set used='Y' where id in(".$ls.");";
			$sql = new mysql("fish838");
			$sql->query($str_sql);
			$sql->close();
			/**/
			//next
			//var_dump($arr_post);
			//$count = 0;
			$ls = "";
		}
		
		
	}
	//exit();
}

function post_track($aid=-1,$clist="",$title="",$content="",$dirid=-1,$poster="")
{
	//��������
	//����:aid����ID,clist��Ŀ�б�,title����,content����,
	//dirid��ĿID,$poster����������
	//���:true,false
	//exit("vvv");
	if(strlen($title) > 255 || strlen($title) < 1)
		return false;
	if(strlen($content) > 100000 || strlen($content) < 20)
		return false;
	$cid = "";
	if(false === strpos($clist,',',0)){			
		$cid = $clist;
	}
	else{
		$arr = explode(",",$clist);
		$cid = strval($arr[0]);
	}
	$icid = intval($cid);
	if($icid < 1)
		return false;
	if($aid > 0){ //�༭����
		$re = edit_article($aid,$title,$content);
		if(!$re)
			return false;
		if($dirid < 1)
			return true;
		//------��ӵ���Ŀ---------
		$objdir = new c_class_dir;
		$arr_dir = ($objdir->get_dir($dirid));
		if(count($arr_dir) > 0){
			$dirtitle = $arr_dir[0]["title"];
			$dircontent = $arr_dir[0]["content"];
			//$dircontent .= "\n";
			$row = explode("\n",$dircontent);
			$len = count($row);
			$newcontent = "";
			$strkey = $aid."`|)";
			$newtitle .= $aid."`|)".$title;
			for($i = 0;$i < $len; ++$i){
				if("" == $row[$i])
					continue;
				if("" != $newcontent)
					$newcontent .= "\n";
				if(!strstr($row[$i],$strkey))
					$newcontent .= $row[$i];
				else 
					$newcontent .= $newtitle;
			}
			$objdir->up_dir($dirid,$icid,$dirtitle,$newcontent);
		}
	} //end edit
	//var_dump(addslashes($content));
	//exit();
	//����������
	$good = "Y";
	if(($re = post_article(addslashes($title),addslashes($content),$clist,$poster,$good)) < 0){
		return false;
	}	
	if($dirid < 1)
		return true;
	//------��ӵ���Ŀ---------
	$objdir = new c_class_dir;
	$arr_dir = ($objdir->get_dir($dirid));
	if(count($arr_dir) > 0){
		$dirtitle = $arr_dir[0]["title"];
		$dircontent = $arr_dir[0]["content"];
		$dircontent .= "\n";
		$dircontent .= $re."`|)".$title;
		$objdir->up_dir($dirid,$icid,$dirtitle,$dircontent);
	}
	return true;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> �б� </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<STYLE type=text/css media=screen>
@import url("/site838/css/track_sou.css");
@import url("/site838/css/title.css");
</STYLE>
<script language="javascript" src="../include/script/xmldom.js"></script>
<script language="javascript" src="../include/script/cookie.js"></script>
<script language="javascript" src="../../include/global.js"></script>
<script language="javascript" src="../../include/track_sou.js"></script>
<script language="javascript">
var m_index = 0; //��ǰ������Դҳ�±�
var dochttp = null; //http����
//var m_cid = <?=$m_cid;?>;
var m_sid = <?=$m_id;?>;
var m_mb = <?=$m_mb;?>;
var m_site = <?=$m_flag;?>;
function start_autoadd838(t)
{
	//�Զ����
	//����:t(string)Y/A(�ͻ����Զ����/������Զ����)
	//���:��
	if("A838" != t)
		return alert("����δ���");
	var url = "./track_sou.php?sid="+m_souid+"&autoadd="+t;
	if(document.all["chk_cover"].checked){
		var hd_aid = parseInt(document.all["hd_aid"].value);
		if(hd_aid < 1){
			return alert("����ʱû��ѡ�о��½�");
		}
		url += "&cover="+hd_aid;
	}
	//alert(url);
	document.location.href = url;
}
function init()
{
	//��ʼ
	//����:��
	//���:��
	//alert(document.getElementById("st_cid"));
	//post_article838();
	//return;
	if("Y" == m_cover){
		document.all["chk_cover"].checked = true;
		//alert(get_cookie("track_aid"));
		var old = (get_cookie("track_aid"));
		//return;
		var obj = document.all["hd_aid"].options;
		//alert(typeof(obj.options[1].value));
		//alert(sou==obj.options[13].value);
		var j;
		for(j=0;j<obj.length;++j){
			if(old == obj.options[j].value)
				break;
			obj.options[j].selected = true;
			//alert(key);
			//break;
		}
	
	}
	//return;
	if("Y" != m_autoadd)
		return;
	add();
	//alert("aaa");
}
function pick_author()
{
	//��ȡ����Ʒ������
	//����:��
	//���:��
	dochttp = new_xmlhttp();
	var url = '../cmd.php?fun=pick_author&sid='+m_sid+"&site="+m_site;
	//return alert(url);
	dochttp.Open('GET',url,false);
	dochttp.Send();
	document.all["txt_author"].value = (dochttp.responseText);
}
function update_author()
{
	//if("" == document.all["frm_action"]["cid"].value)
	//	return alert("����ʧ�ܣ���ĿID����Ϊ��");
	document.all["frm_action"]["fun"].value = "update_author";
	document.all["frm_action"].submit();
}
function check_all()
{
	//ȫѡ
	//����:��
	//���:��
	var arr = document.all;
	var bln = null;
	for(var i = 0;i < arr.length; ++i){
		if("INPUT" != arr[i].tagName)
			continue;
		if("undefined" == typeof(arr[i].id))
			continue;
		var name = arr[i].id;
		if(name.length < 12)
			continue;
		var str = name.substr(0,11);
		if("ck_section_" != str)
			continue;
		if(null == bln){
			if(arr[i].checked)
				bln = false;
			else 
				bln = true;
		}
		arr[i].checked = bln;
		//if(true != arr[i].checked)
		//	continue;
	}

}
function ck_line(li)
{
	//ѡ��һ��
	//����:li(int)�к�
	//���:��
	//alert(li);
	//alert();
	var obj = document.all["line_"+li];
	var len = obj.length;	
	if("undefined"==typeof(len)){
		if(obj.checked)
			obj.checked = false;
		else
			obj.checked = true;
		return;
	}
	if(len < 1){
		//alert("aa");
		return;
	}
	for(var i = 0;i < len; ++i){
		if(obj[i].checked)
			obj[i].checked = false;
		else
			obj[i].checked = true;
	}
}
function open_checked()
{
	//��ѡ���½�
	//����:��
	//���:��
	var ls = get_ls();
	if("" == ls)
		alert("��ʧ�ܣ�����ѡ���½�")
	var url = "./track_sou.php?ls="+ls+"&sid="+m_souid;
	document.location.href=url;
}
function rm_article()
{
	//ɾ������Ŀ�����½�
	//����:��
	//���:��
	if(!window.confirm("���������ɻָ����Ƿ������"))
		return;
	document.all["frm_action"]["fun"].value = "rm_c_article";
	document.all["frm_action"]["content"].value = m_cid;
	//return alert(m_cid);
	document.all["frm_action"].submit();
}

function rm_rc(id)
{
	//ɾ�����ݿ��¼
	//����:id(string)��ԴID
	//���:��
	//�ύ����
	var ls = get_ls();
	if("" == ls)
		return alert("����ʧ�ܣ�����ѡ���½�")
	if(!window.confirm("���������ɻָ����Ƿ������"))
		return;

	document.all["frm_action"]["fun"].value = "track_rmrc";
	document.all["frm_action"]["content"].value = "";
	document.all["frm_action"]["id_ls"].value = ls;
	document.all["frm_action"].submit();
}
function rm_unused(tid)
{
	//ɾ�����ݿ�δ����¼
	//����:tid(string)��ԴID
	//���:��
	//�ύ����

	document.all["frm_action"]["fun"].value = "track_rmunused";
	document.all["frm_action"]["content"].value = "";
	document.all["frm_action"]["id_ls"].value = tid;
	document.all["frm_action"].submit();
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
function set_autoadd(flag,cid,sid)
{
	//�����Զ����
	//����:flagY����/Nȡ��,cid��ĿID,sid��ԴID
	//���:��
	//return alert(document.all["frm_action"]["fun"]);
	document.all["frm_action"]["fun"].value = "set_autoadd";
	//return alert("�����Զ����,flag="+flag+",cid="+cid+",sid="+sid);
	document.all["frm_action"]["ref"].value = flag;
	document.all["frm_action"]["clist"].value = cid;
	document.all["frm_action"]["id_ls"].value = sid;
	document.all["frm_action"].submit();
}
function reset_used(read)
{
	//��Ϊ�Ѷ�
	//����:read(string)Y/N(��Ϊ�Ѷ�/��Ϊδ��)
	//���:��
	//alert("��Ϊ�Ѷ�:"+ls);
	//�ύ����
	//var ls = "1";
	var ls = get_ls();
	if("" == ls)
		alert("����ʧ�ܣ�����ѡ���½�")
	document.all["frm_action"]["fun"].value = "reset_used";
	document.all["frm_action"]["content"].value = read;
	document.all["frm_action"]["id_ls"].value = ls;
	document.all["frm_action"]["clist"].value = m_cid; //��ĿID
	document.all["frm_action"]["ref"].value = "F";
	document.all["frm_action"]["autoadd"].value = "-1"; //��ԴID
	document.all["frm_action"].submit();
}
function add()
{
	//��ӵ���Ŀ
	//����:��
	//���:��
	//var obcid = document.all["st_cid"];
	//return alert(obcid.options[obcid.selectedIndex].value);
	if("" == document.all["frm_action"]["title"].value)
		return alert("���ʧ�ܣ����ⲻ��Ϊ��");
	if("" == document.all["frm_action"]["content"].value)
		return alert("���ʧ�ܣ����ݲ���Ϊ��");
	var ls = get_ls();
	if("" == ls)
		alert("����ʧ�ܣ�����ѡ���½�")
	if(document.all["chk_cover"].checked){
		var hd_aid = parseInt(document.all["hd_aid"].value);
		if(hd_aid < 1){
			return alert("����ʱû��ѡ�о��½�");
		}
		SetCookie("track_aid",hd_aid);
		//alert(hd_aid);
	}
	//return;
	
	//return alert(hd_aid);
	//
	document.all["frm_action"]["fun"].value = "post_article";
	//document.all["frm_action"]["clist"].value = m_cid;
	var obcid = document.all["st_cid"];
	var pcid = obcid.options[obcid.selectedIndex].value;
	document.all["frm_action"]["clist"].value = pcid;
	document.all["frm_action"]["ref"].value = "track";
	document.all["frm_action"]["id_ls"].value = ls;
	document.all["frm_action"]["autoadd"].value = m_autoadd;
	document.all["frm_action"].submit();
	//if(!window.confirm("�Ƿ���Ҫ���ύ�ɹ���������Ϊ�Ѷ���"))
	//	return;
	//reset_used();
}
function add838()
{
	//��ӵ���Ŀ838
	//����:��
	//���:��
	if("" == document.all["frm_action"]["title"].value)
		return alert("���ʧ�ܣ����ⲻ��Ϊ��");
	if("" == document.all["frm_action"]["content"].value)
		return alert("���ʧ�ܣ����ݲ���Ϊ��");
	var ls = get_ls();
	if("" == ls)
		alert("����ʧ�ܣ�����ѡ���½�")
	if(document.all["chk_cover"].checked){
		var hd_aid = parseInt(document.all["hd_aid"].value);
		if(hd_aid < 1){
			return alert("����ʱû��ѡ�о��½�");
		}
		SetCookie("track_aid",hd_aid);
		//alert(hd_aid);
	}
	//return;
	
	//return alert(hd_aid);
	//
	document.all["frm_action"]["fun"].value = "post_article838";
	//document.all["frm_action"]["clist"].value = m_cid;
	var obcid = document.all["st_cid"];
	var pcid = obcid.options[obcid.selectedIndex].value;
	document.all["frm_action"]["clist"].value = pcid;
	document.all["frm_action"]["ref"].value = "track";
	document.all["frm_action"]["id_ls"].value = ls;
	document.all["frm_action"]["autoadd"].value = m_autoadd;
	document.all["frm_action"].submit();
	//if(!window.confirm("�Ƿ���Ҫ���ύ�ɹ���������Ϊ�Ѷ���"))
	//	return;
	//reset_used();
}

</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" onload="javascript:init();">
<?php
echo $m_js;
//echo $m_htmltitle;
?>
<!--��ʾ��//-->
<div id="ntcwin" style="display:none;position:absolute;left:315px;top:283px;">
<table cellpadding="0" cellspacing="0"><tbody><tr><td class="pc_l">&nbsp;</td><td class="pc_c"><div id="div_title"  class="pc_inner"><span>���سɹ�<em>1</em>���ˢ�±�ҳ</span><img src="/site838/images/popupcredit_btn.gif" alt=""></div></td><td class="pc_r">&nbsp;</td></tr></tbody></table>
</div>

<div id="Head_div" align="center">
<div  style="position:relative;left:100px;top:10px;width:300px;height:30px;">
<!-- SiteSearch mwjx -->
<table>
<tr><td nowrap="nowrap" valign="top" align="left" height="32">
<?php
if($m_autoadd_id != $m_id){ //��ǰ�����Զ����ID
	if($m_autoadd_id > 0)
		echo "�������Զ���⣬ԴID<b>��".$m_autoadd_id."��</b>";
	echo "<button onclick=\"javascript:set_autoadd('Y','".$m_cid."','".$m_id."');\">��Ϊ�Զ����</button>";
}
else{
	echo "<font color='red'>��ǰԴ���Զ����</font>";
	echo "<button onclick=\"javascript:set_autoadd('N','".$m_cid."','".$m_id."');\">ȡ���Զ����</button>";
}
?>

<!--&nbsp;&nbsp;<button onclick="javascript:rm_sou('<?=$m_id;?>');">ɾ������Դ</button>//-->

��Դ��<?=$m_flag.".".$m_sitename;?>
</td></tr></table>
<!-- SiteSearch mwjx -->
</div>
</div>
<!--���ܱ�//-->
<form method="POST" name="frm_action" action="../cmd.php" target="submitframe" accept-charset="GBK">
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top" align="left">
<?php
echo $m_htmltitle;
?>

		</td>
	</tr>
	<tr>
		<td valign="top">
�½�ID��<?=($m_htmlselect);?><input type="checkbox" name="chk_cover" style="display:none;"/><!--���Ǿ��½�//-->
<br/>
���⣺<input type="text" id="title" name="title" size="50" value="<?=$m_arr[0];?>"/>&nbsp;
<?php
echo $m_dir;
?>
		</td>
	</tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td valign="top">
���ݣ�<br/>
<textarea id="txt_content" name="content" cols="125" rows="16"><?=$fil->fill($m_arr[1]);?></textarea>
		</td>
		<td align="left"><?=$m_htmllast;?></td>
	</tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td valign="top" align="left">
<DIV style="display:block;width:950px;text-align:center;margin:0px 0px 0 0px;">
<button style="width:120px;height:40px;" onclick="javascript:post_article838();">��Ӻ��Ķ�</button>

&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" onclick="javascript:var o = document.getElementById('div_high');if('none'==o.style.display){o.style.display='block';}else{o.style.display='none';}">������ʾ�������</a>

</DIV>
<DIV id="div_high" style="display:none;">
<button onclick="javascript:check_all();">ȫѡ</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
$html = "";
if("Y" == $m_read){
	$html = "<button onclick=\"javascript:document.location.href='./track_sou.php?read=N&sid=".$m_id."';\">ȫ��δ��</button>
";
	$html .= "&nbsp;&nbsp;<button onclick=\"javascript:reset_used('N');\">��Ϊδ��</button>";
}
else{
	$html = "<button onclick=\"javascript:document.location.href='./track_sou.php?read=Y&sid=".$m_id."';\">ȫ���Ѷ�</button>";
	$html .= "&nbsp;&nbsp;<button onclick=\"javascript:reset_used('Y');\">��Ϊ�Ѷ�</button>";
}
echo $html;
?>
&nbsp;&nbsp;&nbsp;&nbsp;
<button onclick="javascript:add838();" <?echo (($m_flag>77)?"disabled=true":"");?>>��ӵ���Ŀ</button>
<!--���ߣ�<input type="text" name="txt_author" size="8" value="<?=$m_author;?>"/><button onclick="javascript:pick_author();">��ȡ����</button><button onclick="javascript:update_author();">�ύ����</button>//-->
&nbsp;&nbsp;<button onclick="javascript:start_autoadd838('A838');" <?echo (($m_flag>77)?"disabled=true":"");?>>�Զ���ӵ�838</button>
&nbsp;&nbsp;


<br/>
<button onclick="javascript:rm_unused('<?=$m_id;?>');">ɾ��δ��</button>
&nbsp;&nbsp;
<button onclick="javascript:rm_rc('<?=$m_id;?>');">ɾ��ѡ�м�¼</button>
&nbsp;&nbsp;
<button onclick="javascript:open_checked();">��ѡ���½�</button>
&nbsp;&nbsp;
<button onclick="javascript:rm_article();">ɾ�������½�</button>
</DIV>
		</td>
	</tr>
	<tr>
		<td valign="top">
<?php
echo $m_lasttitle;
echo $m_html;
?>
		</td>
	</tr>
<table>

<input type="hidden" name="fun" value=""/>
<input type="hidden" name="id_ls" value=""/>
<input type="hidden" name="clist" value=""/>
<input type="hidden" name="ref" value=""/>
<input type="hidden" name="autoadd" value=""/>
</form>
<iframe name="submitframe" width="1" height="1"></iframe>
</BODY>
</HTML>
