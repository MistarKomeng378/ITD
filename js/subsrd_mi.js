var subsrd_mi_id=0;
var grid_subsrd_mi;
var data_subsrd_mi = [];

var do_subsrd=0;

function get_content_subsrd_mi_dlg()
{                                
    var obj_post = $.post(uri_subsrd_mi_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {         //        alert(msg);
        $("#dialogBox_subsrd_mi_dlg").html(msg);
    });
}

function create_dlg_subsrd_mi()
{
    get_content_subsrd_mi_dlg();
    $("#dialogBox_subsrd_mi_dlg").dialog({ 
            title:        'Subscription Reksadana - Manager Investasi'
        ,    width:        440
        ,    height:        140
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_subsrd_mi();},
             "Ubah": function(){do_edit_subsrd_mi();},
             "Disable": function(){do_enable_subsrd_mi(0);},
             "Enable": function(){do_enable_subsrd_mi(1);},
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function initiate_subsrd_mi()
{             
    add_section("tbl_slick_subsrd_mi","data_subsrd_mi","refresh_subsrd_mi()","hbtn_subsrd_mi","grid_subsrd_mi");
    create_subsrd_mi_grid();
    create_subsrd_mi_event();     
    create_dlg_subsrd_mi(); 

}    
function create_subsrd_mi_grid()
{
    var columns_subsrd_mi = [];
    var options_subsrd_mi = [] ; 
    columns_subsrd_mi = [         
        {id:"mi_code", name:"Kode MI", field:"mi_code",width:80}
        ,{id:"mi_name", name:"Nama MI", field:"mi_name",width:420}
        ,{id:"modified_by", name:"Modified by", field:"modified_by",width:120}
        ,{id:"modified_dt", name:"Modified dt", field:"modified_dt",width:120}
    ];
    options_subsrd_mi = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subsrd_mi = new Slick.Grid("#tbl_slick_subsrd_mi", data_subsrd_mi, columns_subsrd_mi, options_subsrd_mi);
    grid_subsrd_mi.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function open_dlg_subsrd_mi(c_id)
{                                                       
    $($("button", $("#dialogBox_subsrd_mi_dlg").parent())[2]).hide();
    $($("button", $("#dialogBox_subsrd_mi_dlg").parent())[3]).hide();
    
   clear_dlg_subsrd_mi();
    if(c_id>0 )
    {
        $("#dlgSubsrdmi_code").attr('readonly',true);
        $($("button", $("#dialogBox_subsrd_mi_dlg").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrd_mi_dlg").parent())[1]).show();
       do_get_subsrd_mi();
    }
    else
    {
        $("#dlgSubsrdmi_code").attr('readonly',false);
        $($("button", $("#dialogBox_subsrd_mi_dlg").parent())[0]).show();
        $($("button", $("#dialogBox_subsrd_mi_dlg").parent())[1]).hide();
    }    
    $("#dialogBox_subsrd_mi_dlg").dialog("open");
}
function close_dlg_subsrd_mi()
{
    subsrd_mi_id=0;
    $("#dialogBox_subsrd_mi_dlg").dialog("close");
}

function clear_dlg_subsrd_mi()
{
    $("#dlgSubsrdmi_code").val('');
    $("#dlgSubsrdmi_name").val('');
}
function refresh_subsrd_mi()
{
    state_progress(1);
    data_subsrd_mi.length=0;        
    var obj_post = $.post(uri+"/index.php/subsrd_mi/list_mi", {},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrd_mi[i] = {});
            d["mi_code"] = msg.r_sdata[i].mi_code;
            d["mi_name"] = msg.r_sdata[i].mi_name;
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
        }
        
        grid_subsrd_mi.invalidateAllRows();
        grid_subsrd_mi.updateRowCount();
        grid_subsrd_mi.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrd_mi.invalidateAllRows();
        grid_subsrd_mi.updateRowCount();
        grid_subsrd_mi.render();
        state_progress(0);}
    );
}

function create_subsrd_mi_event()
{
    $("#hbtn_subsrd_mi_add").click(function(){   // alert('a');
            open_dlg_subsrd_mi(0);
    });
    grid_subsrd_mi.onDblClick.subscribe(function(e) { 
        var selected_row_subsrd  = grid_subsrd_mi.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_mi_id=data_subsrd_mi[selected_row_subsrd.row].mi_code;
            open_dlg_subsrd_mi(1);
        } 
    });
    $("#hbtn_subsrd_mi_edit").click(function(){ 
        var selected_row_subsrd  = grid_subsrd_mi.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_mi_id=data_subsrd_mi[selected_row_subsrd.row].mi_code;
            open_dlg_subsrd_mi(1);
        } 
    });
    $("#hbtn_subsrd_mi_reload").click(function(){   //  alert('a');
            refresh_subsrd_mi();
    });
}

function do_add_subsrd_mi()
{
    if(do_subsrd==0)
    {
        do_subsrd=1;
        var b_bccode = $("#dlgSubsrdmi_code").val();
        var b_bcname = $("#dlgSubsrdmi_name").val();  
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrd_mi/add_mi", {
            b_ccode:b_bccode,b_cname:b_bcname
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_mi();
            do_subsrd=0;
            close_dlg_subsrd_mi();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}
function do_edit_subsrd_mi()
{                                       
    if(do_subsrd==0)
    {                   
        do_subsrd=1;
        var b_bccode = $("#dlgSubsrdmi_code").val();
        var b_bcname = $("#dlgSubsrdmi_name").val();
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrd_mi/edit_mi", {
            b_ccode:b_bccode,b_cname:b_bcname
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_mi();
            do_subsrd=0;
            close_dlg_subsrd_mi();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}
function do_get_subsrd_mi()
{
    if(do_subsrd==0)
    {
        do_subsrd=1;
        state_progress(1);
                                        
        var obj_post = $.post(uri+"/index.php/subsrd_mi/get_mi", {
            b_id:subsrd_mi_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgSubsrdmi_code").val(msg.r_sdata[0].mi_code);
                $("#dlgSubsrdmi_name").val(msg.r_sdata[0].mi_name);
            }
            state_progress(0);
            do_subsrd=0;               
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}

