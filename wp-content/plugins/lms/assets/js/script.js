jQuery(document).ready(function() {
    //student 
    jQuery('#studenttb').DataTable();
    jQuery('#frmAddStudent').validate({
        submitHandler:function(){
            var poststudentdata = "action=savestudent&param=save_student&" + jQuery('#frmAddStudent').serialize();
            jQuery.post(lmsajaxurl,poststudentdata,function(response){
                //console.log(response);
                var data = jQuery.parseJSON(response);
                if(data.status==1){
                    jQuery("#frmAddStudent")[0].reset();
                    jQuery('#show_image').hide();
                    jQuery.notifyBar({
                        cssClass:"success padding",
                        html:data.message
                    });
                }else if(data.status==2){
                    jQuery.notifyBar({
                        cssClass:"warning padding",
                        html:data.message
                    });
                } 
                else if(data.status==3){
                    jQuery.notifyBar({
                        cssClass:"warning padding",
                        html:data.message
                    });
                } 
                else if(data.status==4){
                    jQuery('email-error').val(data.message);
                }        
            });
        }
    });
    //booktable
    jQuery('#booktb').DataTable();
    //upload pictures
    jQuery('#cover_photo').on('click', function(){
        var cover_photo = wp.media({
            title : 'image for cover photo',
            multiple : false
        }).open().on('select', function(){
            var image = cover_photo.state().get("selection").first();
            var uploaded_image = image.toJSON().url;
            //var filename = image.toJSON().filename;
            jQuery('#show_image').show();
            jQuery('#show_image').html('<img src = "'+ uploaded_image +'" hieght = "100px;" width = "80px;" />');
            jQuery('#image_name').val( uploaded_image );
        });
    });
//addbooks
    jQuery('#frmAddBook').validate({
        submitHandler:function(){
            var postbookdata = "action=savebook&param=save_book&" + jQuery('#frmAddBook').serialize();
            jQuery.post(lmsajaxurl,postbookdata,function(response){
                //console.log(response);
                var data = jQuery.parseJSON(response);
                if(data.status==1){
                    jQuery("#frmAddBook")[0].reset();
                    jQuery('#show_image').hide();
                    jQuery.notifyBar({
                        cssClass:"success padding",
                        html:data.message
                    });
                }else if(data.status==2){
                    jQuery.notifyBar({
                        cssClass:"warning padding",
                        html:data.message
                    });
                }        
            });
        }
    });
    //dynamic cats ...get books on selected category's book list
    jQuery('#scatid').on('change', function(){
        var selected = jQuery('#scatid :selected').val();
        var ajaxurl = jQuery('#ajaxurl').val();
        var books = [];
        var i = 0;
                jQuery.ajax({
                    url: ajaxurl,
                    data: {
                        id:selected,
                        action: 'dynamic_catsid',
                        param: 'dynamic_cats',
                    },
                    dataType: "JSON",
                    success: function(response){
                        //console.log(response); 
                        var data = JSON.parse(JSON.stringify(response));
                        if(data['status'] == 1){ 
                            var booklist = data['list'];
                            var len = booklist.length;
                            for(i = 0; i< len; i++){
                                books += '<option id = "bookid" name="'+ i +'" value="'+booklist[i]['ID']+'"> '+ booklist[i]['name'] +'</option>'; 
                            }
                            jQuery('#sbookid').html(books);
                        }
                        else if(data['status']==0){
                            jQuery.notifyBar({
                                cssClass:"warning padding",
                                html:data.message
                            });
                         }   
                    },
                    error: function (response) {
                        var data = JSON.parse(JSON.stringify(response));
                        if(data['status']==0){
                            jQuery.notifyBar({
                                cssClass:"warning padding",
                                html:data.message
                            });
                        }
                    },
                });
    });
 //returnbooks
jQuery('#frmReturnBook').validate({
    submitHandler:function(){
        var postbookdata = "action=returnbook&param=return_book&" + jQuery('#frmReturnBook').serialize();
        jQuery.post(lmsajaxurl,postbookdata,function(response){
            //console.log(response);
            var data = jQuery.parseJSON(response);
            if(data.status == 1){
                jQuery.notifyBar({
                    cssClass:"success padding",
                    html:data.message
                });
                jQuery("#frmReturnBook")[0].reset();
                setInterval('location.reload()', 2000); 
            }else if(data.status == 2){
                jQuery.notifyBar({
                    cssClass:"warning padding",
                    html:data.message
                });
            }        
        });           
    }
});
//dynamic books ...get books to return for selected user 
jQuery('#userid').on('change', function(){
    var selected = jQuery('#userid :selected').val();
    var ajaxurl = jQuery('#ajaxurl').val();
    var books = [];
    var i = 0;
            jQuery.ajax({
                url: ajaxurl,
                data: {
                    id:selected,
                    action: 'dynamic_booklist',
                    param: 'dynamic_books',
                },
                dataType: "JSON",
                success: function(response){
                    var data =  JSON.parse(JSON.stringify(response));
                         if(data['status']==0){
                            books = '<option id = "returnid" name="" value=""> Select</option>';   
                            jQuery('#sreturnid').html(books);
                            jQuery("#frmReturnBook")[0].reset();
                            jQuery.notifyBar({
                                cssClass:"warning padding",
                                html:data.message
                            });
                         } else{ 
                                var booklist = data['list'];
                                var len = booklist.length;
                                for(i = 0; i< len; i++){
                                    books += '<option id = "returnid" name="'+ i +'" value="'+booklist[i]['ID']+'"> '+ booklist[i]['name'] +'</option>';   
                                }
                                jQuery('#sreturnid').html(books);
                         }  
                    },
                error: function (response) {
                    var data = JSON.parse(JSON.stringify(response));
                    if(data['status']==0){
                        jQuery("#frmReturnBook")[0].reset();
                        setInterval('location.reload()', 2000);
                        jQuery.notifyBar({
                            cssClass:"warning padding",
                            html:data.message
                        });
                    }
                },
             });
});
//save category
    jQuery('#frmAddCat').validate({
        submitHandler:function(){
            var postbookdata = "action=savecat&param=save_cat&" + jQuery('#frmAddCat').serialize();
            jQuery.post(lmsajaxurl,postbookdata,function(response){
                //console.log(response);
                var data = jQuery.parseJSON(response);
                if(data.status==1){
                    jQuery.notifyBar({
                        cssClass:"success padding",
                        html:data.message
                    });
                    jQuery("#frmAddCat")[0].reset();
                }else if(data.status==2){
                    jQuery.notifyBar({
                        cssClass:"warning padding",
                        html:data.message
                    });
                }        
            });
        }
    });
});