<?php
//------------------------------
//create time:2006-3-22
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:��������
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
	exit("û������");
//$m_fun = "vote";
//�ο�
switch($m_fun){
	case "login_reg_out":
		//var_dump($_POST);
		//exit();		
		$cookietime=time()+86400*365; //һ��
		//$cookietime *= 365; //һ��
		$name = isset($_POST["name"])?$_POST["name"]:"";
		$pswd = isset($_POST["password"])?$_POST["password"]:"";
		$name = addslashes($name);
		$pswd = crypt(addslashes($pswd),"d.r");
		switch($_POST["action"]){
			case "login": //
				$obj = new manbase_2($name);
				if($obj->get_id() < 1){
					//var_dump($obj);
					exit("�޴��û����û�ʧЧ:".$name);
				}
				if($pswd != $obj->get_pswd())
					exit("���벻��ȷ!");
				setcookie("username",$name,$cookietime,"/");
				setcookie("userpass",$pswd,$cookietime,"/");
				exit("��¼�ɹ�!");
				break;
			case "reg":
				//ע��
				$currentuser = isset($_COOKIE["username"])?trim($_COOKIE['username']):"";
				if("" != $currentuser)
					exit("����ע�ᣬ�����˳���¼!");
				$obj = new manbase_2($name);
				if($obj->get_id() > 0){
					//var_dump($obj);
					exit("ע��ʧ�ܣ��û����Ѵ���:".$name);
				}
				$new_man=new manbase_2();
				$result = $new_man->reg($name,$pswd);
				if(false == $result[0])
					exit($result[1]);
				//��¼
				setcookie("username",$name,$cookietime,"/");
				setcookie("userpass",$pswd,$cookietime,"/");
				exit("ע��ɹ�!");
				break;
			case "out":
				setcookie("username","",$cookietime,"/");
				setcookie("userpass","",$cookietime,"/");
				exit("�˳���¼�ɹ�!");
				break;
			default:
				//assert(0);
				exit("û�˸�����:".$m_fun);
		}
		//var_dump($_POST);
		//exit();
		break;
	default:
		break;
}

//���Բ��õ�¼ִ�еĲ���
$m_arr_free = array("reply"=>true,"vote_article"=>true,"recommend_article"=>true,"rm_article"=>true,"good_article"=>true,"set_star"=>true,"helpmwjx"=>true,"report_err"=>true,"auto_book"=>true);

$m_guest_id = 200200167;//200200167,�ο�ר��ID
//�û�
$obj_face = new c_interface;
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(!isset($m_arr_free[$m_fun])){ //�����������¼�û��ſɲ���
	if(round($obj_man->get_id()) < 1){
		goto_url("/site838/view/login.php","��ǰ�û���Ч�����ȵ�¼��ע��");
		//exit("��ǰ�û���Ч");
	}
}
//���ϱ�����Ľӿڴ���ֵ�淶
//�������,��һ����url(��Ϊ���ַ���),�ڶ������ַ���˵��,�������Ǳ�־λ
$m_arr_re = array();  
switch($m_fun){
	case "vote_book": //С˵ͶƱ
		if($obj_man->get_id() < 1)
			exit("RE:-3"); //û�е�¼
		//exit("OK");
		$id = intval($_POST["id"]);
		if($id < 1)
			exit("RE:-2");
		$re = $obj_face->vote_book($id,$obj_man->get_id());
		exit("RE:".$re);
		break;
	case "new_class": //�½���Ŀ
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,3)){
			$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
			$str_xml .= "<msg>��Ȩ������Ŀ</msg>";
			print_xml($str_xml);		
			break;
		}
		//xml_result("<aaa>bbb</aaa>");
		$fid = intval(isset($_GET["fid"])?$_GET["fid"]:"");
		$name = addslashes(isset($_GET["name"])?$_GET["name"]:"");
		//�½���Ŀ
		$cdir = addslashes(isset($_GET["cdir"])?$_GET["cdir"]:"N"); 
		//���
		my_safe_include("mwjx/class_info.php");
		$objc = new c_class_info;
		$arg = array("name"=>$name,"fid"=>$fid,"creator"=>$obj_man->get_id(),"memo"=>"");
		$re = $objc->add($arg);
		//writetofile("xxx.txt","�����ɣ�".$name);

		//�ظ�
		$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
		if(true === $re){
			//$str_xml .= "<msg>".htmlspecialchars("������Ŀ�ɹ�")."</msg>";
			$re = "������Ŀ�ɹ�";
			$str_xml .= "<msg>".htmlspecialchars($re)."</msg>";
			//����Ȩ��
			$obj->set_can($obj_man->get_id(),2,$objc->get_addid(),0);
		}
		else{
			$str_xml .= "<msg>".htmlspecialchars($re)."</msg>";
		}
		//writetofile("xxx.txt","�����ɣ�".$str_xml);
		//$str_xml .= "<result><fid>".$fid."</fid><name>".$name."</name></result>";
		//$str_xml = xml_result_head()."<msg>".$fid."</msg>";		
		//writetofile("xxx.xml",$str_xml);
		print_xml($str_xml);		
		//xml_result("<msg>".$fid."</msg>");
		break;
	case "del_class": //ɾ����Ŀ
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,4)){
			$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
			$str_xml .= "<msg>��Ȩɾ����Ŀ</msg>";
			print_xml($str_xml);		
			break;
		}
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($id);
		$re = $obj->del();				
		//$re = true;
		//�ظ�
		$str_xml = "<?xml version=\"1.0\" encoding=\"GB2312\"?>";
		if(true === $re)
			$str_xml .= "<msg>ɾ����Ŀ�ɹ�</msg>";
		else
			$str_xml .= "<msg>".htmlspecialchars($re)."</msg>";
		print_xml($str_xml);		
		break;
	case "set_article": //���¹���
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,6))
			exit("FAIL"); //��Ȩ����
		
		$info = (isset($_POST["info"])?$_POST["info"]:"");
		//writetofile("xxx.txt",$info);
		include_once("./src_php/control/article_reset.php");
		if(true === ($re = article_reset($info)))
			exit("OK");
		else
			exit($re);
		break;
	case "link_class": //������Ŀ
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,15))
			exit("FAIL"); //��Ȩ����
		//exit("OK");
		$info = (isset($_POST["info"])?$_POST["info"]:"");
		//writetofile("xxx.txt",$info);
		include_once("./src_php/control/class_link.php");
		if(true === ($re = link_class($info)))
			exit("OK");
		else
			exit($re);
		break;
	case "set_article_links": //���������������
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,9))
			exit("FAIL"); //��Ȩ����
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
	case "run_article_links": //���������໥����
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,9))
			exit("FAIL"); //��Ȩ����
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
	case "unlink_article": //ȡ����������
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,7))
			exit("��Ȩ����"); //��Ȩ����

		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:"");
		$id = intval(isset($_POST["id"])?$_POST["id"]:"");		//writetofile("xxx.txt",$info);
		include_once("./src_php/control/article_unlink.php");
		if(true === ($re = unlink_article($cid,$id)))
			exit("OK");
		else
			exit($re);
		break;
	case "unlink_class": //ȡ����Ŀ����
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,18))
			exit("��Ȩ����"); //��Ȩ����

		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:"");
		$sid = intval(isset($_POST["id"])?$_POST["id"]:"");		//writetofile("xxx.txt",$info);
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($cid);
		if($obj->get_id() < 1){
			exit("��Ŀ��Ч");
			//$m_arr_re = array("","��Ŀ��Ч");
			//break;		
		}
		//include_once("./src_php/control/article_unlink.php");
		if(true === ($re = $obj->unlink_class($sid)))
			exit("OK");
		else
			exit("����ʧ�ܣ�����ȡ������Ŀ����������Ŀ");
		break;
	case "post_article838": //��������838
		//$m_arr_re = array("","aaa");		
		//break;
		$mb = intval(isset($_POST["mb"])?$_POST["mb"]:-1); //����ID
		//����ID,-1����,>0�����޸�
		$aid = intval(isset($_POST["hd_aid"])?$_POST["hd_aid"]:-1); 
		//��ĿID
		$cid = (isset($_POST["clist"])?$_POST["clist"]:-1);
		$title = ((isset($_POST["title"])?$_POST["title"]:""));
		$content = ((isset($_POST["content"])?$_POST["content"]:""));
		//��Դ�½�ID�б�
		$id_ls = (isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		//supper����������/Fǰ̨/B��̨
		$ref = isset($_POST["ref"])?$_POST["ref"]:"F"; 
		$obj = new c_authorize;		
		if(!($obj->can_do($obj_man,2,$cid,0) || $obj->can_do($obj_man,3,$mb,0))){
			if("B" == $ref)
				exit("-2");
			else
				$m_arr_re = array("","��Ȩ����");			
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
				$m_arr_re = array("","���ʧ��");		
			break;
		}
//		if("supper" == $ref){ //�����������ύ������
//			$str = "window.parent.post_segment();";
//			exit("<script language=\"javascript\">".$str."</script>")
//		}

		//��Ϊ�Ѷ�
		$str_sql = "update track_section set used='Y' where id in(".$id_ls.");";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();

//		//���¾�̬�ļ�
//		add_static(strval($aid),"A","Y");
//		add_static(strval($cid),"C","Y");
		if("B" == $ref)
			exit("".$aid);
		else
			$m_arr_re = array("refresh",""); //�ɹ�
		break;
	case "post_article": //��������
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
			$m_arr_re = array("","���ⳤ�ȳ�������󳤶ȣ�255");
			break;		
		}
		$obj = new c_authorize;		
		if($aid > 0){ //�༭����
			if(!$obj->can_do($obj_man,1,1,12)){
				$m_arr_re = array("","��Ȩ����");			
				break;
			}
		}
		else{ //��������
			if(!$obj->can_do($obj_man,1,1,1)){
				$m_arr_re = array("","��Ȩ����");			
				break;
			}
		}
		if(strlen($content) > 100000){
			//exit("���ݳ��ȳ�������:".strval(strlen($content)));
			$m_arr_re = array("","���ݳ��ȳ�������:".strval(strlen($content)));
			break;
		}
		if("track" == $ref && "" != $id_ls){
			//��Ϊ�Ѷ�
			$str_sql = "update track_section set used='Y' where id in(".$id_ls.");";
			$sql = new mysql("fish838");
			$sql->query($str_sql);
			$sql->close();
		}			include_once("./src_php/control/article_post.php");
		if($aid > 0){ //�༭����
			$re = edit_article($aid,$title,$content);
			if($re){ //�ɹ�
				$cid = 12;
				$url = "/mwjx/src_php/data_article.php?id=".strval($aid)."&r_cid=".$cid;
				$m_arr_re = array("","�༭�ɹ�");
				//------��ӵ���Ŀ---------
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
				//������Զ����Ǿ��½�
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
			else{ //ʧ��
				$m_arr_re = array("","�༭ʧ�ܣ����ܸ���������");
			}						
			break;
		}
		//����������
		//$m_arr_re = array("","title=".$title);
		//break;
		//$m_arr_re = array("",$obj_man->get_name());
		//break;
		$good = "N";
		if("track" == $ref)
			$good = "Y";
		if(200200067 == $obj_man->get_id())
			$good = "Y"; //����Ա�Զ�����
		if(($re = post_article($title,$content,$clist,$obj_man->get_name(),$good)) < 0){
			$m_arr_re = array("","����ʧ�ܣ�ԭ�����:".strval($re));
			//exit("����ʧ�ܣ�ԭ�����:".strval($re));
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
		//------��ӵ���Ŀ---------
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
		if("supper" == $ref){ //�����������ύ������
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
			$m_arr_re = array("","�����ɹ�");
		}
		break;
	case "create_index": //������վ����Ŀ��ҳ
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,5))
			exit("��Ȩ����"); //��Ȩ����
		my_safe_include("fish/class_bbsmanager.php");
		my_safe_include("mwjx/top.php");
		$obj_manager = new c_bbsmanagerbase;
		$obj_top = new c_top;
		//exit($obj_top->write_top());
		//writetofile("xxx.txt","xxx");
		
		//$obj_manager->create_html_bookstore(); //���������ҳ
		//$re = 
		//exit($re);
		//-------����ĳ�����۰���Ŀ��ҳ-----------
		if($obj_manager->create_indexforumboard("0"))
			exit("success");
		else
			exit("fail");		
		//if($obj_top->write_last() && $obj_top->write_top() && $obj_manager->create_indexforumboard("0"))
		//	exit("success");
		//else
		//	exit("fail");
		break;
	case "create_link": //�����������
		if(!$obj_man->check_super_manager())
			exit("��Ȩ����");
		my_safe_include("mwjx/run_link.php");
		$obj = new c_run_link;
		if($obj->run())
			exit("success");
		else
			exit("fail");
		break;
	case "reply": //��������		
		$type = isset($_POST["reply_type"])?$_POST["reply_type"]:"";
		if("class" != $type && "article" != $type && "lib" != $type){
			$m_arr_re = array("","����������Ч");
			break;				
		}
		if($obj_man->get_id() < 1){
			$m_arr_re = array("","�����������ȵ�¼");
			break;						
		}

		$content = addslashes(isset($_POST["message"])?$_POST["message"]:"");
		if("" == $content){
			$m_arr_re = array("","���ݲ���Ϊ��");
			break;						
		}
		if(strlen($content) > 20000){
			$m_arr_re = array("","���ݳ��ȳ�������");
			break;								
		}

		$flag = 0;
		$id = -1;
		//��鱻���Զ����Ƿ���Ч,��
		$flag = 1;
		$id = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		if($id < 1){
			//exit("������Ŀ��Ч");
			$m_arr_re = array("","������Ŀ��Ч");
			break;											
		}
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($id);
		if($obj->get_id() < 1){
			//exit("��Ŀ��Ч");
			$m_arr_re = array("","��Ŀ��Ч");
			break;		
		}
		//�û�ֱ������
		//$m_arr_re = array("",$id."--".$flag."--".$obj_man->get_id()."--".$content);
		//break;				
		my_safe_include("mwjx/reply.php");
		$obj = new c_reply;
		if($obj->reply($content,$id,$flag,$obj_man->get_id())){ //�ɹ�
			$url = "refresh";
			$m_arr_re = array($url,"�ύ�ɹ���������ھ�̬htmlҳ�棬���Կ��ܲ��ἴʱ��ʾ");
			break;		
			//goto_url($url,"�ύ�ɹ�",2);
			//exit($url);		
		}
		else{ //ʧ��
			//exit("����ʧ�ܣ�ԭ��δ֪");
			$m_arr_re = array("","����ʧ�ܣ�ԭ��δ֪");
			break;		
		
		}
		break;
	case "rm_reply": //ɾ������
		$id = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$type = (isset($_GET["type"])?$_GET["type"]:"");
		if("O" != $type && "N" != $type){
			$m_arr_re = array("","ɾ����������ʧ��,�����汾������Ч:".$type);
			break;
		}
		if($id < 1){
			$m_arr_re = array("","ɾ����������ʧ��,����ID��Ч:".$id);
			break;
		}
		//$m_arr_re = array("","ɾ������,".$id.",".$type);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,14)){ //��Ȩ�ޣ��ȴ����
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$re = $obj_action->add($obj_man->get_id(),14,$id.",".$type);
			if($re){	
				$m_arr_re = array("","ɾ���������۳ɹ�����Ҫ�ȴ���Ȩ�޵��������ͨ��������Ч");					
			}
			else{
				$m_arr_re = array("","ɾ����������ʧ�ܣ�ԭ��δ֪");
			}
			break;
		}
		//��Ȩ�ޣ�ֱ�Ӳ���
		my_safe_include("mwjx/reply.php");
		$obj_reply = new c_reply;
		$re = $obj_reply->rm($id,$type);
		if(true !== $re)
			$m_arr_re = array("","ɾ��ʧ�ܣ�ԭ��δ֪");
		else
			$m_arr_re = array("refresh","ɾ���ɹ�:".$id);		
		break;
	case "rm_article": //�߼�ɾ������
		//$m_arr_re = array("","ɾ������");
		//break;
		if(!check_confcode("conf_delarticle"))
			exit(); //�ⲽ�ж���֮��
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,8)){ //��Ȩ�ޣ��ȴ����
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;
			$re = $obj_action->add($requester,8,strval($id));
			if($re){	
				$m_arr_re = array("","ɾ�����³ɹ�����Ҫ�ȴ���Ȩ�޵��������ͨ��������Ч");					
			}
			else{
				$m_arr_re = array("","ɾ������ʧ�ܣ����������»���Ŀ��Ч");
			}
			break;
		}
		//��Ȩ�ޣ�ֱ�Ӳ���
		my_safe_include("class_forum.php");
		$str_id = "400400003428";
		$forum = new c_forumbase($str_id);
		$re = $forum->del_article_update($id);
		if(true !== $re)
			$m_arr_re = array("",$re);
		else
			$m_arr_re = array("","ɾ���ɹ�:".$id);
		break;
	case "set_star": //��������,��Ŀ����
		if(!check_confcode("conf_star"))
			exit(); //�ⲽ�ж���֮��		
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		$otype = (isset($_GET["otype"])?$_GET["otype"]:"");
		$star = intval(isset($_POST["slt_star"])?$_POST["slt_star"]:"0");
		my_safe_include("mwjx/top_star.php");
		$obj = new c_authorize;		
		if("class" == $otype){ //��Ŀ����
			if(!$obj->can_do($obj_man,1,1,21)){ //��Ȩ��
				$m_arr_re = array("","����ʧ�ܣ���Ȩ��");
				break;
			}
			//��Ȩ�ޣ�ֱ�Ӳ���
			$obj_star = new c_top_star(1);		
			$re = $obj_star->set_star($id,$star,2);
			if(true !== $re)
				$m_arr_re = array("","����ʧ��");
			else
				$m_arr_re = array("","�����ɹ�:".$id);
			break;
		}
		//��������
		if(!$obj->can_do($obj_man,1,1,10)){ //��Ȩ�ޣ��ȴ����
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;

			$re = $obj_action->add($requester,10,$id.",".$star);
			if($re){	
				$m_arr_re = array("","���������ɹ�����Ҫ�ȴ���Ȩ�޵��������ͨ��������Ч");					
			}
			else{
				$m_arr_re = array("","��������ʧ�ܣ����������»���Ŀ��Ч");
			}
			break;
		}
		//��Ȩ�ޣ�ֱ�Ӳ���
		$obj_star = new c_top_star(1);		
		$re = $obj_star->set_star($id,$star,1);
		if(true !== $re)
			$m_arr_re = array("","����ʧ��");
		else
			$m_arr_re = array("","�����ɹ�:".$id);		
		break;
	case "recommend_article": //�Ƽ����µ���Ŀ
		if(!check_confcode("conf_recommend"))
			exit(); //�ⲽ�ж���֮��		
		$id = intval(isset($_GET["id"])?$_GET["id"]:"");
		$cid = intval(isset($_GET["cid"])?$_GET["cid"]:"");
		my_safe_include("mwjx/top_star.php");
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,11)){ //��Ȩ���ȴ����
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;
			$re = $obj_action->add($requester,11,$id.",".$cid);
			if($re){	
				$m_arr_re = array("","�Ƽ����µ���Ŀ�ɹ�����Ҫ�ȴ���Ȩ�޵��������ͨ��������Ч");					
			}
			else{
				$m_arr_re = array("","�Ƽ����µ���Ŀʧ�ܣ��������Ƽ������»���Ŀ��Ч�����߸������Ѿ����Ƽ�");
			}
			break;
		}
		//��Ȩ�ޣ�ֱ�Ӳ���
		my_safe_include("mwjx/recommend.php");
		$obj_recommend = new c_recommend;
		if($obj_recommend->recommend_article($id,$cid)){
			$m_arr_re = array("","�Ƽ��ɹ�");
		}
		else{
			$m_arr_re = array("","�Ƽ�ʧ�ܣ����������»���Ŀ��Ч������Ѿ����Ƽ�,id=".$id.",cid=".$cid);
		}
		break;
	case "run_action": //����¼�
		$id = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$tid = intval(isset($_GET["tid"])?$_GET["tid"]:0);
		$effect = isset($_GET["effect"])?$_GET["effect"]:"";
		if("Y" != $effect && "N" != $effect){
			$m_arr_re = array("","������־��Ч");
			break;
		}
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,$tid)) //��Ȩ���ȴ����
			$m_arr_re = array("","������Ч,��Ч���");
		my_safe_include("mwjx/action_queue.php");
		$obj_queue = new c_action_queue;		
		if($obj_queue->run($id,$effect)){
			$m_arr_re = array("","������");
			$title = "���ύ�������Ѿ�������";
		}
		else{
			$m_arr_re = array("","���ʧ�ܣ��쳣");
			$title = "���ύ����������з����쳣";
		}
		$title .= ",��˽����:";
		$title .= (("Y" == $effect)?"��ͨ��":"���ܾ�");
		//����Ϣ��������
		my_safe_include("mwjx/msg_dealer.php");
		$obj_msg = new c_msg_dealer;
		$sender = $obj_man->get_id();
		$receiver = -1;		
		$content = ""; //<content>
		$arr = $obj_queue->get_info($id);
		$receiver = $arr[0];
		$content .= "<txt>���������ύ����������Ϣ,�����:".$obj_man->get_name()."</txt>";
		$content .= $arr[2];
		$content .= ""; //</content>
		$obj_msg->write_msg($sender,$receiver,$title,$content);
		break;
	case "write_msg": //дվ�ڶ���
		//$m_arr_re = array("","����δ���");
		$reveiver = isset($_POST["txt_receiver"])?$_POST["txt_receiver"]:"-1";
		$title = isset($_POST["txt_title"])?$_POST["txt_title"]:"";
		$content = isset($_POST["txt_content"])?$_POST["txt_content"]:"";
		if("" == $title || "" == $content){
			$m_arr_re = array("","��������ݶ�����Ϊ��");
			break;
		}
		//$m_arr_re = array("","����:".$content);
		//break;

		if(strlen($title) > 250 || strlen($content) >10000){
			$m_arr_re = array("","��������ݳ��ȳ���");			
			break;
		}
		$man_receiver = new manbase_2($reveiver);
		if($man_receiver->get_id() < 1){
			$m_arr_re = array("","�ռ��˲����ڣ������ռ���ID�Ƿ���ȷ");
			break;
		}
		//����Ϣ
		my_safe_include("mwjx/msg_dealer.php");
		$obj_msg = new c_msg_dealer;
		$sender = $obj_man->get_id();
		$receiver = $man_receiver->get_id();		
		//$content = ""; //<content>
		$content = "<txt>".addslashes($content)."</txt>";
		//$content .= ""; //</content>
		$obj_msg->write_msg($sender,$receiver,addslashes($title),$content);
		$m_arr_re = array("refresh","�������");
		break;
	case "batch_del": //����ɾ��
		//�б�,��ʽ:"id,id..."(id�б�)
//		$m_arr_re = array("","del");
//		break;		
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){
			$m_arr_re = array("","��Ȩ�ޣ����ǹ���Ա");
			break;
		}
//		if(!$obj->can_do($obj_man,1,1,8)){ //��Ȩ���ȴ����
//			$m_arr_re = array("","��Ȩ��");
//			break;		
//		}
		$slist = isset($_POST["id_ls"])?$_POST["id_ls"]:"";			
		if("" == $slist){
			$m_arr_re = array("","ɾ��ʧ�ܣ�ȱ������ID");
			break;
		}
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info;
		$obj->rm_article($slist);
		//$m_arr_re = array("","re=".$re);
		$m_arr_re = array("refresh","");				
		/*include_once("./src_php/control/article_batch_del.php");
		if(true === ($re = batch_del($slist)))
			$m_arr_re = array("","���óɹ�");
		else
			$m_arr_re = array("",$re);
		*/
		//$m_arr_re = array("","�������þ������".$slist);
		break;
	case "batch_good": //�������þ���
		//$m_arr_re = array("","good");
		//break;		
		//�б�,��ʽ:"Y_id,id...;N_id,id..."(Y����,N�Ǿ���)
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,16)){ //��Ȩ���ȴ����
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$slist = isset($_POST["slist"])?$_POST["slist"]:"";			
		include_once("./src_php/control/article_batch_good.php");
		if(true === ($re = batch_good($slist)))
			$m_arr_re = array("","���óɹ�");
		else
			$m_arr_re = array("",$re);
		//$m_arr_re = array("","�������þ������".$slist);
		break;
	case "good_article": //���þ�������
		$id = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$good = isset($_GET["good"])?$_GET["good"]:"";
		if("Y" != $good && "N" != $good){
			$m_arr_re = array("","���þ���ʧ�ܣ�����������Ч:".$good);
			break;
		}
		if("Y" == $good){
			if(!check_confcode("conf_good"))
				exit(); //�ⲽ�ж���֮��				
		}
		else{
			if(!check_confcode("conf_clgood"))
				exit(); //�ⲽ�ж���֮��				
		}
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,13)){ //��Ȩ���ȴ����
			my_safe_include("mwjx/action_queue.php");
			$obj_action = new c_action_queue;
			$requester = $obj_man->get_id();
			if($requester < 1)
				$requester = $m_guest_id;

			$re = $obj_action->add($requester,13,$id.",".$good);
			if($re){	
				$m_arr_re = array("","���þ����ɹ�����Ҫ�ȴ���Ȩ�޵��������ͨ��������Ч");					
			}
			else{
				$m_arr_re = array("","���þ���ʧ�ܣ�ԭ��δ֪");
			}
			break;
		}
		//��Ȩ�ޣ�ֱ�Ӳ���
		my_safe_include("class_article.php");
		$obj_article = new articlebase($id);
		if($obj_article->get_id() < 1){
			$m_arr_re = array("","����ʧ�ܣ�������Ч:".$id);
			break;
		}
		//$obj_article->set_good($good);
		//$obj_article->enum_good = "N";
		$obj_article->set_good($good);
		if($obj_article->save_info()){
			$url = "/mwjx/src_php/data_article.php?id=".strval($id)."&r_cid=".$obj_article->get_class_id();
			$m_arr_re = array($url,"���óɹ�");
		}
		else{
			$m_arr_re = array("","����ʧ�ܣ�������������Ч,id=".$id);
		}
		break;
	case "add_classdir": //�༭��Ŀ
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,20)){ //��Ȩ���ȴ����
			$m_arr_re = array("","��Ȩ��");
			break;		
		}		
		$dirid = intval(isset($_POST["dir_id"])?$_POST["dir_id"]:-1);
		$cid = intval(isset($_POST["txt_cid"])?$_POST["txt_cid"]:-1);
		$title = isset($_POST["txt_title"])?$_POST["txt_title"]:"";
		$ct = isset($_POST["txt_content"])?$_POST["txt_content"]:"";
		if("" == $title || $cid < 1){
			$m_arr_re = array("","��������Ϊ��");
			break;
		}
		$title = addslashes($title);
		$ct = addslashes($ct);
		my_safe_include("mwjx/class_dir.php");
		$obj_cd = new c_class_dir;
		if($dirid > 0) //����
			$re = $obj_cd->up_dir($dirid,$cid,$title,$ct);
		else //���
			$re = $obj_cd->add_dir($cid,$title,$ct);
		if($re)
			$m_arr_re = array("","�ύ�ɹ�");
		else
			$m_arr_re = array("","�ύʧ��");
		break;
	case "collections": //�ղ���Ʒ
		$oid = intval(isset($_GET["id"])?$_GET["id"]:-1);
		$ctype = (isset($_GET["type"])?$_GET["type"]:"");
		my_safe_include("mwjx/collections.php");
		$obj = new c_collections;
		$re = $obj->collect($obj_man->get_id(),$oid,$ctype);
		if(true === $re)
			$m_arr_re = array("","�ղسɹ�");
		else
			$m_arr_re = array("",$re);
		break;
	case "sitetop": //������µ�����ͷ��
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,22)){ //��Ȩ���ȴ����
			$m_arr_re = array("","��Ȩ��");
			break;		
		}		
		$oid = intval(isset($_GET["id"])?$_GET["id"]:-1);
		//$m_arr_re = array("","����δ���");
		my_safe_include("mwjx/set_article.php");
		$set = new c_set_article;
		$re = $set->sitetop($oid);
		if(true === $re)
			$m_arr_re = array("","���óɹ�");
		else
			$m_arr_re = array("",$re);
		break;
	case "add_homepage": //�Ƽ�����ҳ
		//add_homepage
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,1,1,23)){ //��Ȩ���ȴ����
			$m_arr_re = array("","��Ȩ��");
			break;		
		}		
		$oid = intval(isset($_GET["id"])?$_GET["id"]:-1);
		//$m_arr_re = array("","����δ���");
		my_safe_include("mwjx/set_article.php");
		$set = new c_set_article;
		$re = $set->add_homepage($oid);
		if(true === $re)
			$m_arr_re = array("","���óɹ�");
		else
			$m_arr_re = array("",$re);
		break;
	case "reset_used": //���ø����Ѷ�
		//��ԴID
		$tid = intval(isset($_REQUEST["autoadd"])?$_REQUEST["autoadd"]:"-1");
		//��ĿID
		$cid = intval(isset($_REQUEST["clist"])?$_REQUEST["clist"]:"-1");
		//�ύ��ʽF��/B�����ύ
		$ref = (isset($_REQUEST["ref"])?$_REQUEST["ref"]:"F"); 
		//$m_arr_re = array("refresh","ref:".$ref);
		//break;		
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){ //��Ȩ���ȴ����
			if("F" == $ref){ //ǰ̨�ύ
				$m_arr_re = array("","��Ȩ��");
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
	case "add_track": //�����Դ
//		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
//			$m_arr_re = array("","��Ȩ��");
//			break;		
//		}
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,24)){
			$m_arr_re = array("","��Ȩ��");
			break;
		}
		$url = trim(isset($_POST["txt_url"])?$_POST["txt_url"]:"");
		$flag = intval(isset($_POST["flag_id"])?$_POST["flag_id"]:-1);
		my_safe_include("mwjx/track.php");
		$arr_flag = arr_track_flag(); //flag=>title
		//$m_arr_re = array("","aa");
		//break;
		if($cid < 1 || $flag < 1 || "" == $url){
			$m_arr_re = array("","���ʧ�ܣ�������Ч");
			break;
		}
		if(!isset($arr_flag[$flag])){
			$m_arr_re = array("","���ʧ�ܣ���Դ��־��Ч");
			break;
		}
		//�Ƿ��ظ�
		if(!add_track($cid,$flag,$url,$arr_flag[$flag])){
			$m_arr_re = array("refresh","���ʧ�ܣ�����Դ�Ѵ���");
			break;
		}
		$m_arr_re = array("refresh","��ӳɹ�");
		break;
	case "pick_author": //��ȡ��Ŀ���ߣ�������ҳ
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			exit("");		
		}
		//����ҳ��ַ
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
	case "update_author": //������Ŀ����
//		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
//			$m_arr_re = array("","��Ȩ��");
//			break;		
//		}
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,26)){
			$m_arr_re = array("","��Ȩ��");
			break;
		}

		$stcid = intval(isset($_POST["st_cid"])?$_POST["st_cid"]:-1);
		if($cid < 1)
			$cid = $stcid;
		$author = trim(isset($_POST["txt_author"])?$_POST["txt_author"]:"");
		my_safe_include("mwjx/class_info.php");
		if($cid < 1 || "" == $author){
			$m_arr_re = array("","����ʧ�ܣ�������Ч");
			break;
		}
		$objinfo = new c_class_info($cid);
		if($objinfo->get_id() < 1){
			$m_arr_re = array("","����ʧ�ܣ���Ŀ��Ч");
			break;
		}
		$objinfo->update_author($author);
		/**/
		$m_arr_re = array("refresh","");
		break;
	case "link_mybook": //����Ŀ����������
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		$bid = intval(isset($_POST["content"])?$_POST["content"]:-1);
		if($cid < 1 || $bid < 1){
			$m_arr_re = array("","��Ŀ�����ID��Ч");
			break;
		}
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,3,$bid,25)){
			$m_arr_re = array("","��Ȩ��");
			break;
		}
		my_safe_include("mwjx/mybook.php");
		$obj_mb = new c_mybook($bid);
		if(0 == ($re=$obj_mb->link_book($obj_man->get_id(),$cid)))
			$m_arr_re = array("refresh","��Ŀ����������ɹ�",3);
		else
			$m_arr_re = array("","��Ŀ����������ʧ��,code=".$re);
		//$m_arr_re = array("","cid=".$cid.",bid=".$bid);
		break;
	case "rm_sou": //�����·
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$sid = intval(isset($_POST["content"])?$_POST["content"]:-1);
		if($sid < 1){
			$m_arr_re = array("","����ʧ�ܣ���Դ��Ч");
			break;		
		}
		
		//�ļ�
		/*$dir = "../data/update_track/".$sid;
		//$dir_ab = "/usr/home/mwjx/mwjx.com/data/update_track/".$sid;
		//passthru("chmod 0777 ".$dir_ab);
		if(0 == remove_directory($dir)){
			$m_arr_re = array("","����ʧ�ܣ�ɾ���ļ�ʧ��");
			break;		
		}
		*/
		//��¼
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
		$m_arr_re = array("refresh",""); //"����ɹ�:".$sid
		break;
	case "set_autoadd": //�����Զ����
		$cid = intval(isset($_POST["clist"])?$_POST["clist"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
//		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
//			$m_arr_re = array("","��Ȩ��");
//			break;		
//		}
		$flag = (isset($_POST["ref"])?$_POST["ref"]:'N');
		$sid = intval(isset($_POST["id_ls"])?$_POST["id_ls"]:-1);
		if($sid < 1 || $cid < 1){
			$m_arr_re = array("","����ʧ�ܣ���Դ����Ŀ��Ч");
			break;		
		}
		//$m_arr_re = array("","����");
		//break;			
		//��¼
		if("Y" == $flag){
			$str_sql = "select * from auto_add where cid='".$cid."';";
			$sql = new mysql;
			$sql->query($str_sql);
			$sql->close();
			$arr = $sql->get_array_rows();
			if(count($arr) > 0){ //����
				$str_sql = "update auto_add set sid='".$sid."' where cid='".$cid."';";
			}
			else{ //����
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
		$m_arr_re = array("refresh",""); //"����ɹ�:".$sid
		break;
	case "track_rmrc": //�����·
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$idls = (isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		if("" == $idls){
			$m_arr_re = array("","����ʧ�ܣ���Դ��Ч");
			break;		
		}
		
		//��¼
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
	case "track_rmunused": //���δ����¼
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$idls = (isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		if("" == $idls){
			$m_arr_re = array("","����ʧ�ܣ���Դ��Ч");
			break;		
		}
		
		//��¼
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
	case "del_pass": //ɾ���½ڹ�������
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$id = intval(isset($_POST["hd_id"])?$_POST["hd_id"]:-1);
		if($id < 1){
			$m_arr_re = array("","ɾ��ʧ��,ID��Ч");
			break;
		}
		//ɾ��
		$str_sql = "delete from track_pass where id='".$id."';";
		$sql = new mysql("fish838");
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("refresh","");
		break;
	case "add_pass": //����½ڹ�������
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$id = intval(isset($_POST["hd_id"])?$_POST["hd_id"]:"");
		$site = intval(isset($_POST["hd_site"])?$_POST["hd_site"]:-1);
		$t = intval(isset($_POST["st_t"])?$_POST["st_t"]:-1);
		$val = trim(isset($_POST["txt_val"])?$_POST["txt_val"]:"");
		//$m_arr_re = array("","�������,id=".$id.",site=".$site.",t=".$t.",val:".$val);
		//break;		
		if("" == $val || $site < 1 || $t < 1){
			$m_arr_re = array("","����ʧ�ܣ�������Ч");
			break;		
		}
		
		//��¼
		if($id < 1){ //����
			$str_sql = "insert into track_pass (site,t,val)values('".$site."','".$t."','".$val."');";
		}
		else{ //�޸�
			$str_sql = "update track_pass set t='".$t."',val='".$val."' where id='".$id."';";
		}
		//ɾ��
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
	case "add_sou": //�����Դվ��
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$title = trim(isset($_POST["hd_id"])?$_POST["hd_id"]:"");
		$flag = trim(isset($_POST["hd_site"])?$_POST["hd_site"]:"");
		//$m_arr_re = array("","�������,title=".$title);
		//break;		
		if("" == $title){
			$m_arr_re = array("","����ʧ�ܣ�������Ч");
			break;		
		}
		$str_sql = "insert into track_sou (title,flag)values('".$title."','".$flag."');";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("refresh","");
		break;
	case "save_trackurl": //������Դ��ַ
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$id = trim(isset($_POST["id_ls"])?$_POST["id_ls"]:"");
		$url = trim(isset($_POST["txt_url"])?$_POST["txt_url"]:"");
		//$m_arr_re = array("","�������,id=".$id.",url=".$url);
		//break;		
		if("" == $url || "" == $id){
			$m_arr_re = array("","����ʧ�ܣ�������Ч");
			break;		
		}
		$str_sql = "update update_track set url='".$url."' where id ='".$id."';";
		//exit($str_sql);
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("refresh","");
		break;
	case "rm_c_article": //ɾ����Ŀ�����½�
//		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
//			$m_arr_re = array("","��Ȩ��");
//			break;		
//		}
		$cid = intval(isset($_POST["content"])?$_POST["content"]:-1);
		$obj = new c_authorize;		
		if(!$obj->can_do($obj_man,2,$cid,0)){
			$m_arr_re = array("","��Ȩ�ޣ����ǹ���Ա");
			break;
		}
		//$m_arr_re = array("","�������,cid=".$cid);
		//break;		
		if($cid < 1){
			$m_arr_re = array("","����ʧ�ܣ�������Ч");
			break;		
		}
		my_safe_include("mwjx/class_info.php");
		$obj = new c_class_info($cid);
		if($obj->get_id() < 1){
			$m_arr_re = array("","����ʧ�ܣ���Ŀ��Ч");
			break;		
		}
		$obj->rm_article();
		$m_arr_re = array("refresh","");
		break;
	case "track_preparatory": //�������С˵�б�
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$ls = trim(isset($_POST["hd_content"])?$_POST["hd_content"]:"");
		my_safe_include("mwjx/class_info.php");
		my_safe_include("mwjx/track.php");
		my_safe_include("mwjx/track_preparatory.php");
		//$m_arr_re = array("","����ʧ�ܣ�ԭ��δ֪��ls=".$ls);
		//break;		
		if(!batch_book($ls)){
			$m_arr_re = array("","����ʧ�ܣ�ԭ��δ֪��ls=".$ls);
			break;		
		}
		$m_arr_re = array("refresh","������");
		break;
	case "commit_rules": //�����ύ����
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$site = intval(isset($_POST["hd_site"])?$_POST["hd_site"]:-1);
		$t = intval(isset($_POST["st_t"])?$_POST["st_t"]:-1);
		$val = trim(isset($_POST["txt_rules"])?$_POST["txt_rules"]:"");
		//$m_arr_re = array("","�������,id=".$id.",site=".$site.",t=".$t.",val:".$val);
		//break;		
		if($site < 1 || $t < 1){
			$m_arr_re = array("","����ʧ�ܣ�������Ч");
			break;		
		}
		//$m_arr_re = array("","site=".$site.",t=".$t.",rules:".count($arr));
		//break;		
		//ɾ���ɼ�¼
		$str_sql = "delete from track_pass where site='".$site."' and t = '".$t."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		//����¼�¼
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
	case "static_all": //����������Ŀ��̬�ļ�
		//$m_arr_re = array("","aa");
		//break;
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}		
		$cid = intval(isset($_POST["id_ls"])?$_POST["id_ls"]:-1);
		//��Ŀ
		if($cid > 0){
			$str_sql="insert into static_update (oid,t,action) select id,'C','Y' from class_info where id='".$cid."';";
		}
		else{
			$str_sql="insert into static_update (oid,t,action) select id,'C','Y' from class_info;";
		}
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		
		//����
		if($cid > 0){
			$str_sql="insert into static_update (oid,t,action) select id,'A','Y' from article where cid='".$cid."';";
		}
		else{
			$str_sql="insert into static_update (oid,t,action) select id,'A','Y' from article;";
		}
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		$m_arr_re = array("","����ָ��������");
		break;
	case "rm_emptysou": //ɾ������Դ
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
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
			$m_arr_re = array("","��ǰû�п���Դ");
			break;
		}
		//ɾ����Դ
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
		$m_arr_re = array("refresh","ɾ���ɹ���".$ls);
		break;
	case "report_err":  //��������½�
		$id = intval(isset($_POST["aid"])?$_POST["aid"]:-1);
		//$id = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		//$m_arr_re = array("","aaa");
		if($id < 1){
			$m_arr_re = array("","�ٱ�ʧ�ܣ��½�ID��Ч��".$id);
			break;		
		}
		my_safe_include("mwjx/action_queue.php");
		$obj_action = new c_action_queue;
		$requester = $obj_man->get_id();
		if($requester < 1)
			$requester = $m_guest_id;
		$re = $obj_action->add($requester,15,strval($id));
		$m_arr_re = array("","�ٱ������½ڳɹ�������Ա���ڵ�һʱ�������ô���лл�������");

		break;
	case "class_kw": //�����ύ��Ŀ�ؼ���
		if(200200067 != $obj_man->get_id()){ //С�㲻����֤
			$m_arr_re = array("","��Ȩ��");
			break;		
		}
		$cid = intval(isset($_POST["hd_fid"])?$_POST["hd_fid"]:-1);
		$val = trim(isset($_POST["txt_kwls"])?$_POST["txt_kwls"]:"");
		//$m_arr_re = array("","�������,id=".$id.",site=".$site.",t=".$t.",val:".$val);
		//break;		
		if($cid < 1){
			$m_arr_re = array("","����ʧ�ܣ�������Ч");
			break;		
		}
		//$m_arr_re = array("","site=".$site.",t=".$t.",rules:".count($arr));
		//break;		
		//ɾ���ɼ�¼
		$str_sql = "delete from class_kw where cid='".$cid."';";
		$sql = new mysql;
		$sql->query($str_sql);
		$sql->close();
		//����¼�¼
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
	case "auto_book": //ȫ�Զ���������ղ�
		if($obj_man->get_id() < 1){ //û��¼,�Զ����ο���ݵ�¼
			$uname="��ʱ�û�"; //200222044
			$upass="123";
			$upass=crypt(stripslashes($upass),"d.r");  
			$obj_man = new manbase_2($uname,$upass);
			if($obj_man->get_id() < 1){
				$m_arr_re = array("","���¼:".$obj_man->get_id());
				break;
			}
			$cookietime=time()+86400*1;
			setcookie("username",$uname,$cookietime,"/");
			setcookie("userpass",$upass,$cookietime,"/");
			//break;		
		}
		$title = trim(isset($_REQUEST["title"])?$_REQUEST["title"]:"");
		$nid = intval(isset($_REQUEST["nid"])?$_REQUEST["nid"]:-1);
		//�ύ��ʽF��/B�����ύ
		$ref = (isset($_REQUEST["ref"])?$_REQUEST["ref"]:"F"); 
		//$m_arr_re = array("","����:".$nid);
		//break;		
		if("F" == $ref){ //ǰ̨�ύ
			if("" == $title){
				$m_arr_re = array("","��������Ϊ��");
				break;		
			}
			if($nid < 1){
				$m_arr_re = array("","�����Ч");
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
			$obj_mb->rm_left($uid); //ɾ����������˵���������
			if("F" == $ref){ //ǰ̨�ύ
				$m_arr_re = array("../index.php?main=view/mybook.php?id=".$re,"���顶".$title."���Ѿ��ɹ�����ҵ���⣬�ص�838������ͱ���",1);
			}
			else{
				exit("Y");
			}
		}
		else{
			if("F" == $ref){ //ǰ̨�ύ
				$m_arr_re = array("","��Ӳ���ʧ��,code=".$re);
			}
			else{
				exit("N");
			}
		}
		break;
	case "add_mybook": //��������ղ�
		//$m_arr_re = array("","��Ȩ��,���¼");
		if($obj_man->get_id() < 1){ //��Ȩ
			$m_arr_re = array("","��Ȩ��,���¼");
			break;		
		}
		$title = trim(isset($_POST["title"])?$_POST["title"]:"");
		if("" == $title){
			$m_arr_re = array("","��������Ϊ��");
			break;		
		}
		my_safe_include("mwjx/mybook.php");
		$obj_mb = new c_mybook;
		if(0 == ($re=$obj_mb->add_book($obj_man->get_id(),$title)))
			$m_arr_re = array("refresh","�������ɹ���".$title,3);
		else
			$m_arr_re = array("","�������ʧ��,code=".$re);
		break;
	case "rm_mybook": //ɾ������
		//�ύ��ʽF��/B�����ύ
		$oid = intval(isset($_REQUEST["content"])?$_REQUEST["content"]:-1);
		$ref = (isset($_REQUEST["ref"])?$_REQUEST["ref"]:"F"); 
		$obj = new c_authorize;		
		//if(!$obj->can_do($obj_man,3,$oid,0)){ //��Ȩ���ȴ����
		if($obj_man->get_id() < 1){ //��Ȩ
			if("F" == $ref){ //ǰ̨�ύ
				$m_arr_re = array("","��Ȩ��");
			}
			else{
				exit("��Ȩ��");
			}
			break;		
		}

//		if($obj_man->get_id() < 1){ //��Ȩ
//			$m_arr_re = array("","��Ȩ��,���¼");
//			break;		
//		}
		//$m_arr_re = array("refresh","tests��".$oid,3);
		//exit("<script language=\"javascript\">alert(top.location.href);</script>");
		//break;
		if($oid < 1){
			if("F" == $ref) //ǰ̨�ύ
				$m_arr_re = array("","����ID��Ч");
			else
				exit("����ID��Ч");
			break;		
		}
		my_safe_include("mwjx/mybook.php");
		$obj_mb = new c_mybook;
		$uid = $obj_man->get_id();
		if(0 == ($re=$obj_mb->rm_mybook($oid,$uid))){
			$obj_mb->rm_left($uid); //ɾ����������˵���������
			if("F" == $ref) //ǰ̨�ύ
				$m_arr_re = array("refresh","ɾ������ɹ���".$oid,3);
			else
				exit("Y");
		}
		else{
			if("F" == $ref) //ǰ̨�ύ
				$m_arr_re = array("","ɾ������ʧ��,code=".$re);
			else
				exit("ɾ������ʧ��,code=".$re);
		}
		break;
	case "make_manager": //��Ϊ��Ŀ����Ա
		$cid = intval(isset($_POST["cid"])?$_POST["cid"]:-1);
		//exit("cid==".$cid);
		my_safe_include("cmd/make_manager.php");
		$re = make_manager($obj_man->get_id(),$cid);
		exit("".$re);
		break;
	default:		
		$m_arr_re = array("","������Ч");		
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
	//��תҳ��
	//����:url��Ϊ����ת���õ�ַ,ֵrefreshˢ�µ�ǰ����,
	//str��Ϊ����ʾ����Ϣ
	//flag(int)1/2/3/4(������/��ǰ����/�洰��/�����´���)
	//���:��
	//����Ҫ��exit���
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
	//�����֤��
	//����:str��������֤��ı�����,post��ʽ
	//���:trueͨ��,false��ͨ��
	//ǰ�ñ�֤session_start����
	//��������ͨ��ʱ���ж�ִ������ҳ��
	$conf_code = trim(isset($_POST[$str])?$_POST[$str]:"");
	if("" == $_SESSION[$str] || "" == $conf_code){
		goto_url("","��֤����Ч�����������ˢ��ҳ�滻��ͼƬ����");
		return false;
	}
	$conf_code = strtolower($conf_code);
	if($conf_code != $_SESSION[$str]){
		goto_url("","��֤����Ч�����������ˢ��ҳ�滻��ͼƬ����");
		return false;
	}
	return true;
}
function remove_directory($dir="") 
{
	//ɾ��Ŀ¼�����ļ�
	//����:dir(string)Ŀ¼,��Ҫ/��β
	//���:���Σ����󷵻�0
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