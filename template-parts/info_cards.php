<?php
/**
 * Vien information block
 *
 * Template pats for vien information block
 *
 * @package info
 */

$sub   = get_sub_field(pathinfo(__FILE__, PATHINFO_FILENAME));
$group = $sub ? $sub : ( $args['group'] ? $args['group'] : null );
//Sub Init Done

$title = $args['group']['title'] ?? null;
$image = $args['group']['image'] ?? null;
$cards = $args['group']['cards'] ?? null;
?>
<section class="vien section-padding background--gray section-margin">
    <div class="ast-container">
        <div class="container">
            <?php if ($title) : ?>
                <h2 class="heading-2 vien__heading"><?php echo $title ?></h2>
            <?php endif; ?>
            <?php if ($cards) : ?>
                <div class="vien__slider custom-navigation splide" id="vien_splide">
                    <div class="vien-container splide__track">
                        <ul class="vien__list list-reset splide__list">
                            <?php foreach ($cards as $card) {
                                $cImage = $card['image'] ?? null;
                                $cTitle = $card['title'] ?? null;
                                $cItems = $card['items'] ?? null;
                                $cLink  = $card['link'] ?? null;
                                $cColor = $card['color'] ?? null;
                                ?>
                                <li class="splide__slide">
                                    <div class="vien__item">
                                        <?php if ($cImage) { ?>
                                            <picture>
                                                <?php echo wp_get_attachment_image($cImage['ID'], 'medium', '', ['alt' => $cImage['alt'] ?: $cTitle]); ?>
                                            </picture>
                                        <?php } ?>
                                        <?php if ($cTitle) { ?>
                                            <h3 class="heading-4 vien__item-title"><?php echo $cTitle ?></h3>
                                        <?php } ?>
                                        <?php if ($cItems) { ?>
                                            <ul class="vien__item-ul list-reset <?php echo $cColor ?>">
                                                <?php foreach ($cItems as $cItem) {
                                                    $vIcon = $cItem['icon'] ?? null;
                                                    $vName = $cItem['name'] ?? null;
                                                    ?>
                                                    <li class="vien__item-li">
                                                        <?php if ($vIcon) { ?>
                                                            <span class="vien__item-li-icon <?php echo $vIcon ?>"></span>
                                                        <?php } ?>
                                                        <?php if ($vName) { ?>
                                                            <p class="vien__item-li-name nav-text"><?php echo $vName ?></p>
                                                        <?php } ?>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                        <?php 
                                        if ($cLink) :
                                            $nlink = new Link($cLink);
                                            $nlink->class = 'btn btn--transparent vien__item-link';
                                            $nlink->wrapper_end = '<span class="icon-nav-arrow"></span>';
                                            echo $nlink->a();
                                        endif;
                                        ?>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>