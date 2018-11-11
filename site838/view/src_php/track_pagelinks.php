<?php
//------------------------------
//create time:2008-1-29
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:预处理页面，提取分页链接
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
//header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
//header("Content-Type: text/html;charset=GBK");
//header("Content-Type: text/xml;charset=GBK");
$m_id = intval(isset($_GET["sid"])?$_GET["sid"]:-1);
//$m_id = 3; //tests
$path = "../../data/update_track/8/04665299bc884758d974dc712389dc04.html";
$content = readfromfile($path);
//var_dump(match_links($content));
//(pick_pagelinks($content));
//exit();
//exit(check_new($m_id)?"Y":"N");
function pick_pagelinks(&$str)
{
	//提取分页链接
	//输入:$str(string)页面内容
	//输出:url数组array(array(title,url))
/*
<table><tr><td>分页链接：[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1049300.shtml>首页</a>]&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1106915.shtml><font color=blue>[93]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1107135.shtml><font color=blue>[94]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1107477.shtml><font color=blue>[95]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1108012.shtml><font color=blue>[96]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1108395.shtml><font color=blue>[97]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1109018.shtml><font color=blue>[98]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1109428.shtml><font color=blue>[99]</font></a>&nbsp;<font color=black>[100]</font>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110047.shtml><font color=blue>[101]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110601.shtml><font color=blue>[102]</font></a>&nbsp;[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110047.shtml>下一页</a>]&nbsp;[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110601.shtml>末页</a>]&nbsp;[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110601.shtml>回复此帖</a>]&nbsp;</td></tr></table>
*/
	preg_match_all("|<table><tr><td>分页链接：(.*?)<\/td><\/tr><\/table>|s",$str,$out);
	//var_dump($out);
	//exit();
	$txt = $out[1][0];
	//exit($txt);

	$arr = match_links($txt);
	$re = array(); //url(md5)=>array(title,url)
	$len = count($arr["link"]);
	for($i = 0;$i < $len; ++$i){
		$url = trim($arr["link"][$i]);
		$title = trim(strip_tags($arr["content"][$i]));
		$md5 = md5($url);
		//echo $title.":".$url."<br/>";
		if(isset($re[$md5]))
			continue;
		echo $title.":<br/>".$url."<br/>";
		$re[$md5] = array($title,$url);
	}
	return $re;
}
function match_links($document)
{   
    preg_match_all("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</a>'isx",$document,$links);                       
    while(list($key,$val) = each($links[2])){
        if(!empty($val))
            $match['link'][] = $val;
    }
    while(list($key,$val) = each($links[3])){
        if(!empty($val))
            $match['link'][] = $val;
    }       
    while(list($key,$val) = each($links[4])){
        if(!empty($val))
            $match['content'][] = $val;
    }
    while(list($key,$val) = each($links[0])){
        if(!empty($val))
            $match['all'][] = $val;
    }               
    return$match;
}


function check_new($id = -1)
{
	//是否有新章节
	//输入:id(int)来源索引页ID
	//输出:true有新章节,false没有
	$str_sql = "select count(*) from track_section where tid='".$id."' and used='N';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	return intval($arr[0][0]) > 0;
	//return false;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 妙文精选|www.mwjx.com </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<script language="javascript">
function gopage()
{
	document.pageForm.pID.value=333;
	document.pageForm.submit();

}
</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" leftMargin="0" topMargin="0" marginheight="0" marginwidth="0">
<form name="pageForm" id="pageForm" action="http://cache.tianya.cn/techforum/content/16/603697.shtml#8478045" method="post">
<!--<input type="hidden" name="rs_strTitle_aa" value="[连载]惊悚灵异<font color=#FF6600><b>《青囊尸衣》</b></font>（斑竹推荐）">//-->
<input type="hidden" name="intLogo" value="0">
<input type="hidden" name="rs_permission" value="1">
<input type="hidden" name="apn" value="8478045,8504172,8513978,8522971,8532967,8540548,8546964,8553317,8559000,8564172,8568338,8571941,8574478,8578881,8582367,8585446,8588241,8590373,8592579,8595148,8597159,8599359,8601864,8604618,8606761,8608918,8610817,8612550,8614987,8616246,8617440,8619812,8621871,8623434,8625800,8627724,8630288,8633087,8635856,8638559,8641447,8644299,8646905,8649819,8652762,8655544,8657455,8659549,8661185,8663103,8664511,8666017,8668392,8669995,8672247,8674528,8676621,8678527,8680908,8682583,8685302,8687125,8689051,8691233,8693855,8695860,8697786,8699950,8701377,8702845,8704788,8706208,8707200,8708978,8709734,8710492,8712051,8712841,8714155,8715777,8717738,8719000,8720815,8722494,8724235,8725891,8727386,8729527,8731524,8733133,8734216,8736552,8738675,8741289,8743527,8745546,8747365,8749058,8750415,8751861,8753351,8754929,8756370,8757860,8758601,8759614,8760912,8762170,8763403,8764739,8765611,8766339,8767923,8769144,8770465,8771739,8772878,8773653,8775028,8776217,8777911,8779921,8780891,8782373,8784578,8785708,8787201,8789049,8790612,8792280,8794350,8795869,8797092,8799524,8801104,8802634,8804309,8805858,8807569,8809357,8810575,8812507,8814030,8815491,8816654,8818131,8819525,8820813,8822173,8822942,8824107,8824742,8825619,8826632,8828396,8830149,8831239,8832542,8833751,8835387,8837586,8839310,8840418,8841760,8842767,8844314,8846420,8847920,8849777,8851646,8853494,8855069,8856430,8858301,8859512,8861301,8862857,8864207,8865712,8867504,8869360,8870909,8872117,8873478,8875014,8876197,8877083,8878021,8878994,8880361,8881620,8882907,8884601,8886335,8887644,8889003,8889835,8890896,8892112,8893644,8895228,8897191,8899684,8900997,8902727,8904738,8905989,8907271,8908921,8910037,8911331,8912822,8914094,8916150,8917808,8919151,8920122,8921772,8923599,8925161,8926728,8927653,8928809,8930319,8931287,8932365,8933508,8934452,8935504,8937039,8938229,8939135,8940461,8941612,8942691,8943518,8944646,8945834,8946874,8947753,8948753,8949926,8951101,8951777,8953048,8954168,8955227,8956424,8957554,8958523,8960144,8961407,8962361,8963692,8964490,8965393,8966591,8967561,8968484,8969738,8970641,8971925,8972997,8974202,8975093,8976023,8977195,8977742,8979336,8980100,8981004,8982966,8983904,8985243,8986581,8987988,8988757,8989889,8990702,8991426,8993213,8993963,8994734,8996142,8996907,8998075,8999359,8999961,9000713,9002158,9002939,9003784,9004557,9005573,9006491,9008117,9009190,9009764,9010292,9010685,9011733,9013532,9015020,9015664,9016878,9018100,9019137,9020602,9021686,9022904,9024558,9026102,9027477,9029201,9029859,9030908,9032403,9033235,9034236,9036070,9037519,9038267,9040241,9041457,9042337,9044424,9045874,9047126,9048622,9050349,9051870,9053607,9055317,9056875,9058353">
<input type="hidden" name="pID" id="pID" value=''></form>
<button onclick="javascript:gopage();">gogo</button>
</BODY>
</HTML>
