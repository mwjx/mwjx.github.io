<?php
//------------------------------
//create time:2007-1-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��������
//------------------------------
require("../../class/function.inc.php");
//$_COOKIE['username'] = "";
if("С��" != $_COOKIE['username']){
	$m_id = intval(isset($_GET["id"])?$_GET["id"]:"");
	//$m_id = 1999;
	$dir = g_dir_from_id($m_id);
	$url = "/bbs/html/".$dir.$m_id.".html";
	//ϵͳά����...<br/>
	$html = ("��̬��ַֻ�޻�Ա���ʡ�<br/>���ľ�̬��ַ��<a href=\"".$url."\">".$url."</a><br/><a href=\"http://www.mwjx.com/\"><b>�������ľ�ѡ</b></a>");
	$html .= "<script type=\"text/javascript\">google_ad_client = \"pub-6913943958182517\";google_ad_slot = \"6043945310\";google_ad_width = 468;google_ad_height = 60;</script><script type=\"text/javascript\" src=\"http://pagead2.googlesyndication.com/pagead/show_ads.js\"></script>";
	$html .= "<script type=\"text/javascript\" src=\"http://fishcounter.3322.org/script/md5.js\"></script>
<script language=\"JavaScript\" type=\"text/javascript\">
//----------�ͻ���Ωһ����----------
var cookieString = new String(document.cookie);
var cookieHeader = \"fc_uniqid=\" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = \"\";
if (beginPosition == -1){  //û��cookie,��ֲ
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
//--------end Ωһ����-------------------
var fromr = top.document.referrer;
fromr = ((fromr==\"\")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==\"\"? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
document.write('<a href=\"http://fishcounter.3322.org/data/xml_data.php?uid=1&type=page_detail&hpg='+hex_md5(escape(c_page))+'\" target=\"_blank\"><img src=\"http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'\" title=\"��������ͳ��\" border=\"0\"/>��ҳ����</a>');
</script>
<noscript>
<a href=\"http://fishcounter.3322.org/index.php?uid=1\" target=\"_blank\"><img alt=\"��������ͳ��\" src=\"http://fishcounter.3322.org:8086/fc_1_1.gif\" border=\"0\" /></a>
</noscript>
	
<noscript>
<a href=\"http://fishcounter.mwjx.com/index.php?uid=1\" target=\"_blank\"><img alt=\"&#x5e9f;&#x589f;&#x6d41;&#x91cf;&#x7edf;&#x8ba1;\" src=\"http://fishcounter.mwjx.com:8086/fc_1_1.gif\" border=\"0\" /></a>
</noscript>";
	exit($html);
}
//-------------�°�-------------
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_article.php");
my_safe_include("mwjx/class_query.php");
my_safe_include("mwjx/vote_article.php");
$m_id = (isset($_GET["id"])?$_GET["id"]:"");
//$m_id = "5469"; //tests
$obj_article = new articlebase($m_id,"","Y"); 
if($obj_article->get_id() < 1)
	exit("���²�����");
//if(isset($_GET["edit"])) //ȫģʽ
$obj_article->bln_dynamic = true;
echo $obj_article->get_html();
//else
//	echo $obj_article->get_html_simple();
exit();
/*
*/
//����̫����Դ���ر�
/*
$obj_q = new c_class_query;
$m_id = intval($m_id);	
$star = $obj_article->get_star();
$vote = c_vote_article::vote_num($m_id);
$obj_article->bln_dynamic = true;
echo $obj_article->get_html($obj_q->article_class($m_id),$star,$vote);
exit();
*/
//------------end�°�-----------
/**/
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_article.php");
my_safe_include("lib/fun_global.php");
//my_safe_include("mwjx/class_query.php");
//my_safe_include("class_man.php");
//my_safe_include("mwjx/top_star.php");
$m_id = (isset($_GET["id"])?$_GET["id"]:"");
$m_cid = intval(isset($_GET["r_cid"])?$_GET["r_cid"]:12);
if($m_cid < 1)
	$m_cid = 12;
//$amonth = date("Y-m-00",time());
//exit($amonth);
//$m_id = "5469";
$obj_article = new articlebase($m_id,"","Y"); 
if($obj_article->get_id() < 1)
	exit("������Ч");
visit(intval($m_id)); //��¼����
//$obj_article->safe_write_xml_data();
//$obj_article->safe_write_xml_data("../../data/");
$obj_article->addclick();   //�ӵ��
//$obj_q = new c_class_query;
$m_id = intval($m_id);


/**/
/*
//---------------�����Ķ�--------------
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
$m_canread = false;
if(200200067 == $obj_man->get_id())
	$m_canread = true;
if(!$m_canread){
	if($obj_article->get_star() >= 3)
		$m_canread = true;
}
if(!$m_canread){
	$obj_ts = new c_top_star;
	$arr_ts = ($obj_ts->lists(3,0,2));
	$arr_upclass = $obj_q->article_class($m_id);
	$len = count($arr_upclass);
	for($i = 0;$i < $len; ++$i){
		$cid= intval($arr_upclass[$i][0]);
		if(isset($arr_ts[$cid])){
			$m_canread = true;
			break;
		}
	}
}
//var_dump($m_canread);
//exit();

if(!$m_canread)
	exit("���²�����");
//-------------end�����Ķ�-------------
*/
//$str_xml = ($obj_article->xml_data($m_cid,1,$obj_q->article_class($m_id)));
$str_xml = ($obj_article->xml_data($m_cid,1,NULL));
if("" == $str_xml)
	exit("����������");
print_xml($str_xml);		
//echo "aaa:".$m_id;
?>