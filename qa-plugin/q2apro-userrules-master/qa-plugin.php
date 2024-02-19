<?php

/*
	Plugin Name: Q2APRO User Rules Overrides
	Plugin URI: 
	Plugin Description: Set custom rules for editing
	Plugin Version: 0.1
	Plugin Date: 2015-07-16
	Plugin Author: q2apro
	Plugin Author URI: 
	Plugin Minimum Question2Answer Version: 1.6
	Plugin Update Check URI:
	
	Plugin License: GPLv3

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.gnu.org/licenses/gpl.html	
*/


	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}


	// core function overrides 
	qa_register_plugin_overrides('q2apro-userrules-overrides.php');

/*
	Omit PHP closing tag to help avoid accidental output
*/
