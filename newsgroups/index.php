<?php header("Expires: ".gmdate("D, d M Y H:i:s",time()+7200)." GMT");

   include "config.inc.php";
   include "auth.inc";
   include "head.inc"; 
    ?>

<h1 class="np_index_headline"><?php echo htmlspecialchars($title); ?></h1>

<?php
include("$file_newsportal");
flush();
$newsgroups=groups_read($server,$port);
echo '<div class="np_index_groups">';
groups_show($newsgroups);
echo '</div>';
?>

<?php include "tail.inc"; ?>
