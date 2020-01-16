var grid_subsrd;
var data_subsrd = [];

var subsrd_edited_trx=0;
var subsrd_id=0;
//var do_subsrd=0;
//var do_subsrd_a=0;
//var data_subsrd_param = [];


function initiate_subsrd()
{
    add_section("content_subsrd","data_subsrd","refresh_subsrd()","hbtn_subsrd","grid_subsrd");
    get_content_subsrd();
}
function get_content_subsrd()
{             
    var obj_post = $.post(uri_subsrd_dlg,{},function(data) {
        $("#content_subsrd").html(data);
    });
    obj_post.done(function(msg) { 
        create_subsrd_grid(); 
        create_dpicker_subsrd();
        create_subsrd_event();
        subsrd_dlg1_create();
        $("#i_subsrd_client_dt").val(saiki);
        //get_content_user_subsrd();
    });
}
function create_subsrd_grid()
{
    var columns_subsrd = [];
    var options_subsrd = [] ; 
    columns_subsrd = [         
        {id:"sa_name", name:"Selling Agent", field:"sa_name",width:120}
        ,{id:"subsrd_nominal_a", name:"Jumlah", field:"subsrd_nominal_a",width:140,cssClass:"cell_right"}
        ,{id:"subsrd_desc", name:"Keterangan", field:"subsrd_desc",width:200}
        ,{id:"bank_src", name:"Source Bank", field:"bank_src",width:80}
        ,{id:"acc_src", name:"Source Account", field:"acc_src",width:200}
        ,{id:"bank_dst", name:"Dest Bank", field:"bank_dst",width:80}
        ,{id:"acc_dst", name:"Dest Account", field:"acc_dst",width:200}
        ,{id:"modified_dt", name:"Modified", field:"modified_dt",width:110}
        ,{id:"modified_by", name:"Modified By", field:"modified_by",width:100}
    ];
    options_subsrd = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subsrd = new Slick.Grid("#tbl_slick_subsrd", data_subsrd, columns_subsrd, options_subsrd);
    grid_subsrd.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function create_dpicker_subsrd()
{                      
    var dpick_opt_subsrd ={
        cols : [         
                    {id:"client_code", name:"Code", field:"client_code",width:100}
                   ,{id:"client_name", name:"Account Name", field:"client_name",width:380}
                   ,{id:"mi_code", name:"MI", field:"mi_code"}
            ],
        url: uri_subsrd+"list_client_by_code",
        setval: function(obj_val){                      
            $("#i_subsrd_client_code").val(trim(obj_val.client_code));
            $("#i_subsrd_client_code_h").val(trim(obj_val.client_code));
            $("#i_subsrd_client_name").val(obj_val.client_name);
            subsrd_get_status(trim(obj_val.client_code));      
            list_subsrd(trim(obj_val.client_code),$("#i_subsrd_client_dt").val()); 
            list_subsrd_rekap(trim(obj_val.client_code),$("#i_subsrd_client_dt").val());   
            
            reload_subsrd_sa(trim(obj_val.client_code));
            show_hide_add_subsrd();
            
        }
    }; 
    dPicker_attach($("#i_subsrd_client_code"),dpick_opt_subsrd);        
}
function reload_subsrd_sa(p_code)
{

    var obj_post = $.post(uri_subsrd+"list_sa", {b_code:p_code   },function(data) {
     
    },'json'); 
    obj_post.done(function(msg) { 
        var htm='';           
        for (var i=0; i<msg.r_num_rows; i++) {
            htm = htm + "<option value='"+msg.r_sdata[i].sa_id+"'>"+msg.r_sdata[i].sa_name+"</option>"
        }                            
        $("#i_subsrd_sa_code").html(htm);
        var htm_sa='';
        if(msg.r_num_rows>0)
            htm_sa=msg.r_sdata[0].sa_id;
        setTimeout(function() { 
            get_acc_subsrd($("#i_subsrd_client_code_h").val(),htm_sa,'0');
        },1);

    });
    
}

function get_acc_subsrd(p_code,p_sacode,p_select)
{                        
    var obj_post5 = $.post(uri_subsrd_acc+"list_acc_by_client_sa",{q:p_sacode,par1:p_code,par2:p_select},
    function(data5) { //alert(data5);
    },'json');
    obj_post5.done(function(msg5) {      //alert(msg.r_num_rows);
        var txt_acc='';                
        var txt_acc1='';
        var s_selected='';
        for (var i=0; i<msg5.r_num_rows; i++)
        {            
            if(p_select==msg5.r_sdata[i].acc_id)
                s_selected='selected';
            if(msg5.r_sdata[i].acc_type==1)
                txt_acc=txt_acc+'<option value="'+msg5.r_sdata[i].acc_id+'" '+s_selected+'>'+msg5.r_sdata[i].acc_no+' ('+msg5.r_sdata[i].type_desc+')</option>';
            else
                txt_acc1=txt_acc1+'<option value="'+msg5.r_sdata[i].acc_id+'" '+s_selected+'>'+msg5.r_sdata[i].acc_no+' ('+msg5.r_sdata[i].type_desc+')</option>';
        }   
                        // alert(txt_acc);
        if(msg5.r_num_rows>0)
            $("#i_subsrd_bank_code_h").val(msg5.r_sdata[0].bank_code);
        $("#i_subsrd_acc_src").html(txt_acc);       
        $("#i_subsrd_acc_dest").html(txt_acc1); 
        setTimeout(function() { 
            
        },1);
    });
}
function subsrd_get_status(pc_code)
{                            
    state_progress(1);
    var obj_post = $.post(uri_subsrd+"get_status", {c_code:pc_code},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
        {
            $("#i_subsrd_client_last_date").val(msg.r_sdata[0].subsrd_date_s);
            $("#i_subsrd_client_closed_date").val(msg.r_sdata[0].last_closed_s);
            $("#i_subsrd_client_status").val(msg.r_sdata[0].subsrd_status==1?'Closed':'Open');
            
            setTimeout(function() {  
                show_hide_add_subsrd(1);
            },1);            
        }
        else
        {
            $("#i_subsrd_client_last_date").val('');
            $("#i_subsrd_client_status").val('');   
            $("#i_subsrd_client_closed_date").val('');
        }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function list_subsrd(pc_code,pc_dt)
{                               
    state_progress(1);
    data_subsrd.length=0;   
    var obj_post = $.post(uri_subsrd+"list_data", {c_code:pc_code,c_dt:pc_dt},function(data) {
      //  alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        var c1=0;
        var c2=0;
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrd[i] = {});        
            d["subsrd_id"] = msg.r_sdata[i].subsrd_id; 
            d["sa_id"] = msg.r_sdata[i].sa_id; 
            d["sa_name"] = msg.r_sdata[i].sa_name; 
            d["subsrd_nominal_a"] = strtomoney(msg.r_sdata[i].subsrd_nominal);
            d["subsrd_nominal"] = msg.r_sdata[i].subsrd_nominal;
            d["subsrd_desc"] = msg.r_sdata[i].subsrd_desc;
            d["acc_src"] = msg.r_sdata[i].acc_no_src + '('+msg.r_sdata[i].type_desc_src+')';
            d["acc_dst"] = msg.r_sdata[i].acc_no_dst + '('+msg.r_sdata[i].type_desc_dst+')';
            d["acc_src_id"] = msg.r_sdata[i].acc_no_src;
            d["acc_dst_id"] = msg.r_sdata[i].acc_no_dst;
            d["bank_src"] = msg.r_sdata[i].bank_src; 
            d["bank_dst"] = msg.r_sdata[i].bank_dst;             
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
        }
        
        grid_subsrd.invalidateAllRows();
        grid_subsrd.updateRowCount();
        grid_subsrd.render();
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrd.invalidateAllRows();
        grid_subsrd.updateRowCount();
        grid_subsrd.render();
        state_progress(0);}
    );
}
function list_subsrd_rekap(pc_code,pc_dt)    
{                         
    var obj_post = $.post(uri_subsrd+"view_rekap_data",{c_code:pc_code,c_dt:pc_dt},function(data) {
        $("#subsrd_rekap").html(data);  
    });
}
function subsrd_add()
{                         
    if($("#i_subsrd_client_last_date").val()!=$("#i_subsrd_client_dt").val())              
    {
        alert('Tanggal Transaksi belum di open!');
        return 1;
    }                               
    if($("#i_subsrd_acc_src").val()==$("#i_subsrd_acc_dest").val())              
    {
        alert('Source account same as Destination account!');
        return 1;
    }
	//edit By MK 
    state_progress(1);    
    var obj_post = $.post(uri_subsrd+"add_subsrd", {
        c_code:$("#i_subsrd_client_code_h").val(),
        c_dt:$("#i_subsrd_client_dt").val(),
        c_said:$("#i_subsrd_sa_code").val(),
        c_accsrc:$("#i_subsrd_acc_src").val(),
        c_accdst:$("#i_subsrd_acc_dest").val(),
        c_desc:$("#i_subsrd_desc").val(),
        //c_kat:$("#i_subsrd_kat").val(),
        c_nominal:$("#i_subsrd_nominal").val()
    },function(data) {//alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
            if(msg.r_sdata[0].err==0)
            {
                list_subsrd($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val()) ;
                list_subsrd_rekap($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val()) ;
                show_hide_add_subsrd(1);   
            }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function subsrd_edit()
{                         
    if($("#i_subsrd_client_last_date").val()!=$("#i_subsrd_client_dt").val())              
    {
        alert('Tanggal Transaksi belum di open!');
        return 1;
    } 
	//edit By MK 
    state_progress(1);    
    var obj_post = $.post(uri_subsrd+"edit_subsrd", {
        c_id:subsrd_id,
        c_said:$("#i_subsrd_sa_code").val(),
        c_accsrc:$("#i_subsrd_acc_src").val(),
        c_accdst:$("#i_subsrd_acc_dest").val(),
        c_desc:$("#i_subsrd_desc").val(),
		//c_kat:$("#i_subsrd_kat").val(),
        c_nominal:$("#i_subsrd_nominal").val()
    },function(data) {},"json"); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
            if(msg.r_sdata[0].err==0)
            {
                list_subsrd($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val()) ;
                list_subsrd_rekap($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val()) ;
                show_hide_add_subsrd(1);   
            }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function subsrd_del()
{                         
    if($("#i_subsrd_client_last_date").val()!=$("#i_subsrd_client_dt").val())              
    {
        alert('Tanggal Transaksi belum di open!');
        return 1;
    }           
    state_progress(1);    
    var obj_post = $.post(uri_subsrd+"del_subsrd", {
        c_id:subsrd_id
    },function(data) {},"json"); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
            if(msg.r_sdata[0].err==0)
            {
                list_subsrd($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val()) ;
                list_subsrd_rekap($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val()) ;
                show_hide_add_subsrd(1);   
            }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function show_hide_add_subsrd(p_no)
{ 
    if(p_no==1 && $("#i_subsrd_client_status").val()=='Open' && $("#i_subsrd_client_last_date").val()==$("#i_subsrd_client_dt").val())
    { 
        $("#b_subsrd_add").show();
        $("#b_subsrd_edit").hide();
        $("#b_subsrd_del").hide();
        $("#b_subsrd_cancel").hide();
        $("#i_subsrd_desc").val('Subscription');
        //$("#i_subsrd_kat").val('Subscription');
        $("#i_subsrd_nominal").val('');
        $("#i_subsrd_nominal_a").val('');
    }
    else if(p_no==2 && $("#i_subsrd_client_status").val()=='Open' && $("#i_subsrd_client_last_date").val()==$("#i_subsrd_client_dt").val())
    {
        $("#b_subsrd_add").hide();
        $("#b_subsrd_edit").show();
        $("#b_subsrd_del").show();
        $("#b_subsrd_cancel").show();
    }
    else
    {
        $("#b_subsrd_add").hide();
        $("#b_subsrd_edit").hide();
        $("#b_subsrd_del").hide();
        $("#b_subsrd_cancel").hide();
        $("#i_subsrd_desc").val('');
        //$("#i_subsrd_kat").val('');
        $("#i_subsrd_nominal").val('');
        $("#i_subsrd_nominal_a").val('');
    }
    
}
function refresh_subsrd()
{   
    reload_subsrd_sa($("#i_subsrd_client_code_h").val());
    list_subsrd($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val());
    list_subsrd_rekap($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val());
    show_hide_add_subsrd(1);
}
function create_subsrd_event()
{
    $("#i_subsrd_nominal").keyup(function(){
        $("#i_subsrd_nominal_a").val(strtomoney($("#i_subsrd_nominal").val()))
    });
    $("#i_subsrd_client_dt").datepicker();
    $("#i_subsrd_client_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
   
    $("#hbtn_subsrd_open_day").click(function(){
        if($("#i_subsrd_client_code_h").val()!='')
        {
            if(confirm('Open the day for '+$("#i_subsrd_client_code_h").val()+ ' on ' + $("#i_subsrd_client_dt").val() +'?'))
            {            
                var obj_post = $.post(uri_subsrd+"open_day", {
                    c_code:$("#i_subsrd_client_code_h").val(),
                    c_dt:$("#i_subsrd_client_dt").val()
                },function(data) {
                    //alert(data);
                },"json"); 
                obj_post.done(function(msg) { 
                    if(msg.r_num_rows>0)
                        if(msg.r_sdata[0].err==0)
                        {
                            alert('Open day success!');
                            subsrd_get_status($("#i_subsrd_client_code_h").val());      
                            list_subsrd($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val());
                        }
                        else
                            alert('Open day error!');
                });
                
                obj_post.fail(function(jqXHR, textStatus) {alert('error open the day!');});
            }
        }
                
    });           
    
    $("#hbtn_subsrd_close_day").click(function(){   
        if($("#i_subsrd_client_code_h").val()=='' || $("#i_subsrd_client_last_date").val()!=$("#i_subsrd_client_dt").val()  || $("#i_subsrd_client_status").val()!='Open' )
        {
            alert("Tanggal belum di open!");
        }
        else
        {
            if(confirm('Close the day for '+$("#i_subsrd_client_code_h").val()+ ' on ' + $("#i_subsrd_client_dt").val() +'?'))
            {                    
                var obj_post = $.post(uri_subsrd+"close_day", {
                    c_code:$("#i_subsrd_client_code_h").val(),
                    c_dt:$("#i_subsrd_client_dt").val()
                },function(data) {
                    
                },'json'); 
                obj_post.done(function(msg) {                     
                    if(msg.r_num_rows>0) 
                        if(msg.r_sdata[0].err==0)
                        {
                            alert('Close day success!');
                            subsrd_get_status($("#i_subsrd_client_code_h").val());
                            subsrdToMutasi();
                        }
                        else
                            alert('Close day error!');
                });
                
                obj_post.fail(function(jqXHR, textStatus) {alert('error open the day!');});
            }
        }
                
    });
   
    $("#b_subsrd_add").click(function(){     
        if($("#i_subsrd_acc_src").val()==null || $("#i_subsrd_acc_dest").val()==null)
        {
            alert('No source or destination account defined!');
            return 1;
        }
        subsrd_edited_trx=0;              
        if($("#i_subsrd_client_status").val()=='Closed')
            alert('Current date already closed!');
        else if($("#i_subsrd_client_status").val()!='Open')
            alert('Current status of date must be open!');
        else if(confirm("Tambah mutasi?"))
            subsrd_add();
    });
    $("#i_subsrd_client_dt").change(function(){
        list_subsrd($("#i_subsrd_client_code_h").val(),this.value);
        list_subsrd_rekap($("#i_subsrd_client_code_h").val(),this.value);
        show_hide_add_subsrd(1);
    }); 
    grid_subsrd.onDblClick.subscribe(function(e) {     
        if($("#i_subsrd_client_status").val()=='Open')
        {                                 
            var selected_row_subsrd  = grid_subsrd.getActiveCell();      
            subsrd_id=data_subsrd[selected_row_subsrd.row].subsrd_id;   
            $("#i_subsrd_sa_code").val(data_subsrd[selected_row_subsrd.row].sa_id);
            $("#i_subsrd_desc").val(data_subsrd[selected_row_subsrd.row].subsrd_desc);
            //$("#i_subsrd_kat").val(data_subsrd[selected_row_subsrd.row].subsrd_kat);
            $("#i_subsrd_nominal").val(data_subsrd[selected_row_subsrd.row].subsrd_nominal);      
            $("#i_subsrd_nominal_a").val(strtomoney(data_subsrd[selected_row_subsrd.row].subsrd_nominal));
            show_hide_add_subsrd(2);
            get_acc_subsrd($("#i_subsrd_client_code_h").val(),data_subsrd[selected_row_subsrd.row].sa_id,0);
        }
    });
    $("#b_subsrd_cancel").click(function(){
        show_hide_add_subsrd(1);
        subsrd_edited_trx=0;
        subsrd_id=0;
    });
    $("#b_subsrd_edit").click(function(){
        subsrd_edited_trx=1;              
        if($("#i_subsrd_client_status").val()=='Closed')
            alert('Current date already closed!');
        else if($("#i_subsrd_client_status").val()!='Open')
            alert('Current status of date must be open!');
        else if(confirm("Ubah subscription?"))
            subsrd_edit();
    });
    $("#b_subsrd_del").click(function(){
       if($("#i_subsrd_client_status").val()=='Closed')
            alert('Current date already closed!');
        else if($("#i_subsrd_client_status").val()!='Open')
            alert('Current status of date must be open!');
        else if(confirm("Hapus subscription?"))
            subsrd_del();
    });
    $("#hbtn_subsrd_cancel_close_day").click(function(){
        if($("#i_subsrd_client_code_h").val()!=''&& $("#i_subsrd_client_status").val()=='Closed')
        {
            if(confirm("Status akhir hari mutasi di batalkan?"))
            {
                var obj_post = $.post(uri_subsrd+"cancel_close_day", {
                    c_code:$("#i_subsrd_client_code_h").val(),
                    c_dt:$("#i_subsrd_client_dt").val()
                },function(data) {
                    //alert(data);
                },"json"); 
                obj_post.done(function(msg) { 
                   if(msg.r_num_rows>0)
                   {
                        if(msg.r_sdata[0].err==0)
                        {
                            alert('Cancel Close day success!');
                            subsrd_get_status($("#i_subsrd_client_code_h").val());      
                        }
                        else
                            alert('Cancel Close day error!');
                   }
                   else
                        alert('Cancel Close day error!');
                });
                
                obj_post.fail(function(jqXHR, textStatus) {alert("Error mengecek client!");});
            }
        }
        else
            alert("Hanya subscription berstatus close yang bisa cancel!");
        
    });
    $("#hbtn_subsrd_print").click(function(){     
        subsrd_dlg1_open();
    });
}

function get_content_subsrd_dlg1()
{                                         
    var obj_post = $.post(uri_subsrd+'v_dlg1',{},function(data) {
    });
    obj_post.done(function(msg) {        
        $("#dialogBox_subsrd_dlg1").html(msg);
        setTimeout(function() {    
            $("#dlgSubsrd_bal_dt").datepicker();
            $("#dlgSubsrd_bal_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
            $("#dlgSubsrd_print_dt").datepicker();
            $("#dlgSubsrd_print_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
            $("#dlgSubsrd_print_dt").val(saiki);
        },1);        
    });
}
function get_bank_subsrd_dlg1(p_code)
{                              
    var obj_post = $.post(uri_subsrd+'get_bank_by_client',{c_code:p_code},function(data) {
        
    },'json');
    obj_post.done(function(msg) {       
        var txt_sel='<option value="">ALL</option>'  ;
        for(var i=0;i<msg.r_num_rows;i++)
            txt_sel+='<option value="'+msg.r_sdata[i].bank_code+'">'+msg.r_sdata[i].bank_name+'</option>';
        $("#dlgSubsrd_bank").html(txt_sel);
    });
}


function subsrd_dlg1_create()
{
    get_content_subsrd_dlg1();
    $("#dialogBox_subsrd_dlg1").dialog({ 
            title:        'Print instruksi ke Cash Payment'
        ,    width:        400
        ,    height:        180
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Cetak": function(){do_check_print_instruksi();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function subsrd_dlg1_open()
{
    if($("#i_subsrd_client_code_h").val()!='')
    {
        get_bank_subsrd_dlg1($("#i_subsrd_client_code_h").val());
        $("#dlgSubsrd_client_code_h").val($("#i_subsrd_client_code_h").val());
        $("#dlgSubsrd_bal_dt").val($("#i_subsrd_client_dt").val());
        $("#dlgSubsrd_client_code_s").html($("#i_subsrd_client_code_h").val());
        $("#dlgSubsrd_client_name_s").html($("#i_subsrd_client_name").val());
        $("#dialogBox_subsrd_dlg1").dialog("open");
    }
    else
        alert("Choose the client first!");
}
function do_check_print_instruksi()
{                                     
    var obj_post = $.post(uri_subsrd+"get_balance_status", {
        c_code:$("#dlgSubsrd_client_code_h").val(),
        c_dt:$("#dlgSubsrd_bal_dt").val()
        
    },function(data) { },"json"); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
        {
            if(msg.r_sdata[0].subsrd_status==1)
            {
                //loadPrintDocument(uri_subsrd+'print_instruksi_cs/'+$("#dlgSubsrd_client_code_h").val()+'/'+$("#dlgSubsrd_bal_dt").val()+'/'+$("#dlgSubsrd_print_dt").val()+'/'+$("#dlgSubsrd_bank").val());
                //window.open(uri_subsrd+'print_instruksi_cs/'+$("#dlgSubsrd_client_code_h").val()+'/'+$("#dlgSubsrd_bal_dt").val()+'/'+$("#dlgSubsrd_print_dt").val()+'/'+$("#dlgSubsrd_bank").val());
                loadPrintDocument(uri_subsrd+'print_instruksi_cs/'+$("#dlgSubsrd_client_code_h").val()+'/'+$("#dlgSubsrd_bal_dt").val()+'/'+$("#dlgSubsrd_print_dt").val()+'/'+$("#dlgSubsrd_bank").val());
                //do_print_instruksi();
            }
            else
            alert('Balance status must be closed!');
        }
        else
            alert('Balance status must be closed!');
    });
                                                                    
}
function do_print_instruksi()
{
    
    //$("#frm_subsrd_instruksi_cs").submit();
}

function subsrdToMutasi() {

    var coa_id = 'C002';
    var date = $('#i_subsrd_client_dt').val();
    var acc_no = $('#i_subsrd_acc_dest').val();
    var client_code = $('#i_subsrd_client_code').val();

    $.post(uri+"index.php/subsrd/set_mutasi_trx",{
        coa_id:coa_id,
        client_code:client_code,
        date:date,
        acc_no:acc_no
    }, function(data, status) {
        alert(data.msg);
    });
    
}