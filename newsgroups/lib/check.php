<?
if(($iconv_enable==true) &&
   (!function_exists("iconv")))
  die('There is no iconv-extension in PHP. set <tt>$iconv_enable=false</tt>
       in config.inc.php to disable automatic charset recoding.');
?>