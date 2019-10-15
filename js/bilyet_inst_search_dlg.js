function get_content_bilyet_inst_search()
{             
    var obj_post = $.post(uri_dlg_bilyet_inst_search,{},function(data) {      
        $("#dialogBox_bilyet_inst_search").html(data);
    });
    obj_post.done(function(msg) { 
        set_dt_picker_bilyet_inst_search(); 
    });
}
function create_dlg_bilyet_inst_search()
{
    get_content_bilyet_inst_search();
    $("#dialogBox_bilyet_inst_search").dialog({ 
            title:        'Instruksi Transaksi Deposito - Client'
        ,    width:        400
        ,    height:        300
                ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cari": function(){do_search_bilyet_inst_search();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_bilyet_inst_search(c_id)
{
    $("#dialogBox_bilyet_inst_search").dialog("open");
}
function close_dlg_bilyet_inst_search()
{
    clientid=0;
    $("#dialogBox_bilyet_inst_search").dialog("close");
}  
function do_search_bilyet_inst_search()
{
    list_type_bilyet=0;
    if ( $("#dlgBil_no").val()=='' && $("#dlgBil_client_name").val()=='' && $("#dlgBil_bank_name").val()=='' && $("#dlgBil_val_dt").val()=='' && $("#dlgBil_due_dt").val()=='' && $("#dlgBil_nominal").val() == '' && $("#dlgBil_client_code").val() == ''&& $("#dlgBil_to").val() == ''
            && ( $("#dlgBil_type").val() == '2' || $("#dlgBil_type").val() == '3' || $("#dlgBil_type").val() == '100'))
    {
            alert('Masukkan salah satu kategori pencarian!');
            return 0;
    }                          
    state_progress(1);     
    data_bilyet_inst.length=0;                        
    var obj_post = $.post(uri+"/index.php/itd_bilyet/get_bilyet_inst_search", 
        { b_no:$("#dlgBil_no").val(),b_cname:$("#dlgBil_client_name").val(),b_bname:$("#dlgBil_bank_name").val(),b_val_dt:$("#dlgBil_val_dt").val(),
        b_due_dt:$("#dlgBil_due_dt").val(),b_nominal:$("#dlgBil_nominal").val(),b_type:$("#dlgBil_type").val(), b_ccode:$("#dlgBil_client_code").val()
        ,b_to:$("#dlgBil_to").val()},function(data) {                
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_bilyet_inst[i] = {});
           d["trx_id"] = data.r_sdata[i].trx_id;  
           d["trx_bilyet_rcv"] = data.r_sdata[i].trx_bilyet_flag_no='' || data.r_sdata[i].trx_bilyet_flag_no=='NONE' ? '':data.r_sdata[i].trx_bilyet_flag_no ;
           d["trx_bilyet_no"] = data.r_sdata[i].trx_bilyet_flag_no=='IN'?data.r_sdata[i].no_in:data.r_sdata[i].trx_bilyet_flag_no=='OUT'?data.r_sdata[i].no_out:'';
           d["trx_bilyet_to"] = data.r_sdata[i].trx_to;
           d["trx_bank_name"] = data.r_sdata[i].trx_bank_name;
           d["trx_rate"] = data.r_sdata[i].trx_rate + '%';
           d["trx_acc_no"] = data.r_sdata[i].trx_acc_no;
           d["trx_acc_name"] = data.r_sdata[i].trx_acc_name;
           d["trx_client_name"] = data.r_sdata[i].trx_client_name;
           d["trx_type"] = data.r_sdata[i].type_desc;             
           d["trx_client_name"] = data.r_sdata[i].trx_client_name;
           d["trx_nominal"] = strtomoney(data.r_sdata[i].trx_nominal);
           d["trx_val_dt"] = data.r_sdata[i].trx_valuta_date_s;
           d["trx_due_dt"] = data.r_sdata[i].trx_due_date_s;
           d["trx_due_dt"] = data.r_sdata[i].trx_due_date_s;
           d["trx_in_dt"] = data.r_sdata[i].trx_bilyet_flag_no=='IN'?data.r_sdata[i].dt_in_s:data.r_sdata[i].trx_bilyet_flag_no=='OUT'?data.r_sdata[i].dt_in1_s:'';
           d["trx_out_dt"] = data.r_sdata[i].trx_bilyet_flag_no=='OUT'?data.r_sdata[i].dt_out_s:'';
        }
    },'json');
    obj_post.done(function(msg){
        grid_bilyet_inst.invalidateAllRows();
        grid_bilyet_inst.updateRowCount();
        grid_bilyet_inst.render();
        state_progress(0);
        $("#dialogBox_bilyet_inst_search").dialog("close");
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function set_dt_picker_bilyet_inst_search()
{
    $("#dlgBil_val_dt").datepicker();
    $("#dlgBil_val_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#dlgBil_due_dt").datepicker();
    $("#dlgBil_due_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
}
function set_field_bilyet_inst_search(bilno,biltype)
{
    $("#dlgBil_no").val(bilno);
    $("#dlgBil_type").val(biltype);
}
function clear_field_bilyet_inst_search()
{
    $("#dlgBil_no").val('');
    $("#dlgBil_client_name").val('');
    $("#dlgBil_bank_name").val('');
    $("#dlgBil_val_dt").val('');
    $("#dlgBil_due_dt").val('');
    $("#dlgBil_nominal").val('');
    $("#dlgBil_type").val('0');
}
