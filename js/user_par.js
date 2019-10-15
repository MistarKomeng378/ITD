var grid_user_parameter;
var data_user_parameter = [];
  
function initiate_user_parameter()
{
    add_section("content_user_parameter","data_user_parameter","refresh_user_parameter()","hbtn_user_parameter","grid_user_parameter");
    get_content_user_parameter();
}
function get_content_user_parameter()
{             
    var obj_post = $.post(uri_user_parameter+'v_content',{},function(data) {
        $("#content_user_parameter").html(data);
        setTimeout(function() {    
            event_user_parameter();
        },1);
    });
    obj_post.done(function(msg) { 
        
    });
}

function refresh_user_parameter()
{                               
    state_progress(1);
    var obj_post = $.post(uri_user_parameter+"list_data", {},function(data) {
      //  alert(data);
    },"json"); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
        {
            $("#upar_ex_pass").val(msg.r_sdata[0]["user_pass_expired_days"]);
            $("#upar_ex_log").val(msg.r_sdata[0]["user_expired_days"]);
            $("#upar_max").val(msg.r_sdata[0]["user_pass_max"]);
            $("#upar_min").val(msg.r_sdata[0]["user_pass_min"]);
            $("#upar_alpha_num").val(msg.r_sdata[0]["user_pass_alpha_numeric"]);
            $("#upar_cap").val(msg.r_sdata[0]["user_pass_first_cap"]);
            $("#upar_wrong").val(msg.r_sdata[0]["user_pass_wrong_count"]);
            $("#upar_cycle").val(msg.r_sdata[0]["user_pass_recycle"]);
        }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {
        
        state_progress(0);}
    );
}
function event_user_parameter()
{
    $("#upar_upd").click(function(){
        if(confirm('Update the parameter?'))
            update_user_parameter();
    });
}
function update_user_parameter()
{
    state_progress(1);
    var obj_post = $.post(uri_user_parameter+"save_data", {
        c_ex_pass:$("#upar_ex_pass").val(),
        c_ex_log:$("#upar_ex_log").val(),
        c_max:$("#upar_max").val(),
        c_min:$("#upar_min").val(),
        c_alpha:$("#upar_alpha_num").val(),
        c_first:$("#upar_cap").val(),
        c_wrong:$("#upar_wrong").val(),
        c_cycle:$("#upar_cycle").val()
    },function(data) {
      if(data=='1')
        alert("Update success!");
      else
        alert("failed to update the prameter!");
    }); 
    obj_post.done(function(msg) { 
       
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {
        
        state_progress(0);}
    );
}