<?php

function get_top_parent_category($cat_ID) {
	$cat = get_category( $cat_ID );
	$new_cat_id = $cat->category_parent;

	if($new_cat_id != "0") {
		return (get_top_parent_category($new_cat_id));
	}
	return $cat_ID;
}