<?php
    // disable admin email check
    add_filter( 'admin_email_check_interval', '__return_false' );

    /**
     * Unset health test on development
     *
     * @param $tests
     *
     * @return mixed
     */
    function bp_remove_health_tests( $tests ) {
        if ( 'development' == WP_ENV ) {
            unset( $tests[ 'direct' ][ 'theme_version' ] );
            unset( $tests[ 'direct' ][ 'plugin_version' ] );
            unset( $tests[ 'direct' ][ 'php_extensions' ] );
            unset( $tests[ 'direct' ][ 'ssl_support' ] );
            unset( $tests[ 'direct' ][ 'debug_enabled' ] );
            unset( $tests[ 'direct' ][ 'plugin_theme_auto_updates' ] );
            if ( isset( $tests[ 'direct' ][ 'yoast-health-check-page-comments' ] ) ) {
                unset( $tests[ 'direct' ][ 'yoast-health-check-page-comments' ] );
            }
            if ( isset( $tests[ 'direct' ][ 'yoast-health-check-ryte' ] ) ) {
                unset( $tests[ 'direct' ][ 'yoast-health-check-ryte' ] );
            }
            unset( $tests[ 'async' ][ 'background_updates' ] );
            unset( $tests[ 'async' ][ 'https_status' ] );
        }

        return $tests;
    }
    add_filter( 'site_status_tests', 'bp_remove_health_tests' );


    /**
     * For filter 'bp_login_errors', forces single error message on login-errors
     *
     * @return string
     */
    function bp_login_errors() {
        return sprintf( __( '<strong>ERROR</strong> Invalid username or password.<br /><a href="%s">Lost your password</a>?', 'boilerplate' ), wp_lostpassword_url() );
    }
    add_filter( 'login_errors', 'bp_login_errors' );


    /**
     * Add media wrapper to images
     *
     * @param $content
     *
     * @return null|string|string[]
     */
    function bp_add_image_wrapper( $content ) {
        // Add media-wrappers to images
        $content = preg_replace_callback( '/<img[^>]+>/im', function( $matches ) {
            $image   = $matches[ 0 ];
            $classes = array();
            preg_match( '/class="align([^"]+)"/im', $image, $classes );

            $align = ( ! empty( $classes ) ? $classes[ 1 ] : null );
            $class = '';
            if ( in_array( $align, array( 'left', 'right' ) ) ) {
                $class = 'media--align-' . $align;
            }

            return sprintf( '<div class="media %s">%s</div>', $class, $image );
        }, $content );

        // Remove unneccary classes from media-wrappers inside figures
        $content = preg_replace_callback( '/<figure[^>]+>.+<\/figure>/im', function( $matches ) {
            $figure = $matches[ 0 ];

            return preg_replace( '/class="media[^"]+"/im', 'class="media"', $figure );
        }, $content );

        return $content;
    }
    add_filter( 'the_content', 'bp_add_image_wrapper', 99, 1 );
    add_filter( 'acf/format_value/type=wysiwyg', 'bp_add_image_wrapper', 99, 1 );
