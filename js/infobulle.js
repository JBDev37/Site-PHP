$(function(){
	$("a").mouseover(function(){
		var info = $(this);
		if(!(info.attr("title"))) return false;
		$("body").append('<span class="infobulle"></span>');
		var bulle = $(".infobulle");
		bulle.append($(this).attr("title"));
		var posTop = $(this).offset().top-$("a").height();
		var posLeft = $(this).offset().left+$(this).width()/2-bulle.width()/2;
		bulle.css({
			left:posLeft,
			top:posTop,
			opacity:0
		});

		bulle.animate({
			top:posTop,
			opacity:0.99
		});
	});



	$("a").mouseout(function(){
		$(".infobulle").remove();
	});


});

