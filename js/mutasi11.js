var grid_mutasi11;
var grid_mutasi_by_group;
var grid_mutasi_detail;
var data_mutasi11 = [];
var mutasi_by_group = [];
var mutasi_detail = [];
var do_mutasi11=0;
var do_mutasi11_a=0;
var data_mutasi11_param = [];
var mutasi11_last_balance=0;
var mutasi11_last_balance_close=0;
var trx_edited_balance=0;
var mutasi11_kena_jasgir=0;
var mutasi11_curr_status=0;
var mutasi11_bal_status=0;
var mutasi11_fut=0;
var mutasi11_ct=3;

function initiate_mutasi11()
{
    add_section("content_mutasi11","data_mutasi11","refresh_mutasi11()","hbtn_mutasi11","grid_mutasi11");
    
    get_content_mutasi11();
    
    create_dlg_mutasi11_1();
    create_dlg_mutasi11_2();
    create_dlg_mutasi11_3();
    create_dlg_mutasi11_4();
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
        // create_dlg_dpicker_mutasi11();
        reload_coa_mutasi11();
        create_mutasi11_event();
        $("#i_mutasi11_client_dt").val(saiki);
        //get_content_user_mutasi11();
        dlg_mutasi_client();
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
                    
                    {id:"subsrd_date", name:"Date", field:"subsrd_date", width:50, 
                        formatter: function (row, cell, value, columnDef, dataContext) {
                            return dataContext.subsrd_date.date;
                        }
                    }
                   ,{id:"client_code", name:"Code", field:"client_code",width:50}
                   ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
                //,{id:"bank_src", name:"Selling Agent", field:"deskripsi",width:90}
                   ,{id:"bank_name", name:"Bank Name", field:"bank_name"}
                   ,{id:"client_name", name:"Account Name", field:"client_name",width:180}
                   ,{id:"subsrd_nominal", name:"Nominal", field:"subsrd_nominal",width:100}
                   //,{id:"client_cif", name:"CIF", field:"client_cif",width:60}
                   //,{id:"client_cbest", name:"CBEST", field:"client_cbest",width:100}
                   ,{id:"kena_jasgir", name:"Jasgir", field:"kena_jasgir"}
                   //,{id:"bank_src", name:"Selling Agent", field:"deskripsi",width:90}
                   ,{id:"coa_Id", name:"Coa Id", field:"subsrd_kategori",width:90}
                   ,{id:"subsrd_kategori", name:"Kategori", field:"coa_desc",width:90}
            ],
        url: uri+"index.php/mutasi/list_client_by_code",
        setval: function(obj_val){                      
            $("#i_mutasi11_client_code").val(trim(obj_val.client_code));
            $("#i_mutasi11_rek").val(obj_val.acc_no);
            $("#i_mutasi11_client_name").val(obj_val.client_name);
			$("#i_mutasi11_desc").val(obj_val.deskripsi);
            $("#i_mutasi11_nominal").val(obj_val.subsrd_nominal);
            $("#i_mutasi11_nominal_a").val(strtomoney($("#i_mutasi11_nominal").val()));

            mutasi11_kena_jasgir= obj_val.kena_jasgir;
            
            var d = obj_val.subsrd_date.date;
            var tahun = d.substr(0,4);
            var bulan = d.substr(5,2);
            var hari = d.substr(8,2);
            $("#i_mutasi11_client_dt").val(hari+'-'+bulan+'-'+tahun);

            var c_dt=$("#i_mutasi11_client_dt").val();
            clear_balance_mutasi11();
            get_last_date_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
            
            get_balance_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
            //show_hide_add_mutasi11(1);
            reload_coa_mutasi11(obj_val.subsrd_kategori)

            list_trx_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt)

        }
    }; 
    dPicker_attach($("#i_mutasi11_client_code"),dpick_opt_mutasi11);
}

function setMutasiTRx(coa_id,client_code,date,acc_no,trx_date) {

    var d = date;
    var tahun = d.substr(0,4);
    var bulan = d.substr(5,2);
    var hari = d.substr(8,2);
    var c_dt = hari+'-'+bulan+'-'+tahun;
    
    $.post(uri+"index.php/mutasi/set_mutasi_trx",{
        coa_id:coa_id,
        client_code:client_code,
        date:date,
        acc_no:acc_no,
        trx_date:trx_date
    }, function(data, status) {
        list_trx_mutasi11(client_code,acc_no,trx_date);
    });
    
}

function reload_coa_mutasi11(coa = null)
{
    state_progress(1);    
    var obj_post = $.post(uri+"/index.php/mutasi/list_coa", {},function(data) {},"json"); 
    obj_post.done(function(msg) { 
        var htm='';
        for (var i=0; i<msg.r_num_rows; i++) {
			if(coa == msg.r_sdata[i].coa_no ){
				htm = htm + "<option selected value='"+msg.r_sdata[i].coa_no+"'>"+msg.r_sdata[i].coa_desc+"</option>"
				$("#i_mutasi11_dc").val(msg.r_sdata[i].coa_dc);
			}else{
				htm = htm + "<option value='"+msg.r_sdata[i].coa_no+"'>"+msg.r_sdata[i].coa_desc+"</option>"
			}
        }
        $("#i_mutasi11_coa").html(htm);
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function get_last_date_mutasi11(pc_code,pc_accno,pc_dt)
{
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/mutasi/get_last_balance_date", {c_code:pc_code,c_accno:pc_accno,cdt:pc_dt},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) {   //alert(msg);
        if(msg.r_num_rows>0)
        { 
            $("#i_mutasi11_client_last_date").val(msg.r_sdata[0].last_date_s);
            $("#i_mutasi11_client_status").val(msg.r_sdata[0].balance_status==2?'Closed':(msg.r_sdata[0].balance_status==1?'Open':''));       
            $("#s_mutasi11_dstatus").html(msg.r_sdata[0].curr_status==2?'Closed':(msg.r_sdata[0].curr_status==1?"Open":(msg.r_sdata[0].curr_status==3?"Open (Locked)":(msg.r_sdata[0].curr_status==4|| msg.r_sdata[0].curr_status==6?"Locked":""))));
            mutasi11_last_balance_close=msg.r_sdata[0].balance_close;
            mutasi11_curr_status=msg.r_sdata[0].curr_status;
            mutasi11_bal_status=msg.r_sdata[0].balance_status;
            mutasi11_ct=msg.r_sdata[0].ct;
            $("#i_mutasi11_dstatus").val(msg.r_sdata[0].curr_status);
            show_hide_add_mutasi11(1,msg.r_sdata[0].curr_status,msg.r_sdata[0].fut);
            mutasi11_fut=msg.r_sdata[0].fut; 
        }
        else
        {
            $("#i_mutasi11_client_last_date").val('');
            $("#i_mutasi11_client_status").val('');
            $("#s_mutasi11_dstatus").html('');
            mutasi11_last_balance_close=0;          
            mutasi11_fut=0;
            mutasi11_ct=3;
            $("#i_mutasi11_dstatus").val('0');
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
        $("#s_mutasi11_dc").html('( D= '+strtomoney(c2)+' ) *** ( K= '+strtomoney(c1)+' )');
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
                $("#i_mutasi11_sel1").val(strtomoney(msg.r_sdata[i].balance_close_final-msg.r_sdata[i].balance_gs));;
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
                
                $("#i_mutasi11_remark2").val(msg.r_sdata[i].balance_remark);   
                $("#s_mutasi11_current_dt").html('Balance Date ' +msg.r_sdata[i].balance_date_s);
                mutasi11_last_balance=strtofloat(msg.r_sdata[i].balance_close_final);
                //alert(msg.r_sdata[i].balance_status);
                if(msg.r_sdata[i].balance_status==2)
                {
                    $("#i_mutasi11_gbal2").attr("readonly",true);
                    $("#i_mutasi11_remark2").attr("readonly",true);
                    $("#i_mutasi11_gbal2").val(strtomoney(msg.r_sdata[i].balance_gs));
                    $("#i_mutasi11_sel2").val(strtomoney(msg.r_sdata[i].balance_close_final-msg.r_sdata[i].balance_gs));
                    if(msg.r_sdata[i].balance_close_final-msg.r_sdata[i].balance_gs!=0)
                        $("#i_mutasi11_sel2").addClass("input_warning");
                    else
                        $("#i_mutasi11_sel2").removeClass("input_warning");
                }
                else
                {
                    $("#i_mutasi11_sel2").val(strtomoney(msg.r_sdata[i].balance_close_final));;
                    $("#i_mutasi11_gbal2").attr("readonly",false);
                    $("#i_mutasi11_remark2").attr("readonly",false);
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
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}

function add_trx_mutasi11()
{
    var ckp = mutasi11_last_balance - ($("#i_mutasi11_dc").val()=='D'?strtofloat($("#i_mutasi11_nominal").val()):strtofloat($("#i_mutasi11_nominal").val())*-1);
    if(ckp<0)
        if(confirm("Saldo tidak mencukupi, lanjutkan?"))
            ckp=0;
    if(do_mutasi11==0 && ckp>=0)
    {
        do_mutasi=1;
        var c_ccode = $("#i_mutasi11_client_code").val();
        var c_accno = $("#i_mutasi11_rek").val();
        var c_cdt = $("#i_mutasi11_client_dt").val();
        var c_cat = $("#i_mutasi11_coa").val();   //alert(c_cat);
        
        var c_cname=$("#i_mutasi11_client_name").val();
        var c_cdesc=$("#i_mutasi11_desc").val();
        var c_cnominal=$("#i_mutasi11_nominal").val();
        
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
            show_hide_add_mutasi11(1,mutasi11_curr_status,mutasi11_fut);
            do_mutasi11=0;
    
           /* if(c_cat=='D005' || c_cat=='C007' || c_cat=='D004' || c_cat=='C006')
            {
                fee_book_mutasi11(c_ccode,c_accno,c_cname,c_cdt,c_cat,$('#i_mutasi11_coa option:selected').html(),c_cdesc,c_cnominal);
            }*/
                
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11=0;state_progress(0);});
    }
}
function edit_trx_mutasi11()
{
    var ckp = mutasi11_last_balance - ($("#i_mutasi11_dc").val()=='D'?strtofloat($("#i_mutasi11_nominal").val()):strtofloat($("#i_mutasi11_nominal").val())*-1) - trx_edited_balance;
    if(ckp<0)
        if(confirm("Saldo tidak mencukupi, lanjutkan?"))
            ckp=0;
    if(do_mutasi11==0 && ckp>=0)
    {
        do_mutasi11=1;
        var c_ccode = $("#i_mutasi11_client_code").val();
        var c_accno = $("#i_mutasi11_rek").val();
        var c_cdt = $("#i_mutasi11_client_dt").val();
        
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/mutasi/edit_trx", {
            trx_id:$("#i_mutasi11_trx_id").val(),c_code:c_ccode,c_no:c_accno,c_dt:c_cdt,c_catcode:$("#i_mutasi11_coa").val(),
            c_catdesc:$("#i_mutasi11_coa option:selected").text(),c_desc:$("#i_mutasi11_desc").val(),
            c_dc:$("#i_mutasi11_dc").val(),c_nominal:$("#i_mutasi11_nominal").val()
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            list_trx_mutasi11(c_ccode,c_accno,c_cdt);
            get_balance_mutasi11(c_ccode,c_accno,c_cdt);
            show_hide_add_mutasi11(1,mutasi11_curr_status,mutasi11_fut);
            do_mutasi11=0;
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11=0;state_progress(0);});
    }
}
function del_trx_mutasi11()
{
    if(do_mutasi11==0)
    {
        do_mutasi11=1;
        var c_ccode = $("#i_mutasi11_client_code").val();
        var c_accno = $("#i_mutasi11_rek").val();
        var c_cdt = $("#i_mutasi11_client_dt").val();
        
        state_progress(1);
        //alert($("#i_mutasi11_trx_id").val());
        var obj_post = $.post(uri+"/index.php/mutasi/del_trx", {
                trx_id:$("#i_mutasi11_trx_id").val()
        },function(data) {
            //alert(data);
        },'json'); 
        obj_post.done(function(msg) { 
            state_progress(0);
            list_trx_mutasi11(c_ccode,c_accno,c_cdt);
            get_balance_mutasi11(c_ccode,c_accno,c_cdt);
            show_hide_add_mutasi11(1,mutasi11_curr_status,mutasi11_fut);
            do_mutasi11=0;
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11=0;state_progress(0);});
    }
}

function refresh_mutasi11()
{   
    reload_coa_mutasi11();
     
    //clear_balance_mutasi11();
    var c_code = $("#i_mutasi11_client_code").val();
    var c_acc = $("#i_mutasi11_rek").val();
    var c_dt = $("#i_mutasi11_client_dt").val();
    clear_balance_mutasi11();
    get_last_date_mutasi11(c_code,c_acc,c_dt);
    list_trx_mutasi11(c_code,c_acc,c_dt);
    get_balance_mutasi11(c_code,c_acc,c_dt);
    //show_hide_add_mutasi11(1);
    get_status_mutasi11(c_dt);
}

function show_hide_add_mutasi11(p_no, p_lock,pfut)
{
    if(p_no==1 && (p_lock==0 || p_lock==1 || pfut==1))
    {
		// Edit By MK
        $("#b_mutasi11_add").show();
        $("#b_mutasi11_edit").hide();
        $("#b_mutasi11_del").hide();
        $("#b_mutasi11_cancel").hide();
        //$("#i_mutasi11_desc").val('');
        //$("#i_mutasi11_nominal").val('');
        //$("#i_mutasi11_nominal_a").val('');
    }
    else if(p_no==2  && (p_lock==0 || p_lock==1  || pfut==1))
    {
        $("#b_mutasi11_add").hide();
        $("#b_mutasi11_edit").show();
        $("#b_mutasi11_del").show();
        $("#b_mutasi11_cancel").show();
    }
    else
    {
        $("#b_mutasi11_add").hide();
        $("#b_mutasi11_edit").hide();
        $("#b_mutasi11_del").hide();
        $("#b_mutasi11_cancel").hide();
        //$("#i_mutasi11_desc").val('');
        //$("#i_mutasi11_nominal").val('');
        //$("#i_mutasi11_nominal_a").val('');
    }
}
function create_mutasi11_event()
{
    $("#i_mutasi11_nominal").keyup(function(){
        $("#i_mutasi11_nominal_a").val(strtomoney($("#i_mutasi11_nominal").val()))
    });
    $("#i_mutasi11_client_dt").datepicker();
    $("#i_mutasi11_client_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
   
    $("#b_mutasi11_add").click(function(){
        trx_edited_balance=0;              
        if(mutasi11_curr_status==2)
            alert('Balance date already closed!');
        else if( (mutasi11_curr_status==3 || mutasi11_curr_status==4) && mutasi11_ct!=3 )
            alert('Balance date locked!');
        else if ($("#i_mutasi11_coa").val()=='C001')
            alert('Penambahan jasa giro melalui menu buat jasa giro');
        else if(confirm("Tambah mutasi?"))
            add_trx_mutasi11();
    });
    $("#i_mutasi11_client_dt").change(function(){
        clear_balance_mutasi11();
        var c_code = $("#i_mutasi11_client_code").val();
        var c_acc = $("#i_mutasi11_rek").val();
        var c_dt = this.value;                 
        get_last_date_mutasi11(c_code,c_acc,c_dt);
        list_trx_mutasi11(c_code,c_acc,c_dt);
        get_balance_mutasi11(c_code,c_acc,c_dt);
        //show_hide_add_mutasi11(1);
        get_status_mutasi11(c_dt); 
    });     
    $("#hbtn_mutasi11_close_day").click(function(){  
        var cont=false;
        if($("#i_mutasi11_rek").val()!=''&& (mutasi11_curr_status==1 || mutasi11_curr_status==3))
        {
            if(confirm("Proses akhir hari mutasi?"))
                if(calc_selisih_mutasi11()!=0)
                {
                    if(strtofloat($("#i_mutasi11_gbal2").val())==0)
                        alert("GS Balance harus di isi!");
                    else if(confirm('CLosing balance tidak sama dengan GS Balance, Continue?'))
                          cont =true;
                }else{
                    cont=true;
                }     
                    
        }
        else{
            alert("Hanya mutasi berstatus open yang bisa di close!");
        }
        
        if(cont)
        {
            var obj_post = $.post(uri+"/index.php/mutasi/get_client_id", {
                c_code: $("#i_mutasi11_client_code").val(),c_no:$("#i_mutasi11_rek").val()
            },function(data) {
                //alert(data);
            },"json"); 

            obj_post.done(function(msg) { 
                if(msg.r_num_rows>0){
                    close_day_mutasi11();
                }else{
                    alert("Tidak ada client dengan Kode "+$("#i_mutasi11_client_code").val()+" dan no rekening: "+$("#i_mutasi11_rek").val());
                }
                   
            });
            
            obj_post.fail(function(jqXHR, textStatus) {alert("Error mengecek client!");});
        }
            
    });
    $("#hbtn_mutasi11_cancel_close_day").click(function(){
        if($("#i_mutasi11_rek").val()!=''&&mutasi11_curr_status==2)
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
    $("#hbtn_mutasi11_open_day").click(function(){ 
        if($("#i_mutasi11_rek").val()!='')
        {
            if(mutasi11_curr_status==5 && mutasi11_ct!=3)
                alert('Silahkan close balance sebelumnya!');
            else if(mutasi11_curr_status!=0 && mutasi11_ct!=3)
                alert('Hanya mutasi yang belum open/close dan unlocked yang bisa open!');            
            else
            {
                var obj_post = $.post(uri+"/index.php/mutasi/get_client_id", {
                    c_code:$("#i_mutasi11_client_code").val(),c_no:$("#i_mutasi11_rek").val()
                },function(data) {
                    //alert(data);
                },"json"); 
                obj_post.done(function(msg) { 
                    if(msg.r_num_rows>0)
                        open_day_mutasi11();
                    else
                        alert("Tidak ada client dengan Kode "+$("#i_mutasi11_client_code").val()+" dan no rekening: "+$("#i_mutasi11_rek").val());
                });
                
                obj_post.fail(function(jqXHR, textStatus) {alert("Error mengecek client!");});
            }
        }
                
    });
    $("#hbtn_mutasi11_p_mutasi").click(function(){
        if($("#i_mutasi11_rek").val()!='') 
        {
            var obj_post = $.post(uri+"/index.php/mutasi/get_client_id", {
                c_code:$("#i_mutasi11_client_code").val(),c_no:$("#i_mutasi11_rek").val()
            },function(data) {
                //alert(data);
            },"json"); 
            obj_post.done(function(msg) { 
                if(msg.r_num_rows>0)
                    open_dlg_mutasi11_1($("#i_mutasi11_client_code").val(),$("#i_mutasi11_rek").val(),$("#i_mutasi11_client_dt").val());
                else
                    alert("Tidak ada client dengan Kode "+$("#i_mutasi11_client_code").val()+" dan no rekening: "+$("#i_mutasi11_rek").val());
            });
            
            obj_post.fail(function(jqXHR, textStatus) {alert("Error mengecek client!");});
        }       
        else
            alert('NO rekening belum dipilih');
    });
    $("#hbtn_mutasi11_p_jasgir").click(function(){
        if($("#i_mutasi11_rek").val()!='')
        {
            var gs_balace = Number( $('#i_mutasi11_gbal2').val() );
            if(gs_balace<100000000)
                alert('Last balance kurang dari 100jt!');
            else if (mutasi11_kena_jasgir!=1)
                alert('Client tidak terkena jasa giro!');
            //else if($("#i_mutasi11_status2").val()!='Closed')
              //  alert("Status belum closed");
            else
            {
                var obj_post = $.post(uri+"/index.php/mutasi/get_client_id", {
                    c_code:$("#i_mutasi11_client_code").val(),c_no:$("#i_mutasi11_rek").val()
                },function(data) {
                    //alert(data);
                },"json"); 
                obj_post.done(function(msg) { 
                    if(msg.r_num_rows>0)
                        
                        //parameter false/true untuk auto close dlg dan auto save jasa giro
                        open_dlg_mutasi11_2(
                            $("#i_mutasi11_client_code").val(),
                            $("#i_mutasi11_client_name").val(),
                            $("#i_mutasi11_rek").val(),
                            $("#i_mutasi11_client_dt").val(),
                            false
                        );
                    else
                        alert("Tidak ada client dengan Kode "+$("#i_mutasi11_client_code").val()+" dan no rekening: "+$("#i_mutasi11_rek").val());
                });
                
                obj_post.fail(function(jqXHR, textStatus) {alert("Error mengecek client!");});
            }
        }
        else
            alert('NO rekening belum dipilih');
    });
    $("#hbtn_mutasi11_c_jasgir").click(function(){
        open_dlg_mutasi11_4($("#i_mutasi11_client_code").val(),$("#i_mutasi11_client_name").val(),$("#i_mutasi11_rek").val(),$("#i_mutasi11_client_dt").val());
    });
    $("#hbtn_mutasi11_p_rekap").click(function(){
        open_dlg_mutasi11_3($("#i_mutasi11_client_code").val(),$("#i_mutasi11_rek").val(),$("#i_mutasi11_client_dt").val());
    });
    
    grid_mutasi11.onDblClick.subscribe(function(e) {     
        var selected_row_mutasi11  = grid_mutasi11.getActiveCell();
        if((mutasi11_curr_status==1 || mutasi11_curr_status==5 || (mutasi11_curr_status==3 && mutasi11_ct==3)|| (mutasi11_curr_status==0 && mutasi11_ct==2)) && data_mutasi11[selected_row_mutasi11.row].coa_no!='C001')
        {
            $("#i_mutasi11_trx_id").val(data_mutasi11[selected_row_mutasi11.row].trx_id);
            $("#i_mutasi11_client_dt").val(data_mutasi11[selected_row_mutasi11.row].trx_date);   
            $("#i_mutasi11_dc").val(data_mutasi11[selected_row_mutasi11.row].trx_dc);
            $("#i_mutasi11_coa").val(data_mutasi11[selected_row_mutasi11.row].coa_no);
            $("#i_mutasi11_desc").val(data_mutasi11[selected_row_mutasi11.row].trx_desc);
            $("#i_mutasi11_nominal").val(data_mutasi11[selected_row_mutasi11.row].trx_nominal_n);
            $("#i_mutasi11_nominal_a").val(data_mutasi11[selected_row_mutasi11.row].trx_nominal);
            trx_edited_balance=data_mutasi11[selected_row_mutasi11.row].trx_dc=='C'?strtofloat(data_mutasi11[selected_row_mutasi11.row].trx_nominal):strtofloat(data_mutasi11[selected_row_mutasi11.row].trx_nominal)*-1;
            show_hide_add_mutasi11(2,mutasi11_curr_status,mutasi11_fut);
        }
        
    });

    $("#b_mutasi11_cancel").click(function(){
        show_hide_add_mutasi11(1,mutasi11_curr_status,mutasi11_fut);
        trx_edited_balance=0;
    });
    
    $("#b_mutasi11_edit").click(function(){
         if(mutasi11_curr_status==2)
            alert('Balance date already closed!');
        else if( (mutasi11_curr_status==3 || mutasi11_curr_status==4) && mutasi11_ct!=3 )
            alert('Balance date locked!');
        else if(confirm("Ubah mutasi?"))
            edit_trx_mutasi11();
    });
    $("#b_mutasi11_del").click(function(){
         if(mutasi11_curr_status==2)
            alert('Balance date already closed!');
        else if( (mutasi11_curr_status==3 || mutasi11_curr_status==4) && mutasi11_ct!=3 )
            alert('Balance date locked!');
        else if(confirm("Hapus mutasi?"))
            del_trx_mutasi11();
    });
    $("#i_mutasi11_gbal2").keyup(function(){
        var a = calc_selisih_mutasi11();    
        if(a!=0)
            $("#i_mutasi11_sel2").addClass("input_warning");
        else
            $("#i_mutasi11_sel2").removeClass("input_warning");
        $("#i_mutasi11_sel2").val(strtomoney(a));
        $("#s_mutasi11_gbal2").html(strtomoney(this.value));
    });
    $("#i_mutasi11_coa").change(function(){
        $("#i_mutasi11_dc").val(this.value[0]);
    });
    $("#hbtn_mutasi11_open_day_all").click(function(){
        if($("#i_mutasi11_client_code").val()=='')
            alert('Pilih client!');
        else
        {
            if(confirm("Open This Day for client : " + $("#i_mutasi11_client_code").val() + "?\r\n (All available account for open)"))
            {
                open_day_all_mutasi11()
            }
        }
    });
}
function open_day_all_mutasi11()
{
    state_progress(1);    
    var c_ccode = $("#i_mutasi11_client_code").val();
    var obj_post = $.post(uri+"/index.php/mutasi/open_day_all", {c_code:c_ccode,c_name:$("#i_mutasi11_client_name").val()},
    function(data) {},"json"); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
            alert("Opened " + msg.r_sdata[0].co + " accounts of " + msg.r_sdata[0].c + " active accounts!");
        state_progress(0);
        refresh_mutasi11();
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function clear_balance_mutasi11()
{
    $("#s_mutasi11_last_dt").html('Previous Balance Date');
    $("#s_mutasi11_current_dt").html('Balance Date '+$("#i_mutasi11_client_dt").val()); 
    
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
    
    $("#i_mutasi11_c_by1").val('');
    $("#i_mutasi11_c_dt1").val('');
    $("#i_mutasi11_c_time1").val('');
    $("#i_mutasi11_c_by2").val('');
    $("#i_mutasi11_c_dt2").val('');
    $("#i_mutasi11_c_time2").val('');
}
function  calc_selisih_mutasi11()
{                                  
    return strtofloat($("#i_mutasi11_cbal2").val())-strtofloat($("#i_mutasi11_gbal2").val());
}
function close_day_mutasi11()
{                                  
    if(do_mutasi11_a==0)
    {
        do_mutasi_a=1;
        var c_ccode = $("#i_mutasi11_client_code").val();
        var c_accno = $("#i_mutasi11_rek").val();
        var c_cdt = $("#i_mutasi11_client_dt").val();
                   
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/mutasi/close_day", {
            c_code:c_ccode,c_no:c_accno,c_dt:c_cdt,gs_bal:strtofloat($("#i_mutasi11_gbal2").val()),c_rem:$("#i_mutasi11_remark2").val()
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
                        get_balance_mutasi11(c_ccode,c_accno,c_cdt);

                        // membuat jasa giro ketika akhir hari
                        var gs_balace = Number( $('#i_mutasi11_gbal2').val() );

                        if (mutasi11_kena_jasgir == 1 && gs_balace >= 100000000){
                            open_dlg_mutasi11_2(
                                $("#i_mutasi11_client_code").val(),
                                $("#i_mutasi11_client_name").val(),
                                $("#i_mutasi11_rek").val(),
                                $("#i_mutasi11_client_dt").val(),
                                true
                            );
                        }

                    }
                }
            } catch (e) {
                if(data.substr(0,4)=='SMTP')
                    alert("Error sending email, refreshing status!");
                state_progress(0);
                get_last_date_mutasi11(c_ccode,c_accno,c_cdt);
                get_balance_mutasi11(c_ccode,c_accno,c_cdt)
                // not json
            }
            /*do_mutasi11_a=0;
            state_progress(0);
            if(msg.r_num_rows>0)
            {   
                if(msg.r_sdata[0].success==1)
                {
                    alert('Action is succeded.');
                    get_last_date_mutasi11(c_ccode,c_accno);
                    get_balance_mutasi11(c_ccode,c_accno,c_cdt);
                }
            } */
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11_a=0;state_progress(0);});      
    }
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
                        //show_hide_add_mutasi11(1,$("#i_mutasi11_dstatus").val());                      
                    }
                }
            } catch (e) {
                if(data.substr(0,4)=='SMTP')
                    alert("Error sending email, refreshing status!");
                state_progress(0);
                get_last_date_mutasi11(c_ccode,c_accno,c_cdt);
                list_trx_mutasi11(c_ccode,c_accno,c_cdt);
                get_balance_mutasi11(c_ccode,c_accno,c_cdt);
                //show_hide_add_mutasi11(1,$("#i_mutasi11_dstatus").val());
                // not json
            }
        }); 
        
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11_a=0;state_progress(0);});      
    }
}
function open_day_mutasi11()
{
    if(do_mutasi11_a==0)
    {
        do_mutasi_a=1;
        var c_ccode = $("#i_mutasi11_client_code").val();
        var c_accno = $("#i_mutasi11_rek").val();
        var c_cdt = $("#i_mutasi11_client_dt").val();
                   
        state_progress(1);
        var obj_post = $.post(uri+"/index.php/mutasi/check_last_balance", {
            c_code:c_ccode,c_no:c_accno,c_dt:c_cdt
        },function(data) {
            
        },"json"); 
        obj_post.done(function(msg) { 
            do_mutasi11_a=0;
            state_progress(0);
            if(msg.r_num_rows>0)
            {
                if(msg.r_sdata[0].error==2)
                    alert('Status pada tanggal akhir balance belum close!');
                else if(msg.r_sdata[0].error==3)
                    alert('Tanggal lebih rendah atau sama dari tanggal akhir balance closed!');
                else if(msg.r_sdata[0].error==5)
                    alert('Tanggal akhir open balance belum closed!');
                else
                {                                  
                    if(confirm("Open new Day?") && do_mutasi11_a==0)
                    {
                        do_mutasi11_a=1;           
                        var obj_post1 = $.post(uri+"/index.php/mutasi/open_day", {
                            c_code:c_ccode,c_no:c_accno,c_dt:c_cdt,c_name:$("#i_mutasi11_client_name").val()
                            },function(data) {
                             
                            },"json"); 
                        obj_post1.done(function(msg1) { 
                            if(msg1.r_num_rows>0)
                            {
                                if(msg1.r_sdata[0].error==0)
                                    alert('Open Day Succeded');
                                else if(msg1.r_sdata[0].error==1)
                                    alert('Open Day Failed:: Already open/closed!');
                                else if(msg1.r_sdata[0].error==2 || msg1.r_sdata[0].error==3)
                                    alert('Open Day Failed:: Locked (<=last closed date || <current date).');
                                get_last_date_mutasi11(c_ccode,c_accno,c_cdt);
                                list_trx_mutasi11(c_ccode,c_accno,c_cdt);
                                get_balance_mutasi11(c_ccode,c_accno,c_cdt);
                                //show_hide_add_mutasi11(1);
                                do_mutasi11_a=0;
                            }
                        });
                        obj_post1.fail(function(jqXHR, textStatus) {do_mutasi11_a=0;state_progress(0);});      
                    }
                }                                                                   
            }
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_mutasi11_a=0;state_progress(0);});      
    }
}
function get_status_mutasi11(pc_dt)
{
    state_progress(1);        
    data_mutasi11.length=0;  
    var obj_post = $.post(uri+"/index.php/mutasi/get_rekening_mon", {c_dt:pc_dt},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
            $("#s_mutasi11_mon").html('Tanggal : '+$("#i_mutasi11_client_dt").val()+' , Status "Open": '+msg.r_sdata[0].c_open+' Rekening, Status "Closed": '+msg.r_sdata[0].c_close+' Rekening, <br />Balance status "Closed" dengan "Closing Balance">=Rp 100jt: '+msg.r_sdata[0].c_100jt+' Rekening <br />  Rekening yang dikenai Jasa Giro: '+msg.r_sdata[0].c_jasgir+' Rekening, Jasa giro yang telah dibuat: '+msg.r_sdata[0].c_giro+' Rekening');
        else
            $("#s_mutasi11_mon").html('Tanggal : '+$("#i_mutasi11_client_dt").val()+', Status "Open": 0 Rekening, Status "Closed": 0 Rekening, <br />Balance status "Closed" dengan "Closing Balance">=Rp 100jt: 0 Rekening <br />  Rekening yang dikenai Jasa Giro: 0 Rekening, Jasa giro yang telah dibuat: 0 Rekening');
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {     
        state_progress(0);}
    );
}

function fee_book_mutasi11(p_ccode,p_accno,p_cname,p_dt,p_cat,p_cat_desc,p_desc,p_nominal)
{                                                                                            
    open_dlg_mutasi11_bf_new(p_ccode,p_accno,p_cname,p_dt,p_cat,p_cat_desc,p_desc,p_nominal);
}

function dlg_mutasi_client() {
    $("#i_mutasi11_client_code").click(function () {        
        $("#dialogBox_mutasi_client_kode").dialog("open");
    });

    var mutClient = $.post(uri+"index.php/mutasi/mutasi_client",{},function(data) {
        $("#dialogBox_mutasi_client_kode").html(data);
    });

    mutClient.done(function () {
        var dpick_opt_mutasi22 = {
            cols : [
                {id:"client_code", name:"Code", field:"client_code",width:50}
                ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
                ,{id:"bank_name", name:"Bank Name", field:"bank_name",width:60}
                ,{id:"client_name", name:"Account Name", field:"client_name",width:180}
                ,{id:"kena_jasgir", name:"Jasgir", field:"kena_jasgir"}
            ],
            url: uri+"index.php/mutasi/mutasi_client_code",
            setval: function(obj_val){
                $("#i_mutasi11_client_code").val(trim(obj_val.client_code));
                $("#i_mutasi11_rek").val(obj_val.acc_no);
                $("#i_mutasi11_client_name").val(obj_val.client_name);
                $("#i_mutasi11_desc").val(obj_val.deskripsi);
                $("#i_mutasi11_nominal").val(obj_val.subsrd_nominal);
                $("#i_mutasi11_nominal_a").val(strtomoney($("#i_mutasi11_nominal").val()));

                mutasi11_kena_jasgir= obj_val.kena_jasgir;

                var c_dt=$("#i_mutasi11_client_dt").val();
                clear_balance_mutasi11();
                get_last_date_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
                get_balance_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt);
                reload_coa_mutasi11(obj_val.subsrd_kategori)
                list_trx_mutasi11(obj_val.client_code,obj_val.acc_no,c_dt)
                
                //====== set tabel pada pop up dialog agar kosong ======
                if(grid_mutasi_by_group !== undefined){
                    mutasi_by_group.length=0;
                    grid_mutasi_by_group.invalidateAllRows();
                    grid_mutasi_by_group.updateRowCount();
                    grid_mutasi_by_group.render();
                }
                if(grid_mutasi_detail !== undefined){
                    mutasi_detail.length=0;
                    grid_mutasi_detail.invalidateAllRows();
                    grid_mutasi_detail.updateRowCount();
                    grid_mutasi_detail.render();
                }

                //====== set data untuk pop up dialog =========
                $('#i_mutasi_kategori').find('option').remove();
                $('#i_mutasi_kategori').append('<option value="">Pilih Kategori</option>');

                $('#i_mutasi11_client_code2').val(obj_val.client_code);
                $('#i_mutasi11_rek2').val(obj_val.acc_no);

                $.post(uri+"index.php/mutasi/check_kategori",{
                    client_code : obj_val.client_code,
                    acc_no : obj_val.acc_no
                },function(data) {

                    var obj = JSON.parse(data);
                    for (let index = 0; index < obj.length; index++) {                            
                        if(obj[index].length !== 0 ){
                            $('#i_mutasi_kategori').append('<option value="'+obj[index].coa_no+'">'+obj[index].coa_desc+'</option>');
                        }
                    }
                    
                    $('#get_data_mutasi_by_group').click(function () {
                        list_trx_mutasi_by_group(
                            $('#i_mutasi11_client_code2').val(),
                            $('#i_mutasi11_rek2').val(),
                            $('#i_mutasi_kategori').val()
                        );                            
                    })
                    create_list_mutasi_by_group();
                    
                });
                //====== set data untuk pop up dialog =========
            }
        }
        dPicker_attach($("#i_mutasi11_client_code2"),dpick_opt_mutasi22);
    });
}

function create_dlg_mutasi_client_search()
{
    $("#dialogBox_mutasi_client_kode").dialog({ 
        title       : 'Klien',
        width       : 700,
        height      : 520,
        autoOpen    : false,
        resizable   : true,
        closeOnEsc  : true,
        modal       : true
    }).dialog("widget").draggable("option","containment","none");
}


function list_trx_mutasi_by_group(client_code,acc_no,coa_no)
{
    state_progress(1);
    mutasi_by_group.length=0;
    var obj_post = $.post(uri+"/index.php/mutasi/list_mutasi_by_group", {
        client_code: client_code,
        acc_no: acc_no,
        coa_no: coa_no
    },function(data) {
        
    },'json'); 

    obj_post.done(function(data) { 
        for (let index = 0; index < data.length; index++) {
            mutasi_by_group[index] = {
                'date'              : data[index].subsrd_date.date,
                'client_code'       : data[index].client_code,
                'acc_no'            : data[index].acc_no,
                'bank_name'         : data[index].bank_name,
                'subsrd_nominal'    : strtomoney(data[index].subsrd_nominal),
                'kena_jasgir'       : data[index].kena_jasgir,
                'subsrd_kategori'   : data[index].subsrd_kategori,
                'coa_desc'          : data[index].deskripsi,
                'client_name'       : data[index].client_name
            };
        }
        
        grid_mutasi_by_group.invalidateAllRows();
        grid_mutasi_by_group.updateRowCount();
        grid_mutasi_by_group.render();
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_mutasi_by_group.invalidateAllRows();
        grid_mutasi_by_group.updateRowCount();
        grid_mutasi_by_group.render();
        state_progress(0);}
    );    
    
}

function create_list_mutasi_by_group()
{
    var columns = [];
    var options = [] ; 
    columns = [         
        {id:"date", name:"Date", field:"date", width:75}
        ,{id:"client_code", name:"Code", field:"client_code",width:50}
        ,{id:"acc_no", name:"Account No", field:"acc_no",width:100}
        ,{id:"bank_name", name:"Bank Name", field:"bank_name"}
        ,{id:"client_name", name:"Account Name", field:"client_name",width:180}
        ,{id:"subsrd_nominal", name:"Nominal", field:"subsrd_nominal",width:100,cssClass:"cell_right"}
        ,{id:"kena_jasgir", name:"Jasgir", field:"kena_jasgir",cssClass:"cell_right"}
        ,{id:"coa_Id", name:"Coa Id", field:"subsrd_kategori",width:90}
        ,{id:"subsrd_kategori", name:"Kategori", field:"coa_desc",width:90}
    ];

    options = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         

    grid_mutasi_by_group = new Slick.Grid("#tbl_list_mutasi_by_group", mutasi_by_group, columns, options);
    grid_mutasi_by_group.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));        
    grid_mutasi_by_group.onDblClick.subscribe(function (e, args) {
        var rowSelected = args.grid.getActiveCell().row;
        var dataSelected = args.grid.getDataItem(rowSelected);

        $("#i_mutasi11_client_code").val(trim(dataSelected.client_code));
        $("#i_mutasi11_rek").val(dataSelected.acc_no);
        $("#i_mutasi11_client_name").val(dataSelected.client_name);
        $("#i_mutasi11_desc").val(dataSelected.deskripsi);
        $("#i_mutasi11_nominal").val(dataSelected.subsrd_nominal);
        $("#i_mutasi11_nominal_a").val(strtomoney($("#i_mutasi11_nominal").val()));

        mutasi11_kena_jasgir= dataSelected.kena_jasgir;

        var c_dt=$("#i_mutasi11_client_dt").val();
        clear_balance_mutasi11();
        get_last_date_mutasi11(dataSelected.client_code,dataSelected.acc_no,c_dt);
        get_balance_mutasi11(dataSelected.client_code,dataSelected.acc_no,c_dt);
        reload_coa_mutasi11(dataSelected.subsrd_kategori);
        
        list_trx_mutasi11(dataSelected.client_code,dataSelected.acc_no,c_dt);
        
        list_trx_mutasi_detail(dataSelected.client_code, dataSelected.acc_no, dataSelected.subsrd_kategori, dataSelected.date);
        create_list_mutasi_detail();
    });
}

function list_trx_mutasi_detail(client_code,acc_no,coa_no,date)
{
    state_progress(1);
    mutasi_detail.length=0;
    var obj_post = $.post(uri+"/index.php/mutasi/list_mutasi_detail", {
        client_code: client_code,
        acc_no: acc_no,
        coa_no: coa_no,
        date: date
    },function(data) {
               
    },'json'); 

    obj_post.done(function(data) { 
        
        for (let index = 0; index < data.length; index++) {
            mutasi_detail[index] = {
                'coa_id'         : data[index].subsrd_kategori,
                'coa_desc'       : data[index].coa_desc,
                'trx_desc'       : data[index].bank_name +' - '+data[index].coa_desc,
                'trx_dc'         : data[index].coa_dc,
                'trx_nominal_d'  : data[index].coa_dc=='D' ? strtomoney(data[index].subsrd_nominal):'',
                'trx_nominal_c'  : data[index].coa_dc=='C' ? strtomoney(data[index].subsrd_nominal):'',
                'create_dt'      : data[index].subsrd_date.date
            };
        }
        
        grid_mutasi_detail.invalidateAllRows();
        grid_mutasi_detail.updateRowCount();
        grid_mutasi_detail.render();
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_mutasi_detail.invalidateAllRows();
        grid_mutasi_detail.updateRowCount();
        grid_mutasi_detail.render();
        state_progress(0);}
    );    
    
}

function create_list_mutasi_detail() {
    var columns = [];
    var options = [] ; 
    columns = [         
        {id:"coa_id", name:"Coa ID", field:"coa_id",width:50}
        ,{id:"coa_desc", name:"Kategori", field:"coa_desc",width:140}
        ,{id:"trx_desc", name:"Description", field:"trx_desc",width:140}
        ,{id:"trx_dc", name:"D/C", field:"trx_dc",width:50,cssClass:"cell_center"}
        ,{id:"trx_nominal_d", name:"Debet", field:"trx_nominal_d",width:100,cssClass:"cell_right"}
        ,{id:"trx_nominal_c", name:"Kredit", field:"trx_nominal_c",width:100,cssClass:"cell_right"}
        ,{id:"create_dt", name:"Created", field:"create_dt",width:100,cssClass:"cell_right"}
    ];

    options = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         

    grid_mutasi_detail = new Slick.Grid("#tbl_list_mutasi_detail", mutasi_detail, columns, options);
    grid_mutasi_detail.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));        
    grid_mutasi_detail.onDblClick.subscribe(function (e, args) {
        var rowSelected = args.grid.getActiveCell().row;
        var dataSelected = args.grid.getDataItem(rowSelected);
        var balance_status = $("#s_mutasi11_dstatus").html();
        if(balance_status !== 'Open'){
            alert('Status Bukan Open');
        }else{
            setMutasiTRx(
                dataSelected.coa_id,
                $("#i_mutasi11_client_code").val(),
                dataSelected.create_dt,
                $("#i_mutasi11_rek").val(),
                $("#i_mutasi11_client_dt").val()
            );
        }
        
    });
}