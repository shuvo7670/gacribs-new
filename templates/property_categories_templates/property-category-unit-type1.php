<div class="places_wrapper_elementor  places_wrapper<?php echo esc_attr($place_per_row);?>" style="">
    
    <div class="places_wrapper <?php echo esc_attr($extra_class_name);?>" data-link="<?php echo esc_url($term_link);?>">
        <div class="listing-hover-gradient">
        </div>
        
        <div class="listing-hover" style="left:<?php echo esc_attr($spaces_unit);?>px;right:<?php echo esc_attr($spaces_unit);?>px;">
        </div>
        
        <div class="places_height <?php echo esc_attr('places'.$place_per_row);?>" style="background-image:url(<?php echo esc_url($category_featured_image_url);?>)">
        </div>
        
        <div class="category_name">
            <a class="featured_listing_title" href="<?php echo esc_attr($term_link);?>">
                <?php echo esc_html($category_name);?>
            </a>
            <div class="category_tagline"><?php echo esc_html($category_tagline);?>
            </div>
        </div>
    </div>
</div>