var grid_report1;
var data_report1 = [];

function initiate_report1()
{
    add_section("content_report1","data_report1","refresh_report1()","hbtn_report1","grid_report1");
    $("#content_report1").html('<div id="content_report1_div" style="margin:3px; width:99%;"></div>');
    get_content_report1();
    create_report1_event();
    //create_dlg_report1_search();  
    //create_dlg_report1_listing();
}

function get_content_report1()
{             
    var obj_post = $.post(uri_report1,{},function(data) {
        $("#content_report1_div").html(data);
    });
    obj_post.done(function(msg) { 
        
    });
}

function refresh_report1()
{
    
    /*data_report1.length=0;
    grid_report1.invalidateAllRows();
    grid_report1.updateRowCount();
    grid_report1.render();
    */
}

function create_report1_event()
{
    $("#hbtn_report1_search").click(function(){ 
        open_dlg_report1_search();
    });
        
   /* grid_report1.onDblClick.subscribe(function(e) {     
        var cell = grid_report1.getCellFromEvent(e);
        window.open(uri+"index.php/docim/open_doc/"+data_report1[cell.row].doc_id+data_report1[cell.row].md5_file_name+'.pdf',"_blank");
        //    open_dlg_report1(data_report1[cell.row].client_id);
    });
    
    $("#hbtn_report1_listing").click(function(){                  
        open_dlg_report1_listing();
    });*/
}
