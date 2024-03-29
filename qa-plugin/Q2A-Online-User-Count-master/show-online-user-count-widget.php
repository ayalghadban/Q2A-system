<?php

class show_online_user_count_widget {
	
	function allow_template($template)
	{
		$allow=false;
		
		switch ($template)
		{
		case 'account':
		case 'activity':
		case 'admin':
		case 'ask':
		case 'categories':
		case 'custom':
		case 'favorites':
		case 'feedback':
		case 'hot':
		case 'ip':	
		case 'login':
		case 'message':
		case 'qa':
		case 'question':
		case 'questions':
		case 'register':
		case 'search':
		case 'tag':
		case 'tags':
		case 'unanswered':
		case 'updates':
		case 'user':
		case 'users':
				$allow=true;
				break;
		}
		
		return $allow;
	}
	
	function allow_region($region)
	{
		$allow=false;
		
		switch ($region)
		{
			
			case 'side':
				$allow=true;
				break;
			case 'main':
			case 'full':					
				break;
		}
		
		return $allow;
	}
	function inc_page_view_count()
	{
		if (qa_opt('TODAY_DATE')!=date("Y-m-d"))
		{
			qa_opt('YESTERDAY_VISITOR_COUNT',(int)qa_opt('TODAY_VISITOR_COUNT'));
			qa_opt('TODAY_VISITOR_COUNT','0');
			qa_opt('TODAY_DATE',date("Y-m-d"));
		}
		qa_opt('TODAY_VISITOR_COUNT',((int)qa_opt('TODAY_VISITOR_COUNT')+1));
		qa_opt('TOTAL_VISITOR_COUNT',((int)qa_opt('TOTAL_VISITOR_COUNT')+1));
	}
	
	function clean_offline_user()
	{
		$temp=(int)qa_opt('activity_time_out');
		$activity_time_out=(($temp>0)?$temp:5)*60;
		$timestamp=strtotime("now")-$activity_time_out;
		$query='DELETE FROM ^online_user WHERE last_activity<"'.date('Y-m-d H:i:s',$timestamp).'"';
		qa_db_query_sub($query);
	}
	
	function activity_update()
	{
		$this->inc_page_view_count();
		$logged_userid=qa_get_logged_in_userid();
		$time = time();
		$resultDb=qa_db_query_sub('SELECT id FROM ^online_user WHERE ip="'.$_SERVER['REMOTE_ADDR'].'"');
		$activity_id=qa_db_read_one_assoc($resultDb,true);
		if (isset($activity_id['id']))
		{			
			$query="UPDATE ^online_user SET user_id='".((isset($logged_userid))?$logged_userid:0)."',last_activity='".date('Y-m-d H:i:s')."' WHERE id='".$activity_id['id']."'";
		    
		}
		else
		{
			$query="INSERT INTO ^online_user (user_id,ip,last_activity) VALUES ('".((isset($logged_userid))?$logged_userid:0)."','".$_SERVER['REMOTE_ADDR']."','".date('Y-m-d H:i:s')."')";
			
		}
		
		 qa_db_query_sub($query);
		
	}
	function output_widget($region, $place, $themeobject, $template, $request, $qa_content)
	{
		global $relative_url_prefix;
		$this->clean_offline_user();
		$this->activity_update();
		$query='SELECT COUNT(*) FROM ^online_user WHERE user_id>"0"';
		$resultDb=qa_db_query_sub($query);
		$online_member_count=qa_db_read_one_assoc($resultDb,true);
		$query='SELECT COUNT(*) FROM ^online_user WHERE user_id="0"';
		$resultDb=qa_db_query_sub($query);
		$online_guest_count=qa_db_read_one_assoc($resultDb,true);
		$total_onilne_html='<span class="show-online-user-count-data">'.($online_member_count['COUNT(*)']+$online_guest_count['COUNT(*)']).'</span>';
		$online_quest_html='<span class="show-online-user-count-data">'.$online_guest_count['COUNT(*)'].'</span>';
		$online_member_html='<span class="show-online-user-count-data">'.$online_member_count['COUNT(*)'].'</span>';
		$tempStr=str_replace('^1',$online_member_html,qa_lang_html('show_online_user_count_lang/online_guest_member'));
		$tempStr=str_replace('^2',$online_quest_html,$tempStr);
		$themeobject->output('<link rel="stylesheet" type="text/css" href="https://www.qa.etmaam.com.sa/qa-plugin/Q2A-Online-User-Count-master/css/style.css">');
		$themeobject->output('<div class="show-online-user-count-total">');
		$themeobject->output(str_replace('^',$total_onilne_html,qa_lang_html('show_online_user_count_lang/total_online_users')));
		$themeobject->output('</div>');
		$themeobject->output('<div class="show-online-user-count-info">');
		$themeobject->output($tempStr);
		$themeobject->output('</div>');
		if (qa_opt('show_online_user_list')>0)
		{
			$query="SELECT ^users.handle FROM ^users,^online_user WHERE ^users.userid=^online_user.user_id AND ^online_user.user_id>0";
			$resultDb=qa_db_query_sub($query);
			if (mysqli_num_rows($resultDb)>0){
				$html='';
				while (list($user_name)=mysqli_fetch_row($resultDb))
				{
				  $html.=qa_get_one_user_html($user_name, true, $relative_url_prefix).'-';	
				}
				$html= substr( $html,0,-1);
				$themeobject->output('<div class="show-online-user-list">');
				$themeobject->output('<div class="show-online-user-list_title">',qa_lang_html('show_online_user_count_lang/online_user_list'),'</div>');
				$themeobject->output('<div class="show-online-user-list-users">',$html,'</div>');
				$themeobject->output('</div>');
			}
		}
		if(qa_opt('show_site_visitor_count')>0)
		{
		 $today_count='<span class="show-stats-list-data">'.((int)qa_opt('TODAY_VISITOR_COUNT')).'</span>';
		 $yesterday_count='<span class="show-stats-list-data">'.((int)qa_opt('YESTERDAY_VISITOR_COUNT')).'</span>';
		 $total_count='<span class="show-stats-list-data">'.((int)qa_opt('TOTAL_VISITOR_COUNT')).'</span>';
		 $themeobject->output('<div class="show-stats-list">');
		 $themeobject->output('<div class="show-stats-list-today">');
		 $themeobject->output(str_replace('^',$today_count,qa_lang_html('show_online_user_count_lang/today_count')));
		 $themeobject->output('</div>');
		 $themeobject->output('<div class="show-stats-list-yesterday">');
		 $themeobject->output(str_replace('^',$yesterday_count,qa_lang_html('show_online_user_count_lang/yesterday_count')));
		 $themeobject->output('</div>');	
		 $themeobject->output('<div class="show-stats-list-total">');
		 $themeobject->output(str_replace('^',$total_count,qa_lang_html('show_online_user_count_lang/total_count')));
		 $themeobject->output('</div>');
		 $themeobject->output('</div>');
	/*	if(!qa_is_logged_in())
		{
			$themeobject->output('<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>');
			$themeobject->output('<script>');
			$themeobject->output('(adsbygoogle = window.adsbygoogle || []).push({');
			$themeobject->output('google_ad_client: "ca-pub-6875555204127868",');
			$themeobject->output('enable_page_level_ads: true');
			$themeobject->output(' });');
			$themeobject->output('</script>');
		} 
	*/
		}
}
}

?>
