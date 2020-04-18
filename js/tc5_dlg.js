var picid=0;
var pictrxid=0;
var picunix=0;
function get_content_tc5()
{                                     
    var obj_post = $.post(uri_dlg_tc5,{},function(data) {
    });
    obj_post.done(function(msg) {  
        $("#dialogBox_tc5").html(msg);
        create_tc5_dlg_event();
    });
}
function create_dlg_tc5()
{
    get_content_tc5();
    
    $("#dialogBox_tc5").dialog({ 
            title:        'Aplikasi CS - TC5'
        ,    width:        635
        ,    height:        480
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
         ,    modal:        true
        ,buttons: {
             "Cetak": function(){ do_print_tc5(); },     
             "Batal": function(){ $(this).dialog("close"); }
          }
        });
    
}
function open_dlg_tc5(p_id,p_xid,p_unix)
{
    picid=p_id;
    pictrxid=p_xid;
    picunix=p_unix;
    do_refresh_tc5();
    enable_disabled_field_tc5();
    enable_disabled_btn_tc5();
    $("#dialogBox_tc5").dialog("open");
}
function close_dlg_tc5()
{
    picid=0;
    $("#dialogBox_tc5").dialog("close");
}
function enable_disabled_btn_tc5()
{
    if(picunix==1 && lvl>5)
        $($("button", $("#dialogBox_tc5").parent())[0]).hide();
    else
        $($("button", $("#dialogBox_tc5").parent())[0]).show();
}
function enable_disabled_field_tc5()
{
    if(picunix==1 && lvl>5)
    {
        $("#dlg_tc5_bnf_name").attr("readonly",true); 
        $("#dlg_tc5_bnf_acc_no").attr("readonly",true); 
        $("#dlg_tc5_bnf_bank").attr("readonly",true);   
        $("#dlg_tc5_charges").attr("readonly",true); 
        $("#dlg_tc5_msg").attr("readonly",true); 
        $("#dlg_tc5_sender").attr("readonly",true);  
    }
    else
    {
         if(lvl<=5)
        {
            $("#dlg_tc5_bnf_acc_no").attr("readonly",false); 
            $("#dlg_tc5_bnf_bank").attr("readonly",false); 
            $("#dlg_tc5_bnf_name").attr("readonly",false);          
        }
        else
        {
            $("#dlg_tc5_bnf_acc_no").attr("readonly",true); 
            $("#dlg_tc5_bnf_bank").attr("readonly",true); 
            $("#dlg_tc5_bnf_name").attr("readonly",true);          
        }     
        $("#dlg_tc5_charges").attr("readonly",false); 
        $("#dlg_tc5_msg").attr("readonly",false); 
        $("#dlg_tc5_sender").attr("readonly",false);  
    }
}
function do_print_tc5()
{
    if(confirm("Cetak TC5?"))
    {                       
        state_progress(1); 
        var obj_post = $.post(uri+"/index.php/tc5/save_tc5", 
            { tca5id:picid,trxid:pictrxid,unixno:picunix, bnf_name:$("#dlg_tc5_bnf_name").val(), bnf_rek:$("#dlg_tc5_bnf_acc_no").val()
               ,bnf_bank:$("#dlg_tc5_bnf_bank").val(),src_rek:$("#dlg_tc5_db_acc_no").val() 
               ,charges:$("#dlg_tc5_charges").val() ,msg1:$("#dlg_tc5_msg").val() 
               ,sender1:$("#dlg_tc5_sender").val() 
            },function(data) {
        },"json");
        obj_post.done(function(msg) { 
            //alert("Saving data success!"); 
            state_progress(0);
            close_dlg_tc5();
            do_print_trx(msg.r_sdata[0].tc5_id)
            refresh_tc5_grid();
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Saving data error :" + textStatus);
            state_progress(0);
        });
    }
}
function do_refresh_tc5()
{            
    clear_field_tc5();                                    
    state_progress(1);                            
    var obj_post = $.post(uri+"/index.php/tc5/get_tc5", 
        { pic_id:picid,trx_id:pictrxid,unix_no:picunix },function(data) {   
    },"json");
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
        {
            $("#dlg_tc5_bnf_name").val(msg.r_sdata[0].beneficiary_name);            
            $("#dlg_tc5_bnf_acc_no").val(msg.r_sdata[0].beneficiary_acc_no);
            $("#dlg_tc5_bnf_bank").val(msg.r_sdata[0].beneficiary_bank);
            $("#dlg_tc5_db_acc_no").val(msg.r_sdata[0].src_acc_no);   
            $("#dlg_tc5_db_amount").val(strtomoney(msg.r_sdata[0].amount));
            $("#dlg_tc5_db_amount_h").val(msg.r_sdata[0].amount);
            $("#dlg_tc5_db_amount_say").val(msg.r_sdata[0].amount_said);
            $("#dlg_tc5_msg").val(msg.r_sdata[0].msg.replace(/\|/g,"\n"));
            $("#dlg_tc5_sender").val(msg.r_sdata[0].sender_name.replace(/\|/g,"\n"));
            $("#dlg_tc5_pic_id").val(msg.r_sdata[0].pic_id);   
            $("#dlg_tc5_charges").val(msg.r_sdata[0].charges);
            $("#dlg_tc5_charges_s").html(strtomoney(msg.r_sdata[0].charges));
        }
        else
            clear_field_tc5();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) { 
        clear_field_tc5();
        state_progress(0);
    });
 
}
function clear_field_tc5()
{
    picid=0;
    $("#dlg_tc5_bnf_name").val('');
    $("#dlg_tc5_bnf_acc_no").val('');
    $("#dlg_tc5_bnf_bank").val('');
    $("#dlg_tc5_db_acc_no").val('');
    $("#dlg_tc5_db_amount").val('');
    $("#dlg_tc5_db_amount_say").val('');
    $("#dlg_tc5_msg").val('');
    $("#dlg_tc5_sender").val('');
    $("#dlg_tc5_db_pic_id").val('');
    $("#dlg_tc5_db_amount_h").val('');
    $("#dlg_tc5_charges_s").html('');
}
function create_tc5_dlg_event()    
{
    $("#dlg_tc5_charges").keyup(function(){
        $("#dlg_tc5_charges_s").html(strtomoney(this.value))
    });
}
