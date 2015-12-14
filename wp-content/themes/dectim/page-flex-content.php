<?php /* Template Name: Flexible Content Page */ ?>

<?php get_header();

if( have_rows('title') ):

	// Code Here...

else:

	// No title

endif;

if( have_rows('sub_title') ):

	// Code Here...

else:

	// No title

endif;

get_template_part("flex_content_loop");

get_footer(); ?>

