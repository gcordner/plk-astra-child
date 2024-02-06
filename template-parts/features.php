<?php
/**
 * Features block.
 *
 * @package PLK
 */
$group = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;

$title = $group['title'] ?? null;
$items = $group['items'] ?? null;
$bottom_content = $group['bottom_content'] ?? null;
$top_content = $group['top_content'] ?? null;

$top_large_padding = $group['top_large_padding'] ?? null;
$bottom_padding = $group['bottom_padding'] ?? null;
$gradient_icons = $group['gradient-icons'] ?? null;

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

<section class="<?php echo trim($class); ?>">
    <div class="ast-container">
        <div class="container">
            <?php if ($title) { ?>
                <h2 class="heading-2"><?php echo $title ?></h2>
            <?php } ?>
            <?php if ($top_content) { ?>
                <p class="feature__caption"><?php echo $top_content ?></p>
            <?php } ?>
            <?php if ($items) { ?>
                <div class="feature__slider custom-navigation splide">
                    <div class="feature-container splide__track">
                        <ul class="feature__list list-reset splide__list">
                            <?php foreach ($items as $item) {
                                $iIcon = $item['icon'] ?? null;
                                $iTitle = $item['title'] ?? null;
                                $iSubtitle = $item['subtitle'] ?? null;
                                ?>
                                <li class="splide__slide">
                                    <div class="feature__item">
                                        <?php if ($iIcon) { ?>
                                            <div class="feature__item-icon">
                                                <picture>
                                                    <?php echo wp_get_attachment_image($iIcon['ID'], 'medium', '', ['alt' => $iIcon['alt'] ?: $iTitle]); ?>
                                                </picture>
                                            </div>
                                        <?php } ?>
                                        <?php if ($iTitle) { ?>
                                            <h3 class="heading-4 feature__item-name"><?php echo $iTitle ?></h3>
                                        <?php } ?>
                                        <?php if ($iSubtitle) { ?>
                                            <p class="text-medium item__item-caption"><?php echo $iSubtitle ?></p>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <?php if ($bottom_content) { ?>
                        <p class="feature__caption"><?php echo $bottom_content ?></p>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</section>