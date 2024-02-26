<?php
/**
 * Template part(sub) picture for image text flexible layout
 *
 * @package plk-child-theme
 */

$image       = $args['image'];
$block_title = $args['block_title'];

$medium       = wp_get_attachment_image_url( $image['ID'], 'medium' );
$medium_large = wp_get_attachment_image_url( $image['ID'], 'medium_large' );
$src_set      = $medium . ',' . $medium_large . ' 2x';
?>
<picture>
    <source media="(max-width: 500px)" srcset="<?php echo esc_url( $src_set ); ?>" >
    <?php
    $alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
    echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
    ?>
</picture>