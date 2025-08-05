<?php

if(!function_exists('wprentals_add_pins_icons')):
    /**
     * Adds pin icon fields for property categories and actions
     * Uses cached taxonomy terms to improve performance
     * 
     * @param array $pin_fields Existing pin field configurations
     * @return array Updated pin fields array with new configurations
     */
    function wprentals_add_pins_icons($pin_fields) {
        // Get property action categories
        $tax_terms = wpestate_get_cached_terms('property_action_category');
        
        // Add pins for action categories
        if (is_array($tax_terms)) {
            foreach ($tax_terms as $tax_term) {
                $post_name = sanitize_key(wpestate_limit54($tax_term->slug));
                $pin_fields[] = array(
                    'id' => 'wp_estate_' . $post_name,
                    'type' => 'media',
                    'required' => array('wp_estate_use_single_image_pin', '!=', 'yes'),
                    'title' => esc_html__('For action ', 'wprentals') . '<strong>' . $tax_term->name . '</strong>',
                    'subtitle' => esc_html__('Image size must be 44px x 50px.', 'wprentals'),
                    'default' => 'no',
                );
            }
        }
 
        // Get property categories
        $categories = wpestate_get_cached_terms('property_category');
        
        // Add pins for property categories
        if (is_array($categories)) {
            foreach ($categories as $categ) {
                $post_name = sanitize_key(wpestate_limit54($categ->slug));
                $pin_fields[] = array(
                    'id' => 'wp_estate_' . $post_name,
                    'type' => 'media',
                    'required' => array('wp_estate_use_single_image_pin', '!=', 'yes'),
                    'title' => esc_html__('For category ', 'wprentals') . '<strong>' . $categ->name . '</strong>',
                    'subtitle' => esc_html__('Image size must be 44px x 50px.', 'wprentals'),
                    'default' => 'no',
                );
            }
        }
 
        // Add pins for action-category combinations
        if (is_array($tax_terms) && is_array($categories)) {
            foreach ($tax_terms as $tax_term) {
                foreach ($categories as $categ) {
                    $combined_key = sanitize_key(wpestate_limit27($categ->slug)) . 
                                  sanitize_key(wpestate_limit27($tax_term->slug));
                    
                    $pin_fields[] = array(
                        'id' => 'wp_estate_' . $combined_key,
                        'type' => 'media',
                        'required' => array('wp_estate_use_single_image_pin', '!=', 'yes'),
                        'title' => __('For action', 'wprentals') . ' <strong>' . $tax_term->name . '</strong>, ' . 
                                 __('category', 'wprentals') . ': <strong>' . $categ->name . '</strong>',
                        'subtitle' => esc_html__('Image size must be 44px x 50px.', 'wprentals'),
                        'default' => 'no',
                    );
                }
            }
        }
 
        // Add user geolocation pin
        $pin_fields[] = array(
            'id' => 'wp_estate_userpin',
            'type' => 'media',
            'title' => esc_html__('Userpin in geolocation', 'wprentals') . '<strong>',
            'subtitle' => esc_html__('Image size must be 44px x 50px.', 'wprentals'),
            'default' => 'no',
        );
 
        return $pin_fields;
    }
 endif;