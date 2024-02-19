/*
	Gold Developer (c) Hélio Chun
	https://heliochun.github.io/muffin

	File:           js/muffin-logged.js
	Version:        Muffin 2.0
	Description:    JavaScript helpers for Muffin theme
*/

document.addEventListener('DOMContentLoaded', function(e) {
	
var uiTrigger = document.getElementById('ui-trigger');
var toggleUI = document.querySelector('.qa-nav-user');
var getUserImg = document.querySelector('#ui-trigger .qa-avatar-image');
var userPad = document.querySelector('.header-navbar .qa-user-link');

if (typeof(getUserImg) != 'undefined' && getUserImg != null){
	getUserImgSrc = document.querySelector('#ui-trigger .qa-avatar-image').src;
	userImg = '<img src="'+ getUserImgSrc +'"/>';
} else {
	userImg = '';
}

uiTrigger.innerHTML = userImg;
userPad.innerHTML = '<div class="user-image">'+ userImg +'</div><span class="user-name">'+ userPad.innerText +'</span>';


window.addEventListener('click', function(e){   
	if (uiTrigger.contains(e.target)){
		toggleUI.classList.toggle('display-block');
	} else if (toggleUI.contains(e.target)){
		toggleUI.classList.add('display-block');
	} else{
		toggleUI.classList.remove('display-block');
	}
});

});