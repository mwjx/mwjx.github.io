<?php
//------------------------------
//create time:2006-6-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:�����б�
//------------------------------
class c_task_list
{
	//�����б�
//private:
	//last_time(); //�ϴ�ִ�гɹ�ʱ��
	var $arr_list = array();
//public:
	//c_task_list(); //���캯��
	//run(); //ִ��
//public code:
	function c_task_list($type = "")
	{
		//����
		//����:type�����б�����auto(�Զ�)/hand(�ֶ�)/"all"(ȫ��)
		//���:��
		if("" == $type)
			assert(0);
		if(("auto" != $type) && ("all" != $type))
			assert(0);
		/*$str_auto = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,27,28,29";
		$tbl = $this->get_tbl();
		$str_sql  = "select * from ".$tbl." where type in (".strval($str_auto).") and active = 'Y'";
		//exit($str_sql);
		$sql=new mysql;
		$sql->query($str_sql);
		$sql->close();
		if($sql->get_num_rows() < 1)
			return;
		$this->arr_list = $sql->get_array_rows();	
		*/
		//var_dump($this->arr_list);
	}

	function run($id = 0)
	{
		//���ж���
		//����:id��ִ����ID
		//���:true,false
		//exit("bbb");
		echo "838,run_tasklist<br/>\r\n";
		//echo "���ж���,id=".$id."<br/>\n";
		//ֻ����һ������
		my_safe_include("mwjx/global_conf.php");
		$confname = "run_tasklist";
		$flag = c_global_conf::get_conf($confname);
		if(false === $flag)
			$flag = "N";
		if("N"==$flag){ //��mwjx��conf����Ҫͬʱ���У��Է��ڴ治��
			$flag = c_global_conf::get_conf($confname,"db_mwjx");
			if(false === $flag)
				$flag = "N";
		}
		if("Y" == $flag){
			echo "838,tasklist is runing<br/>\n";
			//echo "flag=".$flag.",last=".$this->last_time()."<br/>\n";
			//����ϴ�ִ��ʱ���񳬹�6Сʱ������ִ��
			if((time()-$this->last_time()) > 6*3600)
				c_global_conf::reset_conf($confname,"N");
			return true;
		}
		c_global_conf::reset_conf($confname,"Y");
		$obj = new c_task_base;
		//ȡ��ID�б�
		$tbl = $this->get_tbl();
		$str_sql  = "select * from ".$tbl." where active = 'Y' and run_er=0 order by id asc;";
		//echo ($str_sql."<br/>\n");
		//exit();
		$sql=new mysql;
		$sql->query($str_sql);
		$arrls = array();
		while($row=$sql->fetch_array()){
			$arrls[] = intval($row[0]);
		}
		//echo "�б�����".count($arrls)."<br/>\n";
		//����ID�б�,�������Է�ֹ�ظ�ִ��
		$len = count($arrls);
		for($i=0;$i < $len; ++$i){
			$tid = $arrls[$i];
//			if(36 != $tid)
//				continue;
//			echo "id=".$tid."<br/>\n";
			//continue;
			//$sql=new mysql;
			$sql->query("select * from ".$tbl." where id='".$tid."';");
			if(!($row = $sql->fetch_array())){
				continue;
			}
			//echo "load\n";
			$obj->load_arr($row);
			//echo "loadok\n";
			if($obj->run($id)){
				echo "838,task #".strval($obj->get_id())." run success<br/>\n";
			}
			else{
				echo "838,task #".strval($obj->get_id())." run fail<br/>\n";
			}
			flush();
		}
		$sql->close();
		//exit();
		echo "838,over list loop<br/>\n";
		c_global_conf::reset_conf($confname,"N");
		return true;
	}
//private:
	function get_tbl()
	{
		return "tbl_task";
	}
	function last_time()
	{
		//�ϴ�ִ�гɹ�ʱ��
		//����:��
		//���:ʱ������,�쳣-1
		$str_sql = "select last from ".$this->get_tbl()." where active='Y' order by last desc limit 1;";
		//exit($str_sql);
		$sql=new mysql;
		$sql->query($str_sql);
		if(!($row = $sql->fetch_array()))
			return -1;
		$t = strtotime($row[0]);
		$sql->close();
		return $t;
	}
}

/*
//--------test-----
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
require("./task.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) <= 0){
	exit("��ǰ�û���Ч");
}
$type = "auto";
$obj = new c_task_list($type);
//--------װ��-------
//var_dump($obj);
//------����-----
var_dump($obj->run());
*/
?>