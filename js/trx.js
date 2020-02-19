var grid_trx;
var data_trx = [];
var trx_sect=0;
var grid_selected = [];

function initiate_trx()
{ 
    add_section("tbl_slick_trx","data_trx","refresh_trx_grid()","hbtn_trx","grid_trx");
    create_trx_grid(); 
    create_trx_event();
    create_dlg_trx();       
    create_dlg_trx_search();       
    create_dlg_trx_history();
    create_dlg_trx_ticket();
    $("#i_trx_list_dt").val(saiki);
    show_sections('tbl_slick_trx');      
    create_dlg_trx_approve();
    create_dlg_mutasi_client_search();
    create_dlg_pending_data();
}

function create_trx_grid()
{
    var columns_trx = [];
    var options_trx = [] ;

    columns_trx = [          
        {id:"trx_id", name:"ID", field:"trx_id",width:50}
        ,{id:"trx_id_upper", name:"Parent ID",width:50, field:"trx_id_upper"}
        ,{id:"nfs_td", name:"NFS", field:"nfs_td",width:30,}
        ,{id:"trx_status", name:"Status", field:"trx_status"}
        ,{id:"trx_valuta_dt", name:"Tgl Valuta", field:"trx_valuta_dt",cssClass:"cell_right"}
        ,{id:"trx_due_dt", name:"Tgl Jth Tempo", field:"trx_due_dt",cssClass:"cell_right"}
        ,{id:"trx_to", name:"Kepada", field:"trx_to",width:200}
        ,{id:"trx_client_name", name:"Nama Klien", field:"trx_client_name",width:200}
        ,{id:"trx_type", name:"Tipe Trx", field:"trx_type"}
        ,{id:"trx_nominal", name:"Nominal", field:"trx_nominal",cssClass:"cell_right",width:160}
        ,{id:"trx_rate", name:"Bunga", field:"trx_rate",cssClass:"cell_right",width:60}
        ,{id:"trx_payment", name:"Pembayaran Bunga", field:"trx_payment",width:140}
        ,{id:"trx_create_by", name:"Dibuat Oleh", field:"trx_create_by"}
        ,{id:"trx_create_dt", name:"Tgl Buat", field:"trx_create_dt",cssClass:"cell_right"}
    ];       
    options_trx = {
        editable: false,
        enableCellNavigation: true,
        asyncEditorLoading: false,
        enableRowNavigation: true,
        autoEdit: false
    };         
    
    grid_trx = new Slick.Grid("#tbl_slick_trx", data_trx, columns_trx, options_trx);
    grid_trx.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
    
}
function refresh_trx_grid()
{
    trx_sect=0;
    //state_progress(1);
    //alert(uri+"/index.php/itd/list_trx");
    state_progress(1);                       
    data_trx.length=0;
    var obj_post = $.post(uri+"index.php/itd/list_trx",{trx_dt:$("#i_trx_list_dt").val()},function(data) {
       //alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_trx[i] = {});
           d["trx_unix_no"] = data.r_sdata[i].trx_unix_no;
           d["trx_id"] = data.r_sdata[i].trx_id;
           d["trx_id_upper"] = data.r_sdata[i].trx_id_upper;
           d["nfs_td"] = (data.r_sdata[i].nfs_td=='1'?'PTP':'');
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
    },"json");
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

function save_to_excel_instruksi_deposito()
{
    var trx_to = $("#dlgTrxSearch_to").val();
    var trx_ccode = $("#dlgTrxSearch_client_code").val();
    var trx_cname = $("#dlgTrxSearch_client_name").val();
    var trx_stype = $("#dlgTrxSearch_type").val();
    var trx_nominal = $("#dlgTrxSearch_nominal").val();
    var trx_ntype = $("#dlgTrxSearch_nominal_type").val();
    var trx_sdate = $("#dlgTrxSearch_sdate").val();
    var trx_edate = $("#dlgTrxSearch_edate").val();
    var trx_id = $("#dlgTrxSearch_id").val();

    var trx_to = trx_to ? trx_to : 0 ;
    var trx_ccode = trx_ccode ? trx_ccode : 0 ;
    var trx_cname = trx_cname ? trx_cname : 0 ;
    var trx_stype = trx_stype ? trx_stype : 0 ;
    var trx_nominal = trx_nominal ? trx_nominal : 0 ;
    var trx_ntype = trx_ntype ? trx_ntype : 0 ;
    var trx_sdate = trx_sdate ? trx_sdate : 0 ;
    var trx_edate = trx_edate ? trx_edate : 0 ;
    var trx_id = trx_id ? trx_id : 0 ;

    var param = '/'+ trx_to +'/'+ trx_ccode +'/'+ trx_cname +'/'+ trx_stype +'/'+ trx_nominal +'/'+ trx_ntype +'/'+ trx_sdate +'/'+ trx_edate +'/'+ trx_id;
    
    window.open(uri+"index.php/itd/save_to_excel_approved"+param,"_blank");
}

function create_trx_event()
{
    $('#instruksi_deposito_excel').click(function(){
        save_to_excel_instruksi_deposito();
    });

    $("#hbtn_trx_refresh").click(function(){
        refresh_trx_grid();
    });
    $("#hbtn_trx_search").click(function(){
        open_dlg_trx_search(); 
    });
    $("#hbtn_trx_history").click(function(){
        open_dlg_trx_history(); 
    });
    $("#hbtn_trx_edit").click(function(){
        selected_row_trx  = grid_trx.getActiveCell();
        
        
        if(selected_row_trx)
        {
			// if(data_trx[selected_row_trx.row].nfs_td=='PTP')            
              //alert("Cannot edit Placement from SINVEST!");
            // else
				// if(data_trx[selected_row_trx.row].trx_unix_no!=2)
                // alert("Instruksi belum dipilih!");
            // else 
			if(data_trx[selected_row_trx.row].trx_child_status==2) 
                alert("Instruksi sudah menjadi acuan instruksi lain (perpanjangan)!");
            else if(data_trx[selected_row_trx.row].trx_child_status==3) 
                alert("Instruksi sudah menjadi acuan instruksi lain (pencairan)!");
            else if(data_trx[selected_row_trx.row].trx_child_status==4) 
                alert("Instruksi sudah menjadi acuan instruksi lain (break)!");
            else
            {
                set_var_dlg_trx(data_trx[selected_row_trx.row].trx_id,data_trx[selected_row_trx.row].trx_id_master,data_trx[selected_row_trx.row].trx_id_upper);
                
                if(data_trx[selected_row_trx.row].trx_type_id == 4){
                    open_dlg_trx(2,4,2);
                }else{
                    open_dlg_trx(2,0,2);
                }
                grid_selected = data_trx[selected_row_trx.row];
            }
        }
        else
            alert("Referensi Instruksi belum dipilih!");   
    });
    $("#hbtn_trx_new").click(function(){
        if($("#hselect_trx_type").val()=='1')         
        {
            set_var_dlg_trx(0,0,0)   ;
            open_dlg_trx(0,1,1);
        }
        else
        {
            selected_row_trx  = grid_trx.getActiveCell();
            if(selected_row_trx)
            {
                if(data_trx[selected_row_trx.row].trx_unix_no!=2)
                    alert("Transaksi acuan belum di Approve!");
                else if(data_trx[selected_row_trx.row].trx_child_status==2) 
                     alert("Instruksi sudah menjadi acuan instruksi lain (perpanjangan)!");
                else if(data_trx[selected_row_trx.row].trx_child_status==3) 
                     alert("Instruksi sudah menjadi acuan instruksi lain (pencairan)!");
                else if(data_trx[selected_row_trx.row].trx_child_status==4) 
                     alert("Instruksi sudah menjadi acuan instruksi lain (break)!");
                else
                {
                    if(data_trx[selected_row_trx.row].trx_type_id!="1" && data_trx[selected_row_trx.row].trx_type_id!="2")
                        alert("Pilih type instruksi yang tepat (penempatan/perpanjangan) untuk menjadi acuan!");
                    else
                    {
                        set_var_dlg_trx(data_trx[selected_row_trx.row].trx_id,data_trx[selected_row_trx.row].trx_id_master,data_trx[selected_row_trx.row].trx_id_upper);
                        open_dlg_trx(0,$("#hselect_trx_type").val(),2);    
                        //console.log(0+'_'+$("#hselect_trx_type").val()+'_'+2);
                                                                                                     
                    }
                }
            }
            else
                alert("Referensi Instruksi belum dipilih!");
        }
    });                 
     $("#hbtn_trx_cancel").click(function(){
        selected_row_trx  = grid_trx.getActiveCell();
        if(selected_row_trx)
        {
			//Edit By MK
            // if(data_trx[selected_row_trx.row].nfs_td=='PTP')
                // alert("can not cancel Placement from SINVEST!");
            // else 
			if(data_trx[selected_row_trx.row].trx_child_status==2) 
                alert("Instruksi sudah menjadi acuan instruksi lain (perpanjangan)!");
            else if(data_trx[selected_row_trx.row].trx_child_status==3) 
                alert("Instruksi sudah menjadi acuan instruksi lain (pencairan)!");
            else if(data_trx[selected_row_trx.row].trx_child_status==4) 
                alert("Instruksi sudah menjadi acuan instruksi lain (break)!");
            else if(data_trx[selected_row_trx.row].trx_bilyet_flag_no=='IN' || data_trx[selected_row_trx.row].trx_bilyet_flag_no=='OUT') 
                alert("Sudah/Pernah ada bilyet masuk pada instruksi ini!");
            else
            {
                set_var_dlg_trx(data_trx[selected_row_trx.row].trx_id,data_trx[selected_row_trx.row].trx_id_master,data_trx[selected_row_trx.row].trx_id_upper);
                open_dlg_trx(5,$("#hselect_trx_type").val(),2); 
                grid_selected = data_trx[selected_row_trx.row];
            }
        }
        else
            alert("Instruki belum di pilih!");
     });
    $("#hbtn_trx_approve").click(function(){
        selected_row_trx  = grid_trx.getActiveCell();
        if(selected_row_trx)
        {
            if(data_trx[selected_row_trx.row].trx_status=="Approved" || data_trx[selected_row_trx.row].trx_status=="Ubah Approved")
                alert("Status Instruksi sudah Approved!");
            else if(data_trx[selected_row_trx.row].trx_status=="Cancelled" )
                alert("Status Instruksi sudah Approved!");
            else
            {
                set_var_dlg_trx(data_trx[selected_row_trx.row].trx_id,data_trx[selected_row_trx.row].trx_id_master,data_trx[selected_row_trx.row].trx_id_upper);
                open_dlg_trx(1,0,data_trx[selected_row_trx.row].trx_unix_no); 
            }
        }
        else
            alert("No data selected!");
    });
    $("#hbtn_trx_print").click(function(){
        selected_row_trx  = grid_trx.getActiveCell();
        if(selected_row_trx)
        {                          
            if (data_trx[selected_row_trx.row].trx_unix_no==2)   
                do_print_trx(data_trx[selected_row_trx.row].trx_id);
            else
                alert("No approved yet.")
        }
        else
            alert("No data selected!");
    });
    grid_trx.onDblClick.subscribe(function(e) {     
        var cell = grid_trx.getCellFromEvent(e);
        set_var_dlg_trx(data_trx[cell.row].trx_id,data_trx[cell.row].trx_id_master,data_trx[cell.row].trx_id_upper);
        
        if(data_trx[cell.row].trx_unix_no==2 && data_trx[cell.row].trx_type_id == 1){
            open_dlg_trx(3,0,data_trx[cell.row].trx_unix_no);
        }else if(data_trx[cell.row].trx_unix_no == 2 && data_trx[cell.row].trx_type_id !== 1 ){
            open_dlg_trx(1,0,data_trx[cell.row].trx_unix_no);
        }else{
            open_dlg_trx(1,0,data_trx[cell.row].trx_unix_no);
        }
             
    });
    $("#hbtn_trx_ticket").click(function(){
        selected_row_trx  = grid_trx.getActiveCell();               
        if(selected_row_trx)
            open_dlg_trx_ticket(data_trx[selected_row_trx.row].trx_id); 
        else
            alert("Instruksi belum dipilih!");
    });
}

function do_print_trx(tid)
{
    loadPrintDocument(uri+'index.php/itd/get_trx_for_print/'+tid);
}