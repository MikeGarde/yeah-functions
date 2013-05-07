<?php
/*
Plugin Name: Yeah, Functions!
Plugin URI: https://github.com/MikeGarde/yeah-functions
Description: A group of functions I regularly use when working with wordpress
Version: 0.1
Author: Mike Garde
Author URI: https://github.com/MikeGarde
License: undecided
*/

class yeah_functions {
	function __construct() {
		add_action('admin_menu', array(&$this, 'admin_menu'));
		require_once('yf---debug.php');
		require_once('yf---time.php');
		require_once('yf---wordpress.php');
	}
	function admin_menu() {
		add_options_page('Documentation',
						'Yeah Functions',
						'manage_options',
						'yeah_functions',
						array($this, 'docs_page'));
	}
	function docs_page() {
		require_once('view/settings.php');
	}
}
new yeah_functions;