<?php
//------------------------------
//create time:2008-1-23
//creater:zll,liang_0735@21cn.com
//purpose:追踪源展示
//------------------------------
if("" == $_COOKIE['username']){
	exit("无权限");
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
$m_ls = (isset($_GET["ls"])?$_GET["ls"]:""); //选中ID列表
//自动添加,Y/N/A(客户端自动/非自动/服务端自动)
$m_autoadd = isset($_GET["autoadd"])?$_GET["autoadd"]:"N"; 
$m_id = intval(isset($_GET["sid"])?$_GET["sid"]:-1); //来源ID
$m_mb = intval(isset($_GET["mb"])?$_GET["mb"]:-1); //来源ID
$m_cover = isset($_GET["cover"])?$_GET["cover"]:""; //是否覆盖
//作者,天涯分页时有效
$m_author = isset($_GET["author"])?$_GET["author"]:"";
$m_read = isset($_GET["read"])?$_GET["read"]:"N"; //Y/N(已读未读)
$m_838 = false; //是否838
//$m_id = 3; //tests
//$m_read = "Y";
//$m_autoadd = "A";
$m_arr_track = arr_track($m_id);
//var_dump($m_arr_track);
//exit();
//if(count($m_arr_track) < 1)
//	exit("来源无效");
$m_arr_site = arr_track_flag();
$m_flag = intval($m_arr_track[0]["flag"]);
$m_sitename = $m_arr_site[$m_flag]; 
$m_cid = get_track_cid($m_id);
if(-1 == $m_cid)
	exit("来源无效");
$m_autoadd_id = auto_add_id($m_cid);
$m_cinfo = new c_class_info($m_cid);
if($m_cinfo->get_id() < 1)
	exit("类目无效：".$m_cid);
$m_htmlselect=(html_lastlists($m_cid)); 
//$fil->fill

$m_author = $m_cinfo->get_author();
/*if("A" == $m_autoadd){ //废弃
	$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
	if($obj_man->get_id() < 1)
		exit("未登录");
	//exit("00");
	//鉴权
	$obj = new c_authorize;		
	//编辑文章
	if(!$obj->can_do($obj_man,1,1,12))
		exit("无权操作,eidt");
	//发布文章
	if(!$obj->can_do($obj_man,1,1,1))
		exit("无权操作,add");
	//发布
	set_time_limit(720);
	track_autoadd($m_id,$m_flag,$m_cid,$obj_man->get_name());
	$m_autoadd = "N"; //停止自动添加
}*/
if("A838" == $m_autoadd){
	$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
	if($obj_man->get_id() < 1)
		exit("未登录");
	//exit("00");
	//鉴权
	$obj = new c_authorize;		
//	//编辑文章
//	if(!$obj->can_do($obj_man,1,1,12))
//		exit("无权操作,eidt");
//	//发布文章
//	if(!$obj->can_do($obj_man,1,1,1))
//		exit("无权操作,add");
	//类目管理员
	if(!$obj->can_do($obj_man,2,$m_cid,0))
		exit("无权操作,不是管理员");
	$cover = isset($_GET["cover"])?intval($_GET["cover"]):-1;
	//var_dump($cover);
	//exit();
	//发布
	set_time_limit(720);
	track_autoadd838($m_id,$m_flag,$m_cid,$obj_man->get_name(),$cover);
	$m_autoadd = "N"; //停止自动添加
}
/**/
$m_htmltitle .= "<a href=\"/site838/view/track/index.php?id=".$m_cid."\" target=\"_blank\"><font size=\"5\">《".$m_cinfo->get_name()."》</font></a>&nbsp;&nbsp;";
$m_htmltitle .= "<select id=\"st_cid\" name=\"st_cid\">";
$m_htmltitle .= "<option value=\"".$m_cid."\">".$m_cinfo->get_name()."</option>\n";
//$m_htmltitle .= "<option value=\"1\">废墟大厅</option>\n";
//$m_htmltitle .= "<option value=\"2\">轻松一笑</option>\n";
//$m_htmltitle .= "<option value=\"3\">精品收藏</option>\n";
//$m_htmltitle .= "<option value=\"6\">经典笑话</option>\n";
//$m_htmltitle .= "<option value=\"427\">军政时事</option>\n";
//$m_htmltitle .= "<option value=\"427\">军政时事</option>\n";
//$m_htmltitle .= "<option value=\"426\">创业</option>\n";
//$m_htmltitle .= "<option value=\"64\">经融</option>\n";
//$m_htmltitle .= "<option value=\"26\">恐怖鬼故事</option>\n";
$m_htmltitle .= "</select>&nbsp;&nbsp;";
$m_lasttitle = "最新章节：";
$arr_last = html_last($m_cid,$m_flag);
$m_lasttitle .= ($arr_last[0]."<br/>");
$m_htmllast = "";
//if(8 == $m_flag){
//	$m_htmllast = "上一次更新内容：<br/><textarea cols=\"65\" rows=\"16\">".$arr_last[1]."</textarea>";
//}
//exit("111");
//exit($m_ls);
//echo "aaa<br/>";
$m_arr = (text_content($m_id,$m_ls,$m_flag));
//exit("222");
$m_kw = $m_arr[0];
$m_ls = $m_arr[2];
if("" != $m_arr[3]){
	$m_htmltitle .= "<br/>可能是图片或异常章节：";
	$m_htmltitle .= "<br/>".$m_arr[3];
}
//-----拆分列表为数组-------
$arr = explode(",",$m_ls);
$len = count($arr);
$m_arr_id = array(); //id=>true
for($i = 0;$i < $len; ++$i){
	$id = intval($arr[$i]);
	if($id < 1)
		continue;
	$m_arr_id[$id] = true;
}
//----end 拆分列表为数组----
//js信息
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
	//类目最新章节
	//输入:id(int)类目ID
	//输出:html字符串
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
	$html .= "<option value=\"-1\">--新增838--</option>";
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
	//类目最新章节
	//输入:id(int)类目ID
	//输出:html字符串
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
	$html .= "<option value=\"-1\">--新增--</option>";
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
	//类目最新章节
	//输入:id(int)类目ID,flag来源标志
	//输出:array(title,coment)
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
			$title = "无标题";
		//$dir = g_dir_from_id($id);
		$url = "/site838/view/track/show.php?id=".$id;
		$str = "<a href=\"".$url."\" target=\"_blank\">".$title."</a>";
		$con = "";
		if(8 == $flag){ //天涯分页
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
		$title = "无标题";
	$dir = g_dir_from_id($id);
	$url = "/bbs/html/".$dir.$id.".html";
	$str = "<a href=\"".$url."\" target=\"_blank\">".$title."</a>";
	$con = "";
	if(8 == $flag){ //天涯分页
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
	//书目列表
	//输入:id(int)类目ID
	//输出:html字符串
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
	//未看章节列表
	//输入:id(int)来源ID,flag(int)来源网站类型
	//输出:html字符串
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
			$ch_line = "<img src=\"/site838/view/image/bsall4.gif\" style=\"cursor:hand;\"  alt=\"选中本行\" onclick=\"javascript:ck_line(".$line.");\"/>&nbsp;";
		}
		$html .= "<li>".$ch_line."&#149;<input id=\"ck_section_".$id."\" line=\"".$line."\" name=\"line_".$line."\" type=\"checkbox\" ".$check."/><a href=\"".$url_sou."\" target=\"_blank\"><img src=\"/site838/view/images/navigation.gif\" border=\"0\"/></a>&nbsp;<a href=\"".$url."\" target=\"_self\">".$title." </a>&nbsp;</li>";
	}
	$html .= "</ul></div>";
	return $html;
}
function arr_track($id = -1)
{
	//取得来源的信息
	//输入:id(int)来源ID
	//输出:信息数组，异常返回空数组
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
	//返回类目的自动入库来源ID
	//输入:cid类目ID
	//输出:来源ID,没有来源返回-1
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
	//小说类目列表
	//输入:id(int)最新追踪根类目ID
	//输出:html字符串
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
	$js_ls = "<script language=\"javascript\">\n"; //来源ID列表,js数组
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
	//来源数组
	//输入:无
	//输出:数组，格式：cid=>array(array(id,title,url));
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
	//自动添加跟踪文章
	//输入:id(int)来源ID,flag(int)来源类型标志,cid类目ID
	//poster发布人
	//输出:无
	//exit("kk");
	include_once("./control/article_post.php");
	$limit = 1; //每次发表文章篇数
	$scid = strval($cid);
	$obj = new c_class_dir;
	$arr = ($obj->search($cid));
	$dirid = -1;
	if(count($arr) > 0)
		$dirid = intval($arr[(count($arr)-1)][0]);
	//var_dump($dirid);
	//exit();
	//未读列表
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
			//发布,覆盖？
			//var_dump($arr_post);
			//exit();
			if(!post_track(-1,$scid,trim($arr_post[0]),trim($arr_post[1]),$dirid,$poster))
				return;
			//设为已读
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
	//发布文章
	//输入:aid文章ID,clist类目列表,title标题,content内容,
	//dirid书目ID,$poster发布人名称
	//输出:true,false
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
	if($aid > 0){ //编辑文章
		$re = edit_article($aid,$title,$content);
		if(!$re)
			return false;
		if($dirid < 1)
			return true;
		//------添加到书目---------
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
	//发布新文章
	$good = "Y";
	if(($re = post_article(addslashes($title),addslashes($content),$clist,$poster,$good)) < 0){
		return false;
	}	
	if($dirid < 1)
		return true;
	//------添加到书目---------
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
<TITLE> 列表 </TITLE>
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
var m_index = 0; //当前检查的来源页下标
var dochttp = null; //http对象
//var m_cid = <?=$m_cid;?>;
var m_sid = <?=$m_id;?>;
var m_mb = <?=$m_mb;?>;
var m_site = <?=$m_flag;?>;
function start_autoadd838(t)
{
	//自动添加
	//输入:t(string)Y/A(客户端自动添加/服务端自动添加)
	//输出:无
	if("A838" != t)
		return alert("功能未完成");
	var url = "./track_sou.php?sid="+m_souid+"&autoadd="+t;
	if(document.all["chk_cover"].checked){
		var hd_aid = parseInt(document.all["hd_aid"].value);
		if(hd_aid < 1){
			return alert("覆盖时没有选中旧章节");
		}
		url += "&cover="+hd_aid;
	}
	//alert(url);
	document.location.href = url;
}
function init()
{
	//初始
	//输入:无
	//输出:无
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
	//提取本作品的作者
	//输入:无
	//输出:无
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
	//	return alert("更新失败，类目ID不能为空");
	document.all["frm_action"]["fun"].value = "update_author";
	document.all["frm_action"].submit();
}
function check_all()
{
	//全选
	//输入:无
	//输出:无
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
	//选中一行
	//输入:li(int)行号
	//输出:无
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
	//打开选中章节
	//输入:无
	//输出:无
	var ls = get_ls();
	if("" == ls)
		alert("打开失败，请先选择章节")
	var url = "./track_sou.php?ls="+ls+"&sid="+m_souid;
	document.location.href=url;
}
function rm_article()
{
	//删除本类目所有章节
	//输入:无
	//输出:无
	if(!window.confirm("本操作不可恢复，是否继续？"))
		return;
	document.all["frm_action"]["fun"].value = "rm_c_article";
	document.all["frm_action"]["content"].value = m_cid;
	//return alert(m_cid);
	document.all["frm_action"].submit();
}

function rm_rc(id)
{
	//删除数据库记录
	//输入:id(string)来源ID
	//输出:无
	//提交请求
	var ls = get_ls();
	if("" == ls)
		return alert("设置失败，请先选择章节")
	if(!window.confirm("本操作不可恢复，是否继续？"))
		return;

	document.all["frm_action"]["fun"].value = "track_rmrc";
	document.all["frm_action"]["content"].value = "";
	document.all["frm_action"]["id_ls"].value = ls;
	document.all["frm_action"].submit();
}
function rm_unused(tid)
{
	//删除数据库未读记录
	//输入:tid(string)来源ID
	//输出:无
	//提交请求

	document.all["frm_action"]["fun"].value = "track_rmunused";
	document.all["frm_action"]["content"].value = "";
	document.all["frm_action"]["id_ls"].value = tid;
	document.all["frm_action"].submit();
}
function rm_sou(tid)
{
	//删除一个来源
	//输入:tid(string)来源ID
	//输出:无
	//提交请求
	//return alert(tid);
	if(!window.confirm("本操作不可恢复，确认吗？"))
		return;
	document.all["frm_action"]["fun"].value = "rm_sou";
	document.all["frm_action"]["content"].value = tid;
	document.all["frm_action"].submit();
}
function set_autoadd(flag,cid,sid)
{
	//设置自动入库
	//输入:flagY设置/N取消,cid类目ID,sid来源ID
	//输出:无
	//return alert(document.all["frm_action"]["fun"]);
	document.all["frm_action"]["fun"].value = "set_autoadd";
	//return alert("设置自动入库,flag="+flag+",cid="+cid+",sid="+sid);
	document.all["frm_action"]["ref"].value = flag;
	document.all["frm_action"]["clist"].value = cid;
	document.all["frm_action"]["id_ls"].value = sid;
	document.all["frm_action"].submit();
}
function reset_used(read)
{
	//设为已读
	//输入:read(string)Y/N(设为已读/设为未读)
	//输出:无
	//alert("设为已读:"+ls);
	//提交请求
	//var ls = "1";
	var ls = get_ls();
	if("" == ls)
		alert("设置失败，请先选择章节")
	document.all["frm_action"]["fun"].value = "reset_used";
	document.all["frm_action"]["content"].value = read;
	document.all["frm_action"]["id_ls"].value = ls;
	document.all["frm_action"]["clist"].value = m_cid; //类目ID
	document.all["frm_action"]["ref"].value = "F";
	document.all["frm_action"]["autoadd"].value = "-1"; //来源ID
	document.all["frm_action"].submit();
}
function add()
{
	//添加到类目
	//输入:无
	//输出:无
	//var obcid = document.all["st_cid"];
	//return alert(obcid.options[obcid.selectedIndex].value);
	if("" == document.all["frm_action"]["title"].value)
		return alert("添加失败，标题不能为空");
	if("" == document.all["frm_action"]["content"].value)
		return alert("添加失败，内容不能为空");
	var ls = get_ls();
	if("" == ls)
		alert("设置失败，请先选择章节")
	if(document.all["chk_cover"].checked){
		var hd_aid = parseInt(document.all["hd_aid"].value);
		if(hd_aid < 1){
			return alert("覆盖时没有选中旧章节");
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
	//if(!window.confirm("是否需要将提交成功的文章设为已读？"))
	//	return;
	//reset_used();
}
function add838()
{
	//添加到类目838
	//输入:无
	//输出:无
	if("" == document.all["frm_action"]["title"].value)
		return alert("添加失败，标题不能为空");
	if("" == document.all["frm_action"]["content"].value)
		return alert("添加失败，内容不能为空");
	var ls = get_ls();
	if("" == ls)
		alert("设置失败，请先选择章节")
	if(document.all["chk_cover"].checked){
		var hd_aid = parseInt(document.all["hd_aid"].value);
		if(hd_aid < 1){
			return alert("覆盖时没有选中旧章节");
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
	//if(!window.confirm("是否需要将提交成功的文章设为已读？"))
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
<!--提示框//-->
<div id="ntcwin" style="display:none;position:absolute;left:315px;top:283px;">
<table cellpadding="0" cellspacing="0"><tbody><tr><td class="pc_l">&nbsp;</td><td class="pc_c"><div id="div_title"  class="pc_inner"><span>下载成功<em>1</em>秒后刷新本页</span><img src="/site838/images/popupcredit_btn.gif" alt=""></div></td><td class="pc_r">&nbsp;</td></tr></tbody></table>
</div>

<div id="Head_div" align="center">
<div  style="position:relative;left:100px;top:10px;width:300px;height:30px;">
<!-- SiteSearch mwjx -->
<table>
<tr><td nowrap="nowrap" valign="top" align="left" height="32">
<?php
if($m_autoadd_id != $m_id){ //当前不是自动入库ID
	if($m_autoadd_id > 0)
		echo "已设置自动入库，源ID<b>（".$m_autoadd_id."）</b>";
	echo "<button onclick=\"javascript:set_autoadd('Y','".$m_cid."','".$m_id."');\">设为自动入库</button>";
}
else{
	echo "<font color='red'>当前源是自动入库</font>";
	echo "<button onclick=\"javascript:set_autoadd('N','".$m_cid."','".$m_id."');\">取消自动入库</button>";
}
?>

<!--&nbsp;&nbsp;<button onclick="javascript:rm_sou('<?=$m_id;?>');">删除本来源</button>//-->

来源：<?=$m_flag.".".$m_sitename;?>
</td></tr></table>
<!-- SiteSearch mwjx -->
</div>
</div>
<!--功能表单//-->
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
章节ID：<?=($m_htmlselect);?><input type="checkbox" name="chk_cover" style="display:none;"/><!--覆盖旧章节//-->
<br/>
标题：<input type="text" id="title" name="title" size="50" value="<?=$m_arr[0];?>"/>&nbsp;
<?php
echo $m_dir;
?>
		</td>
	</tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td valign="top">
内容：<br/>
<textarea id="txt_content" name="content" cols="125" rows="16"><?=$fil->fill($m_arr[1]);?></textarea>
		</td>
		<td align="left"><?=$m_htmllast;?></td>
	</tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width="100%">
	<tr>
		<td valign="top" align="left">
<DIV style="display:block;width:950px;text-align:center;margin:0px 0px 0 0px;">
<button style="width:120px;height:40px;" onclick="javascript:post_article838();">添加后阅读</button>

&nbsp;&nbsp;&nbsp;&nbsp;
<a href="#" onclick="javascript:var o = document.getElementById('div_high');if('none'==o.style.display){o.style.display='block';}else{o.style.display='none';}">＋－显示更多操作</a>

</DIV>
<DIV id="div_high" style="display:none;">
<button onclick="javascript:check_all();">全选</button>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
$html = "";
if("Y" == $m_read){
	$html = "<button onclick=\"javascript:document.location.href='./track_sou.php?read=N&sid=".$m_id."';\">全部未读</button>
";
	$html .= "&nbsp;&nbsp;<button onclick=\"javascript:reset_used('N');\">设为未读</button>";
}
else{
	$html = "<button onclick=\"javascript:document.location.href='./track_sou.php?read=Y&sid=".$m_id."';\">全部已读</button>";
	$html .= "&nbsp;&nbsp;<button onclick=\"javascript:reset_used('Y');\">设为已读</button>";
}
echo $html;
?>
&nbsp;&nbsp;&nbsp;&nbsp;
<button onclick="javascript:add838();" <?echo (($m_flag>77)?"disabled=true":"");?>>添加到类目</button>
<!--作者：<input type="text" name="txt_author" size="8" value="<?=$m_author;?>"/><button onclick="javascript:pick_author();">提取作者</button><button onclick="javascript:update_author();">提交作者</button>//-->
&nbsp;&nbsp;<button onclick="javascript:start_autoadd838('A838');" <?echo (($m_flag>77)?"disabled=true":"");?>>自动添加到838</button>
&nbsp;&nbsp;


<br/>
<button onclick="javascript:rm_unused('<?=$m_id;?>');">删除未读</button>
&nbsp;&nbsp;
<button onclick="javascript:rm_rc('<?=$m_id;?>');">删除选中记录</button>
&nbsp;&nbsp;
<button onclick="javascript:open_checked();">打开选中章节</button>
&nbsp;&nbsp;
<button onclick="javascript:rm_article();">删除所有章节</button>
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
