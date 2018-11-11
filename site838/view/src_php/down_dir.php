<?php
//------------------------------
//create time:2007-12-14
//creater:zll,liang_0735@21cn.com,book.mwjx.com
//purpose:全集下载
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/pagebase.php");
//类目ID
$m_dumpcid = intval(isset($_REQUEST["dumpcid"])?$_REQUEST["dumpcid"]:-1);
//排列顺序,asc,desc
$m_order = (isset($_REQUEST["order"])?$_REQUEST["order"]:"asc"); 
$m_ls = trim(isset($_REQUEST["ls"])?$_REQUEST["ls"]:""); 
$m_kw = addslashes(trim(isset($_REQUEST["kw"])?$_REQUEST["kw"]:"")); 
$m_editcid = "";
$m_clist = ""; //最新生成类目列表
//$m_dumpcid = 168; //tests
//$m_ls = "9";
//$m_kw = "毛泽东"; //tests
//$m_ls = "5286,1590,11471";
//$_COOKIE['username'] = "";
/*if("" == $_COOKIE['username']){
	$m_dumpcid = -1; //tests
	$m_kw = ""; //tests
	$m_editcontent = "由于资源限制，本功能只限注册会员使用。注册是免费的，您可以到《838书城》首页申请注册。";	
}
*/
if("" != $m_ls){ //下载 // && $m_dumpcid > 0
	//生成文章列表
	//$path = "../../data/up_book/0f27865ad2294bd43b21488e2775c94d.zip";
	//exit("99");
	$path = create_downpage($m_dumpcid,$m_ls,$_REQUEST["down"]);
	if("" == $path)
		exit("下载失败，异常");
	if("read"==$_REQUEST["down"]){ //全文阅读
		//$path = strstr($path,"data/up_book");
		//$path = "http://book.mwjx.com/".$path;
		echo "<script language=\"javascript\">";		
		//echo "parent.window.open('".$path."');";
		echo "parent.window.location.href='".$path."';";
		//echo "alert('".$path."');";
		echo "</script>";		
		//writetofile("xxx.txt",$path);
		//$path = "http://book.mwjx.com/data/up_book/1938.html";
		//header("location:".$path);
		//header("location:".$path);
		//var_dump($path);
		exit();
	}
	//var_dump($path);
	//exit();
	//下载给用户
	header("Content-type: application/download\r\n");
	header("Content-length: ".filesize($path)."\r\n");
	header("Content-disposition:attachment; filename=".substr($path,strrpos($path,"/")+1));
	$result = readfile($path);
	//exit($path.":".$m_ls);
	exit();
}
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
$m_cd = new c_class_dir;
//导入
$m_title = "";
$m_note = "注意：请填写正确的类目ID，你可以从1到100一直往下试";
if($m_dumpcid > 0){
	$m_editcid = $m_dumpcid;
	$m_editcontent = get_cdata($m_dumpcid);	
	$m_title = get_ctitle($m_dumpcid);
	if("" != $m_title)
		$m_note = "";
	$m_clist = html_clist();
}
else if("" != $m_kw){ //搜索
	//文章列表
	$m_editcontent = get_searchdata($m_kw);	
	//类目列表
	$m_title = $m_kw;
	$m_clist = html_searchclist($m_kw);
}
if("" == $m_kw)
	$m_kw = "开始全新搜索";
//exit();
//---------函数群----------
function html_searchclist($kw="")
{
	//搜索类目列表
	//输入:kw(string)搜索关键词
	//输出:html字符串
	
	$str_sql = "select id,name,last from class_info where name like '%".$kw."%' order by last DESC limit 20;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$ls = $sql->get_array_array();
	//$ls = array();
	//var_dump($ls);
	$html = "";
	$len = count($ls);
	for($i = 0;$i < $len; ++$i){
		$id = $ls[$i][0];
		$t = $ls[$i][2];
		//$url = $dir_up.$id.".html";
		$url = "./down_dir.php?dumpcid=".$id;
		$title = $ls[$i][1];
		//echo "<a href=\"".$url."\" target=\"_blank\">".$title."</a>&nbsp;".date("Y-m-d H:i:s",$t)."<br/>";
		$html .= "<div class=\"MenuPle_div_css\">&#149;<a href=\"".$url."\" target=\"_self\" title=\"".$t."\">".$title."</a>&nbsp;<a href=\"/data/".$id.".html\" target=\"_blank\">阅读</a></div>";
	}
	return $html;
}

function html_clist()
{
	//最新生成合集
	//输入:无
	//输出:html字符串
	my_safe_include("mwjx/down_dir.php");
	$dir = get_dir_home();
	$dir_up = $dir."../data/up_book/";
	$dd = new c_down_dir;
	$ls = $dd->get_arr($dir_up,10);
	//var_dump($ls);
	$html = "";
	$len = count($ls);
	for($i = 0;$i < $len; ++$i){
		$id = $ls[$i][0];
		$t = $ls[$i][2];
		//$url = $dir_up.$id.".html";
		$url = "./down_dir.php?dumpcid=".$id;
		$title = $ls[$i][1];
		//echo "<a href=\"".$url."\" target=\"_blank\">".$title."</a>&nbsp;".date("Y-m-d H:i:s",$t)."<br/>";
		$html .= "<div class=\"MenuPle_div_css\">&#149;<a href=\"".$url."\" target=\"_self\" title=\"".date("Y-m-d H:i:s",$t)."\">".$title."</a>&nbsp;<a href=\"/data/".$id.".html\" target=\"_blank\">阅读</a></div>";
	}
	return $html;
}
function get_searchdata($kw = "")
{
	//搜索
	//输入:kw(string)关键词
	//输出:列表字符串
	if("" == $kw)
		return "";
	//if("asc" == $m_order){
	$str = "";
	$str_sql = "select int_id,str_title from tbl_article where str_title like '%".$kw."%' and enum_active='Y' and enum_father='Y' order by dtt_change DESC limit 100;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	if(count($arr) < 1)
		return ""; //找不到
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$aid = $arr[$i][0];
		$title = $arr[$i][1];
		$str .= $aid."`|)".$title."\n";
	}
	return $str;
}
function get_cdata($id = -1)
{
	//导出一个类目的书目
	//输入:id(int)类目ID
	//输出:字符串
	global $m_order;
	$str_sql = "select id,title from article where cid ='".$id."' order by id ASC limit 9999;";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	$len = count($arr);
	if(0 == $len)
		return "";
	$count = 0;
	if("asc" == $m_order){
		for($i = ($len-1);$i >= 0; --$i){
			if(!isset($arr[$i])){break;}
			$aid = $arr[$i][0];
			$title = $arr[$i][1];
			$str .= $aid."`|)".$title."\n";
			if(++$count > 300)
				break;
		}
	}
	else{
		for($i = 0;$i < $len; ++$i){
			if(!isset($arr[$i])){break;}
			$aid = $arr[$i][0];
			$title = $arr[$i][1];
			$str .= $aid."`|)".$title."\n";
			if(++$count > 300)
				break;
		}
	}
	return $str;
}
function get_ctitle($id=-1)
{
	//取得类目标题 
	//输入:id(int)类目ID
	//输出:标题 
	$str_sql = "select * from class_info where id = '".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	if(1 != count($arr))
		return ""; //类目不存在
	$title = $arr[0]["name"];
	return $title;
}
function create_downpage($id=-1,$ls = "",$t="down")
{
	//生成下载页面
	//输入:id(int)类目ID,ls(string)文章ID列表
	//t(string)生成下载类型down/downtxt(html/txt)
	//输出:页面路径,异常返回空字符串
	//文件存在且生成日为当天直接返回路径
	//如果没有类目ID,用第一篇文章做ID
	global $m_kw;
	//取得类目标题 	
	if($id < 1)
		$ctitle = $m_kw;
	else
		$ctitle = get_ctitle($id);
	//var_dump($ctitle);
	//exit();
	if("" == $ctitle)
		return "";
	//文章列表
	$arr = explode(",",$ls);
	if(count($arr) < 1)
		return "";
	//var_dump($arr);
	//exit();
	my_safe_include("book/article.php");
	//地址路径
	$curl = "http://book.mwjx.com/data/".$id.".html";
	$dir = get_dir_home();
	$dir = $dir."../data/up_book/";
	//$dir = "../../../data/up_book/";
	$path = $dir.$id.".html";
	if("downtxt" == $t)
		$path = $dir.$id.".txt";
	if($id < 1){ //可能是个搜索
		$aid = intval($arr[0]);
		if($aid < 1)
			return "";
		$obj = new c_article($aid,"N"); 
		if($obj->get_id() < 1)
			return "";
		$curl = "http://book.mwjx.com/";	
		$path = $dir."aid_".$aid.".html";
		if("downtxt" == $t)
			$path = $dir."aid_".$aid.".txt";
	}
	if(file_exists($path)){
		if(false != ($ctime = filectime($path))){
			if(date("Y-m-d",$ctime) == date("Y-m-d",time()))
				return $path;
		}
	}
	//生成
	$head = "";
	$txt = "";
	$len = count($arr);
	if($len > 100)
		$len = 100;
	$head .= "<div id=\"title_index\"><ul>";
	//exit("88888");
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]);
		$obj = new c_article($id,"Y"); 
		if($obj->get_id() < 1)
			continue;
		$title = $obj->get_title();
		$url = $obj->get_url_dynamic($id,1);
		//$url = "http://book.mwjx.com/mwjx/src_php/data_article.php?id=".$id."&state=dynamic&r_cid=12";
		$content = $obj->get_txt();
		if("downtxt" == $t){
			$txt .= $title."\r\n";
			$txt .= $content."\r\n\r\n";
			continue;
		}
		$obj->showtohtml($content,2);
		//$content = msubstr($content,0,200);
		$head .= "<li>&#149;<a href=\"#".$id."\" target=\"_self\" title=\"".$title."\">".$title."</a></li>";
		$txt .= "<table class=adc cellpadding=0 cellspacing=0 border=0><tr><td valign=middle><a class=adt href=\"".$url."\" target=\"_blank\"><span><a name=\"".$id."\" href=\"".$url."\"><b>".$title."</b></a></span></a>
<div class=adb>".$content." </div></td></tr></table>";
		//$txt .= "<a href=\"".$url."\"><b>".$title."</b></a><br/>";
		//$txt .= $content."<a href=\"".$url."\">更多...</a>";		
	}
	if("downtxt" == $t){
		$txt .= $curl;
		$txt = $ctitle."\r\n\r\n".$txt;
		writetofile($path,$txt);
		return $path;
	}
	//return "";

	$head .= "</ul></div>";
	$head .= "<div id=\"google_ad\">
<script type=\"text/javascript\"><!--
google_ad_client = \"pub-6913943958182517\";
//336x280, 创建于 07-12-26
google_ad_slot = \"5339014858\";
google_ad_width = 336;
google_ad_height = 280;
//--></script>
<script type=\"text/javascript\"
src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\">
</script>

</div>";
	//$txt = "";
	$d = date("Y-m-d H:i:s",time());
	$html = "<html><head>
<title>".$ctitle."|生成日期：".$d."|book.mwjx.com</title>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=gb2312\">
<base target=\"_blank\"/>
<style>a:link,a:visited,a:hover,a:active{color:#0000ff;cursor:hand;}body,table,div,ul,li{font-size:10px;margin:0px;padding:0px}body{background-color:".$bg.";font-family:arial,sans-serif;height:100%}#aus{height:200px;width:200px}#ads{left:0px;position:absolute;top:0px;width:200px}span{font-size:16px;}#ads ul{list-style:none;width:100%}#ads ul li{clear:both;cursor:hand;float:left;height:91px;overflow:hidden;width:200px}.ad{margin:0px 2px}.adt{font-size:12px;font-weight:bold;line-height:14px;}.adb{color:#000000;display:block;font-size:14px;line-height:20px;}.adu{color:#009900;font-size:10px;line-height:14px;overflow:hidden;white-space:nowrap}.adc{width:100%;height:91px;table-layout:fixed;overflow:hidden}#abgi{left:120px;position:absolute;top:183px}#aubg{background-color:#ffffff;border:0px solid #ffffff;height:200px;width:200px}#google_ad{
	float:left;
	width:336px;
	height:280px;
	overflow:hidden;
}

#title_index{
	float:left;
	width:632px;
	overflow:hidden;
}
#title_index LI A:link {
	COLOR: #467902;
}
#title_index LI A:visited {
	COLOR: #bc2931;
}
#title_index ul li{
	FONT-SIZE: 13px;
	margin-left:0px;
	margin-right:0x;
	padding-left:5px;
	float:left;
	width:200px;
	white-space:nowrap;
	line-height:15px;
	overflow:hidden;
}
</style>
</head>
<BODY style=\"margin:10px 10px 10px 10px;\">
<a href=\"".$curl."\"><h1>返回《".$ctitle."》</h1></a>本页生成于
".$d.",也许有更新章节发布，请返回<a href=\"".$curl."\">".$ctitle."</a>查看最新章节".$head."<br/><br/>".$txt."<br/>
	<br/><div style=\"width:500px;display:block;\">生成时间：".$d."<br/><a href=\"http://book.mwjx.com/\">返回838书城</a>
<script type=\"text/javascript\" src=\"http://fishcounter.3322.org/script/md5.js\"></script>
<script language=\"JavaScript\" type=\"text/javascript\">
//----------客户端惟一代号----------
var cookieString = new String(document.cookie);
var cookieHeader = \"fc_uniqid=\" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = \"\";
if (beginPosition == -1){  //没有cookie,种植
	sFc_uniqid = Math.round(Math.random() * 2147483647);
	document.cookie = cookieHeader+sFc_uniqid+\";expires=Sun, 18 Jan 2038 00:00:00 GMT;\"+\"path=/\";
}
else{
	var pos_end = cookieString.indexOf(\";\",beginPosition);
	var pos_start = beginPosition+cookieHeader.length;
	if(-1 != pos_end){
		sFc_uniqid = cookieString.substr(pos_start,(pos_end - pos_start));
	}
}
//--------end 惟一代号-------------------
var fromr = top.document.referrer;
fromr = ((fromr==\"\")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==\"\"? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
document.write('<a href=\"http://fishcounter.3322.org/data/xml_data.php?uid=1&type=page_detail&hpg='+hex_md5(escape(c_page))+'\" target=\"_blank\"><img src=\"http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'\" title=\"废墟流量统计\" border=\"0\"/></a>');
</script>
<noscript>
<a href=\"http://fishcounter.3322.org/index.php?uid=1\" target=\"_blank\"><img alt=\"废墟流量统计\" src=\"http://fishcounter.3322.org:8086/fc_1_1.gif\" border=\"0\" /></a>
</noscript></div></BODY>
</html>
";
	writetofile($path,$html);
	return $path;
}
?>
<HTML>
<HEAD>
<TITLE> ·<?=$m_title;?>·〓|合集下载|《838书城》打造绿色健康网文站点|book.mwjx.com </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="<?=$m_title;?>|book.mwjx.com">
<META NAME="Description" CONTENT="<?=$m_title;?>">
<style>
*{margin:0;padding:0}
body{background:#D7DFE6;background-image:url(/site838/view/image/mwbg.gif);background-repeat:repeat-x;margin:0;font-size:12px;font-family:SimSun}
img{border:0}
a{color:#00c}

#Head_div {height:60px;width:100%;/*background-color:red;*/}
#Logo_div {margin:13px 0 10px 3px;width:145px;float:left;}
#user_div {float:right;margin:30px 10px 10px 15px;width:310px}

#Mng_div {position:absolute;left:6px;z-index:23;margin:0 0 20px 0}
#listmng_div {padding:2px 0 15px;z-index:6;font-size:12px;cursor:pointer}
#list_div {height:570px;overflow:hidden;position:absolute;z-index:26;width:107px!important;width:auto;/*background-color:red;*/}
.list_adv_div {height:80px;overflow:hidden;position:absolute;z-index:26;width:108px!important;width:auto}
#SlBtn_div input,.S_div_css img {cursor:pointer}

#logo_img, #listmng_img, #playmode_img, .SP_div_css, .SD_div_css, .SPN_div_css, .tip, .LstCur_div_css, .cbpt, .cbpb, #nosong_div {background-image: url(/site838/view/image/mb.gif);background-repeat:no-repeat}

#nosong_div{position:absolute;top:325px;left:130px;width:132px;height:275px;background-position:-20px 0px;z-index:97;padding:22px 8px 0;line-height:150%;display:none;FILTER:progid:DXImageTransform.Microsoft.BasicImage(Rotation=3);}
#nosong_text_div{position:absolute;top:325px;left:130px;width:275px;height:132px;z-index:99;padding:22px 8px 0;line-height:150%;display:block;}

.addsong {background-position:-152px 0px}
.favolist {background-position:-152px -118px}
#up_img, #down_img {width:15px;height:15px;cursor:pointer}
#down_img {margin-top:5px}
.cbpt {background-position:-10px -304px}
.cbpb {background-position:-25px -304px}
.blank {background-image: none}
.tip {background-position:-62px -304px;width:18px;height:16px}

#logo_img {background-position:-10px -275px;height: 29px;width: 145px;}
#listmng_img, #playmode_img {background-position:-10px -141px;height: 5px;width: 9px}

.SD_div_css, .SDN_div_css, .SP_div_css, .SPN_div_css {float:left;cursor:pointer}
.SD_div_css {width:20px;background-position:-153px -252px}
.SDN_div_css {width:20px;background-image:none}
.SP_div_css {width:14px;margin-right:5px;background-position:-168px -236px}
.SPN_div_css {width:14px;margin-right:5px;background-position:-153px -236px}

.MenuPl_div_css {font-weight:600;padding:10px 0 4px 13px;border-top:1px solid #A0BACD;cursor:default;border-right:1px solid #A0BACD;width:107px}
.MenuPle_div_css {padding:10px 0 5px 20px;border-top:1px solid #A0BACD;border-right:1px solid #A0BACD;width:107px}
#scroll_div {position:absolute;top:416px;left:90px!important;left:80px;width:20px;z-index:999}
.scroll_adv_div {position:absolute;top:113px;left:90px!important;left:75px;width:20px;z-index:999}
#scroll_div img, #scroll_div_img img {clear:both;margin-top:3px}

#MPc_div {position:absolute;left:112px;top:60px;z-index:22;width:505px;height:450px!important;height:440px;background:#fff;border:1px solid #A0BACD}
.MPc_adv_div {position:absolute;left:122px;top:60px;z-index:22;width:299px;height:150px!important;height:100px;background:#fff;border:1px solid #A0BACD}
#MPc_div h1, .MPc_adv_div h1 {background:#ECEDED;text-align:right;cursor:default;clear:none;height:24px}

#thead_div {clear:both;padding:6px 2px 5px;margin-left:2px;float:none}





         

#playmode_div{text-align:left;padding:5px 10px;cursor:pointer;font-size:12px;font-weight:100;float:left}
.spn_title{
	width:120px;
	/*background-color:red;*/
}
.spn_title2{
	width:122px;
	line-height:20px;
	background-color:#eeeeee;/**/
}
.spn_text{
	width:122px;
	line-height:20px;
	background-color:#FFFFFF;/**/
}
#thead_ctlist{
	/*竞争车型列表头*/
	float:left;
	width:100%;
	/*height:200px;*/
	overflow:hidden;
	background-color:#eeefff;/**/
}
#thead_ctlist ul li{
	FONT-SIZE: 13px;
	margin-left:8px;
	margin-right:2px;
	padding-left:8px;
	float:left;
	width:105px;
	white-space:nowrap;
	line-height:18px;
	overflow:hidden;
	/*background:url(../images/secondhandwindow_hit.gif) 0 4px no-repeat;*/
}
#tbody_ctlist{
	/*竞争车型列表头*/
	float:left;
	width:100%;
	/*height:200px;*/
	overflow:hidden;
	/*background-color:#eeefff;*/
}
#tbody_ctlist ul li{
	FONT-SIZE: 13px;
	margin-left:8px;
	margin-right:2px;
	padding-left:8px;
	float:left;
	width:105px;
	white-space:nowrap;
	line-height:18px;
	overflow:hidden;
	cursor:hand;
	/*background:url(../images/secondhandwindow_hit.gif) 0 4px no-repeat;*/
}
#div_cardetail{
	/*竞争车型详情*/
	float:left;
	width:488px;
	/*height:200px;*/
	overflow:hidden;
	/*background-color:red;*/
}
#div_cardetail ul li{
	FONT-SIZE: 13px;
	margin-left:8px;
	margin-right:2px;
	padding-left:8px;
	float:left;
	width:225px;
	white-space:nowrap;
	line-height:18px;
	overflow:hidden;
	background:url(../images/secondhandwindow_hit.gif) 0 4px no-repeat;
}
#div_carprice{
	/*竞争车型详情*/
	float:left;
	width:488px;
	/*height:200px;*/
	overflow:hidden;
	/*background-color:red;*/
}

#div_carprice ul li{
	FONT-SIZE: 13px;
	float:left;
	white-space:nowrap;
	line-height:16px;
	overflow:hidden;
}
#nextc_div {background-image: url(/site838/view/image/mb.gif);background-repeat:no-repeat}
#nextc_div{background-position:-51px -304px;width:11px;height:11px;}
#prec_div {background-image: url(/site838/view/image/mb.gif);background-repeat:no-repeat}
#prec_div{background-position:-40px -304px;width:11px;height:11px;}
#div_terrorist{
	/*恐怖灵异类新书*/
	float:left;
	width:336px;
	height:105px;
	overflow:hidden;
	/*font-weight:bold;*/
	display:block;
	/*background-color:yellow;*/
}
#div_terrorist ul li{
	margin-right:5px;
	padding-left:5px;
	float:left;
	width:105px;
	white-space:nowrap;
	line-height:15px;
	overflow:hidden;
	background:url(/site838/view/images/bussniess/secondhandwindow_hit.gif) 0 4px no-repeat;
}

.li_hot{
	color:darkred;
}
.H{
	color:darkred;
}

#div_ctop628{
	/*奇幻玄幻新书点击*/
	display:block;
	float:left;
	width:500px;
	height:128px;
	overflow:hidden;
	font-weight:bold;/**/
	display:block;
	/*background-color:yellow;*/
}
#div_ctop628 ul li{
	margin-right:5px;
	padding-left:5px;
	float:left;
	width:160px;
	white-space:nowrap;
	line-height:15px;
	overflow:hidden;
	background:url(/site838/view/images/bussniess/secondhandwindow_hit.gif) 0 4px no-repeat;
}

#div_terrorist2{
	/*右上二新书*/
	margin-top:0px;
	margin-bottom:0px;
	float:left;
	width:336px;
	height:105px;
	overflow:hidden;
	/*font-weight:bold;*/
	display:block;
	/*background-color:red;*/
}
#div_terrorist2 ul li{
	margin-right:5px;
	padding-left:5px;
	float:left;
	width:105px;
	white-space:nowrap;
	line-height:15px;
	overflow:hidden;
	background:url(/site838/view/images/bussniess/secondhandwindow_hit.gif) 0 4px no-repeat;
}

#div_terrorist3{
	/*右上三新书*/
	margin-top:0px;
	margin-bottom:-15px;
	float:left;
	width:336px;
	height:105px;
	overflow:hidden;
	/*font-weight:bold;*/
	display:block;
	/*background-color:red;*/
}
#div_terrorist3 ul li{
	margin-right:5px;
	padding-left:5px;
	float:left;
	width:105px;
	white-space:nowrap;
	line-height:15px;
	overflow:hidden;
	background:url(/site838/view/images/bussniess/secondhandwindow_hit.gif) 0 4px no-repeat;
}

/**/

</style>
<script language="javascript">
function commit()
{
	//提交
	//输入:无
	//输出:无
	//alert(document.all["txt_title"].value);
	if("" == document.all["txt_cid"].value)
		return alert("类目为空");
	if("" == document.all["txt_title"].value)
		return alert("标题为空");
	//if("" == document.all["txt_content"].value)
	//	return alert("内容为空");
	//return;
	//----------提交---------
	//document.all["hd_clist"].value = list;
	document.all["frmsubmit"].action = '../cmd.php';
	//alert(document.all["frmsubmit"].action);
	//submitframe
	//alert("开始提交");
	document.all["frmsubmit"].submit();
}
function gotosearch()
{
	//搜索
	//输入:无
	//输出:无
	var str = document.all["txt_kw"].value;
	if("" == str)
		return alert("搜索关键词不能为空");
	var url = './down_dir.php?kw='+str;
	//return alert(url);
	window.location.href=url;
}
function gotodump(order)
{
	//跳转到导出页
	//输入:order(string)顺序asc/desc
	//输出:无
	window.location.href='./down_dir.php?dumpcid='+document.all["txt_cid"].value+"&order="+order;
}
function sendmobil()
{
	//下载到手机
	//输入:无
	//输出:无
	var obj = document.all["txt_content"];
	//alert(obj.value);
	//var rng = obj.createTextRange( );
	//if (rng!=null) {
	//	alert(rng.htmlText);
	//}
	m_temp_range = document.selection.createRange();  	
	if(null == m_temp_range)
		return alert("请在上面文本框中选中一行要下载的章节");
	if("" == m_temp_range.htmlText)
		return alert("请在上面文本框中选中一行要下载的章节");;	
	var arr = m_temp_range.htmlText.split("`|)");
	if(arr.length < 1)
		return alert("请在上面文本框中选中完整的一行");
	var id = parseInt(arr[0],10);
	var url = "/site838/view/src_php/sendmobil.php?id="+id;

	window.open(url,'','width=506,height=527,fullscreen=no,resizable=no,scrollbars=yes');
	//alert(id);
	//alert(m_temp_range.htmlText);
}
function go_next(flag)
{
	//跳转上下页
	//输入:flag(int)上下页-1/1(上页/下页)
	//输出:无
	var order = "asc";
	var id = 0;
	if("" != document.all["txt_cid"].value)
		id = parseInt(document.all["txt_cid"].value,10);
	//return alert(id);
	id += flag;
	window.location.href='./down_dir.php?dumpcid='+id+"&order="+order;
}

function down_book(flag)
{
	//下载
	//输入:无
	//输出:flag:down/read/downtxt(下载/全文阅读/txt下载)
	//形成ID列表
	//return alert(document.all["txt_content"].value);
	var arr = document.all["txt_content"].value.split("\n");
	//return alert(arr.length);
	var ls = "",row = null;
	for(var i = 0;i < arr.length; ++i){
		row = arr[i].split("`|)");
		//return alert(row.length);
		if(2 != row.length)
			continue;
		if("" != ls)
			ls += ",";
		ls += row[0];
	}
	if("" == ls)
		return alert("下载失败，文章列表为空");
	var str = document.all["txt_kw"].value;
	//var url = "./down_dir.php?dumpcid="+document.all["txt_cid"].value+"&ls="+ls+"&down="+flag+"&kw="+str;
	//window.location.href = url;
	//alert(url);
	document.all["frm_action"]["dumpcid"].value = document.all["txt_cid"].value;
	document.all["frm_action"]["ls"].value = ls;
	document.all["frm_action"]["down"].value = flag;
	document.all["frm_action"]["kw"].value = str;
	document.all["frm_action"].submit();

}

function init()
{
	//初始
	//run();
}
</script>
</HEAD>

<BODY id="main" onload="javascript:init();">
<div id="Head_div" align="center">
	<a href="http://book.mwjx.com/">返回《838书城》首页</a><br/>
<div  style="position:relative;top:10px;width:300px;height:30px;"><input  maxlength="12" size="20" name="txt_kw" type="text" value="<?=$m_kw;?>" onclick="this.value='';" onkeydown="javascript:if(13==event.keyCode){gotosearch();}"><button onclick="javascript:gotosearch();">搜索</button><!--//--></div>
</div>

<div id="Mng_div">
<div id="listmng_div">	
	当前类目&nbsp;<a href="#"><span id="listmng_img" style="cursor:hand;"></span></a>
</div>
<div id="list_div">
	<div id="0">
	<a href="./down_dir.php?dumpcid=<?=$m_dumpcid;?>" target="_self">《<?=$m_title;?>》</a></div>
	<div class="MenuPl_div_css">类目列表</div>
<?php
//最新生成合集
echo $m_clist;
?>

		</div>
</div>
<form id="frmsubmit" name="frmsubmit" accept-charset="GB2312" enctype="multipart/form-data;application/x-www-form-urlencoded" action="../cmd.php" method="POST" target="submitframe">
<input name="fun" type="hidden" value="add_classdir"/>
<div id="MPc_div">	
<h1><p id="playmode_div">
在线阅读：<span id="prec_div" onclick="javascript:go_next(-1);"></span>《<a href="/data/<?=$m_dumpcid;?>.html" target="_blank"><?=$m_title;?></a>》<span id="nextc_div" onclick="javascript:go_next(1);"></span>&nbsp;&nbsp;类目ID:<input type="text" name="txt_cid" value="<?=$m_editcid;?>" size="5"/>&nbsp;<button onclick="javascript:gotodump('asc');">确定</button><br/>

</p></h1>
<textarea cols="80" name="txt_content" rows="17" style="FONT-SIZE: 9pt"><?=$m_editcontent;?></textarea>
			<div id="info">
<span style="width:40px;"></span><button onclick="javascript:down_book('read');">&nbsp;&nbsp;全文阅读&nbsp;&nbsp;</button>&nbsp;<button onclick="javascript:down_book('down');">&nbsp;&nbsp;打包下载&nbsp;&nbsp;</button>&nbsp;<button onclick="javascript:down_book('downtxt');">&nbsp;&nbsp;txt文本下载&nbsp;&nbsp;</button>&nbsp;<br/><br/>
<button onclick="javascript:gotodump('asc');">文章列表(最多300条，顺序)</button>
<button onclick="javascript:gotodump('desc');">文章列表(最多300条，倒序)</button><br/>
<!--<IFRAME marginWidth=0 marginHeight=0 src="/site838/view/include/bottom.html" frameBorder=0 width="100%" height=120 scrolling=no topmargin="0" leftmargin="0" valign="top"></IFRAME>//-->
<div style="display:block;float:left;width:500px;height:218px;margin-top:5px;">
<div style="display:inline;float:left;width:300px;height:90px;overflow:hidden;">
说明：<br/>
最多一次下载100篇文章。
可以在列表框编辑列表。<br/>
每个类目每天只能生成一次下载文档。<a href="/site838/view/track/index.php?id=<?=$m_dumpcid;?>" target="_blank"><b>设置自定义下载章节：<?=$m_title;?></b></a><br/>
<?=c_pagebase::html_counter();?>
</div>
<div style="display:inline;float:left;width:200px;height:90px;overflow:hidden;">
<script type="text/javascript"><!--
google_ad_client = "pub-6913943958182517";
/* 200x90, 创建于 08-7-4 */
google_ad_slot = "4277987903";
google_ad_width = 200;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
<div id="div_ctop628">
<b>奇幻玄幻类新书点击</b>
<script type="text/javascript" src="http://book.mwjx.com/html/ctopd30_628.js"></script>
</div>

</div>

			</div>
</div>
</form>
<div style="position:absolute;display:block;left:620px;width:336px;height:500px;">	
<div id="div_terrorist">
<!--<b>恐怖灵异类新书点击</b>//-->
<script type="text/javascript" src="http://book.mwjx.com/html/ctopd30_572.js"></script>
</div>
<div id="div_terrorist2">
<!--<b>言情类新书点击</b>//-->
<script type="text/javascript" src="http://book.mwjx.com/html/ctopd30_500.js"></script>
</div>
<IFRAME border=0 
		marginWidth=0 frameSpacing=0 marginHeight=0 src="/site838/view/include/ads_google_336_280.html" 
		frameBorder=0 width=336 scrolling=no height=280></IFRAME>
<div id="div_terrorist3">
<!--<b>都市类新书点击</b>//-->
<script type="text/javascript" src="http://book.mwjx.com/html/ctopd30_619.js"></script>
</div>
	<!--<IFRAME border=0 
		marginWidth=0 frameSpacing=0 marginHeight=0 src="/mwjx/include/help_mwjx.html" 
		frameBorder=0 width=336 scrolling=no height=280></IFRAME>//--></div>
<!--<script src="http://u.keyrun.com/js/124/124869.js"></script><script src="http://u.keyrun.com/voo.php"></script>//-->
<!--可关闭//-->
<!--<script language="javascript" src="http://js.733.com/gc_usercode__050055055050124095124056048.htm">
</script>//-->
<!--无关闭//-->
<!--<script language="javascript" src="http://js.733.com/gc_usercode__050055055050124095124056055.htm">
</script>//-->
<!--提交表单//-->
<form method="POST" name="frm_action" action="" target="submitframe" accept-charset="GBK">
<input type="hidden" name="fun" value=""/>
<input type="hidden" name="dumpcid" value=""/>
<input type="hidden" name="ls" value=""/>
<input type="hidden" name="down" value=""/>
<input type="hidden" name="kw" value=""/>
</form>
<iframe name="submitframe" width="1" height="1"></iframe>			
</BODY>
</HTML>
