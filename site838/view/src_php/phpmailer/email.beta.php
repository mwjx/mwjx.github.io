<?php
exit();
include_once 'EmailFunc.php';
$to="wynn_chen@allyes.com";
//$to="cici_huang@allyes.com";
$subject="luoji EDM";
$from="webmaster@51shai.com";
$fileName="/www/allyes/adf/shai51new/phpshell/51shai_email/EDM.html";
$handle = fopen($fileName, "rb");
while (!feof($handle)) {
  $message .= fread($handle, 8192);
}
fclose($handle);
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=gb2312\r\n";
$headers .= "Content-Transfer-Encoding: base64\r\n";
$timestamp = date("Y-m-d H:i:s");
$ret=send_mail($to, $from, $fromName, $subject, $message, $headers); 
?>