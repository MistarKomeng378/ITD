
var giro_id_dlg_mutasi11_4=0;

function get_content_mutasi11_4()
{                     
    var obj_post = $.post(uri_mutasi11_dlg4,function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_mutasi11_4").html(msg);
        $("#i_mutasi11_dlg4_pdt").datepicker();
        $("#i_mutasi11_dlg4_pdt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#i_mutasi11_dlg4_c_dt1").datepicker();
        $("#i_mutasi11_dlg4_c_dt1").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        mutasi11_dlg4_create_event();
        get_content_dlg_user_mutasi11_4();
    });
}
function get_content_dlg_user_mutasi11_4()
{
    $("#i_mutasi11_dlg4_proc").html('');
    var obj_post1 = $.post(uri+"/index.php/itd/list_user",{u_unit:1},function(data1) {   
        },"json");
    obj_post1.done(function(msg1) {    //alert(msg.r_num_rows);
        if(msg1.r_num_rows>0)
        {
            var sta='<option value="ALL">***ALL***</option>\n';
            for (var i=0; i<msg1.r_num_rows; i++) {
                sta=sta+'<option value="'+msg1.r_sdata[i].user_id+'">'+msg1.r_sdata[i].user_name+'</option>\n';
            }
            $("#i_mutasi11_dlg4_proc").html(sta);
        }
    });
}

function create_dlg_mutasi11_4()
{
    get_content_mutasi11_4()
    $("#dialogBox_mutasi11_4").dialog({ 
            title:        'Cetak Jasa Giro'
        ,    width:        875
        ,    height:        420
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cetak Jasa Giro": function(){
                   //window.open(uri+'index.php/mutasi_dlg/print_4/'+$("#i_mutasi11_dlg4_c_dt1").val()+'_'+$("#i_mutasi11_dlg4_pdt").val()+'_'+$("#i_mutasi11_dlg4_proc").val());
                 loadPrintDocument(uri+'index.php/mutasi_dlg/print_4/'+$("#i_mutasi11_dlg4_c_dt1").val()+'_'+$("#i_mutasi11_dlg4_pdt").val()+'_'+$("#i_mutasi11_dlg4_proc").val());    
             }, 
             "Simpan Jasa Giro":function(){
                  window.open(uri+'index.php/mutasi_dlg/save_4/'+$("#i_mutasi11_dlg4_c_dt1").val()+'_'+$("#i_mutasi11_dlg4_pdt").val()+'_'+$("#i_mutasi11_dlg4_proc").val());
             },
             "Tutup": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_4(ccode,cname,accno,cdt)
{           
    mutasi11_dlg4_clear();
    $("#i_mutasi11_dlg4_c_code").val(ccode);
    $("#i_mutasi11_dlg4_c_name").val(cname);
    $("#i_mutasi11_dlg4_acc_no").val(accno);
    $("#i_mutasi11_dlg4_cname").val(cname);
    $("#i_mutasi11_dlg4_ano").val(accno);           
    $("#i_mutasi11_dlg4_proc").val(user_id);
    
    $("#dialogBox_mutasi11_4").dialog("open");
    $("#i_mutasi11_dlg4_pdt").val(saiki);
    $("#i_mutasi11_dlg4_c_dt1").val(saiki);
    get_last_giro_mutasi11_dlg4(user_id);          
              
}
function close_dlg_mutasi11_4()
{
    $("#dialogBox_mutasi11_2").dialog("close");
}

function get_last_giro_mutasi11_dlg4(p_uid)
{                                                                           
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/mutasi/get_last_date_jasgir_by_user", {u_id:p_uid},function(data) {
        state_progress(0);
    },"json"); 
    obj_post.done(function(msg) {
        if(msg.r_num_rows>0)
        {
            get_giro_mutasi11_dlg4(msg.r_sdata[0].giro_val_date_s,msg.r_sdata[0].giro_asof_date_s,p_uid);
            $("#i_mutasi11_dlg4_pdt").val(msg.r_sdata[0].giro_asof_date_s); 
            $("#i_mutasi11_dlg4_c_dt1").val(msg.r_sdata[0].giro_val_date_s);
        }
        else
        {
            get_giro_mutasi11_dlg4(saiki,saiki,p_uid);
            $("#i_mutasi11_dlg4_pdt").val(saiki);
            $("#i_mutasi11_dlg4_c_dt1").val(saiki);
        }
        
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function get_giro_mutasi11_dlg4(pc_dt,pv_dt,p_uid)
{                                                                   
    state_progress(1); 
    var obj_post1 = $.post(uri+"/index.php/mutasi_dlg/get_giro_val_asof_by_user", {c_dt:pc_dt,v_dt:pv_dt,u_id:p_uid},function(data) {      
        $("#i_mutasi11_dlg4_detail").html(data);
        state_progress(0);
    }); 
    obj_post1.fail(function(jqXHR, textStatus) {
        $("#i_mutasi11_dlg4_detail").html('');
        state_progress(0);
    });
}
function mutasi11_dlg4_create_event()
{                                 
    var taxnya=20/100;
    $("#b_mutasi11_dlg4_getdata").click(function(){  
        get_giro_mutasi11_dlg4($("#i_mutasi11_dlg4_c_dt1").val(),$("#i_mutasi11_dlg4_pdt").val(),$("#i_mutasi11_dlg4_proc").val());
    });
}
function mutasi11_dlg4_clear()
{
    
}