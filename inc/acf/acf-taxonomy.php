<?php
use StoutLogic\AcfBuilder\FieldsBuilder;
//Example
$taxonomy_categories = new FieldsBuilder('taxonomy_categories', ['title' => 'Settings', 'position' => 'acf_after_title']);
$taxonomy_categories
    ->addImage('hero_image')
        ->setWidth(50)
    ->addColorPicker('title_color', ['instructions' => 'Use On Home Page'])
        ->setWidth(50)
    ->addFlexibleContent('flexible')
        ->addLayout('content')
            ->addFields($content)
        ->addLayout('category_content')
            ->addFields($category_content)
        ->addLayout('image_text')
            ->addFields($image_text)
        ->addLayout('features')
            ->addFields($features)
        ->addLayout('faq')
            ->addFields($faq)
    ->endFlexibleContent()
    ->setLocation('taxonomy', '==', 'product_cat')
;

add_action('acf/init', function() use ($taxonomy_categories) {
    acf_add_local_field_group($taxonomy_categories->build());
});