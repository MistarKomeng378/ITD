
function get_content_dlg_mutasi11_mfb()
{             
    var obj_post = $.post(uri_dlg_mutasi11_mfb,{},function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_mutasi11_mfb").html(msg);
        get_content_dlg_user_mutasi11_mfb();
    });
}
function get_content_dlg_user_mutasi11_mfb()
{
    $("#dlgM11Client_user").html('');
    var obj_post1 = $.post(uri+"/index.php/itd/list_user",{u_unit:1},function(data1) {   
        },"json");
    obj_post1.done(function(msg1) {    //alert(msg.r_num_rows);
        if(msg1.r_num_rows>0)
        {
            var sta='';
            for (var i=0; i<msg1.r_num_rows; i++) {
                sta=sta+'<option value="'+msg1.r_sdata[i].user_id+'">'+msg1.r_sdata[i].user_id+'</option>\n';
            }
            $("#dlgM11Client_user").html(sta);
        }
    });
}
function create_dlg_mutasi11_mfb()
{
    get_content_dlg_mutasi11_mfb()
    $("#dialogBox_mutasi11_mfb").dialog({ 
            title:        'Mutasi - Client'
        ,    width:        420
        ,    height:        320
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Simpan": function(){do_save_mutasi11_mfb();},
             "Ubah Rekening": function(){do_edit_rek_mutasi11_mfb();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_mfb(c_id,c_p)
{
    mutasi11_mfbid=c_id;
    do_refresh_dlg_mutasi11_mfb();
    if(c_p==1)
    {
        $($("button", $("#dialogBox_mutasi11_mfb").parent())[0]).hide();
        $($("button", $("#dialogBox_mutasi11_mfb").parent())[1]).show();
        $("#dlgM11Client_code").attr("disabled",false);
        $("#dlgM11Client_acc_no").attr("disabled",false);
        $("#dlgM11Client_bank").attr("disabled",true);
        $("#dlgM11Client_name").attr("disabled",true);
        $("#dlgM11Client_cif").attr("disabled",true);
        $("#dlgM11Client_cbest").attr("disabled",true);
        $("#dlgM11Client_user").attr("disabled",true);
        $("#dlgM11Client_internal").attr("disabled",true);
        $("#dlgM11Client_type").attr("disabled",true);
        $("#dlgM11Client_jasgir").attr("disabled",true);
    }
    else
    {
        $($("button", $("#dialogBox_mutasi11_mfb").parent())[0]).show();
        $($("button", $("#dialogBox_mutasi11_mfb").parent())[1]).hide();
        $("#dlgM11Client_code").attr("disabled",true);
        $("#dlgM11Client_acc_no").attr("disabled",true);
        $("#dlgM11Client_bank").attr("disabled",false);
        $("#dlgM11Client_name").attr("disabled",false);
        $("#dlgM11Client_cif").attr("disabled",false);
        $("#dlgM11Client_cbest").attr("disabled",false);
        $("#dlgM11Client_user").attr("disabled",false);
        $("#dlgM11Client_internal").attr("disabled",false);
        $("#dlgM11Client_type").attr("disabled",false);
        $("#dlgM11Client_jasgir").attr("disabled",false);
    }
    $("#dialogBox_mutasi11_mfb").dialog("open");
}
function close_dlg_mutasi11_mfb()
{
    mutasi11_mfbid=0;
    $("#dialogBox_mutasi11_mfb").dialog("close");
}
function do_save_mutasi11_mfb()
{
    var input_check = [
    {id:"dlgM11Client_code",empty:false,type:"s"}
    ,{id:"dlgM11Client_name",empty:false,type:"s"}
    ,{id:"dlgM11Client_acc_no",empty:false,type:"s"}
    ]
    if(!input_is_needed(input_check))
        return false;  
    if(confirm("Save data?"))
    {
        //if(lvl<=5)
        {              
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/mutasi_client_dlg/save_client", 
                { client_id:mutasi11_mfbid, client_user:$("#dlgM11Client_user").val(),client_code:$("#dlgM11Client_code").val(),
                    client_name:$("#dlgM11Client_name").val(),acc_no:$("#dlgM11Client_acc_no").val(), 
                    client_cif:$(  "#dlgM11Client_cif").val(), client_cbest:$(  "#dlgM11Client_cbest").val(),
                    client_internal:$(  "#dlgM11Client_internal").val() ,client_jasgir:$(  "#dlgM11Client_jasgir").val()
                    ,client_type:$(  "#dlgM11Client_type").val()
                    ,bank_name:$(  "#dlgM11Client_bank").val()
                },function(data) {
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_mutasi11_mfb();
                refresh_mutasi11_mfb_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_edit_rek_mutasi11_mfb()
{
    var input_check = [
    {id:"dlgM11Client_code",empty:false,type:"s"}
    ,{id:"dlgM11Client_name",empty:false,type:"s"}
    ,{id:"dlgM11Client_acc_no",empty:false,type:"s"}
    ]
    if(!input_is_needed(input_check))
        return false;  
    if(confirm("Mengubah kode klien atau no rekening pada seluruh data (client, mutasi, balance)?"))
    {
        //if(lvl<=5)
        {              
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/mutasi_client_dlg/edit_rek_client", 
                { client_code1:$("#dlgM11Client_code_h").val(),acc_no1:$("#dlgM11Client_acc_no_h").val(), 
                client_code2:$("#dlgM11Client_code").val(),acc_no2:$("#dlgM11Client_acc_no").val()
                },function(data) {
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_mutasi11_mfb();
                refresh_mutasi11_mfb_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}

function do_refresh_dlg_mutasi11_mfb()
{
    if(mutasi11_mfbid==0)
        clear_field_mutasi11_mfb();
    else
    {                                         
        state_progress(1);                            
        var obj_post = $.post(uri+"/index.php/mutasi_client_dlg/get_client", 
            {client_id:mutasi11_mfbid},function(data) {   
        },"json");
        obj_post.done(function(msg) {    //alert(msg.r_num_rows);
            if(msg.r_num_rows>0)
            {
                $("#dlgM11Client_user").val(msg.r_sdata[0].client_user);
                $("#dlgM11Client_code").val(msg.r_sdata[0].client_code);
                $("#dlgM11Client_code_h").val(msg.r_sdata[0].client_code);
                $("#dlgM11Client_name").val(msg.r_sdata[0].client_name);
                $("#dlgM11Client_acc_no").val(msg.r_sdata[0].acc_no);
                $("#dlgM11Client_acc_no_h").val(msg.r_sdata[0].acc_no);
                $("#dlgM11Client_cif").val(msg.r_sdata[0].client_cif);
                $("#dlgM11Client_cbest").val(msg.r_sdata[0].client_cbest);
                $("#dlgM11Client_bank").val(msg.r_sdata[0].bank_name);
                $("#dlgM11Client_internal").val(msg.r_sdata[0].bank_internal);
                $("#dlgM11Client_jasgir").val(msg.r_sdata[0].kena_jasgir);   
                $("#dlgM11Client_type").val(msg.r_sdata[0].client_type==3?'3':msg.r_sdata[0].client_type==2?'2':'1');
            }
            else
                clear_field_mutasi11_mfb();
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) { 
            clear_field_mutasi11_mfb();
            state_progress(0);
        });
    }
}
function clear_field_mutasi11_mfb()
{
    mutasi11_mfbid=0;
    $("#dlgM11Client_code").val('');
    $("#dlgM11Client_name").val('');
    $("#dlgM11Client_acc_no").val('');
    $("#dlgM11Client_cif").val('');
    $("#dlgM11Client_cbest").val('');         
}