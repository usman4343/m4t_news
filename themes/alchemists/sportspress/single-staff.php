<?php
/**
 * The template for displaying Single Staff
 *
 * @author    Dan Fisher
 * @package   Alchemists
 * @version   1.0
 */

get_header();

?>

<div class="site-content" id="content">
  <div class="container">

    <?php while ( have_posts() ) : the_post();

      the_content();

  	endwhile; // end of the loop. ?>

  </div>
</div>

<?php
get_footer();
