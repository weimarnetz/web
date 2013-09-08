<?
header("Expires: ".gmdate("D, d M Y H:i:s",time()+(3600*24))." GMT");
$group=$_REQUEST["group"];
$id=$_REQUEST["id"];
$attachment=$_REQUEST["attachment"];

include "config.inc.php";
include "auth.inc";
require("$file_newsportal");
if (!isset($attachment))
  $attachment=0;
$message=message_read($id,$attachment,$group);
//print_r($message->header);
if (!$message) {
  header ("HTTP/1.0 404 Not Found");
  echo "The Attachment doesn't exists";
} else {
  header("Content-Disposition: attachment; filename=".
        $message->header->content_type_name[$attachment]);
  header("Content-type: ".$message->header->content_type[$attachment]);
  message_show("",$id,$attachment,$message);
}
?>