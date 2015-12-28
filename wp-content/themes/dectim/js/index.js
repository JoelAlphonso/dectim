var requetes = [];

(function($){
var menu;
jQuery(document).ready(function(){
  
  var clic = true;

	$('body').on('click', '.showProject', function () {
	    showProject(this);
	});

	$('body').on('click', '.openVideo', function () {
	    showVideo(this);
	});

	$('body').on('click', '.overlayExit', function () {
	    hideOverlay();
	});
  
  // Var for initial nav offset and height
  var navOffset = $("nav").offset().top;
  var distance = navOffset + $("nav").outerHeight();
  menu = $("header");
  
  $(window).scroll(function(){

  	var scrollAmount = $(window).scrollTop();
  	if($(window).width() >= 960){

	  	if(scrollAmount > distance){
	  		// show minimized fixed menu
	  		if(!menu.hasClass('fixed')){
		  		menu.addClass('fixed');
		  		TweenLite.set(menu, {y:"-125%"});
		  		TweenLite.to(menu, 0.5, {y:"0%", ease:Power2.easeInOut});
	  		}
	  	}else{
	  		// hide minimized fixed menu
	  		if(menu.hasClass('fixed')){
	  			TweenLite.to(menu, 0.5, {y:"-125%", ease:Power2.easeIn, onComplete:removeFixed});
	  		}	
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


	/****************************
		Grille de finissants
	****************************/
	/*Flèche retour*/
	jQuery(".grille article div > span").on("click", function(){
		document.activeElement.blur();
	});
	
	/*Ajax*/
	//Lorsqu'on tape, faire la recherche
	$("body.contenu input[type=search]").on("keyup", function()
	{
		//Récupérer la valeur
		var param = this.value.trim();
		
		//Trouver le nombre d'étudiants
		var nbreEtudiants = jQuery(".grille section").children().length;
		
		//Trouver l'année en cours
		var annee = $("var").text();
		
		//Faire la recherche avec au moins deux lettres
		if (param.length > 1 || (param.length == 0 && nbreEtudiants <= 1))
		{
			//Faire une requête vers le serveur
			var rqt = jQuery.get(ajaxurl, {action:"RechercheEtudiants", "mot-cle":param, "annee":annee}, function(response)
			{
				jQuery(".grille section").html(response);
			});
			
			//Annuler toutes les requetes précédents
			annulerRequetes();
			
			//Garder la requete en mémoire
			requetes.push(rqt);
		}
	});

});

function annulerRequetes()
{
	for (var i = 0; i < requetes.length; i++)
	{
		requetes[i].abort();
	}
	
	requetes = [];
}

function removeFixed(){
	menu.removeClass('fixed');
	TweenLite.to(menu, 0.5, {y:"0%", ease:Power2.easeOut});
}

// OverLay Endler

function showProject($projet) {

    disableScroll();

    $index = jQuery($projet).data('projet');

    $content = "";

    jQuery('.overlay').addClass('visible').removeClass('hidden');

    jQuery('.overlayContent').addClass('grow-off');

    //jQuery('.overlayContent > .content').html($content);

}

function hideOverlay() {

    enableScroll();

    jQuery('.overlay').removeClass('visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){
        jQuery(this).addClass('hidden');
    });
 jQuery('.overlayContent').removeClass('grow-off');
  //  jQuery('.overlayContent > .content').empty();

}

function disableScroll() {
    jQuery('body').addClass('overflowhidden');
}

function enableScroll() {
    jQuery('body').removeClass('overflowhidden');
}

})(jQuery);