<?php
global $wpestate_options;
global $notes;
$thumb_id = get_post_thumbnail_id($post->ID);
$preview = wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_featured');
$preview_url = '';
if (is_array($preview) && isset($preview[0])) {
    $preview_url = esc_url($preview[0]);
} else {
    $preview_url = '';
}

$name =  get_sanitized_truncated_title($post->ID, 0);
$link = esc_url(get_permalink());
$col_class = 4;
if ($wpestate_options['content_class'] == 'col-md-12') {
    $col_class = 3;
}
?>

<div class="featured_property  featured_agent" data-link="<?php print esc_url($link); ?>">  
  
        <div class=" places1" >
            <div class="listing-hover-gradient"></div><div class="listing-hover" ></div>
            <div class="listing-unit-img-wrapper shortcodefull" style="background-image:url(<?php print esc_url($preview_url); ?>)"></div>             
                <div class="category_name">
                    <a class="featured_listing_title" href="<?php print esc_url($link); ?>"> <?php print esc_html($name); ?> </a>
                    <div class="category_tagline">
                       <?php print esc_html($notes);?>
                    </div>
                   
                </div>
          
        </div>          
   
</div>