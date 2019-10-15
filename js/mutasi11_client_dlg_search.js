function get_content_dlg_mutasi11_client_search()
{             
    var obj_post = $.post(uri_dlg_mutasi11_client_search,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_mutasi11_client_search").html(msg);
    });
}
function create_dlg_mutasi11_client_search()
{
    get_content_dlg_mutasi11_client_search()
    $("#dialogBox_mutasi11_client_search").dialog({ 
            title:        'Mutasi - Cari Client'
        ,    width:        420
        ,    height:        230
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cari": function(){do_mutasi11_client_search();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_client_search()
{
    $("#dialogBox_mutasi11_client_search").dialog("open");
}
function close_dlg_mutasi11_client_search()
{
    $("#dialogBox_mutasi11_client_search").dialog("close");
}
function do_mutasi11_client_search()
{
    state_progress(1);
    data_mutasi11_client.length=0;
    var obj_post = $.post(uri+"index.php/mutasi_client_dlg/search_client",{
        client_user:$("#dlgM11SClient_user").val(),
        client_code:$("#dlgM11SClient_code").val(),
        client_name:$("#dlgM11SClient_name").val(),acc_no:$("#dlgM11SClient_acc_no").val(), 
        client_cif:$(  "#dlgM11SClient_cif").val(), client_cbest:$(  "#dlgM11SClient_cbest").val()
    },function(data) { 
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mutasi11_client[i] = {});
           d["client_id"] = data.r_sdata[i].client_id;
           d["client_user"] = data.r_sdata[i].client_user;
           d["client_code"] = data.r_sdata[i].client_code;
           d["client_name"] = data.r_sdata[i].client_name;
           d["client_acc_no"] = data.r_sdata[i].acc_no;
           d["client_cif"] = data.r_sdata[i].client_cif+'&nbsp';
           d["client_cbest"] = data.r_sdata[i].client_cbest+'&nbsp';
           d["client_jasgir"] = (data.r_sdata[i].kena_jasgir==1?"Ya":"Tidak");
           d["client_type"] = (data.r_sdata[i].client_type==3?"Diskree":data.r_sdata[i].client_type==2?"Unit Link":"Reksadana");
           d["client_modified_by"] = data.r_sdata[i].modified_by;
           d["client_modified_dt"] = data.r_sdata[i].modified_dt_s;
        }
    },"json");
    obj_post.done(function(msg){
        grid_mutasi11_client.invalidateAllRows();
        grid_mutasi11_client.updateRowCount();
        grid_mutasi11_client.render();
        state_progress(0);
        close_dlg_mutasi11_client_search();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
