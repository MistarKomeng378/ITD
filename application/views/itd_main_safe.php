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
    <?php if( ($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0)  && $lvl!=0){ ?>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_search_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_in_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_out_dlg.js"></script>
    <?php } ?> 
    <script type="text/javascript" src="<?php echo $url;?>js_query/trx.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_query/trx_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js_query/trx_search_dlg.js"></script>
    
    <script type="text/javascript" src="<?php echo $url;?>js/dPicker.js"></script>    
    <script type="text/javascript" src="<?php echo $url;?>js/printPage.js"></script>
    
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
        ,    west__size:                180
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
                                                             
        
        initiate_pass();
        <?php if( ($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0)  && $lvl!=0){ ?>
            initiate_bilyet_inst();            
            //refresh_bilyet_status_count();
            refresh_bilyet_status_count(); 
        <?php } ?>
        initiate_trx(); 
        
        $(".dtpick").datepicker();
        $(".dtpick").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $(".dtpick").val(saiki);
        //$("#dialogBox_frm_trx_approval").show();
        //if(user_unit==2)
        //    show_sections('tbl_slick_bilyet_inst');
        //show_sections('tbl_slick_bilyet_inst');
    });       
    </script>
</head> 
<body> 

<div class="outer-center">

    <div class="middle-center">

        <div class="inner-center gw_bg">
            
            <div id="tbl_slick_trx" style="width: 100%; height: 100%; "></div>
            <?php if(($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0) && $lvl!=0){ ?>
            <div id="tbl_slick_bilyet_inst" style="width: 100%; height: 100%; display: none;"></div>
            <?php  if($lvl<=5 && $lvl!=0) { ?>
            <div id="tbl_slick_bilyet_inst_cancel" style="width: 100%; height: 100%; display: none;"></div>
            <?php }?>                         
            <?php }?>
            <div   id="img_load">
                <img src="<?php echo $url;?>img/ajax-loader.gif" alt="Loading..">
            </div>
        </div> 
        <div class="ui-layout-north">
            <?php if( ($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0)  && $lvl!=0){ ?>
            <div id="hbtn_bilyet_inst" style="display: none;">
                <button id="hbtn_bilyet_inst_search">Cari</button>  -
                <?php if($itd_user_unit==2 || $itd_user_unit==0){ ?>
                <button id="hbtn_bilyet_inst_in">Bilyet Masuk</button>
                <button id="hbtn_bilyet_inst_out">Bilyet Keluar</button> 
                    <?php if($lvl<=5) { ?>
                    <button id="hbtn_bilyet_cancel">Cancel Bilyet</button> -
                    <?php }?>
                <?php }?>                                                        
                <button id="hbtn_bilyet_inst_print">Cetak</button>
                <button id="hbtn_bilyet_inst_save">Save as..</button> -
                <button id="hbtn_bilyet_inst_view">View Instruksi</button>
            </div>   
            <?php }?>
            <div id="hbtn_trx" style="vertical-align: middle;">
                <button id="hbtn_trx_search">Cari Inst</button> 
                </div> 
            
        </div> 
    </div> 
</div> 

<div class="outer-west gw_bg">
    <ul id="west_toc">
        <?php if( ($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0) && $lvl!=0){ ?>
        <li>Bilyet Instruksi Deposito
            <ul>
                <li><a href="#" onclick="show_sections('tbl_slick_bilyet_inst');">Bilyet IN/ OUT</a></li>
            </ul>
        </li>
        <?php } ?>
        
        <li>Transaksi Deposito
            <ul>
                <li><a href="#" onclick="show_sections('tbl_slick_trx');">Instruksi Deposito</a></li>
            </ul>
        </li>
        <li><a href="<?php echo $url;?>index.php/itd/frm_change_pass">Ubah Password</a></li>
        <li><a href="<?php echo $url;?>index.php/itd/do_logout">Logout</a></li>
    </ul>
    <?php if($itd_user_unit==1 ||  $itd_user_unit==2 || $itd_user_unit==0){ ?>
    <div style="margin-bottom:3px;border: 1px solid #800000; padding: 0;font-size: 120%; font-weight: bold; color: #800000;" align="center">
        <div style="background-color: #580000; padding: 3px;border-bottom: 1px solid #800000;color:#FFFFFF;">Bilyet Belum Diterima</div>
        <div style="padding: 3px;">
        <table width="100%" border="1">
            <tr>
                <td width="25%" align="center">0hr</td>
                <td width="25%" align="center">1hr</td>
                <td width="25%" align="center">2hr</td>
                <td width="25%" align="center">3hr</td>
            </tr>
            <tr>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,0);"><span id="bilyet_status_must_in0" class="status_count">0</span></a></td>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,1);"><span id="bilyet_status_must_in1" class="status_count">0</span></a></td>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,2);"><span id="bilyet_status_must_in2" class="status_count">0</span></a></td>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,3);"><span id="bilyet_status_must_in3" class="status_count">0</span></a></td>
            </tr>
            <tr>
                <td align="center">4hr</td>
                <td align="center">5hr</td>
                <td align="center">6hr</td>
                <td align="center">7hr</td>
            </tr>
            <tr>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,4);"><span id="bilyet_status_must_in4" class="status_count">0</span></a></td>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,5);"><span id="bilyet_status_must_in5" class="status_count">0</span></a></td>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,6);"><span id="bilyet_status_must_in6" class="status_count">0</span></a></td>
                <td align="center"><a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,7);"><span id="bilyet_status_must_in7" class="status_count">0</span></a></td>
            </tr>
        </table>
        </div>
    </div>
    
    <div style="margin-bottom:3px;border: 1px solid #800000; padding: 0;font-size: 120%; font-weight: bold; color: #800000;" align="center">
        <div style="background-color: #580000; padding: 3px;border-bottom: 1px solid #800000;color:#FFFFFF;">Bilyet Belum Diterima<br /> > 7 Hari</div>
        <div style="padding: 3px;">
        <a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(0,8);"><span id="bilyet_status_must_in8" class="status_count">0</span></a>
        </div>
    </div>
    <div style="margin-bottom:3px;border: 1px solid #800000; padding: 0;font-size: 120%; font-weight: bold; color: #800000;" align="center">
        <div style="background-color: #580000; padding: 3px;border-bottom: 1px solid #800000;color:#FFFFFF;">Bilyet Masuk</div>
        <div style="padding: 3px;">
        <a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(1,0);"><span id="bilyet_status_in" class="status_count">0</span></a>
        </div>
    </div>
    <div style="margin-bottom:3px;border: 1px solid #800000; padding: 0;font-size: 120%; font-weight: bold; color: #800000;" align="center">
        <div style="background-color: #580000; padding: 3px;border-bottom: 1px solid #800000;color:#FFFFFF;">Bilyet Keluar</div>
        <div style="padding: 3px;">
        <span id="bilyet_status_out" class="status_count">0</span>
        </div>
    </div>
    <div style="margin-bottom:3px;border: 1px solid #800000; padding: 0;font-size: 120%; font-weight: bold; " align="center">
        <div style="background-color: #580000; padding: 3px;border-bottom: 1px solid #800000;color:#FFFFFF;">Bilyet Harusnya Keluar</div>
        <div style="padding: 3px;">
        <a href="#" class="a_status_count" onclick="show_sections_only('tbl_slick_bilyet_inst');list_pending_bilyet_inst(3,0);"><span id="bilyet_status_must_out" class="status_count">0</span></a>
        </div>
    </div>
    <?php } ?>
    <!--
    <div style="margin-bottom:3px;border: 1px solid #800000; padding: 0;font-size: 120%; font-weight: bold; " align="center">
        <div style="background-color: #580000; padding: 3px;border-bottom: 1px solid #800000;color:#FFFFFF;">
        <a href="#" class="a_status_count1" onclick="refresh_bilyet_status_count();">Refresh Jumlah Pending</a>
        </div>
    </div> -->
    <div style="margin-top: 15px;text-decoration: blink; font-weight: bolder;" align="center"> <font color="#FF0000">Refresh/ Reload/ F5</font><br />Untuk me-Update Aplikasi</div>
</div> 

<div class="ui-layout-north" style="background-color: #800000;padding:0">
    <div style="float: right; padding: 4px;color:#FFFFC0;" id="info_topleft">Login sebagai, <font color="#FFFFFF"><b><?php echo $nm;?></b></font>.</div>
    <img style="margin:0;padding:0;" src="<?php echo $url . "img/cimbniaga.png";?>" border="0" />
</div> 

<div id="div_cetak" style="display: none;"></div>
<DIV id="dialogBox_frm_trx"></DIV> 
<DIV id="dialogBox_frm_trx_search"></DIV> 

<?php if($itd_user_unit==1 || $itd_user_unit==0){ ?>
<!-- DIALOG BOX w/ FRM TRX -->
<DIV id="dialogBox_frm_trx_history"></DIV>

<!-- DIALOG BOX w/ User -->
<!-- DIALOG BOX w/ pic -->
<DIV id="dialogBox_pic"></DIV> 
<DIV id="dialogBox_pic_search"></DIV> 

<!-- DIALOG BOX w/ Klien -->            
<DIV id="dialogBox_client"></DIV>  
<DIV id="dialogBox_client_search"></DIV>

<!-- DIALOG BOX w/ Klien -->
<DIV id="dialogBox_client_group"></DIV>  

<!-- DIALOG BOX w/ docim -->
<DIV id="dialogBox_docim_search"></DIV> 
<DIV id="dialogBox_docim_listing"></DIV> 

<!-- DIALOG BOX w/ Mutasi -->
<DIV id="dialogBox_mutasi11_1"></DIV>  
<DIV id="dialogBox_mutasi11_2"></DIV>  
<DIV id="dialogBox_mutasi11_3"></DIV>
<DIV id="dialogBox_mutasi11_4"></DIV>

<?php if($lvl<=5) { ?>
<!-- DIALOG BOX w/ Mutasi Klien -->            
<DIV id="dialogBox_mutasi11_client"></DIV>  
<DIV id="dialogBox_mutasi11_client_search"></DIV>
<DIV id="dialogBox_mail"></DIV> 
<!-- DIALOG BOX w/ Mutasi Coa -->            
<DIV id="dialogBox_mutasi11_coa"></DIV> 
<?php }?>
<!-- DIALOG BOX w/ Mutasi BF -->            
<DIV id="dialogBox_mutasi11_bf"></DIV> 

<?php }?>


<DIV id="dialogBox_user_change_pass"></DIV> 
<?php if($lvl<=0) { ?>
<DIV id="dialogBox_user"></DIV> 
<DIV id="dialogBox_user_reset_pass"></DIV> 


<?php }?>

<!-- DIALOG BOX w/ Bilyet -->
<DIV id="dialogBox_bilyet_inst_search"></DIV>  
<DIV id="dialogBox_bilyet_inst_in"></DIV>
<DIV id="dialogBox_bilyet_inst_out"></DIV>

<!-- DIALOG BOX w/ Report -->
<DIV id="dialogBox_report11_search"></DIV>  

<!-- DIALOG BOX w/ Subscript -->            
<DIV id="dialogBox_subs_client_dlg"></DIV> 
<DIV id="dialogBox_subs_rekap_dlg"></DIV> 
<DIV id="dialogBox_subs_save_dlg"></DIV> 

<!-- DIALOG BOX w/ Subscript Reksadana-->            
<DIV id="dialogBox_subsrd_dlg1"></DIV>             
<DIV id="dialogBox_subsrd_mi_dlg"></DIV> 
<DIV id="dialogBox_subsrd_bank_dlg"></DIV> 
<DIV id="dialogBox_subsrd_client_dlg"></DIV> 
<DIV id="dialogBox_subsrd_sa_dlg"></DIV> 
<DIV id="dialogBox_subsrd_acc_dlg"></DIV> 

<div id="dlg_dpicker" style="position: absolute; width: 500px; height: 200px; border: 1px solid #800000; z-index: 8000; display: none; background-color: #800000;" class="ui-widget-content"></div>

<div id="add1" style="display: none;"></div>
<form action="" id="frm_hidden_trx" style="display: none;" target="_blank" method="post"></form>
<form action="" id="frm_hidden" style="display: none;" target="_blank" method="post"></form>
</body>
</html>
