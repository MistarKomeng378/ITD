var grid_mutasi11_taxbro;
var data_mutasi11_taxbro = [];

function initiate_mutasi11_taxbro()
{                                                      
    add_section("tbl_slick_mutasi11_taxbro","data_mutasi11_taxbro","refresh_mutasi11_taxbro_grid()","hbtn_mutasi11_taxbro","grid_mutasi11_taxbro");
    create_mutasi11_taxbro_grid(); 
    create_mutasi11_taxbro_event();   
    $("#hbtn_mutasi11_taxbro_dt1").val(saiki);
    $("#hbtn_mutasi11_taxbro_dt2").val(saiki);        
    //get_content_coa_mutasi11_taxbro();
}
function get_content_coa_mutasi11_taxbro()
{
    //$("#hbtn_mutasi11_taxbro_coa").html('');      
    /*var obj_post1 = $.post(uri+"/index.php/mutasi/list_coa",{},function(data1) {   
        },"json");
    obj_post1.done(function(msg1) {    
        if(msg1.r_num_rows>0)
        {
            var sta='<option value="ALL">***ALL***</option>\n';
            for (var i=0; i<msg1.r_num_rows; i++) {
                sta=sta+'<option value="'+msg1.r_sdata[i].coa_no+'">'+msg1.r_sdata[i].coa_desc+'</option>\n';
            }
            $("#hbtn_mutasi11_taxbro_coa").html(sta);
        }
    });*/
}
function create_mutasi11_taxbro_grid()
{    
    var columns_mutasi11_taxbro = [];
    var options_mutasi11_taxbro = [];
    
    columns_mutasi11_taxbro = [
        {id:"fb_date", name:"Date", field:"fb_date",width:80}  
        ,{id:"fb_cat", name:"Kategori", field:"fb_cat",width:80}
        ,{id:"fb_desc", name:"Keterangan", field:"fb_desc",width:200}
        ,{id:"fb_nominal", name:"Nominal", field:"fb_nominal",cssClass:"cell_right",width:120}
        ,{id:"fb_broker", name:"Broker", field:"fb_broker",width:120}
        ,{id:"fb_doc", name:"Dokumen", field:"fb_doc",width:60,cssClass:"cell_center"}
        ,{id:"fb_doc_dt", name:"Tgl Diterima", field:"fb_doc_dt",width:80,cssClass:"cell_center"}
        ,{id:"fb_ccode", name:"Client Code", field:"fb_ccode",width:175}
        ,{id:"fb_cname", name:"Client Name", field:"fb_cname",width:175}
        ,{id:"fb_accno", name:"No Rek", field:"fb_accno",width:175}
    ];
    options_mutasi11_taxbro = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_taxbro = new Slick.Grid("#tbl_slick_mutasi11_taxbro", data_mutasi11_taxbro, columns_mutasi11_taxbro, options_mutasi11_taxbro);
    grid_mutasi11_taxbro.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_taxbro_grid()
{
    state_progress(1);
    data_mutasi11_taxbro.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/list_mutasi_taxbro",{
        coa:$("#hbtn_mutasi11_taxbro_coa").val(),cdoc:$("#hbtn_mutasi11_taxbro_doc").val(),
        dt1:$("#hbtn_mutasi11_taxbro_dt1").val(),dt2:$("#hbtn_mutasi11_taxbro_dt2").val()
    },function(data) {
        //alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mutasi11_taxbro[i] = {});
           d["fb_id"] = data.r_sdata[i].balance_id;
           d["fb_date"] = data.r_sdata[i].fb_dt_s;
           d["fb_cat"] = data.r_sdata[i].fb_cat=='C007'?"JUAL":"BELI";
           d["fb_desc"] = data.r_sdata[i].fb_desc;
           d["fb_nominal"] = strtomoney(data.r_sdata[i].fb_nominal);
           d["fb_broker"] = data.r_sdata[i].fb_broker;
           d["fb_doc"] = data.r_sdata[i].fb_doc_accepted==1?"ADA":"BELUM ADA";
           d["fb_doc_dt"] = data.r_sdata[i].fb_doc_accepted==1?data.r_sdata[i].fb_doc_accepted_dt_s:'';
           d["fb_ccode"] = data.r_sdata[i].client_code;
           d["fb_cname"] = data.r_sdata[i].client_name;
           d["fb_accno"] = data.r_sdata[i].acc_no;
        }
    },"json");
    obj_post.done(function(msg){
        grid_mutasi11_taxbro.invalidateAllRows();
        grid_mutasi11_taxbro.updateRowCount();
        grid_mutasi11_taxbro.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_mutasi11_taxbro_event()
{
    $("#hbtn_mutasi11_taxbro_reload").click(function(){          
        refresh_mutasi11_taxbro_grid();
    });
    
    $("#hbtn_mutasi11_taxbro_save").click(function(){        
        save_mutasi11_taxbro();
        refresh_mutasi11_taxbro_grid();
    });
               
}
function save_mutasi11_taxbro()
{
    var a='';
    a=a+"<input type='text' name='dt1' value='"+$("#hbtn_mutasi11_taxbro_dt1").val()+"' />";
    a=a+"<input type='text' name='dt2' value='"+$("#hbtn_mutasi11_taxbro_dt2").val()+"' />";
    a=a+"<input type='text' name='coa' value='"+$("#hbtn_mutasi11_taxbro_coa").val()+"' />";
    a=a+"<input type='text' name='ccode' value='"+$("#hbtn_mutasi11_taxbro_client").val()+"' />";
    $("#frm_hidden").html(a).attr('action', uri+"index.php/mutasi/save_list_mutasi_taxbro").submit();
}