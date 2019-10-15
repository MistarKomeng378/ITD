var subsrd_bank_id=0;
var grid_subsrd_bank;
var data_subsrd_bank = [];

var do_subsrd=0;

function get_content_subsrd_bank_dlg()
{                                
    var obj_post = $.post(uri_subsrd_bank_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {         //        alert(msg);
        $("#dialogBox_subsrd_bank_dlg").html(msg);
    });
}

function create_dlg_subsrd_bank()
{
    get_content_subsrd_bank_dlg();
    $("#dialogBox_subsrd_bank_dlg").dialog({ 
            title:        'Subscription Reksadana - Bank'
        ,    width:        440
        ,    height:        140
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_subsrd_bank();},
             "Ubah": function(){do_edit_subsrd_bank();},
             "Disable": function(){do_enable_subsrd_bank(0);},
             "Enable": function(){do_enable_subsrd_bank(1);},
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function initiate_subsrd_bank()
{             
    add_section("tbl_slick_subsrd_bank","data_subsrd_bank","refresh_subsrd_bank()","hbtn_subsrd_bank","grid_subsrd_bank");
    create_subsrd_bank_grid();
    create_subsrd_bank_event();     
    create_dlg_subsrd_bank(); 

}    
function create_subsrd_bank_grid()
{
    var columns_subsrd_bank = [];
    var options_subsrd_bank = [] ; 
    columns_subsrd_bank = [         
        {id:"bank_code", name:"Kode Bank", field:"bank_code",width:80}
        ,{id:"bank_name", name:"Nama Bank", field:"bank_name",width:220}
        ,{id:"modified_by", name:"Modified by", field:"modified_by",width:120}
        ,{id:"modified_dt", name:"Modified dt", field:"modified_dt",width:120}
    ];
    options_subsrd_bank = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subsrd_bank = new Slick.Grid("#tbl_slick_subsrd_bank", data_subsrd_bank, columns_subsrd_bank, options_subsrd_bank);
    grid_subsrd_bank.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function open_dlg_subsrd_bank(c_id)
{                                                       
    $($("button", $("#dialogBox_subsrd_bank_dlg").parent())[2]).hide();
    $($("button", $("#dialogBox_subsrd_bank_dlg").parent())[3]).hide();
    
   clear_dlg_subsrd_bank();
    if(c_id>0 )
    {
        $("#dlgSubsrdBank_code").attr('readonly',true);
        $($("button", $("#dialogBox_subsrd_bank_dlg").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrd_bank_dlg").parent())[1]).show();
       do_get_subsrd_bank();
    }
    else
    {
        $("#dlgSubsrdBank_code").attr('readonly',false);
        $($("button", $("#dialogBox_subsrd_bank_dlg").parent())[0]).show();
        $($("button", $("#dialogBox_subsrd_bank_dlg").parent())[1]).hide();
    }    
    $("#dialogBox_subsrd_bank_dlg").dialog("open");
}
function close_dlg_subsrd_bank()
{
    subsrd_bank_id=0;
    $("#dialogBox_subsrd_bank_dlg").dialog("close");
}

function clear_dlg_subsrd_bank()
{
    $("#dlgSubsrdBank_code").val('');
    $("#dlgSubsrdBank_name").val('');
    
}
function refresh_subsrd_bank()
{
    state_progress(1);
    data_subsrd_bank.length=0;        
    var obj_post = $.post(uri+"/index.php/subsrd_bank/list_bank", {},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
                                         
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrd_bank[i] = {});
            d["bank_code"] = msg.r_sdata[i].bank_code;
            d["bank_name"] = msg.r_sdata[i].bank_name;
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
        }
        
        grid_subsrd_bank.invalidateAllRows();
        grid_subsrd_bank.updateRowCount();
        grid_subsrd_bank.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrd_bank.invalidateAllRows();
        grid_subsrd_bank.updateRowCount();
        grid_subsrd_bank.render();
        state_progress(0);}
    );
}

function create_subsrd_bank_event()
{
    $("#hbtn_subsrd_bank_add").click(function(){   
            open_dlg_subsrd_bank(0);
    });
    grid_subsrd_bank.onDblClick.subscribe(function(e) { 
        var selected_row_subsrd  = grid_subsrd_bank.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_bank_id=data_subsrd_bank[selected_row_subsrd.row].bank_code;
            open_dlg_subsrd_bank(1);
        } 
    });
    $("#hbtn_subsrd_bank_edit").click(function(){ 
        var selected_row_subsrd  = grid_subsrd_bank.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_bank_id=data_subsrd_bank[selected_row_subsrd.row].bank_code;
            open_dlg_subsrd_bank(1);
        } 
    });
    $("#hbtn_subsrd_bank_reload").click(function(){   //  alert('a');
            refresh_subsrd_bank();
    });
}

function do_add_subsrd_bank()
{
    if(do_subsrd==0)
    {
        do_subsrd=1;
        var b_bccode = $("#dlgSubsrdBank_code").val();
        var b_bcname = $("#dlgSubsrdBank_name").val();  
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrd_bank/add_bank", {
            b_ccode:b_bccode,b_cname:b_bcname
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_bank();
            do_subsrd=0;
            close_dlg_subsrd_bank();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}
function do_edit_subsrd_bank()
{                                       
    if(do_subsrd==0)
    {                   
        do_subsrd=1;
        var b_bccode = $("#dlgSubsrdBank_code").val();
        var b_bcname = $("#dlgSubsrdBank_name").val();
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrd_bank/edit_bank", {
            b_ccode:b_bccode,b_cname:b_bcname
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_bank();
            do_subsrd=0;
            close_dlg_subsrd_bank();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}
function do_get_subsrd_bank()
{
    if(do_subsrd==0)
    {
        do_subsrd=1;
        state_progress(1);
                                        
        var obj_post = $.post(uri+"/index.php/subsrd_bank/get_bank", {
            b_id:subsrd_bank_id
        },function(data) {
           // alert(data);
        },'json'); 
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgSubsrdBank_code").val(msg.r_sdata[0].bank_code);
                $("#dlgSubsrdBank_name").val(msg.r_sdata[0].bank_name);
            }
            state_progress(0);
            do_subsrd=0;               
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}

