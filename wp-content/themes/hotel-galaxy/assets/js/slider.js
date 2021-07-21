jQuery(document).ready(function(){

	var mainSlider = jQuery(".hg-home-slider");	

	mainSlider.owlCarousel({
		items:1,		
		dots: hgSlider.isNav,
		nav:true,
		loop:true,
		autoplay:true,
		slideSpeed: ( hgSlider.speed*1000 ),		
		autoplayHoverPause:true,	
		navText: [
		'<i class="fa fa-angle-left" aria-hidden="true"></i>',
		'<i class="fa fa-angle-right" aria-hidden="true"></i>'
		],
	});
	

	mainSlider.on('mouseover',function(e){
		mainSlider.find('.owl-nav').css('opacity','1');
	})

	mainSlider.on('mouseleave',function(e){
		mainSlider.find('.owl-nav').css('opacity','0');
	})

	mainSlider.on('change.owl.carousel', function(event) {
		outIndex = event.item.index;
	});	

});