var subsrd_acc_id=0;
var grid_subsrd_acc;
var data_subsrd_acc = [];

var do_subsrd_acc=0;

function get_content_subsrd_acc_dlg()
{                                         
    var obj_post = $.post(uri_subsrd_acc_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {        
        $("#dialogBox_subsrd_acc_dlg").html(msg);
        setTimeout(function() {    
            //create_dlg_dpicker_subsrd_acc();
                
        },1);        
    });
}
function get_client_subsrd_acc_dlg(p_code)
{                                      
    var obj_post = $.post(uri_subsrd_client+"list_client",{c_enable:1},function(data) {
    },'json');
    obj_post.done(function(msg) {      //alert(msg.r_num_rows);
        var txt_acc='';
        for (var i=0; i<msg.r_num_rows; i++)
            txt_acc=txt_acc+'<option value="'+msg.r_sdata[i].client_code+'">'+msg.r_sdata[i].client_code+' - '+msg.r_sdata[i].client_name+'</option>';
        
        $("#dlgSubsrdAccClient_code").html(txt_acc);       
        setTimeout(function() {  
            if(msg.r_num_rows>0)
                get_sa_subsrd_acc_dlg(msg.r_sdata[0].client_code,0);
        },1); 
    });
}
function get_type_subsrd_acc_dlg(p_code)
{                                      
    var obj_post = $.post(uri_subsrd_acc+"list_type",{},function(data) {
    },'json');
    obj_post.done(function(msg) {      //alert(msg.r_num_rows);
        var txt_acc='';
        for (var i=0; i<msg.r_num_rows; i++)
            txt_acc=txt_acc+'<option value="'+msg.r_sdata[i].type_id+'">'+msg.r_sdata[i].type_desc+'</option>';
        
        $("#dlgSubsrdAcc_type").html(txt_acc);  
        setTimeout(function() {  
            set_subsrd_acc_par($("#dlgSubsrdAcc_type").val());
        },1); 
        
    });
}
function get_sa_subsrd_acc_dlg(p_code,p_said)
{   
    var obj_post = $.post(uri_subsrd_sa+"list_sa_by_client",{c_enable:1,q:p_code},function(data) {
    },'json');
    obj_post.done(function(msg) {      //alert(msg.r_num_rows);
        var txt_acc='';
        for (var i=0; i<msg.r_num_rows; i++) 
            if(msg.r_sdata[i].sa_id==p_said)
                txt_acc=txt_acc+'<option value="'+msg.r_sdata[i].sa_id+'" selected>'+msg.r_sdata[i].sa_name+'</option>';
            else
                txt_acc=txt_acc+'<option value="'+msg.r_sdata[i].sa_id+'">'+msg.r_sdata[i].sa_name+'</option>';
        
        $("#dlgSubsrdAccSa_id").html(txt_acc);       
    });
}
function get_bank_subsrd_acc_dlg(p_code)
{                                      
    var obj_post = $.post(uri_subsrd_bank+"list_bank",{c_enable:1},function(data) {
    },'json');
    obj_post.done(function(msg) {      //alert(msg.r_num_rows);
        var txt_acc='';
        for (var i=0; i<msg.r_num_rows; i++)
            txt_acc=txt_acc+'<option value="'+msg.r_sdata[i].bank_code+'">'+msg.r_sdata[i].bank_name+'</option>';
        
        $("#dlgSubsrdAccBank_code").html(txt_acc);       
    });
}


function create_dlg_subsrd_acc()
{
    get_content_subsrd_acc_dlg();
    $("#dialogBox_subsrd_acc_dlg").dialog({ 
            title:        'Subscription Reksadana - Account'
        ,    width:        620
        ,    height:        390
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_subsrd_acc();},
             "Ubah": function(){do_edit_subsrd_acc();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function initiate_subsrd_acc()
{
    add_section("tbl_slick_subsrd_acc","data_subsrd_acc","refresh_subsrd_acc()","hbtn_subsrd_acc","grid_subsrd_acc");
    create_subsrd_acc_grid(); 
    create_subsrd_acc_event();     
    create_dlg_subsrd_acc();       

}    
function create_subsrd_acc_grid()
{
    var columns_subsrd_acc = [];
    var options_subsrd_acc = [] ; 
    columns_subsrd_acc = [
        {id:"mi_code", name:"MI", field:"mi_code",width:70}
        ,{id:"client_code", name:"Kode Client", field:"client_code",width:80}
        ,{id:"sa_name", name:"Nama Selling Agent", field:"sa_name",width:130}
        ,{id:"acc_no", name:"Acc No", field:"acc_no",width:150}
        ,{id:"acc_name", name:"Acc Name", field:"acc_name",width:150}
        ,{id:"bank_name", name:"Bank Name", field:"bank_name",width:160}
        ,{id:"type_desc", name:"Acc Type", field:"type_desc",width:140}
        ,{id:"acc_enable", name:"Enable", field:"acc_enable",width:80}
        ,{id:"ref_to", name:"Ref to", field:"ref_to",width:140}
        ,{id:"ref_up", name:"Ref up", field:"ref_up",width:140}
        ,{id:"ref_telp", name:"Ref telp", field:"ref_telp",width:140}
        ,{id:"ref_fax", name:"Ref fax", field:"ref_fax",width:140}
        ,{id:"modified_by", name:"Modified by", field:"modified_by",width:80}
        ,{id:"modified_dt", name:"Modified dt", field:"modified_dt",width:90}
    ];
    options_subsrd_acc = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subsrd_acc = new Slick.Grid("#tbl_slick_subsrd_acc", data_subsrd_acc, columns_subsrd_acc, options_subsrd_acc);
    grid_subsrd_acc.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}
/*function create_dlg_dpicker_subsrd_acc()
{                           
    var dpick_opt_subsrd_acc ={
        cols : [         
                    {id:"mi_code", name:"MI", field:"mi_code",width:100}
                   ,{id:"bank_name", name:"Bank Name", field:"bank_name",width:120}
                   ,{id:"sa_name", name:"Selling Agent", field:"sa_name",width:380}
                   ,{id:"bank_code", name:"Bank Code", field:"bank_code",width:1}
                   ,{id:"sa_id", name:"SA ID", field:"sa_id",width:1}
            ],
        url: uri_subsrd_sa+"list_sa_by_name",
        setval: function(obj_val){               
            $("#dlgSubsrdAccSa_name").val(trim(obj_val.sa_name)); 
            $("#dlgSubsrdAccSa_id").val(obj_val.sa_id);     
            $("#dlgSubsrdAccBank_code").val(obj_val.bank_code);    
            $("#dlgSubsrdAccBank_name").val(obj_val.bank_name);  
        }
    };                    
    dPicker_attach($("#dlgSubsrdAccSa_name"),dpick_opt_subsrd_acc);    
} */

function open_dlg_subsrd_acc(c_id)
{                                                       
    $($("button", $("#dialogBox_subsrd_acc_dlg").parent())[1]).hide();
    //$($("button", $("#dialogBox_subsrd_acc_dlg").parent())[3]).hide();
    
   clear_dlg_subsrd_acc();
    if(c_id>0 )
    {
        //$("#dlgSubsrdAccSa_name").attr('readonly',true);
        $("#dlgSubsrdAccClient_code").attr('disabled',true);
        $($("button", $("#dialogBox_subsrd_acc_dlg").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrd_acc_dlg").parent())[1]).show();
       do_get_subsrd_acc();
    }
    else
    {
        //$("#dlgSubsrdAccSa_name").attr('readonly',false);
        $("#dlgSubsrdAccClient_code").attr('disabled',false);
        $($("button", $("#dialogBox_subsrd_acc_dlg").parent())[0]).show();
        $($("button", $("#dialogBox_subsrd_acc_dlg").parent())[1]).hide();
    }    
    $("#dialogBox_subsrd_acc_dlg").dialog("open");
}
function close_dlg_subsrd_acc()
{
    subsrd_acc_id=0;
    $("#dialogBox_subsrd_acc_dlg").dialog("close");
}

function clear_dlg_subsrd_acc()
{   
    //$("#dlgSubsrdAccSa_name").val('');
    //$("#dlgSubsrdAccSa_id").val('0');
    //$("#dlgSubsrdAccBank_code").val('');
    //$("#dlgSubsrdAccBank_name").val('');
    $("#dlgSubsrdAcc_no").val('');
    $("#dlgSubsrdAcc_name").val('');
    $("#dlgSubsrdRef_to").val('');
    $("#dlgSubsrdRef_up").val('');
    $("#dlgSubsrdRef_telp").val('');
    $("#dlgSubsrdRef_fax").val('');
}
function refresh_subsrd_acc()
{
    get_client_subsrd_acc_dlg();
    //get_sa_subsrd_acc_dlg();
    get_bank_subsrd_acc_dlg();
    get_type_subsrd_acc_dlg();
    state_progress(1);
    data_subsrd_acc.length=0;        
    var obj_post = $.post(uri_subsrd_acc+"list_acc", {},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrd_acc[i] = {});
            d["acc_id"] = msg.r_sdata[i].acc_id;
            d["client_code"] = msg.r_sdata[i].client_code;
            d["sa_name"] = msg.r_sdata[i].sa_name;
            d["bank_name"] = msg.r_sdata[i].bank_name;
            d["mi_code"] = msg.r_sdata[i].mi_code;
            d["client_code"] = msg.r_sdata[i].client_code;
            d["type_desc"] = msg.r_sdata[i].type_desc;
            d["acc_no"] = msg.r_sdata[i].acc_no;
            d["acc_name"] = msg.r_sdata[i].acc_name;
            d["ref_to"] = msg.r_sdata[i].ref_to;
            d["ref_up"] = msg.r_sdata[i].ref_up;
            d["ref_telp"] = msg.r_sdata[i].ref_telp;
            d["ref_fax"] = msg.r_sdata[i].ref_fax;
            d["acc_enable"] = msg.r_sdata[i].acc_enable==1?"Enable":"Disable";
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
        }
        
        grid_subsrd_acc.invalidateAllRows();
        grid_subsrd_acc.updateRowCount();
        grid_subsrd_acc.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrd_acc.invalidateAllRows();
        grid_subsrd_acc.updateRowCount();
        grid_subsrd_acc.render();
        state_progress(0);}
    );
}
function set_subsrd_acc_par(pval)
{                                     
    dPicker_par1=pval;
}
function create_subsrd_acc_event()
{
    $("#hbtn_subsrd_acc_add").click(function(){   
        dPicker_par1=$("#dlgSubsrdAccClient_code").val();
        open_dlg_subsrd_acc(0);
    });      

    grid_subsrd_acc.onDblClick.subscribe(function(e) { 
        var selected_row_subsrd  = grid_subsrd_acc.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_acc_id=data_subsrd_acc[selected_row_subsrd.row].acc_id;
            dPicker_par1=data_subsrd_acc[selected_row_subsrd.row].client_code;
            open_dlg_subsrd_acc(1);
        } 
    });
    $("#hbtn_subsrd_acc_edit").click(function(){ 
        var selected_row_subsrd  = grid_subsrd_acc.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_acc_id=data_subsrd_acc[selected_row_subsrd.row].acc_id;
            dPicker_par1=data_subsrd_acc[selected_row_subsrd.row].client_code;
            open_dlg_subsrd_acc(1);
        } 
    });
    $("#hbtn_subsrd_acc_reload").click(function(){   //  alert('a');
            refresh_subsrd_acc();
    });
}

function do_add_subsrd_acc()
{                              
    if(do_subsrd_acc==0)
    {
        do_subsrd_acc=1;
        var b_bccode = $("#dlgSubsrdAccClient_code").val();
        var b_bsid = $("#dlgSubsrdAccSa_id").val(); 
        var b_bbcode = $("#dlgSubsrdAccBank_code").val(); 
        var b_btype = $("#dlgSubsrdAcc_type").val(); 
        var b_bno = $("#dlgSubsrdAcc_no").val(); 
        var b_bname = $("#dlgSubsrdAcc_name").val(); 
        var b_benable = $("#dlgSubsrdAcc_enable").val(); 
        var b_bto= $("#dlgSubsrdRef_to").val(); 
        var b_bup= $("#dlgSubsrdRef_up").val(); 
        var b_btelp= $("#dlgSubsrdRef_telp").val(); 
        var b_bfax= $("#dlgSubsrdRef_fax").val(); 
        state_progress(1);
        
        var obj_post = $.post(uri_subsrd_acc+"add_acc", {
            b_ccode:b_bccode,b_sid:b_bsid,b_no:b_bno,b_enable:b_benable ,b_type:b_btype,b_name:b_bname,b_bcode:b_bbcode,
            b_to:b_bto,b_up:b_bup,b_telp:b_btelp,b_fax:b_bfax
        },function(data) {
           //alert(data);
        },'json'); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_acc();
            do_subsrd_acc=0;
            close_dlg_subsrd_acc();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd_acc=0;state_progress(0);});
    }

}
function do_edit_subsrd_acc()
{                                       
    if(do_subsrd_acc==0)
    {                   
        do_subsrd_acc=1;
        var b_bccode = $("#dlgSubsrdAccClient_code").val();
        var b_bsid = $("#dlgSubsrdAccSa_id").val();      
        var b_bbcode = $("#dlgSubsrdAccBank_code").val(); 
        var b_btype = $("#dlgSubsrdAcc_type").val(); 
        var b_bno = $("#dlgSubsrdAcc_no").val(); 
        var b_bname = $("#dlgSubsrdAcc_name").val(); 
        var b_benable = $("#dlgSubsrdAcc_enable").val(); 
        var b_bto= $("#dlgSubsrdRef_to").val(); 
        var b_bup= $("#dlgSubsrdRef_up").val(); 
        var b_btelp= $("#dlgSubsrdRef_telp").val(); 
        var b_bfax= $("#dlgSubsrdRef_fax").val(); 
        state_progress(1);
        
        var obj_post = $.post(uri_subsrd_acc+"edit_acc", {
            b_aid:subsrd_acc_id,b_ccode:b_bccode,b_sid:b_bsid,b_no:b_bno,b_enable:b_benable ,b_type:b_btype,b_name:b_bname,b_bcode:b_bbcode,
            b_to:b_bto,b_up:b_bup,b_telp:b_btelp,b_fax:b_bfax
        },function(data) {
            //alert(data);
        },'json'); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_acc();
            do_subsrd_acc=0;
            close_dlg_subsrd_acc();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd_acc=0;state_progress(0);});
    }

}
function do_get_subsrd_acc()
{
    if(do_subsrd_acc==0)
    {
        do_subsrd_acc=1;
        state_progress(1);
                                        
        var obj_post = $.post(uri_subsrd_acc+"get_acc", {
            b_id:subsrd_acc_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgSubsrdAccClient_code").val(msg.r_sdata[0].client_code);
                $("#dlgSubsrdAccSa_id").val(msg.r_sdata[0].sa_id);
                $("#dlgSubsrdAccBank_code").val(msg.r_sdata[0].bank_code);
                $("#dlgSubsrdAcc_type").val(msg.r_sdata[0].acc_type);
                $("#dlgSubsrdAcc_no").val(msg.r_sdata[0].acc_no);
                $("#dlgSubsrdAcc_name").val(msg.r_sdata[0].acc_name);
                $("#dlgSubsrdAcc_enable").val(msg.r_sdata[0].acc_enable);
                $("#dlgSubsrdRef_to").val(msg.r_sdata[0].ref_to);
                $("#dlgSubsrdRef_up").val(msg.r_sdata[0].ref_up);
                $("#dlgSubsrdRef_telp").val(msg.r_sdata[0].ref_telp);
                $("#dlgSubsrdRef_fax").val(msg.r_sdata[0].ref_fax);
                get_sa_subsrd_acc_dlg(msg.r_sdata[0].client_code,msg.r_sdata[0].sa_id);
            }
            state_progress(0);
            do_subsrd_acc=0;               
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd_acc=0;state_progress(0);});
    }

}
          