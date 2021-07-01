<div class="container">
    <div class="row" style="padding-right:5px; padding-top:10px;">
        <div class="panel panel-primary" style="padding-bottom:10px;" >
            <div class="panel-heading">ADD NEW STUDENT</div>
                <div class="panel-body">
                    <form class="form-horizontal" action="javascript:void(0)" id="frmAddStudent">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="lib_card_nm">Libray Card Number:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" required id="lib_card_nm" name= "lib_card_nm" placeholder="Libray Card Number" value = "<?php echo "NS".uniqid(); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" required id="email" name= "email" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="pwd">Password:</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" required id="password"  name= "password" placeholder="Enter password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address">Address:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="address"  name= "address"  placeholder="Enter Address"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="branch">Select Branch:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="s  branch" name="sbranch" required>  
                                    <option name="branch" value="">Select</option>
                                    <option name="branch" value="1">IT</option>  
                                    <option name="branch" value="2">ARTS</option>  
                                    <option name="branch" value="3">MANAGEMENT</option>  
                                    <option name="branch" value="4">SCIENCE</option>  
                                </select> 
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id= "submitstd" class="btn btn-default">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>    
    </div>
</div>

