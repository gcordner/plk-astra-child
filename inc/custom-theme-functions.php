<?php
//Supports
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );

//Breadcrumbs
function the_breadcrumb($group = []) {
    $position = 1;
    echo '<ul class="breadcrumb__list list-reset">';
    echo '<li class="breadcrumb__item breadcrumb__item"><a class=breadcrumbs__link" href="';
    echo home_url();
    echo '">';
    echo '<span>' . get_bloginfo('name') . '</span>';
    echo '</a><template class="icon-arrow-up breadcrumb__item-icon"></template></li>';
    if (is_single()) {
        $post_type = get_post_type(get_the_ID());
        if($post_type == 'post') {
            $post_type = 'blog';
        }
        $object = get_post_type_object($post_type);
        if($object) {
            $page = isset($object->rewrite['slug']) ? get_page_by_path( $object->rewrite['slug'] ) : '';
        } else {
            $page = get_page_by_path( $post_type );
        }
        if($page) {
            echo '<li class="breadcrumb__item text-small"><a class="breadcrumbs__link" href="'.get_permalink( $page->ID ).'">';
            echo '<span>' . get_the_title( $page->ID ) . '</span>';
            $position++;
            echo '</a><span class="icon-arrow-up breadcrumb__item-icon"></span></li>';
        }
    }
    echo '<li class="breadcrumb__item breadcrumb__item breadcrumb__item--active"><span>';
    $position++;
    if(is_404()) {
        echo '404';
    } else {
        echo isset($group['custom_title']) && $group['custom_title'] ? $group['custom_title'] : get_the_title();
    }
    echo '</span></li>';
    echo '</ul>';
}

//Custom MCE Options
function override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');

//Flexible Previews
add_filter('acf-flexible-content-preview.images_path', 'get_acf_preview_path');
function get_acf_preview_path()
{
    return 'inc/flexible_images';
}

//Custom Menu Walker
function wp_get_menu_array($current_menu) {

    $array_menu = wp_get_nav_menu_items($current_menu);
    if(!$array_menu) return false;
    $menu = array();
    $submenu = array();
    $subsubmenu = array();
    $subsubsubmenu = array();

    foreach ($array_menu as $m) {
        if (empty($m->menu_item_parent)){
            $curent_id = $m->ID;
            $new_tab = get_field('new_tab', $curent_id);
            $menu[$m->ID] = array();
            $menu[$m->ID]['ID'] =   $m->ID;
            $menu[$m->ID]['title'] =   $m->title;
            $menu[$m->ID]['url'] =   $m->url;
            $menu[$m->ID]['target'] =   $new_tab == 1 ? '_blank' : '';
            $menu[$m->ID]['submenu'] = array();
        }

        if ($m->menu_item_parent == $curent_id) {
            $curent_submenu_id = $m->ID;
            $new_tab = get_field('new_tab', $curent_submenu_id);
            $submenu[$m->ID] = array();
            $submenu[$m->ID]['ID']       =   $m->ID;
            $submenu[$m->ID]['title']    =   $m->title;
            $submenu[$m->ID]['url']      =   $m->url;
            $submenu[$m->ID]['target']      =   $new_tab == 1 ? '_blank' : '';
            $submenu[$m->ID]['parent']      =   $m->menu_item_parent;
            $menu[$m->menu_item_parent]['submenu'][$m->ID] = $submenu[$m->ID];
        }

        if (isset($curent_submenu_id) && $m->menu_item_parent == $curent_submenu_id) {
            $current_subsubmenu_id = $m->ID;
            $parent = $submenu[$m->menu_item_parent]['parent'];
            $new_tab = get_field('new_tab', $m->ID);
            $subsubmenu[$m->ID] = array();
            $subsubmenu[$m->ID]['ID']       =   $m->ID;
            $subsubmenu[$m->ID]['title']    =   $m->title;
            $subsubmenu[$m->ID]['url']      =   $m->url;
            $subsubmenu[$m->ID]['target']      =   $new_tab == 1 ? '_blank' : '';
            $subsubmenu[$m->ID]['parent']      =   $m->menu_item_parent;
            $subsubmenu[$m->ID]['parent_two']      =   $parent;
            $menu[$parent]['submenu'][$m->menu_item_parent]['submenu'][$m->ID] = $subsubmenu[$m->ID];
        }

        if (isset($current_subsubmenu_id) && $m->menu_item_parent == $current_subsubmenu_id) {
            $parent = $subsubmenu[$m->menu_item_parent]['parent'];
            $parent_two = $subsubmenu[$m->menu_item_parent]['parent_two'];
            $new_tab = get_field('new_tab', $m->ID);
            $subsubsubmenu[$m->ID] = array();
            $subsubsubmenu[$m->ID]['ID']       =   $m->ID;
            $subsubsubmenu[$m->ID]['title']    =   $m->title;
            $subsubsubmenu[$m->ID]['url']      =   $m->url;
            $subsubsubmenu[$m->ID]['target']      =   $new_tab == 1 ? '_blank' : '';
            $menu[$parent_two]['submenu'][$parent]['submenu'][$m->menu_item_parent]['submenu'][$m->ID] = $subsubsubmenu[$m->ID];
        }

    }

    return $menu;
}

//Google Api Key (Only Acf)
if ( class_exists( 'ACF' ) ) {
    function my_acf_google_map_api( $api ){
        $api['key'] = get_field('google_map_key', 'option');
        return $api;
    }
    add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
}

//Reed Post Time
function estimated_reading_time($postID = null) {
    $post = get_post();
    if($postID) $post = get_post($postID);
    $words = str_word_count( strip_tags( $post->post_content ) );
    $minutes = floor( $words / 120 );
    $seconds = floor( $words % 120 / ( 120 / 60 ) );
    $ms = $seconds / 60;
    $estimated_time = round($minutes + $ms);
    return $estimated_time;
}

/**
 * Disable the emoji's
 */
function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

    // Remove from TinyMCE
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter out the tinymce emoji plugin.
 */
function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

//Phone Number
function phone_number($tel) {
    $sPhone = $tel;
    $phone = trim($sPhone);
    $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);
    return '+1'.$phone;
}

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

//Register Menu
register_nav_menus(array(
    'header_menu' => 'Header Menu',
    'header_menu_mobile' => 'Header Mobile (Footer)',
    'footer_menu' => 'Footer Menu',
));

//Related Blog Posts
function ci_get_related_posts( $post_id, $related_count, $args = array() ) {
    $terms = get_the_terms( $post_id, 'category' );

    if ( empty( $terms ) ) $terms = array();

    $term_list = wp_list_pluck( $terms, 'slug' );

    $related_args = array(
        'post_type' => 'post',
        'posts_per_page' => $related_count,
        'post_status' => 'publish',
        'post__not_in' => array( $post_id ),
        'orderby' => 'rand',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $term_list
            )
        )
    );

    return new WP_Query( $related_args );
}

//Deregister Default Taxonomy
function wpsnipp_remove_default_taxonomies(){
    global $pagenow;

    register_taxonomy( 'post_tag', array() );

    $tax = array('post_tag');

    if($pagenow == 'edit-tags.php' && in_array($_GET['taxonomy'],$tax) ){
        wp_die('Invalid taxonomy');
    }
}
add_action('init', 'wpsnipp_remove_default_taxonomies');

// Remove category archives
add_action('template_redirect', 'jltwp_adminify_remove_archives_category');
function jltwp_adminify_remove_archives_category()
{
    if (is_category()){
        $target = get_option('siteurl') . '/blog/';
        $status = '301';
        wp_redirect($target, 301);
        die();
    }
}

//New Excerpt More
function new_excerpt_more( $more ) {
    return ' ...';
}
add_filter('excerpt_more', 'new_excerpt_more');

add_action('wp_ajax_blog_loadmore', 'blog_loadmore');
add_action('wp_ajax_nopriv_blog_loadmore', 'blog_loadmore');

function blog_loadmore()
{

    $paged = ! empty($_POST[ 'paged' ]) ? $_POST[ 'paged' ] : 1;
    $query = ! empty($_POST[ 'query' ]) ? maybe_unserialize(stripcslashes($_POST[ 'query' ])) : [];
    $category = ! empty($_POST[ 'category' ]) ? $_POST['category'] : '';
    $filter = ! empty($_POST[ 'filter' ]) ? $_POST['filter'] : 'false';
    $i = $paged - 2;
    if ($filter === 'false') {
        $paged++;
        $i++;
    }

    $args = $query;
    $args['paged'] = $paged;
    if ($category && !$category != 'all') {
        $args['cat'] = $category;
    }

    if ($filter == 'false') {
        $args['posts_per_page'] = 9;
        $args['offset'] = 10 + (9 * $i);
    }

    $query = new WP_Query($args);
    $blog = $query->posts;

    ob_start();
    foreach ($blog as $key => $post) {
        get_template_part('template-parts/loop/blog-card', '', ['post' => $post]);
    }
    $content = ob_get_contents();
    ob_end_clean();

    echo json_encode([
        'max_pages' => $query->max_num_pages,
        'paged' => $paged,
        'html' => $content
    ]);

    die;
}

function wc_categories_sidebar() {
    register_sidebar( array(
        'name' => 'Categories Sidebar',
        'id' => 'wc_categories_sidebar',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ) );
}
add_action( 'widgets_init', 'wc_categories_sidebar' );

add_filter( 'woocommerce_breadcrumb_defaults', 'custom_woocommerce_breadcrumbs' );
function custom_woocommerce_breadcrumbs() {
    $custom_class = is_product() ?: 'breadcrumb--category';
    return [
        'delimiter' => '',
        'wrap_before' => '<link href="'.get_template_directory_uri().'/front/build/breadcrumb.css" rel="stylesheet"><section class="breadcrumb '.$custom_class.'"><div class="container"><ul class="breadcrumb__list list-reset">',
        'wrap_after' => '</ul></div></section>',
        'before' => '<li class="breadcrumb__item text-small">',
        'after' => '<span class="icon-arrow-up breadcrumb__item-icon"></span></li>',
        'home' => get_bloginfo('name')
    ];
}

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );

// Disables the block editor from managing widgets. renamed from wp_use_widgets_block_editor
add_filter( 'use_widgets_block_editor', '__return_false' );

//Shortcodes
add_shortcode('accordion', 'plk_faq');
function plk_faq($args, $content) {
    return '<div class="section-margin--md" itemscope itemtype="https://schema.org/FAQPage">
              <h2 class="heading-2" itemprop="name">'.$args['title'].'</h2>
              <div class="faq__list">
                  '.apply_filters('the_content', $content).'
              </div>
            </div>';
}

add_shortcode('accordion-item', 'plk_faq_item');
function plk_faq_item($args, $content) {
    return '
    <div itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
      <div class="faq__item accordion">
        <div class="faq__item-link accordion__link">
          <div class="heading-4 faq__item-name" itemprop="name">'.$args['title'].'</div>
          <div class="icon-arrow-down faq__item-icon"></div>
        </div>
        <div class="faq__item-content accordion__content"  itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer"><div itemprop="text">
          '.apply_filters('the_content', $content).'
        </div></div>
      </div>
    </div>';
}

//Remove Stamped.io on posts
function smartwp_remove_stamped(){
    if (is_singular('post')) {
        wp_deregister_script('woo-stamped-io-public-custom');
        wp_dequeue_script( 'woo-stamped-io-public-custom' );

        wp_dequeue_style( 'lightcase' );
        wp_dequeue_script( 'fgf-lightcase' );
        wp_dequeue_style( 'owl-carousel' );
        wp_dequeue_style( 'fgf-owl-carousel' );
        wp_dequeue_script( 'owl-carousel' );
        wp_dequeue_script( 'fgf-owl-carousel' );
        wp_dequeue_style( 'fgf-frontend-css' );
        wp_dequeue_script( 'fgf-frontend' );
        wp_dequeue_script( 'fgf-frontend-js-extra' );
        wp_dequeue_style( 'fgf-inline-style' );
    }
}
add_action( 'wp_enqueue_scripts', 'smartwp_remove_stamped', 100 );

//Custom Images Flexible
$dir = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/themes/PLK/inc/flexible_images/';

foreach (glob("$dir*.jpg") as $file) {
    $file = substr(basename($file), 0, -4);
    add_filter("acfe/flexible/thumbnail/layout=$file", 'acf_flexible_layout_thumbnail', 10, 3);
}
function acf_flexible_layout_thumbnail($thumbnail, $field, $layout)
{
    return get_template_directory_uri() . '/inc/flexible_images/' . $layout['name'] . '.jpg';
}

function cs_add_order_again_to_my_orders_actions( $actions, $order ) {
    if ( $order->has_status( 'completed' ) ) {
        $actions['order-again'] = array(
            'url'  => wp_nonce_url( add_query_arg( 'order_again', $order->id ) , 'woocommerce-order_again' ),
            'name' => __( 'Order Again', 'woocommerce' )
        );
    }

    return $actions;
}

add_filter( 'woocommerce_my_account_my_orders_actions', 'cs_add_order_again_to_my_orders_actions', 50, 2 );

/* Change article output for Structured data */
add_filter( 'saswp_modify_article_schema_output', 'cs_saswp_modify_article_schema_output', 10, 1 );
function cs_saswp_modify_article_schema_output($output){
  unset($output['author']['image']);
  unset($output['editor']);
  return $output;
}
/**
 * Allow changing of the canonical URL.
 *
 * @param string $canonical The canonical URL.
 */
add_filter( 'rank_math/frontend/canonical', function( $canonical ) {
  if ( is_tax( 'product_cat' ) && is_paged() ) {
    $object = get_queried_object();
    return get_term_link( $object->term_id );
  }
  if(strpos($canonical, 'https')===false)
    $canonical = str_replace('//','https://',$canonical);
  return $canonical;
});

/* Update external links */
add_filter( 'woocommerce_short_description', 'cs_woocommerce_short_description', 10, 1 );
function cs_woocommerce_short_description( $post_excerpt ){
    $post_excerpt = str_replace('href="https', 'target="_blank" rel="noreferrer nofollow noopener" href="https', $post_excerpt);
    return $post_excerpt;
}

/* Remove feeds and feed links */
function custom_disable_feed() {
 wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}

add_action('do_feed', 'custom_disable_feed', 1);
add_action('do_feed_rdf', 'custom_disable_feed', 1);
add_action('do_feed_rss', 'custom_disable_feed', 1);
add_action('do_feed_rss2', 'custom_disable_feed', 1);
add_action('do_feed_atom', 'custom_disable_feed', 1);
add_action('do_feed_rss2_comments', 'custom_disable_feed', 1);
add_action('do_feed_atom_comments', 'custom_disable_feed', 1);
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

/* Popup for sales and holidays */
add_action('wp_footer', 'cwa_custom_popup');
function cwa_custom_popup() {
  $enablePopup = get_field( 'custom_popup_enable', 'option' );
  if($enablePopup){
    $image = get_field( 'custom_popup_image', 'option' );
    $title = get_field( 'custom_popup_title', 'option' );
    $start_date = get_field( 'custom_popup_start_date', 'option' );
    $end_date = get_field( 'custom_popup_end_date', 'option' );
    $fl = 1;
    date_default_timezone_set('Etc/GMT-7');
    $now = strtotime(date('Y/m/d h:i:s'));
    if(!empty($start_date)){
      $start_date = strtotime($start_date);
      if($start_date > $now) $fl = 0;
    }
    if(!empty($end_date)){
      $end_date = strtotime($end_date);
      if($end_date < $now) $fl = 0;
    }
    if($fl){?>
    <div id="custom-popup" class="popup popup--simple" data-popup="auto">
      <picture class="popup__image">
        <?php echo wp_get_attachment_image($image['ID'], 'medium_large', '', ['alt' => $title, 'loading' => 'lazy']) ?>
      </picture>
    </div>

<?php }}}

