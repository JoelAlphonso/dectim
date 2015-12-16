<?php

// check if the repeater field has rows of data
if( have_rows('list_item') ): ?>

 	<div class='tudiv'>
 	
	<?php

 	// loop through the rows of data
    while ( have_rows('list_item') ) : the_row(); ?>
       
			<div>
				<p><?php the_sub_field('item'); ?></p>
			</div>

    <?php endwhile; ?>

    </div>

<?php 

else :

    // no rows found

endif;

?>