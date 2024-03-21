<?php
require_once 'acf-blocks.php';
use StoutLogic\AcfBuilder\FieldsBuilder;

// Page Builder Dynamic Render Start
$array = array(
	'hero'                        => array(
		'css' => 'hero',
	),
	'products_by_categories'      => array(
		'css' => 'products',
	),
	'four_products_by_categories' => array(
		'css' => 'products',
	),
	'about'                       => array(
		'css' => 'about',
	),
	'brands'                      => array(
		'css' => 'brand',
	),
	'breadcrumbs'                 => array(
		'css' => 'breadcrumb',
	),
	'categories'                  => array(
		'css' => 'categories',
	),
	'contact'                     => array(
		'css' => 'form',
	),
	'content'                     => array(
		'css' => 'kratom',
	),
	'cta'                         => array(
		'css' => 'cta',
	),
	'faq'                         => array(
		'css' => 'faq',
	),
	'features'                    => array(
		'css' => 'why',
	),
	'hero_simple'                 => array(
		'css' => 'hero',
	),
	'image_text'                  => array(
		'css'  => 'infoblock',
		'css2' => 'aboutinfo',
	),
	'info_cards'                  => array(
		'css' => 'vien',
	),
	'reviews'                     => array(
		'css' => 'reviews',
	),
);

$page_builder = new FieldsBuilder( 'page_builder', array( 'title' => 'Settings' ) );
$page_builder->addFlexibleContent(
	'flexible',
	array(
		'acfe_flexible_advanced'           => 1,
		'acfe_flexible_layouts_templates'  => 1,
		'acfe_flexible_layouts_thumbnails' => 1,
		'acfe_flexible_layouts_settings'   => 1,
		'acfe_flexible_modal_edit'         => array(
			'acfe_flexible_modal_edit_enabled' => 1,
		),
		'acfe_flexible_modal'              => array(
			'acfe_flexible_modal_enabled' => 1,
		),
		'acfe_flexible_add_actions'        => array( 'toggle' ),
	)
);
foreach ( $array as $key => $value ) {
	if ( isset( ${$key} ) ) {
		$page_builder->getField( 'flexible' )->addLayout( $key )->addFields( ${$key} );
	}
}
$page_builder->getField( 'flexible' )->endFlexibleContent();
$page_builder->setLocation( 'page_template', '==', 'templates/page-builder.php' );
$page_builder->setGroupConfig(
	'hide_on_screen',
	array(
		'the_content',
		'discussion',
		'comments',
		'author',
		'format',
		'categories',
		'tags',
		'send-trackbacks',
	)
);

add_action(
	'acf/init',
	function() use ( $page_builder ) {
		acf_add_local_field_group( $page_builder->build() );
	}
);
// Page Builder Dynamic Render End

$contact_page = new FieldsBuilder( 'contact_page', array( 'title' => 'Settings' ) );
$contact_page
	->addText( 'title' )
	->addTextarea( 'subtitle' )
	->addWysiwyg( 'info' )
	->addWysiwyg( 'form' )
	->setLocation( 'page_template', '==', 'templates/contact.php' );

$contact_page->setGroupConfig(
	'hide_on_screen',
	array(
		'the_content',
		'discussion',
		'comments',
		'author',
		'format',
		'categories',
		'tags',
		'send-trackbacks',
	)
);

add_action(
	'acf/init',
	function() use ( $contact_page ) {
		acf_add_local_field_group( $contact_page->build() );
	}
);

$products_for_free = new StoutLogic\AcfBuilder\FieldsBuilder( 'products_for_free' );
$products_for_free
	->addText( 'link_name' )
	->addUrl( 'link_url' )
	// ->addRelationship('select_products', ['post_type' => 'product', 'filters' => ['search'], 'return_format' => 'ids'])
	->setLocation( 'post_type', '==', 'product' );

add_action(
	'acf/init',
	function() use ( $products_for_free ) {
		acf_add_local_field_group( $products_for_free->build() );
	}
);
