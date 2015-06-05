<?php
/**
 * @package WordPress
 * @subpackage megahout
 * @since megahout 1.0
 */
?>
 <aside id="sidebar">

    <?php if (function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar Widgets')) : else : ?>
    
        <!-- All this stuff in here only shows up if you DON'T have any widgets active in this zone -->

    	<?php get_search_form(); ?>
    
    	<h2><?php _e('Archives','megahout'); ?></h2>
    	<ul>
    		<?php wp_get_archives('type=monthly'); ?>
    	</ul>
            
    	<h2><?php _e('Meta','megahout'); ?></h2>
    	<ul>
    		<?php wp_register(); ?>
    		<li><?php wp_loginout(); ?></li>
    		<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','megahout'); ?>"><?php _e('WordPress','megahout'); ?></a></li>
    		<?php wp_meta(); ?>
    	</ul>
    	
    	<h2><?php _e('Subscribe','megahout'); ?></h2>
    	<ul>
    		<li><a href="<?php bloginfo('rss2_url'); ?>"><?php _e('Entries (RSS)','megahout'); ?></a></li>
    		<li><a href="<?php bloginfo('comments_rss2_url'); ?>"><?php _e('Comments (RSS)','megahout'); ?></a></li>
    	</ul>
	
	<?php endif; ?>

</aside>