<?php get_header(); ?>
<div class="posts-content content">
    <?php while ( have_posts() ) : the_post() ?>
    <article <?php post_class(); ?>>				
        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'minimal-wp'), the_title_attribute('echo=0') ); ?>" ><?php the_title(); ?></a></h2>
        <aside class="post-data">
            <span class="meta-prep meta-prep-author"><?php _e('By ', 'minimal-wp'); ?></span><span class="author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'minimal-wp' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
            <span class="meta-sep"> | </span>
            <span class="meta-prep meta-prep-post-date"><?php _e('Published ', 'minimal-wp'); ?></span><span class="post-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
            <?php edit_post_link( __( 'Edit', 'minimal-wp' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
        </aside>
        <div class="post-content">	
        	<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'minimal-wp' )  ); ?>
            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'minimal-wp' ) . '&after=</div>') ?>
        </div>
        <aside class="post-info">
            <span class="cat-links"><span class="post-info-prep post-info-prep-cat-links"><?php _e( 'Posted in ', 'minimal-wp' ); ?></span><?php echo get_the_category_list(', '); ?></span>
            <span class="meta-sep"> | </span>
            <?php the_tags( '<span class="tag-links"><span class="post-info-prep post-info-prep-tag-links">' . __('Tagged ', 'minimal-wp' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
            <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'minimal-wp' ), __( '1 Comment', 'minimal-wp' ), __( '% Comments', 'minimal-wp' ) ) ?></span>
            <?php edit_post_link( __( 'Edit', 'minimal-wp' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?>
        </aside>
    </article>
    <?php endwhile; ?>	
    <?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
    <nav class="post-nav">
        <div class="previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'minimal-wp' )) ?></div>
        <div class="next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'minimal-wp' )) ?></div>
    </nav>
    <?php } ?>		
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>