<?php
	// check if the repeater field has rows of data
	if( get_sub_field('title') ):
?>
		<h1 class="tp-title"><?php the_sub_field('title'); ?></h1>
<?php
	endif;
?>