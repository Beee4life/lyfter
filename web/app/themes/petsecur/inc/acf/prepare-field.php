<?php
    function tk_load_image_alignments( $field ) {
        $field[ 'choices' ] = [
            'left'  => __( 'left', 'turnkey' ),
            'right' => __( 'right', 'turnkey' ),
        ];
        
        return $field;
    }
    add_filter( 'acf/prepare_field/key=field_5b9aec10f1f15', 'tk_load_image_alignments' );
    
    
    /**
     * Options for contact block
     *
     * @param $field
     *
     * @return mixed
     */
    function tk_load_contact_block_options( $field ) {
        $options = [
            'phone' => __( 'Phone', 'turnkey' ),
            'form'  => __( 'Form', 'turnkey' ),
        ];
        $field[ 'choices' ] = $options;
        
        return $field;
    }
    add_filter( 'acf/prepare_field/key=field_611ac6fa44549', 'tk_load_contact_block_options' );
