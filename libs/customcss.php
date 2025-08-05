<?php
global $post;
$float_form_top                             =   esc_html ( wprentals_get_option('wp_estate_float_form_top','') );
$float_search_form                          =   esc_html ( wprentals_get_option('wp_estate_use_float_search_form','') );

if( is_tax() || is_category() || is_archive() ){
    $float_form_top                          =   esc_html ( wprentals_get_option('wp_estate_float_form_top_tax','') );
}

if(isset( $post->ID)){
    $post_id = $post->ID;
}else{
    $post_id = '';
}

if( wpestate_float_search_placement($post_id) ){
    print'
    #search_wrapper {
        bottom:'.$float_form_top.';

    }
    #search_wrapper.search_wr_oldtype {
        height: 71px;
    }
';

}

$main_color                     = esc_html ( wprentals_get_option('wp_estate_main_color','') );
$background_color               = esc_html( wprentals_get_option('wp_estate_background_color', '') );
$content_back_color             = esc_html( wprentals_get_option('wp_estate_content_back_color', '') );
$header_color                   = esc_html( wprentals_get_option('wp_estate_header_color', '') );
$breadcrumbs_font_color         = esc_html(wprentals_get_option('wp_estate_breadcrumbs_font_color', '') );
$font_color                     = esc_html(wprentals_get_option('wp_estate_font_color', '') );
$link_color                     = esc_html(wprentals_get_option('wp_estate_link_color', '') );
$headings_color                 = esc_html(wprentals_get_option('wp_estate_headings_color', '') );
$footer_back_color              = esc_html(wprentals_get_option('wp_estate_footer_back_color', '') );
$footer_font_color              = esc_html(wprentals_get_option('wp_estate_footer_font_color', '') );
$footer_copy_color              = esc_html(wprentals_get_option('wp_estate_footer_copy_color', '') );
$footer_copy_back_color         = esc_html(wprentals_get_option('wp_estate_footer_copy_back_color', '') );
$sidebar_widget_color           = esc_html(wprentals_get_option('wp_estate_sidebar_widget_color', '') );
$sidebar_heading_color          = esc_html ( wprentals_get_option('wp_estate_sidebar_heading_color','') );
$sidebar_heading_boxed_color    = esc_html ( wprentals_get_option('wp_estate_sidebar_heading_boxed_color','') );
$sidebar2_font_color            = esc_html(wprentals_get_option('wp_estate_sidebar2_font_color', '') );
$menu_font_color                = esc_html(wprentals_get_option('wp_estate_menu_font_color', '') );
$menu_hover_back_color          = esc_html(wprentals_get_option('wp_estate_menu_hover_back_color', '') );
$menu_hover_font_color          = esc_html (wprentals_get_option('wp_estate_menu_hover_font_color', '') );
$agent_color                    = esc_html (wprentals_get_option('wp_estate_agent_color','') );
$top_bar_back                   = esc_html ( wprentals_get_option('wp_estate_top_bar_back','') );
$top_bar_font                   = esc_html ( wprentals_get_option('wp_estate_top_bar_font','') );
$adv_search_back_color          = esc_html ( wprentals_get_option('wp_estate_adv_search_back_color','') );
$adv_search_font_color          = esc_html ( wprentals_get_option('wp_estate_adv_search_font_color','') );
$box_content_back_color         = esc_html ( wprentals_get_option('wp_estate_box_content_back_color','') );
$box_content_border_color       = esc_html ( wprentals_get_option('wp_estate_box_content_border_color','') );
$hover_button_color             = esc_html ( wprentals_get_option('wp_estate_hover_button_color','') );
$widget_title_footer_font_color = esc_html ( wprentals_get_option('wp_estate_widget_title_footer_font_color','') );


$wp_estate_calendar_back_color = esc_html ( wprentals_get_option('wp_estate_calendar_back_color','') );
$wp_estate_calendar_font_color = esc_html ( wprentals_get_option('wp_estate_calendar_font_color','') );
$wp_estate_calendar_internal_color = esc_html ( wprentals_get_option('wp_estate_calendar_internal_color','') );






$wp_estate_logo_max_height                            =   esc_html ( wprentals_get_option('wp_estate_logo_max_height','') );
if($wp_estate_logo_max_height!=''){
    print '.logo img, .mobile-logo img{
        max-height: '.$wp_estate_logo_max_height.'px;
    }';

}

$wp_estate_logo_max_width                            =   esc_html ( wprentals_get_option('wp_estate_logo_max_width','') );
if($wp_estate_logo_max_width!=''){
    print '.logo img{
        max-width: '.$wp_estate_logo_max_width.'px;
    }';

}




/// Custom Colorsx
//////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($main_color != '') {
print'


.listing_detail svg image, 
.listing_detail svg path,
.wpestate_elementor_tabs li:hover svg path,
.listing_detail  svg,
.property_features_svg_icon{
  fill: '.$main_color.';
}

.similar_listings_wrapper{
    background:transparent;
}

.listing_type_3 .listing_main_image_price, .listing_type_1 .listing_main_image_price,
.owner_area_wrapper_sidebar,
.listing_type_1 .listing_main_image_price,
.owner-page-wrapper{
    background-image:none;
}


form.woocommerce-checkout,
.woocommerce-error, .woocommerce-info, .woocommerce-message{
    border-top-color:  ' . $main_color . ';
}

#form_submit_1,
#booking_form_mobile_close,
.vc_button.wpb_btn-info,
.contact_owner_reservation,
.full_invoice_reminder,
.search_dashborad_header .wpb_btn-info.wpb_btn-small.wpestate_vc_button.vc_button,
.search_dashborad_header .wpestate_vc_button,
#submit_mess_front,
.modal-content #wp-forgot-but_mod,
#imagelist .uploaded_images i,
#aaiu-uploader,
#send_sms_pin,
#validate_phone,
.user_dashboard_panel_guide .active:after,
.user_dashboard_panel_guide .guide_past:before,
.user_dashboard_panel_guide .guide_past:after,
.mess_send_reply_button,
#change_pass,
#update_profile,
#book_dates,
#edit_prop_ammenities,
#edit_calendar,
#edit_prop_locations,
#google_capture,
#edit_prop_details,
#edit_prop_image,
#edit_prop_price,
#edit_prop_1,
#set_price_dates,
#agent_submit_contact,
.listing_type_3 .listing_main_image_price, .listing_type_1 .listing_main_image_price,
.property_unit_v3 .price_unit,
.property_unit_v2 .icon-fav.icon-fav-on:after,
.status_verified,
.property_status,
.user_mobile_menu_list li:hover, .mobilex-menu li:hover,
.double-bounce1, .double-bounce2,
.unread_mess_wrap_menu,
#view_profile,
.wprentals_status_pending .wprentals_status_circle,
.listing-hover,
.menu_label,
.wpestream_cart_counter_header_mobile,
.wpestate_bell_note_unread,
.wpestate-price-component-popoup-done, 
.wpestate-price-component-popoup-reset, 
.wpestate-beds-baths-popoup-done, 
.wpestate-beds-baths-popoup-reset,
    .wp_estate_baths_component_item:hover, 
.wp_estate_beds_component_item:hover, 
.wp_estate_component_item_selected{
    background-color: ' . $main_color . ';
}

.widget-container .wp-block-search__button,
.advanced_search_submit_button,
.check_avalability,
.return_woo_button,
.wpestate_header_view_checkout,
.wpestate_header_view_cart,
#submit_booking_front_instant,
#submit_booking_front,
#submit_booking_front_link,
#advanced_submit_widget,
#advanced_submit_2_mobile,
#advanced_submit_2,
#advanced_submit_3,
#submit_action {
    background: linear-gradient(90deg, ' . $main_color . ' 50%, ' . $main_color . ' 100%);
}

.woocommerce #respond input#submit,
.woocommerce a.button,
.woocommerce button.button,
.woocommerce input.button,
.woocommerce #respond input#submit.alt,
.woocommerce a.button.alt,
.woocommerce button.button.alt,
.woocommerce input.button.alt,
.wpestream_cart_counter_header,
.user_loged .wpestream_cart_counter_header,
.img_listings_overlay:hover,
.panel-title-arrow,
.owner_area_wrapper_sidebar,
.listing_type_1 .listing_main_image_price,
.property_listing .tooltip-inner,
.pack-info .tooltip-inner,
.pack-unit .tooltip-inner,
.adv-2-header,
.check_avalability:hover,
.owner-page-wrapper,
.featured_div,
.wpestate_tour .ui-tabs .ui-tabs-nav li.ui-tabs-active,
.ll-skin-melon td .ui-state-active,
.ll-skin-melon td .ui-state-hover,
.price-day,
#slider_price_mobile .ui-widget-header,
#slider_price_sh .ui-widget-header,
#slider_price .ui-widget-header,
#slider_price_widget .ui-widget-header,
.slider_control_left,
.slider_control_right,
.wpestate_accordion_tab .ui-state-active,
.wpestate_accordion_tab .ui-state-active ,
.wpestate_accordion_tab .ui-state-active,
.wpestate_tabs .ui-tabs .ui-tabs-nav li.ui-tabs-active,
.wpestate_progress_bar.vc_progress_bar .vc_single_bar.bar_blue .vc_bar,
.wpestate_posts_grid.wpb_teaser_grid .categories_filter li,
.wpestate_posts_grid.wpb_categories_filter li,
.featured_second_line,
.presenttw,
#colophon .social_sidebar_internal a:hover,
#primary .social_sidebar_internal a:hover ,
.comment-form #submit,
.property_menu_item i:hover,
.ball-pulse > div ,
.icon-fav-on-remove,
.share_unit,
#adv-search-header-mobile,
.red,
.pack-info .tooltip-inner,
.pack-unit .tooltip-inner,
.user_mobile_menu_list li:hover,
#wpestate_slider_radius .ui-widget-header,
.ui-widget-content .ui-state-hover,
.ui-widget-header .ui-state-hover,
.ui-state-focus,
.ui-widget-content .ui-state-focus,
.ui-widget-header .ui-state-focus,
#wp-submit-register,
#wp-forgot-but,
#wp-login-but,
.comment-form #submit,
#wp-forgot-but_shortcode,
#wp-login-but-wd,
#wp-submit-register_wd,
#advanced_submit_shorcode,
.action1_booking,
.generate_invoice,
#add_inv_expenses,
#add_inv_discount,
#wp-submit-register_wd_mobile,
#wp-forgot-but_mobile,
#wp-login-but-wd-mobile,
#book_dates,
#allinone_set_custom,
#submit_mess_front,
.modal-content #wp-login-but,
#wp-login-but_sh,
#wp-submit-register_sh,
#user-id-uploader,
#per_hour_ok,
.openstreet_price_marker_on_click_parent .wpestate_marker,
.wpestate_marker.openstreet_price_marker_on_click,
.hover_z_pin{
    background-color: ' . $main_color . '!important;
}

.openstreet_price_marker_on_click_parent .wpestate_marker:before, 
.wpestate_marker.openstreet_price_marker_on_click:before,
.hover_z_pin:before{
    border-top: 6px solid ' . $main_color . '!important;
}

.showcoupon,
.search_wr_type3 .col-md-6.property_price label,
.pack-name,.user_dashboard_links a:hover i,
.property_ratings_agent i,
.prop_pricex,
.wpestate_recent_tweets .item:after,
.panel-title:hover,
.blog_featured.type_1_class:hover .blog-title-link, .places_wrapper.type_1_class:hover .featured_listing_title, .featured_property .property_listing:hover .featured_listing_title,
.signuplink:hover,.category_details_wrapper a:hover ,
.agent-flex:hover .agent-title-link,
.property_flex:hover .listing_title_unit,
#amount_wd,
#amount,
#amount_sh,
.more_list:hover,
.single-content p a:hover,
#contact_me_long_owner:hover, #contact_me_long:hover,
#view_more_desc,
input[type="checkbox"]:checked:before,
.user_dashboard_panel_guide .active,
.hover_type_4 .signuplink:hover,
.hover_type_3 .signuplink:hover,
#amount_mobile,
#colophon .subfooter_menu a:hover,
 .wpestate_properties_slider_v1_title a:hover,
.featured_property.type_1_class .property_listing:hover .featured_listing_title,
.featured_property.featured_agent_type2:hover .featured_listing_title{
    color: ' . $main_color . '!important;
}

#submit_action:hover,
.property_ratings_agent .owner_total_reviews,
.property_ratings_agent i,.property_menu_item_title,
.owner_contact_details .property_menu_item,
.owner_contact_details .property_menu_item a,
.featured_property .property_listing:hover .featured_listing_title{
    color: #fff!important;
}

.wprentals_status_pending,
.user_dashboard_links a:hover,
.user_dashboard_links .user_tab_active,
.property_unit_v1 .price_unit,
.mobile-trigger-user:hover i, .mobile-trigger:hover i,
.carousel-control-theme-prev:hover, .carousel-control-theme-next:hover,
.hover_price,
#user_terms_register_topbar_link:hover,
#amount_mobile,
#amount_sh,
#amount_wd,
#amount,
.front_plan_row:hover,
.delete_search:hover,
.wpestate_posts_grid .vc_read_more,
.featured_article:hover h2 a,
.featured_article:hover .featured_article_right,
.user_dashboard_listed a,
.pack-listing-title,
.user_dashboard_links .user_tab_active i,
.idx-price,
#infobox_title:hover,
.info_details a:hover,
.contact_info_details h2,
#colophon .widget-container li:hover:before,
#colophon .widget-container li:hover,
#colophon .widget-container li:hover a,
.compare_item_head .property_price,
.adv_extended_options_text:hover,
#adv_extended_options_show_filters,
.show_filters,
.adv_extended_options_text,
#showinpage,
#contactinfobox,
.company_headline a:hover i,
#primary .contact_sidebar_wrap p:hover a,
#colophon .contact_sidebar_wrap p:hover a,
.twitter_wrapper a,
.twitter_time,
.wpestate_recent_tweets .item:after,
.widget_nav_menu .sub-menu li:hover a,
.widget_nav_menu  .sub-menu li:hover,
.top_bar .social_sidebar_internal a:hover,
.agent_unit_social_single a:hover,
.price_area,
i.checkon,
.listing_main_image_price ,
.meta-info a:hover,
.blog_unit_back:hover .blog-title-link,
#colophon .category_name a:hover,
.share_unit a:hover,
.share_list,
.listing_unit_price_wrapper,
.property_listing:hover .listing_title_unit,
.icon_selected,
#grid_view:hover,
#list_view:hover,
#user_menu_open  > a:hover i,
#user_menu_open  > a:focus i,
.menu_user_tools,
.user_menu,
.breadcrumb a:hover,
.breadcrumb .active,
.slider-content .read_more,
.slider-title h2 a:hover,
 a:hover, a:focus,
 .custom_icon_class_icon,
 .property_unit_v3 .property-rating,
 .no_link_details i,
 #infoguest.custom_infobox_icon i,
 #inforoom.custom_infobox_icon i,
 .guest_no_drop:after,
 #start_hour_no_wrapper:after,
 #end_hour_no_wrapper:after,
 .guest_icon .wpestate_guest_no_control_wraper:after,
 .blog_featured.type_1_class .blog-title .featued_article_categories_list a:hover,
 .listing_detail svg image, 
 .listing_detail svg path,
 i.checkon,
 .no_link_details i,
 .icon-fav-on,
 .filter_menu li:hover,
 .listing_type_5 .listing_main_image_price,
 .property_unit_v4 .price_unit,
 .bootstrap-select.show-tick .dropdown-menu .selected .glyphicon-ok:before,
 .signuplink:hover,
.signuplink:hover:before,
#topbarregister:before,
#topbarlogin:before,
.rooms_icon:after,
.map_icon:after,
.calendar_icon:after,
#guest_no_drop:after,
#guest_no_shortcode:after,
#guest_no_mobile:after,
#booking_guest_no_wrapper:after,
#guest_no_widget:after,
#guest_no:after,
.types_icon:after,
.actions_icon:after,
.bedrooms_icon:after,
.baths_icon:after,
i.fas.fa-chevron-up,
.wpestate-price-component-popoup-done:hover, 
.wpestate-price-component-popoup-reset:hover, 
.wpestate-beds-baths-popoup-done:hover, 
.wpestate-beds-baths-popoup-reset:hover{
    color: ' . $main_color . ';
}

.fc-v-event,
.check_avalability{
    border: 1px solid '. $main_color .'!important;
}

.wp_estate_baths_component_item:hover, 
.wp_estate_beds_component_item:hover, 
.wp_estate_component_item_selected,
.wpestate-price-component-popoup-done:hover, 
.wpestate-price-component-popoup-reset:hover, 
.wpestate-beds-baths-popoup-done:hover, 
.wpestate-beds-baths-popoup-reset:hover,
.wpestate-price-component-popoup-done, 
.wpestate-price-component-popoup-reset, 
.wpestate-beds-baths-popoup-done, 
.wpestate-beds-baths-popoup-reset,
.property_flex:hover .blog_unit_back,
.property_flex:hover .property_listing,
.listing_type_1 .check_avalability,
.menu_user_picture,
.scrollon,
#submit_action{
    border-color: '. $main_color .' ;
}

.share_unit:after{
    border-top: 8px solid  '. $main_color .';
}

.agentpict{
    border-bottom: 3px solid '. $main_color .';
}

#adv_extended_options_show_filters,
.show_filters,
.testimonial-image{
    border: 2px solid '. $main_color .';
}

.user_dashboard_links a:hover i,
.user_dashboard_links a:hover,
.edit_class, .user_dashboard_links .user_tab_active{
    border-left-color: '. $main_color .';
}

.user_dashboard_panel .form-control:focus{
    border-left:3px solid '. $main_color .';
}

blockquote{
    border-left:5px solid '. $main_color .';
}

.wpestate_tabs .ui-widget-header {
   border-bottom: 2px solid '. $main_color .';
}



.property_unit_v1 .property_unit_action .icon-fav-on svg {
    fill: '.$main_color.'; 
    opacity:0.9;
}';

}


if ($background_color != '') {
print'
    .wide,#google_map_prop_list_sidebar,
    .content_wrapper,
    .main_wrapper,
    .container.wide{
        background-color: ' . $background_color . ';
    } 
    
    .listing_type_5 .imagebody_new .image_gallery {
        border-bottom: 10px solid' . $background_color . ';
        border-right: 10px solid' . $background_color . ';
    }

';
} // end $background_color



if ($header_color != '') {
print' .master_header,.customnav
      {background-color: ' . $header_color . ' }




    ';
} // end $header_color


if ($breadcrumbs_font_color != '') {
print '
.review-date,
.category_icon_wrapper a,
.category_text,
.breadcrumb a,
.top_bar,
.top_bar a,
.listing-details,
.property_location .inforoom,
.property_location .infoguest,
.property_location .infosize,
.meta-element-head,
.meta-info,
.meta-info a,
.navigational_links a,
.agent_meta,
.agent_meta a,
.agent_pos,
.comment_date,
#adv_extended_close_adv,
#adv_extended_close_mobile,
#inforoom,
#infoguest,
#infosize,
.featured_article_secondline,
.featured_article_right{
    color: ' . $breadcrumbs_font_color . ';
}

#street-view{
    background-color: ' . $breadcrumbs_font_color . ';
}

';
} // end $breadcrumbs_font_color


if ($font_color != '') {
print'
    body,
    a,
    label,
    input[type=text],
    input[type=password],
    input[type=email],
    input[type=url],
    input[type=number],
    textarea,
    .slider-content,
    .listing-details,
    #user_menu_open i,
    #grid_view,
    #list_view,
    .listing_details a,
    .notice_area,
    .social-agent-page a,
    .prop_detailsx,
    #reg_passmail_topbar,
    #reg_passmail,
    .testimonial-text,
    .wpestate_tabs .ui-widget-content,
    .wpestate_tour  .ui-widget-content,
    .wpestate_accordion_tab .ui-widget-content,
    .wpestate_accordion_tab .ui-state-default,
    .wpestate_accordion_tab .ui-widget-content .ui-state-default,
    .wpestate_accordion_tab .ui-widget-header .ui-state-default,
    .filter_menu,
    blockquote p ,
    .panel-body p,
    .owner_details_content p,
    .item_head,
    .listing_detail,
    .blog-unit-content,
    table tbody tr td,
    .social_icons_owner i,
    .social_icons_owner i:hover,
    .category_tagline, .category_tagline a,
    .wide_property .category_tagline.map_icon:after, 
    .property_unit_v1 .category_tagline.map_icon:after, 
    .property_unit_v2 .category_tagline.map_icon:after,
    .property_unit_v3 .category_tagline.actions_icon:after, 
    .wide_property .category_tagline.actions_icon:after, 
    .property_unit_v1 .category_tagline.actions_icon:after, 
    .property_unit_v2 .category_tagline.actions_icon:after,
    #user_menu_open a,
    .wpestate_guest_no_buttons_description_labels,
    #inforoom,
    #infoguest,
    .price_custom_explained, .date_duration, .date_interval,
    .total_inv_span,
    .invoice_content,
    #total_amm,
    .inv_legend,
    .user_dashboard_listed,
    .pay_notice_booking,
    .dropdown.bootstrap-select>.dropdown-toggle.bs-placeholder, 
    .dropdown.bootstrap-select>.dropdown-toggle.bs-placeholder:active, 
    .dropdown.bootstrap-select>.dropdown-toggle.bs-placeholder:focus, 
    .dropdown.bootstrap-select>.dropdown-toggle.bs-placeholder:hover {
        color: '.$font_color.';
    }
    
    .property_menu_item_title,
    .owner_contact_details .property_menu_item,
    .owner_contact_details .property_menu_item a{
        color: #FFF!important;
    }
    
    .caret, 
    .caret_sidebar, 
    .advanced_search_shortcode .caret_filter { 
        border-bottom: 6px solid '. $font_color.';
    }
';

} // end $font_color a0a5a8


$main_grid_content_width                    =   esc_html ( wprentals_get_option('wp_estate_main_grid_content_width','') );
$main_content_width                         =   esc_html ( wprentals_get_option('wp_estate_main_content_width','') );
  
if ($main_grid_content_width!='' && $main_grid_content_width!='1200'){

    print'

    @media (min-width: 992px){
        .entry-prop,
        .property_categs,
        .header_wrapper_inside,
        .top_bar,
        .wpestate_property_disclaimer,
        #footer-widget-area,
        .content-fixed-listing,
        .listing_main_image_location,
        .listing_main_image_price {
            width: '.intval($main_grid_content_width).'px;
        }

        .wpestate_property_disclaimer,
        .sub_footer_content,
        #footer-widget-area{
            max-width: '.intval($main_grid_content_width).'px;
        }

        .owner-page-wrapper-inside,
        #estate-carousel_slick .slider-content-wrapper,
        .similar_listings,
        .carousel_type2_control_wrapper,
        .wide .theme_slider_type2 .slider-content-wrapper,
        .sub_footer_content,
        #gmap-controls-wrapper,
        .content_wrapper,
        #search_wrapper,
        .property_menu_wrapper_hidden .property_menu_wrapper_insider {
            width: '.intval($main_grid_content_width-30).'px;
        }

        .listing_main_image_price{
            margin-left:-'.intval($main_grid_content_width/2).'px;
        }

        #estate-carousel_slick .slider-content-wrapper,
        .entry-prop,
        .listing_main_image_location,
        .carousel_type2_control_wrapper,
        .wide .theme_slider_type2 .slider-content-wrapper,
        #gmap-controls-wrapper{
            margin-left:-'.intval(($main_grid_content_width/2) - 20).'px;
        }

        #footer-widget-area.wide_footer, .sub_footer_content.wide_footer{
            width: 100%;
    }
}

        @media only screen and (max-width: '.$main_grid_content_width.'px) and (min-width: 992px){
            

            #estate-carousel_slick .slider-content-wrapper,
            .similar_listings,
            .sub_footer_content{
                width: calc(100% - 40px);
                max-width: calc(100% - 40px);
            }

            .wpestate_property_disclaimer,
            #footer-widget-area,
            .entry-prop,
            .property_categs,
            .header_wrapper_inside,
            .top_bar,
            .wpestate_property_disclaimer,
            #footer-widget-area,
            .content-fixed-listing,
            .listing_main_image_location,
            .carousel_type2_control_wrapper,
            .wide .theme_slider_type2 .slider-content-wrapper,
            #gmap-controls-wrapper,
            .content_wrapper,
            .property_menu_wrapper_hidden .property_menu_wrapper_insider {
                width: calc(100% - 20px);
                max-width: calc(100% - 20px);
            }

            .owner-page-wrapper-inside,
            #search_wrapper{
                width: calc(100% - 60px);
                max-width: calc(100% - 60px);
            }

            .property_header_wrapper.col-md-8 {
                width: fit-content;
            }

            .wide .content_wrapper {
                margin: 0px;
                padding:0px 20px;
            }

            #estate-carousel_slick .slider-content-wrapper,
            .entry-prop,
            .listing_main_image_price,
            .listing_main_image_location,
            .carousel_type2_control_wrapper,
            .wide .theme_slider_type2 .slider-content-wrapper,
            #gmap-controls-wrapper{
                margin-left: calc(-50%);
            }

            .theme_slider_type1 .theme-slider-price .price-slider,
            #estate-carousel_slick .slider-content{
                padding-left: 90px;
            }

            .theme_slider_type2 .carousel-control-theme-prev, 
            .theme_slider_type2 .carousel-control-theme-next,
            .theme_slider_type2 .slider-content{
                padding-left: 30px;
            }

        }
       

    ';

}

if($main_content_width!=''){
    print '
    @media (min-width: 992px){
    .property_header_wrapper.col-md-8,
    .content-fixed-listing  > .col-md-8,
    .owner-page-wrapper-inside > .col-md-8{
        width:'.intval($main_content_width).'%;
    }

    .booking_form_request.is_shortcode1,
    .listing_type_3 .booking_form_request,
    .listing_type_2 .booking_form_request{
        width: 100%;
    }

    .booking_form_request,
    .listing_type_1 .booking_form_request{
        max-width:100%;
    }

    .booking_form_request,
    #primary{
        width:'.intval(100-$main_content_width).'%;
    }
}
';
    
}

$elements_border_radius                         =   esc_html ( wprentals_get_option('wp_estate_elements_border_radius','') );
 
if(!empty($elements_border_radius)){
    print'
    .property_listing,
    .blog-unit-2,
    #colophon .listing-unit-img-wrapper img,
    #colophon .listing-unit-img-wrapper .carousel-inner,
    .listing-unit-img-wrapper,
    .listing_type_1 .booking_form_request, 
    .listing_type_3 .listing_main_image_price, 
    .listing_type_1 .listing_main_image_price,
    .property_page_container,
    .twitter_wrapper, .loginwd_sidebar, .advanced_search_sidebar,
    .panel-wrapper,
    #carousel-listing,
    #colophon .loginwd_sidebar .form-control, 
    #primary .loginwd_sidebar .form-control, 
    .form-control,
    #agent_submit_contact, 
    .advanced_search_submit_button, 
    .return_woo_button, 
    .wpestate_header_view_checkout, 
    .wpestate_header_view_cart, 
    #submit_booking_front_instant, 
    #submit_booking_front, 
    #submit_booking_front_link, 
    #advanced_submit_widget, 
    #advanced_submit_2_mobile, 
    #advanced_submit_2, 
    #advanced_submit_3,
    #add_favorites,
    #contact_host,
    .daterangepicker,
    .wpestate-multiselect-custom-style,
    .property_unit_v4 .property_listing img,
    #book_dates, .more_list, 
    #wp-forgot-but, 
    #wp-login-but, 
    #wp-login-but_sh,
     #wp-submit-register_sh, 
     #wp-submit-register, 
     .comment-form #submit,
     #submit_message_to_client_dashboard, 
     #submit_mess_front,
     .modal-content,
     #search_wrapper_color,
     .show-tick .dropdown-menu, .filter_menu,
     .single-blog,
     .blog_unit_back,
     .post .post-carusel,
     .agent_unit,
     .blog_featured, .places_wrapper,
     .type_1_class .listing-unit-img-wrapper.shortcodefull,
     .wpestate_testimonial_slider .item,
     .wpestate_testimonial_slider,
     #facebooklogin_mb, 
     #facebooklogin_wd_reg, 
     #facebooklogin, 
     #facebooklogin_reg, 
     #facebooklogin_sh, 
     #facebooklogin_sh_reg, 
     #facebooklogin_wd, 
     #facebooklogin_mb,
     #googlelogin_mb, 
     #googlelogin_wd_reg, 
     #googlelogin_reg, 
     #googlelogin_sh_reg, 
     #googlelogin_wd, 
     #googlelogin_sh, 
     #googlelogin_mb, 
     #googlelogin,
     #twitterlogin_mb, 
     #twitterlogin_wd_reg, 
     #twitterlogin_sh_reg, 
     #twitterlogin_reg, 
     #twitterlogin_sh, 
     #twitterlogin_wd, 
     #twitterlogin_mb,
     #twitterlogin,
     .featured_property,
     .featured_agent_type2 .feature_agent_image_unit_wrapper,
     .testimonial-text,
     .iconcol img,
     .contact_info_details,
     .testimonial-container.testimonial_type_2,
     .listing_type_2 .booking_form_request,
     .listing_type_3 .booking_form_request,
     .adv-1-wrapper,
     .adv_handler,
     #advanced_submit_4,
    .wpestate-price-component-popoup-done,
    .wpestate-price-component-popoup-reset,
    .wpestate-beds-baths-popoup-done,
    .wpestate-beds-baths-popoup-reset,
    .imagebody,
    #primary .listing-unit-img-wrapper, 
    #primary .listing-unit-img-wrapper .carousel-inner, 
    #primary .listing-unit-img-wrapper img,
    .vc_button.wpestate_vc_button,
    .ui-widget-content.ui-autocomplete,
    .listing_type_5 .booking_form_request{
        border-radius:'.intval($elements_border_radius).'px;
    }

    .feature_agent_image_unit_wrapper_color{
            background-color: transparent;
    }


    .agent_unit img,
    .modal-header{
        border-top-left-radius:'.intval($elements_border_radius).'px ;
        border-top-right-radius: '.intval($elements_border_radius).'px ;
    }';

}


if ($link_color != '') {

print '
a,
#user_terms_register_wd_label a,
#user_terms_register_wd_label,
#user_terms_register_topbar_link,
.single-content p a,
.blog_featured.type_1_class .blog-title .featued_article_categories_list a,
.agent_detail.contact_detail i,
.listing_type_5 .listing_main_image_location a{
    color: '.$link_color.';
}
.more_list{
 color: '.$link_color.'!important;
}

.single-estate_property .owner_read_more{
    color: #fff!important;
    opacity: 0.7;
}
.owner_read_more:hover,
.property_menu_item a:hover{
        color: #fff!important;
        opacity:1;
    }
';

} // end $link_color

if ($headings_color != '') {
print 'h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a ,
 .featured_property h2 a,
 .featured_property h2,
 .blog_unit h3,
 .blog_unit h3 a,
 .submit_container_header,
 .panel-title,
 #other_listings,
 .entry-title-agent,
 .blog-title-link,
 .agent-title-link,
 .listing_title a,
 .listing_title_book a,
 #primary .listing_title_unit,
 #tab_prpg.wpestate_elementor_tabs li a,
 #listing_reviews, 
 .agent_listings_title_similar, 
 #listing_calendar, 
 #listing_description .panel-title-description,
 table th,
 .blog_featured.type_1_class .blog-title a,
 .testimonial-author,
 .wpestate_guest_no_buttons_title_labels,
 .user_dashboard_panel_title,
 .feature_chapter_name,
 .other_rules label, .cancelation_policy label,
 .listing_title_unit,
 #loginmodal h2.modal-title_big,
 .close_guest_control,
 .modal-body h3,
 .invoice_data_legend,
 .wpestate_dashboard_table_list_header,
 .listing_type_5 .entry-prop,
 .property_unit_v4 .property-rating{
    color: '.$headings_color.';
  }
  
.backtop{
    background-color: '.$headings_color.';
}

.entry-title-agent{
    color:#ffffff;
}

    ';
} // end $headings_color

if ($footer_back_color != '') {
    print '#colophon { 
               background-color: ' . $footer_back_color . '; 
           }';
} // end

if ($footer_font_color != '') {
    print '#colophon, 
           #colophon a, 
           #colophon li a, 
           .widget-title-footer, 
           #colophon .latest_listings .price_unit { 
               color: ' . $footer_font_color . '; 
           }';
}

if ($footer_copy_color != '') {
    print '.sub_footer, 
           .subfooter_menu a, 
           .subfooter_menu li a { 
               color: ' . $footer_copy_color . ' !important; 
           }';
}

if ($footer_copy_back_color != '') {
    print '.sub_footer { 
               background-color: ' . $footer_copy_back_color . '; 
           }';
}

if ($sidebar_widget_color != '') {
    print '.twitter_wrapper, 
           .booking_form_request, 
           .loginwd_sidebar .widget-title-sidebar, 
           .advanced_search_sidebar .widget-title-sidebar, 
           .advanced_search_sidebar, 
           .loginwd_sidebar { 
               background-color: ' . $sidebar_widget_color . '; 
           }';
}


if ($sidebar_heading_color != '') {
    print '.widget-title-sidebar, 
           .agent_listings_title_similar { 
               color: ' . $sidebar_heading_color . ';
           }';
}

if ($sidebar_heading_boxed_color != '') {
    print '.wpestate_recent_tweets h3, 
           .loginwd_sidebar .widget-title-sidebar, 
           .advanced_search_sidebar .widget-title-sidebar { 
               color: ' . $sidebar_heading_boxed_color . ';
           }';
}

if ($sidebar2_font_color != '') {
    print '#primary, 
           #primary a, 
           #primary label { 
               color: ' . $sidebar2_font_color . ';
           }';
}

if ($menu_font_color != '') {
    print '.menu_username, 
           #access .with-megamenu .sub-menu li:hover > a, 
           .signuplink, 
           #access ul.menu > li > a, 
           #access a, 
           #access ul ul a, 
           #access .menu li:hover > a, 
           #access .menu li:hover > a:active, 
           #access .menu li:hover > a:focus {
               color:' . $menu_font_color . ';
           }';
}

if ($menu_hover_font_color != '') {
    print '.transparent_header #access .sub-menu .menu li:hover > a:active,
           .transparent_header #access .sub-menu .menu li:hover > a:focus,
           .filter_menu li:hover,
           #access .sub-menu li:hover > a, 
           #access .sub-menu li:hover > a:active, 
           #access .sub-menu li:hover > a:focus,
           #access ul ul li.wpestate_megamenu_col_1 .megamenu-title:hover a, 
           #access ul ul li.wpestate_megamenu_col_2 .megamenu-title:hover a, 
           #access ul ul li.wpestate_megamenu_col_3 .megamenu-title:hover a, 
           #access ul ul li.wpestate_megamenu_col_4 .megamenu-title:hover a, 
           #access ul ul li.wpestate_megamenu_col_5 .megamenu-title:hover a, 
           #access ul ul li.wpestate_megamenu_col_6 .megamenu-title:hover a,
           #access .with-megamenu .sub-menu li:hover > a, 
           #access .with-megamenu .sub-menu li:hover > a:active, 
           #access .with-megamenu .sub-menu li:hover > a:focus {
               color: ' . $menu_hover_font_color . ' !important;
           }';

    print '#access ul ul li.wpestate_megamenu_col_1 a.menu-item-link, 
           #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link, 
           #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link, 
           #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link, 
           #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link, 
           #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link {
               color: ' . $menu_font_color . ' !important;
           }';
} // end $menu_hover_font_color

if ($top_bar_back != '') {
    print '.top_bar_wrapper { 
               background-color: ' . $top_bar_back . '; 
           }';
}

if ($top_bar_font != '') {
    print '.top_bar, 
           .top_bar a { 
               color: ' . $top_bar_font . '; 
           }';
}

if ($box_content_back_color != '') {
    print '.featured_article_title,
           .testimonial-text,
           .adv1-holder,
           .advanced_search_shortcode,
           .featured_secondline,
           .property_listing,
           .agent_unit,
           .blog_unit_back,
           .dasboard-prop-listing,
           .message_header,
           .invoice_unit { 
               background-color: ' . $box_content_back_color . '; 
           }

           .testimonial-text:after { 
               border-top-color: ' . $box_content_back_color . '; 
           }';
}

if ($box_content_border_color != '') {
    print '
    .featured_article, 
    .loginwd_sidebar, 
    .advanced_search_sidebar, 
    .advanced_search_shortcode,  
    #access ul ul, 
    .testimonial-text, 
    .submit_container,
    .featured_property, 
    .property_listing,
    .agent_unit,
    .blog_unit_back,
    .property_listing,
    .booking_form_request {
        border-color: ' . $box_content_border_color . ';
    }

    .adv1-holder, 
    .notice_area,  
    .listing_filters {
        border-bottom: 1px solid ' . $box_content_border_color . ';
    }

    .testimonial-text:before {
        border-top-color: ' . $box_content_border_color . ';
    }';
}

if ($hover_button_color != '') {
    print '
    .social_icons_owner i,
    .owner-image-container,
    .owner_listing_image {
        border-color: ' . $hover_button_color . ';
    }';

    print '
    .comment-form #submit:hover,
    .vc_button.wpb_btn-info:active,
    .vc_button.wpb_btn-info.active,
    .vc_button.wpb_btn-info.disabled,
    .vc_button.wpb_btn-info[disabled] {
        background-color: ' . $hover_button_color . '!important;
        border: 1px solid ' . $hover_button_color . ';
    }

    #wp-login-but_sh:hover,
    #wp-submit-register_sh:hover,
    #agent_submit_contact:hover,
    .advanced_search_submit_button:hover,
    #submit_action:hover,
    #advanced_submit_3:hover,
    #advanced_submit_4:hover,
    .adv_handler:hover,
    #submit_booking_front_instant:hover,
    #submit_booking_front:hover,
    #submit_booking_front_link:hover,
    #advanced_submit_widget:hover,
    #advanced_submit_2_mobile:hover,
    #advanced_submit_2:hover,
    .check_avalability:hover {
        background: linear-gradient(90deg, ' . $hover_button_color . ' 50%, ' . $hover_button_color . ' 100%);
    }

    #form_submit_1:hover,
    .contact_owner_reservation:hover,
    .full_invoice_reminder:hover,
    #change_pass:hover,
    #update_profile:hover,
    #view_profile:hover,
    .mess_send_reply_button:hover,
    #set_price_dates:hover,
    .search_dashborad_header .wpb_btn-info.wpb_btn-small.wpestate_vc_button.vc_button:hover,
    .search_dashborad_header .wpestate_vc_button:hover,
    .vc_button.wpb_btn-info:hover,
    .slider_control_right:hover, 
    .slider_control_left:hover {
        background-color: ' . $hover_button_color . ';
    }

    #aaiu-uploader:hover,
    #send_sms_pin:hover,
    #validate_phone:hover,
    #edit_prop_image:hover,
    #edit_prop_ammenities:hover,
    #edit_calendar:hover,
    #edit_prop_locations:hover,
    #google_capture:hover,
    #edit_prop_details:hover,
    #edit_prop_image:hover,
    #edit_prop_price:hover,
    #edit_prop_1:hover,
    #wp-submit-register:hover,
    #wp-forgot-but:hover,
    #wp-login-but:hover,
    .comment-form #submit:hover,
    #wp-forgot-but_shortcode:hover,
    #wp-login-but-wd:hover,
    #wp-submit-register_wd:hover,
    #advanced_submit_shorcode:hover,
    #submit_mess_front:hover,
    .modal-content #wp-forgot-but_mod:hover {
        background-color: ' . $hover_button_color . '!important;
    }';
}



$top_menu_hover_font_color      =   esc_html ( wprentals_get_option('wp_estate_top_menu_hover_font_color','') );
    if ($top_menu_hover_font_color  != '') {
    print'  #access ul.menu >li>a:hover,
            #access > ul > li:hover > a,
            #access .menu li:hover>a:focus,
            #access .menu li:hover>a,
            .hover_type_4  #access .menu > li:hover>a,
            .hover_type_3  #access .menu > li:hover>a,
            .signuplink:hover,
            .customnav #access .menu li:hover>a:active,
             #access .menu li:hover>a:active,
            .customnav #access ul.menu >li>a,
            .customnav #access > ul > li:hover > a,
            .customnav #access .menu li:hover>a:focus,
            .customnav #access .menu li:hover>a,
            .customnav .hover_type_4  #access .menu > li:hover>a,
            .customnav .hover_type_3  #access .menu > li:hover>a,
            .customnav .signuplink:hover, 
            .customnav .menu_username:hover,
            .customnav #topbarlogin:hover:before, 
            .customnav #topbarregister:hover:before, 
            .customnav .signuplink:hover:before{
                color: ' . $top_menu_hover_font_color . ';
        }
        
        .hover_type_3 #access .menu li:hover>a{
            color: ' . $top_menu_hover_font_color . '!important;
        }';
    }

$active_menu_font_color      =   esc_html ( wprentals_get_option('wp_estate_active_menu_font_color','') );
if ($active_menu_font_color  != '') {
print'  #access .current-menu-item >a,
        #access .current-menu-parent>a,
        #access .current-menu-ancestor>a,
        #access .current-menu-item{
        color: ' . $active_menu_font_color . '!important;
    }';
}


$transparent_menu_font_color    =   esc_html ( wprentals_get_option('wp_estate_transparent_menu_font_color','') );
    if ($transparent_menu_font_color  != '') {
    print '.transparent_header #access .menu li>a,
        .transparent_header .signuplink, 
        .transparent_header .signuplink:before, 
        .transparent_header #topbarlogin:before, 
        .transparent_header #topbarregister:before,
        .transparent_header .menu_username{
            color: ' . $transparent_menu_font_color . ';
        }';
    }

$transparent_menu_hover_font_color     =  esc_html ( wprentals_get_option('wp_estate_transparent_menu_hover_font_color','') );
    if ($transparent_menu_hover_font_color  != '') {
    print '.transparent_header #access a:hover,
           .transparent_header #access .menu li:hover>a,
           .transparent_header .signuplink:hover, 
           .transparent_header .menu_username:hover,
           .transparent_header #topbarlogin:hover:before, 
           .transparent_header #topbarregister:hover:before, 
           .transparent_header .signuplink:hover:before{
                color: ' . $transparent_menu_hover_font_color . ';
        }';
    }

$sticky_menu_font_color                =  esc_html ( wprentals_get_option('wp_estate_sticky_menu_font_color','') );
    if ($sticky_menu_font_color   != '') {
    print '.customnav #access ul.menu >li>a,
           .customnav .signuplink,
           .customnav .menu_username{
            color: ' . $sticky_menu_font_color  . ';
        }';
    }

    $menu_items_color = esc_html(wprentals_get_option('wp_estate_menu_items_color', ''));
    if ($menu_items_color != '') {
        print '
        #access .menu li ul li a,
        #access ul ul a,
        #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link,
        #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link {
            color: ' . $menu_items_color . '!important;
        }';
    }
    

$menu_hover_font_color          =   esc_html(wprentals_get_option('wp_estate_menu_hover_font_color', '') );
    if ($menu_hover_font_color != '') {
    print '#access ul ul a:hover,
            #access .menu .sub-menu li:hover>a,
            #access .menu .sub-menu li:hover>a:active,
            #access .menu .sub-menu li:hover>a:focus,
            #access .sub-menu .current-menu-item > a,
            #access .with-megamenu .sub-menu .current-menu-item > a{
             color:' . $menu_hover_font_color  . '!important;
        }';
    }

    $wp_estate_top_menu_font_size = wprentals_get_option('wp_estate_top_menu_font_size', '');
    if ($wp_estate_top_menu_font_size != '') {
        print '
        #access ul.menu > li > a,
        .menu_username,
        #topbarregister,
        #submit_action,
        #topbarlogin {
            font-size: ' . $wp_estate_top_menu_font_size . 'px;
        }';
    }
    

    $wp_estate_menu_item_font_size     = wprentals_get_option('wp_estate_menu_item_font_size','');
    if ($wp_estate_menu_item_font_size   != '') {
        print '
            #access ul ul a,
            #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link, 
            #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link, 
            #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link, 
            #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link, 
            #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link, 
            #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link,
            #user_menu_open a{
                 font-size:' . $wp_estate_menu_item_font_size . 'px;
            }';
        }
    $menu_item_back_color         =  esc_html ( wprentals_get_option('wp_estate_menu_item_back_color','') );
    if ($menu_item_back_color != '') {
        print '
        #access ul ul{
            background-color: '.$menu_item_back_color.';
        }
        #access ul ul:after{
            border-bottom: 13px solid '.$menu_item_back_color.';
        }';
        }

     ///
    $top_menu_hover_back_font_color                =  esc_html ( wprentals_get_option('wp_estate_top_menu_hover_back_font_color','') );
    if($top_menu_hover_back_font_color !=''){
        print '
        .hover_type_3 #access .menu > li:hover>a,
        .hover_type_4 #access .menu > li:hover>a {
            background: '.$top_menu_hover_back_font_color.'!important;
        }';
    }

    if($top_menu_hover_back_font_color!=''){
    print '
        .customnav #access ul.menu >li>a:hover,
        #access ul.menu >li>a:hover,
        .hover_type_3 #access .menu > li:hover>a,
        .hover_type_4 #access .menu > li:hover>a,
        .hover_type_6 #access .menu > li:hover>a {
            color: ' . $top_menu_hover_back_font_color . ';
        }
        .hover_type_5 #access .menu > li:hover>a {
            border-bottom: 3px solid ' . $top_menu_hover_back_font_color . ';
        }
        .hover_type_6 #access .menu > li:hover>a {
          border: 2px solid ' . $top_menu_hover_back_font_color . ';
        }
        .hover_type_2 #access .menu > li:hover>a:before {
            border-top: 3px solid ' . $top_menu_hover_back_font_color . ';
        }';

    }

    $transparent_menu_hover_font_color      =  esc_html ( wprentals_get_option('wp_estate_transparent_menu_hover_font_color','') );
    if($transparent_menu_hover_font_color!=''){
    print '
        .header_transparent .customnav #access ul.menu >li>a:hover,
        .header_transparent #access ul.menu >li>a:hover,
        .header_transparent .hover_type_3 #access .menu > li:hover>a,
        .header_transparent .hover_type_4 #access .menu > li:hover>a,
        .header_transparent .hover_type_6 #access .menu > li:hover>a {
            color: ' . $transparent_menu_hover_font_color . ';
        }
        .header_transparent .hover_type_5 #access .menu > li:hover>a {
            border-bottom: 3px solid ' . $transparent_menu_hover_font_color . ';
        }
        .header_transparent .hover_type_6 #access .menu > li:hover>a {
          border: 2px solid ' . $transparent_menu_hover_font_color . ';
        }
        .header_transparent .hover_type_2 #access .menu > li:hover>a:before {
            border-top: 3px solid ' . $transparent_menu_hover_font_color . ';
        }';
}
 $header_height                              =   esc_html ( wprentals_get_option('wp_estate_header_height','') );
    $sticky_header_height                       =   esc_html ( wprentals_get_option('wp_estate_sticky_header_height','') );

    if($header_height!=''){
        print'  .header_wrapper.header_type2 .header_wrapper_inside,
                .header_wrapper .header_type1 .header_wrapper_inside {
                    height:'.($header_height).'px;
            }

            .header_type1 .menu > li{
                height:' . $header_height . 'px;
                line-height:' . ($header_height-46) . 'px;
            }

            .hover_type_3 .header_type1 .menu > li,
            .hover_type_5 .header_type1 .menu > li,
            .hover_type_6 .header_type1 .menu > li{
                height:' . $header_height . 'px;
                line-height:' . ($header_height-46) . 'px;
            }

            .header_type1 #access ul li:hover > ul,
            .header_wrapper.header_type2 #user_menu_open,
            .social_share_wrapper,
            .hover_type_4 #access ul li:hover > ul,
            #access ul li:hover > ul{
                top:' .$header_height. 'px;
            }
            .admin-bar  #google_map_prop_list_sidebar,
            .admin-bar  #google_map_prop_list_wrapper,
            .admin-bar  .social_share_wrapper{
                top:' . ($header_height+32) . 'px;
                    }
            .admin-bar.top_bar_on  #google_map_prop_list_sidebar,
            .admin-bar.top_bar_on  #google_map_prop_list_wrapper{
                top:' . ($header_height+32+40) . 'px;
            }
            .top_bar_on  #google_map_prop_list_sidebar,
            .top_bar_on  #google_map_prop_list_wrapper{
                top:' . ($header_height+40) . 'px;
            }
            #google_map_prop_list_sidebar,
            #google_map_prop_list_wrapper{
                top:' . ($header_height) . 'px;
            }
            .admin-bar #google_map_prop_list_sidebar.half_header_type2,
            .admin-bar #google_map_prop_list_wrapper.half_header_type2{
                top:' . ($header_height+32) . 'px;
            }
            .admin-bar.top_bar_on  #google_map_prop_list_sidebar.half_header_type2,
            .admin-bar.top_bar_on  #google_map_prop_list_wrapper.half_header_type2{
                top:' . ($header_height+32+40) . 'px;
            }
            .top_bar_on  #google_map_prop_list_sidebar.half_header_type2,
            .top_bar_on  #google_map_prop_list_wrapper.half_header_type2{
                top:' . ($header_height+40) . 'px;
            }
            #google_map_prop_list_sidebar.half_header_type2,
            #google_map_prop_list_wrapper.half_header_type2,
            #access ul li:hover > ul,
            #access ul ul{
                top:' . ($header_height) . 'px;
            }



            #access ul li.with-megamenu>ul.sub-menu,
            #access ul li.with-megamenu:hover>ul.sub-menu,
            .header_wrapper.header_type1.header_align_right #user_menu_open,
            .header_wrapper.header_type2.header_align_right #user_menu_open,
            .header_wrapper.header_type1.header_align_center #user_menu_open,
            .header_wrapper.header_type2.header_align_center #user_menu_open,
            .header_wrapper.header_type1.header_align_left #user_menu_open,
            .header_wrapper.header_type2.header_align_left #user_menu_open{
                top:' . ($header_height) . 'px;
            }

            ';
        }

    if($sticky_header_height!=''){
        print'.header_wrapper.customnav,
            .header_wrapper.header_type2.customnav .header_wrapper_inside,
            .header_wrapper.customnav.header_type2 .header_wrapper_inside,
            .header_wrapper.customnav.header_type2 .header_wrapper_inside,
            .header_wrapper.customnav.header_type2,
            .header_wrapper.customnav.header_type1,
            .header_wrapper.customnav.header_type2 .user_loged,
            .header_wrapper.customnav.header_type1 .user_loged{
                height:'.$sticky_header_height.'px;
                }
            .customnav .menu > li,
            .hover_type_3 .customnav .menu > li,
            .hover_type_5 .customnav .menu > li,
            .hover_type_6 .customnav .menu > li,
            .hover_type_6 .header_type1.customnav .menu > li,
            .hover_type_3 .header_type1.customnav .menu > li,
            .hover_type_5 .header_type1.customnav .menu > li,
            .hover_type_4 .header_type1.customnav .menu > li,
            .hover_type_2 .header_type1.customnav .menu > li,
            .hover_type_1 .header_type1.customnav .menu > li,
            .header_type1.customnav .menu > li{
                height:' . $sticky_header_height . 'px;
                line-height:' . ($sticky_header_height-44) . 'px;
            }

            .hover_type_3 .customnav #access .menu > li:hover>a,
            .hover_type_5 .customnav #access .menu > li:hover>a,
            .hover_type_6 .customnav #access .menu > li:hover>a{
                line-height:' . ($sticky_header_height) . 'px;
            }

            .header_type2.customnav #access ul li.with-megamenu:hover>ul.sub-menu,
            .customnav #access ul li:hover > ul,
            .customnav #access ul ul,
            .hover_type_4 .customnav #access ul li:hover > ul,
            .hover_type_1 .customnav #access ul li:hover> ul,
            .hover_type_4 .customnav #access ul li:hover> ul,
            .hover_type_2 .customnav #access ul li:hover> ul,
            .property_menu_wrapper_hidden{
                top:' . ($sticky_header_height) . 'px;
            }

            .header_type2.customnav.header_left.customnav #access ul li:hover> ul,
            .header_type2.customnav.header_center.customnav #access ul li:hover> ul,
            .header_type2.customnav.header_right.customnav #access ul li:hover> ul,
            .customnav #access ul li.with-megamenu:hover>ul.sub-menu,
            .full_width_header .header_type1.header_left.customnav #access ul li.with-megamenu>ul.sub-menu,
            .full_width_header .header_type1.header_left.customnav #access ul li.with-megamenu:hover>ul.sub-menu,
            .header_wrapper.customnav.header_type1.header_align_right #user_menu_open,
            .header_wrapper.customnav.header_type2.header_align_right #user_menu_open,
            .header_wrapper.customnav.header_type1.header_align_center #user_menu_open,
            .header_wrapper.customnav.header_type2.header_align_center #user_menu_open,
            .header_wrapper.customnav.header_type1.header_align_left #user_menu_open,
            .header_wrapper.customnav.header_type2.header_align_left #user_menu_open,
            .customnav #user_menu_open,
            .property_menu_wrapper_hidde{
                top:' . ($sticky_header_height) . 'px;
            }
            .admin-bar .property_menu_wrapper_hidden{
                top:' .( $sticky_header_height+32) . 'px;
            }


            .header_type2 .hover_type_6 .customnav #access ul li:hover > ul,
            .header_type2 .hover_type_5 .customnav #access ul li:hover > ul,
            .header_type2 .hover_type_6 .customnav #access ul ul ul,
            .header_type2 .hover_type_5 .customnav #access ul ul ul{
                top:' . ( $sticky_header_height-21) . 'px;
            }

            .hover_type_3 .customnav #access ul li:hover > ul,
            .hover_type_5 .customnav #access ul li:hover > ul,
            .hover_type_6 .customnav #access ul li:hover > ul{
                top:' . ( $sticky_header_height-1) . 'px;
            }
            ';
        }


        $border_bottom_header                 =   esc_html ( wprentals_get_option('wp_estate_border_bottom_header','') );
        $sticky_border_bottom_header          =   esc_html ( wprentals_get_option('wp_estate_sticky_border_bottom_header','') );
        $border_bottom_header_sticky_color    =  esc_html ( wprentals_get_option('wp_estate_border_bottom_header_sticky_color','') );
        $border_bottom_header_color           =  esc_html ( wprentals_get_option('wp_estate_border_bottom_header_color','') );
        if($border_bottom_header_color!=''){
            print'.master_header{
                border-color:'.$border_bottom_header_color.';
                border-style: solid;
            }';
        }

        if($border_bottom_header!=''){
            print'.master_header{
               border-bottom-width:'.$border_bottom_header.'px;
            }';
        }



/////// Custom css

$adv_back_color              =  esc_html ( wprentals_get_option('wp_estate_adv_back_color','') );

  if($adv_back_color!=''){
            print'#search_wrapper_color,
                .adv-1-wrapper,
                .adv-2-wrapper,
                .adv-5-wrapper{
               background:'.$adv_back_color.';
            }';
        }

$adv_back_color_opacity             =  esc_html ( wprentals_get_option('wp_estate_adv_back_color_opacity','') );
    if($adv_back_color_opacity!=''){
        print'.with_search_form_float #search_wrapper_color,
            .with_search_form_float .adv-1-wrapper,
            .with_search_form_float .adv-2-wrapper,
            .with_search_form_float .adv-5-wrapper{
               opacity:'.$adv_back_color_opacity.';
            }';

        print'.with_search_form_float.sticky_adv #search_wrapper_color,
            .with_search_form_float.sticky_adv .adv-1-wrapper,
            .with_search_form_float.sticky_adv .adv-2-wrapper{
                opacity: 1;
            }'
            ;
    }

$adv_search_back_button          =  esc_html ( wprentals_get_option('wp_estate_adv_search_back_button','') );
    if($adv_search_back_button !=''){
        print'
            .advanced_search_submit_button,
            #advanced_submit_widget,
            #advanced_submit_2_mobile,
            #advanced_submit_2,
            #advanced_submit_3,
            #advanced_submit_shorcode,
            .adv_handler,
            #advanced_submit_4{
               background:'.$adv_search_back_button .'!important;
            }';
    }

$adv_search_back_hover_button          =  esc_html ( wprentals_get_option('wp_estate_adv_search_back_hover_button','') );
    if($adv_search_back_hover_button !=''){
        print'.advanced_search_submit_button:hover,
            #advanced_submit_widget:hover,
            #advanced_submit_2_mobile:hover,
            #advanced_submit_2:hover,
            #advanced_submit_3:hover,
            #advanced_submit_shorcode:hover,
            .adv_handler:hover,
            #advanced_submit_4:hover{
               background-color:'.$adv_search_back_hover_button .'!important;
            }';
    }
    

if(  wprentals_get_option('wp_estate_use_custom_icon_area','')=='yes' ){
    $wp_estate_property_page_icon_area_font_size            =   ( wprentals_get_option('wp_estate_property_page_icon_area_font_size','') );

    if(!empty( $wp_estate_property_page_icon_area_font_size)){
        print '.category_details_wrapper,.category_details_wrapper a, .no_link_details{';
            if(isset($wp_estate_property_page_icon_area_font_size['font-size'])){
                print 'font-size:'.intval($wp_estate_property_page_icon_area_font_size['font-size']).'px!important;';
            }
            if(isset($wp_estate_property_page_icon_area_font_size['color'])){
              print' color :'. $wp_estate_property_page_icon_area_font_size['color'].'!important;';
            }
            if(isset($wp_estate_property_page_icon_area_font_size['font-size'])){
                print 'font-weight:'.$wp_estate_property_page_icon_area_font_size['font-weight'].'!important;';
            }
        print '}';
    }

    $wp_estate_property_page_icon_area_icon_size            =   ( wprentals_get_option('wp_estate_property_page_icon_area_icon_size','') );
    if( intval($wp_estate_property_page_icon_area_icon_size) >0 ){
        print '
        .category_details_wrapper img{
            height:'.intval($wp_estate_property_page_icon_area_icon_size).'px!important;   
        }
        .category_details_wrapper i{
            font-size:'.intval($wp_estate_property_page_icon_area_icon_size).'px;   
        }

        ';
    }

    $wp_estate_property_page_icon_area_color =   ( wprentals_get_option('wp_estate_property_page_icon_area_color','') );

    if($wp_estate_property_page_icon_area_color!=''){
        print '
        .category_details_wrapper i{
            color:'.esc_html($wp_estate_property_page_icon_area_color).';   
        }
        ';
    }
    $wp_estate_property_page_icon_area_alignment =   ( wprentals_get_option('wp_estate_property_page_icon_area_alignment','') );
    $wp_estate_property_page_icon_area_image_position =   ( wprentals_get_option('wp_estate_property_page_icon_area_image_position','') );
    $wp_estate_property_page_icon_area_gap =   ( wprentals_get_option('wp_estate_property_page_icon_area_gap','') );

 
    if(  $wp_estate_property_page_icon_area_alignment!='' ){
        if($wp_estate_property_page_icon_area_alignment=='flex-end'){
            print '.category_wrapper {
                justify-content: '.esc_html($wp_estate_property_page_icon_area_alignment).';
            }'; 
        } else if($wp_estate_property_page_icon_area_alignment=='space-between'){
            print '.category_details_wrapper {
                flex-grow:1;
                justify-content: space-between;
            }'; 
        }
        
        
    

    }

    if(  $wp_estate_property_page_icon_area_image_position!='' ){
        print '.custom_prop_header{
            flex-direction:'.esc_html($wp_estate_property_page_icon_area_image_position).';
        }';
    }


    if(  $wp_estate_property_page_icon_area_gap!='' ){
        print '.category_details_wrapper{
            gap:'.intval($wp_estate_property_page_icon_area_gap).'px;
        }';
    }


}

if($widget_title_footer_font_color!=''){
    print '.widget-title-footer,
    #colophon .listing_title_unit{
    color: '.$widget_title_footer_font_color.';}';

}

// Mobile Header Background Color
$mobile_header_background_color = esc_html(wprentals_get_option('wp_estate_mobile_header_background_color', ''));
if ($mobile_header_background_color != '') {
    print '.mobile_header { 
                background-color: ' . $mobile_header_background_color . ';
            }';
}

// Mobile Header Icon Color
$mobile_header_icon_color = esc_html(wprentals_get_option('wp_estate_mobile_header_icon_color', ''));
if ($mobile_header_icon_color != '') {
    print '.mobilemenu-close-user, 
                .mobilemenu-close, 
                .mobile_header i { 
                    color: ' . $mobile_header_icon_color . ';
                }';
}

// Mobile Menu Font Color
$mobile_menu_font_color = esc_html(wprentals_get_option('wp_estate_mobile_menu_font_color', ''));
if ($mobile_menu_font_color != '') {
    print '
        .mobilex-menu li a, 
        .user_mobile_menu_list li a, 
        #register-div-title-mobile, 
        #forgot-div-title_mobile, 
        #login-div-title-mobile, 
        .mobilex-menu li a, 
        #widget_login_sw_mobile, 
        #forgot_pass_widget_mobile, 
        #widget_register_mobile, 
        #user_terms_register_wd_label_mobile, 
        #user_terms_register_wd_label_mobile a, 
        #reg_passmail_mobile,
        #register-div-mobile .radiolabel { 
            color: ' . $mobile_menu_font_color . ' ;
        }';
}

// Mobile Menu Hover Font Color
$mobile_menu_hover_font_color = esc_html(wprentals_get_option('wp_estate_mobile_menu_hover_font_color', ''));
if ($mobile_menu_hover_font_color != '') {
    print '
        .mobilex-menu li a:hover, 
        .user_mobile_menu_list li a:hover, 
        .mobilex-menu li a:hover { 
            color: ' . $mobile_menu_hover_font_color . ';
        }';
}

// Mobile Item Hover Background Color
$mobile_item_hover_back_color = esc_html(wprentals_get_option('wp_estate_mobile_item_hover_back_color', ''));
if ($mobile_item_hover_back_color != '') {
    print '
        .mobile_user_menu li:hover, 
        .user_mobile_menu_list li:hover, 
        .mobilex-menu li:hover, 
        .wpestream_cart_counter_header_mobile { 
            background-color: ' . $mobile_item_hover_back_color . '; 
        }';
}

// Mobile Menu Background Color
$mobile_menu_backgound_color = esc_html(wprentals_get_option('wp_estate_mobile_menu_backgound_color', ''));
if ($mobile_menu_backgound_color != '') {
    print '
        .mobilex-menu, 
        .snap-drawer, 
        .user_mobile_menu_list { 
            background-color: ' . $mobile_menu_backgound_color . ' ;
        }';
    
    print '
        .snap-drawer { 
            border: 1px solid ' . $mobile_menu_backgound_color . ' ;
        }';
}

// Mobile Menu Border Color
$mobile_menu_border_color = esc_html(wprentals_get_option('wp_estate_mobile_menu_border_color', ''));
if ($mobile_menu_border_color != '') {
    print '.mobilex-menu li { 
                border-bottom-color: ' . $mobile_menu_border_color . ' ;
            }';
}


  if($wp_estate_calendar_back_color!=''){
      print'  
    .calendar-legend-reserved,
    .fc-event,
    .fc-event-dot,
    .ui-datepicker-calendar .calendar-reserved, 
    .user_dashboard_panel .calendar-reserved,
    .daterangepicker td.off.end-date,
    .daterangepicker td.off.start-date,
    .daterangepicker td.active,
    .daterangepicker td.active:hover,
    .wpestate_booking_class.off.disabled.calendar-reserved,
    .calendar-reserved,
    .rentals_reservation{
        background-color:  '.$wp_estate_calendar_back_color.'!important;
    }
    
    .calendar_pad .rentals_reservation:before,
    .calendar_pad.allinone_internal_booking .rentals_reservation:before{
        border-top: 13px solid '.$wp_estate_calendar_back_color.'!important;    
    }

    .daterangepicker td.in-range{
       background-color: '.$wp_estate_calendar_back_color.';
    }

   
    .calendar-reserved.start_reservation.end_reservation.calendar_pad.allinone_external_booking, 
    .calendar-reserved.start_reservation.end_reservation.allinone_internal_booking{
        background: -webkit-gradient(linear,left top,right bottom,color-stop(0%,#ffffff),color-stop(50%,#ffffff),color-stop(51%,'. $wp_estate_calendar_back_color .'),color-stop(100%,'. $wp_estate_calendar_back_color .'));
        background: -webkit-linear-gradient(-45deg,#ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
        background: -o-linear-gradient(-45deg,#ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
        background: -ms-linear-gradient(-45deg,#ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
        background: linear-gradient(125deg,#ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
        background: linear-gradient(125deg,'. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 48%,#FFFFFF 50%,#FFFFFF 53%,'. $wp_estate_calendar_back_color .' 53%,'. $wp_estate_calendar_back_color .' 100%);
    }

    .calendar-free.calendar_pad.has_future.end_reservation.end_allinone_internal_booking {
        background: -moz-linear-gradient(-45deg, '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 49%, #ffffff 50%, #ffffff 100%);
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,'. $wp_estate_calendar_back_color .'), color-stop(49%,'. $wp_estate_calendar_back_color .'), color-stop(50%,#ffffff), color-stop(100%,#ffffff));
        background: -webkit-linear-gradient(-45deg, '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: -o-linear-gradient(-45deg, '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: -ms-linear-gradient(-45deg, '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: linear-gradient(125deg, '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
    }

    .calendar-reserved.start_reservation.allinone_internal_booking {
        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 50%, '. $wp_estate_calendar_back_color .' 51%, '. $wp_estate_calendar_back_color .' 100%);
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(50%,#ffffff), color-stop(51%,'. $wp_estate_calendar_back_color .'), color-stop(100%,'. $wp_estate_calendar_back_color .'));
        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
        background: linear-gradient(125deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%);
    }

    .booking-calendar-wrapper-in .end_reservation,
    .ll-skin-melon .ui-datepicker td.freetobook.end_reservation{
        background: -moz-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 49%, #ffffff 50%, #ffffff 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,'. $wp_estate_calendar_back_color .'), color-stop(49%,'. $wp_estate_calendar_back_color .'), color-stop(50%,#ffffff), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%); /* IE10+ */
        background: linear-gradient(135deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%); /* W3C */
     }

    .all-front-calendars .end_reservation{
       background: -moz-linear-gradient(-45deg,  '.$wp_estate_calendar_back_color.' 0%, '.$wp_estate_calendar_back_color.' 49%, #edf6f6 50%, #edf6f6 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,'. $wp_estate_calendar_back_color .'), color-stop(49%,'. $wp_estate_calendar_back_color .'), color-stop(50%,#edf6f6), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#edf6f6 50%,#edf6f6 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#edf6f6 50%,#edf6f6 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#edf6f6 50%,#edf6f6 100%); /* IE10+ */
        background: linear-gradient(135deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#edf6f6 50%,#edf6f6 100%); /* W3C */
     }


    .ll-skin-melon .ui-datepicker .ui-state-disabled.end_reservation{
        background: -moz-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 49%, #F8F8F8 50%, #F8F8F8 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,'. $wp_estate_calendar_back_color .'), color-stop(49%,'. $wp_estate_calendar_back_color .'), color-stop(50%,#F8F8F8), color-stop(100%,#F8F8F8)); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#F8F8F8 50%,#F8F8F8 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color.' 0%,'. $wp_estate_calendar_back_color .' 49%,#F8F8F8 50%,#F8F8F8 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#F8F8F8 50%,#F8F8F8 100%); /* IE10+ */
        background: linear-gradient(135deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 49%,#F8F8F8 50%,#F8F8F8 100%); /* W3C */
    }


    .booking-calendar-wrapper-in .calendar-reserved.start_reservation ,
    .ll-skin-melon .ui-datepicker td.calendar-reserved.start_reservation{
        background: -moz-linear-gradient(-45deg,  #ffffff 0%, #ffffff 50%, '. $wp_estate_calendar_back_color .' 51%, '. $wp_estate_calendar_back_color .' 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(50%,#ffffff), color-stop(51%,'. $wp_estate_calendar_back_color .'), color-stop(100%,'. $wp_estate_calendar_back_color .')); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(-45deg,  #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(-45deg,  #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(-45deg,  #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* IE10+ */
        background: linear-gradient(135deg,  #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* W3C */
    }

    .all-front-calendars  .calendar-reserved.start_reservation {
        /*  background: -webkit-gradient(linear, right bottom, left top, color-stop(50%,'. $wp_estate_calendar_back_color.'), color-stop(50%,#fff))!important;    */
       background: #fff9f9; /* Old browsers */
        background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+CiAgICA8c3RvcCBvZmZzZXQ9IjAlIiBzdG9wLWNvbG9yPSIjZmZmOWY5IiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iNTAlIiBzdG9wLWNvbG9yPSIjZmZmZmZmIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iNTElIiBzdG9wLWNvbG9yPSIjYjg4MWZjIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iI2I4ODFmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgPC9saW5lYXJHcmFkaWVudD4KICA8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=);
        background: -moz-linear-gradient(-45deg,  #edf6f6 0%, #edf6f6 50%, '. $wp_estate_calendar_back_color .' 51%, '. $wp_estate_calendar_back_color .' 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#edf6f6), color-stop(50%,#edf6f6), color-stop(51%,'. $wp_estate_calendar_back_color .'), color-stop(100%,'. $wp_estate_calendar_back_color .')); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(-45deg,  #edf6f6 0%,#edf6f6 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(-45deg,  #edf6f6 0%,#edf6f6 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(-45deg,  #edf6f6 0%,#edf6f6 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* IE10+ */
        background: linear-gradient(135deg,  #edf6f6 0%,#edf6f6 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=#edf6f6, endColorstr='. $wp_estate_calendar_back_color .',GradientType=1 ); /* IE6-8 fallback on horizontal gradient */
    }


    .ll-skin-melon .ui-datepicker .ui-state-disabled.start_reservation{
        /*  background: -webkit-gradient(linear, right bottom, left top, color-stop(50%,'. $wp_estate_calendar_back_color .'), color-stop(50%,#fff))!important;    */
       background: #fff9f9; /* Old browsers */
        background: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+CiAgICA8c3RvcCBvZmZzZXQ9IjAlIiBzdG9wLWNvbG9yPSIjZmZmOWY5IiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iNTAlIiBzdG9wLWNvbG9yPSIjZmZmZmZmIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iNTElIiBzdG9wLWNvbG9yPSIjYjg4MWZjIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgIDxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iI2I4ODFmYyIgc3RvcC1vcGFjaXR5PSIxIi8+CiAgPC9saW5lYXJHcmFkaWVudD4KICA8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=);
        background: -moz-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 50%, '. $wp_estate_calendar_back_color .' 51%, '. $wp_estate_calendar_back_color .' 100%); /* FF3.6+ */
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,'. $wp_estate_calendar_back_color .'), color-stop(50%,'. $wp_estate_calendar_back_color .'), color-stop(51%,'. $wp_estate_calendar_back_color .'), color-stop(100%,'. $wp_estate_calendar_back_color .')); /* Chrome,Safari4+ */
        background: -webkit-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* Chrome10+,Safari5.1+ */
        background: -o-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* Opera 11.10+ */
        background: -ms-linear-gradient(-45deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* IE10+ */
        background: linear-gradient(135deg,  '. $wp_estate_calendar_back_color .' 0%,'. $wp_estate_calendar_back_color .' 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%); /* W3C */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=#ffffff, endColorstr='. $wp_estate_calendar_back_color .',GradientType=1 ); /* IE6-8 fallback on horizontal gradient */

    }

    .wpestate_calendar.start_reservation, .wpestate_booking_class.start_reservation{
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(50%,#ffffff), color-stop(51%,'. $wp_estate_calendar_back_color .'), color-stop(100%,'. $wp_estate_calendar_back_color .'))!important;
        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%)!important;
        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%)!important;
        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%!important);
        background: linear-gradient(135deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_back_color .' 51%,'. $wp_estate_calendar_back_color .' 100%)!important;
    }

    .wpestate_calendar.end_reservation, .wpestate_booking_class.end_reservation{
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%, '. $wp_estate_calendar_back_color .'), color-stop(49%, '. $wp_estate_calendar_back_color .'), color-stop(50%,#ffffff), color-stop(100%,#ffffff));
        background: -webkit-linear-gradient(-45deg, '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: -o-linear-gradient(-45deg, '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: -ms-linear-gradient(-45deg, '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: linear-gradient(135deg, '. $wp_estate_calendar_back_color .' 0%, '. $wp_estate_calendar_back_color .' 49%,#ffffff 50%,#ffffff 100%);
    }        
     ';
  }
  
  if($wp_estate_calendar_font_color!=''){
  print'  
      .rentals_reservation,
      .daterangepicker td.active, 
      .daterangepicker td.active:hover,
      .daterangepicker td.off.end-date, 
      .daterangepicker td.off.start-date,
      .fc-v-event .fc-event-main{
        color: '.$wp_estate_calendar_font_color.';
      }
      
    .calendar-reserved{
        color: '.$wp_estate_calendar_font_color.'!important;
    }
    ';    
  }
  
  if($wp_estate_calendar_internal_color!=''){
  print'      
    .calendar-reserved.start_reservation.calendar_pad.allinone_external_booking{
      background: -moz-linear-gradient(-45deg,  '. $wp_estate_calendar_internal_color .' 0%, '. $wp_estate_calendar_internal_color .' 49%, #ffffff 50%, #ffffff 100%); /* FF3.6+ */
      background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,'. $hover_button_color .'), color-stop(49%,'. $wp_estate_calendar_internal_color .'), color-stop(50%,#ffffff), color-stop(100%,#ffffff)); /* Chrome,Safari4+ */
      background: -webkit-linear-gradient(-45deg,  '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%); /* Chrome10+,Safari5.1+ */
      background: -o-linear-gradient(-45deg,  '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%); /* Opera 11.10+ */
      background: -ms-linear-gradient(-45deg,  '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%); /* IE10+ */
      background: linear-gradient(135deg,  '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%); /* W3C */
  }

    .calendar-free.calendar_pad.has_future.end_reservation.end_allinone_external_booking{
        background: -moz-linear-gradient(-45deg, '. $wp_estate_calendar_internal_color .' 0%, '. $wp_estate_calendar_internal_color .' 49%, #ffffff 50%, #ffffff 100%);
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,'. $wp_estate_calendar_internal_color .'), color-stop(49%,'. $wp_estate_calendar_internal_color .'), color-stop(50%,#ffffff), color-stop(100%,#ffffff));
        background: -webkit-linear-gradient(-45deg, '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: -o-linear-gradient(-45deg, '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: -ms-linear-gradient(-45deg, '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%);
        background: linear-gradient(125deg, '. $wp_estate_calendar_internal_color .' 0%,'. $wp_estate_calendar_internal_color .' 49%,#ffffff 50%,#ffffff 100%);
    }

    .calendar-reserved.start_reservation.calendar_pad.allinone_external_booking{
        background: -moz-linear-gradient(-45deg, #ffffff 0%, #ffffff 50%, '. $wp_estate_calendar_internal_color .' 51%, '. $wp_estate_calendar_internal_color .' 100%);
        background: -webkit-gradient(linear, left top, right bottom, color-stop(0%,#ffffff), color-stop(50%,#ffffff), color-stop(51%,'. $wp_estate_calendar_internal_color .'), color-stop(100%,'. $hover_button_color .'));
        background: -webkit-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_internal_color .' 51%,'. $wp_estate_calendar_internal_color .' 100%);
        background: -o-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_internal_color .' 51%,'. $wp_estate_calendar_internal_color .' 100%);
        background: -ms-linear-gradient(-45deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_internal_color .' 51%,'. $wp_estate_calendar_internal_color .' 100%);
        background: linear-gradient(125deg, #ffffff 0%,#ffffff 50%,'. $wp_estate_calendar_internal_color .' 51%,'. $wp_estate_calendar_internal_color .' 100%);
    }

    .external_reservation,
    .calendar-reserved.calendar_pad.has_future.allinone_external_booking{
        background-color: '. $wp_estate_calendar_internal_color .'!important;
    }
    
    .rentals_reservation.external_reservation.allinone_reservation:before,
    .external_reservation:before{
        border-top: 13px solid '. $wp_estate_calendar_internal_color .'!important;
    }


  ';
  }

///////////////////////////////////////////////////////////////////////////////////////////////////////////
// End colors
  

if(!function_exists('wpestate_custom_fonts_elements')):
    function wpestate_custom_fonts_elements(){
        $style='';
        $h1_fontfamily =     ( esc_html( wprentals_get_option('h1_typo','font-family') ));
        $h1_fontfamily =    wp_specialchars_decode  ( $h1_fontfamily,ENT_QUOTES );
        $h1_fontfamily =    str_replace('+', ' ', $h1_fontfamily);
        $h1_fontsubset =    esc_html( wprentals_get_option('h1_typo','subsets') );
        $h1_fontsize   =    esc_html( wprentals_get_option('h1_typo','font-size') );
        $h1_lineheight =    esc_html( wprentals_get_option('h1_typo','line-height') );
        $h1_fontweight =    esc_html( wprentals_get_option('h1_typo','font-weight') );


        if ($h1_fontfamily != '') {
            $style.= 'h1,h1 a, .dashboard-header h1{font-family:' . $h1_fontfamily .';}';
        }
        if ($h1_fontsize != '') {
            $style.= 'h1,h1 a, .dashboard-header h1 {font-size:' . $h1_fontsize .';}';
        }
        if ($h1_lineheight != '') {
            $style.= 'h1,h1 a, .dashboard-header h1 {line-height:' . $h1_lineheight .';}';
        }
        if ($h1_fontweight != '') {
            $style.=  'h1, h1 a, .heading_over_video, .heading_over_image,.dashboard-header h1 {font-weight:' . $h1_fontweight .';}';
        }


        $h2_fontfamily =   (  esc_html( wprentals_get_option('h2_typo','font-family') ) );
        $h2_fontfamily =    wp_specialchars_decode  ( $h2_fontfamily,ENT_QUOTES );
        $h2_fontfamily =    str_replace('+', ' ', $h2_fontfamily);
        $h2_fontsize   =    esc_html( wprentals_get_option('h2_typo','font-size'));
        $h2_lineheight =    esc_html( wprentals_get_option('h2_typo','line-height') );
        $h2_fontweight =    esc_html( wprentals_get_option('h2_typo','font-weight') );



        if ($h2_fontfamily != '') {
            $style.=  '.listing_main_image_price,h2,h2 a{font-family:' . $h2_fontfamily .';}';
        }
        if ($h2_fontsize != '') {
            $style.=  '.listing_main_image_price,h2,h2 a{font-size:' . $h2_fontsize .';}';
        }
        if ($h2_lineheight != '') {
            $style.=  '.listing_main_image_price,h2,h2 a{line-height:' . $h2_lineheight .';}';
        }
        if ($h2_fontweight != '') {
            $style.=  '.listing_main_image_price,h2,h2 a{font-weight:' . $h2_fontweight .';}';
        }


        $h3_fontfamily =    esc_html(  wprentals_get_option('h3_typo','font-family') );
        $h3_fontfamily =    wp_specialchars_decode  ( $h3_fontfamily,ENT_QUOTES );
        $h3_fontfamily =    str_replace('+', ' ', $h3_fontfamily);
        $h3_fontsize   =    esc_html( wprentals_get_option('h3_typo','font-size'));
        $h3_lineheight =    esc_html( wprentals_get_option('h3_typo','line-height') );
        $h3_fontweight =    esc_html( wprentals_get_option('h3_typo','font-weight') );

        if ($h3_fontfamily != '') {
            $style.=  'h3,h3 a{font-family:' . $h3_fontfamily .';}';
        }
        if ($h3_fontsize != '') {
            $style.=  'h3,h3 a, .agentpic-wrapper h3{font-size:' . $h3_fontsize .';}';
        }if ($h3_lineheight != '') {
            $style.=  'h3,h3 a{line-height:' . $h3_lineheight .';}';
        }
        if ($h3_fontweight != '') {
            $style.=  'h3,h3 a{font-weight:' . $h3_fontweight .';}';
        }


        $h4_fontfamily =    esc_html( wprentals_get_option('h4_typo','font-family') );
        $h4_fontfamily =    wp_specialchars_decode  ( $h4_fontfamily,ENT_QUOTES );
        $h4_fontfamily =    str_replace('+', ' ', $h4_fontfamily);
        $h4_fontsize   =    esc_html( wprentals_get_option('h4_typo','font-size') );
        $h4_lineheight =    esc_html( wprentals_get_option('h4_typo','line-height') );
        $h4_fontweight =    esc_html( wprentals_get_option('h4_typo','font-weight') );

        if ($h4_fontfamily != '') {
             $style.=  'h4,h4 a
                    .panel-title,
                    .booking_form_request h3{
                        font-family:' . $h4_fontfamily .';}';
        }
        if ($h4_fontsize != '') {
            $style.=  'h4,h4 a, .panel-title,
                    #on_the_map, #listing_reviews, 
                    .agent_listings_title_similar, 
                    #listing_calendar, 
                    #listing_description .panel-title-description,
                    .listing_title_unit,
                    .places_wrapper .featured_listing_title, 
                    .featured_property .featured_listing_title,
                    .booking_form_request h3{
                        font-size:' . $h4_fontsize .';}';
        }
        if ($h4_lineheight != '') {
            $style.=  'h4,h4 a, 
                    .listing_title_unit,
                    .panel-title,
                    .places_wrapper .featured_listing_title, 
                    .featured_property .featured_listing_title,
                    .booking_form_request h3{
                        line-height:' . $h4_lineheight .';}';
        }
        if ($h4_fontweight != '') {
            $style.=  'h4,h4 a, 
                    .blog-title-link,
                    .panel-title,
                    .listing_title_unit,
                    .places_wrapper .featured_listing_title, 
                    .featured_property .featured_listing_title,
                    .booking_form_request h3{
                        font-weight:' . $h4_fontweight .';}';
        }


        $h5_fontfamily =    esc_html( wprentals_get_option('h5_typo','font-family') );
        $h5_fontfamily =    wp_specialchars_decode  ( $h5_fontfamily,ENT_QUOTES );
        $h5_fontfamily =    str_replace('+', ' ', $h5_fontfamily);
        $h5_fontsize   =    esc_html( wprentals_get_option('h5_typo','font-size') );
        $h5_lineheight =    esc_html( wprentals_get_option('h5_typo','line-height') );
        $h5_fontweight =    esc_html( wprentals_get_option('h5_typo','font-weight') );

        if ($h5_fontfamily != '') {
            $style.= 'h5,h5 a{font-family:' . $h5_fontfamily .';}';
        }
        if ($h5_fontsize != '') {
            $style.= 'h5,h5 a{font-size:' . $h5_fontsize .';}';
        }
        if ($h5_lineheight != '') {
            $style.= 'h5,h5 a{line-height:' . $h5_lineheight .';}';
        }
        if ($h5_fontweight != '') {
            $style.= 'h5,h5 a{font-weight:' . $h5_fontweight .';}';
        }

        $h6_fontfamily =    esc_html( wprentals_get_option('h6_typo','font-family') );
        $h6_fontfamily =    wp_specialchars_decode  ( $h6_fontfamily,ENT_QUOTES );
        $h6_fontfamily =    str_replace('+', ' ', $h6_fontfamily);
        $h6_fontsize   =    esc_html( wprentals_get_option('h6_typo','font-size') );
        $h6_lineheight =    esc_html( wprentals_get_option('h6_typo','line-height') );
        $h6_fontweight =    esc_html( wprentals_get_option('h6_typo','font-weight') );

        if ($h6_fontfamily != '') {
            $style.=  'h6,h6 a,
                       .listing_main_image_location,
                       #infobox_title,
                       .prop_pricex,
                       .widget-title-sidebar,
                       .profile_wellcome,
                       .property_unit_v4 .listing_title_unit,
                       .property_unit_v4 .property-rating{
                            font-family:' . $h6_fontfamily .';}';
        }
        
        if ($h6_fontsize != '') {
           $style.=  'h6,h6 a,
                     .listing_main_image_location,
                     #infobox_title,
                     .prop_pricex,
                     .widget-title-sidebar,
                     .profile_wellcome,
                     .widget-title-footer,
                     .trip_details_container h3, 
                     .trip_details_container h4, 
                     .trip_details_container h5, 
                     .trip_details_container h6,
                     .property_unit_v4 .listing_title_unit,
                    .property_unit_v4 .property-rating{
                            font-size:' . $h6_fontsize .';}';
        }
        
        if ($h6_lineheight != '') {
           $style.=  'h6,h6 a,
                     .listing_main_image_location,
                     #infobox_title,
                     .widget-title-sidebar,
                     .profile_wellcome,
                     .widget-title-footer,
                     .trip_details_container h3, 
                     .trip_details_container h4, 
                     .trip_details_container h5, 
                     .trip_details_container h6,
                     .property_unit_v4 .listing_title_unit,
                    .property_unit_v4 .property-rating{
                            line-height:' . $h6_lineheight .';}';
        }
        
        if ($h6_fontweight != '') {
           $style.=  'h6,h6 a,
                     .listing_main_image_location,
                     #infobox_title,
                     .prop_pricex,
                     .widget-title-sidebar,
                     .profile_wellcome,
                     .user_dashboard_panel_title,
                     .widget-title-footer,
                     .invoice_data_legend,
                     .header_legend,#total_amm,.booking_details_title,
                     .trip_details_container h3, 
                     .trip_details_container h4, 
                     .trip_details_container h5, 
                     .trip_details_container h6,
                     .property_unit_v4 .listing_title_unit{
                            font-weight:' . $h6_fontweight .';}';        
        }

       
        $p_fontfamily = esc_html( wprentals_get_option('paragraph_typo','font-family') );
        $p_fontfamily =    wp_specialchars_decode  ( $p_fontfamily,ENT_QUOTES );
        $p_fontfamily = str_replace('+', ' ', $p_fontfamily);
        $p_fontsize   = esc_html( wprentals_get_option('paragraph_typo','font-size') );
        $p_lineheight = esc_html( wprentals_get_option('paragraph_typo','line-height') );
        $p_fontweight = esc_html( wprentals_get_option('paragraph_typo','font-weight') );
        if ($p_fontfamily != '') {
            $style .= '
                .wprentals_dashboard_page,
                .single-content p, body, p, 
                .cost_row_extra,
                .prop_detailsx,
                .wpestate_marker,
                .wprentals_dashboard_page,
                label,
                .dashboard_chapter_label,
                .property_dashboard_location_wrapper .listing_title,
                .property_dashboard_location_wrapper .user_dashboard_listed,
                .user_dashboard_panel_guide a {
                    font-family: ' . $p_fontfamily . ';
                }';
        }
        
        if ($p_fontsize != '') {
            $style .= '
                .single-content p, 
                body, p, 
                .cost_row_extra,
                .widget-area-sidebar input[type=text], 
                .widget-area-sidebar input[type=password], 
                .widget-area-sidebar input[type=email], 
                .widget-area-sidebar input[type=url], 
                .widget-area-sidebar input[type=number], 
                .widget-area-sidebar textarea, 
                .panel-wrapper,
                .wprentals_dashboard_page,
                .user_tab_menu a, 
                .user_dashboard_links a,
                .blog-unit-content,
                .widget li a, 
                .widget-area-sidebar li a,
                label,
                .dashboard_chapter_label,
                .property_dashboard_location_wrapper .listing_title,
                .property_dashboard_location_wrapper .user_dashboard_listed,
                .user_dashboard_panel_guide a,
                .back_to_home,
                #validate_phone, #send_sms_pin, 
                .mess_send_reply_review_button, 
                #view_profile, .mess_send_reply_button, 
                #change_pass, #update_profile, 
                #book_dates, #aaiu-uploader, 
                #set_price_dates, 
                #book_dates, 
                #edit_prop_ammenities, 
                #edit_prop_locations, 
                #google_capture, 
                #edit_prop_details, 
                #edit_prop_image, 
                #edit_prop_price, 
                #edit_prop_1, 
                #edit_calendar, 
                #form_submit_1, 
                #delete_profile, 
                #user-id-uploader,
                .property_dashboard_reviews, 
                .property_dashboard_price .price_label, 
                .property_dashboard_price, 
                .property_dashboard_status, 
                .property_dashboard_types,
                .next_submit_page,
                .dashboard_chapter_label label,
                .wpestate_dashboard_table_list_header,
                #colophon .loginwd_sidebar .form-control, 
                #primary .loginwd_sidebar .form-control, 
                .form-control,
                .user_dashboard_panel select,
                .delete_extra_detail, 
                #add_extra_detail, 
                .delete_extra_option, 
                #add_extra_feed, 
                #add_extra_option,
                #colophon .category_tagline, 
                #colophon .category_tagline a, 
                #colophon li a, #colophon ul, 
                .subfooter_menu li, 
                #colophon .subfooter_menu a, 
                .sub_footer,
                .category_details_wrapper a, 
                .no_link_details,
                #agent_submit_contact, 
                .advanced_search_submit_button, 
                .return_woo_button, 
                .wpestate_header_view_checkout, 
                .wpestate_header_view_cart, 
                #submit_booking_front_instant, 
                #submit_booking_front, 
                #submit_booking_front_link, 
                #advanced_submit_widget, 
                #advanced_submit_2_mobile, 
                #advanced_submit_2, 
                #advanced_submit_3,
                #add_favorites,
                #contact_host,
                .prop_social_share,
                .item_head,
                .testimonial_type_2 .testimonial-text,
                .testimonial_type_2 .testimonial-clas-line,
                .other_rules label, 
                .cancelation_policy label,
                .widget-area-sidebar,
                .show_cost_form,
                .owner_read_more,
                .listing_filters_head .filter_menu_trigger, 
                .listing_filters .filter_menu_trigger,
                .category_tagline, .category_tagline a,
                .filter_menu li,
                .contact_detail,
                .modal-content #wp-forgot-but_mod, 
                .mess_send_reply_button, 
                #change_pass, #update_profile, #book_dates, 
                #aaiu-uploader, #set_price_dates, 
                #book_dates, #edit_prop_ammenities, 
                #edit_prop_locations, #google_capture, 
                #edit_prop_details, 
                #edit_prop_image, 
                #edit_prop_price, 
                #edit_prop_1, 
                #edit_calendar,
                #form_submit_1, 
                #submit_mess_front, 
                .modal-content #wp-login-but, 
                #wp-login-but_sh, 
                #delete_profile, 
                #user-id-uploader, 
                #wp-submit-register_sh, 
                #wp-forgot-but,
                #ajax_register_div #user_terms_register_sh_label,
                #booking_form_request_mess_modal, 
                #booking_form_request_mess, 
                .alert-message, 
                .alert_error, 
                .login-alert,
                .wpestate_guest_no_buttons_title_labels,
                .wpestate_guest_no_buttons_description_labels,
                .invoice_data_legend,
                .price_custom_explained, 
                .date_duration, 
                .date_interval,
                .total_inv_span,
                .invoice_content,
                .inv_legend,
                .inv_data,
                .woo_pay,
                .reply_to_review, 
                .trip_details, 
                .proceed-payment_full,
                .waiting_payment, 
                .full_invoice_reminder, 
                .you_already_review,
                .post_review_later, 
                .confirmed_booking, 
                .contact_owner_reservation, 
                .proceed-payment_full, 
                #post_review, 
                .proceed-payment, 
                .tag-post-review, 
                .action1_booking, 
                .generate_invoice,
                .booking_canceled_by_owner, 
                .cancel_user_booking, 
                .cancel_own_booking, 
                .delete_invoice, 
                .delete_booking,
                .waiting_payment_status_pending, 
                .waiting_payment_user_status, 
                .waiting_payment_status, 
                .tag-published, 
                .tag-paid,
                .search_dashborad_header .wpb_btn-info.wpb_btn-small.wpestate_vc_button.vc_button,
                .pay_notice_booking,
                #confirm_zero_instant_booking, 
                #send_direct_bill_booking, 
                #direct_pay_booking, 
                #send_direct_bill, 
                #direct_pay, 
                #stripe_cancel, 
                #paypal_booking, 
                #pick_pack,
                .message_listing,
                .review-content {
                    font-size: ' . $p_fontsize . ';
                }';
        }
        
        
        if ($p_lineheight != '') {
            $style.=  '.single-content p, body, p, .cost_row_extra,
                        label,
                        .dashboard_chapter_label
                        .property_dashboard_location_wrapper .user_dashboard_listed,
                        .dashboard_chapter_label label,
                        #colophon .category_tagline, 
                        #colophon .category_tagline a, 
                        #colophon li a, #colophon ul, 
                        .subfooter_menu li, 
                        #colophon .subfooter_menu a, 
                        .sub_footer{
                         line-height:' . $p_lineheight .';}';
        }
        if ($p_fontweight != '') {
            $style.= 'body,p,
                     .single-content p,
                     .cost_row_extra,
                     .wprentals_dashboard_page,
                     .category_name,
                     .dashboard_chapter_label,
                     .property_dashboard_location_wrapper .user_dashboard_listed,
                     .user_dashboard_panel_guide a,
                     .back_to_home,
                     .dashboard_chapter_label label,
                     .delete_extra_detail, 
                     #add_extra_detail, 
                     .delete_extra_option, 
                     #add_extra_feed, 
                     #add_extra_option,
                     #colophon .category_tagline, 
                     #colophon .category_tagline a, 
                     #colophon li a, #colophon ul, 
                     .subfooter_menu li, 
                     #colophon .subfooter_menu a, 
                     .sub_footer{
                         font-weight:' . $p_fontweight .';}';
        }

        $menu_fontfamily =  esc_html( wprentals_get_option('menu_typo','font-family') );
        $menu_fontfamily =    wp_specialchars_decode  ( $menu_fontfamily,ENT_QUOTES );
        $menu_fontfamily =  str_replace('+', ' ', $menu_fontfamily);
        $menu_fontsize   =  esc_html( wprentals_get_option('menu_typo','font-size') );
        $menu_lineheight =  esc_html( wprentals_get_option('menu_typo','line-height') );
        $menu_fontweight =  esc_html( wprentals_get_option('menu_typo','font-weight') );

        if ($menu_fontweight != '') {
            $style.= '
                #access ul ul a,
                .menu_username,
                .submit_listing,
                .header_phone,
                #access a,
                #user_menu_u,
                .signuplink,
                .wpestate_top_property_navigation,
                li.wpestate_megamenu_col_2 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_3 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_4 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_5 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_6 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_1 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_2 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_3 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_4 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_5 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_6 .megamenu-title a,
                #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link,
                #access ul ul li.wpestate_megamenu_col_1, 
                #access ul ul li.wpestate_megamenu_col_2, 
                #access ul ul li.wpestate_megamenu_col_3, 
                #access ul ul li.wpestate_megamenu_col_4,
                #access ul ul li.wpestate_megamenu_col_5, 
                #access ul ul li.wpestate_megamenu_col_6, 
                #access ul ul li.wpestate_megamenu_col_1 a, 
                #access ul ul li.wpestate_megamenu_col_2 a, 
                #access ul ul li.wpestate_megamenu_col_3 a, 
                #access ul ul li.wpestate_megamenu_col_4 a, 
                #access ul ul li.wpestate_megamenu_col_5 a, 
                #access ul ul li.wpestate_megamenu_col_6 a{
                    font-weight:' . $menu_fontweight .';
                }';

        if ($menu_fontfamily != '') {
             $style.= '#access ul ul a,
                .menu_username,
                .submit_listing,
                .header_phone,
                #access a,
                #user_menu_u,
                .wpestate_top_property_navigation,
                li.wpestate_megamenu_col_2 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_3 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_4 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_5 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_6 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_1 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_2 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_3 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_4 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_5 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_6 .megamenu-title a,
                #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link,
                #access ul ul li.wpestate_megamenu_col_1, 
                #access ul ul li.wpestate_megamenu_col_2, 
                #access ul ul li.wpestate_megamenu_col_3, 
                #access ul ul li.wpestate_megamenu_col_4,
                #access ul ul li.wpestate_megamenu_col_5, 
                #access ul ul li.wpestate_megamenu_col_6, 
                #access ul ul li.wpestate_megamenu_col_1 a, 
                #access ul ul li.wpestate_megamenu_col_2 a, 
                #access ul ul li.wpestate_megamenu_col_3 a, 
                #access ul ul li.wpestate_megamenu_col_4 a, 
                #access ul ul li.wpestate_megamenu_col_5 a, 
                #access ul ul li.wpestate_megamenu_col_6 a{
                        font-family:' . $menu_fontfamily .';}';
        }
        
        if ($menu_fontsize != '') {
            $style.= '#access ul ul a,
                .menu_username,
                .submit_listing,
                .header_phone,
                #access a,
                #user_menu_u,
                .wpestate_top_property_navigation,
                li.wpestate_megamenu_col_2 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_3 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_4 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_5 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_6 .megamenu-title, 
                #access ul ul li.wpestate_megamenu_col_1 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_2 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_3 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_4 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_5 .megamenu-title a, 
                #access ul ul li.wpestate_megamenu_col_6 .megamenu-title a,
                #access ul ul li.wpestate_megamenu_col_1 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_2 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_3 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_4 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_5 a.menu-item-link, 
                #access ul ul li.wpestate_megamenu_col_6 a.menu-item-link,
                #access ul ul li.wpestate_megamenu_col_1, 
                #access ul ul li.wpestate_megamenu_col_2, 
                #access ul ul li.wpestate_megamenu_col_3, 
                #access ul ul li.wpestate_megamenu_col_4,
                #access ul ul li.wpestate_megamenu_col_5, 
                #access ul ul li.wpestate_megamenu_col_6, 
                #access ul ul li.wpestate_megamenu_col_1 a, 
                #access ul ul li.wpestate_megamenu_col_2 a, 
                #access ul ul li.wpestate_megamenu_col_3 a, 
                #access ul ul li.wpestate_megamenu_col_4 a, 
                #access ul ul li.wpestate_megamenu_col_5 a, 
                #access ul ul li.wpestate_megamenu_col_6 a{
                        font-size:' . $menu_fontsize .';}';
        }

 
        }

        if($style!=''){
            print trim($style);
        }

    }   
endif;

?>