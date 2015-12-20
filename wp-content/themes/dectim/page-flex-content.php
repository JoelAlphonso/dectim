<?php /* Template Name: Flexible Content Page */ ?>

<?php get_header(); ?>

<section>
	
<?php

if( get_field('title') ): ?>

	<div class="secHeader">
		
		<?php if( get_field('sub_title') ): ?>
		
		<div>
			<div class"superTitleBox"></div>
			<p><?php the_field('sub_title'); ?></p>
		</div>

		<?php endif;?>

		<h1><?php the_field('title'); ?></h1>
	</div>

<?php endif; ?>

	<div class="secContent">

<?php get_template_part("flex_content_loop"); ?>

	</div> <!-- fin de secContent -->

</section>

<?php get_footer(); ?>

