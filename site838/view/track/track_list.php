<?php
include("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");

//var_dump($m_arr);
//exit();
//-------------����Ⱥ-----------
function html_list()
{
	$arr = novels(); //С˵�б�
	$arr_char = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","����");
	$html = "<DIV id=\"charlines\">";
	$nowdte = date("Y-m-d",time());
	$count = 0;
	$domain = "http://book.mwjx.com";
	foreach($arr_char as $c){
		$bigc = strtoupper($c);
		$url_char = $domain."/html/".$c.".html";
		if("����" == $c)
			$url_char = $domain."/html/xx.html";
		$img = "<a href=\"".$url_char."\"><img src=\"../images/track/".$c.".jpg\"/></a>";
		if("����" == $c)
			$img = "����";
		$html .= "<DL><DT>".$img."</DT><DD>";
		if(isset($arr[$c])){
			$html .= "<UL>";
			$len = count($arr[$c]);
			for($i = 0;$i < $len; ++$i){
				++$count;
				if($i > 9)
					continue;
				$last = $arr[$c][$i][2];
				$t = strtotime($last);
				$dte=(date("Y-m-d",$t));
				//continue;
				//exit();
				//var_dump($nowdte);
				//exit();
				//$dte = date("Y-m-d",$t);
				$cc = "li_normal";
				if($nowdte == $dte)
					$cc = "li_red";
				//$url = "http://www.mwjx.com/data/".$arr[$c][$i][0].".html";
				$url = "http://www.fish838.com/site838/view/track/index.php?id=".$arr[$c][$i][0]."";
				$html .= "<LI class=\"".$cc."\" title=\"����ʱ�䣺".$last."\"><a href=\"".$url."\" target=\"_blank\">".$arr[$c][$i][1]."</a>&nbsp;".$dte."</LI>";
			}
			$cc = "li_red";
			$html .= "<LI class=\"".$cc."\" title=\"����\"><a href=\"".$url_char."\" target=\"_blank\">����...</a></LI>";
			$html .= "</UL>";
		}
		$html .= "</DD></DL>\n";
	}
	$html .= "</DIV>";
	$html = "Ŀǰ����С˵���¡�<b>".$count."</b>����<br/>".$html;
	return $html;
}
function novels()
{
	//װ�ؾ�����
	//����:��
	//���:��
	//$str_sql = "select DISTINCT C.id,C.name,C.last from update_track U left join class_info C on U.cid = C.id;";
	$str_sql = "select id,name,last from class_info order by last desc;";

	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	my_safe_include("class_c2e.php");
	$obj_c2ebase = new c2ebase();
	$arr = tear_arr_bychar($arr,$obj_c2ebase);
	//ksort($arr);
	return $arr;
}
function tear_arr_bychar(&$arr_list,&$obj_c2e)
{
	//��һ�������б����鰴����ĸ��ֳɶ������
	//����:arr_list��ԭ�����б�,array(array(id,title))
	//obj_c2e�Ǻ���ת��ĸ��
	//���:�������ز�ֺõĶ�ά���飬�쳣���ؿ�����
	//$i = 0;
	$result = array();
	foreach($arr_list as $arr_rc){
		//$str_title =  $arr_rc[1];
		if("" == $arr_rc[1])
			continue;
		$str_topchar = "";  //ͷ����
		$p=ord(substr($arr_rc[1],0,1));
		if($p > 160){
			$q=ord(substr($arr_rc[1],1,1));
			$p=$p*256+$q-65536;
		}
		//$str_topchar = "a";
		$str_topchar = $obj_c2e->single2e($p);
		$str_topchar = (strlen($str_topchar) > 1)?substr($str_topchar,0,1):$str_topchar;
		//if(("" == $str_topchar) || (ord($str_topchar) > 127)){
		//	continue;
		//}
		$str_topchar = strtolower($str_topchar);
		//var_dump(ord($str_topchar));
		//exit();
		if((ord($str_topchar) < 97) || (ord($str_topchar) > 122)){
			$str_topchar = "����";
		}

		//$int_count = count($result[$str_topchar]);
		$result[$str_topchar][] = $arr_rc;
		//$result[$str_topchar][$int_count][1] = $arr_rc[1];
		//$result[$str_topchar][$int_count][2] = $arr_rc[2];
		//$result[$str_topchar][$int_count][3] = $arr_rc[3];
		//$arr_index[$i][1] = $obj_c2ebase->convert2e($arr_rc[1]); //convert2e("�й���");
		//$i++;
	}
	return $result;
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD><TITLE>��������С˵|��838��ǡ� - ������ɫ����С˵վ��|www.mwjx.com</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="838���" name="description"/>
<META content="С˵,838���,����,��Ĭ��Ц,����,��ʷ,www.fish838.com" name="keywords"/>
<META NAME="Author" CONTENT="mwjx,С��"/>
<STYLE type=text/css media=screen>
@import url("/site838/view/css/tb_1.css");
@import url("/site838/view/css/tb_2.css");
@import url("/site838/view/css/class_dir.css");
.li_normal{
	background-color:#FFFFFF;
}
.li_red{
	background-color:#FFB6C1;
}
#charlines{
	float:left;
	margin-left:10px;
	width:100%;
	overflow:hidden;
	/*height:100%;*/
	line-height:150%;
	/*height:192px;*/
}
#charlines dl {
	position:relative;
	margin:0;
	margin-top:2px;
	width:100%;
	line-height:150%;
	height:auto;
	overflow:hidden;
	/*background-color:red;*/
}
#charlines dl dt{
	margin:0 1px;
	padding-left:1px;
	width:35px;
	/*height:100%;
	line-height:20px;*/
	text-align:center;
	/*overflow:hidden;*/
	cursor:pointer;
	color:#797979;
	background:#fff -36px 0px;
}
#charlines dl dd {
	/*position:absolute;*/
	position:relative;
	top:-25px;
	left:37px;
	margin:0;
	padding:3px 8px;
	display:block;
	height:100%;
	width:100%;/**/
	/*overflow:auto;
	background-color:blue;*/
	/*background:#fff url(/mwjx/images/bussniess/fp_info_bk.gif) no-repeat -77px -20px;*/
}

#charlines dl dd ul li {
	float:left;
	margin-left:0px;
	position:relative;
	width:200px;
	height:18px;
	overflow:hidden;
	cursor:hand;
	/*background:#EEEEFF;*/
	padding:0px 0px 0px 8px;   border:1px solid #CCCCEE;
}
#charlines dl dd ul li a {color:#5A5A5A;}
#charlines dl dd ul li a:hover {color:#FF5500;}
/**/
</STYLE>
<META content="MSHTML 6.00.2900.2180" name=GENERATOR/>
<script language="javascript">
function check_confcode(str)
{
	//�����֤���Ƿ���д
	//����:str(string)��֤���������
	//���:true����,falseδ��д
	if("" == document.all[str].value){
		alert("����д��֤��");
		return false;
	}
	return true;
}
</script>
</HEAD><BODY class="W950 CurHome">
<DIV id=Head><A class=hidden href="http://www.mwjx.com/#Content">����������������</A> 
<DIV id=HeadTop>
<DIV id=Logo><A href="http://www.mwjx.com/" target="_top">
<img src="/site838/view/images/002.gif" width="240" height="62" alt="838��ǣ������ղر�����Ʒ" border="0"/></A> 
</DIV>
<script language="javascript" src="/site838/view/include/top_article.php"></script>
<script src="/online_back.php"></script>

<DIV id=HeadNavBar>
<UL>
  <LI id=AdvanceBox>
<form name="query" action="/" method="get" visable="false" target="_blank">
<input type="hidden" name="main" value="./src_php/data_class.php"/><input type="hidden" name="type" value="search"/><input type="hidden" name="page" value="1"/><input type="hidden" name="per" value="10"/><input type="hidden" name="show_type" value="dynamic"/><input type="hidden" name="cid" value="0"/><input  maxlength="12" size="20" name="str" type="text" value="��ʼȫ������"><input  type="submit" value="����">
</form>
  </LI></UL></DIV></DIV><!--end HeadTop//--><DIV id=QuickLinks>
<UL>
</UL></DIV><DIV id=ChannelMenu>
<UL id=ChannelMenuItems>
  <LI id="MenuHome_n"><A href="http://www.fish838.com/" 
  target=_top><SPAN>��ҳ</SPAN></A> </LI>
  <LI id=MenuMarket><A 
  href="http://www.fish838.com/" 
  target=_top><SPAN>�������</SPAN></A> </LI>
  <LI id=MenuMall><A 
  href="http://www.fish838.com/" 
  target=_top><SPAN>����һЦ</SPAN></A> </LI>
  <LI id=MenuSecondHand><A 
  href="http://www.fish838.com/" 
  target=_top><SPAN>��Ʒ�ղ�</SPAN></A> </LI>
  <LI id=MenuSale><A 
  href="http://www.fish838.com/" 
  target=_top><SPAN>�����ƻ�</SPAN></A> </LI>
  <LI id=MenuGlobal><A 
  href="http://www.fish838.com/" 
  target=_top><SPAN>����Ц��</SPAN></A> </LI>
  <LI id=MenuInfo>
  <UL>
    <LI id=MenuDigital><A 
    href="http://www.fish838.com/" 
    target=_top><SPAN>����ʱ��</SPAN></A> </LI>
</UL></LI></UL>

<DIV id=SearchBox>
<DIV id=SearchInnerBox>
<DIV id=SearchHome>
<DIV id=SearchForm>

<table border="0" align="center" width="100%" cellPadding="0" cellSpacing="0"><tr><td align="left">
<!-- SiteSearch mwjx -->
<form name="query" action="/index.html" method="get" target="_blank">
<table>
<tr><td align="left" valign="top"><table border="0" align="center" width="85%" width="100%" cellPadding="0" cellSpacing="0">
<tr>
<td align="right" valign="top"><img src="/site838/view/images/hot.gif"/>
</td>
<td align="right" valign="top">
<div id="hotkey2"><UL>
<LI><A href="/index.html" target="_blank"> ��Ĺ </A></LI>
<LI><A href="/index.html" target="_blank"> éɽ���� </A></LI>
<LI><A href="/index.html" target="_blank"> �������� </A></LI>
<LI><A href="/index.html" target="_blank"> �й� </A></LI></UL></div>
</td>
<td align="left" valign="top">
</td></tr></table></td><td nowrap="nowrap" valign="top" align="left" height="32">
<label for="sbi" style="display: none">�������������ִ�</label>
<input type="text" name="str" size="50" maxlength="255" value="" id="str"></input>
<label for="sbb" style="display: none">�ύ������</label>
<input type="submit" value="С˵ ����"></input>
		<input type="hidden" name="type" value="search"/>
		<input type="hidden" name="page" value="1"/>
		<input type="hidden" name="per" value="10"/>
		<input type="hidden" name="show_type" value="dynamic"/>
		<input type="hidden" name="cid" value="0"/>

</td></tr></table>
</form>
<!-- SiteSearch mwjx -->
</td></tr></table>

</DIV>
<DIV id=HotKeywords>
<UL>
  <LI class=B><A href="http://www.fish838.com/" 
  target=_blank>��������</A>�� </LI><LI><A href="http://www.fish838.com/" target="_blank"> ���� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> ë�� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> ���޼� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> �Ƕ� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> ���� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> ����ʦ���� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> ���� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> �ϴ� </A></LI>
  <LI><A href="http://www.fish838.com/" target="_blank"> �������� </A></LI>
<LI><A href="http://www.fish838.com/" target="_blank"> а����Ȼ </A></LI></UL></DIV></DIV></DIV></DIV><!-- End SearchBox --></DIV><!-- End ChannelMenu --></DIV>

<div id="title_ad" style="width:100%;height:60px;">
<table width="908" border="0" cellPadding="0" cellSpacing="0" align="center" valign="top">
<tr height="60" align="center">
<td>
<table border="0"><tr>
<td width="100%" align="center" style="color:red;"><H1>��838���--��������С˵��</H1></td>
</tr></table>
</td>
</tr>
</table>
</div><!--end title_ad//-->

<DIV class=L250 id=Content><A name=main></A><DIV style="POSITION: relative"></DIV>

<?=html_list();?>




</DIV>



<DIV id=Foot><DIV style="MARGIN: 0px auto; WIDTH: 380px; FONT-FAMILY: arial">

<script type="text/javascript" src="http://fishcounter.3322.org/script/md5.js"></script>
<script language="JavaScript" type="text/javascript">
//----------�ͻ���Ωһ����----------
var cookieString = new String(document.cookie);
var cookieHeader = "fc_uniqid=" ;
var beginPosition = cookieString.indexOf(cookieHeader) ;
var sFc_uniqid = "";
if (beginPosition == -1){  //û��cookie,��ֲ
	sFc_uniqid = Math.round(Math.random() * 2147483647);
	document.cookie = cookieHeader+sFc_uniqid+";expires=Sun, 18 Jan 2038 00:00:00 GMT;"+"path=/";
}
else{
	var pos_end = cookieString.indexOf(";",beginPosition);
	var pos_start = beginPosition+cookieHeader.length;
	if(-1 != pos_end){
		sFc_uniqid = cookieString.substr(pos_start,(pos_end - pos_start));
	}
}
//--------end Ωһ����-------------------
var fromr = top.document.referrer;
fromr = ((fromr=="")?document.referrer:fromr);
var c_page=top.location.href;
c_page = (c_page ==""? location.href : c_page);
var query = 'c_page=' + escape(c_page) + '&amp;refer1=' + escape(fromr) + '&amp;c_screen=' + screen.width+ 'x'+screen.height+'&amp;fc_uniqid='+sFc_uniqid;
document.write('<a href="http://fishcounter.3322.org/data/xml_data.php?uid=1&type=page_detail&hpg='+hex_md5(escape(c_page))+'" target="_blank"><img src="http://fishcounter.3322.org:8086/fc_1_1.gif?'+query+'" title="��������ͳ��" border="0"/>��ҳ����</a>');
</script>
<noscript>
<a href="http://fishcounter.3322.org/index.php?uid=1" target="_blank"><img alt="��������ͳ��" src="http://fishcounter.3322.org:8086/fc_1_1.gif" border="0" /></a>
</noscript>
	
<noscript>
<a href="http://fishcounter.mwjx.com/index.php?uid=1" target="_blank"><img alt="&#x5e9f;&#x589f;&#x6d41;&#x91cf;&#x7edf;&#x8ba1;" src="http://fishcounter.mwjx.com:8086/fc_1_1.gif" border="0" /></a>
</noscript>Copyright 2002-2007, ��Ȩ���� mwjx.com<BR></DIV></DIV>
<!--//-->
<iframe name="submitframe" width="0" height="0" src="about:blank"></iframe></BODY></HTML>
