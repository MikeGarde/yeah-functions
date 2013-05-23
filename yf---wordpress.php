<?php

function get_top_parent_category($cat_ID) {
	$cat = get_category( $cat_ID );
	$new_cat_id = $cat->category_parent;

	if($new_cat_id != "0") {
		return (get_top_parent_category($new_cat_id));
	}
	return $cat_ID;
}

if(!function_exists('get_category_meta')) {
function get_category_meta($id=null) {
	global $wpdb;

	if($id == null) {
		$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		if(!$term->term_id)
			return false;

		$id = $term->term_id;
	}

	if (!is_numeric($id)) {}

	$meta = $wpdb->get_results('SELECT `option_name`, `option_value` FROM `wp_options` WHERE `option_name` LIKE "'.$term->taxonomy.'_'.$term->term_id.'_%"');
	$cutlen = strlen($term->taxonomy.'_'.$term->term_id.'_');

	foreach($meta as $item) {
		$name = substr($item->option_name, $cutlen);
		$return[$name] = $item->option_value;
	}

	return $return;
}
}