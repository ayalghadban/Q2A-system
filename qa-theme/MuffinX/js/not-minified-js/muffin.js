/*
	Gold Developer (c) Hélio Chun
	https://heliochun.github.io/muffin

	File:           js/muffin.js
	Version:        Muffin 2.0
	Description:    JavaScript helpers for Muffin theme
*/

// Translation words
reputationWord = 'points';


document.addEventListener('DOMContentLoaded', function(e) {

var menuTrigger = document.getElementById('menu-trigger');
var menuWrapper = document.querySelector('.qa-nav-main');
var darkPane = document.getElementById('dark-pane');

var qaSearch = document.querySelector('.qa-search');
var triggerSearch = document.getElementById('mobile-search-button');

var mainWrapper = document.querySelector('.qa-main-wrapper');
var bdloop = document.querySelectorAll('.qa-main, .qa-sidepanel, .qa-footer-bottom-group');

// menu
menuTrigger.addEventListener('click', function(){
	menuWrapper.classList.toggle('menu-slide');
	darkPane.classList.toggle('hidden');
	if (window.innerWidth <= 1250){
		document.body.classList.toggle('no-scroll');
	} else if (window.innerWidth >= 1250){
		for (var i = 0; i < bdloop.length; i++) {
			bodyFooter = bdloop[i];
			bodyFooter.classList.toggle('right-transform');
		}
	}
});

// body shadow
darkPane.addEventListener('click', function(){
	menuWrapper.classList.remove('menu-slide');
	darkPane.classList.add('hidden');
	document.body.classList.remove('no-scroll');
	qaSearch.classList.remove('hidden');
});


// mobile search trigger
triggerSearch.addEventListener('click', function(){
	qaSearch.classList.toggle('hidden');
	darkPane.classList.remove('hidden');
	qaSearch.querySelector('input.qa-search-field').focus();
	document.body.classList.add('no-scroll');
});

// add body spacer if there's a subNavigation
function createProfileBanner() {
	var userName = mainWrapper.querySelector('h1').textContent.replace(/\s+/g, ' ');
	
	var userFavForm = mainWrapper.querySelector('.qa-main form').outerHTML;
		
	var checkUserFav = mainWrapper.querySelector('#favoriting');
	var checkLogged = document.getElementById('ui-trigger');
	
	var userImgSrc = mainWrapper.querySelector('.qa-avatar-image');
	var userSince = mainWrapper.querySelector('#duration').textContent.replace(/\s+/g, ' ');
	
	if (typeof(userImgSrc) != 'undefined' && userImgSrc != null){
		userImgSrc = mainWrapper.querySelector('.qa-avatar-image').src;
	} else {
		userImgSrc = '';
	}
	
	// add edit profile link
	var editLink = document.querySelector('.qa-nav-sub-account a.qa-nav-sub-link');
	
	if (typeof(editLink) != 'undefined' && editLink != null){
		var editLink = editLink.href;
	} else {
		var editLink = '';
	}
	
	// check logged
	if (typeof(checkLogged) != 'undefined' && checkLogged != null){
		var editButton = '<a id="cape-profile-edit" href="'+ editLink +'"><button class="qa-form-wide-button qa-form-wide-button-account paper-button">Edit my Profile</button></div>'
	} else {
		var editButton = '';
	}
	
	// Get User Points
	var goldBadges = document.getElementById('hmb-Gold');
	var silverBadges = document.getElementById('hmb-Silver');
	var bronzeBadges = document.getElementById('hmb-Bronze');
	var profileUserPoints = document.querySelector('#points .qa-uf-user-points').innerHTML;
	profileUserPoints = '<div class="profilePoints">'+profileUserPoints +' '+ reputationWord +'</span></div>'
	
	// Gold Badge
	if (typeof(goldBadges) != 'undefined' && goldBadges != null){
		goldBadges = goldBadges.innerHTML.replace(/'/g, "").replace(/\(|\)/g, "");
		goldBadges = '\
			<div class="pbadge-section" title="'+goldBadges+' Gold">\
				<span class="badge-pointer badge-gold-medal">●</span>\
				<span class="badge-pointer badge-gold-count"> '+goldBadges+'</span>\
			</div>';
	} else { 
		goldBadges = '';
	}
	
	// Silver Badge
	if (typeof(silverBadges) != 'undefined' && silverBadges != null){
		silverBadges = silverBadges.innerHTML.replace(/'/g, "").replace(/\(|\)/g, "");
		silverBadges = '\
			<div class="pbadge-section" title="'+silverBadges+' Silver">\
				<span class="badge-pointer badge-silver-medal">●</span>\
				<span class="badge-pointer badge-silver-count"> '+silverBadges+'</span>\
			</div>';
	} else {
		silverBadges = '';
	}
	
	// Bronze Badge
	if (typeof(bronzeBadges) != 'undefined' && bronzeBadges != null){
		bronzeBadges = bronzeBadges.innerHTML.replace(/'/g, "").replace(/\(|\)/g, "");
		bronzeBadges = '\
			<div class="pbadge-section" title="'+bronzeBadges+' Bronze">\
				<span class="badge-pointer badge-bronze-medal">●</span>\
				<span class="badge-pointer badge-bronze-count"> '+bronzeBadges+'</span>\
			</div>';
	} else {
		bronzeBadges = '';
	}
	
	// Profile Badges Bulk
	var profileBadges = '<div class="userBadges-wrapper">'+goldBadges + silverBadges + bronzeBadges+'</div>';
	
	// create user cape
	var capeBulk = document.createElement('div');
		if (typeof(checkUserFav) != 'undefined' && checkUserFav != null){
			// deletes usual Username and favorite because of "ID" conflicts
			mainWrapper.querySelector('.qa-main form').outerHTML = '';
			
			capeBulk.innerHTML = '\
			<div class="user-cape">\
				<div class="user-p-image">\
					<img src="'+ userImgSrc +'" width="150" height="150" class="qa-adaptive-image" data-adaptive-background>\
				</div>\
				<div class="user-p-text">\
					<div class="user-p-name-fav">\
						'+ userFavForm +'\
					</div>\
					<div class="user-p-since">'+ profileUserPoints + profileBadges +'</div>\
				</div>\
			</div>';
		} else {
			capeBulk.innerHTML = '\
			<div class="user-cape">\
				<div class="user-p-image">\
					<img src="'+ userImgSrc +'" width="150" height="150" class="qa-adaptive-image" data-adaptive-background>\
				</div>\
				<div class="user-p-text">\
					<div class="user-p-name-fav">\
						'+ userName +'\
					</div>\
					<div class="user-p-since">'+ profileUserPoints + profileBadges +'</div>\
					'+ editButton +'\
				</div>\
			</div>';
		}
		mainWrapper.querySelector('.qa-main').classList.add('viewing-profile');
		
		capeBulk.className = 'user-cape-container';
	
	mainWrapper.parentNode.insertBefore(capeBulk, mainWrapper);
	
	var textUserRepl = document.querySelector('.user-cape-container .user-p-name-fav');
	textUserRepl.innerHTML = textUserRepl.innerHTML.replace('User ','');
}

// Add top body spacer
if(mainWrapper.querySelector('.qa-nav-sub') != null) {
	mainWrapper.classList.add('top-spacer');
}
if (mainWrapper.querySelector('.qa-part-form-profile') != null) {
	createProfileBanner();
	mainWrapper.classList.add('profile-top-spacer');
}

// User Cape Hookup
var userCapeEl = document.querySelector('.user-cape-container');

if (typeof(userCapeEl) != 'undefined' && userCapeEl != null){
	menuTrigger.addEventListener('click', function(){
		userCapeEl.classList.toggle('right-transform');
	});
}

// Adds ripple to buttons
var qaRippleLoop = document.querySelectorAll('.qa-nav-main-item, .qa-nav-main-item-opp, .qa-form-tall-button, .qa-form-wide-button, .qa-tag-link');

for (var i = 0; i < qaRippleLoop.length; i++) {
	qaRipple = qaRippleLoop[i];
	qaRipple.classList.add('paper-button');
}

// is ckeditor active?
if (typeof(CKEDITOR) != 'undefined' && CKEDITOR != null){
	var qaTempQuestion = document.querySelector('.qa-template-question');
	
	
		// question text editor live preview
		var muffPrev = document.createElement('div');
			muffPrev.setAttribute('id', 'muffin-prev');
			
			var textAreaLoop = document.querySelectorAll('textarea.qa-form-tall-text');
			for (var i = 0; i < textAreaLoop.length; i++) {
				tali = textAreaLoop[i];
				tali.parentNode.appendChild(muffPrev);
				console.log('ready');
			}
			// Fix for Answer live preview
			if (typeof(qaTempQuestion) != 'undefined' && qaTempQuestion != null){
				// answer text editor live preview
				var muffPrev = document.createElement('div');
					muffPrev.setAttribute('id', 'muffin-prev');
					document.querySelector('#anew textarea.qa-form-tall-text').parentNode.appendChild(muffPrev);

				CKEDITOR.on("instanceCreated", function(event) {
					event.editor.on("change", function () {
						document.getElementById('muffin-prev').innerHTML = event.editor.getData();
					});
				});
			}

		CKEDITOR.on("instanceCreated", function(event) {
			event.editor.on("change", function () {
				document.getElementById('muffin-prev').innerHTML = event.editor.getData();
			});
		});
	
}

// Label input transform animation
var iqftLoop = document.querySelectorAll('input.qa-form-tall-text');
for (var i = 0; i < iqftLoop.length; i++) {
	iqft = iqftLoop[i];
	
	// start on targeted position
	if (iqft.value < 1) {
		iqft.parentNode.parentNode.previousElementSibling.classList.remove('input-focused');
		Object.assign(iqft.parentNode.parentNode.previousElementSibling.querySelector('.qa-form-tall-label').style,{transform:'translateY(90%)',color: '#9E9E9E',pointerEvents: 'none'});
	}
	
	// on action
	iqft.addEventListener('focus', function(){
    	this.parentNode.parentNode.previousElementSibling.classList.add('input-focused');
		Object.assign(this.parentNode.parentNode.previousElementSibling.querySelector('.qa-form-tall-label').style,{transform:'translateY(0)',color: 'inherit',pointerEvents: 'auto'});
    });
    iqft.addEventListener('blur', function(){
    	this.parentNode.parentNode.previousElementSibling.classList.remove('input-focused');
		if (this.value < 1) {
			Object.assign(this.parentNode.parentNode.previousElementSibling.querySelector('.qa-form-tall-label').style,{transform:'translateY(90%)',color: '#9E9E9E',pointerEvents: 'none'});
		}
    });
}

function activityCount() {
	$('.qa-activity-count-data').each(function () {
		var n = $(this).text();
		(n <= 20 ? z=99 : z=0);
		$(this).prop('Counter',z).animate({
			Counter: n.replace(/,/g, '')
		}, {
			duration: 1000,
			easing: 'swing',
			step: function (now) {
				$(this).text(Math.ceil(now));
			},
			complete: function(){
				$(this).text(n);
			} 
		});
	});
}
activityCount();


});



// jQuery
$(document).ready(function() {
	$('.qa-nav-main .qa-nav-main-list').find('.qa-nav-main-admin').prependTo('.qa-nav-main .qa-nav-main-list');
	$('.qa-nav-main .qa-nav-main-list').find('.qa-nav-main-ask').prependTo('.qa-nav-main .qa-nav-main-list');
});


