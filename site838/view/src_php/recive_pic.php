<?php
//------------------------------
//create time:2007-11-23
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:接收图片
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) < 1){
	goto_url("","上传图片失败，当前用户无效，请先到首页登录或注册");
}
//上传图片
$img_ls = "";
$img = "";
for($i = 1;$i <=5;++$i){
	$img_path = cp_pic("file_img".$i);
	if("" == $img_path)
		continue;
	//$img_path = "http://localhost/allyes/beauty_movie/".$img_path;
	$img_path = "/data/up_pics/".$img_path;
	$img_path = "http://".$_SERVER["HTTP_HOST"].$img_path;
	//goto_url("","评论完成：".$img_path);
	//将图片路径插入内容文本
	//限制宽度
	$size = GetImageSize($img_path);
	$width = intval($size[1]);
	$img = "[img]".$img_path."[/img]";
	if($width > 540)
		$img = "[img width=540]".$img_path."[/img]";
	$img_ls .= $img."\\n";
	//goto_url("",$img_ls);
}
if("" == $img_ls)
	goto_url("","上传图片失败，可能是图片格式不正确或太大");
echo "<script language=\"javascript\">";
if(isset($_POST["picref"])){ //跟贴
	echo "window.parent.parent.document.all[\"txt_content\"].value +='\\n".$img_ls."';";
}
else{ //主题
	echo "window.parent.document.all[\"txt_content\"].value +='\\n".$img_ls."';";
}
//echo "alert(window.parent.document.URL);";
//echo "alert(window.parent.parent.document.all['txt_content']);";
echo "</script>";
goto_url("","上传图片成功，请继续发布文章");
function cp_pic($name="")
{
	//上传图片
	//输入:图片输入框名称
	//输出:图片地址，异常或失败返回空字符串
	//exit("up_pic");
	if(!isset($_FILES[$name]))
		return "";
	$path = "";
	//goto_url("",strval(count($_FILES)));
	if("" == $_FILES[$name]['name'])
		return "";
	if(!is_file($_FILES[$name]['tmp_name']))
		return "";
	$max_size = 20*1024*1024;
	if($_FILES[$name]['size'] > $max_size)
	   return "";
		
	$filename = "";
	$hz = strtolower(strrchr(basename($_FILES[$name]['name']),"."));
	//goto_url("","OK:".basename($_FILES['file'.$i]['name']));
	//break;
	//return $hz;
	if($hz != ".gif" && $hz != ".jpg" && $hz != ".jpeg" && $hz != ".bmp"){
		//goto_url("","文件类型错误".__LINE__);
		return "";
	}
	mt_srand((double)microtime()*1000000);
	$filename = md5($_FILES['file'.$i]['name']."_".uniqid(mt_rand())).$hz; 
	//exit($filename);
	//goto_url("",$filename);
	//break;
	$m_dir_upload = "../../data/up_pics/";
	$uploadfile = $m_dir_upload.$filename;
	//return $uploadfile;
	if (!move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile)) {
	   //goto_url("","移至服务器出错".__LINE__);
		return "";
	} 
	$path = $filename; //$uploadfile;
	return $path;
}
function goto_url($url = "",$str = "",$flag=1)
{
	//跳转页面
	//输入:url不为空跳转到该地址,值refresh刷新当前窗口,
	//str不为空显示该信息
	//flag(int)1/2(父窗口/当前窗口)
	//输出:无
	//必须要用exit输出
	if("" != $str)
		$str = "alert(\"".$str."\");";
	$window = "window.parent";
	if(2 == $flag)
		$window = "window";
	if("" != $url){
		if("refresh" == $url)
			$url = $window.".location.reload();";
		else
			$url = $window.".location.href=\"".$url."\";";
	}
	exit("<script language=\"javascript\">
".$str.$url."
</script>");
}
?>