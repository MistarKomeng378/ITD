var dPicker_grid;
var dPicker_data=[];
var dPicker_dlg ;
var dPicker_load ;
var dPicker_elmt;
var dPicker_initialized = false;

var dPicker_cur_id = -1;
var dPicker_id = [];
var dPicker_obj = [];
var dPicker_onshow = false;
var dPicker_pos = {top:0,left:0};

var dPicker_onMouseOver = false;
var dPicker_onElmtFocus = [];
var dPicker_onElOver = false;

var dPicker_load_img = uri +'/img/loading19.gif';

function dPicker_initialize()
{
    if (dPicker_initialized)
        return false;
    $(document).bind("mousedown.dPicker_event",function(event){ dPicker_hide();}); 
    dPicker_dlg = $('<div id="dPicker_Box" style="position: absolute; width: 500px; height: 200px; border: 1px solid #800000;display:none; z-index: 8000;  background-color: #800000;" class="ui-widget-content"></div>');
    dPicker_dlg.appendTo('body');
    dPicker_dlg.bind('mouseover.dPicker_event',function(event){ dPicker_onMouseOver = true;});
    dPicker_dlg.bind('mouseout.dPicker_event',function(event){ dPicker_onMouseOver = false;});
    dPicker_initialized = true;  
    dPicker_load = $('<img src="'+dPicker_load_img+'" style="position: absolute;display:none; z-index: 8001;" />');
    dPicker_load.appendTo('body');
}
$(document).ready(function () { dPicker_initialize();});

function dPicker_grid_create()
{
    dPicker_grid_destroy();
    var options = {
        editable: false
        , enableCellNavigation: true
        , asyncEditorLoading: false
        , enableRowNavigation: true
        , enableAsyncPostRender: true
        , autoEdit: false
        , multiSelect: false
    };
    dPicker_grid = new Slick.Grid(dPicker_dlg, dPicker_data, dPicker_obj[dPicker_cur_id].cols, options);
    dPicker_grid.setSelectionModel(new Slick.RowSelectionModel({selectActiveRow:true}));
    
    dPicker_grid.onDblClick.subscribe(function(e) {   
        var cell = dPicker_grid.getCellFromEvent(e);
        dPicker_obj[dPicker_cur_id].setval(dPicker_data[cell.row]);
        dPicker_hide_force();
        $('#'+dPicker_id[dPicker_cur_id]).focus();            
    }); 
    
}

function dPicker_grid_destroy()
{
    if(dPicker_cur_id>-1 && dPicker_grid)
        dPicker_grid.destroy();
}                                             
function dPicker_reload_data()
{             
    var elmt = $('#'+dPicker_id[dPicker_cur_id]);
    if($.trim(elmt.val())=='')
    {
        dPicker_grid.length=0;
        dPicker_grid.invalidateAllRows();
        dPicker_grid.updateRowCount();
        dPicker_grid.render();              
    }
    else
    {
        if(dPicker_onshow)                                                                      
            dPicker_load.css('left',dPicker_pos.left + 240).css('top',dPicker_pos.top+90).show();
        dPicker_data.length=0;
        var obj_post = $.post(dPicker_obj[dPicker_cur_id].url,{q:$.trim(elmt.val())},function(data) {
            for (var i=0; i<data.r_num_rows; i++) {
               var d = (dPicker_data[i] = {});
               for(var j=0;j<dPicker_obj[dPicker_cur_id].cols.length;j++)
               {
                   var k=dPicker_obj[dPicker_cur_id].cols[j].field;
                   eval('d["'+k+'"] = data.r_sdata['+i+'].'+k);
               }
            }
        },"json");
        obj_post.done(function(msg){
            dPicker_grid.invalidateAllRows();
            dPicker_grid.updateRowCount();
            dPicker_grid.render();
            dPicker_load.hide();
        });
        obj_post.fail(function(jqXHR, textStatus) {    
            alert("Error getting data :" + textStatus);
            dPicker_load.hide();
        });
    }    
}                      
function dPicker_show()
{                                                                      
    var elmt = $('#'+dPicker_id[dPicker_cur_id]);     
    if($.trim(elmt.val())=='')
        return false;           
    var this_pos = elmt.offset();   
    dPicker_pos.top = this_pos.top+elmt.height()+5;    
    dPicker_pos.left = this_pos.left;    
    dPicker_dlg.css('left',dPicker_pos.left).css('top',dPicker_pos.top).fadeIn("fast");
    dPicker_onshow = true; 
}
function dPicker_hide()
{                                  
    if(dPicker_onElmtFocus[dPicker_cur_id] && !dPicker_onElOver)
        if(!dPicker_onMouseOver)
        {
            $(dPicker_dlg).fadeOut("fast");
            dPicker_onshow = false;          
            dPicker_cur_id=-1;  
        }
}
function dPicker_hide_force()
{
   $(dPicker_dlg).hide();
   dPicker_onshow = false;       
}
function dPicker_attach(elmt,obj)
{                             
    if(!dPicker_initialized)
        dPicker_initialize();
    var elmt_id = elmt.attr('id');
    var indexNo= dPicker_id.indexOf(elmt_id);                  
    if(indexNo>-1)                                 
        return false;
    dPicker_id.push(elmt_id);
    dPicker_obj.push(obj);
    dPicker_onElmtFocus.push(false);
    elmt.keyup(function(e){
        
        dPicker_reload_data();
        if($.trim($(this).val()) == ''){
            dPicker_hide_force();
        }else{
            dPicker_show();
        }

    });
    elmt.blur(function(e){
        sleep(10);
        dPicker_onElOver=false;  
        dPicker_hide(); 
    });
    elmt.focus(function(e){
            var no_id= dPicker_id.indexOf($(this).attr('id')); 
            dPicker_onElmtFocus[no_id] = true;
            if (dPicker_cur_id != no_id)
            {
                dPicker_cur_id = no_id;
                dPicker_onElOver=true;
                dPicker_grid_create();
                //dPicker_show();
                //dPicker_reload_data();
            }
    });          
    return true;
}

/**
*   Need JQUERY & SLICKGRID to run this data picker
**/

/** Sample 
  var dpick_opt ={
        cols : [         
                {id:"bank_name", name:"Bank Name", field:"bank_name",width:320}
                ,{id:"pic_name", name:"PIC", field:"pic_name",width:130}
                ,{id:"bank_telp", name:"Telepon", field:"bank_telp"}
                ,{id:"bank_fax", name:"Fax", field:"bank_fax"}
                ,{id:"pic_remark1", name:"Remark 1", field:"pic_remark1"}
                ,{id:"pic_remark2", name:"Remark 2", field:"pic_remark2"}
            ],
        url:  "http://localhost/itd/index.php/itd/list_pic_by_bank",
        setval: function(obj_val){
             $("#idebug").html(obj_val.bank_name);   
        }
    };
    dPicker_attach($("#input_id"),dpick_opt);
**/
/**
*   cols: Columns use form slickgrid and field_name must sam as retrieved fields from url
*   url: adress for getting data   (in background, 'q' is the key for searching)
*   setval: function for callback when record is double clicked
**/