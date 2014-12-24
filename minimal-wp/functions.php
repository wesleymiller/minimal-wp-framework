<?php 
/* Functions ---------------------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/* Validation Functions ------------------------------------------------------------*/
function valid_search_form ($form) { return str_replace('role="search" ', '', $form); }
add_filter('get_search_form', 'valid_search_form');
function replace_cat_tag ( $text ) { $text = str_replace('rel="category tag"', "", $text); return $text; }
add_filter( 'the_category', 'replace_cat_tag' );
function remove_attach_rel_attr($content) { return preg_replace('/\s+rel="attachment wp-att-[0-9]+"/i', '', $content); }
add_filter('the_content', 'remove_attach_rel_attr');
/*------------------------------------------------------------------------------*/
/* Custom Menu -----------------------------------------------------------------*/
function register_custom_menu() { register_nav_menu('navigation', __('Navigation', 'minimal-wp')); }
add_action('init', 'register_custom_menu');
/*------------------------------------------------------------------------------*/
/* Theme Support ----------------------------------------------------------------*/
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'custom-header', array('header-text' => false,	'flex-height' => true));
add_theme_support( 'post-formats', array( 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat' )  );
add_theme_support( 'post-thumbnails' ); 
set_post_thumbnail_size( 150, 150 );
load_theme_textdomain( 'minimal-wp', get_template_directory() . '/languages' );
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable($locale_file) ) { require_once($locale_file); }
/*------------------------------------------------------------------------------*/
/* Sidebar -----------------------------------------------------------------------*/	
if ( function_exists('register_sidebar') )
	register_sidebar(array(
		'name'=>'Sidebar',
		'before_widget' => '<div class="sidebar-widget widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
/*------------------------------------------------------------------------------*/
/* Scripts -----------------------------------------------------------------------*/	
function enqueue_comment_reply() {
	if ( get_option( 'thread_comments' ) )  {
		wp_enqueue_script( 'comment-reply' );
	};
}
add_action( 'comment_form_before', 'enqueue_comment_reply' );
function enqueue_theme_jquery()  {  
    wp_register_script( 'theme_custom_jquery', get_stylesheet_directory_uri()."/js/".get_current_theme().".js", array( 'jquery', 'jquery-ui-core' ), null, true );  
    wp_enqueue_script( 'theme_custom_jquery' );
}  
add_action( 'wp_enqueue_scripts', 'enqueue_theme_jquery' );
/*------------------------------------------------------------------------------*/
/* Custom Comments & Pings ------------------------------------------------------*/
function custom_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
	?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	<div class="comment-author vcard"><?php commenter_link() ?></div>
	<div class="comment-meta"><?php printf(__('Posted %1$s at %2$s <span class="meta-sep">|</span> <a href="%3$s" title="Permalink to this comment">Permalink</a>', 'minimal-wp'),
	get_comment_date(),
	get_comment_time(),
	'#comment-' . get_comment_ID() );
	edit_comment_link(__('Edit', 'minimal-wp'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
	<?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'minimal-wp') ?>
	<div class="comment-content">
	<?php comment_text() ?>
	</div>
	<?php
	if($args['type'] == 'all' || get_comment_type() == 'comment') :
	comment_reply_link(array_merge($args, array(
	'reply_text' => __('Reply','minimal-wp'),
	'login_text' => __('Log in to reply.','minimal-wp'),
	'depth' => $depth,
	'before' => '<div class="comment-reply-link">',
	'after' => '</div>'
	)));
	endif;
	?>
<?php }
function custom_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
	<div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'minimal-wp'),
	get_comment_author_link(),
	get_comment_date(),
	get_comment_time() );
	edit_comment_link(__('Edit', 'minimal-wp'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
	<?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'minimal-wp') ?>
	<div class="comment-content">
	<?php comment_text() ?>
	</div>
	<?php }
	function commenter_link() {
	$commenter = get_comment_author_link();
	if ( ereg( '<a[^>]* class=[^>]+>', $commenter ) ) {
	$commenter = ereg_replace( '(<a[^>]* class=[\'"]?)', '\\1url ' , $commenter );
	} else {
	$commenter = ereg_replace( '(<a )/', '\\1class="url "' , $commenter );
	}
	$avatar_email = get_comment_author_email();
	$avatar = str_replace( "class='avatar", "class='photo avatar", get_avatar( $avatar_email, 80 ) );
	echo $avatar . ' <span class="fn n">' . $commenter . '</span>';
}
/* End Custom Comments & Pings ---------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/* Gallery Markup Fix -------------------------------------------------------------*/
add_filter('wp_get_attachment_link', 'remove_img_width_height', 10, 1);
add_image_size( 'gallery-img', 720 );
function remove_img_width_height($html) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
function fix_gallery($output, $attr) {
	global $post;
	static $instance = 0;
	$instance++;
    if ( isset( $attr['orderby'] ) ) {
        $attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
        if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
    extract( shortcode_atts( array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'div',
        'captiontag' => 'p',
        'columns' => 3,
        'size' => 'gallery-img',
        'include' => '',
        'exclude' => ''
    ), $attr));
    $id = intval($id);
    if ( 'RAND' == $order )
        $orderby = 'none';
    if ( !empty($include) ) {
        $include = preg_replace( '/[^0-9,]+/', '', $include );
        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
        $attachments = array();
        foreach ( $_attachments as $key => $val ) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    } else {
        $attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
    }
    if ( empty($attachments) )
        return '';
    if ( is_feed() ) {
        $output = "\n";
        foreach ( $attachments as $att_id => $attachment )
            $output .= wp_get_attachment_link($att_id, $size, true) . "\n";
        return $output;
    }
    $itemtag = tag_escape($itemtag);
    $captiontag = tag_escape($captiontag);
    $columns = intval($columns);
    $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
    $float = is_rtl() ? 'right' : 'left';
    $selector = "gallery-{$instance}";
    $gallery_style = $gallery_div = '';
    if ( apply_filters( 'use_default_gallery_style', true ) )
    $size_class = sanitize_html_class( $size );
    $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";
    $output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );
    $i = 0;
    foreach ( $attachments as $id => $attachment ) {
        $link = isset($attr['link']) && 'file' == $attr['link'] ? wp_get_attachment_link($id, $size, false, false) : wp_get_attachment_link($id, $size, true, false);
        $output .= "<{$itemtag} class='gallery-item'>";
        $output .= "$link";
        if ( $captiontag && trim($attachment->post_excerpt) ) {
            $output .= "
                <{$captiontag} class='wp-caption-text gallery-caption'>
                " . wptexturize($attachment->post_excerpt) . "
                </{$captiontag}>";
        }
        $output .= "</{$itemtag}>";
        if ( $columns > 0 && ++$i % $columns == 0 )
            $output .= '';
    }
    $output .= "</div>\n";
    return $output;
}
add_filter("post_gallery", "fix_gallery",10,2);
add_shortcode('wp_caption', 'fix_img_caption_shortcode');
add_shortcode('caption', 'fix_img_caption_shortcode');
function fix_img_caption_shortcode($attr, $content = null) {
	if ( ! isset( $attr['caption'] ) ) {
		if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
			$content = $matches[1];
			$attr['caption'] = trim( $matches[2] );
		}
	}
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' )
		return $output;
		extract( shortcode_atts( array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	), $attr));
	if ( 1 > (int) $width || empty($caption) )
		return $content;
	if ( $id ) $id = 'id="' . esc_attr($id) . '" ';
		return '<div ' . $id . 'class="wp-caption ' . esc_attr($align) . '" >'  . do_shortcode( $content ) . '<p class="wp-caption-text">' . $caption . '</p></div>';
}
/* End Gallery Markup Fix ----------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/*------------------------------------------------------------------------------*/
/* End Functions -----------------------------------------------------------------*/	
?>