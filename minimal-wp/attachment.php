<?php get_header(); ?>
<section class="attachment-content content">
	<?php the_post(); ?>
    <h1 class="page-title"><a href="<?php echo get_permalink($post->post_parent) ?>" title="<?php printf( __( 'Return to %s', 'mammoth' ), esc_html( get_the_title($post->post_parent), 1 ) ) ?>" rev="attachment"><span class="meta-nav">&laquo; </span><?php echo get_the_title($post->post_parent) ?></a></h1>
    <article<?php post_class(); ?>>				
        <h2 class="post-title"><?php the_title(); ?></h2>
        <aside class="post-data">
            <span class="meta-prep meta-prep-author"><?php _e('By ', 'mammoth'); ?></span><span class="author vcard"><a class="url fn n" href="<?php echo get_author_posts_url( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'mammoth' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
            <span class="meta-sep"> | </span>
            <span class="meta-prep meta-prep-post-date"><?php _e('Published ', 'mammoth'); ?></span><span class="post-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
            <?php edit_post_link( __( 'Edit', 'mammoth' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
        </aside>
        <div class="post-content">	
            <div class="post-attachment">
				<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "medium"); ?>
                <p class="attachment"><a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title(); ?>" rel="attachment"><img src="<?php echo $att_image[0];?>" width="<?php echo $att_image[1];?>" height="<?php echo $att_image[2];?>"  class="attachment-medium" alt="<?php $post->post_excerpt; ?>" /></a></p>
                <?php else : ?>
                <a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo esc_html( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>
                <?php endif; ?>
            </div>
            <aside class="post-caption"><?php if ( !empty($post->post_excerpt) ) the_excerpt() ?></div>
				<?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'mammoth' )  ); ?>
                <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'mammoth' ) . '&after=</div>') ?>
            </aside>
        </article>
</section>
<?php get_sidebar(); ?>	
<?php get_footer(); ?>