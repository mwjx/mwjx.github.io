<?php
//------------------------------
//create time:2006-12-29
//creator:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:我的家
//------------------------------
if("小鱼" != $_COOKIE['username']){
	$html = "由于资源限制，本功能暂时关闭。";	
	exit($html);
}
//-----------新版-----------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/mylibpage.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //用户ID
if(-1 == $m_id){ //我的妙文
	my_safe_include("class_man.php");
	$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
	$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
	$man_me = new manbase_2($currentuser,$currentpass);
	if($man_me->get_id() > 0)
		$m_id = $man_me->get_id();
}
$obj_hp = new c_mylibpage;
echo ($obj_hp->html_mylibpage($m_id)); //16
exit();
//---------end 新版---------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("lib/fun_global.php");
my_safe_include("mwjx/my_mwjx.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1); //用户ID
$m_name = (isset($_GET["name"])?$_GET["name"]:""); //用户名
$currentuser = isset($_COOKIE['username'])?$_COOKIE['username']:"";
$currentpass = isset($_COOKIE['userpass'])?$_COOKIE['userpass']:"";
//---------test---------
//$m_id = 200200068;
//$m_name = "小鱼";

$man_me = new manbase_2($currentuser,$currentpass);
if($m_id < 1)
	$aman = new manbase_2($m_name);
else
	$aman = new manbase_2($m_id);
if($aman->get_id() < 1)
	exit("用户无效:".$m_id."-".$m_name); 
//，<a href=\"../login.php\">登录</a>
//info_xml
$str_xml = "<?xml version=\"1.0\"  encoding=\"gb2312\"?>\n";
$xsl_path = "../include/xsl/myhome.xsl";
$str_xml .= "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
$str_xml .= "<myhome>";
$str_xml .= $aman->info_xml();
if($man_me->get_id() == $aman->get_id()){ //我的IP		
	$str_xml .= "<i_ip>".strval(ip2int($_SERVER[REMOTE_ADDR]))."</i_ip>";
}
if($man_me->get_id() == $aman->get_id()){ //我的消息列表
	$str_xml .= "<msglist/>";
}
//我的文章数
$obj = new c_my_mwjx;
$str_xml .= "<article_num>".strval($obj->article_num($aman->get_id()))."</article_num>";
$pv_num = get_my_pv($aman->get_name());
$str_xml .= "<my_pv>".(number_format($pv_num,0,".",","))."</my_pv>";
//最新文章
my_safe_include("mwjx/search.php");
//$flag = 0;
$obj_search = new c_search;
$arr = ($obj_search->user_article_arr($m_id,10));
$str_xml .= "<article_new>";
foreach($arr as $row){
	//</title>前空一格以防字符被吃掉，临时解决乱码方案，2007-7-4
	$id = intval($row[0]);	
	$url = "/mwjx/src_php/data_article.php?id=".strval($id);
	$url .= "&amp;state=dynamic";
	$str_xml .= "<item>\n<id>".$row[0]."</id>\n<title>".htmlspecialchars($row[1])." </title>\n<poster>".$row[2]."</poster>\n<dte>".$row[3]."</dte>\n<url>".$url."</url>\n</item>\n";
}		
$str_xml .= "</article_new>\n";

/*
*/
$str_xml .= "</myhome>";
print_xml($str_xml);

function get_my_pv($name="")
{
	//我的总页面访问数
	//输入:name(string)用户名
	//输出:整形
	//前置保证参数有效
	$str_sql = "select sum(int_click) as 'click' from tbl_article where str_poster = '".$name."' and enum_active = 'Y' and enum_father = 'Y';";
	//echo ($str_sql)."<br/>";
	$sql=new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	return intval($arr[0][0]);
}
?>