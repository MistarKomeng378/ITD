var grid_mutasi11_client;
var data_mutasi11_client = [];

function initiate_mutasi11_client()
{
    add_section("tbl_slick_mutasi11_client","data_mutasi11_client","refresh_mutasi11_client_grid()","hbtn_mutasi11_client","grid_mutasi11_client");
    create_mutasi11_client_grid(); 
    create_mutasi11_client_event();
    create_dlg_mutasi11_client();  
    create_dlg_mutasi11_client_search();  
}

function create_mutasi11_client_grid()
{    
    var columns_mutasi11_client = [];
    var options_mutasi11_client = [];
    
    columns_mutasi11_client = [
        {id:"client_user", name:"Procesor", field:"client_user"}
        ,{id:"client_code", name:"Client Code", field:"client_code"}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:220}
        ,{id:"client_acc_no", name:"Account No", field:"client_acc_no",width:120}
        ,{id:"bank_name", name:"Bank Name", field:"bank_name"}
        ,{id:"client_cif", name:"Client CIF", field:"client_cif",width:75}
        ,{id:"client_cbest", name:"Client CBEST", field:"client_cbest",width:120}
        ,{id:"bank_internal", name:"Bank Internal", field:"bank_internal",cssClass:"cell_center"}
        ,{id:"client_jasgir", name:"Kena JasGir", field:"client_jasgir",cssClass:"cell_center"}
        ,{id:"client_type", name:"Tipe Klien", field:"client_type",}
        ,{id:"client_modified_by", name:"Modified By", field:"client_modified_by"}
        ,{id:"client_modified_dt", name:"Modified Date", field:"client_modified_dt"}
        ,{id:"client_enable", name:"Enable", field:"client_enable"}
    ];
    options_mutasi11_client = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_client = new Slick.Grid("#tbl_slick_mutasi11_client", data_mutasi11_client, columns_mutasi11_client, options_mutasi11_client);
    grid_mutasi11_client.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_client_grid()
{
    state_progress(1);
    data_mutasi11_client.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/list_client",{},function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mutasi11_client[i] = {});
           d["client_id"] = data.r_sdata[i].client_id;
           d["client_user"] = data.r_sdata[i].client_user;
           d["client_code"] = data.r_sdata[i].client_code;
           d["client_name"] = data.r_sdata[i].client_name;
           d["bank_name"] = data.r_sdata[i].bank_name;
           d["client_acc_no"] = data.r_sdata[i].acc_no;
           d["client_cif"] = data.r_sdata[i].client_cif+'&nbsp';
           d["client_cbest"] = data.r_sdata[i].client_cbest+'&nbsp';
           d["client_jasgir"] = (data.r_sdata[i].kena_jasgir==1?"Ya":"Tidak");
           //d["client_type"] = (data.r_sdata[i].client_type==3?"Diskree":data.r_sdata[i].client_type==2?"Unit Link":"Reksadana");
           d["client_type"] = data.r_sdata[i].type_desc;
           d["bank_internal"] = (data.r_sdata[i].bank_internal==1?"Internal":"Eksternal");
           d["client_modified_by"] = data.r_sdata[i].modified_by;
           d["client_modified_dt"] = data.r_sdata[i].modified_dt_s;
           d["client_enable"] = data.r_sdata[i].client_enable==1?"Ya":"Tidak";
        }
    },"json");
    obj_post.done(function(msg){
        grid_mutasi11_client.invalidateAllRows();
        grid_mutasi11_client.updateRowCount();
        grid_mutasi11_client.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_mutasi11_client_event()
{
    $("#hbtn_mutasi11_client_refresh").click(function(){
        refresh_mutasi11_client_grid();
    });
    
    $("#hbtn_mutasi11_client_new").click(function(){        
        open_dlg_mutasi11_client(0,0);
    });
    $("#hbtn_mutasi11_client_search").click(function(){ 
        open_dlg_mutasi11_client_search();
    });
    
    $("#hbtn_mutasi11_client_edit").click(function(){
        selected_row_mutasi11_client  = grid_mutasi11_client.getActiveCell();         
        if(selected_row_mutasi11_client)
            open_dlg_mutasi11_client(data_mutasi11_client[selected_row_mutasi11_client.row].client_id,0);
        else
            alert("No data selected!");
    });
    $("#hbtn_mutasi11_client_edit_rek").click(function(){
        selected_row_mutasi11_client  = grid_mutasi11_client.getActiveCell();         
        if(selected_row_mutasi11_client)
            open_dlg_mutasi11_client(data_mutasi11_client[selected_row_mutasi11_client.row].client_id,1);
        else
            alert("No data selected!");
    });
    if(lvl<=5)
    {
        $("#hbtn_mutasi11_client_approve").click(function(){
            selected_row_mutasi11_client  = grid_mutasi11_client.getActiveCell();
            if(selected_row_mutasi11_client)
            {
                if(data_mutasi11_client[selected_row_mutasi11_client.row].client_id)
                {                                                     
                    if(data_mutasi11_client[selected_row_mutasi11_client.row].client_status!='Approved')
                    {   
                        var psn_confirm = 'Are u sure to approve?';
                        psn_confirm = psn_confirm + "\nClient Code: " + data_mutasi11_client[selected_row_mutasi11_client.row].client_code;
                        psn_confirm = psn_confirm + "\nClient Name: " + data_mutasi11_client[selected_row_mutasi11_client.row].client_name;
                        psn_confirm = psn_confirm + "\nBank Name: " + data_mutasi11_client[selected_row_mutasi11_client.row].client_bank;
                        psn_confirm = psn_confirm + "\nBank Account Name: " + data_mutasi11_client[selected_row_mutasi11_client.row].client_acc_name;
                        psn_confirm = psn_confirm + "\nBank Account No: " + data_mutasi11_client[selected_row_mutasi11_client.row].client_acc_no;
                        psn_confirm = psn_confirm + "\CIF No: " + data_mutasi11_client[selected_row_mutasi11_client.row].client_acc_cif;
                        if(confirm(psn_confirm))
                            approve_mutasi11_client(data_mutasi11_client[selected_row_mutasi11_client.row].client_id);
                    }
                    else
                        alert('Approved Already!');
                }
                else
                    alert("No data selected!");
            }
            else
                alert("No data selected!");
        });
        $("#hbtn_mutasi11_client_del").click(function(){
            if(confirm('Are u sure to delete this row?'))
            {
                selected_row_mutasi11_client  = grid_mutasi11_client.getActiveCell();
                if(selected_row_mutasi11_client)
                    delete_mutasi11_client(data_mutasi11_client[selected_row_mutasi11_client.row].client_id);
                else
                    alert("No data selected!");
            }
        });
    }
    grid_mutasi11_client.onDblClick.subscribe(function(e) {     
        var cell = grid_mutasi11_client.getCellFromEvent(e);
        if(lvl<=5)
            open_dlg_mutasi11_client(data_mutasi11_client[cell.row].client_id);
    });
}
function delete_mutasi11_client(c_id)
{
    state_progress(1);
    data_mutasi11_client.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/del_client",{client_id:c_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        if(msg.r_success)
            alert('Delete success!');
        else
            alert('Delete failed!');
        state_progress(0);
        refresh_mutasi11_client_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
