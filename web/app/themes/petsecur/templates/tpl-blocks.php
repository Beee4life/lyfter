<?php
    /**
     * Template Name: Blocks
     */
    
    $context           = Timber::context();
    $post_object       = Timber::get_post()->setup();
    $post_id           = $post_object->ID;
    $templates         = [ 'pages/page--blocks.twig' ];
    $context[ 'post' ] = $post_object;
    
    if ( class_exists( 'acf' ) ) {
        $fields = get_fields( $post_id );
    }
    $context[ 'blocks' ]      = ! empty( $fields[ 'ea_blocks' ] ) ? $fields[ 'ea_blocks' ] : false;
    $context[ 'hide_header' ] = ! empty( $fields[ 'bp_hide_header' ] ) ? $fields[ 'bp_hide_header' ] : false;
    
    $context[ 'intro' ] = [
        'page_label' => ! empty( $fields[ 'ea_page_label' ] ) ? $fields[ 'ea_page_label' ] : false,
        'title'      => 'Everyday Convenience',
        'buttons'    => [
            [
                'link'  => '/link1',
                'label' => 'Buy Lifter garage',
                'icon'  => '',
            ],
            [
                'link'  => '/link2',
                'label' => 'Download the app',
                'icon'  => '',
            ],
        ],
    ];
    
    Timber::render( $templates, $context );
