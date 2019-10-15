var grid_subsrdrekon;
var data_subsrdrekon = [];

function initiate_subsrdrekon()
{
    add_section("content_subsrdrekon","data_subsrdrekon","refresh_subsrdrekon()","hbtn_subsrdrekon","grid_subsrdrekon");
    get_content_subsrdrekon(); 
    //create_subsrdrekon_event();
    //create_dlg_subsrdrekon_search();  
    //create_dlg_subsrdrekon_listing();
}
function get_content_subsrdrekon()
{             
    var obj_post = $.post(uri_subsrdrekon,{},function(data) {
        $("#content_subsrdrekon").html(data);
    });
    obj_post.done(function(msg) { 
        create_subsrdrekon_event();
       /* create_subsrd_grid(); 
        create_dpicker_subsrd();
        create_subsrd_event();
        subsrd_dlg1_create();
        $("#i_subsrd_client_dt").val(saiki);*/
        //get_content_user_subsrd();
        
        
    });
}

function refresh_subsrdrekon()
{
    $("#content_subsrdrekon").html('');
    $("#hbtn_subsrdrekon_dt").val(saiki);
    $("#hbtn_subsrdrekon_type").val(0);
    
}

function create_subsrdrekon_event()
{
    $("#hbtn_subsrdrekon_view").click(function(){ 
        view_subsrdrekon();
    });
}


function view_subsrdrekon()
{
    state_progress(1); 
    var obj_post = $.post(uri_subsrdrekon+'/view',{q:$("#hbtn_subsrdrekon_dt").val(),t:$("#hbtn_subsrdrekon_type").val()},function(data) {
        $("#content_subsrdrekon").html(data);
        state_progress(0); 
    });    
    obj_post.fail(function(jqXHR, textStatus) {    
         $("#content_subsrdrekon").html(''); 
        state_progress(0);
    });
}