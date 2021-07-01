<?php
global $wpdb;
$all_books = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM `" . books_table_name() . "` ORDER by ID DESC", ""), ARRAY_A);
?>
<div class="container">
    <div class="row" style="padding-right:5px; padding-top:10px;">
        <div class="panel panel-primary" >
            <div class="panel-heading">VIEW BOOKS LIST</div>
            <div class="panel-body">
                <table id="booktb" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>Book Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Price</th>
                            <th>Details</th>
                            <th>Cover Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <? $i=1; 
                    foreach($all_books as $key => $book){
                        $catid = $book['catid'];
                        $cats = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `" . cats_table_name() . "` WHERE ID = $catid "," "), ARRAY_A);     
                    ?>
                        <tr>
                            <td><? echo $i++;?></td>
                            <td><? echo $book['name'];?></td>
                            <td><? foreach($cats as $cat){ echo $cat['name'];}?></td>
                            <td><? echo $book['author'];?></td>
                            <td><? echo $book['publisher'];?></td>
                            <td><? echo $book['price'];?></td>
                            <td><? echo $book['details'];?></td>
                            <td><img src = "<? echo $book['cover_photo']?>" hieght = "50px;" width = "50px;"/></td>
                            <td>
                                <a class="btn btn-info" href="javascript : void(0)" >Edit</a>
                                <a class="btn btn-danger" href="javascript : void(0)">Delete</a>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>BOOK Name</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Price</th>
                            <th>Details</th>
                            <th>Cover Photo</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>   
    </div>
</div>
