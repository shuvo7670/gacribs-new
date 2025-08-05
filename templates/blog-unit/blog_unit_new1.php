<?php
global $wpestate_options;
global $unit_class;
global $row_number;
global $wpestate_row_number_col;
global $wpestate_full_row;

$wpestate_row_number_col=12;
$thumb_id   =   get_post_thumbnail_id($post->ID);
$preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
$link       =   esc_url(get_permalink());
$schema_data=   'itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" ';

?>
<div <?php print trim($schema_data);?> class="col-md-<?php print esc_attr($wpestate_row_number_col);?> new_blog blog-unit-1 ">    
    <meta itemprop="position" content="<?php print esc_attr($wpestate_blog_selection->current_post);?>" />       
    <div class="blog_unit_back full_blog blog-unit-1 " data-link="<?php print esc_url($link);?>">
        
        <?php 
            $image_size= 'wpestate_blog_unit2';
            if($wpestate_full_row==1){
                $image_size='wpestate_property_featured';
            }
            print wprentals_blog_card_featured_image($post->ID,$image_size);
        ?>

        <div class="wprentals-blog-unit-content-wrapper">
            <?php 
              print wprentals_blog_card_title($post->ID,$length='58');
            ?>    
            
            <div class="blog-unit-content"> 
                <?php echo  wp_strip_all_tags ( wpestate_the_excerpt_max_charlength(200) );?>
            </div>
            
            <div class="category_tagline">
                <span class="span_widemeta"> <?php print get_the_date();?></span>  
                <span class="span_widemeta"><?php esc_html_e('Category: ','wprentals');the_category(', '); ?></span> 
                <!-- <span class="span_widemeta span_comments"><i class="far fa-comment"></i> <?php //comments_number( '0','1','%');?></span>
                -->
                <span class="span_widemeta span_comments"><?php comments_number( '0','1','%');echo ' ';esc_html_e('Comments','wprentals');?></span>
            </div>
        </div>
    </div>    
</div>