<?php
$title = $args['group']['title'] ?? null;
$heading_tag = $args['group']['heading_tag'] ?? null;
$items = $args['group']['items'] ?? null;
?>
<?php if ($items) { ?>
<section class="faq section-padding background--gray faq--page"<?php if (!is_page(104524)) { ?> itemscope itemtype="https://schema.org/FAQPage"<?php } ?>>
    <div class="container">
        <div class="faq__inner">
            <?php if ($title && $heading_tag) {
                echo '<' . $heading_tag . ' class="heading-2 faq__heading">' . $title . '</' . $heading_tag . '>';
            } ?>
            <div class="faq__list">
                <?php foreach ($items as $item) {
                    $question = $item['question'];
                    $answer = $item['answer'];;
                    ?>
                    <div class="faq__item accordion" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                        <?php if ($question) { ?>
                            <div class="faq__item-link accordion__link">
                                <?php if (is_archive()) { ?>
                                    <h3 class="heading-4 faq__item-name" itemprop="name"><?php echo $question ?></h3>
                                <?php } else { ?>
                                    <div class="heading-4 faq__item-name" itemprop="name"><?php echo $question ?></div>
                                <?php } ?>
                                <div class="icon-arrow-down faq__item-icon"></div>
                            </div>
                        <?php } ?>
                        <?php if ($answer) { ?>
                            <div class="faq__item-content accordion__content" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                                <span class="text-medium" itemprop="text"><?php echo $answer ?></span>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>