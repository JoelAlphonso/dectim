<?php 
	if( get_sub_field('text') ):
		$classList = "tp-text";
		$classList .= ( get_sub_field('left_bracket') ? " leftBracket" : "");
		$classList .= ( get_sub_field('right_bracket') ? " rightBracket" : "");
?> 
		<div class="<?php echo $classList; ?>">
			<div class="Wrapper">
				<?php
					// two column text
					if( get_sub_field('column') == "2" ): 
				?>
						<p class="twoCol"><?php the_sub_field('text')?></p>
				<?php
					// One column text
					else:
				?>
						<p><?php the_sub_field('text')?></p>
				<?php endif; ?>
			</div>
		</div>
<?php endif; ?>