<?php

    // include files for specific acf hooks
    include 'acf/prepare-field.php';
    include 'acf/validate-value.php';
    include 'acf/wysiwyg.php';

    /**
     * Hide ACF menu on non-dev environments
     *
     * @return bool
     */
    function ps_hide_acf_groups( $value ) {
        if ( defined( 'WP_ENV' ) && 'development' != WP_ENV ) {
            $value = false;
        }

        return $value;
    }
    add_filter( 'acf/settings/show_admin', 'ps_hide_acf_groups' );
