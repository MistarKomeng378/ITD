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
    //create_dlg_subs_1();
    //create_dlg_subs_2();
    //create_dlg_subs_3();
    //create_dlg_subs_4();
    //create_dlg_subs_search();  
    //create_dlg_subs_listing();
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
        $("#i_subscript_pending_dt").val(saiki);
        $("#i_subscript_buku_dt").val(saiki);
        $("#i_subscript_dt").val(saiki);
        $("#i_subscript_upd_dt").val(saiki);
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
     get_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),$("#hbtn_subs_dt").val());
     //get_prev_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),$("#hbtn_subs_dt").val());
     show_hide_btn_subs(-1);
}
function add_subs()
{
    if(do_subs==0)
    {
        do_subs=1;
        var b_bccode = $("#i_subscript_client_h").val();
        var b_bcode = $("#i_subscript_bank").val();
        var b_baccno = $("#i_subscript_rek").val();
        var b_bdt = $("#i_subscript_dt").val();
        state_progress(1);
                                 //alert(uri+"/index.php/subscript/add_subs");
        var obj_post = $.post(uri+"/index.php/subscript/add_subs", {
            b_ccode:b_bccode,b_code:b_bcode,b_accno:b_baccno,b_dt:b_bdt,b_desc:$("#i_subscript_desc").val(),b_nominal:$("#i_subscript_nominal").val()
        },function(data) {
            alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs();
            do_subs=0;
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }

}

function edit_subs()
{
    if(do_subs==0 && subs_id!=0)
    {
        do_subs=1;

                       //alert($("#i_subscript_nominal").val());
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/subscript/edit_subs", {
            b_id:subs_id,b_ccode:$("#i_subscript_client_h").val(),b_code:$("#i_subscript_bank").val(),b_accno:$("#i_subscript_rek").val(),b_dt:$("#i_subscript_dt").val(),
            b_desc:$("#i_subscript_desc").val(),b_nominal:$("#i_subscript_nominal").val()
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs();
            do_subs=0;
            show_hide_add_subs(-1);
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }
}
function buku_subs()
{
    if(do_subs==0 && subs_id!=0)
    {
        do_subs=1;

                       //alert($("#i_subscript_nominal").val());
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/subscript/buku_subs", {
            b_id:subs_id,b_dt:$("#i_subscript_dt").val()
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs();      
            do_subs=0;
            show_hide_add_subs(-1);
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }
}

function del_subs()
{
    if(do_subs==0)
    {
        do_subs=1;
        
        state_progress(1);
        //alert($("#i_subs_trx_id").val());
        var obj_post = $.post(uri+"/index.php/subscript/del_subs", {
                b_id:subs_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs();      
            do_subs=0;
            show_hide_add_subs(-1);
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }
}
function cancel_buku_subs()
{
    if(do_subs==0)
    {
        do_subs=1;
        
        state_progress(1);
        //alert($("#i_subs_trx_id").val());
        var obj_post = $.post(uri+"/index.php/subscript/cancel_buku_subs", {
                b_id:subs_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs();      
            do_subs=0;
            show_hide_add_subs(-1);
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }
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
        show_hide_btn_subs(-1);     
        
        get_total_pending(pb_ccode,pb_code,pb_accno,$("#i_subscript_upd_dt").val()) ;
        
        //alert(subs_need_upd)   ;
        /*if(subs_need_upd)        
            get_last_balance_subs(pb_ccode,pb_code,pb_accno);
        else
        
        {
            $("#i_subscript_tot_ph").val(strtomoney( (subs_pending*1)+(strtofloat($("#i_subscript_hiport1").val()))));
            $("#i_subscript_selisih").val(strtomoney( (subs_pending*1)+(strtofloat($("#i_subscript_hiport1").val()))-(strtofloat($("#i_subscript_saldo1").val()))));
        } */           
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subs.invalidateAllRows();
        grid_subs.updateRowCount();
        grid_subs.render();
        state_progress(0);}
    );
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

function get_total_pending(pb_ccode,pb_code,pb_accno,pb_dt)
{
    state_progress(1);                 //  alert(pb_dt);
    var obj_post4 = $.post(uri+"/index.php/subscript/get_total_pending_subs", {b_ccode:pb_ccode,b_code:pb_code,b_accno:pb_accno,b_dt:pb_dt}
    ,function(data4) {
    //alert(data4);
    },"json"); 
    obj_post4.done(function(msg4) {            
        if(msg4.r_num_rows>0)
        {
            $("#i_subscript_upd_pending").val(strtomoney(msg4.r_sdata[0].subs_nominal));
            calc_pending(msg4.r_sdata[0].subs_nominal ,$("#i_subscript_upd_hiport").val(),$("#i_subscript_upd_rekening").val(),0);
        }
        else
        {   
            $("#i_subscript_hist_pending").val('0');
            calc_pending(0,$("#i_subscript_upd_hiport").val(),$("#i_subscript_upd_rekening").val(),0);
        }
        state_progress(0);
    });
    
    obj_post4.fail(function(jqXHR, textStatus) {    
        state_progress(0);}
    );
}


function cek_update_balance_subs()
{
    if(do_subs==0)
    {
        do_subs=1;               
        var b_bccode = $("#i_subscript_client_h").val();
        var b_bcode = $("#i_subscript_bank").val();
        var b_baccno = $("#i_subscript_rek").val();
        var b_bpending = strtofloat($("#i_subscript_upd_pending").val());
        var b_bhiport = strtofloat($("#i_subscript_upd_hiport").val());
        var b_bsaldo = strtofloat($("#i_subscript_upd_rekening").val());
        var b_bdt=$("#i_subscript_upd_dt").val();
        
        state_progress(1);
                                   
        var obj_post = $.post(uri+"/index.php/subscript/get_balance_subs", {b_ccode:b_bccode,b_code:b_bcode,b_accno:b_baccno,b_dt:b_bdt},
        function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);  
            do_subs=0;  
            if(msg.r_num_rows>0)
            {
                
                if(lvl>5)
                {
                    alert('Saldo hiport dan rekening sudah pernah update di tanggal tersebut, hubungi checker!');
                }
                else
                {
                    if(confirm("Saldo hiport dan rekening sudah pernah update di tanggal tersebut, lanjutkan?"))
                    {
                        update_balance_subs(b_bccode,b_bcode,b_baccno,b_bpending,b_bhiport,b_bsaldo,b_bdt);
                    }
                }
            }
            else
                update_balance_subs(b_bccode,b_bcode,b_baccno,b_bpending,b_bhiport,b_bsaldo,b_bdt);
            
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }

}

function update_balance_subs(b_bccode,b_bcode,b_baccno,b_bpending,b_bhiport,b_bsaldo,b_bdt)
{
    if(do_subs==0)
    {
        do_subs=1;
        
        state_progress(1);         
        
        var obj_post5 = $.post(uri+"/index.php/subscript/update_balance_subs", {
            b_ccode:b_bccode,b_code:b_bcode,b_accno:b_baccno,b_pending:b_bpending,b_hiport:b_bhiport,b_saldo:b_bsaldo,b_dt:b_bdt
        },function(data5) {
            //alert(data5);
        },'json'); 
        obj_post5.done(function(msg5) { 
            state_progress(0);          //alert('a');
            //get_balance_subs(b_bccode,b_bcode,b_baccno);
            get_balance_subs_hist(b_bccode,b_bcode,b_baccno,$("#hbtn_subs_dt").val());
            alert('Sukses update balance');
            do_subs=0;
        });
        
        obj_post5.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }

}


function show_hide_btn_subs(no)
{
    subs_show_hide_btn_no=no;
    if (no==0)
    {
        $("#b_subscript_add").hide();
        $("#b_subscript_edit").show();
        $("#b_subscript_del").show();
        $("#b_subscript_edit_buku").show();
        $("#b_subscript_edit_cancel_buku").hide();
        $("#b_subscript_edit_cancel").show();
    }
    else if(no==1)
    {
        $("#b_subscript_add").hide();
        $("#b_subscript_edit").hide();
        $("#b_subscript_del").show();
        $("#b_subscript_edit_buku").hide();
        $("#b_subscript_edit_cancel_buku").show();
        $("#b_subscript_edit_cancel").show();
    }
    else
    {
        $("#b_subscript_add").show();
        $("#b_subscript_edit").hide();
        $("#b_subscript_del").hide();
        $("#b_subscript_edit_buku").hide();
        $("#b_subscript_edit_cancel_buku").hide();
        $("#b_subscript_edit_cancel").hide();
        clear_input_subs();
    }
}
function clear_input_subs()
{                                
    $("#i_subscript_desc").val('');
    $("#i_subscript_nominal").val('');
    $("#i_subscript_nominal_a").val('');
}
function create_subs_event()
{
    $("#i_subscript_nominal").keyup(function(){
        $("#i_subscript_nominal_a").val(strtomoney($("#i_subscript_nominal").val()))
    });
    
    $("#i_subscript_upd_hiport").keyup(function(){
        calc_pending( $("#i_subscript_upd_pending").val(),this.value,$("#i_subscript_upd_rekening").val(),1);
        
    });
    $("#i_subscript_upd_rekening").keyup(function(){
        calc_pending( $("#i_subscript_upd_pending").val(),$("#i_subscript_upd_hiport").val(),this.value,2);
        
    });
    $("#hbtn_subs_dt").datepicker();
    $("#hbtn_subs_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    
    $("#i_subscript_dt").datepicker();
    $("#i_subscript_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    
    $("#i_subscript_upd_dt").datepicker();
    $("#i_subscript_upd_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    
    $("#i_subscript_hist_dt").datepicker();
    $("#i_subscript_hist_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    
    $("#i_subscript_buku_dt").datepicker();
    $("#i_subscript_buku_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    
    $("#b_subscript_add").click(function(){
        trx_edited_balance=0;
        if($("#i_subscript_client_h").val()==$("#i_subscript_client").val() && $("#i_subscript_rek").val()!='')
        {
            if(confirm("Tambah mutasi?"))
                add_subs();
        }
        else
            alert('Pilih ulang rekening bank!');
    });
    
    grid_subs.onDblClick.subscribe(function(e) {     
        var selected_row_subs  = grid_subs.getActiveCell();
        if(data_subs[selected_row_subs.row].subs_status==0)
            $("#i_subscript_dt").val(data_subs[selected_row_subs.row].subs_pending_dt);
        else
            $("#i_subscript_dt").val(data_subs[selected_row_subs.row].subs_buku_dt);
        subs_id=data_subs[selected_row_subs.row].subs_id;
        $("#i_subscript_desc").val(data_subs[selected_row_subs.row].subs_desc);
        $("#i_subscript_nominal").val(data_subs[selected_row_subs.row].subs_nominal);
        $("#i_subscript_nominal_a").val(strtomoney(data_subs[selected_row_subs.row].subs_nominal));
        show_hide_btn_subs(data_subs[selected_row_subs.row].subs_status);
        
        
    });
    grid_subs.onClick.subscribe(function(e) { 
        if(subs_show_hide_btn_no!=-1)   
        {
            var cell = grid_subs.getCellFromEvent(e),
            row = cell.row;
            if(data_subs[row].subs_status==0)
                $("#i_subscript_dt").val(data_subs[row].subs_pending_dt);
            else
                $("#i_subscript_dt").val(data_subs[row].subs_buku_dt);
            subs_id=data_subs[row].subs_id;
            $("#i_subscript_desc").val(data_subs[row].subs_desc);
            $("#i_subscript_nominal").val(data_subs[row].subs_nominal);
            $("#i_subscript_nominal_a").val(strtomoney(data_subs[row].subs_nominal));
            show_hide_btn_subs(data_subs[row].subs_status);
        }  
        
    });
    $("#hbtn_subs_reload1").click(function(){
        subs_need_upd=1;
        refresh_subs();
        show_hide_btn_subs(-1);
    });
    $("#b_subscript_edit_cancel").click(function(){
            show_hide_btn_subs(-1);
    });
    $("#b_subscript_edit").click(function(){
        if(confirm('Ubah data subscript?'))
            edit_subs();
    });
    $("#b_subscript_edit_buku").click(function(){
        if(confirm('Bukukan pending subscription?'))
            buku_subs();
    });
    $("#b_subscript_del").click(function(){
        if(confirm('Hapus pending subscription?'))
            del_subs();
    });
    $("#b_subscript_edit_cancel_buku").click(function(){
        if(confirm('Batalkan status buku pending subscription?'))
            cancel_buku_subs();
    });
    $("#i_subscript_hiport").keyup(function(){
        $("#i_subscript_hiport1").val(strtomoney($("#i_subscript_hiport").val()))
        $("#i_subscript_tot_ph").val(strtomoney( strtofloat($("#i_subscript_total1").val())+(strtofloat($("#i_subscript_hiport").val()))));
        $("#i_subscript_selisih").val(strtomoney( strtofloat($("#i_subscript_total1").val())+(strtofloat($("#i_subscript_hiport").val()))-(strtofloat($("#i_subscript_saldo1").val()))));
    });
    $("#i_subscript_saldo").keyup(function(){
        $("#i_subscript_saldo1").val(strtomoney($("#i_subscript_saldo").val()))
        $("#i_subscript_tot_ph").val(strtomoney( strtofloat($("#i_subscript_total1").val())+(strtofloat($("#i_subscript_hiport1").val()))));
        $("#i_subscript_selisih").val(strtomoney( strtofloat($("#i_subscript_total1").val())+(strtofloat($("#i_subscript_hiport1").val()))-(strtofloat($("#i_subscript_saldo").val()))));
    });
    $("#b_subscript_update").click(function(){
        if($("#i_subscript_client_h").val()==$("#i_subscript_client").val() && $("#i_subscript_rek").val()!='' && $("#i_subscript_upd_hiport").val()!='' && $("#i_subscript_upd_rekening").val()!='')
            if(confirm('Update balance pending subscription?'))
                cek_update_balance_subs();
    });
    /*$("#hbtn_subs_save1").click(function(){
        if($("#i_subscript_rek").val()!='')
            if(confirm('Simpan daftar pending subscription ke excel?'))
                save_list_subs();
    });*/
    $("#hbtn_subs_print1").click(function(){
        if($("#i_subscript_rek").val()!='')
            if(confirm('Cetak daftar pending subscription?'))
                print_list_subs(); 
    });
    $("#i_subscript_hist_dt").change(function(){
        get_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),this.value);
        //get_prev_balance_subs_hist($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),this.value);
    });
    $("#i_subscript_upd_dt").change(function(){
        get_total_pending($("#i_subscript_client_h").val(),$("#i_subscript_bank").val(),$("#i_subscript_rek").val(),this.value);
    });
}

function save_list_subs()
{
    var str_subs_frm='<form id="subs_frm_save" target="_blank" method="post" action="'+uri+'/index.php/subscript/save_subs">';
    str_subs_frm+='<input name="b_ccode" value="'+$("#i_subscript_client_h").val()+'" />';
    str_subs_frm+='<input name="b_code" value="'+$("#i_subscript_bank").val()+'" />';
    str_subs_frm+='<input name="b_accno" value="'+$("#i_subscript_rek").val()+'" />';
    str_subs_frm+='<input name="b_dt" value="'+$("#hbtn_subs_dt").val()+'" />';
    str_subs_frm+='</form>';         
    $("#subs_form_hidden").html(str_subs_frm).promise().done(function(){         
        $('#subs_frm_save').submit();
    });;
}
function print_list_subs()
{
    var str_subs_frm='<form id="subs_frm_print" target="_blank" method="post" action="'+uri+'/index.php/subscript/print_subs">';
    str_subs_frm+='<input name="b_ccode" value="'+$("#i_subscript_client_h").val()+'" />';
    str_subs_frm+='<input name="b_code" value="'+$("#i_subscript_bank_h").val()+'" />';
    str_subs_frm+='<input name="b_accno" value="'+$("#i_subscript_rek").val()+'" />';
    str_subs_frm+='<input name="b_dt" value="'+$("#hbtn_subs_dt").val()+'" />';
    str_subs_frm+='</form>';         
    $("#subs_form_hidden").html(str_subs_frm).promise().done(function(){
        $('#subs_frm_print').submit();
    });;
}

function calc_pending(p_pending,p_hiport,p_saldo,field_no)
{                                                                        
    $("#i_subscript_upd_pending").val(strtomoney(strtofloat(p_pending))); 
    if(field_no!=1)
        $("#i_subscript_upd_hiport").val(strtofloat(p_hiport));
    $("#i_subscript_upd_hiport1").val(strtomoney(strtofloat(p_hiport)));
    $("#i_subscript_upd_pending_hiport").val(strtomoney(strtofloat(p_pending)*1+strtofloat(p_hiport)*1));
    if(field_no!=2)
        $("#i_subscript_upd_rekening").val(strtofloat(p_saldo));
    $("#i_subscript_upd_rekening1").val(strtomoney(strtofloat(p_saldo)));
    $("#i_subscript_upd_selisih").val(strtomoney(strtofloat(p_pending)*1+strtofloat(p_hiport)*1-strtofloat(p_saldo)*1));
}