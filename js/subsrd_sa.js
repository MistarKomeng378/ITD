var subsrd_sa_id=0;
var grid_subsrd_sa;
var data_subsrd_sa = [];

var do_subsrd_sa=0;

function get_content_subsrd_sa_dlg()
{                                         
    var obj_post = $.post(uri_subsrd_sa_dlg,{},function(data) {
    });
    obj_post.done(function(msg) {        
        $("#dialogBox_subsrd_sa_dlg").html(msg);
        setTimeout(function() {    
                create_dlg_dpicker_subsrd_sa();
            },1);        
    });
}
function get_mi_subsrd_sa_dlg()
{                                         
    var obj_post = $.post(uri_subsrd_mi+"list_mi",{},function(data) {
    },'json');
    obj_post.done(function(msg) {      //alert(msg.r_num_rows);
        var txt_sa='';
        for (var i=0; i<msg.r_num_rows; i++)
                txt_sa=txt_sa+'<option value="'+msg.r_sdata[i].mi_code+'">'+msg.r_sdata[i].mi_name+'</option>';
        $("#dlgSubsrdSaMi_code").html(txt_sa);
    });
}
function create_dlg_subsrd_sa()
{
    get_content_subsrd_sa_dlg();
    $("#dialogBox_subsrd_sa_dlg").dialog({ 
            title:        'Subscription Reksadana - Selling Agent'
        ,    width:        540
        ,    height:        180
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_subsrd_sa();},
             "Ubah": function(){do_edit_subsrd_sa();},
             "Disable": function(){do_enable_subsrd_sa(0);},
             "Enable": function(){do_enable_subsrd_sa(1);},
             "Batal": function(){ $(this).dialog("close");}
        }
    });    
    
}
function initiate_subsrd_sa()
{
    add_section("tbl_slick_subsrd_sa","data_subsrd_sa","refresh_subsrd_sa()","hbtn_subsrd_sa","grid_subsrd_sa");
    create_subsrd_sa_grid(); 
    create_subsrd_sa_event();     
    create_dlg_subsrd_sa();       

}    
function create_subsrd_sa_grid()
{
    var columns_subsrd_sa = [];
    var options_subsrd_sa = [] ; 
    columns_subsrd_sa = [
        {id:"mi_code", name:"MI", field:"mi_code",width:80}
        ,{id:"sa_name", name:"Nama Selling Agent", field:"sa_name",width:400}
        ,{id:"sa_enable", name:"Enable", field:"sa_enable",width:120}
        ,{id:"modified_by", name:"Modified by", field:"modified_by",width:120}
        ,{id:"modified_dt", name:"Modified dt", field:"modified_dt",width:120}
    ];
    options_subsrd_sa = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/    
    grid_subsrd_sa = new Slick.Grid("#tbl_slick_subsrd_sa", data_subsrd_sa, columns_subsrd_sa, options_subsrd_sa);
    grid_subsrd_sa.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}
function create_dlg_dpicker_subsrd_sa()
{                              
    var dpick_opt_subsrd ={
        cols : [         
                    {id:"client_code", name:"Code", field:"client_code",width:100}
                   ,{id:"client_name", name:"Client Name", field:"client_name",width:380}
            ],
        url: uri_subsrd+"list_client_by_code",
        setval: function(obj_val){
            $("#dlgSubsrdSaC_code").val(trim(obj_val.client_code));
        }
    }; 
    dPicker_attach($("#dlgSubsrdSaC_code"),dpick_opt_subsrd);        
}

function open_dlg_subsrd_sa(c_id)
{                                                       
    $($("button", $("#dialogBox_subsrd_sa_dlg").parent())[2]).hide();
    $($("button", $("#dialogBox_subsrd_sa_dlg").parent())[3]).hide();
    
   clear_dlg_subsrd_sa();
    if(c_id>0 )
    {                                 
        //$("#dlgSubsrdSaMi_code").prop('disabled', 'disabled');
        $($("button", $("#dialogBox_subsrd_sa_dlg").parent())[0]).hide();
        $($("button", $("#dialogBox_subsrd_sa_dlg").parent())[1]).show();
       do_get_subsrd_sa();
    }
    else
    {
        //$("#dlgSubsrdSaMi_code").removeAttr('disabled');
        $($("button", $("#dialogBox_subsrd_sa_dlg").parent())[0]).show();
        $($("button", $("#dialogBox_subsrd_sa_dlg").parent())[1]).hide();
        get_mi_subsrd_sa_dlg('');
    }    
    $("#dialogBox_subsrd_sa_dlg").dialog("open");
}
function close_dlg_subsrd_sa()
{
    subsrd_sa_id=0;
    $("#dialogBox_subsrd_sa_dlg").dialog("close");
}

function clear_dlg_subsrd_sa()
{
    $("#dlgSubsrdSa_code").val('');
    $("#dlgSubsrdSa_name").val('');
    $("#dlgSubsrdSaC_code").val('');
}
function refresh_subsrd_sa()
{
    get_mi_subsrd_sa_dlg();
    state_progress(1);
    data_subsrd_sa.length=0;        
    var obj_post = $.post(uri+"/index.php/subsrd_sa/list_sa", {},function(data) {
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        
        for (var i=0; i<msg.r_num_rows; i++) {
            var d = (data_subsrd_sa[i] = {});
            d["sa_id"] = msg.r_sdata[i].sa_id;
            d["mi_code"] = msg.r_sdata[i].mi_code;
            d["sa_name"] = msg.r_sdata[i].sa_name;
            d["sa_enable"] = msg.r_sdata[i].sa_enable==1?"Enable":"Disable";
            d["modified_by"] = msg.r_sdata[i].modified_by;
            d["modified_dt"] = msg.r_sdata[i].modified_dt_s;
        }
        
        grid_subsrd_sa.invalidateAllRows();
        grid_subsrd_sa.updateRowCount();
        grid_subsrd_sa.render();                
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        grid_subsrd_sa.invalidateAllRows();
        grid_subsrd_sa.updateRowCount();
        grid_subsrd_sa.render();
        state_progress(0);}
    );
}

function create_subsrd_sa_event()
{
    $("#hbtn_subsrd_sa_add").click(function(){   
            open_dlg_subsrd_sa(0);
    });
    grid_subsrd_sa.onDblClick.subscribe(function(e) { 
        var selected_row_subsrd  = grid_subsrd_sa.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_sa_id=data_subsrd_sa[selected_row_subsrd.row].sa_id;
            open_dlg_subsrd_sa(1);
        } 
    });
    $("#hbtn_subsrd_sa_edit").click(function(){ 
        var selected_row_subsrd  = grid_subsrd_sa.getActiveCell();
        if(selected_row_subsrd)
        {
            subsrd_sa_id=data_subsrd_sa[selected_row_subsrd.row].sa_id;
            open_dlg_subsrd_sa(1);
        } 
    });
    $("#hbtn_subsrd_sa_reload").click(function(){   //  alert('a');
            refresh_subsrd_sa();
    });
}

function do_add_subsrd_sa()
{                              
    if(do_subsrd_sa==0)
    {
        do_subsrd_sa=1;
        var b_bmicode = $("#dlgSubsrdSaMi_code").val(); 
        var b_bcname = $("#dlgSubsrdSa_name").val(); 
        var b_benable = $("#dlgSubsrdSa_enable").val();
        
        state_progress(1);
        
        var obj_post = $.post(uri_subsrd_sa+"add_sa", {
            b_micode:b_bmicode,b_cname:b_bcname,b_enable:b_benable
        },function(data) {
            //alert(data);
        },'json'); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_sa();
            do_subsrd_sa=0;
            close_dlg_subsrd_sa();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd_sa=0;state_progress(0);});
    }

}
function do_edit_subsrd_sa()
{                                       
    if(do_subsrd_sa==0)
    {                   
        do_subsrd_sa=1;
        var b_bmicode = $("#dlgSubsrdSaMi_code").val(); 
        var b_bcname = $("#dlgSubsrdSa_name").val(); 
        var b_benable = $("#dlgSubsrdSa_enable").val();
        state_progress(1);
        
        var obj_post = $.post(uri_subsrd_sa+"edit_sa", {
            b_said:subsrd_sa_id,b_micode:b_bmicode,b_cname:b_bcname,b_enable:b_benable
        },function(data) {
            //alert(data);
        },'json'); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_sa();
            do_subsrd_sa=0;
            close_dlg_subsrd_sa();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd_sa=0;state_progress(0);});
    }

}
function do_get_subsrd_sa()
{
    if(do_subsrd_sa==0)
    {
        do_subsrd_sa=1;
        state_progress(1);
                                        
        var obj_post = $.post(uri_subsrd_sa+"get_sa", {
            b_id:subsrd_sa_id
        },function(data) {
            //alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgSubsrdSa_name").val(msg.r_sdata[0].sa_name);
                $("#dlgSubsrdSaMi_code").val(msg.r_sdata[0].mi_code);
                $("#dlgSubsrdSa_enable").val(msg.r_sdata[0].sa_enable);  
            }
            state_progress(0);
            do_subsrd_sa=0;               
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd_sa=0;state_progress(0);});
    }

}

function do_enable_subsrd_sa(penable)
{
    if(do_subsrd_sa==0)
    {                   
        do_subsrd_sa=1;
        state_progress(1);
        
        var obj_post = $.post(uri+"/index.php/subsrdcript_client/enable_client", {
            b_id:subsrd_sa_id,b_ena:penable
        },function(data) {
           // alert(data);
        },"json"); 
        obj_post.done(function(msg) { 
            state_progress(0);
            refresh_subsrd_sa();
            do_subsrd_sa=0;
            close_dlg_subsrd_sa();
        });
        
        obj_post.fail(function(jqXHR, textStatus) {do_subsrd_sa=0;state_progress(0);});
    }

}
