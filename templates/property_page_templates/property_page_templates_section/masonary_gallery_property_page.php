<?php
global $post_attachments;
global $post;
$post_thumbnail_id       =   get_post_thumbnail_id( $post->ID );
$preview                 =   wp_get_attachment_image_src($post_thumbnail_id, 'full');
$wpestate_currency       =   esc_html( wprentals_get_option('wp_estate_currency_label_main', '') );
$wpestate_where_currency =   esc_html( wprentals_get_option('wp_estate_where_currency_symbol', '') );
$price                   =   intval   ( get_post_meta($post->ID, 'property_price', true) );
$price_label             =   esc_html ( get_post_meta($post->ID, 'property_label', true) );


?>

<div class="listing_main_image header_masonry panel-body imagebody imagebody_new" id="">


        <?php

        echo wpestate_return_property_status($post->ID);


      
            $hidden ='';
            $post_attachments=wpestate_generate_property_slider_image_ids($post->ID,false);
       
            $total_pictures = count($post_attachments);
            
            // Add featured image
            $post_thumbnail_id = get_post_thumbnail_id();
            $post_attachments = array_diff($post_attachments, [$post_thumbnail_id]);

            $full_prty = wp_get_attachment_image_src($post_thumbnail_id, 'wpestate_property_featured');
            $full_prty_hidden = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $full_prty_0 = isset($full_prty[0]) ? $full_prty[0] : '';
            $full_prty_hidden_0 = isset($full_prty_hidden[0]) ? $full_prty_hidden[0] : '';
           
           
            $image_excerpt = get_post_meta($post_thumbnail_id, '_wp_attachment_image_alt', true);

            // Check if alt text exists and display it
            if (!$image_excerpt) {
                $image_excerpt=get_sanitized_truncated_title($post->ID, 0) ;
            }

            $post_attachments = array_values(array_filter($post_attachments, function($value) use ($post_thumbnail_id) {
                return (int)$value !== (int)$post_thumbnail_id && $value !== 'undefined';
            }));
    


            print '<div class="col-md-6 image_gallery lightbox_trigger special_border" data-slider-no="1" style="background-image:url('.esc_attr($full_prty_0).')  ">   <div class="img_listings_overlay" ></div></div>';
            $hidden .= '<a href="'.esc_url($full_prty_hidden_0).'" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" title="'.esc_attr('featured image','wprentals').'" data-caption="'.esc_attr($image_excerpt).'" class="fancybox-thumb prettygalery listing_main_image">
                <img src="'.esc_url($full_prty_hidden_0).'" data-original="'.esc_attr($full_prty_hidden_0).'" alt="'.esc_attr($image_excerpt).'" class="img-responsive"/>
            </a>';
                        
            $count = 0;
            foreach ($post_attachments as $attachment_id) {
                if (!wp_attachment_is_image($attachment_id)) {
                    continue; // Skip this attachment if it's not an image
                }
                $count++;
                $special_border='  ';
                if($count==0){
                    $special_border=' special_border ';
                }

                if($count>=1 && $count<=2){
                    $special_border=' special_border_top ';
                }

  

                $image_excerpt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

                // Check if alt text exists and display it
                if (!$image_excerpt) {
                    $image_excerpt=get_sanitized_truncated_title($post->ID, 0) ;
                }

                if($count <= 3 && $count !=0){
                    $full_prty          = wp_get_attachment_image_src($attachment_id, 'listing_full_slider');
                    print '<div class="col-md-3 image_gallery  '.esc_attr($special_border).' " data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')"> <div class="img_listings_overlay" ></div> </div>';
                }

                if($count == 4 ){
                    $full_prty          = wp_get_attachment_image_src($attachment_id, 'listing_full_slider');
                    print '<div class="col-md-3 image_gallery" data-slider-no="'.esc_attr($count+1).'" style="background-image:url('.esc_attr($full_prty[0]).')  ">
                        <div class="img_listings_overlay img_listings_overlay_last" ></div>
                        <span class="img_listings_mes">'.esc_html__( 'See all','wprentals').' '.esc_html($total_pictures).' '.esc_html__( 'photos','wprentals').'</span></div>';
                }

                $full_prty_hidden          = wp_get_attachment_image_src($attachment_id, 'full');
                $hidden.= ' <a  href="'.esc_url($full_prty_hidden[0]).'" rel="data-fancybox-thumb" data-fancybox="website_rental_gallery" data-caption="'.esc_attr($image_excerpt).'" class="fancybox-thumb prettygalery listing_main_image" >
                        <img  src="'.esc_url($full_prty_hidden[0]).'" data-original="'.esc_attr($full_prty_hidden[0]).'" alt="'.esc_attr($image_excerpt).'" class="img-responsive " />
                    </a>';
            }

        ?>


</div> <div class="hidden_photos hidden_type3"><?php echo trim($hidden);?></div>
