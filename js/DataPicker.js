var dPicker_curr_no = -1;
var dPicker_no = [0,1,2];
var dPicker_url = ['a','b','c'];

var dPicker_grid;
var dPicker_data=[];
var dPicker_obj = '#dlg_dpicker';
var dPicker_obj_over = -1;
var dPicker_over = -1;

function dPicker_create(dp_no)
{
    
}
function dPicker_create_grid(dp_no)
{
    var dp_cols = [];
    var dp_opts = {
            editable: false
            , enableCellNavigation: true
            , asyncEditorLoading: false
            , enableRowNavigation: true
            , autoEdit: false
            , multiSelect: false
        };
    if(dp==0)   
    {
        dp_cols = [         
            {id:"bank_name", name:"Bank Name", field:"bank_name",width:320}
            ,{id:"pic_name", name:"PIC", field:"pic_name",width:130}
            ,{id:"bank_telp", name:"Telepon", field:"bank_telp"}
            ,{id:"bank_fax", name:"Fax", field:"bank_fax"}
            ,{id:"pic_remark1", name:"Remark 1", field:"pic_remark1"}
            ,{id:"pic_remark2", name:"Remark 2", field:"pic_remark2"}
        ];
        
    }
    dPicker_grid = new Slick.Grid(dPicker_obj, dPicker_data, dp_cols, dp_opts);
    dPicker_grid.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
}
function dPicker_refresh_grid_data()
{
    
}
function dPicker_clear_grid_data()
{
    
}
function dPicker_destroy_grid()
{
    
}
function dPicker_clear()
{
    
}
function dPicker_open()
{
    
}
function dPicker_close()
{
    
}
function dPicker_set_object()
{
    
}
function dPicker_set_event()
{
    
}
 