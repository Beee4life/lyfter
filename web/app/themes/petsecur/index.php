<?php
    /**
     * The main template file
     * This is the most generic template file in a WordPress theme
     * and one of the two required files for a theme (the other being style.css).
     * It is used to display a page when nothing more specific matches a query.
     * E.g., it puts together the home page when no home.php file exists
     */

    $context            = Timber::context();
    $context[ 'posts' ] = Timber::get_posts()->to_array();

    Timber::render( 'index.twig', $context );
