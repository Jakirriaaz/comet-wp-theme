<?php 


add_action('cmb2_admin_init', 'metabox_for_posts');

function metabox_for_posts(){
    
    $box = new_cmb2_box(array(
        'id'            => 'additional-box',
        'object_types'  => array('post'),
        'title'         => __('Additional Fields', 'comet')
    ));
    $box->add_field(array(
        'id'            => '_for-video',
        'type'          => 'oembed',
        'name'          => 'Video URL'
    ));
    $box->add_field(array(
        'id'            => '_for-audio',
        'type'          => 'text',
        'name'          => 'Audio URL'
    ));
    $box->add_field(array(
        'id'            => '_for-gallery',
        'type'          => 'file_list',
        'name'          => 'Gallery Images'
    ));

    $slider = new_cmb2_box(array(
        'title'         => 'Additional Fields',
        'id'            => 'additional-slider',
        'object_types'  => array('comet-slider')
    ));

    $slider->add_field(array(
        'name'          => 'Subtitle',
        'id'            => '_slider-subtitle',
        'type'          => 'text'
    ));
    $slider->add_field(array(
        'name'          => 'First button text',
        'id'            => '_first-button-text-name',
        'type'          => 'text'
    ));
    $slider->add_field(array(
        'name'          => 'First button URL',
        'id'            => '_first-button-url',
        'type'          => 'text'
    ));
    $slider->add_field(array(
        'name'              => 'First Button Type',
        'id'                => '_first-botton-type',
        'type'              => 'select',
        'options'           => array(
            'red'           => 'Red Button',
            'transparent'   => 'Transparent Button'
        )
    ));
}

?>