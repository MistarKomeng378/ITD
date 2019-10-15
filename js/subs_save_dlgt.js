
function get_content_subs_save_dlg()
{                                         
    var obj_post = $.post(uri_subs_client_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {         //        alert(msg);
        $("#dialogBox_subs_client_dlg").html(msg);
    });
}

function create_dlg_subs_client()
{
    get_content_subs_client_dlg();
    $("#dialogBox_subs_client_dlg").dialog({ 
            title:        'Pending Transaksi - Client'
        ,    width:        440
        ,    height:        220
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_subs_client();},
             "Ubah": function(){do_edit_subs_client();},
             "Disable": function(){do_enable_subs_client(0);},
             "Enable": function(){do_enable_subs_client(1);},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
    
}
function initiate_subs_client()
{
    add_section("tbl_slick_subs_client","data_subs_client","refresh_subs_client()","hbtn_subs_client","grid_subs_client");
    create_subs_client_grid();
    create_subs_client_event();
    create_dlg_subs_client(); 

}    
function create_subs_client_grid()
{
    var columns_subs_client = [];
    var options_subs_client = [] ; 
    columns_subs_client = [         
        {id:"client_code", name:"Kode Klien", field:"client_code",width:80}
        ,{id:"client_name", name:"Nama Klien", field:"client_name",width:220}
        ,{id:"bank_code", name:"Kode Bank", field:"bank_code",width:80}
        ,{id:"bank_desc", name:"Nama Bank", field:"bank_desc",width:220}
        ,{id:"acc_no", name:"No Rekening", field:"acc_no",width:120}
        ,{id:"rek_enable", name:"Enable", field:"rek_enable",width:120}
        ,{id:"modified_by", name:"Modified by", field:"modified_by",width:120}
        ,{id:"modified_dt", name:"Modified dt", field:"modified_dt",width:120}
    ];
    options_subs_client = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subs_client = new Slick.Grid("#tbl_slick_subs_client", data_subs_client, columns_subs_client, options_subs_client);
    grid_subs_client.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function open_dlg_subs_client(c_id)
{
    $($("button", $("#dialogBox_subs_client_dlg").parent())[2]).hide();
    $($("button", $("#dialogBox_subs_client_dlg").parent())[3]).hide();
    clear_dlg_subs_client();
    if(c_id>0 )
    {
        $($("button", $("#dialogBox_subs_client_dlg").parent())[0]).hide();
        $($("button", $("#dialogBox_subs_client_dlg").parent())[1]).show();
        $("#dlgSubsClient_code").attr("readonly",true); 
        $("#dlgSubsClient_bank_code").attr("readonly",true); 
        $("#dlgSubsClient_acc_no").attr("readonly",true); 
        do_get_subs_client();
    }
    else
    {
        $("#dlgSubsClient_code").attr("readonly",false); 
        $("#dlgSubsClient_bank_code").attr("readonly",false); 
        $("#dlgSubsClient_acc_no").attr("readonly",false); 
        $($("button", $("#dialogBox_subs_client_dlg").parent())[0]).show();
        $($("button", $("#dialogBox_subs_client_dlg").parent())[1]).hide();
    }
    $("#dialogBox_subs_client_dlg").dialog("open");
}
function close_dlg_subs_client()
{
    subs_client_id=0;
    $("#dialogBox_subs_client_dlg").dialog("close");
}

function clear_dlg_subs_client()
{
    $("#dlgSubsClient_code").val('')
    $("#dlgSubsClient_name").val('')
    $("#dlgSubsClient_bank_code").val('')
    $("#dlgSubsClient_bank_name").val('')
    $("#dlgSubsClient_acc_no").val('')
}
function refresh_subs_client()
{
    state_progress(1);
    data_subs_client.length=0;        
    var obj_post = $.post(uri+"/index.php/subscript_client/list_client", {},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subs_client[i] = {});
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
        
        grid_subs_client.invalidateAllRows();
        grid_subs_client.updateRowCount();
        grid_subs_client.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subs_client.invalidateAllRows();
        grid_subs_client.updateRowCount();
        grid_subs_client.render();
        state_progress(0);}
    );
}

function create_subs_client_event()
{
    $("#hbtn_subs_client_add").click(function(){   //  alert('a');
            open_dlg_subs_client(0);
    });
    $("#hbtn_subs_client_edit").click(function(){   //  alert('a');
        var selected_row_subs_client  = grid_subs_client.getActiveCell();
        if(selected_row_subs_client)
        {
            subs_client_id=data_subs_client[selected_row_subs_client.row].rek_id                                      
            open_dlg_subs_client(1);
        }
    });
    grid_subs_client.onDblClick.subscribe(function(e) {     
        var selected_row_subs  = grid_subs_client.getActiveCell();
        if(selected_row_subs)
        {
            subs_client_id=data_subs_client[selected_row_subs.row].rek_id;
            open_dlg_subs_client(1);
        }
    });
    $("#hbtn_subs_client_reload").click(function(){   //  alert('a');
            refresh_subs_client();
    });
    $("#hbtn_subs_client_save").click(function(){   //  alert('a');
            window.open(uri+"/index.php/subscript_client/save_client","_blank");
    });
}

function do_add_subs_client()
{
    if(do_subs==0)
    {
        do_subs=1;
        var b_bccode = $("#dlgSubsClient_code").val();
        var b_bcname = $("#dlgSubsClient_name").val();
        var b_bbcode = $("#dlgSubsClient_bank_code").val();
        var b_bbname = $("#dlgSubsClient_bank_name").val();
        var b_baccno = $("#dlgSubsClient_acc_no").val();
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subscript_client/add_client", {
            b_ccode:b_bccode,b_cname:b_bcname,b_bcode:b_bbcode,b_bname:b_bbname,b_accno:b_baccno
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs_client();
            do_subs=0;
            close_dlg_subs_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }

}
function do_edit_subs_client()
{
    if(do_subs==0)
    {                   
        do_subs=1;
        var b_bccode = $("#dlgSubsClient_code").val();
        var b_bcname = $("#dlgSubsClient_name").val();
        var b_bbcode = $("#dlgSubsClient_bank_code").val();
        var b_bbname = $("#dlgSubsClient_bank_name").val();
        var b_baccno = $("#dlgSubsClient_acc_no").val();
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subscript_client/edit_client", {
            b_id:subs_client_id,b_ccode:b_bccode,b_cname:b_bcname,b_bcode:b_bbcode,b_bname:b_bbname,b_accno:b_baccno
        },function(data) {
           // alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs_client();
            do_subs=0;
            close_dlg_subs_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }

}
function do_get_subs_client()
{
    if(do_subs==0)
    {
        do_subs=1;
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subscript_client/get_client", {
            b_id:subs_client_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgSubsClient_code").val(msg.r_sdata[0].client_code)
                $("#dlgSubsClient_name").val(msg.r_sdata[0].client_name)
                $("#dlgSubsClient_bank_code").val(msg.r_sdata[0].bank_code)
                $("#dlgSubsClient_bank_name").val(msg.r_sdata[0].bank_desc)
                $("#dlgSubsClient_acc_no").val(msg.r_sdata[0].acc_no)
                if(lvl<=5 )
                {
                    if(msg.r_sdata[0].rek_enable==1)
                        $($("button", $("#dialogBox_subs_client_dlg").parent())[2]).show();
                    else
                        $($("button", $("#dialogBox_subs_client_dlg").parent())[3]).show();
                }
            }
            state_progress(0);
            do_subs=0;               
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }

}

function do_enable_subs_client(penable)
{
    if(do_subs==0)
    {                   
        do_subs=1;
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subscript_client/enable_client", {
            b_id:subs_client_id,b_ena:penable
        },function(data) {
           // alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subs_client();
            do_subs=0;
            close_dlg_subs_client();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subs=0;state_progress(0);});
    }

}
