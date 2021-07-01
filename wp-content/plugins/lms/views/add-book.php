<?php   wp_enqueue_media(); ?>
<div class="container">
    <div class="row" style="padding:10px;">
        <div class="panel panel-primary" style="padding-bottom:30px;">
            <div class="panel-heading">ADD NEW BOOK</div>
                <div class="panel-body">
                    <form class="form-horizontal" method = "POST" action="javascript:void(0)" id="frmAddBook" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="bookname" id="bookname" required placeholder="Enter Name">
                            </div>
                        </div>
                        <?php global $wpdb;
                            $results = $wpdb->get_results(  "SELECT * FROM `" . cats_table_name() . "` "); 
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="catid">Category:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="scatid" name="scatid" required>  
                                    <option name="catid" value="">Select</option>
                                    <?php foreach($results as $cats){ ?>
                                        <option name="catid" value="<?php echo $cats->ID; ?> "> <?php echo $cats->name; ?></option>;
                                    <?php } ?>  
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="author">Author:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required name="author" id="author" placeholder="Enter Author">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pbl">Publisher:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required name="publisher" id="publisher" placeholder="Enter Publisher">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="language">Language:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="slanguage" name="slanguage" required selected>  
                                    <option name="language" value="">Select</option>
                                    <option name="language" value="1">English</option>  
                                    <option name="language" value="2">Hindi</option>  
                                    <option name="language" value="3">Other</option>  
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="details">Details:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="details"  name= "details"  placeholder="Enter Details"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="price">Price:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" required name="price" id="price" placeholder="Enter Price">  
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="cover_photo">Upload Photo:</label>
                            <div class=" col-sm-10">
                                <input type = "button" id="cover_photo" class="btn btn-info" value="Upload Photo">
                                <span id= "show_image"></span>
                                <input type="hidden" class="form-control" name="image_name" id="image_name" value = "" >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id= "submitbook" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>    
    </div>
</div>