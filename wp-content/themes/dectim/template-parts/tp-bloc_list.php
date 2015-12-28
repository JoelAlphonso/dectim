<?php
	if( have_rows('list_item') ):
?>
		<div class='tp-box-list'>
			<div class="Wrapper">
				<ul>
				<?php
					while ( have_rows('list_item') ) : the_row();
				?>
					<li><p><?php the_sub_field('item'); ?></p></li>
				<?php endwhile; ?>
				</ul>
			</div>
		</div>
<?php
	endif;
?>