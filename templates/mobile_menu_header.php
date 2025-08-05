<?php
/**
 * Mobile Header Template
 * 
 * Displays the mobile version of the header including:
 * - Mobile menu trigger
 * - Mobile logo
 * - Mobile user menu trigger
 *
 * @package WPRentals
 * @subpackage Templates
 * @since 4.0
 */

// Get all required options at once for efficiency
$mobile_header_options = array(
    'logo'          => wprentals_get_option('wp_estate_logo_image', 'url'),
    'mobile_logo'   => wprentals_get_option('wp_estate_mobile_logo_image', 'url'),
    'sticky_header' => wprentals_get_option('wp_estate_mobile_sticky_header'),
    'show_user'     => wprentals_get_option('wp_estate_show_top_bar_user_login', '')
);

// Ensure $wpestate_is_top_bar_class is defined
$wpestate_is_top_bar_class = isset($wpestate_is_top_bar_class) ? $wpestate_is_top_bar_class : '';
?>

<div class="mobile_header <?php echo esc_attr($wpestate_is_top_bar_class); ?> mobile_header_sticky_<?php echo esc_attr($mobile_header_options['sticky_header']); ?>">
    <!-- Mobile Menu Trigger -->
    <div class="mobile-trigger"><i class="fas fa-bars"></i></div>
    
    <!-- Mobile Logo -->
    <div class="mobile-logo">
        <a href="<?php echo esc_url(home_url('', 'login')); ?>">
            <?php
            if (!empty($mobile_header_options['mobile_logo'])) {
                echo '<img src="'.esc_url($mobile_header_options['mobile_logo']).'" class="img-responsive retina_ready" alt="'.esc_attr__('logo', 'wprentals').'"/>';
            } else {
                echo '<img class="img-responsive retina_ready" src="'.esc_url(get_template_directory_uri().'/img/logo.png').'" alt="'.esc_attr__('logo', 'wprentals').'"/>';
            }
            ?>
        </a>
    </div>
    
    <?php
    // Show user menu trigger if enabled
    if ($mobile_header_options['show_user'] === "yes") {
        echo '<div class="mobile-trigger-user"><i class="fas fa-user-circle"></i></div>';
    }
    ?>
</div>