<?php
    /**
     * Check social fields which only need a username
     *
     * @param $valid
     * @param $value
     * @param $field
     * @param $input
     *
     * @return mixed|string|true|null
     */
    function bp_check_socials( $valid, $value, $field, $input ) {
        // Bail early if value is already invalid.
        if( $valid !== true ) {
            return $valid;
        }
        
        if ( strpos( $value, '@' ) !== false ) {
            return __( 'Your username should not start with a @.', 'boilerplate' );
        }
        
        return $valid;
    }
    add_filter( 'acf/validate_value/key=field_60bba6ba616cb', 'bp_check_socials', 25, 4 );
    add_filter( 'acf/validate_value/key=field_60bba6ac616ca', 'bp_check_socials', 25, 4 );
