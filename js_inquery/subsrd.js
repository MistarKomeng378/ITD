var grid_subsrd;
var data_subsrd = [];

function initiate_subsrd()
{                  
    add_section("tbl_slick_subsrd","data_subsrd","refresh_subsrd_grid()","hbtn_subsrd","grid_subsrd");
    create_subsrd_grid();         
    create_dpicker_subsrd_client();
    create_subsrd_event();
    create_dlg_subsrd_internal();
    create_dlg_subsrd_eksternal();
    //create_dlg_subsrd_search();  
}
function get_content_subsrd_internal_dlg()
{                                         
    var obj_post = $.post(uri_subsrd_pay+'v_dlg_internal',{},function(data) {
    });
    obj_post.done(function(msg) {           //  alert(msg);
        $("#dialogBox_subsrd_int").html(msg);
        setTimeout(function() { 
            $("#_subsrd_pay_int_txn_date").datepicker();
            $("#_subsrd_pay_int_txn_date").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
            $("#_subsrd_pay_int_txn_date").val(saiki);
        });
    });
}
function get_content_subsrd_eksternal_dlg()
{                                         
    var obj_post = $.post(uri_subsrd_pay+'v_dlg_eksternal',{},function(data) {
    });
    obj_post.done(function(msg) {               // alert(msg);
        $("#dialogBox_subsrd_eks").html(msg);
        setTimeout(function() { 
            $("#_subsrd_dlg_pay_e_dt").datepicker();
            $("#_subsrd_dlg_pay_e_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
            $("#_subsrd_dlg_pay_e_dt").val(saiki);
            $("#_subsrd_dlg_pay_txn_dt").datepicker();
            $("#_subsrd_dlg_pay_txn_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
            $("#_subsrd_dlg_pay_txn_dt").val(saiki);
        },1);
    });
}
function create_dlg_subsrd_internal()
{
    get_content_subsrd_internal_dlg();
    $("#dialogBox_subsrd_int").dialog({ 
            title:        'Subscription Reksadana - Print TC5'
        ,    width:        570
        ,    height:        460
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cetak": function(){
                if(confirm('Update data & Print the TC5?'))
                {
                    $(this).dialog("close");
                    print_subsrd_int();
                }
             },
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function create_dlg_subsrd_eksternal()
{
    get_content_subsrd_eksternal_dlg();
    $("#dialogBox_subsrd_eks").dialog({ 
            title:        'Subscription Reksadana - Print instruction'
        ,    width:        800
        ,    height:        520
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cetak": function(){
                 if(confirm('Update Data & Print the instruction?'))
                 {
                    $(this).dialog("close");
                    print_subsrd_eks();
                 }
             },
             "Cetak BCA Template": function(){
                 if(confirm('Update Data & Print the instruction?'))
                 {
                    $(this).dialog("close");
                    print_subsrd_eks_bca();
                 }
             },
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function create_subsrd_grid()
{    
    var columns_subsrd = [];
    var options_subsrd = [];
    
    columns_subsrd = [
        {id:"print_status", name:"Prt", field:"print_status",width:25}
        ,{id:"subsrd_date", name:"Subs Date", field:"subsrd_date",width:65}
        ,{id:"client_code", name:"Client", field:"client_code",width:45}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:150}
        ,{id:"bank_name_src", name:"Subs Bank", field:"bank_name_src",width:130}
        ,{id:"acc_no_src", name:"Subs Acc No", field:"acc_no_src",width:80}
        ,{id:"acc_name_src", name:"Subs Acc Name", field:"acc_name_src",width:150}
        ,{id:"nominal", name:"Nominal", field:"nominal",cssClass:"cell_right",width:120}
        ,{id:"inst_date", name:"Inst Date", field:"inst_date",width:65}
        ,{id:"bank_name_dst", name:"Dest Bank", field:"bank_name_dst",width:130}
        ,{id:"acc_no_dst", name:"Dest Acc No", field:"acc_no_dst",width:80}
        ,{id:"acc_name_dst", name:"Dest Acc Name", field:"acc_name_dst",width:150}
        ,{id:"printed_date", name:"Printed Date", field:"printed_date",width:65}
        ,{id:"printed_by", name:"Printed By", field:"printed_by",width:65}
    ];
    options_subsrd = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_subsrd = new Slick.Grid("#tbl_slick_subsrd", data_subsrd, columns_subsrd, options_subsrd);
    grid_subsrd.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}
function create_dpicker_subsrd_client()
{                      
    var dpick_opt_subsrd ={
        cols : [         
                    {id:"client_code", name:"Code", field:"client_code",width:100}
                   ,{id:"client_name", name:"Account Name", field:"client_name",width:380}
                   ,{id:"mi_code", name:"MI", field:"mi_code"}
            ],
        url: uri_subsrd+"list_client_by_code",
        setval: function(obj_val){                      
            $("#hbtn_subsrd_client_code").val(trim(obj_val.client_code));
        }
    }; 
    dPicker_attach($("#hbtn_subsrd_client_code"),dpick_opt_subsrd);        
}
function open_dlg_subsrd_internal()
{
    $("#dialogBox_subsrd_int").dialog("open");   
}
function close_dlg_subsrd_internal()
{
    $("#dialogBox_subsrd_int").dialog("close");   
}
function open_dlg_subsrd_eksternal()
{
    $("#dialogBox_subsrd_eks").dialog("open");   
}
function close_dlg_subsrd_eksternal()
{
    $("#dialogBox_subsrd_eks").dialog("close");   
}
function get_data_subsrd_eksternal_dlg(p_ccode,p_acc_src,p_acc_dst,p_date)
{                                         
    var obj_post = $.post(uri_subsrd_pay+'get_data',{
        s_code:p_ccode,
        s_src:p_acc_src,
        s_dst:p_acc_dst,
        s_dt:p_date
    },function(data) { alert(data);
    });
    obj_post.done(function(msg) {    
        if(msg.r_num_rows>0)
        {
            $("#_subsrd_dlg_pay_e_to").val(msg.r_sdata[0].ref_to);
            $("#_subsrd_dlg_pay_e_up").val(msg.r_sdata[0].ref_up);
            $("#_subsrd_dlg_pay_e_telp").val(msg.r_sdata[0].ref_telp);
            $("#_subsrd_dlg_pay_e_fax").val(msg.r_sdata[0].ref_fax);
            $("#_subsrd_dlg_pay_e_ref").html('XXX'+msg.r_sdata[0].ref_no);
            $("#_subsrd_dlg_pay_e_from").html(msg.r_sdata[0].ref_from1);
            $("#_subsrd_dlg_pay_e_from_telp").html(msg.r_sdata[0].ref_telp1);
            $("#_subsrd_dlg_pay_e_from_fax").html(msg.r_sdata[0].ref_fax1);
            $("#_subsrd_dlg_pay_src_name").val(msg.r_sdata[0].acc_name_src);
            $("#_subsrd_dlg_pay_src_no").html(msg.r_sdata[0].acc_no_src);
            $("#_subsrd_dlg_pay_dst_name").html(msg.r_sdata[0].acc_name_dst);
            $("#_subsrd_dlg_pay_dst_no").html(msg.r_sdata[0].acc_no_dst);
            $("#_subsrd_dlg_pay_dst_bank").html(msg.r_sdata[0].bank_name_dst);
            $("#_subsrd_dlg_pay_nominal").html(strtomoney(msg.r_sdata[0].nominal));
            $("#_subsrd_dlg_pay_terbilang").html(msg.r_sdata[0].terbilang);
            $("#_subsrd_dlg_pay_subs_date").html(msg.r_sdata[0].subsrd_date_s1);
            
        }
    });
}

function open_dlg_subsrd(p_id,p_ccode,p_acc_src,p_acc_dst,p_date)
{
    /*if(p_id==1)
        open_dlg_subsrd_internal();
    else
    {
        get_data_subsrd_eksternal_dlg(p_ccode,p_acc_src,p_acc_dst,p_date);
        open_dlg_subsrd_eksternal();
    }*/                   //      alert(p_acc_src);alert(p_acc_dst);
    var obj_post = $.post(uri_subsrd_pay+'get_data',{
        s_code:p_ccode,
        s_src:p_acc_src,
        s_dst:p_acc_dst,
        s_dt:p_date
    },function(data) { //alert(data);
    },"json");
    obj_post.done(function(msg) {    
        if(msg.r_num_rows>0)
        {
            if(msg.r_sdata[0].src==0)  
                _subsrd_show_hide_button(true);
            else
                _subsrd_show_hide_button(false);
            if(msg.r_sdata[0].acc_src_internal==0)
            {
                $("#_subsrd_dlg_pay_e_to").val(msg.r_sdata[0].ref_to);
                $("#_subsrd_dlg_pay_e_up").val(msg.r_sdata[0].ref_up);
                $("#_subsrd_dlg_pay_e_telp").val(msg.r_sdata[0].ref_telp);
                $("#_subsrd_dlg_pay_e_fax").val(msg.r_sdata[0].ref_fax);
                $("#_subsrd_dlg_pay_e_ref").html(msg.r_sdata[0].ref_no);
                $("#_subsrd_dlg_pay_e_from").html(msg.r_sdata[0].ref_from1);
                $("#_subsrd_dlg_pay_e_from_telp").html(msg.r_sdata[0].ref_telp1);
                $("#_subsrd_dlg_pay_e_from_fax").html(msg.r_sdata[0].ref_fax1);
                $("#_subsrd_dlg_pay_src_name").val(msg.r_sdata[0].acc_src_name);
                $("#_subsrd_dlg_pay_src_no").html(msg.r_sdata[0].acc_src_no);
                $("#_subsrd_dlg_pay_dst_name").val(msg.r_sdata[0].acc_dst_name);
                $("#_subsrd_dlg_pay_dst_no").html(msg.r_sdata[0].acc_dst_no);
                $("#_subsrd_dlg_pay_dst_bank").html(msg.r_sdata[0].acc_dst_bank);
                $("#_subsrd_dlg_pay_nominal").html(strtomoney(msg.r_sdata[0].nominal));    
                $("#_subsrd_dlg_pay_terbilang").html(msg.r_sdata[0].terbilang);
                $("#_subsrd_dlg_pay_subs_date").html(msg.r_sdata[0].subsrd_date_s1);
                $("#_subsrd_dlg_pay_via").val(msg.r_sdata[0].txn_via);
                $("#_subsrd_dlg_pay_remark").val(msg.r_sdata[0].remark); 
                $("#_subsrd_dlg_pay_e_dt").val(msg.r_sdata[0].txn_date_s); 
                open_dlg_subsrd_eksternal();
            }
            else
            {
                $("#subsrd_pay_int_bnf_name").val(msg.r_sdata[0].acc_dst_name);
                $("#subsrd_pay_int_src_name").val(msg.r_sdata[0].acc_src_name);
                $("#subsrd_pay_int_bnf_acc_no").val(msg.r_sdata[0].acc_dst_no);
                $("#subsrd_pay_int_bnf_bank").val(msg.r_sdata[0].acc_dst_bank);
                $("#subsrd_pay_int_db_acc_no").val(msg.r_sdata[0].acc_src_no);
                $("#subsrd_pay_int_db_amount").val(strtomoney(msg.r_sdata[0].nominal));
                $("#subsrd_pay_int_db_amount_say").val(msg.r_sdata[0].terbilang);
                $("#subsrd_pay_int_charges").val(msg.r_sdata[0].charges);
                $("#subsrd_pay_int_charges_s").html(strtomoney(msg.r_sdata[0].charges));
                $("#subsrd_pay_int_msg").val(msg.r_sdata[0].txn_via==''?'OB':msg.r_sdata[0].txn_via);
                $("#subsrd_pay_int_sender").val(msg.r_sdata[0].remark==''?msg.r_sdata[0].client_name+"\rC/O Custodial Bank CIMB Niaga":msg.r_sdata[0].remark);
                $("#_subsrd_pay_int_txn_date").val(msg.r_sdata[0].txn_date_s);
                open_dlg_subsrd_internal();
            }        
        }
        else
        {
            _subsrd_show_hide_button(false);
            alert("Error getting data.");
        }
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function refresh_subsrd_grid()
{  
    
    state_progress(1);
    data_subsrd.length=0;      
    var obj_post = $.post(uri_subsrd_pay+"list_data",{
        vdt:$("#hbtn_subsrd_dt").val(), vccode:$("#hbtn_subsrd_client_code").val()
    },function(data) {                                              //alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_subsrd[i] = {});
           d["print_status"] = data.r_sdata[i].printed_status;
           d["subsrd_date"] = data.r_sdata[i].subsrd_date_s;
           d["client_code"] = data.r_sdata[i].client_code;
           d["client_name"] = data.r_sdata[i].client_name;
           d["bank_name_src"] = data.r_sdata[i].acc_src_bank;
           d["acc_no_src"] = data.r_sdata[i].acc_src_no;
           d["acc_name_src"] = data.r_sdata[i].acc_src_name;  
           d["nominal"] = strtomoney(data.r_sdata[i].nominal);
           d["inst_date"] = data.r_sdata[i].inst_date_s; 
           d["bank_name_dst"] = data.r_sdata[i].acc_dst_bank;
           d["acc_no_dst"] = data.r_sdata[i].acc_dst_no;
           d["acc_name_dst"] = data.r_sdata[i].acc_dst_name;
           d["printed_date"] = data.r_sdata[i].printed_date_s;
           d["printed_by"] = data.r_sdata[i].printed_by;
           d["acc_src"] = data.r_sdata[i].acc_src;
           d["acc_dst"] = data.r_sdata[i].acc_dst;
           d["bank_internal"] = data.r_sdata[i].bank_internal;
           d["sa_id"] = data.r_sdata[i].sa_id;   
        }
    },'json');
    obj_post.done(function(msg){
        grid_subsrd.invalidateAllRows();
        grid_subsrd.updateRowCount();
        grid_subsrd.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_subsrd_event()
{
    $("#hbtn_subsrd_dt").datepicker();
    $("#hbtn_subsrd_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#hbtn_subsrd_dt").val(saiki); 
    
    $("#hbtn_subsrd_refresh").click(function(){
        refresh_subsrd_grid();
    });
    
    $("#hbtn_subsrd_print").click(function(){ 
        selected_row_subsrd  = grid_subsrd.getActiveCell();
        if(selected_row_subsrd)
        {                           
            open_dlg_subsrd(data_subsrd[selected_row_subsrd.row].bank_internal,data_subsrd[selected_row_subsrd.row].client_code,data_subsrd[selected_row_subsrd.row].acc_src,data_subsrd[selected_row_subsrd.row].acc_dst,data_subsrd[selected_row_subsrd.row].subsrd_date);
        }
        else
            alert("No data selected!");
    });
    grid_subsrd.onDblClick.subscribe(function(e) {     
        var cell = grid_subsrd.getCellFromEvent(e);    
        open_dlg_subsrd(data_subsrd[cell.row].bank_internal,data_subsrd[cell.row].client_code,data_subsrd[cell.row].acc_src,data_subsrd[cell.row].acc_dst,data_subsrd[cell.row].subsrd_date);
    });
    
}

function  print_subsrd_eks()
{
    selected_row_subsrd  = grid_subsrd.getActiveCell();
    if(selected_row_subsrd)
    {                                            
        var obj_post = $.post(uri_subsrd_pay+'create_get_cso',{
            s_code:data_subsrd[selected_row_subsrd.row].client_code,
            s_src:data_subsrd[selected_row_subsrd.row].acc_src,
            s_dst:data_subsrd[selected_row_subsrd.row].acc_dst,
            s_dt:data_subsrd[selected_row_subsrd.row].subsrd_date,
            s_sa:data_subsrd[selected_row_subsrd.row].sa_id,
            s_refto:$("#_subsrd_dlg_pay_e_to").val(),
            s_refup:$("#_subsrd_dlg_pay_e_up").val(),
            s_reftelp:$("#_subsrd_dlg_pay_e_telp").val(),
            s_reffax:$("#_subsrd_dlg_pay_e_fax").val(),
            s_inst_dt:$("#_subsrd_dlg_pay_e_dt").val(),
            s_via:$("#_subsrd_dlg_pay_via").val(),
            s_remarks:$("#_subsrd_dlg_pay_remark").val(),
            s_txn_date:$("#_subsrd_dlg_pay_txn_dt").val(),
            s_add_info:$("#_subsrd_dlg_pay_info").val(),
            s_charges:0,                                    
            s_src_name:$("#_subsrd_dlg_pay_src_name").val(),
            s_dst_name:$("#_subsrd_dlg_pay_dst_name").val()
        },function(data) { //alert(data);
            refresh_subsrd_grid();
            if(data.err==0)
                subsrd_print(data.cso_id);
            else
                alert("Error creating the instruction!");
        },"json");
        obj_post.done(function(msg){
            
        });
        obj_post.fail(function(jqXHR, textStatus) {     
            alert("Error getting data :" + textStatus);
        });
    }
    else
        alert('Choose the data!');
}
function  print_subsrd_eks_bca()
{
    selected_row_subsrd  = grid_subsrd.getActiveCell();
    if(selected_row_subsrd)
    {                                            
        var obj_post = $.post(uri_subsrd_pay+'create_get_cso_bca',{
            s_code:data_subsrd[selected_row_subsrd.row].client_code,
            s_src:data_subsrd[selected_row_subsrd.row].acc_src,
            s_dst:data_subsrd[selected_row_subsrd.row].acc_dst,
            s_dt:data_subsrd[selected_row_subsrd.row].subsrd_date,
            s_sa:data_subsrd[selected_row_subsrd.row].sa_id,
            s_refto:$("#_subsrd_dlg_pay_e_to").val(),
            s_refup:$("#_subsrd_dlg_pay_e_up").val(),
            s_reftelp:$("#_subsrd_dlg_pay_e_telp").val(),
            s_reffax:$("#_subsrd_dlg_pay_e_fax").val(),
            s_inst_dt:$("#_subsrd_dlg_pay_e_dt").val(),
            s_via:$("#_subsrd_dlg_pay_via").val(),
            s_remarks:$("#_subsrd_dlg_pay_remark").val(),
            s_txn_date:$("#_subsrd_dlg_pay_txn_dt").val(),
            s_add_info:$("#_subsrd_dlg_pay_info").val(),
            s_charges:0,                                    
            s_src_name:$("#_subsrd_dlg_pay_src_name").val(),
            s_dst_name:$("#_subsrd_dlg_pay_dst_name").val()
        },function(data) { //alert(data);
            refresh_subsrd_grid();
            if(data.err==0)
                subsrd_print_bca(data.cso_id);
            else
                alert("Error creating the instruction!");
        },"json");
        obj_post.done(function(msg){
            
        });
        obj_post.fail(function(jqXHR, textStatus) {     
            alert("Error getting data :" + textStatus);
        });
    }
    else
        alert('Choose the data!');
}

function  print_subsrd_int()
{
    selected_row_subsrd  = grid_subsrd.getActiveCell();
    if(selected_row_subsrd)
    {   
        var obj_post = $.post(uri_subsrd_pay+'create_get_cso',{
            s_code:data_subsrd[selected_row_subsrd.row].client_code,
            s_src:data_subsrd[selected_row_subsrd.row].acc_src,
            s_dst:data_subsrd[selected_row_subsrd.row].acc_dst,
            s_dt:data_subsrd[selected_row_subsrd.row].subsrd_date,
            s_sa:data_subsrd[selected_row_subsrd.row].sa_id,
            s_refto:'',
            s_refup:'',
            s_reftelp:'',
            s_reffax:'',
            s_inst_dt:saiki,
            s_via:'OB',
            s_remarks:$("#subsrd_pay_int_msg").val(),
            s_txn_date:$("#_subsrd_pay_int_txn_date").val(),
            s_add_info:$("#subsrd_pay_int_sender").val(),
            s_charges:0,
            s_src_name:$("#subsrd_pay_int_src_name").val() ,
            s_dst_name:$("#subsrd_pay_int_bnf_name").val() ,
        },function(data) { //alert(data);
                //window.open(uri_subsrd_pay+'print_instruksi/'+data.cso_id);
           refresh_subsrd_grid();
            if(data.err==0)
                subsrd_print(data.cso_id);
            else
                alert("Error creating the instruction!");
        },"json");
        obj_post.done(function(msg){
            
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Error getting data :" + textStatus);
        });
    }
    else
        alert('Choose the data!');
}
function subsrd_print(p_cso_id)
{
    loadPrintDocument(uri_subsrd_pay+'print_instruksi/'+p_cso_id);
}
function subsrd_print_bca(p_cso_id)
{
    loadPrintDocument(uri_subsrd_pay+'print_instruksi_bca/'+p_cso_id);
}

function _subsrd_show_hide_button(p_show)
{
    if(p_show)
    {
        $($("button", $("#dialogBox_subsrd_int").parent())[0]).show();
        $($("button", $("#dialogBox_subsrd_eks").parent())[0]).show();
        $($("button", $("#dialogBox_subsrd_eks").parent())[1]).show();
        $('#dialogBox_subsrd_int').dialog('option','title','Print TC5');
        $('#dialogBox_subsrd_eks').dialog('option','title','Print Instruksi');
        
        $("#_subsrd_dlg_pay_e_to").prop('readonly', false);
        $("#_subsrd_dlg_pay_e_up").prop('readonly', false);
        $("#_subsrd_dlg_pay_e_telp").prop('readonly', false);
        $("#_subsrd_dlg_pay_e_fax").prop('readonly', false);
        $("#_subsrd_dlg_pay_e_dt").prop('readonly', false);
        $("#_subsrd_dlg_pay_via").prop('readonly', false);
        $("#_subsrd_dlg_pay_remark").prop('readonly', false);
        $("#_subsrd_dlg_pay_txn_dt").prop('readonly', false);
        $("#_subsrd_dlg_pay_info").prop('readonly', false);
        
        $("#_subsrd_pay_int_txn_date").prop('readonly', false);
        
        $("#subsrd_pay_int_charges").prop('readonly', false);
        $("#subsrd_pay_int_msg").prop('readonly', false);
        $("#subsrd_pay_int_sender").prop('readonly', false);
    }
    else
    {
        $('#dialogBox_subsrd_int').dialog('option','title','Print TC5-View Only (Checker or above can do reprint)');
        $('#dialogBox_subsrd_eks').dialog('option','title','Print Instruksi-View Only (Checker or above can do reprint)');
        
        $($("button", $("#dialogBox_subsrd_int").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrd_eks").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrd_eks").parent())[1]).hide();
        
        $("#_subsrd_dlg_pay_e_to").prop('readonly', true);
        $("#_subsrd_dlg_pay_e_up").prop('readonly', true);
        $("#_subsrd_dlg_pay_e_telp").prop('readonly', true);
        $("#_subsrd_dlg_pay_e_fax").prop('readonly', true);
        $("#_subsrd_dlg_pay_e_dt").prop('readonly', true);
        $("#_subsrd_dlg_pay_via").prop('readonly', true);
        $("#_subsrd_dlg_pay_remark").prop('readonly', true);
        $("#_subsrd_dlg_pay_txn_dt").prop('readonly', true);
        $("#_subsrd_dlg_pay_info").prop('readonly', true);
        
        $("#_subsrd_pay_int_txn_date").prop('readonly', true);
        
        $("#subsrd_pay_int_charges").prop('readonly', true);
        $("#subsrd_pay_int_msg").prop('readonly', true);
        $("#subsrd_pay_int_sender").prop('readonly', true);
        
    }
}
