function get_content_dlg_trx_search()
{        
    var obj_post = $.post(uri_dlg_trx_search,{},function(data) {
        $("#dialogBox_frm_trx_search").html(data);
    });
    obj_post.done(function(msg) { 
        set_event_dlg_trx_search();
        $("#dlgTrxSearch_sdate").datepicker();
        $("#dlgTrxSearch_sdate").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#dlgTrxSearch_edate").datepicker();
        $("#dlgTrxSearch_edate").datepicker( "option", "dateFormat", 'dd-mm-yy' );
        $("#dlgTrxSearch_sdate").val(saiki);
        $("#dlgTrxSearch_edate").val(saiki);
    });
}
function create_dlg_trx_search()
{
    get_content_dlg_trx_search();           
    $("#dialogBox_frm_trx_search").dialog({ 
            title:        'Instruksi Transaksi Deposito - Search'
        ,    width:        320
        ,   height:     280
         ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cari": function(){ do_dlg_trx_search();close_dlg_trx_search();  },
             "Cari & Save": function(){ do_dlg_trx_search_save();close_dlg_trx_search();  },
             "Batal": function(){$(this).dialog("close");}
          }
          , open : function (event,ui){  
             
          }
          , close: function(event, ui) { 
             
          }
        });               
        
}       
function open_dlg_trx_search()
{
     $("#dialogBox_frm_trx_search").dialog("open");
     if  ($("#dlgTrxSearch_nominal_type").val()=='0')
             $("#dlgTrxSearch_nominal").attr("disabled",true);
        else
            $("#dlgTrxSearch_nominal").removeAttr("disabled");
}
function close_dlg_trx_search()
{
     $("#dialogBox_frm_trx_search").dialog("close");
}
function do_dlg_trx_search()
{
    state_progress(1);      
    data_trx.length=0;            
    var obj_post = $.post(uri+"index.php/itd/search_trx_approved",{
        trx_to:$("#dlgTrxSearch_to").val(),trx_ccode:$("#dlgTrxSearch_client_code").val() ,
        trx_cname:$("#dlgTrxSearch_client_name").val(),trx_stype:$("#dlgTrxSearch_type").val() ,
        trx_nominal:$("#dlgTrxSearch_nominal").val(),trx_ntype:$("#dlgTrxSearch_nominal_type").val() 
        ,trx_sdate:$("#dlgTrxSearch_sdate").val(),trx_edate:$("#dlgTrxSearch_edate").val(),
        trx_id:$("#dlgTrxSearch_id").val()
        },function(data) {        
       // alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_trx[i] = {});
           d["trx_unix_no"] = data.r_sdata[i].trx_unix_no;
           d["trx_id"] = data.r_sdata[i].trx_id;
           d["trx_id_master"] = data.r_sdata[i].trx_id_master;
           d["trx_id_upper"] = data.r_sdata[i].trx_id_upper;
           d["trx_status"] = data.r_sdata[i].status_desc;
           d["trx_to"] = data.r_sdata[i].trx_to;
           d["trx_client_name"] = data.r_sdata[i].trx_client_name;
           d["trx_type_id"] = data.r_sdata[i].trx_type;
           d["trx_type"] = data.r_sdata[i].type_desc;
           d["trx_nominal"] = strtomoney(data.r_sdata[i].trx_nominal);  
           d["trx_rate"] = data.r_sdata[i].trx_rate + "%";
           d["trx_payment"] = data.r_sdata[i].payment_desc;
           d["trx_create_dt"] = data.r_sdata[i].trx_create_dt_s;
           d["trx_create_by"] = data.r_sdata[i].trx_create_by;
           d["trx_valuta_dt"] = data.r_sdata[i].trx_valuta_date_s;
           d["trx_due_dt"] = data.r_sdata[i].trx_due_date_s;
           d["trx_child_status"] = data.r_sdata[i].trx_child_status;
           d["trx_bilyet_flag_no"] = data.r_sdata[i].trx_bilyet_flag_no;   
        }
    },'json');
    obj_post.done(function(msg){
        
        grid_trx.invalidateAllRows();
        grid_trx.updateRowCount();
        grid_trx.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function do_dlg_trx_search_save()
{
    $("#dlgTrxSearch_to1").val($("#dlgTrxSearch_to").val());
    $("#dlgTrxSearch_client_code1").val($("#dlgTrxSearch_client_code").val());
    $("#dlgTrxSearch_client_name1").val($("#dlgTrxSearch_client_name").val());
    $("#dlgTrxSearch_type1").val($("#dlgTrxSearch_type").val());     
    $("#dlgTrxSearch_nominal1").val($("#dlgTrxSearch_nominal").val());
    $("#dlgTrxSearch_nominal_type1").val($("#dlgTrxSearch_nominal_type").val());
    $("#dlgTrxSearch_sdate1").val($("#dlgTrxSearch_sdate").val());
    $("#dlgTrxSearch_edate1").val($("#dlgTrxSearch_edate").val());
    $("#dlgTrxSearch_id1").val($("#dlgTrxSearch_id").val());
    
    state_progress(1);      
    data_trx.length=0;            
    var obj_post = $.post(uri+"index.php/itd/search_trx_approved",{
        trx_to:$("#dlgTrxSearch_to").val(),trx_ccode:$("#dlgTrxSearch_client_code").val() ,
        trx_cname:$("#dlgTrxSearch_client_name").val(),trx_stype:$("#dlgTrxSearch_type").val() ,
        trx_nominal:$("#dlgTrxSearch_nominal").val(),trx_ntype:$("#dlgTrxSearch_nominal_type").val() 
        ,trx_sdate:$("#dlgTrxSearch_sdate").val(),trx_edate:$("#dlgTrxSearch_edate").val(),
        trx_id:$("#dlgTrxSearch_id").val()
        },function(data) {        
       // alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_trx[i] = {});
           d["trx_unix_no"] = data.r_sdata[i].trx_unix_no;
           d["trx_id"] = data.r_sdata[i].trx_id;
           d["trx_id_master"] = data.r_sdata[i].trx_id_master;
           d["trx_id_upper"] = data.r_sdata[i].trx_id_upper;
           d["trx_status"] = data.r_sdata[i].status_desc;
           d["trx_to"] = data.r_sdata[i].trx_to;
           d["trx_client_name"] = data.r_sdata[i].trx_client_name;
           d["trx_type_id"] = data.r_sdata[i].trx_type;
           d["trx_type"] = data.r_sdata[i].type_desc;
           d["trx_nominal"] = strtomoney(data.r_sdata[i].trx_nominal);  
           d["trx_rate"] = data.r_sdata[i].trx_rate + "%";
           d["trx_payment"] = data.r_sdata[i].payment_desc;
           d["trx_create_dt"] = data.r_sdata[i].trx_create_dt_s;
           d["trx_create_by"] = data.r_sdata[i].trx_create_by;
           d["trx_valuta_dt"] = data.r_sdata[i].trx_valuta_date_s;
           d["trx_due_dt"] = data.r_sdata[i].trx_due_date_s;
           d["trx_child_status"] = data.r_sdata[i].trx_child_status;
           d["trx_bilyet_flag_no"] = data.r_sdata[i].trx_bilyet_flag_no;   
        }
    },'json');
    obj_post.done(function(msg){
        grid_trx.invalidateAllRows();
        grid_trx.updateRowCount();
        grid_trx.render();
        state_progress(0);
        $("#dlgTrxSearch_frm").submit();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}


function set_event_dlg_trx_search()
{
    $("#dlgTrxSearch_nominal_type").change(function(){
        if  ($("#dlgTrxSearch_nominal_type").val()=='0')
             $("#dlgTrxSearch_nominal").attr("disabled",true);
        else
            $("#dlgTrxSearch_nominal").removeAttr("disabled");
    });
}