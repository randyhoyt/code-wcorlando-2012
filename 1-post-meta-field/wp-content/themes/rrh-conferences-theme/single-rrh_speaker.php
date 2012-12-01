<?php
/**
 * The Template for displaying all single speakers.
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
                    <h1 class="entry-title">
                        <?php $display = get_post_meta($post->ID,'name_first',true) . " " . get_post_meta($post->ID,'name_last',true); ?>
                        <?php echo apply_filters('the_title',trim($display)); ?>
                    </h1>
                </header>
                
                <div class="entry-content">
                    <?php $img = get_post_meta($post->ID,'img',true); ?>
                    <?php if (!empty($img)) { ?>
                        <img style="margin-top: 0;" class="alignright" src="<?php echo get_post_meta($post->ID,'img',true); ?>">
                    <?php } ?>
                    <?php
                        $twitter = get_post_meta($post->ID,'twitter',true);
                        $job_title = get_post_meta($post->ID,'job_title',true);
                        $company = get_post_meta($post->ID,'company',true);
                        $company_url = get_post_meta($post->ID,'company_url',true);
                        
                        if (!empty($twitter) || !empty($company) || !empty($company_url)) {
                            echo '<p>';                        
                            if (!empty($twitter)) {
                                echo '<div><a href="http://twitter.com/' . $twitter . '">@' . $twitter . '</a></div>';
                            }
                        
                            if (!empty($job_title)) {
                                echo '<div>' . $job_title . '</div>';
                            }
                                                    
                            if (!empty($company) || !empty($company_url)) {
                                echo '<div>';
                                echo $company;
                                if (!empty($company) && !empty($company_url)) echo " - ";
                                if (!empty($company_url)) { echo '<a href="' . $company_url . '">' . $company_url . '</a>'; }
                                echo '</div>';
                            }
                            echo '</p>';                            
                        }
                        
                    ?>
                    <?php the_content(); ?>
                </div>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

    <div id="secondary" class="widget-area" role="complementary">
    	<?php $talks = get_posts(array('post_type' => 'rrh_talk', 'meta_key' => 'speaker', 'meta_value' => $post->ID)); ?>
    	<?php if ($talks) { ?>
        	<aside class="widget">
        	    <h3 class="widget-title">Talk<?php if (count($talks)>1) { echo 's'; } ?></h3>
        	    <ul>
        	    <?php foreach($talks as $talk_id) { ?>
        	        <?php $talk = get_post($talk_id); ?>
        		    <li>
        			    <a href="<?php echo get_permalink($talk->ID); ?>"><?php echo apply_filters('the_title',$talk->post_title); ?></a>
                    </li>        	    
        	    <?php } ?>
                </ul>
            </aside>
        <?php } ?>
    </div>

<?php get_footer(); ?>