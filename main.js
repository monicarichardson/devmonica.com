$(document).ready(function (){
	/* Scroll to each section using nav bar buttons */
	$('nav ul li button').click(function (){
		let navButtonId = $(this).attr('id');
		if (navButtonId == 'home'){
			$('html, body').animate({
			scrollTop: 0
			 }, 500);
			if ($('.mobile-nav-button-close')) {
				$('.mobile-nav-button-close')[0].click();
			}
		}
		else {
			$('html, body').animate({
			scrollTop: $('#' + navButtonId + '-section').offset().top
			 }, 500);
			if ($('.mobile-nav-button-close')) {
				$('.mobile-nav-button-close')[0].click();
			}
		}
		return false;
	});
	
	/* Mobile nav */
	$('.mobile-nav-button-open').click(function(e) {
		e.preventDefault();
		$(this).toggleClass('mobile-nav-button-close');
		$('#menu').toggleClass('display');
		$('nav').toggleClass('mobile-menu');
		$('body').toggleClass('position-fixed');
	});
	
	/* Display timeline bubble on hover over each milestone */
	$('.timeline-milestone').hover(function(){
		let milestoneName = $(this).attr('data-milestone');
		$('#timeline-bubble-' + milestoneName).toggleClass('timeline-bubble-display');
	});
});

function contactForm() {
	var feedback = $('#contact-form-feedback');
	$.ajax({
	  type: "POST",
	  data:{
		  action:'contact',
		  name: $('#name').val(),
		  email: $('#email').val(),
		  message: $('#message').val(),
	  },
	  url: 'contact.php',
	  error: function(xhr,status,error){alert(error);},
	  success:function(data) {
		  try {
			  var jsonData = JSON.parse(data);
			  feedback[0].innerHTML = "";
			  if (jsonData.sent) {
				  feedback[0].innerHTML = "<p>" + jsonData.message + "</p>";
				  $('#name').val("");
				  $('#email').val("");
				  $('#message').val("");
				  location.href = '#contact-section';
			  }
			  else {
				  feedback[0].innerHTML = "<p>" + jsonData.message + "</p>";
			  }
		  }
		  catch(e) {
			  feedback[0].innerHTML = "<p>" + data + "</p>";
		  }
	  }
	});
}