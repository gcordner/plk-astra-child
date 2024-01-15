<?php
//Sub Init
$sub = get_sub_field(pathinfo(__FILE__, PATHINFO_FILENAME));
if (!$sub) {
    ?><link href="<?php echo get_template_directory_uri() ?>/front/build/breadcrumb.css" rel="stylesheet"><?php
}
$group = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;
//Sub Init Done
$color = $args['group']['color'] ?? null;
?>
<section class="breadcrumb <?php echo $color ?>">
    <div class="container">
        <?php the_breadcrumb(); ?>
    </div>
</section>