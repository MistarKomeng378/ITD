var grid_subs;
var data_subs = [];
var do_subs=0;
var subs_id=0;
var subs_show_hide_btn_no=-1;   
var subs_pending=0;        
var subs_need_upd=1;

function initiate_subs()
{
    add_section("content_subs","data_subs","refresh_subs()","hbtn_subs","grid_subs");
    
    get_content_subs(); 
}
function get_content_subs()
{             
    var obj_post = $.post(uri_subs,{},function(data) {
        $("#content_subs").html(data);
    });
    obj_post.done(function(msg) { 
        create_subs_grid(); 
        create_dlg_dpicker_subs();
        //reload_coa_subs();
        create_subs_event();
        $("#hbtn_subs_dt").val(saiki);
        //$("#i_subscript_pending_dt").val(saiki);
        //$("#i_subscript_buku_dt").val(saiki);
        //$("#i_subscript_dt").val(saiki);    
        //$("#i_subscript_upd_dt").val(saiki);
        $("#i_subscript_hist_dt").val(saiki);
        //get_content_user_subs();
    });
}
function create_subs_grid()
{
    var columns_subs = [];
    var options_subs = [] ; 
    columns_subs = [                                                                      
        {id:"subs_pending_dt", name:"Tanggal Pending", field:"subs_pending_dt",width:110}
        ,{id:"subs_desc", name:"Keterangan", field:"subs_desc",width:200}
        ,{id:"subs_pending_nominal", name:"Nominal Pending", field:"subs_pending_nominal",width:150,cssClass:"cell_right"}
        ,{id:"subs_buku_dt", name:"Tanggal Buku", field:"subs_buku_dt",width:110}
        ,{id:"subs_buku_nominal", name:"Nominal Buku", field:"subs_buku_nominal",width:150,cssClass:"cell_right"}
    ];
    options_subs = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subs = new Slick.Grid("#tbl_slick_subs", data_subs, columns_subs, options_subs);
    grid_subs.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function create_dlg_dpicker_subs()
{
    var dpick_opt_subs ={
        cols : [         
                   {id:"client_code", name:"Client Code", field:"client_code",width:70}
                   ,{id:"bank_code", name:"Bank Code", field:"bank_code",width:70}
                   ,{id:"acc_no", name:"No Rekening", field:"acc_no",width:100}
                   ,{id:"client_name", name:"Client Name", field:"client_name",width:220}
                   ,{id:"bank_desc", name:"Bank Name", field:"bank_desc",width:220}
            ],
        url: uri+"index.php/subscript/subs_list_bank_by_code",
        setval: function(obj_val){                      
            $("#i_subscript_bank").val(trim(obj_val.bank_code));
            $("#i_subscript_rek").val(obj_val.acc_no);
            $("#i_subscript_bank_name").val(obj_val.bank_desc);
            $("#i_subscript_client").val(obj_val.client_code);
            $("#i_subscript_client_name").val(obj_val.client_name);
            $("#i_subscript_rek_id_h").val(obj_val.rek_id);
            $("#i_subscript_bank_h").val(obj_val.bank_code);
            $("#i_subscript_client_h").val(obj_val.client_code);
            var b_dt=$("#hbtn_subs_dt").val();  
            subs_need_upd=1;
            list_subs(obj_val.client_code,obj_val.bank_code,obj_val.acc_no,b_dt);
            get_balance_subs_hist(obj_val.client_code,obj_val.bank_code,obj_val.acc_no,b_dt);
            /*
            subs_kena_jasgir= obj_val.kena_jasgir;
            var c_dt=$("#i_subs_client_dt").val();
            clear_balance_subs();
            get_last_date_subs(obj_val.client_code,obj_val.acc_no);
            list_trx_subs(obj_val.client_code,obj_val.acc_no,c_dt);
            get_balance_subs(obj_val.client_code,obj_val.acc_no,c_dt);
            show_hide_add_subs(1);
            */
        }
    }; 
    dPicker_attach($("#i_subscript_client"),dpick_opt_subs);        
}
function refresh_subs()
{   
     list_subs($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),$("#hbtn_subs_dt").val());
    // get_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),$("#hbtn_subs_dt").val());
     //get_prev_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),$("#hbtn_subs_dt").val());
     //show_hide_btn_subs(-1);
}

function list_subs(pb_ccode,pb_code,pb_accno,pb_dt)
{
    state_progress(1);                    
    data_subs.length=0;  
    subs_pending=0;
    var obj_post = $.post(uri+"/index.php/subscript/list_subs", {b_ccode:pb_ccode,b_code:pb_code,b_accno:pb_accno,b_dt:pb_dt},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        var tot_buku=0;
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subs[i] = {});
            d["subs_id"] = msg.r_sdata[i].subs_id;
            d["subs_desc"] = msg.r_sdata[i].subs_desc;
            d["subs_pending_dt"] = msg.r_sdata[i].pending_dt_s;
            d["subs_nominal"] = msg.r_sdata[i].subs_nominal;
            d["subs_pending_nominal"] = msg.r_sdata[i].subs_status==1?'':strtomoney(msg.r_sdata[i].subs_nominal);
            d["subs_buku_dt"] = msg.r_sdata[i].subs_status==1?msg.r_sdata[i].buku_dt_s:'';
            d["subs_buku_nominal"] = msg.r_sdata[i].subs_status==1?strtomoney(msg.r_sdata[i].subs_nominal):'';
            d["subs_status"] = msg.r_sdata[i].subs_status;
            subs_pending+= msg.r_sdata[i].subs_status==1?0:(msg.r_sdata[i].subs_nominal*1);
            tot_buku+= msg.r_sdata[i].subs_status==1?(msg.r_sdata[i].subs_nominal*1):0;
        }
        $("#i_subscript_total1").val(strtomoney(subs_pending));
        $("#i_subscript_total_pending").val(strtomoney(subs_pending));
        $("#i_subscript_total_buku").val(strtomoney(tot_buku));
        grid_subs.invalidateAllRows();
        grid_subs.updateRowCount();
        grid_subs.render();                
        state_progress(0);           
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subs.invalidateAllRows();
        grid_subs.updateRowCount();
        grid_subs.render();
        state_progress(0);}
    );
}


function clear_input_subs()
{                                

}
function create_subs_event()
{
    $("#i_subscript_hist_dt").datepicker();
    $("#i_subscript_hist_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' );  
    
    $("#hbtn_subs_reload1").click(function(){
        subs_need_upd=1;
        refresh_subs();
    });   
    $("#i_subscript_hist_dt").change(function(){
        get_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),this.value);
        //get_prev_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),this.value);
    });
}

function get_balance_subs_hist(pb_ccode,pb_code,pb_accno,pb_dt)
{
    state_progress(1);    
    var obj_post3 = $.post(uri+"/index.php/subscript/get_balance_subs", {b_ccode:pb_ccode,b_code:pb_code,b_accno:pb_accno,b_dt:pb_dt},function(data3) {
        //alert(data3);
    },"json"); 
    obj_post3.done(function(msg3) { 
        if(msg3.r_num_rows>0)
        {
            $("#i_subscript_hist_pending").val(strtomoney(msg3.r_sdata[0].pending));
            $("#i_subscript_hist_hiport").val(strtomoney(msg3.r_sdata[0].hiport));
            $("#i_subscript_hist_pending_hiport").val(strtomoney( (msg3.r_sdata[0].pending*1)+(msg3.r_sdata[0].hiport*1)));
            $("#i_subscript_hist_rekening").val(strtomoney(msg3.r_sdata[0].saldo_rek));
            $("#i_subscript_hist_selisih").val(strtomoney( (msg3.r_sdata[0].pending*1)+(msg3.r_sdata[0].hiport*1) -(msg3.r_sdata[0].saldo_rek*1) ));

            subs_need_upd=0;
        }
        else
        {   //$("#i_subscript_total1").val('');
            $("#i_subscript_hist_pending").val('');
            $("#i_subscript_hist_hiport").val(''); 
            $("#i_subscript_hist_pending_hiport").val('');
            $("#i_subscript_hist_rekening").val('');
            $("#i_subscript_hist_selisih").val('');
        }
        get_prev_balance_subs_hist(pb_ccode,pb_code,pb_accno,pb_dt);
        state_progress(0);
    });
    
    obj_post3.fail(function(jqXHR, textStatus) {
        state_progress(0);}
    );
}

function get_prev_balance_subs_hist(pb_ccode,pb_code,pb_accno,pb_dt)
{
//    state_progress(1);              /alert('aa');
    var obj_post6 = $.post(uri+"/index.php/subscript/get_prev_balance_subs", {b_ccode:pb_ccode,b_code:pb_code,b_accno:pb_accno,b_dt:pb_dt},function(data6) {
        //alert(data6);
    },'json'); 
    obj_post6.done(function(msg6) { 
        if(msg6.r_num_rows>0)
        {
            $("#i_subscript_hist_dt1").val(msg6.r_sdata[0].update_time_s);
            $("#i_subscript_hist_pending1").val(strtomoney(msg6.r_sdata[0].pending));
            $("#i_subscript_hist_hiport1").val(strtomoney(msg6.r_sdata[0].hiport));
            $("#i_subscript_hist_pending_hiport1").val(strtomoney( (msg6.r_sdata[0].pending*1)+(msg6.r_sdata[0].hiport*1)));
            $("#i_subscript_hist_rekening1").val(strtomoney(msg6.r_sdata[0].saldo_rek));
            $("#i_subscript_hist_selisih1").val(strtomoney( (msg6.r_sdata[0].pending*1)+(msg6.r_sdata[0].hiport*1) -(msg6.r_sdata[0].saldo_rek*1) ));

            subs_need_upd=0;
        }
        else
        {   //$("#i_subscript_total1").val('');
            $("#i_subscript_hist_dt1").val('');
            $("#i_subscript_hist_pending1").val('');
            $("#i_subscript_hist_hiport1").val(''); 
            $("#i_subscript_hist_pending_hiport1").val('');
            $("#i_subscript_hist_rekening1").val('');
            $("#i_subscript_hist_selisih1").val('');
        }
        state_progress(0);
    });
    
    obj_post6.fail(function(jqXHR, textStatus) {
        state_progress(0);}
    );
}
