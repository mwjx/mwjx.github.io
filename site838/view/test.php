<?php
//------------------------------
//create time:2007-2-26
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:测试
//------------------------------
//var_dump(intval(substr("4321009",0,-3)));
//exit();
//echo "<iframe width=\"150\" height=\"150\" src=\"http://www.mwjx.com/data/1.html\"></iframe>";
exit();
require("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
$uname="hujjkk"; //临时用户
$upass="123";
$upass=crypt(stripslashes($upass),"d.r");  
$obj_man = new manbase_2($uname,$upass);
var_dump($obj_man->get_id());
exit();
$dir = "../../data/up_pics/";
$dir .= "zz/";
$path = $dir."zz.txt";
if(file_exists($path)){
	unlink($path);
}
if(file_exists($dir)){
	rmdir($dir);
}
mkdir($dir,0644);
chmod($dir,0777);
if(false === ($fp2=fopen($path,"a")))
	exit("fopen fail:".$path);;
if(-1 == fwrite($fp2,"zz")){ //把抓取得内容写到 临时文件中
	fclose($fp2);
	exit("fopen fail:".$path);
}
fclose($fp2);
exit("over");
require("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//来源优先级
$str_sql = "SELECT flag,count(*) as num FROM `update_track` group by flag order by num DESC;";
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
var_dump($arr);
exit();
//----------修正错误跟踪URL--------
$str_sql = "SELECT * FROM `update_track` WHERE flag = 20 order by id asc;";
$sql = new mysql;
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_array();
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	$id = $arr[$i]["id"];
	$url = $arr[$i]["url"];

	/*
	//19
	if(!strstr($url,"http://www.xiaoshuo520.net/html/Book/"))
		continue;
	$url = str_replace("http://www.xiaoshuo520.net/html/Book/","",$url);
	//$url = str_replace("/Index.shtml","",$url);

	$row = explode("/",$url);
	if(3 == count($row))
		continue;
	if(5 != count($row))
		continue;
	$url = $row[2]."/".$row[3]."/";
	$url = "http://www.xiaoshuo520.net/html/Book/".$url;
	*/
	//20
	$url = str_replace("http://www.9173.com/Html/Book/","",$url);
	$url = str_replace("/Index.shtml","",$url);
	$row = explode("/",$url);
	if(2 == count($row))
		continue;
	//$a = (intval(substr($row[1],0,-3)));
	$a = (intval(substr($url,0,-3)));
	//echo $a.".";
	//if($a == intval($row[0]))
	//	continue;
	$url = strval($a)."/".$url;
	//echo $url."<br/>\n";
	//continue;
	//$url = substr($url,2);
	$url = "http://www.9173.com/Html/Book/".$url."/Index.shtml";
	/*
	*/
	/*
	//25
	if(!strstr($url,"index.html"))
		continue;
	$url = str_replace("http://www.mop5.com/files/article/mop5/","",$url);
	$url = str_replace("/index.html","",$url);
	$row = explode("/",$url);
	if(2 == count($row))
		continue;
	$url = substr($url,2);
	$url = "http://www.mop5.com/files/article/mop5/".$url."/index.html";
	*/
		
	echo $url."<br/>\n";
	$str_sql = "update `update_track` set url = '".$url."' where id = '".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();

}

//echo md5("http://www.hszw.com/book/17846/content.html");
exit();
//统计fidh_down
$path = "nohup.out";
$arr = file($path);
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	$line = $arr[$i];
	
	//$row = explode(",",$line);
	//if("client:3" != $row[0])
	//	continue;
	/**/
	
	if(!strstr($line,"sockid:8"))
		continue;
	/**/
	echo $line."<br/>";
}
//$im = imagegrabscreen();
//imagepng($im, "gd_screen.png");
exit();
$url = "http://youshengdx.52ps.cn/yousheng/历史军事_亮剑/01.mp3?0000000674892025001tflag=1200476821mpin=6ea2618aef5edc6e91b431006a91f703.mp3";
$url = "http://www.mwjx.com/003.wma";
$url = "http://www.mwjx.com/index.html";
//var_dump(copy($url,"003.wma"));
//exit();
//$fd = fopen($url,"r");
//$contents = fread($fd,filesize($url));
//fclose($fd);
//writetofile("index.html",$contents);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 妙文精选|www.mwjx.com </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<script language="javascript" src="include/script/xmldom.js"></script>
<script language="javascript">
function init()
{
	return;
	//alert("ff");
	var xmldoc = new_xmlhttp();
	xmldoc.Open('GET','http://www.mwjx.com/',false);
	xmldoc.Send();
	alert(xmldoc.responseText);
}
</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0" onload="javascript:init();">
hello
</BODY>
</HTML>
