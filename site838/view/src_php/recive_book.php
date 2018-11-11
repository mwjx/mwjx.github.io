<?php
//------------------------------
//create time:2007-11-21
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:接收书籍
//------------------------------
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
//goto_url("","上传书籍成功--");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) < 1){
	goto_url("","上传书籍失败，当前用户无效，请先到首页登录或注册");
}

if(!check_input())
	goto_url("","上传书籍失败，名称或简介无效");
//上传图片
$re = cp_book($obj_man->get_id());
//$img_path = "http://slek.allyes.com/beauty/".$img_path;
if("" == $re)
	goto_url("refresh","上传书籍成功");
else
	goto_url("","上传书籍失败，原因：".$re);
function check_input()
{
	//检查参数是否正确,名称或简介
	//输入:无，表单提交过来的参数
	//输出:true正确，false错误
	if(!isset($_POST["book_title"]) || !isset($_POST["book_txt"]) || !isset($_POST["cid"]))
		return false;
	if(strlen($_POST["book_title"]) < 1 ||strlen($_POST["book_title"]) > 255)
		return false;
	if(strlen($_POST["book_txt"]) < 1 ||strlen($_POST["book_txt"]) > 100000)
		return false;
	if(intval($_POST["cid"]) < 1)
		return false;
	return true;
}
function cp_book($uid=0)
{
	//上传书籍
	//输入:uid(int)用户ID
	//输出:成功返回空字符串，异常或失败返回失败原因字符串
	if("" == $_FILES['file_book']['name'])
		return "无文件1";
	if(!is_file($_FILES['file_book']['tmp_name']))
		return "无文件2,".$_FILES['file_book']['error'];
	$max_size = 20*1024*1024;
	if($_FILES['file_book']['size'] > $max_size)
	   return "超过最大尺寸20M";
		
	$filename = "";
	$hz = strtolower(strrchr(basename($_FILES['file_book']['name']),"."));
	//goto_url("","OK:".basename($_FILES['file'.$i]['name']));
	//break;
	//return $hz;
	if($hz != ".rar" && $hz != ".zip" && $hz != ".chm" && $hz != ".doc" && $hz != ".pdf" && $hz != ".txt" && $hz != ".xls"){
		//goto_url("","文件类型错误".__LINE__);
		return "文件类型无效";
	}
	mt_srand((double)microtime()*1000000);
	$filename = md5($_FILES['file_book']['name']."_".(uniqid(mt_rand()))).$hz; 
	//exit($filename);
	//goto_url("",$filename);
	//break;
	$m_dir_upload = "../../data/up_book/";
	$uploadfile = $m_dir_upload.$filename;
	//return $uploadfile;
	if (!move_uploaded_file($_FILES['file_book']['tmp_name'], $uploadfile)) {
	   //goto_url("","移至服务器出错".__LINE__);
		return "复制文件出错";
	} 
	//入库
	$title = addslashes($_POST["book_title"]);
	$txt = addslashes($_POST["book_txt"]);
	$cid = intval($_POST["cid"]);
	$str_sql = "insert into book_down (title,txt,fid,aday,poster,filename,size,hz)values('".$title."','".$txt."','".$cid."','".date("Y-m-d",time())."','".$uid."','".$filename."','".$_FILES['file_book']['size']."','".$hz."');";
	$sql = new mysql;
	$sql->query($str_sql);
	$sql->close();
	return "";
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