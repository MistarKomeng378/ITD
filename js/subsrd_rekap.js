var subsrd_rekap_id=0;
var grid_subsrd_rekap;
var data_subsrd_rekap = [];

var do_subsrd_rekap=0;
                                
function initiate_subsrd_rekap(){             
    add_section("tbl_slick_subsrd_rekap","data_subsrd_rekap","refresh_subsrd_rekap()","hbtn_subsrd_rekap","grid_subsrd_rekap");
    create_subsrd_rekap_grid();               
    create_subsrd_rekap_event();

}    
function create_subsrd_rekap_grid()
{
    var columns_subsrd_rekap = [];
    var options_subsrd_rekap = [] ; 
    columns_subsrd_rekap = [
        {id:"subsrd_date", name:"Date", field:"subsrd_date",width:75}
        ,{id:"subsrd_status", name:"Status", field:"subsrd_status",width:60}
        ,{id:"mi_name", name:"MI", field:"mi_name",width:130}
        ,{id:"client_code", name:"Client", field:"client_code",width:65}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:200}
        ,{id:"subsrd_nominal_a", name:"Jumlah", field:"subsrd_nominal_a",width:130,cssClass:"cell_right"}
        ,{id:"bank_src", name:"Source Bank", field:"bank_src",width:80}
        ,{id:"acc_src", name:"Source Account", field:"acc_src",width:120}
        ,{id:"bank_dst", name:"Dest Bank", field:"bank_dst",width:80}
        ,{id:"acc_dst", name:"Dest Account", field:"acc_dst",width:120}
        
        //,{id:"subsrd_date", name:"Date", field:"subsrd_date",width:90}
        //,{id:"subsrd_status", name:"Status", field:"subsrd_status",width:60}
        //,{id:"open_by", name:"Open by", field:"open_by",width:110}
        //,{id:"open_date", name:"Open dt", field:"open_date",width:90}
        //,{id:"close_by", name:"Close by", field:"close_by",width:110}
        //,{id:"close_date", name:"Close dt", field:"close_date",width:90}
    ];
    options_subsrd_rekap = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/                                         
    grid_subsrd_rekap = new Slick.Grid("#tbl_slick_subsrd_rekap", data_subsrd_rekap, columns_subsrd_rekap, options_subsrd_rekap);
    grid_subsrd_rekap.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}
function refresh_subsrd_rekap()
{ 
    state_progress(1);     
    var obj_post = $.post(uri_subsrd_rekap+"list_data", {s_dt:$("#hbtn_subsrd_rekap_dt").val(),s_dt2:$("#hbtn_subsrd_rekap_dt2").val()},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrd_rekap[i] = {});
            d["mi_name"] = msg.r_sdata[i].mi_name;
            d["client_name"] = msg.r_sdata[i].client_name;
            d["client_code"] = msg.r_sdata[i].client_code;
            d["subsrd_status"] = msg.r_sdata[i].subsrd_status==1?'Closed':'Opened';
            d["bank_src"] = msg.r_sdata[i].bank_src;
            d["acc_src"] = msg.r_sdata[i].acc_no_src ;
            d["bank_dst"] = msg.r_sdata[i].bank_dst;
            d["acc_dst"] = msg.r_sdata[i].acc_no_dst;
            d["subsrd_nominal_a"] = strtomoney(msg.r_sdata[i].subsrd_nominal);
            d["subsrd_date"] = msg.r_sdata[i].subsrd_date_s;
            //d["open_by"] = msg.r_sdata[i].open_by;
            //d["open_date"] = msg.r_sdata[i].open_date_s;
            //d["close_by"] = msg.r_sdata[i].close_by;
            //d["close_date"] = msg.r_sdata[i].close_date_s;
        }
        
        grid_subsrd_rekap.invalidateAllRows();
        grid_subsrd_rekap.updateRowCount();
        grid_subsrd_rekap.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrd_rekap.invalidateAllRows();
        grid_subsrd_rekap.updateRowCount();
        grid_subsrd_rekap.render();
        state_progress(0);}
    );                  
}
function export_subsrd_rekap()
{
    $("#hbtn_subsrd_rekap_dt1_h").val($("#hbtn_subsrd_rekap_dt").val());
    $("#hbtn_subsrd_rekap_dt2_h").val($("#hbtn_subsrd_rekap_dt2").val());
    setTimeout(function() {    
        $("#frm_subsrd_rekap").submit();
    },2); 
}

function create_subsrd_rekap_event()
{
    $("#hbtn_subsrd_rekap_dt").datepicker();
    $("#hbtn_subsrd_rekap_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#hbtn_subsrd_rekap_dt").val(saiki);
    
    $("#hbtn_subsrd_rekap_dt2").datepicker();
    $("#hbtn_subsrd_rekap_dt2").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#hbtn_subsrd_rekap_dt2").val(saiki);
                                                               
    $("#hbtn_subsrd_rekap_reload").click(function(){ 
        refresh_subsrd_rekap();
    });
    $("#hbtn_subsrd_rekap_export").click(function(){ 
        export_subsrd_rekap();
    });
    /*
    $("#hbtn_subsrd_rekap_add").click(function(){   
        dPicker_par1=$("#dlgSubsrdAccClient_code").val();
        open_dlg_subsrd_rekap(0);
    });      

    grid_subsrd_rekap.onDblClick.subscribe(function(e) { 
        var selected_row_subsrd  = grid_subsrd_rekap.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_rekap_id=data_subsrd_rekap[selected_row_subsrd.row].acc_id;
            dPicker_par1=data_subsrd_rekap[selected_row_subsrd.row].client_code;
            open_dlg_subsrd_rekap(1);
        } 
    });
    $("#hbtn_subsrd_rekap_edit").click(function(){ 
        var selected_row_subsrd  = grid_subsrd_rekap.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_rekap_id=data_subsrd_rekap[selected_row_subsrd.row].acc_id;
            dPicker_par1=data_subsrd_rekap[selected_row_subsrd.row].client_code;
            open_dlg_subsrd_rekap(1);
        } 
    });
    $("#hbtn_subsrd_rekap_reload").click(function(){   //  alert('a');
            refresh_subsrd_rekap();
    });
    */
}
          