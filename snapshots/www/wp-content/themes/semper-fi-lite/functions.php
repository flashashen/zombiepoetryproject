<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

?><?php

// Global Content Width, Kind of a Joke with this theme, lol
	if (!isset($content_width))
		$content_width = 648;


// Ladies, Gentalmen, boys and girls let's start our engines
add_action('after_setup_theme', 'semperfi_setup');

if (!function_exists('semperfi_setup')):

function semperfi_setup() {

    global $content_width; 
			
    // Add Callback for Custom TinyMCE editor stylesheets. (editor-style.css)
    add_editor_style();

    // This feature enables post and comment RSS feed links to head
    add_theme_support('automatic-feed-links');

    // This feature enables custom-menus support for a theme
    register_nav_menus(array(
        'bar' => __('The Menu Bar', 'semperfi' ) ) );

    // This enables featured image on posts and pages
    add_theme_support( 'post-thumbnails', array( 'post', 'page' ) );
    add_image_size( 'small_featured', 400, 237, true );
    add_image_size( 'medium_featured', 600, 355, true );
    add_image_size( 'large_featured', 1200, 1200 );

    // WordPress 3.4+
    if ( function_exists('get_custom_header')) {
        add_theme_support('custom-background'); } } endif;


// Filters the title so that it says something useful on the tabs
add_filter( 'wp_title', 'semperfi_filter_wp_title' );
function semperfi_filter_wp_title( $title ) {
	global $page, $paged;

	if ( is_feed() )
		return $title;

	$site_description = get_bloginfo( 'description' );

	$filtered_title = $title . get_bloginfo( 'name' );
	$filtered_title .= ( ! empty( $site_description ) && ( is_home() || is_front_page() ) ) ? ' | ' . $site_description: '';
	$filtered_title .= ( 2 <= $paged || 2 <= $page ) ? ' | ' . sprintf( __( 'Page %s' ), max( $paged, $page ) ) : '';

	return $filtered_title;}


/**
 * Filter 'get_comments_number'
 * 
 * Filter 'get_comments_number' to display correct 
 * number of comments (count only comments, not 
 * trackbacks/pingbacks)
 *
 * Courtesy of Chip Bennett
 */
function semperfi_comment_count( $count ) {  
	if ( ! is_admin() ) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']); }
	else {
		return $count; } }


/**
 * wp_list_comments() Pings Callback
 * 
 * wp_list_comments() Callback function for 
 * Pings (Trackbacks/Pingbacks)
 */
add_filter('get_comments_number', 'semperfi_comment_count', 0);
function semperfi_comment_list_pings( $comment ) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo comment_author_link(); ?></li>
<?php }

// Sets the post excerpt length to 250 characters
add_filter('excerpt_length', 'semperfi_excerpt_length');
function semperfi_excerpt_length($length) {
    return 250; }


/* This function adds in code specifically for IE6 to IE9
add_action('wp_head', 'semperfi_ie_css');
function semperfi_ie_css() {
	echo "\n" . '<!-- IE 6 to 9 CSS Hacking -->' . "\n";
	echo '<!--[if lt IE 11]><style type="text/css">' . "\n";
    echo '  .content {margin:0 1%; display:none;}';
    
    echo '</style><![endif]-->' . "\n";
	echo '<!--[if lt IE 9]><style type="text/css">';
    echo '  .content {margin:0 1%; display:none;}';
    echo '</style><![endif]-->' . "\n";
	echo "\n" . '<!-- End of Internet Explorer Hacking -->' . "\n";
	echo "\n"; }*/


// This function removes inline styles set by WordPress gallery
add_filter('gallery_style', 'semperfi_remove_gallery_css');
function semperfi_remove_gallery_css($css) {
    return preg_replace("#<style type='text/css'>(.*?)</style>#s", '', $css); }


// This function removes default styles set by WordPress recent comments widget
add_action( 'widgets_init', 'semperfi_remove_recent_comments_style' );
function semperfi_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) ); }


// A comment reply
add_action( 'wp_enqueue_scripts', 'semperfi_enqueue_comment_reply' );
function semperfi_enqueue_comment_reply() {
    if ( is_singular() && comments_open() && get_option('thread_comments')) 
            wp_enqueue_script('comment-reply'); }


// Wrap Video in a DIV so that videos width and height become reponsive using CSS
add_filter('embed_oembed_html', 'wrap_embed_with_div', 10, 3);
function wrap_embed_with_div($html, $url, $attr) {
	if (preg_match("/youtu.be/", $html) || preg_match("/youtube.com/", $html) || preg_match("/vimeo/", $html) || preg_match("/wordpress.tv/", $html) || preg_match("/v.wordpress.com/", $html)) { 
        // Don't see your video host in here? Just add it in, make sure you have the forward slash marks
            $html = '<div class="video-container">' . $html . "</div>"; }
            return $html;}


// WordPress Widgets start right here.
add_action('widgets_init', 'semperfi_widgets_init');
function semperfi_widgets_init() {

	register_sidebars(3, array(
		'name'=>'footer widget%d',
		'id' => 'widget',
		'description' => 'Widgets in this area will be shown below the the content of every page.',
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '<h2 class="post_title">',
		'after_title' => '</h2>', )); }


// Checks if the Widgets are active
function semperfi_is_sidebar_active($index) {
	global $wp_registered_sidebars;
	$widgetcolums = wp_get_sidebars_widgets();
	if ($widgetcolums[$index]) {
		return true; }
		return false; }

		
// Load up links in admin bar so theme is edit
function semperfi_theme_options_add_page() {
    add_theme_page(__('Theme Information', 'localize_alocalize_semperfi'), __('Theme Information', 'localize_localize_semperfi'), 'edit_theme_options', 'theme_options', 'semperfi_theme_options_do_page');}


// Load up the Localizer so that the theme can be translated
load_theme_textdomain( 'semperfi_localizer', TEMPLATEPATH.'/language' );


// Adds a meta box to the post editing screen
add_action( 'add_meta_boxes', 'prfx_custom_meta' );
function prfx_custom_meta() {
    add_meta_box( 'prfx_meta', __( 'Featured Background', 'localize_semperfi' ), 'prfx_meta_callback', 'post', 'side' );
    add_meta_box( 'prfx_meta', __( 'Featured Background', 'localize_semperfi' ), 'prfx_meta_callback', 'page', 'side' ); }


// Outputs the content of the meta box
function prfx_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
	if (!empty($prfx_stored_meta['featured-background'][0]) ) $featured_background = $prfx_stored_meta['featured-background'][0];
    ?>

	<p>
	<label for="featured-background" class="prfx-row-title" style="text-align:justify;">The ideal image size is smaller than 400kb and a resolution around 1920 by 1080 pixels.<br><br></label>
	<img id="theimage" src='<?php if (empty($featured_background)) { echo get_template_directory_uri() . '/images/nothing_found.jpg';} else {echo $featured_background;} ?>' style="box-shadow:0 0 .05em rgba(19,19,19,.5); height:auto; width:100%;"/>
		<input type="text" name="featured-background" id="featured-background" value="<?php if ( isset ( $featured_background ) ) echo $featured_background; ?>" style="margin:0 0 .5em; width:100%;" />
		<input type="button" id="featured-background-button" class="button" value="<?php _e( 'Choose or Upload an Image', 'localize_semperfi' )?>" style="margin:0 0 .25em; width:100%;" />
	</p> <?php }


// Loads the image management javascript
add_action( 'admin_enqueue_scripts', 'enqueue_featured_background' );

function enqueue_featured_background() {
	global $typenow;
    if(($typenow == 'post' ) || ($typenow == 'page' )) {

        // This function loads in the required files for the media manager.
        wp_enqueue_media();

        // Register, localize and enqueue our custom JS.
        wp_register_script( 'featured-background', get_template_directory_uri() . '/js/featured-background.js', array( 'jquery' ), '1', true );
        wp_localize_script( 'featured-background', 'featured_background',
            array(
                'title'     => 'Upload or choose an image for the Featured Background',
                'button'    => 'Use as Featured Background') );
        wp_enqueue_script( 'featured-background' ); } }

// Saves the custom meta input
add_action( 'save_post', 'prfx_meta_save' );
function prfx_meta_save( $post_id ) {
 
    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';
 
    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return; }
	
	// Checks for input and saves if needed
	if( isset( $_POST[ 'featured-background' ] ) ) {
    	update_post_meta( $post_id, 'featured-background', $_POST[ 'featured-background' ] ); } }

// Sets up the Customize.php for Semper Fi (More to come)
function semperfi_customize($wp_customize) {

	// Before we begin let's create a textarea input
	class semperfi_Customize_Textarea_Control extends WP_Customize_Control {
    
		public $type = 'textarea';
	 
		public function render_content() { ?>
			<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<textarea rows="1" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label> <?php } }

	// Create an Array with a ton of google fonts	
	$google_font_array = array(
        'Default'				=> 'Default',
        'Abel'					=> 'Abel',
        'Abril+Fatface'			=> 'Abril+Fatface',
        'Aclonica'				=> 'Aclonica',
        'Actor'					=> 'Actor',
        'Adamina'				=> 'Adamina',
        'Aldrich'				=> 'Aldrich',
        'Alice'					=> 'Alice',
        'Alike'					=> 'Alike',
        'Alike+Angular'			=> 'Alike+Angular',
        'Allan:700'				=> 'Allan:700',
        'Allerta'				=> 'Allerta',
        'Allerta+Stencil'		=> 'Allerta+Stencil',
        'Amaranth'				=> 'Amaranth',
        'Amatic+SC'				=> 'Amatic+SC',
        'Andada'				=> 'Andada',
        'Andika'				=> 'Andika',
        'Annie+Use+Your+Telescope' => 'Annie+Use+Your+Telescope',
        'Anonymous+Pro'			=> 'Anonymous+Pro',
        'Antic'					=> 'Antic',
        'Anton'					=> 'Anton',
        'Arapey'				=> 'Arapey',
        'Architects+Daughter'	=> 'Architects+Daughter',
        'Arimo'					=> 'Arimo',
        'Artifika'				=> 'Artifika',
        'Arvo'					=> 'Arvo',
        'Asset'					=> 'Asset',
        'Astloch'				=> 'Astloch',
        'Atomic+Age'			=> 'Atomic+Age',
        'Aubrey'				=> 'Aubrey',
        'Bangers'				=> 'Bangers',
        'Bentham'				=> 'Bentham',
        'Bevan'					=> 'Bevan',
        'Bigshot+One'			=> 'Bigshot+One',
        'Bitter'				=> 'Bitter',
        'Black+Ops+One'			=> 'Black+Ops+One',
        'Bowlby+One'			=> 'Bowlby+One',
        'Bowlby+One+SC'			=> 'Bowlby+One+SC',
        'Brawler'				=> 'Brawler',
        'Buda:300'				=> 'Buda:300',
        'Butcherman+Caps'		=> 'Butcherman+Caps',
        'Cabin'					=> 'Cabin',
        'Cabin+Sketch'			=> 'Cabin+Sketch',
        'Calligraffitti'		=> 'Calligraffitti',
        'Candal'				=> 'Candal',
        'Cantarell'				=> 'Cantarell',
        'Cardo'					=> 'Cardo',
        'Carme'					=> 'Carme',
        'Carter+One'			=> 'Carter+One',
        'Caudex'				=> 'Caudex',
        'Cedarville+Cursive'	=> 'Cedarville+Cursive',
        'Changa+One'			=> 'Changa+One',
        'Cherry+Cream+Soda'		=> 'Cherry+Cream+Soda',
        'Chewy'					=> 'Chewy',
        'Chivo'					=> 'Chivo',
        'Coda'					=> 'Coda',
        'Coda+Caption:800'		=> 'Coda+Caption:800',
        'Comfortaa'				=> 'Comfortaa',
        'Coming+Soon'			=> 'Coming+Soon',
        'Contrail+One'			=> 'Contrail+One',
        'Convergence'			=> 'Convergence',
        'Cookie'				=> 'Cookie',
        'Copse'					=> 'Copse',
        'Corben'				=> 'Corben',
        'Cousine'				=> 'Cousine',
        'Coustard'				=> 'Coustard',
        'Covered+By+Your+Grace' => 'Covered+By+Your+Grace',
        'Creepster+Caps'		=> 'Creepster+Caps',
        'Crimson+Text'			=> 'Crimson+Text',
        'Crushed'				=> 'Crushed',
        'Crafty+Girls'			=> 'Crafty+Girls',
        'Cuprum'				=> 'Cuprum',
        'Damion'				=> 'Damion',
        'Dancing+Script'		=> 'Dancing+Script',
        'Dawning+of+a+New+Day'	=> 'Dawning+of+a+New+Day',
        'Days+One'				=> 'Days+One',
        'Delius'				=> 'Delius',
        'Delius+Swash+Caps'		=> 'Delius+Swash+Caps',
        'Delius+Unicase'		=> 'Delius+Unicase',
        'Didact+Gothic'			=> 'Didact+Gothic',
        'Dorsa'					=> 'Dorsa',
        'Droid+Sans'			=> 'Droid+Sans',
        'Droid+Sans+Mono'		=> 'Droid+Sans+Mono',
        'Droid+Serif'			=> 'Droid+Serif',
        'Eater+Caps'			=> 'Eater+Caps',
        'EB+Garamond'			=> 'EB+Garamond',
        'Expletus+Sans'			=> 'Expletus+Sans',
        'Fanwood+Text'			=> 'Fanwood+Text',
        'Federant'				=> 'Federant',
        'Federo'				=> 'Federo',
        'Fjord+One'				=> 'Fjord+One',
        'Fontdiner+Swanky'		=> 'Fontdiner+Swanky',
        'Forum'					=> 'Forum',
        'Francois+One'			=> 'Francois+One',
        'Gentium+Basic'			=> 'Gentium+Basic',
        'Gentium+Book+Basic'	=> 'Gentium+Book+Basic',
        'Geo'					=> 'Geo',
        'Geostar'				=> 'Geostar',
        'Geostar+Fill'			=> 'Geostar+Fill',
        'Give+You+Glory'		=> 'Give+You+Glory',
        'Gloria+Hallelujah'		=> 'Gloria+Hallelujah',
        'Goblin+One'			=> 'Goblin+One',
        'Gochi+Hand'			=> 'Gochi+Hand',
        'Goudy+Bookletter+1911' => 'Goudy+Bookletter+1911',
        'Gravitas+One'			=> 'Gravitas+One',
        'Gruppo'				=> 'Gruppo',
        'Hammersmith+One'		=> 'Hammersmith+One',
        'Holtwood+One+SC'		=> 'Holtwood+One+SC',
        'Homemade+Apple'		=> 'Homemade+Apple',
        'IM+Fell+Double+Pica'	=> 'IM+Fell+Double+Pica',
        'IM+Fell+Double+Pica+SC' => 'IM+Fell+Double+Pica+SC',
        'IM+Fell+DW+Pica'		=> 'IM+Fell+DW+Pica',
        'IM+Fell+DW+Pica+SC'	=> 'IM+Fell+DW+Pica+SC',
        'IM+Fell+English'		=> 'IM+Fell+English',
        'IM+Fell+English+SC'	=> 'IM+Fell+English+SC',
        'IM+Fell+French+Canon'	=> 'IM+Fell+French+Canon',
        'IM+Fell+French+Canon+SC' => 'IM+Fell+French+Canon+SC',
        'IM+Fell+Great+Primer'	=> 'IM+Fell+Great+Primer',
        'IM+Fell+Great+Primer+SC' => 'IM+Fell+Great+Primer+SC',
        'Inconsolata'			=> 'Inconsolata',
        'Indie+Flower'			=> 'Indie+Flower',
        'Irish+Grover'			=> 'Irish+Grover',
        'Istok+Web'				=> 'Istok+Web',
        'Jockey+One'			=> 'Jockey+One',
        'Josefin+Sans'			=> 'Josefin+Sans',
        'Josefin+Slab'			=> 'Josefin+Slab',
        'Judson'				=> 'Judson',
        'Julee'					=> 'Julee',
        'Jura'					=> 'Jura',
        'Just+Another+Hand'		=> 'Just+Another+Hand',
        'Just+Me+Again+Down+Here' => 'Just+Me+Again+Down+Here',
        'Kameron'				=> 'Kameron',
        'Kelly+Slab'			=> 'Kelly+Slab',
        'Kenia'					=> 'Kenia',
        'Kranky'				=> 'Kranky',
        'Kreon'					=> 'Kreon',
        'Kristi'				=> 'Kristi',
        'La+Belle+Aurore'		=> 'La+Belle+Aurore',
        'Lancelot'				=> 'Lancelot',
        'Lato'					=> 'Lato',
        'League+Script'			=> 'League+Script',
        'Leckerli+One'			=> 'Leckerli+One',
        'Lekton'				=> 'Lekton',
        'Limelight'				=> 'Limelight',
        'Linden+Hill'			=> 'Linden+Hill',
        'Lobster'				=> 'Lobster',
        'Lobster+Two'			=> 'Lobster+Two',
        'Lora'					=> 'Lora',
        'Love+Ya+Like+A+Sister' => 'Love+Ya+Like+A+Sister',
        'Loved+by+the+King'		=> 'Loved+by+the+King',
        'Luckiest+Guy'			=> 'Luckiest+Guy',
        'Maiden+Orange'			=> 'Maiden+Orange',
        'Mako'					=> 'Mako',
        'Marck+Script'			=> 'Marck+Script',
        'Marvel'				=> 'Marvel',
        'Mate'					=> 'Mate',
        'Mate+SC'				=> 'Mate+SC',
        'Maven+Pro'				=> 'Maven+Pro',
        'Meddon'				=> 'Meddon',
        'MedievalSharp'			=> 'MedievalSharp',
        'Megrim'				=> 'Megrim',
        'Merienda+One'			=> 'Merienda+One',
        'Merriweather'			=> 'Merriweather',
        'Metrophobic'			=> 'Metrophobic',
        'Michroma'				=> 'Michroma',
        'Miltonian'				=> 'Miltonian',
        'Miltonian+Tattoo'		=> 'Miltonian+Tattoo',
        'Molengo'				=> 'Molengo',
        'Monofett'				=> 'Monofett',
        'Monoton'				=> 'Monoton',
        'Montez'				=> 'Montez',
        'Modern+Antiqua'		=> 'Modern+Antiqua',
        'Mountains+of+Christmas' => 'Mountains+of+Christmas',
        'Muli'					=> 'Muli',
        'Neucha'				=> 'Neucha',
        'Neuton'				=> 'Neuton',
        'News+Cycle'			=> 'News+Cycle',
        'Nixie+One'				=> 'Nixie+One',
        'Nobile'				=> 'Nobile',
        'Nosifer+Caps'			=> 'Nosifer+Caps',
        'Nothing+You+Could+Do'	=> 'Nothing+You+Could+Do',
        'Nova+Cut'				=> 'Nova+Cut',
        'Nova+Flat'				=> 'Nova+Flat',
        'Nova+Mono'				=> 'Nova+Mono',
        'Nova+Oval'				=> 'Nova+Oval',
        'Nova+Script'			=> 'Nova+Script',
        'Nova+Slim'				=> 'Nova+Slim',
        'Nova+Round'			=> 'Nova+Round',
        'Nova+Square'			=> 'Nova+Square',
        'Numans'				=> 'Numans',
        'Nunito'				=> 'Nunito',
        'Old+Standard+TT'		=> 'Old+Standard+TT',
        'Open+Sans'				=> 'Open+Sans',
        'Open+Sans+Condensed:300' => 'Open+Sans+Condensed:300',
        'Orbitron'				=> 'Orbitron',
        'Oswald'				=> 'Oswald',
        'Over+the+Rainbow'		=> 'Over+the+Rainbow',
        'Ovo'					=> 'Ovo',
        'Pacifico'				=> 'Pacifico',
        'Play'					=> 'Play',
        'Passero+One'			=> 'Passero+One',
        'Patrick+Hand'			=> 'Patrick+Hand',
        'Paytone+One'			=> 'Paytone+One',
        'Permanent+Marker'		=> 'Permanent+Marker',
        'Petrona'				=> 'Petrona',
        'Philosopher'			=> 'Philosopher',
        'Pinyon+Script'			=> 'Pinyon+Script',
        'Playfair+Display'		=> 'Playfair+Display',
        'Podkova'				=> 'Podkova',
        'Poller+One'			=> 'Poller+One',
        'Poly'					=> 'Poly',
        'Pompiere'				=> 'Pompiere',
        'Prata'					=> 'Prata',
        'Prociono'				=> 'Prociono',
        'PT+Sans'				=> 'PT+Sans',
        'PT+Sans+Caption'		=> 'PT+Sans+Caption',
        'PT+Sans+Narrow'		=> 'PT+Sans+Narrow',
        'PT+Serif'				=> 'PT+Serif',
        'PT+Serif+Caption'		=> 'PT+Serif+Caption',
        'Puritan'				=> 'Puritan',
        'Quattrocento'			=> 'Quattrocento',
        'Quattrocento+Sans'		=> 'Quattrocento+Sans',
        'Questrial'				=> 'Questrial',
        'Quicksand'				=> 'Quicksand',
        'Radley'				=> 'Radley',
        'Raleway:100'			=> 'Raleway:100',
        'Rammetto+One'			=> 'Rammetto+One',
        'Rancho'				=> 'Rancho',
        'Rationale'				=> 'Rationale',
        'Redressed'				=> 'Redressed',
        'Reenie+Beanie'			=> 'Reenie+Beanie',
        'Rock+Salt'				=> 'Rock+Salt',
        'Rochester'				=> 'Rochester',
        'Rokkitt'				=> 'Rokkitt',
        'Rosario'				=> 'Rosario',
        'Ruslan+Display'		=> 'Ruslan+Display',
        'Salsa'					=> 'Salsa',
        'Sancreek'				=> 'Sancreek',
        'Sansita+One'			=> 'Sansita+One',
        'Satisfy'				=> 'Satisfy',
        'Schoolbell'			=> 'Schoolbell',
        'Shadows+Into+Light'	=> 'Shadows+Into+Light',
        'Shanti'				=> 'Shanti',
        'Short+Stack'			=> 'Short+Stack',
        'Sigmar+One'			=> 'Sigmar+One',
        'Six+Caps'				=> 'Six+Caps',
        'Slackey'				=> 'Slackey',
        'Smokum'				=> 'Smokum',
        'Smythe'				=> 'Smythe',
        'Sniglet:800'			=> 'Sniglet:800',
        'Snippet'				=> 'Snippet',
        'Sorts+Mill+Goudy'		=> 'Sorts+Mill+Goudy',
        'Special+Elite'			=> 'Special+Elite',
        'Spinnaker'				=> 'Spinnaker',
        'Stardos+Stencil'		=> 'Stardos+Stencil',
        'Sue+Ellen+Francisco'	=> 'Sue+Ellen+Francisco',
        'Supermercado+One'		=> 'Supermercado+One',
        'Sunshiney'				=> 'Sunshiney',
        'Swanky+and+Moo+Moo'	=> 'Swanky+and+Moo+Moo',
        'Syncopate'				=> 'Syncopate',
        'Tangerine'				=> 'Tangerine',
        'Tenor+Sans'			=> 'Tenor+Sans',
        'Terminal+Dosis'		=> 'Terminal+Dosis',
        'The+Girl+Next+Door'	=> 'The+Girl+Next+Door',
        'Tienne'				=> 'Tienne',
        'Tinos'					=> 'Tinos',
        'Tulpen+One'			=> 'Tulpen+One',
        'Ubuntu'				=> 'Ubuntu',
        'Ubuntu+Condensed'		=> 'Ubuntu+Condensed',
        'Ubuntu+Mono'			=> 'Ubuntu+Mono',
        'Ultra'					=> 'Ultra',
        'UnifrakturCook:700'	=> 'UnifrakturCook:700',
        'UnifrakturMaguntia'	=> 'UnifrakturMaguntia',
        'Unkempt'				=> 'Unkempt',
        'Unna'					=> 'Unna',
        'Varela'				=> 'Varela',
        'Varela+Round'			=> 'Varela+Round',
        'Vast+Shadow'			=> 'Vast+Shadow',
        'Vidaloka'				=> 'Vidaloka',
        'Vibur'					=> 'Inconsolata',
        'Volkhov'				=> 'Volkhov',
        'Vollkorn'				=> 'Vollkorn',
        'Voltaire'				=> 'Voltaire',
        'VT323'					=> 'VT323',
        'Waiting+for+the+Sunrise' => 'Waiting+for+the+Sunrise',
        'Wallpoet'				=> 'Wallpoet',
        'Walter+Turncoat'		=> 'Walter+Turncoat',
        'Wire+One'				=> 'Wire+One',
        'Yanone+Kaffeesatz'		=> 'Yanone+Kaffeesatz',
        'Yellowtail'			=> 'Yellowtail',
        'Yeseva+One'			=> 'Yeseva+One',
        'Zeyada'				=> 'Zeyada');
    
    // Add in all the settings with an array
    $set_semperfi_theme_option_defaults = array(
        'author_setting'			    => 'on',
        'backgroundcolor_setting'       => '#b4b09d',
        'bodyfontstyle_setting'	        => 'Default',
        'backgroundpaper_setting'       => 'clean',
        'backgroundsize_setting'        => 'auto',
        'bannerimage_setting'           => '',
        'border_setting'			    => '3px',
        'bordercolor_setting'			=> '#4a4646',
        'commentsclosed_setting'        => 'on',
        'comments_setting'			    => 'both',
        'contentbackground_setting'     => '.80',
        'display_date_setting'          => 'on',
        'display_excerpt_setting'       => 'off',
        'display_post_title_setting'    => 'on',
        'dropcolor_setting'			    => '#e0dbce',
        'dropcolorhover_setting'        => '#3e5a21',
        'facebook_setting'              => __('The url link goes in here.', 'localize_semperfi'),
        'fontcolor_setting'			    => '#000000',
        'fontsizeadjust_setting'        => '100',
        'footer_text_setting'           => __('Replace the text in the footer', 'localize_semperfi'),
        'google_webmaster_tool_setting' => 'For example mine is "gN9drVvyyDUFQzMSBL8Y8-EttW1pUDtnUypP-331Kqh"',
        'google_analytics_setting'      => 'For example mine is "UA-9335180-X"',
        'google_plus_setting'           => __('The url link goes in here.', 'localize_semperfi'),
        'headerfontstyle_setting'       => 'Default',
        'headerspacing_setting'	        => '18',
        'header_image_width_setting'    => '20',
        'instagram_setting'        => __('The url link goes in here.', 'localize_semperfi'),
        'linkcolor_setting'	            => '#dc1111',
        'linkcolorhover_setting'        => '#555555',
        'menu_setting'                  => 'standard',
        'navcolor_setting'              => '#b19f70',
        'navcolorhover_setting'         => '#cccccc',
        'navi_search_setting'           => 'off',
        'previousnext_setting'		    => 'both',
        'removefooter_setting'          => 'visible',
        'sidebarbackground_setting' 	=> '.50',
        'sidebarcolor_setting'		    => '#000000',
        'soundcloud_setting'            => __('The url link goes in here.', 'localize_semperfi'),
        'taglinecolor_setting'		    => '#3e5a21',
        'taglinefontstyle_setting'      => 'Default',
        'tagline_rotation_setting'      => '0.00',
        'titlecolor_setting'            => '#e0dbce',
        'title_size_setting'            => '4.0',
        'titlefontstyle_setting'        => 'Default',
        'twitter_setting'               => __('The url link goes in here.', 'localize_semperfi'),
        'vimeo_setting'                 => __('The url link goes in here.', 'localize_semperfi'),
        'youtube_setting'               => __('The url link goes in here.', 'localize_semperfi'));
    
    // Create the Setting
    foreach($set_semperfi_theme_option_defaults as $setting => $value) {
            $wp_customize->add_setting( $setting , array('default' => $value )); }
    
    // Set the setting if it is some how blank
    foreach($set_semperfi_theme_option_defaults as $setting => $value) {
        if ( get_theme_mod($setting) == '' ) set_theme_mod($setting , $value); }
    
    // The Standard Sections for Theme Custimizer
	$wp_customize->add_section( 'meta_section', array(
        'title'					=> __('Meta', 'localize_semperfi'),
        'priority'				=> 1, ));

	$wp_customize->add_section( 'header_section', array(
        'title'				=> __('Header', 'localize_semperfi'),
		'priority'			=> 26, ));

	$wp_customize->add_section( 'nav', array(
        'title'				=> __('Menu', 'localize_semperfi'),
		'priority'			=> 27, ));

	$wp_customize->add_section( 'background_image', array(
        'title'				=> __('Background', 'localize_semperfi'),
		'priority'			=> 28, ));

	$wp_customize->add_section( 'content_section', array(
        'title'				=> __('Content', 'localize_semperfi'),
        'priority'			=> 29, ));

	$wp_customize->add_section( 'sidebar_section', array(
        'title'				=> __('Sidebar', 'localize_semperfi'),
        'priority'			=> 30, ));

	$wp_customize->add_section( 'links_section', array(
        'title'				=> __('Links', 'localize_semperfi'),
        'priority'			=> 32, ));

	// Remove the Section Colors for the Sake of making Sense
	$wp_customize->remove_section( 'colors');

	// Background needed to be moved to to the Background Section
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'background_color', array(
		'label'				=> __('Background Color', 'localize_semperfi'),
		'section'			=> 'background_image', )));

	// Change Site Title Color
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'titlecolor_control', array(
		'label'				=> __('Site Title Color - #e0dbce', 'localize_semperfi'),
		'section'			=> 'title_tagline',
		'settings'			=> 'titlecolor_setting', )));
    
    // Control the Size of the site Title and Slogan size
    $wp_customize->add_control('title_size_control', array(
		'label'				=> __('Title Font Size', 'localize_semperfi'),
		'priority'			=> 1,
		'section'			=> 'header_section',
		'settings'			=> 'title_size_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'6.0'			=> '6.0em',
			'5.8'			=> '5.8em',
			'5.6'			=> '5.6em',
			'5.4'			=> '5.4em',
			'5.2'			=> '5.2em',
			'5.0'			=> '5.0em',
			'4.8'			=> '4.8em',
			'4.6'			=> '4.6em',
			'4.4'			=> '4.4em',
			'4.2'			=> '4.2em',
			'4.0'			=> '4.0em',
			'3.8'			=> '3.8em',
			'3.6'			=> '3.6em',
			'3.4'			=> '3.4em',
			'3.2'			=> '3.2em',
			'3.0'			=> '3.0em',
			'2.8'			=> '2.8em', ), ));

	// Change Tagline Color
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'taglinecolor_control', array(
		'label'				=> __('Site Title Color - #066ba0', 'localize_semperfi'),
		'section'			=> 'title_tagline',
		'settings'			=> 'taglinecolor_setting', )));
    
    // Rotation of The Tagline
    $wp_customize->add_control('tagline_rotation_control', array(
		'label'				=> __('Tagline Rotation', 'localize_semperfi'),
		'priority'			=> 2,
		'section'			=> 'header_section',
		'settings'			=> 'tagline_rotation_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'-2.00'			=> '-2.00&deg;',
			'-1.75'			=> '-1.75&deg;',
			'-1.50'			=> '-1.50&deg;',
			'-1.25'			=> '-1.25&deg;',
			'-1.00'			=> '-1.00&deg;',
			'-0.75'			=> '-0.75&deg;',
			'-0.50'			=> '-0.50&deg;',
			'-0.25'			=> '-0.25&deg;',
			'0.00'			=> '0.00&deg;',
			'0.25'			=> '0.25&deg;',
			'0.50'			=> '0.50&deg;',
			'0.75'			=> '0.75&deg;',
			'1.00'			=> '1.00&deg;', ), ));

	// Choose the Different Images for the Banner
	$wp_customize->add_control('themename_color_scheme', array(
		'label'				=> __('Banner Background', 'localize_semperfi'),
		'priority'			=> 1,
		'section'			=> 'header_section',
		'settings'			=> 'bannerimage_setting',
		'type'				=> 'select',
		'choices'			=> array(
			''	=> __('Marble (Default)', 'localize_semperfi'),
			'purple.png'	=> __('Purple', 'localize_semperfi'),
			'blue.png'		=> __('Blue', 'localize_semperfi'),
			'green.png'		=> __('Green', 'localize_semperfi'), ), ));

	// Upload and Customization for the Banner and Header Options
	$wp_customize->add_control('menu_control', array(
		'label'				=> __('Menu Display Options', 'localize_semperfi'),
		'priority'			=> 6,
		'section'			=> 'header_section',
		'settings'			=> 'menu_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'standard'		=> __('Standard (Default)', 'localize_semperfi'),
			'notitle'		=> __('No Title', 'localize_semperfi'),
			'bottom'		=> __('Moves Menu To Bottom', 'localize_semperfi'), ), ));
			
	// Turn the Search bar in the navigation on or off
	$wp_customize->add_control( 'navi_search_control', array(
		'label'					=> __('Search bar in navigaton', 'localize_semperfi'),
		'section'				=> 'nav',
		'settings'				=> 'navi_search_setting',
		'type'					=> 'select',
		'choices'				=> array(
			'off'				=> __('Do not display search', 'localize_semperfi'),
			'on'				=> __('Display the search', 'localize_semperfi'),), ));
			
	// Turn the date / time on post on or off
	$wp_customize->add_control( 'display_date_control', array(
		'section'				=> 'content_section',
		'label'					=> __('Display the date', 'localize_semperfi'),
		'settings'				=> 'display_date_setting',
		'type'					=> 'select',
		'choices'				=> array(
			'on'				=> __('Display the dates', 'localize_semperfi'),
			'off'				=> __('Do not display dates', 'localize_semperfi'),), ));
			
	// Add Facebook Icon to the navigation
	$wp_customize->add_control( new semperfi_Customize_Textarea_Control( $wp_customize, 'facebook_control', array(
		'label'				=> __('Facebook icon in the Menu', 'localize_semperfi'),
		'priority'			=> 50,
		'section'			=> 'nav',
		'settings'			=> 'facebook_setting', )));
			
	// Add Twitter Icon to the navigation
	$wp_customize->add_control( new semperfi_Customize_Textarea_Control( $wp_customize, 'twitter_control', array(
		'label'				=> __('Twitter icon in the Menu', 'localize_semperfi'),
		'priority'			=> 51,
		'section'			=> 'nav',
		'settings'			=> 'twitter_setting', )));
			
	// Add Instagram Icon to the navigation
	$wp_customize->add_control( new semperfi_Customize_Textarea_Control( $wp_customize, 'instagram_plus_control', array(
		'label'				=> __('Instagram icon in the Menu', 'localize_semperfi'),
		'priority'			=> 52,
		'section'			=> 'nav',
		'settings'			=> 'instagram_setting', )));
			
	// Add Google+ Icon to the navigation
	$wp_customize->add_control( new semperfi_Customize_Textarea_Control( $wp_customize, 'google_plus_control', array(
		'label'				=> __('Google Plus icon in the Menu', 'localize_semperfi'),
		'priority'			=> 52,
		'section'			=> 'nav',
		'settings'			=> 'google_plus_setting', )));
			
	// Add YouTube Icon to the navigation
	$wp_customize->add_control( new semperfi_Customize_Textarea_Control( $wp_customize, 'youtube_control', array(
		'label'				=> 'Youtube icon in the Menu',
		'priority'			=> 54,
		'section'			=> 'nav',
		'settings'			=> 'youtube_setting', )));
			
	// Add Vimeo Icon to the navigation
	$wp_customize->add_control( new semperfi_Customize_Textarea_Control( $wp_customize, 'vimeo_control', array(
		'label'				=> __('Vimeo icon in the Menu', 'localize_semperfi'),
		'priority'			=> 55,
		'section'			=> 'nav',
		'settings'			=> 'vimeo_setting', )));
			
	// Add Soundcloud Icon to the navigation
	$wp_customize->add_control( new semperfi_Customize_Textarea_Control( $wp_customize, 'soundcloud_control', array(
		'label'				=> __('Soundcloud icon in the Menu', 'localize_semperfi'),
		'priority'			=> 56,
		'section'			=> 'nav',
		'settings'			=> 'soundcloud_setting', )));	
			
	// Adjust the Space Between the Top of the Page and Content
	$wp_customize->add_control( 'titlefontstyle_control', array(
		'label'					=> __('Google Webfonts Site Title', 'localize_semperfi'),
		'priority'				=> 10,
		'section'				=> 'title_tagline',
		'settings'				=> 'titlefontstyle_setting',
		'type'					=> 'select',
		'choices'				=> $google_font_array, ));
			
	// Adjust the Space Between the Top of the Page and Content
	$wp_customize->add_control( 'taglinefontstyle_control', array(
		'label'					=> __('Google Webfonts Tagline', 'localize_semperfi'),
		'priority'				=> 11,
		'section'				=> 'title_tagline',
		'settings'				=> 'taglinefontstyle_setting',
		'type'					=> 'select',
		'choices'				=> $google_font_array, ));

	// Settings for the Previous & Next Post Link
	$wp_customize->add_control( 'previousnext_control', array(
		'label'				=> __('Previous & Next Links After Content', 'localize_semperfi'),
		'section'			=> 'content_section',
		'settings'			=> 'previousnext_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'both'			=> __('Both Pages & Posts', 'localize_semperfi'),
			'single'	    => __('Only Posts', 'localize_semperfi'),
			'page'			=> __('Only Pages', 'localize_semperfi'),
			'neither'		=> __('Neither', 'localize_semperfi'), ), ));

	// Adjust the Space Between the Top of the Page and Content
	$wp_customize->add_control( 'headerspacing_control', array(
		'label'				=> __('Spacing Between Top and Content', 'localize_semperfi'),
		'priority'			=> 90,
		'section'			=> 'header_section',
		'settings'			=> 'headerspacing_setting',
		'type'				=> 'select',
		'choices'			=> array(
			'26'			=> '26em',
			'24'			=> '24em',
			'22'			=> '22em',
			'20'			=> '20em',
			'18'			=> '18em Default',
			'16'			=> '16em',
			'14'			=> '14em',
			'12'			=> '12em',
			'10'			=> '10em',
			'9'				=> '9em',
			'8'				=> '8em',
			'7'				=> '7em',
			'6'				=> '6em',
			'5'				=> '5em',
			'4'				=> '4em',
			'3'				=> '3em',
			'2'				=> '2em',
			'1'				=> '1em',
			'0'				=> '0em',), ));
			
	// Change up the type of paper in the background
	$wp_customize->add_control( 'backgroundpaper_control', array(
		'section'				=> 'content_section',
		'label'					=> 'Background Paper Image',
		'settings'				=> 'backgroundpaper_setting',
		'type'					=> 'select',
		'choices'				=> array(
			'clean'				=> __('Clean but Used (Default)', 'localize_semperfi'),
			'peppered'			=> __('Peppered', 'localize_semperfi'),
			'vintage'			=> __('Vintage', 'localize_semperfi'),
			'canvas'			=> __('Heavy Canvas', 'localize_semperfi'),), ));

	// Add the option to use the CSS3 property Background-size
	$wp_customize->add_control( 'backgroundsize_control', array(
		'label'				=> __('Background Size', 'localize_semperfi'),
		'section'			=> 'background_image',
		'settings'			=> 'backgroundsize_setting',
		'priority'			=> 10,
		'type'				=> 'select',
		'choices'			=> array(
			'auto'			=> __('Auto (Default)', 'localize_semperfi'),
			'contain'		=> __('Contain', 'localize_semperfi'),
			'cover'			=> __('Cover', 'localize_semperfi'),), ));
			
	// Comments Choice
	$wp_customize->add_control( 'comments_control', array(
		'section'				=> 'content_section',
		'label'					=> 'Options for Displaying Comments',
		'settings'				=> 'comments_setting',
		'type'					=> 'select',
		'choices'				=> array(
			'both'	            => __('Comments on both Pages & Posts', 'localize_semperfi'),
			'single'	        => __('Comments only on Posts', 'localize_semperfi'),
			'page'				=> __('Comments only on Pages', 'localize_semperfi'),
			'none'				=> __('Comments completely Off', 'localize_semperfi'),), )); }

add_action('customize_register', 'semperfi_customize');

// Inject the Customizer Choices into the Theme
function semperfi_inline_css() {
		
        if ( ( get_theme_mod('titlefontstyle_setting') != 'Default') || (get_theme_mod('taglinefontstyle_setting') != 'Default') || (get_theme_mod('bodyfontstyle_setting') != 'Default') || (get_theme_mod('headerfontstyle_setting') != 'Default')) {
            echo '<!-- Custom Font Styles -->' . "\n";
            if (get_theme_mod('titlefontstyle_setting') != 'Default') {echo "<link href='http://fonts.googleapis.com/css?family=" . get_theme_mod('titlefontstyle_setting') . "' rel='stylesheet' type='text/css'>"  . "\n"; }
            if (get_theme_mod('taglinefontstyle_setting') != 'Default') {	echo "<link href='http://fonts.googleapis.com/css?family=" . get_theme_mod('taglinefontstyle_setting') . "' rel='stylesheet' type='text/css'>"  . "\n"; }
            if (get_theme_mod('bodyfontstyle_setting') != 'Default') {	echo "<link href='http://fonts.googleapis.com/css?family=" . get_theme_mod('bodyfontstyle_setting') . "' rel='stylesheet' type='text/css'>"  . "\n"; }
            if (get_theme_mod('headerfontstyle_setting') != 'Default') {	echo "<link href='http://fonts.googleapis.com/css?family=" . get_theme_mod('headerfontstyle_setting') . "' rel='stylesheet' type='text/css'>"  . "\n"; }
            echo '<!-- End Custom Fonts -->' . "\n\n";}

		echo '<!-- Custom CSS Styles -->' . "\n";
        echo '<style type="text/css" media="screen">' . "\n";
        if (is_page() || is_single()) $featured_background = get_post_meta( get_queried_object_ID(), 'featured-background', true ); if (!empty($featured_background)) echo '   body, body.custom-background {background-image:url(' . $featured_background . '); background-size:cover;}' . "\n";
		if ( get_theme_mod('backgroundsize_setting') != 'auto' ) echo '	body, body.custom-background {background-size:' . get_theme_mod('backgroundsize_setting') . ';}' . "\n";
		if ( (get_theme_mod('backgroundpaper_setting') != 'auto') && (get_theme_mod('backgroundpaper_setting') != '') )echo '	.content {background-image:url(' . get_template_directory_uri() . '/images/' . get_theme_mod('backgroundpaper_setting') . '.png);}' . "\n";
		if ( get_theme_mod('titlecolor_setting') != '#e0dbce' ) echo '	.header h1 a {color:' . get_theme_mod('titlecolor_setting') . ';}' . "\n";
		if ( get_theme_mod('taglinecolor_setting') != '#3e5a21' ) echo '	.header h1 i {color:' . get_theme_mod('taglinecolor_setting') . ';}' . "\n";
		if ( get_theme_mod('title_size_setting') != '4.0' ) echo '	.header h1 {font-size:' . get_theme_mod('title_size_setting') . 'em;}' . "\n";   
    
    
    
		if ( get_theme_mod('tagline_rotation_setting') != '-1.00' ) echo '	.header h1 i {-moz-transform:rotate(' . get_theme_mod('tagline_rotation_setting') . 'deg); transform:rotate(' . get_theme_mod('tagline_rotation_setting') . 'deg);}' . "\n";
		if ( get_theme_mod('bannerimage_setting') != '' ) echo '	.header {background: bottom url(' . get_template_directory_uri() . '/images/' . get_theme_mod('bannerimage_setting') .  ');}'. "\n";
		if ( get_theme_mod('headerspacing_setting') != '20' ) echo '	.spacing {height:' . get_theme_mod('headerspacing_setting') . 'em;}'. "\n";
		if ( get_theme_mod('menu_setting') == 'notitle' ) { echo '	.header {position: fixed;margin-top:0px;}' . "\n" . '	.admin-bar .header {margin-top:28px;}' . "\n" . '.header h1:first-child, .header h1:first-child i,  .header img:first-child {display: none;}' . "\n"; }
		if ( get_theme_mod('menu_setting') == 'bottom' ) { echo '	.header {position: fixed; bottom:0; top:auto;}' . "\n" . '	.header h1:first-child, .header h1:first-child i,  .header img:first-child {display: none;}' . "\n" . '.header li ul {bottom:2.78em; top:auto;}' . "\n";}
        if ( get_theme_mod('content_bg_setting') != '') { echo '   .content {background-image:url(' . get_theme_mod('content_bg_setting') . ');}' . "\n";}
    
		
		if ( get_theme_mod('titlefontstyle_setting') != 'Default' ) {
			$q = get_theme_mod('titlefontstyle_setting');
			$q = preg_replace('/[^a-zA-Z0-9]+/', ' ', $q);
		 	echo	"	.header h1 {font-family: '" . $q . "';}" . "\n"; }

		if ( get_theme_mod('taglinefontstyle_setting') != 'Default') {
			$x = get_theme_mod('taglinefontstyle_setting');
			$x = preg_replace('/[^a-zA-Z0-9]+/', ' ', $x);
			echo	"	.header h1 i {font-family: '" . $x . "';}" . "\n"; }

		echo '</style>' . "\n";
		echo '<!-- End Custom CSS -->' . "\n";
		echo "\n"; }

add_action('wp_head', 'semperfi_inline_css', 50);

//	A safe way of adding javascripts to a WordPress generated page
if (!function_exists('semperfi_js')) {
	function semperfi_js() {
        // JS at the bottom for fast page loading
        wp_enqueue_script('semperfi-menu-scrolling', get_template_directory_uri() . '/js/jquery.menu.scrolling.js', array('jquery'), '1.1', true);
        wp_enqueue_script('semperfi-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0', true);
        wp_enqueue_script('semperfi-doubletaptogo', get_template_directory_uri() . '/js/doubletaptogo.min.js', array('jquery'), '1.0', true); } }

if (!is_admin()) add_action('wp_enqueue_scripts', 'semperfi_js', 21);

// Add some CSS so I can Style the Theme Options Page
function semperfi_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style('semperfi-theme-options', get_template_directory_uri() . '/theme-options.css', false, '1.0');}

add_action('admin_print_styles-appearance_page_theme_options', 'semperfi_admin_enqueue_scripts');

// Create the Theme Information page (Theme Options)
function semperfi_theme_options_do_page() { ?>
 
    <div class="cover">

    <ul id="spacing"></ul>

    <div class="contain">
            
        <div id="header">
		
			<div class="themetitle">
				<a href="http://schwarttzy.com/shop/semper-fi/" target="_blank" ><h1><?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Name' ); ?></h1>
				<span>- v<?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Version' ); ?></span></a>
			</div>
            
            
			<div class="upgrade">
                <a href="http://schwarttzy.com/shop/semper-fi/" target="_blank" ><h2><?php _e('Upgrade to Semper Fi', 'localize_semperfi'); ?></h2></a>
            </div>
		
    	</div>
            
        <ul class="info_bar">
			<li><a href="#description"><?php _e('Description', 'localize_semperfi'); ?></a></li>
			<li><a href="#customizing"><?php _e('Customizing', 'localize_semperfi'); ?></a></li>
			<li><a href="#features"><?php _e('Features', 'localize_semperfi'); ?></a></li>
			<li><a href="#faq"><?php _e('FAQ', 'localize_semperfi'); ?></a></li>
			<!-- <li><a href="#screenshots"><?php _e('Screen Shots', 'localize_semperfi'); ?></a></li> -->
			<li><a href="#changelog"><?php _e('Changelog', 'localize_semperfi'); ?></a></li>
			<li><a href="#support"><?php _e('Support', 'localize_semperfi'); ?></a></li>
		</ul>
        
        <div id="main">
            
            <div id="customizing" class="information">
                <h3><?php _e('Customizing', 'localize_semperfi'); ?></h3>
                <p><?php _e('Basically all I have right now is <a href="https://www.youtube.com/watch?v=IU__-ipUxxc" target="_blank">this video</a> on YouTube. I know the video is for a different theme, but this will change soon. Also, I would embed the video, but regrettably people wiser than me have said that it will introduce security issues. In the future I plan to add stuff here, but for now I just need to get the theme approved.', 'localize_semperfi'); ?></p>
            </div>
            
            <div id="features" class="information">
                <h3><?php _e('Semper Fi Lite Features', 'localize_semperfi'); ?></h3>
                <ul>
                    <li><?php _e('100% Responsive WordPress Theme', 'localize_semperfi'); ?></li>
                    <li><?php _e('Clean and Beautiful Stylized HTML, CSS, JavaScript', 'localize_semperfi'); ?></li>
                    <li><?php _e('Change the site Title and Slogan Colors', 'localize_semperfi'); ?></li>
                    <li><?php _e('Control the rotation of the Slogan', 'localize_semperfi'); ?></li>
                    <li><?php _e('Upload Your Own Background Image', 'localize_semperfi'); ?></li>
                    <li><?php _e('Add a search bar to the menu', 'localize_semperfi'); ?></li>
                    <li><?php _e('Add Social icons to the menu bar', 'localize_semperfi'); ?></li>
                    <li><?php _e('Choose from one of four backgrounds', 'localize_semperfi'); ?></li>
                    <li><?php _e('Four Menu Banner Images to Choose From', 'localize_semperfi'); ?></li>
                    <li><?php _e('Control wether or not the "Previous" & "Next" shows', 'localize_semperfi'); ?></li>
                    <li><?php _e('Adjust the spacing between the top of the page and content', 'localize_semperfi'); ?></li>
                    <li><?php _e('Comments on Pages only, Posts only, Both, or Nones', 'localize_semperfi'); ?></li>
                    <li><?php _e('Featured Background Image unique to a post or page', 'localize_semperfi'); ?></li>
                    <li><?php _e("Choose from 100's of Google fonts for the Title and Slogan", 'localize_semperfi'); ?></li>
                </ul>
                <p><?php _e('Do not see a feature the theme needs? <a href="http://schwarttzy.com/contact-me/" target="_blank">Contact me</a> about it.', 'localize_semperfi'); ?></p>
                <h3><?php _e('Premium Semper Fi Features', 'localize_semperfi'); ?></h3>
                <ul>
                    <li><?php _e('Easily remove the footer with the link to my website', 'localize_semperfi'); ?></li>
                    <li><?php _e('Insert you own text and links in the footer', 'localize_semperfi'); ?></li>
                    <li><?php _e('Adjust the scaling of the entire website', 'localize_semperfi'); ?></li>
                    <li><?php _e('Change the standard text fonts', 'localize_semperfi'); ?></li>
                    <li><?php _e('Change the in page H1-6 font style', 'localize_semperfi'); ?></li>
                    <li><?php _e('Favicon on Your Website', 'localize_semperfi'); ?></li>
                    <li><?php _e('GoogleAnalytics & Webmaster Verificatio', 'localize_semperfi'); ?></li>
                    <li><?php _e('Change the Hyper Link Color on the page', 'localize_semperfi'); ?></li>
                    <li><?php _e('Change the Link Colors in the Menu', 'localize_semperfi'); ?></li>
                    <li><?php _e('Change the Font Color in the Content', 'localize_semperfi'); ?></li>
                    <li><?php _e('Upload Your Own Logo in either the Header or above Content', 'localize_semperfi'); ?></li>
                    <li><?php _e('Upload Your Own Custom Banner Image', 'localize_semperfi'); ?></li>
                    <li><?php _e('Add Text Shadow to links and non-linked text.', 'localize_semperfi'); ?></li>
                    <li><?php _e('More to come!', 'localize_semperfi'); ?></li>
                </ul>
            </div>
            
            <div id="faq" class="information">
                <h3><?php _e('FAQ', 'localize_semperfi'); ?></h3>
                <p><b><?php _e('How do I remove the "Good Old Fashioned Hand Written code by Eric J. Schwarz"', 'localize_semperfi'); ?></b></p>
                <p><?php _e('According to the WordPress.org I am allowed to include one credit link, which you can read about <a href="http://make.wordpress.org/themes/guidelines/guidelines-license-theme-name-credit-links-up-sell-themes/" target="_blank">here</a>. I use this link to spread the word about my coding skills in the hopes I will get some jobs. Anyway, you can dig through the code and remove it by hand but if you upgrade to the lastest version it will come right back. It is not really a big deal to do it by hand each time I release an update. However if you want to support my theme and get the Semper Fi upgrade, its just a simple "On or Off" option in the "Theme Customizer."', 'localize_semperfi'); ?></p>
                <p><b><?php _e('More FAQs coming soon!', 'localize_semperfi'); ?></b></p>
            </div>
            
            <!--- <div id="screenshots" class="information">
                <h3><?php _e('I will take some screen shots', 'localize_semperfi'); ?></h3>
            </div> -->
            
            <div id="changelog" class="information">
                <h3><?php _e('The Changelog', 'localize_semperfi'); ?></h3>
                <table>
                    <tbody>
                        <tr>
                            <th><?php _e('Version', 'localize_semperfi'); ?></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>15</th>
                            <td><?php _e('Fixed the issue with the title being worthless, unless you have an SEO plugin installed. Added instagram to the mix of social plugins.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>14</th>
                            <td><?php _e('Fixed the issues with Social Icons.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>13</th>
                            <td><?php _e('Added the ablity to remove the previous and next tag from posts and pages.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>11</th>
                            <td><?php _e('Changed site Title and Slogan to scale using CSS instead of jQuery code. Added an option to control the size of the Title and Slogan under in the "Theme Customizer" under "Header." Fixed the issues with featured backgrounds, and also added some jQuery to auto load the background image after making your choice.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>10</th>
                            <td><?php _e('Brought back missing features. Fixed scaling error. Added in the ablitiy to tilt the Slogan of the website. Cleaned up the customizer code. Organized the fonts alphabetically. Drop down menus should work great on touch screen devices. Some other odds and ends too.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>9</th>
                            <td><?php _e('The theme was completely rewritten from the ground up so that the code would be easier to manage, better written, and enable faster updates. It is a complete reset of the code, which all the old feature plus more.', 'localize_semperfi'); ?></td>
                        </tr>
                    </tbody>
                </table>
                <h3><?php _e('The Changelog Semper Fi Lite', 'localize_semperfi'); ?></h3>
                <table>
                    <tbody>
                        <tr>
                            <th><?php _e('Version', 'localize_semperfi'); ?></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>3.3</th>
                            <td><?php _e('Fixed the issue with updater problems.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>3.2</th>
                            <td><?php _e('Fixed the issue with the title being worthless, unless you have an SEO plugin installed. Added instagram to the mix of social plugins.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>3.1</th>
                            <td><?php _e('Fixed the issues with Social Icons.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>2.9</th>
                            <td><?php _e('Added the ablity to remove the previous and next tag from posts and pages.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>2.5</th>
                            <td><?php _e('Same thing as Version 11 Of Semper Fi.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>2.4</th>
                            <td><?php _e('Updated Semper Fi lite to use the new code that is cleaner, lighter, and faster. Also drop in some code to make drop down menus to be easier to use on mobile menus. Also added a feature to tilt the tag line.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>2.3</th>
                            <td><?php _e('The Theme Information page was changed to something more professional looking and easierto navigate. Fixed some issues with CSS problems with video not displaying correctly, wp-caption issues, etc. Added in the ablity to choose a differnet background image for a post or page.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>2.1</th>
                            <td><?php _e('Sorry about not updating as much lately I just do not have the money to spend the time on this theme as much as I would like too. Anyway, I added in editor CSS so that it easier to know what the text, photos, list, and any other HTML element will actually look like on the website. Social icon open up a new tab for browsing.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>1.9</th>
                            <td><?php _e('Forgot a bit of code in the CSS that would just waste bandwidth.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>1.7</th>
                            <td><?php _e('Added code to the theme so that search engines can understand when a post was published. Brought back featured images into individual posts and pages, but you have to enable from the theme customizer. Dropped some code I thought I would use but never got around to it. Finally I fixed the google analytics, not sure what happened, but it is back along with adding site verification.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>1.6</th>
                            <td><?php _e('Fixed the issue where comments would not display.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>1.5</th>
                            <td><?php _e('Fixed an issue with comments, SEO plugins, and add complete control over commenting.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>1.4</th>
                            <td><?php _e('Minor fixes that show up in the header the theme options are blank.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>1.3</th>
                            <td><?php _e('Included Google Web Fonts for the Title, Slogan, Menu, Post Title, and Content. I also cleaned up the "Theme Customizer" menu so that it makes more sense.', 'localize_semperfi'); ?></td>
                        </tr>
                        <tr>
                            <th>.9</th>
                            <td><?php _e('Just a mix up in the code that would cause some errors in version .8', 'localize_semperfi'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div id="support" class="information">
                <h3><?php _e('Support Information', 'localize_semperfi'); ?></h3>
                <p><?php _e('If you happen to have issues with plugins, writing posts, customizing the theme, and basically anything just shoot me an email on <a href="http://schwarttzy.com/contact-me/" target="_blank">this page</a> I setup for contacting me.', 'localize_semperfi'); ?></p>
                <p><?php _e('I have a <a href="https://twitter.com/Schwarttzy" target="_blank">Twitter</a> account, but all I really use it for is posting information on updates to my themes. So if you looking for a new feature, you may be in luck. I am not really sure what to do with Twitter, but I know a lot of people use it.', 'localize_semperfi'); ?></p>
                <p><?php _e('Your always welcome to use the "<a href="http://wordpress.org/support/theme/semper-fi-lite/" target="_blank">Support</a>" forums on WordPress.org for any questions or problems, I just do not check it as often because I do not recieve email notifications on new posts or replies.', 'localize_semperfi'); ?></p>
            </div>
        
            <div id="description" class="information">
                <h3><?php _e('Description', 'localize_semperfi'); ?></h3>
                <p><?php _e('If you are having trouble with using the WordPress Theme', 'localize_semperfi'); $my_theme = wp_get_theme(); echo $my_theme->get( 'Name' ); _e('and need some help, <a href="http://schwarttzy.com/contact-me/" target="_blank">contact me</a> about it. But I recommend taking a look at <a href="https://www.youtube.com/watch?v=IU__-ipUxxc" target="_blank">this video</a> before sending me an email. The video is old and missing a bunch of the new features, but it will teach you everything there is to using the theme Customizer', 'localize_semperfi'); ?>"<?php $my_theme = wp_get_theme(); echo $my_theme->get( 'Name' )?>."</p>
                <p><?php _e('Now that I have covered contacting me and a how to video, I would like to thank you for downloading and installing this theme. I hope that you enjoy it. I also hope that I can continue to create more beautiful themes like this for years to come, but that requires your help. I have created this Theme, and others, free of charge. And while I am not looking to get rich, I really like creating these themes for you guys.', 'localize_semperfi'); ?></p>
                <p><?php _e('So if you are interested in supporting my work, I can offer you an <a href="http://schwarttzy.com/shop/semper-fi/" target="_blank" >upgrade Semper Fi Lite</a>. I have already included a few more features, some of which I am not allowed include in the free version, and I also offer to write additional code to customize the theme for you. Even if the code will be unique to your website.', 'localize_semperfi'); ?></p>
                <p><?php _e('Eric Schwarz<br><a href="http://schwarttzy.com/" targe="_blank">http://schwarttzy.com/</a>', 'localize_semperfi'); ?></p>                
            </div>
        
        </div>
            
    </div>
        
  
        
        
    
    <ul id="finishing"></ul>

    
    </div>
<?php }
add_action('admin_menu', 'semperfi_theme_options_add_page'); ?>