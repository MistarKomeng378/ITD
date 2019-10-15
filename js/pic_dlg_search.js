function get_content_dlg_pic_search()
{             
    var obj_post = $.post(uri_dlg_pic_search,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_pic_search").html(msg);
    });
}
function create_dlg_pic_search()
{
    get_content_dlg_pic_search(); 
    $("#dialogBox_pic_search").dialog({ 
            title:        'Instruksi Transaksi Deposito - Client'
        ,    width:        420
        ,    height:        160
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cari": function(){do_refresh_dlg_pic_search();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_pic_search()
{                                       
    $("#dialogBox_pic_search").dialog("open");
}
function close_dlg_pic_search()
{                          
    $("#dialogBox_pic_search").dialog("close");
}
function do_refresh_dlg_pic_search()
{
    data_pic.length=0;
    state_progress(1);  
    var obj_post = $.post(uri+"/index.php/itd/search_pic", 
        { b_name:$("#dlgPicSearch_bank").val(),c_name:$("#dlgPicSearch_pic").val(),c_remark1:$("#dlgPicSearch_remark1").val() },function(data) {   
            for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_pic[i] = {});
               d["rec_no"] = data.r_sdata[i].row_num;
               d["pic_id"] = data.r_sdata[i].pic_id;
               d["bank_name"] = data.r_sdata[i].bank_name;
               d["bank_rek"] = data.r_sdata[i].bank_rek;
               d["bank_acc_name"] = data.r_sdata[i].bank_acc_name;
               d["pic_name"] = data.r_sdata[i].pic_name;  
               d["bank_telp"] = data.r_sdata[i].bank_telp;  
               d["bank_fax"] = data.r_sdata[i].bank_fax;
               d["pic_remark1"] = data.r_sdata[i].pic_remark1;
               d["pic_remark2"] = data.r_sdata[i].pic_remark2;
        }
    },'json');
    obj_post.done(function(msg){
        grid_pic.invalidateAllRows();
        grid_pic.updateRowCount();
        grid_pic.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
    close_dlg_pic_search();
}                                    