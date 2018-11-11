<?php
//------------------------------
//create time:2007-8-2
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:妙文精选津贴管理
//------------------------------
require_once("../../aboutfish/fishcountry/class/function.inc.php");
//require_once("./fun_global.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/mwjx_cash.php");
my_safe_include("mwjx/authorize.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) < 1){
	exit("当前用户无效，请先到首页登录或注册");
	//exit("当前用户无效");
}
$obj = new c_authorize;		
if(!$obj->can_do($obj_man,1,1,17)){ //无权，等待审核
	exit("无权限");
}

$m_obj = new c_mwjx_cash;
//exit("aaa");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
</HEAD>

<BODY>
<b>mwjx未分配金额更新</b><br/>
mwjx未分金额(<?=date("Y-m-00",time())?>):<?=$m_obj->get_unsettled(date("Y-m-00",time()))?><br/>
更新mwjx未分金额:<br/>
<form action="/mwjx/cmd.php?fun=up_unsettled" method="POST"  target="submitframe">

月份:<input name="txt_up_month" type="text" value="<?=date("Y-m-00",time())?>"/>&nbsp;&nbsp;
金额:<input name="txt_up_cash" type="text" value="<?=$m_obj->get_unsettled(date("Y-m-00",time()))?>"/>
<button onclick="this.form.submit();">提交</button>
</form>
<br/>
<br/><br/>
<b>预测今日</b><br/>
<form action="/mwjx/cmd.php?fun=count_usercash" method="POST"  target="submitframe">
月份:<input name="txt_count_month" type="text" value="<?=date("Y-m-00",time())?>"/>&nbsp;&nbsp;
<button onclick="this.form.submit();">提交</button></form>
<br/>
<br/>
<br/><br/>
<b>mwjx未分配金额每月结算</b><br/>
<form action="/mwjx/cmd.php?fun=checkout_month" method="POST"  target="submitframe">
月份:<input name="txt_checkout_month" type="text" value="<?=date("Y-m-00",time())?>"/>&nbsp;&nbsp;
<button onclick="this.form.submit();">提交</button></form>
<br/>
:注意月份的格式一定要正确
<iframe name="submitframe" width="0" height="0"></iframe>
</BODY>
</HTML>
