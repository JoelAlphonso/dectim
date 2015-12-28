<div class="grille etudiants">
	<div class="Wrapper">
		<?php
			#Ajouter la recherche si elle est activée
			if (get_sub_field("recherche") == true && get_sub_field("type") == "Étudiants")
			{ ?>
				<div>
					<input type="search" placeholder="Recherchez un finissant ou un profil" />
				</div>
		<?php } ?>
		
		<section>
			<?php
				if (get_sub_field("type") == "Étudiants")
				{
					#Trouver l'année des finissants
					$annee = get_sub_field("annee");
					
					if ($annee === "0")
					{
						$annee = currentYearFinissants();
					}
					
					#Variable d'année pour ajax
					echo "<var>" . $annee . "</var>";
					
					getEtudiants($annee);
				}
				else
				{
					getProfesseurs();
				}
			?>
		</section>
	</div>
</div>