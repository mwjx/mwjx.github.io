<?php
//------------------------------
//create time:2008-4-24
//creater:zll
//purpose:小说点击榜
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$m_site = isset($_GET["site"])?$_GET["site"]:"fish838";
$str_sql = "select A.cid,CI.name,sum(A.click) as num from article A left join class_info CI on A.cid = CI.id group by A.cid order by num DESC limit 15;";
//exit($str_sql);
$sql = new mysql("fish838");
$sql->query($str_sql);
$sql->close();
$arr = $sql->get_array_rows();
//var_dump($arr);
//exit();
//新书点击
$d = 7;
$e = date("Y-m-d",time());
$s = date("Y-m-d",(time()-86400*$d));
//$str_sql = "select CA.cid,CI.name,sum(A.int_click) as num from class_article CA inner join update_track UT on CA.cid = UT.cid left join tbl_article A on CA.aid=A.int_id left join class_info CI on CA.cid = CI.id where CI.id not in (1,2,3,4,6,7,427,426) and CI.last BETWEEN '".$s."' and '".$e."' group by CA.cid  order by num DESC limit 15;";
$str_sql = "select A.cid,CI.name,sum(A.click) as num from article A left join class_info CI on A.cid = CI.id where CI.last BETWEEN '".$s."' and '".$e."' group by A.cid  order by num DESC limit 15;";
//exit($str_sql);
$sql = new mysql("fish838");
$sql->query($str_sql);
$sql->close();
$arr2 = $sql->get_array_rows();
//var_dump($arr2);
//exit();

$m_js = "";
//$m_js .= "document.write('<DIV id=\"HeadTop_myalimama_list2\" style=\"BACKGROUND: #FFFFFF\"><UL><LI><SPAN style=\"COLOR: #FFFFFF\">| </SPAN><A href=\"http://www.fish838.com/\">首页</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN> 您好! <A href=\"/index.html?id=".$man_me->get_id()."\">".$man_me->get_name()."</A> [<A href=\"/site838/view/login.php?fun=logout\">退出</A>]</LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/src_php/msglist.php\" target=\"_blank\">短消息(".$man_me->newmsg_num().")</A> </A></LI><LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"/site838/view/src_php/msglist.php\" target=\"_blank\">事件(".$man_me->action_num().")</A> </A></LI></UL></DIV>');\n";

$html = "";
$html .= "<DIV class=deal-collect><UL class=deal-collect-menu><LI class=Selected><A href=\"#\"   target=_self onmouseover=\"javascript:this.parentNode.parentNode.parentNode.childNodes[1].style.display=\'block\';this.parentNode.parentNode.parentNode.childNodes[2].style.display=\'none\';this.parentNode.parentNode.childNodes[1].className=\'\';this.parentNode.className=\'Selected\';\">总点击</A> </LI><LI class=\'\'><A href=\"#\"   target=_self onmouseover=\"javascript:this.parentNode.parentNode.parentNode.childNodes[1].style.display=\'none\';this.parentNode.parentNode.parentNode.childNodes[2].style.display=\'block\';this.parentNode.parentNode.childNodes[0].className=\'\';this.parentNode.className=\'Selected\';\">新书点击</A> </LI></UL>";
$html .= "<DIV><UL class=SecondandCommend>";		
$count = 0;
$len = count($arr);
for($i = 0;$i < $len; ++$i){
	if(++$count > 14)
		break;
	$id = intval($arr[$i][0]);
	$title_more = $arr[$i][1];
	if(strlen($title_more) > 20)
		$title = msubstr($title_more,0,20)."...";
	else
		$title = $title_more;
	$num = intval($arr[$i][2]);
	//$num  = 5893534;
	if($count < 4)
		$title = "<SPAN class=H>".$title."</SPAN>";
	$num = number_format($num,0, ".", ",");
	$url = id2url_dynamic($id,$m_site);
	$html .= "<LI>[".$num."]<A href=\"".$url."\" target=_blank title=\"".$title_more."\">".$title."</A></LI>";
}
//$html .= "</UL></DIV>";
$html .= "</UL></DIV>";
//新书
$html .= "<DIV style=\"display:none;\"><UL class=SecondandCommend>";		
$count = 0;
$len = count($arr2);
for($i = 0;$i < $len; ++$i){
	if(++$count > 14)
		break;
	$id = intval($arr2[$i][0]);
	$title_more = $arr2[$i][1];
	if(strlen($title_more) > 20)
		$title = msubstr($title_more,0,20)."...";
	else
		$title = $title_more;
	$num = intval($arr2[$i][2]);
	//$num  = 5893534;
	if($count < 4)
		$title = "<SPAN class=H>".$title."</SPAN>";
	$num = number_format($num,0, ".", ",");
	$url = id2url_dynamic($id);
	$html .= "<LI>[".$num."]<A href=\"".$url."\" target=_blank title=\"".$title_more."\">".$title."</A></LI>";
}
//$html .= "</UL></DIV>";
$html .= "</UL></DIV>";
$html .= "</DIV>";

$m_js .= "document.write('".$html."');\n";
//<LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"http://mwjxhome.3322.org/fish/home.php\" target=_blank>废墟双城</A> </LI>
//<LI><SPAN style=\"COLOR: #cccccc\">| </SPAN><A href=\"#\" onclick=\"javascript:alert(\'聪明人无需帮助\');\">帮助？</A> </LI>
exit($m_js);

function id2url_dynamic($id=-1,$site="fish838")
{
	//得到地址
	//输入:id类目ID
	//输出:url字符串
	if("mwjx" == $site){
		return "http://book.mwjx.com/site838/view/track/index.php?id=".$id;
	}
	return "http://www.fish838.com/site838/view/track/index.php?id=".$id;
}
?>
