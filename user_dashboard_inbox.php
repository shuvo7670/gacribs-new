<?php
// Template Name: User Dashboard Inbox
// Wp Estate Pack
if (!is_user_logged_in()) {
    wp_redirect(esc_url(home_url('/')));
    exit();
}


global $user_login;
$current_user = wp_get_current_user();
$userID                         =   $current_user->ID;
$user_login                     =   $current_user->user_login;
$user_pack                      =   get_the_author_meta('package_id', $userID);
$user_registered                =   get_the_author_meta('user_registered', $userID);
$user_package_activation        =   get_the_author_meta('package_activation', $userID);
$paid_submission_status         =   esc_html(wprentals_get_option('wp_estate_paid_submission', ''));
$price_submission               =   floatval(wprentals_get_option('wp_estate_price_submission', ''));
$submission_curency_status      =   wpestate_curency_submission_pick();
$edit_link                      =   wpestate_get_template_link('user_dashboard_edit_listing.php');
$processor_link                 =   wpestate_get_template_link('processor.php');

get_header();
$wpestate_options = wpestate_page_details($post->ID);
?>

<div class="row is_dashboard">
    <?php
    if (wpestate_check_if_admin_page($post->ID)) {
        if (is_user_logged_in()) {
            include(locate_template('templates/user_menu.php'));
        }
    }
    ?>
    <div class=" dashboard-margin">
        <?php wprentals_dashboard_header_display(); ?>

        <div class="row admin-list-wrapper inbox-wrapper user_dashboard_panel">
           <?php echo do_shortcode('[better_messages]'); ?>
        </div>
    </div>
</div>

<?php

$ajax_nonce = wp_create_nonce("wprentals_inbox_actions_nonce");
print '<input type="hidden" id="wprentals_inbox_actions" value="' . esc_html($ajax_nonce) . '" />    ';

wp_reset_query();
get_footer();
?>

<style>
    .user_dashboard_panel.inbox-wrapper .bp-messages-wrap-main .bp-messages-wrap .chat-header.side-header, 
    .user_dashboard_panel.inbox-wrapper .bp-messages-wrap .thread-not-selected .empty .bpbm-empty-link, 
    .user_dashboard_panel.inbox-wrapper .bp-messages-wrap .thread-not-selected .empty .bpbm-empty-or,
    .user_dashboard_panel.inbox-wrapper .bp-messages-wrap .threads-list .empty .bpbm-empty-link, 
    .user_dashboard_panel.inbox-wrapper .bp-messages-wrap .chat-footer{
        display: none;
    }
</style>