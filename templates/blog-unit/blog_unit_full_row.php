<?php
global $wpestate_options;
global $unit_class;
global $row_number;
$thumb_id   =   get_post_thumbnail_id($post->ID);
$preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
$link       =   esc_url(get_permalink());
?>

<div class="places_wrapper   places_wrapper<?php print esc_attr($row_number);?>" data-link="<?php print esc_url($link);?>">
    <div class="places<?php print esc_attr($row_number);?>">
        <?php 
    
        $preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'wpestate_property_featured');
        $preview_img = get_stylesheet_directory_uri().'/img/defaultimage.jpg';
        if( isset($preview[0]) ){
            $preview_img=$preview[0];
        }

        print   '<div class="listing-hover-gradient"></div><div class="listing-hover" ></div>';
        print   '<div class="listing-unit-img-wrapper shortcodefull" style="background-image:url('.esc_url($preview_img).')"></div>';
        print   '<div class="featured-article-date blog_unit_full_row">'. get_the_date().'</div>'; 
        ?>
    </div>
    
    <a href="<?php echo esc_url(get_permalink()); ?>" class="blog-title-link"><?php print  get_sanitized_truncated_title(0, 0); ?></a> 
</div>