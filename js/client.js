var grid_client;
var data_client = [];

function initiate_client()
{
    add_section("tbl_slick_client","data_client","refresh_client_grid()","hbtn_client","grid_client");
    create_client_grid(); 
    create_client_event();
    create_dlg_client();  
    create_dlg_client_search();  
}

function create_client_grid()
{    
    var columns_client = [];
    var options_client = [];
    
    columns_client = [
        {id:"client_status", name:"Status", field:"client_status"}
        ,{id:"client_code", name:"Client Code", field:"client_code"}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:300}
        ,{id:"client_bank", name:"Bank Name", field:"client_bank",width:100}
        ,{id:"client_acc_no", name:"Account No", field:"client_acc_no",width:100}
        ,{id:"client_acc_name", name:"Account Name", field:"client_acc_name",width:300}
        ,{id:"client_acc_cif", name:"CIF", field:"client_acc_cif"}
        ,{id:"has_tax", name:"TAX", field:"has_tax",cssClass:"cell_center",width:40}
        ,{id:"group_name", name:"Group Name", field:"group_name",width:300}
        ,{id:"client_modified_by", name:"Modified By", field:"client_modified_by"}
        ,{id:"client_modified_dt", name:"Modified Date", field:"client_modified_dt"}
        ,{id:"client_approved_by", name:"Approved By", field:"client_approved_by"}
        ,{id:"client_approved_dt", name:"Approved Date", field:"client_approved_dt"}
    ];
    options_client = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_client = new Slick.Grid("#tbl_slick_client", data_client, columns_client, options_client);
    grid_client.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_client_grid()
{
    state_progress(1);
    data_client.length=0;
    var obj_post = $.post(uri+"index.php/itd/list_client",{test:"tes"},function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_client[i] = {});
           d["client_status"] = data.r_sdata[i].client_progress_status==3?'Approved':data.r_sdata[i].client_progress_status==2?'Revised':'Submited';
           d["client_id"] = data.r_sdata[i].client_id;
           d["client_code"] = data.r_sdata[i].client_code;
           d["client_name"] = data.r_sdata[i].client_name;
           d["client_bank"] = data.r_sdata[i].bank_name;
           d["client_acc_no"] = data.r_sdata[i].acc_no;  
           d["client_acc_name"] = data.r_sdata[i].acc_name;
           d["client_acc_cif"] = data.r_sdata[i].acc_cif+'&nbsp';
           d["has_tax"] = (data.r_sdata[i].has_tax==2?"Y":"N");
           d["group_name"] = data.r_sdata[i].group_name;
           d["group_code"] = data.r_sdata[i].group_code;
           d["client_modified_by"] = data.r_sdata[i].client_modified_by;
           d["client_modified_dt"] = data.r_sdata[i].client_modified_dt_s;
           d["client_approved_by"] = data.r_sdata[i].client_approved_by;
           d["client_approved_dt"] = data.r_sdata[i].client_approved_dt_s;
        }
    },"json");
    obj_post.done(function(msg){
        grid_client.invalidateAllRows();
        grid_client.updateRowCount();
        grid_client.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
    do_refresh_client_g();    
}

function create_client_event()
{
    $("#hbtn_client_refresh").click(function(){
        refresh_client_grid();
    });
    
    $("#hbtn_client_new").click(function(){ 
        open_dlg_client(0);
    });
    $("#hbtn_client_search").click(function(){ 
        open_dlg_client_search();
    });
    
    $("#hbtn_client_edit").click(function(){
        selected_row_client  = grid_client.getActiveCell();
        if(selected_row_client)
            open_dlg_client(data_client[selected_row_client.row].client_id);
        else
            alert("No data selected!");
    });
    if(lvl<=5)
    {
        $("#hbtn_client_approve").click(function(){
            selected_row_client  = grid_client.getActiveCell();
            if(selected_row_client)
            {
                if(data_client[selected_row_client.row].client_id)
                {                                                     
                    if(data_client[selected_row_client.row].client_status!='Approved')
                    {   
                        var psn_confirm = 'Are u sure to approve?';
                        psn_confirm = psn_confirm + "\nClient Code: " + data_client[selected_row_client.row].client_code;
                        psn_confirm = psn_confirm + "\nClient Name: " + data_client[selected_row_client.row].client_name;
                        psn_confirm = psn_confirm + "\nBank Name: " + data_client[selected_row_client.row].client_bank;
                        psn_confirm = psn_confirm + "\nBank Account Name: " + data_client[selected_row_client.row].client_acc_name;
                        psn_confirm = psn_confirm + "\nBank Account No: " + data_client[selected_row_client.row].client_acc_no;
                        psn_confirm = psn_confirm + "\CIF No: " + data_client[selected_row_client.row].client_acc_cif;
                        if(confirm(psn_confirm))
                            approve_client(data_client[selected_row_client.row].client_id);
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
        $("#hbtn_client_del").click(function(){
            if(confirm('Are u sure to delete this row?'))
            {
                selected_row_client  = grid_client.getActiveCell();
                if(selected_row_client)
                    delete_client(data_client[selected_row_client.row].client_id);
                else
                    alert("No data selected!");
            }
        });
    }
    grid_client.onDblClick.subscribe(function(e) {     
        var cell = grid_client.getCellFromEvent(e);
        if(lvl<=5)
            open_dlg_client(data_client[cell.row].client_id);
    });
}
function delete_client(c_id)
{
    state_progress(1);
    data_client.length=0;
    var obj_post = $.post(uri+"index.php/itd_del/d_client",{client_id:c_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        if(msg.r_success)
            alert('Delete success!');
        else
            alert('Delete failed!');
        state_progress(0);
        refresh_client_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function approve_client(c_id)
{
    state_progress(1);
    var obj_post = $.post(uri+"index.php/itd_save/submit_approve_client",{client_id:c_id},function(data) {
        
    },'json');
    obj_post.done(function(msg){
        if(msg.r_data[0].can_approve==1)
            alert('Success approve record!');
        else
            alert('You dont have right to approve or Record is unapproveable!');
        state_progress(0);
        refresh_client_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}