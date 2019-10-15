var picid=0;
function get_content_pic()
{             
    var obj_post = $.post(uri_dlg_pic,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_pic").html(msg);
    });
}
function create_dlg_pic()
{
    get_content_pic();
    $("#dialogBox_pic").dialog({ 
            title:        'Instruksi Transaksi Deposito - PIC'
        ,    width:        390
        ,    height:        280
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
         ,    modal:        true
        ,buttons: {
             "Simpan": function(){ do_save_pic(); },
             "Refresh": function(){ do_refresh_pic(); },
             "Batal": function(){ $(this).dialog("close"); }
          }
        });
    
}
function open_dlg_pic(p_id)
{
    picid=p_id;
    do_refresh_pic();
    $("#dialogBox_pic").dialog("open");
}
function close_dlg_pic()
{
    picid=0;
    $("#dialogBox_pic").dialog("close");
}
function do_save_pic()
{
    var input_check = [
    {id:"dlgPIC_bank_name",empty:false,type:"s"}
    ,{id:"dlgPIC_name",empty:false,type:"s"}
    ]
    if(!input_is_needed(input_check))
        return false;
    if(confirm("Save data?"))
    {
        
        state_progress(1); 
        var obj_post = $.post(uri+"/index.php/itd_save/save_pic", 
            { pic_id:picid, bank_name:$("#dlgPIC_bank_name").val(),bank_rek:$("#dlgPIC_bank_rek").val(),
                bank_acc_name:$("#dlgPIC_bank_acc_name").val(),pic_name:$("#dlgPIC_name").val(),pic_telp:$("#dlgPIC_telp").val(), 
                pic_fax:$("#dlgPIC_fax").val(), pic_remark1:$("#dlgPIC_remark1").val(),
                pic_remark2:$("#dlgPIC_remark2").val()
            },function(data) {
        },"json");
        obj_post.done(function(msg) { 
            alert("Saving data success!"); 
            state_progress(0);
            close_dlg_pic();
            refresh_pic_grid();
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Saving data error :" + textStatus);
            state_progress(0);
        });
    }
}
function do_refresh_pic()
{
    if(picid==0)
        clear_field_pic();
    else
    {
        state_progress(1);                            
        var obj_post = $.post(uri+"/index.php/itd/get_pic", 
            { pic_id:picid },function(data) {   
        },"json");
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgPIC_bank_name").val(msg.r_sdata[0].bank_name);
                $("#dlgPIC_bank_rek").val(msg.r_sdata[0].bank_rek);
                $("#dlgPIC_bank_acc_name").val(msg.r_sdata[0].bank_acc_name);
                $("#dlgPIC_name").val(msg.r_sdata[0].pic_name);
                $("#dlgPIC_telp").val(msg.r_sdata[0].bank_telp);
                $("#dlgPIC_fax").val(msg.r_sdata[0].bank_fax);
                $("#dlgPIC_remark1").val(msg.r_sdata[0].pic_remark1);
                $("#dlgPIC_remark2").val(msg.r_sdata[0].pic_remark2);
            }
            else
                clear_field_pic();
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) { 
            clear_field_pic();
            state_progress(0);
        });
    }
}
function clear_field_pic()
{
    picid=0;
    $("#dlgPIC_bank_name").val('');
    $("#dlgPIC_name").val('');
    $("#dlgPIC_telp").val('');
    $("#dlgPIC_fax").val('');
    $("#dlgPIC_remark1").val('');
    $("#dlgPIC_remark2").val('');
}
