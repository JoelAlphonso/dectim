<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo("charset"); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php
		bloginfo("name");
		$desc = get_bloginfo("description");
		if (! empty($desc)) echo " : " . $desc;
	?></title>
	<link href='https://fonts.googleapis.com/css?family=Roboto:900,700,300,300italic,500,400' rel='stylesheet' type='text/css'>
	<link href="<?php bloginfo("stylesheet_url"); ?>" rel="stylesheet" type="text/css" />
	<?php wp_head(); ?>
</head>

<body class="Accueil">

<header>
	<div class='slideTop'></div>
	<div class='bgHeaderSlide'>
	<div class='slogan'>
			<p><span>TECHNIQUES</span> D'INTÉGRATION MULTIMÉDIA</p>
			<p><span>CÉGEP</span> ÉDOUARD-MONTPETIT</p>
	</div>
		<div class='bgHeaderBack'>
		 
		</div>
		<div class='bgHeaderFront'></div>
	</div>
	<div>		
		<div class='hamburger'>
		  <!--Le hamburger sera fait en CSS-->
			<img id='hamburgerImg' src='<?php echo bloginfo("template_url")?>/img/hamburger.svg' alt='Burger'>
		</div>
		<div class='logoBox'>
			<a href='index.html'>
				<img src='<?php echo bloginfo("template_url")?>/img/logo.png' alt='logo'>	
			</a>
		</div>
		<nav id='menu'>
			 <?php wp_nav_menu('nav'); ?>
		</nav>
	</div>
</header>