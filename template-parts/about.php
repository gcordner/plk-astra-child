<?php
//Sub Init
$sub = get_sub_field(pathinfo(__FILE__, PATHINFO_FILENAME));
$group = $sub ?? null ?: $args['group'] ?? null;
//Sub Init Done

$title = $group['title'] ?? null;
$subtitle = $group['subtitle'] ?? null;
$big_image = $group['big_image'] ?? null;
$small_image = $group['small_image'] ?? null;
$right_image = $group['right_image'] ?? null;
$content = $group['content'] ?? null;
$link = $group['link'] ?? null;
?>
<section class="about background--warm-contrast section-padding">
    <div class="container">
        <div class="about__wrapper--large">
            <?php if ($title) { ?>
                <h2 class="heading-2"><?php echo $title ?></h2>
            <?php } ?>
            <?php if ($subtitle) { ?>
                <p class="about__caption text-large"><?php echo $subtitle ?></p>
            <?php } ?>
            <div class="about__wrapper-image">
                <?php if ($big_image) { ?>
                    <picture class="about__image">
                        <source media="(max-width: 500px)" srcset="<?php echo wp_get_attachment_image_url($big_image['ID'], 'medium') ?>, <?php echo wp_get_attachment_image_url($big_image['ID'], 'medium_large') ?> 2x">
                        <?php echo wp_get_attachment_image($big_image['ID'], 'large', '', ['alt' => $big_image['alt'] ?: $title]) ?>
                    </picture>
                <?php } ?>
                <?php if ($small_image) { ?>
                    <picture class="about__image--animated">
                        <?php echo wp_get_attachment_image($small_image['ID'], 'medium', '', ['alt' => $small_image['alt'] ?: $title]) ?>
                    </picture>
                <?php } ?>
            </div>
        </div>
        <div class="about__wrapper--small">
            <?php if ($right_image) { ?>
                <picture class="about__image">
                    <?php echo wp_get_attachment_image($right_image['ID'], 'medium_large', '', ['alt' => $right_image['alt'] ?: $title]) ?>
                </picture>
            <?php } ?>
            <?php echo str_replace('<p>', '<p class="about__caption about__caption--small">', $content) ?>
            <?php if ($content) {
                $link = new Link($link);
                $link->class = 'btn--arrow link-reset about__btn';
                $link->wrapper_end = '<span class="icon-nav-arrow"></span>';
                echo $link->a();
            } ?>
        </div>
    </div>
</section>