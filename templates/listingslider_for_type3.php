<?php
global $post_attachments;
global $post;
$post_thumbnail_id       =   get_post_thumbnail_id( $post->ID );
$preview                 =   wp_get_attachment_image_src($post_thumbnail_id, 'full');
$wpestate_currency       =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );
$wpestate_where_currency =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
$price                   =   intval   ( get_post_meta($post->ID, 'property_price', true) );
$price_label             =   esc_html ( get_post_meta($post->ID, 'property_label', true) );

   echo wpestate_return_property_status($post->ID);
?>

<div class="listing_main_image" id="listing_main_image_photo_slider">


        <?php

        $hidden         =   '';
        $post_attachments=wpestate_generate_property_slider_image_ids($post->ID,true);
        foreach ($post_attachments as $attachment_id) {
                if (!wp_attachment_is_image($attachment_id)) {
                    continue; // Skip this attachment if it's not an image
                }
                $attachment = get_post($attachment_id);
                $full_prty          = wp_get_attachment_image_src($attachment_id, 'wpestate_property_full_map');
                $full_prty_hidden          = wp_get_attachment_image_src($attachment_id, 'full');
                print '<div class="listing_main_image_photo_slider_item" style="background-image:url('.esc_url($full_prty[0]).')">
                        <div class="price_unit_wrapper"></div></div>';

                $hidden.= ' <a href="'.esc_url($full_prty_hidden[0]).'" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery"   title="'.esc_attr($attachment->post_excerpt).'"  data-caption="'.esc_attr($attachment->post_excerpt).'"  class="fancybox-thumb prettygalery listing_main_image" >
                        <img  src="'.esc_url($full_prty_hidden[0]).'" data-original="'.esc_attr($full_prty_hidden[0]).'" alt="'.esc_attr($attachment->post_excerpt).'" class="img-responsive " />
                    </a>';

        }
        ?>


</div> <div class="hidden_photos hidden_type3 vvv "><?php echo trim($hidden);?></div><!--
