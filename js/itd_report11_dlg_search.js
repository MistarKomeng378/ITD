function get_content_dlg_report11_search()
{             
    var obj_post = $.post(uri_dlg_report11_search,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_report11_search").html(msg);
        $("#dlgReport11Search_sdate").datepicker();
        $("#dlgReport11Search_sdate").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#dlgReport11Search_edate").datepicker();
        $("#dlgReport11Search_edate").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        create_dlg_dpicker_report11_search();
    });
}
function create_dlg_dpicker_report11_search()
{
    
    var dpick_opt_client1 ={
        cols : [         
                   {id:"client_code", name:"Code", field:"client_code",width:50}
                   ,{id:"client_name", name:"Client Name", field:"client_name",width:180}
                   ,{id:"client_bank", name:"Bank Name", field:"bank_name",width:80}
                   ,{id:"client_acc_no", name:"Account No", field:"acc_no",width:100}
                   ,{id:"client_acc_name", name:"Account Name", field:"acc_name",width:180}
                   ,{id:"client_acc_cif", name:"CIF", field:"acc_cif"}
                   ,{id:"client_id", name:"cid", field:"client_id",width:1}
            ],
        url: uri+"index.php/itd/list_client_by_code",
        setval: function(obj_val){
            $("#dlgReport11Search_client_code").val(obj_val.client_code);
        }
    }; 
    dPicker_attach($("#dlgReport11Search_client_code"),dpick_opt_client1);
}
function create_dlg_report11_search()
{
    get_content_dlg_report11_search(); 
    $("#dialogBox_report11_search").dialog({ 
            title:        'Instruksi Transaksi Deposito - Client'
        ,    width:        400
        ,    height:        200
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Rekap": function(){        
                 if(trim($("#dlgReport11Search_client_code").val())=='')
                    alert('Kode Client Kosong')
                 else
                    do_refresh_dlg_report11_search();   
             },
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_report11_search()
{                                                                   
    $("#dialogBox_report11_search").dialog("open");
    $("#dlgReport11Search_client_code").focus();
}
function close_dlg_report11_search()
{                          
    $("#dialogBox_report11_search").dialog("close");
}
function do_refresh_dlg_report11_search()
{
    data_report11.length=0;
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/itd_report_dlg/report11_search", 
        { c_code:$("#dlgReport11Search_client_code").val(),th:$("#dlgReport11Search_th").val(),
        s_dt:$("#dlgReport11Search_sdate").val(),e_dt:$("#dlgReport11Search_edate").val(),tipe:$("#dlgReport11Search_type").val()},function(data) {   
    });
    obj_post.done(function(msg){
        $("#content_report11_div").html(msg);
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
    close_dlg_report11_search();
}                                    