<?php
global $wpestate_curent_fav;
$wpestate_currency              =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );
$wpestate_where_currency        =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
global $show_compare;
global $wpestate_show_compare_only;
global $show_remove_fav;
global $wpestate_options;
global $isdashabord;
global $align;
global $align_class;
global $is_shortcode;
global $wpestate_row_number_col;
global $type;
$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';
$col_class          =   'col-md-6';
$col_org            =   4;
$booking_type       =   wprentals_return_booking_type($post->ID);
$rental_type        =   wprentals_get_option('wp_estate_item_rental_type');
if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.esc_attr($wpestate_row_number_col).' shortcode-col';
}

$link           =   esc_url(get_permalink());
$preview        =   array();
$preview[0]     =   '';
?>

<div class="listing_wrapper" data-org="12" data-listid="<?php print intval($post->ID);?>" >
    <div class="property_listing" data-link="<?php print esc_attr($link);?>">
        <?php
        if ( has_post_thumbnail() ):

            $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_listings');
            $extra= array(
                'data-original' =>  $preview[0],
                'class'         =>  'lazyload img-responsive',
            );

            $thumb_prop         =   get_the_post_thumbnail($post->ID, 'wpestate_property_listings',$extra);
            $thumb_id           =   get_post_thumbnail_id($post->ID);
            $thumb_prop_url     =   wp_get_attachment_image_src($thumb_id,'wpestate_property_featured');
            $featured           =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );
            $property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
            $property_area      =   get_the_term_list($post->ID, 'property_area', '', ', ', '');
            $currency_code      =   wprentals_get_option('wp_estate_currency_symbol', '');
            $title              =   get_sanitized_truncated_title(0,  40);
           
            ?>




            <div class="listing-unit-img-wrapper_color">
              <div class="listing-hover-gradient"></div>
              <div class="listing-unit-img-wrapper" style="background-image:url('<?php echo esc_url($thumb_prop_url[0]);?>')"></div>
            </div>

            <?php
            if($featured==1){
                print '<div class="featured_div">'.esc_html__( 'featured','wprentals').'</div>';
            }

            echo wpestate_return_property_status($post->ID);


            $price_per_guest_from_one       =   floatval( get_post_meta($post->ID, 'price_per_guest_from_one', true) );

            if($price_per_guest_from_one==1){
                $price          =   floatval( get_post_meta($post->ID, 'extra_price_per_guest', true) );
            }else{
                $price          =   floatval( get_post_meta($post->ID, 'property_price', true) );
            }
            ?>
            <div class="category_name">
                <div class="" itemprop="offers" itemscope itemtype="http://schema.org/Offer">  
                  <link itemprop="url" href="<?php echo esc_url($link);?>"/>   
                  <meta itemprop="priceCurrency" content="<?php echo esc_html($currency_code);?>" />

                  <div class="price_unit">
                    <span itemprop="price" content="<?php echo floatval($price);?>">
                    <?php
                    wpestate_show_price($post->ID,$wpestate_currency,$wpestate_where_currency,0);
                    if($price!=0){
                      print '<span class="pernight"> '.wpestate_show_labels('per_night2',$rental_type,$booking_type).'</span>';
                    }
                    ?>
                  </div>
                </div>
                <?php
                  $total_stars = get_post_meta($post->ID , 'property_stars', TRUE);
                if (!$total_stars) {
                    $total_stars = wpestate_calculate_property_rating($post->ID );
                }


                $tmp_rating = json_decode($total_stars, TRUE);
                $review_number = number_format( ($tmp_rating['rating']),2,'.');

                print   '<meta itemprop="ratingValue" content="'.floatval($review_number).'"/>';

                if(wpestate_has_some_review($post->ID)!==0){
                    print wpestate_display_property_rating( $post->ID );
                }

                print '<a class="featured_listing_title" href="'.esc_url($link).'">'.esc_html($title).'</a>';

                print '<div class="category_tagline">';
                  if ($property_area != '') {
                      print trim($property_area).', ';
                  }
                  print trim($property_city);
                print '</div>';?>

          </div>
        <?php
        endif;
        ?>
    </div>
</div>
