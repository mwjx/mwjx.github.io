<?php
//------------------------------
//create time:2006-6-12
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:任务
//------------------------------
class c_task_base
{
	//任务基类
//public:
	//set_active(); //设置有效性
	//save(); //保存数据
//private:
	var $id = -1;
	var $name = "";
	var $type = -1; //任务类型,看get_tbl_task中的定义
	var $host = -1;
	var $run_er = -1;
	var $interval = "D";
	var $cday = "0000-00-00";
	var $last = "0000-00-00 00:00:00";
	var $active = "N";
//public:
	function c_task_base($id = "")
	{
		//构造
		//输入:id任务ID
		//输出:无
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
		//运行本任务
		//输入:$uid是执行者ID
		//输出:true,false
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
		//新建一个任务
		//输入:arr是参数列表name(s),type(i),host(i),interval(s)
		//输出:true,false
		$this->new_default();
		//设置参数
		$this->name = $arr["name"];
		$this->type = intval($arr["type"]);
		$this->host = $arr["host"];
		$this->interval = $arr["interval"];
		$this->id = 0; //不设置这个值,check_var通不过
		if(!$this->check_var())
			return false;
		return $this->insert_self(); //添加到数据库
	}
//private:
	function set_active($a = "Y")
	{
		//设置有效性
		//输入:a(string)Y/N
		//输出:无
		$this->active = $a;
	}
	function save()
	{
		//保存本对象信息
		//输入:无
		//输出:true,false
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
		$this->last = date("Y-m-d H:i:s",time());  //更新时间
	}
	function run_able()
	{
		//本任务是否能运行
		//输入：无
		//输出：能运行返回true,否则返回false
		//最近运行时间和运行周期
		//return true;
		if(!$this->check_var())
			return false;
		$int_last = strtotime($this->last);
		if($int_last > time())   //上次更新日期竟然大于当前日期
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
		//检查各项成员变量是否在正常取值范围
		//输入:无
		//输出:正常返回true,否则返回false
		if(($this->id  == -1) || ("" == $this->name) || ($this->type < 1) || ($this->host < 1))
			return false;		
		return true;
	}
	function new_default()
	{
		//设置本对象缺省值
		//输入:无
		//输出:无
		$this->cday = date("Y-m-d",time());
		$this->active = "Y";
	}
	function insert_self()
	{
		//将本对象作为新记录添加到数据库
		//输入:无
		//输出:true,false
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
		//根据一个任务类型ID查询其信息
		//输入:id是任务类型ID
		//输出:数组,array("文件路径","类名"),异常返回false
		$arr = $this->get_tbl_task();
		if(!isset($arr[$id]))
			return false;
		return $arr[$id];
	}
	function get_tbl_task()
	{
		//任务信息列表
		//输入:无
		//输出:数组array(任务类型ID=>array("文件路径","类名"))
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
//服务器上命令行执行时用命令php4不要用php
//命令行运行时手动设置此值
$_SERVER["PHP_SELF"] = "/mwjx/src_php/task.php"; 
require("../../aboutfish/fishcountry/class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
$obj_man = new manbase_2(manbase_2::query_current_username(),manbase_2::query_current_userpswd());
if(round($obj_man->get_id()) <= 0){
	exit("当前用户无效");
}
$id = 3;
$obj = new c_task_base($id);
//---------新建一个任务-------
//$arr_new = array("name"=>"生成html文件","type"=>1,"host"=>$obj_man->get_id(),"interval"=>"W");
//var_dump($obj->add_new($arr_new));
//生成xml文件
//$arr_new = array("name"=>"生成xml文件","type"=>2,"host"=>$obj_man->get_id(),"interval"=>"M");
//var_dump($obj->add_new($arr_new));
//生成栏目及网站首页
//$arr_new = array("name"=>"生成栏目及网站首页","type"=>3,"host"=>$obj_man->get_id(),"interval"=>"H");
//var_dump($obj->add_new($arr_new));
//文章结算
//$arr_new = array("name"=>"每日文章结算","type"=>4,"host"=>$obj_man->get_id(),"interval"=>"D");
//var_dump($obj->add_new($arr_new));
//删除垃圾文章
//$arr_new = array("name"=>"删除垃圾文章","type"=>5,"host"=>$obj_man->get_id(),"interval"=>"W");
//var_dump($obj->add_new($arr_new));

//--------装载一个任务---------
//var_dump($obj);
//--------运行一个任务----------
var_dump($obj->run(0));
*/
?>
