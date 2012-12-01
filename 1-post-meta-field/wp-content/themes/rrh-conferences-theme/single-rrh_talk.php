<?php
/**
 * The Template for displaying all single talks.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

    <div id="secondary" class="widget-area" role="complementary">
    	<?php $speakers = get_post_meta($post->ID,'speaker',false); ?>
    	<?php if ($speakers) { ?>
        	<aside class="widget">
        	    <h3 class="widget-title">Speaker<?php if (count($speakers)>1) { echo 's'; } ?></h3>
        	    <ul>
        	    <?php foreach($speakers as $speaker_id) { ?>
        	        <?php $speaker = get_post($speaker_id); ?>
        		    <li>
        			    <a href="<?php echo get_permalink($speaker->ID); ?>"><?php echo apply_filters('the_title',$speaker->post_title); ?></a>
                    </li>        	    
        	    <?php } ?>
                </ul>
            </aside>
        <?php } ?>
    </div>

<?php get_footer(); ?>