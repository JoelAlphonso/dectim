<?php get_header(); ?>
	<main class="p404">
		<h1><span>Erreur</span></h1>		
		<h1>Page 404</h1>
		<?php
			#Si on a un lien vers une autre page
			if (get_field("lien_vers_une_autre_page")):
				#Trouver le target
				$target = empty(get_field("lien_externe")) ? "":'target="_blank"';
				
				#Trouver l'url
				$lien = empty(get_field("lien_externe")) ? get_field("lien_vers_une_page"):get_field("url_du_lien");
		?>
				<p><a href="<?php echo $lien; ?>" <?php echo $target; ?>><?php the_field("texte_du_lien"); ?></a></p>
		<?php
			endif;
		?>
	</main>
<?php get_footer(); ?>
