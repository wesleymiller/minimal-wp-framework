<?php get_header(); ?>
<div class="single-content content">
	<?php the_post(); ?>
    <article <?php post_class(); ?>>				
        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'minimal-wp'), the_title_attribute('echo=0') ); ?>" ><?php the_title(); ?></a></h2>
        <aside class="post-data">
            <span class="meta-prep meta-prep-author"><?php _e('By ', 'minimal-wp'); ?></span><span class="author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'minimal-wp' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
            <span class="meta-sep"> | </span>
            <span class="meta-prep meta-prep-post-date"><?php _e('Published ', 'minimal-wp'); ?></span><span class="post-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
            <?php edit_post_link( __( 'Edit', 'minimal-wp' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
        </aside>
        <div class="post-content">	
			<?php the_content(); ?>
            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'minimal-wp' ) . '&after=</div>') ?>
        </div>
        <aside class="post-info">
			<?php printf( __( 'This entry was posted in %1$s%2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" >permalink</a>. Follow any comments here with the <a href="%5$s" title="Comments RSS to %4$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.', 'minimal-wp' ),
				get_the_category_list(', '),
				get_the_tag_list( __( ' and tagged ', 'minimal-wp' ), ', ', '' ),
				get_permalink(),
				the_title_attribute('echo=0'),
				get_post_comments_feed_link() )
			?>
            <?php if ( ('open' == $post->comment_status) && ('open' == $post->ping_status) ) : ?>
            <?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'minimal-wp' ), get_trackback_url() ) ?>
            <?php elseif ( !('open' == $post->comment_status) && ('open' == $post->ping_status) ) : ?>
			<?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'minimal-wp' ), get_trackback_url() ) ?>
			<?php elseif ( ('open' == $post->comment_status) && !('open' == $post->ping_status) ) : ?>
			<?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'minimal-wp' ) ?>
			<?php elseif ( !('open' == $post->comment_status) && !('open' == $post->ping_status) ) : ?>
			<?php _e( 'Both comments and trackbacks are currently closed.', 'minimal-wp' ) ?>
			<?php endif; ?>
            <?php edit_post_link( __( 'Edit', 'minimal-wp' ), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>" ) ?>
        </aside>
    </article>
    <nav class="post-nav">
        <div class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
        <div class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
    </nav>
    <?php comments_template('', true); ?>			
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>