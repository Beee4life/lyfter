<?php
    /**
     * Remove admin bar for users
     */
    function bp_remove_admin_bar( $value ) {
        if ( ! current_user_can( 'manage_options' ) ) {
            return false;
        }
        return $value;
    }
    add_filter( 'show_admin_bar', 'bp_remove_admin_bar' );
