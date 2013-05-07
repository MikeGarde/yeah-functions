<?php
/**
 * Like print_r() but so much better! Removes HTML formatting from an array while using Google Prittify.
 *
 * @author  Mike Garde
 *
 * @param array    $array   Array you want to see.
 * @param boolean  $die     Should this kill the process when done?
 * @param boolean  $return  Do you want this echoed or returned
 *
 * @return string  $string  A view of an array but formatted for easy reading via HTML.
 */
function print_a($array=false, $die=true, $return=false) {

	if(!$return)
		$return = 0;

	if(!$array && !$return)
		$array = $GLOBALS;

	if(!$return) {
		$in = '';
		$dent = '    ';
	} elseif($return) {
		$in = str_repeat(' ', ($return*4));
		$dent = str_repeat(' ', ($return*4)+4);
	}
	$indent = $in.$dent;
	unset($dent);

	$result = ($return) ? ' ' : $in;
	$result.= ((is_array($array)) ? 'Array' : 'stdClass Object')." (\n";
	foreach($array as $key => $value) {

		$result.= $indent.'['. $key .'] => ';

		if(is_array($value) || is_object($value))
			$result.= print_a($value, false, $return+1);
		elseif(strlen($value) == 0)
			$result.= 'null';
		elseif(preg_match("/^[0-9]+$/", $value))
			$result.= $value;
		elseif(preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/", $value))
			$result.= '<span title="'.date("D, M j, Y, g:i a", strtotime($value)).' | '.clean_time_diff($value).'">'.$value.'</span>';
		else {
			$value = addcslashes(htmlspecialchars($value), '\'');

			if(strlen($value) > 240) {
				$value = str_replace(array("\n", "\r"), array('<br />', ''), $value);
				$result.= '<details><summary>\''.substr($value, 0, 80).'\'</summary>\''.$value.'\'</details>';
			} else {
				$result.= '\''.$value.'\'';
			}
		}
		$result.= "\n";
	}
	$result.= $in.')';
	$result = str_replace(array('    ', "\t"), '&nbsp;&nbsp;&nbsp;&nbsp;', $result);

	if(!$return) {
		$string = '<script src="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.js"></script>'.
				  '<script src="//google-code-prettify.googlecode.com/svn/trunk/src/lang-css.js"></script>'.
				  '<link rel="stylesheet" type="text/css" href="//google-code-prettify.googlecode.com/svn/trunk/src/prettify.css">'.
				  '<link href="//fonts.googleapis.com/css?family=Ubuntu+Mono" rel="stylesheet" type="text/css">'.
				  '<style>'.
				  'pre { background-color: #fff; font-family: \'Ubuntu Mono\', sans-serif; }'.
				  'li.L0, li.L1, li.L2, li.L3, li.L5, li.L6, li.L7, li.L8 { list-style-type: decimal; }'.
				  'ol { padding: 0 0 0 45px; }'.
				  'details, details summary { display: inline-block; }'.
				  'details[open] summary span { display: none; }'.
				  '</style>'.
				  '<pre class="prettyprint linenums">'. $result .'</pre>'.
				  '<script>prettyPrint();</script>';
		echo $string;

		if ($die) die();

	} else {
		return $result;
	}

}


/**
 * Called by preg_replace_callback
 *
 * @param array  $matches
 */
function addslashes_2_regex($matches){
	echo '<pre>';
	print_r($matches);
	echo '</pre>';
	//return ' => \''.$matches[1]."'\n";
	return ' =&gt; \''.addslashes($matches[1])."'\n".$matches[2];
}

