var grid_mail;
var data_mail = [];
var mail_no='';

function initiate_mail()
{
    add_section("tbl_slick_mail","data_mail","refresh_mail_grid()","hbtn_mail","grid_mail");
    create_mail_grid();
    create_mail_event();
    create_dlg_mail();
}

function create_mail_grid()
{
    var columns_mail = [];
    var options_mail = [] ;
    columns_mail = [
        {id:"notif_type", name:"Default", field:"notif_type"}
        ,{id:"mail_host", name:"Mail Host", field:"mail_host",width:120}
        ,{id:"mail_port", name:"Mail Port", field:"mail_port",width:50}
        ,{id:"mail_username", name:"Mail UserName", field:"mail_username",width:170}
        ,{id:"mail_from", name:"Mail From", field:"mail_from",width:130}
        ,{id:"mail_fromname", name:"Mail From Name", field:"mail_fromname",width:160}
        ,{id:"mail_to", name:"Mail To", field:"mail_to",width:300} 
    ];
    options_mail = {
        editable: false,
        enableCellNavigation: true,
        asyncEditorLoading: false,
        enableRowNavigation: true,
        autoEdit: false
    };         
    grid_mail = new Slick.Grid("#tbl_slick_mail", data_mail, columns_mail, options_mail);
    grid_mail.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}


function refresh_mail_grid()
{
    //state_progress(1);
    //alert(uri+"/index.php/itd/list_mail");
    state_progress(1);
    data_mail.length=0;
    var obj_post = $.post(uri+"index.php/itd_mail/list_mail",{},function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_mail[i] = {});
           d["notif_type"] = data.r_sdata[i].notif_type;
           d["mail_host"] = data.r_sdata[i].mail_host;
           d["mail_port"] = data.r_sdata[i].mail_port;  
           d["mail_username"] = data.r_sdata[i].mail_username;  
           d["mail_password"] = data.r_sdata[i].mail_password;  
           d["mail_from"] = data.r_sdata[i].mail_from;  
           d["mail_fromname"] = data.r_sdata[i].mail_fromname;
           d["mail_to"] = data.r_sdata[i].mail_to;
           d["mail_no"] = data.r_sdata[i].mail_no;
        }
    },"json");
    obj_post.done(function(msg){
        grid_mail.invalidateAllRows();
        grid_mail.updateRowCount();
        grid_mail.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function get_content_dlg_mail()
{             
    var obj_post = $.post(uri+"index.php/itd_mail/view_dlg",{},function(data) {
    });
    obj_post.done(function(msg) {         
        $("#dialogBox_mail").html(msg);
    });
}
function create_dlg_mail()
{
    get_content_dlg_mail(); 
    $("#dialogBox_mail").dialog({ 
            title:        'Mail Notification settings'
        ,    width:        420
        ,    height:        280
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Simpan": function(){do_save_mail();},
             "Batal": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mail(c_no)
{
    mail_no=c_no;
    if(c_no!=0)
    {
        selected_row_mail  = grid_mail.getActiveCell();
        if(selected_row_mail)
        {
            $("#dlgMail_default").val(data_mail[selected_row_mail.row].notif_type);
            $("#dlgMail_host").val(data_mail[selected_row_mail.row].mail_host);
            $("#dlgMail_port").val(data_mail[selected_row_mail.row].mail_port);
            $("#dlgMail_user").val(data_mail[selected_row_mail.row].mail_username);
            $("#dlgMail_password").val(data_mail[selected_row_mail.row].mail_password);
            $("#dlgMail_from").val(data_mail[selected_row_mail.row].mail_from);
            $("#dlgMail_fromname").val(data_mail[selected_row_mail.row].mail_fromname);
            $("#dlgMail_to").val(data_mail[selected_row_mail.row].mail_to);
        }
    }
    $("#dialogBox_mail").dialog("open");
}
function close_dlg_mail()
{
    $("#dialogBox_mail").dialog("close");
}
function refresh_dlg_mail(){
    mail_no=0;
    $("#dlgMail_default").val('none');
    $("#dlgMail_host").val('');
    $("#dlgMail_port").val('');
    $("#dlgMail_user").val('');
    $("#dlgMail_password").val('');
    $("#dlgMail_from").val('');
    $("#dlgMail_fromname").val('');
    $("#dlgMail_to").val('');
}
function do_save_mail()
{
    if(confirm("Save data?"))
    {
        //if(lvl<=5)
        {              
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/itd_mail/save_mail", 
                { mail_no:mail_no 
                 ,mail_host:$("#dlgMail_host").val()
                 ,mail_port:$("#dlgMail_port").val()
                 ,mail_user:$("#dlgMail_user").val()
                 ,mail_password:$("#dlgMail_password").val()
                 ,mail_from:$("#dlgMail_from").val()
                 ,mail_fromname:$("#dlgMail_fromname").val()
                 ,mail_to:$("#dlgMail_to").val()
                 ,mail_default:$("#dlgMail_default").val()
                },function(data) { //alert(data);
            },"json");
            obj_post.done(function(msg) { 
                alert("Saving data success!"); 
                state_progress(0);
                close_dlg_mail();
                refresh_mail_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Saving data error :" + textStatus);
                state_progress(0);
            });
        }
    }
}
function delete_mail(c_no)
{
        //if(lvl<=5)
        {              
            state_progress(1); 
            var obj_post = $.post(uri+"/index.php/itd_mail/delete_mail", 
                { mail_no:c_no
                },function(data) { //alert(data);
            },"json");
            obj_post.done(function(msg) { 
                state_progress(0);
                close_dlg_mail();
                refresh_mail_grid();
            });
            obj_post.fail(function(jqXHR, textStatus) {    
                alert("Deleting data error :" + textStatus);
                state_progress(0);
            });
        }
    
}
function create_mail_event()
{
    if(lvl<=5)
    {           
        $("#hbtn_mail_refresh").click(function(){
            refresh_mail_grid();
        });
        $("#hbtn_mail_new").click(function(){
            refresh_dlg_mail();
            open_dlg_mail(0);
        });
        $("#hbtn_mail_edit").click(function(){
            var selected_row_mail  = grid_mail.getActiveCell();     
            if(selected_row_mail)
                open_dlg_mail(data_mail[selected_row_mail.row].mail_no);
            else
                alert("No data selected!");
        });
    
        $("#hbtn_mail_del").click(function(){
            if(confirm('Are u sure to delete this row?'))
            {
                selected_row_mail  = grid_mail.getActiveCell();
                if(selected_row_mail)           
                {
                    if(data_mail[selected_row_mail.row].notif_type=='default')
                        alert('Can not delete default mail!');
                    else
                        delete_mail(data_mail[selected_row_mail.row].mail_no);
                }
                else
                    alert("No data selected!");
            }
        });
        grid_mail.onDblClick.subscribe(function(e) {     
            var cell = grid_mail.getCellFromEvent(e);
            open_dlg_mail(data_mail[cell.row].mail_no);
        });
    }
}
