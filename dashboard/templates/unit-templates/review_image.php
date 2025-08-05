<div class="blog_listing_image ">
     <a href="<?php print esc_url ( get_permalink($propertyId) );?>">
         <?php if (has_post_thumbnail($propertyId)){?>
         <img  src="<?php  print esc_url($preview[0]); ?>"  class="img-responsive dashboad-prop-img" alt="<?php esc_html_e('image','wprentals');?>"/>
         <?php
         }else{
             $thumb_prop_default =  get_stylesheet_directory_uri().'/img/defaultimage_prop.jpg';
             ?>
             <img  src="<?php  print esc_url($thumb_prop_default); ?>"  class="img-responsive" alt="<?php esc_html_e('image','wprentals');?>" />
         <?php }?>
     </a>
</div>
