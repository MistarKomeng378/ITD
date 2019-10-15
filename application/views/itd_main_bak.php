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
        var uri="<?php echo $url;?>";
        var lvl=<?php echo $lvl;?>;
        
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
    <script type="text/javascript" src="<?php echo $url;?>js/client.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/client_dlg.js"></script>   
    <script type="text/javascript" src="<?php echo $url;?>js/pic.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/pic_dlg.js"></script> 
    <?php if($lvl<=0) { ?>
    <script type="text/javascript" src="<?php echo $url;?>js/user.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/user_dlg.js"></script>
    <?php } ?>
    <script type="text/javascript" src="<?php echo $url;?>js/pass_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/pass.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/trx.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/dPicker.js"></script>    
    <style type="text/css">
    body{
        font-size:.8em;
    }
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
        initiate_trx(); 
        
        
        /*initiate_trx(); 
        initiate_pic();
        initiate_client();
        <?php if($lvl<=0) { ?> 
        initiate_user();
        <?php }?>
        initiate_pass();*/
    });       
    </script>
</head> 
<body> 

<div class="outer-center">

    <div class="middle-center">

        <div class="inner-center gw_bg">
            <div id="tbl_slick_trx" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_pic" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_client" style="width: 100%; height: 100%; display: none;"></div>
            <?php  if($lvl<=0) { ?>
            <div id="tbl_slick_user" style="width: 100%; height: 100%; display: none;"></div>
            <?php }?>
            <div   id="img_load">
                <img src="<?php echo $url;?>img/ajax-loader.gif" alt="Loading..">
            </div>
        </div> 
        <div class="ui-layout-north">
            <div id="hbtn_trx" style="display: none; vertical-align: middle;">
            <!--
            <?php if($lvl<=5) { ?>
            <button id="hbtn_trx_approval">Approval</button> -
            <?php }?>
            <button id="hbtn_trx_new">Baru</button> 
            <button id="hbtn_trx_edit">Edit</button>
            <button id="hbtn_trx_del">Hapus</button> -
            -->
            <button id="hbtn_trx_open">Buka</button> 
            <button id="hbtn_trx_new">Baru</button> -
            <button id="hbtn_trx_print">Cetak</button> -
            <button id="hbtn_trx_refresh">Refresh</button>  -
            <input id="i_trx_list_dt" type="text" class="dtpick" style="width:80px;text-align: center;" /> 
                <span id="trx_auto_refresh">
                    -
                    <select id="field_trx_auto_refresh_time" name="field_trx_auto_refresh_time">
                        <option value="10">5 Menit</option>
                        <option value="15">15 Menit</option>
                        <option value="30">30 Menit</option>
                        <option value="60">1 Jam</option>
                    </select>
                    <input type="checkbox" name="field_trx_auto_refresh" id="field_trx_auto_refresh" /> Auto Refresh
                </span>
            
            </div>
            <div id="hbtn_user" style="display: none;">
            <button id="hbtn_user_new"> Baru</button> 
            <button id="hbtn_user_edit">Edit</button> 
            <button id="hbtn_user_del">Delete</button> 
            <button id="hbtn_user_reset_pass">Reset Password</button>  -
            <button id="hbtn_user_refresh">Refresh</button> 
            </div>
            <div id="hbtn_pic" style="display: none;">
            <button id="hbtn_pic_new">Baru</button> 
            <button id="hbtn_pic_edit">Edit</button>  
            <?php if($lvl<=5) { ?>
            <button id="hbtn_pic_del">Hapus</button>
            <?php } ?> -
            <button id="hbtn_pic_refresh">Refresh</button>
            </div>
            
            <div id="hbtn_client" style="display: none;">
                <?php if($lvl<=5) { ?>
                <button id="hbtn_client_new">Baru</button> 
                <button id="hbtn_client_edit">Edit</button>
                <button id="hbtn_client_del">Hapus</button> -
                <?php }?>
                <button id="hbtn_client_refresh">Refresh</button>
            </div>
        </div> 
    </div> 

</div> 

<div class="outer-west gw_bg">
    <ul id="west_toc">
        <li><a href="#" onclick="show_sections('tbl_slick_trx');">Instruksi</a></li>
        <li>Manage
            <ul>
                <li><a href="#" onclick="show_sections('tbl_slick_pic');">PIC</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_client');">Klien</a></li>
                <?php if($lvl<=0) { ?>
                <li><a href="#" onclick="show_sections('tbl_slick_user');">User App</a></li>
                <?php } ?>
            </ul>
        </li>
        <li><a href="#" onclick="show_dlg_change_pass();">Ubah Password</a></li>
        <li><a href="<?php echo $url;?>index.php/itd/do_logout">Logout</a></li>
    </ul>
</div> 

<div class="ui-layout-north" style="background-color: #800000;padding:0"><img style="margin:0;padding:0;" src="<?php echo $url . "img/cimbniaga.png";?>" border="0" /></div> 

<div id="div_cetak" style="display: none;"></div>

<!-- DIALOG BOX w/ FRM TRX -->
<DIV id="dialogBox_frm_trx"></DIV> 

<!-- DIALOG BOX w/ User -->
<DIV id="dialogBox_user"></DIV> 
<DIV id="dialogBox_user_reset_pass"></DIV> 
<DIV id="dialogBox_user_change_pass"></DIV> 


<!-- DIALOG BOX w/ pic -->
<DIV id="dialogBox_pic"></DIV> 

<!-- DIALOG BOX w/ Klien -->
<DIV id="dialogBox_client"></DIV>  

<div id="dlg_dpicker" style="position: absolute; width: 500px; height: 200px; border: 1px solid #800000; z-index: 8000; display: none; background-color: #800000;" class="ui-widget-content"></div>


</body>
</html>