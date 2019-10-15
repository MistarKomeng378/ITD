var grid_trx_duedate;
var data_trx_duedate = [];


function initiate_trx_duedate()
{
    add_section("tbl_slick_duedate","data_trx_duedate","refresh_trx_duedate_grid()","hbtn_trx_duedate","grid_trx_duedate");
    create_trx_duedate_grid(); 
    create_trx_duedate_event();
    
}

function create_trx_duedate_grid()
{
    var columns_trx_duedate = [];
    var options_trx_duedate = [] ;

    columns_trx_duedate = [          
        {id:"trx_duedate_no", name:"No", field:"trx_duedate_no",width:30}
        ,{id:"trx_duedate_id", name:"ID", field:"trx_duedate_id",width:40}
        ,{id:"trx_duedate_valuta_dt", name:"Tgl Valuta", field:"trx_duedate_valuta_dt",cssClass:"cell_right",width:70}
        ,{id:"trx_duedate_due_dt", name:"Tgl Jth Tempo", field:"trx_duedate_due_dt",cssClass:"cell_right",width:70}
        ,{id:"trx_duedate_to", name:"Kepada", field:"trx_duedate_to",width:230}
        ,{id:"trx_duedate_code", name:"Code", field:"trx_duedate_code",width:50}
        ,{id:"trx_duedate_client_name", name:"Nama Klien", field:"trx_duedate_client_name",width:250}
        ,{id:"trx_duedate_nominal", name:"Nominal", field:"trx_duedate_nominal",cssClass:"cell_right",width:140}
        ,{id:"trx_duedate_type", name:"Tipe Trx", field:"trx_duedate_type"}
        ,{id:"trx_duedate_rate", name:"Bunga", field:"trx_duedate_rate",cssClass:"cell_right",width:60}
        ,{id:"trx_duedate_payment", name:"Pembayaran Bunga", field:"trx_duedate_payment",width:140}
        ,{id:"trx_duedate_create_by", name:"Dibuat Oleh", field:"trx_duedate_create_by"}
        ,{id:"trx_duedate_create_dt", name:"Tgl Buat", field:"trx_duedate_create_dt",cssClass:"cell_right"}
    ];       
    options_trx_duedate = {
        editable: false,
        enableCellNavigation: true,
        asyncEditorLoading: false,
        enableRowNavigation: true,
        autoEdit: false
    };         
    
    grid_trx_duedate = new Slick.Grid("#tbl_slick_duedate", data_trx_duedate, columns_trx_duedate, options_trx_duedate);
    grid_trx_duedate.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
    
}
function refresh_trx_duedate_grid()
{
    state_progress(1);
    //alert(uri+"/index.php/itd/list_trx");
    state_progress(1);                       
    data_trx_duedate.length=0;
    var obj_post = $.post(uri+"index.php/itd_duedate/list_data",{trx_dt:$("#hbtn_trx_duedate_dt").val()},function(data) {
       //   alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_trx_duedate[i] = {});
           d["trx_duedate_no"] = i+1;
           d["trx_duedate_id"] = data.r_sdata[i].trx_id;
           d["trx_duedate_valuta_dt"] = data.r_sdata[i].trx_valuta_date_s;
           d["trx_duedate_due_dt"] = data.r_sdata[i].trx_due_date_s;
           d["trx_duedate_code"] = data.r_sdata[i].trx_client_code;
           d["trx_duedate_to"] = data.r_sdata[i].trx_to;
           d["trx_duedate_client_name"] = data.r_sdata[i].trx_client_name;
           d["trx_duedate_type"] = data.r_sdata[i].type_desc;
           d["trx_duedate_nominal"] = strtomoney(data.r_sdata[i].trx_nominal);  
           d["trx_duedate_rate"] = data.r_sdata[i].trx_rate + "%";
           d["trx_duedate_payment"] = data.r_sdata[i].payment_desc;
           d["trx_duedate_create_dt"] = data.r_sdata[i].trx_create_dt_s;
           d["trx_duedate_create_by"] = data.r_sdata[i].trx_create_by;
           
        }
    },'json');
    obj_post.done(function(msg){
        
        grid_trx_duedate.invalidateAllRows();
        grid_trx_duedate.updateRowCount();
        grid_trx_duedate.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}


function create_trx_duedate_event()
{
    $("#hbtn_trx_duedate_reload").click(function(){
        refresh_trx_duedate_grid();
    });
}