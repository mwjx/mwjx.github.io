<?
define("SMTP_SERVER_ADDR", "localhost"); //本机作为SMTP主机
//define("SMTP_SERVER_ADDR", "127.0.0.1"); //本机作为SMTP主机(两者皆可行,不过老师推荐上面那个)
//define("SMTP_SERVER_ADDR", "210.52.214.219");
define("SMTP_DOMAIN", "localhost");


global $sendFromMailAddr,$sendFromMailName; 
$sendFromMailAddr = "webmaster@allyes.com";
$sendFromMailName = "51shai 通知";


function replaceurl($str)//替换MAIL中的URL
{
	$pattern = "/(https|http):\/\/[\w-]+(\.[-\w]+)+((\/\w+([-\w]+)?)*((\/[-\w.]+\.(htm|phtml|html|php3|php|asp|xml|aspx|jsp|shtml)(\?[\w=&]+)?)|\/))?/i";
	return preg_replace($pattern, '<a href="\\0" target="_blank">\\0</a>', $str);
}

function title_gb2312_encode($subtxt)
{//对mail的标题进行gb2312编码, 使之显示中文时有更大的兼容性
	$round = strlen($subtxt);
	for ($i=0; $i < $round; $i++)
	{
		if (ord($subtxt[$i]) >= 160)
		{
			$tempstr1 = dechex(ord($subtxt[$i]));
			$tempstr2 = dechex(ord($subtxt[$i+1]));
			$str .= "=".$tempstr1."=".$tempstr2;
			$i++;
		}else
		{
			$str.=$subtxt[$i];
		}
	}
	return "=?GB2312?Q?".$str."?=";
}

//$mail收信人地址列表(可以为数组)
//$aryInfo信件内容数组
/*
$aryInfo = array(
	"body" => "",//信件内容
	"title" => "",//信件标题
	"from" => 发信人email
	"fromName" => 发信人名称	
	)
*/

function sendTrueMail($mail, $aryInfo)
{
	$mailbody = replaceurl($aryInfo['body']);
	$subject = $aryInfo['title'];

	$from = $aryInfo['from'];
	$fromName = empty($aryInfo['fromName'])?$from:$aryInfo['fromName'].'<'.$from.'>';
	
	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=gb2312\r\n";
	$headers .= "Content-Transfer-Encoding: base64\r\n";

	//发信地址
	$mailflag = date("YmdHis");
	
	if (!is_array($mail))
	{
		$mail = array($mail);
	}
	$mail=array_unique($mail); //保持不重复发信

	foreach ($mail as $onemail)
	{
		$timestamp = date("Y-m-d H:i:s");
		if (!send_mail($onemail, $from, $fromName, title_gb2312_encode($subject), $mailbody, $headers))
		{
			$mailfp = fopen("truemail.log", "a");
			$logline = "Error\t\t".$mailflag."\t\tFROM ".$from." TO ".$onemail."\t\t".$subject."\t\t".$timestamp."\n";
			fwrite($mailfp, $logline);
			fclose($mailfp);
			return false;
		}else
		{
			$mailfp = fopen("truemail.log", "a");
			$logline = "OK   \t\t".$mailflag."\t\tFROM ".$from." TO ".$onemail."\t\t".$subject."\t\t".$timestamp."\n";
			fwrite($mailfp, $logline);
			fclose($mailfp);
			return true;
		}
	}
}

function send_mail($to, $from, $fromName, $subject, $message, $headers) 
{
	//Open an SMTP connection
	$smtpfp = fsockopen(SMTP_SERVER_ADDR, 25, $e1, $e2, 30);
	if (!$smtpfp)
	{
		$successFlag = 0;
	}else
	{
		$res = fgets($smtpfp, 256);
		if (substr($res,0,3) != "220")
		{
			$successFlag = 0;
		}else
		{
			// Introduce ourselves
			fputs($smtpfp, "HELO ".SMTP_DOMAIN."\r\n");
			$res = fgets($smtpfp, 256);
			if (substr($res,0,3) != "250")
			{
				$successFlag = 0;
			}else
			{
				// Envelope from
				fputs($smtpfp, "MAIL FROM: ".$from."\r\n");
				$res = fgets($smtpfp, 256);
				if (substr($res,0,3) != "250")
				{
					$successFlag = 0;
				}else
				{
					// Envelope to
					fputs($smtpfp, "RCPT TO: ".$to."\r\n");
					$res = fgets($smtpfp, 256);
					if (substr($res,0,3) != "250")
					{
						$successFlag = 0;
					}else
					{
						// The message
						fputs($smtpfp, "DATA\r\n");
						$res = fgets($smtpfp,256);
						if (substr($res,0,3) != "354")
						{
							$successFlag = 0;
						}else
						{
							// Send To:, From:, Subject:, other headers, blank line, message, and finish
							// with a period on its own line.
							$message = chunk_split(base64_encode(StripSlashes($message)));
							fputs($smtpfp, "To: ".$to."\r\nFrom: ".$fromName."\r\nSubject: ".$subject."\r\n".$headers."\r\n\r\n".$message."\r\n.\r\n");
							$res = fgets($smtpfp,256);
							if (substr($res,0,3) != "250")
							{
								$successFlag = 0;
							}else
							{
								// Say bye bye
								fputs($smtpfp, "QUIT\n");
								$res = fgets($smtpfp, 256);
								if (substr($res,0,3) != "221")
								{
									$successFlag = 0;
								}else
								{
									$successFlag = 1;
								}
							}
						}
					}
				}
			}
		}
		if ($successFlag == 0)
			fputs($smtpfp, "QUIT\n");
		fclose ($smtpfp);
	}
	return $successFlag?TRUE:FALSE;
}
?>