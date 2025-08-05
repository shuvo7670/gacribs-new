<?php
/**
 * Top Bar Template
 * 
 * Displays the top bar with left and right widget areas.
 * Note: Relies on Redux framework options via wprentals_get_option
 *
 * @package WPRentals
 * @subpackage Templates
 */

// Get mobile menu visibility setting from Redux
$mobile_menu_class = 'topbar_show_mobile_'.wprentals_get_option('wp_estate_show_top_bar_mobile_menu','');

// Check if widgets are active before rendering the container
$has_left_widgets = is_active_sidebar('top-bar-left-widget-area');
$has_right_widgets = is_active_sidebar('top-bar-right-widget-area');

if ($has_left_widgets || $has_right_widgets) : ?>
    <div class="top_bar_wrapper <?php echo esc_attr($mobile_menu_class); ?>">
        <div class="top_bar">        
            <?php if ($has_left_widgets) : ?>
                <div class="left-top-widet">
                    <ul class="xoxo">
                        <?php dynamic_sidebar('top-bar-left-widget-area'); ?>
                    </ul>    
                </div>  
            <?php endif; ?>
            
            <?php if ($has_right_widgets) : ?>
                <div class="right-top-widet">
                    <ul class="xoxo">
                        <?php dynamic_sidebar('top-bar-right-widget-area'); ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>    
    </div>
<?php endif; ?>