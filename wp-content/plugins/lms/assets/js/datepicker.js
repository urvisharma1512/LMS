jQuery(document).ready(function() {    
    if(jQuery( "#firstDate" ).datepicker({
        format: 'yyyy-mm-dd',
        startDate: new Date(),
        endDate: '+5D',
    }).datepicker("getDate")!= ''){
        jQuery('#firstDate').on('change', function(){
            showDays();
        }).datepicker("setDate", new Date());
    }
    if(jQuery('#secondDate').datepicker({
        format: 'yyyy-mm-dd',
        startDate:  new Date(),
        endDate: '+5D',
    }).datepicker("getDate")!= ''){
        jQuery('#secondDate').on('change', function(){
            showDays();
        }).datepicker("setDate", new Date());
    }
    //defining the funciton 
    function showDays(){
        var start= jQuery("#firstDate").datepicker("getDate");
        var end= jQuery("#secondDate").datepicker("getDate");
        if(!start || !end || start > end){
            jQuery.notifyBar({
                cssClass:"warning padding",
                html:'Choose Correct Dates'
            });
            return;
        }
        var days = (end- start) / (1000 * 60 * 60 * 24);
        //alert(Math.round(days)); 
        days = Math.round(days + 1);
        jQuery("#days").val(days);
        var charges = 10 * days;
        jQuery("#ibcharges").val(charges+'.00');
    }
    //issuebooks
    jQuery('#ibtb').DataTable();
    jQuery('#frmIssueBook').validate({
        submitHandler:function(){
            var postbookdata = "action=issuebook&param=issue_book&" + jQuery('#frmIssueBook').serialize();
            jQuery.post(lmsajaxurl,postbookdata,function(response){
                //console.log(response);
                var data = jQuery.parseJSON(response);
                if(data.status==1){
                    jQuery.notifyBar({
                        cssClass:"success padding",
                        html:data.message
                    });
                    jQuery("#frmIssueBook")[0].reset();
                    //seting default dates on submit
                    jQuery( "#firstDate" ).datepicker({
                        format: 'yyyy-mm-dd',
                        startDate: new Date(),
                        endDate: '+5D',
                    }).datepicker("setDate", new Date());
                   // var today = new Date();
                    //validating dates on submit 
                    jQuery('#secondDate').datepicker({
                        format: 'yyyy-mm-dd',
                        startDate:  new Date(),
                        endDate: '+10D',
                    }).datepicker("setDate", new Date());
                }else if(data.status==2){
                    jQuery.notifyBar({
                        cssClass:"warning padding",
                        html:data.message
                    });
                }else if(data.status==3){
                    jQuery.notifyBar({
                        cssClass:"warning padding",
                        html:data.message
                    });
                }          
            });           
        }
    });

    
});
//sending selected for issue 
jQuery('#issue').on('click', function(){
    var issueid = jQuery('#issueid').val();
    
});
