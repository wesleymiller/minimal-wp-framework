<?php get_header(); ?>
<div class="pages-content content">
		<?php the_post(); ?>
        <article <?php post_class(); ?>>
            <h1 class="page-title"><?php the_title(); ?></h1>
            <div class="page-content">
                <?php the_content(); ?>
                <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'minimal-wp' ) . '&after=</div>') ?>					
                <?php edit_post_link( __( 'Edit', 'minimal-wp' ), '<span class="edit-link">', '</span>' ) ?>
            </div>
        </article>
</div>
<?php get_sidebar(); ?>	
<?php get_footer(); ?>