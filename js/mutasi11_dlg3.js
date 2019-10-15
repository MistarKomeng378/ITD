function get_content_mutasi11_3()
{             
    var obj_post = $.post(uri_mutasi11_dlg3,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_mutasi11_3").html(msg);
         $("#i_mutasi11_dlg3_dt").datepicker();
        $("#i_mutasi11_dlg3_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    });
}
function create_dlg_mutasi11_3()
{
    get_content_mutasi11_3()
    $("#dialogBox_mutasi11_3").dialog({ 
            title:        'Cetak Rekap Jasa Giro'
        ,    width:        500
        ,    height:        210
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "View": function(){act_mutasi11_3();},
             "to Excel": function(){act_mutasi11_3a();},
             "to CSV": function(){act_mutasi11_3b();},
             "Tutup": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_3(ccode,accno,cdt)
{                                 
    $("#i_mutasi11_dlg3_c_code").val(ccode);
    $("#i_mutasi11_dlg3_acc_no").val(accno);
    $("#i_mutasi11_dlg3_c_dt").val(cdt);
    $("#dialogBox_mutasi11_3").dialog("open");
    $("#i_mutasi11_dlg3_no").val('');
}
function close_dlg_mutasi11_3()
{                                       
    $("#dialogBox_mutasi11_3").dialog("close");
}

function act_mutasi11_3()
{
    
    $("#frm_mutasi11_3").submit();
}
function act_mutasi11_3a()
{                                    
    window.open(uri+'index.php/mutasi_dlg/save_3/'+$("#i_mutasi11_dlg3_dt").val()+'/'+$("#i_mutasi11_dlg3_no").val());
}
function act_mutasi11_3b()
{                                    
    window.open(uri+'index.php/mutasi_dlg/save_3b/'+$("#i_mutasi11_dlg3_dt").val()+'/'+$("#i_mutasi11_dlg3_no").val());
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