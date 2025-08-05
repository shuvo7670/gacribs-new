<?php


/*
*
* retrive svg icons
*
*/

function wpestate_return_svg_icon($file_name){
    ob_start();
        include(locate_template('css/css-images/svg-icons/'.$file_name));
    $icon = ob_get_contents();
    ob_end_clean();

    return $icon;
}

/*
*
* Unit card add to favorite
*
*/



if (!function_exists('wprentals_card_owner_image')):
function wprentals_unit_card_favorite($postID){
    $current_user               =   wp_get_current_user();
    $userID                     =   $current_user->ID;
    $user_option                =   'favorites'.$userID;
    $wpestate_curent_fav        =   get_option($user_option);


    $favorite_class =   'icon-fav-off';
    $fav_mes        =   esc_html__( 'add to favorites','wprentals');
    if($wpestate_curent_fav){
        if ( in_array ($postID,$wpestate_curent_fav) ){
            $favorite_class =   'icon-fav-on';
            $fav_mes        =   esc_html__( 'remove from favorites','wprentals');
        }
    }


    $icon = wpestate_return_svg_icon('heart.svg');
    $return='<div class="property_unit_action">
    <span class="icon-fav '. esc_attr($favorite_class).'" data-original-title="'. esc_attr($fav_mes).'" data-postid="'.intval($postID).'">
        '.$icon.'</span>
    </div>';

    return $return;
}
endif;



/*
*
* Unit card owner image
*
*/
if (!function_exists('wprentals_card_owner_image')):
    function wprentals_card_owner_image($post_id)
    {
        $author_id          =   wpsestate_get_author($post_id);
        $agent_id           =   get_user_meta($author_id, 'user_agent_id', true);
        $thumb_id_agent     =   get_post_thumbnail_id($agent_id);
        $preview_agent      =   wp_get_attachment_image_src($thumb_id_agent, 'wpestate_user_thumb');
        $preview_agent_img  =   '';
        if( isset($preview_agent[0]) ){
            $preview_agent_img  =   $preview_agent[0];
        }
        $agent_link         =   esc_url(get_permalink($agent_id));
    
        if ($preview_agent_img   ==  '') {
            $preview_agent_img    =   get_stylesheet_directory_uri().'/img/default_user_small.png';
        }
    
    
        if ($thumb_id_agent=='') {
            $preview_agent_img   = get_the_author_meta('custom_picture', $agent_id);
            return '<div class="owner_thumb" style="background-image: url('. esc_url($preview_agent_img).')"></div>';
        } else {
            return '<a href="'.esc_url($agent_link).'" class="owner_thumb" style="background-image: url('. esc_url($preview_agent_img).')"></a>';
        }
    }
    endif;
    

/*
*
* Unit card owner image
*
*/

if (!function_exists('wpestate_display_property_rating_simple')) {  
    function wpestate_display_property_rating_simple($proeprty_id, $type = 'total') {
        $star_rating = '';
        $total_stars = get_post_meta($proeprty_id, 'property_stars', TRUE);
        if (!$total_stars) {
            $total_stars = wpestate_calculate_property_rating($proeprty_id);
        }


        $tmp_rating = json_decode($total_stars, TRUE);

        ob_start();
        include(locate_template('css/css-images/svg-icons/star.svg'));
        $icon =ob_get_contents();
        ob_end_clean();
        
        $return_string ='';

        if(intval($tmp_rating['rating'])!==0 ){
            $review_number = number_format( ($tmp_rating['rating']),2,'.');
            $return_string = '<div class="property-rating">';
            $return_string .= '<meta itemprop="ratingValue" content="'.floatval($review_number).'"/>';
            $return_string .= $icon.$review_number ;
            $return_string .='</div>';
            return $return_string ;
        }else{
            return;
        }   
      
    }

}


/*
*
* Unit card property price
*
*/

if (!function_exists('wprentals_card_property_price')):
    function wprentals_card_property_price($postID){
        $return_string='';
        $wpestate_currency          =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );
        $wpestate_where_currency    =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
        $currency_code              =   wprentals_get_option('wp_estate_currency_symbol', '');
        $rental_type                =   esc_html(wprentals_get_option('wp_estate_item_rental_type', ''));      
        $booking_type               =   wprentals_return_booking_type($postID);


        $price_per_guest_from_one       =   floatval( get_post_meta($postID, 'price_per_guest_from_one', true) );

        if($price_per_guest_from_one==1){
            $price          =   floatval( get_post_meta($postID, 'extra_price_per_guest', true) );
        }else{
            $price          =   floatval( get_post_meta($postID, 'property_price', true) );
        }
        

        $return_string.= '<div class="" itemprop="offers" itemscope itemtype="http://schema.org/Offer"> ';
      
            $return_string.= '<link itemprop="url" href="'.esc_url( get_permalink( $postID ) ).'"/>';   
            $return_string.= '<meta itemprop="priceCurrency" content="'.esc_html($currency_code).'" />';
            
            $return_string.= '<div class="price_unit">';
                $return_string.= '<span itemprop="price" content="'.floatval($price).'">';
                $return_string.=  wpestate_show_price($postID,$wpestate_currency,$wpestate_where_currency,1);
                if($price!=0){
      
                    if($price_per_guest_from_one==1){
                        $return_string.=  '<span class="pernight"> '.wpestate_show_labels('per_night_per_guest2',$rental_type,$booking_type).'</span>';
                    }else{
                        $return_string.=  '<span class="pernight"> '.wpestate_show_labels('per_night2',$rental_type,$booking_type).'</span>';
                    }
                }
            $return_string.= '</div>';
        $return_string.= '</div>';

        return $return_string;
    }
endif;






/*
*
* Blog card featured image
*
*/

if (!function_exists('wprentals_blog_card_featured_image')):
    function wprentals_blog_card_featured_image($postID,$image_size='wpestate_blog_unit'){
        $title      =   get_sanitized_truncated_title($postID, 0);
   

        if( has_post_thumbnail($postID) ){
            $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($postID), $image_size);
            $return_string  =  '<div class="listing-unit-img-wrapper"> <img src="'.esc_url($preview[0]).'" class=" b-lazy img-responsive" alt="'.esc_attr($title).'" ></div>';         
        }else{
            $preview_img    =   get_stylesheet_directory_uri().'/img/defaultimage_blog.jpg';
            $return_string  =   '<div class="listing-unit-img-wrapper"> <div class="cross"></div><img itemprop="image"  src="'.esc_url($preview_img).'" class=" b-lazy  img-responsive" alt="'.esc_attr($title).'" ></div>';
        }


        return  $return_string;

}
endif;




/*
*
* Blog card title
*
*/

if (!function_exists('wprentals_blog_card_title')):
    function wprentals_blog_card_title($postID,$length='58'){
        $title=get_sanitized_truncated_title($postID, 0);
        
        $return_string = '<a itemprop="url"  href="'. esc_url(get_permalink($postID)).'" class="blog-title-link">
        <span itemprop="name">';
        
        $return_string .= mb_substr( html_entity_decode($title),0,58); 
        if(strlen($title)>58){
            $return_string .='...';   
        }

        $return_string.='</span></a>';
        
        return $return_string;
    }
endif;



/*
*
* Blog card title
*
*/

if (!function_exists('wprentals_blog_card_picker')):
    function wprentals_blog_card_picker($blog_type=''){

        if($blog_type==''){
            $blog_type        =   intval(wprentals_get_option('wp_estate_blog_unit', ''));
        }

        $path =  'templates/blog-unit/blog_unit_new'.$blog_type.'.php';
        return $path;
    }
endif;