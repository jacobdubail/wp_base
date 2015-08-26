<a href="<?php the_permalink(); ?>" class="col--md-4 card__link">
	<figure class="card__figure">
		<img src="<?php echo $url; ?>" alt="<?php echo esc_html(get_the_title()); ?>" class="card__media">
		<figcaption class="card__caption">
			<h3 class="card__title"><?php the_title(); ?></h3>
			<p class="card__text"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
		</figcaption>
		<figcaption class="card__badge"></figcaption>
	</figure>
</a>