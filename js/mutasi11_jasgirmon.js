var grid_mutasi11_jasgirmon;
var data_mutasi11_jasgirmon = [];

function initiate_mutasi11_jasgirmon()
{
    add_section("tbl_slick_mutasi11_jasgirmon","data_mutasi11_jasgirmon","refresh_mutasi11_jasgirmon_grid()","hbtn_mutasi11_jasgirmon","grid_mutasi11_jasgirmon");
    create_mutasi11_jasgirmon_grid(); 
    create_mutasi11_jasgirmon_event();
    $("#hbtn_mutasi11_jasgirmon_dt1").val(saiki);
    $("#hbtn_mutasi11_jasgirmon_dt2").val(saiki);
}

function create_mutasi11_jasgirmon_grid()
{    
    var columns_mutasi11_jasgirmon = [];
    var options_mutasi11_jasgirmon = [];
    
    columns_mutasi11_jasgirmon = [
        {id:"status", name:"Status", field:"status",width:40,cssClass:"cell_center"}
        ,{id:"client_code", name:"Client Code", field:"client_code",width:70,cssClass:"cell_center"}
        ,{id:"client_name", name:"Client Name", field:"client_name",width:200}
        ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
        ,{id:"giro_val_date", name:"Bal dt", field:"giro_val_date",cssClass:"cell_center",width:65}
        ,{id:"giro_asof_date", name:"Giro dt", field:"giro_asof_date",cssClass:"cell_center",width:65}
        ,{id:"giro_tenor", name:"Tenor", field:"giro_tenor",cssClass:"cell_right",width:40}
        ,{id:"giro_year", name:"DiY", field:"giro_year",cssClass:"cell_right",width:35}
        ,{id:"giro_rate", name:"Rate", field:"giro_rate",cssClass:"cell_right",width:35}
        ,{id:"giro_nominal", name:"Nominal", field:"giro_nominal",cssClass:"cell_right"}
        ,{id:"giro_interest", name:"Interest", field:"giro_interest",cssClass:"cell_right"}
        ,{id:"giro_interest_tax", name:"Interest Tax", field:"giro_interest_tax",cssClass:"cell_right"}
        ,{id:"giro_interest_net", name:"Net", field:"giro_interest_net",cssClass:"cell_right"}
        ,{id:"giro_created_by", name:"Created By", field:"giro_created_by"}
        ,{id:"giro_created_dt", name:"Created Date", field:"giro_created_dt"}
    ];
    options_mutasi11_jasgirmon = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_mutasi11_jasgirmon = new Slick.Grid("#tbl_slick_mutasi11_jasgirmon", data_mutasi11_jasgirmon, columns_mutasi11_jasgirmon, options_mutasi11_jasgirmon);
    grid_mutasi11_jasgirmon.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_mutasi11_jasgirmon_grid()
{
    state_progress(1);
    data_mutasi11_jasgirmon.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/list_jasgirmon",{
        f:$("#hbtn_mutasi11_jasgirmon_filter").val(),
        dt1:$("#hbtn_mutasi11_jasgirmon_dt1").val(),dt2:$("#hbtn_mutasi11_jasgirmon_dt2").val()
    },function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mutasi11_jasgirmon[i] = {});
           d["giro_id"] = data.r_sdata[i].giro_id;
           d["client_code"] = data.r_sdata[i].client_code;
           d["client_name"] = data.r_sdata[i].client_name;
           d["acc_no"] = data.r_sdata[i].acc_no;
           d["giro_val_date"] = data.r_sdata[i].giro_val_date_s;
           d["giro_asof_date"] = data.r_sdata[i].giro_asof_date_s;
           d["giro_tenor"] = data.r_sdata[i].giro_tenor;
           d["giro_year"] = data.r_sdata[i].giro_year;
           d["giro_rate"] = strtomoney(data.r_sdata[i].giro_rate);
           d["giro_nominal"] = strtomoney(data.r_sdata[i].giro_nominal);
           d["giro_interest"] = strtomoney(data.r_sdata[i].giro_interest);
           d["giro_interest_tax"] = strtomoney(data.r_sdata[i].giro_interest_tax);
           d["giro_interest_net"] = strtomoney(data.r_sdata[i].giro_interest_net);
           d["giro_created_by"] = data.r_sdata[i].created_by;
           d["giro_created_dt"] = data.r_sdata[i].created_dt_s;
           d["balance_status"] = data.r_sdata[i].balance_status;
           d["status"] = data.r_sdata[i].balance_status=='2'?'Closed':'Open';
        }
    },"json");
    obj_post.done(function(msg){
        grid_mutasi11_jasgirmon.invalidateAllRows();
        grid_mutasi11_jasgirmon.updateRowCount();
        grid_mutasi11_jasgirmon.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}

function create_mutasi11_jasgirmon_event()
{
    $("#hbtn_mutasi11_jasgirmon_reload").click(function(){          
        refresh_mutasi11_jasgirmon_grid();
    });
    
    $("#hbtn_mutasi11_jasgirmon_save").click(function(){        
        save_mutasi11_jasgirmon();
        refresh_mutasi11_jasgirmon_grid();
    });
         
    $("#hbtn_mutasi11_jasgirmon_del").click(function(){
        selected_row_mutasi11_jasgirmon  = grid_mutasi11_jasgirmon.getActiveCell();         
        if(selected_row_mutasi11_jasgirmon)
        {   
            if(data_mutasi11_jasgirmon[selected_row_mutasi11_jasgirmon.row].balance_status!=2)
            {
                if(confirm("Yakin menghapus jasa giro?"))
                {
                    del_mutasi11_jasgirmon(data_mutasi11_jasgirmon[selected_row_mutasi11_jasgirmon.row].giro_id);
                }
            }
            else
                alert("Status balance di tanggal ini sudah closed!");
        }
        else
            alert("No data selected!");
    });
    
    
}
function del_mutasi11_jasgirmon(g_id)
{
    state_progress(1);
    data_mutasi11_jasgirmon.length=0;
    var obj_post = $.post(uri+"index.php/mutasi/del_jasgirmon",{giro_id:g_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        if(msg.r_success)
            alert('Delete success!');
        else
            alert('Delete failed!');
        state_progress(0);
        refresh_mutasi11_jasgirmon_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function save_mutasi11_jasgirmon()
{
    var a='';
    a="<input type='text' name='f' value='"+$("#hbtn_mutasi11_jasgirmon_filter").val()+"' />";
    a=a+"<input type='text' name='dt1' value='"+$("#hbtn_mutasi11_jasgirmon_dt1").val()+"' />";
    a=a+"<input type='text' name='dt2' value='"+$("#hbtn_mutasi11_jasgirmon_dt2").val()+"' />";
    $("#frm_hidden").html(a).attr('action', uri+"index.php/mutasi/save_list_jasgirmon").submit();
}