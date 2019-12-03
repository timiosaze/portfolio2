$(document).ready(function() {
	$('.element-group .element').click(function(){
		$this = $(this).parent('.element-group').find('.actions');
		$nothis = $(this).parent('.element-group').siblings().find('.actions');
		$this.slideToggle();
		$nothis.slideUp();
	});
	$('.image_box').click(function(){
		$this = $(this).find('form');
		$nothis = $(this).parent(".image_outer").siblings('.image_outer').find('form');
		$this.slideToggle();
		$nothis.slideUp();
	})
});