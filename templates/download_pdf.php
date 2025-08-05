<?php

$attachment_ids = wpestate_generate_property_slider_image_ids($post->ID );        
$display = '';

foreach ($attachment_ids as $attachment_id) {
    // Check if the attachment is a PDF
    if (get_post_mime_type($attachment_id) === 'application/pdf') {
        $attachment = get_post($attachment_id);
        $display.= '<div class="document_down"><a href="'.esc_url( wp_get_attachment_url($attachment_id)).'" target="_blank">'.esc_html($attachment->post_title).'<i class="fas fa-download"></i></a></div>';
  
    }
}

if($display){
    print '<div class="download_docs">'.esc_html__( 'Documents','wprentals').'</div>';
    print $display;
}