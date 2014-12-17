<?php get_header(); ?>
    <div class="error404-content content">
        <section class="post error404 not-found">
            <h1 class="post-title"><?php _e( 'Not Found', 'mammoth' ); ?></h1>
            <article class="post-content">
                <p><?php _e( 'What you are looking for is not available. You could try searching.', 'mammoth' ); ?></p>
                <?php get_search_form(); ?>
                <p><?php _e( 'Or return to the ', 'mammoth' ); ?><a href="<?php echo home_url() ?>/" title="<?php bloginfo( 'name' ) ?>" rel="home">Homepage</a>.</p>
            </article>
        </section>
    </div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>