<?php

$widget_options = array(
	'uw_title' => array(
		'label' => 'Widget Title:',
		'default-value' => '',
		'tags' => 'name="uw_title"',
	),
	'uw_text' => array(
		'label' => 'PHP Code(Field can contain raw text, HTML or PHP code):',
		'type' => 'textarea',
		'rows' => '8',
		'default-value' => qa_html('<?php echo "test is successfull!"; ?>'),
		'tags' => 'NAME="uw_text"',
	),
);
