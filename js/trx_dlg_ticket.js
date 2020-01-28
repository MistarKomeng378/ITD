var trx_ticket_trx_id=0;
function get_content_dlg_trx_ticket()
{
    var obj_post = $.post(uri_dlg_trx_ticket,{},function(data) {
        $("#dialogBox_frm_trx_ticket").html(data);
    });
    obj_post.done(function(msg) {             
        set_event_dlg_trx_ticket(); 
    });
}
function create_dlg_trx_ticket()
{
    get_content_dlg_trx_ticket();          
    $("#dialogBox_frm_trx_ticket").dialog({ 
            title:        'Instruksi Transaksi Deposito - Tiket'
        ,    width:        800
        ,   height:     520
         ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {             
             "Cetak": function(){ do_dlg_trx_ticket_print(); },
             "Batal": function(){$(this).dialog("close");}
          }
          , open : function (event,ui){  
             
          }
          , close: function(event, ui) { 
             
          }
        });            
    
}       
function open_dlg_trx_ticket(t_id)
{
     trx_ticket_trx_id=t_id;
     set_val_dlg_trx_ticket(t_id);
     $("#dialogBox_frm_trx_ticket").dialog("open");   
}
function close_dlg_trx_ticket()
{
     $("#dialogBox_frm_trx_ticket").dialog("close");
}

function set_val_dlg_trx_ticket(t_id)
{
    if(t_id!=0)
    {                           
        state_progress(1);    
        var obj_post = $.post(uri+"/index.php/itd/get_itd_print", 
            { trx_id:t_id,trx_unix:2},function(data) { 
            
        },"json"); 
        obj_post.done(function(msg) { 
            console.log(msg);
            
            if(msg.r_num_rows>0)
            {                                                       
                $("#dlg_trx_ticket_client_code").val(msg.r_sdata[0].trx_client_code);
                $("#dlg_trx_ticket_client_name").val(msg.r_sdata[0].trx_client_name);
                //$("input[@name=trx_type]:checked").attr("checked",false);
                if(msg.r_sdata[0].trx_type==1)
                    $("#dlg_trx_ticket_type1").attr("checked",true);
                else if(msg.r_sdata[0].trx_type==2)
                    $("#dlg_trx_ticket_type2").attr("checked",true);
                else if(msg.r_sdata[0].trx_type==3)
                    $("#dlg_trx_ticket_type3").attr("checked",true);
                else if(msg.r_sdata[0].trx_type==4)
                    $("#dlg_trx_ticket_type3").attr("checked",true);
                else
                    $("#dlg_trx_ticket_type5").attr("checked",true);
                // $("#dlg_trx_ticket_bank").val(msg.r_sdata[0].trx_bank_name);
                $("#dlg_trx_ticket_bank").val(msg.r_sdata[0].trx_to);
                $("#dlg_trx_ticket_set_dt").val(msg.r_sdata[0].trx_due_date_s);
                $("#dlg_trx_ticket_term").val(msg.r_sdata[0].trx_deposit_tenor_hr);
                
                if(msg.r_sdata[0].trx_type==4)
                    $("#dlg_trx_ticket_rate").val(msg.r_sdata[0].trx_rate_break);
                else
                    $("#dlg_trx_ticket_rate").val(msg.r_sdata[0].trx_rate);
                $("#dlg_trx_ticket_amount").val(strtomoney(msg.r_sdata[0].trx_nominal));
                $("#dlg_trx_ticket_ref").val(msg.r_sdata[0].trx_ref);
                $("#dlg_trx_ticket_notes").val(msg.r_sdata[0].trx_other);  
                var p_year =  Number($("#dlg_trx_ticket_year").val().replace(/[^0-9\.]+/g,""));
                //var ac_mount = dlg_trx_ticket_calc_rate(msg.r_sdata[0].trx_rate,msg.r_sdata[0].trx_nominal,msg.r_sdata[0].trx_deposit_tenor_hr,$("#dlg_trx_ticket_year").val());
                var ac_mount =0;
                if(msg.r_sdata[0].trx_type==4)
                    ac_mount = msg.r_sdata[0].trx_rate_break*msg.r_sdata[0].trx_nominal*msg.r_sdata[0].trx_deposit_tenor_hr/p_year/100;
                else
                    ac_mount = msg.r_sdata[0].trx_rate*msg.r_sdata[0].trx_nominal*msg.r_sdata[0].trx_deposit_tenor_hr/p_year/100;
                var p_tax = Number($("#dlg_trx_ticket_tax").val().replace(/[^0-9\.]+/g,""));
                var bt_mount = ac_mount - ac_mount*p_tax /100;
                
                var tax_mount =ac_mount*(0+$("#dlg_trx_ticket_tax").val()) / 100;
                $("#dlg_trx_ticket_taxamount").val(strtomoney(tax_mount));
                $("#dlg_trx_ticket_rate_amount").val(strtomoney(ac_mount));
                $("#dlg_trx_ticket_net").val(strtomoney(bt_mount));
                
            }
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Loading data error :" + textStatus);
            state_progress(0);
        });
    }    
    //else
    //{                                                  
    //    clear_dlg_trx_ticket();
    //}
}
function dlg_trx_ticket_calc_rate(p_rate,p_amount,p_term,p_year)
{
    return string2number(p_amount)*string2number(p_rate)/100*string2number(p_term)/string2number(p_year);
}
function dlg_trx_ticket_calc_tax(p_rate,p_amount,p_tax,p_other,p_term,p_year)
{                           
    var hihi = (string2number(p_amount)*string2number(p_rate)/100*string2number(p_term)/string2number(p_year)) ;
    //alert((string);
    return (hihi - string2number(p_other) - (hihi * string2number(p_tax) / 100));
    //return (string2number(p_amount)*string2number(p_rate)/100*string2number(p_term)/string2number(p_year)) -(string2number(p_amount)*string2number(p_rate)/100*string2number(p_tax)/100*string2number(p_term)/string2number(p_year)-string2number(p_other));
}
function dlg_trx_ticket_calc_taxamount(p_tax,p_rate,p_amount,p_term,p_year)
{
    return string2number(p_amount)*string2number(p_rate)/100*string2number(p_term)/string2number(p_year)*string2number(p_tax)/100;
}

function clear_dlg_trx_ticket(){
    
}
function set_event_dlg_trx_ticket()
{                    
    $("#dlg_trx_ticket_term").keyup(function(){ 
       $("#dlg_trx_ticket_rate_amount").val(strtomoney(dlg_trx_ticket_calc_rate($("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),this.value,$("#dlg_trx_ticket_year").val())));
       $("#dlg_trx_ticket_net").val(strtomoney(dlg_trx_ticket_calc_tax($("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_tax").val(),$("#dlg_trx_ticket_stamp_amount").val(),this.value,$("#dlg_trx_ticket_year").val())));
       $("#dlg_trx_ticket_taxamount").val(strtomoney(dlg_trx_ticket_calc_taxamount($("#dlg_trx_ticket_tax").val(),$("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),this.value,$("#dlg_trx_ticket_year").val())));
    });
    $("#dlg_trx_ticket_rate").keyup(function(){ 
       $("#dlg_trx_ticket_rate_amount").val(strtomoney(dlg_trx_ticket_calc_rate(this.value,$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
       $("#dlg_trx_ticket_net").val(strtomoney(dlg_trx_ticket_calc_tax(this.value,$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_tax").val(),$("#dlg_trx_ticket_stamp_amount").val(),$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
       $("#dlg_trx_ticket_taxamount").val(strtomoney(dlg_trx_ticket_calc_taxamount($("#dlg_trx_ticket_tax").val(),this.value,$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
    });
    $("#dlg_trx_ticket_year").change(function(){ 
       $("#dlg_trx_ticket_rate_amount").val(strtomoney(dlg_trx_ticket_calc_rate($("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_term").val(),this.value)));
       $("#dlg_trx_ticket_net").val(strtomoney(dlg_trx_ticket_calc_tax($("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_tax").val(),$("#dlg_trx_ticket_stamp_amount").val(),$("#dlg_trx_ticket_term").val(),this.value)));
       $("#dlg_trx_ticket_taxamount").val(strtomoney(dlg_trx_ticket_calc_taxamount($("#dlg_trx_ticket_tax").val(),$("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_term").val(),this.value)));
    });
    $("#dlg_trx_ticket_amount").keyup(function(){ 
       $("#dlg_trx_ticket_rate_amount").val(strtomoney(dlg_trx_ticket_calc_rate($("#dlg_trx_ticket_rate").val(),this.value,$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
       $("#dlg_trx_ticket_net").val(strtomoney(dlg_trx_ticket_calc_tax($("#dlg_trx_ticket_rate").val(),this.value,$("#dlg_trx_ticket_tax").val(),$("#dlg_trx_ticket_stamp_amount").val(),$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
       $("#dlg_trx_ticket_taxamount").val(strtomoney(dlg_trx_ticket_calc_taxamount($("#dlg_trx_ticket_tax").val(),$("#dlg_trx_ticket_rate").val(),this.value,$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
    });
    $("#dlg_trx_ticket_tax").keyup(function(){ 
       $("#dlg_trx_ticket_net").val(strtomoney(dlg_trx_ticket_calc_tax($("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),this.value,$("#dlg_trx_ticket_stamp_amount").val(),$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
       $("#dlg_trx_ticket_taxamount").val(strtomoney(dlg_trx_ticket_calc_taxamount(this.value,$("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
    });
    $("#dlg_trx_ticket_stamp_amount").keyup(function(){ 
       $("#dlg_trx_ticket_net").val(strtomoney(dlg_trx_ticket_calc_tax($("#dlg_trx_ticket_rate").val(),$("#dlg_trx_ticket_amount").val(),$("#dlg_trx_ticket_tax").val(),this.value,$("#dlg_trx_ticket_term").val(),$("#dlg_trx_ticket_year").val())));
    });
    $("#dlg_trx_ticket_rate_amount").keyup(function(){ 
        var net_mount =  strtomoney(string2number(this.value) - string2number(this.value)*string2number($("#dlg_trx_ticket_tax").val())/100-string2number($("#dlg_trx_ticket_stamp_amount").val()));
       $("#dlg_trx_ticket_net").val(net_mount);
       $("#dlg_trx_ticket_taxamount").val(strtomoney(string2number(this.value)*string2number($("#dlg_trx_ticket_tax").val())/100));
    });
}

function string2number(p_str)
{
   return Number(p_str.replace(/[^0-9\.]+/g,""));
}

function do_dlg_trx_ticket_print()
{ //alert(trx_ticket_trx_id);
    var val_trx_type = $("input:radio[name=dlg_trx_ticket_trx_type]:checked").val();
    var val_trx_stamp = $("input:radio[name=dlg_trx_ticket_trx_stamp_type]:checked").val();
    //alert(val_trx_type);
    //alert(val_trx_stamp);
    var obj_post = $.post(uri+"/index.php/itd_save/submit_trx_ticket_print", 
        { trx_code:$("#dlg_trx_ticket_client_code").val(),trx_cname:$("#dlg_trx_ticket_client_name").val()
        , trx_type:val_trx_type, trx_type_other:$("#dlg_trx_ticket_type").val(), trx_bank:$("#dlg_trx_ticket_bank").val()
        , trx_setdate:$("#dlg_trx_ticket_set_dt").val(), trx_term:$("#dlg_trx_ticket_term").val(),trx_rate:$("#dlg_trx_ticket_rate").val()
        , trx_year:$("#dlg_trx_ticket_year").val(), trx_nominal:$("#dlg_trx_ticket_amount").val()
        , trx_ref:$("#dlg_trx_ticket_ref").val(), trx_rate_amount:$("#dlg_trx_ticket_rate_amount").val()
        , trx_tax:$("#dlg_trx_ticket_tax").val(), trx_stamp_type:val_trx_stamp
        , trx_stamp:$("#dlg_trx_ticket_stamp").val(), trx_stamp_amount:$("#dlg_trx_ticket_stamp_amount").val()
        , trx_net:$("#dlg_trx_ticket_net").val() , trx_tid:trx_ticket_trx_id
        , trx_note:$("#dlg_trx_ticket_notes").val(),trx_taxamount:$("#dlg_trx_ticket_taxamount").val()
        },function(data) {});
    obj_post.done(function(msg) { 
        loadPrintDocument(uri+'index.php/itd/get_trx_ticket_print/'+trx_ticket_trx_id);  
    });
    obj_post.fail(function(jqXHR, textStatus) {alert("Failed printing data :" + textStatus);});
}


