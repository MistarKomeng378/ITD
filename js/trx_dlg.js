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
        set_dt_picker_trx();
        create_dlg_dpicker_trx();
        //set_select_trx_type();
        //set_select_trx_deposit_type();
        set_dlg_event_trx();
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
             "Buat & Cetak Instruksi": function(){ do_submit_new_trx();},
             "Ubah & Cetak Instruksi": function(){ do_submit_edit_trx();},
             "Batalkan Instruksi": function(){ do_submit_cancel_trx();},
             "Approve Instruksi": function(){ trx_cetak=0;do_submit_approve_trx();},
             "Approve & Cetak Instruksi": function(){ trx_cetak=1;do_submit_approve_trx();},
             "Cetak": function(){ do_print_trx(trxid);},
             "Batal": function(){$(this).dialog("close");}
          }
          , open : function (event,ui){
              var today = new Date();
              var monthromawi=['I','II','III','IV','V','VI','VII','VIII','IX','X','XI','XII'];
              var curmonth = today.getMonth();
              var curyear = today.getFullYear();
              $("#s_trx_ref").html('XXX/CUSTODY/CIMBNIAGA/'+monthromawi[curmonth]+'/'+curyear);
              show_hide_btn_dlg_trx();
          }
          , close: function(event, ui) {
              dPicker_hide_force();
          }
        });
        
}
function create_dlg_dpicker_trx()
{
    var dpick_opt_pic ={
        cols : [         
                {id:"bank_name1", name:"Bank Name", field:"bank_name",width:180}
                ,{id:"bank_rek", name:"Bank Rek", field:"bank_rek",width:95}
                ,{id:"bank_acc_name", name:"Bank Acc Name", field:"bank_acc_name",width:130}
                ,{id:"pic_name1", name:"PIC", field:"pic_name",width:130}
                ,{id:"bank_telp", name:"Telepon", field:"bank_telp"}
                ,{id:"bank_fax", name:"Fax", field:"bank_fax"}
                ,{id:"pic_remark1", name:"Remark 1", field:"pic_remark1"}
                ,{id:"pic_remark2", name:"Remark 2", field:"pic_remark2"}
                ,{id:"pic_id", name:"i", field:"pic_id",width:1}
            ],
        url:  uri+"index.php/itd/list_pic_by_bank",
        setval: function(obj_val){
             $("#i_trx_to").val(obj_val.bank_name);   
             $("#i_trx_remark1").val(obj_val.pic_remark1);   
             $("#i_trx_up").val(obj_val.pic_name);   
             $("#i_trx_telp").val(obj_val.bank_telp);   
             $("#i_trx_fax").val(obj_val.bank_fax);  
             $("#i_trx_dst_rek").val(obj_val.bank_rek);  
             $("#i_trx_dst_acc_name").val(obj_val.bank_acc_name);  
             $("#h_trx_pic_id").val(obj_val.pic_id);
        }
    }; 
    dPicker_attach($("#i_trx_to"),dpick_opt_pic);
                                          
    var dpick_opt_client ={
        cols : [         
                   {id:"client_code", name:"Code", field:"client_code",width:50}
                   ,{id:"client_name", name:"Client Name", field:"client_name",width:180}
                   ,{id:"client_bank", name:"Bank Name", field:"bank_name",width:80}
                   ,{id:"client_acc_no", name:"Account No", field:"acc_no",width:100}
                   ,{id:"client_acc_name", name:"Account Name", field:"acc_name",width:180}
                   ,{id:"client_acc_cif", name:"CIF", field:"acc_cif"}
                   ,{id:"client_id", name:"cid", field:"client_id",width:1}
                   ,{id:"has_tax", name:"has_tax", field:"has_tax",width:1}
            ],
        url: uri+"index.php/itd/list_client_by_code",
        setval: function(obj_val){
            $("#i_trx_client_id").val(obj_val.client_id);                
            $("#i_trx_client_code").val(obj_val.client_code);
            $("#s_trx_client_name").html(obj_val.client_name);
            $("#i_trx_client_name").val(obj_val.client_name);
            $("#s_trx_client_acc_no").html(obj_val.acc_no);
            $("#i_trx_client_acc_no").val(obj_val.acc_no);
            $("#s_trx_client_bank_name").html(obj_val.bank_name);   
            $("#i_trx_client_bank_name").val(obj_val.bank_name);
            $("#s_trx_client_acc_name").html(obj_val.acc_name);
            $("#i_trx_client_acc_name").val(obj_val.acc_name);   
            $("#i_trx_tax_status").val(obj_val.has_tax);    
        }
    }; 
    dPicker_attach($("#i_trx_client_code"),dpick_opt_client);
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
    show_hide_btn_dlg_trx(act_dlg_trx);
     $("#i_trx_dt").val(saiki);
     $("#dialogBox_frm_trx").dialog("open");
     
}

function close_dlg_trx()
{
     $("#dialogBox_frm_trx").dialog("close");
}

function set_dt_picker_trx()
{
    $("#i_trx_valuta_dt").datepicker();
    $("#i_trx_valuta_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#i_trx_due_dt").datepicker();
    $("#i_trx_due_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#i_trx_break_dt").datepicker();
    $("#i_trx_break_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#s_trx_tgl_break").hide();
    $("#i_trx_dt").datepicker();
    $("#i_trx_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
}

function show_hide_btn_dlg_trx(no)
{
    if (no==0)
    {
        $($("button", $("#dialogBox_frm_trx").parent())[0]).show();
        $($("button", $("#dialogBox_frm_trx").parent())[1]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[2]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[3]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[4]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[5]).hide();
        $("#dlg_trx_note").hide();
        $("#dlg_trx_key").hide();
    }
    if (no==1)
    {
        $($("button", $("#dialogBox_frm_trx").parent())[0]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[1]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[2]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[3]).show();
        $($("button", $("#dialogBox_frm_trx").parent())[4]).show();
        $($("button", $("#dialogBox_frm_trx").parent())[5]).hide();
        $("#dlg_trx_note").hide();
        $("#dlg_trx_key").hide();
    }
    if (no==2)
    {
        $($("button", $("#dialogBox_frm_trx").parent())[0]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[1]).show();
        $($("button", $("#dialogBox_frm_trx").parent())[2]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[3]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[4]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[5]).hide();
        $("#dlg_trx_note").hide();
        $("#dlg_trx_key").hide();
    }
    if (no==3)
    {
        $($("button", $("#dialogBox_frm_trx").parent())[0]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[1]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[2]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[3]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[4]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[5]).show();
        $("#dlg_trx_note").hide();
        $("#dlg_trx_key").hide();
    }
    if (no==5)  
    {
        $($("button", $("#dialogBox_frm_trx").parent())[0]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[1]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[2]).show();
        $($("button", $("#dialogBox_frm_trx").parent())[3]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[4]).hide();
        $($("button", $("#dialogBox_frm_trx").parent())[5]).hide();       
        $("#dlg_trx_note").show();
        $("#dlg_trx_key").hide();
    }
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
    var selectType = $('#hselect_trx_type').val();
                                              
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
     
    // edit MK
    if((pdata.nfs_td=='1' && selectType == 2) || (pdata.nfs_td=='1' && selectType == 3) || (pdata.nfs_td=='1' && selectType == 4)){
        $("#i_trx_nominal").attr("disabled",true);
        $("#i_trx_rate").attr("disabled",true);
        $("#i_trx_due_dt").attr("disabled",true);
        $("#i_trx_valuta_dt").attr("disabled",true);
        $("#i_trx_deposit_tenor").attr("disabled",true);
        //$("#i_trx_client_code").attr("disabled",true);
        $("#i_trx_curr").attr("disabled",true);

    }else if(pdata.nfs_td=='1'){
        $("#i_trx_nominal").attr("disabled",true);
        $("#i_trx_rate").attr("disabled",true);
        $("#i_trx_due_dt").attr("disabled",true);
        $("#i_trx_valuta_dt").attr("disabled",true);
        $("#i_trx_deposit_tenor").attr("disabled",true);
        $("#i_trx_client_code").attr("disabled",true);
        $("#i_trx_curr").attr("disabled",true);

        $("#i_trx_to").attr("disabled",true);
        $("#i_trx_remark1").attr("disabled",true);
        $("#i_trx_up").attr("disabled",true);
        $("#i_trx_telp").attr("disabled",true);
        $("#i_trx_fax").attr("disabled",true);
    }
    
    
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
            "i_trx_payment_type","i_trx_due_dt_status","i_trx_other",];
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
function do_submit_new_trx()
{
    if((trim($("#i_trx_rate_break").val())==0 || trim($("#i_trx_rate_break").val())=='') && $("#i_trx_type").val()=='4')
    {
        alert('Please input Bunga Break!'); return 0;
    }
    var input_check = [
     {id:"i_trx_to",empty:false,type:"s"}
    ,{id:"i_trx_up",empty:false,type:"s"}
    ,{id:"i_trx_dt",empty:false,type:"d"}
    ,{id:"i_trx_valuta_dt",empty:false,type:"d"}
    ,{id:"i_trx_due_dt",empty:false,type:"d"}
    ,{id:"i_trx_nominal",empty:false,type:"n"}
    ,{id:"i_trx_rate",empty:false,type:"n"}
    ,{id:"i_trx_client_id",empty:false,type:"n"}
    ];
    //alert(trxid_master); alert(trxid_upper);  
    if(!input_is_needed(input_check))
    {
        if($.trim($("#i_trx_client_id").val())=='' || $.trim($("#i_trx_client_id").val())=='0')
            $("#s_trx_client_code").html("* Client belum dipilih.");
        else
            $("#s_trx_client_code").html("");
        return false;
    }
    if(confirm("Pastikan instruksi sudah benar!\nLanjut buat instruksi?"))
    {
        var mov_bilyet= $("#i_trx_move_bilyet:checked").val();
        if(mov_bilyet!=1 || trxid==0)
            mov_bilyet=0;
            
        state_progress(1);                      
        var obj_post = $.post(uri+"/index.php/itd_save/submit_new_trx", 
            { trx_to:$("#i_trx_to").val(),trx_remark1:$("#i_trx_remark1").val()
                ,trx_up:$("#i_trx_up").val(),trx_telp:$("#i_trx_telp").val(),trx_fax:$("#i_trx_fax").val()
                ,trx_c_code:$("#i_trx_client_code").val(),trx_c_name:$("#i_trx_client_name").val()
                ,trx_acc_no:$("#i_trx_client_acc_no").val(),trx_acc_name:$("#i_trx_client_acc_name").val()
                ,trx_bank_name:$("#i_trx_client_bank_name").val()
                ,trx_dt:$("#i_trx_dt").val(),trx_val_dt:$("#i_trx_valuta_dt").val()
                ,trx_due_dt:$("#i_trx_due_dt").val(),trx_other:$("#i_trx_other").val()
                ,trx_nominal:$("#i_trx_nominal").val(),trx_rate:$("#i_trx_rate").val()
                ,trx_type:$("#i_trx_type").val(),trx_dep_type:$("#i_trx_deposit_type").val()
                ,trx_tax_status:$("#i_trx_tax_status").val(),trx_pay_type:$("#i_trx_payment_type").val()
                ,trx_nominal:$("#i_trx_nominal").val(),trx_rate:$("#i_trx_rate").val()
                ,trx_break_dt:$("#i_trx_break_dt").val(),trx_client_id:$("#i_trx_client_id").val()
                ,trx_curr:$("#i_trx_curr").val(),trx_due_type:$("#i_trx_due_dt_status").val()
                ,trx_id:trxid,trx_id_master:trxid_master
                ,trx_id_upper:trxid_upper
                ,trx_mov_bil:mov_bilyet
                ,bank_rek:$("#i_trx_dst_rek").val()
                ,bank_rek_name:$("#i_trx_dst_acc_name").val()
                ,pic_pid:$("#h_trx_pic_id").val()
                ,trx_rbreak:$("#i_trx_rate_break").val()
            },function(data) { 
        },"json");
        obj_post.done(function(msg) { 
            alert("Sukses membuat instruksi!");
            state_progress(0);
            if(msg.r_numrows>0)
            {
                trxid=msg.r_sdata[0].trx_id;
                if($("#i_trx_type").val()==1)
                    open_dlg_trx_approve();
                else
                {
                    trx_cetak=1;do_submit_approve_trx(); 
                }
            }
            close_dlg_trx();
            if(msg.r_numrows<=0)
                refresh_trx_grid();
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Saving data error :" + textStatus);
            state_progress(0);
        });
    }
}
function do_submit_edit_trx()
{
    if((trim($("#i_trx_rate_break").val())==0 || trim($("#i_trx_rate_break").val())=='') && $("#i_trx_type").val()=='4')
    {
        alert('Please input Bunga Break!'); return 0;
    }
    if(confirm("Ubah instruksi?"))
    {
        var mov_bilyet= $("#i_trx_move_bilyet:checked").val();
        if(mov_bilyet!=1 )
            mov_bilyet=0;
        state_progress(1);                                        
        var obj_post = $.post(uri+"/index.php/itd_save/submit_edit_trx", 
            {   trx_id:trxid,trx_to:$("#i_trx_to").val(),trx_remark1:$("#i_trx_remark1").val()
                ,trx_up:$("#i_trx_up").val(),trx_telp:$("#i_trx_telp").val(),trx_fax:$("#i_trx_fax").val()
                ,trx_c_code:$("#i_trx_client_code").val(),trx_c_name:$("#i_trx_client_name").val()
                ,trx_acc_no:$("#i_trx_client_acc_no").val(),trx_acc_name:$("#i_trx_client_acc_name").val()
                ,trx_bank_name:$("#i_trx_client_bank_name").val()
                ,trx_dt:$("#i_trx_dt").val(),trx_val_dt:$("#i_trx_valuta_dt").val()
                ,trx_due_dt:$("#i_trx_due_dt").val(),trx_other:$("#i_trx_other").val()
                ,trx_nominal:$("#i_trx_nominal").val(),trx_rate:$("#i_trx_rate").val()
                ,trx_type:$("#i_trx_type").val(),trx_dep_type:$("#i_trx_deposit_type").val()
                ,trx_tax_status:$("#i_trx_tax_status").val(),trx_pay_type:$("#i_trx_payment_type").val()
                ,trx_nominal:$("#i_trx_nominal").val(),trx_rate:$("#i_trx_rate").val()
                ,trx_break_dt:$("#i_trx_break_dt").val(),trx_client_id:$("#i_trx_client_id").val()
                ,trx_curr:$("#i_trx_curr").val(),trx_due_type:$("#i_trx_due_dt_status").val()
                ,trx_note:$("#i_trx_note").val()
                ,trx_mov_bil:mov_bilyet
                ,bank_rek:$("#i_trx_dst_rek").val()
                ,bank_rek_name:$("#i_trx_dst_acc_name").val()
                ,pic_pid:$("#h_trx_pic_id").val()
                ,trx_rbreak:$("#i_trx_rate_break").val()
            },function(data){
        },"json");
        obj_post.done(function(data) { 
            alert(data.r_sdata.msg);
            // alert("Submit instruction success!"); 
            state_progress(0);
            close_dlg_trx();
            close_dlg_trx();
            refresh_trx_grid();  
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Saving data error :" + textStatus);
            state_progress(0);
        });
    }
}
function do_submit_revise_trx()
{
    if(confirm("Revise instruction?"))
    {
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/itd_save/submit_revise_trx", 
            { trx_id:trxid,trx_note:$("#i_trx_note").val()},function(data) {
        },"json");
        obj_post.done(function(msg) { 
            alert("Revise instruction success!");
            state_progress(0);
            close_dlg_trx();
            refresh_trx_grid();   
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Saving data error :" + textStatus);
            state_progress(0);
        });
    }
}    
function do_submit_approve_trx()
{
    //if(confirm("Approve instruksi?"))
    //{
    trx_cetak=1;
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/itd_save/submit_approve_trx", 
            { trx_id:trxid},function(data) {},"json");
            obj_post.done(function(msg) { 
            //alert("Approve instruction success!");    alert(msg.r_numrows);
            state_progress(0);
            close_dlg_trx();          
            if(msg.r_numrows>0) 
            {
                if(msg.r_sdata[0].can_approve!=1)
                    alert("User doesn't have right to approve the instruction");
                else
                {
                    alert("Approve instruction success!");
                    if(msg.penempatan_to_mutasi.msg){
                        alert(msg.penempatan_to_mutasi.msg);
                    }else if(msg.pencairan_to_mutasi.msg){
                        alert(msg.pencairan_to_mutasi.msg);
                    }
                    
                    if(trx_cetak==1)
                    {
                        do_print_trx(msg.r_sdata[0].trx_id);
                    }
                }
            }               
            if(trx_sect==0)
                refresh_trx_grid();
            else
                refresh_trx_nfs_grid();
            refresh_bilyet_status_count();
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Saving data error :" + textStatus);
            state_progress(0);
        });
    //}
}

function do_submit_cancel_trx()
{
    var data = grid_selected;
    var acc_no = 0;
    var client_code = 0;
    var trx_type = 0;
    $.post(uri+"index.php/itd/get_trx",{ trx_id:data.trx_id,trx_unix: data.trx_unix_no},function(data) {
        var coa     = '';
        var res     = data.r_sdata[0];
        acc_no      = res.trx_acc_no;
        client_code = res.trx_client_code;
        trx_type    = res.trx_type;
        
        switch (trx_type) {
            case '1':
                coa = 'D002';
                break;
            case '2':
                coa = 'D002';
                break;
            case '3':
                coa = 'C003';
                break;
            case '4':
                coa = 'C004';
                break;
        }

        if(confirm("Batalkan instruksi?")){
            state_progress(1);
            var obj_post = $.post(uri+"/index.php/itd_save/submit_cancel_trx", 
                { 
                    trx_id  :   trxid,
                    acc_no  :   acc_no,
                    client_code : client_code,
                    coa : coa,
                    trx_note:$("#i_trx_note").val()
                },
            function(data) {
                    
            },"json");
            obj_post.done(function(data) { 

                // alert("Pembatalan sukses!");
                alert(data.r_sdata.msg);

                state_progress(0);
                close_dlg_trx();
                refresh_trx_grid();   
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }

    },"json");
}
function set_dlg_event_trx()
{
    $("#i_trx_nominal").keyup(function(){
       $("#trx_nominal").html(strtomoney(this.value));
    });
    $("#i_trx_type").change(function(){
       if(this.value==4) 
            $("#s_trx_tgl_break").show();
       else
            $("#s_trx_tgl_break").hide();
    });
    $("#i_trx_valuta_dt").change(function(){  
        var thisval = this.value;
        var diffmonth = parseDate($("#i_trx_due_dt").val(),'-',1).getMonth()-parseDate(thisval,'-',1).getMonth(); 
        var diffyear = parseDate($("#i_trx_due_dt").val(),'-',1).getFullYear()-parseDate(thisval,'-',1).getFullYear(); 
        if (isNaN(diffyear))
            diffyear=0;
        if(isNaN(diffmonth))
            diffmonth = 0;
        else if(diffyear>0)
            diffmonth = 12-parseDate(thisval,'-',1).getMonth()+parseDate($("#i_trx_due_dt").val(),'-',1).getMonth()+ (diffyear-1)*12;
        $("#s_trx_deposit_tenor").html(' / ' + diffmonth + ' Bulan');
        $("#i_trx_deposit_tenor").val(daydiff(parseDate(thisval,'-',1),parseDate($("#i_trx_due_dt").val(),'-',1)));
        if($("#i_trx_deposit_type").val()!=1 && daydiff(parseDate(thisval,'-',1),parseDate($("#i_trx_due_dt").val(),'-',1))<31)
            $("#s_trx_cek_tipe").html("<br /> Warning,Kurang dari 31 hari & bukan On Call!");
        else
            $("#s_trx_cek_tipe").html("");
    });
    $("#i_trx_due_dt").change(function(){ 
        var thisval = this.value;
        var diffmonth = parseDate(thisval,'-',1).getMonth() - parseDate($("#i_trx_valuta_dt").val(),'-',1).getMonth(); 
        var diffyear = parseDate(thisval,'-',1).getFullYear()-parseDate($("#i_trx_valuta_dt").val(),'-',1).getFullYear();
       if (isNaN(diffyear))
            diffyear=0;
       if(isNaN(diffmonth))
            diffmonth = 0;
        else if(diffyear>0)
            diffmonth = 12-parseDate($("#i_trx_valuta_dt").val(),'-',1).getMonth()+parseDate(thisval,'-',1).getMonth()+ (diffyear-1)*12;
       $("#s_trx_deposit_tenor").html(' / ' + diffmonth + ' Bulan');
        $("#i_trx_deposit_tenor").val(daydiff(parseDate($("#i_trx_valuta_dt").val(),'-',1),parseDate(thisval,'-',1)));
        if($("#i_trx_deposit_type").val()!=1 && daydiff(parseDate($("#i_trx_valuta_dt").val(),'-',1),parseDate(thisval,'-',1))<31)
            $("#s_trx_cek_tipe").html("<br /> Warning,Kurang dari 31 hari & bukan On Call!");
        else
            $("#s_trx_cek_tipe").html("");
    });
    $("#hbtn_trx_print").click(function(){
       var aa="12-12-2233" ;                                                   
    });
}
function ena_break_trx0(p_no,p_nil)
{
    $("#i_trx_rate_break").val(p_nil);
    if(act_dlg_trx_no==0 || act_dlg_trx_no==2)
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
    if(act_dlg_trx_no!=0 && act_dlg_trx_no!=2)
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
