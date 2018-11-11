<?php
//------------------------------
//create time:2005-12-4
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:XML文本论坛起始页
//------------------------------
if("小鱼" != $_COOKIE['username']){
	$html = "由于资源限制，本功能暂时关闭。";	
	exit($html);
}
$m_str_aid = isset($_GET["aid"])?$_GET["aid"]:"";
//$m_str_aid = "25";
$m_str_right = "/aboutfish/fishcountry/tools/liveroom/data/conf/xsl/board.php?id=1";
if("" != $m_str_aid){
	if(false !== ($str_dir = query_dir_from_id($m_str_aid))){
		$str_dir = "/aboutfish/fishcountry/data/classdata/articlebase/xmldata/".$str_dir;
		$m_str_right = $str_dir.$m_str_aid.".xml";
	}
}
function query_dir_from_id($id)
{
	//通过ID算出文章所有目录
	//$id是文章的ID
	//正常返回目录字符串，异常返回false
	$id = intval($id);
	if($id <= 0){
		return false;
	}
	$int_dir_pagenum = 2000;
	$result = strval((intval(($id-1)/$int_dir_pagenum)+1)*$int_dir_pagenum)."/";  //得到html文件当前目录
	return $result;
}
//echo $m_str_right;
//exit;
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312">
<title>妙文精选|www.mwjx.com</TITLE>
</head>
<BODY scroll=no style="MARGIN: 0px" oncontextmenu="return false" >
<IFRAME frameBorder=0 scrolling="?" id="real_content" src="<?php
echo $m_str_right;
?>" style="HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1"></IFRAME>
</body></html>
