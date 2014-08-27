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
        if ($eventCounter >= $eventsToShow) {
            break;
        }
        echo "<li>" .
            date_format(new DateTime($event['DTSTART'], new DateTimeZone(('Europe/Berlin'))), 'd.m.Y H:i') .
            ": <a href=\"\">" . $event['SUMMARY'] . "</a>" .
            ", Ort: " . $event['LOCATION'] .
            "</li>";
        $eventCounter++;
    }
    ?>
</ul>

