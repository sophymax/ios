//选项js

jQuery(document).ready(function($){

	$('.lianyue_admin .nav-tab-wrapper .nav-tab').hover(function(){
		$(this).addClass("nav-tab-active").siblings().removeClass("nav-tab-active");
		$(".tabs > .tab_div").addClass("hide").removeClass("show").eq($('.lianyue_admin .nav-tab-wrapper .nav-tab').index(this)).addClass("show").removeClass("hide");
	});
});
