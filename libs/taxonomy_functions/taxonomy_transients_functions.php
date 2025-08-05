<?php 
/**
 * Returns the mapping of taxonomy slugs to their corresponding transient keys.
 * 
 * This function provides a centralized way to manage the relationship between
 * property taxonomies and their transient storage keys. It's used throughout
 * the theme for consistent cache handling of taxonomy terms.
 * 
 * @return array Associative array of taxonomy slugs to transient keys
 */
function wpestate_get_taxonomy_transient_mapping() {
    return array(
        'property_action_category' => 'wpestate_action_terms',
        'property_category'        => 'wpestate_category_terms',
        'property_city'           => 'wpestate_city_terms',
        'property_area'           => 'wpestate_area_terms',
        'property_status'         => 'wpestate_status_terms',
        'property_features'       => 'wpestate_features_terms',
    );
}



function wpestate_get_cached_terms($taxonomy, $args = array('hide_empty' => 0), $cache_time = 43200) {
    // Define taxonomy to transient key mapping
    $taxonomy_transients = wpestate_get_taxonomy_transient_mapping();
    
    // Check if taxonomy is in our mapping
    if (!isset($taxonomy_transients[$taxonomy])) {
        error_log("WP Rentals: Attempted to fetch terms for unmapped taxonomy: {$taxonomy}");
        return false;
    }
    //error_log("WP Rentals: Args: " . print_r($args, true));
    
    // Create unique key based on taxonomy and args
    $args_hash = md5(serialize($args));
    $transient_key = $taxonomy_transients[$taxonomy] . '_' . $args_hash;
    
    // Try to get cached terms
    $terms = get_transient($transient_key);
    
    // If no cache exists or it has expired
    if ($terms === false) {
        //error_log("WP Rentals: Generating transients for transient_key : {$transient_key}");
        
        // Get fresh terms
        $terms = get_terms($taxonomy, $args);
        
        // Cache the results
        if (!is_wp_error($terms)) {
            set_transient($transient_key, $terms, $cache_time);
        }
    }else{
        //error_log("WP Rentals: Service from cache transients for transient_key: {$transient_key}");
    }
    
    return $terms;
}



/**
 * Resets the cached transients for property taxonomies.
 * 
 * This function handles cache invalidation for all property-related taxonomies:
 * - property_action_category
 * - property_category
 * - property_city
 * - property_area
 * 
 * It should be triggered whenever a term is added, edited, or deleted in any
 * of these taxonomies. The function automatically identifies the relevant
 * transient based on the taxonomy and removes it.
 *
 * @param int    $term_id  Term ID being modified
 * @param int    $tt_id    Term taxonomy ID
 * @param string $taxonomy Taxonomy slug
 */
function wprentals_reset_taxonomy_transients($term_id, $tt_id, $taxonomy) {
    global $wpdb;
    $taxonomy_transients = wpestate_get_taxonomy_transient_mapping();
   
    // Check if this taxonomy has a corresponding transient
    if (isset($taxonomy_transients[$taxonomy])) {
        $transient_key_base = $taxonomy_transients[$taxonomy];
        
        // Get all transients that start with our base key
        $transient_like = $wpdb->esc_like('_transient_' . $transient_key_base) . '%';
        $sql = $wpdb->prepare(
            "SELECT option_name FROM $wpdb->options WHERE option_name LIKE %s",
            $transient_like
        );
        $transients = $wpdb->get_col($sql);
        
        // Delete each matching transient
        foreach($transients as $transient) {
            $transient_name = str_replace('_transient_', '', $transient);
            delete_transient($transient_name);
            error_log('Resetting transient: ' . $transient_name . ' for taxonomy: ' . $taxonomy . ' (Term ID: ' . $term_id . ')');
        }
    }
}

// Hook into all term modification events
add_action('create_term', 'wprentals_reset_taxonomy_transients', 10, 3);
add_action('edited_term', 'wprentals_reset_taxonomy_transients', 10, 3);
add_action('delete_term', 'wprentals_reset_taxonomy_transients', 10, 3);