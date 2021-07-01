<?
global $wpdb, $user_ID;
$all_cats = $wpdb->get_results($wpdb->prepare("SELECT * FROM `" . cats_table_name() . "` ORDER by ID DESC", ""), ARRAY_A);
$all_books = $wpdb->get_results($wpdb->prepare("SELECT * FROM `" . books_table_name() . "` ORDER by ID DESC", ""), ARRAY_A);
$Fiction = $wpdb->get_results($wpdb->prepare("SELECT * FROM `" . cats_table_name() . "` WHERE name = 'Fiction' ORDER by ID DESC", ""), ARRAY_A);
echo '<h2 style= "padding-left:120px;">Book List</h2>
      <div class="container">
      <div class="row">';
      foreach($all_books as $key=>$book){ 
      $img = $book['cover_photo'];    
      echo '<div class="col-sm-4" style= "padding-bottom:20px;">
      <div class="card" style="width: 18rem;">
          <img src="'. $img .'" class="card-img-top" alt="'.$img .'">
          <div class="card-body">
            <h5 class="card-title">'. $book['name'] .'by'. $book['author'].'</h5>
            <input type = "hidden" id= "issueid" value=" '.$$book['ID'].'">
            <p class="card-text">'. $book['details'].'</p>';
            if($book['status']=='1'){
              echo '<a id = "issued"  class="btn btn-danger issued" disabled = true href="#" a> Issued </a>';
            } if($book['status']=='0'){
              echo '<a id = "issue"  class="btn btn-primary issue" href="';
              if($user_ID){ 
                 echo site_url()."/issue_book";
              }else{
                echo wp_login_url();
              }
              echo '">';
              if($user_ID){ 
               echo 'Issue';
              }else{
                echo 'Login To Issue';
              } 
              echo '</a>';
            }
          echo '</div>
      </div>
      </div>';
      }
  echo '</div>
</div>';     
?>