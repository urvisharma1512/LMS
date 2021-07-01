<?php
global $wpdb;
$reports = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM `" . issued_books_table_name() . "` ORDER by ID DESC", ""), ARRAY_A);
//print_r($all_books); 
?>
<div class="container">
    <div class="row" style="padding-right:5px; padding-top:10px;">
        <div class="panel panel-primary" >
            <div class="panel-heading">VIEW ISSUED BOOKS LIST</div>
            <div class="panel-body">
                <table id="ibtb" class="display" style="width:100%">
                <thead>
                        <tr>
                            <th>Sno</th>
                            <th>User Name</th>
                            <th>Book Name</th>
                            <th>Issue for (days)</th>
                            <th> Return Date</th>
                            <th>Charges</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? 
                    $i=1; 
                    foreach($reports as $key => $report){
                        $userid = $report['userid'];
                        $bookid = $report['bookid'];
                        $username = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `wp_users` WHERE ID = $userid "," "), ARRAY_A);     
                        $bookname = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . books_table_name() . "` WHERE ID = $bookid "," "), ARRAY_A);     
                    ?>
                        <tr>
                            <td><? echo $i++;?></td>
                            <td><? foreach($username as $name){ echo $name['user_login'];}?></td>
                            <td><? foreach($bookname as $book){ echo $book['name'];}?></td>
                            <td><? echo $report['total_days'];?></td>
                            <td><? echo $report['last_date'];?></td>
                            <td><? echo $report['charges'];?></td>
                        </tr>
                    <?}?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Sno</th>
                            <th>User Name</th>
                            <th>Book Name</th>
                            <th>Issue for (days)</th>
                            <th> Return Date</th>
                            <th>Charges</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
    </div>
</div>