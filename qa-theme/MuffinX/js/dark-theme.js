/*
	Gold Developer (c) Hélio Chun
	https://heliochun.github.io/muffin

	File:           js/muffin-logged.js
	Version:        Muffin 2.1
	Description:    JavaScript helpers for Muffin theme
*/

document.addEventListener('DOMContentLoaded', function(e) {
	
	var darktheme = document.getElementById('darktheme-wrapper');

	darktheme.addEventListener('click', function(){
		
		localStorage.setItem('mode', (localStorage.getItem('mode') || 'dark-theme') === 'dark-theme' ? 'light-theme' : 'dark-theme'); 
		localStorage.getItem('mode') === 'dark-theme' ? document.querySelector('body').classList.add('dark-theme') : document.querySelector('body').classList.remove('dark-theme');
		localStorage.getItem('mode') === 'light-theme' ? document.querySelector('body').classList.add('light-theme') : document.querySelector('body').classList.remove('light-theme');
		
		// button class handle
		localStorage.getItem('mode') === 'dark-theme' ? document.querySelector('#dt-button').classList.add('dtb-active') : document.querySelector('#dt-button').classList.remove('dtb-active');

	});

	// Check if Dark Mode is active
	((localStorage.getItem('mode') || 'dark-theme') === 'dark-theme') ? document.querySelector('body').classList.add('dark-theme') : document.querySelector('body').classList.remove('dark-theme');
	((localStorage.getItem('mode') || 'light-theme') === 'light-theme') ? document.querySelector('body').classList.add('light-theme') : document.querySelector('body').classList.remove('light-theme');
	
	// button class handle
	localStorage.getItem('mode') === 'dark-theme' ? document.querySelector('#dt-button').classList.add('dtb-active') : document.querySelector('#dt-button').classList.remove('dtb-active');
		
});

//Prevent DOM right click
var devMode = true;

if (devMode == false) {
	$(function() {
		$(this).bind("contextmenu", function(e) {
			e.preventDefault();
		});
	});
}