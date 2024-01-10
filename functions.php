<?php
/**
 * Payless Kratom Child Theme Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Payless Kratom Child Theme
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_PAYLESS_KRATOM_CHILD_THEME_VERSION', '1.0.0' );

/**
 * Include files
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_stylesheet_directory() . '/inc/woocommerce.php';
}


/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'plk-child-theme-theme-css', get_stylesheet_directory_uri() . '/style.css', array( 'astra-theme-css' ), CHILD_THEME_PAYLESS_KRATOM_CHILD_THEME_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );

/**
 * Register webpack compiled js and css with theme.
 */
function enqueue_webpack_scripts() {

	$css_file_path = glob( get_stylesheet_directory() . '/css/build/plk.min.*.css' );
	$css_file_uri  = get_stylesheet_directory_uri() . '/css/build/' . basename( $css_file_path[0] );
	wp_enqueue_style( 'main_css', $css_file_uri ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	$js_file_path = glob( get_stylesheet_directory() . '/js/build/main.min.*.js' );
	$js_file_uri  = get_stylesheet_directory_uri() . '/js/build/' . basename( $js_file_path[0] );
	wp_enqueue_script( 'main_js', $js_file_uri, null, null, true ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

}
add_action( 'wp_enqueue_scripts', 'enqueue_webpack_scripts', 20 );

/**
 * Custom version of the astra get taxonomy function, removing the case 'archive-breadcrumb':
 */
function custom_astra_get_taxonomy_banner_legacy_layout() {
	?>
	<section class="ast-archive-description">
	<?php
	$post_type        = strval( get_post_type() );
	$banner_structure = astra_get_option( 'ast-dynamic-archive-' . $post_type . '-structure', array( 'ast-dynamic-archive-' . $post_type . '-title', 'ast-dynamic-archive-' . $post_type . '-description' ) );

	// Check if it's the main blog page and log accordingly.
	if ( is_home() ) {
		foreach ( $banner_structure as $metaval ) {
			$meta_key = 'archive-' . astra_get_last_meta_word( $metaval );
			switch ( $meta_key ) {
				case 'archive-title':
					do_action( 'astra_before_archive_title' );
					add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
					// Insert the manual breadcrumb structure.
					echo '<div class="ast-breadcrumbs-wrapper">';
					echo '  <div class="ast-breadcrumbs-inner">';
					echo '      <nav aria-label="breadcrumbs" class="rank-math-breadcrumb">';
					echo '          <p>';
					echo '              <a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html( get_bloginfo('name') ) . '</a>';
					echo '              <span class="separator"> » </span>';
					echo '              <span class="last">Blog</span>';
					echo '          </p>';
					echo '      </nav>';
					echo '  </div>';
					echo '</div>';
					// Set the title to "Blog".
					echo '<h1 class="page-title ast-archive-title">Blog</h1>';
					remove_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
					do_action( 'astra_after_archive_title' );
					break;
				// Removed the 'archive-breadcrumb' case here.
				case 'archive-description':
					do_action( 'astra_before_archive_description' );
					echo wp_kses_post( wpautop( get_the_archive_description() ) );
					do_action( 'astra_after_archive_description' );
					break;
			}
		}
	} else {

		foreach ( $banner_structure as $metaval ) {
			$meta_key = 'archive-' . astra_get_last_meta_word( $metaval );
			switch ( $meta_key ) {
				case 'archive-title':
					do_action( 'astra_before_archive_title' );
					add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
					the_archive_title( '<h1 class="page-title ast-archive-title">', '</h1>' );
					remove_filter( 'get_the_archive_title_prefix', '__return_empty_string' );
					do_action( 'astra_after_archive_title' );
					break;
				// Removed the 'archive-breadcrumb' case here.
				case 'archive-description':
					do_action( 'astra_before_archive_description' );
					echo wp_kses_post( wpautop( get_the_archive_description() ) );
					do_action( 'astra_after_archive_description' );
					break;
			}
		}
	}
	?>
	</section>
	<?php
}
/**
 * Replace the astra_archive_page_info function with a custom version.
 */
function custom_astra_archive_page_info() {
	if ( apply_filters( 'astra_the_title_enabled', true ) ) {
		// Author.
		if ( is_author() ) {
			$author_name      = get_the_author() ? get_the_author() : '';
			$author_name_html = ( true === astra_check_is_structural_setup() && $author_name ) ? __( 'Author name: ', 'astra' ) . $author_name : $author_name;
			?>
			<section class="ast-author-box ast-archive-description">
				<div class="ast-author-bio">
				<?php do_action( 'astra_before_archive_title' ); ?>
					<h1 class='page-title ast-archive-title'><?php echo esc_html( apply_filters( 'astra_author_page_title', $author_name_html ) ); ?></h1>
				<?php do_action( 'astra_after_archive_title' ); ?>
					<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
				<?php do_action( 'astra_after_archive_description' ); ?>
				</div>
				<div class="ast-author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'email' ), 120 ); ?>
				</div>
			</section>
			<?php
			// Search.
		} elseif ( is_search() ) {
			?>
			<section class="ast-archive-description">
			<?php do_action( 'astra_before_archive_title' ); ?>
			<?php
				/* translators: 1: search string */
				$title = apply_filters( 'astra_the_search_page_title', sprintf( __( 'Search Results for: %s', 'astra' ), '<span>' . get_search_query() . '</span>' ) );
			?>
				<h1 class="page-title ast-archive-title"> <?php echo $title; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> </h1>
				<?php do_action( 'astra_after_archive_title' ); ?>
			</section>
			<?php
			// Other.
		} else {
			echo wp_kses_post( custom_astra_get_taxonomy_banner_legacy_layout() ); // Use the custom function.
		}
	}
}

// Now, unhook the original function and hook your custom version.
// remove_action( 'astra_archive_header', 'astra_archive_page_info' );
/**
 * Replace the astra_archive_page_info function with a custom version.
 */
function replace_astra_archive_function() {
	// Unhook the original function.
	remove_action( 'astra_archive_header', 'astra_archive_page_info' );

	// Hook the custom function with a higher priority to ensure it replaces the original.
	add_action( 'astra_archive_header', 'custom_astra_archive_page_info', 11 );
}
add_action( 'after_setup_theme', 'replace_astra_archive_function' );


//Custom Link Class
class Link
{

    protected $link;

    public $class;
    public $rel;
    public $wrapper_start;
    public $wrapper_end;
    public $animation;

    public function __construct($link)
    {
        if (is_array($link)) {
            $this->link = $link;
        } else {
            $this->link = [
                'url' => '',
                'target' => '',
                'title' => ''
            ];
        }
    }

    public function a()
    {
        if (!$this->link ?? null) return false;
        $linkAttr = '';
        $title = '';
        if ($this->class ?? null) {
            $linkAttr .= ' class="' . $this->class . '" ';
        }
        if ($this->link['url'] ?? null) {
            if ($this->link['url'] != '#') {
                $linkAttr .= ' href="' . $this->link['url'] . '" ';
            }
        }
        if ($this->link['target'] ?? null) {
            $linkAttr .= ' target="' . $this->link['target'] . '" ';
        }
        if ($this->rel ?? null) {
            $linkAttr .= ' rel="' . $this->rel . '" ';
        } else if ($this->link['target'] ?? null && $this->link['target'] == '_blank') {
            $linkAttr .= ' rel="nofollow noopener" ';
        }
        if ($this->animation ?? null) {
            $linkAttr .= ' ' . $this->animation;
        }
        if ($this->link['title'] ?? null) {
            $title = $this->link['title'];
        }
        if ($this->wrapper_start ?? null) {
            $title = $this->wrapper_start . $title;
        }
        if ($this->wrapper_end ?? null) {
            $title .= $this->wrapper_end;
        }
        if ($this->link['url'] == '#') {
            return '<span ' . $linkAttr . '>' . $title . '</span>';
        }
        return '<a ' . $linkAttr . '>' . $title . '</a>';
    }

}
