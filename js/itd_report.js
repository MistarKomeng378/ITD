var grid_report;
var data_report = [];

function initiate_report()
{
    add_section("content_report","data_report","refresh_report_grid()","hbtn_report","grid_report");
    create_report_grid(); 
    create_report_event();
    create_dlg_report_search();  
    create_dlg_report_listing();
}

function create_report_grid()
{    
    var columns_report = [];
    var options_report = [];
    
    columns_report = [
        {id:"tgl_scan", name:"Tanggal Scan", field:"tgl_scan"}
        ,{id:"bagian", name:"Bagian", field:"bagian",width:140}
        ,{id:"client_id", name:"Client ID", field:"client_id"}
        ,{id:"fund_id", name:"Fund ID", field:"fund_id",width:300}
        ,{id:"fund", name:"Nama Fund", field:"fund",width:300}
        ,{id:"tgl_inst", name:"Tgl Instruksi", field:"tgl_inst"}
        ,{id:"tgl_surat", name:"Tgl Surat", field:"tgl_surat"}
    ];
    options_report = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_report = new Slick.Grid("#tbl_slick_report", data_report, columns_report, options_report);
    grid_report.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_report_grid()
{
    /*data_report.length=0;
    grid_report.invalidateAllRows();
    grid_report.updateRowCount();
    grid_report.render();
    */
}

function create_report_event()
{
    $("#hbtn_report_search").click(function(){ 
        open_dlg_report_search();
    });
        
    grid_report.onDblClick.subscribe(function(e) {     
        var cell = grid_report.getCellFromEvent(e);
        window.open(uri+"index.php/docim/open_doc/"+data_report[cell.row].doc_id+data_report[cell.row].md5_file_name+'.pdf',"_blank");
        //    open_dlg_report(data_report[cell.row].client_id);
    });
    
    $("#hbtn_report_listing").click(function(){                  
        open_dlg_report_listing();
    });
}
function delete_report(c_id)
{
    state_progress(1);
    data_report.length=0;
    var obj_post = $.post(uri+"index.php/itd_del/d_report",{client_id:c_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        if(msg.r_success)
            alert('Delete success!');
        else
            alert('Delete failed!');
        state_progress(0);
        refresh_report_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function approve_report(c_id)
{
    state_progress(1);
    var obj_post = $.post(uri+"index.php/itd_save/submit_approve_report",{client_id:c_id},function(data) {
        
    },'json');
    obj_post.done(function(msg){
        if(msg.r_data[0].can_approve==1)
            alert('Success approve record!');
        else
            alert('You dont have right to approve or Record is unapproveable!');
        state_progress(0);
        refresh_report_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}