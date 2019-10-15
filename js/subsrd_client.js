var subsrd_client_id=0;
var grid_subsrd_client;
var data_subsrd_client = [];

var do_subsrd=0;

function get_content_subsrd_client_dlg()
{                                         
    var obj_post = $.post(uri_subsrd_client_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {         //        alert(msg);
        $("#dialogBox_subsrd_client_dlg").html(msg);
    });
}

function get_mi_subsrd_client_dlg()
{                                         
    var obj_post = $.post(uri_subsrd_mi+"list_mi",{},function(data) {
    },'json');
    obj_post.done(function(msg) {      //alert(msg.r_num_rows);
        var txt_sa='';
        for (var i=0; i<msg.r_num_rows; i++) 
            txt_sa=txt_sa+'<option value="'+msg.r_sdata[i].mi_code+'">'+msg.r_sdata[i].mi_name+'</option>';
        $("#dlgSubsrdClient_mi").html(txt_sa);
    });
}

function create_dlg_subsrd_client()
{
    get_content_subsrd_client_dlg();
    $("#dialogBox_subsrd_client_dlg").dialog({ 
            title:        'Subscription Reksadana - Reksadana'
        ,    width:        440
        ,    height:        180
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_subsrd_client();},
             "Ubah": function(){do_edit_subsrd_client();},
             "Disable": function(){do_enable_subsrd_client(0);},
             "Enable": function(){do_enable_subsrd_client(1);},
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function initiate_subsrd_client()
{
    add_section("tbl_slick_subsrd_client","data_subsrd_client","refresh_subsrd_client()","hbtn_subsrd_client","grid_subsrd_client");
    create_subsrd_client_grid();
    create_subsrd_client_event();     
    create_dlg_subsrd_client(); 
}    
function create_subsrd_client_grid()
{
    var columns_subsrd_client = [];
    var options_subsrd_client = [] ; 
    columns_subsrd_client = [  
        {id:"mi_code", name:"MI", field:"mi_code",width:80}
        ,{id:"client_code", name:"Kode Klien", field:"client_code",width:80}
        ,{id:"client_name", name:"Nama Klien", field:"client_name",width:420}
        ,{id:"client_enable", name:"Enable", field:"client_enable",width:80}
        ,{id:"modified_by", name:"Modified by", field:"modified_by",width:120}
        ,{id:"modified_dt", name:"Modified dt", field:"modified_dt",width:120}
    ];
    options_subsrd_client = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subsrd_client = new Slick.Grid("#tbl_slick_subsrd_client", data_subsrd_client, columns_subsrd_client, options_subsrd_client);
    grid_subsrd_client.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function open_dlg_subsrd_client(c_id)
{                                                       
    $($("button", $("#dialogBox_subsrd_client_dlg").parent())[2]).hide();
    $($("button", $("#dialogBox_subsrd_client_dlg").parent())[3]).hide();
    
   clear_dlg_subsrd_client();
    if(c_id>0 )
    {
        $("#dlgSubsrdClient_code").attr('readonly',true);
        $($("button", $("#dialogBox_subsrd_client_dlg").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrd_client_dlg").parent())[1]).show();
       do_get_subsrd_client();
    }
    else
    {
        $("#dlgSubsrdClient_code").attr('readonly',false);
        $($("button", $("#dialogBox_subsrd_client_dlg").parent())[0]).show();
        $($("button", $("#dialogBox_subsrd_client_dlg").parent())[1]).hide();
    }    
    $("#dialogBox_subsrd_client_dlg").dialog("open");
}
function close_dlg_subsrd_client()
{
    subsrd_client_id=0;
    $("#dialogBox_subsrd_client_dlg").dialog("close");
}

function clear_dlg_subsrd_client()
{
    $("#dlgSubsrdClient_code").val('');
    $("#dlgSubsrdClient_name").val('');
}
function refresh_subsrd_client()
{
    get_mi_subsrd_client_dlg();
    state_progress(1);
    data_subsrd_client.length=0;        
    var obj_post = $.post(uri+"/index.php/subsrd_client/list_client", {},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrd_client[i] = {});
            d["mi_code"] = msg.r_sdata[i].mi_code; 
            d["client_code"] = msg.r_sdata[i].client_code;
            d["client_name"] = msg.r_sdata[i].client_name;
            d["client_enable"] = msg.r_sdata[i].client_enable==1?"Enable":"Disable";
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
        }
        
        grid_subsrd_client.invalidateAllRows();
        grid_subsrd_client.updateRowCount();
        grid_subsrd_client.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrd_client.invalidateAllRows();
        grid_subsrd_client.updateRowCount();
        grid_subsrd_client.render();
        state_progress(0);}
    );
    get_mi_subsrd_client_dlg('');
}


function create_subsrd_client_event()
{
    $("#hbtn_subsrd_client_add").click(function(){   // alert('a');
            open_dlg_subsrd_client(0);
    });
    grid_subsrd_client.onDblClick.subscribe(function(e) { 
        var selected_row_subsrd  = grid_subsrd_client.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_client_id=data_subsrd_client[selected_row_subsrd.row].client_code;
            open_dlg_subsrd_client(1);
        } 
    });
    $("#hbtn_subsrd_client_edit").click(function(){ 
        var selected_row_subsrd  = grid_subsrd_client.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_client_id=data_subsrd_client[selected_row_subsrd.row].client_code;
            open_dlg_subsrd_client(1);
        } 
    });
    $("#hbtn_subsrd_client_reload").click(function(){   //  alert('a');
            refresh_subsrd_client();
    });
}

function do_add_subsrd_client()
{
    if(do_subsrd==0)
    {
        do_subsrd=1;
        var b_bccode = $("#dlgSubsrdClient_code").val(); 
        var b_bmicode = $("#dlgSubsrdClient_mi").val(); 
        var b_bcname = $("#dlgSubsrdClient_name").val();  
        var b_bcenable = $("#dlgSubsrdClient_enable").val();  
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrd_client/add_client", {
            b_ccode:b_bccode,b_cname:b_bcname,b_micode:b_bmicode,b_cenable:b_bcenable
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_client();
            do_subsrd=0;
            close_dlg_subsrd_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}
function do_edit_subsrd_client()
{                                       
    if(do_subsrd==0)
    {                   
        do_subsrd=1;
        var b_bccode = $("#dlgSubsrdClient_code").val();
        var b_bmicode = $("#dlgSubsrdClient_mi").val();   
        var b_bcname = $("#dlgSubsrdClient_name").val();
        var b_bcenable = $("#dlgSubsrdClient_enable").val();  
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrd_client/edit_client", {
            b_ccode:b_bccode,b_cname:b_bcname,b_micode:b_bmicode ,b_cenable:b_bcenable
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_client();
            do_subsrd=0;
            close_dlg_subsrd_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}
function do_get_subsrd_client()
{
    if(do_subsrd==0)
    {
        do_subsrd=1;
        state_progress(1);
                                        
        var obj_post = $.post(uri+"/index.php/subsrd_client/get_client", {
            b_id:subsrd_client_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgSubsrdClient_code").val(msg.r_sdata[0].client_code);
                $("#dlgSubsrdClient_name").val(msg.r_sdata[0].client_name);
                $("#dlgSubsrdClient_mi").val(msg.r_sdata[0].mi_code);
                $("#dlgSubsrdClient_enable").val(msg.r_sdata[0].client_enable);
                //get_mi_subsrd_client_dlg(msg.r_sdata[0].client_code);
                /*if(lvl<=5 )
                {
                    if(msg.r_sdata[0].rek_enable==1)
                        $($("button", $("#dialogBox_subsrd_client_dlg").parent())[2]).show();
                    else
                        $($("button", $("#dialogBox_subsrd_client_dlg").parent())[3]).show();
                } */
            }
            state_progress(0);
            do_subsrd=0;               
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}

function do_enable_subsrd_client(penable)
{
    if(do_subsrd==0)
    {                   
        do_subsrd=1;
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrdcript_client/enable_client", {
            b_id:subsrd_client_id,b_ena:penable
        },function(data) {
           // alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_client();
            do_subsrd=0;
            close_dlg_subsrd_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd=0;state_progress(0);});
    }

}
