jQuery(document).ready(function($) {
 
	$(window).load(function() {
		if (window.innerWidth > 320) {
			$('.recent-posts .featured-post-content').equalHeights();
		}
	});
 
	$(window).resize(function(){
		if (window.innerWidth > 320) {
			$('.recent-posts .featured-post-content').height('auto');
			$('.recent-posts .featured-post-content').equalHeights();
		}
	});
 
});