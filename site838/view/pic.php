<?php
//------------------------------
//create time:2007-8-19
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:验证图片
//------------------------------
//echo phpinfo();
//exit();
/*
Header("Content-type: image/gif");
$im = imagecreate(400,30);
$black = ImageColorAllocate($im, 0,0,0);
$white = ImageColorAllocate($im, 255,255,255);
imageline($im, 1, 1, 350, 25, $black);
imagearc($im, 200, 15, 20, 20, 35, 190, $white);
imagestring($im, 5, 4, 10, "Graph TEST!!", $white);
ImageGif($im);
ImageDestroy($im);
exit();
*/
$m_t = isset($_GET["t"])?$_GET["t"]:"";
session_start();
$type = 'png'; 
$width= 53; 
$height= 20; 
header("Content-type: image/".$type); 
srand((double)microtime()*1000000); 
$randval = randStr(5,"CHAR_big");
switch($m_t){
	case "reply": //回复评论
		$_SESSION['conf_reply']=strtolower($randval);
		break;
	case "recommend": //推荐
		$_SESSION['conf_recommend']=strtolower($randval);
		break;
	case "delarticle": //删除文章
		$_SESSION['conf_delarticle']=strtolower($randval);
		break;
	case "star": //文章评级
		$_SESSION['conf_star']=strtolower($randval);
		break;
	case "clgood": //取消精华
		$_SESSION['conf_clgood']=strtolower($randval);
		break;
	case "good": //评置精华
		$_SESSION['conf_good']=strtolower($randval);
		break;
	case "vote": //文章投票
		$_SESSION['conf_vote']=strtolower($randval);
		break;
	case "helpmwjx":
		$_SESSION['conf_helpmwjx']=strtolower($randval);
		break;
	default:
		$_SESSION['PICNUM']=strtolower($randval);
		break;
}


if($type!='gif' && function_exists('imagecreatetruecolor')){
	$im = @imagecreatetruecolor($width,$height);
}else{ 
	$im = @imagecreate($width,$height);
}
$r = Array(225,211,255,223);
$g = Array(225,236,237,215);
$b = Array(225,236,166,125);

$key = rand(0,3);

//$backColor = ImageColorAllocate($im,20,180,250);
$backColor = ImageColorAllocate($im,150,150,199);
//$backColor = ImageColorAllocate($im,229,229,225);

$borderColor = ImageColorAllocate($im, 200, 200, 200);
$pointColor = ImageColorAllocate($im, 255, 170, 255);

@imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $backColor);
@imagerectangle($im, 0, 0, $width-1, $height-1, $borderColor);
$stringColor = ImageColorAllocate($im, 255,255,255);

for($i=0;$i<=100;$i++){
	$pointX = rand(2,$width-2);
	$pointY = rand(2,$height-2);
	@imagesetpixel($im, $pointX, $pointY, $pointColor);
}

@imagestring($im, 8, 5, 1, $randval, $stringColor); 
$ImageFun='Image'.$type;
$ImageFun($im);
@ImageDestroy($im);

//产生随机字符串
function randStr($len=6,$format='ALL') {
	switch($format) {
	case 'ALL':
	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	break;
	case 'CHAR':
	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	break;
	case 'CHAR_big':
	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	break;
	case 'NUMBER':
	$chars='0123456789';
	break;
	default :
	$chars='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	break;
	}
	$string="";
	while(strlen($string)<$len)
	$string.=substr($chars,(mt_rand()%strlen($chars)),1);
	return $string;
}
?>