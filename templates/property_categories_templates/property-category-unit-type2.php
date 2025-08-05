<?php
$place_per_row_class='col-md-4';
if($place_per_row==1){
    $place_per_row_class='col-md-12';
}else if($place_per_row==2){
        $place_per_row_class='col-md-6';
}else if($place_per_row==3){
        $place_per_row_class='col-md-4';
}else if($place_per_row==4){
        $place_per_row_class='col-md-3';
}else if($place_per_row==5){
    $place_per_row_class='col-md-24';
}
?>

<div class="places_wrapper_design_2_wrapper <?php echo esc_attr($place_per_row_class);?>" data-link="<?php echo esc_url($term_link);?>">
    <div class="places_wrapper places_wrapper_design_2" data-link="<?php echo esc_url($term_link);?>">
        <div class="listing-hover"></div>

        <div class="places" style="background-image:url(<?php echo esc_url($category_featured_image_url);?>)">
        </div>
    </div>
                
    <div class="category_name">
        <a class="featured_listing_title" href="<?php echo esc_url($term_link);?>">
            <?php echo esc_html($category_name);?>
        </a> 
                 
    <div class="place_counter">            
        <?php echo sprintf(  _n('%d listing', '%d listings', $category_count, 'wprentals'), $category_count ); ?>        
    </div>

    </div>
</div>