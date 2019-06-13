// COOKIES
	// Switch state
    var buttonswitch = $.cookie('profile');
	var stickybuttonswitch = $.cookie('sticky');
	var nightmodeswitch = $.cookie('nightmode');
	// Set the user's selection
	if (buttonswitch == 'leftprofile') {
		$('.profilebuttonon').css("background-position","-0px -0px");
		$('.profilebuttonoff').css("background-position","-0px -26px");
		$('.postprofile').css("float","left").css("border-width","0 1px 0 0");
		$('.rtl .postprofile').css("float","right").css("border-width","0 0 0 1px");
		$('.postbody').css("float","right");
		$('.rtl .postbody').css("float","left");
		$('.online').css("background-position","16% 0");
		$('.rtl .online').css("background-position","85% 0");
		$('.rtl .has-profile .post-buttons').css("right","auto");
    };
	
	if (stickybuttonswitch == 'stickyoff') {
		$('.sticky').css("display","none");
		$('.stickybuttonoff').css("display","block");
		$('.stickybuttonon').css("display","none");
    };
	
	if (nightmodeswitch == 'nightmodeon') {
		$('.nightmodeoff').css("display","none");
		$('.nightmodeon').css("display","block");
		$('html, body').css("background-color","#868686").css("color","#D5D5D5");
		$('.copyright').css("color","#393939");
		$('.panel, .post').css("border","1px solid transparent");
		$('#overlay').css("display","block");
    };
	
$(document).ready(function() {	
// PROFILEBUTTON:
    // When buttonoff is clicked:
    $('.profilebuttonoff').click(function() {
		$('.profilebuttonon').css("background-position","-0px -0px");
		$('.profilebuttonoff').css("background-position","-0px -26px");
		$('.postprofile').css("float","left").css("border-width","0 1px 0 0");
		$('.rtl .postprofile').css("float","right").css("border-width","0 0 0 1px");
		$('.postbody').css("float","right");
		$('.rtl .postbody').css("float","left");
		$('.online').css("background-position","16% 0");
		$('.rtl .online').css("background-position","85% 0");
		$('.rtl .has-profile .post-buttons').css("right","auto");
		$.cookie('profile', 'leftprofile', { expires: 365, path: '/' });
    });
	// When buttonon is clicked:
    $('.profilebuttonon').click(function() {
		$('.profilebuttonon').css("background-position","-0px -26px");
		$('.profilebuttonoff').css("background-position","-0px -0px");
		$('.postprofile').css("float","right").css("border-width","0 0 0 1px");
		$('.rtl .postprofile').css("float","left").css("border-width","0 1px 0 0");
		$('.postbody').css("float","left");
		$('.rtl .postbody').css("float","right");
		$('.online').css("background-position","100% 0");
		$('.rtl .online').css("background-position","-15px 0");
		$('.rtl .has-profile .post-buttons').css("left","0").css("right","auto");
		$.cookie('profile', null, { path: '/' });
    });
	
// STICKYBUTTON:
	// When buttonoff is clicked:
    $('.stickybuttonoff').click(function() {
		$('.sticky').css("display","block");
		$('.stickybuttonoff').css("display","none");
		$('.stickybuttonon').css("display","block");
		$.cookie('sticky', null, { path: '/' });
    });
	// When buttonon is clicked:
    $('.stickybuttonon').click(function() {
		$('.sticky').css("display","none");
		$('.stickybuttonoff').css("display","block");
		$('.stickybuttonon').css("display","none");
		$.cookie('sticky', 'stickyoff', { expires: 365, path: '/' });
    });
	
// NIGHTMODE:
	// When nightmodeon is clicked:
    $('.nightmodeon').click(function() {
		$('.nightmodeoff').css("display","block");
		$('.nightmodeon').css("display","none");
		$('html, body').css("background-color","#EEEEEE").css("color","#333333").css("-webkit-transition","background-color 1s, color 1s").css("-moz-transition","background-color 1s, color 1s").css("-o-transition","background-color 1s, color 1s").css("transition","background-color 1s, color 1s");
		$('.copyright').css("color","#555555").css("-webkit-transition","color 1s").css("-moz-transition","color 1s").css("-o-transition","color 1s").css("transition","color 1s");
		$('.panel, .post').css("border","1px dashed #CCCCCC");
		$('#overlay').css("display","none");
		$.cookie('nightmode', null, { path: '/' });
    });
	// When nightmodeoff is clicked:
    $('.nightmodeoff').click(function() {
		$('.nightmodeoff').css("display","none");
		$('.nightmodeon').css("display","block");
		$('html, body').css("background-color","#868686").css("color","#D5D5D5").css("-webkit-transition","background-color 1s, color 1s").css("-moz-transition","background-color 1s, color 1s").css("-o-transition","background-color 1s, color 1s").css("transition","background-color 1s, color 1s");
		$('.copyright').css("color","#393939").css("-webkit-transition","color 1s").css("-moz-transition","color 1s").css("-o-transition","color 1s").css("transition","color 1s");
		$('.panel, .post').css("border","1px solid transparent");
		$('#overlay').css("display","block");
		$.cookie('nightmode', 'nightmodeon', { expires: 365, path: '/' });
    });
});