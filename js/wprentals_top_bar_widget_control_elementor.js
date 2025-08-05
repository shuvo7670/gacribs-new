jQuery(document).ready(function ($) {
    "use strict";

    wpestate_ajax_top_bar_widget_elementor_control();


});

function wpestate_ajax_top_bar_widget_elementor_control(){
    
    jQuery('.wpestate_display_item_list_top_bar_wrapper .wpestate_categories_as_tabs_item').on('click',function(){
        
        var term_id         = jQuery(this).attr('data-term-id');
        //var content_wrapper = jQuery(this).parent().parent();
        var content_wrapper = jQuery(this).parents('.wpestate_display_item_list_top_bar_wrapper');
        var item_number     = content_wrapper.attr('data-number');
        var row_number      = content_wrapper.attr('data-row_number');
        var display_grid    = content_wrapper.attr('data-display_grid');
        var nonce           = jQuery('#wprentals_ajax_filtering_top_bar').val();
        ajaxurl             =  control_vars.admin_url + 'admin-ajax.php';


        jQuery('#wpestate_display_item_list_top_bar_content_wrapper').empty();
        jQuery('#listing_loader').show();

        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            dataType: 'json',
            data: {
                'action'            :   'wpestate_ajax_top_bar_widget_elementor',
                'term_id'           :   term_id,
                'item_number'       :   item_number,
                'row_number'        :   row_number,
                'display_grid'      :   display_grid,
                'security'          :   nonce,
            },
            success: function (data) {

        
                jQuery('#wpestate_display_item_list_top_bar_content_wrapper').append('something');
                jQuery('#wpestate_display_item_list_top_bar_content_wrapper').html(data.to_display);
                jQuery('#listing_loader').hide();   
                wpestate_restart_js_after_ajax();     

            },
            error: function (errorThrown) {
            }

        });
    });
}