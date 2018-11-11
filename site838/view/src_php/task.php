<?php
//------------------------------
//create time:2006-6-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:����
//------------------------------
class c_task_base
{
	//�������
//public:
	//set_active(); //������Ч��
	//save(); //��������
//private:
	var $id = -1;
	var $name = "";
	var $type = -1; //��������,��get_tbl_task�еĶ���
	var $host = -1;
	var $run_er = -1;
	var $interval = "D";
	var $cday = "0000-00-00";
	var $last = "0000-00-00 00:00:00";
	var $active = "N";
//public:
	function c_task_base($id = "")
	{
		//����
		//����:id����ID
		//���:��
		if(intval($id) < 1)
			return;
		$tbl = $this->get_tbl();
		$str_sql  = "select * from ".$tbl." where id = ".strval($id)." and active = 'Y'";
		$sql=new mysql;
		$sql->query($str_sql);
		$sql->close();
		if($sql->get_num_rows() != 1)
			return;
		$arr = $sql->get_array_rows();
		$this->load_arr($arr[0]);
	}
	//run
	//add_new
	//load_arr
	//get_id
	//get_type
	//update_last_save
//public code:
	function update_last_save()
	{
		$this->update_last();
		$this->save();
	}
	function get_last()
	{
		return $this->last;
	}
	function get_type()
	{
		return $this->type;
	}
	function get_id()
	{
		return $this->id;
	}
	function run($uid = 0)
	{
		//���б�����
		//����:$uid��ִ����ID
		//���:true,false
		if(!$this->run_able())
			return false;
		$id = $this->type;
		if(($arr = $this->query_task_info($id)) === false)
			return false;
		//if(7 != $this->type)
		//	return false;
		//echo "oo";
		my_safe_include($arr[0]);
		$obj = new $arr[1]($this);
		//var_dump($arr);
		$re = $obj->run();
		//exit("ccc");
		if(true === $re){
			$this->run_er = $uid;
			$this->update_last();
			$this->save();
		}
		return $re;
	}

	function add_new($arr)
	{
		//�½�һ������
		//����:arr�ǲ����б�name(s),type(i),host(i),interval(s)
		//���:true,false
		$this->new_default();
		//���ò���
		$this->name = $arr["name"];
		$this->type = intval($arr["type"]);
		$this->host = $arr["host"];
		$this->interval = $arr["interval"];
		$this->id = 0; //���������ֵ,check_varͨ����
		if(!$this->check_var())
			return false;
		return $this->insert_self(); //��ӵ����ݿ�
	}
//private:
	function set_active($a = "Y")
	{
		//������Ч��
		//����:a(string)Y/N
		//���:��
		$this->active = $a;
	}
	function save()
	{
		//���汾������Ϣ
		//����:��
		//���:true,false
		$tbl = $this->get_tbl();
		$str_sql  = "update ".$tbl." set name = '$this->name',run_er = '".strval($this->run_er)."',last = '$this->last',active = '$this->active' where id = ".strval($this->id);
		//exit($str_sql);
		$sql=new mysql;
		$sql->query($str_sql);
		$sql->close();
		return true;
	}
	function update_last()
	{
		$this->last = date("Y-m-d H:i:s",time());  //����ʱ��
	}
	function run_able()
	{
		//�������Ƿ�������
		//���룺��
		//����������з���true,���򷵻�false
		//�������ʱ�����������
		//return true;
		if(!$this->check_var())
			return false;
		$int_last = strtotime($this->last);
		if($int_last > time())   //�ϴθ������ھ�Ȼ���ڵ�ǰ����
			return false;
		switch($this->interval){
			case "D":				
				//if(date("d",time()) != date("d",$int_last)){
				if((date("d",time()) != date("d",$int_last)) || (date("m",time()) != date("m",$int_last)) || (date("Y",time()) != date("Y",$int_last))){			
					return true;
				}
				break;
			case "W":
				if(date("W",time()) != date("W",$int_last))
					return true;
				break;
			case "M":
				if(date("m",time()) != date("m",$int_last))
					return true;
				break;
			case "H":
				if((date("H",time()) != date("H",$int_last)) || (date("d",time()) != date("d",$int_last)) || (date("m",time()) != date("m",$int_last)) || (date("Y",time()) != date("Y",$int_last)))
					return true;
				break;
			case "E":
				return true;
			default:
				assert(0);
		}
		return false;
	}
	function load_arr(&$arr)
	{
		list($this->id,$this->name,$this->type,$this->host,$this->run_er,$this->interval,$this->cday,$this->last,$this->active)=$arr;
	}
	function check_var()
	{
		//�������Ա�����Ƿ�������ȡֵ��Χ
		//����:��
		//���:��������true,���򷵻�false
		if(($this->id  == -1) || ("" == $this->name) || ($this->type < 1) || ($this->host < 1))
			return false;		
		return true;
	}
	function new_default()
	{
		//���ñ�����ȱʡֵ
		//����:��
		//���:��
		$this->cday = date("Y-m-d",time());
		$this->active = "Y";
	}
	function insert_self()
	{
		//����������Ϊ�¼�¼��ӵ����ݿ�
		//����:��
		//���:true,false
		$tbl = $this->get_tbl();
		$str_sql  = "insert into ".$tbl." (name,`type`,host,run_er,`interval`,cday,last,active)values('$this->name','".strval($this->type)."','".strval($this->host)."','".strval($this->run_er)."','$this->interval','$this->cday','$this->last','$this->active')";
		//exit($str_sql);
		$sql=new mysql;
		$sql->query($str_sql);
		$sql->close();
		return true;
	}
	function get_tbl()
	{
		return "tbl_task";
	}
	function query_task_info($id = -1)
	{
		//����һ����������ID��ѯ����Ϣ
		//����:id����������ID
		//���:����,array("�ļ�·��","����"),�쳣����false
		$arr = $this->get_tbl_task();
		if(!isset($arr[$id]))
			return false;
		return $arr[$id];
	}
	function get_tbl_task()
	{
		//������Ϣ�б�
		//����:��
		//���:����array(��������ID=>array("�ļ�·��","����"))
		$list = array();
		$list[1] = array("mwjx/task/create_html.php","c_create_html");
		$list[2] = array("mwjx/task/create_xml.php","c_create_xml");
		$list[3] = array("mwjx/task/create_index.php","c_create_index");
		$list[4] = array("mwjx/task/batch_checkout.php","c_batch_checkout");
		$list[5] = array("mwjx/task/del_garbage.php","c_del_garbage");
		$list[6] = array("mwjx/task/create_xml_new.php","c_create_xml_new");
		$list[7] = array("mwjx/run_link.php","c_run_link");
		$list[8] = array("mwjx/task/create_classpage.php","c_create_classpage");
		$list[9] = array("mwjx/task/create_dailymail.php","c_create_dailymail");
		$list[10] = array("mwjx/task/daily_html.php","c_daily_html");
		$list[11] = array("mwjx/task/links_html.php","c_links_html");
		$list[12] = array("mwjx/task/create_starpage.php","c_create_starpage");
		$list[13] = array("mwjx/task/today_html.php","c_today_html");
		$list[14] = array("mwjx/task/search_source.php","c_searchsou_task");
		$list[15] = array("mwjx/task/chars_page.php","c_chars_page");
		$list[16] = array("mwjx/task/auto_add.php","c_auto_add");
		$list[17] = array("mwjx/task/create_classtop.php","c_create_classtop");
		$list[18] = array("mwjx/task/static_update.php","c_static_update");
		$list[19] = array("mwjx/task/create_searchlists.php","c_create_searchlists");
		$list[20] = array("mwjx/task/auto_addbook.php","c_auto_addbook");
		$list[21] = array("mwjx/task/create_votetop.php","c_create_votetop");
		$list[22] = array("mwjx/task/clear_track.php","c_clear_track");
		$list[23] = array("mwjx/task/clear_files.php","c_clear_files");
		$list[24] = array("mwjx/task/book_lists.php","c_book_lists");
		$list[25] = array("mwjx/task/empty_class.php","c_empty_class");
		$list[26] = array("mwjx/task/create_classhome.php","c_create_classhome");
		$list[27] = array("mwjx/task/author_lists.php","c_author_lists");
		$list[28] = array("mwjx/task/create_authorpage.php","c_create_authorpage");
		$list[29] = array("mwjx/task/out_lists.php","c_out_lists");
		$list[30] = array("mwjx/task/chars_author.php","c_chars_author");
		$list[31] = array("mwjx/task/update_fchar.php","c_update_fchar");
		$list[32] = array("mwjx/task/last_artid.php","c_last_artid");
		return $list;
	}
}

/*
//---------test------
//��������������ִ��ʱ������php4��Ҫ��php
//����������ʱ�ֶ����ô�ֵ
$_SERVER["PHP_SELF"] = "/mwjx/src_php/task.php"; 
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) <= 0){
	exit("��ǰ�û���Ч");
}
$id = 3;
$obj = new c_task_base($id);
//---------�½�һ������-------
//$arr_new = array("name"=>"����html�ļ�","type"=>1,"host"=>$obj_man->get_id(),"interval"=>"W");
//var_dump($obj->add_new($arr_new));
//����xml�ļ�
//$arr_new = array("name"=>"����xml�ļ�","type"=>2,"host"=>$obj_man->get_id(),"interval"=>"M");
//var_dump($obj->add_new($arr_new));
//������Ŀ����վ��ҳ
//$arr_new = array("name"=>"������Ŀ����վ��ҳ","type"=>3,"host"=>$obj_man->get_id(),"interval"=>"H");
//var_dump($obj->add_new($arr_new));
//���½���
//$arr_new = array("name"=>"ÿ�����½���","type"=>4,"host"=>$obj_man->get_id(),"interval"=>"D");
//var_dump($obj->add_new($arr_new));
//ɾ����������
//$arr_new = array("name"=>"ɾ����������","type"=>5,"host"=>$obj_man->get_id(),"interval"=>"W");
//var_dump($obj->add_new($arr_new));

//--------װ��һ������---------
//var_dump($obj);
//--------����һ������----------
var_dump($obj->run(0));
*/
?>
