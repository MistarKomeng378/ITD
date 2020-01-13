
function get_content_trx_approve()
{             
    var obj_post = $.post(uri_dlg_trx_approve,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_trx_approve").html(msg);
    });
}
function create_dlg_trx_approve()
{
    get_content_trx_approve()
    $("#dialogBox_trx_approve").dialog({ 
            title:        'Instruksi Transaksi Deposito - Approval'
        ,    width:        280
        ,    height:        140
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Approve & Print the Instruction?": function(){
                 trx_cetak=1;do_submit_approve_dlg_trx_approve();
             },   
             "Cancel": function(){ $(this).dialog("close");}
        }
        ,close: function( event, ui ) {
            refresh_trx_grid();
            refresh_bilyet_status_count();
        }
    });
}
function open_dlg_trx_approve()
{
    $("#dialogBox_trx_approve").dialog("open");
}
function close_dlg_trx_approve()
{
    $("#dialogBox_trx_approve").dialog("close");
}
function do_submit_approve_dlg_trx_approve()
{
    //if(confirm("Approve instruksi?"))
    //{
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/itd_save/submit_approve_trx1", 
        { trx_id:trxid,ud1:$("#ud1").val(),up1:$("#up1").val()
        },function(data) {},"json");
        obj_post.done(function(msg) { 
            //alert("Approve instruction success!");    alert(msg.r_numrows);
            state_progress(0);      
            if(msg.r_numrows>0) 
            {
                if(msg.r_sdata[0].password_is_match<1)
                    alert("Wrong user or password.");
                else if(msg.r_sdata[0].can_approve!=1)
                    alert("User doesn't have right to approve the instruction.");
                else
                {
                    alert("Approve instruction success!");
                    if(msg.penempatan_to_mutasi){
                        alert(msg.penempatan_to_mutasi.msg);
                    }else if(msg.pencairan_to_mutasi){
                        alert(msg.pencairan_to_mutasi.msg);
                    }

                    if(trx_cetak==1)
                    {
                        do_print_trx(msg.r_sdata[0].trx_id);
                    }
                    close_dlg_trx_approve();
                }
            }               
            
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Saving data error :" + textStatus);
            state_progress(0);
        });
    //}
}