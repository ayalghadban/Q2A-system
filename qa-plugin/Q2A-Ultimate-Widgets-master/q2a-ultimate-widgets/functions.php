<?php
function get_widget_options($widget_key){
	global $widget_options;
	$option_key = 'uw_option_'.$widget_key;
	if(! isset($widget_options[$option_key]))
		$widget_options[$option_key] = json_decode( qa_opt($option_key), true);
	return $widget_options[$option_key];
}
function get_widget_option($widget_key, $option){
	$options = get_widget_options($widget_key);
	return @$options[$option];
}
function get_widget_option_fields($widget_key, $option_key){
	// get $widget_options from file
	include UW_DIR.'/widgets/'.$widget_key.'/options.php'; // get local variable for options from widget module
	if( function_exists($widget_key) )
		$widget_options = $widget_key($widget_options, $option_key);
	return $widget_options;
}

function get_widget_option_form($widget_key, $option_key){
	$fields = get_widget_option_fields($widget_key, $option_key);
	$options = get_widget_options($option_key);
	// add a header to all plugin options to let admins know that it's a Plugin Specific section
	if( count($fields)>0 )
		$fields = array('__uw_options_header_css' => array(
					'label' => '<hr><h3>Widget Options <small>for Ultimate Widgets plugin</small></h3>',
					'type' => 'static',
				)) + $fields;
	// Show filtering option(Conditional Widgets)
		$filter_points = (bool)@$options['uw_filter_user_point_enable'] ? ' checked=""' : '';
		$point_type = @$options['uw_filter_user_point_type'];
		$points = (int)@$options['uw_filter_user_point_value'];
		$less_select = ($point_type=='less')? ' selected':'';
		$more_select = ($point_type=='more')? ' selected':'';
		$fields = array('uw_filter_user_points' => array(
					'label' => '',
					'html' => '
<label><input name="uw_filter_user_point_enable"' . $filter_points . ' value="1" class="qa-form-tall-checkbox" type="checkbox">Filter for points</label>
, And for users only show widgets to those with 
<select name="uw_filter_user_point_type" class="qa-form-tall-select"><option value="less"' . $less_select . '>less</option><option value="more"' . $more_select . '>more</option></select>
than
<input class="qa-form-tall-number" name="uw_filter_user_point_value" value="' . $points . '" type="text"> points.
					',
					'type' => 'custom',
					'tags' => 'NAME="uw_filter_user_points"',
				)) + $fields;
		$fields = array('uw_filter_user_special' => array(
					'label' => 'For Users, show widget to:',
					'options' => array('anybody'=>'Anybody', 'users'=>'Only Normal Users', 'special'=>'Only Special Users(Adminss, Moderators, Editors, Experts)'),
					'type' => 'select',
					'default-value' => 'anybody',
					'tags' => 'NAME="uw_filter_user_special"',
					'match_by' => 'key',
				)) + $fields;
		$fields = array('uw_filter_user' => array(
					'label' => 'Show widget to:',
					'options' => array('anybody'=>'Anybody', 'visitors'=>'Only Visitors', 'users'=>'Only Registered Users'),
					'type' => 'select',
					'default-value' => 'anybody',
					'tags' => 'NAME="uw_filter_user"',
					'match_by' => 'key',
				)) + $fields;
		$fields = array('uw_filter_device' => array(
					'label' => 'Show widget for:',
					'options' => array('all'=>'All devices', 'desktop'=>'Only Desktops', 'mobile'=>'Only Mobile Phones'),
					'type' => 'select',
					'default-value' => 'all',
					'tags' => 'NAME="uw_filter_device"',
					'match_by' => 'key',
				)) + $fields;
			// a header to attract attention to styling options
		$fields = array('__uw_filter_header' => array(
					'label' => '<hr><h3>Filtering Options</h3>',
					'type' => 'static',
				)) + $fields;

	// if widget can store cache, show cache options
		GLOBAL $qa_modules, $uw_widgets;
		if(@$qa_modules['widget'][$uw_widgets[$widget_key]]['object']->allow_cache){
			$fields = array('uw_cache_exp_type' => array(
						'label' => 'Refresh cache each:',
						'options' => array('second'=>'Second', 'minute'=>'Minute', 'hour'=>'Hour', 'day' => 'Day',),
						'type' => 'select',
						'default-value' => 'minute',
						'tags' => 'NAME="uw_cache_exp_type"',
						'match_by' => 'key',
					)) + $fields;
			$fields = array('uw_cache_exp_delay' => array(
						'label' => 'Refresh Time:',
						'type' => 'number',
						'default-value' => 10,
						'tags' => 'NAME="uw_cache_exp_delay"',
						'match_by' => 'key',
					)) + $fields;
			// a header to attract attention to styling options
			$fields = array('__uw_cache_header' => array(
						'label' => '<hr><h3>Cache Options</h3>',
						'type' => 'static',
					)) + $fields;
		}
	// if there are css files in this widget add them to options
	$styles_path = UW_DIR.'/widgets/'.$widget_key.'/styles/';
	if(file_exists($styles_path)){
		// Select list for choosing a css file
		$fields = array('uw_styles' => array(
					'label' => 'Active CSS Style for widget:',
					'options' => array('none' => 'No Styling'),
					'type' => 'select',
					'default-value' => 'none',
					'tags' => 'NAME="uw_styles"',
					'match_by' => 'key',
					'note' => 'this options are from CSS files in your widget\'s "styles" directory. you can add your own styling file to it and choose it from this options.',
				)) + $fields;
		// a header to attract attention to styling options
		$fields = array('__uw_styling_header' => array(
					'label' => '<hr><h3>Styling Options</h3>',
					'type' => 'static',
				)) + $fields;

		foreach(glob($styles_path .'*.css') as $file)
			$fields['uw_styles']['options'] += array(basename($file) => substr(basename($file), 0, -4)); // remove .css from file name
		$active_style = get_widget_option($option_key, 'uw_styles');
		//if( !$active_style or $active_style='' or $active_style=='none' )
		//	$fields['uw_styles']['options']['value'] = 'none';
	}

	// set default values
	foreach ($fields as $key => $field) {
		if( isset($options[$key]) )
			$fields[$key]['value'] = qa_html($options[$key]);
		else
			if( isset($fields[$key]['default-value']) )
				$fields[$key]['value'] = $fields[$key]['default-value'];
			else
				$fields[$key]['value'] = '';
	}

	return $fields;
}


function uw_get_base_url()
{
	/* First we need to get the protocol the website is using */
	$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';

	/* returns /myproject/index.php */
	if(QA_URL_FORMAT_NEAT == 0 || strpos($_SERVER['PHP_SELF'],'/index.php/') !== false):
		$path = strstr($_SERVER['PHP_SELF'], '/index', true);
		$directory = $path;
	else:
		$path = $_SERVER['PHP_SELF'];
		$path_parts = pathinfo($path);
		$directory = $path_parts['dirname'];
		$directory = ($directory == "/") ? "" : $directory;
	endif;       
		
		$directory = ($directory == "\\") ? "" : $directory;
		
	/* Returns localhost OR mysite.com */
	$host = $_SERVER['HTTP_HOST'];

	return $protocol . $host . $directory;
}
