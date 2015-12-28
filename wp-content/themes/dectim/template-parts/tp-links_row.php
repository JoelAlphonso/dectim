<?php
	if( have_rows('links') ):
?>
		<div class='tp-links'>
			<?php
				while ( have_rows('links') ) : the_row();
					$linkUrl = ( get_sub_field('is_internal_link')? get_sub_field('internal_link'): get_sub_field('external_link') );
					$targetlink = get_sub_field('is_internal_link') ? "":'target="_blank"';
			?>	
					<a href="<?php echo $linkUrl; ?>" <?php echo $targetlink; ?> class="button"><?php the_sub_field('title')?></a>
			<?php
				endwhile;
			?>
		</div>
<?php
	endif;
?>