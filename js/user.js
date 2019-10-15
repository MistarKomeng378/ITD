var grid_user;
var data_user = [];

function initiate_user()
{
    add_section("tbl_slick_user","data_user","refresh_user_grid()","hbtn_user","grid_user");
    create_user_grid();
    create_user_event();
    create_dlg_user();
    create_dlg_pass();
}

function create_user_grid()
{
    var columns_user = [];
    var options_user = [] ;
    columns_user = [
        {id:"user_id", name:"User ID", field:"user_id"}
        ,{id:"user_name", name:"User Name", field:"user_name",width:320}
        ,{id:"user_lvl_desc", name:"Level", field:"user_lvl_desc"}
        ,{id:"user_unit_desc", name:"Unit", field:"user_unit_desc"}
        ,{id:"user_active_desc", name:"Enabled", field:"user_active_desc"}
        ,{id:"user_lock", name:"Locked", field:"user_lock"}
        
    ];
    options_user = {
        editable: false,
        enableCellNavigation: true,
        asyncEditorLoading: false,
        enableRowNavigation: true,
        autoEdit: false
    };         
    grid_user = new Slick.Grid("#tbl_slick_user", data_user, columns_user, options_user);
    grid_user.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}


function refresh_user_grid()
{
    //state_progress(1);
    //alert(uri+"/index.php/itd/list_user");
    state_progress(1);
    data_user.length=0;
    var obj_post = $.post(uri+"index.php/itd/list_user",{test:"tes"},function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_user[i] = {});
           d["user_id"] = data.r_sdata[i].user_id;
           d["user_name"] = data.r_sdata[i].user_name;
           d["user_lvl"] = data.r_sdata[i].user_lvl;  
           d["user_lvl_desc"] = data.r_sdata[i].lvl_desc;  
           d["user_unit_desc"] = data.r_sdata[i].unit_desc;  
           d["user_active"] = data.r_sdata[i].user_active;
           d["user_active_desc"] = (data.r_sdata[i].user_active==1)?"Enable":"Disable";
           d["user_lock"] = (data.r_sdata[i].user_locked==1)?"Yes":"No";
        }
    },"json");
    obj_post.done(function(msg){
        grid_user.invalidateAllRows();
        grid_user.updateRowCount();
        grid_user.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_user_event()
{
    if(lvl<=0)
    {           
        $("#hbtn_user_refresh").click(function(){
            refresh_user_grid();
        });
        $("#hbtn_user_new").click(function(){
            open_dlg_user('');
        });
        $("#hbtn_user_reset_pass").click(function(){
            var selected_row_user  = grid_user.getActiveCell();
            if(selected_row_user)
                open_dlg_user_reset_pass(data_user[selected_row_user.row].user_id);
            else
                alert("No data selected!");
        });
        $("#hbtn_user_edit").click(function(){
            var selected_row_user  = grid_user.getActiveCell();     
            if(selected_row_user)
                open_dlg_user(data_user[selected_row_user.row].user_id);
            else
                alert("No data selected!");
        });
    
        $("#hbtn_user_del").click(function(){
            if(confirm('Are u sure to delete this row?'))
            {
                selected_row_user  = grid_user.getActiveCell();
                if(selected_row_user)           
                    delete_user(data_user[selected_row_user.row].user_id);
                else
                    alert("No data selected!");
            }
        });
        grid_user.onDblClick.subscribe(function(e) {     
            var cell = grid_user.getCellFromEvent(e);
            open_dlg_user(data_user[cell.row].user_id);
        });
    }
}
function delete_user(u_id)
{
    state_progress(1);
    data_user.length=0;
    var obj_post = $.post(uri+"index.php/itd_del/d_user",{user_id:u_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        if(msg.r_success)
            alert('Delete success!');
        else
            alert('Delete failed!');
        state_progress(0);
        refresh_user_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
