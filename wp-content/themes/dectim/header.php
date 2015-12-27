<!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo("charset"); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php getPageTitle(); ?></title>
	<link href='https://fonts.googleapis.com/css?family=Roboto:900,700,300,300italic,500,400' rel='stylesheet' type='text/css'>
	<link href="<?php bloginfo("stylesheet_url"); ?>" rel="stylesheet" type="text/css" />
	<?php wp_head(); ?>
</head>

<body class="<?php if(is_front_page()){ echo "Accueil"; }else{ echo "contenu"; }; ?>">

<header>
	<div class='slideTop'></div>
	<div class='bgHeaderSlide'>
		<div class='bgHeaderBack'></div>
		<div class='bgHeaderFront'></div>
		<div class='slogan'>
				<p><span>TECHNIQUES</span> D'INTÉGRATION MULTIMÉDIA</p>
				<p><span>CÉGEP</span> ÉDOUARD-MONTPETIT</p>
		</div>
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