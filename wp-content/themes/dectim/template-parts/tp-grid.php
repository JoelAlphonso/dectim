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
						$profils = get_the_term_list($post->ID, "profil", "", ",");
						$profils = strip_tags($profils);
						$profils = explode(",", $profils);
						?>
							<article tabindex="<?php echo $i; ?>">
								<div>
									<span></span>
									<p><?php echo $nom1; ?><span><?php echo implode($nom); ?></span></p>
									
									<?php if (count($profils) > 1): ?>
										<ul>
											<?php for ($j = 0; $j < min(count($profils), 3); $j++): ?>
												<li><?php echo $profils[$j]; ?></li>
											<?php endfor; ?>
										</ul>
									<?php endif; ?>
									
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