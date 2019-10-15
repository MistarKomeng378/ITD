var grid_pic;
var data_pic = [];

function initiate_pic()
{
    add_section("tbl_slick_pic","data_pic","refresh_pic_grid()","hbtn_pic","grid_pic");
    create_pic_grid();
    create_pic_event(); 
    create_dlg_pic(); 
    create_dlg_pic_search();  
}
function create_pic_grid()
{
    var columns_pic = [];
    var options_pic = [] ; 
    columns_pic = [         
        {id:"bank_name", name:"Bank Name", field:"bank_name",width:320}
        ,{id:"bank_rek", name:"No Rekening", field:"bank_rek",width:130}
        ,{id:"bank_acc_name", name:"Account Name", field:"bank_acc_name",width:220}
        ,{id:"pic_name", name:"PIC", field:"pic_name",width:130}
        ,{id:"bank_telp", name:"Telepon", field:"bank_telp"}
        ,{id:"bank_fax", name:"Fax", field:"bank_fax"}
        ,{id:"pic_remark1", name:"Remark 1", field:"pic_remark1"}
        ,{id:"pic_remark2", name:"Remark 2", field:"pic_remark2"}
    ];
    options_pic = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };         
    /*dataView_pf = new Slick.Data.DataView();
    grid_pf = new Slick.Grid("#dlg_list_pf_tbl", dataView_pf, columns_pf, options_pf);*/
    grid_pic = new Slick.Grid("#tbl_slick_pic", data_pic, columns_pic, options_pic);
    grid_pic.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_pic_grid()
{
    //state_progress(1);
    //alert(uri+"/index.php/itd/list_user");
    state_progress(1);
    data_pic.length=0;
    var obj_post = $.post(uri+"index.php/itd/list_pic",{},function(data) {
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_pic[i] = {});
           d["rec_no"] = data.r_sdata[i].row_num;
           d["pic_id"] = data.r_sdata[i].pic_id;
           d["bank_name"] = data.r_sdata[i].bank_name;
           d["bank_rek"] = data.r_sdata[i].bank_rek;
           d["bank_acc_name"] = data.r_sdata[i].bank_acc_name;
           d["pic_name"] = data.r_sdata[i].pic_name;  
           d["bank_telp"] = data.r_sdata[i].bank_telp;  
           d["bank_fax"] = data.r_sdata[i].bank_fax;
           d["pic_remark1"] = data.r_sdata[i].pic_remark1;
           d["pic_remark2"] = data.r_sdata[i].pic_remark2;
        }
    },"json");
    obj_post.done(function(msg){
        grid_pic.invalidateAllRows();
        grid_pic.updateRowCount();
        grid_pic.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}
function create_pic_event()
{
    $("#hbtn_pic_refresh").click(function(){
        refresh_pic_grid();
    });
    $("#hbtn_pic_new").click(function(){
        open_dlg_pic(0);
    });
    $("#hbtn_pic_search").click(function(){           
        open_dlg_pic_search();
    });
    $("#hbtn_pic_edit").click(function(){
        selected_row_pic  = grid_pic.getActiveCell();
        if(selected_row_pic)
            open_dlg_pic(data_pic[selected_row_pic.row].pic_id);
        else
            alert("No data selected!");
    });
    if(lvl<=5)
    {           
        $("#hbtn_pic_del").click(function(){
            if(confirm('Are u sure to delete this row?'))
            {
                selected_row_pic  = grid_pic.getActiveCell();
                if(selected_row_pic)           
                    delete_pic(data_pic[selected_row_pic.row].pic_id);
                else
                    alert("No data selected!");
            }
        });
    }
    grid_pic.onDblClick.subscribe(function(e) {     
        var cell = grid_pic.getCellFromEvent(e);
        //if(lvl<=5)
            open_dlg_pic(data_pic[cell.row].pic_id);
    });
}
function delete_pic(p_id)
{
    //state_progress(1);
    //alert(uri+"/index.php/itd/list_client");
    state_progress(1);
    data_client.length=0;
    var obj_post = $.post(uri+"index.php/itd_del/d_pic",{pic_id:p_id},function(data) {
    },"json");
    obj_post.done(function(msg){
        alert('Delete success!');
        state_progress(0);
        refresh_pic_grid();
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });
}