




























<?php
/**
 * Template part(sub) container for image text flexible layout
 *
 * @package plk-child-theme
 */

$image       = $args['image'];
$block_title = $args['block_title'];
$text        = $args['text'];
$btn_link    = $args['btn_link'];
?>
<div class="ast-container">
    <div class="container">
        <div class="infoblock__wrapper">
            <?php
            if ( $block_title ) :
                ?>
                <h2 class="heading-2 infoblock__heading"><?php echo esc_html( $block_title ); ?></h2>
                <?php
            endif;
            echo wp_kses_post( str_replace( array( '<p>', '<strong>' ), array( '<p class="infoblock__caption">', '<p class="text-large infoblock__caption">' ), $text ) );
            if( !empty( $btn_link ) ):
            ?>
            <a href="<?php echo esc_url( $btn_link['url'] ); ?>" class="btn btn--primary"><?php echo esc_html( $btn_link['title'] ); ?></a>
            <?php
            endif;
            ?>
        </div>
    </div>
</div>