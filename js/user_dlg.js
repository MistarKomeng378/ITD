var userid='';

function get_content_user(no)
{             
    var obj_post = $.post(uri_dlg_user + '/' + no,{},function(data) {
    });
    obj_post.done(function(msg) {                          
        if(no==0)
            $("#dialogBox_user").html(msg);
        else if (no==1)
            $("#dialogBox_user_reset_pass").html(msg);
        else if (no==2)
            $("#dialogBox_user_change_pass").html(msg);
        get_unit_dlg_user();
    });
}
function get_unit_dlg_user()
{ 
    state_progress(1);                            
    var obj_post = $.post(uri+"/index.php/itd/list_unit", 
        { },function(data) {   
    },"json");
    obj_post.done(function(msg) { 
        var sta='';
        for (var i=0; i<msg.r_num_rows; i++) {
            sta=sta+'<option value="'+msg.r_sdata[i].unit_id+'">'+msg.r_sdata[i].unit_desc+'</option>';
        }
        $("#dlgU_group").html(sta);
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) { 
        clear_field_user();
        state_progress(0);
    });
}
function create_dlg_user()
{
    get_content_user(0);
    $("#dialogBox_user").dialog({ 
            title:        'New User'
        ,    width:        300
        ,    height:        260
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Simpan": function(){do_save_user();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
    get_content_user(1);
    $("#dialogBox_user_reset_pass").dialog({ 
            title:        'Reset Pass'
        ,    width:        280
        ,    height:        145
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Reset Password": function(){do_reset_user_pass();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_user(u_id)
{
    userid=u_id;
    do_refresh_user();
    $("#dialogBox_user").dialog("open");
}
function open_dlg_user_reset_pass(u_id)
{                    
    userid=u_id;            
    $("#dlgU_uid_1").val(u_id);
    $("#user_name1").html(u_id);
    $("#dialogBox_user_reset_pass").dialog("open");
}
function close_dlg_user()
{
    userid='';
    $("#dialogBox_user").dialog("close");
}
function close_dlg_reset_user()
{
    userid='';
    $("#dialogBox_user_reset_pass").dialog("close");
}
function do_save_user()
{

    var pass1 = $("#dlgU_pass").val();
    var pass2 = $("#dlgU_pass1").val();
    if(userid=='')
    {
        if (!isValid(pass1))
        {
            alert("Password at less 8 alphanumeric!");
            return 0;
        }
        if(pass1=='')
        {
            alert('Password kosong!');
            return 0;
        }
        if(pass1!=pass2)
        {
            alert('Password tidak match');
            return 0;
        }
    }
    if(confirm("Save data?"))
    {
        if(lvl<=0)
        {
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/itd_save/save_user", 
                { uid:userid, user_id:$("#dlgU_login").val(),
                    user_name:$("#dlgU_name").val(),user_pass:$("#dlgU_pass").val(), 
                    user_lvl:$("#dlgU_lvl").val(), user_active:$("#dlgU_aktif").val(),
                    user_group:$("#dlgU_group").val(), user_lock:$("#dlgU_lock").val()
                },function(data) {
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_user();
                refresh_user_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function do_refresh_user()
{
    if(userid=='')
        clear_field_user();
    else
    {
        state_progress(1);                            
        var obj_post = $.post(uri+"/index.php/itd/get_user", 
            { user_id:userid },function(data) {   
        },"json");
        obj_post.done(function(msg) { 
            if(msg.r_num_rows>0)
            {
                $("#dlgU_login").val(msg.r_sdata[0].user_id);
                $("#dlgU_name").val(msg.r_sdata[0].user_name);
                $("#dlgU_lvl").val(msg.r_sdata[0].user_lvl);
                $("#dlgU_group").val(msg.r_sdata[0].user_unit);
                $("#dlgU_aktif").val(msg.r_sdata[0].user_active);
                $("#dlgU_lock").val(msg.r_sdata[0].user_locked);
                $("#dlgU_login").attr("disabled",true);
                $("#dlgU_pass").attr("disabled",true);
                $("#dlgU_pass1").attr("disabled",true);
            }
            else
                clear_field_user();
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) { 
            clear_field_user();
            state_progress(0);
        });
    }
}
function clear_field_user()
{
    userid=0;
    $("#dlgU_login").val('');
    $("#dlgU_name").val('');
    $("#dlgU_pass").val('');
    $("#dlgU_pass1").val('');
    $("#dlgU_lvl").val('10');
    $("#dlgU_aktif").val('0');
    $("#dlgU_login").removeAttr("disabled");
    $("#dlgU_pass").removeAttr("disabled");
    $("#dlgU_pass1").removeAttr("disabled");
}
function do_reset_user_pass()
{
    var pass1 = $("#dlgU_pass_1").val();
    var pass2 = $("#dlgU_pass1_1").val();
    if (!isValid(pass1))
    {
        alert("Password at less 8 alphanumeric!");
        return 0;
    }
    if(userid!='' && userid!='0')
    {
        if(pass1=='')
        {
            alert('Password kosong!');
            return 0;
        }
        if(pass1!=pass2)
        {
            alert('Password tidak match');
            return 0;
        }
    }
    else
    {
        alert("Empty user!");
        return 0;
    }
    if(confirm("Save data?"))
    {
        if(lvl<=0)
        {
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/itd_save/reset_user_pass", 
                { uid:userid, user_pass:$("#dlgU_pass_1").val()},function(data) {
            },"json");
            obj_post.done(function(msg) { 
                alert("Reset password success!"); 
                state_progress(0);
                close_dlg_reset_user();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Reset password error :" + textStatus);
                state_progress(0);
            });
        }
    }
}