<?php
    // remove dashboard widgets
    function bp_remove_dashboard_meta() {
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );    // wp news
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // quick draft
        remove_action( 'welcome_panel', 'wp_welcome_panel' );
    }
    add_action( 'admin_init', 'bp_remove_dashboard_meta' );
