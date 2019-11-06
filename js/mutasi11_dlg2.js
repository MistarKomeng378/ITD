

function get_content_mutasi11_2()
{                     
    var obj_post = $.post(uri_mutasi11_dlg2,function(data) {
    });
    obj_post.done(function(msg) { 
        $("#dialogBox_mutasi11_2").html(msg);
        $("#i_mutasi11_dlg2_pdt").datepicker();
        $("#i_mutasi11_dlg2_pdt").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        mutasi11_dlg2_create_event();
    });
}
function create_dlg_mutasi11_2()
{
    get_content_mutasi11_2()
    $("#dialogBox_mutasi11_2").dialog({ 
            title:        'Cetak Jasa Giro'
        ,    width:        800
        ,    height:        375
        ,    autoOpen:    false
        ,   resizable: false
        ,    closeOnEsc:    true
        ,    modal:        true
        ,buttons: {
             "Buat Jasa Giro": function(){act_mutasi11_2();}, 
             "Tutup": function(){ $(this).dialog("close");}
        }
    });
}
function open_dlg_mutasi11_2(ccode,cname,accno,cdt)
{           
    mutasi11_dlg2_clear();
    $("#i_mutasi11_dlg2_c_code").val(ccode);
    $("#i_mutasi11_dlg2_c_name").val(cname);
    $("#i_mutasi11_dlg2_acc_no").val(accno);
    
    $("#dialogBox_mutasi11_2").dialog("open");
    $("#i_mutasi11_dlg2_pdt").val(saiki);
    get_last_date_mutasi11_dlg2(ccode,accno,cdt);
    get_balance_mutasi11_dlg2(ccode,accno,cdt);
    get_giro_mutasi11_dlg2(ccode,accno,cdt,saiki);
}
function close_dlg_mutasi11_2()
{
    $("#dialogBox_mutasi11_2").dialog("close");
}

function get_last_date_mutasi11_dlg2(pc_code,pc_accno,pdt)
{                                                    
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/mutasi/get_last_balance_date", {c_code:pc_code,c_accno:pc_accno,cdt:pdt,cstatus:2},function(data) {
        //alert(data);
    },'json'); 
    obj_post.done(function(msg) {        
        if(msg.r_num_rows>0)
        {
            $("#i_mutasi11_dlg2_c_dt").val(msg.r_sdata[0].last_closed_date_s);
            $("#i_mutasi11_dlg2_c_dt1").val(msg.r_sdata[0].last_closed_date_s); 
            $("#i_mutasi11_dlg2_pdt").val(saiki);
            $("#i_mutasi11_dlg2_tenor").val(daysBetween(parseDate(msg.r_sdata[0].last_closed_date_s,'-',1),parseDate(saiki,'-',1)));
            rate();
        }
        else
        {
            $("#i_mutasi11_dlg2_c_dt").val('');
            $("#i_mutasi11_dlg2_c_dt1").val('');
        }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function get_balance_mutasi11_dlg2(pc_code,pc_accno)
{
    state_progress(1);
    var obj_post = $.post(uri+"/index.php/mutasi_dlg/get_last_balance", {c_code:pc_code,c_accno:pc_accno},function(data) {      
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) {        
        if(msg.r_num_rows>0)
        {                                                  
            $("#i_mutasi11_dlg2_cname").val(msg.r_sdata[0].client_name);
            $("#i_mutasi11_dlg2_ano").val(msg.r_sdata[0].acc_no);
            $("#i_mutasi11_dlg2_nml").val(msg.r_sdata[0].balance_gs);
            $("#i_mutasi11_dlg2_nml1").val(strtomoney(msg.r_sdata[0].balance_gs));
        }
        else
        {
            $("#i_mutasi11_dlg2_cname").val('');
            $("#i_mutasi11_dlg2_ano").val('');
            $("#i_mutasi11_dlg2_nml").val('0');
            $("#i_mutasi11_dlg2_nml1").val('0');
        }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function get_giro_mutasi11_dlg2(pc_code,pc_accno,pc_dt,pc_vdt)
{
    state_progress(1); 
    var obj_post = $.post(uri+"/index.php/mutasi_dlg/get_giro_val_asof", {c_code:pc_code,c_accno:pc_accno,c_dt:pc_dt,v_dt:pc_vdt},function(data) {      
        //alert(data);
    },"json"); 
    obj_post.done(function(msg) {        
        if(msg.r_num_rows>0)
        {                                                  
            $("#i_mutasi11_dlg2_rate").val(msg.r_sdata[0].giro_rate);
            $("#i_mutasi11_dlg2_year").val(msg.r_sdata[0].giro_year);
            $("#i_mutasi11_dlg2_rate1").val(strtomoney(msg.r_sdata[0].giro_rate));
            $("#i_mutasi11_dlg2_int").val(msg.r_sdata[0].giro_interest);
            $("#i_mutasi11_dlg2_tax").val(msg.r_sdata[0].giro_interest_tax);
            $("#i_mutasi11_dlg2_netint").val(msg.r_sdata[0].giro_interest_net);
            $("#i_mutasi11_dlg2_int1").val(strtomoney(msg.r_sdata[0].giro_interest));
            $("#i_mutasi11_dlg2_tax1").val(strtomoney(msg.r_sdata[0].giro_interest_tax));
            $("#i_mutasi11_dlg2_netint1").val(strtomoney(msg.r_sdata[0].giro_interest_net));
        }
        else
        {
            var t_or1 = daysBetween(parseDate(pc_dt,'-',1),parseDate(pc_vdt,'-',1));
            var i_nt1 = $("#i_mutasi11_dlg2_nml").val()*$("#i_mutasi11_dlg2_rate").val()/100/$("#i_mutasi11_dlg2_year").val()*t_or1;
            $("#i_mutasi11_dlg2_int").val(i_nt1);
            $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt1));
            var t_ax1 = i_nt1*20/100;
            $("#i_mutasi11_dlg2_tax").val(t_ax1);
            $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax1));
            var n_int1 = strtofloat(strtomoney(i_nt1))-strtofloat(strtomoney(t_ax1));
            $("#i_mutasi11_dlg2_netint").val(n_int1);
            $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int1));
            
            /*$("#i_mutasi11_dlg2_rate").val('');
            $("#i_mutasi11_dlg2_rate1").val('');
            $("#i_mutasi11_dlg2_int").val('');
            $("#i_mutasi11_dlg2_tax").val('');
            $("#i_mutasi11_dlg2_netint").val('');
            $("#i_mutasi11_dlg2_int1").val('0');
            $("#i_mutasi11_dlg2_tax1").val('0');
            $("#i_mutasi11_dlg2_netint1").val('0');
            */
        }
        state_progress(0);
    });
    
    obj_post.fail(function(jqXHR, textStatus) {state_progress(0);});
}
function mutasi11_dlg2_create_event()
{                                 
    var taxnya=20/100;
    $("#i_mutasi11_dlg2_pdt").change(function(){
        var t_or = daysBetween(parseDate($("#i_mutasi11_dlg2_c_dt").val(),'-',1),parseDate(this.value,'-',1));
        $("#i_mutasi11_dlg2_tenor").val(t_or);
        /*var i_nt = $("#i_mutasi11_dlg2_nml").val()*$("#i_mutasi11_dlg2_rate").val()/100/$("#i_mutasi11_dlg2_year").val()*t_or;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = i_nt-t_ax;
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));*/
        get_giro_mutasi11_dlg2($("#i_mutasi11_dlg2_c_code").val(),$("#i_mutasi11_dlg2_acc_no").val(),$("#i_mutasi11_dlg2_c_dt").val(),this.value);
    });
    $("#i_mutasi11_dlg2_rate").change(function(){
        var t_or = $("#i_mutasi11_dlg2_tenor").val();
        $("#i_mutasi11_dlg2_tenor").val(t_or);
        var i_nt = $("#i_mutasi11_dlg2_nml").val()*this.value/100/$("#i_mutasi11_dlg2_year").val()*t_or;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
        $("#i_mutasi11_dlg2_rate1").val($("#i_mutasi11_dlg2_rate").val());
    });
    $("#i_mutasi11_dlg2_rate").keyup(function(){
        var t_or = $("#i_mutasi11_dlg2_tenor").val();
        $("#i_mutasi11_dlg2_tenor").val(t_or);
        var i_nt = $("#i_mutasi11_dlg2_nml").val()*this.value/100/$("#i_mutasi11_dlg2_year").val()*t_or;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
        $("#i_mutasi11_dlg2_rate1").val($("#i_mutasi11_dlg2_rate").val());
    });
    $("#i_mutasi11_dlg2_tenor").keyup(function(){
        var t_or = this.value;
        $("#i_mutasi11_dlg2_tenor").val(t_or);
        var i_nt = $("#i_mutasi11_dlg2_nml").val()*$("#i_mutasi11_dlg2_rate").val()/100/$("#i_mutasi11_dlg2_year").val()*t_or;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
    });
    $("#i_mutasi11_dlg2_tenor").change(function(){
        var t_or = this.value;
        $("#i_mutasi11_dlg2_tenor").val(t_or);
        var i_nt = $("#i_mutasi11_dlg2_nml").val()*$("#i_mutasi11_dlg2_rate").val()/100/$("#i_mutasi11_dlg2_year").val()*t_or;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
    });
    $("#i_mutasi11_dlg2_int").change(function(){
        var i_nt = this.value;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
        
    });
    $("#i_mutasi11_dlg2_int").keyup(function(){
        var i_nt = this.value;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
    });
    $("#i_mutasi11_dlg2_tax").change(function(){
        var i_nt = $("#i_mutasi11_dlg2_int").val();
        var t_ax = this.value;        
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
        
    });
    $("#i_mutasi11_dlg2_tax").keyup(function(){
        var i_nt = $("#i_mutasi11_dlg2_int").val();
        var t_ax = this.value;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
    });
    /*$("#i_mutasi11_dlg2_netint").keyup(function(){
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(strtofloat(this.value)));
    });*/
    $("#i_mutasi11_dlg2_year").change(function(){
        var t_or = $("#i_mutasi11_dlg2_tenor").val();
        $("#i_mutasi11_dlg2_tenor").val(t_or);
        var i_nt = $("#i_mutasi11_dlg2_nml").val()*$("#i_mutasi11_dlg2_rate").val()/100/$("#i_mutasi11_dlg2_year").val()*t_or;
        $("#i_mutasi11_dlg2_int").val(i_nt);
        $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));
        var t_ax = i_nt*taxnya;
        $("#i_mutasi11_dlg2_tax").val(t_ax);
        $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));
        var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
        $("#i_mutasi11_dlg2_netint").val(n_int);
        $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
    });
}
function mutasi11_dlg2_calc_nominal(p_a)
{
    var pnl= 0+$("#i_mutasi11_dlg2_rate").val();
    var pn2= 0+$("#i_mutasi11_dlg2_tenor").val();
    var pn3= 0+$("#i_mutasi11_dlg2_nml").val();
    var pn4= 0+$("#i_mutasi11_dlg2_int").val();
    var pn5= 0+$("#i_mutasi11_dlg2_tax").val();
    if(p_a<=0)
    {
        
    }
}

function act_mutasi11_2()
{
    if(do_mutasi11_a==0)
    {
        if(confirm("Buat transaksi jasa giro?"))
        {              
            do_mutasi11_a=1;
            var addgir = 0;
            //if(confirm('Tambahkan juga mutasi giro ini di tanggal '+$("#i_mutasi11_dlg2_pdt").val()+'?'))
                addgir=1;
            state_progress(1);
            var obj_post = $.post(uri+"/index.php/mutasi_dlg/add_mutasi_giro", {
                v_dt:$("#i_mutasi11_dlg2_c_dt").val(),a_dt:$("#i_mutasi11_dlg2_pdt").val(),c_rate:$("#i_mutasi11_dlg2_rate1").val(),
                c_tenor:$("#i_mutasi11_dlg2_tenor").val(),c_year:$("#i_mutasi11_dlg2_year").val(),c_tenor:$("#i_mutasi11_dlg2_tenor").val(),
                c_code:$("#i_mutasi11_dlg2_c_code").val(),c_name:$("#i_mutasi11_dlg2_c_name").val(),c_accno:$("#i_mutasi11_dlg2_acc_no").val(),
                c_nml:$("#i_mutasi11_dlg2_nml1").val(),c_int:$("#i_mutasi11_dlg2_int1").val(),c_int_tax:$("#i_mutasi11_dlg2_tax1").val(),
                c_int_net:$("#i_mutasi11_dlg2_netint1").val(),c_add:addgir
            },function(data) {      
                do_mutasi11_a=0; //alert(data);
            },"json"); 
            obj_post.done(function(msg) {        
                if(msg.r_num_rows>0)
                {                                                                 // alert(msg.r_sdata[0].giro_id);
                    //loadPrintDocument(uri+'index.php/mutasi_dlg/print_1/'+msg.r_sdata[0].giro_id);
                    alert('Success membuat jasa giro!');
                    close_dlg_mutasi11_2();
                }
                state_progress(0);
            });
            
            obj_post.fail(function(jqXHR, textStatus) {state_progress(0);do_mutasi11_a=0;});
           
        }
    }
}   
function mutasi11_dlg2_clear()
{
    $("#i_mutasi11_dlg2_rate").val('');
    $("#i_mutasi11_dlg2_rate1").val('');
    $("#i_mutasi11_dlg2_int").val('');
    $("#i_mutasi11_dlg2_tax").val('');
    $("#i_mutasi11_dlg2_netint").val('');
    $("#i_mutasi11_dlg2_int1").val('');
    $("#i_mutasi11_dlg2_tax1").val('');
    $("#i_mutasi11_dlg2_netint1").val('');
}
function rate() {
    var nominal = $("#i_mutasi11_dlg2_nml").val();
    if(nominal >= 100000000 && nominal <=500000000){
        $("#i_mutasi11_dlg2_rate").val(1.5);
    }else if(nominal >= 500000000 && nominal <=5000000000){
        $("#i_mutasi11_dlg2_rate").val(2);
    }else{
        $("#i_mutasi11_dlg2_rate").val(2.5);
    }

    var pdt =$("#i_mutasi11_dlg2_pdt").val();
    var t_or = daysBetween(parseDate($("#i_mutasi11_dlg2_c_dt").val(),'-',1),parseDate(pdt,'-',1));
    $("#i_mutasi11_dlg2_tenor").val(t_or);
    
    var nml = $("#i_mutasi11_dlg2_nml").val();
    var rate = $("#i_mutasi11_dlg2_rate").val();
    var year = $("#i_mutasi11_dlg2_year").val();

    var i_nt = nml*rate/100/year*t_or;
    
    $("#i_mutasi11_dlg2_int").val(i_nt);
    $("#i_mutasi11_dlg2_int1").val(strtomoney(i_nt));

    var taxnya=20/100;
    var t_ax = i_nt*taxnya;
    $("#i_mutasi11_dlg2_tax").val(t_ax);
    $("#i_mutasi11_dlg2_tax1").val(strtomoney(t_ax));

    var n_int = strtofloat(strtomoney(i_nt))-strtofloat(strtomoney(t_ax));
    $("#i_mutasi11_dlg2_netint").val(n_int);
    $("#i_mutasi11_dlg2_netint1").val(strtomoney(n_int));
    $("#i_mutasi11_dlg2_rate1").val($("#i_mutasi11_dlg2_rate").val());
}