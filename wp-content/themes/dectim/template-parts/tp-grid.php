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
				#Trouver l'année des finissants
				$annee = get_sub_field("annee");

				if ($annee === 0) $annee = date("Y");
				
				getEtudiants($annee);
			?>
		</section>
	</div>
</div>