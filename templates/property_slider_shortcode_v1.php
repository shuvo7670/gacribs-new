<?php
if(isset($args['prop_id'])){
    $prop_id=intval($args['prop_id']);
}
$title              =   get_sanitized_truncated_title($prop_id, 0);

$booking_type       =   $wprentals_is_per_hour=  wprentals_return_booking_type($prop_id);
$rental_type        =   wprentals_get_option('wp_estate_item_rental_type');
$link               =   esc_url ( get_permalink($prop_id));
$link               =   wprentals_card_link_autocomplete($prop_id,$link,$wprentals_is_per_hour);

$preview = wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'wpestate_property_places');
if(isset($preview[0])){
    $thumb_prop =  esc_url($preview[0]);

}else{
    $thumb_prop = get_stylesheet_directory_uri() . '/img/defaultimage_prop.jpg';
}
$price                      =   intval( get_post_meta($prop_id, 'property_price', true) );      
$wpestate_currency          =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );
$wpestate_where_currency    =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
$property_city              =   get_the_term_list($prop_id, 'property_city', '', ', ', '') ;
$property_area              =   get_the_term_list($prop_id, 'property_area', '', ', ', '');
$featured                   =   intval  ( get_post_meta($prop_id, 'prop_featured', true) );
$excerpt                    =   wpestate_strip_excerpt_by_char(get_the_excerpt($prop_id),130,$prop_id);     
$property_action            =   get_the_term_list($prop_id, 'property_action_category', '', ', ', '');
$property_categ             =   get_the_term_list($prop_id, 'property_category', '', ', ', '');
$guests                     =   floatval( get_post_meta($prop_id, 'guest_no', true));
$bedrooms                   =   floatval( get_post_meta($prop_id, 'property_bedrooms', true));


?>



<div class="item">

    <div class="wpestate_properties_slider_v1_image" style="background-image:url(<?php echo esc_url($thumb_prop); ?>);">
        <?php
        if($featured==1){
            print '<div class="featured_div">'.esc_html__( 'featured','wprentals').'</div>';
        }
        echo wpestate_return_property_status($prop_id);
        ?>
    </div>


    <div class="wpestate_properties_slider_v1_content">
            <?php
                if(wpestate_has_some_review($prop_id)!==0){
                    print wpestate_display_property_rating( $prop_id );
                }else{
                    print '<div class=rating_placeholder></div>';
                }
            ?>



        <div class="price_unit">
            <?php
                wpestate_show_price($prop_id,$wpestate_currency,$wpestate_where_currency,0);
                if($price!=0){
                    echo '<span class="pernight"> '.wpestate_show_labels('per_night2',$rental_type,$booking_type).'</span>';
                }
            ?>
        </div>


        <div class="wpestate_properties_slider_v1_title"><a href="<?php echo esc_url($link)?>"><?php echo trim($title);?></a></div>
        <div class="wpestate_properties_slider_v1_location">
        <?php
            if ($property_area != '') {
                print trim($property_area).', ';
            }
            print trim($property_city);?>    
        </div>

        <div class="wpestate_properties_slider_v1_text"><?php echo trim($excerpt);?></div>
            

        <div class="wpestate_properties_slider_v1_details">
            

            <?php if(intval($bedrooms)==99999999999): ?>
                <div class="wpestate_properties_slider_v1_text_details_bedrooms wpestate_properties_slider_v1_single_details">
                <?php 
                    include (locate_template('img/svg_icons/slider_bedrooms.html'));
                    print intval($bedrooms);
                ?>
                </div>
            <?php endif; ?>

            <?php if(intval($bedrooms)>0): ?>
                <div class="wpestate_properties_slider_v1_text_details_guests wpestate_properties_slider_v1_single_details">
                <?php 
                    include (locate_template('img/svg_icons/slider_guets.html'));
                    print intval($guests);
                ?>
                </div>
            <?php endif;?>


            <?php if( $property_categ!=='' ): ?>
                <div class="wpestate_properties_slider_v1_text_details_categ wpestate_properties_slider_v1_single_details">
                <?php 
                    include (locate_template('img/svg_icons/slider_property_categ.html'));
                    print trim($property_categ);
                ?>
                </div>
            <?php endif;?>

            <?php if( $property_action!==''): ?>
                <div class="wpestate_properties_slider_v1_text_details_action_categ wpestate_properties_slider_v1_single_details">
                <?php 
                    include (locate_template('img/svg_icons/slider_property_action.html'));
                    print trim($property_action);
                ?>
                </div>
            <?php endif;?>

          
        </div>

        <div class="wpestate_properties_slider_v1_owner_section">
            <?php
            echo wprentals_card_owner_image($prop_id); 
            ?>
            <div class="owner_name">
            <?php
            echo trim(wprentals_card_owner_name($prop_id));
            ?>
            </div>
        </div>
    </div>


   

</div>
