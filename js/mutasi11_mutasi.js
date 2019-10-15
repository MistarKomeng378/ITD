var grid_mutasi11_mutasi;
var data_mutasi11_mutasi = [];

function initiate_mutasi11_mutasi()
{                                                      
    add_section("tbl_slick_mutasi11_mutasi","data_mutasi11_mutasi","refresh_mutasi11_mutasi_grid()","hbtn_mutasi11_mutasi","grid_mutasi11_mutasi");
    create_mutasi11_mutasi_grid(); 
    create_mutasi11_mutasi_event();
    $("#hbtn_mutasi11_mutasi_dt1").val(saiki);
    $("#hbtn_mutasi11_mutasi_dt2").val(saiki);        
}
function create_mutasi11_mutasi_grid()
{    
    var columns_mutasi11_mutasi = [];
    var options_mutasi11_mutasi = [];
    
    columns_mutasi11_mutasi = [
        {id:"client_code", name:"Client Code", field:"client_code",width:70,cssClass:"cell_center"}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:200}
        ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
        ,{id:"trx_date", name:"Date", field:"balance_date",width:100}
        ,{id:"trx_nominal", name:"Nominal", field:"trx_nominal",cssClass:"cell_right",width:120}
    ];
    options_mutasi11_mutasi = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_mutasi = new Slick.Grid("#tbl_slick_mutasi11_mutasi", data_mutasi11_mutasi, columns_mutasi11_mutasi, options_mutasi11_mutasi);
    grid_mutasi11_mutasi.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_mutasi_grid()
{
    state_progress(1);
    data_mutasi11_mutasi.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/list_mutasi_taxbro",{
        dt1:$("#hbtn_mutasi11_mutasi_dt1").val(),dt2:$("#hbtn_mutasi11_mutasi_dt2").val()
    },function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mutasi11_mutasi[i] = {});
           d["trx_id"] = data.r_sdata[i].balance_id;
           d["client_code"] = data.r_sdata[i].client_code;
           d["client_name"] = data.r_sdata[i].client_name;
           d["acc_no"] = data.r_sdata[i].acc_no;
           d["trx_date"] = data.r_sdata[i].trx_date_s;
           d["trx_nominal"] = strtomoney(data.r_sdata[i].trx_nominal);
        }
    },"json");
    obj_post.done(function(msg){
        grid_mutasi11_mutasi.invalidateAllRows();
        grid_mutasi11_mutasi.updateRowCount();
        grid_mutasi11_mutasi.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_mutasi11_mutasi_event()
{
    $("#hbtn_mutasi11_mutasi_reload").click(function(){          
        refresh_mutasi11_mutasi_grid();
    });
    
    $("#hbtn_mutasi11_mutasi_save").click(function(){        
        save_mutasi11_mutasi();
        refresh_mutasi11_mutasi_grid();
    });
               
}
function save_mutasi11_mutasi()
{
    var a='';
    a=a+"<input type='text' name='dt1' value='"+$("#hbtn_mutasi11_mutasi_dt1").val()+"' />";
    a=a+"<input type='text' name='dt2' value='"+$("#hbtn_mutasi11_mutasi_dt2").val()+"' />";
    a=a+"<input type='text' name='proc' value='"+$("#hbtn_mutasi11_mutasi_proc").val()+"' />";
    $("#frm_hidden").html(a).attr('action', uri+"index.php/mutasi/save_list_mutasi").submit();
}