<?php
/**
 * Returns an easly readable time difference.
 *
 * @author  Mike Garde
 *
 * @param string  $start  Start time OR previously calculated difference
 * @param string  $end    End time OR leave blank if using previously calculated difference
 *
 * @return string Clean and readable difference in time
 *
 *
 * @example echo clean_time_diff(strtotime('-8 hours -31 minutes'));
 * @example echo clean_time_diff('2013-05-03 10:15:41');
 * @example echo clean_time_diff('2015-01-01 00:00:00', '2013-05-03 10:15:41');
 */
function clean_time_diff($start, $end=false){

	if(!is_int($start)) $start = strtotime($start);
	if(!is_int($end)) $end = strtotime($end);

	$diff   = (($end == false) ? time() : $end) - $start;
	$tense  = ($diff > 0) ? 'ago' : 'in the future';
	$diff   = abs($diff);
	$return = '';

	// Now
	if($diff == 0)
		return 'now';

	// Seconds
	if($diff < 60) {
		$return = $diff.' second'. (($diff==1) ? '' : 's');

	// Minutes
	} elseif($diff < 3600) {
		$minutes = round($diff / 60);
		$return = $minutes .' minute'. (($minutes==1) ? '' : 's');

	// < 4 Hours
	} elseif($diff < 14400) {
		$hours = floor($diff / 3600);
		$minutes = round((($diff / 3600) - $hours) * 60);
		$append = ($minutes > 0) ? ', '.$minutes.' minute'.(($hours==1) ? '' : 's') : '';
		$return = $hours.' hour'.(($hours==1) ? '' : 's').$append;

	// Hours
	} elseif($diff < 86400) {
		$hours = round($diff / 3600);
		$return = $hours .' hours';

	// < 4 Days
	} elseif($diff < 345600) {
		$days = floor($diff / 86400);
		$hours = round((($diff / 86400) - $days) * 24);
		$append = ($hours > 0) ? ', '.$hours.' hour'.(($hours==1) ? '' : 's') : '';
		$return = $days.' day'.(($days==1) ? '' : 's').$append;

	// Days
	} elseif($diff < 2592000) {
		$days = round($diff / 86400);
		$return = $days.' day'.(($days==1) ? '' : 's');

	// < 4 Months
	} elseif($diff < 10511769) {
		$months = floor($diff / 2627942);
		$days = round((($diff / 2627942) - $months) * 30.416);
		$append = ($days > 0) ? ', '.$days.' day'.(($days==1) ? '' : 's') : '';
		$return = $months.' month'.(($months==1) ? '' : 's').$append;

	// Months
	} elseif($diff < 31536000) {
		$months = round($diff / 2627942);
		$return = $months.' month'. (($months==1) ? '' : 's');

	// Years
	} else {
		$years = floor($diff / 31536000);
		$months = round((($diff / 31536000) - $years) * 12);
		$append = ($months > 0) ? ', '.$months.' month'.(($months==1) ? '' : 's') : '';
		$return = $years.' year'.(($years==1) ? '' : 's').$append;

	}
	return $return.' '.$tense;
}