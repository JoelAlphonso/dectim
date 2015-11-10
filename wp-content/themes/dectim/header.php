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
		<link href="<?php bloginfo("stylesheet_url"); ?>" rel="stylesheet" type="text/css" />
		<?php wp_head(); ?>
	</head>

	<body>