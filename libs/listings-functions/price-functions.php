<?php
/**
 * Original price display function that gets data directly from the database
 * 
 * Formats and displays the price for a property with currency symbols and labels
 * Handles both regular pricing and per-guest pricing
 * Supports custom currency conversion based on user preferences
 * 
 * @param int    $post_id               The ID of the property post
 * @param string $wpestate_currency     The currency symbol to use
 * @param string $wpestate_where_currency Whether to show currency before or after amount
 * @param int    $return                Whether to return (1) or print (0) the result
 * @return string|void                  Formatted price string or void if printing
 */
if (!function_exists('wpestate_show_price')):
    function wpestate_show_price($post_id, $wpestate_currency, $wpestate_where_currency, $return = 0) {
        // Get price labels from meta data
        $price_label = '<span class="price_label">' . esc_html(get_post_meta($post_id, 'property_label', true)) . '</span>';
        $property_price_before_label = esc_html(get_post_meta($post_id, 'property_price_before_label', true));
        $property_price_after_label = esc_html(get_post_meta($post_id, 'property_price_after_label', true));
        
        // Reset price label (note: this overwrites the previous price_label)
        $price_label = '';

        // Check if property uses per-guest pricing
        $price_per_guest_from_one = floatval(get_post_meta($post_id, 'price_per_guest_from_one', true));
        
        // Get appropriate price based on pricing model
        if ($price_per_guest_from_one == 1) {
            $price = floatval(get_post_meta($post_id, 'extra_price_per_guest', true));
        } else {
            $price = floatval(get_post_meta($post_id, 'property_price', true));
        }

        // Get thousands separator and currency settings
        $th_separator = wprentals_get_option('wp_estate_prices_th_separator', '');
        $custom_fields = wprentals_get_option('wpestate_currency', '');

        // Handle custom currency if user has selected one
        if (!empty($custom_fields) && 
            isset($_COOKIE['my_custom_curr']) && 
            isset($_COOKIE['my_custom_curr_pos']) && 
            isset($_COOKIE['my_custom_curr_symbol']) && 
            $_COOKIE['my_custom_curr_pos'] != -1) {
            
            $i = floatval($_COOKIE['my_custom_curr_pos']);
            $custom_fields = wprentals_get_option('wpestate_currency', '');
            
            if ($price != 0) {
                // Convert price to custom currency
                $price = $price * floatval($custom_fields[$i][2]);
                
                // Format the price number
                $price = number_format($price, 2, '.', $th_separator);
                $price = wpestate_TrimTrailingZeroes($price);
                
                // Use custom currency symbol
                $wpestate_currency = $custom_fields[$i][1];
                
                // Position currency symbol
                if ($custom_fields[$i][3] == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        } else {
            // Handle default currency display
            if ($price != 0) {
                // Format the price number
                $price = number_format($price, 2, '.', $th_separator);
                $price = wpestate_TrimTrailingZeroes($price);
                
                // Position currency symbol
                if ($wpestate_where_currency == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        }

        // Combine all parts of the price display
        $final_string = trim($property_price_before_label . ' ' . $price . ' ' . $price_label . $property_price_after_label);
        
        // Either print or return the result
        if ($return == 0) {
            print $final_string;
        } else {
            return $final_string;
        }
    }
endif;

/**
 * Optimized price display function that uses pre-cached data
 * 
 * Functions identically to wpestate_show_price but uses cached property data
 * instead of making separate database calls for each piece of information
 * 
 * @param array  $cached_data           Array containing all property meta and data
 * @param string $wpestate_currency     The currency symbol to use
 * @param string $wpestate_where_currency Whether to show currency before or after amount
 * @param int    $return                Whether to return (1) or print (0) the result
 * @return string|void                  Formatted price string or void if printing
 */
if (!function_exists('wpestate_show_price_from_cached_data')):
    function wpestate_show_price_from_cached_data($cached_data, $wpestate_currency, $wpestate_where_currency, $return = 0) {
        // Extract meta data from cached property data
        $meta = $cached_data['meta'];
        
        // Get price labels from cached meta
        $price_label = '<span class="price_label">' . esc_html($meta['property_label'] ?? '') . '</span>';
        $property_price_before_label = esc_html($meta['property_price_before_label'] ?? '');
        $property_price_after_label = esc_html($meta['property_price_after_label'] ?? '');
        $price_label = '';
        
        // Check if property uses per-guest pricing
        $price_per_guest_from_one = floatval($meta['price_per_guest_from_one'] ?? 0);
        
        // Get appropriate price based on pricing model
        if ($price_per_guest_from_one == 1) {
            $price = floatval($meta['extra_price_per_guest'] ?? 0);
        } else {
            $price = floatval($meta['property_price'] ?? 0);
        }

        // Get thousands separator and currency settings
        $th_separator = wprentals_get_option('wp_estate_prices_th_separator', '');
        $custom_fields = wprentals_get_option('wpestate_currency', '');

        // Handle custom currency if user has selected one
        if (!empty($custom_fields) && 
            isset($_COOKIE['my_custom_curr']) && 
            isset($_COOKIE['my_custom_curr_pos']) && 
            isset($_COOKIE['my_custom_curr_symbol']) && 
            $_COOKIE['my_custom_curr_pos'] != -1) {
            
            $i = floatval($_COOKIE['my_custom_curr_pos']);
            
            if ($price != 0) {
                // Convert price to custom currency
                $price = $price * floatval($custom_fields[$i][2]);
                
                // Format the price number
                $price = number_format($price, 2, '.', $th_separator);
                $price = wpestate_TrimTrailingZeroes($price);
                
                // Use custom currency symbol
                $wpestate_currency = $custom_fields[$i][1];
                
                // Position currency symbol
                if ($custom_fields[$i][3] == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        } else {
            // Handle default currency display
            if ($price != 0) {
                // Format the price number
                $price = number_format($price, 2, '.', $th_separator);
                $price = wpestate_TrimTrailingZeroes($price);
                
                // Position currency symbol
                if ($wpestate_where_currency == 'before') {
                    $price = $wpestate_currency . ' ' . $price;
                } else {
                    $price = $price . ' ' . $wpestate_currency;
                }
            } else {
                $price = '';
            }
        }

        // Combine all parts of the price display
        $final_string = trim($property_price_before_label . ' ' . $price . ' ' . $price_label . $property_price_after_label);
        
        // Either print or return the result
        if ($return == 0) {
            print $final_string;
        } else {
            return $final_string;
        }
    }
endif;