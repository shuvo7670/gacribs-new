<?php

$main_image = wp_get_attachment_image_src(get_post_thumbnail_id($itemID), 'wpestate_blog_unit2');
$main_image_url = isset($main_image[0]) ? $main_image[0] : wprentals_get_option('wp_estate_prop_list_slider_image_palceholder', 'url');

$title = get_sanitized_truncated_title($itemID, 0); 
$link = esc_url(get_permalink($itemID));

$property_address = esc_html(get_post_meta($itemID, 'property_address', true));
$property_city = get_the_term_list($itemID, 'property_city', '', ', ', '');
$property_area = get_the_term_list($itemID, 'property_area', '', ', ', '');

$address_parts = array_filter([$property_address, $property_city, $property_area]);

$wpestate_currency = esc_html(wprentals_get_option('wp_estate_currency_label_main', ''));
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

$allowed_html = [
    'br' => [],
    'em' => [],
    'strong' => [],
    'b' => []
];

$new_page_option = wprentals_get_option('wp_estate_unit_card_new_page', '');
$target = $new_page_option === '_self' ? '' : 'target="' . esc_attr($new_page_option) . '"';

?>

<div class="property_unit_big_grid_content_wrapper property_listing" data-link="<?php echo esc_url($link); ?>">

    <div class="property_unit_big_grid_content" style="background-image:url('<?php echo esc_url($main_image_url); ?>')"></div>
    <div class="listing-hover-gradient"></div>

    <div class="property_unit_content_grid_big_details">
        <div class="featured_property_stars"><?php echo $featured_propr_stars; ?> </div>

        <div class="listing_unit_price_wrapper">
            <?php echo( $featured_propr_price) ; ?>
        </div>
        <h4>
            <a href="<?php echo esc_url($link); ?>" <?php echo esc_attr($target); ?>>
                <?php echo wp_kses($title, $allowed_html); ?>
            </a>
        </h4>
        <div class="property_unit_content_grid_big_details_location">
            <?php echo implode(', ', $address_parts); ?>
        </div>
    </div>
</div>
