<?
define("SMTP_SERVER_ADDR", "localhost"); //������ΪSMTP����
//define("SMTP_SERVER_ADDR", "127.0.0.1"); //������ΪSMTP����(���߽Կ���,������ʦ�Ƽ������Ǹ�)
//define("SMTP_SERVER_ADDR", "210.52.214.219");
define("SMTP_DOMAIN", "localhost");


global $sendFromMailAddr,$sendFromMailName; 
$sendFromMailAddr = "webmaster@allyes.com";
$sendFromMailName = "51shai ֪ͨ";


function replaceurl($str)//�滻MAIL�е�URL
{
	$pattern = "/(https|http):\/\/[\w-]+(\.[-\w]+)+((\/\w+([-\w]+)?)*((\/[-\w.]+\.(htm|phtml|html|php3|php|asp|xml|aspx|jsp|shtml)(\?[\w=&]+)?)|\/))?/i";
	return preg_replace($pattern, '<a href="\\0" target="_blank">\\0</a>', $str);
}

function title_gb2312_encode($subtxt)
{//��mail�ı������gb2312����, ʹ֮��ʾ����ʱ�и���ļ�����
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

//$mail�����˵�ַ�б�(����Ϊ����)
//$aryInfo�ż���������
/*
$aryInfo = array(
	"body" => "",//�ż�����
	"title" => "",//�ż�����
	"from" => ������email
	"fromName" => ����������	
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

	//���ŵ�ַ
	$mailflag = date("YmdHis");
	
	if (!is_array($mail))
	{
		$mail = array($mail);
	}
	$mail=array_unique($mail); //���ֲ��ظ�����

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