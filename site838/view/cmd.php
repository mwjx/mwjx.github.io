<?php
//------------------------------
//create time:2006-3-22
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:处理请求
//------------------------------
require("../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/interface.php");
my_safe_include("class_man.php");
my_safe_include("mwjx/authorize.php");
my_safe_include("lib/fun_global.php");
//goto_url("","aaa");
session_start();
$m_fun = isset($_GET["fun"])?$_GET["fun"]:"";
if("" == $m_fun)
	$m_fun = isset($_POST["fun"])?$_POST["fun"]:"";
$m_fun = trim($m_fun);
//header("Content-Type: text/html;charset=GBK");
if("" == $m_fun)
	exit("没有命令");
//$m_fun = "vote";
//游客
switch($m_fun){
	case "login_reg_out":
		//var_dump($_POST);
		//exit();		
		$cookietime=time()+86400*365; //一天
		//$cookietime *= 365; //一年
		$name = isset($_POST["name"])?$_POST["name"]:"";
		$pswd = isset($_POST["password"])?$_POST["password"]:"";
		$name = addslashes($name);
		$pswd = crypt(addslashes($pswd),"d.r");
		switch($_POST["action"]){
			case "login": //
				$obj = new manbase_2($name);
				if($obj->get_id() < 1){
					//var_dump($obj);
					exit("无此用户或用户失效:".$name);
				}
				if($pswd != $obj->get_pswd())
					exit("密码不正确!");
				setcookie("username",$name,$cookietime,"/");
				setcookie("userpass",$pswd,$cookietime,"/");
				exit("登录成功!");
				break;
			case "reg":
				//注册
				$currentuser = isset($_COOKIE["username"])?trim($_COOKIE['username']):"";
				if("" != $currentuser)
					exit("不能注册，请先退出登录!");
				$obj = new manbase_2($name);
				if($obj->get_id() > 0){
					//var_dump($obj);
					exit("注册失败，用户名已存在:".$name);
				}
				$new_man=new manbase_2();
				$result = $new_man->reg($name,$pswd);
				if(false == $result[0])
					exit($result[1]);
				//登录
				setcookie("username",$name,$cookietime,"/");
				setcookie("userpass",$pswd,$cookietime,"/");
				exit("注册成功!");
				break;
			case "out":
				setcookie("username","",$cookietime,"/");
				setcookie("userpass","",$cookietime,"/");
				exit("退出登录成功!");
				break;
			default:
				//assert(0);
				exit("没人该命令:".$m_fun);
		}
		//var_dump($_POST);
		//exit();
		break;
	default:
		break;
}

//可以不用登录执行的操作
$m_arr_free = array("reply"=>true,"vote_article"=>true,"recommend_article"=>true,"rm_article"=>true,"good_article"=>true,"set_star"=>true,"helpmwjx"=>true,"report_err"=>true,"auto_book"=>true);

$m_guest_id = 200200167;//200200167,游客专用ID
//用户
$obj_face = new c_interface;
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(!isset($m_arr_free[$m_fun])){ //这个命令必须登录用户才可操作
	if(round($obj_man->get_id()) < 1){
		goto_url("/site838/view/login.php","当前用户无效，请先登录或注册");
		//exit("当前用户无效");
	}
}
//符合本代理的接口传回值规范
//结果数组,第一项是url(可为空字符串),第二项是字符串说明,第三项是标志位
$m_arr_re = array();  
switch($m_fun){
	case "vote_book": //小说投票
		if($obj_man->get_id() < 1)
			exit("RE:-3"); //没有登录
		//exit("OK");
		$id = intval($_POST["id"]);
		if($id < 1)
			exit("RE:-2");
		$re = $obj_face->vote_book($id,$obj_man->get_id());
		exit("RE:".$re);
		break;
	case "new_class": //新建类目
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,3)){
			$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
			$str_xml .= "<msg>无权创建类目</msg>";
			print_xml($str_xml);		
			break;
		}
		//xml_result("<aaa>bbb</aaa>");
		$fid = intval(isset($_GET["fid"])?$_GET["fid"]:"");
		$name = addslashes(isset($_GET["name"])?$_GET["name"]:"");
		//新建书目
		$cdir = addslashes(isset($_GET["cdir"])?$_GET["cdir"]:"N"); 
		//添加
		my_safe_include("mwjx/class_info.php");
		$objc = new c_class_info;
		$arg = array("name"=>$name,"fid"=>$fid,"creator"=>$obj_man->get_id(),"memo"=>"");
		$re = $objc->add($arg);
		//writetofile("xxx.txt","添加完成：".$name);

		//回复
		$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
		if(true === $re){
			//$str_xml .= "<msg>".htmlspecialchars("创建类目成功")."</msg>";
			$re = "创建类目成功";
			$str_xml .= "<msg>".htmlspecialchars($re)."</msg>";
			//加入权限
			$obj->set_can($obj_man->get_id(),2,$objc->get_addid(),0);
		}
		else{
			$str_xml .= "<msg>".htmlspecialchars($re)."</msg>";
		}
		//writetofile("xxx.txt","添加完成：".$str_xml);
		//$str_xml .= "<result><fid>".$fid."</fid><name>".$name."</name></result>";
		//$str_xml = xml_result_head()."<msg>".$fid."</msg>";		
		//writetofile("xxx.xml",$str_xml);
		print_xml($str_xml);		
		//xml_result("<msg>".$fid."</msg>");
		break;
	case "del_class": //删除类目
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,4)){
			$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
			$str_xml .= "<msg>无权删除类目</msg>";
			print_xml($str_xml);		
			break;
		}
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($id);
		$re = $obj->del();				
		//$re = true;
		//回复
		$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
		if(true === $re)
			$str_xml .= "<msg>删除类目成功</msg>";
		else
			$str_xml .= "<msg>".htmlspecialchars($re)."</msg>";
		print_xml($str_xml);		
		break;
	case "set_article": //文章归类
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,6))
			exit("FAIL"); //无权操作
		
		$info = (isset($_POST["info"])?$_POST["info"]:"");
		//writetofile("xxx.txt",$info);
		include_once("./src_php/control/article_reset.php");
		if(true === ($re = article_reset($info)))
			exit("OK");
		else
			exit($re);
		break;
	case "link_class": //链接类目
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,15))
			exit("FAIL"); //无权操作
		//exit("OK");
		$info = (isset($_POST["info"])?$_POST["info"]:"");
		//writetofile("xxx.txt",$info);
		include_once("./src_php/control/class_link.php");
		if(true === ($re = link_class($info)))
			exit("OK");
		else
			exit($re);
		break;
	case "set_article_links": //设置文章相关链接
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,9))
			exit("FAIL"); //无权操作
		//exit("OK");
		
		$info = (isset($_POST["list"])?$_POST["list"]:"");
		$id = (isset($_POST["id"])?$_POST["id"]:"");
		if("" == $id)
			exit("masterid is not exists");
		//writetofile("xxx.txt",$info);
		my_safe_include("mwjx/link.php");
		$obj = new c_link;
		if(true === ($re = $obj->set_links($id,$info)))
			exit("OK");
		else
			exit("set fail");
		/**/
		break;
	case "run_article_links": //设置文章相互链接
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,9))
			exit("FAIL"); //无权操作
		//exit("OK");		
		$info = (isset($_POST["list"])?$_POST["list"]:"");
		//$id = (isset($_POST["id"])?$_POST["id"]:"");
		//if("" == $id)
		//	exit("masterid is not exists");
		//writetofile("xxx.txt",$info);
		my_safe_include("mwjx/link.php");
		$obj = new c_link;
		//exit("OK");
		if(true === ($re = $obj->run_links($info)))
			exit("OK");
		else
			exit("run_links fail");
		/**/
		break;
	case "unlink_article": //取消文章链接
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,7))
			exit("无权操作"); //无权操作

		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:"");
		$id = intval(isset($_POST["id"])?$_POST["id"]:"");		//writetofile("xxx.txt",$info);
		include_once("./src_php/control/article_unlink.php");
		if(true === ($re = unlink_article($cid,$id)))
			exit("OK");
		else
			exit($re);
		break;
	case "unlink_class": //取消类目链接
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,18))
			exit("无权操作"); //无权操作

		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:"");
		$sid = intval(isset($_POST["id"])?$_POST["id"]:"");		//writetofile("xxx.txt",$info);
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($cid);
		if($obj->get_id() < 1){
			exit("类目无效");
			//$m_arr_re = array("","类目无效");
			//break;		
		}
		//include_once("./src_php/control/article_unlink.php");
		if(true === ($re = $obj->unlink_class($sid)))
			exit("OK");
		else
			exit("操作失败，可能取消的类目不是链接类目");
		break;
	case "post_article838": //发布文章838
		//$m_arr_re = array("","aaa");		
		//break;
		$mb = intval(isset($_POST["mb"])?$_POST["mb"]:-1); //藏书ID
		//文章ID,-1新增,>0更新修改
		$aid = intval(isset($_POST["hd_aid"])?$_POST["hd_aid"]:-1); 
		//类目ID
		$cid = (isset($_POST["clist"])?$_POST["clist"]:-1);
		$title = ((isset($_POST["title"])?$_POST["title"]:""));
		$content = ((isset($_POST["content"])?$_POST["content"]:""));
		//来源章节ID列表
		$id_ls = (isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		//supper超级发帖器/F前台/B后台
		$ref = isset($_POST["ref"])?$_POST["ref"]:"F"; 
		$obj = new c_authorize;		
		if(!($obj->can_do($obj_man,2,$cid,0) || $obj->can_do($obj_man,3,$mb,0))){
			if("B" == $ref)
				exit("-2");
			else
				$m_arr_re = array("","无权操作");			
			break;
		}
		if("B" == $ref){
			$title = iconv('UTF-8','GB2312//IGNORE',$title);
			$content = iconv('UTF-8','GB2312//IGNORE',$content);
		}
		//exit("aa:".$title);
		my_safe_include("mwjx/track.php");
		if(($aid=post_track838($aid,$cid,$title,$content)) < 1){
			if("B" == $ref)
				exit("".$aid);
			else
				$m_arr_re = array("","添加失败");		
			break;
		}
//		if("supper" == $ref){ //超级发贴器提交过来的
//			$str = "window.parent.post_segment();";
//			exit("<script language=\"javascript\">".$str."</script>")
//		}

		//设为已读
		$str_sql = "update track_section set used='Y' where id in(".$id_ls.");";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();

//		//更新静态文件
//		add_static(strval($aid),"A","Y");
//		add_static(strval($cid),"C","Y");
		if("B" == $ref)
			exit("".$aid);
		else
			$m_arr_re = array("refresh",""); //成功
		break;
	case "post_article": //发布文章
		$aid = intval(isset($_POST["hd_aid"])?$_POST["hd_aid"]:-1);
		$clist = (isset($_POST["clist"])?$_POST["clist"]:"");
		$title = ((isset($_POST["title"])?$_POST["title"]:""));
		$content = ((isset($_POST["content"])?$_POST["content"]:""));
		$ref = isset($_POST["ref"])?$_POST["ref"]:"";
		$dirid = intval(isset($_POST["dir_id"])?$_POST["dir_id"]:-1);
		$id_ls = (isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		//$m_arr_re = array("","title=".$title);
		//break;
		if(strlen($title) > 255){
			$m_arr_re = array("","标题长度超出，最大长度：255");
			break;		
		}
		$obj = new c_authorize;		
		if($aid > 0){ //编辑文章
			if(!$obj->can_do($obj_man,1,1,12)){
				$m_arr_re = array("","无权操作");			
				break;
			}
		}
		else{ //发布文章
			if(!$obj->can_do($obj_man,1,1,1)){
				$m_arr_re = array("","无权操作");			
				break;
			}
		}
		if(strlen($content) > 100000){
			//exit("内容长度超出限制:".strval(strlen($content)));
			$m_arr_re = array("","内容长度超出限制:".strval(strlen($content)));
			break;
		}
		if("track" == $ref && "" != $id_ls){
			//设为已读
			$str_sql = "update track_section set used='Y' where id in(".$id_ls.");";
			$sql = new mysql("fish838");
			$sql->query($str_sql);
			$sql->close();
		}			include_once("./src_php/control/article_post.php");
		if($aid > 0){ //编辑文章
			$re = edit_article($aid,$title,$content);
			if($re){ //成功
				$cid = 12;
				$url = "/mwjx/src_php/data_article.php?id=".strval($aid)."&r_cid=".$cid;
				$m_arr_re = array("","编辑成功");
				//------添加到书目---------
				$icid = intval($cid);
				if("track" == $ref && $dirid > 0 && $icid > 0){
					my_safe_include("mwjx/class_dir.php");
					$objdir = new c_class_dir;
					$arr_dir = ($objdir->get_dir($dirid));
					if(count($arr_dir) > 0){
						$dirtitle = $arr_dir[0]["title"];
						$dircontent = $arr_dir[0]["content"];
						//$dircontent .= "\n";
						$row = explode("\n",$dircontent);
						$len = count($row);
						$newcontent = "";
						$strkey = $aid."`|)";
						$newtitle .= $aid."`|)".$title;
						for($i = 0;$i < $len; ++$i){
							if("" == $row[$i])
								continue;
							if("" != $newcontent)
								$newcontent .= "\n";
							if(!strstr($row[$i],$strkey))
								$newcontent .= $row[$i];
							else 
								$newcontent .= $newtitle;
						}
						//$dircontent=preg_replace("/"$aid."`|)(.*?)/is",$newtitle,$dircontent);
						$objdir->up_dir($dirid,$icid,$dirtitle,$newcontent);
					}
				}
				//如果是自动覆盖旧章节
				// && "Y" == $_POST["autoadd"]
				//refresh
				if("track" == $ref){
					//$m_arr_re = array("",($_POST["chk_cover"]));
					if("Y" == $_POST["autoadd"])
						$m_arr_re = array("refresh","");
					else
						$m_arr_re = array("refresh","");
					/**/
				}

			}
			else{ //失败
				$m_arr_re = array("","编辑失败，可能该文章已损坏");
			}						
			break;
		}
		//发布新文章
		//$m_arr_re = array("","title=".$title);
		//break;
		//$m_arr_re = array("",$obj_man->get_name());
		//break;
		$good = "N";
		if("track" == $ref)
			$good = "Y";
		if(200200067 == $obj_man->get_id())
			$good = "Y"; //管理员自动精华
		if(($re = post_article($title,$content,$clist,$obj_man->get_name(),$good)) < 0){
			$m_arr_re = array("","发布失败，原因代码:".strval($re));
			//exit("发布失败，原因代码:".strval($re));
			break;
		}	
		$cid = "";
		if(false === strpos($clist,',',0)){			
			$cid = $clist;
		}
		else{
			$arr = explode(",",$clist);
			$cid = strval($arr[0]);
		}
		//------添加到书目---------
		$icid = intval($cid);
		if("track" == $ref && $dirid > 0 && $re > 0 && $icid > 0){
			my_safe_include("mwjx/class_dir.php");
			$objdir = new c_class_dir;
			$arr_dir = ($objdir->get_dir($dirid));
			if(count($arr_dir) > 0){
				$dirtitle = $arr_dir[0]["title"];
				$dircontent = $arr_dir[0]["content"];
				$dircontent .= "\n";
				$dircontent .= $re."`|)".$title;
				$objdir->up_dir($dirid,$icid,$dirtitle,$dircontent);
			}
		}
	
		$url = "/mwjx/src_php/data_article.php?id=".strval($re)."&r_cid=".$cid;
		//exit($url);
		$obj_man->log_update();
		//Header("Location: ".$url);
		//exit($url);
		if("supper" == $ref){ //超级发贴器提交过来的
			$str = "window.parent.post_segment();";
			exit("<script language=\"javascript\">".$str."</script>");		
			//$m_arr_re = array("","");
		}
		else if("track" == $ref){
			//$m_arr_re = array($url,"");
			if("Y" == $_POST["autoadd"])
				$m_arr_re = array("refresh","");
			else
				$m_arr_re = array("refresh","");
		}
		else{
			//$m_arr_re = array($url,"");
			$m_arr_re = array("","发布成功");
		}
		break;
	case "create_index": //生成网站及栏目首页
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,5))
			exit("无权操作"); //无权操作
		my_safe_include("fish/class_bbsmanager.php");
		my_safe_include("mwjx/top.php");
		$obj_manager = new c_bbsmanagerbase;
		$obj_top = new c_top;
		//exit($obj_top->write_top());
		//writetofile("xxx.txt","xxx");
		
		//$obj_manager->create_html_bookstore(); //生成书库首页
		//$re = 
		//exit($re);
		//-------生成某个讨论板栏目首页-----------
		if($obj_manager->create_indexforumboard("0"))
			exit("success");
		else
			exit("fail");		
		//if($obj_top->write_last() && $obj_top->write_top() && $obj_manager->create_indexforumboard("0"))
		//	exit("success");
		//else
		//	exit("fail");
		break;
	case "create_link": //生成文章相关
		if(!$obj_man->check_super_manager())
			exit("无权操作");
		my_safe_include("mwjx/run_link.php");
		$obj = new c_run_link;
		if($obj->run())
			exit("success");
		else
			exit("fail");
		break;
	case "reply": //跟贴留言		
		$type = isset($_POST["reply_type"])?$_POST["reply_type"]:"";
		if("class" != $type && "article" != $type && "lib" != $type){
			$m_arr_re = array("","跟贴类型无效");
			break;				
		}
		if($obj_man->get_id() < 1){
			$m_arr_re = array("","留言评论请先登录");
			break;						
		}

		$content = addslashes(isset($_POST["message"])?$_POST["message"]:"");
		if("" == $content){
			$m_arr_re = array("","内容不能为空");
			break;						
		}
		if(strlen($content) > 20000){
			$m_arr_re = array("","内容长度超出限制");
			break;								
		}

		$flag = 0;
		$id = -1;
		//检查被留言对象是否有效,略
		$flag = 1;
		$id = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		if($id < 1){
			//exit("跟贴类目无效");
			$m_arr_re = array("","跟贴类目无效");
			break;											
		}
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($id);
		if($obj->get_id() < 1){
			//exit("类目无效");
			$m_arr_re = array("","类目无效");
			break;		
		}
		//用户直接留言
		//$m_arr_re = array("",$id."--".$flag."--".$obj_man->get_id()."--".$content);
		//break;				
		my_safe_include("mwjx/reply.php");
		$obj = new c_reply;
		if($obj->reply($content,$id,$flag,$obj_man->get_id())){ //成功
			$url = "refresh";
			$m_arr_re = array($url,"提交成功，如果你在静态html页面，留言可能不会即时显示");
			break;		
			//goto_url($url,"提交成功",2);
			//exit($url);		
		}
		else{ //失败
			//exit("留言失败，原因未知");
			$m_arr_re = array("","留言失败，原因未知");
			break;		
		
		}
		break;
	case "rm_reply": //删除跟贴
		$id = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$type = (isset($_GET["type"])?$_GET["type"]:"");
		if("O" != $type && "N" != $type){
			$m_arr_re = array("","删除跟贴评论失败,跟贴版本类型无效:".$type);
			break;
		}
		if($id < 1){
			$m_arr_re = array("","删除跟贴评论失败,跟贴ID无效:".$id);
			break;
		}
		//$m_arr_re = array("","删除跟贴,".$id.",".$type);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,14)){ //无权限，等待审核
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$re = $obj_action->add($obj_man->get_id(),14,$id.",".$type);
			if($re){	
				$m_arr_re = array("","删除跟贴评论成功，需要等待有权限的网友审核通过才能生效");					
			}
			else{
				$m_arr_re = array("","删除跟贴评论失败，原因未知");
			}
			break;
		}
		//有权限，直接操作
		my_safe_include("mwjx/reply.php");
		$obj_reply = new c_reply;
		$re = $obj_reply->rm($id,$type);
		if(true !== $re)
			$m_arr_re = array("","删除失败，原因未知");
		else
			$m_arr_re = array("refresh","删除成功:".$id);		
		break;
	case "rm_article": //逻辑删除文章
		//$m_arr_re = array("","删除文章");
		//break;
		if(!check_confcode("conf_delarticle"))
			exit(); //这步有多余之嫌
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,8)){ //无权限，等待审核
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;
			$re = $obj_action->add($requester,8,strval($id));
			if($re){	
				$m_arr_re = array("","删除文章成功，需要等待有权限的网友审核通过才能生效");					
			}
			else{
				$m_arr_re = array("","删除文章失败，可能是文章或类目无效");
			}
			break;
		}
		//有权限，直接操作
		my_safe_include("class_forum.php");
		$str_id = "400400003428";
		$forum = new c_forumbase($str_id);
		$re = $forum->del_article_update($id);
		if(true !== $re)
			$m_arr_re = array("",$re);
		else
			$m_arr_re = array("","删除成功:".$id);
		break;
	case "set_star": //文章评级,类目评级
		if(!check_confcode("conf_star"))
			exit(); //这步有多余之嫌		
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		$otype = (isset($_GET["otype"])?$_GET["otype"]:"");
		$star = intval(isset($_POST["slt_star"])?$_POST["slt_star"]:"0");
		my_safe_include("mwjx/top_star.php");
		$obj = new c_authorize;		
		if("class" == $otype){ //类目评级
			if(!$obj->can_do($obj_man,1,1,21)){ //无权限
				$m_arr_re = array("","操作失败，无权限");
				break;
			}
			//有权限，直接操作
			$obj_star = new c_top_star(1);		
			$re = $obj_star->set_star($id,$star,2);
			if(true !== $re)
				$m_arr_re = array("","评级失败");
			else
				$m_arr_re = array("","评级成功:".$id);
			break;
		}
		//文章评级
		if(!$obj->can_do($obj_man,1,1,10)){ //无权限，等待审核
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;

			$re = $obj_action->add($requester,10,$id.",".$star);
			if($re){	
				$m_arr_re = array("","文章评级成功，需要等待有权限的网友审核通过才能生效");					
			}
			else{
				$m_arr_re = array("","文章评级失败，可能是文章或类目无效");
			}
			break;
		}
		//有权限，直接操作
		$obj_star = new c_top_star(1);		
		$re = $obj_star->set_star($id,$star,1);
		if(true !== $re)
			$m_arr_re = array("","评级失败");
		else
			$m_arr_re = array("","评级成功:".$id);		
		break;
	case "recommend_article": //推荐文章到类目
		if(!check_confcode("conf_recommend"))
			exit(); //这步有多余之嫌		
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		$cid = intval(isset($_GET["cid"])?$_GET["cid"]:"");
		my_safe_include("mwjx/top_star.php");
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,11)){ //无权，等待审核
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;
			$re = $obj_action->add($requester,11,$id.",".$cid);
			if($re){	
				$m_arr_re = array("","推荐文章到类目成功，需要等待有权限的网友审核通过才能生效");					
			}
			else{
				$m_arr_re = array("","推荐文章到类目失败，可能是推荐的文章或类目无效，或者该文章已经被推荐");
			}
			break;
		}
		//有权限，直接操作
		my_safe_include("mwjx/recommend.php");
		$obj_recommend = new c_recommend;
		if($obj_recommend->recommend_article($id,$cid)){
			$m_arr_re = array("","推荐成功");
		}
		else{
			$m_arr_re = array("","推荐失败，可能是文章或类目无效或该文已经被推荐,id=".$id.",cid=".$cid);
		}
		break;
	case "run_action": //审核事件
		$id = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$tid = intval(isset($_GET["tid"])?$_GET["tid"]:0);
		$effect = isset($_GET["effect"])?$_GET["effect"]:"";
		if("Y" != $effect && "N" != $effect){
			$m_arr_re = array("","操作标志无效");
			break;
		}
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,$tid)) //无权，等待审核
			$m_arr_re = array("","操作无效,无效审核");
		my_safe_include("mwjx/action_queue.php");
		$obj_queue = new c_action_queue;		
		if($obj_queue->run($id,$effect)){
			$m_arr_re = array("","审核完成");
			$title = "你提交的申请已经审核完成";
		}
		else{
			$m_arr_re = array("","审核失败，异常");
			$title = "你提交的申请审核中发生异常";
		}
		$title .= ",审核结果是:";
		$title .= (("Y" == $effect)?"被通过":"被拒绝");
		//发消息给提请人
		my_safe_include("mwjx/msg_dealer.php");
		$obj_msg = new c_msg_dealer;
		$sender = $obj_man->get_id();
		$receiver = -1;		
		$content = ""; //<content>
		$arr = $obj_queue->get_info($id);
		$receiver = $arr[0];
		$content .= "<txt>下面是你提交申请的相关信息,审核人:".$obj_man->get_name()."</txt>";
		$content .= $arr[2];
		$content .= ""; //</content>
		$obj_msg->write_msg($sender,$receiver,$title,$content);
		break;
	case "write_msg": //写站内短信
		//$m_arr_re = array("","功能未完成");
		$reveiver = isset($_POST["txt_receiver"])?$_POST["txt_receiver"]:"-1";
		$title = isset($_POST["txt_title"])?$_POST["txt_title"]:"";
		$content = isset($_POST["txt_content"])?$_POST["txt_content"]:"";
		if("" == $title || "" == $content){
			$m_arr_re = array("","标题和内容都不能为空");
			break;
		}
		//$m_arr_re = array("","内容:".$content);
		//break;

		if(strlen($title) > 250 || strlen($content) >10000){
			$m_arr_re = array("","标题或内容长度超出");			
			break;
		}
		$man_receiver = new manbase_2($reveiver);
		if($man_receiver->get_id() < 1){
			$m_arr_re = array("","收件人不存在，请检查收件人ID是否正确");
			break;
		}
		//发消息
		my_safe_include("mwjx/msg_dealer.php");
		$obj_msg = new c_msg_dealer;
		$sender = $obj_man->get_id();
		$receiver = $man_receiver->get_id();		
		//$content = ""; //<content>
		$content = "<txt>".addslashes($content)."</txt>";
		//$content .= ""; //</content>
		$obj_msg->write_msg($sender,$receiver,addslashes($title),$content);
		$m_arr_re = array("refresh","发送完成");
		break;
	case "batch_del": //批量删除
		//列表,格式:"id,id..."(id列表)
//		$m_arr_re = array("","del");
//		break;		
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){
			$m_arr_re = array("","无权限，不是管理员");
			break;
		}
//		if(!$obj->can_do($obj_man,1,1,8)){ //无权，等待审核
//			$m_arr_re = array("","无权限");
//			break;		
//		}
		$slist = isset($_POST["id_ls"])?$_POST["id_ls"]:"";			
		if("" == $slist){
			$m_arr_re = array("","删除失败，缺少文章ID");
			break;
		}
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info;
		$obj->rm_article($slist);
		//$m_arr_re = array("","re=".$re);
		$m_arr_re = array("refresh","");				
		/*include_once("./src_php/control/article_batch_del.php");
		if(true === ($re = batch_del($slist)))
			$m_arr_re = array("","设置成功");
		else
			$m_arr_re = array("",$re);
		*/
		//$m_arr_re = array("","批量设置精华完成".$slist);
		break;
	case "batch_good": //批量设置精华
		//$m_arr_re = array("","good");
		//break;		
		//列表,格式:"Y_id,id...;N_id,id..."(Y精华,N非精华)
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,16)){ //无权，等待审核
			$m_arr_re = array("","无权限");
			break;		
		}
		$slist = isset($_POST["slist"])?$_POST["slist"]:"";			
		include_once("./src_php/control/article_batch_good.php");
		if(true === ($re = batch_good($slist)))
			$m_arr_re = array("","设置成功");
		else
			$m_arr_re = array("",$re);
		//$m_arr_re = array("","批量设置精华完成".$slist);
		break;
	case "good_article": //设置精华文章
		$id = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$good = isset($_GET["good"])?$_GET["good"]:"";
		if("Y" != $good && "N" != $good){
			$m_arr_re = array("","设置精华失败，设置类型无效:".$good);
			break;
		}
		if("Y" == $good){
			if(!check_confcode("conf_good"))
				exit(); //这步有多余之嫌				
		}
		else{
			if(!check_confcode("conf_clgood"))
				exit(); //这步有多余之嫌				
		}
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,13)){ //无权，等待审核
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;

			$re = $obj_action->add($requester,13,$id.",".$good);
			if($re){	
				$m_arr_re = array("","设置精华成功，需要等待有权限的网友审核通过才能生效");					
			}
			else{
				$m_arr_re = array("","设置精华失败，原因未知");
			}
			break;
		}
		//有权限，直接操作
		my_safe_include("class_article.php");
		$obj_article = new articlebase($id);
		if($obj_article->get_id() < 1){
			$m_arr_re = array("","设置失败，文章无效:".$id);
			break;
		}
		//$obj_article->set_good($good);
		//$obj_article->enum_good = "N";
		$obj_article->set_good($good);
		if($obj_article->save_info()){
			$url = "/mwjx/src_php/data_article.php?id=".strval($id)."&r_cid=".$obj_article->get_class_id();
			$m_arr_re = array($url,"设置成功");
		}
		else{
			$m_arr_re = array("","设置失败，可能是文章无效,id=".$id);
		}
		break;
	case "add_classdir": //编辑书目
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,20)){ //无权，等待审核
			$m_arr_re = array("","无权限");
			break;		
		}		
		$dirid = intval(isset($_POST["dir_id"])?$_POST["dir_id"]:-1);
		$cid = intval(isset($_POST["txt_cid"])?$_POST["txt_cid"]:-1);
		$title = isset($_POST["txt_title"])?$_POST["txt_title"]:"";
		$ct = isset($_POST["txt_content"])?$_POST["txt_content"]:"";
		if("" == $title || $cid < 1){
			$m_arr_re = array("","参数不能为空");
			break;
		}
		$title = addslashes($title);
		$ct = addslashes($ct);
		my_safe_include("mwjx/class_dir.php");
		$obj_cd = new c_class_dir;
		if($dirid > 0) //更新
			$re = $obj_cd->up_dir($dirid,$cid,$title,$ct);
		else //添加
			$re = $obj_cd->add_dir($cid,$title,$ct);
		if($re)
			$m_arr_re = array("","提交成功");
		else
			$m_arr_re = array("","提交失败");
		break;
	case "collections": //收藏作品
		$oid = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$ctype = (isset($_GET["type"])?$_GET["type"]:"");
		my_safe_include("mwjx/collections.php");
		$obj = new c_collections;
		$re = $obj->collect($obj_man->get_id(),$oid,$ctype);
		if(true === $re)
			$m_arr_re = array("","收藏成功");
		else
			$m_arr_re = array("",$re);
		break;
	case "sitetop": //添加文章到今日头条
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,22)){ //无权，等待审核
			$m_arr_re = array("","无权限");
			break;		
		}		
		$oid = intval(isset($_GET["id"])?$_GET["id"]:-1);
		//$m_arr_re = array("","功能未完成");
		my_safe_include("mwjx/set_article.php");
		$set = new c_set_article;
		$re = $set->sitetop($oid);
		if(true === $re)
			$m_arr_re = array("","设置成功");
		else
			$m_arr_re = array("",$re);
		break;
	case "add_homepage": //推荐到首页
		//add_homepage
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,23)){ //无权，等待审核
			$m_arr_re = array("","无权限");
			break;		
		}		
		$oid = intval(isset($_GET["id"])?$_GET["id"]:-1);
		//$m_arr_re = array("","功能未完成");
		my_safe_include("mwjx/set_article.php");
		$set = new c_set_article;
		$re = $set->add_homepage($oid);
		if(true === $re)
			$m_arr_re = array("","设置成功");
		else
			$m_arr_re = array("",$re);
		break;
	case "reset_used": //设置跟踪已读
		//来源ID
		$tid = intval(isset($_REQUEST["autoadd"])?$_REQUEST["autoadd"]:"-1");
		//类目ID
		$cid = intval(isset($_REQUEST["clist"])?$_REQUEST["clist"]:"-1");
		//提交方式F表单/B数据提交
		$ref = (isset($_REQUEST["ref"])?$_REQUEST["ref"]:"F"); 
		//$m_arr_re = array("refresh","ref:".$ref);
		//break;		
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){ //无权，等待审核
			if("F" == $ref){ //前台提交
				$m_arr_re = array("","无权限");
			}
			else{
				exit("N");
			}
			break;		
		}
	
		$read = isset($_POST["content"])?$_POST["content"]:"Y";
		if("F" == $ref){
			$str_sql = "update track_section set used='".$read."' where id in(".$_POST["id_ls"].");";
		}
		else{
			$str_sql = "update track_section set used='Y' where tid ='".$tid."' and used='N';";
		}
	
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		if("F" == $ref){
			$m_arr_re = array("refresh","");
		}
		else{
			exit("Y");
		}
		break;
	case "add_track": //添加来源
//		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
//			$m_arr_re = array("","无权限");
//			break;		
//		}
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,24)){
			$m_arr_re = array("","无权限");
			break;
		}
		$url = trim(isset($_POST["txt_url"])?$_POST["txt_url"]:"");
		$flag = intval(isset($_POST["flag_id"])?$_POST["flag_id"]:-1);
		my_safe_include("mwjx/track.php");
		$arr_flag = arr_track_flag(); //flag=>title
		//$m_arr_re = array("","aa");
		//break;
		if($cid < 1 || $flag < 1 || "" == $url){
			$m_arr_re = array("","添加失败，参数无效");
			break;
		}
		if(!isset($arr_flag[$flag])){
			$m_arr_re = array("","添加失败，来源标志无效");
			break;
		}
		//是否重复
		if(!add_track($cid,$flag,$url,$arr_flag[$flag])){
			$m_arr_re = array("refresh","添加失败，该来源已存在");
			break;
		}
		$m_arr_re = array("refresh","添加成功");
		break;
	case "pick_author": //提取类目作者，从索引页
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			exit("");		
		}
		//索引页地址
		$sid = intval(isset($_GET["sid"])?$_GET["sid"]:-1);
		$site = intval(isset($_GET["site"])?$_GET["site"]:-1);
		//exit("bbb:".$sid);		
		if($sid < 1 || $site < 1)
			exit();
		my_safe_include("mwjx/track.php");
		$file = get_track_index($sid);
		//exit($file);
		if("" == $file)
			exit();
		$path = "../../data/update_track/".$sid."/".$file;
		if(!file_exists($path))
			exit("file not exists");
		//exit($path);
		$author = pick_author($site,readfromfile($path));
		//writetofile("","|".$author."|");
		//exit("|".$author."|");
		//if(14 == $site)
		//	exit($author);
		exit(gb2utf8_dolt($author));		
		break;
	case "update_author": //更新类目作者
//		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
//			$m_arr_re = array("","无权限");
//			break;		
//		}
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,26)){
			$m_arr_re = array("","无权限");
			break;
		}

		$stcid = intval(isset($_POST["st_cid"])?$_POST["st_cid"]:-1);
		if($cid < 1)
			$cid = $stcid;
		$author = trim(isset($_POST["txt_author"])?$_POST["txt_author"]:"");
		my_safe_include("mwjx/class_info.php");
		if($cid < 1 || "" == $author){
			$m_arr_re = array("","更新失败，参数无效");
			break;
		}
		$objinfo = new c_class_info($cid);
		if($objinfo->get_id() < 1){
			$m_arr_re = array("","更新失败，类目无效");
			break;
		}
		$objinfo->update_author($author);
		/**/
		$m_arr_re = array("refresh","");
		break;
	case "link_mybook": //将类目关联到藏书
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$bid = intval(isset($_POST["content"])?$_POST["content"]:-1);
		if($cid < 1 || $bid < 1){
			$m_arr_re = array("","类目或藏书ID无效");
			break;
		}
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,3,$bid,25)){
			$m_arr_re = array("","无权限");
			break;
		}
		my_safe_include("mwjx/mybook.php");
		$obj_mb = new c_mybook($bid);
		if(0 == ($re=$obj_mb->link_book($obj_man->get_id(),$cid)))
			$m_arr_re = array("refresh","类目关联到藏书成功",3);
		else
			$m_arr_re = array("","类目关联到藏书失败,code=".$re);
		//$m_arr_re = array("","cid=".$cid.",bid=".$bid);
		break;
	case "rm_sou": //清除来路
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$sid = intval(isset($_POST["content"])?$_POST["content"]:-1);
		if($sid < 1){
			$m_arr_re = array("","操作失败，来源无效");
			break;		
		}
		
		//文件
		/*$dir = "../data/update_track/".$sid;
		//$dir_ab = "/usr/home/mwjx/mwjx.com/data/update_track/".$sid;
		//passthru("chmod 0777 ".$dir_ab);
		if(0 == remove_directory($dir)){
			$m_arr_re = array("","操作失败，删除文件失败");
			break;		
		}
		*/
		//记录
		$str_sql = "delete from track_section where tid='".$sid."';";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		$str_sql = "delete from update_track where id='".$sid."';";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		$str_sql = "delete from track_deal where sid='".$sid."';";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		/**/
		$m_arr_re = array("refresh",""); //"清除成功:".$sid
		break;
	case "set_autoadd": //设置自动入库
		$cid = intval(isset($_POST["clist"])?$_POST["clist"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){
			$m_arr_re = array("","无权限");
			break;		
		}
//		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
//			$m_arr_re = array("","无权限");
//			break;		
//		}
		$flag = (isset($_POST["ref"])?$_POST["ref"]:'N');
		$sid = intval(isset($_POST["id_ls"])?$_POST["id_ls"]:-1);
		if($sid < 1 || $cid < 1){
			$m_arr_re = array("","操作失败，来源或类目无效");
			break;		
		}
		//$m_arr_re = array("","操作");
		//break;			
		//记录
		if("Y" == $flag){
			$str_sql = "select * from auto_add where cid='".$cid."';";
			$sql = new mysql;
			$sql->query($str_sql);
			$sql->close();
			$arr = $sql->get_array_rows();
			if(count($arr) > 0){ //更新
				$str_sql = "update auto_add set sid='".$sid."' where cid='".$cid."';";
			}
			else{ //新增
				$str_sql = "insert into auto_add (cid,sid)values('".$cid."','".$sid."');";
			}
			$sql = new mysql;
			$sql->query($str_sql);
			$sql->close();
		}
		else{
			$str_sql = "delete from auto_add where cid='".$cid."' and sid='".$sid."';";
			$sql = new mysql;
			$sql->query($str_sql);
			$sql->close();
		}
		$m_arr_re = array("refresh",""); //"清除成功:".$sid
		break;
	case "track_rmrc": //清除来路
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$idls = (isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		if("" == $idls){
			$m_arr_re = array("","操作失败，来源无效");
			break;		
		}
		
		//记录
		$str_sql = "delete from track_section where id in (".$idls.");";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		/*$str_sql = "delete from update_track where id='".$sid."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		*/
		$m_arr_re = array("refresh","");
		break;
	case "track_rmunused": //清除未读记录
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$idls = (isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		if("" == $idls){
			$m_arr_re = array("","操作失败，来源无效");
			break;		
		}
		
		//记录
		$str_sql = "delete from track_section where tid = '".$idls."' and used='N';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		/*$str_sql = "delete from update_track where id='".$sid."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		*/
		$m_arr_re = array("refresh","");
		break;
	case "del_pass": //删除章节过滤条件
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$id = intval(isset($_POST["hd_id"])?$_POST["hd_id"]:-1);
		if($id < 1){
			$m_arr_re = array("","删除失败,ID无效");
			break;
		}
		//删除
		$str_sql = "delete from track_pass where id='".$id."';";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("refresh","");
		break;
	case "add_pass": //添加章节过滤条件
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$id = intval(isset($_POST["hd_id"])?$_POST["hd_id"]:"");
		$site = intval(isset($_POST["hd_site"])?$_POST["hd_site"]:-1);
		$t = intval(isset($_POST["st_t"])?$_POST["st_t"]:-1);
		$val = trim(isset($_POST["txt_val"])?$_POST["txt_val"]:"");
		//$m_arr_re = array("","操作完成,id=".$id.",site=".$site.",t=".$t.",val:".$val);
		//break;		
		if("" == $val || $site < 1 || $t < 1){
			$m_arr_re = array("","操作失败，参数无效");
			break;		
		}
		
		//记录
		if($id < 1){ //新增
			$str_sql = "insert into track_pass (site,t,val)values('".$site."','".$t."','".$val."');";
		}
		else{ //修改
			$str_sql = "update track_pass set t='".$t."',val='".$val."' where id='".$id."';";
		}
		//删除
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		/*$str_sql = "delete from update_track where id='".$sid."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		*/
		$m_arr_re = array("refresh","");
		break;
	case "add_sou": //添加来源站点
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$title = trim(isset($_POST["hd_id"])?$_POST["hd_id"]:"");
		$flag = trim(isset($_POST["hd_site"])?$_POST["hd_site"]:"");
		//$m_arr_re = array("","操作完成,title=".$title);
		//break;		
		if("" == $title){
			$m_arr_re = array("","操作失败，参数无效");
			break;		
		}
		$str_sql = "insert into track_sou (title,flag)values('".$title."','".$flag."');";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("refresh","");
		break;
	case "save_trackurl": //更新来源地址
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$id = trim(isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		$url = trim(isset($_POST["txt_url"])?$_POST["txt_url"]:"");
		//$m_arr_re = array("","操作完成,id=".$id.",url=".$url);
		//break;		
		if("" == $url || "" == $id){
			$m_arr_re = array("","操作失败，参数无效");
			break;		
		}
		$str_sql = "update update_track set url='".$url."' where id ='".$id."';";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("refresh","");
		break;
	case "rm_c_article": //删除类目所有章节
//		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
//			$m_arr_re = array("","无权限");
//			break;		
//		}
		$cid = intval(isset($_POST["content"])?$_POST["content"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){
			$m_arr_re = array("","无权限，不是管理员");
			break;
		}
		//$m_arr_re = array("","操作完成,cid=".$cid);
		//break;		
		if($cid < 1){
			$m_arr_re = array("","操作失败，参数无效");
			break;		
		}
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($cid);
		if($obj->get_id() < 1){
			$m_arr_re = array("","操作失败，类目无效");
			break;		
		}
		$obj->rm_article();
		$m_arr_re = array("refresh","");
		break;
	case "track_preparatory": //批量添加小说列表
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$ls = trim(isset($_POST["hd_content"])?$_POST["hd_content"]:"");
		my_safe_include("mwjx/class_info.php");
		my_safe_include("mwjx/track.php");
		my_safe_include("mwjx/track_preparatory.php");
		//$m_arr_re = array("","操作失败，原因未知，ls=".$ls);
		//break;		
		if(!batch_book($ls)){
			$m_arr_re = array("","操作失败，原因未知，ls=".$ls);
			break;		
		}
		$m_arr_re = array("refresh","添加完成");
		break;
	case "commit_rules": //批量提交规则
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$site = intval(isset($_POST["hd_site"])?$_POST["hd_site"]:-1);
		$t = intval(isset($_POST["st_t"])?$_POST["st_t"]:-1);
		$val = trim(isset($_POST["txt_rules"])?$_POST["txt_rules"]:"");
		//$m_arr_re = array("","操作完成,id=".$id.",site=".$site.",t=".$t.",val:".$val);
		//break;		
		if($site < 1 || $t < 1){
			$m_arr_re = array("","操作失败，参数无效");
			break;		
		}
		//$m_arr_re = array("","site=".$site.",t=".$t.",rules:".count($arr));
		//break;		
		//删除旧记录
		$str_sql = "delete from track_pass where site='".$site."' and t = '".$t."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		//添加新记录
		$arr = explode("\n",$val);
		$len = count($arr);
		for($i = 0;$i < $len; ++$i){
			$line = trim($arr[$i]);
			if("" == $line)
				continue;
			$str_sql = "insert into track_pass (site,t,val)values('".$site."','".$t."','".$line."');";
			$sql = new mysql;
			$sql->query($str_sql);
			$sql->close();
		}
		$m_arr_re = array("refresh","");
		break;	
	case "static_all": //生成所有类目静态文件
		//$m_arr_re = array("","aa");
		//break;
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}		
		$cid = intval(isset($_POST["id_ls"])?$_POST["id_ls"]:-1);
		//类目
		if($cid > 0){
			$str_sql="insert into static_update (oid,t,action) select id,'C','Y' from class_info where id='".$cid."';";
		}
		else{
			$str_sql="insert into static_update (oid,t,action) select id,'C','Y' from class_info;";
		}
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		
		//文章
		if($cid > 0){
			$str_sql="insert into static_update (oid,t,action) select id,'A','Y' from article where cid='".$cid."';";
		}
		else{
			$str_sql="insert into static_update (oid,t,action) select id,'A','Y' from article;";
		}
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("","所有指令加入完成");
		break;
	case "rm_emptysou": //删除空来源
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$str_sql = "select TS.tid from track_section TS left join update_track UT on TS.tid=UT.id where TS.used='N' and UT.id is NULL group by TS.tid;";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$arr = $sql->get_array_array();
		$ls = "";
		$len = count($arr);
		for($i = 0;$i < $len; ++$i){
			if("" != $ls)
				$ls .= ",";
			$ls .= $arr[$i][0];
		}
		if("" == $ls){
			$m_arr_re = array("","当前没有空来源");
			break;
		}
		//删除来源
		$str_sql = "delete from track_section where tid in (".$ls.");";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$str_sql = "delete from update_track where id in (".$ls.");";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		//$m_arr_re = array("",$ls);
		//break;
		$m_arr_re = array("refresh","删除成功：".$ls);
		break;
	case "report_err":  //报告错误章节
		$id = intval(isset($_POST["aid"])?$_POST["aid"]:-1);
		//$id = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		//$m_arr_re = array("","aaa");
		if($id < 1){
			$m_arr_re = array("","举报失败，章节ID无效：".$id);
			break;		
		}
		my_safe_include("mwjx/action_queue.php");
		$obj_action = new c_action_queue;
		$requester = $obj_man->get_id();
		if($requester < 1)
			$requester = $m_guest_id;
		$re = $obj_action->add($requester,15,strval($id));
		$m_arr_re = array("","举报错误章节成功，管理员会在第一时间修正该错误，谢谢你的热心");

		break;
	case "class_kw": //批量提交类目关键词
		if(200200067 != $obj_man->get_id()){ //小鱼不用验证
			$m_arr_re = array("","无权限");
			break;		
		}
		$cid = intval(isset($_POST["hd_fid"])?$_POST["hd_fid"]:-1);
		$val = trim(isset($_POST["txt_kwls"])?$_POST["txt_kwls"]:"");
		//$m_arr_re = array("","操作完成,id=".$id.",site=".$site.",t=".$t.",val:".$val);
		//break;		
		if($cid < 1){
			$m_arr_re = array("","操作失败，参数无效");
			break;		
		}
		//$m_arr_re = array("","site=".$site.",t=".$t.",rules:".count($arr));
		//break;		
		//删除旧记录
		$str_sql = "delete from class_kw where cid='".$cid."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		//添加新记录
		$arr = explode("\n",$val);
		$len = count($arr);
		for($i = 0;$i < $len; ++$i){
			$line = trim($arr[$i]);
			if("" == $line)
				continue;
			$str_sql = "insert into class_kw (cid,kw)values('".$cid."','".$line."');";
			$sql = new mysql;
			$sql->query($str_sql);
			$sql->close();
		}
		$m_arr_re = array("refresh","");
		break;	
	case "auto_book": //全自动添加新书收藏
		if($obj_man->get_id() < 1){ //没登录,自动用游客身份登录
			$uname="临时用户"; //200222044
			$upass="123";
			$upass=crypt(stripslashes($upass),"d.r");  
			$obj_man = new manbase_2($uname,$upass);
			if($obj_man->get_id() < 1){
				$m_arr_re = array("","请登录:".$obj_man->get_id());
				break;
			}
			$cookietime=time()+86400*1;
			setcookie("username",$uname,$cookietime,"/");
			setcookie("userpass",$upass,$cookietime,"/");
			//break;		
		}
		$title = trim(isset($_REQUEST["title"])?$_REQUEST["title"]:"");
		$nid = intval(isset($_REQUEST["nid"])?$_REQUEST["nid"]:-1);
		//提交方式F表单/B数据提交
		$ref = (isset($_REQUEST["ref"])?$_REQUEST["ref"]:"F"); 
		//$m_arr_re = array("","书名:".$nid);
		//break;		
		if("F" == $ref){ //前台提交
			if("" == $title){
				$m_arr_re = array("","书名不能为空");
				break;		
			}
			if($nid < 1){
				$m_arr_re = array("","书号无效");
				break;		
			}
		}
		else{
			if("" == $title){
				exit("N");
				break;		
			}
			if($nid < 1){
				exit("N");
				break;		
			}
		}
		my_safe_include("mwjx/mybook.php");
		$obj_mb = new c_mybook;
		$uid = $obj_man->get_id();
		if(0 < ($re=$obj_mb->auto_book($uid,$nid))){
			$obj_mb->rm_left($uid); //删除操作者左菜单缓存数据
			if("F" == $ref){ //前台提交
				$m_arr_re = array("../index.php?main=view/mybook.php?id=".$re,"藏书《".$title."》已经成功添加我的书库，回到838书库欣赏本书",1);
			}
			else{
				exit("Y");
			}
		}
		else{
			if("F" == $ref){ //前台提交
				$m_arr_re = array("","添加藏书失败,code=".$re);
			}
			else{
				exit("N");
			}
		}
		break;
	case "add_mybook": //添加新书收藏
		//$m_arr_re = array("","无权限,请登录");
		if($obj_man->get_id() < 1){ //无权
			$m_arr_re = array("","无权限,请登录");
			break;		
		}
		$title = trim(isset($_POST["title"])?$_POST["title"]:"");
		if("" == $title){
			$m_arr_re = array("","书名不能为空");
			break;		
		}
		my_safe_include("mwjx/mybook.php");
		$obj_mb = new c_mybook;
		if(0 == ($re=$obj_mb->add_book($obj_man->get_id(),$title)))
			$m_arr_re = array("refresh","添加新书成功：".$title,3);
		else
			$m_arr_re = array("","添加新书失败,code=".$re);
		break;
	case "rm_mybook": //删除藏书
		//提交方式F表单/B数据提交
		$oid = intval(isset($_REQUEST["content"])?$_REQUEST["content"]:-1);
		$ref = (isset($_REQUEST["ref"])?$_REQUEST["ref"]:"F"); 
		$obj = new c_authorize;		
		//if(!$obj->can_do($obj_man,3,$oid,0)){ //无权，等待审核
		if($obj_man->get_id() < 1){ //无权
			if("F" == $ref){ //前台提交
				$m_arr_re = array("","无权限");
			}
			else{
				exit("无权限");
			}
			break;		
		}

//		if($obj_man->get_id() < 1){ //无权
//			$m_arr_re = array("","无权限,请登录");
//			break;		
//		}
		//$m_arr_re = array("refresh","tests：".$oid,3);
		//exit("<script language=\"javascript\">alert(top.location.href);</script>");
		//break;
		if($oid < 1){
			if("F" == $ref) //前台提交
				$m_arr_re = array("","藏书ID无效");
			else
				exit("藏书ID无效");
			break;		
		}
		my_safe_include("mwjx/mybook.php");
		$obj_mb = new c_mybook;
		$uid = $obj_man->get_id();
		if(0 == ($re=$obj_mb->rm_mybook($oid,$uid))){
			$obj_mb->rm_left($uid); //删除操作者左菜单缓存数据
			if("F" == $ref) //前台提交
				$m_arr_re = array("refresh","删除藏书成功：".$oid,3);
			else
				exit("Y");
		}
		else{
			if("F" == $ref) //前台提交
				$m_arr_re = array("","删除藏书失败,code=".$re);
			else
				exit("删除藏书失败,code=".$re);
		}
		break;
	case "make_manager": //成为类目管理员
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		//exit("cid==".$cid);
		my_safe_include("cmd/make_manager.php");
		$re = make_manager($obj_man->get_id(),$cid);
		exit("".$re);
		break;
	default:		
		$m_arr_re = array("","操作无效");		
		//assert(0);
		break;
}

if(2 == count($m_arr_re))
	goto_url($m_arr_re[0],$m_arr_re[1]);
if(3 == count($m_arr_re))
	goto_url($m_arr_re[0],$m_arr_re[1],$m_arr_re[2]);
//if(3 == count($m_arr_re))
//	goto_url($m_arr_re[0],$m_arr_re[1],$m_arr_re[2]);
function goto_url($url = "",$str = "",$flag=1)
{
	//跳转页面
	//输入:url不为空跳转到该地址,值refresh刷新当前窗口,
	//str不为空显示该信息
	//flag(int)1/2/3/4(父窗口/当前窗口/祖窗口/弹出新窗口)
	//输出:无
	//必须要用exit输出
	if("" != $str)
		$str = "alert(\"".$str."\");";
	$window = "window.parent";
	if(2 == $flag)
		$window = "window";
	if(3 == $flag)
		$window = "window.parent.parent";
	if("" != $url){
		if(4 == $flag){
			$url = "omvc=window.open('".$url."');if(omvc && omvc.open && !omvc.closed){omvc.focus();}";
		}
		else if("refresh" == $url){
			//$str = "";
			$url = $window.".location.reload();";
			//$url = $window.".location.href=".$window.".location.href;";
		}
		else{
			$url = $window.".location.href=\"".$url."\";";
		}
	}
	//exit($url);
	//$str = "";
	//$url = "alert(window.parent.parent.roll.location.href);";
	//writetofile("xxx.txt",$url);
	exit("<script language=\"javascript\">".$str.$url."</script>");
}

function xml_result_head()
{
	return "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
}
function check_confcode($str="")
{
	//检查验证码
	//输入:str是请求验证码的变量名,post方式
	//输出:true通过,false不通过
	//前置保证session_start开启
	//本函数不通过时会中断执行整个页面
	$conf_code = trim(isset($_POST[$str])?$_POST[$str]:"");
	if("" == $_SESSION[$str] || "" == $conf_code){
		goto_url("","验证码无效，看不清可以刷新页面换张图片重试");
		return false;
	}
	$conf_code = strtolower($conf_code);
	if($conf_code != $_SESSION[$str]){
		goto_url("","验证码无效，看不清可以刷新页面换张图片重试");
		return false;
	}
	return true;
}
function remove_directory($dir="") 
{
	//删除目录及下文件
	//输入:dir(string)目录,不要/结尾
	//输出:整形，错误返回0
	if (!($handle = opendir($dir)))
		return 0;
	while (false !== ($item = readdir($handle))) {
		if ($item == "." || $item == "..")
			continue;
		if (is_dir($dir."/".$item)) {
			remove_directory($dir."/".$item);
		} 
		else {
			unlink($dir."/".$item);
			//echo " removing $dir/$item<br>\n";
		}
	}
	closedir($handle);
	return @rmdir($dir);
	//echo "removing $dir<br>\n";
}
?>