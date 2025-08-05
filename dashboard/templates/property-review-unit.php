<?php
$propertyId =   $comment->comment_post_ID;
$preview    =   wp_get_attachment_image_src(get_post_thumbnail_id($propertyId), 'wpestate_slider_thumb');
     
?>

<div class="col-md-12 dasboard-prop-listing dashboard-review-listing-wrapper">
    <div class="col-md-8 wpestate-dashboard-review-content">
        <?php   include(locate_template('dashboard/templates/unit-templates/review_title_section.php') );  ?>
        <?php   include(locate_template('dashboard/templates/unit-templates/review-dashboard-content.php') );  ?>
    </div>
</div>