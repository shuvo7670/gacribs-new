<div class="listing_type_title_wrapper">
    <h1 itemprop="name" class="entry-title entry-prop"><?php the_title(); ?></h1>     
                    

    <?php
    if($listing_page_type==5){
        include(locate_template('templates/property_page_templates/property_page_templates_section/property_price_simple.php'));
    }
   
   
    print wprentals_return_property_ratiings_v1($post->ID);
   
    if(trim($property_area)!=''){
        $property_area=', '.$property_area;
    }
    ?>

    <div class="listing_main_image_location" itemprop="location" itemscope itemtype="http://schema.org/Place">
        <?php print  wp_kses_post($property_city.$property_area); ?>     
        <div  class="schema_div_noshow" itemprop="name"><?php echo strip_tags (  $property_city.', '.$property_area); ?></div>
    </div>   

</div>   