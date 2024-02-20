<?php
/**
 * Categories Block
 *
 * @package plk-child-theme
 */

// Sub Init.
$sub   = get_sub_field( pathinfo( __FILE__, PATHINFO_FILENAME ) );
$group = $sub ? $sub : ( $args['group'] ? $args['group'] : null );

$section_title     = $group['title'] ?? null;
$view_all_link     = $group['view_all_link'] ?? null;
$select_categories = $group['select_categories'] ?? null;


if ( $select_categories ) : ?>

<section class="categories section-margin section-margin-bottom">
    <div class="ast-container">
        <div class="container categories__container">
            <?php if ( $section_title ) : ?>
                <h2 class="heading-2 categories__heading"><?php echo esc_html( $section_title ); ?></h2>
            <?php endif; ?>
            <?php
            if ( $view_all_link ) :
                $link_title = $view_all_link['title'] ?? '';
                $link_href  = $view_all_link['url'] ?? '';
                ?>
                <a href="<?php echo esc_html( $link_href ); ?>" class="btn--arrow link-reset products__link">
                    <?php echo esc_html( $link_title ); ?>
                    <span class="icon-nav-arrow"></span>
                </a>
                <?php
            endif;
            ?>
            <ul class="categories__list list-reset">
                <?php
                foreach ( $select_categories as $category ) {
                    $cterm       = get_term( $category, 'product_cat' );
                    $thumb_id    = get_term_meta( $cterm->term_id, 'thumbnail_id', true );
                    $title_color = get_field( 'title_color', $cterm );
                    ?>
                    <li class="categories__item">
                        <a class="categories__item-link" href="<?php echo esc_html( get_term_link( $cterm, 'product_cat' ) ); ?>">
                            <?php if ( $thumb_id ) : ?>
                                <picture>
                                    <?php echo wp_get_attachment_image( $thumb_id, 'woocommerce_thumbnail', '', array( 'alt' => $cterm->name ) ); ?>
                                </picture>
                            <?php endif; ?>
                            <h3 
                                class="heading-4 categories__item-heading
                                    <?php
                                    if ( ! $title_color ) :
                                        ?>
                                        bg--orange
                                    <?php endif; ?>" <?php echo $title_color ? 'style="background-color: ' . esc_html( $title_color ) . '"' : ''; ?>><?php echo esc_html( $cterm->name ); ?></h3>
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
</section>
<?php endif; ?>
