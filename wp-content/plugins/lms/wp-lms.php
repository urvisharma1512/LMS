<?php
/*
  * Plugin Name: LMS
  * Plugin URI: http://LMS.com/
  * Description: This is custom plugin is for library management
  * Version: 1.0
  * Author: Urvi Sharma
  * Author URI: http://urvi.netsolutions.com/
*/
//DEFINING CONSTANTS for paths and directories 
if (!defined("ABSPATH"))
    exit;
if (!defined("LMS_PLUGIN_DIR_PATH"))
  define("LMS_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
if (!defined("LMS_PLUGIN_URL"))
  define("LMS_PLUGIN_URL", plugins_url() . "/lms");  
//echo 'pluginpath'.LMS_PLUGIN_DIR_PATH.'<br> url path'.LMS_PLUGIN_URL;
function lms_include_assets() {
//styles
  wp_enqueue_style("bootstrap", LMS_PLUGIN_URL . "/assets/css/bootstrap.min.css", '');
  wp_enqueue_style("datatable", LMS_PLUGIN_URL . "/assets/css/datatables.min.css", '');
  wp_enqueue_style("notifybar", LMS_PLUGIN_URL . "/assets/css/jquery.notifyBar.css", '');
  wp_enqueue_style("style", LMS_PLUGIN_URL . "/assets/css/style.css", '');
//scripts
  wp_enqueue_script('jquery');
  wp_enqueue_script('bootstrap.min.js', LMS_PLUGIN_URL . '/assets/js/bootstrap.min.js', '', true);
  wp_enqueue_script('validation.min.js', LMS_PLUGIN_URL . '/assets/js/jquery.validate.min.js', '', true);
  wp_enqueue_script('datatable.min.js', LMS_PLUGIN_URL . '/assets/js/datatables.min.js', '', true);
  wp_enqueue_script('jquery.notifyBar.js', LMS_PLUGIN_URL . '/assets/js/jquery.notifyBar.js', '', true);
  wp_enqueue_script('script.js', LMS_PLUGIN_URL . '/assets/js/script.js', '', true);
  //wp_enqueue_script('jqueryslim', LMS_PLUGIN_URL . '/assets/js/jquery.slim.min.js', '', true);
  
  wp_localize_script("script.js","lmsajaxurl",admin_url("admin-ajax.php"));
  
}
/*****************CREATING MENUS ON INITIALISATION***************** */
add_action("init", "lms_include_assets");
//callback functions to menus and submenus 
function lms_plugin_menus() {
  add_menu_page("LMS", "LMS", "manage_options", "lms-menu", "my_lms_function", "dashicons-book", 30);
  add_submenu_page("lms-menu", "Admin Dashboard", "Admin Dashboard", "manage_options", "admin-dashboard", "admin_dashboard");
  add_submenu_page("lms-menu", "Add Category", "Add Category", "manage_options", "add-new-cat", "add_new_cat");
  add_submenu_page("lms-menu", "Add New Book", "Add New Book", "manage_options", "add-new-book", "add_new_book");
  add_submenu_page("lms-menu", "Issue New Book", "Issue New Book", "manage_options", "issue-new-book", "issue_new_book");
  add_submenu_page("lms-menu", "Add New Student", "Add New Student", "manage_options", "add-new-student", "add_new_student");
  add_submenu_page("lms-menu", "Return Book", "Return Book", "manage_options", "return-book", "return_book");
  add_submenu_page("lms-menu", "View Books", "View Books", "manage_options", "view-all-books", "view_books");
  add_submenu_page("lms-menu", "View Students", "View Students", "manage_options", "view-all-students", "view_students");
  add_submenu_page("lms-menu", "Issue Reports", "Issue Reports", "manage_options", "issue-reports", "issue_reports");
}
add_action("admin_menu", "lms_plugin_menus");
/*****************CALLBACK FOR MENUS***************** */
//callback functions to menus and submenus
function my_lms_function() {
  include_once LMS_PLUGIN_DIR_PATH . "/views/lms-master.php";
}
function admin_dashboard() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/lms-master.php';
}
function add_new_cat() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/add-cat.php';
}
function add_new_book() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/add-book.php';
}
function add_new_student() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/add-student.php';
}
function view_students() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/view-students.php';
}
function view_books() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/view-books.php';
}
function issue_reports() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/issue-reports.php';
}
function issue_new_book() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/issue-new-book.php';
}
function return_book() {
  include_once LMS_PLUGIN_DIR_PATH . '/views/return-book.php';
}
/*****************TABLE NAMES***************** */
//students table name function
function students_table_name() {
  global $wpdb;
  return $wpdb->prefix."student_details";
}
//books table name function
function books_table_name() {
  global $wpdb;
  return $wpdb->prefix."book_details";
}
//books category table name function
function cats_table_name() {
  global $wpdb;
  return $wpdb->prefix."cats";
}
//issue tables name function 
function issued_books_table_name() {
  global $wpdb;
  return $wpdb->prefix."issued_book_details";
}
/*****************CREATE ON ACTIVATION***************** */
//creating table query 
function create_tables_pages_data() {
  global $wpdb, $usertb;
  $usertb = 'wp_users';
  $wpdb->hide_errors();
  $collate = '';
  if ( $wpdb->has_cap( 'collation' ) ) {
    $collate = $wpdb->get_charset_collate();
  }
  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  $queries = array();
    array_push($queries, "CREATE TABLE `" . students_table_name() . "`  (
      `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
      `userid` bigint unsigned NOT NULL,
      `library_card_nm` varchar(20) NOT NULL,
      `address` varchar(50) DEFAULT NULL,
      `branch` enum('1','2','3','4') NOT NULL DEFAULT '1'  COMMENT '''1:IT'',''2:Arts'',''3:Management'',''4:Science''',
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      UNIQUE KEY `library_card_nm` (`library_card_nm`),
      KEY `userid` (`userid`),
      CONSTRAINT `fk_user_id` FOREIGN KEY (`userid`) REFERENCES `wp_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
    ) {$collate}");
    array_push($queries, "CREATE TABLE `" . cats_table_name() . "` (
      `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
      `name` varchar(15) NOT NULL,
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) {$collate}");
    array_push($queries, "CREATE TABLE `" . books_table_name() . "` (
      `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
      `catid` bigint unsigned NOT NULL,
      `name` varchar(15) NOT NULL,
      `author` varchar(30) NOT NULL,
      `publisher` varchar(30) NOT NULL,
      `language` enum('1','2','3') NOT NULL DEFAULT '1' COMMENT '''1:English'',''2:Hindi'',''3:Other''',
      `details` varchar(150) NOT NULL,
      `price` float(6,2) NOT NULL,
      `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '''1:Issued'',''0:Not issued''',
      `cover_photo` varchar(250) NOT NULL,
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`),
      KEY `catid` (`catid`),
      CONSTRAINT `fk_catid` FOREIGN KEY (`catid`) REFERENCES `wp_cats` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
    ) {$collate}");
     array_push($queries, " CREATE TABLE `" . issued_books_table_name() . "`  (
      `ID` bigint unsigned NOT NULL AUTO_INCREMENT,
      `userid` bigint unsigned NOT NULL,
      `bookid` bigint unsigned NOT NULL,
      `last_date` date NOT NULL,
      `total_days` varchar(5) COLLATE utf8mb4_unicode_520_ci NOT NULL,
      `charges` float(6,2) NOT NULL,
      `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '''1:issued'',''0: Returned''',
      `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`ID`),
      KEY `bookid` (`bookid`),
      KEY `userid` (`userid`),
      CONSTRAINT `fk_bookid` FOREIGN KEY (`bookid`) REFERENCES `wp_book_details` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
      CONSTRAINT `fk_user_id_for_issued_books` FOREIGN KEY (`userid`) REFERENCES `wp_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
    ) {$collate}");
    // print_r($queries); die();
      foreach ($queries as $key => $sql) {
          dbDelta( $sql );
      } 
      //Create New Role
      add_role("wp_lms_user_key","Student",array(
        "read" => true,
      )); 
      //create pages on activation 
      //home page
      $book_post = array(
        'post_title'      => 'Book Page',
        'post_content'    =>  "[book_page]",
        'post_status'     =>  'publish',
        'post_type'       =>  'page',
        'post_name'       =>  'all_books'
      );
      //issue book
      $issuebook_post = array(
        'post_title'      => 'Issue Book Page',
        'post_content'    =>  "[issuebook_page]",
        'post_status'     =>  'publish',
        'post_type'       =>  'page',
        'post_name'       =>  'issue_book'
      );
      //return book
      $returnbook_post = array(
        'post_title'      => 'Return Book Page',
        'post_content'    =>  "[returnbook_page]",
        'post_status'     =>  'publish',
        'post_type'       =>  'page',
        'post_name'       =>  'return_book'
      );
      //Insert the post into the database
      $book_id = wp_insert_post( $book_post );
      add_option("all_books_page_id", $book_id );  
      $issuebook_id = wp_insert_post( $issuebook_post );
      add_option("issue_book_page_id", $issuebook_id );
      $returnbook_id = wp_insert_post( $returnbook_post );
      add_option("return_book_page_id", $returnbook_id );  
}
/*****************DROP ON DEACTIVATION***************** */
register_activation_hook(__FILE__, "create_tables_pages_data");
//drop tables and pages if exits
function drop_tables_pages_plugin_alltables() {
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS " . students_table_name());
    $wpdb->query("DROP TABLE IF EXISTS " . issued_books_table_name());
    $wpdb->query("DROP TABLE IF EXISTS " . books_table_name());
    $wpdb->query("DROP TABLE IF EXISTS " . cats_table_name());
    //delete id from option table for book list page
    if(!empty(get_option("all_books_page_id"))){
      $page_id = get_option("all_books_page_id");
      wp_delete_post($page_id,true); //wp_posts
      delete_option("all_books_page_id");//wp_options
    }
    //delete id from option table for issue book page
    if(!empty(get_option("issue_book_page_id"))){
      $page_id = get_option("issue_book_page_id");
      wp_delete_post($page_id,true); //wp_posts
      delete_option("issue_book_page_id");//wp_options
    }
    //delete id from option table for return book page
    if(!empty(get_option("return_book_page_id"))){
      $page_id = get_option("return_book_page_id");
      wp_delete_post($page_id,true); //wp_posts
      delete_option("return_book_page_id");//wp_options
    }
  }
register_deactivation_hook(__FILE__, "drop_tables_pages_plugin_alltables");
/*****************QUERIES FOR DATABASE AND AJAX CALLS ***************** */
//posting data to database for saving student details 
add_action("wp_ajax_savestudent", "add_student_ajax_handler");
function add_student_ajax_handler(){
  global $wpdb;
  if($_REQUEST['param'] == 'save_student'){
      // save data to db table 
      $user_id = username_exists( $_REQUEST['name'] );
      if ( !$user_id && false == email_exists( $_REQUEST['email'] )) {
        $user_id = wp_create_user($_REQUEST['name'],$_REQUEST['password'],$_REQUEST['email']); 
        $user = new WP_User($user_id);
        $user->set_role("wp_lms_user_key");
        $wpdb->insert(students_table_name(), array(
          "userid"              => $user_id,
          "address"             => $_POST['address'],
          "branch"              => $_POST['sbranch'],
          "library_card_nm"     => $_POST['lib_card_nm'],                            
        ));
        //echo  json_encode($wpdb->last_query);
        echo json_encode( array("status" => 1,"message" => "Saved successfully"));
      }else{
        echo json_encode( array("status" => 2,"message" => "Please Check The Values!"));
      }
  }
  wp_die();  
}
//posting data to database for saving books
add_action("wp_ajax_savebook", "add_book_ajax_handler");
function add_book_ajax_handler(){
  global $wpdb;
  if($_REQUEST['param'] == 'save_book'){
      // save data to db table                                //echo  json_encode($wpdb->last_query);
      $savebook = $wpdb->insert(books_table_name(), array(
      "name"           => $_POST['bookname'],
      "catid"          => $_POST['scatid'],
      "author"         => $_POST['author'],
      "publisher"      => $_POST['publisher'],
      "language"       => $_POST['slanguage'],
      "details"        => $_POST['details'],
      "price"          => $_POST['price'],
      "cover_photo"    => $_POST['image_name'],
    )); 
    if($savebook){
      echo json_encode( array("status" => 1,"message" => "Book details saved successfully"));
    }else{
      echo json_encode( array("status" => 2,"message" =>"Please Check The Values! !"));
    }
  }
  wp_die();  
}
//add cats 
add_action("wp_ajax_savecat", "add_cat_ajax_handler");
function add_cat_ajax_handler(){
  global $wpdb;
  if($_REQUEST['param'] == 'save_cat'){
      // save data to db table
      $savecat = $wpdb->insert(cats_table_name(), array(
      "name"           => $_POST['catname'],
    ));
    if($savecat){
      echo json_encode( array("status" => 1,"message" => "Category Saved !"));
    }else{
      echo json_encode( array("status" => 2,"message" =>"Please Check The Values! !"));
    }
  }
  wp_die();  
}
//dynamic dropdown for issue book
add_action("wp_ajax_dynamic_catsid", "add_dynamicdd_ajax_handler");
function add_dynamicdd_ajax_handler(){
  global $wpdb;
  if($_REQUEST['param'] == 'dynamic_cats'){
    $catid = $_REQUEST['id'];
    if($catid){
      $books = $wpdb->get_results( "SELECT * FROM `" . books_table_name() . "` WHERE catid =  $catid AND status = 0");
      if($books != null){
        echo json_encode( array("status" => 1, "list" =>$books));
      }
    }else{
      echo json_encode( array("status" => 0,"message" =>"Please Select the Category !" ));
    }
  }
  wp_die();  
}
//issue book 
add_action("wp_ajax_issuebook", "issue_book_ajax_handler");
function issue_book_ajax_handler(){
  global $wpdb;
  if($_REQUEST['param'] == 'issue_book'){
      // save data to db table
    $bookid = $_POST['sbookid'];
    $books = $wpdb->get_results( "SELECT * FROM `" . books_table_name() . "` WHERE status = 1 AND ID = $bookid");
    if($books == null){
      $issuebook = $wpdb->insert(issued_books_table_name(), array(
        "userid"           => $_POST['userid'],
        "bookid"           => $_POST['sbookid'],
        "last_date"        => $_POST['secondDate'],
        "total_days"       => $_POST['days'],
        "charges"          => $_POST['ibcharges'],
      )); 
      if($issuebook){
        $wpdb->query($wpdb->prepare("UPDATE `" . books_table_name() . "`SET status = 1 WHERE ID = $bookid"));
        echo json_encode( array("status" => 1,"message" => "Book Issued!"));
      }else{
        echo json_encode( array("status" => 2,"message" =>"Please Check The Values! !"));
      }
    }else{
      echo json_encode( array("status" => 3,"message" =>"Try Again"));
    }
  }
  wp_die();  
}
//return book 
add_action("wp_ajax_returnbook", "return_book_ajax_handler");
function return_book_ajax_handler(){
  global $wpdb;
  if($_REQUEST['param'] == 'return_book'){
    $bookid = $_POST['sreturnid']; 
    if($bookid){
      $wpdb->query($wpdb->prepare("UPDATE `" . books_table_name() . "`SET status=0 WHERE ID=$bookid"));
      $wpdb->query($wpdb->prepare("UPDATE `" . issued_books_table_name() . "`SET status=0 WHERE bookid=$bookid"));
      echo json_encode( array("status" => 1,"message" => "Book Returned!"));
    }else{
      echo json_encode( array("status" => 2,"message" =>"Please Check The Values! !"));
    }
  }
  wp_die();  
}
//dynamic dropdown for return book
add_action("wp_ajax_dynamic_booklist", "add_booklist_ajax_handler");
function add_booklist_ajax_handler(){
  global $wpdb;
  $books = array();
  if($_REQUEST['param'] == 'dynamic_books'){
    $userid = $_REQUEST['id'];
    if($userid){
      $results = $wpdb->get_results( "SELECT * FROM `" . issued_books_table_name() . "` WHERE userid =  $userid AND status = 1");
      foreach($results as $value){
        $bookid = $value->bookid;  
        $books =  $wpdb->get_results( "SELECT * FROM `" . books_table_name() . "` WHERE ID = $bookid ");
      }
      if($books != null){
        echo json_encode( array ("list" => $books));
      }else{
        echo json_encode( array("status" => 0,"message" =>"No book issued by this user" ));
      }
    }else{
      echo json_encode( array("status" => 0,"message" =>"No book issued by this user" ));
    }
  }
  wp_die();  
}
/************Front-End TEMPLATE AND SHORT CODE************ */
//adding short code for all book list 
function issuebook_page_function(){
  include_once LMS_PLUGIN_DIR_PATH . '/views/issue-new-book.php';
}
add_shortcode("issuebook_page","issuebook_page_function");
//adding short code for all issue book page 
function all_books_page_function(){
   include_once LMS_PLUGIN_DIR_PATH . '/views/Frontend/home.php';  
}
add_shortcode("book_page","all_books_page_function");
//adding short code for return book
function return_book_page_function(){
  include_once LMS_PLUGIN_DIR_PATH . '/views/return-book.php';  
}
add_shortcode("returnbook_page","return_book_page_function");
//filters for booklisting page template 
function custom_home_page_layout($page_template){
  global $post;
  $page_slug = $post->post_name;
  if($page_slug == "all_books" || "issue_book"|| "return_book"){
    $page_template = LMS_PLUGIN_DIR_PATH . '/views/Frontend/Template/master.php';
  }
  return $page_template;
}
add_filter("page_template","custom_home_page_layout");
/*********** REDIRECTING TO LOGIN PAGE************ */
//login redirect 
function lms_login_user_role_filter($redirect_to,$request,$user){
  global $user;
  if(isset($user->roles) && is_array($user->roles)){
    if(in_array("wp_lms_user_key",$user->roles)){
      return $redirect_to = site_url()."/all_books";
    }else{
      return $redirect_to;
    } 
  }
}
add_filter("login_redirect","lms_login_user_role_filter",10,3);
//logout redirect
function lms_logout_user_role_filter(){
 wp_redirect(site_url()."/all_books");
 exit();
}
add_filter("wp_logout","lms_logout_user_role_filter");