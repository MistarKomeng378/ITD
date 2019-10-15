var grid_client_group;
var data_client_group = [];

function initiate_client_group()
{
    add_section("tbl_slick_client_group","data_client_group","refresh_client_group_grid()","hbtn_client_group","grid_client_group");
    create_client_group_grid(); 
    create_client_group_event();
    create_dlg_client_group();  
    //create_dlg_client_group_search();  
}

function create_client_group_grid()
{
    var columns_client_group = [];
    var options_client_group = [];
    
    columns_client_group = [
        {id:"group_code", name:"Code", field:"group_code"}
        ,{id:"group_name", name:"Name", field:"group_name",width:300}
        ,{id:"group_mail_enable_s", name:"Mail Enable", field:"group_mail_enable_s"} 
        ,{id:"group_mail", name:"Mail", field:"group_mail",width:300}
        ,{id:"group_mail_cc", name:"Mail CC", field:"group_mail_cc",width:300}
    ];
    options_client_group = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_client_group = new Slick.Grid("#tbl_slick_client_group", data_client_group, columns_client_group, options_client_group);
    grid_client_group.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_client_group_grid()
{
    state_progress(1);
    data_client_group.length=0;
    var obj_post = $.post(uri+"index.php/itd/list_client_group",{test:"tes"},function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_client_group[i] = {});
           d["group_code"] = data.r_sdata[i].group_code;
           d["group_name"] = data.r_sdata[i].group_name;
           d["group_mail_enable_s"] = data.r_sdata[i].group_mail_enable==1?'Ya':'Tidak';
           d["group_mail_enable"] = data.r_sdata[i].group_mail_enable;  
           d["group_mail"] = data.r_sdata[i].group_mail;
           d["group_mail_cc"] = data.r_sdata[i].group_mail_cc;
           
        }
    },"json");
    obj_post.done(function(msg){
        grid_client_group.invalidateAllRows();
        grid_client_group.updateRowCount();
        grid_client_group.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_client_group_event()
{
    $("#hbtn_client_group_refresh").click(function(){
        refresh_client_group_grid();
    });
    
    $("#hbtn_client_group_new").click(function(){ 
        open_dlg_client_group('');
    });
    $("#hbtn_client_group_search").click(function(){ 
        open_dlg_client_group_search();
    });
    
    $("#hbtn_client_group_edit").click(function(){
        selected_row_client  = grid_client_group.getActiveCell();
        if(selected_row_client)
            open_dlg_client_group(data_client_group[selected_row_client.row].group_code);
        else
            alert("No data selected!");
    });
    
    grid_client_group.onDblClick.subscribe(function(e) {     
        var cell = grid_client_group.getCellFromEvent(e);
        if(lvl<=5)
            open_dlg_client_group(data_client_group[cell.row].group_code);
    });
}
