<?php
//------------------------------
//create time:2008-1-24
//creater:zll,liang_0735@21cn.com
//purpose:小说追踪添加
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
my_safe_include("mwjx/class_dir.php");
my_safe_include("mwjx/track.php");

$m_kw = (isset($_GET["kw"])?$_GET["kw"]:""); //搜索关键词
$m_cid = -1;
$m_author = ""; //作者
$m_lists = html_class($m_kw);

//$m_id = 1; //tests

function js_track_domain()
{
	//来源域名标志
	//输入:无
	//输出:html字符串
	$js = "<script language=\"javascript\">\n";
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
		$str_sql = "select id,name,memo from class_info where name like '%".$kw."%';";
		//exit($str_sql);
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		$arr = $sql->get_array_array();
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
		$sql->close();
		$arr = $sql->get_array_array();
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
		$str_sql = "select N.id,N.title,NL.sou,NL.val from novels N left join novels_links NL on N.id=NL.novels where N.title like '%".$kw."%';";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$arr = $sql->get_array_array();
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
	for($i = 0;$i < $len; ++$i){
		$id = $arr[$i][0];
		$site = intval($arr[$i]["sou"]);
		$val = $arr[$i]["val"];
		//if($m_cid < 1){
		//	$m_cid = intval($id);
		//	$m_author = $arr[$i][2];
		//}
		$title = $arr[$i][1];
		if(isset($arr_flag[$site]))
			$title = "[".$arr_flag[$site]."]".$title;
		//$js .= "m_arr_author['".$id."'] = '".$arr[$i][2]."';\n";
		$html .= "<option value=\"".$val."\" id=\"".$site."\">".$title."</option>";
	}
	$html .= "</select>";
	
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
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$arr = $sql->get_array_array();
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
<script language="javascript" src="../script/val2url.php"></script>
<script language="javascript">
function empty_class()
{
	//显示空白类目列表
	//输入:str(string)查询关分键词
	//输出:无
	//td_empty
	var url = "../track/data_emptyclass.php";
	var xmlDoc= new_xmldom();
	xmlDoc.async="false";
	xmlDoc.load(url);
	var nodes=xmlDoc.documentElement.childNodes
	//var obj = document.all["xmldso_list"];
	//obj.src = url;
	//var rows = obj.selectNodes("row");
	//var nodes=obj.documentElement.childNodes;
	document.all["td_empty"].innerHTML = "空白类目：<select name=\"st_emptyclass\" size=\"10\" MULTIPLE style=\"width:400px;\" ondblclick=\"javascript:go_search(this.value);\"></select>";
	var obj = document.all["st_emptyclass"];
	obj.options.length = 0;
	var title,num,txt;
	//alert(nodes[0].childNodes[0].text);
	//return;
	for(var i = 0;i < nodes.length;++i){
		title = nodes[i].childNodes[0].text;
		num = nodes[i].childNodes[1].text;
		txt = "("+num+")"+title;
		var oOption = document.createElement("OPTION");
		oOption.text=txt;
		oOption.value=title;
		obj.add(oOption);
	}
	//alert(nodes.length);
	//detail += "<xml id=\"xmldso_list\" src=\""+url+"\" tppabs=\"http://www.w3schools.com/xml/cd_catalog.xml\"></xml>";
	//document.location.href = url;
	//alert(str);
}
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
function del_class()
{
	//删除类目
	//输入:无
	//输出:无
	var cid = parseInt(document.all["cid"].value,10);
	if(cid < 1)
		return alert("删除失败，类目ID无效");
	//return alert();
	var url = "../cmd.php?fun=del_class&id="+cid;
	var xmlDoc= new_xmldom();
	xmlDoc.async="false";
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
	//alert(g_arr_v2u);
	//alert(g_arr_v2u[site]+":"+val);
	var url = "";
	url = val2url(site,val);
	/*
	switch(site){
		case 1: //三五
			url = "http://www.xiaoshuo555.cn/modules/article/reader.php?aid="+val;
			break;
		case 2:
			url = "http://read.2200book.com/files/article/html/"+val+"/index.html";
			break;
		case 5: //奇迹
			//var tmp = val.substr(0,2);
			var tmp = val.substr(0,(val.length-3));
			//return alert(tmp);
			url = "http://www.qjzw.com/files/article/html/"+tmp+"/"+val+"/index.html";
			break;
		case 10: //华夏
			url = "http://www.huaxiazw.com/files/article/html/"+val+"/index.html";
			break;
		case 12: //乐乐书房
			url = "http://52wf.cn/html/"+val+"/";
			break;
		case 16: //第九
			url = "http://book.d9cn.com/d9cnbook/"+val+"/index.html";
			break;
		case 14: //逐浪
			url = "http://book.zhulang.com/"+val+"/index.html";
			break;
		case 18: //小说阅读网
			url = "http://www.readnovel.com/partlist/"+val+"/";
			break;
		case 19: //小说520
			var tmp = val.substr(0,(val.length-3));
			//var tmp = "";
			url = "http://www.xiaoshuo520.net/html/Book/"+tmp+"/"+val+"/";
			break;
		case 20:
			url = "http://www.9173.com/Html/Book/0/"+val+"/Index.shtml";
			break;
		case 22:
			url = "http://www.xiaoshuom.com/html/"+val+"/";
			break;
		case 25:
			url = "http://www.mop5.com/files/article/mop5/"+val+"/index.html";
			//url = "http://www.mop5.com/files/article/mop5/0/"+val+"/index.html";
			break;
		case 28:
			url = "http://novel.hongxiu.com/a/"+val+"/";
			break;
		case 26: //新浪
			url = "http://vip.book.sina.com.cn/book/catalog.php?book="+val;
			break;
		case 34: //翠微居
			url = "http://read.cuiweiju.com/files/article/html/"+val+"/index.html";
			break;
		default:
			return;
	} */
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
echo $m_js;
//echo $m_htmltitle;
?>
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top" align="center">
<br/><input type="text" name="search_title" size="15" value="<?=$m_kw;?>" onclick="javascript:this.value='';"/>
&nbsp;<button onclick="javascript:go_search(search_title.value);">搜索类目</button>	&nbsp;&nbsp;<button onclick="javascript:	document.all['tbl_detail'].style.display = 'block';">创建类目</button>
&nbsp;&nbsp;<button onclick="javascript:empty_class();">空白类目</button>
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
类目ID：&nbsp;&nbsp;&nbsp;<input type="text" name="cid" size="8" value="<?=$m_cid;?>"/>&nbsp;&nbsp;&nbsp;
<?php
echo $m_lists;
?>
&nbsp;&nbsp;&nbsp;作者：<input type="text" name="txt_author" size="8" value="<?=$m_author;?>"/><button onclick="javascript:update_author();">更新作者</button>
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
<button onclick="javascript:window.open('/site838/view/src_php/track_sou.php?sid='+document.all['id_ls'].value);">打开来源</button>
		&nbsp;&nbsp;
<button onclick="javascript:rm_sou(document.all['id_ls'].value);">删除来源</button>
		&nbsp;&nbsp;
<button onclick="javascript:del_class();">删除类目</button>
		&nbsp;&nbsp;
<button onclick="javascript:up_url();">更新地址</button>
		&nbsp;&nbsp;
<button onclick="javascript:add();">添加来源</button>
<span style="width:100px;"></span>
		</td>
	</tr>
	<tr>
		<td valign="top">
<?php
echo html_store($m_kw);
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
<table border="0" cellspacing="0" cellpadding="0" id="tbl_detail"  style="display:none;left:550px;width:430px;height:200px;top:40px;position:absolute;z-index:10;">
<tr><td valign=top class="box-note" id="td_detail">
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class="h2-note"><img src="../images/icon_timealert32.gif" align=absmiddle>选择父类目</td><td><img style='cursor:hand;position:absolute;right:5px;top:5px;display:block' src="../images/cha.gif" onclick="javascript:this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.style.display='none';" alt="关闭"/></td></tr></table>
<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td class=note align="center"><?=html_sonclass();?></td></tr></table>
<table width="100%" border="0" cellspacing="2" cellpadding="0"><tr><td class=note><span class=lh15></td></tr></table>


</td>
</tr>
</table>

<iframe name="submitframe" width="1" height="1"></iframe>
</BODY>
</HTML>
