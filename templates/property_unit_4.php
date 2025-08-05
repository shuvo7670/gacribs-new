
<?php
$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';

$col_class  =   'col-md-6';
$col_org    =   4;
$title              =   get_sanitized_truncated_title($post->ID, 0);

if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.esc_attr($wpestate_row_number_col).' shortcode-col';
}

if(isset($is_widget) && $is_widget==1 ){
    $col_class='col-md-12';
    $col_org    =   12;
}

if(isset($wpestate_full_page) && $wpestate_full_page==1 ){
    $col_class='col-md-4 ';
    $col_org    =   3;
    if(isset($is_shortcode) && $is_shortcode==1 && $wpestate_row_number_col==''){
        $col_class='col-md-'.esc_attr($wpestate_row_number_col).' shortcode-col';
    }
}

$link                       =   esc_url ( get_permalink());
$wprentals_is_per_hour      =   wprentals_return_booking_type($post->ID);
$link                       =   wprentals_card_link_autocomplete($post->ID,$link,$wprentals_is_per_hour);

$preview        =   array();
$preview[0]     =   '';


$listing_type_class='property_unit_v4';


global $schema_flag;
if( $schema_flag==1) {
   $schema_data='itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" ';
}else{
   $schema_data=' itemscope itemtype="http://schema.org/Product" ';
}
?>


<div <?php print trim($schema_data);?> class="listing_wrapper <?php print esc_attr($col_class).' '.esc_attr($listing_type_class); ?>  property_flex " data-org="<?php print esc_attr($col_org);?>" data-listid="<?php print esc_attr($post->ID);?>" >

    <?php if( $schema_flag==1) {?>
        <meta itemprop="position" content="<?php print esc_html($prop_selection->current_post);?>" />
    <?php } ?>

    <div class="property_listing " >
        <?php

            $featured           =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );
            $price              =   intval( get_post_meta($post->ID, 'property_price', true) );
            $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
            $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
            $property_action    =   get_the_term_list($post->ID, 'property_action_category', '', ', ', '');
            $property_categ     =   get_the_term_list($post->ID, 'property_category', '', ', ', '');


            $property_guests           =    floatval ( get_post_meta($post->ID, 'guest_no', true));  
            $property_bedrooms         =    floatval ( get_post_meta($post->ID, 'property_bedrooms', true));
            $property_bathrooms        =    floatval ( get_post_meta($post->ID, 'property_bathrooms', true));
            ?>


            <?php wpestate_print_property_unit_slider($post->ID,$wpestate_property_unit_slider,$wpestate_listing_type,$wpestate_currency,$wpestate_where_currency,$link,''); ?>

       

            <?php
            if($featured==1){
                print '<div class="featured_div">'.esc_html__( 'featured','wprentals').'</div>';
            }

            echo wpestate_return_property_status($post->ID);
            ?>

            <div class="wprentals-card-unit-details-wrapper">

                <div class="wprentals-card-unit-title-wrapper">

                <?php   
                    include(locate_template('templates/property_card_templates/property_card_title.php'));  

                    if(wpestate_has_some_review($post->ID)!==0){
                        print wpestate_display_property_rating_simple( $post->ID );
                    }
                ?>
                </div>


                <div class="category_tagline actions_icon">
                    <?php print wp_kses_post($property_categ);
                    if($property_action){
                        print ' <span>&#183;</span> ';
                    }                    
                    print wp_kses_post($property_action);?>
                </div>

                <div class="category_tagline">

                    <?php
                    if($property_guests!=0){
                      
                        printf( _n( '%s Guest', '%s Guests', $property_guests, 'wprentals' ), number_format_i18n( $property_guests ) );
                        if($property_bedrooms!=0 or $property_bathrooms!=0 ){
                            echo ' '.trim('<span>&#183;</span>').' ';
                        }
                    }   
                    
                    if($property_bedrooms!=0){

                        printf( _n( '%s Bedroom', '%s Bedrooms', $property_bedrooms, 'wprentals' ), number_format_i18n( $property_bedrooms ) );
                        if($property_bathrooms!=0 ){
                            echo ' '.trim('<span>&#183;</span>').' ';
                        }
                    }

                    if($property_bathrooms!=0){

                        printf( _n( '%s Bathroom', '%s Bathrooms', $property_bathrooms, 'wprentals' ), number_format_i18n( $property_bathrooms ) );
                     //   echo ' '.trim('<span>&#183;</span>').' ';

                    }
                    
                    ?>
                
                </div>
            

                <?php print wprentals_card_property_price($post->ID); ?>
            </div>


   





    </div>
</div>


<?php
/*
    <div class="category_tagline map_icon">
                    <?php
                    if ($property_area != '') {
                        print trim($property_area).', ';
                    }
                    print trim($property_city);?>
                </div>
    */

?>