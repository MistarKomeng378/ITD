function get_content_dlg_docim_search()
{             
    var obj_post = $.post(uri_dlg_docim_search,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_docim_search").html(msg);
        $("#dlgDocim_scan_sdate").datepicker();
        $("#dlgDocim_scan_sdate").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#dlgDocim_scan_edate").datepicker();
        $("#dlgDocim_scan_edate").datepicker( "option", "dateFormat", 'dd-mm-yy' );
        $("#dlgDocim_inst_sdate").datepicker();
        $("#dlgDocim_inst_sdate").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $("#dlgDocim_inst_edate").datepicker();
        $("#dlgDocim_inst_edate").datepicker( "option", "dateFormat", 'dd-mm-yy' );
        $("#dlgDocim_scan_sdate").val(saiki);
        $("#dlgDocim_scan_edate").val(saiki);
    });
}
function create_dlg_docim_search()
{
    get_content_dlg_docim_search(); 
    $("#dialogBox_docim_search").dialog({ 
            title:        'Pencarian Dokumen'
        ,    width:        400
        ,    height:        200
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cari": function(){do_refresh_dlg_docim_search();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_docim_search()
{                       
    $("#dialogBox_docim_search").dialog("open");
}
function close_dlg_docim_search()
{                          
    $("#dialogBox_docim_search").dialog("close");
}
function do_refresh_dlg_docim_search()
{
    data_docim.length=0;
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/docim/get_docim_search", 
        { c_id:$("#dlgDocim_client_code").val(),f_id:$("#dlgDocim_fund").val()
            ,b_id:$("#dlgDocim_bagian").val(),s_sdate:$("#dlgDocim_scan_sdate").val()
            ,s_edate:$("#dlgDocim_scan_edate").val(),i_sdate:$("#dlgDocim_inst_sdate").val()
            ,i_edate:$("#dlgDocim_inst_edate").val()},function(data) {   
            for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_docim[i] = {});
           d["doc_id"] = data.r_sdata[i].doc_id;
           d["tgl_scan"] = data.r_sdata[i].scan_dt_s;
           d["bagian"] = data.r_sdata[i].bagian_desc;
           d["client_id"] = data.r_sdata[i].client_id;
           d["fund_id"] = data.r_sdata[i].fund_id;
           d["fund"] = data.r_sdata[i].fund_desc;
           d["tgl_inst"] = data.r_sdata[i].instruction_dt_s;  
           d["tgl_surat"] = data.r_sdata[i].letter_dt_s;
           d["file_name"] = data.r_sdata[i].filename;
           d["md5_file_name"] = data.r_sdata[i].md5filename;
        }
    },"json");
    obj_post.done(function(msg){
        grid_docim.invalidateAllRows();
        grid_docim.updateRowCount();
        grid_docim.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
    close_dlg_docim_search();
}                                    