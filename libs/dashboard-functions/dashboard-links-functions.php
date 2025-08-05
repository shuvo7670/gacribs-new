<?php
/**
 * Gets all dashboard template links at once and caches them
 * 
 * This function optimizes template link retrieval by:
 * 1. Using static caching for the current request
 * 2. Using transient caching for persistent storage
 * 3. Batch loading all dashboard template links in a single query
 * 
 * @since 4.0.0
 * @return array Array of template paths as keys and their permalink URLs as values
 */


if (!function_exists('wpestate_get_all_dashboard_template_links')):
    function wpestate_get_all_dashboard_template_links() {
        // Setup transient name with language support
        $transient_name = 'wpestate_dashboard_links';
        if (defined('ICL_LANGUAGE_CODE')) {
            $transient_name .= '_' . ICL_LANGUAGE_CODE;
        }
        
        // Try to get from WordPress transient cache
        $dashboard_links = wpestate_request_transient_cache($transient_name);
        if ($dashboard_links !== false && !empty($dashboard_links)) {
            return $dashboard_links;
        }
        
        // Define all dashboard templates we need to fetch
        $templates = array(
            'user_dashboard_main.php',
            'user_dashboard_add_step1.php',
            'user_dashboard_profile.php',
            'user_dashboard_packs.php',
            'user_dashboard_favorite.php',
            'user_dashboard.php',
            'user_dashboard_searches.php',
            'user_dashboard_my_reservations.php',
            'user_dashboard_my_bookings.php',
            'user_dashboard_inbox.php',
            'user_dashboard_invoices.php',
            'user_dashboard_edit_listing.php',
            'user_dashboard_add_step1.php',
            'user_dashboard_my_reviews.php',
            'compare_listings.php',
            'ical.php',
            'user_dashboard_allinone.php',
            'processor.php',
            'stripecharge.php',
            'advanced_search_results.php',
            'terms_conditions.php'


        );
        
        // Get all pages in one query
        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $templates,
            'number' => count($templates)
        ));
        
        $dashboard_links = array();
        
        if (!empty($pages)) {
            // Prime the post meta cache
            $page_ids = wp_list_pluck($pages, 'ID');
            update_postmeta_cache($page_ids);
            
            
            // Build links array using cached meta
            foreach ($pages as $page) {
                $template = get_post_meta($page->ID, '_wp_page_template', true); // Will use cache
                if ($template && in_array($template, $templates)) {
                    $dashboard_links[$template] = esc_url(get_permalink($page->ID));
                }
            }
            
            // Cache for 24 hours
            wpestate_set_transient_cache($transient_name, $dashboard_links, 60 * 60 * 24);
        }
        
        return $dashboard_links;
    }
endif;


/**
 * Optimized template link retrieval function
 * 
 * Acts as a wrapper to either return a dashboard link from cache
 * or fall back to the original single template lookup
 * 
 * @since 4.0.0
 * @param string $template_name The template file name to look up
 * @param int    $bypass       Whether to bypass cache (0 or 1)
 * @return string URL of the template page or empty string if not found
 */
if (!function_exists('wpestate_get_template_link')):
    function wpestate_get_template_link($template_name, $bypass = 0) {
        // Get all dashboard links from cache or fresh
        $dashboard_links = wpestate_get_all_dashboard_template_links();
        
        // Return cached dashboard link if available
        if (isset($dashboard_links[$template_name])) {
            return $dashboard_links[$template_name];
        }
        
        // Fall back to original function for non-dashboard templates
        return wpestate_get_template_link_original($template_name, $bypass);
    }
endif;

/**
 * Original template link lookup function
 * 
 * Looks up a single template's page URL and caches it individually
 * Used as fallback for non-dashboard templates
 * 
 * @since 4.0.0
 * @param string $template_name The template file name to look up
 * @param int    $bypass       Whether to bypass cache (0 or 1)
 * @return string URL of the template page or empty string if not found
 */
if (!function_exists('wpestate_get_template_link_original')):
    function wpestate_get_template_link_original($template_name, $bypass = 0) {
        // Generate transient name with language support
        $transient_name = $template_name;
        if (defined('ICL_LANGUAGE_CODE')) {
            $transient_name .= '_' . ICL_LANGUAGE_CODE;
        }
        
        // Try to get from cache unless bypassed
        $template_link = wpestate_request_transient_cache('wpestate_get_template_link_' . $transient_name);
        if ($template_link === false || $template_link === '' || $bypass == 1) {
            
            // Query parameters vary by language support
            if (defined('ICL_LANGUAGE_CODE')) {
                $pages = get_pages(array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => $template_name,
                ));
            } else {
                $pages = get_pages(array(
                    'meta_key' => '_wp_page_template',
                    'meta_value' => $template_name,
                    'number' => 1
                ));
            }
            
            // Get permalink if page exists
            if ($pages) {
                $template_link = esc_url(get_permalink($pages[0]->ID));
            } else {
                $template_link = '';
            }
            
            // Cache the result
            wpestate_set_transient_cache('wpestate_get_template_link_' . $transient_name, $template_link, 60 * 60 * 24);
        }
        
        return $template_link;
    }
endif;