<?php
//------------------------------
//create time:2008-1-14
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:二进制流
//------------------------------
$path = "/usr/home/mwjx/data/003.wma";
//下载给用户
header("Content-type: application/download\r\n");
header("Content-length: ".filesize($path)."\r\n");
header("Content-disposition:attachment; filename=".substr($path,strrpos($path,"/")+1));
$result = readfile($path);
//exit($path.":".$m_ls);
exit();
/*
*/
/*
$fp = fopen($file, "rb";
if ($start >; 0)
{
        fseek($fp, $start);
        Header("HTTP/1.1 206 Partial Content";
        Header("Content-Type: application/octet-stream";
        Header("Accept-Ranges: bytes";   
        Header("Content-Range: bytes ".$start."-".($size-1)."/".$size);
        Header("Content-Length: ".($size-$start));
        Header("Content-Disposition: attachment; filename=".$file);
}
else
{
        Header("Content-Type: application/octet-stream";
        Header("Accept-Ranges: bytes";
        Header("Content-Length: ".$size);
        Header("Content-Disposition: attachment; filename=".$file);
}
fpassthru($fp); 
*/
?>