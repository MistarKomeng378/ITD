
function get_content_trx_history()
{                                    
    var obj_post = $.post(uri_dlg_trx_history,{},function(data) {
        $("#dialogBox_frm_trx_history").html(data);        
    });
    obj_post.done(function(msg) { 
        set_dt_picker_trx_history();      
        create_dlg_dpicker_trx_history();     
        set_trx_history_event();
        //set_select_trx_history_deposit_type();
        //set_dlg_event_trx_history();
    });
}
function create_dlg_trx_history()
{     
    get_content_trx_history();
    $("#dialogBox_frm_trx_history").dialog({ 
            title:        'Instruksi Transaksi Deposito'
        ,    width:        460
        ,   height:     160
         ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {        
             "Cetak": function(){cetak_dlg_trx_history();},
             "Batal": function(){$(this).dialog("close");}
          }
          , open : function (event,ui){ }
          , close: function(event, ui) {  dPicker_hide_force();   }
        });           
        
}
function create_dlg_dpicker_trx_history()
{
    var dpick_opt_client ={
        cols : [         
                {id:"client_code", name:"Kode Klien", field:"client_code",width:80}
                ,{id:"client_name", name:"Nama Klien", field:"client_name",width:380}
            ],
        url:  uri+"index.php/itd/list_client_distinct",
        setval: function(obj_val){
             $("#dlgTrx_client_code").val(obj_val.client_code);
             $("#s_dlgTrx_client_code").html(obj_val.client_name);
        }
    }; 
    dPicker_attach($("#dlgTrx_client_code"),dpick_opt_client);
}
function open_dlg_trx_history()
{
    //do_refresh_trx_history();        
   // show_hide_btn_dlg_trx_history(-1);
     $("#dialogBox_frm_trx_history").dialog("open");
}
function close_dlg_trx_history()
{
     $("#dialogBox_frm_trx_history").dialog("close");
}

function set_dt_picker_trx_history()
{
    $("#dlgTrx_s_dt").datepicker();
    $("#dlgTrx_s_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#dlgTrx_e_dt").datepicker();
    $("#dlgTrx_e_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
}

function set_trx_history_event()
{
    $("#dlgTrx_client_code").keyup(function(e){    
        var obj_post = $.post(uri+"index.php/itd/get_client_by_code",{client_code:$("#dlgTrx_client_code").val()},function(data) {
            if(data.r_num_rows>0)
                $("#s_dlgTrx_client_code").html(data.r_sdata[0].client_name);
            else
                $("#s_dlgTrx_client_code").html('');
        },"json");
        
    });
}
function cetak_dlg_trx_history(){
    if ($("#s_dlgTrx_client_code").html()=='')
    {
        alert('Pilihlah klien.');
        return 0;
    }
}