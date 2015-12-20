<?php 
	
if( get_sub_field('text') ):
	$classList = "tp-text";
	$classList .= ( get_sub_field('left_bracket') ? " leftBracket" : "");
	$classList .= ( get_sub_field('right_bracket') ? " rightBracket" : "");

?> 

	<div class="<?php echo $classList; ?>">

	<?php if( get_sub_field('column') == "2" ): 
		// two column text ?>
		<div class="twoCol"><?php the_sub_field('text')?></div>
	<?php else: 
		// One column text ?>
		<div><?php the_sub_field('text')?></div>
	<?php endif; ?>

	</div>

<?php endif; ?>