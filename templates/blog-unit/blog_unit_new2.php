<?php
global $wpestate_options;
global $unit_class;
global $row_number;
global $wpestate_row_number_col;
$thumb_id   =   get_post_thumbnail_id($post->ID);
$preview    =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'thumbnail');
$link       =  esc_url(get_permalink());
?>
<div class="col-md-<?php print esc_attr($wpestate_row_number_col);?> blog_unit_wrapper ">
    <div class="blog_unit_back blog-unit-2" data-link="<?php print esc_url($link);?>">
        <?php 
        print wprentals_blog_card_featured_image($post->ID,'wpestate_blog_unit');
          
        ?>
          
        <div class="wprentals-blog-unit-content-wrapper">

            <?php 
            print wprentals_blog_card_title($post->ID,$length='58');
            ?>    
            
            <div class="blog-unit-content">
                <?php print wpestate_strip_words( get_the_excerpt(),25).' ...'; ?>
            </div>
            
            <div class="category_tagline">
                <span class="span_widemeta"> <?php print get_the_date();?></span> , 
                <span class="span_widemeta span_comments"><i class="far fa-comment"></i> <?php comments_number( '0','1','%');?></span>
            </div>           
        </div>
    </div>    
</div>