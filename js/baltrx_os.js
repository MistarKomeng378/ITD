var grid_baltrx_os;
var data_baltrx_os = [];

function initiate_baltrx_os()
{                                                      
    add_section("tbl_slick_baltrx_os","data_baltrx_os","refresh_baltrx_os_grid()","hbtn_baltrx_os","grid_baltrx_os");
    create_baltrx_os_grid(); 
    create_baltrx_os_event();
    $("#hbtn_baltrx_os_dt").val(saiki);
    //create_baltrx_os_event();
    //$("#hbtn_baltrx_os_dt1").val(saiki);
    //$("#hbtn_baltrx_os_dt2").val(saiki);        
   // get_content_user_baltrx_os();
}
function create_baltrx_os_grid()
{    
    var columns_baltrx_os = [];
    var options_baltrx_os = [];
    
    columns_baltrx_os = [
        {id:"trade_date", name:"Trade Date", field:"trade_date",width:80}
        ,{id:"sett_date", name:"Settle Date", field:"sett_date",width:80}
        ,{id:"client_code", name:"Client Code", field:"client_code",width:70,cssClass:"cell_center"}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:170}
        ,{id:"sec_code", name:"Sec Code", field:"sec_code",width:70,cssClass:"cell_center"}
        ,{id:"sec_name", name:"Sec Name", field:"sec_name",width:170}
        ,{id:"tipe", name:"Trx Type", field:"tipe",width:100}
        ,{id:"units", name:"Units", field:"units",cssClass:"cell_right",width:140}
        ,{id:"amount", name:"Amount OS", field:"amount",cssClass:"cell_right",width:140}
    ];
    options_baltrx_os = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_baltrx_os = new Slick.Grid("#tbl_slick_baltrx_os", data_baltrx_os, columns_baltrx_os, options_baltrx_os);
    grid_baltrx_os.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_baltrx_os_grid()
{
    state_progress(1);
    data_baltrx_os.length=0;
    var obj_post = $.post(uri+"index.php/trxos/l",{
        dt:$("#hbtn_baltrx_os_dt").val()
    },function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_baltrx_os[i] = {});
           d["trade_date"] = data.r_sdata[i].trade_date_s;
           d["sett_date"] = data.r_sdata[i].settle_date_s;
           d["client_code"] = data.r_sdata[i].pfcode;
           d["client_name"] = data.r_sdata[i].pfname;
           d["sec_code"] = data.r_sdata[i].seccode;
           d["sec_name"] = data.r_sdata[i].secname;
           d["tipe"] = data.r_sdata[i].trxtype;
           d["units"] = strtomoney(data.r_sdata[i].unit);  
           d["amount"] = strtomoney(data.r_sdata[i].os);
           
        }
    },"json");
    obj_post.done(function(msg){
        grid_baltrx_os.invalidateAllRows();
        grid_baltrx_os.updateRowCount();
        grid_baltrx_os.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_baltrx_os_event()
{
    $("#hbtn_baltrx_os_reload").click(function(){          
        refresh_baltrx_os_grid();
    });
    $("#hbtn_baltrx_os_print").click(function(){          
        do_print_baltrx_os($("#hbtn_baltrx_os_dt").val());
    });
}
function do_print_baltrx_os(p_dt)
{
    loadPrintDocument(uri+'index.php/trxos/p/'+p_dt);
}