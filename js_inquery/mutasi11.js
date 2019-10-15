var grid_mutasi11;
var data_mutasi11 = [];
var do_mutasi11=0;
var do_mutasi11_a=0;
var data_mutasi11_param = [];
var mutasi11_last_balance=0;
var mutasi11_last_balance_close=0;
var trx_edited_balance=0;
var mutasi11_curr_status=0;
var mutasi11_enable_set =0;

function initiate_mutasi11()
{
    add_section("content_mutasi11","data_mutasi11","refresh_mutasi11()","hbtn_mutasi11","grid_mutasi11");
    
    get_content_mutasi11();
    create_dlg_mutasi11_4();
    //create_dlg_mutasi11_1();
    //create_dlg_mutasi11_2();
    //create_dlg_mutasi11_3();
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
        create_mutasi11_event();
        $("#i_mutasi11_client_dt").val(saiki);
        $("#content_mutasi11").show();
        $("#hbtn_mutasi11").show();
    });
}
function create_mutasi11_grid()
{
    var columns_mutasi11 = [];
    var options_mutasi11 = [] ; 
    columns_mutasi11 = [         
        {id:"coa_desc", name:"Kategori", field:"coa_desc",width:240}
        ,{id:"trx_desc", name:"Description", field:"trx_desc",width:200}
        ,{id:"trx_dc", name:"D/C", field:"trx_dc",width:30,cssClass:"cell_center"}
        ,{id:"trx_nominal_d", name:"Debet", field:"trx_nominal_d",width:150,cssClass:"cell_right"}
        ,{id:"trx_nominal_c", name:"Kredit", field:"trx_nominal_c",width:150,cssClass:"cell_right"}
        ,{id:"modified_dt", name:"Modified", field:"modified_dt",width:110}
        ,{id:"modified_by", name:"Modified By", field:"modified_by",width:100}
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
                   ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
                   ,{id:"client_name", name:"Account Name", field:"client_name",width:180}
                   ,{id:"bank_name", name:"Bank Name", field:"bank_name"}
                   ,{id:"client_cif", name:"CIF", field:"client_cif",width:60}
                   ,{id:"client_cbest", name:"CBEST", field:"client_cbest",width:100}
            ],
        url: uri+"index.php/mutasi/list_client_by_code",
        setval: function(obj_val){                      
            $("#i_mutasi11_client_code").val(trim(obj_val.client_code));
            $("#i_mutasi11_rek").val(obj_val.acc_no);
            $("#i_mutasi11_client_name").val(obj_val.client_name);
            var c_dt=$("#i_mutasi11_client_dt").val();
            clear_balance_mutasi11();
            get_last_date_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
            list_trx_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
            get_balance_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
            //show_hide_add_mutasi11(1);
            
        }
    }; 
    dPicker_attach($("#i_mutasi11_client_code"),dpick_opt_mutasi11);        
}

function get_last_date_mutasi11(pc_code,pc_accno,pc_dt)
{
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/mutasi/get_last_balance_date", {c_code:pc_code,c_accno:pc_accno,cdt:pc_dt},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
        {
            $("#i_mutasi11_client_last_date").val(msg.r_sdata[0].last_date_s);
            $("#i_mutasi11_client_status").val(msg.r_sdata[0].balance_status==2?'Closed':'Open');
            $("#s_mutasi11_dstatus").html(msg.r_sdata[0].curr_status==2?'Closed':(msg.r_sdata[0].curr_status==1?"Open":(msg.r_sdata[0].curr_status==3?"Open (Locked)":(msg.r_sdata[0].curr_status==4?"Locked":""))));
            mutasi11_last_balance_close=msg.r_sdata[0].balance_close;
            mutasi11_curr_status=msg.r_sdata[0].curr_status;
            mutasi11_enable_set=msg.r_sdata[0].enable_set;
        }
        else
        {
            $("#i_mutasi11_client_last_date").val('');
            $("#i_mutasi11_client_status").val('');
            mutasi11_last_balance_close=0;  
            mutasi11_enable_set=6;
            $("#s_mutasi11_dstatus").html('');         
             mutasi11_curr_status=0;
        }
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
        var c1=0;
        var c2=0;
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_mutasi11[i] = {});
            d["trx_id"] = msg.r_sdata[i].trx_id;
            d["trx_date"] = msg.r_sdata[i].trx_date_s;
            d["coa_no"] = msg.r_sdata[i].coa_no;
            d["coa_desc"] = msg.r_sdata[i].coa_no+' - '+msg.r_sdata[i].coa_desc;
            d["trx_desc"] = msg.r_sdata[i].trx_desc;
            d["trx_dc"] = msg.r_sdata[i].trx_dc;
            d["trx_nominal"] = strtomoney(msg.r_sdata[i].trx_nominal);
            d["trx_nominal_c"] = msg.r_sdata[i].trx_dc=='C'?strtomoney(msg.r_sdata[i].trx_nominal):'';
            d["trx_nominal_d"] = msg.r_sdata[i].trx_dc=='D'?strtomoney(msg.r_sdata[i].trx_nominal):'';
            d["trx_nominal_n"] = msg.r_sdata[i].trx_nominal;
            d["created_by"] = msg.r_sdata[i].created_by;
            d["created_dt"] = msg.r_sdata[i].created_dt_st;
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_st;
            d["trx_status"] = msg.r_sdata[i].trx_status;
            if(msg.r_sdata[i].trx_dc=='C')
                c1 = c1 + 1*msg.r_sdata[i].trx_nominal;
            else if (msg.r_sdata[i].trx_dc=='D')
                c2 = c2 + 1*msg.r_sdata[i].trx_nominal;
        }
        $("#s_mutasi11_dc").html('K= '+strtomoney(c1)+' *** D= '+strtomoney(c2)+'');
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
    $("#s_mutasi11_gbal2").hide(); 
    var obj_post = $.post(uri+"/index.php/mutasi/get_balance", {c_code:pc_code,c_accno:pc_accno,c_dt:pc_dt},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        mutasi11_last_balance=0;
        for (var i=0; i<msg.r_num_rows; i++) {
            
            if(0+msg.r_sdata[i].p==1)
            {
                $("#i_mutasi11_status1").val(msg.r_sdata[i].balance_status==1?'Open':msg.r_sdata[i].balance_status==2?'Closed':'');
                $("#i_mutasi11_obal1").val(strtomoney(msg.r_sdata[i].balance_open));
                $("#i_mutasi11_tbal1").val(strtomoney(msg.r_sdata[i].balance_trx_final));
                $("#i_mutasi11_cbal1").val(strtomoney(msg.r_sdata[i].balance_close_final));
                $("#i_mutasi11_gbal1").val(strtomoney(msg.r_sdata[i].balance_gs));
                $("#i_mutasi11_sel1").val(strtomoney(msg.r_sdata[i].balance_gs-msg.r_sdata[i].balance_close_final));;
                if(msg.r_sdata[i].balance_close_final-msg.r_sdata[i].balance_gs!=0)
                    $("#i_mutasi11_sel1").addClass("input_warning");
                else
                    $("#i_mutasi11_sel1").removeClass("input_warning");
                $("#i_mutasi11_remark1").val(msg.r_sdata[i].balance_remark);
                $("#s_mutasi11_last_dt").html('Previous Balance Date ' +msg.r_sdata[i].balance_date_s);
                mutasi11_last_balance=strtofloat(msg.r_sdata[i].balance_close_final);
                
                $("#i_mutasi11_c_by1").val(msg.r_sdata[i].balance_close_by);
                $("#i_mutasi11_c_dt1").val(msg.r_sdata[i].balance_close_dt_s);
                $("#i_mutasi11_c_time1").val(msg.r_sdata[i].balance_close_dt_t);
            }
            if(0+msg.r_sdata[i].p==2)
            {
                $("#i_mutasi11_status2").val(msg.r_sdata[i].balance_status==1?'Open':msg.r_sdata[i].balance_status==2?'Closed':'');
                $("#i_mutasi11_obal2").val(strtomoney(msg.r_sdata[i].balance_open));
                $("#i_mutasi11_tbal2").val(strtomoney(msg.r_sdata[i].balance_trx_final));
                $("#i_mutasi11_cbal2").val(strtomoney(msg.r_sdata[i].balance_close_final));
                $("#i_mutasi11_sel2").val(strtomoney(msg.r_sdata[i].balance_close_final));;
                $("#i_mutasi11_remark2").val(msg.r_sdata[i].balance_remark);   
                $("#s_mutasi11_current_dt").html('On Date ' +msg.r_sdata[i].balance_date_s);
                mutasi11_last_balance=strtofloat(msg.r_sdata[i].balance_close_final);
                //alert(msg.r_sdata[i].balance_status);
                if(msg.r_sdata[i].balance_status==2)
                {
                    //$("#i_mutasi11_gbal2").attr("readonly",true);
                    //$("#i_mutasi11_remark2").attr("readonly",true);
                    $("#i_mutasi11_gbal2").val(strtomoney(msg.r_sdata[i].balance_gs));
                    $("#i_mutasi11_sel2").val(strtomoney(msg.r_sdata[i].balance_gs-msg.r_sdata[i].balance_close_final));
                    if(msg.r_sdata[i].balance_close_final-msg.r_sdata[i].balance_gs!=0)
                        $("#i_mutasi11_sel2").addClass("input_warning");
                    else
                        $("#i_mutasi11_sel2").removeClass("input_warning");
                    
                }
                else
                {
                    //$("#i_mutasi11_gbal2").attr("readonly",false);
                    //$("#i_mutasi11_remark2").attr("readonly",false);
                    $("#i_mutasi11_gbal2").val('');
                    $("#s_mutasi11_gbal2").html('0');
                    $("#s_mutasi11_gbal2").show(); 
                    $("#i_mutasi11_sel2").removeClass("input_warning");
                }
                $("#i_mutasi11_c_by2").val(msg.r_sdata[i].balance_close_by);
                $("#i_mutasi11_c_dt2").val(msg.r_sdata[i].balance_close_dt_s);
                $("#i_mutasi11_c_time2").val(msg.r_sdata[i].balance_close_dt_t);
            }
        }
        $("#i_mutasi11_gbal2").attr("readonly",true);
        $("#i_mutasi11_remark2").attr("readonly",true);
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}


function refresh_mutasi11()
{   
    //reload_coa_mutasi11(); 
}

function create_mutasi11_event()
{
    
    $("#i_mutasi11_client_dt").datepicker();
    $("#i_mutasi11_client_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
   
    $("#i_mutasi11_client_dt").change(function(){
        clear_balance_mutasi11();
        var c_code = $("#i_mutasi11_client_code").val();
        var c_acc = $("#i_mutasi11_rek").val();
        var c_dt = this.value;
        get_last_date_mutasi11(c_code,c_acc,c_dt);
        list_trx_mutasi11(c_code,c_acc,c_dt);
        get_balance_mutasi11(c_code,c_acc,c_dt);
        //show_hide_add_mutasi11(1);
    });     
    $("#hbtn_mutasi11_c_jasgir").click(function(){
        open_dlg_mutasi11_4($("#i_mutasi11_client_code").val(),$("#i_mutasi11_client_name").val(),$("#i_mutasi11_rek").val(),$("#i_mutasi11_client_dt").val());
    });
    $("#hbtn_mutasi11_cancel_close_day").click(function(){
        if($("#i_mutasi11_rek").val()!=''&&$("#i_mutasi11_status2").val()=='Closed')
        {
            if(confirm("Status akhir hari mutasi di batalkan?"))
            {
                var obj_post = $.post(uri+"/index.php/mutasi/get_client_id", {
                    c_code:$("#i_mutasi11_client_code").val(),c_no:$("#i_mutasi11_rek").val()
                },function(data) {
                    //alert(data);
                },"json"); 
                obj_post.done(function(msg) { 
                    if(msg.r_num_rows>0)
                        cancel_close_day_mutasi11();
                    else
                        alert("Tidak ada client dengan Kode "+$("#i_mutasi11_client_code").val()+" dan no rekening: "+$("#i_mutasi11_rek").val());
                });
                
                obj_post.fail(function(jqXHR, textStatus) {alert("Error mengecek client!");});
            }
        }
        else
            alert("Hanya mutasi berstatus close yang bisa cancel!");
        
    });
    $("#hbtn_mutasi11_unlock").click(function(){//alert(mutasi11_enable_set);
        if(mutasi11_enable_set==0)
            alert('Tidak bisa di flag, liat tanggal akhir tutup balance!');
        else
            permit_mutasi11();
    });
}       
function cancel_close_day_mutasi11()
{
    if(do_mutasi11_a==0)
    {
        do_mutasi_a=1;        
        var c_ccode = $("#i_mutasi11_client_code").val();
        var c_accno = $("#i_mutasi11_rek").val();
        var c_cdt = $("#i_mutasi11_client_dt").val();
                   
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/mutasi/cancel_close_day", {
            c_code:c_ccode,c_no:c_accno,c_dt:c_cdt
        },function(data) {
            do_mutasi11_a=0;
            try {
                var msg = $.parseJSON(data);
                
                if(msg.r_num_rows>0)
                {   
                    if(msg.r_sdata[0].success==1)
                    {
                        state_progress(0); 
                        alert('Action is succeded.');                   
                        get_last_date_mutasi11(c_ccode,c_accno,c_cdt);
                        list_trx_mutasi11(c_ccode,c_accno,c_cdt);
                        get_balance_mutasi11(c_ccode,c_accno,c_cdt);
                        show_hide_add_mutasi11(1);                      
                    }
                }
            } catch (e) {
                if(data.substr(0,4)=='SMTP')
                    alert("Error sending email, refreshing status!");
                state_progress(0);
                get_last_date_mutasi11(c_ccode,c_accno,c_cdt);
                list_trx_mutasi11(c_ccode,c_accno,c_cdt);
                get_balance_mutasi11(c_ccode,c_accno,c_cdt);
                show_hide_add_mutasi11(1);
                // not json
            }
        }); 
        
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11_a=0;state_progress(0);});      
    }
}
function clear_balance_mutasi11()
{
    $("#s_mutasi11_last_dt").html('Previous Balance Date');
    $("#s_mutasi11_current_dt").html('On Date '+$("#i_mutasi11_client_dt").val()); 
    
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
function  calc_selisih_mutasi11()
{
    return strtofloat($("#i_mutasi11_cbal2").val())-strtofloat($("#i_mutasi11_gbal2").val());
}
function permit_mutasi11()
{
    if(do_mutasi11_a==0 && confirm("Give permission to backdate?"))
    {
        do_mutasi_a=1; 
        var c_ccode = $("#i_mutasi11_client_code").val();
        var c_accno = $("#i_mutasi11_rek").val();
        var c_cdt = $("#i_mutasi11_client_dt").val();
                   
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/mutasi/set_permission", {
            c_code:c_ccode,c_no:c_accno,c_dt:c_cdt
        },function(data) {// alert(data);
            alert('Action is succeded.');
            do_mutasi11_a=0;
            state_progress(0);
        }); 
        
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11_a=0;state_progress(0);});      
    }
}