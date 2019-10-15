var grid_bilyet_inst;
var data_bilyet_inst = [];
var trx_id_bilyet =0;

// for save as
var search_kat = 0;

var list_type_bilyet=0;
var tipe_bilyet_inst=0;
var opt_bilyet_inst=0;
//

function initiate_bilyet_inst()
{ 
    add_section("tbl_slick_bilyet_inst","data_bilyet_inst","refresh_bilyet_inst_grid()","hbtn_bilyet_inst","grid_bilyet_inst");
    create_bilyet_inst_grid(); 
    create_bilyet_inst_event();
    create_dlg_bilyet_inst_search();       
    create_dlg_bilyet_inst_in();    
    create_dlg_bilyet_inst_out();     
    //if(user_unit==2)
    //        show_sections('tbl_slick_bilyet_inst');             
}

function create_bilyet_inst_grid()
{
    var columns_bilyet_inst = [];
    var options_bilyet_inst = [] ;

    columns_bilyet_inst = [
        {id:"trx_id", name:"Txr ID", field:"trx_id",cssClass:"cell_center",width:60}
        ,{id:"trx_bilyet_rcv", name:"IN/ OUT", field:"trx_bilyet_rcv",cssClass:"cell_center",width:60}
        ,{id:"trx_bilyet_no", name:"No Bilyet", field:"trx_bilyet_no",width:120} 
        ,{id:"trx_bilyet_to", name:"Kepada", field:"trx_bilyet_to",width:160}
        ,{id:"trx_client_name", name:"Nama Klien", field:"trx_client_name",width:180}
        ,{id:"trx_type", name:"Tipe", field:"trx_type",width:80}
        ,{id:"trx_nominal", name:"Nominal", field:"trx_nominal",cssClass:"cell_right",width:120}
        ,{id:"trx_val_dt", name:"Tgl Valuta", field:"trx_val_dt",cssClass:"cell_right",width:80} 
        ,{id:"trx_due_dt", name:"Tgl Jth Tempo", field:"trx_due_dt",cssClass:"cell_right",width:80} 
        ,{id:"trx_rate", name:"Rate", field:"trx_rate",cssClass:"cell_right",width:40}
        ,{id:"trx_in_dt", name:"Tgl Masuk", field:"trx_in_dt",cssClass:"cell_right",width:80} 
        ,{id:"trx_out_dt", name:"Tgl Keluar", field:"trx_out_dt",cssClass:"cell_right",width:80} 
        ,{id:"trx_acc_name", name:"Nama Account", field:"trx_acc_name",width:180} 
        ,{id:"trx_bank_name", name:"Bank", field:"trx_bank_name",width:160}   
        ,{id:"trx_acc_no", name:"No Rek", field:"trx_acc_no",width:120}          
    ];       
    options_bilyet_inst = {
        editable: false,
        enableCellNavigation: true,
        asyncEditorLoading: false,
        enableRowNavigation: true,
        autoEdit: false
    };         
    
    grid_bilyet_inst = new Slick.Grid("#tbl_slick_bilyet_inst", data_bilyet_inst, columns_bilyet_inst, options_bilyet_inst);
    grid_bilyet_inst.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
    
}
function clear_bilyet_inst_grid()
{
    data_bilyet_inst.length=0;
    grid_bilyet_inst.invalidateAllRows();
    grid_bilyet_inst.updateRowCount();
    grid_bilyet_inst.render();
}
function list_pending_bilyet_inst(ptipe,popt1)
{
    list_type_bilyet=1;
    tipe_bilyet_inst=ptipe;
    opt_bilyet_inst=popt1;
    state_progress(1);     
    data_bilyet_inst.length=0;                        
    var obj_post = $.post(uri+"/index.php/itd_bilyet/list_pending_bilyet_inst", 
        { b_tipe:ptipe,p_opt:popt1},function(data) {                
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_bilyet_inst[i] = {});
           d["trx_id"] = data.r_sdata[i].trx_id;
           d["trx_bilyet_rcv"] = data.r_sdata[i].trx_bilyet_flag_no='' || data.r_sdata[i].trx_bilyet_flag_no=='NONE' ? '':data.r_sdata[i].trx_bilyet_flag_no ;
           d["trx_bilyet_no"] = data.r_sdata[i].trx_bilyet_flag_no=='IN'?data.r_sdata[i].no_in:data.r_sdata[i].trx_bilyet_flag_no=='OUT'?data.r_sdata[i].no_out:'';
           d["trx_bilyet_to"] = data.r_sdata[i].trx_to;
           d["trx_bank_name"] = data.r_sdata[i].trx_bank_name;
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
function refresh_bilyet_inst_grid()
{
    data_bilyet_inst.length=0;
    //grid_bilyet_inst.invalidateAllRows();
    //grid_bilyet_inst.updateRowCount();
    //grid_bilyet_inst.render();
    clear_field_bilyet_inst_search();
    do_search_bilyet_inst_search();           
    //state_progress(1);
    //alert(uri+"/index.php/itd/list_bilyet_inst");
    /*state_progress(1);                       
    data_bilyet_inst.length=0;
    var obj_post = $.post(uri+"index.php/itd/list_bilyet_inst",{trx_dt:$("#i_bilyet_inst_list_dt").val()},function(data) {
        //alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_bilyet_inst[i] = {});
           d["trx_unix_no"] = data.r_sdata[i].trx_unix_no;
           d["trx_id"] = data.r_sdata[i].trx_id;
           d["trx_status"] = data.r_sdata[i].status_desc;
           d["trx_to"] = data.r_sdata[i].trx_to;
           d["trx_client_name"] = data.r_sdata[i].trx_client_name;
           d["trx_type"] = data.r_sdata[i].type_desc;
           d["trx_nominal"] = data.r_sdata[i].trx_nominal;  
           d["trx_rate"] = data.r_sdata[i].trx_rate + "%";
           d["trx_payment"] = data.r_sdata[i].payment_desc;
           d["trx_create_dt"] = data.r_sdata[i].trx_create_dt_s;
           d["trx_create_by"] = data.r_sdata[i].trx_create_by;
        }
    },"json");
    obj_post.done(function(msg){
        
        grid_bilyet_inst.invalidateAllRows();
        grid_bilyet_inst.updateRowCount();
        grid_bilyet_inst.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });*/
}


function create_bilyet_inst_event()
{
    $("#hbtn_bilyet_inst_search").click(function(){
        //set_var_dlg_bilyet_inst(0,0);
        open_dlg_bilyet_inst_search();
    });    
    $("#hbtn_bilyet_inst_in").click(function(){
        selected_row_bilyet_inst  = grid_bilyet_inst.getActiveCell();
        if(selected_row_bilyet_inst!=null)
        {
            if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='' || data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv == null)
            {
                open_dlg_bilyet_inst_in();
                trx_id_bilyet=data_bilyet_inst[selected_row_bilyet_inst.row].trx_id ;
                do_get_bilyet_inst_none();
            }
            else if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='IN')
                alert("Please take out the bilyet first.");
            else if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='OUT')
                alert("Bilyet Out Already.");
            else 
                alert("Unknown bilyet status");
        }
        else
            alert("No data selected!");
    });                 
    $("#hbtn_bilyet_inst_out").click(function(){ 
        selected_row_bilyet_inst  = grid_bilyet_inst.getActiveCell();
        if(selected_row_bilyet_inst!=null)
        {
            if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='IN')
            {
                open_dlg_bilyet_inst_out();
                trx_id_bilyet=data_bilyet_inst[selected_row_bilyet_inst.row].trx_id ;
                do_get_bilyet_inst_in();
            }
            else 
                alert("No bilyet IN yet.");
        }
        else
            alert("No data selected!");
    });
    $("#hbtn_bilyet_inst_open").click(function(){
        selected_row_bilyet_inst  = grid_bilyet_inst.getActiveCell();
        if(selected_row_bilyet_inst &&  selected_row_bilyet_inst.row < data_bilyet_inst.length)
        {
            if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='')
            {
                set_var_dlg_bilyet_inst(data_bilyet_inst[selected_row_bilyet_inst.row].trx_id,data_bilyet_inst[selected_row_bilyet_inst.row].trx_unix_no);
                open_dlg_bilyet_inst();                                                                                 
            }
            else if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='IN')
                alert("Please take out the bilyet first.");
            else 
                alert("Unknown bilyet status");
        }
        else
            alert("No data selected!");
    });
    $("#hbtn_bilyet_inst_print").click(function(){
        if(confirm('Print current list?'))
            do_print_bilyet_list();
    });
    $("#hbtn_bilyet_inst_save").click(function(){
        //do_save_bilyet_list();
        //alert('a');
        excel_bilyet_inst(); 
    });
    $("#hbtn_bilyet_cancel").click(function(){
        selected_row_bilyet_inst  = grid_bilyet_inst.getActiveCell();
        if(selected_row_bilyet_inst &&  selected_row_bilyet_inst.row < data_bilyet_inst.length)
        {
            if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='IN')
            {
                if(confirm("Are you sure to cancel the Bilyet IN?"))
                    do_bilyet_cancel(data_bilyet_inst[selected_row_bilyet_inst.row].trx_id,1);
            }
            else if(data_bilyet_inst[selected_row_bilyet_inst.row].trx_bilyet_rcv=='OUT')
            {
                if(confirm("Are you sure to cancel the Bilyet OUT?"))
                    do_bilyet_cancel(data_bilyet_inst[selected_row_bilyet_inst.row].trx_id,2);
            }
            else
                alert("No bilyet IN or Out.");
        }
    });
    grid_bilyet_inst.onDblClick.subscribe(function(e) {     
        var cell = grid_bilyet_inst.getCellFromEvent(e);
        //set_var_dlg_bilyet_inst(data_bilyet_inst[cell.row].trx_id,data_bilyet_inst[cell.row].trx_unix_no);
        //open_dlg_bilyet_inst(); 
        if(user_unit==2)
        {
            if(data_bilyet_inst[cell.row].trx_bilyet_rcv=='' ||  data_bilyet_inst[cell.row].trx_bilyet_rcv == null)
            {
                open_dlg_bilyet_inst_in();
                trx_id_bilyet=data_bilyet_inst[cell.row].trx_id ;
                do_get_bilyet_inst_none();
            }
            else if(data_bilyet_inst[cell.row].trx_bilyet_rcv=='IN')
            {
                open_dlg_bilyet_inst_out();
                trx_id_bilyet=data_bilyet_inst[cell.row].trx_id ;
                do_get_bilyet_inst_in();
            }
        }
        else
        {
            set_var_dlg_trx(data_bilyet_inst[cell.row].trx_id,0,0);
        
            //if(data_trx[cell.row].trx_unix_no==2)       
                open_dlg_trx(3,0,2); 
            //else
            //open_dlg_trx(1,0,data_trx[cell.row].trx_unix_no); 
        }
        
    });
    $("#hbtn_bilyet_inst_view").click(function(){
        selected_row_bilyet_inst  = grid_bilyet_inst.getActiveCell();
        if(selected_row_bilyet_inst!=null)
        {
            set_var_dlg_trx(data_bilyet_inst[selected_row_bilyet_inst.row].trx_id,0,0);
             open_dlg_trx(3,0,2); 
        }
        else
            alert("No data selected!");
    });
}
function do_print_bilyet_list()
{                                          
    var bil_q=  trim($("#dlgBil_type").val());
    for(var i=0;i<data_bilyet_inst.length;i++) 
    {
          bil_q=bil_q+dlmt+data_bilyet_inst[i].trx_id;
    }
    //alert(bil_q);
    loadPrintDocument(uri+'index.php/itd_bilyet/get_list_bilyet_for_print/'+bil_q);
}

function do_save_bilyet_list()
{                                          
    var bil_q=  trim($("#dlgBil_type").val());
    for(var i=0;i<data_bilyet_inst.length;i++) 
    {
          bil_q=bil_q+dlmt+data_bilyet_inst[i].trx_id;
    }
    
    window.location = (uri+'index.php/itd_bilyet/get_list_bilyet_for_save/'+bil_q);
}
var bilyet_timer_id;
function refresh_bilyet_status_count()
{                                                      
    if(typeof(bilyet_timer_id)=='number')
        clearTimeout ( bilyet_timer_id );
    var obj_post = $.post(uri+"/index.php/itd_bilyet/get_bilyet_status_count", {},function(data) {},'json');
    obj_post.done(function(msg){  
        if(msg.r_num_rows>0)
        {
            $("#bilyet_status_must_in0").html(msg.r_sdata[0].c_min0);
            $("#bilyet_status_must_in1").html(msg.r_sdata[0].c_min1);
            $("#bilyet_status_must_in2").html(msg.r_sdata[0].c_min2);
            $("#bilyet_status_must_in3").html(msg.r_sdata[0].c_min3);
            $("#bilyet_status_must_in4").html(msg.r_sdata[0].c_min4);
            $("#bilyet_status_must_in5").html(msg.r_sdata[0].c_min5);
            $("#bilyet_status_must_in6").html(msg.r_sdata[0].c_min6);
            $("#bilyet_status_must_in7").html(msg.r_sdata[0].c_min7);
            $("#bilyet_status_must_in8").html(msg.r_sdata[0].c_min8);
            $("#bilyet_status_in").html(msg.r_sdata[0].c_in);
            $("#bilyet_status_out").html(msg.r_sdata[0].c_out);
            $("#bilyet_status_must_out").html(msg.r_sdata[0].c_mout);
        }
        else
        {
            $("#bilyet_status_must_in0").html(0);
            $("#bilyet_status_must_in1").html(0);
            $("#bilyet_status_must_in2").html(0);
            $("#bilyet_status_must_in3").html(0);
            $("#bilyet_status_must_in4").html(0);
            $("#bilyet_status_must_in5").html(0);
            $("#bilyet_status_must_in6").html(0);
            $("#bilyet_status_must_in7").html(0);
            $("#bilyet_status_must_in8").html(0);
            $("#bilyet_status_in").html(0);
            $("#bilyet_status_out").html(0);
            $("#bilyet_status_must_out").html(0);
        }
       bilyet_timer_id=setTimeout(function(){refresh_bilyet_status_count()},60000);
    });
}

function do_bilyet_cancel(t_id,i_cancel)
{                          
    state_progress(1);     
    data_bilyet_inst.length=0;                        
    var obj_post = $.post(uri+"/index.php/itd_bilyet/do_bilyet_inst_cancel", 
        { trx_id:t_id,i_c:i_cancel},function(data) {},'json');
    obj_post.done(function(msg){
        do_search_bilyet_inst_search();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function excel_bilyet_inst()
{
    var a='';
    a="<input type='text' name='tipe' value='"+list_type_bilyet+"' />";
    a=a+"<input type='text' name='p1' value='"+tipe_bilyet_inst+"' />";
    a=a+"<input type='text' name='p2' value='"+opt_bilyet_inst+"' />";
    a=a+"<input type='text' name='b_no' value='"+$("#dlgBil_no").val()+"' />";
    a=a+"<input type='text' name='b_cname' value='"+$("#dlgBil_client_name").val()+"' />";
    a=a+"<input type='text' name='b_bname' value='"+$("#dlgBil_bank_name").val()+"' />";
    a=a+"<input type='text' name='b_val_dt' value='"+$("#dlgBil_val_dt").val()+"' />";
    a=a+"<input type='text' name='b_due_dt' value='"+$("#dlgBil_due_dt").val()+"' />";
    a=a+"<input type='text' name='b_nominal' value='"+$("#dlgBil_nominal").val()+"' />";
    a=a+"<input type='text' name='b_type' value='"+$("#dlgBil_type").val()+"' />";
    a=a+"<input type='text' name='b_ccode' value='"+$("#dlgBil_client_code").val()+"' />";
    a=a+"<input type='text' name='b_to' value='"+$("#dlgBil_to").val()+"' />";    // alert(a);
    $("#frm_hidden").html(a).attr('action', uri+"index.php/itd_bilyet/save_list_bilyet").submit();
}