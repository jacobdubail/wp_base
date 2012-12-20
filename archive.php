<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
  
  <h2><?php echo single_term_title(); ?></h2>
  <div class="tax-description"><?php echo term_description(); ?></div>
  
    <?php while ( have_posts() ) : the_post(); ?>

      <?php the_content(); ?>

    <?php endwhile; ?> 
  
  <?php endif; ?>

<?php get_footer(); ?>
