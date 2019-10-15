function get_content_pass(no)
{
    var obj_post = $.post(uri_dlg_user + '/' + no,{},function(data) {
    });
    obj_post.done(function(msg) { 
        if (no==2)
            $("#dialogBox_user_change_pass").html(msg);
    });
}
function create_dlg_pass()
{
    get_content_pass(2);
    $("#dialogBox_user_change_pass").dialog({ 
            title:        'Change Pass'
        ,    width:        280
        ,    height:        160
        ,    autoOpen:    false
        ,    resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,   buttons: {
             "Change Password": function(){do_change_pass_user();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function show_dlg_change_pass()
{ 
     $("#dialogBox_user_change_pass").dialog("open");
}
function close_dlg_change_pass()
{
    $("#dialogBox_user_change_pass").dialog("close");
}
function do_change_pass_user()
{                                  
    var pass1 = $("#dlgU_pass_2").val();
    var pass2 = $("#dlgU_pass1_2").val();
    if (!isValid(pass1))
    {
        alert("Must min 8 alphanumeric!");
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

    if(confirm("Save data?"))
    {           
        state_progress(1); 
        var obj_post = $.post(uri+"/index.php/itd_save/change_user_pass", 
            { user_pass_old:$("#dlgU_pass_old").val(),user_pass:$("#dlgU_pass_2").val()},function(data) {
        },"json");
        obj_post.done(function(msg) { 
            if(msg.e==0)
            {
                alert("Change password success!"); 
                close_dlg_change_pass();
            }
            else
                alert("Wrong old password!"); 
            state_progress(0);
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Change password error :" + textStatus);
            state_progress(0);
        });        
    }
}
function isValid(input)
{
     var reg = /^[^%\s]{8,}$/;
     var reg2 = /[a-zA-Z]/;
     var reg3 = /[0-9]/;
     return reg.test(input) && reg2.test(input) && reg3.test(input);
}
