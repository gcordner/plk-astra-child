<?php
//Sub Init
$sub = get_sub_field(pathinfo(__FILE__, PATHINFO_FILENAME));
if (!$sub) {
    ?><link href="<?php echo get_template_directory_uri() ?>/front/build/reviews.css" rel="stylesheet"><?php
}
$group = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;
//Sub Init Done

$title = $args['group']['title'] ?? null;
$reviews_code = $args['group']['reviews_code'] ?? null;
$padding_top = $args['group']['padding_top'] ?? null;
?>
<section class="reviews <?php echo $padding_top ? 'section-padding' : 'section-padding-bottom' ?>">
    <div class="container">
        <?php if ($title) { ?>
            <h2 class="heading-2 reviews__heading"><?php echo $title; ?></h2>
        <?php } ?>
        <?php echo $reviews_code; ?>
    </div>
</section>
<?php wp_reset_postdata(); ?>