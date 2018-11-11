<?php
//------------------------------
//create time:2008-1-22
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:更新追踪服务器接口
//------------------------------
if("" == $_COOKIE['username']){
	exit("无权限");
}
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
header("Expires: Sat, 1 Jan 2000 00:00:00 GMT");
header("Content-Type: text/html;charset=GBK");
//header("Content-Type: text/xml;charset=GBK");
//$m_id = intval(isset($_GET["sid"])?$_GET["sid"]:-1);
$m_id = intval(isset($_GET["sid"])?$_GET["sid"]:-1);
//$m_id = 1; //tests
if($m_id > 0){ //天涯分页处理
	//exit("aa");
	track_deal($m_id);
	check_newtianya($m_id);
	exit();
}
exit(check_new());
function empty_deal($id = -1)
{
	//返回下一次的预处理地址
	//输入:id(int)来源索引页ID
	//输出:url字符串，异常返回空字符串
	$str_sql = "select * from track_section where tid='".$id."' order by id DESC limit 1;";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	$url = "";
	if(count($arr) > 0){
		$url = $arr[0]["url"];
	}
	return $url;
}
function track_deal($id = -1)
{
	//预处理
	//输入:id(int)来源索引页ID
	//输出:无
	//有预处理记录，跳过
	//exit("vvv");
	//return;
	//$str_sql = "select count(*) from track_deal where sid='".$id."' and status='D';";
	$str_sql = "select count(*) from track_deal where sid='".$id."';";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	//exit($str_sql);
	if(intval($arr[0][0]) > 0)
		return; //有记录，跳过
	$url_sou = track_sou($id);
	$fname = md5($url_sou);
	$path = "../../../data/update_track/".$id."/".$fname.".html";
	//exit($path);
	$content = readfromfile($path);
	//echo (""==$content);
	//exit();
	if("" == $content){ //首页都没有，肯定无数据，插入预处理
		$title = "";
		$url = $url_sou;
		$post = "";
		$str_sql = "INSERT INTO `track_deal` (`sid`, `title`, `url`, `status`, `post`) VALUES ('".$id."', 'first', '".$url."', 'R', '');";
		$sql = new mysql("fish838");
		//exit("ff");
		$sql->query($str_sql);
		$sql->close();
		return;
		//exit("deal");
	}
	$action_get = is_get($content);
	$url_new = empty_deal($id); //最后一页
	if($action_get){
		$url_last = $url_new;
	}
	else{
		$url_last = $url_sou;
	}

	//exit($url_sou);
	//无预处理记录，找到预处理文件，提取链接插入下载队列
	//echo $url_last;
	//exit();
	if("" == $url_last){
		$url_last = $url_sou;
	}
	//exit($url_last);
	if("" == $url_last)
		return; //异常
	
	$fname = md5($url_last);
	$path = "../../../data/update_track/".$id."/".$fname.".html";
	//exit($path);
	$content = readfromfile($path);
	//echo $content;
	//exit();
	if("" == $content){ //无数据，插入预处理
		$title = "";
		$url = $url_sou;
		$post = "";
		$str_sql = "INSERT INTO `track_deal` (`sid`, `title`, `url`, `status`, `post`) VALUES ('".$id."', '', '".$url."', 'D', '');";
		//exit($str_sql);
		$sql = new mysql("fish838");
		//exit("ff");
		$sql->query($str_sql);
		$sql->close();
		return;
		//exit("deal");
	}
	$arr_link = (pick_pagelinks($content,$url_sou));
	//var_dump($arr_link);
	//exit();
	//去除重复链接
	//已存在链接
	$str_sql = "select url from track_section where tid='".$id."';";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	$len = count($arr);
	$arr_md5 = array(); //url(md5)=>true
	for($i = 0;$i < $len; ++$i){
		$url = $arr[$i][0];
		if("" == $url)
			continue;
		$md5 = md5($url);
		$arr_md5[$md5] = true;

	}
	$str_sql_f = "insert into track_deal (`sid`,`title`,`url`,`status`,`post`)values";
	$len = count($arr_link);
	//$bln_first = true;
	$lastkey = "";	
	$count = 0;
	//$action_get = true; //get方式
	$sql = new mysql("fish838");
	foreach($arr_link as $key=>$row){
		$url = $row[1];
		if("" == $url)
			continue;
		$lastkey = $key;
		if(isset($arr_md5[$key]))
			continue; //记录存在
		//if(!$bln_first)
		//	$str_sql .= ",";
		//$bln_first = false;
		$str_sql = $str_sql_f."('".$id."','".$row[0]."','".$url."','R','".$row[2]."');";
		//echo $str_sql."<br/>";
		$sql->query_ignore($str_sql);
		++$count;

		//echo $row[0]."<br/>\n";
		//if(++$count > 10)
		//	break; //sql语太大会死掉
	}
	$sql->close();
	if($count > 0)
		return;
	//重新下载最后一页,无论get或post统一用get方式
	if($action_get){ //get方式
		/*$str_sql = "update track_section set used='N'  where url ='".$url_last."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		*/
		$title = "last";
		$url = $url_last;
		$post = "";
		$str_sql = "insert into track_deal (`sid`,`title`,`url`,`status`,`post`)values('".$id."','".$title."','".$url."','D','".$post."');";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
	}
	else{ //post
		/*$str_sql = "update track_section set used='N'  where url ='".$url_last."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();*/
		//下载首页
		$title = "first";
		$url = $url_sou;
		$post = "";
		$str_sql = "insert into track_deal (`sid`,`title`,`url`,`status`,`post`)values('".$id."','".$title."','".$url."','D','".$post."');";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		//下载最后一页
		if("" == $lastkey)
			return;
		if(!isset($arr_link[$lastkey]))
			return;
		$title = "last";
		$url = $arr_link[$lastkey][1];
		$post = $arr_link[$lastkey][2];
		$str_sql = "insert into track_deal (`sid`,`title`,`url`,`status`,`post`)values('".$id."','".$title."','".$url."','D','".$post."');";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		/**/
	}

}
function track_sou($id=-1)
{
	//追踪源地址
	//输入:id(int)来源索引页ID
	//输出:url地址,异常返回空字符串
	$str_sql = "select url from update_track where id='".$id."';";
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_rows();
	if(count($arr) < 1)
		return "";
	return $arr[0][0];
}
function check_new($id = -1,$flag=-1)
{
	//是否有新章节
	//输入:id(int)来源索引页ID,flag来源网站标志
	//输出:有更新来源列表字符串
	$str_sql = "select tid from track_section where used='N' group by tid order by tid asc;";
	
	//return "aa";
	//exit($str_sql);
	//return $str_sql;
	//$str_sql = "select * from track_section where used='N';";
	$sql = new mysql();
	$sql->query($str_sql);
	$sql->close();
	//var_dump($sql->get_num_rows());
	//exit();
	$arr = $sql->get_array_rows();
	//var_dump($arr);
	//exit();
	$len = count($arr);
	if($len < 1)
		return "";
	//return "aa";
	$ls = "";
	for($i = 0;$i < $len; ++$i){
		if("" != $ls)
			$ls .= ",";
		$ls .= $arr[$i][0];
	}
	//exit($ls);
	return $ls;
}
function check_newtianya($id=-1)
{
	//天涯分页最新
	//输入:id来源ID
	//输出:true,false
	//var_dump(intval($arr[0][0]));
	//exit("dd");
	//检查最后一页有否更新
	my_safe_include("mwjx/track.php");
	my_safe_include("mwjx/class_info.php");
	$str_sql = "select * from track_section where tid='".$id."' and used='Y' order by id DESC limit 1;";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	$arr = $sql->get_array_array();
	//var_dump($arr);
	//exit();
	if(1 != count($arr))
		return false;
	
	$url_new = $arr[0]["url"]; //最后一页
	$old_hash = $arr[0]["hash"]; //旧内容hash
	if("" == $url_new)
		return false;
	
	$fname = md5($url_new);
	$path = "../../../data/update_track/".$id."/".$fname.".html";
	//exit($path);
	$content = readfromfile($path);
	//exit($content);
	if("" == $content)
		return false;
	//exit("rr");
	$objinfo = new c_class_info(get_track_cid($id));
	if($objinfo->get_id() < 1)
		return false;
	$author = trim($objinfo->get_author());
	if("" == $author)
		return false;
	//exit($author);
	//$txt = ;
	//var_dump(txt_tianya(strtolower($content),$author));
	//exit();
	$new_hash = md5(txt_tianya($content,$author));		
	//var_dump($new_hash == $old_hash);
	//exit();
	if($new_hash == $old_hash)
		return false;
	//更新
	$str_sql = "update track_section set used='N',hash='".$new_hash."' where id='".$arr[0]["id"]."';";
	//exit($str_sql);
	$sql = new mysql("fish838");
	$sql->query($str_sql);
	$sql->close();
	return true;
}
function is_get(&$str)
{
	//是否get方式网页
	//输入:$str(string)页面内容
	//输出:true是get方式,false是post方式
	preg_match_all("|<table><tr><td>分页链接：(.*?)<\/td><\/tr><\/table>|s",$str,$out);
	//var_dump($out);
	//exit();
	$txt = $out[1][0];
	//exit($txt);
	if("" != $txt)
		return true;
	return false;

}
function pick_pagelinks(&$str,$urlsou="")
{
	//提取分页链接
	//输入:$str(string)页面内容,$urlsou来源地址
	//输出:url数组url(md5)=>array(array(title,url,post))
/*
<table><tr><td>分页链接：[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1049300.shtml>首页</a>]&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1106915.shtml><font color=blue>[93]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1107135.shtml><font color=blue>[94]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1107477.shtml><font color=blue>[95]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1108012.shtml><font color=blue>[96]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1108395.shtml><font color=blue>[97]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1109018.shtml><font color=blue>[98]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1109428.shtml><font color=blue>[99]</font></a>&nbsp;<font color=black>[100]</font>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110047.shtml><font color=blue>[101]</font></a>&nbsp;<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110601.shtml><font color=blue>[102]</font></a>&nbsp;[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110047.shtml>下一页</a>]&nbsp;[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110601.shtml>末页</a>]&nbsp;[<a style=text-decoration:underline; href=http://cache.tianya.cn/publicforum/content/free/1/1110601.shtml>回复此帖</a>]&nbsp;</td></tr></table>
*/
	
	//exit($str);
	preg_match_all("|<table><tr><td>分页链接：(.*?)<\/td><\/tr><\/table>|s",$str,$out);
	//var_dump($out);
	//exit();
	$txt = $out[1][0];
	//exit($txt);
	if("" != $txt){ 
		$arr = match_links($txt);
		$re = array(); 
		$len = count($arr["link"]);
		for($i = 0;$i < $len; ++$i){
			$url = trim($arr["link"][$i]);
			$title = trim(strip_tags($arr["content"][$i]));
			/*if(false !== strstr($title,"首页"))
				continue;
			if(false !== strstr($title,"上一页"))
				continue;
			if(false !== strstr($title,"下一页"))
				continue;
			if(false !== strstr($title,"末页"))
				continue;
			*/
			if(false === strstr($title,"["))
				continue; //去掉首页末页等
			$md5 = md5($url);
			//echo $title.":".$url."<br/>";
			if(isset($re[$md5]))
				continue;
			//echo $title.":<br/>".$url."<br/>";
			$re[$md5] = array($title,$url,"");
		}
		//var_dump($re);
		//exit();
		return $re;
	}
	//可能是post分页
	//exit("ff");
	preg_match_all("|<input type=\"hidden\" name=\"apn\" value=\"(.*?)\">|s",$str,$out);
	$txt = $out[1][0];
	//var_dump($txt);
	$arr = explode(",",$txt);
	$len = count($arr);
	$re = array(); 
	$txt = urlencode($txt);
	$txt = "intLogo=0&rs_permission=1&apn=".$txt."&pID=";	
	//echo $txt;
	//exit();
	for($i = 0;$i < $len; ++$i){
		//echo $arr[$i]."<br>";
		//exit();
		$id = intval($arr[$i]);		
		if($id < 1)
			continue;
		$page = ($i + 1);
		$url = $urlsou."#".$id;
		$title = "P".$page;
		$md5 = md5($url);
		//echo $title.":".$url."<br/>";
		//break;
		if(isset($re[$md5]))
			continue;
		//echo $title.":<br/>".$url."<br/>";
		$post = $txt.$page;
		//echo $post;
		//break;
		$re[$md5] = array($title,$url,$post);
	}
	return $re;
	//var_dump($re);
	//exit();


	/*
intLogo=0&rs_permission=1&apn=8478045%2C8504172%2C8513978%2C8522971%2C8532967%2C8540548%2C8546964%2C8553317%2C8559000%2C8564172%2C8568338%2C8571941%2C8574478%2C8578881%2C8582367%2C8585446%2C8588241%2C8590373%2C8592579%2C8595148%2C8597159%2C8599359%2C8601864%2C8604618%2C8606761%2C8608918%2C8610817%2C8612550%2C8614987%2C8616246%2C8617440%2C8619812%2C8621871%2C8623434%2C8625800%2C8627724%2C8630288%2C8633087%2C8635856%2C8638559%2C8641447%2C8644299%2C8646905%2C8649819%2C8652762%2C8655544%2C8657455%2C8659549%2C8661185%2C8663103%2C8664511%2C8666017%2C8668392%2C8669995%2C8672247%2C8674528%2C8676621%2C8678527%2C8680908%2C8682583%2C8685302%2C8687125%2C8689051%2C8691233%2C8693855%2C8695860%2C8697786%2C8699950%2C8701377%2C8702845%2C8704788%2C8706208%2C8707200%2C8708978%2C8709734%2C8710492%2C8712051%2C8712841%2C8714155%2C8715777%2C8717738%2C8719000%2C8720815%2C8722494%2C8724235%2C8725891%2C8727386%2C8729527%2C8731524%2C8733133%2C8734216%2C8736552%2C8738675%2C8741289%2C8743527%2C8745546%2C8747365%2C8749058%2C8750415%2C8751861%2C8753351%2C8754929%2C8756370%2C8757860%2C8758601%2C8759614%2C8760912%2C8762170%2C8763403%2C8764739%2C8765611%2C8766339%2C8767923%2C8769144%2C8770465%2C8771739%2C8772878%2C8773653%2C8775028%2C8776217%2C8777911%2C8779921%2C8780891%2C8782373%2C8784578%2C8785708%2C8787201%2C8789049%2C8790612%2C8792280%2C8794350%2C8795869%2C8797092%2C8799524%2C8801104%2C8802634%2C8804309%2C8805858%2C8807569%2C8809357%2C8810575%2C8812507%2C8814030%2C8815491%2C8816654%2C8818131%2C8819525%2C8820813%2C8822173%2C8822942%2C8824107%2C8824742%2C8825619%2C8826632%2C8828396%2C8830149%2C8831239%2C8832542%2C8833751%2C8835387%2C8837586%2C8839310%2C8840418%2C8841760%2C8842767%2C8844314%2C8846420%2C8847920%2C8849777%2C8851646%2C8853494%2C8855069%2C8856430%2C8858301%2C8859512%2C8861301%2C8862857%2C8864207%2C8865712%2C8867504%2C8869360%2C8870909%2C8872117%2C8873478%2C8875014%2C8876197%2C8877083%2C8878021%2C8878994%2C8880361%2C8881620%2C8882907%2C8884601%2C8886335%2C8887644%2C8889003%2C8889835%2C8890896%2C8892112%2C8893644%2C8895228%2C8897191%2C8899684%2C8900997%2C8902727%2C8904738%2C8905989%2C8907271%2C8908921%2C8910037%2C8911331%2C8912822%2C8914094%2C8916150%2C8917808%2C8919151%2C8920122%2C8921772%2C8923599%2C8925161%2C8926728%2C8927653%2C8928809%2C8930319%2C8931287%2C8932365%2C8933508%2C8934452%2C8935504%2C8937039%2C8938229%2C8939135%2C8940461%2C8941612%2C8942691%2C8943518%2C8944646%2C8945834%2C8946874%2C8947753%2C8948753%2C8949926%2C8951101%2C8951777%2C8953048%2C8954168%2C8955227%2C8956424%2C8957554%2C8958523%2C8960144%2C8961407%2C8962361%2C8963692%2C8964490%2C8965393%2C8966591%2C8967561%2C8968484%2C8969738%2C8970641%2C8971925%2C8972997%2C8974202%2C8975093%2C8976023%2C8977195%2C8977742%2C8979336%2C8980100%2C8981004%2C8982966%2C8983904%2C8985243%2C8986581%2C8987988%2C8988757%2C8989889%2C8990702%2C8991426%2C8993213%2C8993963%2C8994734%2C8996142%2C8996907%2C8998075%2C8999359%2C8999961%2C9000713%2C9002158%2C9002939%2C9003784%2C9004557%2C9005573%2C9006491%2C9008117%2C9009190%2C9009764%2C9010292%2C9010685%2C9011733%2C9013532%2C9015020%2C9015664%2C9016878%2C9018100%2C9019137%2C9020602%2C9021686%2C9022904%2C9024558%2C9026102%2C9027477%2C9029201%2C9029859%2C9030908%2C9032403%2C9033235%2C9034236%2C9036070%2C9037519%2C9038267%2C9040241%2C9041457%2C9042337%2C9044424%2C9045874%2C9047126%2C9048622%2C9050349%2C9051870%2C9053607%2C9055317%2C9056875%2C9058353&pID=333
	*/
}
function match_links($document)
{   
    preg_match_all("'<\s*a\s.*?href\s*=\s*([\"\'])?(?(1)(.*?)\\1|([^\s\>]+))[^>]*>?(.*?)</a>'isx",$document,$links);                       
    while(list($key,$val) = each($links[2])){
        if(!empty($val))
            $match['link'][] = $val;
    }
    while(list($key,$val) = each($links[3])){
        if(!empty($val))
            $match['link'][] = $val;
    }       
    while(list($key,$val) = each($links[4])){
        if(!empty($val))
            $match['content'][] = $val;
    }
    while(list($key,$val) = each($links[0])){
        if(!empty($val))
            $match['all'][] = $val;
    }               
    return$match;
}
?>