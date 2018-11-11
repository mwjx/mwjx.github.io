<?php
//------------------------------
//create time:2008-8-4
//creater:zll,liang_0735@21cn.com
//purpose:类目关键词
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/class_info.php");
//my_safe_include("mwjx/class_dir.php");
//my_safe_include("mwjx/track.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);
$m_title = cname($m_id);

function cname($id = -1)
{
	//类目名称
	//输入:id类目ID
	//输出:名称字符串
	$str_sql = "select name from class_info where id='".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	if(1 != count($arr))
		return "";
	return $arr[0][0];
}
function lists_kw($id = -1)
{
	//关键词列表
	//输入:id类目ID
	//输出:html字符串
	$html = "";
	$html .= "<textarea name=\"txt_kwls\" style=\"width:480px;\" rows=\"12\">";
	$str_sql = "select * from class_kw where cid='".$id."';";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$html .= $arr[$i][2]."\n";
	}
	$html .= "</textarea>";
	return $html;
}
function html_sonclass()
{
	//评剑科幻子类目
	//输入:无
	//输出:html字符串
	$novels = new c_class_info(4); //评剑科幻
	$arr_tmp = $novels->get_son_link();
	$ls = "<div id=\"div_slbrand\" style=\"display:block;\"><ul>";
	$index = 0;
	$arr_char = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	$js = "<script language=\"javascript\">\n";
	$js .= "var m_arr_c = Array();\n";
	foreach($arr_tmp as $row){
		$obj = new c_class_info(intval($row[0]));
		$arr = $obj->get_son_link();
		if(count($arr) < 1)
			continue;
		$id= $row[0];
		$name= $row[1];
		//this.style.backgroundColor='red';
		$c = strtoupper($arr_char[$index++]);
		$js .= "m_arr_c['".$c."'] = Array('".$id."','".$name."');\n";
		$c = "（".($c)."）";
		$ls .= "<li onclick=\"javascript:chk_fid('".$id."','".$name."');\"><span>".$c.$name."</span></li>";
	}
	$js .= "</script>\n";
	$ls .= "</ul></div>";
	$ls .= $js;
	//var_dump($js);
	//exit();
	return $ls;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> 添加新书 </TITLE>
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
<script language="javascript" src="../include/script/xmldom.js"></script>
<script language="javascript" src="../script/val2url.php"></script>
<script language="javascript">
function go_search(str)
{
	//跳转页面查询
	//输入:str(string)查询关分键词
	//输出:无
	document.all["txt_cname"].value = "";
	document.all["txt_url"].value = "";
	var objck = document.all["exists_track"];
	document.all["pid"].value = objck.options[objck.selectedIndex].value;
	//alert(document.all["id_ls"].value);
	var author = objck.options[objck.selectedIndex].author;
	document.all["txt_author"].value = author;
	//var title = objck.options[objck.selectedIndex].title;
	document.all["pname"].value = str;
	//alert(title);
	var url = "./data_searchbook.php?kw="+str;
	var xmlDoc= new_xmldom();
	xmlDoc.async="false";
	xmlDoc.load(url);
	var nodes=xmlDoc.documentElement.childNodes
	//var obj = document.all["xmldso_list"];
	//obj.src = url;
	//var rows = obj.selectNodes("row");
	//var nodes=obj.documentElement.childNodes;
	var obj = document.all["st_urllists"];
	obj.options.length = 0;
	var title,site,sitename,val,id;
	//alert(nodes[0].childNodes[0].text);
	//return;
	for(var i = 0;i < nodes.length;++i){
		title = nodes[i].childNodes[0].text;
		sitename = nodes[i].childNodes[1].text;
		val = nodes[i].childNodes[2].text;
		site = nodes[i].childNodes[3].text;
		id = nodes[i].childNodes[4].text;
		title = "["+sitename+"]"+title;
		var oOption = document.createElement("OPTION");
		oOption.sid=id;
		oOption.site=site;
		oOption.text=title;
		oOption.value=val;
		obj.add(oOption);
	}
	//alert(nodes.length);
	//detail += "<xml id=\"xmldso_list\" src=\""+url+"\" tppabs=\"http://www.w3schools.com/xml/cd_catalog.xml\"></xml>";
	//document.location.href = url;
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
function commit()
{
	//提交队列到服务器
	//输入:无
	//输出:无
	document.all["frm_action"]["fun"].value = "class_kw";
	document.all["frm_action"].submit();
	//return;
}
function add(flag)
{
	//添加到类目
	//输入:flag(bool)1/2(正常/强制添加)
	//输出:无
	var obj = document.all["store_name"];
	var oOption = document.createElement("OPTION");
	var pid = parseInt(document.all["pid"].value,10);
	if(pid < 1)
		return alert("添加失败,佳丽ID无效");
	if(1 == flag){
		if("" == document.all["txt_cname"].value)
			return alert("添加失败，未选择父类目");
		var sou = parseInt(document.all["flag_id"].value,10);
		if(sou < 1)
			return alert("添加失败，来源无效："+sou);
		if("" == document.all["txt_url"].value)
			return alert("添加失败，未选择来源URL");
		var txt = pid;
		txt += ("`|"+document.all["txt_cname"].value);
		txt += "`|"+document.all["pname"].value;
		var val = pid;
		val += (","+document.all["hd_sou"].value);
		val += (","+document.all["hd_fid"].value);
	}
	else if(2 == flag){
		var txt = pid;
		txt += ("`|"+document.all["txt_cname"].value);
		txt += "`|"+document.all["pname"].value;
		var val = pid;
		val += (",-1");
		val += (",-1");
	}
	else{
		return alert("err");
	}
	//oOption.sid=id;
	oOption.text=txt;
	oOption.value=val;
	obj.add(oOption);
	document.all["txt_cname"].value = "";
	return;
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
function keydown()
{
	//键盘事件
	//输入:无
	//输出:无
	var cd = event.keyCode;
	var big = String.fromCharCode(cd);
	//return alert(cd);
	//return alert(String.fromCharCode(cd));
	if(cd >= 65 && cd <= 90){
		if(null != m_arr_c[big]){
			chk_fid(m_arr_c[big][0],m_arr_c[big][1]);
		}
		return;
	}
	switch(event.keyCode){
		case 32: //空格，下一个佳丽
			var obj = document.all["exists_track"];
			if(obj.selectedIndex < 0)
				obj.selectedIndex = 0;
			else
				++obj.selectedIndex;
			go_search(obj.options[obj.selectedIndex].title);	
			//下一个来源
			obj = document.all["st_urllists"];
			if(obj.selectedIndex < 0)
				obj.selectedIndex = 0;
			else
				++obj.selectedIndex;
			ck_store();
			break;
		case 13: //enter，添加
			add(1);
			break;
		case 8: //backspace，禁用
			add(2);
			break;
		case 38:  //上,选来源
			var obj = document.all["st_urllists"];
			if(obj.selectedIndex <= 0)
				obj.selectedIndex = 0;
			else
				--obj.selectedIndex;
			ck_store();
			break;
		case 40: //下,选来源
			var obj = document.all["st_urllists"];
			if(obj.selectedIndex < 0)
				obj.selectedIndex = 0;
			else
				++obj.selectedIndex;
			ck_store();
			break;
		default:
			break;
	}
	/*
		case 37: //左
			x -= m;  
			break;
		case 39: //右
			x += m;
			break;
		case 40: //下
			y += m;
			break;

	*/
}
function chk_fid(fid,fname)
{
	//选中一个父类目
	//输入:fid(string)父类目ID,fname(string)父类目名称
	//输出:无
	//alert(fid);
	//var name = document.all["search_title"].value;
	if("" == fid)
		return alert("父类目ID无效");
	var url = "./class_kw.php?id="+fid;
	window.location.href = url;
	/*document.all["txt_cname"].value = fname;
	document.all["hd_fid"].value = fid;
	
	//this.childnodes[0].style.backgroundcolor='red';
	//alert(this.style);
	return;
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
	*/
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
	var obj = document.all["st_urllists"];
	if(obj.options.length < 1)
		return;
	//alert(obj.selectedIndex);
	//return;
	var val = obj.options[obj.selectedIndex].value;
	//var site = parseInt(obj.options[obj.selectedIndex].site,10);
	var site = obj.options[obj.selectedIndex].site;
	document.all["hd_sou"].value = obj.options[obj.selectedIndex].sid;
	//aatt();
	//var tmp = "aa`|bb";
	//tmp = tmp.replace("`|","123");
	//return alert(tmp);
	//return alert(g_arr_v2u[site]+"---"+val);
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
			//var tmp = val.substr(0,(val.length-3));
			//return alert(tmp);
			url = "http://www.qjzw.com/files/article/html/"+val+"/index.html";
			break;
		case 10: //华夏
			url = "http://www.huaxiazw.com/files/article/html/"+val+"/index.html";
			break;
		case 12: //乐乐书房
			url = "http://52wf.cn/html/"+val+"/";
			break;
		case 13: //香港文学城
			url = "http://www.hkwxc.com/Html/Book/"+val+"/Index.shtml";
			break;
		case 14: //逐浪
			url = "http://book.zhulang.com/"+val+"/index.html";
			break;
		case 15: //书家
			url = "http://www.bookjia.com/Html/Book/"+val+"/List.html";
			break;
		case 16: //第九
			url = "http://book.d9cn.com/d9cnbook/"+val+"/index.html";
			break;
		case 18: //小说阅读网
			url = "http://www.readnovel.com/partlist/"+val+"/";
			break;
		case 19: //小说520
			//var tmp = val.substr(0,(val.length-3));
			//var tmp = "";
			url = "http://www.xiaoshuo520.net/html/Book/"+val+"/";
			//url = "http://www.xiaoshuo520.net/html/Book/"+tmp+"/"+val+"/";
			break;
		case 20:
			//url = "http://www.9173.com/Html/Book/0/"+val+"/Index.shtml";
			url = "http://www.9173.com/Html/Book/"+val+"/Index.shtml";
			break;
		case 22:
			url = "http://www.xiaoshuom.com/html/"+val+"/";
			break;
		case 25: //可可书屋
			//url = "http://www.mop5.com/files/article/mop5/0/"+val+"/index.html";
			url = "http://www.mop5.com/files/article/mop5/"+val+"/index.html";
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
	}
	*/
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

<BODY text="#000000" bgColor="#ffffff">
<?php
//echo $m_js;
//echo $m_htmltitle;
?>
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top" align="center">
		</td>
	</tr>
</table>
<!--功能表单//-->
<form method="POST" name="frm_action" action="../cmd.php" target="submitframe" accept-charset="GBK">
<table id="content" border=0 cellspacing=0 cellpadding=0>
	<tr>
		<td valign="top">
当前类目：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="txt_cname" size="8" value="<?=$m_title;?>"/>&nbsp;&nbsp;&nbsp;
<br/>
关键词列表：
<?=lists_kw($m_id);?>
<br/>

<br/>
</td>
	</tr>
	<tr>
		<td valign="top" align="center">
<button onclick="javascript:commit();">提交列表</button>
		</td>
	</tr>
<table>

<input type="hidden" name="fun" value="class_kw"/>
<input type="hidden" name="hd_fid" value="<?=$m_id;?>"/><!--当前父类ID//-->
</form>

<!--弹出浮层//-->
<table border="0" cellspacing="0" cellpadding="0" id="tbl_detail"  style="display:block;left:550px;width:430px;height:200px;top:40px;position:absolute;z-index:10;">
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
