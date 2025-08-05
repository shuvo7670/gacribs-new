<?php

/*
*
* 
* * Add footer buttons, navigations and nounces
*
*
*/

add_action( 'wp_footer', 'wprentals_footer_includes',10 );
if(!function_exists('wprentals_footer_includes')):
    function wprentals_footer_includes(){
    
        include(locate_template('templates/footer_buttons.php'));
        if(is_singular('estate_property')){
            include(locate_template('templates/book_per_hour_form.php'));
        }
        
        wp_get_schedules();
        include(locate_template('templates/social_share.php'));
        
        
        
        if(is_singular('estate_property') ){
            ?>
            <!-- Modal -->
            <div class="modal fade" id="instant_booking_modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
               <div class="modal-dialog">
                   <div class="modal-content">
                       <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                           <h2 class="modal-title_big" ><?php esc_html_e( 'Confirm your booking','wprentals');?></h2>
                           <h4 class="modal-title" id="myModalLabel"><?php esc_html_e( 'Review the dates and confirm your booking','wprentals');?></h4>
                       </div>

                       <div class="modal-body"></div>

                       </div><!-- /.modal-content -->
                   </div><!-- /.modal-dialog -->
               </div><!-- /.modal -->
           </div>
        <?php
        }
        
           
           
        // trigger change in calendar if check in and checkout             
        if ( isset($_GET['check_in_prop']) && isset($_GET['check_out_prop'])   ){
            print '<script type="text/javascript">
                    //<![CDATA[
                    jQuery(document).ready(function(){
                      setTimeout(function(){
                          jQuery("#end_date").trigger("change");
                      },1000);
                    });
                    //]]>
            </script>';
        }
        
        
    }
endif;




/**
 * Header Wrapper Function
 * 
 * Renders the main header section of the WPRentals theme including:
 * - Master header container
 * - Top bar (conditional)
 * - Mobile menu header
 * - Logo
 * - User menu (conditional)
 * - Main navigation
 *
 * @package WPRentals
 * @subpackage Header
 * @since 4.0
 * 
 * @param string $transparent_class    - Class for transparent header styling
 * @param string $wide_class          - Class for wide header layout
 * @param string $header_map_class    - Class for header map styling
 * @param string $header_wide         - Header width type class
 * @param string $top_menu_hover_type - Menu hover effect class
 * @param string $wpestate_is_top_bar_class - Top bar visibility class
 * @param string $wpestate_header_type - Header type class
 * @param string $header_align        - Header alignment class
 */

if(!function_exists('wprentals_show_header_wrapper')):
    function wprentals_show_header_wrapper($transparent_class, $wide_class, $header_map_class, $header_wide, $top_menu_hover_type, $wpestate_is_top_bar_class, $wpestate_header_type, $header_align) {
        global $post;
        
        // Get all required theme options at once to reduce DB queries
        $header_options = array(
            'splash_logo_link' => wprentals_get_option('wp_estate_splash_page_logo_link', ''),
            'transparent_logo' => wprentals_get_option('wp_estate_transparent_logo_image', 'url'),
            'regular_logo'     => wprentals_get_option('wp_estate_logo_image', 'url'),
            'show_user_menu'   => wprentals_get_option('wp_estate_show_top_bar_user_login', '')
        );

        // Build master header class string
        $master_header_class = 'master_'.trim($transparent_class).' '.
            esc_attr($wide_class).' '.
            esc_attr($header_map_class).' master_'.
            esc_attr($header_wide).' hover_type_'.
            esc_attr($top_menu_hover_type);

        // Build header wrapper class string
        $header_wrapper_class = esc_attr($transparent_class).' '.
            esc_attr($wpestate_is_top_bar_class).' '.
            esc_attr($wpestate_header_type).' '.
            esc_attr($header_align).' '.
            esc_attr($header_wide);

        // Get page template for conditional rendering
        $page_template = isset($post->ID) ? get_post_meta($post->ID, '_wp_page_template', true) : '';
        
        // Determine logo URL based on page type
        $logo_url = '';
        if ($page_template == 'splash_page.php' && !empty($header_options['splash_logo_link'])) {
            $logo_url = $header_options['splash_logo_link'];
        } else {
            $logo_url = home_url('', 'login');
        }

        // Select appropriate logo based on header transparency
        $logo = !empty(trim($transparent_class)) ? $header_options['transparent_logo'] : $header_options['regular_logo'];
        if (empty($logo)) {
            $logo = get_template_directory_uri() . '/img/logo.png';
        }
        ?>
        
        <!-- Master Header Container -->
        <div class="master_header <?php echo $master_header_class; ?>">
            <?php
            // Include top bar if conditions are met
            if (wpestate_show_top_bar() && $page_template != 'splash_page.php') {
                include(locate_template('templates/top_bar.php'));
            }
            
            // Include mobile menu header - always shown
            include(locate_template('templates/mobile_menu_header.php'));
            ?>
            
            <!-- Main Header Wrapper -->
            <div class="header_wrapper <?php echo $header_wrapper_class; ?>">
                <div class="header_wrapper_inside">
                    
                    <!-- Logo Section -->
                    <div class="logo">
                        <a href="<?php echo esc_url($logo_url); ?>">
                            <img src="<?php echo esc_url($logo); ?>" 
                                 class="img-responsive retina_ready" 
                                 alt="<?php esc_attr_e('logo','wprentals'); ?>"/>
                        </a>
                    </div>
                    
                    <?php
                    // Include user menu if enabled in theme options
                    if ($header_options['show_user_menu'] === "yes") {
                        include(locate_template('templates/top_user_menu.php'));
                    }
                    ?>
                    
                    <!-- Main Navigation -->
                    <nav id="access">
                        <?php 
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'walker'         => new wpestate_custom_walker()
                        ));
                        ?>
                    </nav><!-- #access -->
                </div>
            </div>
        </div>
        <?php
    }
endif;