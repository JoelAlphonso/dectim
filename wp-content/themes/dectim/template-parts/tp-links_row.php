<?php

// check if the repeater field has rows of data
if( have_rows('links') ): ?>

 	<div class='tp-links'>
 	
	<?php

 	// loop through the rows of data
    while ( have_rows('links') ) : the_row(); 

    	$linkUrl = ( get_sub_field('is_internal_link')? get_sub_field('internal_link'): get_sub_field('external_link') );

    ?>	

		<a href="<?php echo $linkUrl; ?>" class="<?php echo (get_sub_field('is_call_to_action')? "highlight": ""); ?>"><?php the_sub_field('title')?></a>	
			
    <?php endwhile; ?>

    </div>

<?php

else :

    // no rows found

endif;

?>