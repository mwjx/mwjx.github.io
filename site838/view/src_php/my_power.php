<?php
//------------------------------
//create time:2007-8-16
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:我的权限
//------------------------------
require("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("lib/fun_global.php");
my_safe_include("class_man.php");
$m_id = intval(isset($_GET["id"])?$_GET["id"]:-1);

//$m_id = 200200067; //tests
//$m_id = 200307525;
//$m_id = -1;
//var_dump($arr);
if($m_id < 1)
	exit("用户ID无效");
$m_man = new manbase_2($m_id);
if($m_man->get_id() < 1)
	exit("用户不存在");


$m_arr = get_arr_power($m_id);
//var_dump($m_arr);
//exit();
$str_xml = power_arr2xml($m_arr,$m_man->get_name());
//echo "hello";

print_xml($str_xml);
//echo $m_html;
function get_arr_power($id = -1)
{
	//返回我的权限数组
	//输入:id(int)用户ID
	//输出:数组,array(cid=>res=>array(1,2,3))
	$str_sql = "select * from authorize where run_class = '1' and (runer = '".$id."' or runer = '0');";
	//exit($str_sql);
	$sql=new mysql;
	$sql->query($str_sql);
	$arr = $sql->get_array_array();
	$sql->close();
	//var_dump($arr);
	//exit();
	$arr_power = array();
	$len = count($arr);
	for($i = 0;$i < $len; ++$i){
		$cid = intval($arr[$i]["res_class"]);
		$res = intval($arr[$i]["res"]);
		$action = intval($arr[$i]["action"]);
		//var_dump($arr[$i]);
		//exit();
		if(!isset($arr_power[$cid]))
			$arr_power[$cid] = array();
		if(!isset($arr_power[$cid][$res]))
			$arr_power[$cid][$res] = array();		
		//if(isset($arr_power[$cid][$res]))
		$arr_power[$cid][$res][$action] = true;		
	}
	return $arr_power;
}
function power_arr2xml(&$arr,$name="")
{
	//将权限数组转为xml字符串
	//输入:arr(array)权限数组,name(string)用户名
	//输出:xml字符串
	$arr_type = array(); //资源类型列表
	$arr_type[0] = "所有";
	$arr_type[1] = "网站";
	$arr_type[2] = "类目";
	$arr_type[3] = "藏书";
	$arr_res = array(); //资源列表
	//$arr_res[1] = "妙文精选";
	$arr_res[1] = "838书库";
	//功能列表，array(资源类型=>array(功能ID=>功能名))
	$arr_action = array(); 
	$arr_action[1] = array();
	//$arr_action[1][1] = "发布文章";
	//$arr_action[1][2] = "留言评论";
	$arr_action[1][3] = "创建类目";
	$arr_action[1][4] = "删除类目";
	/*$arr_action[1][5] = "生成首页及排行";
	$arr_action[1][6] = "文章归类";
	$arr_action[1][7] = "取消文章链接";
	$arr_action[1][8] = "删除文章";
	$arr_action[1][9] = "设置文章相关链接";
	$arr_action[1][10] = "设置文章星级";
	$arr_action[1][11] = "推荐文章到类目首页";
	$arr_action[1][12] = "编辑文章";
	$arr_action[1][13] = "设置文章精华";
	$arr_action[1][14] = "删除跟贴评论";
	$arr_action[1][15] = "链接类目";
	$arr_action[1][16] = "批量设置精华文章";
	$arr_action[1][17] = "津贴管理";
	$arr_action[1][18] = "取消类目链接";
	$arr_action[1][19] = "服务器文本修改";
	*/
	$aa [0] = "所有";
	$aa [24] = "添加类目来源";
	$aa [25] = "类目关联到藏书"; //藏书操作
	//----------
	$xml = "<?xml version=\"1.0\"  encoding=\"gb2312\"?>\n";
	$xsl_path = "../include/xsl/my_power.xsl";
	$str_xsl = "<?xml-stylesheet type=\"text/xsl\" href=\"".$xsl_path."\"?>";
	$xml .= $str_xsl;
	$xml .= "<listview>";
	$xml .= "<title>".$name."的权限列表</title>";
	//$len = count($arr);
	foreach($arr as $cid=>$res){
		$xml .= "<res_type>";
		$xml .= "<id>".$cid."</id>";
		$tname = $arr_type[$cid];
		$xml .= "<name>".$tname."</name>";
		foreach($res as $rid=>$row){
			$xml .= "<res>";
			$xml .= "<id>".$rid."</id>";
			$rname = "";
//			if(1 == $cid)
//				$rname = $arr_res[$rid];
//			else
//				$rname = $rid;
			if(0 == $rid)
				$rname = "所有";
			else
				$rname = $rid;
			$xml .= "<name>".$rname."</name>";
			if(1 == $cid){
				foreach($arr_action[$cid] as $aid=>$aname){
					$xml .= "<action>";
					$xml .= "<id>".$aid."</id>";
					$xml .= "<name>".$aname."</name>";
					if($row[$aid])
						$xml .= "<enable>Y</enable>";
					$xml .= "</action>\n";
				}
			}
			else{
				foreach($row as $aid=>$val){
					$xml .= "<action>";
					$xml .= "<id>".$aid."</id>";
					$aname = (isset($aa[$aid])?$aa[$aid]:"未知");
					$xml .= "<name>".$aname."</name>";
					//if($row[$aid])
					$xml .= "<enable>Y</enable>";
					$xml .= "</action>\n";
				}
			}
			/*
			foreach($row as $val){
				$xml .= "<action>";
				$xml .= "<id>".$val."</id>";
				$xml .= "<name>".$val."</name>";
				$xml .= "</action>";
			}
			*/
			$xml .= "</res>\n";
		}
		//$xml .= "<res></res>";
		$xml .= "</res_type>\n";
	}
	$xml .= "</listview>";
	return $xml;
}
?>