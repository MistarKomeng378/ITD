var trxid=0;
var trx_master =0;
var trx_upper =0 ;
var trxunixno=1;
var trx_cetak=0;  


function set_var_dlg_trx(t_id,t_mast,t_up)
{
    trxid = t_id;
    trxid_master = t_mast;        
    trxid_upper = t_up;
}   
function get_content_trx()
{
    var obj_post = $.post(uri_dlg_trx,{},function(data) {
        $("#dialogBox_frm_trx").html(data);
    });
    obj_post.done(function(msg) { 
        //set_dt_picker_trx();
        //create_dlg_dpicker_trx();
        //set_select_trx_type();
        //set_select_trx_deposit_type();
        
        
    });
}
function create_dlg_trx()
{
    var height_client = get_client_size().height;
    if(height_client>590)
        height_client=600;
    else
        height_client=height_client-10;
    get_content_trx();
    $("#dialogBox_frm_trx").dialog({ 
            title:        'Instruksi Transaksi Deposito'
        ,    width:        700
        ,   height:     height_client
         ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Close": function(){$(this).dialog("close");}
          }
          , open : function (event,ui){
              var today = new Date();
              var monthromawi=['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
              var curmonth = today.getMonth();
              var curyear = today.getFullYear();
              $("#s_trx_ref").html('XXX/CUSTODY/CIMBNIAGA/'+monthromawi[curmonth]+'/'+curyear);
              //show_hide_btn_dlg_trx();
          }
          , close: function(event, ui) {
              //dPicker_hide_force();
          }
        });
        
}

/* edited
    act_dlg_trx
        0 new instruction
        1 approve instruction
        2 edit instruction
        5 cancel instruction
        100 open instruction
    type_dlg_trx
        trx type
*/
var act_dlg_trx_no=0;
function open_dlg_trx(act_dlg_trx,type_dlg_trx,unix_dlg_trx)
{   
    trxunixno = unix_dlg_trx;
    act_dlg_trx_no =act_dlg_trx;    
    ena_break_trx0(type_dlg_trx,0);
    $("#i_trx_move_bilyet").attr("checked",false);
    $("#s_trx_bilyet_no").hide();
    $("#s_trx_cek_tipe").html('');
    if(act_dlg_trx==1)
    {
        disable_input_trx();
        do_refresh_trx(type_dlg_trx);
    }
    else if(act_dlg_trx==2)
    {
        enable_input_trx();
        do_refresh_trx(type_dlg_trx);
        
    }
    else if(act_dlg_trx==3 || act_dlg_trx==5 || act_dlg_trx==100)
    {
        do_refresh_trx(type_dlg_trx);
        disable_input_trx();
    }
    else
    {
        if(type_dlg_trx==1)
            clear_input(type_dlg_trx);
        else
        {
            do_refresh_trx(type_dlg_trx);
            $("#s_trx_bilyet_no").show();              
        }
        enable_input_trx();
    }
    //show_hide_btn_dlg_trx(act_dlg_trx);
     $("#i_trx_dt").val(saiki);
     $("#dialogBox_frm_trx").dialog("open");
     
}

function close_dlg_trx()
{
     $("#dialogBox_frm_trx").dialog("close");
}


function  do_refresh_trx(no_tt)
{ 
    if(trxid!=0)
    {                           
        state_progress(1);    
        var obj_post = $.post(uri+"/index.php/itd/get_trx", 
            { trx_id:trxid,trx_unix:trxunixno},function(data) { 
            if(data.r_num_rows>0){                 
              load_data_trx(data.r_sdata[0],no_tt);
              /*if(data.r_sdata[0].trx_progress_status!=2)
                disable_input_trx();
              else
                enable_input_trx();
              set_state_trx();     */
            }
        },"json"); 
        obj_post.done(function(msg) { 
            $("#trx_nominal").html(strtomoney($("#i_trx_nominal").val()));
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Loading data error :" + textStatus);
            state_progress(0);
        });
    }    
    else
    {
        clear_input();       
        enable_input_trx();
    }
}
function  set_state_trx()
{
    var obj_post = $.post(uri+"/index.php/itd/get_trx_info", 
        { trx_id:trxid,trx_unix:trxunixno},function(data) {
        if(data.r_num_rows>0){
           // alert(data.r_sdata[0].trx_status);
            if(data.r_sdata[0].lvl<=5 && trxunixno==1 && data.r_sdata[0].own_trx==0 && data.r_sdata[0].trx_status1==1)
                show_hide_btn_dlg_trx(10);
            if(data.r_sdata[0].lvl<=5 && trxunixno==1 && data.r_sdata[0].own_trx==1 && data.r_sdata[0].trx_status1==2)
                show_hide_btn_dlg_trx(11);
            if(data.r_sdata[0].lvl>5 && trxunixno==1 && data.r_sdata[0].own_trx==1 && data.r_sdata[0].trx_status==2)
                show_hide_btn_dlg_trx(11);
        }
    },"json");
}
function load_data_trx(pdata,no_tt)
{                                                            
    $("#i_trx_to").val(pdata.trx_to);
    $("#i_trx_up").val(pdata.trx_up);
    $("#i_trx_remark1").val(pdata.trx_remark1);
    $("#i_trx_telp").val(pdata.trx_telp);
    $("#i_trx_fax").val(pdata.trx_fax);
    $("#i_trx_ref").val(pdata.trx_ref);
    $("#s_trx_ref").html(pdata.trx_ref);
    
    if(no_tt==0)
    {
        $("#i_trx_type").val(pdata.trx_type);
        $("#s_trx_type").html(pdata.type_desc);
        if(pdata.trx_type==4) $("#s_trx_tgl_break").show();
        else $("#s_trx_tgl_break").hide();
    }
    else  if(act_dlg_trx_no==5)
    {                         
        $("#i_trx_type").val(pdata.trx_type);
         $("#s_trx_type").html(pdata.trx_type==1?"Penempatan":pdata.trx_type==2?"Perpanjangan":pdata.trx_type==3?"Pencairan":"Break - ");
         if(pdata.trx_type=='4') $("#s_trx_tgl_break").show();      
         else $("#s_trx_tgl_break").hide();
    }
    else
    {
          $("#i_trx_type").val(no_tt);
         $("#s_trx_type").html(no_tt==1?"Penempatan":no_tt==2?"Perpanjangan":no_tt==3?"Pencairan":"Break - ");
         if(no_tt=='4') $("#s_trx_tgl_break").show();      
         else $("#s_trx_tgl_break").hide();
         //$("#s_trx_tgl_break").show();
    }
    $("#i_trx_deposit_type").val(pdata.trx_deposit_type);
    $("#i_trx_deposit_tenor").val(pdata.trx_deposit_tenor_hr);
    if (pdata.trx_deposit_type>1)
        $("#s_trx_deposit_tenor").html(pdata.bulan + ' Bulan');
    $("#i_trx_curr").val(pdata.trx_curr);
    $("#i_trx_tax_status").val(pdata.trx_tax_status);
    $("#i_trx_payment_type").val(pdata.trx_rate_payment);
    $("#i_trx_dt").val(pdata.trx_date_s);
    if(act_dlg_trx_no==2 && pdata.trx_type==2)
       $("#s_trx_bilyet_no").show();
    
    if(pdata.trx_type==4)
        $("#i_trx_break_dt").val(pdata.trx_break_dt_s);
    $("#i_trx_valuta_dt").val(pdata.trx_valuta_date_s);
    $("#i_trx_due_dt").val(pdata.trx_due_date_s);
    $("#i_trx_client_code").val(pdata.trx_client_code);
    $("#i_trx_client_name").val(pdata.trx_client_name);
    $("#s_trx_client_name").html(pdata.trx_client_name);
    $("#i_trx_nominal").val(+pdata.trx_nominal);
    $("#i_trx_rate").val(pdata.trx_rate);
    $("#i_trx_client_acc_no").val(pdata.trx_acc_no);
    $("#s_trx_client_acc_no").html(pdata.trx_acc_no);
    $("#i_trx_client_bank_name").val(pdata.trx_bank_name);
    $("#s_trx_client_bank_name").html(pdata.trx_bank_name);
    $("#i_trx_client_acc_name").val(pdata.trx_acc_name);
    $("#s_trx_client_acc_name").html(pdata.trx_acc_name);
    $("#i_trx_due_dt_status").val(pdata.trx_due_date_type);  
    $("#i_trx_dst_rek").val(pdata.bank_acc_no);
    $("#i_trx_dst_acc_name").val(pdata.bank_acc_name);
    $("#h_trx_pic_id").val(pdata.pic_id);
    $("#i_trx_other").val(pdata.trx_other);
    //if(trxunixno==1 && pdata.trx_progress_status==2 )
        $("#i_trx_note").val(pdata.trx_revise_note);
    $("#i_trx_client_id").val(pdata.trx_client_id);
    $("#s_trx_key").html(pdata.val_key);
    if(pdata.bilyet_no!='')
        $("#i_trx_bilyet_no").html('NO BILYET: ' + pdata.bilyet_no + ', STATUS: ' + pdata.bilyet_desc);
    else
        $("#i_trx_bilyet_no").html('<font color="#FF0000">BELUM ADA BILYET.</font>');
    if(pdata.trx_bilyet_flag_no=='FOLLOW')
        $("#i_trx_move_bilyet").attr("checked",true);
    else
        $("#i_trx_move_bilyet").attr("checked",false);
    ena_break_trx1(pdata.trx_type,pdata.trx_rate_break);
    
    
}
function clear_input(no_tt)
{
    var input_check = ["i_trx_to","i_trx_up","i_trx_dt","i_trx_valuta_dt",
            "i_trx_due_dt","i_trx_nominal","i_trx_rate","i_trx_client_id"];
    input_is_needed_clear(input_check);
    var input_list = ["i_trx_to","i_trx_remark1","i_trx_up","i_trx_telp","i_trx_fax","i_trx_client_code","i_trx_client_name",
            "i_trx_client_acc_no","i_trx_client_bank_name","i_trx_client_acc_name","i_trx_dt","i_trx_valuta_dt","i_trx_due_dt",
            "i_trx_trx_other","i_trx_trx_note","i_trx_nominal","i_trx_rate","i_trx_client_id","i_trx_other","i_trx_dst_rek",
            "i_trx_dst_acc_name","h_trx_pic_id"];
    for(var i=0;i<input_list.length;i++)
    {
        $("#"+input_list[i]).val('');
    }
    var html_list = ["s_trx_client_code","s_trx_client_name","s_trx_client_acc_no","s_trx_client_bank_name",
            "s_trx_client_acc_name","trx_nominal"];
    for(var i=0;i<html_list.length;i++)
    {
        $("#"+html_list[i]).html('');
    }
    $("#i_trx_type").val(no_tt);
    $("#s_trx_type").html(no_tt==1?"Penempatan":no_tt==2?"Perpanjangan":no_tt==3?"Pencairan":"Break - ");
    if(no_tt=='4') $("#s_trx_tgl_break").show();
    else $("#s_trx_tgl_break").hide();
     $("#i_trx_rate_break").val('');
}
function enable_input_trx(no)
{
      var input_list = ["i_trx_to","i_trx_remark1","i_trx_up","i_trx_telp","i_trx_fax","i_trx_client_code","i_trx_client_name",
            "i_trx_client_acc_no","i_trx_client_bank_name","i_trx_client_acc_name","i_trx_dt","i_trx_valuta_dt","i_trx_due_dt",
            "i_trx_trx_other","i_trx_trx_note","i_trx_nominal","i_trx_rate","i_trx_type","i_trx_break_dt","i_trx_deposit_type",
            "i_trx_deposit_tenor","i_trx_valuta_dt","i_trx_due_dt","i_trx_client_code","i_trx_curr","i_trx_tax_status",
            "i_trx_payment_type","i_trx_due_dt_status","i_trx_other"];
    for(var i=0;i<input_list.length;i++)
    {
        $("#"+input_list[i]).removeAttr('disabled');
    }
}
function disable_input_trx()
{                                        
       var input_list = ["i_trx_to","i_trx_remark1","i_trx_up","i_trx_telp","i_trx_fax","i_trx_client_code","i_trx_client_name",
            "i_trx_client_acc_no","i_trx_client_bank_name","i_trx_client_acc_name","i_trx_dt","i_trx_valuta_dt","i_trx_due_dt",
            "i_trx_trx_other","i_trx_trx_note","i_trx_nominal","i_trx_rate","i_trx_break_dt","i_trx_deposit_type",
            "i_trx_deposit_tenor","i_trx_valuta_dt","i_trx_due_dt","i_trx_client_code","i_trx_curr","i_trx_tax_status",
            "i_trx_payment_type","i_trx_due_dt_status","i_trx_other"];
    for(var i=0;i<input_list.length;i++)
    {
        $("#"+input_list[i]).attr('disabled',true);
    }
}
function set_dlg_event_trx()
{
}
function ena_break_trx0(p_no,p_nil)
{
    $("#i_trx_rate_break").val(p_nil);
    if(act_dlg_trx_no==0)
    {
        if(p_no==4)
        {   
            $("#td_trx_rate_break").show();
            $("#td_trx_rate_break1").show();
            $("#i_trx_rate").attr('readonly','readonly');
            $("#i_trx_rate_break").removeAttr('readonly');
        }
        else
        {
            $("#td_trx_rate_break").hide();
            $("#td_trx_rate_break1").hide();
            $("#i_trx_rate").removeAttr('readonly');
        }
    }
}
function ena_break_trx1(p_no,p_nil)
{
    if(act_dlg_trx_no!=0)
    {
        $("#i_trx_rate_break").val(p_nil);
        $("#i_trx_rate").attr('readonly','readonly');
        $("#i_trx_rate_break").attr('readonly','readonly');
        if(p_no==4)
        {   
            $("#td_trx_rate_break").show();
            $("#td_trx_rate_break1").show();
            if(act_dlg_trx_no==2)
                $("#i_trx_rate_break").removeAttr('readonly');
        }
        else
        {
            $("#td_trx_rate_break").hide();
            $("#td_trx_rate_break1").hide();
        }
    }    
}
