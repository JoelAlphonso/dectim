<div class="grille etudiants">
	<div class="Wrapper">
		<?php
			#Ajouter la recherche si elle est activée
			if (get_sub_field("recherche"))
			{ ?>
				<div>
					<input type="search" placeholder="Recherchez un finissant ou un profil" />
				</div>
		<?php } ?>
		
		<section>
			<?php
				#Aller chercher l'année
				/*$annee = get_sub_field("annee");
				
				if (empty($annee))
				{
					
				}*/
			?>
			
			<?php
				#Commencer une query WP
				$args = array("post_type" => "etudiant_post_type", "nopaging" => true, "orderby" => "name", "order" => "ASC");
				
				$query = new WP_Query($args);
				
				#Aller chercher tous les étudiants
				if ($query->have_posts())
				{
					$i = 0;
					
					while ($query->have_posts())
					{
						$query->the_post();
						
						$nom = explode(" ", get_the_title());
						$nom1 = array_shift($nom);
						$url = empty(get_field("url_portfolio")) ? "javascript:void(0)" : get_field("url_portfolio");
						
						#Aller chercher les profils
						$profils = null;
						
						?>
							<article tabindex="<?php echo $i; ?>">
								<div>
									<span></span>
									<p><?php echo $nom1; ?><span><?php echo implode($nom); ?></span></p>
									
									<ul>
										<li>3D</li>
										<li>Intégration</li>
										<li>Traitement des médias</li>
									</ul>
									<a href="<?php echo $url; ?>" target="_blank">Portfolio</a>
								</div>

								<p><?php echo $nom1; ?><span><?php echo implode($nom); ?></span></p>
								<img src="<?php echo get_field("photo_etudiant")["sizes"]["medium"]; ?>" alt="<?php the_title(); ?>" />
							</article>
						<?php
							$i++;
					}
				}
				
				#Ajouter des fillers
				for ($i = 0; $i < 3; $i++)
				{ ?>
					<article class="filler">
					</article>
			<?php }
				
				wp_reset_postdata();
			?>
		</section>
	</div>
</div>