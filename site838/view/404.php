<?php
include("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$url = $_SERVER["REQUEST_URI"];
//$url = "/html/1f5/4674/615.html";
//$url = $HTTP_REFERER;
//var_dump($_SERVER);
if("" != $url)
	gourl($url);
function gourl($url)
{
	//echo $url."<br/>";
	if(file_exists($url))
		return;
	if(false === ($s=strstr($url,"/html/")))
		return;
	$arr = explode("/",$s);
	//var_dump($arr);
	if(5 != count($arr))
		return;
	if(".html" != substr($arr[4],-5))
		return;
	$cid = intval($arr[3]);
	if($cid < 1)
		return;
	$id = -1;
	if("index" != substr($arr[4],0,5)){ //章节
		$id = intval(substr($arr[4],0,strpos($arr[4],".")));
		$id = idbyorder($cid,$id);
		header("location:/site838/view/track/show.php?id=".$id);
	}
	else{ //类目
		header("location:/site838/view/track/index.php?id=".$cid);
	}
	//exit();
}
function idbyorder($c,$a)
{
	//根据顺序号查章节ID
	//输入:c类目ID,a章节顺序号
	//输出:章节ID,异常-1
	$str_sql = "select id from article  where cid='".$c."' order by id asc limit ".$a.";";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_rows();
	$sql->close();
	//var_dump($arr);
	//exit();
	$len = count($arr);
	if($len < $a)
		return -1;
	$id = intval($arr[$len-1][0]);
	return $id;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<LINK 
href="/site838/view/include/content.css" type=text/css rel=stylesheet>
</HEAD>

<BODY leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">


<table width="778" cellSpacing=0 cellPadding=0 BORDER=0 bgColor=#eeeeee align="center">
<tr>
<td style="display:;">
<br/>
找不到所要的文件，可能文件不存在或是该文章没有生成静态页面:<br>
<!--静态页面地址:http://www.mwjx.com/bbs/html/6000/5549.html<br>
论坛地址:http://www.mwjx.com/bbs/show_txt.php?fid=5549<br/>//-->
</td>
</tr>
<tr>
<td>
<script language="JavaScript">
//<meta http-equiv="Refresh" content="3; url=/fc_client/go.html"/>
var str_html = "";
var int_id = 0;
/*
页面类别:文章页/其他类型
http://book.mwjx.com/html/b7e/771/-1.html

*/
if(false !== (default_url = get_article_id())){
	//str_html = "http://www.mwjx.com/bbs/show_txt.php?fid="+int_id;
	//alert(default_url);
	str_html = default_url;
	str_html = "<a href=\""+str_html+"\">没有下一页，返回作品索引页</a>";
}
else{
	str_html = "http://www.fish838.com/site838/";
	str_html = "<a href=\""+str_html+"\">回到838小说阅读器</a>";
}
if("" == str_html){
	str_html = "对不起，动态页面好像也不存在!";
}
document.write(str_html);
function get_article_id()
{
	//返回当前文章ID
	//输入:无，当前URL前置条件
	//输出:ID字符串，异常或找不到返回false
	var str_url = top.location.href;
	//str_url = "http://book.mwjx.com/html/b7e/771/1.html";
	if(true !== is_ie()){
		return false;
	}
	try{
		//var str_erg = /(\w+):\/\/([^/:]+)(:\d*)?\/html\/(\w+)\/(\d+)\/(\d+).html/;
		var str_erg = /(\w+):\/\/([^/:]+)(:\d*)?\/html\/(\w+)\/(\d+)\/([^/.]+).html/;
		var arg1 = str_url.replace(str_erg,"$1");
		var arg2 = str_url.replace(str_erg,"$2");
		var arg3 = str_url.replace(str_erg,"$3");
		var dir1 = str_url.replace(str_erg,"$4");
		var dir2 = str_url.replace(str_erg,"$5");
	}
	catch(err){
		return false;
	}
	if(("" != dir1) && (str_url != dir1) && ("" != dir2) && (str_url != dir2)){
		return arg1+"://"+arg2+"/html/"+dir1+"/"+dir2+"/";
		//var int_id = parseInt(rv);
		//if(int_id > 0){
		//	return int_id;
		//}
	}
	return false;
}
function is_ie()
{
	//是IE返回true,否则返回false
	var agent = navigator.userAgent.toLowerCase();
	if(agent.indexOf("msie")!=-1){
		return true;
	}
	return false;
}
</script>
</td>
</tr>
<tr><td align="center">
<br/>
<a href="http://www.fish838.com/"><b>返回838首页</b></a>
<!--
精华检索:<a href="/bbs/html/a/index.html" target="_blank"><strong>A<strong></a>&nbsp;<a href="/bbs/html/b/index.html" target="_blank"><strong>B<strong></a>&nbsp;<a href="/bbs/html/c/index.html" target="_blank"><strong>C<strong></a>&nbsp;<a href="/bbs/html/d/index.html" target="_blank"><strong>D<strong></a>&nbsp;<a href="/bbs/html/e/index.html" target="_blank"><strong>E<strong></a>&nbsp;<a href="/bbs/html/f/index.html" target="_blank"><strong>F<strong></a>&nbsp;<a href="/bbs/html/g/index.html" target="_blank"><strong>G<strong></a>&nbsp;<a href="/bbs/html/h/index.html" target="_blank"><strong>H<strong></a>&nbsp;<a href="/bbs/html/i/index.html" target="_blank"><strong>I<strong></a>&nbsp;<a href="/bbs/html/j/index.html" target="_blank"><strong>J<strong></a>&nbsp;<a href="/bbs/html/k/index.html" target="_blank"><strong>K<strong></a>&nbsp;<a href="/bbs/html/l/index.html" target="_blank"><strong>L<strong></a>&nbsp;<a href="/bbs/html/m/index.html" target="_blank"><strong>M<strong></a>&nbsp;<a href="/bbs/html/n/index.html" target="_blank"><strong>N<strong></a>&nbsp;<a href="/bbs/html/o/index.html" target="_blank"><strong>O<strong></a>&nbsp;<a href="/bbs/html/p/index.html" target="_blank"><strong>P<strong></a>&nbsp;<a href="/bbs/html/q/index.html" target="_blank"><strong>Q<strong></a>&nbsp;<a href="/bbs/html/r/index.html" target="_blank"><strong>R<strong></a>&nbsp;<a href="/bbs/html/s/index.html" target="_blank"><strong>S<strong></a>&nbsp;<a href="/bbs/html/t/index.html" target="_blank"><strong>T<strong></a>&nbsp;<a href="/bbs/html/u/index.html" target="_blank"><strong>U<strong></a>&nbsp;<a href="/bbs/html/v/index.html" target="_blank"><strong>V<strong></a>&nbsp;<a href="/bbs/html/w/index.html" target="_blank"><strong>W<strong></a>&nbsp;<a href="/bbs/html/x/index.html" target="_blank"><strong>X<strong></a>&nbsp;<a href="/bbs/html/y/index.html" target="_blank"><strong>Y<strong></a>&nbsp;<a href="/bbs/html/z/index.html" target="_blank"><strong>Z<strong></a>&nbsp;<a href="/bbs/html/otherchars/index.html" target="_blank"><strong>其它<strong></a>&nbsp;
//-->
</td></tr>
<tr><td colspan="3" align="center">
</td></tr>
</table>

</BODY>
</HTML>