<?php 
/*
Template Name: custom_home_page_layout 
*/ 
get_header();
wp_enqueue_style("stackpathstyle", LMS_PLUGIN_URL . "/assets/css/stackpath.bootstrap.min.css", '');
wp_enqueue_script('popper', LMS_PLUGIN_URL . '/assets/js/popper.min.js', '', true);
wp_enqueue_script('stackpathjs', LMS_PLUGIN_URL . '/assets/js/stackpath.bootstrap.min.js', '', true);
?>
<h1 style= "padding-left:120px;">ELibrary</h1>
<hr>
    <?php 
    global $post;
    $page_slug = $post->post_name;
    if($page_slug == "all_books"){
        echo do_shortcode("[book_page]");
       }else  if($page_slug == "issue_book"){
          echo do_shortcode("[issuebook_page]");
       }
       else  if($page_slug == "return_book"){
        echo do_shortcode("[returnbook_page]");
     }
    ?>
<?php
get_footer();
?>
