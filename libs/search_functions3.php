<?php

/**
*
*
*
*
*
*/

if( !function_exists('wpestate_argumets_builder') ):
    function wpestate_argumets_builder($input,$is_half=''){
        global $query_meta;
        $query_meta         =   0;
        $adv_search_what    =   wprentals_get_option('wp_estate_adv_search_what');
        $adv_search_how     =   wprentals_get_option('wp_estate_adv_search_how');
        $adv_search_label   =   wprentals_get_option('wp_estate_adv_search_label');
        $adv_search_icon    =   wprentals_get_option('wp_estate_search_field_label');
        $adv_search_type    =   wprentals_get_option('wp_estate_adv_search_type','');

     


        if( $adv_search_type=='newtype' || $adv_search_type=='oldtype'){
            if($is_half==1){ //$is_half means has price for type 1 and 2

                $adv_search_what   =   wprentals_get_option('wp_estate_adv_search_what_half');
                $adv_search_how    =   wprentals_get_option('wp_estate_adv_search_how_half');
            }else{
                $adv_search_what    =   wprentals_get_option('wp_estate_adv_search_what_classic');
                $adv_search_how     =   wprentals_get_option('wp_estate_adv_search_how_classic');
            }

        } else if($adv_search_type=='type4' ){

            $adv_search_what[]='property_category';
            $adv_search_how[]='like';
            $adv_search_label[]='';

            $adv_search_what[]='property_action_category';
            $adv_search_how[]='like';
            $adv_search_label[]='';
        }
        
        if(isset($_GET['elementor_form_id']) && intval($_GET['elementor_form_id'])!=0 ){
            $elementor_post_id              = intval($_GET['elementor_form_id']);
            $elementor_search_name_how      = "elementor_search_how_" . $elementor_post_id;
            $elementor_search_name_what     = "elementor_search_what_" . $elementor_post_id;
            $elementor_search_name_label    = "elementor_search_label_" . $elementor_post_id;

            $adv_search_what        =   get_option($elementor_search_name_what,true);
            $adv_search_how         =   get_option($elementor_search_name_how,true);
            $adv_search_label       =   get_option($elementor_search_name_label,true);

            
       
        }


        if($is_half==1){

           $adv_search_label        =   wprentals_get_option('wp_estate_adv_search_label_half_map');
            $adv_search_icon        =   wprentals_get_option('wp_estate_search_field_label_half_map');

            $adv_search_what        =   wprentals_get_option('wp_estate_adv_search_what_half_map') ;
            $adv_search_how         =   wprentals_get_option('wp_estate_adv_search_how_half_map');
            if($adv_search_type=='type4' ){

                $adv_search_what[]='property_category';
                $adv_search_how[]='like';
                $adv_search_label[]='';

                $adv_search_what[]='property_action_category';
                $adv_search_how[]='like';
                $adv_search_label[]='';
            }
        }






        $move_map=0;
        if ( isset($input['move_map']) ){
            $move_map=intval($input['move_map']);
        }


        //////////////////////////////////////////begin
        $tax_array  =   array();
        $meta_array =   array();



        if(is_array($adv_search_what)){
            foreach($adv_search_what as $key=>$term ){
            $term   =   sanitize_key($term);



            if( rentals_is_tax_case($term) ){
            
                $tax_element    = wpestate_add_tax_element($term,$adv_search_how[$key],$input);
              

                if(!empty($tax_element)){


                    // check if we already added location tax
                    if( isset($tax_array['relation']) && $tax_array['relation']=='OR' ){
                        $temp_tax       =   $tax_array;
                        $tax_array      =   array();
                        $tax_array[]    =   $temp_tax;
                        $tax_array[]    =   $tax_element;
                    }else{
                       
                        $tax_array[]    = $tax_element;
                    }


                }
            }else{
                // is_meta_case is_combo
                
                $meta_element = wpestate_add_meta_element($term,$adv_search_how[$key],$input);
                if(!empty($meta_element)){
                    if(isset($meta_element[0]) && $meta_element[0]=='is_combo'){
                        unset($meta_element[0]);
                        foreach($meta_element as $key=>$value){
                              $meta_array[] = $value;
                        }
                    }else{
                        $meta_array[] = $meta_element;
                    }
    
                }
            }

            if( strtolower($term)=='location'){
                $location_array =   wpestate_apply_location($tax_array,$meta_array,$input);
                $tax_array      =   $location_array['tax_already_made'];
                $meta_array     =   $location_array['meta_already_made'];
            }

           

        }
        }
        $paged  =   1;
        $paged  =   get_query_var('paged') ? get_query_var('paged') : 1;

        if( isset($_REQUEST['newpage']) ){
            $paged  = intval($_REQUEST['newpage']);
        }




        $prop_no    =   intval ( wprentals_get_option('wp_estate_prop_no', '') );
        $wpestate_book_from  =   '';
        $wpestate_book_to    =   '';
        if( isset($input['check_in'])){
            $wpestate_book_from      =  sanitize_text_field( $input['check_in']);
        }

        if( isset($input['check_out'])){
            $wpestate_book_to        =  sanitize_text_field( $input['check_out'] );
        }



        $features_array = wpestate_add_feature_to_search($input,$is_half);

        if( isset($tax_array['relation']) && $tax_array['relation']=='OR' ){
            $tax_array_old = $tax_array;

            $tax_array=array();
            $tax_array['relation']='AND';
            $tax_array[]=$tax_array_old;
            $tax_array[]=$features_array;

        }else{
            if( !isset($tax_array['relation']) ){
                $tax_array['relation']='AND';
            }

            $tax_array[]=$features_array;
        }




        $args = array(
            'cache_results'             =>  false,
            'update_post_meta_cache'    =>  false,
            'update_post_term_cache'    =>  false,

            'post_type'       => 'estate_property',
            'post_status'     => 'publish',
            'paged'           => $paged,
            'posts_per_page'  => $prop_no,
            'meta_key'        => 'prop_featured',
            'orderby'         => 'meta_value',
            'order'           => 'DESC',
            'meta_query'      => $meta_array,
            'tax_query'       => $tax_array
        );


        if( $move_map==1 ){
            $args['meta_query']   =$meta_array  =   wpestate_map_pan_filtering($input,$meta_array);
        }





        $meta_ids=array();
        if(!empty($args['meta_query']) ){
            $meta_results           =   wpestate_add_meta_post_to_search($meta_array);
            $meta_ids               =   $meta_results[0];
            $args['meta_query']     =   $meta_results[1];
        }





        if(!empty($meta_ids)){
            $args['post__in']=$meta_ids;
        }





        if( $move_map != 1 ){
            if( wprentals_get_option('wp_estate_use_geo_location','')=='yes' && isset($input['geo_lat']) && isset($input['geo_long']) && $input['geo_lat']!='' && $input['geo_long']!='' ){


                $geo_lat  = $input['geo_lat'];
                $geo_long = $input['geo_long'];
                $geo_rad  = $input['geo_rad'];
                $args     = wpestate_geo_search_filter_function($args, $geo_lat, $geo_long, $geo_rad);

            }
        }

        //check the or in meta situation for location
        if ($query_meta==0 && isset( $args['meta_query'][0]['relation']) && $args['meta_query'][0]['relation']==='OR' && isset($args['post__in']) && $args['post__in'][0]==0 ){
         //   print 'kKUK_de_mare';
            unset($args['post__in']);
        }






        ////////////////////////////////////////////////////////////////////////////
        // if we have check in and check out dates we need to double loop
        ////////////////////////////////////////////////////////////////////////////
        if ( $wpestate_book_from!='' && $wpestate_book_to!='' ){
            $args[ 'posts_per_page'] =  -1;
            $prop_selection =   new WP_Query($args);

            $num            =   $prop_selection->found_posts;
            $right_array    =   array();
            $right_array[]  =   0;
            while ($prop_selection->have_posts()): $prop_selection->the_post();
                $post_id=get_the_ID();

                if( wpestate_check_booking_valability($wpestate_book_from,$wpestate_book_to,$post_id) ){
                    $right_array[]=$post_id;
                }
            endwhile;


            wp_reset_postdata();
            $args = array(
                'cache_results'           =>    false,
                'update_post_meta_cache'  =>    false,
                'update_post_term_cache'  =>    false,
                'meta_key'                =>    'prop_featured',
                'orderby'                 =>    'meta_value',
                'post_type'               =>    'estate_property',
                'post_status'             =>    'publish',
                'paged'                   =>    $paged,
                'posts_per_page'          =>    $prop_no,
                'post__in'                =>    $right_array
            );


        }


        $order = intval(wprentals_get_option('wp_estate_property_list_type_adv_order',''));
        // add filters
        if($order==0){
            add_filter( 'posts_orderby', 'wpestate_my_order' );
        }

        if( isset($input['keyword_search']) ){
            global $keyword;
            $keyword    = stripslashes($input['keyword_search']);
            add_filter( 'posts_where', 'wpestate_title_filter', 10, 2 );
        }



        
    
     
        $order_array    =   wpestate_create_query_order_by_array($order);
        $args           =   array_merge($args,$order_array['order_array']);
    


   
     $prop_selection =   new WP_Query($args);


        //remove
        if(function_exists('wpestate_disable_filtering') and $order==0 ){
          wpestate_disable_filtering( 'posts_orderby', 'wpestate_my_order' );
        }

        if( isset($input['keyword_search']) ){
            if(function_exists('wpestate_disable_filtering2')){
                wpestate_disable_filtering2( 'posts_where', 'wpestate_title_filter', 10, 2 );
            }
        }

        $return_arguments       =   array();
        $return_arguments[0]    =   $prop_selection;
        $return_arguments[1]    =   $args;

        return $return_arguments;





    }
endif;


/**
*
*
*
*
*
*/

if( !function_exists('wpestate_apply_location') ):
    function wpestate_apply_location($tax_array_already_made,$meta_already_made,$input){
        $show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
        $allowed_html                       =   array();
        $tax_query                          =   array();
        $meta_query                         =   array();
        $city_array                         =   array();
        $area_array                         =   array();
        $categ_array                        =   array();
        $action_array                       =   array();

        if($show_adv_search_general=='no'){
            if( isset($input['stype']) && esc_html($input['stype'])=='tax' ){
                $stype='tax';

                if (isset($input['search_location']) and $input['search_location'] != 'all' && $input['search_location'] != '' && $input['search_location'] != '0') {
                    //////////////////////////////////////////////////////////////////////////////////////
                    ///// city filters
                    //////////////////////////////////////////////////////////////////////////////////////

                    $taxcity[] = sanitize_text_field ($input['search_location']);
                    $city_array = array(
                        'taxonomy'     => 'property_city',
                        'field'        => 'slug',
                        'terms'        => $taxcity
                    );

                    //////////////////////////////////////////////////////////////////////////////////////
                    ///// area filters
                    //////////////////////////////////////////////////////////////////////////////////////
                    $taxarea[]      = sanitize_text_field($input['search_location'] );
                    $area_array     = array(
                        'taxonomy'     => 'property_area',
                        'field'        => 'slug',
                        'terms'        => $taxarea
                    );
                }

                $tax_query2 =   array();

                if( !empty($city_array) || !empty($area_array) ){
                    $tax_query2 = array(
                        'relation' => 'OR',
                        $city_array,
                        $area_array
                    );
                }


                if( !empty($tax_array_already_made) ){

                    if(!empty( $tax_query2 )){
                        $tax_array_already_made[]=$tax_query2;
                    }

                }else{

                    $tax_array_already_made =$tax_query2;

                }




            }else{
                $stype                      =   'meta';
                $meta_query_part            =   array();
                $meta_query['relation']     =   'AND';
                if( isset($input['search_location'])  && $input['search_location']!='' && $input['search_location'] != '0' ){

                    $search_string              =   sanitize_text_field ( $input['search_location'] );
                    $search_string              =   str_replace('-', ' ', $search_string);

                    $meta_query_part['relation'] =   'OR';

                    $country_array               =   array();
                    $country_array['key']        =   'property_country';
                    $country_array['value']      =   $search_string;
                    $country_array['type']       =   'CHAR';
                    $country_array['compare']    =   'LIKE';

                    $meta_query_part[]           =   $country_array;

                    $country_array               =   array();
                    $country_array['key']        =   'property_state';
                    $country_array['value']      =   $search_string;
                    $country_array['type']       =   'CHAR';
                    $country_array['compare']    =   'LIKE';
                    $meta_query_part[]           =   $country_array;


                    $county_array               =   array();
                    $county_array['key']        =   'property_county';
                    $county_array['value']      =   $search_string;
                    $county_array['type']       =   'CHAR';
                    $county_array['compare']    =   'LIKE';
                    $meta_query_part[]          =   $county_array;

                    $meta_already_made[]         =   $meta_query_part;
                }
            }
        }else{
            if (isset($input['advanced_city']) and $input['advanced_city'] != 'all' && $input['advanced_city'] != '') {
                $taxcity[] = sanitize_title (    wp_kses($input['advanced_city'],$allowed_html) );
                $city_array = array(
                    'taxonomy'     => 'property_city',
                    'field'        => 'slug',
                    'terms'        => $taxcity
                );
            }




            if (isset($input['advanced_area']) and $input['advanced_area'] != 'all' && $input['advanced_area'] != '') {
                $taxarea[] = sanitize_title (  wp_kses($input['advanced_area'],$allowed_html) );
                $area_array = array(
                    'taxonomy'     => 'property_area',
                    'field'        => 'slug',
                    'terms'        => $taxarea
                );
            }

            if(!empty($city_array)){
                $tax_array_already_made[]=$city_array;
            }

            if(!empty($area_array)){
                $tax_array_already_made[]=$area_array;
            }



            $country_array=array();
            if( isset($input['advanced_country'])  && $input['advanced_country']!='' ){
                $country                     =   sanitize_text_field ( $input['advanced_country'] );
                $country                     =   str_replace('-', ' ', $country);
                $country_array['key']        =   'property_country';
                $country_array['value']      =   wprentals_agolia_dirty_hack($country);
                $country_array['type']       =   'CHAR';
                $country_array['compare']    =   'LIKE';
                $meta_already_made[]         =   $country_array;
            }

            if( isset($input['advanced_city']) && $input['advanced_city']=='' && isset($input['property_admin_area']) && $input['property_admin_area']!=''   ){
                $admin_area_array               =   array();
                $admin_area                     =   sanitize_text_field (  $input['property_admin_area'] );
                $admin_area                     =   str_replace(" ", "-", $admin_area);
                $admin_area                     =   str_replace("\'", "", $admin_area);
                $admin_area_array['key']        =   'property_admin_area';
                $admin_area_array['value']      =   $admin_area;
                $admin_area_array['type']       =   'CHAR';
                $admin_area_array['compare']    =   'LIKE';
                $meta_already_made[]            =   $admin_area_array;

            }
        }


        $return_info = array(
                    'tax_already_made' =>$tax_array_already_made,
                    'meta_already_made'=>$meta_already_made,
        );
        return $return_info;
    }
endif;



/**
*
*
*
*
*
*/

if( !function_exists('wprentals_agolia_dirty_hack') ):
    function  wprentals_agolia_dirty_hack($country){
        if( intval( wprentals_get_option('wp_estate_kind_of_places') ) == 2 ){
            if(strtolower($country)=='united states of america'){
                $country = 'united states';
                return $country;
            }else{
                return $country;
            }

        }else{
            return  $country;
        }
    }
endif;


/**
*
*
*
*
*
*/

if( !function_exists('wpestate_add_meta_element') ):
    function wpestate_add_meta_element($term,$how,$input){
        $meta_term          =   array();
        $input_value        =   '';

        if($term=='property_price' || $term =='property_price_v2'){
            $meta_term          =   array();
            $price_min      =   floatval($input['price_low']);
            $price_max      =   floatval($input['price_max']);
            $custom_fields  =   wprentals_get_option('wpestate_currency','');

            if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                $i              =   intval($_COOKIE['my_custom_curr_pos']);
                $price_max      =   $price_max / $custom_fields[$i][2];
                $price_min      =   $price_min / $custom_fields[$i][2];
            }


            $meta_term['key']        = 'property_price';
            $meta_term['value']      = array($price_min, $price_max);
            $meta_term['type']       = 'numeric';
            $meta_term['compare']    = 'BETWEEN';


            return $meta_term;
        }else if($term=='property_beds_baths'){
                $componentsbeds=0;
                $meta_term_component[]='is_combo';
                if(isset( $_REQUEST['componentsbeds'] )){
                    $componentsbeds=floatval( $_REQUEST['componentsbeds'] );
                }
                $componentsbaths=0;
                if(isset( $_REQUEST['componentsbaths'] )){
                    $componentsbaths=floatval( $_REQUEST['componentsbaths'] );
                }

                if($componentsbeds>0){
                    $meta_term=array();
                    $meta_term['key']        = 'property_bedrooms';
                    $meta_term['value']      =  $componentsbeds;
                    $meta_term['type']       = 'numeric';
                    $meta_term['compare']    = '>=';
                    $meta_term_component[]= $meta_term;
                }

                if($componentsbaths>0){
                    $meta_term=array();
                    $meta_term['key']        = 'property_bathrooms';
                    $meta_term['value']      =  $componentsbaths;
                    $meta_term['type']       = 'numeric';
                    $meta_term['compare']    = '>=';
                    $meta_term_component[]= $meta_term;
                }
                return $meta_term_component;
        }


        if( isset($input[$term]) ){
            $input_value        =   sanitize_text_field($input[$term]);
        }
        $allowed_html       =   array();

        if( $input_value==''  || $term=='check_in' || $term=='check_out' ){
            return $meta_term;
        }
        if( ( $how === 'equal' || $how === 'greater' || $how === 'smaller' ) && !is_numeric($input_value)){
            return $meta_term;
        }
        if( $how === 'like'&& $input_value=='all' ){
             return $meta_term;
        }



        if($how === 'equal' ){
            $compare         =   '=';
            $search_type     =   'numeric';
            $term_value      =   floatval ($input_value );

        }else if($how === 'greater'){
            $compare        = '>=';
            $search_type    = 'numeric';
            $term_value     =  floatval ( $input_value );

        }else if($how === 'smaller'){
            $compare        ='<=';
            $search_type    ='numeric';
            $term_value     = floatval ( $input_value );

        }else if($how === 'like'){
            $compare        = 'LIKE';
            $search_type    = 'CHAR';
            $term_value     = wp_kses( $input_value ,$allowed_html);


        }else if($how === 'date bigger'){
            $compare        ='>=';
            $search_type    ='DATE';
            $term_value     =  str_replace(' ', '-', $input_value);
            $term_value     = wp_kses( $input_value,$allowed_html );

        }else if($how === 'date smaller'){
            $compare        = '<=';
            $search_type    = 'DATE';
            $term_value     =  str_replace(' ', '-', $term_value);
            $term_value     = wp_kses( $input_value,$allowed_html );
        }





        $meta_term['key']        = $term;
        $meta_term['value']      = $term_value;
        $meta_term['type']       = $search_type;
        $meta_term['compare']    = $compare;





        return $meta_term;


    }
endif;



/**
*
*
*
*
*
*/

if( !function_exists('wpestate_add_tax_element') ):
    function wpestate_add_tax_element($term,$how,$input){


        $taxcateg_include       =   array();
        $taxonomy_term          =   array();
        $input_value            =   '';

        if( isset( $input[$term] )){
            $input_value        =  wpestate_sanitize_text_array($input[$term]);
            if(is_array( $input_value) ){
                $taxcateg_include =   $input_value;
            }else{
                $taxcateg_include[] =   $input_value;
            }
      
        }

      



        if( (   is_array($taxcateg_include)  && !empty($taxcateg_include)  && ( !empty($taxcateg_include[0]) )  ) ||
            (   is_string($taxcateg_include) &&  $taxcateg_include!='all' ) ){

                
                    $taxonomy_term=array(
                        'taxonomy'  => $term,
                        'field'     => 'slug',
                        'terms'     => $taxcateg_include
                    );
        }
        

        return $taxonomy_term;

    }
endif;




/**
*
* check if we have taxonomy dropdown
*
*
*
*/


if( !function_exists('wpestate_build_dropdown_adv_new') ):
    function rentals_is_tax_case($term){
        if($term=='property_category' || $term=='property_action_category' || $term=='property_city' || $term=='property_area' ){
            return true;
        }
        return false;

    }
endif;
/*
*
*
*
*/
if(!function_exists('wpestate_show_dropdown_taxonomy_v21')):
    function wpestate_show_dropdown_taxonomy_v21($search_field, $term_value, $label, $appendix,$active='') {
        
   
        $field_options = [
            'property_category' => [
                'option_name' => 'wp_estate_categ_select_list_multiple', 
                'select_list_function' => 'wpestate_get_category_select_list',
                'term' => 'property_category', 
                'default_label' => esc_html__('Categories','wprentals'),
                'ul_id'=>'categlist',
                'toogle_id'=>'property_category',
                'get_var'=>'property_category'
            ],
            'property_action_category' => [
                'option_name' => 'wp_estate_action_select_list_multiple', 
                'select_list_function' => 'wpestate_get_action_select_list',
                'term' => 'property_action_category', 
                'default_label' => esc_html__('Types','wprentals'),
                'ul_id'=>'actionslist',
                'toogle_id'=>'property_action_category',
                'get_var'=>'property_action_category'
            ],
            'property_city' => [
                'option_name' => 'wp_estate_city_select_list_multiple', 
                'select_list_function' => 'wpestate_get_city_select_list',
                'term' => 'property_city', 
                'default_label' => esc_html__('Cities','wprentals'),
                'ul_id'=>'adv-search-city',
                'toogle_id'=>'property_city',
                'get_var'=>'property_city',
                'is_array' => false
            ],
            'property_area' => [
                'option_name' => 'wp_estate_area_select_list_multiple', 
                'select_list_function' => 'wpestate_get_area_select_list',
                'term' => 'property_area', 
                'default_label' => esc_html__('Areas','wprentals'),
                'ul_id'=>'adv-search-area',
                'toogle_id'=>'property_area',
                'get_var'=>'property_area',
                'is_array' => false
            ],
       
            'property_status' => [
                'option_name' => 'wp_estate_status_select_list_multiple', 
                'select_list_function' => 'wpestate_get_status_select_list',
                'term' => 'property_status', 
                'default_label' => esc_html__('Status','wprentals'),
                'ul_id'=>'statuslist',
                'toogle_id'=>'adv_status',
                'get_var'=>'property_status'
            ]
        ];
    
        $args                       =   wpestate_get_select_arguments();
        if (!array_key_exists($search_field, $field_options)) {
            return ''; // Return empty string if search field is not defined
        }
    
        $options        = $field_options[$search_field];
        $getField       = $options['get_var'];
        $term           = $options['term'];
        $optionName     = $options['option_name'];
        $defaultLabel   = $options['default_label'];
        $ulId           = $options['ul_id'];
        $toggleId       = $options['toogle_id'];
    
        $is_array = isset($options['is_array']) ? $options['is_array'] : true;
    
        $value = $value1 = 'all';
       
        $multiple_selected_values=null;
        
        if(isset($_GET[$getField]) && is_array( $_GET[$getField]) && $active=='active' ){
            $multiple_selected_values=wpestate_sanitize_text_array ($_GET[$getField]);
           
            if(isset($multiple_selected_values[0])){
                $full_name = get_term_by('slug', sanitize_text_field( $multiple_selected_values[0] ), $term);
                if($full_name){
                    $value = $value1 = $full_name->name;
                }
            }
    
        }
            
         
        if( isset($_GET[$getField]) && !is_array( $_GET[$getField]) && trim($_GET[$getField]) != '' && $_GET[$getField] != 'all' && $active=='active') {
        
    
            $full_name = get_term_by('slug', sanitize_text_field($_GET[$getField]), $term);
            if( isset( $full_name->name)) {
                $value = $value1 = $full_name->name;
            }
           
        } else{
            $value = $label;
            if ($label == '') {
                    $value =$defaultLabel;
            }
    
        }
    
    
        $value = $label == '' ? $defaultLabel : $label;
        $selectListFunc = $field_options[$search_field]['select_list_function'];
    
        if (wprentals_get_option($optionName, '') == 'yes') {
            $select_list = wpestate_get_taxonomy_select_list_for_dropdown($args, $search_field, 'yes', 'maca',$multiple_selected_values);



            return wpestate_build_dropdown_multiple($appendix, $ulId, $toggleId, $value, $value1, $getField, $select_list);
        } else {
            $list_args          =   wpestate_get_select_arguments();
            $select_list = call_user_func($selectListFunc, $args);
            $dropdown_list      =   wpestate_get_action_select_list_4all($list_args,$search_field);
            return   wpestate_build_dropdown_adv_new('',$search_field,$term_value,$dropdown_list,$label);
            //return   wpestate_build_dropdown_adv_new($appendix, $ulId, $toggleId, $value, $value1, $getField, $select_list,$active);
        }
    }
    endif;

/**
*
*
*
*
*
*/
if( !function_exists('wpestate_build_dropdown_adv_new') ):
    function wpestate_build_dropdown_adv_new($appendix,$term,$term_value,$dropdown_list,$label){
        $extraclass='';
        $caret_class='';
        $wrapper_class='';
        $return_string='';
        $is_half=0;
        $allowed_html =array();

        if($appendix==''){
            $extraclass=' filter_menu_trigger  ';
            $caret_class= ' caret_filter ';
        }else  if($appendix=='sidebar-'){
            $extraclass=' filter_menu_trigger  ';
            $caret_class= ' caret_sidebar ';
        } else  if($appendix=='shortcode-'){
            $extraclass=' filter_menu_trigger  ';
            $caret_class= ' caret_filter ';
            $wrapper_class = 'listing_filter_select';
        } else  if($appendix=='mobile-'){
            $extraclass=' filter_menu_trigger  ';
            $caret_class= ' caret_filter ';
            $wrapper_class = '';
        }else  if($appendix=='half-'){
            $extraclass=' filter_menu_trigger  ';
            $caret_class= ' caret_filter ';
            $wrapper_class = '';

            $appendix='';
            $is_half=1;
        }

            if(is_array($term_value)){
                $term_value=$term_value[0];
            }     

            $term_value= str_replace('-', ' ', $term_value);


            $return_string.=  '<div class="dropdown custom_icon_class  form-control '.$wrapper_class.'"> ';
            $return_string.=  '<div data-toggle="dropdown" id="'.sanitize_key( $appendix.$term ).'_toogle" class="'.$extraclass.'"   data-value="'.( esc_attr( $term_value) ).'">';

            if (  $term=='property_category' || $term=='property_action_category' || $term=='property_city' || $term=='property_area'
                    || $term=='property_county' || $term=='property_country'){
                               
                       

                    if( strtolower($term_value) =='' ||  strtolower ($term_value) =='all'  ){

                            if($term=='property_category'){
                                $return_string.=   wpestate_category_labels_dropdowns('main',$label);
                            }else if($term=='property_action_category'){
                                $return_string.=  wpestate_category_labels_dropdowns('second',$label);
                            }else if($term=='property_city' ){
                                
                                if($label!=''){
                                    $return_string.=$label;
                                }else{
                                    $return_string.= esc_html__('All Cities','wprentals');
                                }
                               
                            }else if($term=='property_area'){
                              
                                if($label!=''){
                                    $return_string.=$label;
                                }else{
                                    $return_string.= esc_html__('All Areas','wprentals');
                                }
                                
                            }else if($term=='property_county'){
                             
                                if($label!=''){
                                    $return_string.=$label;
                                }else{
                                    $return_string.= esc_html__('All Counties/States','wprentals');
                                }
                                
                            }else if($term=='property_country'){
                               
                                if($label!=''){
                                    $return_string.=$label;
                                }else{
                                    $return_string.= esc_html__('All Countries','wprentals');
                                }
                                
                            }else{
                                $return_string.=ucfirst($label);
                            }

                    }else{
                        $return_string.= ucfirst($term_value);
                    }

            }else{

                    if (function_exists('icl_translate') ){
                        $term_value = apply_filters('wpml_translate_single_string', trim($term_value),'custom field value','custom_field_value'.$term_value );
                    }

                    if( strtolower ($term_value) =='all' || $term_value=='' ){
                        $return_string.= ucfirst( stripslashes( $label) );
                    }else{
                        $return_string.=  ucfirst( stripslashes( $term_value) );
                    }
            }


                $return_string.= '
                <span class="caret '.$caret_class.'"></span>
                </div>';


                $return_string.=' <input type="hidden" name="'.sanitize_key( $term ).'" id="'.sanitize_key( $appendix.$term ).'" value="';
                    if(isset($_GET[$term])){
                        $term_get=$_GET[$term];
                        if(is_array($_GET[$term] )){
                            $term_get=$_GET[$term][0] ;
                        }
                        $return_string.= strtolower( esc_attr ( $term_get ) );
                    }


                    $return_string.='">
                    <ul  class="dropdown-menu filter_menu" role="menu" aria-labelledby="'.sanitize_key( $appendix.$term ).'_toogle">
                        '.$dropdown_list.'
                    </ul>
                </div>';


        return $return_string;
    }
endif;























/**
*
*
*
*
*
*/

function wpestate_build_dropdown_multiple($appendix,$ul_id,$toogle_id,$values,$values1,$get_var,$select_list,$active=''){
    $extraclass='';
    $caret_class='';
    $wrapper_class='';
    $return_string='';
    $is_half=0;
    $allowed_html =array();

   
    if($get_var=='advanced_categories'){
        $get_var='filter_search_type';
    }
    if($get_var=='advanced_types'){
        $get_var='filter_search_action';
    }


    switch ($appendix) {
        case 'half-':   
            $appendix = '';
            $is_half = 1;
            $return_string='<div class="col-md-3">';
            break;
    }
    $get_var_sanitized = sanitize_key($get_var);
  

    $live_search='';
    if( "yes" === wprentals_get_option('wp_estate_select_list_multiple_show_search','') ){
        $live_search='data-live-search="true" ';
    }
//dropdown form-control custom_icon_class icon_categlist 
    $return_string.='
    <select class="form-control selectpicker wpestate-selectpicker" multiple
        
        name="' . esc_attr($get_var_sanitized) . '[]"
        id="'.esc_attr($appendix.$toogle_id).'"
        title="'.esc_attr($values).'" 
        '.esc_html($live_search).'
        data-selected-text-format="count"
        data-count-Selected-Text="{0} '.esc_html__('items selected','wprentals').'"
        data-select-all-text="'.esc_html__('Select All','wprentals').'"
        data-deselect-all-text="'.esc_html__('Select None','wprentals').'"
        data-actions-box="true"
        aria-labelledby="'.esc_attr($appendix.$toogle_id).'">
        '.$select_list.'
    </select>';
 
    if($is_half==1 && $adv_search_type!=6 ){
        $return_string.='</div>';
    }

    return $return_string;
}


/*
*
*      $taxonomy = 'property_action_category';
*
*/


function wpestate_get_taxonomy_select_list_for_dropdown($args,$field_type,$multiple,$placeholder,$multiple_selected_values) {

    $transient_appendix = '';
    if (defined('ICL_LANGUAGE_CODE')) {
        $transient_appendix .= '_' . ICL_LANGUAGE_CODE;
    }
    

    $field_options = [
        'property_category' => [         
            'taxonomy' => 'property_category', 
            'label' => esc_html__('Categories', 'wprentals')
        ],
        'property_action_category' => [          
            'taxonomy' => 'property_action_category', 
            'label' => esc_html__('Types', 'wprentals')           
        ],
        'property_city' => [         
            'taxonomy' => 'property_city', 
            'label' => esc_html__('Cities', 'wprentals')
        ],
        'property_area' => [
     
            'taxonomy' => 'property_area', 
            'label' => esc_html__('Areas', 'wprentals')
        
        ],
        'property status' => [
            'taxonomy' => 'property_status', 
            'label' => esc_html__('Status', 'wprentals')
          
        ]
    ];

 

    $taxonomy    =  $field_options[$field_type]['taxonomy'];
    $label       =  $field_options[$field_type]['label'];
    if($placeholder!=''){
        $label=$placeholder;
    }



    $selection_list = wpestate_request_transient_cache('wpestate_get_dropdown_multiple_select_list_'.$taxonomy.'_'.$transient_appendix);
    $selection_list =false;
    if ($selection_list === false) {
  
        $categories = wpestate_get_cached_terms($taxonomy, $args);
     

        $adv_search_label = wprentals_get_option('wp_estate_adv_search_label', '');
        $adv_search_what = wprentals_get_option('wp_estate_adv_search_what', '');

        $label = wpestate_return_default_label($adv_search_what, $adv_search_label, 'types',$label);



      

        if($multiple=='yes'){
            //$selection_list = ' <option role="presentation" value="all" data-value="all">' . $label . '</option>';
        }else{
            $selection_list = ' <li role="presentation" data-value="all">' . $label . '</li>';
        }



        if (is_array($categories)) {
            foreach ($categories as $categ) {
                $received = wpestate_hierarchical_category_childen_v2($multiple_selected_values,$taxonomy,$multiple, $categ->term_id, $args);
                $counter = $categ->count;
                if (isset($received['count'])) {
                    $counter = $counter + $received['count'];
                }

             
                if($multiple=='yes'){

                    $parent_value = '';
                    if($field_type=='cities'){
                 
                        $term_meta = get_option("taxonomy_$categ->term_id");
                        if (isset($term_meta['stateparent'])) {
                            $parent_value = sanitize_title($term_meta['stateparent']) ;
                        }
                    }else if($field_type=='areas'){
                 
                        $term_meta = get_option("taxonomy_$categ->term_id");
                        if (isset($term_meta['cityparent'])) {
                          
                            $parent_value = sanitize_title($term_meta['cityparent']) ;
                        }
                    }


                    $selection_list .= '<option role="presentation" value="'. esc_attr($categ->slug).'" data-taxonomy="'.esc_attr($field_type).'" 
                                        data-parent-value="'.esc_attr($parent_value).'" data-value="'. esc_attr($categ->slug).'" ';
                    
                    if( is_array($multiple_selected_values) && in_array($categ->slug,$multiple_selected_values) ||
                        is_array($multiple_selected_values) && in_array(urldecode($categ->slug),$multiple_selected_values)                     
                    ){
                        $selection_list.= 'selected';
                    }
                    $selection_list.='>' . ucwords(urldecode($categ->name))  . '</option>';

                }else{
                    $selection_list .= '<li role="presentation" data-value="' . esc_attr($categ->slug) . '">' . ucwords(urldecode($categ->name)) . '</li>';
                }
               
               
               
               
                if (isset($received['html'])) {
                    $selection_list .= $received['html'];
                }
            }
        }
        wpestate_set_transient_cache('wpestate_get_dropdown_multiple_select_list_'.$taxonomy .'_'.$transient_appendix, $categories, 4 * 60 * 60);
    }
    return $selection_list;
}



/**
*
*
*
*
*
*/


if( !function_exists('wpestate_get_action_select_list_4all') ):
    function wpestate_get_action_select_list_4all($args,$taxonomy){

        $categ_select_list  =   wpestate_request_transient_cache('wpestate_get_select_list_'.$taxonomy);
        if($categ_select_list===false){



            $categories = wpestate_get_cached_terms($taxonomy, $args);
            if($taxonomy=='property_category'){
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.  wpestate_category_labels_dropdowns('main').'</li>';
            }else  if($taxonomy=='property_action_category'){
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.   wpestate_category_labels_dropdowns('second').'</li>';
            }else  if($taxonomy=='property_city'){
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.  esc_html__('All Cities','wprentals').'</li>';
            }else{
                $categ_select_list  =   ' <li role="presentation" data-value="all">'.  esc_html__('All Areas','wprentals').'</li>';
            }



            foreach ($categories as $categ) {
                $received   =   wpestate_hierarchical_category_childen($taxonomy, $categ->term_id,$args );
                $counter    =   $categ->count;
                if( isset($received['count'])   ){
                    $counter = $counter+$received['count'];
                }

                $categ_select_list     .=   '<li role="presentation" data-value="'.esc_attr($categ->slug).'">'. ucwords ( urldecode( $categ->name ) ).' ('.$counter.')'.'</li>';
                if(isset($received['html'])){
                    $categ_select_list     .=   $received['html'];
                }

            }
            $transient_appendix =   '';
            $transient_appendix =   wpestate_add_language_currency_cache($transient_appendix,1);
            wpestate_set_transient_cache('wpestate_get_action_select_list'.$transient_appendix,$categ_select_list,4*60*60);

        }
        return $categ_select_list;
    }
endif;
/**
*
*
*
*
*
*/



if (!function_exists('wpestate_hierarchical_category_childen_v2')):

    function wpestate_hierarchical_category_childen_v2($multiple_selected_values,$taxonomy,$multiple, $cat, $args, $base = 1, $level = 1) {
        $level++;
        $args['parent'] = $cat;
  
        $children = wpestate_get_cached_terms($taxonomy, $args);
        $return_array = array();
        $total_main[$level] = 0;
        $children_categ_select_list = '';
        foreach ($children as $categ) {

            $area_addon = '';
            $city_addon = '';
            $county_addon='';

            if ($taxonomy == 'property_city') {

                $term_meta = get_option("taxonomy_$categ->term_id");

                $string_county = '';
                if (isset($term_meta['stateparent'])) {
                    $string_county = wpestate_limit45(sanitize_title($term_meta['stateparent']));
                }
                $slug_county = sanitize_key($string_county);


                $string = wpestate_limit45(sanitize_title($categ->slug));
                $slug = sanitize_key($string);
                $city_addon = '  data-parentcounty="' . esc_attr($slug_county) . '" data-value2="' . esc_attr($slug) . '" ';
            }

            if ($taxonomy == 'property_county_state') {

               

                $string = wpestate_limit45(sanitize_title($categ->slug));
                $slug = sanitize_key($string);
                $county_addon = '  data-value2="' . esc_attr($slug) . '" ';
            }



            if ($taxonomy == 'property_area') {
                $term_meta = get_option("taxonomy_$categ->term_id");
                $string = wpestate_limit45(sanitize_title($term_meta['cityparent']));
                $slug = sanitize_key($string);
                $area_addon = ' data-parentcity="' . esc_attr($slug) . '" ';
            }

            $hold_base = $base;
            $base_string = '';
            $base++;
            $hold_base = $base;

            if ($level == 2) {
                $base_string = '-';
            } else {
                $i = 2;
                $base_string = '';
                while ($i <= $level) {
                    $base_string .= '-';
                    $i++;
                }
            }


            if ($categ->parent != 0) {
                $received = wpestate_hierarchical_category_childen_v2($multiple_selected_values,$taxonomy, $multiple,$categ->term_id, $args, $base, $level);
            }


            $counter = $categ->count;
            if (isset($received['count'])) {
                $counter = $counter + $received['count'];
            }

            $children_categ_select_list .= '<option role="presentation" value="' . esc_attr($categ->slug) . '"   data-value="' . esc_attr($categ->slug) . '"  '.$county_addon.' '.$city_addon.' '.$area_addon;
            
            if( is_array($multiple_selected_values) && in_array($categ->slug,$multiple_selected_values) ||
            is_array($multiple_selected_values) && in_array(urldecode($categ->slug),$multiple_selected_values) ){
                $children_categ_select_list.= 'selected';
            }


            $children_categ_select_list .= '>' . $base_string . ' ' . ucwords(urldecode($categ->name)) . '</option>';

            if (isset($received['html'])) {
                $children_categ_select_list .= $received['html'];
            }

            $total_main[$level] = $total_main[$level] + $counter;

            $return_array['count'] = $counter;
            $return_array['html'] = $children_categ_select_list;
        }
        $return_array['count'] = $total_main[$level];


        return $return_array;
    }

endif;
