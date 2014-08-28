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
				?>
				<small><div class="row"><div class="col-sm-4">
					<div class="panel panel-primary panel-sm">
						<div class="panel-heading">
						<h3 class="panel-title"><?php echo $month; ?></h3>
				    </div>
						<div class="panel-body">
							<?php echo "<strong>" . $day . "</strong><br/>" . $weekday; ?>
					  </div>
				  </div>
				</div>
				<div class="col-sm-8"><div class="well">
				<?php

        $output = $time . " ";
				if ($event['URL']) {
						$output .= "<a href=\"". $event['URL'] ."\">" . $event['SUMMARY'] . "</a>";
				} else {
	          $output .= "" . $event['SUMMARY'];
				}
        $output .= "<br/>Ort: " . $event['LOCATION'];
				echo $output;
				$eventCounter++;
				?>
				</div></div></div></small>
				<?php
		}
    ?>

