		<footer>
			<div class="conteneurTriangles">
				<div></div>
				<div></div>
			</div>
			
			<div>
				<div>
					<ul>
						<?php
							#Aller chercher les réseaux sociaux
							if (have_rows("reseaux_sociaux", "options")):
								while (have_rows("reseaux_sociaux", "options")):
									the_row();
						?>
									<li class="<?php echo strtolower(get_sub_field("reseau_social")); ?>"><a href="<?php the_sub_field("url_socialmedia"); ?>" target="_blank"><?php the_sub_field("reseau_social"); ?></a></li>
						<?php			
								endwhile;
							endif;
						?>
					</ul>
				</div>
				<div>
					<div class="Wrapper">
						<a href='<?php the_field("url_du_cegep", "options"); ?>' target="_blank">
							<img src="<?php bloginfo("template_url")?>/img/dectimlogo.png" alt='TimEdouard'>
						</a>
					</div>
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