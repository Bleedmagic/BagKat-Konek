/**
 * Called in about_us.php, barangay_certificate.php, barangay_clearance.php, barangay_indigency.php, certification.php, contact_us.php, index.php
 */

let lastScrollY = window.scrollY;
const sidebar = document.querySelector('.nav-tab-container');

window.addEventListener('scroll', function () {
	const header = document.querySelector('header');
	if (window.scrollY > lastScrollY) {
		header.style.transform = 'translateY(-100%)';
	} else {
		header.style.transform = 'translateY(0)';
	}
	lastScrollY = window.scrollY;
});

var dropdown = document.querySelector('.hamburger');
var dropdownContent = document.getElementById('nav-tab-content');
var dropbtn = document.querySelector('.hamburger');


dropdownContent.style.display = 'none';


dropbtn.addEventListener('click', function (event) {
	console.log('paku');
	dropdownContent.style.display =
		dropdownContent.style.display === 'flex' ? 'none' : 'flex';
	event.stopPropagation(); 

	console.log(dropdownContent.style.display);
});

document.addEventListener('click', function (event) {
	if (!dropdown.contains(event.target)) {
		dropdownContent.style.display = 'none';
	}
});
