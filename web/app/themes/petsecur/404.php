<?php
    /**
     *  The 404 template file
     */

    $context            = Timber::context();
    $context[ 'title' ] = __( '404', 'boilerplate' );

    Timber::render( 'pages/404.twig', $context );
