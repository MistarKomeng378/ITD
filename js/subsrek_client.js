var subsrek_client_id=0;
var grid_subsrek_client;
var data_subsrek_client = [];

function get_content_subsrek_client_dlg()
{                                         
    var obj_post = $.post(uri_subsrek_client_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {         //        alert(msg);
        $("#dialogBox_subsrek_client_dlg").html(msg);
    });
}

function create_dlg_subsrek_client()
{
    get_content_subsrek_client_dlg();
    $("#dialogBox_subsrek_client_dlg").dialog({ 
            title:        'Pending Transaksi - Client'
        ,    width:        440
        ,    height:        220
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_subsrek_client();},
             "Ubah": function(){do_edit_subsrek_client();},
             "Disable": function(){do_enable_subsrek_client(0);},
             "Enable": function(){do_enable_subsrek_client(1);},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
    
}
function initiate_subsrek_client()
{
    add_section("tbl_slick_subsrek_client","data_subsrek_client","refresh_subsrek_client()","hbtn_subsrek_client","grid_subsrek_client");
    create_subsrek_client_grid();
    create_subsrek_client_event();
    create_dlg_subsrek_client(); 

}    
function create_subsrek_client_grid()
{
    var columns_subsrek_client = [];
    var options_subsrek_client = [] ; 
    columns_subsrek_client = [         
        {id:"client_code", name:"Kode Klien", field:"client_code",width:80}
        ,{id:"client_name", name:"Nama Klien", field:"client_name",width:220}
        ,{id:"bank_code", name:"Kode Bank", field:"bank_code",width:80}
        ,{id:"bank_desc", name:"Nama Bank", field:"bank_desc",width:220}
        ,{id:"acc_no", name:"No Rekening", field:"acc_no",width:120}
        ,{id:"rek_enable", name:"Enable", field:"rek_enable",width:120}
        ,{id:"modified_by", name:"Modified by", field:"modified_by",width:120}
        ,{id:"modified_dt", name:"Modified dt", field:"modified_dt",width:120}
    ];
    options_subsrek_client = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subsrek_client = new Slick.Grid("#tbl_slick_subsrek_client", data_subsrek_client, columns_subsrek_client, options_subsrek_client);
    grid_subsrek_client.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function open_dlg_subsrek_client(c_id)
{
    $($("button", $("#dialogBox_subsrek_client_dlg").parent())[2]).hide();
    $($("button", $("#dialogBox_subsrek_client_dlg").parent())[3]).hide();
    clear_dlg_subsrek_client();
    if(c_id>0 )
    {
        $($("button", $("#dialogBox_subsrek_client_dlg").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrek_client_dlg").parent())[1]).show();
        $("#dlgsubsrekClient_code").attr("readonly",true); 
        $("#dlgsubsrekClient_bank_code").attr("readonly",true); 
        $("#dlgsubsrekClient_acc_no").attr("readonly",true); 
        do_get_subsrek_client();
    }
    else
    {
        $("#dlgsubsrekClient_code").attr("readonly",false); 
        $("#dlgsubsrekClient_bank_code").attr("readonly",false); 
        $("#dlgsubsrekClient_acc_no").attr("readonly",false); 
        $($("button", $("#dialogBox_subsrek_client_dlg").parent())[0]).show();
        $($("button", $("#dialogBox_subsrek_client_dlg").parent())[1]).hide();
    }
    $("#dialogBox_subsrek_client_dlg").dialog("open");
}
function close_dlg_subsrek_client()
{
    subsrek_client_id=0;
    $("#dialogBox_subsrek_client_dlg").dialog("close");
}

function clear_dlg_subsrek_client()
{
    $("#dlgsubsrekClient_code").val('')
    $("#dlgsubsrekClient_name").val('')
    $("#dlgsubsrekClient_bank_code").val('')
    $("#dlgsubsrekClient_bank_name").val('')
    $("#dlgsubsrekClient_acc_no").val('')
}
function refresh_subsrek_client()
{
    state_progress(1);
    data_subsrek_client.length=0;        
    var obj_post = $.post(uri+"/index.php/subsrekcript_client/list_client", {},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrek_client[i] = {});
            d["rek_id"] = msg.r_sdata[i].rek_id;
            d["client_code"] = msg.r_sdata[i].client_code;
            d["client_name"] = msg.r_sdata[i].client_name;
            d["bank_code"] = msg.r_sdata[i].bank_code;
            d["bank_desc"] = msg.r_sdata[i].bank_desc;
            d["acc_no"] = msg.r_sdata[i].acc_no;
            d["rek_enable"] = msg.r_sdata[i].rek_enable==1?"Enable":"Disable";
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
        }
        
        grid_subsrek_client.invalidateAllRows();
        grid_subsrek_client.updateRowCount();
        grid_subsrek_client.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrek_client.invalidateAllRows();
        grid_subsrek_client.updateRowCount();
        grid_subsrek_client.render();
        state_progress(0);}
    );
}

function create_subsrek_client_event()
{
    $("#hbtn_subsrek_client_add").click(function(){   //  alert('a');
            open_dlg_subsrek_client(0);
    });
    $("#hbtn_subsrek_client_edit").click(function(){   //  alert('a');
        var selected_row_subsrek_client  = grid_subsrek_client.getActiveCell();
        if(selected_row_subsrek_client)
        {
            subsrek_client_id=data_subsrek_client[selected_row_subsrek_client.row].rek_id                                      
            open_dlg_subsrek_client(1);
        }
    });
    grid_subsrek_client.onDblClick.subsrekcribe(function(e) {     
        var selected_row_subsrek  = grid_subsrek_client.getActiveCell();
        if(selected_row_subsrek)
        {
            subsrek_client_id=data_subsrek_client[selected_row_subsrek.row].rek_id;
            open_dlg_subsrek_client(1);
        }
    });
    $("#hbtn_subsrek_client_reload").click(function(){   //  alert('a');
            refresh_subsrek_client();
    });
    $("#hbtn_subsrek_client_save").click(function(){   //  alert('a');
            window.open(uri+"/index.php/subsrekcript_client/save_client","_blank");
    });
}

function do_add_subsrek_client()
{
    if(do_subsrek==0)
    {
        do_subsrek=1;
        var b_bccode = $("#dlgsubsrekClient_code").val();
        var b_bcname = $("#dlgsubsrekClient_name").val();
        var b_bbcode = $("#dlgsubsrekClient_bank_code").val();
        var b_bbname = $("#dlgsubsrekClient_bank_name").val();
        var b_baccno = $("#dlgsubsrekClient_acc_no").val();
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrekcript_client/add_client", {
            b_ccode:b_bccode,b_cname:b_bcname,b_bcode:b_bbcode,b_bname:b_bbname,b_accno:b_baccno
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrek_client();
            do_subsrek=0;
            close_dlg_subsrek_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrek=0;state_progress(0);});
    }

}
function do_edit_subsrek_client()
{
    if(do_subsrek==0)
    {                   
        do_subsrek=1;
        var b_bccode = $("#dlgsubsrekClient_code").val();
        var b_bcname = $("#dlgsubsrekClient_name").val();
        var b_bbcode = $("#dlgsubsrekClient_bank_code").val();
        var b_bbname = $("#dlgsubsrekClient_bank_name").val();
        var b_baccno = $("#dlgsubsrekClient_acc_no").val();
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrekcript_client/edit_client", {
            b_id:subsrek_client_id,b_ccode:b_bccode,b_cname:b_bcname,b_bcode:b_bbcode,b_bname:b_bbname,b_accno:b_baccno
        },function(data) {
           // alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrek_client();
            do_subsrek=0;
            close_dlg_subsrek_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrek=0;state_progress(0);});
    }

}
function do_get_subsrek_client()
{
    if(do_subsrek==0)
    {
        do_subsrek=1;
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrekcript_client/get_client", {
            b_id:subsrek_client_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgsubsrekClient_code").val(msg.r_sdata[0].client_code)
                $("#dlgsubsrekClient_name").val(msg.r_sdata[0].client_name)
                $("#dlgsubsrekClient_bank_code").val(msg.r_sdata[0].bank_code)
                $("#dlgsubsrekClient_bank_name").val(msg.r_sdata[0].bank_desc)
                $("#dlgsubsrekClient_acc_no").val(msg.r_sdata[0].acc_no)
                if(lvl<=5 )
                {
                    if(msg.r_sdata[0].rek_enable==1)
                        $($("button", $("#dialogBox_subsrek_client_dlg").parent())[2]).show();
                    else
                        $($("button", $("#dialogBox_subsrek_client_dlg").parent())[3]).show();
                }
            }
            state_progress(0);
            do_subsrek=0;               
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrek=0;state_progress(0);});
    }

}

function do_enable_subsrek_client(penable)
{
    if(do_subsrek==0)
    {                   
        do_subsrek=1;
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrekcript_client/enable_client", {
            b_id:subsrek_client_id,b_ena:penable
        },function(data) {
           // alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrek_client();
            do_subsrek=0;
            close_dlg_subsrek_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrek=0;state_progress(0);});
    }

}
