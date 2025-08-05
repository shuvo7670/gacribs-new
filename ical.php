<?php
/**
 * Template Name: ICAL FEED
 * 
 * This template generates an iCalendar (.ics) feed for property bookings.
 * It fetches all confirmed bookings for a specific property and formats them
 * according to the RFC 5545 iCalendar specification.
 * 
 * The property is identified by a unique code passed via the 'ical' GET parameter.
 * Access URL format: https://yoursite.com/page-template-slug/?ical=UNIQUE_CODE
 * 
 * References:
 * - RFC 5545: https://tools.ietf.org/html/rfc5545
 * - iCalendar format: https://en.wikipedia.org/wiki/ICalendar
 */

// Start output buffering at the beginning to prevent any unexpected output
// that would break the ability to set HTTP headers later
ob_start();

// Verify the required 'ical' parameter exists in the URL
if( !isset($_GET['ical'])){
    exit('ouch'); // Exit with minimal error message if missing
}

// Sanitize the input to prevent security issues
$allowed_html   =   array(); // No HTML tags allowed
$unique_ical_id =   sanitize_text_field ( wp_kses($_GET['ical'],$allowed_html)  );

// Get the property ID based on the unique ical identifier
$post_id        =   wpestate_get_id_for_ical($unique_ical_id);

// Build the iCalendar content
// Line breaks in iCalendar MUST be CRLF (\r\n) according to RFC 5545
$ical = "BEGIN:VCALENDAR\r\n";                      // Start the calendar object
$ical .= "PRODID:-//Booking Hosting Calendar t1//EN\r\n"; // Product identifier
$ical .= "VERSION:2.0\r\n";                          // iCalendar version (2.0 is standard)
$ical .= wpestate_ical_get_booking_dates($post_id);  // Add all booking events
$ical .= "END:VCALENDAR\r\n";                        // End the calendar object

// Clear any buffered output before setting headers
// This prevents issues with headers already being sent
ob_end_clean();

// Set proper HTTP headers for iCalendar content
header('Content-type: text/calendar; charset=utf-8');        // Correct MIME type
header('Content-Disposition: inline; filename=calendar.ics'); // Suggest filename
// Prevent caching of dynamic calendar content
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');

// Output the calendar content and exit
print trim($ical);
exit;

/**
 * Find property ID based on the unique iCalendar identifier
 *
 * Searches the database for a property with a matching unique_code_ica meta value
 *
 * @param string $unique_ical_id The unique identifier for the property
 * @return int The WordPress post ID of the matching property
 */
function wpestate_get_id_for_ical($unique_ical_id){
    // Set up WP_Query arguments to find the property
    $args=array(
        'post_type'     => 'estate_property',  // Custom post type for properties
        'post_status'   => 'publish',          // Only published properties
     
        // Search for property with matching unique code in meta
        'meta_query'    => array(
                        array(
                            'key'     => 'unique_code_ica',  // Meta field containing the code
                            'value'   => $unique_ical_id,    // The code to match
                            'compare' => '=',                // Exact match
                        )
                        ),
        );

    // Execute query to find matching property
    $prop_selection  =   new WP_Query($args);

    // Process result - should be exactly one property
    if ($prop_selection->have_posts()){    
        while ($prop_selection->have_posts()): $prop_selection->the_post();
            $pid = get_the_ID(); // Get the property ID
        endwhile;
    }else{
        exit(''); // Exit silently if no matching property found
    }

    // Clean up after query
    wp_reset_query();
    wp_reset_postdata();
    
    return $pid;    
}

/**
 * Generate iCalendar entries for all confirmed bookings of a property
 *
 * Fetches all confirmed bookings for the specified property and formats
 * them as VEVENT components according to iCalendar standard
 *
 * @param int $listing_id The WordPress post ID of the property
 * @return string Formatted iCalendar VEVENT entries for all bookings
 */
function wpestate_ical_get_booking_dates($listing_id){
    $ical_feed='';
    
    // Query arguments to find confirmed bookings for this property
    $args=array(
        'post_type'        => 'wpestate_booking',  // Custom post type for bookings
        'post_status'      => 'any',               // Any post status
        'posts_per_page'   => -1,                  // Get all matching bookings
        'meta_query' => array(
                            array(
                                'key'       => 'booking_id',      // Property ID
                                'value'     => $listing_id,       // Match our property
                                'type'      => 'NUMERIC',         // ID is numeric
                                'compare'   => '='                // Exact match
                            ),
                            array(
                                'key'       =>  'booking_status', // Booking status field
                                'value'     =>  'confirmed',      // Only confirmed bookings
                                'compare'   =>  '='               // Exact match
                            )
                        )
        );
    
    // Execute query to find all confirmed bookings
    $booking_selection  =   new WP_Query($args);

    // Process each booking and add it to the feed
    if ($booking_selection->have_posts()){    
        $ical_feed='';
        while ($booking_selection->have_posts()): $booking_selection->the_post();
            $pid            =   get_the_ID();                                   // Booking ID
            $fromd          =   esc_html(get_post_meta($pid, 'booking_from_date', true)); // Start date
            $tod            =   esc_html(get_post_meta($pid, 'booking_to_date', true));   // End date
            
            // Convert date strings to DateTime objects and timestamps
            $from_date      =   new DateTime($fromd);
            $from_date_unix =   $from_date->getTimestamp();
            $to_date        =   new DateTime($tod);
            $to_date_unix   =   $to_date->getTimestamp();

            // Generate iCal event for this booking and add to feed
            $ical_feed      =   $ical_feed.wpestate_ical_unit($from_date_unix,$to_date_unix,$pid);
            
        endwhile;
         
        wp_reset_query(); // Clean up after query
    }        
  
    return $ical_feed;
}

/**
 * Format timestamp for iCalendar
 *
 * Converts a PHP timestamp to the iCalendar date-time format
 * Format: YYYYMMDDTHHMMSSZ (in UTC)
 *
 * @param int $timestamp Unix timestamp
 * @return string Formatted date-time string
 */
function dateToCal($timestamp) {
  return date('Ymd\THis\Z', $timestamp);
}

/**
 * Escape special characters in iCalendar text
 *
 * In iCalendar, commas and semicolons must be escaped with a backslash
 *
 * @param string $string Text to escape
 * @return string Escaped text
 */
function escapeString($string) {
  return preg_replace('/([\,;])/','\\\$1', $string);
}

/**
 * Create a single iCalendar VEVENT component
 *
 * Formats a booking as an iCalendar event with proper line breaks
 * and required properties
 *
 * @param int $from_date Unix timestamp for booking start
 * @param int $to_date Unix timestamp for booking end
 * @param int $pid Booking ID
 * @return string Formatted VEVENT component
 */
function wpestate_ical_unit($from_date, $to_date, $pid) {
    // Create the event summary/title
    $name = esc_url(home_url('/'))." booking no ".esc_html($pid);
    
    // Build the event with proper line breaks
    $ical_unit = "BEGIN:VEVENT\r\n";                                             // Start event
    $ical_unit .= "DTEND:".dateToCal($to_date)."\r\n";                           // End date/time
    $ical_unit .= "UID:" . md5(uniqid(mt_rand(), true)) . "@". esc_url(home_url('/'))."\r\n"; // Unique ID
    $ical_unit .= "DTSTAMP:" .dateToCal(time())."\r\n";                          // Creation timestamp
    $ical_unit .= "SUMMARY:".escapeString($name)."\r\n";                         // Event title
    $ical_unit .= "DTSTART:".dateToCal($from_date)."\r\n";                       // Start date/time
    $ical_unit .= "END:VEVENT\r\n";                                              // End event
    
    return $ical_unit;
}
?>