<?php
//------------------------------
//create time:2006-3-2
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:首页函数文件
//------------------------------
//----------functions---------
function clear_session_user()
{
	$_SESSION["username"] = "";
	$_SESSION["userpass"] = "";
	session_destroy();
}
function get_html_login()
{
	$result = "<table cellpadding=\"3\" border=\"0\" align=\"center\" height=\"500\"><tr>\n";
	$result .= "<td width=\"100%\" valign=\"top\">";
	$result .= "<table border=\"0\" align=\"center\" valign=\"top\" width=\"100%\"><tr valign=\"top\"><td align=\"center\" valign=\"top\" colspan=\"2\" ><center><font size=\"+1\"><b>妙文精选</b></font></center></td></tr>";
	$result .= "<tr align=\"left\"><td align=\"left\"  colspan=\"2\">特色功能介绍:<br/><li>用户可推荐文章</li><br/><li>所有类目都可自由申请创建维护</li><br/><li>用户自己评选最佳文章</li><br/></td></tr>";

	$result .= "<tr align=\"right\"><td width=\"60%\"></td><td align=\"right\"><!--<INPUT name=\"apply\" type=\"submit\" value=\"功能演示\" onclick=\"window.open('http://fishcounter.mwjx.com/index.php?uid=3');\">&nbsp;&nbsp;//--><INPUT name=\"apply\" type=\"submit\" value=\"免费申请\" onclick=\"window.open('./reg.php');\">";
	$result .= "</td></tr></table></td>";
	$result .= "<td width=\"30%\" align=\"right\" valign=\"top\"><table cellpadding=\"0\" width=\"100%\" cellspacing=\"0\"> <tr valign=\"top\"><td bgcolor=\"#e6f2ea\" style=\"border: 2px solid #6699cc; padding: 1ex 2ex 1ex;\" valign=\"top\">\n";
	$result .= "<form name=\"login\" action=\"./index.php\" method=\"post\" visable=\"false\"><table cellpadding=\"3\" cellspacing=\"0\" border=\"0\" valign=\"top\"> <tr > <td colspan=\"2\"> <font color=\"#006633\" size=\"-1\"><b> 会员入口  </b></font> </td> </tr>\n";

	$result .= "<tr> <td align=\"right\" nowrap><font size=\"-1\">用户名：</font></td> <td> <span dir=\"ltr\"> <input name=\"name\" type=\"text\" id=\"username\" tabindex=\"1\" size=\"15\"> </span></td> </tr> <tr> <td align=\"right\" nowrap><font size=\"-1\">密码：&nbsp;&nbsp;</font></td> <td> <span dir=\"ltr\"> <input name=\"password\" type=\"password\" id=\"password\" tabindex=\"2\" size=\"15\"> </span> </td> </tr>\n";
	$result .= "<tr> <td> </td> <td> <input type=\"submit\" name=\"login\" value=\"登录\" tabindex=\"3\">&nbsp;&nbsp;<input name=\"resett\" type=\"reset\" id=\"resett\" tabindex=\"4\" value=\"重填\"></td> </tr></table></form>\n";
	$result .= "</td></tr></table></td>\n";

	$result .= "</tr>";
	//$result .= "</tr>";
	$result .= "</table>";
	return $result;
}
function get_html_frame($id = "",$path = "")
{
	//显示登录后的HTML页面
	//输入:id是用户ID,paht主显示区页面绝对路径
	//输出:xml字符串
	$url_left = "./src_php/left_menu.php";
	//$url_left = "../left.php";
	if("" == $path){
		//$url_main = "../data/12_20_1.xml";
		$url_main = "./src_php/data_class.php?cid=12&page=1&per=20";
	}
	else{
		$url_main = $path;
	}
	$result = "<TABLE border=0 cellPadding=0 cellSpacing=0 height=94% width=100%>
	<TBODY><TR><TD align=middle id=frmTitle noWrap vAlign=center>
	<IFRAME FRAMEBORDER=\"no\" name=window_left scrolling=\"auto\" src=\"".$url_left."\"  style=\"HEIGHT:100%;VISIBILITY:inherit;WIDTH:157px;Z-INDEX:2\">
	</IFRAME>
	<TD bgColor=#FFFFFF>
	<TABLE border=0 cellSpacing=1 cellPadding=1 height=100%>
	<TBODY><tr><TD onclick=switchSysBar() style=\"HEIGHT:100%;\" bgColor=#FFFFFF>
	<font style=\"COLOR:000000;CURSOR:hand;FONT-FAMILY:Webdings;FONT-SIZE:6pt\">
	<SPAN id=switchPoint title=\"收缩/弹出左栏\">3</SPAN></font>
	</TBODY></TABLE></TD>
	<TD style=\"WIDTH:100%\">
	<IFRAME frameBorder=0 name=roll scrolling=\"?\" src=\"".$url_main."\" style=\"HEIGHT:100%;VISIBILITY:inherit;WIDTH:100%;Z-INDEX:1\"></IFRAME>
	</TR></TBODY></TABLE>";
	return $result;
}
//--------------end functions---------
?>