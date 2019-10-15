var grid_tc5;
var data_tc5 = [];

function initiate_tc5()
{                              
    add_section("tbl_slick_tc5","data_tc5","refresh_tc5_grid()","hbtn_tc5","grid_tc5");
    create_tc5_grid();         
    create_tc5_event();
    create_dlg_tc5();  
    //create_dlg_tc5_search();  
}

function create_tc5_grid()
{    
    var columns_tc5 = [];
    var options_tc5 = [];
    
    columns_tc5 = [
        {id:"p_status", name:"Prt", field:"p_status",width:25}
        ,{id:"p_by", name:"Printed By", field:"p_by",width:65}
        ,{id:"nfs_td", name:"NFS", field:"nfs_td",width:30,}
        ,{id:"c_code", name:"Client", field:"c_code",width:65}
        ,{id:"bnf_bank", name:"Bnf Bank Name", field:"bnf_bank",width:130}
        ,{id:"bnf_acc_no", name:"Bnf Acc No", field:"bnf_acc_no",width:80}
        ,{id:"bnf_nama", name:"Bnf Acc Name", field:"bnf_nama",width:150}
        ,{id:"db_acc_no", name:"Debet Rek No", field:"db_acc_no",width:80}
        ,{id:"amount", name:"Amount", field:"amount",cssClass:"cell_right",width:120}             
        ,{id:"amount_say", name:"Verb Amount", field:"amount_say",width:150}
        ,{id:"charges", name:"Charges", field:"charges",cssClass:"cell_right",width:140}
        ,{id:"msg", name:"Message", field:"msg",width:240}
        ,{id:"sender_name", name:"Sender's Name", field:"sender_name",width:240}
        ,{id:"dt", name:"Val Date", field:"dt",width:80}
    ];
    options_tc5 = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , autoEdit: false
        , multiSelect: false
    };
    grid_tc5 = new Slick.Grid("#tbl_slick_tc5", data_tc5, columns_tc5, options_tc5);
    grid_tc5.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}

function refresh_tc5_grid()
{  
    state_progress(1);
    data_tc5.length=0;
    var obj_post = $.post(uri+"index.php/tc5/list_tc5",{
        vdt:$("#hbtn_tc5_dt").val(), vccode:$("#hbtn_client_code").val()
        , vbank:$("#hbtn_bnf_bank").val(),vname:$("#hbtn_bnf_name").val()
    },function(data) {                                            //  alert(data);
        for (var i=0; i<data.r_num_rows; i++) {
           var d = (data_tc5[i] = {});
           d["p_status"] = data.r_sdata[i].printed_status;
           d["p_by"] = data.r_sdata[i].printed_by;
           d["c_code"] = data.r_sdata[i].trx_client_code;
           d["nfs_td"] = (data.r_sdata[i].nfs_td=='1'?'PTP':'');
           d["bnf_bank"] = data.r_sdata[i].beneficiary_bank;
           d["bnf_acc_no"] = data.r_sdata[i].beneficiary_acc_no;
           d["bnf_nama"] = data.r_sdata[i].beneficiary_name;
           d["db_acc_no"] = data.r_sdata[i].src_acc_no;  
           d["amount"] = strtomoney(data.r_sdata[i].amount);
           d["amount_say"] = data.r_sdata[i].amount_said;
           d["msg"] = data.r_sdata[i].msg;
           d["sender_name"] = data.r_sdata[i].sender_name;
           d["tc5_id"] = data.r_sdata[i].tc5_id;
           d["trx_id"] = data.r_sdata[i].trx_id;
           d["pic_id"] = data.r_sdata[i].pic_id;
           d["no_unix"] = data.r_sdata[i].no_unix;
           d["charges"] = strtomoney(data.r_sdata[i].charges);
           d["dt"] = data.r_sdata[i].trx_valuta_date_s;
           
        }
    },"json");
    obj_post.done(function(msg){
        grid_tc5.invalidateAllRows();
        grid_tc5.updateRowCount();
        grid_tc5.render();
        state_progress(0);
    });
    obj_post.fail(function(jqXHR, textStatus) {    
        alert("Error getting data :" + textStatus);
        state_progress(0);
    });     
}

function create_tc5_event()
{
    $("#hbtn_tc5_dt").datepicker();
    $("#hbtn_tc5_dt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
    $("#hbtn_tc5_dt").val(saiki); 
    
    $("#hbtn_tc5_refresh").click(function(){
        refresh_tc5_grid();
    });
    
    $("#hbtn_tc5_print").click(function(){ 
        selected_row_tc5  = grid_tc5.getActiveCell();
        if(selected_row_tc5)
        {
            //alert(data_tc5[selected_row_tc5.row].tc5_id);
            //alert(data_tc5[selected_row_tc5.row].trx_id);
            //alert(data_tc5[selected_row_tc5.row].no_unix);
            open_dlg_tc5(data_tc5[selected_row_tc5.row].tc5_id,data_tc5[selected_row_tc5.row].trx_id,data_tc5[selected_row_tc5.row].no_unix);
        }
        else
            alert("No data selected!");
    });
    grid_tc5.onDblClick.subscribe(function(e) {     
        var cell = grid_tc5.getCellFromEvent(e);    
        open_dlg_tc5(data_tc5[cell.row].tc5_id,data_tc5[cell.row].trx_id,data_tc5[cell.row].no_unix);
    });
    /*    
    $("#hbtn_tc5_search").click(function(){ 
        open_dlg_tc5_search();
    });
    
    $("#hbtn_tc5_edit").click(function(){
        selected_row_tc5  = grid_tc5.getActiveCell();
        if(selected_row_tc5)
            open_dlg_tc5(data_tc5[selected_row_tc5.row].client_id);
        else
            alert("No data selected!");
    });
    if(lvl<=5)
    {
        $("#hbtn_tc5_approve").click(function(){
            selected_row_tc5  = grid_tc5.getActiveCell();
            if(selected_row_tc5)
            {
                if(data_tc5[selected_row_tc5.row].client_id)
                {                                                     
                    if(data_tc5[selected_row_tc5.row].client_status!='Approved')
                    {   
                        var psn_confirm = 'Are u sure to approve?';
                        psn_confirm = psn_confirm + "\nClient Code: " + data_tc5[selected_row_tc5.row].client_code;
                        psn_confirm = psn_confirm + "\nClient Name: " + data_tc5[selected_row_tc5.row].client_name;
                        psn_confirm = psn_confirm + "\nBank Name: " + data_tc5[selected_row_tc5.row].client_bank;
                        psn_confirm = psn_confirm + "\nBank Account Name: " + data_tc5[selected_row_tc5.row].client_acc_name;
                        psn_confirm = psn_confirm + "\nBank Account No: " + data_tc5[selected_row_tc5.row].client_acc_no;
                        psn_confirm = psn_confirm + "\CIF No: " + data_tc5[selected_row_tc5.row].client_acc_cif;
                        if(confirm(psn_confirm))
                            approve_tc5(data_tc5[selected_row_tc5.row].client_id);
                    }
                    else
                        alert('Approved Already!');
                }
                else
                    alert("No data selected!");
            }
            else
                alert("No data selected!");
        });
        $("#hbtn_tc5_del").click(function(){
            if(confirm('Are u sure to delete this row?'))
            {
                selected_row_tc5  = grid_tc5.getActiveCell();
                if(selected_row_tc5)
                    delete_tc5(data_tc5[selected_row_tc5.row].client_id);
                else
                    alert("No data selected!");
            }
        });
    }
    
    */
}


function do_print_trx(tc5id)
{
    loadPrintDocument(uri+'index.php/tc5/print_tc5/'+tc5id);
}