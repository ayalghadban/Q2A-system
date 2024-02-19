/*
	Gold Developer (c) Hélio Chun
	https://heliochun.github.io/muffin

	File:           js/muffin-not-logged.js
	Version:        Muffin 2.0
	Description:    JavaScript helpers for Muffin theme
*/

document.addEventListener('DOMContentLoaded', function(e) {
	
var regLogCont = document.getElementById('reg-log-container');
// fill animation Login
var fillTrigger = document.getElementById('fill-action');
var loginCont = document.querySelector('.login-container');
var mdLoginIcon = document.getElementById('md-login');
var loginText = document.getElementById('log-in-action');

// fill animation Register
var regTrigger = document.getElementById('pop-reg');
var registCont = document.querySelector('.register-container');
var mdRegIcon = document.querySelector('#pop-reg i');

var rcs = document.getElementById('reg-color-swap');
var aRegTrigger = document.getElementById('md-reg-link');


function fillAnimation(){
	if (fillTrigger.getAttribute('class') == 'fill-animation'){
        fillTrigger.setAttribute('class', 'fill-animation-reverse');
		loginCont.classList.add('display-none');
		regLogCont.classList.add('display-none');
		document.body.classList.remove('no-scroll');
    } else {
        fillTrigger.setAttribute('class', 'fill-animation');
		setTimeout(function(){
			loginCont.classList.remove('display-none');
			regLogCont.classList.remove('display-none');
			document.body.classList.add('no-scroll');
		}, 1000);
    }
	mdLoginIcon.classList.toggle('hidden');
	loginText.classList.toggle('hidden');
	

	registCont.classList.add('display-none');
	regTrigger.removeAttribute("class");
	mdRegIcon.classList.remove('tilt-reg-button-icon');
}

fillTrigger.addEventListener('click', function(){
	fillAnimation();
});
loginText.addEventListener('click', function(){
	fillAnimation();
});

function openReg() {
	if (regTrigger.getAttribute('class') == 'reg-button-animation'){
        rcs.setAttribute('class', 'rcs-reverse');
		regTrigger.setAttribute('class', 'reg-button-animation-reverse');
		
		setTimeout(function(){
			registCont.classList.add('display-none');
			loginCont.classList.remove('display-none');
		}, 500);
    } else {
        rcs.setAttribute('class', 'rcs-on');
		regTrigger.setAttribute('class', 'reg-button-animation');
		
			registCont.classList.remove('display-none');
			loginCont.classList.add('display-none');
		
    }
	mdRegIcon.classList.toggle('tilt-reg-button-icon');
}

regTrigger.addEventListener('click', function(){
    openReg();
});

aRegTrigger.addEventListener('click', function(){
	openReg();
});

// Open Login Plugin
var molid = document.getElementById('muffin-open-login');
var openLogAol = document.querySelector('.open-login-button.aol'),
	openLogFb = document.querySelector('.open-login-button.facebook'),
	openLog4s = document.querySelector('.open-login-button.foursquare'),
	openLogGl = document.querySelector('.open-login-button.google'),
	openLogLi = document.querySelector('.open-login-button.linkedin'),
	openLogTw = document.querySelector('.open-login-button.twitter');

if (typeof(openLogAol) != 'undefined' && openLogAol != null){
	var fbLogin = '<a class="mdolog-a mdolog-facebook" href="'+ openLogAol.href +'" rel="nofollow"></a>'
    molid.insertAdjacentHTML('beforeend', fbLogin);
}
if (typeof(openLogFb) != 'undefined' && openLogFb != null){
	var fbLogin = '<a class="mdolog-a mdolog-facebook" href="'+ openLogFb.href +'" rel="nofollow"></a>'
    molid.insertAdjacentHTML('beforeend', fbLogin);
}
if (typeof(openLog4s) != 'undefined' && openLog4s != null){
	var fbLogin = '<a class="mdolog-a mdolog-facebook" href="'+ openLog4s.href +'" rel="nofollow"></a>'
    molid.insertAdjacentHTML('beforeend', fbLogin);
}
if (typeof(openLogGl) != 'undefined' && openLogGl != null){
	var fbLogin = '<a class="mdolog-a mdolog-facebook" href="'+ openLogGl.href +'" rel="nofollow"></a>'
    molid.insertAdjacentHTML('beforeend', fbLogin);
	console.log(fbLogin);
}
if (typeof(openLogLi) != 'undefined' && openLogLi != null){
	var fbLogin = '<a class="mdolog-a mdolog-facebook" href="'+ openLogLi.href +'" rel="nofollow"></a>'
    molid.insertAdjacentHTML('beforeend', fbLogin);
}
if (typeof(openLogTw) != 'undefined' && openLogTw != null){
	var fbLogin = '<a class="mdolog-a mdolog-facebook" href="'+ openLogTw.href +'" rel="nofollow"></a>'
    molid.insertAdjacentHTML('beforeend', fbLogin);
}

// Solo Original Facebok Login
var molid2 = document.querySelector('.login-button-wrapper'),
	openLogSoloFB = document.querySelector('.qa-nav-user-item.qa-nav-user-facebook-login');
	
if (typeof(openLogSoloFB) != 'undefined' && openLogSoloFB != null){
	var soloFbLogin = '<div id="muffin-open-login-2" class="muffin-open-login"><a class="mdolog-a mdolog-facebook"></a></div>'
    molid2.insertAdjacentHTML('beforeend', soloFbLogin);

	document.querySelector('.mdolog-facebook').addEventListener('click', function(){
		FB.login();
	});
}

});