<?php /* Template Name: Flexible Content Page */ ?>

<?php get_header(); ?>

<section>
	
<?php

if( get_field('title') ): ?>

	<div class="secHeader">
		<div><p><?php the_field('title'); ?></p></div>
		<h1>As-tu le profil ?</h1>
	</div>

<?php else:

	// No title

endif;

if( have_rows('sub_title') ):

	// Code Here...

else:

	// No title

endif;

get_template_part("flex_content_loop");

?>

</section>

<?php get_footer(); ?>

