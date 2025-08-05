<?php

if(!function_exists('wpestate_global_check_mandatory')):
function wpestate_global_check_mandatory($post_id){

    $mandatory_fields           =   ( wprentals_get_option('wp_estate_mandatory_page_fields','') );
    
    if( empty($mandatory_fields)){
        return;
    }
    
    $admin_submission_status= esc_html ( wprentals_get_option('wp_estate_admin_submission','') );
    if($admin_submission_status=='yes' ){ // anmin validate submission so no mandatory check is required
        return;
    }
    

            
    $new_status='publish';

    $paid_submission_status = esc_html ( wprentals_get_option('wp_estate_paid_submission','') );

    if($paid_submission_status=='per listing'){
        $admin_submission_status = esc_html ( wprentals_get_option('wp_estate_admin_submission','') );
        $pay_status    = get_post_meta($post_id, 'pay_status', true);

     
        if($admin_submission_status=='yes' ){
            $new_status             = 'pending';
        } 
        if($pay_status !='paid' ){
            $new_status             = 'pending'; 
        }
    }
    


    $terms = wpestate_get_cached_terms('property_features');
    foreach($terms as $key => $term){
        $feature_list_array_1[]=$term->slug ;     
    }

    
    $custom_fields = wprentals_get_option('wpestate_custom_fields_list','');
    $custom_fields_1=array();
    $i=0;
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
            $name               =   stripslashes($custom_fields[$i][0]);
            $slug               =   str_replace(' ','-',$name);
            $label              =  stripslashes( $custom_fields[$i][1] );
           
            $slug   =   htmlspecialchars ( $slug ,ENT_QUOTES);
            $slug   =   wpestate_limit45(sanitize_title( $slug ));
            $slug   =   sanitize_key($slug);
            $custom_fields_1[]= strtolower($slug);
            $i++;
       }
    }
   
    

  
    foreach ( $mandatory_fields as $key=>$value ){

        if( $value=='prop_category_submit'  || $value=='prop_action_category_submit'   || $value=='property_city_front'   || $value=='property_area_front'   ){

            if($value=='prop_category_submit'){
                $value='property_category';
            }else  if($value=='prop_action_category_submit'){
                $value = 'property_action_category';
            }else  if($value=='property_city_front'){
                $value = 'property_city';    
            }else  if($value=='property_area_front'){
                $value = 'property_area';
            }
            
            
            $terms = wp_get_post_terms( $post_id, $value ); 
            if(!isset($terms [0])){
                $new_status='pending';
            }
        
            
        }else if($value=='title'){
            $title= get_the_title($post_id);
            if($title==''){
                $new_status='pending';
            }
        }else if($value=='property_description'){
            $content_post = get_post($post_id);
            $content = $content_post->post_content;
            if($content==''){
                $new_status='pending';
            }

        }else if (is_array ($feature_list_array_1) && in_array($value, $feature_list_array_1)  ){
            $post_var_name=$value;
            $terms = intval(get_post_meta($post_id,$post_var_name,true));
            if (!has_term( $post_var_name, 'property_features',$post_id )  ) {
                $new_status='pending';
            }

            
        }else if ( in_array($value, $custom_fields_1)  ){
            $terms = get_post_meta($post_id,$value,true);
            if($terms==''){
                $new_status='pending';
            }
        }else if ( $value=='attachid' ){   
            if(!has_post_thumbnail($post_id)){
                $new_status='pending';
            }
        }else{
            
            $terms = get_post_meta($post_id,$value,true);
            if($terms==''){
                
                $new_status='pending';
            }
        }
        
    }


        $my_post = array(
            'ID'            => $post_id,
            'post_status'   => $new_status
        );
        wp_update_post( $my_post );
    
        return $new_status;
}
endif;




if(!function_exists('wpestate_price_default_convert') ):
function wpestate_price_default_convert($price){
    
    $custom_fields = wprentals_get_option('wpestate_currency',''); 
    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i=intval($_COOKIE['my_custom_curr_pos']);
        return $price* $custom_fields[$i][2];
    } else{
        return $price;
    }
}
endif;


if( !function_exists('wpestate_show_price_label_slider') ):
function wpestate_show_price_label_slider($min_price_slider,$max_price_slider,$wpestate_currency,$wpestate_where_currency){
    $th_separator       =   wprentals_get_option('wp_estate_prices_th_separator','');
    $custom_fields = wprentals_get_option('wpestate_currency',''); 
  
    if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
        $i=intval($_COOKIE['my_custom_curr_pos']);
        $wpestate_currency  =   $custom_fields[$i][1];
        $min_price_slider   =   number_format($min_price_slider,0,'.',$th_separator);
        $max_price_slider   =   number_format($max_price_slider,0,'.',$th_separator);
        
        if ($custom_fields[$i][3] == 'before') {  
            $price_slider_label = $wpestate_currency .' '. $min_price_slider.' '.esc_html__( 'to','wprentals').' '.$wpestate_currency .' '. $max_price_slider;      
        } else {
            $price_slider_label =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__( 'to','wprentals').' '.$max_price_slider.' '.$wpestate_currency;      
        }
        
    }else{
        $min_price_slider   =   number_format($min_price_slider,0,'.',$th_separator);
        $max_price_slider   =   number_format($max_price_slider,0,'.',$th_separator);
        
        if ($wpestate_where_currency == 'before') {
            $price_slider_label = $wpestate_currency .' '. ($min_price_slider).' '.esc_html__( 'to','wprentals').' '.$wpestate_currency .' '. $max_price_slider;
        } else {
            $price_slider_label =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__( 'to','wprentals').' '.$max_price_slider.' '.$wpestate_currency;
        }  
    }
    
    return $price_slider_label;
                            
    
}
endif;


if( !function_exists('wpestate_show_price_label_slider_v2') ):
    function wpestate_show_price_label_slider_v2($min_price_slider,$max_price_slider,$wpestate_currency,$wpestate_where_currency){
        $th_separator       =   wprentals_get_option('wp_estate_prices_th_separator','');
        $custom_fields = wprentals_get_option('wpestate_currency',''); 
      
        if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
            $i=intval($_COOKIE['my_custom_curr_pos']);
            $wpestate_currency  =   $custom_fields[$i][1];
            $min_price_slider   =   number_format($min_price_slider,0,'.',$th_separator);
            $max_price_slider   =   number_format($max_price_slider,0,'.',$th_separator);
            
            if ($custom_fields[$i][3] == 'before') {  
                $price_slider_label = $wpestate_currency .' '. $min_price_slider.' '.esc_html__( 'to','wprentals').' '.$wpestate_currency .' '. $max_price_slider;      
                $price_slider_label_min = $wpestate_currency .' '. $min_price_slider;
                $price_slider_label_max = $wpestate_currency .' '. $max_price_slider;
            } else {
                $price_slider_label =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__( 'to','wprentals').' '.$max_price_slider.' '.$wpestate_currency;      
                $price_slider_label_min =  $min_price_slider.' '.$wpestate_currency;
                $price_slider_label_max =  $max_price_slider.' '.$wpestate_currency;
            }
            
        }else{
            $min_price_slider   =   number_format($min_price_slider,0,'.',$th_separator);
            $max_price_slider   =   number_format($max_price_slider,0,'.',$th_separator);
            
            if ($wpestate_where_currency == 'before') {
                $price_slider_label = $wpestate_currency .' '. ($min_price_slider).' '.esc_html__( 'to','wprentals').' '.$wpestate_currency .' '. $max_price_slider;
                $price_slider_label_min = $wpestate_currency .' '. $min_price_slider;
                $price_slider_label_max = $wpestate_currency .' '. $max_price_slider;
            } else {
                $price_slider_label =  $min_price_slider.' '.$wpestate_currency.' '.esc_html__( 'to','wprentals').' '.$max_price_slider.' '.$wpestate_currency;
                $price_slider_label_min =  $min_price_slider.' '.$wpestate_currency;
                $price_slider_label_max =  $max_price_slider.' '.$wpestate_currency;
            }  
        }
        
        
        $return_array=array(
            'label'     =>  $price_slider_label,
            'label_min' =>  $price_slider_label_min,
            'label_max' =>  $price_slider_label_max
        );
    
        return $return_array;
                                
        
    }
    endif;
    

///////////////////////////////////////////////////////////////////////////////////////////
/////// Define thumb sizes
///////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_image_size') ):

       function wpestate_image_size(){
        $default_image_size = wpestate_return_default_image_size_theme();

        foreach($default_image_size as $key=>$value ){
            $option_name = 'wp_estate_'.$key;
            $wpresidence_admin =  get_option('wprentals_admin','') ;
    
           
            if(isset($wpresidence_admin[$option_name])){
                $saved_option =$wpresidence_admin[$option_name];
                $crop=true;
                if( isset($saved_option['add_field_width']) && intval($saved_option['add_field_width'])> 0 &&
                    isset($saved_option['add_field_height']) && intval($saved_option['add_field_height'])> 0 ){  
                        $width = intval($saved_option['add_field_width']);
                        $height = intval($saved_option['add_field_height']);
                }else{
                    $width  =   $value['width'];
                    $height =   $value['height'];
                }

                if( isset($saved_option['add_field_width']) && $saved_option['add_field_crop']=='no' ){
                    $crop=false;
                }
            }else{
                $width  =   $value['width'];
                $height =   $value['height'];
                $crop   =   true;
            }
          //  print '</br> fac'.$key.' '.$width.' '.$height.' '.$crop;

            add_image_size($key, $width, $height , $crop);
        }


       set_post_thumbnail_size(  250, 220, true);
    }


    function wpestate_image_size_old(){
        add_image_size('wpestate_blog_unit'           , 400 , 242, true); // 1.45 387 234 1.65
        add_image_size('wpestate_blog_unit2'           , 805 , 453, true); // 1.45 387 234 1.65       
        add_image_size('wpestate_slider_thumb'        , 143,  83, true); //
        add_image_size('wpestate_property_listings'   , 400, 314, true); // 1.6 590, 362, 1.27 386, 302
        add_image_size('wpestate_property_featured'   , 1170, 921, true); // 1.27
        add_image_size('wpestate_property_listings_page'   , 240, 160, true); // 1.6 590, 362, 1.27 386, 302
        add_image_size('wpestate_property_places'   , 600, 456, true);//1.315
        add_image_size('wpestate_property_full_map'   , 1920, 790, true);//2.4
        add_image_size('wpestate_user_thumb'          , 60, 60, true);
        set_post_thumbnail_size(  250, 220, true);
    }
endif;


function wpestate_return_default_image_size_theme(){
   $default_image_size = array(
    'wpestate_blog_unit' => array(
        'name' => esc_html__('Blog Unit', 'wprentals-core'),
        'width' => 400,
        'height' => 242,
        'crop' => true,
    ),
    'wpestate_blog_unit2' => array(
        'name' => esc_html__('Blog Unit type 2', 'wprentals-core'),
        'width' => 805,
        'height' => 453,
        'crop' => true,
    ),
    'wpestate_slider_thumb' => array(
        'name' => esc_html__('Slider thumb', 'wprentals-core'),
        'width' => 143,
        'height' => 83,
        'crop' => true,
    ),
    'wpestate_property_listings' => array(
        'name' => esc_html__('Property Card Image', 'wprentals-core'),
        'width' => 400,
        'height' => 314,
        'crop' => true,
    ),
    'wpestate_property_featured' => array(
        'name' => esc_html__('Property Featured', 'wprentals-core'),
        'width' => 1170,
        'height' => 921,
        'crop' => true,
    ),
    'wpestate_property_listings_page' => array(
        'name' => esc_html__('Property Page Thumb', 'wprentals-core'),
        'width' => 240,
        'height' => 160,
        'crop' => true,
    ),
    'wpestate_property_places' => array(
        'name' => esc_html__('Category Image', 'wprentals-core'),
        'width' => 600,
        'height' => 456,
        'crop' => true,
    ),
    'wpestate_property_full_map' => array(
        'name' => esc_html__('Property full', 'wprentals-core'),
        'width' => 1920,
        'height' => 790,
        'crop' => true,
    ),
    'wpestate_user_thumb' => array(
        'name' => esc_html__('User Thumb', 'wprentals-core'),
        'width' => 60,
        'height' => 60,
        'crop' => true,
    )
);

   return $default_image_size;
   
}


///////////////////////////////////////////////////////////////////////////////////////////
/////// register sidebars
///////////////////////////////////////////////////////////////////////////////////////////



if( !function_exists('wpestate_widgets_init') ):
function wpestate_widgets_init() {
    register_nav_menu( 'primary', esc_html__(  'Primary Menu', 'wprentals' ) ); 
    register_nav_menu( 'mobile', esc_html__(  'Mobile Menu', 'wprentals' ) ); 
    register_nav_menu( 'footer_menu', esc_html__(  'Footer Menu', 'wprentals' ) ); 
    
    register_sidebar(array(
        'name' => esc_html__( 'Primary Widget Area', 'wprentals'),
        'id' => 'primary-widget-area',
        'description' => esc_html__( 'The primary widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => esc_html__( 'Secondary Widget Area', 'wprentals'),
        'id' => 'secondary-widget-area',
        'description' => esc_html__( 'The secondary widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => esc_html__( 'First Footer Widget Area', 'wprentals'),
        'id' => 'first-footer-widget-area',
        'description' => esc_html__( 'The first footer widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => esc_html__( 'Second Footer Widget Area', 'wprentals'),
        'id' => 'second-footer-widget-area',
        'description' => esc_html__( 'The second footer widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));


    register_sidebar(array(
        'name' => esc_html__( 'Third Footer Widget Area', 'wprentals'),
        'id' => 'third-footer-widget-area',
        'description' => esc_html__( 'The third footer widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__( 'Fourth Footer Widget Area', 'wprentals'),
        'id' => 'fourth-footer-widget-area',
        'description' => esc_html__( 'The fourth footer widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-footer">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => esc_html__( 'Top Bar Left Widget Area', 'wprentals'),
        'id' => 'top-bar-left-widget-area',
        'description' => esc_html__( 'The top bar left widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
       
    register_sidebar(array(
        'name' => esc_html__( 'Top Bar Right Widget Area', 'wprentals'),
        'id' => 'top-bar-right-widget-area',
        'description' => esc_html__( 'The top bar right widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
       'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => esc_html__( 'Owner Page', 'wprentals'),
        'id' => 'owner-page-widget-area',
        'description' => esc_html__( 'Owner page widget area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-sidebar">',
        'after_title' => '</h3>',
    ));
    
      register_sidebar(array(
        'name' => __('Splash Page Bottom Right Widget Area', 'wprentals'),
        'id' => 'splash-page_bottom-right-widget-area',
        'description' => __('Splash Page - Bottom right area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="splash_page_widget widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Splash Page Bottom Left Widget Area', 'wprentals'),
        'id' => 'splash-page_bottom-left-widget-area',
        'description' => __('Splash Page - Bottom left area', 'wprentals'),
        'before_widget' => '<li id="%1$s" class="splash_page_widget widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title-topbar">',
        'after_title' => '</h3>',
    ));
}
endif; // end   wpestate_widgets_init  


/////////////////////////////////////////////////////////////////////////////////////////
///// custom excerpt
/////////////////////////////////////////////////////////////////////////////////////////



if( !function_exists('wpestate_excerpt_length') ):
    function wpestate_excerpt_length($length) {
        return 20;
    }
endif; // end   wpestate_excerpt_length  


/////////////////////////////////////////////////////////////////////////////////////////
///// custom excerpt more
/////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_new_excerpt_more') ):
    function wpestate_new_excerpt_more( $more ) {
            return ' ...';
    }
endif; // end   wpestate_new_excerpt_more  



/////////////////////////////////////////////////////////////////////////////////////////
///// strip words
/////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('wpestate_strip_words') ):
    function wpestate_strip_words($text, $words_no) {
        $temp = explode(' ', $text, ($words_no + 1));
        if (count($temp) > $words_no) {
            array_pop($temp);
        }
        return implode(' ', $temp);
    }
endif; // end   wpestate_strip_words 

/////////////////////////////////////////////////////////////////////////////////////////
///// add extra div for wp embeds
/////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_embed_html') ):
    function wpestate_embed_html( $html ) {
        if (strpos($html,'twitter') !== false) {
            return '<div class="video-container-tw">' . $html . '</div>';
        }else{
            return '<div class="video-container">' . $html . '</div>';
        }
    }
endif;
add_filter( 'embed_oembed_html', 'wpestate_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'wpestate_embed_html' ); // Jetpack

/////////////////////////////////////////////////////////////////////////////////////////
///// html in conmment
/////////////////////////////////////////////////////////////////////////////////////////
//add_action('init', 'wpestate_html_tags_code', 10);
if( !function_exists('wpestate_html_tags_code') ):
    function wpestate_html_tags_code() {
        global $allowedposttags, $allowedtags;
        $allowedposttags = array(
            'strong' => array(),
            'em' => array(),
            'pre' => array(),
            'code' => array(),
            'a' => array(
              'href' => array (),
              'title' => array ())
        );

        $allowedtags = array(
            'strong' => array(),
            'em' => array(),
            'pre' => array(),
            'code' => array(),
            'a' => array(
              'href' => array (),
              'title' => array ())
        );
    }
endif;
?>