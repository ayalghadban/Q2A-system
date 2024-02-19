<?php
/*
	Plugin Name: Q2APRO User Rules Overrides
*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}


	// override rules by extending them
	function qa_page_q_post_rules($post, $parentpost=null, $siblingposts=null, $childposts=null)
	{
		// default function call
		$rules = qa_page_q_post_rules_base($post, $parentpost, $siblingposts, $childposts);


		$userid = qa_get_logged_in_userid();
		$level = qa_get_logged_in_level();
		
		// do not show answer button if spam-limit exceeded (git-suggest)
		if(!qa_limits_remaining($userid, QA_LIMIT_ANSWERS)) 
		{
			$rules['answerbutton']=false;
		}
		
		// users are never allowed to hide posts
		$rules['hideable'] = false;
		
		// normal users are not allowed to edit posts after x min
		$timestamp = time();
		
		// edit time frame: 5 min (300s) for questions/comments + 20 min (1200s) for answers
		if($post['type']=='A') 
		{
			$rules['editable'] = $rules['editbutton'] = $rules['isbyuser'] && ($timestamp - $post['created'] < 1200);
		}
		else {
			$rules['editable'] = $rules['editbutton'] = $rules['isbyuser'] && ($timestamp - $post['created'] < 300);
		}

		// questions cannot be reopened, only admin
		$rules['reopenable'] = $rules['reopenable'] && $level>=QA_USER_LEVEL_ADMIN;
		
		// Moderator
		if ($level==QA_USER_LEVEL_EXPERT) 
		{
			// allowed to edit own answers and all questions
			// time frame: allow edit after 5 min and up to 7 days (604800 sec), can edit his own answer immediately
			$rules['editable'] = $rules['editbutton'] = 
				($rules['isbyuser'] || $post['type']=='Q') // can edit his own post and all questions in forum
					&& (!isset($post['closedbyid'])) // post is not closed, if closed it must be of user to let him edit or Redakteur-Level
						&& ($post['userid']!=1); // never allow question-posts of admin to be edited
		}
		
		// Redakteur (highest level)
		else if ($level==QA_USER_LEVEL_EDITOR) 
		{
			// can edit all posts in forum, but not admin posts
			$rules['editable'] = $rules['editbutton'] = ($post['userid']!=1);
			// can clear flags
			$rules['clearflaggable'] = ($post['flagcount']>=(@$post['userflag'] ? 2 : 1));
		}
		
		// && ( ($timestamp - $post['created'] > 300) || $rules['isbyuser'] ) // can edit question just after 5 min OR his own answer immediately
		// && ($timestamp - $post['created'] < 604800 || $level>=QA_USER_LEVEL_EDITOR) // do not allow edit of posts older than 7 days, Redakteur can

		// admin has all rights
		if ($level>=QA_USER_LEVEL_ADMIN) 
		{
			$rules['editable'] = $rules['editbutton'] = $rules['hideable'] = true;
		}
		
		// experts, moderators, admins can close questions
		$rules['closeable'] = ( $level>=QA_USER_LEVEL_EXPERT && !$rules['closed'] ); // && ($timestamp - $post['created'] < 1209600) ); // within 7 days

		// do not show retag button as it does the same as edit button
		$rules['retagcatbutton'] = false;
		

		return $rules;
	}


/*
	Omit PHP closing tag to help avoid accidental output
*/
