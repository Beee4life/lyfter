<?php
    /**
     * Override wysiwyg editor (to override height)
     *
     * SRC: https://support.advancedcustomfields.com/forums/topic/set-wysiwyg-height/#post-122675
     */
    new AcfTextarea();

    class AcfTextarea {
        public function __construct() {
            add_action( 'acf/render_field_settings',        [ $this, 'addSettingsForWysiwyg' ] );
            add_filter( 'acf/render_field/type=wysiwyg',    [ $this, 'preRenderWysiwygField' ], 0, 1 );
        }

        public function addSettingsForWysiwyg( $field ) {
            if ( $field[ 'type' ] !== 'wysiwyg' ) {
                return;
            }

            $field_args = [
                'label' => 'Limit height of TinyMCE?',
                'name'  => 'wpf_tinymce_low',
                'type'  => 'true_false',
                'ui'    => 1,
            ];
            acf_render_field_setting( $field, $field_args, true );
        }

        public function preRenderWysiwygField( $field ) {
            if ( ! isset( $field[ 'wpf_tinymce_low' ] ) || ! $field[ 'wpf_tinymce_low' ] ) {
                return;
            }

            ob_start();
            add_filter( 'acf/render_field/type=wysiwyg', [ $this, 'afterRenderWysiwygField' ], 20, 1 );
        }

        public function afterRenderWysiwygField( $field ) {
            remove_filter( 'acf/render_field/type=wysiwyg', [ $this, 'afterRenderWysiwygField' ], 20, 1 );

            $output = ob_get_contents();
            $output = str_replace( 'height:300px;', 'height:50px;', $output );

            ob_end_clean();
            echo $output;
        }
    }
