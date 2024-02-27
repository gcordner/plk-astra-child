<?php
/**
 * Contact form Block
 *
 * @package plk-child-theme
 */

$sub   = get_sub_field(pathinfo(__FILE__, PATHINFO_FILENAME));
$group = $sub ? $sub : ( $args['group'] ? $args['group'] : null );

$form          = $group['form'] ?? null;
$image         = $group['image'] ?? null;
$contact_title = $group['title'] ?? null;
$subtitle      = $group['subtitle'] ?? null;
?>
<section class="form form--image">
    <div class="ast-container">
        <div class="container">
            <div class="form__wrapper">
                <?php
                if ( $form ) :
                    ?>
                    <div class="form__block">
                        <?php
                        if ( $contact_title ) :
                            ?>
                            <h2 class="heading-2 form__heading"><?php echo esc_html( $contact_title ); ?></h2>
                            <?php
                        endif;
                        if ( $subtitle ) :
                            ?>
                            <p class="form__caption text-large"><?php echo esc_html( $subtitle ); ?></p>
                            <?php
                        endif;
                        echo $form;
                        ?>
                    </div>
                    <?php
                endif;
                if ( $image ) :
                    ?>
                    <div class="form__image-wrapper">
                        <picture>
                            <?php
                            if ( $image['ID'] ) :
                                echo wp_get_attachment_image( $image['ID'], 'large', '', array( 'alt' => $image['alt'] ) );
                            else :
                                echo 'Contact Us';
                            endif;
                            ?>
                        </picture>
                    </div>
                    <?php
                endif;
                ?>
            </div>
        </div>
    </div>
</section>