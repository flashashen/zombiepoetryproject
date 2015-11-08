<?php
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );

/**
 * Includes
  */
require_once (get_template_directory() . '/inc/options-framework.php'); // Functions for theme options page
require_once (get_template_directory() .'/inc/wp_bootstrap_navwalker.php');  // Bootstrap:  Register Custom Navigation Walker
require_once(get_template_directory() .'/inc/fonts.php'); // Functions for theme Fonts

function prpin_setup() {
load_theme_textdomain( 'prpin', get_template_directory() . '/languages' );
add_editor_style();
if ( ! isset( $content_width ) ) $content_width = 1200;
register_nav_menus(array('top_nav' => __('Top Navigation', 'prpin')));
add_theme_support('automatic-feed-links');
add_theme_support('post-thumbnails');
add_theme_support('custom-background', array(
	'default-color' => 'f2f2f2',
));
add_theme_support('post-formats', array( 'aside', 'gallery','link','image','quote','status','video','audio','chat' ) );
add_theme_support( 'title-tag' );
}
add_action( 'after_setup_theme', 'prpin_setup' );

/**
 * Styles the header text displayed on the blog.
 */
function prpin_custom_header_setup() {
	$args = array(
		// Text color and image (empty to use none).
		'default-text-color'     => '0088CC',
		// Set height and width, with a maximum value for the width.
		'height'                 => 200,
		'width'                  => 1600,
		// Callbacks for styling the header .
		'wp-head-callback'       => 'prpin_header_style'
	);
	add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'prpin_custom_header_setup' );

function prpin_header_style() {
	$header_image = get_header_image();
	$text_color   = get_header_textcolor();

	// If no custom options for text are set, let's bail.
	if ( empty( $header_image ) && $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
		return;

	// If we get this far, we have custom styles.
	?>
	<style type="text/css" id="prpin-header-css">
	<?php
		if ( ! empty( $header_image ) ) :
	?>
		.site-header {
			background: url(<?php header_image(); ?>) no-repeat scroll top;
			background-size: 100% 100%;
			height: 200px;
		}
	<?php
		endif;

		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px 1px 1px 1px); /* IE7 */
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
			if ( empty( $header_image ) ) :
	?>
		.site-header .home-link {
			min-height: 0;
		}
	<?php
			endif;

		// If the user has set a custom color for the text, use that.
		elseif ( $text_color != get_theme_support( 'custom-header', 'default-text-color' ) ) :
	?>
		.site-title {
			color: #<?php echo esc_attr( $text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}

function prpin_widgets_init() {
register_sidebar(array('name' => 'sidebar-left', 'id' => 'sidebar-left', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => "</div>", 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
register_sidebar(array('name' => 'sidebar-right', 'id' => 'sidebar-right', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => "</div>", 'before_title' => '<h4 class="widget-title">', 'after_title' => '</h4>'));
}
add_action( 'widgets_init', 'prpin_widgets_init' );

function prpin_scripts() {
// Load Theme and Bootstrap Stylesheet
wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', null, '3.3.4');
wp_enqueue_style('fontawesome',  get_template_directory_uri() . '/css/font-awesome.min.css', array( 'bootstrap' ), '4' );
wp_enqueue_style( 'google_fonts', 'http://fonts.googleapis.com/css?family=Lobster', false, null, 'all' );
wp_enqueue_style( 'prpin-style', get_stylesheet_uri() ); // Load Theme Stylesheet
wp_enqueue_script('prpin_bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
wp_enqueue_script('prpin_dropdown', get_template_directory_uri() . '/js/hover-dropdown.min.js', array('jquery'), null, true);
if (is_singular() && comments_open() && get_option( 'thread_comments' )) {
wp_enqueue_script('comment-reply');
}

if (!is_singular()) {
wp_enqueue_script('jquery-masonry');
wp_enqueue_script('prpin_iloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), null, false);
wp_enqueue_script('prpin_infinitescroll', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array('jquery'), null, false);
     	}
}

add_action('wp_enqueue_scripts', 'prpin_scripts');

function prpin_foot_scripts() {
	if (!is_singular()) {	?>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		/* Masonry */
		var $container = $('#masonry');
	 // Callback on After new masonry boxes load
		window.onAfterLoaded = function(el) {
			el.find('div.post-meta li').popover({
				trigger: 'hover',
				placement: 'top',
				container: 'body'
			});
		};

		onAfterLoaded($container.find('.boxy'));

		$container.imagesLoaded(function() {
			$container.masonry({
			itemSelector: '.boxy',
		 	isAnimated: true
			});
		});
	});
</script>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			var $container = $('#masonry');
			$container.infinitescroll({
				navSelector : '#navigation',
				nextSelector : '#navigation #navigation-next a',
				itemSelector : '.boxy',
				maxPage       :10,
 loading: {
			msgText: '<?php _e('Loading', 'prpin') ?>',
			finishedMsg: '<?php _e('All items loaded', 'prpin') ?>',
			img: '<?php echo get_template_directory_uri(); ?>/img/loading.gif',
	}
			},
			// trigger Masonry as a callback
			function(newElements) {
				// hide new items while they are loading
				var $newElems = $(newElements).css({
					opacity: 0});
				// ensure that images load before adding to masonry layout
				$newElems.imagesLoaded(function() {
					// show elems now they're ready
					$newElems.animate({
						opacity: 1});
					$container.masonry('appended', $newElems, true);
				});
				onAfterLoaded($newElems);
			}
			);
		});
	</script>
	<?php }
	// end if !is_singular() ?>

	<script>
		jQuery(document).ready(function($) {
			var $scrolltotop = $("#scroll-top");
			$scrolltotop.css('display', 'none');

			$(function () {
				$(window).scroll(function () {
					if ($(this).scrollTop() > 100) {
						$scrolltotop.slideDown('fast');
					} else {
						$scrolltotop.slideUp('fast');
					}
				});

				$scrolltotop.click(function () {
					$('body,html').animate({
						scrollTop: 0
					}, 'fast');
					return false;
				});
			});
		});

	</script>
		<?php
}
add_action('wp_footer', 'prpin_foot_scripts');

/**
* Get the author post link
*/
function prpin_get_the_author_posts_link() {
			$format = '<a href="%1$s" title="%2$s" rel="author">%3$s</a>';
			$link = sprintf($format, get_author_posts_url(get_the_author_meta('ID'), get_the_author_meta('nicename')), esc_attr(sprintf(__('Posts by %s', 'prpin'), get_the_author())), get_the_author());

			return sprintf(__('By: %s', 'prpin'), $link);
		}

/**
 * Get post meta(date, categories, tags etc.)
*/
function prpin_get_post_meta($inline = false, $author = true, $date = false, $category = true, $tag = true, $comments = false, $sticky = false, $tooltip = false) {
			$inline = ($inline) ? 'list-inline' : 'list-unstyled';
			$html = '<div class = "post-meta">';
			$html .= '<ul class = "' . $inline . '">';
			if (is_sticky() && $sticky) {
				$html .= '<li class = "post-sticky label label-info" ';
				$html .= ($tooltip) ? 'data-content="' . __('Featured', 'prpin') . '"' : '';
				$html .= '><i class = "fa fa-star"></i> ';
				$html .= ($tooltip) ? '' : __('Featured', 'prpin');
				$html .= '</li>';
			}
			if ($date) {
				$formatedDate = get_the_date(__('M d, Y', 'prpin'));
				$html .= '<li class = "post-date" ';
				$html .= ($tooltip) ? 'title="' . __('Published on', 'prpin') . '" data-content="' . $formatedDate . '"' : '';
				$html .= '><i class = "fa fa-calendar"></i> ';
				$html .= ($tooltip) ? '' : $formatedDate;
				$html .= '</li>';
			}
			if ($author) {
				$authorName = get_the_author();
				$html .= '<li class = "post-author" ';
				$html .= ($tooltip) ? 'title="' . __('Author', 'prpin') . '" data-content="' . $authorName . '"' : '';
				$html .= '><i class = "fa fa-user"></i> ';
			 	$html .= ($tooltip) ? '' : prpin_get_the_author_posts_link();
				$html .= '</li>';
			}
			if ($category) {
				if (has_category()):
					$categories = get_the_category();
					$categoryList = array();
					foreach ($categories as $category) {
						$categoryList[] = $category->cat_name;
					}
					$html .= '<li class = "post-category" ';
					$html .= ($tooltip) ? 'title="' . __('Categories', 'prpin') . '" data-content="' . join(", ", $categoryList) . '"' : '';
					$html .= '><i class = "fa fa-folder-open"></i> ';
					$html .= ($tooltip) ? '' : sprintf(__('Category: %s', 'prpin'), get_the_category_list(' ', '', false));
					$html .= '</li>';
				endif;
			}
			if ($tag) {
				if (has_tag()):
					$tags = get_the_tags();
					$tagList = array();
					foreach ($tags as $tag) {
						$tagList[] = $tag->name;
					}
					$html .= '<li class = "post-tags" ';
					$html .= ($tooltip) ? 'title="' . __('Tags', 'prpin') . '" data-content="' . join(", ", $tagList) . '"' : '';
					$html .= '><i class = "fa fa-tags"></i> ';
					$html .= ($tooltip) ? '' : get_the_tag_list(__('Tag:  ', 'prpin'), ' ');
					$html .= '</li>';
				endif;
			}
			if ($comments) {
				$commentNumber = get_comments_number();
				$html .= '<li class = "post-comments" ';
				$html .= ($tooltip) ? 'title="' . __('Comments', 'prpin') . '" data-content="' . $commentNumber . '"' : '';
				$html .= '><i class = "fa fa-comment"></i> ';
				$html .= $commentNumber;
				$html .= '</li>';
			}
			$html .= '</ul>';
			$html .= '</div>';
			return $html;
		}


function prpin_thumbnail($pID,$thumb='medium') {
$imgsrc = FALSE;
 if (has_post_thumbnail()) {
						$imgsrc = wp_get_attachment_image_src(get_post_thumbnail_id($pID),$thumb);
						$imgsrc = $imgsrc[0];
} elseif ($postimages = get_children("post_parent=$pID&post_type=attachment&post_mime_type=image&numberposts=0")) {
				foreach($postimages as $postimage) {
							$imgsrc = wp_get_attachment_image_src($postimage->ID, $thumb);
							$imgsrc = $imgsrc[0];
						}
					} elseif (preg_match('/<img [^>]*src=["|\']([^"|\']+)/i', get_the_content(), $match) != FALSE) {
						$imgsrc = $match[1];
					}
		if($imgsrc) {
$imgsrc = '<a href="'. get_permalink().'"><img src="'.$imgsrc.'" alt="'.get_the_title().'" /></a>';
     	return $imgsrc;
		}
	}


 /**
 * Replace rel="category tag" with rel="tag"
 * For W3C validation purposes only.
 */
function prpin_replace_rel_category ($output) {
    $output = str_replace(' rel="category tag"', ' rel="tag"', $output);
    return $output;
}

add_filter('wp_list_categories', 'prpin_replace_rel_category');
add_filter('the_category', 'prpin_replace_rel_category');

 // Comment Layout

function prpin_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">

		<?php if ('1' == $show_avatars = get_option('show_avatars')) { ?>
		<div class="comment-avatar"><?php echo get_avatar(get_comment_author_email(), '48'); ?></div>
		<?php } ?>
		<div class="comment-content<?php if ($show_avatars == '1') { echo ' comment-content-with-avatar'; } ?>">

			<strong><span <?php comment_class(); ?>><?php comment_author_link() ?></span></strong> / <?php comment_date('j M Y g:ia'); ?> <a href="#comment-<?php comment_ID() ?>" title="<?php esc_attr_e('Comment Permalink', 'prpin'); ?>">#</a> <?php edit_comment_link('<i class="fa fa-pencil"></i>','','');?>
			<?php if ($comment->comment_approved == '0') : ?>
			<br /><em><?php _e('Your comment is awaiting moderation.', 'prpin'); ?></em>
			<?php endif; ?>

			<?php comment_text() ?>
			<?php comment_reply_link(array('reply_text' => __('<i class="fa fa-reply"></i> Reply', 'prpin'), 'depth' => $depth, 'max_depth'=> $args['max_depth'])) ?>
        </div>
	<?php
}



/**
 * Title tag filter

function prpin_title_filter( $title, $sep, $seplocation ) {
    // get special index page type (if any)
    if( is_category() ) $type = 'Category';
    elseif( is_tag() ) $type = 'Tag';
    elseif( is_author() ) $type . 'Author';
    elseif( is_date() || is_archive() ) $type = 'Archives';
    else $type = false;

    // get the page number
    if( get_query_var( 'paged' ) )
        $page_num = get_query_var( 'paged' ); // on index
    elseif( get_query_var( 'page' ) )
        $page_num = get_query_var( 'page' ); // on single
    else $page_num = false;

    // strip title separator
    $title = trim( str_replace( $sep, '', $title ) );

    // determine order based on seplocation
    $parts = array( get_bloginfo( 'name' ), $type, $title, $page_num );
    if( $seplocation == 'left' )
        $parts = array_reverse( $parts );

    // strip blanks, implode, and return title tag
    $parts = array_filter( $parts );
    return implode( ' ' . $sep . ' ', $parts );
}
// call our custom wp_title filter, with normal (10) priority, and 3 args
add_filter( 'wp_title', 'prpin_title_filter', 10, 3 );
 */

/**
 * Sidebar  displayed in home page
*/
function prpin_get_sidebar($side) {
	if ( of_get_option('prpin_hlayout') == '2c-l-fixed'  && $side == 'left' )  {
			echo '<div id="sidebar" class="col-sm-3 col-md-3 col-lg-3"><div class="sidebar-inner">';
				get_sidebar($side);
				echo '</div></div>';
} elseif (of_get_option('prpin_hlayout') == '2c-r-fixed'  && $side == 'right' ) {
			echo '<div id="sidebar" class="col-sm-3 col-md-3 col-lg-3"><div class="sidebar-inner">';
				get_sidebar($side);
				echo '</div></div>';
}
}

/**
 * Sidebar  displayed in single page
*/
function prpin_get_sidebar_single($side) {
			if ($side == 'left' && is_active_sidebar('sidebar-left')) {
				echo '<div id="sidebar" class="col-sm-3 col-md-3 col-lg-3"><div class="sidebar-inner">';
				get_sidebar($side);
				echo '</div></div>';
			}
         if ($side == 'right' && is_active_sidebar('sidebar-right')) {
             echo '<div id="sidebar" class="col-sm-3 col-md-3 col-lg-3"><div class="sidebar-inner">';
				get_sidebar($side);
				echo '</div></div>';
			}
	 }

/**
* Is sidebar active
 */
function prpin_is_sidebar_active() {
			$bool = is_active_sidebar('sidebar-right') ||
					     is_active_sidebar('sidebar-left');
			return $bool;
		}

/**
* Get the columns width Index
*/
function prpin_get_index_span() {
		if ( of_get_option('prpin_hlayout') == '1col-fixed')  {
				return 'col-sm-12 col-md-12 col-lg-12';
			}
			return  'col-sm-9 col-md-9 col-lg-9';
		}

/**
* Get the columns width Content
*/
function prpin_get_contentspan() {
         	if ( is_active_sidebar('sidebar-right') && is_active_sidebar('sidebar-left')) {
		 	return 'col-sm-6 col-md-6 col-lg-6';
			} elseif ( is_active_sidebar('sidebar-right') || is_active_sidebar('sidebar-left')) {
            return  'col-sm-9 col-md-9 col-lg-9';
			} else {
	     	return 'col-sm-12 col-md-12 col-lg-12';
			}
 		}

/**
* Get the image width
*/
function prpin_get_imagespan() {
if (!prpin_is_sidebar_active()) {
return 'width12';
}
			$options = prpin_get_theme_options();
			return ($options['theme_layout'] == 'content') ? 'width12' : 'width9';
}

/**
* Get the no result string
*/
function prpin_get_no_result() {
			$span = prpin_get_contentspan();
			$html = '<div class="jumbotron '.$span.'">';
			$html .= '<h2>' . __('Sorry, no posts matched your criteria.', 'prpin') . '</h2>';
			$html .= '</div>';
			return $html;
}

/**
 *   Responsive videos
 */
function prpin_responsive_video_support($content) {
if (is_singular()) {
?>
<script type="text/javascript">
 jQuery(document).ready(function($) {
  $('iframe').each(function() {
    $(this).wrap('<div class="video-container"></div>');
  });
});
</script>
<?php
}
} //end function

add_action('wp_footer', 'prpin_responsive_video_support');

 ?>