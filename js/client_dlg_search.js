function get_content_dlg_client_search()
{             
    var obj_post = $.post(uri_dlg_client_search,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_client_search").html(msg);
    });
}
function create_dlg_client_search()
{
    get_content_dlg_client_search(); 
    $("#dialogBox_client_search").dialog({ 
            title:        'Instruksi Transaksi Deposito - Client'
        ,    width:        400
        ,    height:        140
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cari": function(){do_refresh_dlg_client_search();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_client_search()
{                       
    $("#dialogBox_client_search").dialog("open");
}
function close_dlg_client_search()
{                          
    $("#dialogBox_client_search").dialog("close");
}
function do_refresh_dlg_client_search()
{
    data_client.length=0;
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/itd/search_client", 
        { c_code:$("#dlgClientSearch_code").val(),c_name:$("#dlgClientSearch_name").val() },function(data) {   
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
    close_dlg_client_search();
}                                    