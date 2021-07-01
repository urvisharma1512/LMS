<?php
global $wpdb;
$all_students = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM `" . students_table_name() . "` ORDER by ID DESC", ""), ARRAY_A);
?>
<div class="container">
    <div class="row" style="padding-right:5px; padding-top:10px;">
        <div class="panel panel-primary" >
            <div class="panel-heading">VIEW STUDENTS LIST</div>
            <div class="panel-body">
                <table id="studenttb" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>Name</th>
                            <th>Library Card Num</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? $i=1; 
                    foreach($all_students as $key => $student){
                        $userid = $student['userid'];
                        $users = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `wp_users` WHERE ID = $userid "," "), ARRAY_A);     
                    ?>
                        <tr>
                            <td><? echo $i++;?></td>
                            <td><? foreach($users as $user){ echo $user['user_login'];}?></td>
                            <td><? echo $student['library_card_nm'];?></td>
                            <td><? foreach($users as $user){ echo $user['user_email'];}?></td>
                            <td><? echo $student['branch'];?></td>
                            <td><? echo $student['address'];?></td>
                            <td>
                                <a class="btn btn-info" href="javascript : void(0)" >Edit</a>
                                <a class="btn btn-danger" href="javascript : void(0)">Delete</a>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sno</th>
                            <th>Name</th>
                            <th>Library Card Num</th>
                            <th>Email</th>
                            <th>Branch</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
    </div>
</div>