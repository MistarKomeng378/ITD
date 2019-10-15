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
    <?php if( ($itd_user_unit==5 || $itd_user_unit==0)){ ?>        
        <script type="text/javascript" src="<?php echo $url;?>js_query/trx.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js_query/trx_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js_query/trx_search_dlg.js"></script>
    <?php } ?> 
    <?php if($lvl<=0) { ?>
    
        <script type="text/javascript" src="<?php echo $url;?>js/user.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/user_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/user_par.js"></script>
    <?php } ?>
    <script type="text/javascript" src="<?php echo $url;?>js/pass_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/pass.js"></script>
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
                                                             
        <?php if( ($itd_user_unit==5 ||  $itd_user_unit==0)){ ?>
            initiate_trx(); 
            
        <?php } ?>
        initiate_pass();
        <?php if($lvl<=0) { ?>
            initiate_user();
            initiate_user_parameter();        
        <?php }?>
        
        $(".dtpick").datepicker();
        $(".dtpick").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $(".dtpick").val(saiki);
        //$("#dialogBox_frm_trx_approval").show();
        //if(user_unit==2)
        show_sections('tbl_slick_trx');
    });       
    </script>
</head> 
<body> 

<div class="outer-center">

    <div class="middle-center">

        <div class="inner-center gw_bg">
            <?php if( ($itd_user_unit==5 || $itd_user_unit==0)){ ?>
                <div id="tbl_slick_trx" style="width: 100%; height: 100%; "></div>
            <?php }?>
            
            <?php if(($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0) && $lvl!=0){ ?>
            <div id="tbl_slick_bilyet_inst" style="width: 100%; height: 100%; display: none;"></div>
            <?php  if($lvl<=5 && $lvl!=0) { ?>
            <div id="tbl_slick_bilyet_inst_cancel" style="width: 100%; height: 100%; display: none;"></div>
            <?php }?>
            <?php }?>
            <?php  if($lvl<=0) { ?>
            <div id="tbl_slick_user" style="width: 100%; height: 100%; display: none;"></div>
            <div id="content_user_parameter" style="width: 100%; height: 100%; display: none;"></div>
            
            <?php }?>
            <div   id="img_load">
                <img src="<?php echo $url;?>img/ajax-loader.gif" alt="Loading..">
            </div>
        </div> 
        <div class="ui-layout-north">
            <?php if(($itd_user_unit==5)){ ?>
                <div id="hbtn_trx" style="vertical-align: middle;">
                <button id="hbtn_trx_search">Cari Inst</button> 
                </div>                
            <?php } ?>
        </div> 
    </div> 
</div> 

<div class="outer-west gw_bg">
    <ul id="west_toc">  
        <?php if( ($itd_user_unit==5)){ ?>
        <li>Transaksi Deposito
            <ul>
                <li><a href="#" onclick="show_sections('tbl_slick_trx');">Instruksi Deposito</a></li>
            </ul>
        </li>
        <?php } ?>
                
        <li><a href="<?php echo $url;?>index.php/itd/frm_change_pass">Ubah Password</a></li>
        <li><a href="<?php echo $url;?>index.php/itd/do_logout">Logout</a></li>
    </ul>
    <div style="margin-top: 15px;text-decoration: blink; font-weight: bolder;" align="center"> <font color="#FF0000">Refresh/ Reload/ F5</font><br />Untuk me-Update Aplikasi</div>
</div> 

<div class="ui-layout-north" style="background-color: #800000;padding:0">
    <div style="float: right; padding: 4px;color:#FFFFC0;" id="info_topleft">Login sebagai, <font color="#FFFFFF"><b><?php echo $nm;?></b></font>.</div>
    <img style="margin:0;padding:0;" src="<?php echo $url . "img/cimbniaga.png";?>" border="0" />
</div> 

<div id="div_cetak" style="display: none;"></div>

<?php if($itd_user_unit==5 || $itd_user_unit==0 ){ ?>
<!-- DIALOG BOX w/ FRM TRX -->
<DIV id="dialogBox_frm_trx"></DIV> 
<DIV id="dialogBox_frm_trx_search"></DIV> 
<DIV id="dialogBox_frm_trx_history"></DIV>


<?php }?>


<DIV id="dialogBox_user_change_pass"></DIV> 

<div id="dlg_dpicker" style="position: absolute; width: 500px; height: 200px; border: 1px solid #800000; z-index: 8000; display: none; background-color: #800000;" class="ui-widget-content"></div>

<div id="add1" style="display: none;"></div>
<form action="" id="frm_hidden_trx" style="display: none;" target="_blank" method="post"></form>
<form action="" id="frm_hidden" style="display: none;" target="_blank" method="post"></form>
</body>
</html>
