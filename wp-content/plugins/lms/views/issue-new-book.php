<?php
 wp_enqueue_style("bootstrap-datepicker", LMS_PLUGIN_URL . "/assets/css/bootstrap-datepicker.min.css", '');
 wp_enqueue_script('datepicker', LMS_PLUGIN_URL . '/assets/js/datepicker.js', '', true);
 wp_enqueue_script('bootstrap-datepicker', LMS_PLUGIN_URL . '/assets/js/bootstrap-datepicker.min.js', '', true);
global $wpdb, $user_ID;
if($user_ID){
    $cardnum =  $wpdb->get_var( "SELECT library_card_nm FROM `" . students_table_name() . "` WHERE userid =  $user_ID ");
    $username =  $wpdb->get_var( "SELECT user_login FROM wp_users WHERE ID =  $user_ID ");
}    
?>
<div class="container">
    <div class="row" style="padding-right:5px; padding-top:10px;">
        <div class="panel panel-primary"  >
            <div class="panel-heading">ISSUE NEW BOOK</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="javascript:void(0)" id="frmIssueBook">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Student Name:</label>
                            <?php if($user_ID != 1){
                            echo   '<div class="col-sm-6">
                                        <input type="text" readonly class="form-control" id="ibname" value = "'. $username.'" >
                                        <input type="hidden" class="form-control" id="userid" name= "userid" value = "'.$user_ID.'" >
                                    </div> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="iblib_card_nm">Library Card Number:</label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly class="form-control"  id="iblib_card_nm" value = "'. $cardnum.'">
                                    </div>
                                </div>';
                            }else{
                                $users = $wpdb->get_results( "SELECT * FROM `" . students_table_name() . "`");
                                echo '<div class="col-sm-6">
                                    <select class="form-control" id="userid" name="userid" required selected>  
                                        <option name="suserid" value="" selected>Select</option>';
                                        foreach($users as $user){
                                            $userid = $user->userid;
                                            $prepared_statement = $wpdb->prepare( "SELECT user_login FROM `wp_users` WHERE ID = $userid" );
                                            $username = $wpdb->get_var( $prepared_statement ); 
                                            echo '<option name="suserid" value="'.$userid.'">'. $username .'</option>';
                                        }
                                echo '</select></div></div>';
                            }
                            ?>    
                        <?php global $wpdb;
                            $prepared_statement = $wpdb->prepare( "SELECT DISTINCT catid FROM `" . books_table_name() . "` WHERE status = 0" );
                            $avail_cats = $wpdb->get_col( $prepared_statement ); 
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="catid">Select Category:</label>
                            <div class="col-sm-6">
                                <select class="form-control" id="scatid" name="scatid" required selected>  
                                <option name="catid" value="" selected>Select</option>
                                    <? 
                                    foreach($avail_cats as $key =>$cats ){ 
                                        $results = $wpdb->get_results( "SELECT * FROM `" . cats_table_name() . "` WHERE ID = $cats ");                                   
                                        foreach($results as $cats ){ ?> 
                                            <option name="catid" value="<?php echo $cats->ID; ?>"><?php echo $cats->name;?></option>
                                      <?} 
                                    }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="bookid"> Select Book: </label>
                            <div class="col-sm-6">
                                <select class="form-control" id="sbookid" name="sbookid" required selected>  
                                    <option name="bookid" value="">Select</option>    
                                </select> 
                                <span id= "nobooks" style = "color:blue;"> Info: these are list of books available for issue.</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-2" for="fromdate"> From Date: </label>
                            <div class="col-xs-2">
                                <input type="text" class="form-control" id="firstDate" name="firstDate"/>
                            </div>
                            <label class="control-label col-xs-2" for="todate"> To Date:</label>
                            <div class="col-xs-2">
                                <input type="text" class="form-control" id="secondDate" name="secondDate"/>
                            </div>
                        
                            <label class="control-label col-xs-1" for="days"> Days: </label>
                            <div class="col-xs-2">
                                <input type="text" class="form-control" readonly id="days" name="days" value="1"/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="charges">Charges(Rs):</label>
                            <div class="col-sm-3">
                                <input type="text" readonly class="form-control" id="ibcharges" name="ibcharges" value="">
                            </div>
                        </div>
                        </div>
                        <input type="hidden" name="ajaxurl" id="ajaxurl" value = "<?php echo admin_url('admin-ajax.php'); ?>">
                        <div class="form-group row">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id= "issuebook" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>    
    </div>
</div>

