<aside class="comments">
	<?php
		$req = get_option('require_name_email');
		if ( 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
			die ( 'This page cannot be loaded directly.' );
		if ( ! empty($post->post_password) ) :
		if ( $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password ) :
	?>
	<div class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', 'minimal-wp') ?></div>
	<?php
		return;
		endif;
		endif;
	?>
    <?php if ( have_comments() ) : ?>
		<?php
            $ping_count = $comment_count = 0;
            foreach ( $comments as $comment )
            get_comment_type() == "comment" ? ++$comment_count : ++$ping_count;
        ?>
        <?php if ( ! empty($comments_by_type['comment']) ) : ?>
            <div class="comments-list">
                <h3><?php printf($comment_count > 1 ? __('<span>%d</span> Comments', 'minimal-wp') : __('<span>One</span> Comment', 'minimal-wp'), $comment_count) ?></h3>
                <?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>
                <nav id="comments-nav-above" class="comments-navigation">
                    <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
                </nav>  
                <?php endif; ?>					
                <ol>
	                <?php wp_list_comments('type=comment&callback=custom_comments'); ?>
                </ol>
				<?php $total_pages = get_comment_pages_count(); if ( $total_pages > 1 ) : ?>					
                <nav id="comments-nav-below" class="comments-navigation">
                    <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
                </nav>
				<?php endif; ?>					
            </div>
		<?php endif; ?>
        <?php if ( ! empty($comments_by_type['pings']) ) : ?>
            <div class="trackbacks-list">
                <h3><?php printf($ping_count > 1 ? __('<span>%d</span> Trackbacks', 'minimal-wp') : __('<span>One</span> Trackback', 'minimal-wp'), $ping_count) ?></h3>
                <ol>
	                <?php wp_list_comments('type=pings&callback=custom_pings'); ?>
                </ol>				
            </div>		
        <?php endif ?>
    <?php endif ?>
	<?php comment_form(); ?>
</aside>