<?php

/*
* Filter image caption for masonary gallery type 4
*
*/


add_filter('wpestate_image_excerpt', 'wpestate_modify_image_excerpt',10,1);
function wpestate_modify_image_excerpt($post_thumbnail_id) {
   
    return get_the_excerpt($post_thumbnail_id) ;
}



/*
* Filter for datepicker calendar option
*
*/
add_filter('wpestate_datepicker_language', 'wpestate_datepicker_language_function',10,0);
function wpestate_datepicker_language_function() {
    return $date_lang_status= esc_html ( wprentals_get_option('wp_estate_date_lang','') );
   
}




/*
*
*
*/




/*
*
*
*/
