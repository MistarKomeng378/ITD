
function get_content_subs_save_dlg()
{                                         
    var obj_post = $.post(uri_subs_save_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {         //        alert(msg);
        $("#dialogBox_subs_save_dlg").html(msg);
        $("#i_dlgSubsDlg_dt").datepicker();
        $("#i_dlgSubsDlg_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#i_dlgSubsDlg_dt").val(saiki);
    });
}

function create_dlg_subs_save()
{
    get_content_subs_save_dlg();
    
    
    
    $("#dialogBox_subs_save_dlg").dialog({ 
            title:        'Pending Transaksi - Client'
        ,    width:        240
        ,    height:        120
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Download": function(){             // alert($("#i_subscript_client_h").val());alert($("#i_subscript_bank_h").val());alert($("#i_subscript_rek").val());
                 $("#i_dlgSubsDlg_dt_h").val($("#i_dlgSubsDlg_dt").val()); 
                 $("#i_dlgSubsDlg_ccode_h").val($("#i_subscript_client_h").val()); 
                 $("#i_dlgSubsDlg_bcode_h").val($("#i_subscript_bank_h").val()); 
                 $("#i_dlgSubsDlg_accno_h").val($("#i_subscript_rek").val()); 
                 $("#frm_dlgSubsDlg_h").submit();
             },
             "Batal": function(){ $(this).dialog("close");}
        }
    });
    create_subs_save_event(); 
    
}
function open_dlg_subs_save()
{
    $("#dialogBox_subs_save_dlg").dialog("open");
}
function close_dlg_subs_save()
{
    $("#dialogBox_subs_save_dlg").dialog("close");
}

function create_subs_save_event()
{                                    
    
    $("#hbtn_subs_save1").click(function(){    
        if($("#i_subscript_rek").val()=='')
            alert("Pilih klien!");
        else
            open_dlg_subs_save();
    });
}