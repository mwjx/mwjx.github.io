<?php
//------------------------------
//create time:2006-6-13
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:����������е��Զ�����
//------------------------------
//��������������ִ��ʱ������php4��Ҫ��php
//����������ʱ�ֶ����ô�ֵ
//�����nohupִ�б�����,ע������nohup.out�ļ�
$_SERVER["PHP_SELF"] = "/site838/view/src_php/run_list.php"; 
require("../../class/function.inc.php");
require("./task_list.php");
require("./task.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("class_man.php");
//echo("aaa<br/>\n");
//writetofile("/usr/home/mwjx/xxx.txt",date("Y-m-d H:i:s",time()));
$type = "auto";
$obj = new c_task_list($type);
//------����-----
echo "838,start auto tasklist at:".date("Y-m-d H:i:s",time())."<br/>\n";
$re = $obj->run(0);
if($re)
	echo "838,end tasklist at:".date("Y-m-d H:i:s",time())."<br/>\n";
else
	echo "838,end tasklist at:".date("Y-m-d H:i:s",time())."<br/>\n";
?>
