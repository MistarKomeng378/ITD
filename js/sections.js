//var var_form_number = ({});
/*var mySections = new Array("tbl_slick_trx","tbl_slick_pic","tbl_slick_client","tbl_slick_user");
var mySectionsData = new Array("data_trx","data_pic","data_client","data_user");
var mySectionsFunction = new Array("refresh_trx_grid()","refresh_pic_grid()","refresh_client_grid()","refresh_user_grid()");
var mySectionsButton = new Array("hbtn_trx","hbtn_pic","hbtn_client","hbtn_user");

var mySectionsCount = 4;

var curSection = -1;*/

var mySections =[];
var mySectionsData = [];
var mySectionsFunction = [];
var mySectionsButton = [];
var mySectionsGrid = [];
var mySectionsIsGrid = [];  

var mySectionsCount = 0;

var curSection = -1

function get_index_number(s_sect)
{
    return (mySections.indexOf(s_sect));
}

function refresh_section_grid(i_sect)
{
    
    for(var i=0;i<mySectionsCount;i++)
        eval(mySectionsData[i] + '.length=0');
    eval(mySectionsFunction[i_sect]);
}

function show_section_button(i_sect)
{
    for(var i=0;i<mySectionsCount;i++)
        eval('$("#' + mySectionsButton[i] + '").hide()');
    eval('$("#' + mySectionsButton[i_sect] + '").show()');             
}
                              
function hide_sections()
{
    if(curSection!=-1)
        $("#" + mySections[curSection]).fadeOut("slow");
    else
        for(var i=0;i<mySections.length;i++)
            $("#" + mySections[i]).fadeOut("slow");
}

function show_sections(s_sect)
{
    var i_sect = get_index_number(s_sect);
    
    if(i_sect!=curSection)
    {
        hide_sections();      
        if(mySectionsIsGrid[i_sect])
            refresh_section_grid(i_sect);         
        $("#" + mySections[i_sect]).fadeIn("slow");   
        show_section_button(i_sect);
        curSection=i_sect;
        resize_Canvas();
    }
}

function show_sections_only(s_sect)
{
    var i_sect = get_index_number(s_sect);
    
    if(i_sect!=curSection)
    {
        hide_sections();      
        // if(mySectionsIsGrid[i_sect])
        //    clear_bilyet_inst_grid(i_sect);         
        $("#" + mySections[i_sect]).fadeIn("slow");   
        show_section_button(i_sect);
        curSection=i_sect;
        resize_Canvas();
    }
}


function add_section(sect_div,sect_data,sect_func,sect_btn,sect_grid,sect_is_grid)
{
    mySections.push(sect_div);
    mySectionsData.push(sect_data);
    mySectionsFunction.push(sect_func);
    mySectionsButton.push(sect_btn);
    mySectionsGrid.push(sect_grid);        
    if (sect_is_grid==undefined)
        mySectionsIsGrid.push(true);
    else
        mySectionsIsGrid.push(sect_is_grid);
    mySectionsCount++;
}
function remove_section(sect_div)
{   
    var i = mySections.indexOf(sect_div);
    if(i>0)
    {
        mySections.splice(i,1);
        mySectionsData.splice(i,1);
        mySectionsFunction.splice(i,1);
        mySectionsButton.splice(i,1);
        mySectionsCount--;
        if(curSection==i)
        {
            curSection=-1;
            hide_sections();
        }
    }
}

function state_progress(state)
{
    if(state==1)
        $("#img_load").show();
    else
        $("#img_load").hide();
}

function resize_Canvas()
{
    if(curSection!=-1)
    eval(mySectionsGrid[curSection] + '.resizeCanvas()');
}

function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
Number.prototype.formatMoney = function(c, d, t){
var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
 };

function strtomoney(amount)
{
    var i = parseFloat(amount);
    if(isNaN(i)) { i = 0.00; }   
    return i.formatMoney(2,'.',',');
}

function clearFormatNumber(amount) {
    var a = amount;
    a = a.replace(/\,/g,'');
    return Number(a);
}
function strtofloat(str)
{
    var i = parseFloat(str.replace(/,/g,''));
    if(isNaN(i)) { i = 0.00; }   
    return i;
}

function parseDate(str,delim,no) {
    var mdy = str.split(delim)
    if (no == 1)
        return new Date(mdy[2], mdy[1]-1, mdy[0]);         // dmy
    else if(no==2)
        return new Date(mdy[2], mdy[0]-1, mdy[1]);        //  mdy
    else
        return new Date(mdy[0], mdy[1]-1, mdy[2]);        //  ymd
}

function daydiff(first, second1) {
    var second=1000, minute=second*60, hour=minute*60, day=hour*24, week=day*7;  
    return Math.ceil((second1.getTime()-first.getTime())/(day)) | 0;
}

function input_is_needed(arr_input)
{
    // arr_input = []
    // {id:"",empty:false,type:"[n,s,d]"}
    var is_complete = true;
    for(var i=0;i<arr_input.length;i++)
    {
        var obj_input = $("#"+arr_input[i].id);
        obj_input.removeClass('input_error');
        var txt = obj_input.val();
        if ((!arr_input[i].empty && /^\s*$/.test(txt)) || (!arr_input[i].empty && arr_input[i].type=='n' && $.trim(txt)=='0'))
        {
            is_complete = false;
            obj_input.addClass('input_error');
            continue;
        }
        if(! /^\s*$/.test(txt))
        {
            if (arr_input[i].type=='n' && !(/^\d*(\.)?\d*$/.test(txt)))
            {
                is_complete = false;
                obj_input.addClass('input_error');
                continue;
            }
            if (arr_input[i].type=='d' && !(/^[0-9]{1,2}-[0-9]{1,2}-[0-9]{4}$/.test(txt)))
            {
                is_complete = false;
                obj_input.addClass('input_error');
                continue;
            }
        }
    }
    return is_complete;
}
function input_is_needed_clear(arr_input)
{   
    for(var i=0;i<arr_input.length;i++)
    {
        $("#"+arr_input[i]).removeClass('input_error');
    }
}

function get_client_size() {
  var myWidth = 0, myHeight = 0;
  if( typeof( window.innerWidth ) == 'number' ) {
    //Non-IE
    myWidth = window.innerWidth;
    myHeight = window.innerHeight;
  } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
    //IE 6+ in 'standards compliant mode'
    myWidth = document.documentElement.clientWidth;
    myHeight = document.documentElement.clientHeight;
  } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
    //IE 4 compatible
    myWidth = document.body.clientWidth;
    myHeight = document.body.clientHeight;
  }
  return {width:myWidth,height:myHeight};
  //window.alert( 'Width = ' + myWidth );
  //window.alert( 'Height = ' + myHeight );                     
}

function daysBetween(first, second) {

    // Copy date parts of the timestamps, discarding the time parts.
    var one = new Date(first.getFullYear(), first.getMonth(), first.getDate());
    var two = new Date(second.getFullYear(), second.getMonth(), second.getDate());

    // Do the math.
    var millisecondsPerDay = 1000 * 60 * 60 * 24;
    var millisBetween = two.getTime() - one.getTime();
    var days = millisBetween / millisecondsPerDay;

    // Round down.
    return Math.floor(days);
}

function disableButton(pBt)
{
    $("#"+pBt).attr("disabled", "disabled");
}
function enableButton(pBt)
{
    $("#"+pBt).removeAttr("disabled");
}