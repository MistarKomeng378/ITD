var subs_rekap_id=0;
var grid_subs_rekap;
var data_subs_rekap = [];

function initiate_subs_rekap()
{
    add_section("tbl_slick_subs_rekap","data_subs_rekap","refresh_subs_rekap()","hbtn_subs_rekap","grid_subs_rekap");
    $("#hbtn_subs_rekap_dt1").val(saiki);
    $("#hbtn_subs_rekap_dt2").val(saiki);
    create_subs_rekap_grid();
    create_subs_rekap_event();
    

}    
function create_subs_rekap_grid()
{
    var columns_subs_rekap = [];
    var options_subs_rekap = [] ; 
    columns_subs_rekap = [         
        {id:"client_code", name:"Kode Klien", field:"client_code",width:60}
        ,{id:"client_name", name:"Nama Klien", field:"client_name",width:200}
        ,{id:"bank_desc", name:"Nama Bank", field:"bank_desc",width:200}
        ,{id:"acc_no", name:"No Rekening", field:"acc_no",width:110}
        ,{id:"update_time", name:"Update dt", field:"update_time",width:80}
        ,{id:"pending_upd", name:"Pending Upd", field:"pending_upd",width:110}
        ,{id:"hiport_upd", name:"Hiport Upd", field:"hiport_upd",width:110}
        ,{id:"hiport_pending_upd", name:"Pending+Hiport Upd", field:"hiport_pending_upd",width:110}
        ,{id:"saldo_upd", name:"Saldo Upd", field:"saldo_upd",width:110}
        ,{id:"selisih_upd", name:"Selisih Upd", field:"selisih_upd",width:110}
        ,{id:"update_by", name:"Update by", field:"update_by",width:110}
    ];
    options_subs_rekap = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subs_rekap = new Slick.Grid("#tbl_slick_subs_rekap", data_subs_rekap, columns_subs_rekap, options_subs_rekap);
    grid_subs_rekap.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_subs_rekap()
{
    state_progress(1); //             alert('a');
    data_subs_rekap.length=0;        
    var obj_post = $.post(uri+"/index.php/subscript_rekap/list_rekap", {b_dt:$("#hbtn_subs_rekap_dt").val()},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subs_rekap[i] = {});
            d["client_code"] = msg.r_sdata[i].client_code;
            d["client_name"] = msg.r_sdata[i].client_name;
            d["bank_code"] = msg.r_sdata[i].bank_code;
            d["acc_no"] = msg.r_sdata[i].acc_no;
            d["bank_desc"] = msg.r_sdata[i].bank_desc;
            d["update_time"] = msg.r_sdata[i].update_time_s;            
            d["pending_upd"] = strtomoney(msg.r_sdata[i].pending_upd);
            d["hiport_upd"] = strtomoney(msg.r_sdata[i].hiport_upd);  
            d["hiport_pending_upd"] = strtomoney(msg.r_sdata[i].hiport_pending_upd);
            d["saldo_upd"] = strtomoney(msg.r_sdata[i].saldo_upd);
            d["selisih_upd"] = strtomoney(msg.r_sdata[i].selisih_upd);
            d["update_by"] = msg.r_sdata[i].update_by;
        }
        

        
        grid_subs_rekap.invalidateAllRows();
        grid_subs_rekap.updateRowCount();
        grid_subs_rekap.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subs_rekap.invalidateAllRows();
        grid_subs_rekap.updateRowCount();
        grid_subs_rekap.render();
        state_progress(0);}
    );
}

function create_subs_rekap_event()
{
    $("#hbtn_subs_rekap_reload").click(function(){   //  alert('a');
        refresh_subs_rekap();
    });
    $("#hbtn_subs_rekap_save").click(function(){   //  alert('a');
        window.open(uri+"/index.php/subscript_rekap/save_rekap"+'/'+$("#hbtn_subs_rekap_dt").val(),"_blank");
    });
}
