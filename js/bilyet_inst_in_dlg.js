function get_content_bilyet_inst_in()
{             
    var obj_post = $.post(uri_dlg_bilyet_inst_in,{},function(data) {
        $("#dialogBox_bilyet_inst_in").html(data);
    });
    obj_post.done(function(msg) { 
        set_dt_picker_bilyet_inst_in();
    });
}
function create_dlg_bilyet_inst_in()
{
    get_content_bilyet_inst_in();
    $("#dialogBox_bilyet_inst_in").dialog({ 
            title:        'Instruksi Transaksi Deposito - Proses Bilyet Masuk'
        ,    width:        460
        ,    height:        380
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Bilyet Masuk": function(){
                 if (confirm('Bilyet in : ' + $("#dlgBilIn_no").val() + ' ?'))
                    do_bilyet_inst_in();
             },
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_bilyet_inst_in(c_id)
{
    $("#dialogBox_bilyet_inst_in").dialog("open");
    
}
function close_dlg_bilyet_inst_in()
{
    trx_id_bilyet=0;
    $("#dialogBox_bilyet_inst_in").dialog("close");
}  

function do_get_bilyet_inst_none ()
{
    state_progress(1);       
    clear_field_bilyet_inst_in();
    var obj_post = $.post(uri+"/index.php/itd_bilyet/get_bilyet_inst_none", 
        { trx_id:trx_id_bilyet },function(data) {
        if(data.r_num_rows>0)
        {
            $("#dlgBilIn_to").html(data.r_sdata[0].trx_to); 
            $("#dlgBilIn_client_acc").html(data.r_sdata[0].trx_acc_no); 
            $("#dlgBilIn_client_name").html(data.r_sdata[0].trx_client_name); 
            $("#dlgBilIn_rate").html(data.r_sdata[0].trx_rate+'%'); 
            $("#dlgBilIn_type").html(data.r_sdata[0].type_desc); 
            $("#dlgBilIn_nominal").html(strtomoney(data.r_sdata[0].trx_nominal)); 
            $("#dlgBilIn_val_dt").html(data.r_sdata[0].trx_valuta_date_s); 
            $("#dlgBilIn_due_dt").html(data.r_sdata[0].trx_due_date_s); 
        }
        else
            alert("Instruksi tidak ada atau status bilyet in");
    },"json");
    obj_post.done(function(msg){           
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function do_bilyet_inst_in()
{
    state_progress(1);       
    var bilin_oncall = $('#dlgBilIn_oncall:checked').val() != undefined?$('#dlgBilIn_oncall:checked').val():0;
    var obj_post = $.post(uri+"/index.php/itd_bilyet/save_bilyet_inst_in", 
        { trx_id:trx_id_bilyet, bil_dt:$("#dlgBilIn_dt").val() , bil_no:$("#dlgBilIn_no").val() 
        , bil_desc:$("#dlgBilIn_desc").val(),bil_oncall:bilin_oncall },function(data) {
            
    },"json");
    obj_post.done(function(msg){          
        refresh_bilyet_status_count();   
        alert("Saving Bilyet No (IN) success");
        state_progress(0);         
        do_search_bilyet_inst_search();
        $("#dialogBox_bilyet_inst_in").dialog("close");
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error saving data :" + textStatus);
        state_progress(0);
        $("#dialogBox_bilyet_inst_in").dialog("close");
    });
}
function clear_field_bilyet_inst_in()
{
    clientid=0;
    $("#dlgBilIn_bank_name").html(''); 
    $("#dlgBilIn_acc_no").html('');
    $("#dlgBilIn_acc_name").html('');
    $("#dlgBilIn_type").html('');
    $("#dlgBilIn_nominal").html('');
    $("#dlgBilIn_val_dt").html('');
    $("#dlgBilIn_due_dt").html('');
    $("#dlgBilIn_no").val('');
    $("#dlgBilIn_desc").val('');
    $("#dlgBilIn_dt").val(saiki);
    $("#dlgBilIn_oncall").attr("checked",false);
}
function set_dt_picker_bilyet_inst_in()
{
    $("#dlgBilIn_dt").datepicker();
    $("#dlgBilIn_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
}