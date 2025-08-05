<?php
$main_image     =   wp_get_attachment_image_src(get_post_thumbnail_id($itemID), 'blog_thumb');
$main_image_url =   isset($main_image[0]) ? $main_image[0] : wprentals_get_option('wp_estate_prop_list_slider_image_palceholder', 'url');
$title          =   get_sanitized_truncated_title($itemID, 0);
$link           =   esc_url(get_permalink($itemID));
$date           =   get_the_date( get_option('date_format'),$itemID);
$excerpt        =   wpestate_strip_excerpt_by_char(get_the_excerpt($itemID),85,$itemID,'...');
$new_page_option=   wprentals_get_option('wp_estate_unit_card_new_page', '');
$target         =   $new_page_option === '_self' ? '' : 'target="' . esc_attr($new_page_option) . '"';
$allowed_html = [
    'br' => [],
    'em' => [],
    'strong' => [],
    'b' => []
];
?>



<div class="wpestate_content_grid_wrapper_second_col_item_wrapper">
    <div class="wpestate_content_grid_wrapper_second_col_image property_listing" style="background-image:url('<?php echo $main_image_url; ?>')" data-link="<?php echo $link; ?>"></div>

    <div class="property_unit_content_grid_small_details">
        <div class="blog_unit_meta">
            <?php echo trim($date); ?>
        </div>
        <h4>
            <a href="<?php echo $link; ?>" <?php echo $target; ?>>
                <?php echo wp_kses($title, $allowed_html); ?>
            </a>
        </h4>
        <div class="property_unit_content_grid_small_details_location">
            <?php       echo trim($excerpt); ?>
        </div>
    
    </div>
</div>
