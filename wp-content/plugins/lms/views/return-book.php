<?php
global $wpdb, $user_ID;
if($user_ID){
    $cardnum =  $wpdb->get_var( "SELECT library_card_nm FROM `" . students_table_name() . "` WHERE userid =  $user_ID ");
    $username =  $wpdb->get_var( "SELECT user_login FROM wp_users WHERE ID =  $user_ID ");
} 
?>
<div class="container">
    <div class="row" style="padding:10px;">
        <div class="panel panel-primary" style="padding-bottom:30px;">
            <div class="panel-heading">Return Book Form</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="javascript:void(0)" id="frmReturnBook">
                    <div class="form-group">
                    <? if($user_ID !=1){
                            echo '<label class="control-label col-sm-2" for="name">Student Name:</label>'; }else{
                                echo '<label class="control-label col-sm-2" for="name">Admin:</label>'; 
                            }?>
                            <div class="col-sm-6">
                                <input type="text" readonly class="form-control" id="ibname" value = "<?php echo $username; ?>" >
                                <input type="hidden" class="form-control" id="userid" name= "userid" value = "<?php echo $user_ID; ?>" >
                            </div>
                        </div>
                        <? if($user_ID !=1){
                        echo  '<div class="form-group">
                                <label class="control-label col-sm-2" for="iblib_card_nm">Library Card Number:</label>
                                <div class="col-sm-6">
                                    <input type="text" readonly class="form-control"  id="iblib_card_nm" value = "' .$cardnum. '">
                                </div>
                            </div>';
                            $results =$wpdb->get_results( "SELECT * FROM `" . issued_books_table_name() . "` WHERE status = 1 AND userid = $user_ID ");
                        }else{
                            $results =$wpdb->get_results( "SELECT * FROM `" . issued_books_table_name() . "` WHERE status = 1");
                        }
                        ?>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="return">Select Book:</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="sreturnid" name="sreturnid" required selected>  
                                    <option name="returnid" value="" selected>Select</option>
                                    <?php 
                                    foreach($results as $book){ 
                                        $bookid = $book->bookid; 
                                        $bookname =  $wpdb->get_var( "SELECT name FROM `" . books_table_name() . "` WHERE ID =  $bookid ");    
                                    ?>
                                        <option name="returnid" value="<?php echo $bookid; ?>"><?php echo $bookname; ?></option>
                                    <? } ?>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id= "returnbook" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>    
    </div>
</div>
