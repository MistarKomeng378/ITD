
var broker_mutasi11_bf=[];
var broker_mutasi11_bf_id=0;   

function get_content_dlg_mutasi11_bf()
{             
    var obj_post = $.post(uri_dlg_mutasi11_bf,{},function(data) {
    });
    obj_post.done(function(msg) {         
        $("#dialogBox_mutasi11_bf").html(msg);
        get_broker_dlg_mutasi11_bf();
        $("#i_mutasi11_bf_broker").autocomplete({
            source: broker_mutasi11_bf
        });
        create_mutasi11_bf_event_dlg();
    });
}   
function get_broker_dlg_mutasi11_bf()
{
    broker_mutasi11_bf.length=0;
    var obj_post1 = $.post(uri+"/index.php/mutasi_bf_dlg/list_broker", {},function(data) { //alert(data);
        },"json");
    obj_post1.done(function(msg1) { 
        for (var i=0; i<msg1.r_num_rows; i++) {
            broker_mutasi11_bf.push(msg1.r_sdata[i].fb_broker)
        }
    });
    
}
function create_dlg_mutasi11_bf()
{
    get_content_dlg_mutasi11_bf(); 
    $("#dialogBox_mutasi11_bf").dialog({ 
            title:        'Mutasi - Dokumen Fee Broker'
        ,    width:        580
        ,    height:        430
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Tambah": function(){do_add_mutasi11_bf();},
             "Ubah": function(){do_edit_mutasi11_bf();},
             "Hapus": function(){do_del_mutasi11_bf();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_bf_edit(p_id)
{
    //mutasi11_bf_no=c_no;
    do_refresh_dlg_mutasi11_bf_edit(p_id);
    $("#dialogBox_mutasi11_bf").dialog("open");
    $($("button", $("#dialogBox_mutasi11_bf").parent())[0]).hide();
    $($("button", $("#dialogBox_mutasi11_bf").parent())[1]).show();
    $($("button", $("#dialogBox_mutasi11_bf").parent())[2]).show();
}
function open_dlg_mutasi11_bf_new(p_ccode,p_accno,p_cname,p_dt,p_cat,p_cat_desc,p_desc,p_nominal)
{                                       
    //mutasi11_bf_no=c_no;
    clear_field_mutasi11_bf();                                     
    do_refresh_dlg_mutasi11_bf_new(p_ccode,p_accno,p_cname,p_dt,p_cat,p_cat_desc,p_desc,p_nominal);
    $($("button", $("#dialogBox_mutasi11_bf").parent())[0]).show();
    $($("button", $("#dialogBox_mutasi11_bf").parent())[1]).hide();
    $($("button", $("#dialogBox_mutasi11_bf").parent())[2]).hide();
    $("#dialogBox_mutasi11_bf").dialog("open");
}
function close_dlg_mutasi11_bf()
{
    //mutasi11_bf_no='';
    $("#dialogBox_mutasi11_bf").dialog("close");
}
function do_add_mutasi11_bf()
{
    if(confirm("Tambah data?"))
    {
        //if(lvl<=5)
        {              
            
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/mutasi_bf_dlg/add_bf", 
                { c_code:$("#s_mutasi11_bf_ccode").html(), c_accno:$("#s_mutasi11_bf_accno").html(),c_name:$("#s_mutasi11_bf_cname").html(),
                    c_dt:$("#s_mutasi11_bf_dt").html(),c_coa:$("#i_mutasi11_bf_coa_no").val(),c_coadesc:$("#s_mutasi11_bf_trx_type").html()
                    ,c_desc:$("#s_mutasi11_bf_trx_desc").html(),c_nominal:$("#i_mutasi11_bf_trx_nominal").val(),c_brokername:$("#i_mutasi11_bf_broker").val()
                    ,c_bfdesc:$("#i_mutasi11_bf_desc").val(),c_bfnominal:$("#i_mutasi11_bf_nominal").val(),c_doc:$("#i_mutasi11_bf_doc").val()
                    ,c_docdt:$("#i_mutasi11_bf_doc_dt").val(),c_setdt:$("#i_mutasi11_bf_settle_dt").val()
                },function(data) { 
                   // alert(data);
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_mutasi11_bf();
                refresh_mutasi11_bf_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_edit_mutasi11_bf()
{
    if(confirm("Ubah data?"))  
    {
        {              
            
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/mutasi_bf_dlg/edit_bf", 
                { c_id:broker_mutasi11_bf_id,c_brokername:$("#i_mutasi11_bf_broker").val()
                    ,c_bfdesc:$("#i_mutasi11_bf_desc").val(),c_bfnominal:$("#i_mutasi11_bf_nominal").val(),c_doc:$("#i_mutasi11_bf_doc").val()
                    ,c_docdt:$("#i_mutasi11_bf_doc_dt").val(),c_setdt:$("#i_mutasi11_bf_settle_dt").val()
                },function(data) { 
                //    alert(data);
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_mutasi11_bf();
                refresh_mutasi11_bf_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_del_mutasi11_bf()
{
    if(confirm("Yakin menghapus data?"))  
    {
        {              
            
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/mutasi_bf_dlg/del_bf", 
                { c_id:broker_mutasi11_bf_id
                },function(data) { 
                   // alert(data);
            },"json");
            obj_post.done(function(msg) { 
                state_progress(0);
                close_dlg_mutasi11_bf();
                refresh_mutasi11_bf_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Delete data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}

function do_refresh_dlg_mutasi11_bf_edit(p_id)
{                                      
    clear_field_mutasi11_bf();
    broker_mutasi11_bf_id=p_id;
    state_progress(1);              
    var obj_post = $.post(uri+"/index.php/mutasi_bf_dlg/get_bf_edit", 
        {ccode:p_id},function(data) { //  alert(data);
    },"json");
    obj_post.done(function(msg) {   // alert(msg.r_num_rows);
        if(msg.r_num_rows>0)
        {
            $("#s_mutasi11_bf_ccode").html(msg.r_sdata[0].client_code);
            $("#s_mutasi11_bf_accno").html(msg.r_sdata[0].acc_no);
            $("#s_mutasi11_bf_coa_no").html(msg.r_sdata[0].coa_no);
            $("#s_mutasi11_bf_cname").html(msg.r_sdata[0].client_name);
            $("#s_mutasi11_bf_dt").html(msg.r_sdata[0].fb_dt_s);
            $("#s_mutasi11_bf_trx_type").html(msg.r_sdata[0].coa_desc);
            $("#s_mutasi11_bf_trx_desc").html(msg.r_sdata[0].mutasi_desc);
            $("#i_mutasi11_bf_broker").val(msg.r_sdata[0].fb_broker);
            $("#i_mutasi11_bf_desc").val(msg.r_sdata[0].fb_desc);
            $("#i_mutasi11_bf_nominal").val(msg.r_sdata[0].fb_nominal);
            $("#i_mutasi11_bf_nominal1").val(strtomoney(msg.r_sdata[0].fb_nominal));
            $("#s_mutasi11_bf_trx_nominal").html(strtomoney(msg.r_sdata[0].trx_nominal));
            $("#i_mutasi11_bf_doc").val(msg.r_sdata[0].fb_doc_accepted);
            $("#i_mutasi11_bf_settle_dt").val(msg.r_sdata[0].fb_settle_dt_s);
        }
        else
            clear_field_mutasi11_bf();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) { 
        clear_field_mutasi11_bf();
        state_progress(0);
    });
}
function do_refresh_dlg_mutasi11_bf_new(p_ccode,p_accno,p_cname,p_dt,p_cat,p_cat_desc,p_desc,p_nominal)
{                                                               
    broker_mutasi11_bf_id=0;
    $("#s_mutasi11_bf_ccode").html(p_ccode);             
    $("#s_mutasi11_bf_accno").html(p_accno);
    $("#i_mutasi11_bf_coa_no").val(p_cat);
    $("#s_mutasi11_bf_cname").html(p_cname);
    $("#s_mutasi11_bf_dt").html(p_dt);           
    $("#s_mutasi11_bf_trx_type").html(p_cat_desc);           
    $("#s_mutasi11_bf_trx_desc").html(p_desc);                             
    $("#s_mutasi11_bf_trx_nominal").html(strtomoney(p_nominal));
    $("#i_mutasi11_bf_trx_nominal").val(p_nominal);
    $("#i_mutasi11_bf_doc").val(0); 
}

function clear_field_mutasi11_bf()
{
    $("#s_mutasi11_bf_ccode").html('');
    $("#s_mutasi11_bf_accno").html('');
    $("#s_mutasi11_bf_coa_no").html('');
    $("#s_mutasi11_bf_cname").html('');
    $("#s_mutasi11_bf_trx_type").html('');
    $("#s_mutasi11_bf_trx_desc").html('');
    $("#i_mutasi11_bf_broker").val('');
    $("#i_mutasi11_bf_desc").val('');
    $("#i_mutasi11_bf_nominal").val('');               
    $("#i_mutasi11_bf_nominal1").val('');               
    $("#i_mutasi11_bf_settle_dt").val(saiki);
    $("#i_mutasi11_bf_doc_dt").val(saiki);
}

function create_mutasi11_bf_event_dlg()
{
    $("#i_mutasi11_bf_doc_dt").datepicker();
    $("#i_mutasi11_bf_doc_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#i_mutasi11_bf_doc_dt").val(saiki);
    $("#i_mutasi11_bf_settle_dt").datepicker();
    $("#i_mutasi11_bf_settle_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#i_mutasi11_bf_settle_dt").val(saiki);
    
    $("#i_mutasi11_bf_nominal").keyup(function(){
        $("#i_mutasi11_bf_nominal1").val(strtomoney(this.value));
    });
}