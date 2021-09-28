const animationClass = 'animate';

window.addEventListener('load', function(){

	document.querySelectorAll('[data-anime]').forEach(function(element){
			element.classList.add(animationClass);
	});
});