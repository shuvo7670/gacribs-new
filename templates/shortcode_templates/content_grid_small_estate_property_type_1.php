<?php

$main_image = wp_get_attachment_image_src(get_post_thumbnail_id($itemID), 'blog_thumb');
$main_image_url = isset($main_image[0]) ? $main_image[0] : wprentals_get_option('wp_estate_prop_list_slider_image_palceholder', 'url');

$title = get_sanitized_truncated_title($itemID, 0); // Assuming wpestate_return_property_card_title() is not required
$link = esc_url(get_permalink($itemID));

$property_address = esc_html(get_post_meta($itemID, 'property_address', true));
$property_city = get_the_term_list($itemID, 'property_city', '', ', ', '');
$property_area = get_the_term_list($itemID, 'property_area', '', ', ', '');
$address_parts = array_filter([$property_address, $property_city, $property_area]);

$property_bedrooms =    get_post_meta($itemID, 'property_bedrooms', true);
$property_bathrooms =   get_post_meta($itemID, 'property_bathrooms', true);
$guests             =   floatval( get_post_meta($itemID, 'guest_no', true));
$guestString        = sprintf( _n('%s Guest', '%s Guests', $guests, 'wprentals'),$guests);


$wpestate_currency = esc_html(wprentals_get_option('wp_estate_currency_symbol', ''));
$where_currency = esc_html(wprentals_get_option('wp_estate_where_currency_symbol', ''));
$price_per_guest_from_one = floatval(get_post_meta($itemID, 'price_per_guest_from_one', true));
$rental_type = wprentals_get_option('wp_estate_item_rental_type');
$booking_type = wprentals_return_booking_type($itemID);

if ($price_per_guest_from_one == 1) {
    $featured_propr_price = wpestate_show_price($itemID, $wpestate_currency, $where_currency, 1) . ' <div class="featured_price_label">' . esc_html__('per guest', 'wprentals-core') . '</div>';
} else {
    $featured_propr_price = wpestate_show_price($itemID, $wpestate_currency, $where_currency, 1) . ' <div class="featured_price_label"><span class="pernight">' . wpestate_show_labels('per_night2', $rental_type, $booking_type) . '</span></div>';
}

$featured_propr_stars = '';

if (wpestate_has_some_review($itemID) !== 0) {
    $featured_propr_stars = wpestate_display_property_rating($itemID);
}
$featured_propr_stars = '';

if (wpestate_has_some_review($itemID) !== 0) {
    $featured_propr_stars = wpestate_display_property_rating($itemID);
}
$allowed_html = [
    'br' => [],
    'em' => [],
    'strong' => [],
    'b' => []
];

$new_page_option = wprentals_get_option('wp_estate_unit_card_new_page', '');
$target = $new_page_option === '_self' ? '' : 'target="' . esc_attr($new_page_option) . '"';

$details = array_filter([
    $property_bedrooms ? $property_bedrooms . ' ' . esc_html__('Bedrooms', 'wprentals') : '',
    $property_bathrooms ? $property_bathrooms . ' ' . esc_html__('Baths', 'wprentals') : '',$guestString    

]);
$details_string = implode('<span class="wpestate_separator_dot">&#183;</span>', $details);

?>

<div class="wpestate_content_grid_wrapper_second_col_item_wrapper" data-listid="<?php print intval($itemID);?>" >
    <div class="wpestate_content_grid_wrapper_second_col_image property_listing" style="background-image:url('<?php echo $main_image_url; ?>')" data-link="<?php echo esc_attr($link); ?>"></div>

    <div class="property_unit_content_grid_small_details">
        <?php if( !empty($featured_propr_stars) ){ ?>
            <div class="featured_property_stars"><?php echo $featured_propr_stars; ?> </div>
        <?php }?>


        <div class="listing_unit_price_wrapper">
            <?php echo( $featured_propr_price) ; ?>
        </div>

    
        <h4>
            <a href="<?php echo $link; ?>" <?php echo $target; ?>>
                <?php echo wp_kses($title, $allowed_html); ?>
            </a>
        </h4>
        <div class="property_unit_content_grid_small_details_location property_unit_content_grid_small_address ">
            <?php echo implode(', ', $address_parts); ?>
        </div>
        <div class="property_unit_content_grid_small_details_location">
            <?php echo $details_string; ?>
        </div>
    </div>
</div>
