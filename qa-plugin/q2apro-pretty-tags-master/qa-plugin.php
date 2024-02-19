<?php

/*
	Plugin Name: Pretty Tags
	Plugin URI: 
	Plugin Description: Provides a pretty autocomplete for tags on the ask page
	Plugin Version: 1.0
	Plugin Date: 2014-10-05
	Plugin Author: q2apro
	Plugin Author URI: 
	Plugin Minimum Question2Answer Version: 1.5
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

	// language file
	qa_register_plugin_phrases('q2apro-prettytags-lang-*.php', 'q2apro_prettytags_lang');

	// layer
	qa_register_plugin_layer('q2apro-prettytags-layer.php', 'Q2APRO Prettytags Layer');

	// admin
	qa_register_plugin_module('module', 'q2apro-prettytags-admin.php', 'q2apro_prettytags_admin', 'Q2APRO Prettytags Admin');
        

/*
	Omit PHP closing tag to help avoid accidental output
*/
