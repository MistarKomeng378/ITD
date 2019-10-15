

function get_content_mutasi11_1()
{             
    var obj_post = $.post(uri_mutasi11_dlg1,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_mutasi11_1").html(msg);
        $("#i_mutasi11_dlg1_dt").datepicker();
        $("#i_mutasi11_dlg1_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#i_mutasi11_dlg1_dt1").datepicker();
        $("#i_mutasi11_dlg1_dt1").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#i_mutasi11_dlg1_dt").val(saiki);
        $("#i_mutasi11_dlg1_dt1").val(saiki);
    });
}
function create_dlg_mutasi11_1()
{
    get_content_mutasi11_1()
    $("#dialogBox_mutasi11_1").dialog({ 
            title:        'Cetak mutasi'
        ,    width:       290
        ,    height:        110
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cetak Mutasi": function(){act_mutasi11_1();},
             "Tutup": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_1(ccode,accno,cdt)
{                                 
    
    $("#i_mutasi11_dlg1_c_code").val(ccode);
    $("#i_mutasi11_dlg1_acc_no").val(accno);
    $("#i_mutasi11_dlg1_c_dt").val(cdt);
    $("#dialogBox_mutasi11_1").dialog("open");
}
function close_dlg_mutasi11_1()
{
    $("#dialogBox_mutasi11_1").dialog("close");
}

function act_mutasi11_1()
{
    $("#frm_mutasi11_1").submit();
}

/*function do_save_mutasi11()
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
            var obj_post = $.post(uri+"/index.php/itd_save/save_mutasi11", 
                { client_id:clientid, client_code:$("#dlgClient_code").val(),
                    client_name:$("#dlgClient_name").val(),bank_name:$("#dlgClient_bank_name").val(), 
                    acc_no:$("#dlgClient_acc_no").val(), acc_name:$("#dlgClient_acc_name").val(),
                    acc_cif:$(  "#dlgClient_cif").val()
                },function(data) {
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_mutasi11();
                refresh_mutasi11_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_refresh_mutasi11()
{
    if(clientid==0)
        clear_field_mutasi11();
    else
    {
        state_progress(1);                            
        var obj_post = $.post(uri+"/index.php/itd/get_mutasi11", 
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
            }
            else
                clear_field_mutasi11();
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) { 
            clear_field_mutasi11();
            state_progress(0);
        });
    }
}
function clear_field_mutasi11()
{
    clientid=0;
    $("#dlgClient_code").val('');
    $("#dlgClient_name").val('');
    $("#dlgClient_bank_name").val('');
    $("#dlgClient_acc_no").val('');
    $("#dlgClient_acc_name").val('');
    $("#dlgClient_cif").val('');
}*/