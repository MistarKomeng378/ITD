var grid_subsrd;
var data_subsrd = [];

var subsrd_edited_trx=0;
var subsrd_id=0;
//var do_subsrd=0;
//var do_subsrd_a=0;
//var data_subsrd_param = [];


function initiate_subsrd()
{
    add_section("content_subsrd","data_subsrd","refresh_subsrd()","hbtn_subsrd","grid_subsrd");
    
    get_content_subsrd();       
}
function get_content_subsrd()
{             
    var obj_post = $.post(uri_subsrd_dlg,{},function(data) {
        $("#content_subsrd").html(data);
    });
    obj_post.done(function(msg) {   
        create_dlg_dpicker_subsrd();
        create_subsrd_event();
        $("#i_subsrd_client_dt").val(saiki);
        //get_content_user_subsrd();
    });
}

function create_dlg_dpicker_subsrd()
{                      
    var dpick_opt_subsrd ={
        cols : [         
                    {id:"client_code", name:"Code", field:"client_code",width:100}
                   ,{id:"client_name", name:"Account Name", field:"client_name",width:380}
            ],
        url: uri_subsrd+"list_client_by_code",
        setval: function(obj_val){                      
            $("#i_subsrd_client_code").val(trim(obj_val.client_code));
            $("#i_subsrd_client_code_h").val(trim(obj_val.client_code));
            $("#i_subsrd_client_name").val(obj_val.client_name);
            subsrd_get_status(trim(obj_val.client_code));      
            list_subsrd_rekap(trim(obj_val.client_code),$("#i_subsrd_client_dt").val()); 
            
            
        }
    }; 
    dPicker_attach($("#i_subsrd_client_code"),dpick_opt_subsrd);        
}
function subsrd_get_status(pc_code)
{                            
    state_progress(1);
    var obj_post = $.post(uri_subsrd+"get_status", {c_code:pc_code},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) { 
        if(msg.r_num_rows>0)
        {
            $("#i_subsrd_client_last_date").val(msg.r_sdata[0].subsrd_date_s);
            $("#i_subsrd_client_closed_date").val(msg.r_sdata[0].last_closed_s);
            $("#i_subsrd_client_status").val(msg.r_sdata[0].subsrd_status==1?'Closed':'Open');
            setTimeout(function() {   
                show_hide_add_subsrd(1);
            },1);            
        }
        else
        {
            $("#i_subsrd_client_last_date").val('');
            $("#i_subsrd_client_status").val('');   
            $("#i_subsrd_client_closed_date").val('');
        }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function list_subsrd_rekap(pc_code,pc_dt)    
{                           
    state_progress(1);  
    var obj_post = $.post(uri_subsrd+"view_rekap_data",{c_code:pc_code,c_dt:pc_dt},function(data) {
        $("#subsrd_rekap").html(data);
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function refresh_subsrd()
{   
    list_subsrd_rekap($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val());
}
function create_subsrd_event()
{
    $("#i_subsrd_client_dt").datepicker();
    $("#i_subsrd_client_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
   
    $("#i_subsrd_client_dt").change(function(){
        list_subsrd_rekap($("#i_subsrd_client_code_h").val(),this.value);
    }); 
    $("#hbtn_subsrd_reload1").click(function(){      
        list_subsrd_rekap($("#i_subsrd_client_code_h").val(),$("#i_subsrd_client_dt").val());
    });   
    $("#hbtn_subsrd_cancel_close_day").click(function(){
        if($("#i_subsrd_client_code_h").val()!='')
        {
            if(confirm("Status akhir hari mutasi pada tanggl " + $("#i_subsrd_client_closed_date").val()  + " di batalkan?"))
            {
                var obj_post = $.post(uri_subsrd+"cancel_close_day", {
                    c_code:$("#i_subsrd_client_code_h").val(),
                    c_dt:$("#i_subsrd_client_dt").val()
                },function(data) {
                    //alert(data);
                },"json"); 
                obj_post.done(function(msg) { 
                   if(msg.r_num_rows>0)
                   {
                        if(msg.r_sdata[0].err==0)
                        {
                            alert('Cancel Close day success!');
                            subsrd_get_status($("#i_subsrd_client_code_h").val());      
                        }
                        else
                            alert('Cancel Close day error!');
                   }
                   else
                        alert('Cancel Close day error!');
                });
                
                obj_post.fail(function(jqXHR, textStatus) {alert("Error mengecek client!");});
            }
        }
        else
            alert("Please choose the client!");
        
    });
}



