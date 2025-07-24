<?php
    /**
     * Add a custom function to Twig
     *
     * @param $functions
     *
     * @return
     */
    function bp_add_to_twig( $functions ) {
        $functions['get_block_classes']  = [ 'callable' => 'tk_get_block_classes' ];
        $functions['get_block_style']    = [ 'callable' => 'tk_get_block_style' ];

        return $functions;
    }
    add_filter( 'timber/twig/functions', 'bp_add_to_twig' );
    
    
    /**
     * Return block classes
     *
     * @param $block
     * @param $modifier
     *
     * @return string
     */
    function tk_get_block_classes( $block, $modifier = false, $loop_count = 1 ) {
        $classes = [ 'block' ];

        // general
        if ( false !== $modifier ) {
            $classes[] = 'block--' . $modifier;
        }
        
        if ( isset( $block[ 'text_alignment' ] ) ) {
            $classes[] = 'block--' . $block[ 'text_alignment' ];
        }
        
        if ( ! empty( $block[ 'center_content' ] ) ) {
            $classes[] = 'block--center';
        }
        
        if ( ! empty( $block[ 'add_border' ] ) ) {
            $classes[] = 'has-border';
            
            if ( isset( $block[ 'border_style' ] ) ) {
                $classes[] = $block[ 'border_style' ];
            } else {
                $classes[] = 'solid';
            }
        }
        
        
        // block specific
        if ( 'cta' !== $modifier && ! empty( $block[ 'background_color' ] ) ) {
            $classes[] = 'has-background-color';
        }
        
        if ( 'columns' == $modifier && ! empty( $block[ 'add_border' ] ) ) {
            if ( isset( $block[ 'border_around' ] ) ) {
                $classes[] = 'around-' . $block[ 'border_around' ];
            } else {
                $classes[] = 'around-block';
            }
            
        } elseif ( 'contact' == $modifier ) {
            if ( isset( $block[ 'header' ] ) || isset( $block[ 'text' ] ) ) {
                $classes[] = 'with-text';
            }
            if ( isset( $block[ 'button_position' ] ) && 'left' == $block[ 'button_position' ] ) {
                $classes[] = 'buttons-left';
            }
            
        } elseif ( 'cta' == $modifier ) {
            if ( ! empty( $block[ 'background_type' ] ) ) {
                switch( $block[ 'background_type' ] ) {
                    case 'color':
                        $classes[] = 'has-background-color';
                        break;
                    case 'image':
                        if ( ! empty( $block[ 'cta_image' ] ) ) {
                            $classes[] = 'has-background-image';
                        }
                        break;
                    default:
                        $classes[] = '';
                }
            }
            if ( isset( $block[ 'image_position' ] ) && 'right' == $block[ 'image_position' ] ) {
                $classes[] = 'block--image-right';
            }
            
        } elseif ( 'image-text' == $modifier ) {
            if ( isset( $block[ 'column_width' ] ) ) {
                $classes[] = 'block--w' . $block[ 'column_width' ];
            } else {
                $classes[] = 'block--w5050';
            }
            if ( isset( $block[ 'image_position' ] ) ) {
                $classes[] = 'image--' . $block[ 'image_position' ];
            } else {
                $classes[] = 'image--left';
            }
            
        } elseif ( 'video' == $modifier ) {
            if ( isset( $block[ 'video_width' ] ) ) {
                if ( 'fullwidth' == $block[ 'video_width' ] ) {
                    $classes[] = 'block--fullwidth';
                } elseif ( '50%' == $block[ 'video_width' ] ) {
                    $classes[] = 'block--half-container';
                }
            }
        }
        
        return trim( implode( ' ', $classes ) );
    }
    
    
    /**
     * Output block style
     *
     * @param $block
     * @param $image_src
     *
     * @return void'
     */
    function tk_get_block_style( $block = false, $image_src = false ) {
        $style = [];
        if ( 'block_cta' == $block[ 'acf_fc_layout' ] ) {
            if ( '' !== $block[ 'background_type' ] ) {
                if ( 'color' == $block[ 'background_type' ] && ! empty( $block[ 'background_color' ] ) ) {
                    $style[] = sprintf( 'background-color: %s;', $block[ 'background_color' ] );
                    
                } elseif ( 'image' == $block[ 'background_type' ] && $image_src ) {
                    $style[] = sprintf( 'background-image: url(%s);', $image_src );
                    $style[] = 'background-repeat: no-repeat;';
                }
            }
            if ( ! empty( $block[ 'font_color' ] ) ) {
                $style[] = sprintf( 'color: %s;', $block[ 'font_color' ] );
            }
        } elseif ( ! empty( $block[ 'background_color' ] ) ) {
            if ( ! empty( $block[ 'transparency' ] ) ) {
                // hex to rgba
                $trimmed         = trim( $block[ 'background_color' ], '#' );
                $split_hex_color = str_split( $trimmed, 2 );
                $rgb1            = hexdec( $split_hex_color[ 0 ] );
                $rgb2            = hexdec( $split_hex_color[ 1 ] );
                $rgb3            = hexdec( $split_hex_color[ 2 ] );
                $transparency    = ( 100 - $block[ 'transparency' ] ) / 100;
                $color           = sprintf( 'rgba(%s,%s,%s,%s)', $rgb1, $rgb2, $rgb3, $transparency );
            } else {
                $color = $block[ 'background_color' ];
            }
            $style[] = sprintf( 'background-color: %s;', $color );
        }
        
        if ( ! empty( $style ) ) {
            $style_string = implode( ' ', $style );
            echo sprintf( 'style="%s"', $style_string );
        }
    }
