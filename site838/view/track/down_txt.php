<?php
//------------------------------
//create time:2008-6-23
//creater:zll,liang_0735@21cn.com,book.mwjx.com
//purpose:�û�txtȫ������
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
//��ĿID
//��������:downtxt(�����ı�)/downhtml(����htmlȫ��)/readhtml(ȫ���Ķ�)
$m_downtype = trim(isset($_REQUEST["downtype"])?$_REQUEST["downtype"]:""); 
$m_ls = trim(isset($_REQUEST["id_ls"])?$_REQUEST["id_ls"]:""); 
$m_clist = ""; //����������Ŀ�б�
//$m_ls = "9,10,11,12"; //tests
//$m_downtype = "readhtml"; //tests
//goto_url("","aaa");
if("" == $m_ls){
	goto_url("","����ʧ�ܣ�����ѡ��Ҫ���ص��½�");
}
if("" == $_COOKIE['username'])
	goto_url("","����ʧ�ܣ����ȵ�¼");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if($obj_man->get_id() < 1)
	goto_url("","����ʧ�ܣ����ȵ�¼");
//���������б�
//$path = "../../data/up_book/0f27865ad2294bd43b21488e2775c94d.zip";
//exit("99");
$path = create_downpage($obj_man->get_id(),$m_ls,$m_downtype);
if("" == $path)
	goto_url("","����ʧ�ܣ����������ļ��쳣");
if("readhtml" == $m_downtype){ //ȫ���Ķ�
	echo "<script language=\"javascript\">";		
	echo "parent.window.location.href='".$path."';";
	echo "</script>";		
	exit();
}
//���ظ��û�
header("Content-type: application/download\r\n");
header("Content-length: ".filesize($path)."\r\n");
header("Content-disposition:attachment; filename=".substr($path,strrpos($path,"/")+1));
$result = readfile($path);
//exit($path.":".$m_ls);
exit();
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
$m_cd = new c_class_dir;
//����
//---------����Ⱥ----------
function create_downpage($uid=-1,$ls = "",$t="downtxt")
{
	//��������ҳ��
	//����:uid�û�ID,ls(string)����ID�б�
	//t(string)������������readhtml/downhtml/downtxt
	//���:ҳ��·��,�쳣���ؿ��ַ���
	//�ļ�������������Ϊ����ֱ�ӷ���·��
	//���û����ĿID,�õ�һƪ������ID
	$fname = md5($ls);
	$ctitle = "838����ı����أ�".$fname;
	if("" == $ctitle)
		return "";
	//�����б�
	$arr = explode(",",$ls);
	if(count($arr) < 1)
		return "";
	//var_dump($arr);
	//exit();
	my_safe_include("book/article.php");
	//��ַ·��
	$curl = "http://book.mwjx.com/udata/".$uid."/".$fname.".html";
	$dir = get_dir_home();
	$dir = $dir."../udata/".$uid."/";
	//$dir = "../../../data/up_book/";
	if(!file_exists($dir)){
		if(!mkdir($dir,0777))
			return "";
	}
	$path = $dir.$fname.".html";
	if("downtxt" == $t){
		$path = $dir.$fname.".txt";
		$curl = "http://book.mwjx.com/udata/".$uid."/".$fname.".txt";	
	}
	//����
	$head = "";
	$txt = "";
	$len = count($arr);
	if($len > 1000)
		$len = 1000;
	$head .= "<div id=\"title_index\"><ul>";
	//exit("88888");
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]);
		$obj = new c_article($id,"Y"); 
		if($obj->get_id() < 1)
			continue;
		$title = $obj->get_title();
		$url = $obj->get_url_dynamic($id,1);
		$url = G_DOMAIN.$url;
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
		//$txt .= $content."<a href=\"".$url."\">����...</a>";		
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
//336x280, ������ 07-12-26
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
<title>".$ctitle."|�������ڣ�".$d."|book.mwjx.com</title>
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
<BODY style=\"margin:10px 10px 10px 24px;\">
<a href=\"".$curl."\"><h1>���ء�".$ctitle."��</h1></a>��ҳ������
".$d.",Ҳ���и����½ڷ������뷵��<a href=\"".$curl."\">".$ctitle."</a>�鿴�����½�".$head."<br/><br/>".$txt."<br/><script type=\"text/javascript\" language=\"javascript1.2\" src=\"http://send.ivansms.com/ebook/Booksms/LFbookTag.php?publisher=mwjx&owner=ivansms\"></script>
	<br/><div style=\"width:500px;display:block;\">����ʱ�䣺".$d."<br/><a href=\"http://book.mwjx.com/\">����838���</a>
<script type=\"text/javascript\" src=\"http://fishcounter.3322.org/script/md5.js\"></script>
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
document.write('<a href=\"http://fishcounter.3322.org/data/xml_data.php?uid=1&type=page_detail&hpg='+hex_md5(escape(c_page))+'\" target=\"_blank\"><img src=\"http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'\" title=\"��������ͳ��\" border=\"0\"/></a>');
</script>
<noscript>
<a href=\"http://fishcounter.3322.org/index.php?uid=1\" target=\"_blank\"><img alt=\"��������ͳ��\" src=\"http://fishcounter.3322.org:8086/fc_1_1.gif\" border=\"0\" /></a>
</noscript></div></BODY>
</html>
";
	writetofile($path,$html);
	return $path;
}

function goto_url($url = "",$str = "",$flag=1)
{
	//��תҳ��
	//����:url��Ϊ����ת���õ�ַ,ֵrefreshˢ�µ�ǰ����,
	//str��Ϊ����ʾ����Ϣ
	//flag(int)1/2(������/��ǰ����)
	//���:��
	//����Ҫ��exit���
	if("" != $str)
		$str = "alert(\"".$str."\");";
	$window = "window.parent";
	if(2 == $flag)
		$window = "window";
	if("" != $url){
		if("refresh" == $url)
			$url = $window.".location.reload();";
		else
			$url = $window.".location.href=\"".$url."\";";
	}
	exit("<script language=\"javascript\">
".$str.$url."
</script>");
}
?>
