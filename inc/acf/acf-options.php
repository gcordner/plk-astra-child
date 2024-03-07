<?php
include_once('acf-blocks.php');
use StoutLogic\AcfBuilder\FieldsBuilder;
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title' 	=> 'General Theme Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false,
        'update_button'		=> __('Save Theme Options', 'acf'),
        'updated_message'	=> __("Theme Update", 'acf'),

    ));

}

$theme_settings = new FieldsBuilder('settings');
$theme_settings
    ->addTab('header')
        ->addText('top_banner')
    ->addTab('footer')
        ->addWysiwyg('newsletter_form')
        ->addWysiwyg('disclaimer')
    ->addTab('contact_information')
        ->addEmail('email')
        ->addText('phone')
        ->addText('address')
        ->addUrl('address_link')
        ->addWysiwyg('work_hours')
    ->addTab('other')
        ->addText('google_map_key')
        ->addImage('favicon')
        ->addImage('autopopup')
    ->addTab('custom_popup')
      ->addTruefalse('custom_popup_enable', ['ui' => 1])
      ->addImage('custom_popup_image')
      ->addText('custom_popup_title')
      ->addDateTimePicker('custom_popup_start_date',['display_format' => 'Y/m/d h:i:s a','return_format' => 'Y/m/d h:i:s a'])
      ->addDateTimePicker('custom_popup_end_date',['display_format' => 'Y/m/d h:i:s a','return_format' => 'Y/m/d h:i:s a'])
    ->addTab('404')
        ->addText('title_404')
        ->addTextarea('subtitle_404')
        ->addLink('link_404')
    ->addTab('default_images')
        ->addImage('default_archive_image')
    ->addTab('product_inner_settings')
        ->addWysiwyg('product_disclaimer')
        ->addRepeater('custom_tooltips', ['layout' => 'block'])
            ->addTextarea('title')
            ->addWysiwyg('tooltip_content')
        ->endRepeater()
    ->setLocation('options_page', '==', 'theme-general-settings');

add_action('acf/init', function() use ($theme_settings) {
    acf_add_local_field_group($theme_settings->build());
});