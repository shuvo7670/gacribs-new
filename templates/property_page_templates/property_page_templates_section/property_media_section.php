<?php 
if ($listing_page_type==1) { 
?>

    <div class="panel-wrapper imagebody_wrapper">
        <div class="panel-body imagebody imagebody_new property_pictures_wrapper">
            <?php  
            include(locate_template('templates/property_page_templates/property_page_templates_section/property_slider_type1.php'));
            ?>
        </div> 
    </div>
<?php 
    }else if ($listing_page_type==5) { 
        include(locate_template('templates/property_page_templates/property_page_templates_section/masonary_gallery_property_page.php') ); 
    }
?>