var grid_docim;
var data_docim = [];

function initiate_docim()
{
    add_section("tbl_slick_docim","data_docim","refresh_docim_grid()","hbtn_docim","grid_docim");
    create_docim_grid(); 
    create_docim_event();
    create_dlg_docim_search();  
    create_dlg_docim_listing();
}

function create_docim_grid()
{    
    var columns_docim = [];
    var options_docim = [];
    
    columns_docim = [
        {id:"tgl_scan", name:"Tanggal Scan", field:"tgl_scan"}
        ,{id:"bagian", name:"Bagian", field:"bagian",width:140}
        ,{id:"client_id", name:"Client ID", field:"client_id"}
        ,{id:"fund_id", name:"Fund ID", field:"fund_id",width:300}
        ,{id:"fund", name:"Nama Fund", field:"fund",width:300}
        ,{id:"tgl_inst", name:"Tgl Instruksi", field:"tgl_inst"}
        ,{id:"tgl_surat", name:"Tgl Surat", field:"tgl_surat"}
    ];
    options_docim = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_docim = new Slick.Grid("#tbl_slick_docim", data_docim, columns_docim, options_docim);
    grid_docim.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_docim_grid()
{
    /*data_docim.length=0;
    grid_docim.invalidateAllRows();
    grid_docim.updateRowCount();
    grid_docim.render();
    */
}

function create_docim_event()
{
    $("#hbtn_docim_search").click(function(){ 
        open_dlg_docim_search();
    });
        
    grid_docim.onDblClick.subscribe(function(e) {     
        var cell = grid_docim.getCellFromEvent(e);
        window.open(uri+"index.php/docim/open_doc/"+data_docim[cell.row].doc_id+data_docim[cell.row].md5_file_name+'.pdf',"_blank");
        //    open_dlg_docim(data_docim[cell.row].client_id);
    });
    
    $("#hbtn_docim_listing").click(function(){                  
        open_dlg_docim_listing();
    });
}
function delete_docim(c_id)
{
    state_progress(1);
    data_docim.length=0;
    var obj_post = $.post(uri+"index.php/itd_del/d_docim",{client_id:c_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        if(msg.r_success)
            alert('Delete success!');
        else
            alert('Delete failed!');
        state_progress(0);
        refresh_docim_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function approve_docim(c_id)
{
    state_progress(1);
    var obj_post = $.post(uri+"index.php/itd_save/submit_approve_docim",{client_id:c_id},function(data) {
        
    },'json');
    obj_post.done(function(msg){
        if(msg.r_data[0].can_approve==1)
            alert('Success approve record!');
        else
            alert('You dont have right to approve or Record is unapproveable!');
        state_progress(0);
        refresh_docim_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}