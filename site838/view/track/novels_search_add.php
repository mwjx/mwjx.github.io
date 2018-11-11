<?php
//------------------------------
//create time:2008-5-27
//creater:zll,liang_0735@21cn.com,www.mwjx.com
//purpose:提取小说数据添加到数据库，搜索来源
//------------------------------
//必须要cd到这个目录下才执行下面的命令
//cd /usr/home/mwjx/fish838.com/site838/view/track/
///usr/local/php/bin/php /usr/home/mwjx/fish838.com/site838/view/track/novels_search_add.php
//var_dump(extension_loaded("zlib")); 
exit();
$_SERVER["PHP_SELF"] = "/site838/view/track/novels_search_add.php";

include("../../class/function.inc.php");
my_safe_include("config.inc.php");
my_safe_include("class_mysql.inc.php");
my_safe_include("mwjx/search_source.php");
my_safe_include("mwjx/rules.php");


$m_sou = 1; //来源标志
$dirroot = "../../../data/update_track/search/".$m_sou."/";
$obj = new c_search_source($m_sou);
$obj->run();
//-------tests------
//$obj = new c_search_source($m_sou,true);
//$path = $dirroot."00ea73179364858f1608955550083b07.html";
//$obj->deal_file($path);
exit();
//-------tests-------
//$path = $dirroot."f7a257f57c75ae78b5890df3b05d6cdc.gz";
//$path = $dirroot."f7a257f57c75ae78b5890df3b05d6cdc.html";
//$path = $dirroot."3a42689fe7403c35fc22c1d33cb35fc8.html";
//$path = "yyy.txt";
//$tmp = (readfromfile($path));
//$tmp = gzencode($tmp);

//writetofile("xxx.txt",$tmp);
//$tmp = (gzdecodev2($tmp));
//header("Content-Encoding: gzip");
//header("Vary: Accept-Encoding");
//header("Content-Length: ".strlen($tmp));
//echo $tmp;
//echo gzuncompress(gzencode($tmp,9));
//var_dump(function_exists("gzdecode"));
//readgzfile($path);
//var_dump(readgzfile($path));
//exit();

//-----end tests------

//-------------函数群-----------


function gzdecode($data,&$filename='',&$error='',$maxlength=null)
{
    $len = strlen($data);
    if ($len < 18 || strcmp(substr($data,0,2),"\x1f\x8b")) {
        $error = "Not in GZIP format.";
        return null;  // Not GZIP format (See RFC 1952)
    }
    $method = ord(substr($data,2,1));  // Compression method
    $flags  = ord(substr($data,3,1));  // Flags
    if ($flags & 31 != $flags) {
        $error = "Reserved bits not allowed.";
        return null;
    }
    // NOTE: $mtime may be negative (PHP integer limitations)
    $mtime = unpack("V", substr($data,4,4));
    $mtime = $mtime[1];
    $xfl   = substr($data,8,1);
    $os    = substr($data,8,1);
    $headerlen = 10;
    $extralen  = 0;
    $extra     = "";
    if ($flags & 4) {
        // 2-byte length prefixed EXTRA data in header
        if ($len - $headerlen - 2 < 8) {
            return false;  // invalid
        }
        $extralen = unpack("v",substr($data,8,2));
        $extralen = $extralen[1];
        if ($len - $headerlen - 2 - $extralen < 8) {
            return false;  // invalid
        }
        $extra = substr($data,10,$extralen);
        $headerlen += 2 + $extralen;
    }
    $filenamelen = 0;
    $filename = "";
    if ($flags & 8) {
        // C-style string
        if ($len - $headerlen - 1 < 8) {
            return false; // invalid
        }
        $filenamelen = strpos(substr($data,$headerlen),chr(0));
        if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
            return false; // invalid
        }
        $filename = substr($data,$headerlen,$filenamelen);
        $headerlen += $filenamelen + 1;
    }
    $commentlen = 0;
    $comment = "";
    if ($flags & 16) {
        // C-style string COMMENT data in header
        if ($len - $headerlen - 1 < 8) {
            return false;    // invalid
        }
        $commentlen = strpos(substr($data,$headerlen),chr(0));
        if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
            return false;    // Invalid header format
        }
        $comment = substr($data,$headerlen,$commentlen);
        $headerlen += $commentlen + 1;
    }
    $headercrc = "";
    if ($flags & 2) {
        // 2-bytes (lowest order) of CRC32 on header present
        if ($len - $headerlen - 2 < 8) {
            return false;    // invalid
        }
        $calccrc = crc32(substr($data,0,$headerlen)) & 0xffff;
        $headercrc = unpack("v", substr($data,$headerlen,2));
        $headercrc = $headercrc[1];
        if ($headercrc != $calccrc) {
            $error = "Header checksum failed.";
            return false;    // Bad header CRC
        }
        $headerlen += 2;
    }
    // GZIP FOOTER
    $datacrc = unpack("V",substr($data,-8,4));
    $datacrc = sprintf('%u',$datacrc[1] & 0xFFFFFFFF);
    $isize = unpack("V",substr($data,-4));
    $isize = $isize[1];
    // decompression:
    $bodylen = $len-$headerlen-8;
    if ($bodylen < 1) {
        // IMPLEMENTATION BUG!
        return null;
    }
    $body = substr($data,$headerlen,$bodylen);
    $data = "";
    if ($bodylen > 0) {
        switch ($method) {
        case 8:
            // Currently the only supported compression method:
            $data = gzinflate($body,$maxlength);
            break;
        default:
            $error = "Unknown compression method.";
            return false;
        }
    }  // zero-byte body content is allowed
    // Verifiy CRC32
    $crc   = sprintf("%u",crc32($data));
    $crcOK = $crc == $datacrc;
    $lenOK = $isize == strlen($data);
    if (!$lenOK || !$crcOK) {
        $error = ( $lenOK ? '' : 'Length check FAILED. ') . ( $crcOK ? '' : 'Checksum FAILED.');
        return false;
    }
    return $data;
}
function gzdecodev2($data) {
  $len = strlen($data);
  if ($len < 18 || strcmp(substr($data,0,2),"\x1f\x8b")) {
    return null;  // Not GZIP format (See RFC 1952)
  }
  $method = ord(substr($data,2,1));  // Compression method
  $flags  = ord(substr($data,3,1));  // Flags
  if ($flags & 31 != $flags) {
    // Reserved bits are set -- NOT ALLOWED by RFC 1952
    return null;
  }
  // NOTE: $mtime may be negative (PHP integer limitations)
  $mtime = unpack("V", substr($data,4,4));
  $mtime = $mtime[1];
  $xfl   = substr($data,8,1);
  $os    = substr($data,8,1);
  $headerlen = 10;
  $extralen  = 0;
  $extra     = "";
  if ($flags & 4) {
    // 2-byte length prefixed EXTRA data in header
    if ($len - $headerlen - 2 < 8) {
      return false;    // Invalid format
    }
    $extralen = unpack("v",substr($data,8,2));
    $extralen = $extralen[1];
    if ($len - $headerlen - 2 - $extralen < 8) {
      return false;    // Invalid format
    }
    $extra = substr($data,10,$extralen);
    $headerlen += 2 + $extralen;
  }

  $filenamelen = 0;
  $filename = "";
  if ($flags & 8) {
    // C-style string file NAME data in header
    if ($len - $headerlen - 1 < 8) {
      return false;    // Invalid format
    }
    $filenamelen = strpos(substr($data,8+$extralen),chr(0));
    if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
      return false;    // Invalid format
    }
    $filename = substr($data,$headerlen,$filenamelen);
    $headerlen += $filenamelen + 1;
  }

  $commentlen = 0;
  $comment = "";
  if ($flags & 16) {
    // C-style string COMMENT data in header
    if ($len - $headerlen - 1 < 8) {
      return false;    // Invalid format
    }
    $commentlen = strpos(substr($data,8+$extralen+$filenamelen),chr(0));
    if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
      return false;    // Invalid header format
    }
    $comment = substr($data,$headerlen,$commentlen);
    $headerlen += $commentlen + 1;
  }

  $headercrc = "";
  if ($flags & 2) {
    // 2-bytes (lowest order) of CRC32 on header present
    if ($len - $headerlen - 2 < 8) {
      return false;    // Invalid format
    }
    $calccrc = crc32(substr($data,0,$headerlen)) & 0xffff;
    $headercrc = unpack("v", substr($data,$headerlen,2));
    $headercrc = $headercrc[1];
    if ($headercrc != $calccrc) {
      return false;    // Bad header CRC
    }
    $headerlen += 2;
  }

  // GZIP FOOTER - These be negative due to PHP's limitations
  $datacrc = unpack("V",substr($data,-8,4));
  $datacrc = $datacrc[1];
  $isize = unpack("V",substr($data,-4));
  $isize = $isize[1];

  // Perform the decompression:
  $bodylen = $len-$headerlen-8;
  if ($bodylen < 1) {
    // This should never happen - IMPLEMENTATION BUG!
    return null;
  }
  $body = substr($data,$headerlen,$bodylen);
  $data = "";
  if ($bodylen > 0) {
    switch ($method) {
      case 8:
        // Currently the only supported compression method:
        $data = gzinflate($body);
        break;
      default:
        // Unknown compression method
        return false;
    }
  } else {
    // I'm not sure if zero-byte body content is allowed.
    // Allow it for now...  Do nothing...
  }

  // Verifiy decompressed size and CRC32:
  // NOTE: This may fail with large data sizes depending on how
  //       PHP's integer limitations affect strlen() since $isize
  //       may be negative for large sizes.
  if ($isize != strlen($data) || crc32($data) != $datacrc) {
    // Bad format!  Length or CRC doesn't match!
    return false;
  }
  return $data;
}


?>