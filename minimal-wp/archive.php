<?php get_header(); ?>
<section class="archive-content posts content">
    <?php the_post(); ?>			
    <?php if ( is_day() ) : ?>
    <h1 class="page-title"><?php printf( __( 'Daily Archives: <span>%s</span>', 'mammoth' ), get_the_time(get_option('date_format')) ) ?></h1>
    <?php elseif ( is_month() ) : ?>
    <h1 class="page-title"><?php printf( __( 'Monthly Archives: <span>%s</span>', 'mammoth' ), get_the_time('F Y') ) ?></h1>
    <?php elseif ( is_year() ) : ?>
    <h1 class="page-title"><?php printf( __( 'Yearly Archives: <span>%s</span>', 'mammoth' ), get_the_time('Y') ) ?></h1>
    <?php elseif ( is_category() ) : ?>
    <h1 class="page-title"><?php _e( 'Category Archives:', 'mammoth' ) ?> <span><?php single_cat_title() ?></span></span></h1>
    <?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>
    <?php elseif ( is_tag() ) : ?>
    <h1 class="page-title"><?php _e( 'Tag Archives:', 'mammoth' ) ?> <span><?php single_tag_title() ?></span></h1>
    <?php elseif ( is_author() ) : ?>
    <h1 class="page-title author"><?php printf( __( 'Author Archives: <span class="vcard">%s</span>', 'mammoth' ), "<a class='url fn n' href='$authordata->user_url' title='$authordata->display_name' rel='me'>$authordata->display_name</a>" ) ?></h1>
    <?php $authordesc = $authordata->user_description; if ( !empty($authordesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $authordesc . '</div>' ); ?>
    <?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
    <h1 class="page-title"><?php _e( 'Archives', 'mammoth' ) ?></h1>
    <?php endif; ?>
    <?php rewind_posts(); ?>
    <?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class(); ?>>
        <h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'mammoth'), the_title_attribute('echo=0') ); ?>" ><?php the_title(); ?></a></h2>
        <aside class="post-data">
            <span class="meta-prep meta-prep-author"><?php _e('By ', 'mammoth'); ?></span>
            <span class="author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'mammoth' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
            <span class="meta-sep"> | </span>
            <span class="meta-prep meta-prep-post-date"><?php _e('Published ', 'mammoth'); ?></span>
            <span class="post-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
            <?php edit_post_link( __( 'Edit', 'mammoth' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
        </aside>
        <div class="post-content post-summary">	
			<?php the_excerpt( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'mammoth' )  ); ?>
        </div>
        <aside class="post-info">
            <span class="cat-links"><span class="post-info-prep post-info-prep-cat-links"><?php _e( 'Posted in ', 'mammoth' ); ?></span><?php echo get_the_category_list(', '); ?></span>
            <span class="meta-sep"> | </span>
            <?php the_tags( '<span class="tag-links"><span class="post-info-prep post-info-prep-tag-links">' . __('Tagged ', 'mammoth' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
            <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'mammoth' ), __( '1 Comment', 'mammoth' ), __( '% Comments', 'mammoth' ) ) ?></span>
            <?php edit_post_link( __( 'Edit', 'mammoth' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?>
        </aside>	
    </article>
    <?php endwhile; ?>			
    <?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
    <nav class="post-nav">
        <div class="previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'mammoth' )) ?></div>
        <div class="next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'mammoth' )) ?></div>
    </nav>
    <?php } ?>			
</section>
<?php get_sidebar(); ?>	
<?php get_footer(); ?>