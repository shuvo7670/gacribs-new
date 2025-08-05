<?php
$category_featured_image_url='';


$term = get_term( $place_id );


$category_name='';
$category_tax = '';
$category_count=0;
if(!is_wp_error($term)){
    $category_tax = $term->taxonomy;
    $category_name = $term->name;
    $category_count = $term->count;
}

$term_meta                      =   get_option( "taxonomy_$place_id");
if(isset($term_meta['category_attach_id'])){
    $category_attach_id=$term_meta['category_attach_id'];
    $category_tagline = $term_meta['category_tagline'];    
    $category_featured_image= wp_get_attachment_image_src( $category_attach_id, 'property_full');
    $category_featured_image_url=$category_featured_image[0];
}
if($category_featured_image_url==''){
    $category_featured_image_url=get_stylesheet_directory_uri().'/img/defaultimage.jpg';
}





$term_link =  get_term_link( $place_id, $category_tax );

if(is_wp_error($term_link)){
    $term_link='';
}


?>
<div class="places_wrapper_elementor  places_wrapper_design_3_wrapper_slider" style="">
    
    <div class="places_wrapper  places_wrapper_no_shadow " data-link="<?php echo esc_url($term_link);?>">
        <div class="listing-hover-gradient">
        </div>
        
        <div class="listing-hover" >
        </div>
        
        <div class="places_height <?php echo esc_attr('places'.$place_per_row);?>" style="background-image:url(<?php echo esc_url($category_featured_image_url);?>)">
        </div>
        
    </div>



    <div class="category_name">
        <a class="featured_listing_title" href="<?php echo esc_attr($term_link);?>">
            <?php echo esc_html($category_name);?>
        </a>
    </div>
    
    <div class="place_counter">            
        <?php echo sprintf(  _n('%d listing', '%d listings', $category_count, 'wprentals'), $category_count ); ?>        
    </div>


</div>



