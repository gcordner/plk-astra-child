<?php
/**
 * Establishes ACF fields and field groups
 *
 * @package PLK
 */

$hero = new StoutLogic\AcfBuilder\FieldsBuilder( 'hero' );
$hero
	->addGroup( 'hero', array( 'label' => '' ) )
	->addButtonGroup(
		'type',
		array(
			'choices' => array(
				'type_1' => 'Image Right',
				'type_2' => 'Big Parallax Image',
			),
		)
	)
	->addImage( 'image' )
	->setWidth( 50 )
	->addImage( 'promo_image' )
	->setWidth( 50 )
	->conditional( 'type', '==', 'type_1' )
	->addText( 'promo_link' )
	->conditional( 'type', '==', 'type_1' )
	->addText( 'promo_button_text' )
	->conditional( 'promo_link', '!=', '' )
	->addColorPicker( 'bg_color' )
	->setWidth( 50 )
	->addTruefalse( 'promo_wide', array( 'ui' => 1 ) )
	->setWidth( 50 )
	->conditional( 'type', '==', 'type_1' )
	->addImage( 'small_right_image' )
	->setWidth( 50 )
	->conditional( 'type', '==', 'type_2' )
	->addImage( 'small_bottom_image' )
	->setWidth( 50 )
	->conditional( 'type', '==', 'type_2' )
	->addTruefalse( 'expand_image', array( 'ui' => 1 ) )
	->setWidth( 50 )
	->conditional( 'type', '==', 'type_1' )
	->addTruefalse( 'enable_star', array( 'ui' => 1 ) )
	->setWidth( 50 )
	->conditional( 'type', '==', 'type_1' )
	->addText( 'star_number' )
	->setWidth( 50 )
	->conditional( 'enable_star', '==', 1 )
	->and( 'type', '==', 'type_1' )
	->addText( 'star_text' )
	->setWidth( 50 )
	->conditional( 'enable_star', '==', 1 )
	->and( 'type', '==', 'type_1' )
	->addText( 'title' )
	->addText( 'subtitle' )
	->addTextarea( 'description' )
	->addLink( 'link' )
	->endGroup();

$products_by_categories = new StoutLogic\AcfBuilder\FieldsBuilder( 'products_by_categories' );
$products_by_categories
	->addGroup( 'products_by_categories', array( 'label' => '' ) )
	->addText( 'title' )
	->addTrueFalse( 'background', array( 'ui' => 1 ) )
	->addRelationship(
		'select_products',
		array(
			'post_type'     => 'product',
			'filters'       => array( 'search' ),
			'return_format' => 'ids',
		)
	)
	->addField( 'select_category', 'acfe_taxonomy_terms' )
	->setConfig( 'taxonomy', array( 'product_cat' ) )
	->setConfig( 'field_type', 'select' )
	->setConfig( 'ui', 1 )
	->setConfig( 'multiple', 0 )
	->setConfig( 'allow_null', 1 )
	->addLink( 'view_all_link' )
	->endGroup();

	$four_products_by_categories = new StoutLogic\AcfBuilder\FieldsBuilder( 'four_products_by_categories' );
	$four_products_by_categories
		->addGroup( 'four_products_by_categories', array( 'label' => '' ) )
		->addText( 'title' )
		->addTrueFalse( 'background', array( 'ui' => 1 ) )
		->addRelationship(
			'select_products',
			array(
				'post_type'     => 'product',
				'filters'       => array( 'search' ),
				'return_format' => 'ids',
			)
		)
		->addField( 'select_category', 'acfe_taxonomy_terms' )
		->setConfig( 'taxonomy', array( 'product_cat' ) )
		->setConfig( 'field_type', 'select' )
		->setConfig( 'ui', 1 )
		->setConfig( 'multiple', 0 )
		->setConfig( 'allow_null', 1 )
		->addLink( 'view_all_link' )
		->endGroup();

	$categories = new StoutLogic\AcfBuilder\FieldsBuilder( 'categories' );
	$categories
	->addGroup( 'categories', array( 'label' => '' ) )
	->addText( 'title' )
	->addLink( 'view_all_link' )
	->addField( 'select_categories', 'acfe_taxonomy_terms' )
	->setConfig( 'taxonomy', array( 'product_cat' ) )
	->setConfig( 'field_type', 'select' )
	->setConfig( 'ui', 1 )
	->setConfig( 'multiple', 1 )
	->setConfig( 'allow_null', 1 )
	->endGroup();

	$image_text = new StoutLogic\AcfBuilder\FieldsBuilder( 'image_text' );
	$image_text
	->addGroup( 'image_text', array( 'label' => '' ) )

	->addTruefalse( 'big_image', array( 'ui' => 1 ) )
	->addTruefalse( 'reverse', array( 'ui' => 1 ) )
		->conditional( 'big_image', '!=', 1 )
	->setWidth( 50 )
	->addImage( 'image' )
		->setWidth( 50 )
	->addImage( 'small_image' )
		->conditional( 'big_image', '!=', 1 )
		->and( 'reverse', '!=', 1 )
	->addTrueFalse(
		'mobile_image_down',
		array(
			'ui'    => 1,
			'label' => 'Move image to Bottom on mobile',
		)
	)
		->conditional( 'big_image', '!=', 1 )
		->and( 'reverse', '!=', 1 )
	->addText( 'title' )
	->addWysiwyg( 'text' )
	->addLink( 'link' )
	->endGroup();

	$features = new StoutLogic\AcfBuilder\FieldsBuilder( 'features' );
	$features
	->addGroup( 'features', array( 'label' => '' ) )
	->addTrueFalse( 'top_large_padding', array( 'ui' => 1 ) )
		->setWidth( 33 )
	->addTrueFalse( 'bottom_padding', array( 'ui' => 1 ) )
		->setWidth( 33 )
	->addTrueFalse( 'gradient_icons', array( 'ui' => 1 ) )
		->setWidth( 33 )
	->addText( 'title' )
	->addTextarea( 'top_content' )
	->addRepeater( 'items' )
	->addImage( 'icon' )
	->addText( 'title' )
	->addText( 'subtitle' )
	->endRepeater()
	->addTextarea( 'bottom_content' )
	->endGroup();

	$info_cards = new StoutLogic\AcfBuilder\FieldsBuilder( 'info_cards' );
	$info_cards
	->addGroup( 'info_cards', array( 'label' => '' ) )
	->addText( 'title' )
	->addRepeater( 'cards', array( 'layout' => 'block' ) )
	->addImage( 'image' )
	->addText( 'title' )
	->addButtonGroup(
		'color',
		array(
			'choices'       => array(
				'vien__item-ul--red'    => 'Red',
				'vien__item-ul--white'  => 'Blue',
				'vien__item-ul--green'  => 'Green',
				'vien__item-ul--yellow' => 'Yellow',
			),
			'default_value' => 'vien__item-ul--green',
		)
	)
	->addRepeater( 'items', array( 'layout' => 'block' ) )
	->addSelect(
		'icon',
		array(
			'choices'    => array(
				'icon-pain'     => 'Pain',
				'icon-sleep'    => 'Sleep',
				'icon-opiate'   => 'Opiate',
				'icon-stress'   => 'Stress',
				'icon-stimul'   => 'Stimulation',
				'icon-energy'   => 'Energy',
				'icon-smile'    => 'Smile',
				'icon-relax'    => 'Relax',
				'icon-detox'    => 'Detox',
				'icon-euphoria' => 'Euphoria',
				'icon-moon'     => 'Insomnia',
				'icon-mellow'   => 'Mellow',
			),
			'allow_null' => 1,
		)
	)
	->addText( 'name' )
	->endRepeater()
	->addLink( 'link' )
	->endRepeater()
	->endGroup();

	$brands = new StoutLogic\AcfBuilder\FieldsBuilder( 'brands' );
	$brands
	->addGroup( 'brands', array( 'label' => '' ) )
	->addText( 'title' )
	->addTextarea( 'subtitle' )
	->addField( 'select_categories', 'acfe_taxonomy_terms' )
	->setConfig( 'taxonomy', array( 'product_cat' ) )
	->setConfig( 'field_type', 'select' )
	->setConfig( 'ui', 1 )
	->setConfig( 'multiple', 1 )
	->setConfig( 'allow_null', 1 )
	->addLink( 'view_all_link' )
	->endGroup();

	$reviews = new StoutLogic\AcfBuilder\FieldsBuilder( 'reviews' );
	$reviews
	->addGroup( 'reviews', array( 'label' => '' ) )
	->addTruefalse( 'padding_top', array( 'ui' => 1 ) )
	->addText( 'title' )
	->addTextarea( 'reviews_code' )
	->endGroup();

	$about = new StoutLogic\AcfBuilder\FieldsBuilder( 'about' );
	$about
	->addGroup( 'about', array( 'label' => '' ) )
	->addText( 'title' )
	->addText( 'subtitle' )
	->addImage( 'big_image' )
	->setWidth( 33 )
	->addImage( 'small_image' )
	->setWidth( 33 )
	->addImage( 'right_image' )
	->setWidth( 34 )
	->addWysiwyg( 'content' )
	->addLink( 'link' )
	->endGroup();

	$faq = new StoutLogic\AcfBuilder\FieldsBuilder( 'faq' );
	$faq
	->addGroup( 'faq', array( 'label' => '' ) )
	->addText( 'title' )
	->setWidth( 50 )
	->addSelect(
		'heading_tag',
		array(
			'choices'       => array(
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
			),
			'default_value' => 'h1',
		)
	)
	->setWidth( 50 )
	->addRepeater( 'items', array( 'layout' => 'block' ) )
	->addText( 'question' )
	->addWysiwyg( 'answer' )
	->endRepeater()
	->endGroup();

	$cta = new StoutLogic\AcfBuilder\FieldsBuilder( 'cta' );
	$cta
	->addGroup( 'cta', array( 'label' => '' ) )
	->addButtonGroup(
		'color',
		array(
			'choices'       => array(
				'background--gray' => 'Gray',
				'background--warm' => 'Yellow',
			),
			'default_value' => 'background--gray',
		)
	)
	->setWidth( 50 )
	->addTruefalse( 'padding_top', array( 'ui' => 1 ) )
	->setWidth( 50 )
	->addImage( 'image' )
	->addText( 'title' )
	->addTextarea( 'subtitle' )
	->addLink( 'link' )
	->addWysiwyg( 'bottom_content' )
	->endGroup();

	$breadcrumbs = new StoutLogic\AcfBuilder\FieldsBuilder( 'breadcrumbs' );
	$breadcrumbs
	->addGroup( 'breadcrumbs', array( 'label' => '' ) )
	->addButtonGroup(
		'color',
		array(
			'choices'       => array(
				'background--warm-contrast' => 'Yellow',
				'background--gray'          => 'Gray',
				''                          => 'White',
			),
			'default_value' => 'background--warm-contrast',
		)
	)
	->endGroup();

	$contact = new StoutLogic\AcfBuilder\FieldsBuilder( 'contact' );
	$contact
	->addGroup( 'contact', array( 'label' => '' ) )
	->addText( 'title' )
	->addTextarea( 'subtitle' )
	->addWysiwyg( 'form' )
	->addImage( 'image' )
	->endGroup();

	$content = new StoutLogic\AcfBuilder\FieldsBuilder( 'content' );
	$content
	->addGroup( 'content', array( 'label' => '' ) )
	->addText( 'title' )
	->addWysiwyg( 'text' )
	->endGroup();
	// Register the field group with ACF.
	acf_add_local_field_group( $content->build() );

	$category_content = new StoutLogic\AcfBuilder\FieldsBuilder( 'category_content' );
	$category_content
	->addGroup( 'category_content', array( 'label' => '' ) )
	->addTruefalse( 'image_then_content', array( 'ui' => 1 ) )
	->addTruefalse( 'bottom_padding', array( 'ui' => 1 ) )
	->addText( 'title' )
	->addWysiwyg( 'text' )
	->addImage( 'image' )
	->endGroup();
