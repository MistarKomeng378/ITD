var docim_listing_doing =0;
function get_content_dlg_docim_listing()
{                           
    var obj_post = $.post(uri_dlg_docim_listing,{},function(data) {
    });
    obj_post.done(function(msg) {            
        $("#dialogBox_docim_listing").html(msg);
    });
}
function create_dlg_docim_listing()
{                          
    $("#dialogBox_docim_listing").dialog({ 
            title:        'Listing Scan Dokumen'
        ,    width:        400
        ,    height:        200
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Do Listing": function(){
                 if (docim_listing_doing==0)
                    do_dlg_docim_listing();
             },
             "Tutup": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_docim_listing()
{              
    get_content_dlg_docim_listing();            
    $("#dialogBox_docim_listing").dialog("open");
}
function close_dlg_docim_listing()
{                          
    $("#dialogBox_docim_listing").dialog("close");
}
function do_dlg_docim_listing()
{
    docim_listing_doing=1;
    var trrr = $("input[name=c_dirlist]:checked").map(function () {return this.value;}).get().join(",");
    data_docim.length=0;
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/docim/do_docim_listing", 
        { dir_list:trrr},function(data) {  
    });
    obj_post.done(function(msg){
        var obj_post = $.post(uri_dlg_docim_listing,{},function(data) {
        });
        obj_post.done(function(msg1) {            
            $("#dialogBox_docim_listing").html(msg+msg1);
        });
        state_progress(0);
        docim_listing_doing=0;
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error listing dokumen :" + textStatus);
        state_progress(0);
    });
    
}                                    