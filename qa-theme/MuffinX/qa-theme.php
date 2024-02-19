<?php
/*
	Theme Name: Muffin X
	Theme Version: 2.0
	Theme Date: 04-09-2017
	Theme Version Update Date: 01-08-2018
	Theme Landing Page: https://heliochun.github.io/muffin
	
	Theme Author: Helio Chun
	Theme Author URI: https://twitter.com/TweetChun
	Theme Author Blog: https://www.tedcss.blogspot.com
*/

class qa_html_theme extends qa_html_theme_base
{
	// use new ranking layout
	protected $ranking_block_layout = true;

	// theme subdirectories
	private $js_dir = 'js';
	
	private $icon_url = 'qa.png';
	public function head_metas()
	{
		$this->output('<meta name="viewport" content="width=device-width, initial-scale=1"/>');
		parent::head_metas();
	}
	
	public function head_css()
	{
		$this->output_raw('<link href="//fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,500italic,700,700italic|Arimo:400|Material+Icons" media="all" rel="stylesheet"/>');
		
		$this->output('<link rel="stylesheet" href="'.$this->rooturl . $this->css_name().'&v=005"/>');

		// add RTL CSS file
		if ($this->isRTL) {
			$this->content['css_src'][] = $this->rooturl . 'css/qa-styles-rtl.css?' . QA_VERSION;
		}
		
		if (isset($this->content['css_src'])) {
			foreach ($this->content['css_src'] as $css_src)
				$this->output('<link rel="stylesheet" href="'.$css_src.'&v=005"/>');
		}
		
		if (!empty($this->content['notices'])) {
			$this->output(
				'<style>',
				'.qa-body-js-on .qa-notice {display:none;}',
				'</style>'
			);
		}
				
		if (!qa_is_logged_in()) {
			$this->output('<style>.qa-nav-user{display:none;}</style>');
		}
		
		$this->output('<link rel="stylesheet" href="'.$this->rooturl.'css/custom-styles.css"/>');
	}
	
	
	// Adding theme javascripts
	public function head_script()
	{
		$jsUrl = $this->rooturl . $this->js_dir;
		$this->content['script'][] = '<script src="' . $jsUrl . '/muffin.min.js?v=005"></script>';

		if (qa_is_logged_in()) {
			$this->content['script'][] = '<script src="' . $jsUrl . '/muffin-logged.min.js?v=005"></script>';
		} else {
			$this->content['script'][] = '<script src="' . $jsUrl . '/muffin-not-logged.min.js?v=005"></script>';
		}
		
		$this->content['script'][] = '<script src="' . $jsUrl . '/material-effects.min.js?v=005"></script>';

		parent::head_script();
	}
	
	// outputs login form if user not logged in
	public function nav_user_search()
	{
		$this->output('<div class="left-hand-bar table-cell"><div class="left-hb-wrapper">');
		$this->output('<div id="menu-trigger" class="paper-button paper-button--fab"><i class="material-icons">menu</i></div>');
		$this->output('<div class="qa-header">');

		$this->logo();
		$this->header_clear();
		$this->header_custom();

		$this->output('</div>'); // END qa-header
		$this->output('</div>'); // END left-hb-wrapper
		
		// where login form used to be
		qa_html_theme_base::nav_user_search();
		$this->output('</div>'); // left-hand-bar
	}

	public function logged_in()
	{
		qa_html_theme_base::logged_in();

		if (qa_is_logged_in()) {
			$userpoints = qa_get_logged_in_points();
			$pointshtml = $userpoints == 1
				? qa_lang_html_sub('main/1_point', '1', '1')
				: qa_html(number_format($userpoints))
			;
			$this->output('<div class="qam-logged-in-points">' . $pointshtml .' '.qa_lang_html('admin/points').'</div>');
			$this->output('
			<ul class="qa-nav-user-list">
				<li class="qa-nav-user-item qa-nav-user-profile">
					<a href="'.qa_path('user/').'" class="qa-nav-user-link">'.qa_lang_html('profile/my_account_title').'</a>
				</li>
				<li class="qa-nav-user-item qa-nav-user-account">
					<a href="'.qa_path('account').'" class="qa-nav-user-link">'.qa_lang_html('users/edit_profile').'</a>
				</li>
				<li class="qa-nav-user-item qa-nav-user-messages">
					<a href="'.qa_path('messages').'" class="qa-nav-user-link">'.qa_lang_html('misc/nav_user_pms').'</a>
				</li>
			</ul>
			');
			
		}
	}

	// adds login bar, user navigation and search at top of page in place of custom header content
	public function body_header()
	{
		$this->output('<div class="header-navbar">');
		$this->nav_user_search();
		$this->output('<div class="qam-login-bar table-cell">');
		
		$this->output('<div id="mobile-search-button"><i class="material-icons">search</i></div>');
		
		if (qa_is_logged_in()){ // output user avatar to login bar
			
			$userpoints = qa_get_logged_in_points();
			$pointshtml = $userpoints == 1
				? qa_lang_html_sub('main/1_point', '1', '1')
				: qa_html(number_format($userpoints))
			;
			$this->output('<div class="show-my-points">' . $pointshtml . ' نقطة</div>');
			
			$this->output('<div id="ui-trigger" class="no-select">');
			$this->output(
				'<div class="qa-logged-in-avatar">',
				QA_FINAL_EXTERNAL_USERS
				? qa_get_external_avatar_html(qa_get_logged_in_userid(), 70, true)
				: qa_get_user_avatar_html(qa_get_logged_in_flags(), qa_get_logged_in_email(), qa_get_logged_in_handle(),
					qa_get_logged_in_user_field('avatarblobid'), qa_get_logged_in_user_field('avatarwidth'), qa_get_logged_in_user_field('avatarheight'),
					70, true),
				'</div>'
			);
			$this->output('</div>');
			
		} elseif (QA_FINAL_EXTERNAL_USERS) {
			
			$this->output('<div class="altLogReg">');
			$this->output('<a href="'.qa_path('login').'">'.qa_lang_html('users/login_button').'</a> /');
			$this->output('<a href="'.qa_path('register').'">'.qa_lang_html('users/register_button').'</a>');
			$this->output('</div>');
			
		} else {
			
			$this->output('<span id="log-in-action">'.qa_lang_html('users/login_button').'</span><div class="virtual-login-spacer"><div id="fill-action" class="no-select"><i id="md-login" class="material-icons">account_circle</i></div></div>');
			$this->output('<div id="reg-log-container" class="display-none">
			<div id="muffin-open-login" class="muffin-open-login"></div>
			<div id="reg-log">');
			
			if (isset($this->content['navigation']['user']['login']) && !QA_FINAL_EXTERNAL_USERS) {
				$login = $this->content['navigation']['user']['login'];
				$this->output(
					'<div class="login-container display-none">
						<div class="login-wrapper">
							<h2>'.qa_lang_html('users/login_button').'</h2>
							<form action="' . $login['url'] . '" method="post">
								<div class="group">      
									<input class="login-input" type="text" name="emailhandle" required>
									<span class="input-highlight"></span>
									<span class="input-bar"></span>
									<label>' . trim(qa_lang_html(qa_opt('allow_login_email_only') ? 'users/email_label' : 'users/email_handle_label'), ':') . '</label>
								</div>

								<div class="group">      
									<input type="password" name="password" required>
									<span class="input-highlight"></span>
									<span class="input-bar"></span>
									<label>' . trim(qa_lang_html('users/password_label'), ':') . '</label>
								</div>
								<label for="qam-rememberme" class="label--checkbox">
									<input type="checkbox" id="qam-rememberme" value="1" class="checkbox" checked>
									' . qa_lang_html('users/remember') . '
								</label>
								<input type="hidden" name="code" value="' . qa_html(qa_get_form_security_code('login')) . '"/>
								<div class="login-button-wrapper">
									<button type="submit" value="' . $login['label'] . '" class="no-select paper-button qa-form-tall-button qa-form-tall-button-login" name="dologin">'.qa_lang_html('users/login_button').'</button>
								</div>
							</form>
							
							<div id="login-extra">');
								if (!qa_opt('suspend_register_users')) {
									$this->output('<div id="md-reg-link" class="extralog-item float-left">'.qa_lang_html('users/register_button').'</div>');
								}
								$this->output('<a class="extralog-item float-right" href="'.qa_path('forgot').'">'.qa_lang_html('users/forgot_link').'</a>
								<div class="clear-float"></div>
							</div>
						</div>
					</div>'
				);
				// remove regular navigation link to log in page
				unset($this->content['navigation']['user']['login']);
			}
			if (isset($this->content['navigation']['user']['register']) && !QA_FINAL_EXTERNAL_USERS) {
				$register = $this->content['navigation']['user']['register'];
				$this->output(
					'<div class="register-container display-none">
						<div class="login-wrapper">
							<h2>'.qa_lang_html('users/register_button').'</h2>
							<form action="' . $register['url'] . '" method="post">
								<div class="group">      
									<input class="login-input" type="text" name="handle" required>
									<span class="input-highlight"></span>
									<span class="input-bar"></span>
									<label>اسم المستخدم/العضو</label>
								</div>

								<div class="group">      
									<input class="login-input" type="text" name="email" required>
									<span class="input-highlight"></span>
									<span class="input-bar"></span>
									<label>البريد الإلكتروني</label>
								</div>

								<div class="group">      
									<input type="password" name="password" required>
									<span class="input-highlight"></span>
									<span class="input-bar"></span>
									<label>كلمة السر</label>
								</div>
								<input type="hidden" name="doregister" value="1">
								<input type="hidden" name="code" value="' . qa_html(qa_get_form_security_code('register')) . '"/>
								<button type="submit" value="' . $register['label'] . '" class="no-select paper-button qa-form-tall-button qa-form-tall-button-login" name="dologin">'.qa_lang_html('users/register_button').'</button>
							</form>
							<div id="reg-color-swap"></div>
						</div>
					</div>'
				);
				// remove regular navigation link to Register page
				unset($this->content['navigation']['user']['register']);
			}
			if (!qa_opt('suspend_register_users')) {
				$this->output('<div id="pop-reg"><i class="no-select material-icons">add</i></div>');
			}
			$this->output('</div>'); // qam-login-group
			
		}
		$this->output('</div>');
		$this->output('</div>'); // qam-login-bar
		parent::body_header();
		$this->output('</div>'); // header-navbar
		
	}

	// allows modification of custom element shown inside header after logo
	public function header_custom()
	{
		if (isset($this->content['body_header'])) {
			$this->output('<div class="header-banner">');
			$this->output_raw($this->content['body_header']);
			$this->output('</div>');
		}
	}

	// removes user navigation and search from header and replaces with custom header content. Also opens new <div>s
	public function header()
	{

		$this->output('<div class="qa-main-wrapper">', '');
		$this->nav_main_sub();

	}
	
	// Question List short description
	public function q_list($q_list)
	{
		if (!empty($q_list['qs']) ) { // first check it is not an empty list and the feature is turned on

			// Collect the question ids of all items in the question list (so we can do this in one DB query)

			$postids = array();
			foreach ($q_list['qs'] as $question) {
				if (isset($question['raw']['postid']))
					$postids[] = $question['raw']['postid'];
			}

			if (!empty($postids)) {

				// Retrieve the content for these questions from the database

				$maxlength = '400';
				$result = qa_db_query_sub('SELECT postid, content, format FROM ^posts WHERE postid IN (#)', $postids);
				$postinfo = qa_db_read_all_assoc($result, 'postid');

				// Get the regular expression fragment to use for blocked words and the maximum length of content to show

				$blockwordspreg = qa_get_block_words_preg();

				// Now add the popup to the title for each question

				foreach ($q_list['qs'] as $index => $question) {
					if (isset($postinfo[$question['raw']['postid']])) {
						$thispost = $postinfo[$question['raw']['postid']];
						$text = qa_viewer_text($thispost['content'], $thispost['format'], array('blockwordspreg' => $blockwordspreg));
						$text = preg_replace('/\s+/', ' ', $text);  // Remove duplicated blanks, new line characters, tabs, etc
						$text = qa_shorten_string_line($text, $maxlength);
						$title = isset($question['title']) ? $question['title'] : '';
						
						if (!empty($text)) {
							$q_list['qs'][$index]['content']='<span class="qa-description">'.qa_html($text).'</span>';
						}
					}
				}
			}
		}

		parent::q_list($q_list); // call back through to the default function
	}

	// View counter to 1K 2M
	private $suffixes = array('', 'K', 'M');
 
	private function formatViews($size, $precision = 1) {
		$base = log($size) / log(1000);
		return round(pow(1000, $base - floor($base)), $precision) . $this->suffixes[floor($base)];
	}
	 
	private function updateViewCount(&$questionItem) {
		if (isset($questionItem['views_raw'], $questionItem['views']['data'])) {
			$questionItem['views']['data'] = $this->formatViews($questionItem['views_raw']);
		}
	}
	 
	public function q_list_item($q_item) {
		$this->updateViewCount($q_item);
		qa_html_theme_base::q_list_item($q_item);
	}

		/**
	 * Add close icon
	 *
	 * @since Snow 1.4
	 * @param array $q_item
	 */ 
	public function q_item_title($q_item)
	{
		$closedText = qa_lang('main/closed');
		$imgHtml = empty($q_item['closed'])
			? ''
			: '<img src="'  . $this->icon_url . '/qa.png" class="qam-q-list-close-icon" height="40" width="50" alt="'  . $closedText . '" title=" مغلق' . '"/>';

		$this->output(
			'<div class="qa-q-item-title">',
			// add closed note in title
			$imgHtml,
			'<a href="' . $q_item['url'] . '">' . $q_item['title'] . '</a>',
			'</div>'
		);
	}

	// Replace "input" icons for "buttons"
	public function notice($notice) {
		$this->output('<div class="qa-notice" id="'.$notice['id'].'">');
		if (isset($notice['form_tags']))
			$this->output('<form '.$notice['form_tags'].'>');
		$this->output_raw($notice['content']);
		$this->output('<button '.$notice['close_tags'].' type="submit" value="X" class="qa-notice-close-button"></button>');
		if (isset($notice['form_tags'])) {
			$this->form_hidden_elements(@$notice['form_hidden']);
			$this->output('</form>');
		}
		$this->output('</div>');
	}
	public function search_button($search){
		$this->output('<button type="submit" value="'.$search['button_label'].'" class="qa-search-button"></button>');
	}
	public function favorite_button($tags, $class){
		if (isset($tags))
			$this->output('<button '.$tags.' type="submit" value="" class="'.$class.'-button paper-button paper-button--fab"></button> ');
	}
	public function form_button_data($button, $key, $style){
		$baseclass = 'qa-form-'.$style.'-button qa-form-'.$style.'-button-'.$key;
		$this->output('<button'.rtrim(' '.@$button['tags']).' value="'.@$button['label'].'" title="'.@$button['popup'].'" type="submit"'.
			(isset($style) ? (' class="'.$baseclass.'"') : '').'>'.@$button['label'].'</button>');
	}
	public function post_hover_button($post, $element, $value, $class){
		if (isset($post[$element]))
			$this->output('<button '.$post[$element].' type="submit" value="'.$value.'" class="'.$class.'-button paper-button paper-button--fab"></button>');
	}
	public function post_disabled_button($post, $element, $value, $class){
		if (isset($post[$element]))
			$this->output('<button '.$post[$element].' type="submit" value="'.$value.'" class="'.$class.'-disabled paper-button paper-button--fab" disabled="disabled"></button>');
	}
	// End of Replace "input" icons for "buttons"
	
	function vote_count($post) 
    { 
        $post['netvotes_view']['data'] = str_replace( '+', '', $post['netvotes_view']['data'] ); 
        parent::vote_count($post); 
    }
	
	// removes sidebar for user profile pages
	public function sidepanel()
	{
		if ($this->template!='user')
		{
		    
		    		$this->output(
			'<div class="qa-theme-attribution">',
			'  <a href="https://etmaam.com.sa" target="_blank">المنصة قيد البث التجريبي</a>',
			'</div>'

		);
			

		}
			qa_html_theme_base::sidepanel();
	}

	// prevent display of regular footer content (see body_suffix()) and replace with closing new <div>s
	public function footer()
	{
		$this->output('</div> <!-- END main-wrapper -->');
	}
	
	// add RSS feed icon after the page title
	public function title()
	{
		qa_html_theme_base::title();

		$feed=@$this->content['feed'];

		if (!empty($feed))
			$this->output('<a href="'.$feed['url'].'" title="'.@$feed['label'].'"><img src="'.$this->rooturl.'images/rss.jpg" alt="" width="16" height="16" border="0" class="qa-rss-icon"/></a>');
	}

	// add view count to question list
	function q_view($q_view)
{
qa_html_theme_base::q_view($q_view);

// اضافة المشاهدات في صفحة الاسئلة اسفل صندوق الميتا

if ($this->template=='question') {

    $this->output_split(@$q_view['views'], 'qa-view-count2');

}

    /* 

$this->output('<div class="qa-a-selected-text-2">السؤال</div>');
*/
// here you can use html tags or simpel string
}

	public function q_item_stats($q_item)
	{
		$this->output('<div class="qa-q-item-stats">');

		$this->voting($q_item);
		$this->a_count($q_item);
		qa_html_theme_base::view_count($q_item);

		$this->output('</div>');
	}

	// prevent display of view count in the usual place
	public function view_count($q_item)
	{
		if ($this->template=='question')
			qa_html_theme_base::view_count($q_item);
	}
	
	// who posted fixes and brackes removal
	public function post_meta_who($post, $class)
	{
		if (isset($post['who'])) {
			$this->output('<span class="'.$class.'-who">');

			if (isset($post['who']['data']))
				$this->output('<span class="'.$class.'-who-data qa-who-main">'.$post['who']['data'].'</span>');

			if (isset($post['who']['title']))
				$this->output('<span class="'.$class.'-who-title">'.$post['who']['title'].'</span>');

			// You can also use $post['level'] to get the author's privilege level (as a string)

			if (isset($post['who']['points'])) {
				$post['who']['points']['prefix'] = ''.$post['who']['points']['prefix'];
				$post['who']['points']['suffix'] .= '';
				$this->output_split($post['who']['points'], $class.'-who-points');
			}

			if (strlen(@$post['who']['suffix']))
				$this->output('<span class="'.$class.'-who-pad">'.$post['who']['suffix'].'</span>');

			$this->output('</span>');
		}
	}

	// to replace standard Q2A footer
	public function body_suffix()
	{
		$this->output('<div class="qa-footer-bottom-group">');
		qa_html_theme_base::footer();
		$this->output('</div> <!-- END footer-bottom-group -->', '');
		$this->output('<div id="dark-pane" class="no-select hidden"></div>');
	}

	public function attribution()
	{
		$this->output(
			'<div class="qa-theme-attribution">',
			'  <!! here we add text !!>  <a href="https://etmaam.com.sa" target="_blank">  </a>',
			'<a href="https://etmaam.com.sa/"><img src="https://etmaam.com.sa/assets/front/img/619d47f38d315.png" alt="logodown" height="35" width="110"></a>',
			'</div>'
		);
		$this->output('<script>
		// qa notification plugin
		var osnboxMD = document.getElementById("osnbox");
		var msb = document.getElementById("mobile-search-button");

		if (typeof(osnboxMD) != "undefined" && osnboxMD != null){
			msb.parentNode.insertBefore(osnboxMD, msb);
		}
		</script>');

		
		parent::attribution();
	}
}

/* اخفاء قفل السؤال واخفاءه من الاعضاء */
function q_view_buttons($q_view) {
  if (!empty($q_view['form'])) {
    if(qa_get_logged_in_userid() == $q_view['raw']['userid']) {
      /*
      define('QA_USER_LEVEL_BASIC', 0);
      define('QA_USER_LEVEL_APPROVED', 10);
      define('QA_USER_LEVEL_EXPERT', 20);
      define('QA_USER_LEVEL_EDITOR', 50);
      define('QA_USER_LEVEL_MODERATOR', 80);
      define('QA_USER_LEVEL_ADMIN', 100);
      define('QA_USER_LEVEL_SUPER', 120);
      */
      if(qa_get_logged_in_level() < QA_USER_LEVEL_EXPERT) {
        if(isset($q_view['form']['buttons']['close']))
          unset($q_view['form']['buttons']['close']);
        if(isset($q_view['form']['buttons']['hide']))
          unset($q_view['form']['buttons']['hide']);
      }
    }
  }
  qa_html_theme_base::q_view_buttons($q_view);
}