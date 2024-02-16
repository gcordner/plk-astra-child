<?php
/**
 * Features block.
 *
 * @package PLK
 */

$group         = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;

$block_title    = $group['title'] ?? null;
$items          = $group['items'] ?? null;
$bottom_content = $group['bottom_content'] ?? null;
$top_content    = $group['top_content'] ?? null;

$top_large_padding = $group['top_large_padding'] ?? null;
$bottom_padding    = $group['bottom_padding'] ?? null;
$gradient_icons    = $group['gradient-icons'] ?? null;

$class = 'feature section-padding-top bg--gray-gradient';
if ($top_large_padding) {
    $class .= ' section-padding-top--xl ';
}
if ($bottom_padding) {
    $class .= ' section-padding-bottom ';
}
if ($gradient_icons) {
    $class .= ' feature--gradient-icons ';
}
?>

<section class="<?php echo esc_html($class); ?>">
    <div class="ast-container">
        <div class="container">
            <?php if ($block_title) : ?>
                <h2 class="heading-2"><?php echo esc_html($block_title); ?></h2>
            <?php endif; ?>
            <?php if ($top_content) : ?>
                <p class="feature__caption"><?php echo esc_html($top_content); ?></p>
            <?php endif; ?>
            <?php if ($items) : ?>
                <div class="feature__slider custom-navigation splide" id="feature_splide">
                    <div class="feature-container splide__track">
                        <ul class="feature__list list-reset splide__list">
                            <?php 
                            foreach ( $items as $item ) {
                                $i_icon     = $item['icon'] ?? null;
                                $i_title    = $item['title'] ?? null;
                                $i_subtitle = $item['subtitle'] ?? null;
                                ?>
                                <li class="splide__slide">
                                    <div class="feature__item">
                                        <?php if ($i_icon) : ?>
                                            <div class="feature__item-icon">
                                                <picture>
                                                    <?php echo wp_get_attachment_image( $i_icon['ID'], 'medium', '', array ( 'alt' => $i_icon['alt'] ?: $i_title ) ); ?>
                                                </picture>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($i_title) : ?>
                                            <h3 class="heading-4 feature__item-name"><?php echo esc_html($i_title); ?></h3>
                                        <?php endif; ?>
                                        <?php if ($i_subtitle) : ?>
                                            <p class="text-medium item__item-caption"><?php echo esc_html($i_subtitle); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php if ($bottom_content) : ?>
                        <p class="feature__caption"><?php echo esc_html($bottom_content); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>