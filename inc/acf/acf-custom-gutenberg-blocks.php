<?php
use StoutLogic\AcfBuilder\FieldsBuilder;
add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types() {

    // Check function exists.
    if( function_exists('acf_register_block_type') ) {

        // register a testimonial block.
        acf_register_block_type(array(
            'name'              => 'cwa_product_recommended',
            'title'             => __('Product Recommended'),
            'description'       => __('CWA custom product recommended block.'),
            'render_template'   => 'template-parts/blocks/product_recommended.php',
            'enqueue_style' =>  '',
            'category'          => 'theme',
            'icon'              => 'admin-comments',
            'keywords'          => array( 'testimonial', 'quote' ),
        ));
    }
}

$product_recommended_block = new FieldsBuilder('product_recommended_block', ['title' => 'Settings']);
$product_recommended_block
    ->addText('title')
    ->addRelationship('select_products', ['max' => 2, 'post_type' => 'product', 'filters' => ['search']])
    ->setLocation('block', '==', 'acf/cwa-product-recommended')
;

add_action('acf/init', function() use ($product_recommended_block) {
    acf_add_local_field_group($product_recommended_block->build());
});