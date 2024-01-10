<?php
//Sub Init
$group = $sub ?? null ?: $args['group'] ?? null;
$args['group'] = $group;
//Sub Init Done

$title = $args['group']['title'] ?? null;
$items = $args['group']['items'] ?? null;
$bottom_content = $args['group']['bottom_content'] ?? null;
$top_content = $args['group']['top_content'] ?? null;

$top_large_padding = $args['group']['top_large_padding'] ?? null;
$bottom_padding = $args['group']['bottom_padding'] ?? null;
$gradient_icons = $args['group']['gradient-icons'] ?? null;

$class = 'why section-padding-top bg--gray-gradient';
if ($top_large_padding) {
    $class .= ' section-padding-top--xl ';
}
if ($bottom_padding) {
    $class .= ' section-padding-bottom ';
}
if ($gradient_icons) {
    $class .= ' why--gradient-icons ';
}
?>
<?php if(!is_tax('product_cat')):?>
  <?php $sub = get_sub_field(pathinfo(__FILE__, PATHINFO_FILENAME));
    if (!$sub) {
        ?><link href="<?php echo get_template_directory_uri() ?>/front/build/why.css" rel="stylesheet"><?php
    }
  ?>

  <section class="<?php echo trim($class); ?>">
      <div class="container">
          <?php if ($title) { ?>
              <h2 class="heading-2"><?php echo $title ?></h2>
          <?php } ?>
          <?php if ($top_content) { ?>
              <p class="why__caption"><?php echo $top_content ?></p>
          <?php } ?>
          <?php if ($items) { ?>
              <div class="why__slider custom-navigation">
                  <div class="swiper-container">
                      <ul class="why__list list-reset swiper-wrapper">
                          <?php foreach ($items as $item) {
                              $iIcon = $item['icon'] ?? null;
                              $iTitle = $item['title'] ?? null;
                              $iSubtitle = $item['subtitle'] ?? null;
                              ?>
                              <li class="swiper-slide">
                                  <div class="why__item">
                                      <?php if ($iIcon) { ?>
                                          <div class="why__item-icon">
                                              <picture>
                                                  <?php echo wp_get_attachment_image($iIcon['ID'], 'medium', '', ['alt' => $iIcon['alt'] ?: $iTitle]); ?>
                                              </picture>
                                          </div>
                                      <?php } ?>
                                      <?php if ($iTitle) { ?>
                                          <h3 class="heading-4 why__item-name"><?php echo $iTitle ?></h3>
                                      <?php } ?>
                                      <?php if ($iSubtitle) { ?>
                                          <p class="text-medium item__item-caption"><?php echo $iSubtitle ?></p>
                                      <?php } ?>
                                  </div>
                              </li>
                          <?php } ?>
                      </ul>
                      <div class="custom-navigation__button custom-navigation__button--next custom-navigation__button--next-why"><span class="icon-arrow-up"></span></div>
                      <div class="custom-navigation__button custom-navigation__button--prev custom-navigation__button--prev-why"><span class="icon-arrow-up"></span></div>
                  </div>
                  <?php if ($bottom_content) { ?>
                      <p class="why__caption"><?php echo $bottom_content ?></p>
                  <?php } ?>
              </div>
          <?php } ?>
      </div>
  </section>

<?php else:?>
  <?php 
  if (!$sub) {
      ?><link href="<?php echo get_template_directory_uri() ?>/front/build/catalog-features.css" rel="stylesheet"><?php
  }
  $class = 'catalog-features';
  ?>
  <section class="<?php echo trim($class); ?>">
    <div class="container catalog-features__container">
      <?php if ($title) { ?>
          <h2 class="heading-2 catalog-features__heading"><?php echo $title ?></h2>
      <?php } ?>
      <?php if ($top_content) { ?>
          <div class="catalog-features__text"><p><?php echo $top_content ?></p></div>
      <?php } ?>
      <?php if ($items) { ?>
        <div class="catalog-features__list">
          <?php foreach ($items as $item) {
              $iIcon = $item['icon'] ?? null;
              $iTitle = $item['title'] ?? null;
              $iSubtitle = $item['subtitle'] ?? null;
              ?>
            <div class="feature-card">
              <div class="feature-card__inner">
                <?php if ($iIcon) { ?>
                  <div class="feature-card__wr-ico">
                    <div class="feature-card__ico">
                      <picture>
                        <?php echo wp_get_attachment_image($iIcon['ID'], 'medium', '', ['alt' => $iIcon['alt'] ?: $iTitle]); ?>
                      </picture>
                    </div>
                  </div>
                <?php } ?>
                <?php if ($iTitle) { ?>
                  <div class="feature-card__name"><?php echo $iTitle ?></div>
                <?php } ?>
                <?php if ($iSubtitle) { ?>
                  <div class="feature-card__text">
                    <p><?php echo $iSubtitle ?></p>
                  </div>
                <?php } ?>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php } ?>
      <?php if ($bottom_content) { ?>
        <div class="catalog-features__text">
          <p><?php echo $bottom_content ?></p>
        </div>
      <?php } ?>
    </div>
  </section>

<?php endif;?>