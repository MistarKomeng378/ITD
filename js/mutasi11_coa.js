var grid_mutasi11_coa;
var data_mutasi11_coa = [];

function initiate_mutasi11_coa()
{
    add_section("tbl_slick_mutasi11_coa","data_mutasi11_coa","refresh_mutasi11_coa_grid()","hbtn_mutasi11_coa","grid_mutasi11_coa");
    create_mutasi11_coa_grid(); 
    create_mutasi11_coa_event();
    create_dlg_mutasi11_coa();  
    //create_dlg_mutasi11_coa_search();  
}

function create_mutasi11_coa_grid()
{    
    var columns_mutasi11_coa = [];
    var options_mutasi11_coa = [];
    
    columns_mutasi11_coa = [
        {id:"coa_no", name:"COA NO", field:"coa_no",width:60}
        ,{id:"coa_desc", name:"Keterangan", field:"coa_desc",width:220}
        ,{id:"coa_dc", name:"D/C", field:"coa_dc",width:45,cssClass:"cell_center"}
        ,{id:"coa_order", name:"Order", field:"coa_order",width:45,cssClass:"cell_center"}
        ,{id:"coa_enable", name:"Enable", field:"coa_enable",width:45,cssClass:"cell_center"}
        ,{id:"modified_by", name:"Modified by", field:"modified_by"}
        ,{id:"modified_dt", name:"Modified Date", field:"modified_dt"}
    ];
    options_mutasi11_coa = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_coa = new Slick.Grid("#tbl_slick_mutasi11_coa", data_mutasi11_coa, columns_mutasi11_coa, options_mutasi11_coa);
    grid_mutasi11_coa.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_coa_grid()
{
    state_progress(1);
    data_mutasi11_coa.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/list_coa",{},function(data) {
        var irow=0;
        for (var i=0; i<data.r_num_rows; i++) {
            if(data.r_sdata[i].coa_no!='C111')
            {
               var d = (data_mutasi11_coa[irow++] = {});
               d["coa_no"] = data.r_sdata[i].coa_no;
               d["coa_desc"] = data.r_sdata[i].coa_desc;
               d["coa_dc"] = (data.r_sdata[i].coa_dc=='C'?"Kredit":"Debet");
               d["coa_order"] = data.r_sdata[i].coa_order;          
               d["coa_enable"] = (data.r_sdata[i].coa_enable==1?"Enable":"Disable");
               d["modified_by"] = data.r_sdata[i].modified_by;          
               d["modified_dt"] = data.r_sdata[i].modified_dt_s;          
            }
        }
    },"json");
    obj_post.done(function(msg){
        grid_mutasi11_coa.invalidateAllRows();
        grid_mutasi11_coa.updateRowCount();
        grid_mutasi11_coa.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_mutasi11_coa_event()
{
    $("#hbtn_mutasi11_coa_refresh").click(function(){
        refresh_mutasi11_coa_grid();
    });
    
    $("#hbtn_mutasi11_coa_new").click(function(){         
        open_dlg_mutasi11_coa('');
    });
    $("#hbtn_mutasi11_coa_edit").click(function(){
        selected_row_mutasi11_coa  = grid_mutasi11_coa.getActiveCell();         
        if(selected_row_mutasi11_coa)
            open_dlg_mutasi11_coa(data_mutasi11_coa[selected_row_mutasi11_coa.row].coa_no);
        else
            alert("No data selected!");
    });
    
    grid_mutasi11_coa.onDblClick.subscribe(function(e) {     
        var cell = grid_mutasi11_coa.getCellFromEvent(e);
        if(lvl<=5)
            open_dlg_mutasi11_coa(data_mutasi11_coa[cell.row].coa_no);
    });
}

