var mutasi11_coa_no='';

function get_content_dlg_mutasi11_coa()
{             
    var obj_post = $.post(uri_dlg_mutasi11_coa,{},function(data) {
    });
    obj_post.done(function(msg) {         
        $("#dialogBox_mutasi11_coa").html(msg);
    });
}   
function create_dlg_mutasi11_coa()
{
    get_content_dlg_mutasi11_coa(); 
    $("#dialogBox_mutasi11_coa").dialog({ 
            title:        'Mutasi - Client'
        ,    width:        420
        ,    height:        220
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Simpan": function(){do_save_mutasi11_coa();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_coa(c_no)
{
    mutasi11_coa_no=c_no;
    do_refresh_dlg_mutasi11_coa();
    $("#dialogBox_mutasi11_coa").dialog("open");
}
function close_dlg_mutasi11_coa()
{
    mutasi11_coa_no='';
    $("#dialogBox_mutasi11_coa").dialog("close");
}
function do_save_mutasi11_coa()
{
    if(confirm("Save data?"))
    {
        //if(lvl<=5)
        {              
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/mutasi_coa_dlg/save_coa", 
                { coa_no:$("#dlgM11coa_no").val(), coa_desc:$("#dlgM11coa_desc").val(),coa_dc:$("#dlgM11coa_dc").val(),
                    coa_enable:$("#dlgM11coa_enable").val(),coa_order:$("#dlgM11coa_order").val()
                },function(data) { //alert(data);
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_mutasi11_coa();
                refresh_mutasi11_coa_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_refresh_dlg_mutasi11_coa()
{                                      
    if(mutasi11_coa_no=='')
        clear_field_mutasi11_coa();
    else
    {                                 
        state_progress(1);                            
        var obj_post = $.post(uri+"/index.php/mutasi_coa_dlg/get_coa", 
            {coa_no:mutasi11_coa_no},function(data) {  // alert(data);
        },"json");
        obj_post.done(function(msg) {   // alert(msg.r_num_rows);
            if(msg.r_num_rows>0)
            {
                $("#dlgM11coa_no").val(msg.r_sdata[0].coa_no);
                $("#dlgM11coa_desc").val(msg.r_sdata[0].coa_desc);
                $("#dlgM11coa_dc").val(msg.r_sdata[0].coa_dc);
                $("#dlgM11coa_enable").val(msg.r_sdata[0].coa_enable);
                $("#dlgM11coa_order").val(msg.r_sdata[0].coa_order);
                $("#dlgM11coa_no").attr("disabled",true); 
            }
            else
                clear_field_mutasi11_coa();
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) { 
            clear_field_mutasi11_coa();
            state_progress(0);
        });
    }
}
function clear_field_mutasi11_coa()
{
    mutasi11_coaid=0;
    $("#dlgM11coa_no").val('');
    $("#dlgM11coa_desc").val('');  
    $("#dlgM11coa_order").val('1000');
    $("#dlgM11coa_no").removeAttr("disabled"); 
}