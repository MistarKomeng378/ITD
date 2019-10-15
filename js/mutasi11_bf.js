var grid_mutasi11_bf;
var data_mutasi11_bf = [];
var selected_row_mutasi11_bf;



function initiate_mutasi11_bf()
{                                                      
    add_section("tbl_slick_mutasi11_bf","data_mutasi11_bf","refresh_mutasi11_bf_grid()","hbtn_mutasi11_bf","grid_mutasi11_bf");
    create_mutasi11_bf_grid(); 
    create_mutasi11_bf_event();   
    
    $("#hbtn_mutasi11_bf_dt1").datepicker();
    $("#hbtn_mutasi11_bf_dt1").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#hbtn_mutasi11_bf_dt2").datepicker();
    $("#hbtn_mutasi11_bf_dt2").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    
    create_dlg_mutasi11_bf();                                                              
    
    
    //get_content_coa_mutasi11_bf();
}
function get_content_coa_mutasi11_bf()
{
    //$("#hbtn_mutasi11_bf_coa").html('');      
    /*var obj_post1 = $.post(uri+"/index.php/mutasi/list_coa",{},function(data1) {   
        },"json");
    obj_post1.done(function(msg1) {    
        if(msg1.r_num_rows>0)
        {
            var sta='<option value="ALL">***ALL***</option>\n';
            for (var i=0; i<msg1.r_num_rows; i++) {
                sta=sta+'<option value="'+msg1.r_sdata[i].coa_no+'">'+msg1.r_sdata[i].coa_desc+'</option>\n';
            }
            $("#hbtn_mutasi11_bf_coa").html(sta);
        }
    });*/
    
}
function create_mutasi11_bf_grid()
{    
    var columns_mutasi11_bf = [];
    var options_mutasi11_bf = [];
    
    columns_mutasi11_bf = [
        {id:"fb_settle_date", name:"Settle Date", field:"fb_settle_date",width:80}  
        ,{id:"fb_cat", name:"Kategori", field:"fb_cat",width:80}
        ,{id:"fb_desc", name:"Keterangan", field:"fb_desc",width:200}
        ,{id:"fb_nominal", name:"Broker Fee", field:"fb_nominal",cssClass:"cell_right",width:120}
        ,{id:"fb_broker", name:"Broker", field:"fb_broker",width:120}
        ,{id:"fb_doc", name:"Ada Dokumen", field:"fb_doc",width:80,cssClass:"cell_center"}
        ,{id:"fb_doc_dt", name:"Tgl Diterima", field:"fb_doc_dt",width:80,cssClass:"cell_center"}
        ,{id:"fb_ccode", name:"Client Code", field:"fb_ccode",width:175}
        ,{id:"fb_cname", name:"Client Name", field:"fb_cname",width:175}
        ,{id:"fb_accno", name:"No Rek", field:"fb_accno",width:175}
        ,{id:"fb_trxnominal", name:"Nominal Trx", field:"fb_trxnominal",cssClass:"cell_right",width:120}
        ,{id:"fb_date", name:"Trx Date", field:"fb_date",width:80}  
    ];
    options_mutasi11_bf = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_bf = new Slick.Grid("#tbl_slick_mutasi11_bf", data_mutasi11_bf, columns_mutasi11_bf, options_mutasi11_bf);
    grid_mutasi11_bf.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_bf_grid()
{
    state_progress(1);
    data_mutasi11_bf.length=0;
    var obj_post = $.post(uri+"index.php/mutasi_bf/list_bf",{
        coa:$("#hbtn_mutasi11_bf_coa").val(),tipe:$("#hbtn_mutasi11_bf_doc").val(),
        dt1:$("#hbtn_mutasi11_bf_dt1").val(),dt2:$("#hbtn_mutasi11_bf_dt2").val()
    },function(data) {
//        /alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mutasi11_bf[i] = {});
           d["fb_id"] = data.r_sdata[i].fb_id;
           d["fb_settle_date"] = data.r_sdata[i].fb_settle_dt_s;
           d["fb_cat"] = data.r_sdata[i].coa_desc;
           d["fb_desc"] = data.r_sdata[i].fb_desc;
           d["fb_nominal"] = strtomoney(data.r_sdata[i].fb_nominal);
           d["fb_broker"] = data.r_sdata[i].fb_broker;
           d["fb_doc"] = data.r_sdata[i].fb_doc_accepted==1?"Y":"T";
           d["fb_doc_dt"] = data.r_sdata[i].fb_doc_accepted==1?data.r_sdata[i].fb_doc_accepted_dt_s:'';
           d["fb_ccode"] = data.r_sdata[i].client_code;
           d["fb_cname"] = data.r_sdata[i].client_name;
           d["fb_accno"] = data.r_sdata[i].acc_no;
           d["fb_trxnominal"] = strtomoney(data.r_sdata[i].trx_nominal);
           d["fb_date"] = data.r_sdata[i].fb_dt_s;
        }
    },'json');
    obj_post.done(function(msg){
        grid_mutasi11_bf.invalidateAllRows();
        grid_mutasi11_bf.updateRowCount();
        grid_mutasi11_bf.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_mutasi11_bf_event()
{
    $("#hbtn_mutasi11_bf_reload").click(function(){          
        refresh_mutasi11_bf_grid();
    });
    
    $("#hbtn_mutasi11_bf_save").click(function(){        
        save_mutasi11_bf();
        refresh_mutasi11_bf_grid();
    });
    
    $("#hbtn_mutasi11_bf_edit").click(function(){    
        selected_row_mutasi11_bf  = grid_mutasi11_bf.getActiveCell();         
        if(selected_row_mutasi11_bf)
        {                            
            open_dlg_mutasi11_bf_edit(data_mutasi11_bf[selected_row_mutasi11_bf.row].fb_id);
        }
        else
            alert("No data selected!");
    });           
    grid_mutasi11_bf.onDblClick.subscribe(function(e) {     
        var cell = grid_mutasi11_bf.getCellFromEvent(e);
        if(lvl<=5)
            open_dlg_mutasi11_bf_edit(data_mutasi11_bf[cell.row].fb_id);
    });
    
               
}
function save_mutasi11_bf()
{
    var a='';
    a=a+"<input type='text' name='dt1' value='"+$("#hbtn_mutasi11_bf_dt1").val()+"' />";
    a=a+"<input type='text' name='dt2' value='"+$("#hbtn_mutasi11_bf_dt2").val()+"' />";
    a=a+"<input type='text' name='coa' value='"+$("#hbtn_mutasi11_bf_coa").val()+"' />";
    a=a+"<input type='text' name='ccode' value='"+$("#hbtn_mutasi11_bf_client").val()+"' />";
    $("#frm_hidden").html(a).attr('action', uri+"index.php/mutasi/save_list_mutasi_taxbro").submit();
}