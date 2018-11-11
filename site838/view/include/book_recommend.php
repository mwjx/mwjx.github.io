<?php
//------------------------------
//create time:2008-4-25
//creater:zll
//purpose:站长推荐小说
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
$m_site = isset($_GET["site"])?$_GET["site"]:"fish838";
$cid = 77;		
$url_channel = "#";
$arr_cname = array(2=>array("幽默","Fashion","recommend_1.jpg"),3=>array("精品","Sports","recommend_2.jpg"),427=>array("军事","Digital","recommend_3.jpg"),114=>array("小说","Life","recommend_4.jpg"));				 
//-----------组织数据--------------
//array(cid=>array(tid,id,title)),tid:1/2(文章/类目)
$data = array();
$str_sql = "select I.fid,T.sid,I.name from class_tree T left join class_info I on T.sid = I.id where T.fid = '".$cid."' order by I.id desc limit 20;";		
$sql = new mysql("fish838");
$sql->query($str_sql);
$sql->close();
$arr_c = $sql->get_array_rows();		
//----------end 组织数据-----------
//形成字符串
$html = "";
$html .= "<DL>";
$len = count($arr_c);
$i = 0;
$count = 0;
foreach($arr_cname as $cid=>$vals){
	//$url_f = id2url_dynamic($cid,$m_site);
	$url_f = "#";
	$html .= "<DT class=\"".$vals[1]."\">".$vals[0]." </DT>";
	$html .= "<DD>";
	$html .= "<A href=\"".$url_f."\"  target=_blank><IMG alt=\"".$vals[0]."\" src=\"http://www.fish838.com/site838/view/images/index/".$vals[2]."\" width=\"44\" height=\"33\"></A>";
	$max = (($count+1)*2);
	for(;$i < $len; ++$i){
		$id = intval($arr_c[$i][1]);
		$title_more = $arr_c[$i][2];
		if(strlen($title_more) > 24)
			$title = msubstr($title_more,0,24)."...";
		else
			$title = $title_more;
		$url = id2url_dynamic($id,$m_site);
		$html .= "<A href=\"".$url."\"   target=_blank title=\"".$title_more."\">".$title."</A>";
		if(0 == $i%2)
			$html .= "<BR/>";
		if(($i+1) >= $max){
			++$i;
			break;
		}
	}/**/
	$html .= "</DD>"; 		
	++$count;
}
$html .= "</DL>";
/**/
$html .= "<P>";
for(;$i < $len; ++$i){
	$id = intval($arr_c[$i][1]);
	$title_more = $arr_c[$i][2];
	//$click = intval($arr_a[$i][2]);
	if(strlen($title_more) > 12)
		$title = msubstr($title_more,0,12)."...";
	else
		$title = $title_more;
	$url = id2url_dynamic($id,$m_site);
	$html .= "&#149;<A href=\"".$url."\"   target=_blank title=\"".$title_more."\">".$title."</A>&nbsp;&nbsp;";

}
$html .= "</P>";
/**/
//形成字符串
$m_js = "";
$m_js .= "document.write('".$html."');\n";

echo $m_js;
exit();

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