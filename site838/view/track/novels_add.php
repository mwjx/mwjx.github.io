<?php
//------------------------------
//create time:2008-5-10
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:添加待入库小说列表
//------------------------------
//必须要cd到这个目录下才执行下面的命令
//cd /usr/home/mwjx/fish838.com/site838/view/track/
///usr/local/php/bin/php /usr/home/mwjx/fish838.com/site838/view/track/novels_add.php
//var_dump(extension_loaded("zlib")); 
exit();
$_SERVER["PHP_SELF"] = "/site838/view/track/novels_add.php";

include("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");


$m_sou = 32; //来源标志
$dirroot = "../../../data/update_track/index/".$m_sou."/";

//-------tests-------
//$path = $dirroot."f7a257f57c75ae78b5890df3b05d6cdc.gz";
//$path = $dirroot."f7a257f57c75ae78b5890df3b05d6cdc.html";
//$path = $dirroot."3a42689fe7403c35fc22c1d33cb35fc8.html";
//$path = "yyy.txt";
//$tmp = (readfromfile($path));
//$tmp = gzencode($tmp);

//writetofile("xxx.txt",$tmp);
//$tmp = (gzdecodev2($tmp));
//header("Content-Encoding: gzip");
//header("Vary: Accept-Encoding");
//header("Content-Length: ".strlen($tmp));
//echo $tmp;
//echo gzuncompress(gzencode($tmp,9));
//var_dump(function_exists("gzdecode"));
//readgzfile($path);
//var_dump(readgzfile($path));
//exit();

//-----end tests------
$m_novels = array(); //作品=>ID
$m_author = array(); //作者=>ID,废弃
$m_links = array(); //作品ID=>来源ID=>true,废弃
load_novels();
//var_dump(!isset($m_novels["天女劫"]));
//exit();
$files = get_arr_files($dirroot);
//var_dump($files);
//exit();
$len = count($files);
for($i = 0;$i < $len; ++$i){
	$path = $dirroot.$files[$i];
	set_time_limit(120);
	flush();
	deal_file($path,$m_sou);
	//exit();
	//break;
	//echo $path."<br/>";
}
echo "OVER!";
//var_dump($files);

//-------------函数群-----------
function load_novels()
{
	//装载旧数据
	//输入:无
	//输出:无
	//global $m_author;
	global $m_novels;
	//global $m_links;
	//作品
	$str_sql = "select id,name from class_info;";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i][0]);
		$name = ($arr[$i][1]);
		if(isset($m_novels[$name]))
			continue;
		$m_novels[$name] = true;
	}
	$str_sql = "select id,title from track_preparatory;";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i][0]);
		$name = ($arr[$i][1]);
		if(isset($m_novels[$name]))
			continue;
		$m_novels[$name] = true;
	}
	//var_dump($m_novels);
	//exit();
}
function get_arr_files($dir="")
{
	//查找对应的所有文件
	//输入：无
	//输出：文件列表数组,异常返回false
	//exit($dir);
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
	//处理一个文件，将符合条件的记录输出到输出数组中
	//输入：path是文件路径,sou来源标志来自track.php
	//输出：true,false
	//var_dump($sou);
	//exit();
	//exit("fisdfj");
	//if(!file_exists($path))
	//	return false;
	//global $m_author;
	global $m_novels;
	//global $m_links;
	echo($path."<br/>\n");
	//return false;
	$shtml = readfromfile($path);
	if("" == $shtml)
		return false;
	//echo $shtml;
	//exit();
	switch($sou){
		case 1:
			preg_match("|<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" class=\"grid\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 2: //世纪
			preg_match("|<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"1\" style=\"line-height:150%;text-decoration:none;color:#000000\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 5: //奇迹
			preg_match("|<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" class=\"grid\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 10: //华夏
			preg_match("|<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" class=\"grid\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 16: //d9
			preg_match("|<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" class=\"b1\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 19:
			preg_match("|<tr bgcolor=\"#FFFFFF\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[0];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 20:
			preg_match("|<table width=\"100%\" height=\"32\" border=\"0\" class=\"b1\" cellpadding=\"0\" cellspacing=\"0\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 22:
			preg_match("|<tr height=24>(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[0];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 25:
			preg_match("|<table width=\"100%\" cellpadding=\"0\" cellspacing=\"1\" class=\"grid\">(.*?)<\/table>|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			$arr = $out[2];
			//var_dump($arr);
			//exit();
			break;
		case 28:
			preg_match("|<table width=\"96%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">(.*?)<form|s",$shtml,$out);
			//var_dump($out);
			//exit();
			$txt = $out[0];
			preg_match_all("|<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">(.*?)<\/table>|s",$txt,$out);
			$arr = $out[1];
			//var_dump($arr);
			//exit();
			break;
		case 4:
			preg_match_all("|\<script language=javascript>putlist(.*?)\<\/script>|s",$shtml,$out);
			$txt = $out[1][0];
			if("" == $txt)
				return false;
			$arr = explode("\n",$txt);
			break;
		case 14: //逐浪
			preg_match("|<div class=\"mf4\">(.*?)<\/div>|s",$shtml,$out);
			$txt = $out[0];
			preg_match_all("|<ul(.*?)>(.*?)<\/ul>|s",$txt,$out);
			//var_dump($out);
			//exit();
			$arr = $out[0];
			//$len = count($out[0]);
			//for($i = 0; $i)
			break;
		case 18: //小说阅读网
			preg_match("|<ul>(.*?)<\/ul>|s",$shtml,$out);
			$txt = $out[0];
			//$txt = $shtml;
			preg_match_all("|<li>(.*?)<\/li>|s",$txt,$out);
			//var_dump($out);
			//exit();
			$arr = $out[1];
			//$len = count($out[0]);
			//for($i = 0; $i)
			break;
		case 26: //新浪
			preg_match("|<div class=\"textList\">(.*?)<\/div>|s",$shtml,$out);
			//echo $shtml;
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			//var_dump($out);
			//exit();
			$arr = $out[2];
		case 32: //新浪来源
			preg_match("|<div class=\"textList\">(.*?)<\/div>|s",$shtml,$out);
			//echo $shtml;
			//var_dump($out);
			//exit();
			$txt = $out[1];
			preg_match_all("|<tr(.*?)>(.*?)<\/tr>|s",$txt,$out);
			//var_dump($out);
			//exit();
			$arr = $out[2];			
			break;
		default:
			return false;
	}

	$len = count($arr);
	$info = array();
	$sql = new mysql("fish838");
	for($i = 0;$i < $len; ++$i){
		$info = array();
		deal_line($arr[$i],$info,$sou);
		if(count($info) < 1)
			continue;
		//if("天女劫" != $info[0])
		//	continue;
		//echo $info[0]."<br/>";
		//continue;
		//continue;
		//var_dump($info);
		//exit();
		if(isset($m_novels[$info[0]])){
			continue;
		}
		$str_sql = "insert into track_preparatory (title,t,author)values('".addslashes($info[0])."','".addslashes($info[1])."','".addslashes($info[2])."');";
		$sql->query_ignore($str_sql);

		$m_novels[$info[0]] = true;
	}
	$sql->close();
	//var_dump($m_author);
	//exit();
	return true;
}
function deal_line($line="",&$out,$site=-1)
{
	//处理一行
	//输入:line一行,out输出数组array(作品,类别,作者)
	//site来源站点
	//输出:无
	//echo $line;
	//var_dump(!strpos($line,"(",0));
	//var_dump($site);
	//exit();
	//site:14
	//if(14 != $site)
	//	return;
	$class = ""; //类别
	switch($site){
		case 1: //三五
			if(!strstr($line,"odd"))
				break;
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 6)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[0];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//articleinfo.php?id=(.*?)"
			preg_match("|articleinfo.php\?id=(.*?)\"|s",$title,$pma);
			//var_dump($pma);
			//exit();
			$nid= $pma[1];
			if(intval($nid) < 1)
				return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[2]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 2: //世纪
			//if(!strstr($line,"odd"))
			//	break;
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 7)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[1];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//\/files\/article\/info\/(.*?).htm
			preg_match("|\/files\/article\/info\/(.*?).htm|s",$title,$pma);
			if(sizeof($pma) < 1)
				return;
			//var_dump($pma);
			//exit();
			$nid= $pma[1];
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			$title = str_replace("《","",$title);
			$title = str_replace("》","",$title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[3]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 5: //奇迹
			if(!strstr($line,"odd"))
				break;
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 7)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[0];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//articleinfo.php?id=(.*?)"
			preg_match("|articleinfo.php\?id=(.*?)\"|s",$title,$pma);
			//var_dump($pma);
			//exit();
			$nid= $pma[1];
			if("" == $nid)
				return;
			if(intval($nid) < 1)
				return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			$title = str_replace("《","",$title);
			$title = str_replace("》","",$title);
			$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[2]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 10: //华夏
			if(!strstr($line,"odd"))
				break;
			//var_dump($line);
			//exit();
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 6)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[0];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//articleinfo.php?id=(.*?)"
			preg_match("|\/files\/article\/info\/(.*?).htm|s",$title,$pma);
			//var_dump($pma);
			//exit();
			$nid= $pma[1];
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			$title = str_replace("《","",$title);
			$title = str_replace("》","",$title);
			//$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[2]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 16: //d9
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 6)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[0];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//\/d9info\/(.*?).htm
			preg_match("|\/d9info\/(.*?).htm|s",$title,$pma);
			if(sizeof($pma) < 1)
				return;
			//var_dump($pma);
			//exit();
			$nid= $pma[1];
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			//$title = str_replace("《","",$title);
			//$title = str_replace("》","",$title);
			//$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[2]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 19:
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 7)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[1];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//\/Book\/(.*?)\/Index.aspx
			preg_match("|\/Book\/(.*?)\/Index.aspx|s",$title,$pma);
			if(sizeof($pma) < 1)
				return;
			//var_dump($pma);
			//exit();
			$nid= trim($pma[1]);
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			//$title = str_replace("《","",$title);
			//$title = str_replace("》","",$title);
			//$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[5]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 20:
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 5)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[1];
			preg_match("|<a(.*?)>(.*?)<\/a>|s",$title,$pma);
			if(sizeof($pma) < 1)
				return;
			$title = $pma[0];
			//var_dump($pma);
			//exit();
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//\/Book\/(.*?).aspx
			preg_match("|\/Book\/(.*?).aspx|s",$title,$pma);
			if(sizeof($pma) < 1)
				return;
			//var_dump($pma);
			//exit();
			$nid= trim($pma[1]);
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			//$title = str_replace("《","",$title);
			//$title = str_replace("》","",$title);
			//$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[2]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 22:
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 6)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[1];
			//preg_match("|<a(.*?)>(.*?)<\/a>|s",$title,$pma);
			//if(sizeof($pma) < 1)
			//	return;
			//$title = $pma[0];
			//var_dump($pma);
			//exit();
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//href=(.*?).html
			preg_match("|href=(.*?).html|s",$title,$pma);
			if(sizeof($pma) < 1)
				return;
			//var_dump($pma);
			//exit();
			$nid= trim($pma[1]);
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			//$title = str_replace("《","",$title);
			//$title = str_replace("》","",$title);
			//$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[4]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 25: 
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 6)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[0];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//\/mop5\/(.*?)\/index.html
			preg_match("|\/mop5\/(.*?)\/index.html|s",$title,$pma);
			//var_dump($pma);
			//exit();
			if(sizeof($pma) < 1)
				return;
			$nid= $pma[1];
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			$title = str_replace("《","",$title);
			$title = str_replace("》","",$title);
			//$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[2]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;
		case 28: 
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			//var_dump($arr);
			//exit();
			if(count($arr) < 6)
				return;
			//var_dump($arr);
			//exit();
			$title = $arr[0];
			preg_match("|<a(.*?)>(.*?)<\/a>|s",$title,$pma);
			if(sizeof($pma) < 1)
				return;
			$title = $pma[0];
			//var_dump($title);
			//exit();
			//\/book\/index_(.*?).html
			//\/a\/(.*?)\/
			preg_match("|\/a\/(.*?)\/|s",$title,$pma);
			//var_dump($pma);
			//exit();
			if(sizeof($pma) < 1)
				return;
			$nid= $pma[1];
			if("" == $nid)
				return;
			//if(intval($nid) < 1)
			//	return;
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			//$title = str_replace("《","",$title);
			//$title = str_replace("》","",$title);
			//$title = trim($title);
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[1]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止

			break;

		case 14: //逐浪
			if(strstr($line,"<ul class=\"header\">"))
				return; //去掉头部
			preg_match_all("|<li(.*?)>(.*?)<\/li>|s",$line,$pma);
			$arr = $pma[2];
			$title = trim(togbk_dolt(strip_tags($arr[1])));
			$title = str_replace("《","",$title);
			$title = str_replace("》","",$title);
			$author = trim(togbk_dolt(strip_tags($arr[3])));
			preg_match("|http:\/\/www.zhulang.com\/(.*?)\/index.html|s",$arr[1],$pma);
			$nid= $pma[1];
			$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止
			if("全本" == $st)
				$s = "O";
			if("连载" == $st)
				$s = "I";
			break;
		case 18: 
			//<h1>《<a href="http://www.readnovel.com/novel/39067.html" target="_blank"><b>倚天屠龙之我是纪哓芙</b></a>》&nbsp;&nbsp;[小说连载]</h1><br /><h2>作者：<em>惘然晨辰</em></h2>女主角穿越回大宋，重生为纪晓芙，在倚天屠龙的世界里，改变了杨逍与纪晓芙相爱却又不能相守的结局。从第三十二章开始是有些重复倚天的情节，推动剧情的需要，各位担待。到后面主角性格会有些改变，毕竟死而复生，心境不同了。<div class="bothall"></div>
			//exit($line);
			preg_match("|<b>(.*?)<\/b>|s",$line,$pma);
			$title = $pma[1];
			if("" == $title)
				return;
			preg_match("|<em>(.*?)<\/em>|s",$line,$pma);
			$author = $pma[1];
			if("" == $author)
				return;
			preg_match("|\/novel\/(.*?).html|s",$line,$pma);
			$nid= $pma[1];
			//var_dump($author);
			//exit();
			$s = "S"; //停止

			//exit();
			break;
		case 26: //新浪
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 8)
				return;
			$title = $arr[2];
			//\/book\/index_(.*?).html
			preg_match("|\/book\/index_(.*?).html|s",$title,$pma);
			$nid= $pma[1];
			//var_dump($nid);
			//exit();
			$title = trim(strip_tags($title));
			//exit("|".$title."|");
			$author = trim(strip_tags($arr[4]));
			//exit("|".$author."|");
			
			//$st = trim(togbk_dolt($arr[4]));
			$s = "S"; //停止
			//if("全本" == $st)
			//	$s = "O";
			//if("连载" == $st)
			//	$s = "I";
			break;
		case 32: //新浪来源
			preg_match_all("|<td(.*?)>(.*?)<\/td>|s",$line,$pma);
			$arr = $pma[2];
			if(count($arr) < 8)
				return;
			$class = trim(strip_tags($arr[1]));
			$title = $arr[2];
			//\/book\/index_(.*?).html
			preg_match("|title=\"(.*?)\"|s",$title,$pma);
			$title= strip_tags($pma[1]);
			$author = $arr[4];
			preg_match("|title=\"(.*?)\"|s",$author,$pma);
			$author= strip_tags($pma[1]);
			//exit($author);
			break;
		default:
			break;
	}
	//exit("|".$author."|");
	$out = array(trim($title),trim($class),trim($author));
	return;
}


function gzdecode($data,&$filename='',&$error='',$maxlength=null)
{
    $len = strlen($data);
    if ($len < 18 || strcmp(substr($data,0,2),"\x1f\x8b")) {
        $error = "Not in GZIP format.";
        return null;  // Not GZIP format (See RFC 1952)
    }
    $method = ord(substr($data,2,1));  // Compression method
    $flags  = ord(substr($data,3,1));  // Flags
    if ($flags & 31 != $flags) {
        $error = "Reserved bits not allowed.";
        return null;
    }
    // NOTE: $mtime may be negative (PHP integer limitations)
    $mtime = unpack("V", substr($data,4,4));
    $mtime = $mtime[1];
    $xfl   = substr($data,8,1);
    $os    = substr($data,8,1);
    $headerlen = 10;
    $extralen  = 0;
    $extra     = "";
    if ($flags & 4) {
        // 2-byte length prefixed EXTRA data in header
        if ($len - $headerlen - 2 < 8) {
            return false;  // invalid
        }
        $extralen = unpack("v",substr($data,8,2));
        $extralen = $extralen[1];
        if ($len - $headerlen - 2 - $extralen < 8) {
            return false;  // invalid
        }
        $extra = substr($data,10,$extralen);
        $headerlen += 2 + $extralen;
    }
    $filenamelen = 0;
    $filename = "";
    if ($flags & 8) {
        // C-style string
        if ($len - $headerlen - 1 < 8) {
            return false; // invalid
        }
        $filenamelen = strpos(substr($data,$headerlen),chr(0));
        if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
            return false; // invalid
        }
        $filename = substr($data,$headerlen,$filenamelen);
        $headerlen += $filenamelen + 1;
    }
    $commentlen = 0;
    $comment = "";
    if ($flags & 16) {
        // C-style string COMMENT data in header
        if ($len - $headerlen - 1 < 8) {
            return false;    // invalid
        }
        $commentlen = strpos(substr($data,$headerlen),chr(0));
        if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
            return false;    // Invalid header format
        }
        $comment = substr($data,$headerlen,$commentlen);
        $headerlen += $commentlen + 1;
    }
    $headercrc = "";
    if ($flags & 2) {
        // 2-bytes (lowest order) of CRC32 on header present
        if ($len - $headerlen - 2 < 8) {
            return false;    // invalid
        }
        $calccrc = crc32(substr($data,0,$headerlen)) & 0xffff;
        $headercrc = unpack("v", substr($data,$headerlen,2));
        $headercrc = $headercrc[1];
        if ($headercrc != $calccrc) {
            $error = "Header checksum failed.";
            return false;    // Bad header CRC
        }
        $headerlen += 2;
    }
    // GZIP FOOTER
    $datacrc = unpack("V",substr($data,-8,4));
    $datacrc = sprintf('%u',$datacrc[1] & 0xFFFFFFFF);
    $isize = unpack("V",substr($data,-4));
    $isize = $isize[1];
    // decompression:
    $bodylen = $len-$headerlen-8;
    if ($bodylen < 1) {
        // IMPLEMENTATION BUG!
        return null;
    }
    $body = substr($data,$headerlen,$bodylen);
    $data = "";
    if ($bodylen > 0) {
        switch ($method) {
        case 8:
            // Currently the only supported compression method:
            $data = gzinflate($body,$maxlength);
            break;
        default:
            $error = "Unknown compression method.";
            return false;
        }
    }  // zero-byte body content is allowed
    // Verifiy CRC32
    $crc   = sprintf("%u",crc32($data));
    $crcOK = $crc == $datacrc;
    $lenOK = $isize == strlen($data);
    if (!$lenOK || !$crcOK) {
        $error = ( $lenOK ? '' : 'Length check FAILED. ') . ( $crcOK ? '' : 'Checksum FAILED.');
        return false;
    }
    return $data;
}
function gzdecodev2($data) {
  $len = strlen($data);
  if ($len < 18 || strcmp(substr($data,0,2),"\x1f\x8b")) {
    return null;  // Not GZIP format (See RFC 1952)
  }
  $method = ord(substr($data,2,1));  // Compression method
  $flags  = ord(substr($data,3,1));  // Flags
  if ($flags & 31 != $flags) {
    // Reserved bits are set -- NOT ALLOWED by RFC 1952
    return null;
  }
  // NOTE: $mtime may be negative (PHP integer limitations)
  $mtime = unpack("V", substr($data,4,4));
  $mtime = $mtime[1];
  $xfl   = substr($data,8,1);
  $os    = substr($data,8,1);
  $headerlen = 10;
  $extralen  = 0;
  $extra     = "";
  if ($flags & 4) {
    // 2-byte length prefixed EXTRA data in header
    if ($len - $headerlen - 2 < 8) {
      return false;    // Invalid format
    }
    $extralen = unpack("v",substr($data,8,2));
    $extralen = $extralen[1];
    if ($len - $headerlen - 2 - $extralen < 8) {
      return false;    // Invalid format
    }
    $extra = substr($data,10,$extralen);
    $headerlen += 2 + $extralen;
  }

  $filenamelen = 0;
  $filename = "";
  if ($flags & 8) {
    // C-style string file NAME data in header
    if ($len - $headerlen - 1 < 8) {
      return false;    // Invalid format
    }
    $filenamelen = strpos(substr($data,8+$extralen),chr(0));
    if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
      return false;    // Invalid format
    }
    $filename = substr($data,$headerlen,$filenamelen);
    $headerlen += $filenamelen + 1;
  }

  $commentlen = 0;
  $comment = "";
  if ($flags & 16) {
    // C-style string COMMENT data in header
    if ($len - $headerlen - 1 < 8) {
      return false;    // Invalid format
    }
    $commentlen = strpos(substr($data,8+$extralen+$filenamelen),chr(0));
    if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
      return false;    // Invalid header format
    }
    $comment = substr($data,$headerlen,$commentlen);
    $headerlen += $commentlen + 1;
  }

  $headercrc = "";
  if ($flags & 2) {
    // 2-bytes (lowest order) of CRC32 on header present
    if ($len - $headerlen - 2 < 8) {
      return false;    // Invalid format
    }
    $calccrc = crc32(substr($data,0,$headerlen)) & 0xffff;
    $headercrc = unpack("v", substr($data,$headerlen,2));
    $headercrc = $headercrc[1];
    if ($headercrc != $calccrc) {
      return false;    // Bad header CRC
    }
    $headerlen += 2;
  }

  // GZIP FOOTER - These be negative due to PHP's limitations
  $datacrc = unpack("V",substr($data,-8,4));
  $datacrc = $datacrc[1];
  $isize = unpack("V",substr($data,-4));
  $isize = $isize[1];

  // Perform the decompression:
  $bodylen = $len-$headerlen-8;
  if ($bodylen < 1) {
    // This should never happen - IMPLEMENTATION BUG!
    return null;
  }
  $body = substr($data,$headerlen,$bodylen);
  $data = "";
  if ($bodylen > 0) {
    switch ($method) {
      case 8:
        // Currently the only supported compression method:
        $data = gzinflate($body);
        break;
      default:
        // Unknown compression method
        return false;
    }
  } else {
    // I'm not sure if zero-byte body content is allowed.
    // Allow it for now...  Do nothing...
  }

  // Verifiy decompressed size and CRC32:
  // NOTE: This may fail with large data sizes depending on how
  //       PHP's integer limitations affect strlen() since $isize
  //       may be negative for large sizes.
  if ($isize != strlen($data) || crc32($data) != $datacrc) {
    // Bad format!  Length or CRC doesn't match!
    return false;
  }
  return $data;
}

?>