<?php /* Template Name: Home page */ ?>
<?php get_header(); ?>
	<section class="hero">
			<div class="videoContainer">
				<div class="videoWrapper">
					<!-- Copy & Pasted from YouTube -->
					<iframe width="1920" height="1080" src="https://www.youtube.com/embed/8uhp-HZt7UY?rel=0&amp;autoplay=1&amp;loop=1&amp;controls=0&amp;showinfo=0&amp;autohide=1&amp;playlist=8uhp-HZt7UY" frameborder="0" allowfullscreen=""></iframe>
				</div>
			</div>
			<div class="content">
				<h1><span>Vois grand,</span></h1>
				<h1><span>suis tes rêves</span></h1>

				<div class="Wrapper">
					<p>Le programme de Techniques d'intégration multimédia vise à former des techniciens polyvalents qui pourront intervenir dans toutes les étapes de production d'une application multimédia.</p>
					
					<a href="#" class="button orange small">S'inscrire</a><!--
					--><a href="#" class="button small">En savoir plus</a>
					
					<?php
						#Afficher le triangle si nécessaire
						if (get_field("activer_triangle", "options")):
							#Ajouter le triangle orange si la date est dans les limites
							$dateDebut = strtotime(get_field("date_debut", "options"));
							$dateFin = strtotime(get_field("date_fin", "options"));
							$now = strtotime(date("Y-m-d"));
							
							if ($dateDebut - $now < 0 && ($dateFin === false || $dateFin - $now > 0)):
						?>
								<svg viewBox="0 0 275 275" style="enable-background:new 0 0 275 275;">
									<polygon points="275,275 0,275 275,0 "/>
									<text style="fill: #fff;" transform="rotate(-45)">
										<tspan x="0" y="245"><?php the_field("premiere_ligne", "options"); ?></tspan>
										<tspan x="0" y="295"><?php the_field("deuxième_ligne", "options"); ?></tspan>
									</text>
								</svg>
					<?php
						endif;
							endif;
					?>
				</div>
			</div>
			
		</section>

		<div class="projets">
			<div class="Wrapper">
				<!--Project highlight-->
				<h1>Dernières réalisations <span>étudiantes</span></h1>
			</div>

			<article>
				<div class="Wrapper">
					<div>
						<h1>Fancy <span>Robot</span></h1>
						<p>Par: <a href="#">Marc-Antoine-Gautreau</a></p>
						<a href="#" class="button">Voir sa fiche</a>
					</div>
					
					<div>}</div>

					<aside>
						<img src="<?php echo get_template_directory_uri(); ?>/img/fancyrobot.png" alt="Fancy Robot" />
					</aside>
				</div>
			</article>
				
			<!--Projets-->
			<div class="Wrapper projets-list">

				<?php 

				$posts = get_posts(array(
					'posts_per_page'	=> 5,
					'post_type'			=> 'projets_post_type'
				));

				if($posts):

					foreach ($posts as $post):

						setup_postdata($post); ?>
						
							<article class="selected showProject" data-projet="0">
								<div class="hoverContainer">
									<span></span>
									<span></span>
								</div>
								<div class="contentContainer">
									<h1><?php the_title(); ?></h1>
									<p>Par: <a href="javascript:void(0)">Marc-Antoine Gautreau</a></p>
								</div>
							</article>

				<?php 
					endforeach;
					wp_reset_postdata();

				endif;

				?>
			</div>
		</div>

		<main>
			<div class="Wrapper">
				<div>
					<h1>Le <span>programme</span></h1>
					<p>Le programme de Techniques d’intégration multimédia vise à former des techniciens polyvalents qui pourront intervenir dans toutes les étapes de production d’une application multimédia. Notre formation te permettra de développer tes compétences dans la gestion de projet, le design graphique, la production sonore et vidéo, l’animation 2D et 3D et la programmation. L’intégrateur est donc un véritable touche-à-tout, ce qui rend son métier passionnant. Si vous êtes créatif, curieux et que les nouvelles technologies vous intéressent, le programme de Techniques d’intégration multimédia est pour vous!</p>
					<p>En devenant intégrateur multimédia, vous travaillerez avec différents logiciels vous permettant de traiter et d'intégrer des images, des textes, des animations 2D et 3D, des sons et des vidéos. Vous programmerez et créerez des scripts pour des applications multimédias. Vous planifierez, analyserez, scénariserez et gérerez une production multimédia. Vous réaliserez des projets multimédias interactifs en ligne (sites Web) et sur supports DVD, bornes interactives, etc.</p>
					<p>Vous pourrez travailler dans les entreprises de production multimédia en ligne et sur support, maisons d'édition, médias électroniques, agences du publicité, milieu artistique (télévision, cinéma, culture), milieu d'affaires (commerce électronique) et éducationnel (e-learning), etc.</p>
					<a href="#" class="button orange">En savoir plus</a>
				</div>

				<div class="js-flickity">
					<div class="gallery-cell"><img src="<?php echo get_template_directory_uri(); ?>/img/etudiant_1.jpg" alt=""></div>
					<div class="selected gallery-cell"><img src="<?php echo get_template_directory_uri(); ?>/img/etudiant_2.jpg" alt=""></div>
					<div class="gallery-cell"><img src="<?php echo get_template_directory_uri(); ?>/img/etudiant_3.jpg" alt=""></div>
					<div class="gallery-cell"><img src="<?php echo get_template_directory_uri(); ?>/img/etudiant_2.jpg" alt=""></div>
				</div>
			</div>
		</main>
<?php get_footer(); ?>
