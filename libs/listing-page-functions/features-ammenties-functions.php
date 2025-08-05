<?php 
/**
 * Generates HTML output for property features with hierarchical structure
 * 
 * This function processes and displays property features in a structured format,
 * handling both parent-child relationships and standalone features. It includes
 * performance metrics tracking for monitoring execution time, memory usage,
 * and database queries.
 *
 * @param int $post_id The ID of the property post
 * @return string HTML output containing all property features
 */
function estate_listing_features($post_id) {
    $single_return_string = '';   // Holds standalone features
    $multi_return_string = '';    // Holds parent-child feature structures
    
    // Load all required data in batch to minimize database queries
    $feature_data = wpestate_batch_load_feature_data($post_id);
    
    // Process features if we have valid parsed data
    if (is_array($feature_data['parsed_features'])) {
        foreach ($feature_data['parsed_features'] as $key => $item) {
            // Handle features with children (parent features)
            if (count($item['childs']) > 0) {
                // Start parent feature block
                $multi_return_string_part = '<div class="listing_detail col-md-12 feature_block_' . $item['name'] . ' ">';
                $multi_return_string_part .= '<div class="feature_chapter_name col-md-12">' . $item['name'] . '</div>';
                $multi_return_string_part_check = '';
                
                // Process child features if they exist
                if (is_array($item['childs'])) {
                    foreach ($item['childs'] as $key_ch => $child) {
                        $temp = wpestate_display_feature_optimized(
                            $feature_data['show_no_features'],
                            $child,
                            $feature_data['property_features'],
                            $feature_data['term_meta'],
                            $feature_data['term_mapping']
                        );
                        $multi_return_string_part .= $temp;
                        $multi_return_string_part_check .= $temp;  // Used to check if any children were actually displayed
                    }
                }
                
                // Close parent feature block
                $multi_return_string_part .= '</div>';
                // Only add to output if child features were displayed
                if ($multi_return_string_part_check != '') {
                    $multi_return_string .= $multi_return_string_part;
                }
            } else {
                // Handle standalone features (no children)
                $single_return_string .= wpestate_display_feature_optimized(
                    $feature_data['show_no_features'],
                    $item['name'],
                    $feature_data['property_features'],
                    $feature_data['term_meta'],
                    $feature_data['term_mapping']
                );
            }
        }
    }

    // Add standalone features to the end if they exist
    if (trim($single_return_string) != '') {
        $multi_return_string = $multi_return_string . '<div class="listing_detail col-md-12 feature_block_others "><div class="feature_chapter_name col-md-12">' . esc_html__('Other Features ', 'wprentals') . '</div>' . $single_return_string . '</div>';
    }

    return $multi_return_string;
}

/**
 * Batch loads all necessary feature data to minimize database queries
 * 
 * This function efficiently loads all required data for property features
 * in as few database queries as possible. It handles options, terms,
 * term relationships, and term meta data.
 *
 * @param int $post_id The ID of the property post
 * @return array Associative array containing all necessary feature data
 */
function wpestate_batch_load_feature_data($post_id) {
    // Load display options for features (1 query)
    $show_no_features = esc_html(wprentals_get_option('wp_estate_show_no_features', ''));
    
    // Get features associated with this property (1 query)
    $property_features = get_the_terms($post_id, 'property_features');
    
    // Get all possible feature terms (1 query)
    $all_terms =wpestate_get_cached_terms('property_features'); 
    
    // Build efficient lookup arrays for terms
    $term_mapping = [];
    $term_ids = [];
    if(!is_wp_error($all_terms)) {
        foreach($all_terms as $term) {
            $term_mapping[$term->name] = $term->term_id;
            $term_ids[] = $term->term_id;
        }
    }
    
    // Get hierarchical feature structure (1 query if cached)
    $parsed_features = wpestate_build_terms_array();
    
    // Batch load all term meta in one query
    $term_meta = array();
    if (!empty($term_ids)) {
        global $wpdb;
        // Prepare and execute single query for all term meta
        $meta_results = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT option_name, option_value FROM $wpdb->options WHERE option_name LIKE 'taxonomy_%' AND option_name IN (" . 
                implode(',', array_fill(0, count($term_ids), "'taxonomy_%d'")) . ")",
                ...$term_ids
            )
        );
        
        // Process results into usable format
        foreach ($meta_results as $result) {
            $term_meta[str_replace('taxonomy_', '', $result->option_name)] = maybe_unserialize($result->option_value);
        }
    }
    
    // Return all collected data
    return array(
        'show_no_features' => $show_no_features,
        'property_features' => $property_features,
        'parsed_features' => $parsed_features,
        'term_meta' => $term_meta,
        'term_mapping' => $term_mapping
    );
}

/**
 * Displays a single feature with optimized data access
 * 
 * Generates HTML for a single feature, handling its icon and presence/absence
 * status. Uses pre-loaded data to avoid additional database queries.
 *
 * @param string $show_no_features Whether to show absent features
 * @param string $term_name The name of the feature term
 * @param array $property_features Array of features associated with the property
 * @param array $term_meta Preloaded term meta data
 * @param array $term_mapping Name to ID mapping for terms
 * @return string HTML output for the feature
 */
function wpestate_display_feature_optimized($show_no_features, $term_name, $property_features, $term_meta, $term_mapping) {
    $return_string = '';
    $term_icon = '';
    
    // Get term ID from preloaded mapping
    $term_id = isset($term_mapping[$term_name]) ? $term_mapping[$term_name] : false;
    
    // Handle feature icon
    if ($term_id && isset($term_meta[$term_id])) {
        $current_term_meta = $term_meta[$term_id];
        if (!empty($current_term_meta['category_featured_image'])) {
            $svg_content = wpestate_get_svg_from_url($current_term_meta['category_featured_image']);
            if (!empty($svg_content)) {
                $term_icon = $svg_content;
            }
        }
    }
    
    // Generate feature HTML based on presence and display settings
    if ($show_no_features != 'no') {
        // Show both present and absent features
        if (is_array($property_features) && array_search($term_name, array_column($property_features, 'name')) !== false) {
            if ($term_icon == '') {
                $term_icon = '<i class="fas fa-check checkon"></i>';
            }
            $return_string .= '<div class="listing_detail col-md-6">' . $term_icon . trim($term_name) . '</div>';
        } else {
            if ($term_icon == '') {
                $term_icon = '<i class="fas fa-times"></i>';
            }
            $return_string .= '<div class="listing_detail not_present col-md-6">' . $term_icon . trim($term_name) . '</div>';
        }
    } else {
        // Show only present features
        if (is_array($property_features) && array_search($term_name, array_column($property_features, 'name')) !== false) {
            if ($term_icon == '') {
                $term_icon = '<i class="fas fa-check checkon"></i>';
            }
            $return_string .= '<div class="listing_detail col-md-6">' . $term_icon . trim($term_name) . '</div>';
        }
    }
    
    return $return_string;
}

/**
 * Safely loads and sanitizes SVG content from a file
 * 
 * Converts a URL to a filesystem path and loads SVG content directly,
 * implementing various security checks and sanitization measures.
 *
 * @param string $url URL of the SVG file in the uploads directory
 * @return string Sanitized SVG content or empty string on failure
 */
function wpestate_get_svg_from_url($url) {
    // Validate URL input
    if (empty($url)) {
        return '';
    }

    // Get WordPress upload directory information
    $upload_dir = wp_upload_dir();
    
    // Convert URL to server filesystem path
    $file_path = str_replace(
        $upload_dir['baseurl'],
        $upload_dir['basedir'],
        $url
    );
    
    // Verify file exists and is accessible
    if (!is_readable($file_path)) {
        return '';
    }
    
    // Validate file extension
    $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    if ($file_extension !== 'svg') {
        return '';
    }
    
    // Load and sanitize SVG content
    try {
        // Get raw file contents
        $svg_content = file_get_contents($file_path);
        
        // Validate basic SVG structure
        if (!preg_match('/<svg[\s>]/', $svg_content)) {
            return '';
        }
        
        // Security cleanup
        $svg_content = preg_replace('/<\?xml.*?\?>/', '', $svg_content);  // Remove XML declaration
        $svg_content = preg_replace('/<script[\s\S]*?<\/script>/', '', $svg_content);  // Remove script tags
        $svg_content = preg_replace('/on\w+="[^"]*"/', '', $svg_content);  // Remove event handlers
        
        return $svg_content;
        
    } catch (Exception $e) {
        // Log errors for debugging
        error_log('SVG Load Error: ' . $e->getMessage() . ' for file: ' . $file_path);
        return '';
    }
}



/**
 * Builds a hierarchical array of property features terms
 * 
 * Retrieves and structures property feature terms into a parent-child relationship.
 * Uses transient caching for performance except when WPML is active.
 * Only declared if function doesn't already exist to prevent conflicts.
 *
 * @return array Array of features with their children, cached when possible
 */
if (!function_exists('wpestate_build_terms_array')):
    function wpestate_build_terms_array()
    {
        // Try to get cached version of the features array
        $parsed_features = wpestate_request_transient_cache('wpestate_get_features_array');
        
        // Disable cache if WPML is active to ensure correct language content
        if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
            $parsed_features = false;
        }
        
        // If no cached data found or cache disabled, build the array
        if ($parsed_features === false) {
            $parsed_features = array();
            
            // Get all parent terms (terms without parents)
            $args= array(
                'hide_empty' => false,
                'parent'=> 0
            );
            $terms  =  wpestate_get_cached_terms('property_features', $args); 
            
            // Process each parent term
            foreach ($terms as $key => $term) {
                $temp_array = array();
                
                // Get child terms for current parent
                $child_terms = get_terms(array(
                    'taxonomy' => 'property_features',
                    'hide_empty' => false,
                    'parent'=> $term->term_id
                ));
                
                // Process child terms
                $children = array();
                if (is_array($child_terms)) {
                    foreach ($child_terms as $child_key => $child_term) {
                        $children[] = $child_term->name;
                    }
                }
                
                // Build the feature array structure
                $temp_array['name'] = $term->name;
                $temp_array['childs'] = $children;
                $parsed_features[] = $temp_array;
            }
            
            // Cache the results if WPML is not active
            if ( !defined( 'ICL_LANGUAGE_CODE' ) ) {
                wpestate_set_transient_cache('wpestate_get_features_array', $parsed_features, 60*60*4); // Cache for 4 hours
            }
        }
        
        return $parsed_features;
    }
endif;