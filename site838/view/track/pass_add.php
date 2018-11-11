<?php
//------------------------------
//create time:2008-5-7
//creater:zll,liang_0735@21cn.com
//purpose:章节过滤条件添加
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
my_safe_include("mwjx/track.php");

$m_site = intval(isset($_GET["site"])?$_GET["site"]:-1); //站点
$m_t = intval(isset($_GET["t"])?$_GET["t"]:-1); //类型
$m_arrflag = arr_track_flag(); //flag=>title
$m_lists = ""; //条件列表
$m_title = ""; //站点名称
if(isset($m_arrflag[$m_site])){ //搜索条件
	$m_title = $m_arrflag[$m_site];
	$m_lists = html_pass($m_site,$m_t);
}
//$m_cid = -1;
//$m_author = ""; //作者
//$m_id = 1; //tests

function js_track_domain()
{
	//来源域名标志
	//输入:无
	//输出:html字符串
	global $m_site;
	global $m_t;
	$js = "<script language=\"javascript\">\n";
	//$js .= "var m_arr_td = Array();\n";
	$js .= "var m_site = '".$m_site."';\n";
	$js .= "var m_t = '".$m_t."';\n";
	/*$arr = arr_track_domain();
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
	}*/
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
		$title = $flag.".".$title;
		$html .= "<option value=\"".$flag."\">".$title."</option>";
	}
	$html .= "</select>";
	return $html;
}
function html_pass($site=-1,$type = -1)
{
	//某站点条件列表
	//输入:site站点,type类型
	//输出:html字符串
	//数据
	$str_sql = "select * from track_pass where site='".$site."' order by id asc;";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	//形成字符串
	$html = "";
	$html .= "条件列表：<select name=\"st_passlists\" style=\"width:400px;\" SIZE=\"8\" MULTIPLE onchange=\"javascript:ck_store();\">\n";
	//$arr_flag = arr_track_flag(); //flag=>title
	$len = count($arr);
	//var_dump($arr);
	//exit();
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i]["id"];
		$site = intval($arr[$i]["site"]);
		$t = intval($arr[$i]["t"]);
		$val = $arr[$i]["val"];
		
		$title = $id.".[".$t."],".htmlspecialchars($val);
		$html .= "<option value=\"".htmlspecialchars($val)."\" id=\"".$id."\" t=\"".$t."\">".($title)."</option>\n";
	}
	$html .= "</select>";
	if($type < 1)
		return $html;
	$txt = "";
	for($i = 0;$i < $len; ++$i){
		$t = intval($arr[$i]["t"]);
		if($t != $type)
			continue;
		$id = $arr[$i]["id"];
		$site = intval($arr[$i]["site"]);
		$val = $arr[$i]["val"];
		if("" != $txt)
			$txt .= "\n";
		$txt .= htmlspecialchars($val);
		
		
		//$title = $id.".[".$t."],".htmlspecialchars($val);
		//$html .= "<option value=\"".htmlspecialchars($val)."\" id=\"".$id."\" t=\"".$t."\">".($title)."</option>\n";
	}
	$html .= "<br/>规则列表：<TEXTAREA STYLE=\"width:800px;height:130px;\" name=\"txt_rules\">";
	$html .= $txt;
	$html .= "</TEXTAREA><br/>";
	$html .= "调试文件：<input type=\"text\" name=\"txt_file\" size=\"50\" value=\"\"/><button onclick=\"javascript:debug();\">开始调试规则</button>&nbsp;&nbsp;文件形如:2/03bdc69e5c9a8980c2d386c1ab2a0f42.html";
	//var_dump($html);
	//exit();
	return $html;
}
function html_class($kw="")
{
	//类目列表
	//输入:kw(string)搜索关键词
	//输出:html字符串
	global $m_cid;
	global $m_author;
	$str_sql = "select id,name,memo from class_info where name like '%".$kw."%';";
	//exit($str_sql);
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	
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
	$sql = new mysql;
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
	$sql = new mysql;
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
<TITLE> 添加过滤条件 </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<META NAME="Author" CONTENT="mwjx">
<META NAME="Keywords" CONTENT="mwjx">
<link rel="icon" href="favicon.ico" type=""/>
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
a:link,a:visited,a:hover,a:active{color:#0000ff;cursor:hand;}body,table,div,ul,li{font-size:10px;margin:0px;padding:0px}body{background-color:;font-family:arial,sans-serif;height:100%}

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
<script language="javascript" src="../include/script/xmldom.js"></script>
<script language="javascript">
function go_search(str)
{
	//跳转页面查询
	//输入:str(string)查询关分键词
	//输出:无
	//return alert(str);
	var url = "./pass_add.php?site="+str;
	document.location.href = url;
	//alert(str);
}
function t_lists()
{
	//显示批量列表
	//输入:无
	//输出:无
	var t = parseInt(document.all["st_t"].value,10);
	if(t < 1)
		return alert("请选择类型");
	var url = "./pass_add.php?site="+m_site+"&t="+t;
	document.location.href = url;
	//alert(url);
}
function change_url()
{
	//输入url自动识别来源
	//输入:url来源地址
	//输出:无
	var url = window.clipboardData.getData("Text");
	//alert(url);
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
				var obj = document.all["flag_id"].options;
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
function commit_rules()
{
	//批量提交规则
	//输入:无
	//输出:无
	var site = parseInt(document.all["hd_site"].value,10);
	var t = parseInt(document.all["st_t"].value,10);
	if(site < 1)
		return alert("提交失败，站点无效");
	if(t < 1)
		return alert("提交失败，类型无效");
	//alert(site);
	document.all["frm_action"]["fun"].value = "commit_rules";
	document.all["frm_action"].submit();

}
function debug()
{
	//调试规则
	//输入:无
	//输出:无
	var url = "./rules_debug.php?site="+m_site;
	var t = parseInt(document.all["st_t"].value,10);
	var file = document.all["txt_file"].value;
	url += "&t="+t;
	url += "&file="+file;
	window.open(url);
}
function add()
{
	//添加条件
	//输入:无
	//输出:无
	var site = parseInt(document.all["hd_site"].value,10);
	var t = parseInt(document.all["st_t"].value,10);
	//return alert("添加到类目:"+typeof(sou));
	//if("" == document.all["frm_action"]["cid"].value)
	//	return alert("添加失败，类目ID不能为空");
	if("" == document.all["frm_action"]["txt_val"].value)
		return alert("添加失败，条件不能为空");
	if(site < 1)
		return alert("添加失败，站点无效："+site);
	if(t < 1)
		return alert("添加失败，类型无效："+t);
	document.all["frm_action"]["fun"].value = "add_pass";
	document.all["frm_action"].submit();
	//if(!window.confirm("是否需要将提交成功的文章设为已读？"))
	//	return;
	//reset_used();
}
function del()
{
	//删除条件
	//输入:无
	//输出:无
	var id = parseInt(document.all["hd_id"].value,10);
	if(id < 1)
		return alert("删除失败，ID无效："+id);
	document.all["frm_action"]["fun"].value = "del_pass";
	document.all["frm_action"].submit();
}
function rm_emptysou()
{
	//删除空来源
	//输入:无
	//输出:无
	//return alert();
	document.all["frm_action"]["fun"].value = "rm_emptysou";
	document.all["frm_action"].submit();
}
function create_static()
{
	//生成所有类目静态文件
	//输入:无
	//输出:无
	document.all["frm_action"]["fun"].value = "static_all";
	document.all["frm_action"].submit();
}
function add_sou(title,flag)
{
	//添加站点
	//输入:title名称,flag特征
	//输出:无
	//var id = parseInt(document.all["hd_id"].value,10);
	//if(id < 1)
	//	return alert("删除失败，ID无效："+id);
	if("" == title)
		return alert("名称不能为空");
	//return alert(title+":"+flag);
	document.all["frm_action"]["fun"].value = "add_sou";
	document.all["frm_action"]["hd_id"].value = title;
	document.all["frm_action"]["hd_site"].value = flag;
	document.all["frm_action"].submit();
}

function update_author()
{
	if("" == document.all["frm_action"]["cid"].value)
		return alert("更新失败，类目ID不能为空");
	document.all["frm_action"]["fun"].value = "update_author";
	document.all["frm_action"].submit();
}
function init()
{
	//初始
	//输入:无
	//输出:无
	//if(m_t < 1)
	//	return;
	var obj = document.all["st_t"];
	for(var i = 0;i < obj.options.length; ++i){
		if(m_t == obj.options[i].value){
			obj.options[i].selected = true;			
			break;
		}
	}
	var sites = document.all["flag_id"];
	for(var i = 0;i < sites.options.length; ++i){
		if(m_site == sites.options[i].value){
			sites.options[i].selected = true;			
			break;
		}
	}
	//alert("aaa");
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
	var url = "../cmd.php?fun=new_class&fid="+fid+"&name="+name;
	url += "&cdir=Y"; //新建书目
	xmldoc.async="false";
	xmldoc.load(url);
	var str_confrim = "创建类目失败";
	//alert(xmldoc.xml);
	if(null != xmldoc.documentElement.childNodes[0])
		str_confrim = xmldoc.documentElement.childNodes[0].text;
	alert(str_confrim);
	window.location.reload();
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
function ck_exists()
{
	var obj = document.all["exists_track"];
	var val = obj.options[obj.selectedIndex].value;
	alert(val);
}
function ck_store()
{
	//选中一个搜索来源
	//输入:无
	//输出:无
	var obj = document.all["st_passlists"];
	var id = obj.options[obj.selectedIndex].id;
	var t = obj.options[obj.selectedIndex].t;
	var val = obj.options[obj.selectedIndex].value;
	//var site = parseInt(obj.options[obj.selectedIndex].id,10);
	//alert(site+":"+val);
	var objt = document.all["st_t"];
	for(var i = 0;i < objt.options.length; ++i){
		if(t == objt.options[i].value){
			objt.options[i].selected = true;
			break;
		}
	}
	document.all["hd_id"].value = id;
	document.all["txt_val"].value = val;
	//auto_site(url);
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
echo $m_js;
//echo $m_htmltitle;
?>
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top" align="center">
管理：<button onclick="javascript:rm_emptysou();" title="删除没有类目的来源">删除空来源</button>
&nbsp;&nbsp;<button onclick="javascript:create_static();" title="插入所有类目的静态文件生成指令">所有类目静态</button>
<br/>

当前站点：<?=$m_title;?>&nbsp;&nbsp;
<?php
echo html_flag();
?>
&nbsp;<button onclick="javascript:go_search(flag_id.value);">搜索条件</button>	&nbsp;&nbsp;<!--&nbsp;&nbsp;<button onclick="javascript:	document.all['tbl_detail'].style.display = 'block';">创建类目</button>//-->	
名称：<input type="text" name="txt_soutitle" value="" size="12"/>&nbsp;&nbsp;
特征标识(若多个，|号分隔)：<input type="text" name="txt_souflag" value="" size="8"/>&nbsp;<button onclick="javascript:add_sou(txt_soutitle.value,txt_souflag.value);">添加站点</button>
<br/>
	
<br/><br/>
<?php
//echo $m_htmltitle;
?>

		</td>
	</tr>
</table>
<!--功能表单//-->
<form method="POST" name="frm_action" action="../cmd.php" target="submitframe" accept-charset="GBK">
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top">
类型：&nbsp;&nbsp;&nbsp;
<select name="st_t" onchange="javascript:hd_id.value='-1';">
<option value="-1">--选择过滤类型--</option>
<option value="1">1.★[章节]URL中存在跳过</option>
<option value="2">2.★[章节]URL中不存在跳过</option>
<!--<option value="5">5.[来源]URL中存在跳过</option>
<option value="6">6.[来源]URL中不存在跳过</option>
//-->
<option value="7">7.[章节]标题中存在跳过</option>
<option value="8">8.[章节]标题中不存在跳过</option>
<option value="9">9.[章节]标题长度小于跳过</option>
<option value="10">10.[章节]标题长度大于跳过</option>
<option value="11">11.★[章节]标题规则</option>
<option value="12">12.★[章节]内容规则</option>
<option value="13">13.[章节]作者规则</option>
<option value="14">14.[章节]编码:utf8,gb2312</option>
<option value="15">15.[章节]索引地址规则:前部`|后部</option>

<option value="21">21.★[搜索]列表起始页</option>
<option value="22">22.[搜索]列表打开方式get(默认不写)/post</option>
<option value="23">23.★[搜索]URL中存在跳过</option>
<option value="24">24.★[搜索]URL中不存在跳过</option>
<option value="25">25.[搜索]标题找到跳过</option>
<option value="26">26.[搜索]标题找不到跳过</option>
<option value="27">27.★[搜索]提取搜索源列表</option>
<option value="28">28.★[搜索]提取搜索源记录</option>
<option value="29">29.[搜索]去掉URL中的参数</option>
<option value="41">41.[新书]列表起始页</option>
<option value="42">42.[新书]列表打开方式get(默认不写)/post</option>
<option value="43">43.[新书]URL中存在跳过</option>
<option value="44">44.[新书]URL中不存在跳过</option>
<option value="45">45.[新书]标题找到跳过</option>
<option value="46">46.[新书]标题找不到跳过</option>
<option value="47">47.[新书]提取搜索源列表</option>
<option value="48">48.[新书]提取搜索源记录</option>
<option value="49">49.[新书]去掉URL中的参数</option>
</select>
&nbsp;&nbsp;&nbsp;

&nbsp;&nbsp;&nbsp;
条件：<input type="text" name="txt_val" size="50" value=""/>&nbsp;

<br/>
</td>
	</tr>
	<tr>
		<td valign="top" align="center">
<button onclick="javascript:del();">删除条件</button>
&nbsp;&nbsp;
<button onclick="javascript:add();">保存条件</button>
&nbsp;&nbsp;
<button onclick="javascript:t_lists();">批量列表</button>
&nbsp;&nbsp;
<button onclick="javascript:commit_rules();">批量提交</button>
		</td>
	</tr>
	<tr>
		<td valign="top">
<?php
//echo html_store($m_kw);
echo $m_lists;
?>
		</td>
	</tr>
<table>

<input type="hidden" name="fun" value="add_pass"/>
<input type="hidden" name="hd_id" value="-1"/>
<input type="hidden" name="hd_site" value="<?=$m_site;?>"/>
<input type="hidden" name="ref" value=""/>
</form>

<!--弹出浮层
<table border="0" cellspacing="0" cellpadding="0" id="tbl_detail"  style="display:none;left:550px;width:430px;height:200px;top:40px;position:absolute;z-index:10;">
<tr><td valign=top class="box-note" id="td_detail">
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="h2-note"><img src="../images/icon_timealert32.gif" align=absmiddle>选择父类目</td><td><img style='cursor:hand;position:absolute;right:5px;top:5px;display:block' src="../images/cha.gif" onclick="javascript:this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';" alt="关闭"/></td></tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class=note align="center"><?=html_sonclass();?></td></tr></table>
<table width="100%" border="0" cellspacing="2" cellpadding="0"><tr><td class=note><span class=lh15></td></tr></table>
//-->

</td>
</tr>
</table>

<iframe name="submitframe" width="1" height="1"></iframe>
</BODY>
</HTML>
