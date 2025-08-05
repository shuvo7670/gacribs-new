<?php
$userId         =   $comment->user_id;
         
if($userId == 1){
    $reviewer_name="admin";
    $userid_agent   =   get_user_meta($userId, 'user_agent_id', true);
}else{
    $userid_agent   =   get_user_meta($userId, 'user_agent_id', true);
    $reviewer_name  =   get_sanitized_truncated_title($userid_agent, 0);
    if($userid_agent==''){
        $reviewer_name=   $comment->comment_author;
    }
    
}

if($userid_agent==''){
    $user_small_picture_id     =    get_the_author_meta( 'small_custom_picture' ,  $comment->user_id,true  );
    $preview                   =    wp_get_attachment_image_src($user_small_picture_id,'wpestate_user_thumb');
    $preview_img               =    '';
    if(isset($preview[0])){
        $preview_img               =    $preview[0];
    }
  
}else{
    $thumb_id           = get_post_thumbnail_id($userid_agent);
    $preview            = wp_get_attachment_image_src($thumb_id, 'thumbnail');
    $preview_img               =    '';
    if(isset($preview[0])){
        $preview_img               =    $preview[0];
    }
}

if($preview_img==''){
       $preview_img    =   get_stylesheet_directory_uri().'/img/default-user.png';
}

$rating= get_comment_meta( $comment->comment_ID , 'review_stars', true );
?>


    <div class="reviewer_image"  style="background-image: url(<?php echo esc_url($preview_img);?>);"></div>
    
    <div class="reviwer-name-wrapper">    
        <div class="reviwer-name">
            <?php echo esc_html($reviewer_name);?>
        </div>
        <div class="property_ratings">
            <?php
            print wpestate_display_rating($rating, 'total');
            $total_rating = wpestate_get_star_total_rating($rating);
            ?>
            <span class="ratings-star">( <?php print $total_rating . ' ' . esc_html__( 'of','wprentals').' 5'; ?>)
            </span>
        </div>
    </div>
 
    <div class="review-date">
        <?php echo esc_html__( 'Posted on ','wprentals' ). ' '. get_comment_date('j F Y',$comment->comment_ID);?>
    </div>
    
    
    <div class="review-content">
        <?php print $comment->comment_content;?>       
    </div>

    <?php
    
        $owner_reply = get_comment_meta($comment->comment_ID,'owner_reply',true);   
        ?>

        <div class="wpestate-repy-review-wrapper">
        
            <h4><?php esc_html_e('Your Reply','wprentals');?></h4>
            <div class="wpestate_reply_to_review_message"></div>

            <?php if ( $owner_reply!=''){ ?>
                <div class="wpestate_reply_to_review_content" style="display:block;" ><?php echo esc_html($owner_reply);?></div>
            <?php }else{ ?>
                <div class="wpestate_reply_to_review_content"></div>
                <textarea autocomplete="off" rows="4" class="review_reply_content form-control" placeholder="<?php esc_html_e('type your reply','wprentals');?>"></textarea>
                <span class="mess_send_reply_review_button" data-review-reply-to-id="<?php print intval($comment->comment_ID);?>" data-review-reply-to-propertyid="<?php print intval($propertyId);?>">
                    <?php esc_html_e('Reply to Review','wprentals');?>        
                </span>

            <?php } ?>


        </div>
        <?php

    ?>


   