<?php
function wprentals_start_track_performance($name = 'default') {
    global $wpdb, $wprentals_performance_data;
    
    if (!isset($wprentals_performance_data)) {
        $wprentals_performance_data = [];
    }
    
    $wprentals_performance_data[$name] = [
        'start_time' => microtime(true),
        'start_memory' => memory_get_usage(),
        'start_queries' => $wpdb->num_queries,
        'start_query_time' => defined('SAVEQUERIES') && SAVEQUERIES ? 
            array_sum(array_column($wpdb->queries, 1)) : 0
    ];
}

function wprentals_end_track_performance($name = 'default') {
    global $wpdb, $wprentals_performance_data;
    
    if (!isset($wprentals_performance_data[$name])) {
        return false;
    }
    
    $end_time = microtime(true);
    $end_memory = memory_get_usage();
    $peak_memory = memory_get_peak_usage();
    
    $data = $wprentals_performance_data[$name];
    
    // Calculate metrics
    $metrics = [
        'execution_time' => round(($end_time - $data['start_time']) * 1000, 2),
        'memory_used' => round(($end_memory - $data['start_memory']) / 1024, 2),
        'peak_memory' => round($peak_memory / 1024 / 1024, 2),
        'queries_count' => $wpdb->num_queries - $data['start_queries']
    ];
    
    // Add query time if SAVEQUERIES is enabled
    if (defined('SAVEQUERIES') && SAVEQUERIES) {
        $current_query_time = array_sum(array_column($wpdb->queries, 1));
        $metrics['query_time'] = round($current_query_time - $data['start_query_time'], 4);
    }
    
    return $metrics;
}

function wprentals_display_performance_results($name = 'default') {
    global $wprentals_performance_data;
    
    if (!isset($wprentals_performance_data[$name])) {
        return;
    }
    
    $metrics = wprentals_end_track_performance($name);
    if (!$metrics) return;
    
    // Only show if user can manage options or if WP_DEBUG is true
    if (!current_user_can('manage_options') && (!defined('WP_DEBUG') || !WP_DEBUG)) {
        return;
    }
    
    $output = sprintf(
        '<div class="wprentals-performance-metrics" style="background: #f5f5f5; padding: 15px; margin: 10px 0; border: 1px solid #ddd;">
            <h3>WP Rentals Performance: %s</h3>
            <ul>
                <li>⏱️ Execution Time: %s ms</li>
                <li>💾 Memory Used: %s KB</li>
                <li>📈 Peak Memory: %s MB</li>
                <li>🔍 Database Queries: %d</li>
                %s
            </ul>
            <p><small>📊 For detailed analysis, check Query Monitor\'s Performance tab</small></p>
        </div>',
        esc_html($name),
        number_format($metrics['execution_time'], 2),
        number_format($metrics['memory_used']),
        number_format($metrics['peak_memory'], 2),
        $metrics['queries_count'],
        isset($metrics['query_time']) ? sprintf('<li>⚡ Query Time: %s seconds</li>', number_format($metrics['query_time'], 4)) : ''
    );
    
    echo $output;
}

function wprentals_track_this($name, callable $callback) {
    wprentals_start_track_performance($name);
    $result = $callback();
    wprentals_display_performance_results($name);
    return $result;
}



function wprentals_analyze_queries() {
    global $wpdb;
    
    if (!defined('SAVEQUERIES') || !SAVEQUERIES) {
        return 'Enable SAVEQUERIES in wp-config.php to analyze queries';
    }
    
    $queries = $wpdb->queries;
    $analysis = [
        'patterns' => [],
        'slow_queries' => [],
        'query_types' => [],
        'duplicate_patterns' => []
    ];
    
    foreach ($queries as $query) {
        $sql = $query[0];
        $time = $query[1];
        $caller = $query[2];
        
        // Analyze query type
        preg_match('/^(SELECT|INSERT|UPDATE|DELETE|SHOW|SET|CREATE|ALTER)/i', $sql, $matches);
        $type = $matches[0] ?? 'OTHER';
        $analysis['query_types'][$type] = ($analysis['query_types'][$type] ?? 0) + 1;
        
        // Track slow queries (over 0.01 seconds)
        if ($time > 0.01) {
            $analysis['slow_queries'][] = [
                'sql' => $sql,
                'time' => $time,
                'caller' => $caller
            ];
        }
        
        // Identify patterns (normalize the query)
        $pattern = preg_replace('/[\d]+/', 'N', $sql);
        $pattern = preg_replace('/\'[^\']+\'/', "'X'", $pattern);
        $analysis['patterns'][$pattern] = ($analysis['patterns'][$pattern] ?? 0) + 1;
    }
    
    // Find duplicate patterns (queries executed multiple times)
    foreach ($analysis['patterns'] as $pattern => $count) {
        if ($count > 1) {
            $analysis['duplicate_patterns'][$pattern] = $count;
        }
    }
    
    // Sort by count
    arsort($analysis['duplicate_patterns']);
    
    $output = '<div style="position: fixed; top: 32px; right: 20px; max-width: 800px; max-height: 80vh; overflow: auto; background: white; padding: 20px; border: 2px solid #ff0000; z-index: 9999; font-family: monospace;">';
    $output .= '<h2>WP Rentals Query Analysis</h2>';
    
    // Query Types Summary
    $output .= '<h3>Query Types</h3><ul>';
    foreach ($analysis['query_types'] as $type => $count) {
        $output .= "<li>{$type}: {$count}</li>";
    }
    $output .= '</ul>';
    
    // Top Duplicate Patterns (limited to top 10)
    $output .= '<h3>Top Repeated Query Patterns</h3>';
    $output .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    $output .= '<tr><th>Count</th><th>Query Pattern</th></tr>';
    $i = 0;
    foreach ($analysis['duplicate_patterns'] as $pattern => $count) {
        if ($i++ >= 10) break;
        $output .= "<tr><td>{$count}</td><td>" . esc_html(substr($pattern, 0, 150)) . "...</td></tr>";
    }
    $output .= '</table>';
    
    // Slow Queries
    $output .= '<h3>Slow Queries (>0.01s)</h3>';
    $output .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    $output .= '<tr><th>Time</th><th>Query</th><th>Caller</th></tr>';
    foreach ($analysis['slow_queries'] as $query) {
        $output .= sprintf(
            '<tr><td>%.4f</td><td>%s</td><td>%s</td></tr>',
            $query['time'],
            esc_html(substr($query['sql'], 0, 150)) . '...',
            esc_html($query['caller'])
        );
    }
    $output .= '</table>';
    
    $output .= '</div>';
    
    return $output;
}

// Add this to display the analysis
add_action('wp_footer', function() {
    if (current_user_can('manage_options')) {
        //echo wprentals_analyze_queries();
    }
}, 999);

if(!function_exists('wprentals_debug_queries')):
    function wprentals_debug_queries() {
        if (!is_admin() && defined('SAVEQUERIES') && SAVEQUERIES) {
            global $wpdb;
            
            // Initialize query categories
            $query_analysis = [
                'meta_queries' => [],
                'term_queries' => [],
                'post_queries' => [],
                'option_queries' => [],
                'slow_queries' => [],
                'other_queries' => []
            ];
            
            $total_time = 0;
            
            foreach ($wpdb->queries as $query) {
                $sql = $query[0];
                $time = floatval($query[1]);
                $caller = $query[2];
                $total_time += $time;
                
                // Categorize query
                if (strpos($sql, 'wp_postmeta') !== false) {
                    $category = 'meta_queries';
                } elseif (strpos($sql, 'wp_terms') !== false || strpos($sql, 'wp_term_relationships') !== false) {
                    $category = 'term_queries';
                } elseif (strpos($sql, 'wp_posts') !== false) {
                    $category = 'post_queries';
                } elseif (strpos($sql, 'wp_options') !== false) {
                    $category = 'option_queries';
                } else {
                    $category = 'other_queries';
                }
                
                // Track slow queries (over 0.01 seconds)
                if ($time > 0.01) {
                    $query_analysis['slow_queries'][] = [
                        'sql' => $sql,
                        'time' => $time,
                        'caller' => $caller
                    ];
                }
                
                // Count queries by caller
                if (!isset($query_analysis[$category][$caller])) {
                    $query_analysis[$category][$caller] = [
                        'count' => 1,
                        'time' => $time
                    ];
                } else {
                    $query_analysis[$category][$caller]['count']++;
                    $query_analysis[$category][$caller]['time'] += $time;
                }
            }
            
            // Display for admin users
            if (current_user_can('manage_options')) {
                echo '<div style="position: fixed; top: 32px; right: 20px; max-width: 800px; max-height: 80vh; overflow: auto; background: white; padding: 20px; border: 2px solid #ff0000; z-index: 999999; font-family: monospace;">';
                echo '<h2>WP Rentals Query Analysis</h2>';
                echo '<p>Total Query Time: ' . number_format($total_time * 1000, 2) . 'ms</p>';
                
                // Display each category
                foreach ($query_analysis as $category => $data) {
                    if ($category !== 'slow_queries' && !empty($data)) {
                        echo '<h3>' . ucwords(str_replace('_', ' ', $category)) . '</h3>';
                        echo '<table style="border-collapse: collapse; width: 100%; margin-bottom: 20px;">';
                        echo '<tr><th>Count</th><th>Time (ms)</th><th>Caller</th></tr>';
                        
                        // Sort by count
                        uasort($data, function($a, $b) {
                            return $b['count'] - $a['count'];
                        });
                        
                        foreach ($data as $caller => $stats) {
                            echo '<tr>';
                            echo '<td style="border: 1px solid #ddd; padding: 5px;">' . $stats['count'] . '</td>';
                            echo '<td style="border: 1px solid #ddd; padding: 5px;">' . number_format($stats['time'] * 1000, 2) . '</td>';
                            echo '<td style="border: 1px solid #ddd; padding: 5px; word-break: break-all;">' . esc_html($caller) . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    }
                }
                
                // Display slow queries
                if (!empty($query_analysis['slow_queries'])) {
                    echo '<h3>Slow Queries (>0.01s)</h3>';
                    echo '<table style="border-collapse: collapse; width: 100%;">';
                    echo '<tr><th>Time (ms)</th><th>Query</th><th>Caller</th></tr>';
                    foreach ($query_analysis['slow_queries'] as $query) {
                        echo '<tr>';
                        echo '<td style="border: 1px solid #ddd; padding: 5px;">' . number_format($query['time'] * 1000, 2) . '</td>';
                        echo '<td style="border: 1px solid #ddd; padding: 5px;">' . esc_html(substr($query['sql'], 0, 100)) . '...</td>';
                        echo '<td style="border: 1px solid #ddd; padding: 5px;">' . esc_html($query['caller']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                }
                
                echo '</div>';
            }
        }
    }
endif;

add_action('wp_footer', 'wprentals_debug_queries', 999);

add_action('wp_loaded', function() {
    if(defined('SAVEQUERIES') && SAVEQUERIES) {
        global $wpdb;
        $wpdb->queries = array(); // Reset queries to only catch page-specific ones
    }
});



add_action('wp_loaded', function() {
    wprentals_start_track_performance('page_load');
});

add_action('shutdown', function() {
    wprentals_display_performance_results('page_load');
}, 999);