var data_mutasi11_rekap=[];     

function initiate_mutasi11_rekap()
{                                                      
    add_section("content_mutasi11_rekap","data_mutasi11_rekap","refresh_mutasi11_rekap()","hbtn_mutasi11_rekap","");
    //create_mutasi11_rekap_grid(); 
    //create_mutasi11_rekap_event();
    $("#hbtn_mutasi11_rekap_dt").val(saiki);
    get_content_user_mutasi11_rekap();
    create_mutasi11_rekap_event();
}
function get_content_user_mutasi11_rekap()
{         
    var obj_post = $.post(uri+"/index.php/mutasi/v_frekap",{},function(data) {
        $("#content_mutasi11_rekap").html(data);
    });
    obj_post.done(function(msg) { 
        
    });
}
function create_mutasi11_rekap_grid()
{    
    var columns_mutasi11_rekap = [];
    var options_mutasi11_rekap = [];
    
    columns_mutasi11_rekap = [
        {id:"status", name:"Status", field:"status",width:40,cssClass:"cell_center"}
        ,{id:"client_code", name:"Client Code", field:"client_code",width:70,cssClass:"cell_center"}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:200}
        ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
        ,{id:"balance_date", name:"Date", field:"balance_date",width:100}
        ,{id:"balance_open", name:"Opening", field:"balance_open",cssClass:"cell_right",width:120}
        ,{id:"balance_trx", name:"Mutasi", field:"balance_trx",cssClass:"cell_right",width:120}
        ,{id:"balance_close", name:"Closing", field:"balance_close",cssClass:"cell_right",width:120}
        ,{id:"balance_gs", name:"GS", field:"balance_gs",cssClass:"cell_right",width:120}
        ,{id:"selisih", name:"Selisih", field:"selisih",cssClass:"cell_right"}
        ,{id:"balance_remark", name:"Remark", field:"balance_remark",width:200}
        ,{id:"balance_open_by", name:"Opened by", field:"balance_open_by"}
        ,{id:"balance_close_by", name:"Closed by", field:"balance_close_by"}
    ];
    options_mutasi11_rekap = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_rekap = new Slick.Grid("#tbl_slick_mutasi11_rekap", data_mutasi11_rekap, columns_mutasi11_rekap, options_mutasi11_rekap);
    grid_mutasi11_rekap.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_rekap()
{
    $("#hbtn_mutasi11_rekap_dt").val(saiki);
    reload_mutasi11_rekap(saiki);
}

function create_mutasi11_rekap_event()
{
    $("#hbtn_mutasi11_rekap_reload").click(function(){
        reload_mutasi11_rekap($("#hbtn_mutasi11_rekap_dt").val());
    });
}

function reload_mutasi11_rekap(p_dt)
{                                    
    state_progress(1);
    data_mutasi11_rekap.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/v_frekap",{dt1:p_dt},function(data) {
    });
    obj_post.done(function(msg){    
         $("#content_mutasi11_rekap").html(msg);
        state_progress(0);                                 
    });
    obj_post.fail(function(jqXHR, textStatus) {        
        state_progress(0);
    });
}
