<?php
add_filter( 'vc_iconpicker-type-ktcustomfonts', 'kutetheme_ovic_iconpicker_type_ktcustomfonts' );
if( !function_exists( 'kutetheme_ovic_iconpicker_type_ktcustomfonts' ) ) {
    function kutetheme_ovic_iconpicker_type_ktcustomfonts($icons){
        $ktcustomfonts_icons = array(
            array('flaticon-arrow' => 'Flaticon circle time'),
            array('flaticon-arrows' => 'Flaticon circle arrow left'),
            array('flaticon-arrows-1' => 'Flaticon circle arrow right'),
            array('flaticon-left-arrow' => 'Flaticon arrow left'),
            array('flaticon-right-arrow' => 'Flaticon arrow right'),
            array('flaticon-bag' => 'Flaticon cart'),
            array('flaticon-bars' => 'Flaticon bars'),
            array('flaticon-magnifying-glass' => 'Flaticon find'),
            array('flaticon-repeat-button' => 'Flaticon compare'),
            array('flaticon-shape' => 'Flaticon user'),
            array('flaticon-shape-1' => 'Flaticon wishlist'),
            array('flaticon-shield' => 'Flaticon shield'),
            array('flaticon-interface' => 'Flaticon list view'),
            array('flaticon-squares' => 'Flaticon grid view'),
            array('flaticon-checked'   =>  'Flaticon checked'),
            array('flaticon-link'       =>  'Flaticon Link'),
            array('flaticon-transport'       =>  'Flaticon Transport'),
        );
        return array_merge($icons, $ktcustomfonts_icons);
    }
}
