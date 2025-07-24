<?php
    /**
     * Search results page
     */

    $context            = Timber::context();
    $context[ 'posts' ] = Timber::get_posts()->to_array();
    $context[ 'title' ] = sprintf( __( 'Search results for: %s', 'boilerplate' ), get_search_query() );
    $templates          = [ 'index.twig', 'archive.twig' ];

    Timber::render( $templates, $context );

