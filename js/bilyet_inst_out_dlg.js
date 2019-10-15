function get_content_bilyet_inst_out()
{                        
    var obj_post = $.post(uri_dlg_bilyet_inst_out,{},function(data) {
        $("#dialogBox_bilyet_inst_out").html(data);
    });                  
    obj_post.done(function(msg) { 
        set_dt_picker_bilyet_inst_out(); 
    });
}
function create_dlg_bilyet_inst_out()
{
    get_content_bilyet_inst_out();
    $("#dialogBox_bilyet_inst_out").dialog({ 
            title:        'Instruksi Transaksi Deposito - Proses Bilyet Keluar'
        ,    width:        460
        ,    height:        380
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Bilyet Keluar": function(){
                 if (confirm('Bilyet Out : ' + $("#dlgBilOut_no").html() + ' ?'))
                    do_bilyet_inst_out();
             },    
            "Update Bilyet": function(){
                if (confirm('Update Bilyet  ?'))
                    do_bilyet_inst_update();
            },
             "Batal": function(){ $(this).dialog("close");}
        }
    });          
}
function open_dlg_bilyet_inst_out(c_id)
{
    $("#dialogBox_bilyet_inst_out").dialog("open");     
    
}
function close_dlg_bilyet_inst_out()
{
    trx_id_bilyet=0;
    $("#dialogBox_bilyet_inst_out").dialog("close");
}  

function do_get_bilyet_inst_in ()
{
    state_progress(1);       
    clear_field_bilyet_inst_out();
    var obj_post = $.post(uri+"/index.php/itd_bilyet/get_bilyet_inst_in", 
        { trx_id:trx_id_bilyet },function(data) { 
        if(data.r_num_rows>0)
        {
            $("#dlgBilOut_to").html(data.r_sdata[0].trx_to); 
            $("#dlgBilOut_client_acc").html(data.r_sdata[0].trx_acc_no); 
            $("#dlgBilOut_client_name").html(data.r_sdata[0].trx_client_name); 
            $("#dlgBilOut_rate").html(data.r_sdata[0].trx_rate+'%'); 
            $("#dlgBilOut_type").html(data.r_sdata[0].type_desc); 
            $("#dlgBilOut_nominal").html(strtomoney(data.r_sdata[0].trx_nominal)); 
            $("#dlgBilOut_val_dt").html(data.r_sdata[0].trx_valuta_date_s); 
            $("#dlgBilOut_due_dt").html(data.r_sdata[0].trx_due_date_s); 
            $("#dlgBilOut_dt_in").html(data.r_sdata[0].bilyet_dt_in_s); 
            $("#dlgBilOut_no").val(data.r_sdata[0].bilyet_no); 
            $("#dlgBilOut_desc").val(data.r_sdata[0].bilyet_desc); 
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
function do_bilyet_inst_out()
{
    state_progress(1);       
    var obj_post = $.post(uri+"/index.php/itd_bilyet/save_bilyet_inst_out", 
        { trx_id:trx_id_bilyet, bil_dt:$("#dlgBilOut_dt").val(), bil_desc:$("#dlgBilOut_desc").val() },function(data) {
    },"json");
    obj_post.done(function(msg){      
        refresh_bilyet_status_count();       
        alert("Getting Bilyet No (Out) success");
        state_progress(0);
        do_search_bilyet_inst_search();             
        $("#dialogBox_bilyet_inst_out").dialog("close");
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error saving data :" + textStatus);
        state_progress(0);
        $("#dialogBox_bilyet_inst_out").dialog("close");
    });
}

function do_bilyet_inst_update()
{
    state_progress(1);       
    var obj_post = $.post(uri+"/index.php/itd_bilyet/update_bilyet_inst", 
        { trx_id:trx_id_bilyet, bil_no:$("#dlgBilOut_no").val(), bil_desc:$("#dlgBilOut_desc").val() },function(data) {
    },"json");
    obj_post.done(function(msg){      
        alert("Update bilyet success");
        state_progress(0);
        do_search_bilyet_inst_search();             
        $("#dialogBox_bilyet_inst_out").dialog("close");
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error saving data :" + textStatus);
        state_progress(0);
        $("#dialogBox_bilyet_inst_out").dialog("close");
    });
}


function clear_field_bilyet_inst_out()
{                    
    $("#dlgBilOut_bank_name").html(''); 
    $("#dlgBilOut_acc_no").html('');
    $("#dlgBilOut_acc_name").html('');
    $("#dlgBilOut_type").html('');
    $("#dlgBilOut_nominal").html('');
    $("#dlgBilOut_val_dt").html('');
    $("#dlgBilOut_due_dt").html('');
    $("#dlgBilOut_dt").html('');
    $("#dlgBilOut_no").val('');
    $("#dlgBilOut_desc").val('');
    $("#dlgBilOut_dt").val(saiki);    
}
function set_dt_picker_bilyet_inst_out()
{
    $("#dlgBilOut_dt").datepicker();
    $("#dlgBilOut_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
}