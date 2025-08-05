<?php


class WpRentalsSearch {
    //put your code here

    public $search_type;
    public $postid;
    public $search_fields;
    public $search_fields2;
    public $search_submit_link;
    public $use_extended_search;
    public $adv_search_label;
    public $adv_search_how;
    public $adv_search_icon;
    public $allowed_html;
    public $show_dropdowns;
    public $custom_fields;
    public $adv_submit;
    public $items_that_could_dropdown=array(
        'property_rooms',
        'property_bedrooms',
        'property_bathrooms',
        'guest_no'

    );
    public $found_dropdown;

    public $items_with_default_icons=array(
        'location'                      =>  'map_icon',
        'check_in'                      =>  'calendar_icon ',
        'check_out'                     =>  'calendar_icon ',
        'guest_no'                      =>  'guest_no_drop',
        'property_category'             =>  'types_icon',
        'property_action_category'      =>  'actions_icon',
        'property_rooms'                =>  'rooms_icon',
        'property_bedrooms'             =>  'bedrooms_icon',
        'property_bathrooms'            =>  'baths_icon'
    );

    public $adv_search_fields_no_per_row;
    public $adv_search_fields_no_per_row_half;




    /**
    *  class construct
    *
    *
    * @since    3.1
    * @access   public
    */


    function __construct() {

        $this->search_type              =   wprentals_get_option('wp_estate_adv_search_type','') ;
        $this->search_submit_link       =   wpestate_get_template_link('advanced_search_results.php');
        $this->search_fields2           =   wprentals_get_option('wpestate_set_search','') ;
        $this->use_extended_search      =   wprentals_get_option('wp_estate_show_adv_search_extended','');
        $this->allowed_html             =   array();
        $this->show_dropdowns           =   wprentals_get_option('wp_estate_show_dropdowns','');
        $this->custom_fields            =   wprentals_get_option('wpestate_custom_fields_list','');
        $this->found_dropdown           =   0;
        $this->adv_search_fields_no_per_row        =   ( floatval( wprentals_get_option('wp_estate_search_fields_no_per_row') ) );
        $this->adv_search_fields_no_per_row_half   =   ( floatval( wprentals_get_option('wp_estate_search_fields_no_per_row_half_map') ) );
        $this->set_search_fields();

    }

    /**
    *  set search fields
    *
    *
    * @since    3.1
    * @access   public
    */

    function set_search_fields(){
        global $search_defaults;

        if($this->search_type =='newtype'){
            $this->search_fields            =   $search_defaults['newtype'];
            $this->adv_search_label         =   $search_defaults['newtype']['adv_search_label'];
            $this->adv_search_how           =   $search_defaults['newtype']['adv_search_how'];
            $this->adv_search_icon          =   $search_defaults['newtype']['search_field_label'];


        } else if($this->search_type =='oldtype'){
            $this->search_fields            =   $search_defaults['newtype'];
            $this->adv_search_label         =   $search_defaults['newtype']['adv_search_label'];
            $this->adv_search_how           =   $search_defaults['newtype']['adv_search_how'];
            $this->adv_search_icon          =   $search_defaults['newtype']['search_field_label'];
        }else{
            $this->search_fields            =   wprentals_get_option('wpestate_set_search','') ;
            $this->adv_search_label         =   wprentals_get_option('wp_estate_adv_search_label');
            $this->adv_search_how           =   wprentals_get_option('wp_estate_adv_search_how');
            $this->adv_search_icon          =   wprentals_get_option('wp_estate_search_field_label');

        }
        
        


    }


    /**
    *  Set field data for half map
    *
    *
    * @since    3.1
    * @access   public
    */

    function change_data_to_half(){
        $this->search_fields            =   wprentals_get_option('wpestate_set_search_half_map','') ;
        $this->adv_search_label         =   wprentals_get_option('wp_estate_adv_search_label_half_map');
        $this->adv_search_how           =   wprentals_get_option('wp_estate_adv_search_how_half_map');
        $this->adv_search_icon          =   wprentals_get_option('wp_estate_search_field_label_half_map');

    }




    /**
    *  display search form
    *
    *
    * @since    3.1
    * @access   public
    */

    function wpstate_display_search_form($position) {


        if($position == 'half'){
            $this->change_data_to_half();
        }


        global $post;
        $post_id='';
        if(isset($post->ID)){
            $post_id = $post->ID;
        }
        $return_string=$this->get_advanced_search_wrapper($position);

        $return_string.='<div class="'.esc_attr($this->get_advanced_search_wrapper_class($position)).' advanced_search_form_wrapper"  data-postid="'.esc_attr($post_id).'">';

            $return_string.= '<form role="search" method="get"   action="'. esc_url( $this->search_submit_link ).'" >';
                if (function_exists('icl_translate') ){
                    $return_string.= do_action( 'wpml_add_language_form_field' );
                }

                if( $this->search_type =='type4' ){
                    $return_string.=$this->type4_inject_fields($position);
                }

                $return_string.=$this->display_search_fields($position);

                if($this->use_extended_search == 'yes'){
                   $return_string.=$this->wprentals_show_extended_search('adv');
                }

                $return_string.=  wp_nonce_field( 'wpestate_regular_search', 'wpestate_regular_search_nonce',true,false );

                $form_class =   $this->calculate_field_length('',$position);
                $return_string.= '<div class="'.$form_class.'" ><input name="submit" type="submit" class="advanced_search_submit_button "  value="'.__('Search','wprentals').'"></div>';


                if( $this->search_type =='type4' ){
                    $return_string.='</div>';
                }

                $return_string.=$this->show_extented_search($position);

            $return_string.= '</form>';
        $return_string.= '</div>';


        return $return_string;

    }



    /**
    *  show extended search
    *
    *
    * @since    3.1
    * @access   public
    */


    function show_extented_search($position,$show_elementor=''){
        
        if($show_elementor=='show'){
            return  $this->show_extended_search('adv');
        }else{
            $extended_search    =   wprentals_get_option('wp_estate_show_adv_search_extended','');
            if($extended_search=='yes'  && ( $this->search_type =='type3' || $this->search_type =='type4' || $this->search_type =='type5' || $position=='half')  ){
                return  $this->show_extended_search('adv');
            }
        }
    }

    /**
    *  show extended search
    *
    *
    * @since    3.1
    * @access   public
    */
    function show_extended_search($tip){

  
        $terms =wpestate_get_cached_terms('property_features');

        foreach($terms as $key => $term){
            if (defined('ICL_SITEPRESS_VERSION')) {
                $term_name = $term->name;
                $term_slug = $term->slug;

                $current_language = apply_filters('wpml_current_language', NULL);
                $default_language = apply_filters('wpml_default_language', NULL);
                if ($current_language != $default_language) {
                    $trid = apply_filters('wpml_element_trid', NULL, $term->term_id, 'tax_property_features');
                    $term_translations = apply_filters('wpml_get_element_translations', NULL, $trid, 'tax_property_features');
                    $original_term_id = $term_translations[$default_language]->element_id;
                    do_action('wpml_switch_language', $default_language);
                    $original_term = get_term($original_term_id);
                    do_action('wpml_switch_language', $current_language);
                    $term_slug = $original_term->slug;
                }
                $label_array[$term_slug]=$term_name;
            }else{
                $label_array[ $term->slug ]=$term->name;
            }





        }



        $return= '<div class="adv_extended_options_text" >'.__('More Search Options','wprentals').'</div>';
            $return.= '<div class="extended_search_check_wrapper">';
            $return.= '<span class="adv_extended_close_button" ><i class="fas fa-times"></i></span>';

                $advanced_exteded   =   wprentals_get_option( 'wp_estate_advanced_exteded');

                foreach($advanced_exteded as $value){
                    $input_name =   $value;
                    $label      =   $label_array[$value];
                    if($value!='none' && $label!=''){

                        $check_selected='';
                        if( isset($_GET[$input_name]) && $_GET[$input_name]=='1'  ){
                            $check_selected=' checked ';
                        }

                        //was  id="'.$input_name.$tip.'"
                        $return.='<div class="extended_search_checker">
                            <input type="checkbox" data-label-search="'.$input_name.'" id="'.$input_name.$tip.'" name="'.$value.'" value="1" '.$check_selected.'>
                            <label for="'.$input_name.$tip.'">'.($label).'</label>
                        </div>';
                    }
               }

        $return.= '</div>';


        return $return;
    }








    /**
    *  get advanced search wrapper class
    *
    *
    * @since    3.1
    * @access   public
    */
    function get_advanced_search_wrapper($position){
        

        if($position=='mobile' ||$position=='shortcode' || $position=='sidebar' || $position=='half'){
            return '';
        }

        $wrapper_array=array(
            'oldtype'   => '<div class="adv-1-wrapper"></div>',
            'newtype'   => '<div class="adv-2-header">'. esc_html__('Make a Reservation','wprentals').'</div><div class="adv-2-wrapper"></div>',
            'type3'     => '<div id="search_wrapper_color"></div><div id="adv-search-header-3">'.esc_html( wprentals_get_option('wp_estate_adv_search_label_for_form') ).'</div>',
            'type4'     => '<div id="search_wrapper_color"></div>',
            'type5'     => '<div class="adv-2-header">'.esc_html(wprentals_get_option('wp_estate_adv_search_label_for_form')).'</div><div class="adv-5-wrapper"></div>',
            'elementor' => '<div class="adv-2-header">'. esc_html__('Make a Reservation','wprentals').'</div><div class="adv-2-wrapper"></div>',
         
        );

        if($position=='elementor'){
             return $wrapper_array['elementor'] ;
        }
        
        if(wprentals_get_option('wp_estate_adv_search_label_for_form')==''){
            $wrapper_array[ 'type5' ] ='<div class="adv-5-wrapper"></div>';
        }
        return $wrapper_array[$this->search_type] ;
    }






    /**
    *  get advanced search wrapper class
    *
    *
    * @since    3.1
    * @access   public
    */

    function get_advanced_search_wrapper_class($position){
        global $post;
        $default_class_array=array(
            'oldtype'   =>  'adv-search-1',
            'newtype'   =>  'adv-search-2',
            'type3'     =>  'adv-search-3',
            'type4'     =>  'adv-search-4',
            'type5'     =>  'adv-search-5',
            'elementor' => 'elementor-search-form-builder',
        );

        if($position=='elementor'){
            return $default_class_array['elementor'];
        }

        if(wprentals_get_option('wp_estate_adv_search_label_for_form')==''){
            $default_class_array[ 'type5' ] ='adv-search-5 search5-nolabel';
        }


        if($position=='mobile' || $position=='half'){
            return '';
        }

        $default_class                      =   $default_class_array[$this->search_type];
        $wpestate_header_type               =   '';
        if(isset($post->ID)){
            $wpestate_header_type               =   get_post_meta ( $post->ID, 'header_type', true);
        }
        $wpestate_global_header_type        =   wprentals_get_option('wp_estate_header_type','');


        $google_map_lower_class='';
        if (!$wpestate_header_type==0){  // is not global settings
           if ($wpestate_header_type==5){
               $google_map_lower_class='adv_lower_class';
           }
       }else{    // we don't have particular settings - applt global header
           if($wpestate_global_header_type==4){
               $google_map_lower_class='adv_lower_class';
           }
       }

        $close_class                =   '';
        $extended_search    =   wprentals_get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';
        $show_adv_search_visible    =   wprentals_get_option('wp_estate_show_adv_search_visible','');

        if ( $extended_search =='yes' ){
            $extended_class='adv_extended_class';
            if($show_adv_search_visible=='no'){
                $close_class='adv-search-1-close-extended';
            }
        }

        $to_return= $default_class.' '.$google_map_lower_class.' '.$close_class.' '.$extended_class.' ';
        if(isset($post->ID)){
            $to_return=$to_return.$post->ID;
        }
        
        return $to_return;


    }






    /**
    *  display search fields
    *
    *
    * @since    3.1
    * @access   public
    */
    function display_search_fields($position){
        $return_string  =   '';
        foreach($this->search_fields['adv_search_what'] as $key=>$field){
            if($field=='none'){
                continue;
            }

            $label      =   $this->search_field_get_label($key);
            $icon       =   $this->search_field_get_icon($key,$field);
            $form_class =   $this->calculate_field_length($field,$position);
            $term_value =   '';

            if( isset( $_REQUEST[$field] ) ){
                $term_value = wpestate_sanitize_text_array ( $_REQUEST[$field] );
            }

            $return_string.=  '<div class=" '.esc_attr($form_class).' '.esc_attr( str_replace(" ","_",$label) ).' '.$icon['class'].' ">';
                $return_string  .=  $icon['icon'];
                $return_string  .=  $this->build_search_field($key,$field,$label,$term_value,$position);
            $return_string.=   '</div>';
        }
        return  $return_string;
    }






    /**
    *  inject fields for type 4
    *
    *
    * @since    3.1
    * @access   public
    */

    function type4_inject_fields($position){
        $args                       =   wpestate_get_select_arguments();
        $categ_select_list          =   wpestate_get_category_select_list($args);
        $action_select_list         =   wpestate_get_action_select_list($args);

        $return  =  wpestate_search_type_inject($categ_select_list,$action_select_list,$position);
        $return .=  '<div class="col-md-2 adv_handler_wrapper">
            <div class="adv_handler"><i class="fas fa-sliders-h" aria-hidden="true"></i></div>
            <input name="submit" type="submit" class="wpb_btn-info wpb_btn-small wpestate_vc_button  vc_button" id="advanced_submit_4" value="'. esc_html__('SEARCH','wprentals').'">
        </div>

        <input type="hidden" name="is11" value="11">

        <div class="adv_search_hidden_fields ">';

        return $return;

    }









    /**
    *  calculate field length
    *
    *
    * @since    3.1
    * @access   public
    */

    function calculate_field_length($field,$position){

        $return_class='';

        $swithc_value=$this->adv_search_fields_no_per_row;

        if($position=='half'){
            $swithc_value=$this->adv_search_fields_no_per_row_half;
        }



        switch ( $swithc_value ) {
            case 1:
                $return_class=12;
                break;
            case 2:
                $return_class=6;
                break;
            case 3:
                $return_class=4;
                break;
            case 4:
                $return_class=3;
                break;
            case 6:
                $return_class=2;
                break;
        }


        // if we have type 1 or type 2 we force to col-md-2 class
        if($this->search_type =='oldtype' && $position!='half' ){
            $return_class=2;
        }

        if($field=='property_price' || $field=='Location' ){
            $return_class=intval($return_class)*2;
        }


        // if we have type 1 or type 2 we force to col-md-2 class
        if( ( $this->search_type =='newtype' && $position=='mainform' ) || $position =='sidebar' || $position =='sidebar' || $position =='mobile'){
            $return_class=12;
        }



        // compose the bootstrap class
        $return_class='col-md-'.$return_class;
        return $return_class;
    }



    /**
    *  build search fields
    *
    *
    * @since    3.1
    * @access   public
    */


    function build_search_field($key,$field,$label,$term_value,$position){


        $return_string     =   '';
        $form_field         =   strtolower($field);

        if($form_field=='none'){
            //nothing
            $return_string .='';
        }else if(   strtolower($form_field)=='property_beds_baths'  ){
            $return_string .=$this->wpestate_show_beds_baths_component($label,$position);
        }else if(   strtolower($form_field)=='property_price_v2'  ){
            $return_string .= $this->wpestate_display_price_v2($label,$position);
        }else if(   strtolower($form_field)=='guest_no' &&  wprentals_get_option('wp_estate_custom_guest_control','') =='yes' ){
            $return_string .= $this->wpestate_display_guest_no_field($label,$position);
        }else if(   strtolower($form_field)=='location' ){

            // In case of a location field
            $return_string .= $this->wpestate_search_location_field($label,$position);

        }else if(   strtolower($form_field)=='property_country' ){

            // In case of a country
            $return_string .=  wpestate_country_list_adv_search('',$term_value,$label);

        }else if ( $form_field=='property_price'){

            // in case of a price slide
             $return_string .= wpestate_price_form_adv_search($position,$form_field,$label);

        }else if (   $this->show_dropdowns   =='yes' && in_array($form_field, $this->items_that_could_dropdown) ){

            // In case we have items that could dropdown and drop down is set to yes
            $get_rooms_select_list_dropdow  =   $this->get_rooms_select_list_dropdow($form_field,$label);
            $return_string                  .=  wpestate_build_dropdown_adv_new('',$form_field,$term_value,$get_rooms_select_list_dropdow,$label);

        }else if ($this->rentals_is_tax_case($form_field) ){

   
            $appendix='';
            $active='active';
            $return_string .= wpestate_show_dropdown_taxonomy_v21($form_field,$term_value, $label, $appendix,$active); 
        }else{
            //  in case we have an item from custom field
           $return_string.=$this->search_field_from_custom_fields($key,$form_field,$label,$term_value,$position);
        }
        return $return_string;
    }







/**
 *
 *
 *
 * @since    3.1
 * @access   public
 */



function search_field_from_custom_fields($key,$form_field,$label,$term_value,$position){

    $i                      =   0;
    $this->found_dropdown   =   0;
    $return_string          =   '';

    if( !empty($this->custom_fields)){
        while($i< count($this->custom_fields) ){

            $name       =   str_replace(' ', '-',  $this->custom_fields[$i][0]) ;
            if( sanitize_key($name) == $form_field && $this->custom_fields[$i][2]=='dropdown' ){
                $dropdown_select_list =   $this->custom_field_dropdown_list($key,$i);
                $return_string      .=  wpestate_build_dropdown_adv_new('',$form_field,$term_value,$dropdown_select_list,$label);
            }
            $i++;
        }
    }

        
    $adv_search_how_internal= $this->adv_search_how;  
    if( $this->search_type =='elementor' ){
        $elementor_search_name_how      = "elementor_search_how_" . $this->postid;
        $adv_search_how_internal         =   get_option($elementor_search_name_how,true);
    } 
        

        
        
        
    if($this->found_dropdown==0){
        //////////////// regular field
        $field_id=sanitize_key($form_field);

        if($adv_search_how_internal[$key]=='date bigger' || $adv_search_how_internal[$key]=='date smaller' || $form_field=='check_in' || $form_field=='check_out'){
            if($position=='sidebar'){
                $field_id=$form_field.'_widget';
            }else if($position=='shortcode'){
                $field_id=$form_field.'_shortcode';
            }else if($position=='mobile'){
                $field_id=$form_field.'_mobile';
            }
        }

        $return_string.='<input type="text"    id="'.$field_id.'"  name="'.sanitize_key($form_field).'"'  . ' placeholder="'. stripslashes(wp_kses($label,$this->allowed_html)).'" ';
        $return_string.= ' class="advanced_select form-control custom_icon_class_input" value="';

        if (isset($_GET[sanitize_key($form_field)])) {
            $return_string.=  esc_attr( stripslashes( $_GET[sanitize_key($form_field)] ) );
        }
        $return_string.='" />';

        ////////////////// apply datepicker if is the case
        if ( $adv_search_how_internal[$key]=='date bigger' || $adv_search_how_internal[$key]=='date smaller' ){
            if( $form_field !='check_in' && $form_field !='check_out'){
                $this->wpestate_date_picker_translation(sanitize_key($field_id));
            }
        }
    }

    return $return_string;
}










/**
 *
 *
 *
 * @since    3.1
 * @access   public
 */

function custom_field_dropdown_list($key,$i){

    $this->found_dropdown   =   1;
          
    $adv_search_label_internal= $this->adv_search_label;  
    if( $this->search_type =='elementor' ){
        $elementor_search_name_label    =   "elementor_search_label_" . $this->postid;
        $adv_search_label_internal      =   get_option($elementor_search_name_label,true);       
    } 
    
    
    
    $front_name     =   esc_html($adv_search_label_internal[$key]);
    if (function_exists('icl_translate') ){
        $initial_key            =   apply_filters('wpml_translate_single_string', trim($front_name),'custom field value','custom_field_value_cc'.$front_name );
        $dropdown_select_list     =   '<li role="presentation" data-value="all"> '. stripslashes($initial_key) .'</li>';
    }else{
        $dropdown_select_list =   ' <li role="presentation" data-value="all">'. stripslashes( $front_name).'</li>';
    }



    $dropdown_values_array=explode(',',$this->custom_fields[$i][4]);

    foreach($dropdown_values_array as $drop_key=>$value_drop){
        $original_value_drop    =   $value_drop;
        if (function_exists('icl_translate') ){
            $value_drop = apply_filters('wpml_translate_single_string', trim($value_drop),'custom field value','custom_field_value'.$value_drop );
        }
        $dropdown_select_list .=   ' <li role="presentation" data-value="'.esc_attr($original_value_drop).'">'. stripslashes(trim($value_drop)).'</li>';
    }

    return $dropdown_select_list;
}








    /**
    *  get field label
    *
    *
    * @since    3.1
    * @access   public
    */

    function search_field_get_label($key){
        $label  =       $this->adv_search_label [$key];
    
        $translation_labels=array(
            'Where do you want to go ?'  =>  esc_html__('Where do you want to go ?','wprentals'),
             'Check-In'                  =>  esc_html__('Check-In','wprentals'),
             'Check-Out'                 =>  esc_html__('Check-Out','wprentals'),
             'Guests'                    =>  esc_html__('Guests','wprentals'),
             'Type Keyword'              =>  esc_html__('Type Keyword','wprentals'),
             'Rooms'                     =>  esc_html__('Rooms','wprentals'),
             'All Types'                 =>  esc_html__('All Types','wprentals'),
             'All Sizes'                 =>  esc_html__('All Sizes','wprentals'),
             'Bedrooms'                  =>  esc_html__('Bedrooms','wprentals'),
             'Baths'                     =>   esc_html__('Baths','wprentals'),
             'Price Range'               =>  esc_html__('Price Range','wprentals'),
             'Location'               =>  esc_html__('Location','wprentals'),
             'Type'               =>  esc_html__('Type','wprentals'),
             'Category'               =>  esc_html__('Category','wprentals'),
             'Bathrooms'               =>  esc_html__('Bathrooms','wprentals'),
        );
     
        if(isset($translation_labels [   $this->adv_search_label [$key] ])){
            $label  =   $translation_labels [   $this->adv_search_label [$key] ];
        }
    

        if (function_exists('icl_translate') ){
            $label     =   icl_translate('wprentals','wp_estate_custom_search_'.$label, $label ) ;
        }

        $label   =  wp_kses($label,$this->allowed_html);
        return $label;
    }


    function search_field_get_icon($key,$field){
        $return_array=array(
            'class' => '',
            'icon'  => '',
        );


        // it has no iconclass and no icon
        if($field=='property_price'){
            return $return_array;
        }


        if($this->adv_search_icon[$key]==''){

            $field=strtolower($field);
            if( array_key_exists (  $field, $this->items_with_default_icons )){
                $return_array=array(
                    'class' => $this->items_with_default_icons[$field],
                    'icon'  => '',
                );
            }

        }else{
            $return_array=array(
                'class' => '',
                'icon'  => '<i class="custom_icon_class_icon '.$this->adv_search_icon[$key].'"></i>',
            );
        }



        return $return_array;
    }



/**
*  datepicket initiale
*
*
* @since    3.1
* @access   public
*/


 function wpestate_date_picker_translation($selector){

    if( $selector !=='check_in' &&  $selector !=='check_out' ){
        $date_lang_status= apply_filters( 'wpestate_datepicker_language','' );
        $dates_types=array(
            '0' =>'yy-mm-dd',
            '1' =>'yy-dd-mm',
            '2' =>'dd-mm-yy',
            '3' =>'mm-dd-yy',
            '4' =>'dd-yy-mm',
            '5' =>'mm-yy-dd',

        );

        print '<script type="text/javascript">
                    //<![CDATA[
                    jQuery(document).ready(function(){
                            jQuery("#'.$selector.'").datepicker({
                                    dateFormat : "'.$dates_types[esc_html ( wprentals_get_option('wp_estate_date_format','') )].'"
                            },jQuery.datepicker.regional["'.$date_lang_status.'"]).datepicker("widget").wrap(\'<div class="ll-skin-melon"/>\');
                    });
                    //]]>
            </script>';

    }
}












    /**
    *  display search fields
    *
    *
    * @since    3.1
    * @access   public
    */

    function wprentals_show_extended_search($type){

    }


    /**
    *  display search fields
    *
    *
    * @since    3.1
    * @access   public
    */
    function wpestate_show_search_field(){

    }


    /**
    *  check if search term is taxonomy
    *
    *
    * @since    3.1
    * @access   public
    */

    function rentals_is_tax_case($term){
        if($term=='property_category' || $term=='property_action_category' || $term=='property_city' || $term=='property_area' ){
            return true;
        }
        return false;

    }


    
    /**
    *  display guest no custom control
    *
    *
    * @since    3.1
    * @access   public
    */

    
    
    function wpestate_display_guest_no_field($label,$position=''){         
        $return=wpestate_show_advanced_guest_form($label, $position,'' );
        return $return;
    }
     
    /**
    *  display beds and baths custom control
    *
    *
    * @since    3.1
    * @access   public
    */
        

    function wpestate_show_beds_baths_component($label,$position){
        $beds_values     = wprentals_get_option('wp_estate_beds_component_values', '');
        $baths_values    = wprentals_get_option('wp_estate_baths_component_values', '');
        $beds_selection  = $this->wpestate_get_component_selection($beds_values, 'wp_estate_beds_component','active');
        $baths_selection = $this->wpestate_get_component_selection($baths_values, 'wp_estate_baths_component','active');
    
        $default_value=esc_html__('Beds/Baths', 'wprentals');
        if($label!='') $default_value=$label;
    
        $return_string='';
        $is_half=null;
   
        
        
        $componentsbeds='';
        $componentsbaths='';
        if(( isset($_REQUEST['componentsbeds']) || isset($_REQUEST['componentsbaths']))  ){
            if( isset($_REQUEST['componentsbeds']) ){
                $componentsbeds  = floatval( $_REQUEST['componentsbeds'] );
            }
    
            if( isset($_REQUEST['componentsbaths']) ){
                $componentsbaths = floatval($_REQUEST['componentsbaths']);
            }       
            $default_value= floatval( $componentsbeds) .'+ '.esc_html__('bd','wprentals').'/'.floatval($componentsbaths).'+ '.esc_html__('ba','wprentals');
        }
    
      
        $componentsbeds_value ='';
        if(isset( $_REQUEST['componentsbeds'])){
            $componentsbeds_value =sanitize_text_field($_REQUEST['componentsbeds']);
        }
        $componentsbaths_value ='';
        if(isset( $_REQUEST['componentsbaths'])){
            $componentsbeds_value =sanitize_text_field($_REQUEST['componentsbaths']);
        }
    
    
        $return_string .= '
            <div class="dropdown form-control custom_icon_class wpestate-multiselect-custom-style  wpestate-beds-baths-popoup-component" style="width:100%;">
                <div class="filter_menu_trigger   dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%;">
                    ' . esc_html($default_value) . '
                    <span class="caret caret_filter "></span>
                </div>
                <div class="dropdown-menu wpestate-beds-baths-popoup-wrapper">
                    <h3>' . esc_html__('Beds', 'wprentals') . '</h3>
                    <div>' . $beds_selection . '</div>
                    <h3>' . esc_html__('Baths', 'wprentals') . '</h3>
                    <div>' . $baths_selection . '</div>
                    <div>
                        <div  class="wpestate-beds-baths-popoup-reset" data-default-value="'.esc_attr($default_value).'">' . esc_html__('Reset', 'wprentals') . '</div>
                        <div  class="wpestate-beds-baths-popoup-done">' . esc_html__('Done', 'wprentals') . '</div>
                    </div>
                    <input type="hidden" name="componentsbeds"   class="wpresidence-componentsbeds"  value="'.esc_html( $componentsbeds_value).'">
                    <input type="hidden" name="componentsbaths"  class="wpresidence-componentsbaths" value="'.esc_html ($componentsbaths_value).'">
                </div>
            </div>';
  
    
        return $return_string;
    }



    function wpestate_get_component_selection($component_values, $class_prefix,$active) {
        $component_values_array = explode(',', $component_values);
    
      
     
        $component_selection = array_map(function($value) use ($class_prefix,$active) {
                $selected_class = '';
    
                if($active =='active'):
                    if ($class_prefix === 'wp_estate_beds_component' && isset($_REQUEST['componentsbeds']) && $value == $_REQUEST['componentsbeds']) {
                        $selected_class = ' wp_estate_component_item_selected';
                    } elseif ( $class_prefix === 'wp_estate_baths_component' && isset($_REQUEST['componentsbaths']) && $value == $_REQUEST['componentsbaths']) {
                        $selected_class = ' wp_estate_component_item_selected';
                    }
                endif;
    
                return '<div class="' . esc_attr($class_prefix) . '_item' . $selected_class . '" data-value="' . floatval($value) . '">' . esc_html($value) . '</div>';
            }, $component_values_array);
    
    
    
    
        return implode('', $component_selection);
    }



    /**
    *  display price v2 search form
    *
    *
    * @since    3.1
    * @access   public
    */

    
    function wpestate_display_price_v2($label,$position=''){

        $return_string='';
      
        
        if($position=='mainform'){
            $slider_id      =   'slider_price';
            $price_low_id   =   'price_low';
            $price_max_id   =   'price_max';
            $ammount_id     =   'amount';
            
        }else if($position=='sidebar') {
            $slider_id      =   'slider_price_widget';
            $price_low_id   =   'price_low_widget';
            $price_max_id   =   'price_max_widget';
            $ammount_id     =   'amount_wd';
            
        }else if($position=='shortcode') {
            $slider_id      =   'slider_price_sh';
            $price_low_id   =   'price_low_sh';
            $price_max_id   =   'price_max_sh';
            $ammount_id     =   'amount_sh';
            
        }else if($position=='mobile') {
            $slider_id      =   'slider_price_mobile';
            $price_low_id   =   'price_low_mobile';
            $price_max_id   =   'price_max_mobile';
            $ammount_id     =   'amount_mobile';
           
        }else if($position=='half') {
            $slider_id='slider_price';
            $price_low_id   =   'price_low';
            $price_max_id   =   'price_max';
            $ammount_id     =   'amount';
            
        }
        $default_value=esc_html__('Price', 'wprentals');
        if($label!='') $default_value=$label;

        if(isset($_REQUEST['price_label_component']) && $_REQUEST['price_label_component']!=''  ){
            $default_value= sanitize_text_field( $_REQUEST['price_label_component'] );
        }

        $label_value='';
        if(isset($_GET['price_label_component']) ){
            $label_value=sanitize_text_field( $_GET['price_label_component']);
        }



   
        $min_price_slider   = ( floatval(wprentals_get_option('wp_estate_show_slider_min_price','')) );
        $max_price_slider   = ( floatval(wprentals_get_option('wp_estate_show_slider_max_price','')) );

        if(isset($_GET['price_low'])){
            $min_price_slider   =  floatval($_GET['price_low']) ;
        }

        if(isset($_GET['price_low'])){
            $max_price_slider=  floatval($_GET['price_max']) ;
        }

        $wpestate_where_currency=   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
        $wpestate_currency      =   esc_html( wprentals_get_option('wp_estate_currency_symbol', '') );

        $price_slider_label_data = wpestate_show_price_label_slider_v2($min_price_slider,$max_price_slider,$wpestate_currency,$wpestate_where_currency);


        $price_slider_label         =   $price_slider_label_data['label'];
        $price_slider_label_min     =   $price_slider_label_data['label_min'];
        $price_slider_label_max     =   $price_slider_label_data['label_max'];

        $return_string='
        <div class="dropdown form-control dropdown custom_icon_class wpestate-multiselect-custom-style   wpestate-beds-baths-popoup-component" style="width:100%;">
            <div  class="filter_menu_trigger   dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-default-value="'.esc_attr($default_value).'" style="width:100%;">
            ' . esc_html($default_value) . '
            <span class="caret caret_filter "></span>
            </div>
            <div class="dropdown-menu wpestate-price-popoup-wrapper">
            <h3>' . esc_html__('Price selector', 'wprentals') . '</h3>';

                        $return_string.='<div class="wpestate_pricev2_component_adv_search_wrapper">
                        <input type="text" id="component_'.$price_low_id.'" class="component_adv_search_elementor_price_low price_active wpestate-price-popoup-field-low"   value="'.$price_slider_label_min.'" data-value="'.esc_attr($price_slider_label_min).'" />
                        <input type="text" id="component_'.$price_max_id.'" class="component_adv_search_elementor_price_max price_active wpestate-price-popoup-field-max"   value="'.$price_slider_label_max.'" data-value="'.esc_attr($price_slider_label_max).'" />
                        </div>';


                        $return_string.='<div class="adv_search_slider">';

                        $return_string.=' 
                            <p>
                                <label for="amount">'. esc_html__('Price range:','wprentals').'</label>
                                <span id="'.$ammount_id.'"  style="border:0;  font-weight:bold;" data-default="'.esc_attr($price_slider_label).'" >'.$price_slider_label.'</span>
                            </p>
                            <div id="'.$slider_id.'"></div>';
                        $custom_fields = wprentals_get_option('wpestate_currency',''); 
                        if( !empty($custom_fields) && isset($_COOKIE['my_custom_curr']) &&  isset($_COOKIE['my_custom_curr_pos']) &&  isset($_COOKIE['my_custom_curr_symbol']) && $_COOKIE['my_custom_curr_pos']!=-1){
                            $i=intval($_COOKIE['my_custom_curr_pos']);

                            if( !isset($_GET['price_low']) && !isset($_GET['price_max'])  ){
                                $min_price_slider       =   $min_price_slider * $custom_fields[$i][2];
                                $max_price_slider       =   $max_price_slider * $custom_fields[$i][2];
                            }
                        }

                     //   $return_string.='
                       //    <input type="hidden" id="'.$price_low_id.'"  name="price_low"  value="'.$min_price_slider.'"/>
                      //      <input type="hidden" id="'.$price_max_id.'"  name="price_max"  value="'.$max_price_slider.'"/>
                      //  </div>';

                        $return_string .= '
                        <input type="hidden" id="' . $price_low_id . '"  name="price_low"  class="single_price_low" data-value="' . floatval($min_price_slider) . '" value="' . floatval($min_price_slider) . '"/>
                        <input type="hidden" id="' . $price_max_id . '"  name="price_max"  class="single_price_max" data-value="' . floatval($max_price_slider) . '" value="' . floatval($max_price_slider) . '"/>
                        <input type="hidden"  class="price_label_component" name="price_label_component"   value="'.esc_html($label_value).'" />';
                        $return_string.='</div>';


        $return_string .='
        <div  class="wpestate-price-component-popoup-reset">' . esc_html__('Reset', 'wprentals') . '</div>
        <div  class="wpestate-price-component-popoup-done">' . esc_html__('Done', 'wprentals') . '</div>
    </div>
</div>';
        
        return $return_string;
    }
    
    
    /**
    *  show location field
    *
    *
    * @since    3.1
    * @access   public
    */

    function wpestate_search_location_field($label,$position=''){
        $return                             =   '';
        $show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
        $wpestate_internal_search           =   '';
        $search_location                    =   '';
        $search_location_tax                =   'tax';
        $advanced_city                      =   '';
        $advanced_area                      =   '';
        $advanced_country                   =   '';
        $property_admin_area                =   '';

        if($position=='mainform'){
            $position='';
        }

        if(isset($_GET['search_location'])){
            $search_location = sanitize_text_field($_GET['search_location']);
        }


        if(isset($_GET['stype']) && $_GET['stype']=='meta'){
            $search_location_tax = 'meta';
        }

        if(isset($_GET['advanced_city']) ){
            $advanced_city = sanitize_text_field($_GET['advanced_city']);
        }

        if(isset($_GET['advanced_area']) ){
            $advanced_area = sanitize_text_field($_GET['advanced_area']);
        }

        if(isset($_GET['advanced_country']) ){
            $advanced_country = sanitize_text_field($_GET['advanced_country']);
        }

         if(isset($_GET['property_admin_area']) ){
            $property_admin_area = sanitize_text_field($_GET['property_admin_area']);
        }


        if($show_adv_search_general=='no'){
            $wpestate_internal_search='_autointernal';
            $return.= '<input type="hidden" class="stype" id="stype" name="stype" value="'.$search_location_tax.'">';
        }
        $wpestate_autocomplete_use_list             =   wprentals_get_option('wp_estate_wpestate_autocomplete_use_list','');
        if ($wpestate_autocomplete_use_list=='yes' && $show_adv_search_general=='no'){
            $return.= wprentals_location_custom_dropwdown($_REQUEST,$label);
        }else{
            $label_to_show=esc_html__('Where do you want to go ?','wprentals');
            if($label!=''){
                $label_to_show=$label;
            }
            $return.=  '<input type="text" autocomplete="off"   id="search_location'.$position.$wpestate_internal_search.'"      class="form-control" name="search_location" placeholder="'.$label_to_show.'" value="'.$search_location.'"  >';
        }

        $inputId= "search_location".$position.$wpestate_internal_search;
        $return.='  <input type="hidden" autocomplete="off" id="advanced_city'.esc_attr($position).'"      class="form-control" name="advanced_city" data-value=""   value="'.esc_attr($advanced_city).'" >
                    <input type="hidden" autocomplete="off" id="advanced_area'.esc_attr($position).'"      class="form-control" name="advanced_area"   data-value="" value="'.esc_attr($advanced_area).'" >
                    <input type="hidden" autocomplete="off" id="advanced_country'.esc_attr($position).'"   class="form-control" name="advanced_country"   data-value="" value="'.esc_attr($advanced_country).'" >
                    <input type="hidden" autocomplete="off" id="property_admin_area'.esc_attr($position).'" name="property_admin_area" value="'.esc_attr($property_admin_area).'">';



        $availableTags=get_option('wpestate_autocomplete_data',true);
        $show_adv_search_general            =   wprentals_get_option('wp_estate_wpestate_autocomplete','');
        $wpestate_autocomplete_use_list             =   wprentals_get_option('wp_estate_wpestate_autocomplete_use_list','');

        if($show_adv_search_general=='no' && $wpestate_autocomplete_use_list!=='yes'){

                $return.= '<script type="text/javascript">
                //<![CDATA[
                jQuery(document).ready(function(){
                    var availableTags = ['.$availableTags.'];
                    var inputId="'.$inputId.'";
                    wprentalsInitializeAutocomplete(availableTags,inputId);
                });
                //]]>
                </script>';
        }


        return $return;

    }



     /**
    *  get dropddown for rooms, bedrooms. bathrooms or guests
    *
    *
    * @since    3.1
    * @access   public
    */

    function get_rooms_select_list_dropdow($search_field,$label){


        if($search_field=='property_bedrooms'){
            $beds_values     = wprentals_get_option('wp_estate_beds_component_values', '');
            if($beds_values!=''){
                $values_array =  explode(',', $beds_values);
                return $this->wprentals_custom_values_dropdowns($label,$values_array);
            }
      
        }else if($search_field=='property_bathrooms'){
            $baths_values    = wprentals_get_option('wp_estate_baths_component_values', '');
            if($baths_values!=''){
                $values_array =  explode(',', $baths_values);
                return $this->wprentals_custom_values_dropdowns($label,$values_array);
            }   
        }


        $i=0;
        $rooms_select_list =   ' <li role="presentation" data-value="all">'.esc_html($label).'</li>';
        $max=10;

        if($search_field=='guest_no'){
            $max =   intval   ( wprentals_get_option('wp_estate_guest_dropdown_no','') );
        }

        while($i < $max ){
            $i++;
            $rooms_select_list.='<li data-value="'.esc_attr($i).'"  value="'.esc_attr($i).'">'.esc_html($i).'</li>';
        }

        return $rooms_select_list;

    }
     /**
    *  get dropddown for rooms, bedrooms. bathrooms or guests
    *
    *
    * @since    3.1
    * @access   public
    */
    function wprentals_custom_values_dropdowns($label,$values_array){
        $select_list =   ' <li role="presentation" data-value="all">'.esc_html($label).'</li>';
        if(is_array($values_array)){
            foreach($values_array as $key=>$value){
                $select_list.='<li data-value="'.floatval($value).'"  value="'.floatval($value).'">'.esc_html($value).'</li>';
            } 
        }
        
        return $select_list;
    }

    /**
    *  display search form elementor
    *
    *
    * @since    3.1
    * @access   public
    */

    function wpstate_display_search_form_elementor($settings,$elementor_this,$post_id) {
        ob_start();
        ?>
        <div class="search_wrapper search_wr_elementor search_wr_elementor_shadow"> 
           <div class="search_wrapper_color"></div>

           <?php
           if($settings['form_field_show_section_title']=='true'){
               print ' <div class="adv-search-header">'. $settings['form_field_section_title_text'].'</div>';
           }
           ?>

           <div class="wpestate-adv-holder">
               <?php
                print   '<form role="search" method="get" action="'. esc_url( $this->search_submit_link ).'"  >';
                    print  trim( $this->wpestate_search_form_render_fields($settings,$elementor_this,'','') );
                    print  trim( $this->wpestate_elementor_show_button($settings));
                    if( $settings['form_field_show_exra_details']){
                        print trim($this->show_extented_search('mainform','show'));
                    }
                    print   '<input type="hidden" name="elementor_form_id" value="'.intval($post_id).'">';
                print   '</form>';
               ?>
           </div>

        </div>

        <?php
        $return = ob_get_contents();
        ob_end_clean();

        return $return;


    }

    
    
    /*
     * 
     * Rednder fields for elementor search form builder
     * 
     *  
     **/
    
    function wpestate_search_form_render_fields($settings,$elementor_this,$term_slug,$term_id){

    $args                       =   wpestate_get_select_arguments();

    $show_slider_price          =   wprentals_get_option('wp_estate_show_slider_price','');
    $return = '';
    
   
    foreach ($settings['form_fields'] as $key => $item) :
        

   
           
            $elementor_this->wpestate_render_attributes($key, $item, $settings);
            $return.= '<div '.$elementor_this->get_render_attribute_string('field-group' . $key).'>';

         
            if ( $item['field_label'] ) {
                if( $item['field_type']!=='property price' ||( $item['field_type']=='property price') && $show_slider_price =='no' ){
                    $return.= '<label '.$elementor_this->get_render_attribute_string('label' . $key) .'>' . $item['field_label'].'</label>';
                }
            }

            
            ob_start();
            
            $term_value='';
            if( isset( $_REQUEST[$item['field_type']] ) ){
                $term_value = sanitize_text_field ( rawurldecode($_REQUEST[$item['field_type']]) );
            }
            print '<div class="elementor_search_builder_field_wrapper">';
                if($item['field_type']!='property_price'){
                    \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); 
                }
                print trim($this->build_search_field($key,$item['field_type'],$item['placeholder'],$term_value,'mainform'));
            print '</div>';
            
            
            $return_content_fields= ob_get_contents();
            ob_end_clean();

            $return.= $return_content_fields.'</div>';
        
    endforeach;
    
    return $return;
}


/*
 * show search buttons
 * 
 * 
 * 
 * 
 * 
 * */


function wpestate_elementor_show_button($settings){
    $form_field_show_labels_class='';
    if($settings['form_field_show_labels']=='true'){
        $form_field_show_labels_class=" form_field_show_labels_true ";
    }
    
    $extra_button_class=' button_with_text_wprentals ';
    if($settings['submit_button_text']==''){
        $extra_button_class='';
    }
    
    $return_string=  '<div class="elemenentor_submit_wrapper elementor-field-group form-group '.esc_attr($form_field_show_labels_class).' elementor-column elementor-col-'.esc_attr($settings['submit_button_width']).'" >';
    $return_string.= '<button name="submit" type="submit" class="advanced_search_submit_button '.esc_attr( $extra_button_class).'"  value="'.esc_html($settings['submit_button_text']).'">';

    
   
        ob_start();
        \Elementor\Icons_Manager::render_icon( $settings['search_icon_button'], [ 'aria-hidden' => 'true' ] ); 
        $icon = ob_get_contents();
        ob_end_clean();      
        $return_string.='<div class="elementor-icon">'.$icon.'</div>';
  
    
    $return_string.= esc_html($settings['submit_button_text']).'</button>';
    $return_string.= '</div>';
              
    return $return_string;
}


//end class
}
