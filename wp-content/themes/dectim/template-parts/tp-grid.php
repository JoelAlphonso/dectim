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
				$args = array("post_type" => "finissants");
				
				$query = new WP_Query($args);
				
				#Aller chercher tous les étudiants
				if ($query->have_posts())
				{
					while ($query->$have_posts())
					{
						$query->the_post();
						
						?>
							<article>
								<div>
									<span></span>
									<p>Maxime <span>St-Onge</span></p>
									<ul>
										<li>3D</li>
										<li>Intégration</li>
										<li>Traitement des médias</li>
									</ul>
									<a href="http://mstonge.com/" target="_blank">Portfolio</a>
								</div>

								<p>Maxime <span>St-Onge</span></p>
								<img src="img/maxime_st_onge.jpg" alt="Maxime St-Onge" />
							</article>
						<?php
					}
				}
				
				wp_reset_postdata();
			?>
		</section>
	</div>
</div>