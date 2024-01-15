<?php
//Sub Init
$sub = get_sub_field(pathinfo(__FILE__, PATHINFO_FILENAME));
if (!$sub) {
    ?><link href="<?php echo get_template_directory_uri() ?>/front/build/image-block.css" rel="stylesheet"><?php
}
$group = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;
//Sub Init Done

$image = $args['group']['image'] ?? null;
$title = $args['group']['title'] ?? null;
$subtitle = $args['group']['subtitle'] ?? null;
$link = $args['group']['link'] ?? null;
$bottom_content = $args['group']['bottom_content'] ?? null;
$color = $args['group']['color'] ?? null;
$padding_top = $args['group']['padding_top'] ?? null;
?>
<section class="image-block <?php echo $padding_top ? 'section-padding' : 'section-padding-bottom' ?> <?php echo $color ?>">
    <div class="container">
        <div class="image-block__wrapper section-padding">
            <?php if ($image) { ?>
                <picture class="image-block__image">
                    <?php echo wp_get_attachment_image($image['ID'], 'large', '', ['alt' => $image['alt'] ?? $title]); ?>
                </picture>
            <?php } ?>
            <?php if ($title) { ?>
                <h3 class="heading-3 image-block__heading"><?php echo $title; ?></h3>
            <?php } ?>
            <?php if ($subtitle) { ?>
                <p class="image-block__caption"><?php echo $subtitle; ?></p>
            <?php } ?>
            <?php if ($link) { ?>
                <div class="image-block__btn-wrapper">
                    <?php
                    $link = new Link($link);
                    $link->class = 'btn btn--middle btn--primary';
                    echo $link->a();
                    ?>
                </div>
            <?php } ?>
        </div>
        <?php if ($bottom_content) { ?>
            <div class="info-image__disclosure">
                <?php echo str_replace(['<h5>', '<p>'], ['<h5 class="heading-5 info-image__disclosure-heading">', '<p class="text-small info-image__disclosure-caption">'], $bottom_content) ?>
            </div>
        <?php } ?>
    </div>
</section>