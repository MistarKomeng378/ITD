<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>Instruksi Transaksi Deposito</title>

    <link type="text/css" rel="stylesheet" href="<?php echo $url;?>css/layout-default-latest.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo $url;?>css/gw/jquery-ui-1.8.16.custom.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo $url;?>css/layout-pane.css" />
    <link type="text/css" rel="stylesheet" href="<?php echo $url;?>css/dlg-pane.css" /> 
    <link type="text/css" rel="stylesheet" href="<?php echo $url;?>css/itd.css" />
        
    <script type="text/javascript" src="<?php echo $url;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/jquery-ui-1.8.16.gw.min.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/jquery.layout.js"></script>
    
    <link rel="stylesheet" href="<?php echo $url;?>css/slick.grid.css" type="text/css" media="screen" charset="utf-8" />
    
    <script type="text/javascript" src="<?php echo $url;?>js/jquery.event.drag-2.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/slick.core.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/plugins/slick.checkboxselectcolumn.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/plugins/slick.autotooltips.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/plugins/slick.rowselectionmodel.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/slick.editors.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/slick.grid.js"></script>

        
    <script type="text/javascript">        
        function ltrim(str, chars) {
            chars = chars || "\\s";
            return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
        }
         
        function rtrim(str, chars) {
            chars = chars || "\\s";
            return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
        }
        function trim(str, chars) {
            return ltrim(rtrim(str, chars), chars);
        }                                       
    </script>
     
    
    <script type="text/javascript" src="<?php echo $url;?>index.php/itd/get_js_config"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/sections.js"></script>
    
    <script type="text/javascript" src="<?php echo $url;?>js/pass_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/pass.js"></script>
    
    <script type="text/javascript" src="<?php echo $url;?>js/dPicker.js"></script>    
    <script type="text/javascript" src="<?php echo $url;?>js/printPage.js"></script>
    
    
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/mutasi11.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/mutasi11_taxbro.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_rekap.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/mutasi11_dlg4.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/subs.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/subsrd_acc.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/subsrd_rekon.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/baltrx_os.js"></script>
    <!--
    <script type="text/javascript" src="<?php echo $url;?>js_inquery/mutasi11_dlg1.js"></script>
    -->
    
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_balance.js"></script>
    
    
    
    <style type="text/css">
    body{
        font-size:.8em;
    }   
    .status_count{
        font-size: 100%;
    }
    .a_status_count{
        text-decoration: none;color: #800000;
    }
    .a_status_count:hover{  color: #FF0000;  }
    .a_status_count1{
        text-decoration: none;color: #FFFF00;
    }
    .a_status_count1:hover{  color: #FFFFFF;  }
    </style>
    
    <script type="text/javascript">
    var outerLayout, middleLayout, innerLayout; 

    $(document).ready(function () { 
        outerLayout = $('body').layout({ 
            center__paneSelector:    ".outer-center" 
        ,    west__paneSelector:        ".outer-west" 
        ,    west__size:                160
        ,    spacing_open:            2 // ALL panes
        ,    spacing_closed:            12 // ALL panes
        ,    north__spacing_open:    0
        ,    north__maxSize:            "auto"                                  
        }); 

        middleLayout = $('div.outer-center').layout({ 
            center__paneSelector:    ".middle-center"              
        }); 

        innerLayout = $('div.middle-center').layout({ 
            center__paneSelector:    ".inner-center" 
            
        ,    spacing_open:              0// ALL panes
        ,    spacing_closed:            8  // ALL pan
        ,    north__size:           28
        , onresize : function(){resize_Canvas();}//grid_trx.resizeCanvas();grid_user.resizeCanvas();grid_pic.resizeCanvas();grid_client.resizeCanvas();}
        }); 
        
        $(".dtpick").datepicker();
        $(".dtpick").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        initiate_pass();                       
        initiate_mutasi11();          
                                        
        initiate_mutasi11_balance();
        //initiate_mutasi11_taxbro();
        
        initiate_subs();
        initiate_subsrd();
        initiate_subsrdrekon();
        initiate_mutasi11_rekap();
        initiate_baltrx_os();
    });       
    </script>
</head> 
<body> 

<div class="outer-center">

    <div class="middle-center">

        <div class="inner-center gw_bg">
            <div id="content_mutasi11" style="width: 845px; height: 500px; display: none;"></div>
            <div id="tbl_slick_mutasi11_balance" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_mutasi11_taxbro" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_baltrx_os" style="width: 100%; height: 100%; display: none;"></div>
            <div id="content_mutasi11_rekap" style="width: 100%; height: 100%; display: none;"></div>
            <div id="content_subs" style="width: 100%; height: 100%; display: none;"></div>
            <div id="content_subsrd" style="width: 100%; height: 100%; display: none;"></div>
            <div id="content_subsrdrekon" style="width: 100%; height: 100%; display: none;"></div>
            
            <div   id="img_load">
                <img src="<?php echo $url;?>img/ajax-loader.gif" alt="Loading..">
            </div>
        </div> 
        <div class="ui-layout-north">
            <div id="hbtn_mutasi11" style="display: none;">  
                <button id="hbtn_mutasi11_c_jasgir">Lihat Instruksi Jasa Giro</button> 
                <?php if($lvl<=5) { ?>
                <button id="hbtn_mutasi11_cancel_close_day">Batal Akhir Hari</button> -
                <button id="hbtn_mutasi11_unlock">Unlock account</button> 
                <?php }?>
            </div>
            <div id="hbtn_mutasi11_balance" style="display: none;">
               &nbsp; Processor :
                <select id="hbtn_mutasi11_balance_proc">
                    <option value="ALL">ALL</option>
                </select>
                client :
                    <select id="hbtn_mutasi11_balance_cli">
                        <option value="ALL">ALL</option>
                    </select>
                Tanggal :
                <input type="text" class="dtpick" id="hbtn_mutasi11_balance_dt1" style="width: 80px; text-align: center;"  /> s/d
                <input type="text" class="dtpick" id="hbtn_mutasi11_balance_dt2" style="width: 80px; text-align: center;"  /> 
                <button id="hbtn_mutasi11_balance_reload">Reload</button> 
                <button id="hbtn_mutasi11_balance_save">Save to Excel</button> 
            </div>
            <div id="hbtn_mutasi11_rekap" style="display: none;">
                <form action="<?php echo $url;?>/index.php/mutasi/v_rekap" target="_subsrd_rekon" method="post">
                Tanggal :
                <input type="text" class="dtpick" id="hbtn_mutasi11_rekap_dt" style="width: 80px; text-align: center;" name="dt1"  /> 
                <input type="button" id="hbtn_mutasi11_rekap_reload" value="Reload" />
                <input type="submit" id="hbtn_mutasi11_rekap_prev" value="Preview" />
                </form>
            </div>
            <div id="hbtn_mutasi11_taxbro" style="display: none;">
                &nbsp; 
                Klien : <input type="text" id="hbtn_mutasi11_taxbro_client" style="width: 60px;" />
                Kategori :
                <select id="hbtn_mutasi11_taxbro_coa">
                    <option value="ALL">ALL</option>
                </select>
                Tanggal : 
                <input type="text" class="dtpick" id="hbtn_mutasi11_taxbro_dt1" style="width: 80px; text-align: center;"  /> s/d
                <input type="text" class="dtpick" id="hbtn_mutasi11_taxbro_dt2" style="width: 80px; text-align: center;"  /> 
                <button id="hbtn_mutasi11_taxbro_reload">Reload</button> 
                <button id="hbtn_mutasi11_taxbro_save">Save to Excel</button> 
            </div>
            <div id="hbtn_subs" style="display: none;">
                <input type="hidden" id="hbtn_subs_dt"  />
                <button id="hbtn_subs_reload1">Reload</button> 
            </div>
            <div id="hbtn_subsrd" style="display: none;">
                <input type="hidden" id="hbtn_subsrd_dt"  />
                <button id="hbtn_subsrd_reload1">Reload</button> 
                <button id="hbtn_subsrd_cancel_close_day">Batal Akhir Hari</button> 
            </div>
            <div id="hbtn_subsrdrekon" style="display: none;">
            <form action="<?php echo $url;?>/index.php/subsrd_rekon/view_html" target="_subsrd_rekon" method="post">
                Date: <input type="text" class="dtpick" id="hbtn_subsrdrekon_dt" style="width: 80px; text-align: center;" name="q"  />
                <select id="hbtn_subsrdrekon_type" name="t">
                    <option value="0">After Posting</option>
                    <option value="1">Before Posting</option>
                </select>
                <input type="button" id="hbtn_subsrdrekon_view" value="View" />
                <input type="submit" id="hbtn_subsrdrekon_viewprint" value="Preview">
            </form>
            </div> 
            <div id="hbtn_baltrx_os" style="display: none;">
            <iframe name="iframe_baltrx_os" id="iframe_baltrx_os"  src="#" style="postion:fixed;left:-9999;top:-9999;display:none"></iframe>
            <form id="frm_baltrx_os" name="frm_baltrx_os" target="iframe_baltrx_os"  action="<?php echo $url;?>index.php/trxos/u" method="POST" enctype="multipart/form-data"> 
                Trade Date: <input type="text" class="dtpick" id="hbtn_baltrx_os_dt" style="width: 80px; text-align: center;" name="dt"  />
                File:<input type="file" id="f_baltrx_os" size="60" name="f" /> 
                <input type="button" id="hbtn_baltrx_os_up"  value="Upload" /> -
                <input type="button" id="hbtn_baltrx_os_reload"  value="Reload Data" />
            </form>
            </div>
        </div>
        </div> 
         
    </div> 
</div> 

<div class="outer-west gw_bg">
    <ul id="west_toc">
        <?php if($itd_user_unit!=2){ ?>
        <li>Rekening Operasional
            <ul>
                <li><a href="#" onclick="show_sections('content_mutasi11');">Mutasi</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_balance');">Rekap Balance</a></li>
                <li><a href="#" onclick="show_sections('content_mutasi11_rekap');">Summary</a></li>
            </ul>
        </li>
        <li>Pending Subscription
            <ul>
                <li><a href="#" onclick="show_sections('content_subs');">Pending Subscript</a></li>
            </ul>
        </li>
        <li>Subscription Reksadana
            <ul>
                <li><a href="#" onclick="show_sections('content_subsrd');">Subscription</a></li>
                <li><a href="#" onclick="show_sections('content_subsrdrekon');">Subscription Vs URS</a></li>
            </ul>
        </li>
        <li><a href="#" onclick="show_sections('tbl_slick_baltrx_os');">Balance TRX OS</a></li>
        <?php } ?>
        <li><a href="#" onclick="show_dlg_change_pass();">Ubah Password</a></li>
        <li><a href="<?php echo $url;?>index.php/itd/do_logout">Logout</a></li>
    </ul>
    <div style="margin-top: 15px;text-decoration: blink; font-weight: bolder;" align="center"> <font color="#FF0000">Refresh/ Reload/ F5</font><br />Untuk me-Update Aplikasi</div>
</div> 

<div class="ui-layout-north" style="background-color: #800000;padding:0">
    <div style="float: right; padding: 4px;color:#FFFFC0;" id="info_topleft">Login sebagai, <font color="#FFFFFF"><b><?php echo $nm;?></b></font>.</div>
    <img style="margin:0;padding:0;" src="<?php echo $url . "img/cimbniaga.png";?>" border="0" />
</div> 

<div id="div_cetak" style="display: none;"></div>


<!-- DIALOG BOX w/ Mutasi -->
<DIV id="dialogBox_mutasi11_1"></DIV>  
<DIV id="dialogBox_mutasi11_2"></DIV>  
<DIV id="dialogBox_mutasi11_3"></DIV>
<DIV id="dialogBox_mutasi11_4"></DIV>

<DIV id="dialogBox_user_change_pass"></DIV> 

<div id="dlg_dpicker" style="position: absolute; width: 500px; height: 200px; border: 1px solid #800000; z-index: 8000; display: none; background-color: #800000;" class="ui-widget-content"></div>

<div id="add1" style="display: none;"></div>
<form action="" id="frm_hidden_trx" style="display: none;" target="_blank" method="post"></form>
<form action="" id="frm_hidden" style="display: none;" target="_blank" method="post"></form>
</body>
</html>