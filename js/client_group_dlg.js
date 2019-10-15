var clientgroupcode='';

function get_content_client_group()
{             
    var obj_post = $.post(uri_dlg_client_group,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_client_group").html(msg);
    });
}
function create_dlg_client_group()
{
    get_content_client_group()
    $("#dialogBox_client_group").dialog({ 
            title:        'Instruksi Transaksi Deposito - Client Mail Group'
        ,    width:        530
        ,    height:        340
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Simpan": function(){do_save_client_group();},
             "Refresh": function(){do_refresh_client_group();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_client_group(c_code)
{
    clientgroupcode=c_code;
    do_refresh_client_group();
    $("#dialogBox_client_group").dialog("open");
}
function close_dlg_client_group()
{
    clientgroupcode='';
    $("#dialogBox_client_group").dialog("close");
}
function do_save_client_group()
{
    var input_check = [
    {id:"dlgClientGroup_code",empty:false,type:"s"}
    ,{id:"dlgClientGroup_name",empty:false,type:"s"}
    ]
    if(!input_is_needed(input_check))
        return false;  
    if(confirm("Save data?"))
    {
        //if(lvl<=5)
        {              
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/itd_save/save_client_group", 
                { g_id:clientgroupcode, 
                    c_code:$("#dlgClientGroup_code").val(),
                    c_name:$("#dlgClientGroup_name").val(),
                    c_ena:$("#dlgClientGroup_enable").val(),
                    c_mail:$("#dlgClientGroup_mail").val(),
                    c_mailcc:$("#dlgClientGroup_mail_cc").val()
                },function(data) {
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_client_group();
                refresh_client_group_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_refresh_client_group()
{
    if(clientgroupcode=='')
        clear_field_client_group();
    else
    {
        state_progress(1);                            
        var obj_post = $.post(uri+"/index.php/itd/get_client_group", 
            { g_code:clientgroupcode },function(data) {   
        },"json");
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgClientGroup_code").val(msg.r_sdata[0].group_code);
                $("#dlgClientGroup_name").val(msg.r_sdata[0].group_name);
                $("#dlgClientGroup_enable").val(msg.r_sdata[0].group_mail_enable);
                $("#dlgClientGroup_mail").val(msg.r_sdata[0].group_mail);
                $("#dlgClientGroup_mail_cc").val(msg.r_sdata[0].group_mail_cc);
            }
            else
                clear_field_client_group();
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) { 
            clear_field_client_group();
            state_progress(0);
        });
    }
}
function clear_field_client_group()
{
    clientgroupcode='';
    $("#dlgClientGroup_code").val('');
    $("#dlgClientGroup_name").val('');
    $("#dlgClientGroup_enable").val('1');
    $("#dlgClientGroup_mail").val('');
    $("#dlgClientGroup_mail_cc").val('');
}