<?php
    /**
     * Boilerplate functions and definitions
     */

    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    use Timber\Site;

    if ( ! class_exists( 'acf' ) ) {
        add_action( 'admin_notices', function() {
            echo sprintf( '<div class="error"><p>%s is not activated. Some theme functions will not run until you activate the plugin <a href="%s">%s</a>.</p></div>',
                'Advanced Custom Fields', esc_url( admin_url( 'plugins.php?s=acf' ) ),
                'here' );
        } );
    }

    if ( ! class_exists( 'BoilerPlateTheme' ) && class_exists( 'Timber\Site' ) ) :

        /**
         * Main class
         */
        class BoilerPlateTheme extends Site {
            var $settings;
            var $options;

            public function __construct( $site_name_or_id = null ) {
                parent::__construct( $site_name_or_id );

                $this->settings = [
                    'path'    => trailingslashit( dirname( __FILE__ ) ),
                    'version' => wp_get_theme()->Version,
                ];

                // Actions
                add_action( 'after_setup_theme',        [ $this, 'bp_after_setup_theme' ] );
                add_action( 'wp_enqueue_scripts',       [ $this, 'bp_enqueue_libraries' ] );
                add_action( 'wp_enqueue_scripts',       [ $this, 'bp_enqueue_scripts_frontend' ] );
                add_action( 'admin_enqueue_scripts',    [ $this, 'bp_enqueue_admin_css' ] );
                add_action( 'admin_enqueue_scripts',    [ $this, 'bp_enqueue_css_after_plugins' ] );

                // Filters
                add_filter( 'timber/context',           [ $this, 'bp_add_to_context' ] );

                include 'inc/functions-acf.php';
                include 'inc/admin-menus.php';
                include 'inc/filters.php';
                include 'inc/twig-functions.php';
                include 'inc/widgets.php';
            }


            /**
             * Register theme stuff
             */
            public function bp_after_setup_theme() {
                // Theme
                add_theme_support( 'post-thumbnails' );
                add_theme_support( 'title-tag' );
                add_theme_support( 'html5', [ 'search-form', 'gallery', 'caption' ] );

                // Menus
                register_nav_menus( [
                    'menu_main'    => __( 'Main navigation', 'boilerplate' ),
                    'menu_foldout' => __( 'Fold out navigation', 'boilerplate' ),
                    'menu_footer'  => __( 'Footer navigation', 'boilerplate' ),
                ] );
            }


            /**
             * Enqueue styles/scripts
             */
            public function bp_enqueue_libraries() {
                // Update jQuery in frontend
                if ( ! is_admin() ) {
                    wp_deregister_script( 'jquery' ); // Deregister the included library
                    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', [], '2.1.4', true );
                }

                wp_register_style( 'googleFonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap' );
                wp_enqueue_style( 'googleFonts' );
            }


            /**
             * Enqueue styles/scripts
             */
            public function bp_enqueue_scripts_frontend() {
                if ( file_exists( get_stylesheet_directory() . '/assets/css/style.min.css' ) ) {
                    wp_enqueue_style( 'bp-style', get_template_directory_uri() . '/assets/css/style.min.css', [], $this->file_version( 'assets/css/style.min.css' ) );
                }

                if ( file_exists( get_stylesheet_directory() . '/assets/js/main.min.js' ) ) {
                    wp_enqueue_script( 'bp-js', get_stylesheet_directory_uri() . '/assets/js/main.min.js', [ 'jquery' ], $this->file_version( 'assets/js/main.min.js' ) );
                }
            }


            /**
             *  Enqueue scripts on back-end
             */
            public function bp_enqueue_admin_css() {
                // if css is generated use that file
                if ( file_exists( get_stylesheet_directory() . '/assets/css/admin.min.css' ) ) {
                    wp_enqueue_style( 'bp-admin', get_stylesheet_directory_uri() . '/assets/css/admin.min.css', '', $this->file_version( 'assets/css/admin.min.css' ) );
                }
            }


            /**
             *  Enqueue css after plugins
             *
             *  This css contains plugin 'overrides'
             */
            public function bp_enqueue_css_after_plugins() {
                if ( file_exists( get_stylesheet_directory() . '/assets/css/plugins.min.css' ) ) {
                    wp_enqueue_style( 'bp-plugins', get_stylesheet_directory_uri() . '/assets/css/plugins.min.css', [], $this->file_version( 'assets/css/plugins.min.css' ) );
                }
            }



            /**
             * Add stuff to global $context (each page load)
             * Should only be 'allowed' when Timber is active
             *
             * @param $context
             *
             * @return mixed
             */
            public function bp_add_to_context( $context ) {
                $context[ 'site' ]         = $this;
                $context[ 'menu_main' ]    = Timber::get_menu( 'menu_main' );
                $context[ 'menu_foldout' ] = Timber::get_menu( 'menu_foldout' );
                $context[ 'menu_footer' ]  = Timber::get_menu( 'menu_footer' );
                $context[ 'options' ]      = $this->retrieve_theme_options();
                
                return $context;
            }


            /**
             * Get theme options
             *
             * @return array
             */
            public function retrieve_theme_options() {
                $all_options = [];
                if ( class_exists( 'acf' ) ) {
                    $all_options = get_fields( 'options' );
                }

                $options[ 'google' ] = [
                    'tag_manager_code' => isset( $all_options[ 'bp_gtm_id' ] ) ? $all_options[ 'bp_gtm_id' ] : false,
                ];

                $options[ 'fallback_images' ] = [
                    'default' => 'https://unsplash.it/600/300',
                ];

                return $options;
            }


            /**
             * Returns a file-versionnumber for given file
             *
             * @param   string $file file-path relative from template-directory
             *
             * @return  bool|int|string
             */
            public function file_version( $file ) {
                $hash = false;

                if ( $file ) {
                    $path = $this->settings[ 'path' ] . $file;
                    $hash = hash_file( 'md5', $path );
                }

                return $hash;
            }
        }

        Timber\Timber::init();

        /**
         * The main function responsible for returning the one true BoilerPlateTheme instance to functions everywhere.
         *
         * @return \BoilerPlateTheme
         */
        function boilerplate_theme() {
            global $boilerplate;

            if ( ! isset( $boilerplate ) ) {
                $boilerplate = new BoilerPlateTheme();
            }

            return $boilerplate;
        }

        // initialize
        boilerplate_theme();

    endif; // class_exists check
