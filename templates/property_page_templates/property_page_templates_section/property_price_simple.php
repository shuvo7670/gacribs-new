<div itemprop="price" class="listing_main_image_price">
    <?php

        $price_per_guest_from_one       =   floatval( get_post_meta($post->ID, 'price_per_guest_from_one', true) );

        $price          = floatval( get_post_meta($post->ID, 'property_price', true) );
        wpestate_show_price($post->ID,$wpestate_currency,$wpestate_where_currency,0);
        $rental_type        =   wprentals_get_option('wp_estate_item_rental_type');
        $booking_type       =   wprentals_return_booking_type($post->ID);

        if($price!=0){
            if( $price_per_guest_from_one == 1){
                echo ' '.esc_html__( 'per guest','wprentals');
            }else{
                echo ' '.wpestate_show_labels('per_night',$rental_type,$booking_type);
            }
        }

    ?>
</div>