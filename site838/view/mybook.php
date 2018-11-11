<?php
//------------------------------
//create time:2010-4-16
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:我的藏书
//------------------------------
require("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/mybook.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
my_safe_include("mwjx/track.php");

$m_id = intval(isset($_GET["id"])?$_GET["id"]:0); //藏书ID
$m_t = (isset($_GET["t"])?$_GET["t"]:""); //是否管理模式:m是
//$m_id = 4; //tests
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
$obj_mb = new c_mybook($m_id);
$m_mycid = $obj_mb->get_cid();
if($m_mycid > 0 && "m"!=$m_t){
	//header("Location:track/index.php?id=".$m_mycid);
	$url = "cache/cpage/".$m_mycid.".html";
	$dir = get_dir_root();
	//exit($url);
	if(file_exists($dir.$url)){
		header("Location:/".$url);
		exit();
	}
	if(init_book($m_mycid)) //已经初始过
		header("Location:/".$url);
//	else
//		header("Location:track/info.php?id=".$m_mycid."&mb=".$m_id);
	exit();
}
exit("藏书不存在");
function init_book($cid=-1)
{
	//初始新书
	//输入:cid类目
	//输出:true跳转/false不跳转
	//var_dump($cid);
	//exit();
	$sql = new mysql;
	if(had_init($sql,$cid)){
		//exit("had");
		$sql->close();
		return true;
	}
	//exit("none");
	//取来源列表
	$str_sql = "select NL.id,NL.sou,NL.val from novels N inner join novels_links NL on N.id=NL.novels where N.cid=".$cid.";";
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$len = count($arr);
	echo "=>-----------开始读取本书".$len."个来源-----------<br/>\r\n";
	flush();
	$count = 0;
	for($i=0;$i<$len;++$i){
		++$count;
		echo "=>".$count."。开始读取第".$count."个来源，请稍侯...<br/>\r\n";
		flush();
		$nlid = intval($arr[$i][0]);
		$site = intval($arr[$i][1]);
		if(deal_sou($sql,$nlid,$site,$arr[$i][2]))
			echo "来源".$site."读取成功。<br/>\r\n";
		else
			echo "来源".$site."读取失败。<br/>\r\n";
		flush();
		set_time_limit(360);
	}
	$sql->close();
//	echo "=>２。开始读取第２个来源，请稍侯...<br/>\r\n";
//	echo "第２个来源读取完成。<br/>\r\n";
	echo "=>-----------新书初始完成，<a href=\"/cache/cpage/".$cid.".html\">打开本书</a>-----------<br/>\r\n";
	flush();
	return false;
}
function had_init(&$osql,$cid=-1)
{
	//新书是否已经初始
	//输入:osql数据库,cid类目
	//输出:true/false
	//$str_sql = "select TS.* from track_section TS inner join novels_links NL on TS.tid=NL.id where NL.novels=".$cid." limit 1;";
	$str_sql = "select TS.* from track_section TS inner join novels_links NL on TS.tid=NL.id inner join novels N on NL.novels=N.id where N.cid=".$cid." limit 1;";
	//exit($str_sql);
	$osql->query($str_sql);
	return ($osql->get_num_rows()>0);
}
function deal_sou(&$osql,$sid=-1,$site=-1,$val="")
{
	//处理一个来源索引
	//输入:osql数据库,sid来源链接ID,site站点,val索引地址关键值
	//输出:true/false
	//echo $site.":".$val."<br/>";
	//var_dump($arr_t);
	//var_dump(effective_url($arr_t,"http://me.qidian.com/BookCase/2/1","我的书架"));
	//return false;
	$url = val2url($site,$val);
	if(false===($arr_u = parseurl($url)))
		return false; //析出原始url失败
	if(!($txt=readurl($url)))
		return false; //下载失败
	$arr_t = array(); //规则[[t,val]]
	load_rules($osql,$site,$arr_t);
	$utf8 = is_utf8($arr_t); //是否utf8编码
	//提取链接
	preg_match_all("|<a.*?href=\s*?[\"'](.*?)[\"'].*?>(.*?)<\/a>|is",$txt,$out);

	//var_dump($out);
	$len = count($out[1]);
	$count = 0;
	$str_sql = "";
	$url_key = array(); //url是否存在,url=>true
	for($i=0;$i < $len;++$i){
		$title = $out[2][$i];
		$url = $out[1][$i];
		if(""==$title || ""==$url)
			continue;
		if(!effective_url($arr_t,$url,$title))
			continue; //不合格
		if(false===($url=smart_url($arr_u,$url)))
			continue; //组合网址失败
		if(isset($url_key[$url])){
			echo "章节重复:".$title."<br/>\r\n";
			continue;
		}
		$url_key[$url] = true;
		//echo $title.":".$url."<br/>\r\n";
		//加入数据库
		if(""!=$str_sql)
			$str_sql .= ",";
		$str_sql .= ("('".$sid."','");
		//如果标题是utf8,转为gb
		if($utf8)
			$title = iconv('UTF-8','GB2312//IGNORE',$title);
		$str_sql .= (addslashes($title)."','".$url."')");
	}
	//return true;
	if("" ==$str_sql)
		return true;
	$str_sql = ("insert into track_section (tid,title,url)values".$str_sql.";");
	//echo $str_sql."<br/>";
	$osql->query($str_sql);
	return true;
}
function is_utf8(&$arrt)
{
	//是否utf8
	//输入:arrt规则
	//输出:true/false
	for($i=0;$i < $len;++$i){
		if(14!=$arrt[$i][0])
			continue;
		if("utf8" == $arrt[$i][1])
			return true;
		return false;
	}
	return false;
}
function smart_url(&$arru,$val="")
{
	//智能组合绝对url
	//输入:arru先天条件,val初步网址
	//输出:网址/false
	if(strlen($val) < 1)
		return false;
	if("#" == $val)
		return false;
	$f = substr($val,0,1);
	if('/' == $f) //根目录
		$ph = $arru[0].$val;
	else if("http" == substr($val,0,4)) //绝对地址
		$ph = $val;
	else //相对目录
		$ph = $arru[1].$val;
	return $ph;
}
function parseurl($url = "")
{
	//析出url
	//输入:url原始网址
	//输出:[dm,root]/false
	$matches = parse_url($url);
	$path = $matches['path'] ? $matches['path'].(isset($matches['query']) ? '?'.$matches['query'] : '') : '/';
	$pos = strrpos($path,'/');
	if(false===$pos)
		return false;
	$dir = substr($path,0,$pos+1);
	$root = $matches['scheme']."://".$matches['host'].$dir;
	$dm = $matches['scheme']."://".$matches['host'];
	return array($dm,$root);
}
function effective_url(&$arrt,$url="",$title="")
{
	//是否有效列表页
	//输入:arrt站点规则,要检查的url,title标题
	//输出:true有效，false无效
	//cerr << "url:" << url << endl;
	//cerr << "count 5:" << mp_us.count(5) << ":" << site << endl;
	if(($len=count($arrt)) < 1){
		//cerr << "无条件" << endl;
		return true; //无过滤
	}
	for($i=0;$i < $len;++$i){
		$t = $arrt[$i][0];
		$val = $arrt[$i][1];
		//cerr << "t=" << t << endl;
		switch($t){
			case 1:	  //url存在
				if(false !== strpos($url,$val)){
					//cerr << "pass,val:" << val << endl;
					return false;
				}
				break;
			case 2:	  //url不存在
				if(false === strpos($url,$val))
					return false;
				break;
			case 7:	  //title存在
				if(false !== strpos($title,$val))
					return false;
				break;
			case 8:	  //title不存在
				if(false === strpos($title,$val))
					return false;
				break;
			case 9:	  //title长度小于
				if(strlen($title) < intval($val))
					return false;
				break;
			case 10: //title长度大于
				if(strlen($title) > intval($val))
					return false;
				break;
			default:
				break;
			
		}
	}
	return true;
}

function load_rules(&$osql,$site=-1,&$arrt)
{
	//装载规则
	//输入:osql数据库,site站点,arrt输出规则表[t=>val]
	//输出:无
	$str_sql = "select t,val from track_pass  where site = '".$site."';";
	$osql->query($str_sql);
	while($row=$osql->fetch_array()){
		$t = intval($row["t"]);
		$arrt[] = array($t,$row["val"]);
	}
}
//关联类目
if($m_id > 0 && $m_mycid < 1)
	$obj_mb->auto_link($m_id,$obj_man->get_id());
$m_kw = (isset($_GET["kw"])?$_GET["kw"]:""); //搜索关键词
$m_kw = $obj_mb->get_title();
$m_cid = -1;
$m_author = ""; //作者
$m_lists = html_class($m_kw);
$m_store = html_store($m_kw);
//$m_id = 1; //tests

function js_track_domain()
{
	//来源域名标志
	//输入:无
	//输出:html字符串
	global $m_id;
	global $m_mycid;
	$js = "<script language=\"javascript\">\n";
	$js .= "var m_id = ".$m_id.";\n";
	$js .= "var m_cid = ".$m_mycid.";\n";
	$js .= "var m_arr_td = Array();\n";
	$arr = arr_track_domain();
	$ls = "";
	foreach($arr as $key=>$row){
		$ls = "";
		$len = count($row);
		for($i = 0;$i < $len; ++$i){
			if("" != $ls)
				$ls .= ",";
			$ls .= "'".$row[$i]."'";
		}
		$js .= "m_arr_td['".$key."']=Array(".$ls.");\n";
	}
	$js .= "</script>\n";
	return $js;
}
function html_sonclass()
{
	//评剑科幻子类目
	//输入:无
	//输出:html字符串
	$novels = new c_class_info(4); //评剑科幻
	$arr_tmp = $novels->get_son_link();
	$ls = "<div id=\"div_slbrand\" style=\"display:block;\"><ul>";
	foreach($arr_tmp as $row){
		$obj = new c_class_info(intval($row[0]));
		$arr = $obj->get_son_link();
		if(count($arr) < 1)
			continue;
		$id= $row[0];
		$name= $row[1];
		$ls .= "<li onclick=\"javascript:chk_fid('".$id."','".$name."');\"><span>".$name."</span></li>";
	}
	$ls .= "</ul></div>";
	return $ls;
}
function html_flag()
{
	//书目列表
	//输入:无
	//输出:html字符串
	$arr = arr_track_flag(); //flag=>title

	$html = "";
	$html .= "<select name=\"flag_id\">";
	$len = count($arr);
	$html .= "<option value=\"-1\">请选择</option>";
	foreach($arr as $flag=>$title){
		$html .= "<option value=\"".$flag."\">".$title."</option>";
	}
	$html .= "</select>";
	return $html;
}
function html_store($kw="")
{
	//搜索小说
	//输入:kw(string)搜索关键词
	//输出:html字符串
	global $m_cid;
	global $m_author;
	//已有来源
	$arr = array();
	if("" != $kw){
		//$str_sql = "select id,name,memo from class_info where name like '%".$kw."%';";
		$str_sql = "select id,name,memo from class_info where name = '".$kw."';";
		//exit($str_sql);
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	$len = count($arr);
	if($len > 0){
		$ls = "";
		for($i = 0;$i < $len; ++$i){
			if("" != $ls)
				$ls .= ",";
			$ls .= $arr[$i]["id"];
		}
		$arr_track = arr_track_flag(); //flag=>title
		$str_sql = "select * from update_track  where cid in (".$ls.");";
		//exit($str_sql);
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	else{
		$arr = array();
	}
	//var_dump($arr);
	//exit();
	$html = "";
	$js = "";
	//$js = "<script language=\"javascript\">\n";
	//$js .= "var m_arr_author = Array();\n";
	$html .= "已有来源：<select name=\"exists_track\" style=\"width:400px;\" SIZE=\"4\" MULTIPLE onchange=\"javascript:ck_exists();\">";
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i]["id"];
		$cid = $arr[$i]["cid"];
		$site = intval($arr[$i]["flag"]);
		$title = $cid.":".$arr_track[$site];
		$url = $arr[$i]["url"];
		//if($m_cid < 1){
		//	$m_cid = intval($id);
		//	$m_author = $arr[$i][2];
		//}
		//$title = $arr[$i][1];
		//$js .= "m_arr_author['".$id."'] = '".$arr[$i][2]."';\n";
		$html .= "<option value=\"".$url."\" id=\"".$id."\" site=\"".$site."\">".$title."</option>";
	}
	$html .= "</select>";	
	$html .= "<br/>";
	//搜索结果		
	$arr = array();
	if("" != $kw){
		$str_sql = "select N.id,N.title,NL.sou,NL.val from novels N left join novels_links NL on N.id=NL.novels where N.title like '%".$kw."%' limit 512;";
		//$str_sql = "select N.id,N.title,NL.sou,NL.val from novels N left join novels_links NL on N.id=NL.novels where N.title = '".$kw."';";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	//var_dump($arr);
	//exit();
	//$html = "";
	$js = "";
	//$js = "<script language=\"javascript\">\n";
	//$js .= "var m_arr_author = Array();\n";
	$html .= "搜索结果：<select name=\"store_name\" style=\"width:400px;\" SIZE=\"4\" MULTIPLE onchange=\"javascript:ck_store();\">";
	$arr_flag = arr_track_flag(); //flag=>title
	$len = count($arr);
	//$m_author = "aa:".$len;
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i][0];
		$site = intval($arr[$i]["sou"]);
		$val = $arr[$i]["val"];
		//if($m_cid < 1){
		//	$m_cid = intval($id);
		//	$m_author = $arr[$i][2];
		//}
		//if(0 == $i)
		//	$m_author = $arr[$i][4];
		$title = $arr[$i][1];
		if(isset($arr_flag[$site]))
			$title = "[".$arr_flag[$site]."]".$title;
		//$js .= "m_arr_author['".$id."'] = '".$arr[$i][2]."';\n";
		$html .= "<option value=\"".$val."\" id=\"".$site."\">".$title."</option>";
	}
	$html .= "</select>";
	//作者
	$str_sql = "select A.title from novels N left join author A on N.author=A.id where N.title = '".$kw."' limit 1;";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	if(count($arr) > 0)
		$m_author = $arr[0][0];
	/**/
	//$js .= "</script>\n";
	return $js.$html;
}
function html_class($kw="")
{
	//类目列表
	//输入:kw(string)搜索关键词
	//输出:html字符串
	global $m_cid;
	global $m_author;
	$arr = array();
	if("" != $kw){
		$str_sql = "select id,name,memo from class_info where name like '%".$kw."%' limit 999;";
		//$str_sql = "select id,name,memo from class_info where name ='".$kw."' limit 999;";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$arr = $sql->get_array_array();
		$sql->close();
	}
	$html = "";
	$js = "<script language=\"javascript\">\n";
	$js .= "var m_arr_author = Array();\n";
	$html .= "<select name=\"class_name\" style=\"width:200px;\" onchange=\"javascript:ck_cname();\">";
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i][0];
		if($m_cid < 1){
			$m_cid = intval($id);
			$m_author = $arr[$i][2];
		}
		$title = $arr[$i][1];
		$js .= "m_arr_author['".$id."'] = '".$arr[$i][2]."';\n";
		$html .= "<option value=\"".$id."\">".$title."</option>";
	}
	$html .= "</select>";
	$js .= "</script>\n";
	return $js.$html;

}
function get_cid($id = -1)
{
	//取得来源的类目ID
	//输入:id(int)来源ID
	//输出:类目ID整形，异常返回-1
	$str_sql = "select cid from update_track where id='".$id."';";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	if(1 != count($arr))
		return -1;
	return intval($arr[0][0]);
}


function arr_sou()
{
	//来源数组
	//输入:无
	//输出:数组，格式：cid=>array(array(id,title,url));
	$re = array();
	$str_sql = "select * from update_track;";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$id = intval($arr[$i]["id"]);
		$cid = intval($arr[$i]["cid"]);
		$title = $arr[$i]["title"];
		$url = $arr[$i]["url"];
		if(!isset($re[$cid]))
			$re[$cid] = array();
		$re[$cid][] = array($id,$title,$url);
	}
	return $re;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 添加来源 </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<style>
<!--
	a:link { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:visited { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:active { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #000000; font-weight: normal; text-decoration: none; }
	a:hover { font-family: Verdana, Arial, sans-serif; font-size: 12px; color: #FF0000; font-weight: normal; text-decoration: none; }

	#content {width:100%}

-->
</style>
<style>
a:link,a:visited,a:hover,a:active{color:#0000ff;cursor:hand;}body,table,div,ul,li{font-size:10px;margin:0px;padding:0px}body{font-family:arial,sans-serif;height:100%}

/*弹出浮层*/
.h2-note         {font-weight:bold;font-size:14px;LINE-HEIGHT:150%;padding:8px 8px 3px 8px; border-bottom:1px solid #CCCCEE;}
.note        {font-size: 12px;LINE-HEIGHT:130%;padding:6px 3px 3px 8px;}
.lh15 {LINE-HEIGHT:150%;}
.box-note   {LINE-HEIGHT:150%; padding:6px 8px 6px 8px;   border:1px solid #CCCCEE; background:#EEEEFF;}

#div_slbrand{
	float:left;
	margin-left:0px;
	width:100%;
	height:100%px;
	overflow:hidden;
	/*background-color:red;*/
}
#div_slbrand ul li{
	float:left;
	margin-left:0px;
	position:relative;
	width:125px;
	height:20px;
	overflow:hidden;
	cursor:hand;
	/*background:#EEEEFF;*/
	padding:0px 0px 0px 8px;   border:1px solid #CCCCEE;

}

</style>
<?=js_track_domain();?>
<script language="javascript" src="./include/script/xmldom.js"></script>
<script language="javascript" src="./script/val2url.php"></script>
<script language="javascript">
function go_search(str)
{
	//跳转页面查询
	//输入:str(string)查询关分键词
	//输出:无
	var url = "./track_add.php?kw="+str;
	document.location.href = url;
	//alert(str);
}
function change_url()
{
	//输入url自动识别来源
	//输入:url来源地址
	//输出:无
	//return;
	var url = window.clipboardData.getData("Text");
	//alert(url);
	//return;
	if("" == url)
		return;
	//return alert(m_arr_td);
	auto_site(url);
}
function auto_site(url)
{
	//根据url自动更新站点
	//输入:url来源路径
	//输出:无
	//return;
	try{
	var key = "";
	for(var sou in m_arr_td){
		if(null == m_arr_td[sou])
			continue;
		//alert(sou);
		for(var i = 0;i < m_arr_td[sou].length;++i){
			key = m_arr_td[sou][i];
			if(-1 != url.indexOf(key)){ //找到
				//alert("oo");
				//document.all["flag_id"].selectedIndex = parseInt(key,10);
				//alert(document.all["flag_id"]);
				var obj = document.all["flag_id"];
				//alert(typeof(obj.options[1].value));
				//alert(sou==obj.options[13].value);
				var j;
				for(j=0;j<obj.length;++j){
					if(sou != obj.options[j].value)
						continue;
					//alert(key);
					obj.options[j].selected = true;
					break;
				}
				return; 
			}
		}
		/**/
	}
	}
	catch(err){
		alert("auto_site"+err.message);
	}
}
function del_class()
{
	//删除类目
	//输入:无
	//输出:无
	var cid = parseInt(document.all["cid"].value,10);
	if(cid < 1)
		return alert("删除失败，类目ID无效");
	//return alert();
	var url = "./cmd.php?fun=del_class&id="+cid;
	var xmlDoc= new_xmldom();
	xmlDoc.async=false;
	xmlDoc.load(url);
	var nodes=xmlDoc.documentElement.childNodes
	return alert(nodes[0].text);
}
function up_url()
{
	//更新地址
	//输入:无
	//输出:无
	if("" == document.all["frm_action"]["id_ls"].value)
		return alert("更新失败，来源ID不能为空");
	if("" == document.all["frm_action"]["txt_url"].value)
		return alert("更新失败，来源URL不能为空");
	//return alert();
	document.all["frm_action"]["fun"].value = "save_trackurl";
	document.all["frm_action"].submit();
}
function add()
{
	//添加到类目
	//输入:无
	//输出:无
	var sou = parseInt(document.all["flag_id"].value,10);
	//return alert("添加到类目:"+typeof(sou));
	if("" == document.all["frm_action"]["cid"].value)
		return alert("添加失败，类目ID不能为空");
	if("" == document.all["frm_action"]["txt_url"].value)
		return alert("添加失败，来源URL不能为空");
	if(sou < 1)
		return alert("添加失败，来源无效："+sou);
	document.all["frm_action"]["fun"].value = "add_track";
	document.all["frm_action"].submit();
	//if(!window.confirm("是否需要将提交成功的文章设为已读？"))
	//	return;
	//reset_used();
}
function update_author()
{
	var cid = parseInt(document.all["frm_action"]["cid"].value,10);
	if(cid < 1)
		return alert("更新失败，类目ID不能为空");
	document.all["frm_action"]["fun"].value = "update_author";
	document.all["frm_action"].submit();
}
function link_mybook()
{
	//将类目关联到藏书
	//输入:无
	//输出:无
	var cid = parseInt(document.all["frm_action"]["cid"].value,10);
	if(cid < 1)
		return alert("关联失败，类目ID不能为空:"+cid);
	if(m_id < 1)
		return alert("关联失败，藏书ID不能为空:"+m_id);
	document.all["frm_action"]["fun"].value = "link_mybook";
	document.all["frm_action"]["content"].value = m_id;
	document.all["frm_action"].submit();
}
function rm_book()
{
	//删除当前藏书
	//输入:无
	//输出:无
	if(m_id < 1)
		return;
	document.all["frm_action"]["fun"].value = "rm_mybook";
	document.all["frm_action"]["content"].value = m_id;
	document.all["frm_action"].submit();
}
function init()
{
	//初始
	//输入:无
	//输出:无
	if(m_cid < 1)
		document.getElementById("btn_create").style.display = "block";
	else
		document.getElementById("btn_rmbook").style.display = "block";
	//alert("aaa");
}
function tests_dom()
{
	return;
	try{
	var obj = document.all["flag_id"];
	//alert(typeof(obj.options[1].value));
	//alert(sou==obj.options[13].value);
	var sou = 3;
	var j;
	for(j=0;j<obj.length;++j){
		if(sou != obj.options[j].value)
			continue;
		//alert(key);
		obj.options[j].selected = true;
		break;
	}
	}
	catch(err){
		alert(err.message);
	}
	return;
	//alert("tests_dom");
	var xmldoc = new_xmldom();
	if(false === xmldoc)
		return alert("创建xmldom对象失败");
	var url = "./cmd.php?fun=new_class&fid=0&name=aa";
	//var url = "../../fc_client/map/1.xml";
	//var url = "http://localhost/fc_client/map/1.xml";
	//url += "&cdir=Y"; //新建书目
	//alert(url);
	//return;
	xmldoc.async=false;
	xmldoc.load(url);
	//alert(xmldoc.documentElement);
	try{
//		if("ie" == m_agent)
//			str = xmldoc.documentElement.childNodes[0].nodeValue;
//		else
//			str = xmldoc.documentElement.childNodes[1].text;
		alert(xmldoc.documentElement.childNodes[0].nodeValue);
	}
	catch(err){
		alert("llk.js,loadmap,err:"+err.message);
	}
	//alert(str);
	//var arr = str.split("\n");
	//alert(arr);
}
function chk_fid(fid,fname)
{
	//选中一个父类目
	//输入:fid(string)父类目ID,fname(string)父类目名称
	//输出:无
	//alert(fid);
	var name = document.all["search_title"].value;
	if("" == fid)
		return alert("父类目ID无效");
	if("" == name)
		return alert("创建类目的名称为空，请在搜索框内填入类目名称");
	//alert(fid+":"+name);
	
	document.all["tbl_detail"].style.display = "none";
		
	if(!window.confirm("确认要在类目《"+fname+"》下创建子类目《"+name+"》吗？"))
		return alert("放弃创建");
	var xmldoc = new_xmldom();
	if(false === xmldoc)
		return alert("创建xmldom对象失败");
	var url = "./cmd.php?fun=new_class&fid="+fid+"&name="+name;
	//url += "&cdir=Y"; //新建书目
	//alert(url);
	//return;
	xmldoc.async=false;
	xmldoc.load(url);
	var str_confrim = "创建类目失败";
	//alert(xmldoc);
	if(null != xmldoc.documentElement.childNodes[0]){
		if(!document.all){ //firefox
			str_confrim = xmldoc.documentElement.childNodes[0].nodeValue;
		}
		else{
			str_confrim = xmldoc.documentElement.childNodes[0].text;
		}
	}
	alert(str_confrim);
	//window.location.reload();
	window.location.href="./mybook.php?id="+m_id+"&t=m";
	/**/
}
function ck_cname()
{
	//选中一个类目
	//输入:无
	//输出:无
	var obj = document.all["class_name"];
	var id = obj.options[obj.selectedIndex].value;
	document.all["cid"].value = id;
	var author = m_arr_author[id];
	document.all["txt_author"].value = author;
}
function rm_sou(tid)
{
	//删除一个来源
	//输入:tid(string)来源ID
	//输出:无
	//提交请求
	//return alert(tid);
	if(!window.confirm("本操作不可恢复，确认吗？"))
		return;
	document.all["frm_action"]["fun"].value = "rm_sou";
	document.all["frm_action"]["content"].value = tid;
	document.all["frm_action"].submit();
}
function ck_exists()
{
	//选中一个已有来源
	//return alert();
	var obj = document.all["exists_track"];
	var url = obj.options[obj.selectedIndex].value;
	var site = parseInt(obj.options[obj.selectedIndex].site,10);
	//alert(site);
	var sid = obj.options[obj.selectedIndex].id;
	document.all["id_ls"].value = sid;
	document.all["txt_url"].value = url;
	auto_site(url);
}
function ck_store()
{
	//选中一个搜索来源
	//输入:无
	//输出:无
	var obj = document.all["store_name"];
	var val = obj.options[obj.selectedIndex].value;
	//var site = parseInt(obj.options[obj.selectedIndex].id,10);
	var site = obj.options[obj.selectedIndex].id;
	//alert(site);
	//return;
	//alert(g_arr_v2u);
	//alert(g_arr_v2u[site]+":"+val);
	var url = "";
	url = val2url(site,val);
	//return;
	document.all["txt_url"].value = url;
	auto_site(url);
	//window.clipboardData.getData("Text",url);
	//window.clipboardData.getData("Url",url);
	
	//alert(window.clipboardData.getData("Text"));
	//change_url();
	//alert(url);
	//document.all["cid"].value = id;
	//var author = m_arr_author[id];
	//document.all["txt_author"].value = author;
}
</script>
</HEAD>

<BODY text="#000000" bgColor="#ffffff" onload="javascript:init();">
<?php
//echo $m_js;
//echo $m_htmltitle;
?>
<h2>1.藏书未创建，开始创建该书</h2>
<table border=0 cellspacing=0 cellpadding=0 style="width:100%;">
	<tr>
	<td style="width:30%;"></td>
		<td>
书名：<input type="text" name="search_title" size="15" value="<?=$m_kw;?>" disabled onclick="javascript:this.value='';"/>

		</td>
<td>
<!--<button onclick="javascript:tests_dom();" style="display:block;">tests</button>
//-->
<button id="btn_create" onclick="javascript:document.all['tbl_detail'].style.display = 'block';" style="display:none;">开始创建</button>
</td><td>
<button id="btn_rmbook" onclick="javascript:rm_book();" style="display:block;">删除本藏书</button>
</td>
	<td style="width:30%;"></td>
	</tr>
</table>
<div style="height:70px;width:100%;">说明：<br/>１.如果藏书未创建，请先点上面的“开始创建”按钮创建一本新书。<br/>２.新书创建成功后，就可以为新书选定一个来源网站，点“添加来源”按钮，新书的章节将会与来源网站自动同步。</div>
<!--功能表单//-->
<form method="POST" name="frm_action" action="./cmd.php" target="submitframe" accept-charset="GBK">
<table border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top">
类目ID：&nbsp;&nbsp;&nbsp;<input type="text" name="cid" size="8" value="<?=$m_cid;?>"/>&nbsp;&nbsp;&nbsp;
<?php
echo $m_lists;
?>
<button onclick="javascript:link_mybook();">类目关联到当前藏书</button>&nbsp;&nbsp;&nbsp;作者：<input type="text" name="txt_author" size="8" value="<?=$m_author;?>"/><button onclick="javascript:update_author();">更新作者</button>
<br/>
<h2>2.为本书选定下载来源网站</h2>(选定来源网站后，系统会为你从来源网站自动下载最新章节添加到藏书，来源网站可选择一个或更多)
<br/>
来源URL：<input type="text" name="txt_url" size="50" value="" onbeforepaste="javascript:change_url();"/>&nbsp;
<?php
echo html_flag();
?>
<br/>
</td>
	</tr>
	<tr>
		<td valign="top" align="center">
<button onclick="javascript:if(''==document.all['id_ls'].value){alert('请先在已有来源列表中选择一个来源');return false;}window.open('/site838/view/src_php/track_sou.php?sid='+document.all['id_ls'].value);return false;">打开来源</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(''==document.all['id_ls'].value){alert('请先在已有来源列表中选择一个来源');return false;}rm_sou(document.all['id_ls'].value);">删除来源</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(m_cid < 1){alert('删除失败，类目ID无效');return false;}del_class();">删除类目</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(''==document.all['txt_url'].value){alert('请先在来源URL中填写新的来源');return false;}up_url();">更改来源</button>
		&nbsp;&nbsp;
<button onclick="javascript:if(''==document.all['txt_url'].value){alert('请先选择一个已有来源');return false;}add();">添加来源</button>
<span style="width:100px;"></span>
		</td>
	</tr>
	<tr>
		<td valign="top">
<?php
echo $m_store;
?>
		</td>
	<tr>
		<td valign="top" id="td_empty">
		</td>
	</tr>
<table>

<input type="hidden" name="fun" value="add_track"/>
<input type="hidden" name="id_ls" value=""/>
<input type="hidden" name="clist" value=""/>
<input type="hidden" name="ref" value=""/>
<input type="hidden" name="content" value=""/>
</form>

<!--弹出浮层//-->
<table border="0" cellspacing="0" cellpadding="0" id="tbl_detail"  style="display:none;left:350px;width:430px;height:200px;top:0px;position:absolute;z-index:10;">
<tr><td valign=top class="box-note" id="td_detail">
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="h2-note"><img src="./images/icon_timealert32.gif" align=absmiddle>为本书选择一个所属类目</td><td><img style='cursor:hand;position:absolute;right:5px;top:5px;display:block' src="./images/cha.gif" onclick="javascript:this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';" alt="关闭"/></td></tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class=note align="center"><?=html_sonclass();?></td></tr></table>
<table width="100%" border="0" cellspacing="2" cellpadding="0"><tr><td class=note><span class=lh15></td></tr></table>


</td>
</tr>
</table>

<iframe name="submitframe" width="1" height="1"></iframe>
</BODY>
</HTML>
