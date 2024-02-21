<?php
/**
 * FAQ Block
 *
 * @package plk-child-theme
 */

$faq_title   = $args['group']['title'] ?? null;
$heading_tag = $args['group']['heading_tag'] ?? null;
$items       = $args['group']['items'] ?? null;
?>
<?php if ( $items ) : ?>
<section class="faq section-padding background--gray faq--page"
    <?php
    if ( ! is_page( 104524 ) ) :
        ?>
        itemscope itemtype="https://schema.org/FAQPage"
        <?php
    endif;
    ?>
    >
    <div class="ast-container">
        <div class="container">
            <div class="faq__inner">
                <?php
                if ( $faq_title && $heading_tag ) :
                    echo '<' . esc_html( $heading_tag ) . ' class="heading-2 faq__heading">' . esc_html( $faq_title ) . '</' . esc_html( $heading_tag ) . '>';
                endif;
                ?>
                <div class="faq__list">
                    <?php
                    foreach ( $items as $item ) {
                        $question = $item['question'];
                        $answer   = $item['answer'];
                        ?>
                        <div class="faq__item accordion" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                            <?php
                            if ( $question ) :
                                ?>
                                <div class="faq__item-link accordion__link">
                                    <?php
                                    if ( is_archive() ) {
                                        ?>
                                        <h3 class="heading-4 faq__item-name" itemprop="name"><?php echo esc_html( $question ); ?></h3>
                                        <?php
                                    } else {
                                        ?>
                                        <div class="heading-4 faq__item-name" itemprop="name"><?php echo esc_html( $question ); ?></div>
                                    <?php } ?>
                                    <div class="icon-arrow-down faq__item-icon"></div>
                                </div>
                                <?php
                            endif;
                            ?>
                            <?php
                            if ( $answer ) :
                                ?>
                                <div class="faq__item-content accordion__content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                    <span class="text-medium" itemprop="text"><?php echo esc_html( $answer ); ?></span>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>