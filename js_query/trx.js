var grid_trx;
var data_trx = [];


function initiate_trx()
{ 
    add_section("tbl_slick_trx","data_trx","refresh_trx_grid()","hbtn_trx","grid_trx");
    create_trx_grid(); 
    create_trx_event();
    create_dlg_trx();       
    create_dlg_trx_search();       
    $("#i_trx_list_dt").val(saiki);
    show_sections('tbl_slick_trx');      
    
}

function create_trx_grid()
{
    var columns_trx = [];
    var options_trx = [] ;

    columns_trx = [          
        {id:"trx_id", name:"ID", field:"trx_id",width:50}
        ,{id:"trx_id_upper", name:"Parent ID",width:60, field:"trx_id_upper"}
        ,{id:"trx_status", name:"Status", field:"trx_status"}
        ,{id:"trx_valuta_dt", name:"Tgl Valuta", field:"trx_valuta_dt",cssClass:"cell_right"}
        ,{id:"trx_due_dt", name:"Tgl Jth Tempo", field:"trx_due_dt",cssClass:"cell_right"}
        ,{id:"trx_to", name:"Kepada", field:"trx_to",width:230}
        ,{id:"trx_client_name", name:"Nama Klien", field:"trx_client_name",width:250}
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


function create_trx_event()
{
    $("#hbtn_trx_search").click(function(){
        open_dlg_trx_search(); 
    });
    grid_trx.onDblClick.subscribe(function(e) {     
        var cell = grid_trx.getCellFromEvent(e);
        set_var_dlg_trx(data_trx[cell.row].trx_id,data_trx[cell.row].trx_id_master,data_trx[cell.row].trx_id_upper);
        
        if(data_trx[cell.row].trx_unix_no==2)       
            open_dlg_trx(3,0,data_trx[cell.row].trx_unix_no); 
        else
            open_dlg_trx(1,0,data_trx[cell.row].trx_unix_no); 
    });
    
}

function do_print_trx(tid)
{
    loadPrintDocument(uri+'index.php/itd/get_trx_for_print/'+tid);
}