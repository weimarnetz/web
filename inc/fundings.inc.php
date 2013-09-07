<?php
        $wikinews=file_get_contents("http://wireless.subsignal.org/index.php?title=Vorlage:Spendenaufruf");
	$wikinews=substr($wikinews, strpos($wikinews, "<ul><li>" ), strpos($wikinews, "</li></ul>")-strpos($wikinews, "<ul><li>") + strlen("</li></ul>" ));
	echo str_replace("/index.php?title=","http://wireless.subsignal.org/index.php?title",str_replace("<a href=", "<a target=_blank href=",$wikinews) );
?>
