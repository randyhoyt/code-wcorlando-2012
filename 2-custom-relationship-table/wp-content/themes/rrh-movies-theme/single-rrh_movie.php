<?php
/**
 * Template Name: Sidebar Template
 * Description: A Page Template that adds a sidebar to pages
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'page' ); ?>

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

			</div><!-- #content -->
		</div><!-- #primary -->

        <div id="secondary" class="widget-area" role="complementary">
            <aside class="widget" style="padding-top: 59px;">
                
        <?php

            $connected = new WP_Query( array(
        		'connected_type' => 'rrh_person_to_movie',
        		'connected_items' => $post,
        		'nopaging' => true
        	) );
        
        	if ( $connected->have_posts() ) {
            	echo '<h3 class="widget-title">People</h3>';
            	while ( $connected->have_posts() ) : $connected->the_post();
            		echo '<li><a href="';
            		the_permalink(); 
            		echo '">';
            		the_title();
            		echo '</a></li>';
            	endwhile;
            }
        
        	wp_reset_postdata();
	
	   ?>
    		</aside>	
        </div>
<?php get_footer(); ?>