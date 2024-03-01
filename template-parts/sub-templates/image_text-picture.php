<?php
/**
 * Template part(sub) picture for image text flexible layout
 *
 * @package plk-child-theme
 */

$image       = $args['image'];
$block_title = $args['block_title'];
$small_image = isset( $args['small_image'] ) ? $args['small_image'] : null;

$medium       = wp_get_attachment_image_url( $image['ID'], 'medium' );
$small        = wp_get_attachment_image_url( $image['ID'], 'small' );
$medium_large = wp_get_attachment_image_url( $image['ID'], 'medium_large' );
$src_set      = $medium . ',' . $small . ',' . $medium_large . ' 2x';
?>
<picture>
    
    <?php
    $alt_text = ! empty( $image['alt'] ) ? $image['alt'] : $block_title;
    echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $alt_text ) );
    ?>
</picture>

<?php
if ( $small_image ) :
    ?>
    <div class="infoblock__parallax">
        <picture>
        <?php
        $alt_text = ! empty( $small_image['alt'] ) ? $small_image['alt'] : $block_title;
        echo wp_get_attachment_image( $small_image['ID'], 'large', '', array( 'alt' => $alt_text ) );
        ?>
        </picture>
    </div>
    <?php
endif;