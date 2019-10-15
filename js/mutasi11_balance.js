var grid_mutasi11_balance;
var data_mutasi11_balance = [];

function initiate_mutasi11_balance()
{                                                      
    add_section("tbl_slick_mutasi11_balance","data_mutasi11_balance","refresh_mutasi11_balance_grid()","hbtn_mutasi11_balance","grid_mutasi11_balance");
    create_mutasi11_balance_grid(); 
    create_mutasi11_balance_event();
    $("#hbtn_mutasi11_balance_dt1").val(saiki);
    $("#hbtn_mutasi11_balance_dt2").val(saiki);        
    get_content_user_mutasi11_balance();
}
function get_content_user_mutasi11_balance()
{
    $("#hbtn_mutasi11_balance_proc").html('');
    var obj_post1 = $.post(uri+"/index.php/itd/list_user",{u_unit:1},function(data1) {   
        },"json");
    obj_post1.done(function(msg1) {    //alert(msg.r_num_rows);
        if(msg1.r_num_rows>0)
        {
            var sta='<option value="ALL">***ALL***</option>\n';
            for (var i=0; i<msg1.r_num_rows; i++) {
                sta=sta+'<option value="'+msg1.r_sdata[i].user_id+'">'+msg1.r_sdata[i].user_name+'</option>\n';
            }
            $("#hbtn_mutasi11_balance_proc").html(sta);
        }
    });
    var obj_post2 = $.post(uri+"/index.php/mutasi/list_cli", {},function(data) {},"json"); 
    obj_post2.done(function(msg) { 
        var htm="<option value=\"All\">All</option>";
        for (var i=0; i<msg.r_num_rows; i++) {
            htm = htm + "<option value='"+msg.r_sdata[i].client_code+"'>"+msg.r_sdata[i].client_code+"</option>"
        }
        $("#hbtn_mutasi11_balance_cli").html(htm);
        state_progress(0);
    });
    
    obj_post2.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function create_mutasi11_balance_grid()
{    
    var columns_mutasi11_balance = [];
    var options_mutasi11_balance = [];
    
    columns_mutasi11_balance = [
        {id:"status", name:"Status", field:"status",width:40,cssClass:"cell_center"}
        ,{id:"client_code", name:"Client Code", field:"client_code",width:70,cssClass:"cell_center"}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:200}
        ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
        ,{id:"balance_date", name:"Date", field:"balance_date",width:100}
        ,{id:"balance_open", name:"Opening", field:"balance_open",cssClass:"cell_right",width:120}
        ,{id:"balance_trx", name:"Mutasi", field:"balance_trx",cssClass:"cell_right",width:120}
        ,{id:"balance_close", name:"Closing", field:"balance_close",cssClass:"cell_right",width:120}
        ,{id:"balance_gs", name:"GS", field:"balance_gs",cssClass:"cell_right",width:120}
        ,{id:"selisih", name:"Selisih", field:"selisih",cssClass:"cell_right"}
        ,{id:"balance_remark", name:"Remark", field:"balance_remark",width:200}
        ,{id:"balance_open_by", name:"Opened by", field:"balance_open_by"}
        ,{id:"balance_close_by", name:"Closed by", field:"balance_close_by"}
    ];
    options_mutasi11_balance = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_balance = new Slick.Grid("#tbl_slick_mutasi11_balance", data_mutasi11_balance, columns_mutasi11_balance, options_mutasi11_balance);
    grid_mutasi11_balance.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_balance_grid()
{
    state_progress(1);
    data_mutasi11_balance.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/list_balance",{
        f:$("#hbtn_mutasi11_balance_filter").val(),
        dt1:$("#hbtn_mutasi11_balance_dt1").val(),dt2:$("#hbtn_mutasi11_balance_dt2").val(),proc:$("#hbtn_mutasi11_balance_proc").val(),
        cclient:$("#hbtn_mutasi11_balance_cli").val()
    },function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mutasi11_balance[i] = {});
           d["balance_id"] = data.r_sdata[i].balance_id;
           d["status"] = data.r_sdata[i].balance_status=='2'?'Closed':'Open';
           d["client_code"] = data.r_sdata[i].client_code;
           d["client_name"] = data.r_sdata[i].client_name;
           d["acc_no"] = data.r_sdata[i].acc_no;
           d["balance_date"] = data.r_sdata[i].balance_date_s;
           d["balance_open"] = strtomoney(data.r_sdata[i].balance_open);
           d["balance_trx"] = strtomoney(data.r_sdata[i].balance_trx);
           d["balance_close"] = strtomoney(data.r_sdata[i].balance_close);
           d["balance_gs"] = strtomoney(data.r_sdata[i].balance_gs);
           d["selisih"] = strtomoney(data.r_sdata[i].balance_close-data.r_sdata[i].balance_gs);
           d["balance_remark"] = data.r_sdata[i].balance_remark;
           d["balance_open_by"] = data.r_sdata[i].balance_open_by;
           d["balance_close_by"] = data.r_sdata[i].balance_close_by;
           
        }
    },"json");
    obj_post.done(function(msg){
        grid_mutasi11_balance.invalidateAllRows();
        grid_mutasi11_balance.updateRowCount();
        grid_mutasi11_balance.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_mutasi11_balance_event()
{
    $("#hbtn_mutasi11_balance_reload").click(function(){          
        refresh_mutasi11_balance_grid();
    });
    
    $("#hbtn_mutasi11_balance_save").click(function(){        
        save_mutasi11_balance();
        refresh_mutasi11_balance_grid();
    });
    $("#hbtn_mutasi11_balance_compare_save").click(function(){        
        compare_mutasi11_balance();
    });
               
}

function del_mutasi11_balance(g_id)
{
    state_progress(1);
    data_mutasi11_balance.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/del_balance",{giro_id:g_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        if(msg.r_success)
            alert('Delete success!');
        else
            alert('Delete failed!');
        state_progress(0);
        refresh_mutasi11_balance_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function save_mutasi11_balance()
{
    var a='';
    a=a+"<input type='text' name='dt1' value='"+$("#hbtn_mutasi11_balance_dt1").val()+"' />";
    a=a+"<input type='text' name='dt2' value='"+$("#hbtn_mutasi11_balance_dt2").val()+"' />";
    a=a+"<input type='text' name='proc' value='"+$("#hbtn_mutasi11_balance_proc").val()+"' />";
    $("#frm_hidden").html(a).attr('action', uri+"index.php/mutasi/save_list_balance").submit();
}
function compare_mutasi11_balance()
{
    var a='';
    a=a+"<input type='text' name='dt1' value='"+$("#hbtn_mutasi11_balance_dt1").val()+"' />";
    a=a+"<input type='text' name='dt2' value='"+$("#hbtn_mutasi11_balance_dt2").val()+"' />";
    $("#frm_hidden").html(a).attr('action', uri+"index.php/mutasi/compare_balance").submit();
}