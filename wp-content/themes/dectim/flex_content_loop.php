<?php
	// check if the flexible content field has rows of data
	if( have_rows('flexible_content') ):
	
		 // loop through the rows of data
		while ( have_rows('flexible_content') ) : the_row();
			
			if( get_row_layout() == 'new_section' ): 
				// Get the specific flexible content template part
				get_template_part("template-parts/tp" , "new_section");

			elseif( get_row_layout() == 'title' ): 
				// Get the specific flexible content template part
				get_template_part("template-parts/tp" , "title");

			elseif( get_row_layout() == 'text' ): 
				// Get the specific flexible content template part
				get_template_part("template-parts/tp" , "text");

			elseif( get_row_layout() == 'bloc_list' ): 
				// Get the specific flexible content template part
				get_template_part("template-parts/tp" , "bloc_list");

			elseif( get_row_layout() == 'links_row' ): 
				// Get the specific flexible content template part
				get_template_part("template-parts/tp" , "links_row");
			elseif (get_row_layout() == "grille"):
				// Get the specific flexible content template part
				get_template_part("template-parts/tp" , "grid");
			endif;

		endwhile;

	else :
		// no layouts found
	endif;
?>