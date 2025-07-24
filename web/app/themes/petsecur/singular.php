<?php
    /**
     * The Template for displaying all single posts
     */

    $context     = Timber::context();
    $post_object = Timber::get_post()->setup();
    $post_id     = $post_object->ID;
    $templates   = [ sprintf( 'pages/page-%s.twig', $post_id ), 'singular.twig' ];

    if ( class_exists( 'acf' ) ) {
        $fields = get_fields( $post_id );
    }
    $context[ 'post' ]         = $post_object;
    $context[ 'blocks' ]      = ! empty( $fields[ 'ea_blocks' ] ) ? $fields[ 'ea_blocks' ] : false;
    $context[ 'hide_header' ]  = ! empty( $fields[ 'bp_hide_header' ] ) ? $fields[ 'bp_hide_header' ] : false;
    $context[ 'show_sidebar' ] = true;

    Timber::render( $templates, $context );
