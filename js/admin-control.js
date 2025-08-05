/*global $, jQuery, document, window, tb_show, tb_remove ,admin_control_vars*/
jQuery(document).ready(function ($) {
    wpestate_upload_images_in_wpadmin();


    var icon_field;
    $('.input-group-addon').on('click',function(event){
          $('.iconpicker-items_wrapper').show();
          $('.icon_look_for_class').val('');
          $('.iconpicker-item').show();
          icon_field = $(this).parent().find('.icp-auto');
    });

    $('.iconpicker-items_wrapper_close').on('click',function(event){
        $('.iconpicker-items_wrapper').hide();
    });

    $('.iconpicker-item').on('click',function(event){
        event.preventDefault();
        var value = $(this).find('i').attr('class');
        icon_field.val(value);
        icon_field.parent().find('i').attr('class',value);
        $('.iconpicker-items_wrapper').hide();
    });


    $('.icon_look_for_class').keydown(function(event){

        var look_for= $(this).val();
        var title, search_term,parent;
        parent = $(this).parent();

        if(look_for!==''){
            parent.find('.iconpicker-item').each(function() {
                title       = $(this).attr('title');
                search_term = $(this).attr('data-search-terms');

                if(typeof title==='undefined'){
                    title='';
                }
                if(typeof search_term==='undefined'){
                    search_term='';
                }


                if(title.indexOf(look_for) !== -1 || search_term.indexOf(look_for) !== -1){
                    $(this).show();
                }else{
                    $(this).hide();
                }

            });
        }else{
            parent.find('.iconpicker-item').show();
        }
    });


    $('.css_modal_close').on('click',function(){
        $('#css_modal').hide();
    });

    $('#copycsscode').on('click',function(){
        $('#css_modal').html();

    });


    $('#activate_pack_reservation_fee').on('click',function(){
        var book_id, invoice_id,ajaxurl,type;
        jQuery(this).text(admin_control_vars.processing);
        book_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        type        = $(this).attr('data-type');
        ajaxurl     =   admin_control_vars.ajaxurl;
        var nonce = jQuery('#wprentals_activate_pack').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_admin_activate_reservation_fee',
            'book_id'       :   book_id,
            'invoice_id'    :   invoice_id,
            'security'      :   nonce,
        },
        success: function (data) {
            jQuery("#activate_pack_reservation_fee").remove();
            jQuery("#invnotpaid").remove();
        },
        error: function (errorThrown) {
        }
    });//end ajax

    });



     $('#activate_pack_listing').on('click',function(){
        var item_id, invoice_id,ajaxurl,type;

        item_id     = $(this).attr('data-item');
        invoice_id  = $(this).attr('data-invoice');
        type        = $(this).attr('data-type');
        ajaxurl     =   admin_control_vars.ajaxurl;
        var nonce = jQuery('#wprentals_activate_pack').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_activate_purchase_listing',
            'item_id'       :   item_id,
            'invoice_id'    :   invoice_id,
            'type'          :   type,
            'security'      :   nonce,

        },
        success: function (data) {
            jQuery("#activate_pack_listing").remove();
            jQuery("#invnotpaid").remove();


        },
        error: function (errorThrown) {}
    });//end ajax

    });

     ///////////////////////////////////////////////////////////////////////////////
    /// activate purchase
    ///////////////////////////////////////////////////////////////////////////////

     $('#activate_pack').on('click',function(){
        var item_id, invoice_id,ajaxurl;

        item_id     =   $(this).attr('data-item');
        invoice_id  =   $(this).attr('data-invoice');
        ajaxurl     =   admin_control_vars.ajaxurl;
        var nonce = jQuery('#wprentals_activate_pack').val();


        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
        data: {
            'action'        :   'wpestate_activate_purchase',
            'item_id'       :   item_id,
            'invoice_id'    :   invoice_id,
            'security'         :   nonce,

        },
        success: function (data) {
            jQuery("#activate_pack").remove();
            jQuery("#invnotpaid").remove();

        },
        error: function (errorThrown) {}
    });//end ajax

    });







    if (jQuery('.user-verifications').length === 1) {
        var verifications = jQuery('.user-verifications');

        verifications.on('change', 'input[type="checkbox"]', function () {
            var   userID = jQuery(this).data('userid');

            var   isVerified = 0;
            var   editUser = jQuery(this).closest('.verify-user', jQuery('.user-verifications'));


            if( $('input[name="verified-users[]"]:checked').length > 0 ){
                isVerified = 1;
            }


           var nonce = jQuery('#wprentals_user_verfication').val();

            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    'action': 'wpestate_update_verification',
                    'userid': userID,
                    'verified': isVerified,
                    'security': nonce,
                },
                success: function (data) {
              
                    switch (true) {
                        case (isVerified === 0):

                            editUser.removeClass('verified');
                            break;
                        case (isVerified === 1):

                            editUser.addClass('verified');
                            break;
                    }
                },
                error: function (errorThrown) {

                }
            });
        });
    }


});




/*
* Upload images in admin
*
*/
function wpestate_upload_images_in_wpadmin(){
    
    var idList          = ["category_featured_image_button","page_custom_image_button" , "page_custom_video_cover_image_button","page_custom_video_button","page_custom_video_webbm_button","page_custom_video_ogv_button" ];

    for (var i = 0; i < idList.length; i++) {
        var currentId = idList[i];
        jQuery('#'+currentId).on( 'click', function(event) {

       

            var parent=jQuery(this).parent();
            wpestate_admin_return_uploaded_image().then(function(image) {      
                parent.find('.wpestate_landing_upload').val(image.url);
                parent.find('.wpestate_landing_upload_id').val(image.id);
              //  wpestate_break_attachment(image.id);
            });
          
        });

    }
}

/*
* return uploaded image
*
*/
function wpestate_admin_return_uploaded_image(){

    return new Promise(function(resolve, reject) {
        var mediaUploader = wp.media({
          frame: "post",
          state: "insert",
          multiple: false
        });
    
        mediaUploader.on("insert", function(){
          var image = mediaUploader.state().get("selection").first().toJSON();
          resolve(image);
        });
    
        mediaUploader.open();
      });
}

/*
* 
*
*/
function wpestate_break_attachment(attachmentID){
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'        :   'wpestate_break_attachment',
            'attachmentID'       :   attachmentID,
        },
        success: function (data) {

        },
        error: function (errorThrown) {}
});//end ajax
    
}