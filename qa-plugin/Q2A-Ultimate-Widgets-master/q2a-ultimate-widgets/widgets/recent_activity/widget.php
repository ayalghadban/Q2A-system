<?php

class recent_activity {
	public $allow_cache = true;
	
	function allow_template($template)
	{
		return true;
	}

	function allow_region($region)
	{
		return true;
	}
	
	function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
	{
		$widget_name = get_class($this) . '_' .strtoupper(substr($region,0,1).substr($place,0,1)) ;
		$count = (int)get_widget_option($widget_name, 'uw_count');
		$title = get_widget_option($widget_name, 'uw_title');
		$thumbnail = (bool)get_widget_option($widget_name, 'uw_thumbnail');
		$default_thumbnail = get_widget_option($widget_name, 'uw_default_thumbnail');


		$userid = qa_get_logged_in_userid();
		$categoryslugs = '';
		list($questions1, $questions2, $questions3, $questions4)=qa_db_select_with_pending(
			qa_db_qs_selectspec($userid, 'created', 0, $categoryslugs, null, false, false, $count),
			qa_db_recent_a_qs_selectspec($userid, 0, $categoryslugs),
			qa_db_recent_c_qs_selectspec($userid, 0, $categoryslugs),
			qa_db_recent_edit_qs_selectspec($userid, 0, $categoryslugs)
		);
		$questions = qa_any_sort_and_dedupe(array_merge($questions1, $questions2, $questions3, $questions4));

		echo '<aside class="uw-recent-activity-widget">';
		if($title)
			echo '<H2 class="uw-recent-activity-header">'. $title .'</H2>';

		echo '<ul class="uw-recent-activity-list">';
		
		$i=0;
		$thumb='';
		foreach ($questions as $question)
		{
			$i++;
			$questionid=$question['postid'];
			$questionlink = qa_path_html(qa_q_request($questionid, $question['title']),null, qa_opt('site_url'));
			$q_time= qa_when_to_html($question['created'], 7);
			$when=@$q_time['prefix'] . ' ' . @$q_time['data'] . ' ' . @$q_time['suffix'];
			if ($thumbnail){
				// get question content
				$result=qa_db_query_sub('SELECT content FROM ^posts WHERE postid=#', $questionid);
				$postinfo=qa_db_read_one_assoc($result, 'postid');
				// get thumbnail
				$doc = new DOMDocument();
				@$doc->loadHTML($postinfo['content']);
				$xpath = new DOMXPath($doc);
				$src = htmlspecialchars($xpath->evaluate("string(//img/@src)"));
				
				if ( empty($src) && !empty($default_thumbnail) )
					$src = $default_thumbnail;
				$thumb='';
				if ( !empty($src) )
					$thumb= '<img class="uw-recent-activity-thumbnail" width="60" height="50" src="' . $src . '">';
			}
			echo '<li class="uw-recent-activity-link-body">';
			echo '<a class="uw-recent-activity-link" href="' . $questionlink . '">';
			echo $thumb . '<span class="uw-recent-activity-title">'. htmlspecialchars($question['title']) . '</span>';
			echo '<span class="uw-recent-activity-time">' . $when . '</span></a></li>';
		}		
		echo '</ul></aside>';


	}
}
