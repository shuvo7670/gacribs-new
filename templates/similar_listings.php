<?php
//related listings
global $wpestate_full_page;
global $is_widget;
global $show_sim_two;
global $wpestate_property_unit_slider;

$is_widget              =   0;
$wpestate_full_page     =   1;
$counter                =   0;
$post_category          =   get_the_terms($post->ID, 'property_category');
$post_action_category   =   get_the_terms($post->ID, 'property_action_category');
$post_city_category     =   get_the_terms($post->ID, 'property_city');
$post_area_category     =   get_the_terms($post->ID, 'property_area');
$order                  =   wprentals_get_option('wp_estate_similar_listins_order');

$similar_no             = wprentals_get_option('wp_estate_similar_prop_no');
$args                   = '';
$items                  = array();
$items_actions          = array();
$items_city             = array();
$items_area             = array();
$categ_array            = '';
$action_array           = '';
$area_array             =   '';
$city_array             = '';
$not_in                 = array();
$not_in[]               = $post->ID;

$listing_page_type      =   wprentals_get_option('wp_estate_listing_page_type','');

if($listing_page_type == 1){
    $wpestate_full_page=0;
}

$selected_categ= wprentals_get_option('wp_estate_simialar_taxes');
 /*
* Compose taxonomomy category
*/

if ($post_category!=''):
    foreach ($post_category as $item) {
        $items[] = $item->term_id;
    }
    $categ_array=array(
            'taxonomy' => 'property_category',
            'field' => 'id',
            'terms' => $items
        );
endif;





/*
* Compose taxonomomy action category
*/

if ($post_action_category!=''):
    foreach ($post_action_category as $item) {
        $items_actions[] = $item->term_id;
    }
    $action_array=array(
            'taxonomy' => 'property_action_category',
            'field' => 'id',
            'terms' => $items_actions
        );
endif;

/*
* Compose taxonomomy action city
*/

if ($post_city_category!=''):
    foreach ($post_city_category as $item) {
        if(intval($item->term_id)!=0){
            $items_city[] = $item->term_id;
        }
    }
      
    $city_array=array(
            'taxonomy' => 'property_city',
            'field' => 'id',
            'terms' => $items_city
        );
endif;



/*
* Compose taxonomomy action area
*/

if ($post_area_category!=''):
    foreach ($post_area_category as $item) {
        $items_area[] = $item->term_id;
    }
    $area_array=array(
            'taxonomy' => 'property_area',
            'field' => 'id',
            'terms' => $items_area
        );
endif;



////////////////////////////////////////////////////////////////////////////
/// compose wp_query
////////////////////////////////////////////////////////////////////////////


$order_array    =   wpestate_create_query_order_by_array($order);



$args=array(
    'showposts'             => $similar_no,      
    'ignore_sticky_posts'   => 0,
    'post_type'             => 'estate_property',
    'post_status'           => 'publish',
    'post__not_in'          => $not_in,
    'tax_query'             => array(
    'relation'              => 'AND',
                                    'relation'=>'AND',
                               )
);



$args =array_merge($args,$order_array['order_array']);



if(is_array($selected_categ)){
    if(in_array('property_category'  , $selected_categ)){
        $args[ 'tax_query' ][]=$categ_array;
    }         

    if(in_array('property_action_category' , $selected_categ)){
         $args[ 'tax_query' ][]=$action_array;
    }     

    if(in_array('property_city' , $selected_categ)){
         $args[ 'tax_query' ][]=$city_array;
    }   
    if(in_array('property_area' , $selected_categ)){
        $args[ 'tax_query' ][]=$area_array;
   }    
}else{
    $args[ 'tax_query' ][]=$categ_array;
    $args[ 'tax_query' ][]=$action_array;
    $args[ 'tax_query' ][]=$city_array;
    $args[ 'tax_query' ][]=$area_array;
}




global $wpestate_listing_type;
$wpestate_listing_type   =   wprentals_get_option('wp_estate_listing_unit_type','');
$compare_submit          =   wpestate_get_template_link('compare_listings.php');
$my_query                =   new WP_Query($args);
   
    if ($my_query->have_posts()) { ?>	
        <div class="similar_listings_wrapper">
            <div class="similar_listings">
               
       
                <h3 class="agent_listings_title_similar" ><?php esc_html_e('Similar Listings', 'wprentals'); ?></h3>  
                <div class="similar_listings_wrapper_flex">
                    <?php
                    $wpestate_property_unit_slider= esc_html ( wprentals_get_option('wp_estate_prop_list_slider','') );    

                    while ($my_query->have_posts()):$my_query->the_post();
                        include(locate_template('templates/property_unit.php') ); 
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    <?php } //endif have post

wp_reset_query();