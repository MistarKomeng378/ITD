var clientid=0;

function get_content_client()
{             
    var obj_post = $.post(uri_dlg_client,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_client").html(msg); 
    });
}
function create_dlg_client()
{
    get_content_client()
    $("#dialogBox_client").dialog({ 
            title:        'Instruksi Transaksi Deposito - Client'
        ,    width:        440
        ,    height:        280
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Simpan": function(){do_save_client();},
             "Refresh": function(){do_refresh_client();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_client(c_id)
{
    clientid=c_id;
    do_refresh_client();
    $("#dialogBox_client").dialog("open");
}
function close_dlg_client()
{
    clientid=0;
    $("#dialogBox_client").dialog("close");
}
function do_save_client()
{
    var input_check = [
    {id:"dlgClient_code",empty:false,type:"s"}
    ,{id:"dlgClient_name",empty:false,type:"s"}
    ,{id:"dlgClient_bank_name",empty:false,type:"s"}
    ,{id:"dlgClient_acc_no",empty:false,type:"s"}
    ,{id:"dlgClient_acc_name",empty:false,type:"s"}
    ]
    if(!input_is_needed(input_check))
        return false;  
    if(confirm("Save data?"))
    {
        //if(lvl<=5)
        {              
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/itd_save/save_client", 
                { client_id:clientid, client_code:$("#dlgClient_code").val(),
                    client_name:$("#dlgClient_name").val(),bank_name:$("#dlgClient_bank_name").val(), 
                    acc_no:$("#dlgClient_acc_no").val(), acc_name:$("#dlgClient_acc_name").val(),
                    acc_cif:$(  "#dlgClient_cif").val(),h_tax:$("#dlgClient_tax").val()
                    ,g_code:$("#dlgClient_group").val()
                },function(data) {
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_client();
                refresh_client_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_refresh_client()
{
    if(clientid==0)
        clear_field_client();
    else
    {
        state_progress(1);                            
        var obj_post = $.post(uri+"/index.php/itd/get_client", 
            { client_id:clientid },function(data) {   
        },"json");
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgClient_code").val(msg.r_sdata[0].client_code);
                $("#dlgClient_name").val(msg.r_sdata[0].client_name);
                $("#dlgClient_bank_name").val(msg.r_sdata[0].bank_name);
                $("#dlgClient_acc_no").val(msg.r_sdata[0].acc_no);
                $("#dlgClient_acc_name").val(msg.r_sdata[0].acc_name);
                $("#dlgClient_cif").val(msg.r_sdata[0].acc_cif);
                $("#dlgClient_tax").val(msg.r_sdata[0].has_tax) ;
                $("#dlgClient_group").val(msg.r_sdata[0].group_code) ;
            }
            else
                clear_field_client();
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) { 
            clear_field_client();
            state_progress(0);
        });
    }
}
function clear_field_client()
{
    clientid=0;
    $("#dlgClient_code").val('');
    $("#dlgClient_name").val('');
    $("#dlgClient_bank_name").val('');
    $("#dlgClient_acc_no").val('');
    $("#dlgClient_acc_name").val('');
    $("#dlgClient_cif").val('');
}
function do_refresh_client_g()
{
    var obj_post_g = $.post(uri+"/index.php/itd/get_client_group_select", 
        {},function(data_g) {   
    });
    obj_post_g.done(function(msg_g) { 
        $("#dlgClient_group").html(msg_g);
    });
}