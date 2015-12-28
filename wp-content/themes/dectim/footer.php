	<footer>
		<div class='footerBack'></div>
		<div class='footerFront'></div>
		<div class='content'>
			<div class='sociaux'>
				<ul>
					<?php
						#Aller chercher les réseaux sociaux
						if (have_rows("reseaux_sociaux", "options")):
							while (have_rows("reseaux_sociaux", "options")):
								the_row();
					?>
								<li class="<?php echo strtolower(get_sub_field("reseau_social")); ?>"><a href="<?php the_sub_field("url_socialmedia"); ?>" target="_blank"><h3><?php the_sub_field("reseau_social"); ?></h3></a></li>
					<?php			
							endwhile;
						endif;
					?>
				</ul>
			</div>
			<div class='logos'>
				<a href='<?php the_field("url_du_cegep", "options"); ?>' target="_blank">
					<img src="<?php bloginfo("template_url")?>/img/dectimlogo.png" alt='TimEdouard'>
				</a>
			</div>
		</div>
	</footer>
		<!--CDN links for TweenLite, CSSPlugin, and EasePack-->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/plugins/CSSPlugin.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/easing/EasePack.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenLite.min.js"></script>
		<?php wp_footer(); ?>
  	</body>
</html>