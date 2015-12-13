(function($)
{
  var clic = true;

  $(window).resize(function()
  {
	window.scrollTo(0, 0);
	if ($(window).width() > 983)
	{
	  $('.bgHeaderSlide').show();
	  $('.slideTop').css('height', '0');
	  $('.slideTop').css('margin-top', '0');
	  $('header').css('margin-top', '0');
	  $('.logoBox').css('left', '45%');
	  $('.logoBox').css('top', '20px');
	  $('.logoBox').css('height', '100px');
	  $('.logoBox').css('width', '150px');
	  $('header nav').css('top', '150px');
	  $('header nav').css('margin-left', '25%');
	  $('header nav').css('margin-right', '25%');
	  $('header nav').css('width', '50%');

	  $('#hamburgerImg').css('opacity', '1');
	  $('header li').css('display', 'inline-block');
	  $('header .logoBox img').css('width', '50%');
	  $('header .logoBox img').css('margin', '25px 25%');
	}
	else
	{
	  $('.bgHeaderSlide').show();
	  $('.slideTop').css('height', '63px');
	  $('.slideTop').css('margin-top', '0px');
	  $('header').css('margin-top', '0px');
	  $('.logoBox').css('left', '-2%');
	  $('.logoBox').css('top', '0px');
	  $('.logoBox').css('height', '63px');
	  $('.logoBox').css('width', '150px');
	  $('header nav').css('top', '0px');
	  $('header nav').css('margin-left', '30%');
	  $('header nav').css('margin-right', '5%');
	  $('header nav').css('width', '65%');

	  $('.hamburgerImg').css('opacity', '1');
	  $('header li').css('display', 'inline-block');
	  $('header .logoBox img').css('width', '30%');

	  $('header .logoBox img').css('margin', '12px 34%');

	  if ($(window).width() < 720)
	  {
		$('#hamburgerImg').css('opacity', '1');
		$('header li').css('display', 'none');
		$('header .logoBox img').css('margin', '20px 34%');
		clic = true;
	  }
	}
  });

  $(window).scroll(function(event)
  {
	var size = $(window).width();
	var scroll = $(window).scrollTop();

	if (size > 983)
	{
	  // Do something
	  if (scroll >= 100)
	  {
		console.log('red');
		$('.bgHeaderSlide').stop().hide('fast');
		$('.slideTop').stop().animate(
		{
		  height: 63
		}, 200);

		$('header ul').stop().animate(
		{
		  height: 63
		}, 200);

		$('.logoBox').stop().animate(
		{
		  left: '-2%',
		  top: '0px',
		  height: '63px',
		  width: '250px'
		}, 100);

		$('header nav').stop().animate(
		{
		  top: '0px',
		  width: '65%',
		  marginLeft: '30%',
		  marginRight: '5%'
		}, 200);

		$('header').stop().animate(
		{
		  marginTop: '0px'
		}, 200);

		$('header .logoBox img').stop().animate(
		{
		  width: '30%',
		  margin: '12px 37%'
		});
	  }
	  else
	  {
		$('.bgHeaderSlide').stop().show('fast');

		$('.slideTop').stop().animate(
		{
		  height: 0,
		  marginTop: '0px'
		}, 200);

		$('header .logoBox img').stop().animate(
		{
		  width: '50%',
		  margin: '25px 25%'
		});

		$('header').stop().animate(
		{
		  marginTop: '0px'
		}, 200);

		$('.logoBox').stop().animate(
		{
		  left: '45%',
		  top: '20px',
		  height: '100px',
		  width: '150px'
		}, 100);

		$('header nav').stop().animate(
		{
		  top: '150px',
		  width: '65%',
		  marginLeft: '17.5%',
		  marginRight: '17.5%'
		}, 200);
	  }
	}
  });

  $("#hamburgerImg").off("click");
  clic = true;

  $('#hamburgerImg').on('click', function()
  {
	if (clic == true)
	{
	  clic = false;
	  $(this).css('opacity', '0.5');
	  $('header li').slideDown('fast');

	}
	else
	{
	  clic = true;
	  $(this).css('opacity', '1');
	  $('header li').slideUp('fast');
	}
  });
})(jQuery);