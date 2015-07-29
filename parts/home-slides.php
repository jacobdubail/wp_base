<?php if ( have_rows( 'slides' ) ) : ?>
	<div class="owl-carousel owl-theme" id="carousel">
		<?php while ( have_rows( 'slides' ) ) : the_row(); ?>
			<a href="<?php the_sub_field('link'); ?>" class="item">
				<img src="<?php the_sub_field('image'); ?>" alt="Slide">
			</a>
		<?php endwhile; ?>
	</div>
<?php endif; ?>
