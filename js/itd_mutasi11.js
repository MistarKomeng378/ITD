var grid_mutasi11;
var data_mutasi11 = [];

function initiate_mutasi11()
{
    add_section("content_mutasi11","data_mutasi11","refresh_mutasi11()","hbtn_mutasi11","grid_mutasi11");
    
    get_content_mutasi11();
    
alert('a');
    //create_dlg_mutasi11_search();  
    //create_dlg_mutasi11_listing();
}

function get_content_mutasi11()
{             
    var obj_post = $.post(uri_mutasi11,{},function(data) {
        $("#content_mutasi11").html(data);
    });
    obj_post.done(function(msg) { 
        create_mutasi11_grid(); 
        create_dlg_dpicker_mutasi11();
        reload_coa_mutasi11();
        create_mutasi11_event();
        $("#i_mutasi11_client_dt").val(saiki);
    });
}
function create_mutasi11_grid()
{
    var columns_mutasi11 = [];
    var options_mutasi11 = [] ; 
    columns_mutasi11 = [         
        {id:"coa_desc", name:"Kategori", field:"coa_desc",width:280}
        ,{id:"trx_desc", name:"Description", field:"trx_desc",width:240}
        ,{id:"trx_dc", name:"D/C", field:"trx_dc",width:30,cssClass:"cell_center"}
        ,{id:"trx_nominal", name:"Nominal", field:"trx_nominal",width:160,cssClass:"cell_right"}
        ,{id:"created_by", name:"Created By", field:"created_by",width:80}
        ,{id:"created_dt", name:"Created", field:"created_dt",width:110}
        ,{id:"modified_by", name:"Modified By", field:"modified_by",width:100}
        ,{id:"modified_dt", name:"Modified", field:"modified_dt",width:110}
    ];
    options_mutasi11 = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_mutasi11 = new Slick.Grid("#tbl_slick_mutasi11", data_mutasi11, columns_mutasi11, options_mutasi11);
    grid_mutasi11.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function create_dlg_dpicker_mutasi11()
{
    var dpick_opt_mutasi11 ={
        cols : [         
                   {id:"client_code", name:"Code", field:"client_code",width:50}
                   ,{id:"acc_no", name:"Account No", field:"acc_no",width:140}
                   ,{id:"client_name", name:"Account Name", field:"client_name",width:180}
                   ,{id:"client_cif", name:"CIF", field:"client_cif",width:80}
                   ,{id:"client_cbest", name:"CBEST", field:"client_cbest",width:80}
            ],
        url: uri+"index.php/mutasi/list_client_by_code",
        setval: function(obj_val){                      
            $("#i_mutasi11_client_code").val(obj_val.client_code);
            $("#i_mutasi11_rek").val(obj_val.acc_no);
            $("#i_mutasi11_client_name").val(obj_val.acc_name);
            var c_dt=$("#i_mutasi11_client_dt").val();
            clear_balance_mutasi11();
            get_last_date_mutasi11(obj_val.client_code,obj_val.acc_no);
            list_trx_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
            get_balance_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
        }
    }; 
    dPicker_attach($("#i_mutasi11_client_code"),dpick_opt_mutasi11);        
}
function reload_coa_mutasi11()
{
    state_progress(1);    
    var obj_post = $.post(uri+"/index.php/mutasi/list_coa", {},function(data) {},"json"); 
    obj_post.done(function(msg) { 
        var htm='';
        for (var i=0; i<msg.r_num_rows; i++) {
            htm = htm + "<option value='"+msg.r_sdata[i].coa_no+"'>"+msg.r_sdata[i].coa_desc+"</option>"
        }
        $("#i_mutasi11_coa").html(htm);
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}

function get_last_date_mutasi11(pc_code,pc_accno)
{
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/mutasi/get_last_balance_date", {c_code:pc_code,c_accno:pc_accno},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
            $("#i_mutasi11_client_last_date").val(msg.r_sdata[0].last_date_s)
        else
            $("#i_mutasi11_client_last_date").val('');
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}

function list_trx_mutasi11(pc_code,pc_accno,pc_dt)
{
    state_progress(1);
    data_mutasi11.length=0;  
    var obj_post = $.post(uri+"/index.php/mutasi/list_trx", {c_code:pc_code,c_accno:pc_accno,c_dt:pc_dt},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_mutasi11[i] = {});
            d["trx_id"] = msg.r_sdata[i].trx_id;
            d["coa_desc"] = msg.r_sdata[i].coa_no+' - '+msg.r_sdata[i].coa_desc;
            d["trx_desc"] = msg.r_sdata[i].trx_desc;
            d["trx_dc"] = msg.r_sdata[i].trx_dc;
            d["trx_nominal"] = strtomoney(msg.r_sdata[i].trx_nominal);
            d["created_by"] = msg.r_sdata[i].created_by;
            d["created_dt"] = msg.r_sdata[i].created_dt_s;
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
            d["trx_status"] = msg.r_sdata[i].trx_status;
        }
        grid_mutasi11.invalidateAllRows();
        grid_mutasi11.updateRowCount();
        grid_mutasi11.render();
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_mutasi11.invalidateAllRows();
        grid_mutasi11.updateRowCount();
        grid_mutasi11.render();
        state_progress(0);}
    );
}
function get_balance_mutasi11(pc_code,pc_accno,pc_dt)
{
    state_progress(1);                
    var obj_post = $.post(uri+"/index.php/mutasi/get_balance", {c_code:pc_code,c_accno:pc_accno,c_dt:pc_dt},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            
            if(0+msg.r_sdata[i].p==1)
            {
                $("#i_mutasi11_status1").val(msg.r_sdata[i].balance_status==1?'Open':msg.r_sdata[i].balance_status==2?'Closed':'');
                $("#i_mutasi11_obal1").val(strtomoney(msg.r_sdata[i].balance_open));
                $("#i_mutasi11_tbal1").val(strtomoney(msg.r_sdata[i].balance_trx_final));
                $("#i_mutasi11_cbal1").val(strtomoney(msg.r_sdata[i].balance_close_final));
                $("#i_mutasi11_gbal1").val(strtomoney(msg.r_sdata[i].balance_gs));
                $("#i_mutasi11_sel1").val(strtomoney(msg.r_sdata[i].balance_open+msg.r_sdata[i].balance_trx));;
                $("#i_mutasi11_remark1").val(msg.r_sdata[i].balance_remark);
                $("#s_mutasi11_last_dt").html('Last Date ' +msg.r_sdata[i].balance_date_s);
            }
            if(0+msg.r_sdata[i].p==2)
            {
                $("#i_mutasi11_status2").val(msg.r_sdata[i].balance_status==1?'Open':msg.r_sdata[i].balance_status==2?'Closed':'');
                $("#i_mutasi11_obal2").val(strtomoney(msg.r_sdata[i].balance_open));
                $("#i_mutasi11_tbal2").val(strtomoney(msg.r_sdata[i].balance_trx_final));
                $("#i_mutasi11_cbal2").val(strtomoney(msg.r_sdata[i].balance_close_final));
                $("#i_mutasi11_gbal2").val(strtomoney(msg.r_sdata[i].balance_gs));
                $("#i_mutasi11_sel2").val(strtomoney(msg.r_sdata[i].balance_close+msg.r_sdata[i].balance_gs));;
                $("#i_mutasi11_remark2").val(msg.r_sdata[i].balance_remark);   
                $("#s_mutasi11_current_dt").html('Current Date ' +msg.r_sdata[i].balance_date_s);
                //alert(msg.r_sdata[i].balance_status);
                if(msg.r_sdata[i].balance_status==2)
                {
                    $("#i_mutasi11_gbal2").attr("readonly",true);
                    $("#i_mutasi11_remark2").attr("readonly",true);
                }
                else
                {
                    $("#i_mutasi11_gbal2").attr("readonly",false);
                    $("#i_mutasi11_remark2").attr("readonly",false);
                }
            }
        }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}

function add_trx_mutasi11()
{
    var c_ccode = $("#i_mutasi11_client_code").val();
    var c_accno = $("#i_mutasi11_rek").val();
    var c_cdt = $("#i_mutasi11_client_dt").val();
               
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/mutasi/add_trx", {
        c_code:c_ccode,c_no:c_accno,c_dt:c_cdt,c_catcode:$("#i_mutasi11_coa").val(),
        c_catdesc:$("#i_mutasi11_coa option:selected").text(),c_desc:$("#i_mutasi11_desc").val(),
        c_dc:$("#i_mutasi11_dc").val(),c_nominal:$("#i_mutasi11_nominal").val()
    },function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        state_progress(0);
        list_trx_mutasi11(c_ccode,c_accno,c_cdt);
        get_balance_mutasi11(c_ccode,c_accno,c_cdt);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}

function refresh_mutasi11()
{
    
    //data_mutasi11.length=0;
    //grid_mutasi11.invalidateAllRows();
    //grid_mutasi11.updateRowCount();
    //grid_mutasi11.render();
    reload_coa_mutasi11(); 
}

function create_mutasi11_event()
{
    $("#i_mutasi11_nominal").keyup(function(){
        $("#i_mutasi11_nominal_a").val(strtomoney($("#i_mutasi11_nominal").val()))
    });
    $("#i_mutasi11_client_dt").datepicker();
    $("#i_mutasi11_client_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
   
    $("#b_mutasi11_add").click(function(){
        if($("#i_mutasi11_status2").val()=='Closed')
            alert('Current date already closed!');
        else if($("#i_mutasi11_status2").val()!='Open')
            alert('Current date status must be open!');
        else if(confirm("Tambah mutasi?"))
            add_trx_mutasi11();
    });
    $("#i_mutasi11_client_dt").change(function(){
        clear_balance_mutasi11();
        var c_code = $("#i_mutasi11_client_code").val();
        var c_acc = $("#i_mutasi11_rek").val();
        var c_dt = this.value;                 
        list_trx_mutasi11(c_code,c_acc,c_dt);
        get_balance_mutasi11(c_code,c_acc,c_dt);
    });
    /*$("#i_mutasi11_client_code").change(function(){
        clear_balance_mutasi11();
        var c_code = $("#i_mutasi11_client_code").val();
        var c_acc = $("#i_mutasi11_rek").val();
        var c_dt = this.value;                 
        list_trx_mutasi11(c_code,c_acc,c_dt);
        get_balance_mutasi11(c_code,c_acc,c_dt);
    });*/
    
    $("#hbtn_mutasi11_close_day").click(function(){
        
        alert($("#i_mutasi11_coa option:selected").text());
    });
}
function clear_balance_mutasi11()
{
    $("#s_mutasi11_last_dt").html('Last Date');
    $("#s_mutasi11_current_dt").html('Current Date '+$("#i_mutasi11_client_dt").val()); 
    
    $("#i_mutasi11_status2").val('');
    $("#i_mutasi11_obal2").val('0');
    $("#i_mutasi11_tbal2").val('0');
    $("#i_mutasi11_cbal2").val('0');
    $("#i_mutasi11_gbal2").val('0');
    $("#i_mutasi11_sel2").val('0');;
    $("#i_mutasi11_remark2").val('');
    
    $("#i_mutasi11_status1").val('');
    $("#i_mutasi11_obal1").val('0');
    $("#i_mutasi11_tbal1").val('0');
    $("#i_mutasi11_cbal1").val('0');
    $("#i_mutasi11_gbal1").val('0');
    $("#i_mutasi11_sel1").val('0');;
    $("#i_mutasi11_remark1").val('');
}