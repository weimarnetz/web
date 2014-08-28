<?php
/**
 * Created by PhpStorm.
 * User: andi
 * Date: 27.08.14
 * Time: 21:50
 */
$eventsToShow = 5;

require('ical/class.iCalReader.php');
$ical = new ical('http://ics.freifunk.net/tags/weimar.ics');
$eventCounter = 0;

?>
<ul>

    <?php

		foreach ($ical->events() as $event) {
				$output = "";
        if ($eventCounter >= $eventsToShow) {
            break;
        }
				$eventtime = new DateTime($event['DTSTART']);
				$eventtime->setTimezone(new DateTimeZone('Europe/Berlin'));
				$day = date_format($eventtime, 'd');
				$weekday = date_format($eventtime, 'D');
				$month = date_format($eventtime, 'M');
				$time = date_format($eventtime, 'H:i');
				$output = "<li>" . $weekday . ", " . $day . ". " . $month . "<br/>";
        $output .= $time . " Uhr: ";
				if ($event['URL']) {
						$output .= "<a href=\"". $event['URL'] ."\">" . $event['SUMMARY'] . "</a>";
				} else {
	          $output .= "" . $event['SUMMARY'];
				}
        $output .= ", Ort: " . $event['LOCATION'];
				$output .= "</li>";
				echo $output;
        $eventCounter++;
		}
    ?>
</ul>

