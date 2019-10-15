var grid_report11;
var data_report11 = [];

function initiate_report11()
{
    add_section("content_report11","data_report11","refresh_report11()","hbtn_report11","grid_report11");
    $("#content_report11").html('<div id="content_report11_div" style="margin:3px; width:99%;"></div>');
    get_content_report11();
    create_report11_event();
    create_dlg_report11_search();  
    //create_dlg_report11_listing();
}

function get_content_report11()
{             
    var obj_post = $.post(uri_report11,{},function(data) {
        $("#content_report11_div").html(data);
    });
    obj_post.done(function(msg) { 
        
    });
}

function refresh_report11()
{
    
    /*data_report11.length=0;
    grid_report11.invalidateAllRows();
    grid_report11.updateRowCount();
    grid_report11.render();
    */
}

function create_report11_event()
{
    $("#hbtn_report11_search").click(function(){ 
        open_dlg_report11_search();
    });
    $("#hbtn_report11_save").click(function(){
        if(trim($("#dlgReport11Search_client_code").val())!='')
            window.open(uri_dlg_report11_save+$("#dlgReport11Search_client_code").val()+'/'+$("#dlgReport11Search_th").val()+'/'+$("#dlgReport11Search_sdate").val()+'/'+$("#dlgReport11Search_edate").val()+'/'+$("#dlgReport11Search_type").val(),"_blank");
    });
   /* grid_report11.onDblClick.subscribe(function(e) {     
        var cell = grid_report11.getCellFromEvent(e);
        window.open(uri+"index.php/docim/open_doc/"+data_report11[cell.row].doc_id+data_report11[cell.row].md5_file_name+'.pdf',"_blank");
        //    open_dlg_report11(data_report11[cell.row].client_id);
    });
    
    $("#hbtn_report11_listing").click(function(){                  
        open_dlg_report11_listing();
    });*/
}
