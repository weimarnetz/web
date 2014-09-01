<?php
/**
 * Created by PhpStorm.
 * User: andi
 * Date: 01.09.14
 * Time: 10:58
 */

$betterplaceProject = file_get_contents('https://api.betterplace.org/de/api_v4/projects/14895.json');
$bpPrjJson = json_decode($betterplaceProject, true);
$betterplaceNeeds = file_get_contents('https://api.betterplace.org/de/api_v4/projects/14895/needs.json');
$bpNeedsJson = json_decode($betterplaceNeeds, true);

$bpProgressPercentage = $bpPrjJson['progress_percentage'];
$bpOpenAmount = $bpPrjJson['open_amount_in_cents'];
$bpIncompleteNeedCount = $bpPrjJson['incomplete_need_count'];
$bpCompletedNeedCount = $bpPrjJson['completed_need_count'];
foreach($bpPrjJson['links'] as $links) {
    if ($links['rel'] == 'platform') {
        $bpPlatformLink = $links['href'];
    } elseif ($links['rel'] == 'new_donation' ) {
        $bpDonationLink = $links['href'];
    }
}

$bpNeeds = $bpNeedsJson['data'];

?>