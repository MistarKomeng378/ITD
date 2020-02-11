var grid_trx_nfs;
var data_trx_nfs = [];

var grid_data_pending;
var grid_data_pending_parent;

var data_list_pending = [];
var data_list_pending_parent = [];

var dataView;

function initiate_trx_nfs()
{ 
    add_section("tbl_slick_trx_nfs","data_trx_nfs","refresh_trx_nfs_grid()","hbtn_trx_nfs","grid_trx_nfs");
    create_trx_nfs_grid(); 
    create_trx_nfs_event();
    //create_dlg_trx_nfs();       
    //create_dlg_trx_nfs_search();       
    //create_dlg_trx_nfs_history();
    //create_dlg_trx_nfs_ticket();
    $("#i_trx_nfs_list_dt").val(saiki);
    //show_sections('tbl_slick_trx_nfs');      
    //create_dlg_trx_nfs_approve();
}

function create_trx_nfs_grid()
{
    var columns_trx_nfs = [];
    var options_trx_nfs = [] ;

    columns_trx_nfs = [          
        {id:"trx_status", name:"Status", field:"trx_status",width:60}
        ,{id:"trx_sid", name:"SI REF", field:"trx_sid",width:80}
        ,{id:"trx_act", name:"Action", field:"trx_act",width:60}
        ,{id:"trx_valuta_dt", name:"Valuta Dt", field:"trx_valuta_dt",cssClass:"cell_right"}
        ,{id:"trx_due_dt", name:"Due Dt", field:"trx_due_dt",cssClass:"cell_right"}
        ,{id:"trx_to", name:"Kepada", field:"trx_to",width:190}
        ,{id:"trx_client_name", name:"Nama Klien", field:"trx_client_name",width:190}
        ,{id:"trx_type", name:"Tipe Trx", field:"trx_type"}
        ,{id:"trx_nominal", name:"Nominal", field:"trx_nominal",cssClass:"cell_right",width:160}
        ,{id:"trx_rate", name:"Bunga", field:"trx_rate",cssClass:"cell_right",width:60}
        ,{id:"trx_payment", name:"Pembayaran Bunga", field:"trx_payment",width:140}
        ,{id:"trx_create_by", name:"Dibuat Oleh", field:"trx_create_by"}
        ,{id:"trx_create_dt", name:"Tgl Buat", field:"trx_create_dt",cssClass:"cell_right"}
    ];       
    options_trx_nfs = {
        editable: false,
        enableCellNavigation: true,
        asyncEditorLoading: false,
        enableRowNavigation: true,
        autoEdit: false
    };         
    
    grid_trx_nfs = new Slick.Grid("#tbl_slick_trx_nfs", data_trx_nfs, columns_trx_nfs, options_trx_nfs);
    grid_trx_nfs.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
    
}

function refresh_trx_nfs_grid()
{
    trx_sect=1;                
    //state_progress(1);                                   alert()
    //alert(uri+"/index.php/itd/list_trx_nfs");
    state_progress(1);                       
    data_trx_nfs.length=0;
    var obj_post = $.post(uri+"index.php/itd_nfs/list_trx",{trx_dt:$("#i_trx_list_dt_nfs").val()},function(data) {
       //alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_trx_nfs[i] = {});
           d["trx_unix_no"] = data.r_sdata[i].trx_unix_no;
           d["trx_id"] = data.r_sdata[i].trx_id;
           d["trx_sid"] = data.r_sdata[i].nfs_sino;
           d["trx_act"] = data.r_sdata[i].nfs_trxstatus;
           d["trx_id_upper"] = data.r_sdata[i].trx_id_upper;
           d["trx_id_master"] = data.r_sdata[i].trx_id_master;
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
        
        grid_trx_nfs.invalidateAllRows();
        grid_trx_nfs.updateRowCount();
        grid_trx_nfs.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_trx_nfs_event()
{
    $("#hbtn_trx_get_nfs").click(function(){
        if(confirm('Dwonload data from S-Invest :'+$("#i_trx_list_dt_nfs").val()+'?'))
        {
            download_td_nfs($("#i_trx_list_dt_nfs").val());
        }
    });

    $("#hbtn_trx_refresh_nfs").click(function(){
        refresh_trx_nfs_grid();
    });

    $("#hbtn_trx_approve_nfs").click(function(){
        selected_row_trx_nfs  = grid_trx_nfs.getActiveCell();
        if(selected_row_trx_nfs)
        {
            if(data_trx_nfs[selected_row_trx_nfs.row].trx_status=="Approved" || data_trx_nfs[selected_row_trx_nfs.row].trx_status=="Ubah Approved")
                alert("Status Instruksi sudah Approved!");
            else if(data_trx_nfs[selected_row_trx_nfs.row].trx_status=="Cancelled" )
                alert("Status Instruksi sudah Approved!");
            else
            {
                set_var_dlg_trx(data_trx_nfs[selected_row_trx_nfs.row].trx_id,data_trx_nfs[selected_row_trx_nfs.row].trx_id_master,data_trx_nfs[selected_row_trx_nfs.row].trx_id_upper);
                open_dlg_trx(1,0,data_trx_nfs[selected_row_trx_nfs.row].trx_unix_no); 
            }
        }
        else
            alert("No data selected!");
    });

    $("#hbtn_trx_search_nfs").click(function(){
        open_dlg_trx_search(); 
    });

    $("#hbtn_trx_ticket_nfs").click(function(){
        selected_row_trx  = grid_trx_nfs.getActiveCell();               
        if(selected_row_trx)
            open_dlg_trx_ticket(data_trx_nfs[selected_row_trx.row].trx_id); 
        else
            alert("Instruksi belum dipilih!");
    });

    $("#hbtn_trx_print_nfs").click(function(){
        selected_row_trx  = grid_trx_nfs.getActiveCell();
        if(selected_row_trx)
        {                          
            if (data_trx_nfs[selected_row_trx.row].trx_unix_no==2)   
                do_print_trx(data_trx_nfs[selected_row_trx.row].trx_id);
            else
                alert("No approved yet.")
        }
        else
            alert("No data selected!");
    });
    
    grid_trx_nfs.onDblClick.subscribe(function(e) {     
        var cell = grid_trx_nfs.getCellFromEvent(e);
        set_var_dlg_trx(data_trx_nfs[cell.row].trx_id,data_trx_nfs[cell.row].trx_id_master,data_trx_nfs[cell.row].trx_id_upper);
        
        if(data_trx_nfs[cell.row].trx_unix_no==2)       
            open_dlg_trx(3,0,data_trx_nfs[cell.row].trx_unix_no); 
        else
            open_dlg_trx(1,0,data_trx_nfs[cell.row].trx_unix_no); 
    }); 

    $("#hbtn_trx_nfs_pending").click(function(){
        open_dlg_pending_data();
    });    
}

function download_td_nfs(p_dt)
{
    state_progress(1);
    disableButton("hbtn_trx_get_nfs");
    data_trx_nfs.length=0;
    var obj_post_down = $.post(uri+"index.php/itd_nfs/down_trx",{trx_dt:p_dt},function(data) {
    });
    obj_post_down.done(function(msg){
        refresh_trx_nfs_grid();
        state_progress(0);
        enableButton("hbtn_trx_get_nfs");
    });
    obj_post_down.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
        enableButton("hbtn_trx_get_nfs");
    });
}

function create_dlg_pending_data()
{
    $("#dialogBox_pending_data").dialog({ 
        title       : 'List Pending Data <span id="loadingPendingData"></span>',
        width       : 750,
        height      : 520,
        autoOpen    : false,
        resizable   : true,
        closeOnEsc  : true,
        modal       : true
    }).dialog("widget").draggable("option","containment","none");
}

function open_dlg_pending_data() {
    $("#dialogBox_pending_data").dialog("open");
    var listPending = $.post(uri+"index.php/itd_nfs/list_pending",{},function(data) {
        $("#dialogBox_pending_data").html(data);
    });
    listPending.done(function () {
        get_data_pending();
        create_list_table_pending();

        $("#pending_submit").click(function(){
            var parent = $('#input_parent').val();
            var child = $('#input_child').val();
    
            if(parent == '' && child == ''){ 
                alert('Pilih data terlebih dahulu');
                throw 'Pilih data terlebih dahulu';
            }
    
            if(parent == '' || child == ''){
                alert('Lengkapi data terlebih dahulu');
                throw 'Lengkapi data terlebih dahulu';
            }

            if(parent && child ){
                var txt;
                var r = confirm("Yakin akan proses data ini ?");
                if (r == true) {
                    $.post(uri+"index.php/itd_nfs/pending_to_submit",{parent: parent, child: child},function(data) {
                        console.log(data);
                    });
                }
            }
            
        });

    });
}

function get_data_pending() {
    $('#loadingPendingData').html('<img src="'+uri+'img/ajax-loader-small.gif" width="10px"/>');
    var obj_post = $.post(uri+"index.php/itd_nfs/show_list_pending",function(data){
    },'json');
    obj_post.done(function(data) {
        for (let index = 0; index < data.length; index++) {
            data_list_pending[index] = {
                'trx_id'            : data[index].trx_id,
                'type'              : data[index].type_desc,
                'trx_valuta_date'   : data[index].trx_valuta_date.date,
                'trx_due_date'      : data[index].trx_due_date.date,
                'trx_client_code'   : data[index].trx_client_code,
                'nfs_bank_code'     : data[index].nfs_bank_code,
                'trx_rate'          : data[index].trx_rate,
                'trx_nominal'       : strtomoney(data[index].trx_nominal),
            };
        }
        
        grid_data_pending.invalidateAllRows();
        grid_data_pending.updateRowCount();
        grid_data_pending.render();
        $('#loadingPendingData').html('');
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_data_pending.invalidateAllRows();
        grid_data_pending.updateRowCount();
        grid_data_pending.render();
        $('#loadingPendingData').html('');
    });    
}

function get_data_pending_parent(data) {
    $('#list_parent').html('');
    data_list_pending_parent = [];
    var obj_post = $.post(uri+"/index.php/itd_nfs/show_list_pending_parent",{
        trx_valuta_date : data.trx_valuta_date,
        trx_due_date : data.trx_due_date,
        trx_client_code : data.trx_client_code,
        nfs_bank_code : data.nfs_bank_code,
        trx_rate : data.trx_rate,
        trx_nominal : data.trx_nominal
    },function(data){
    },'json');

    obj_post.done(function(data) {        
        for (let index = 0; index < data.length; index++) {
            data_list_pending_parent[index] = {
                'trx_id'            : data[index].trx_id,
                'trx_id_upper'      : data[index].trx_id_upper,
                'type'              : data[index].type_desc,
                'trx_valuta_date'   : data[index].trx_valuta_date.date,
                'trx_due_date'      : data[index].trx_due_date.date,
                'trx_client_code'   : data[index].trx_client_code,
                'nfs_bank_code'     : data[index].nfs_bank_code,
                'trx_rate'          : data[index].trx_rate,
                'trx_nominal'       : strtomoney(data[index].trx_nominal),
                'id'                : data[index].id,
                'indent'            : data[index].trx_id_upper == 0 ? 0 : 1,
                'parent'            : data[index].parent
            };
        }
                
        create_list_table_pending_parent();
    });

    obj_post.fail(function(jqXHR, textStatus) {

    });  
}

function create_list_table_pending()
{
    var columns = [];
    var options = [] ; 
    columns = [         
        {id:"id", name:"ID", field:"trx_id", width:80}
        ,{id:"type", name:"Type", field:"type", width:80}
        ,{id:"trx_valuta_date", name:"Valuta Date", field:"trx_valuta_date", width:105}
        ,{id:"trx_due_date", name:"Due Date", field:"trx_due_date", width:105}
        ,{id:"trx_client_code", name:"Client Code", field:"trx_client_code",width:70}
        ,{id:"nfs_bank_code", name:"Bank Code", field:"nfs_bank_code",width:75}
        ,{id:"trx_rate", name:"Rate", field:"trx_rate",width:50, cssClass:"cell_right"}
        ,{id:"trx_nominal", name:"Nominal", field:"trx_nominal",width:110, cssClass:"cell_right"}
    ];

    options = {
        enableAddRow: true,
        editable: false,
        enableCellNavigation: true,
        asyncEditorLoading: false,
        enableRowNavigation: true,
        autoEdit: false,
        multiSelect: false
    };

    grid_data_pending = new Slick.Grid("#list_pending", data_list_pending, columns, options);
    grid_data_pending.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));        
    grid_data_pending.onDblClick.subscribe(function (e, args) {
        var rowSelected = args.grid.getActiveCell().row;
        var dataSelected = args.grid.getDataItem(rowSelected);

        get_data_pending_parent(dataSelected);
        
        var result_child = dataSelected.type+' : '+
        dataSelected.trx_id+' | '+
        dataSelected.trx_valuta_date+' | '+
        dataSelected.trx_due_date+' | '+
        dataSelected.trx_client_code+' | '+
        dataSelected.nfs_bank_code+' | '+
        dataSelected.trx_rate+' | '+
        dataSelected.trx_nominal;

        $('#result_chlid').html(result_child);
        $('#input_child').val(dataSelected.trx_id);
    });
}

function myFilter(item) {    
    if (item.parent != null) {
        var parent = data_list_pending_parent[item.parent];

        while (parent) {
            if (parent._collapsed) {
                return false;
            }

            parent = data_list_pending_parent[parent.parent];
        }
    }
    return true;
}

var TaskNameFormatter = function (row, cell, value, columnDef, dataContext) {
    value = value.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");
    var spacer = "<span style='display:inline-block;height:1px;width:" + (15 * dataContext["indent"]) + "px'></span>";
    var idx = dataView.getIdxById(dataContext.id);
    if (data_list_pending_parent[idx + 1] && data_list_pending_parent[idx + 1].indent > data_list_pending_parent[idx].indent) {
        if (dataContext._collapsed) {
            return spacer + " <span class='toggle expand'></span>&nbsp;" + value;
        } else {
            return spacer + " <span class='toggle collapse'></span>&nbsp;" + value;
        }
    } else {
        return spacer + " <span class='toggle'></span>&nbsp;" + value;
    }
};

function create_list_table_pending_parent()
{
    var columns = [
        {id:"trx_id", name:"ID", field:"trx_id", width:80, formatter: TaskNameFormatter}
        ,{id:"trx_id_upper", name:"Parent", field:"trx_id_upper", width:50}
        ,{id:"type", name:"Type", field:"type", width:80}
        ,{id:"trx_valuta_date", name:"Valuta Date", field:"trx_valuta_date", width:105}
        ,{id:"trx_due_date", name:"Due Date", field:"trx_due_date", width:105}
        ,{id:"trx_client_code", name:"Client Code", field:"trx_client_code",width:70}
        ,{id:"nfs_bank_code", name:"Bank Code", field:"nfs_bank_code",width:75}
        ,{id:"trx_rate", name:"Rate", field:"trx_rate",width:50, cssClass:"cell_right"}
        ,{id:"trx_nominal", name:"Nominal", field:"trx_nominal",width:110, cssClass:"cell_right"}
    ];

    var options = {
        editable: true,
        enableAddRow: true,
        enableCellNavigation: true,
        asyncEditorLoading: false
    };

    dataView = new Slick.Data.DataView({ inlineFilters: true });
    dataView.beginUpdate(); 
    dataView.setItems(data_list_pending_parent);
    dataView.setFilter(myFilter);
    dataView.endUpdate();

    grid_data_pending_parent = new Slick.Grid("#list_parent", dataView, columns, options);

    grid_data_pending_parent.onClick.subscribe(function (e, args) {
        if ($(e.target).hasClass("toggle")) {
            var item = dataView.getItem(args.row);            
            if (item) {
                if (!item._collapsed) {
                    item._collapsed = true;
                } else {
                    item._collapsed = false;
                }
                dataView.updateItem(item.id, item);
            }
            e.stopImmediatePropagation();
        }
    });
    
    // wire up model events to drive the grid
    dataView.onRowCountChanged.subscribe(function (e, args) {
        grid_data_pending_parent.updateRowCount();
        grid_data_pending_parent.render();
    });

    dataView.onRowsChanged.subscribe(function (e, args) {
        grid_data_pending_parent.invalidateRows(args.rows);
        grid_data_pending_parent.render();
    });

    grid_data_pending_parent.onDblClick.subscribe(function (e, args) {
        var rowSelected = args.grid.getActiveCell().row;
        var dataSelected = args.grid.getDataItem(rowSelected);
        
        var result_child = dataSelected.type+' : '+
        dataSelected.trx_id+' | '+
        dataSelected.trx_valuta_date+' | '+
        dataSelected.trx_due_date+' | '+
        dataSelected.trx_client_code+' | '+
        dataSelected.nfs_bank_code+' | '+
        dataSelected.trx_rate+' | '+
        dataSelected.trx_nominal;

        $('#result_parent').html(result_child);
        $('#input_parent').val(dataSelected.trx_id);
    });
}