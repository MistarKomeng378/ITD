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
    <?php if($itd_user_unit!=2){ ?>  
    <script type="text/javascript" src="<?php echo $url;?>js/client.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/client_dlg.js"></script>   
    <script type="text/javascript" src="<?php echo $url;?>js/client_dlg_search.js"></script>   
    <script type="text/javascript" src="<?php echo $url;?>js/pic.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/pic_dlg.js"></script> 
    <script type="text/javascript" src="<?php echo $url;?>js/pic_dlg_search.js"></script> 
    <script type="text/javascript" src="<?php echo $url;?>js/docim.js"></script> 
    <script type="text/javascript" src="<?php echo $url;?>js/docim_dlg_search.js"></script> 
    <script type="text/javascript" src="<?php echo $url;?>js/docim_dlg_listing.js"></script> 
    <?php if($lvl<=0) { ?>
    <script type="text/javascript" src="<?php echo $url;?>js/user.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/user_dlg.js"></script>
    <?php } ?>
    <script type="text/javascript" src="<?php echo $url;?>js/trx.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/trx_search_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg_ticket.js"></script> 
    <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg_history.js"></script>    
    <?php } ?> 
    <script type="text/javascript" src="<?php echo $url;?>js/pass_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/pass.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_search_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_in_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_out_dlg.js"></script>
    
    <script type="text/javascript" src="<?php echo $url;?>js/dPicker.js"></script>    
    <script type="text/javascript" src="<?php echo $url;?>js/printPage.js"></script>
    
    <script type="text/javascript" src="<?php echo $url;?>js/itd_report11.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/itd_report11_dlg_search.js"></script>
    
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg1.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg2.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg3.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg4.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_jasgirmon.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_balance.js"></script>
    <?php if($lvl<=5) { ?>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_client.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_client_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_client_dlg_search.js"></script> 
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_coa.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_coa_dlg.js"></script>
    <?php } ?>
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
        <?php if($itd_user_unit!=2){ ?>        
        initiate_trx(); 
        initiate_pic();
        initiate_client();
        initiate_docim();
        <?php if($lvl<=0) { ?>
        initiate_user();
        <?php }?>
        <?php } ?>
        initiate_pass();
        initiate_bilyet_inst();
        initiate_report11();
        initiate_mutasi11();
        initiate_mutasi11_jasgirmon();
        initiate_mutasi11_balance();
        <?php if($lvl<=5) { ?>
        initiate_mutasi11_client();
        initiate_mutasi11_coa();
        <?php } ?>
        //refresh_bilyet_status_count();
        refresh_bilyet_status_count(); 
    });       
    </script>
</head> 
<body> 

<div class="outer-center">

    <div class="middle-center">

        <div class="inner-center gw_bg">
            <?php if($itd_user_unit!=2){ ?>
            <div id="tbl_slick_trx" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_pic" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_client" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_docim" style="width: 100%; height: 100%; display: none;"></div>
            <?php  if($lvl<=0) { ?>
            <div id="tbl_slick_user" style="width: 100%; height: 100%; display: none;"></div>
            <?php }?>
            <?php }?>
            <?php  if($lvl<=5) { ?>
            <div id="tbl_slick_mutasi11_client" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_mutasi11_coa" style="width: 100%; height: 100%; display: none;"></div>
            <?php }?>
            <div id="tbl_slick_mutasi11_jasgirmon" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_mutasi11_balance" style="width: 100%; height: 100%; display: none;"></div>
            <div id="tbl_slick_bilyet_inst" style="width: 100%; height: 100%; display: none;"></div>
            <div id="content_report11" style="width: 100%; height: 100%; display: none;"></div>
            <div id="content_mutasi11" style="width: 845px; height: 500px; display: none;"></div>
            <div   id="img_load">
                <img src="<?php echo $url;?>img/ajax-loader.gif" alt="Loading..">
            </div>
        </div> 
        <div class="ui-layout-north">
            <?php if($itd_user_unit!=2){ ?>
            <div id="hbtn_trx" style="display: none; vertical-align: middle;">
            <!--
            <?php if($lvl<=5) { ?>
            <button id="hbtn_trx_approval">Approval</button> -
            <?php }?>
            <button id="hbtn_trx_new">Baru</button> 
            <button id="hbtn_trx_edit">Edit</button>
            <button id="hbtn_trx_del">Hapus</button> -
            -->
            <button id="hbtn_trx_search">Cari Inst</button> 
            -
            <select id="hselect_trx_type">
                <option value="1">Penempatan</option>
                <option value="2">Perpanjangan</option>
                <option value="3">Pencairan</option>
                <option value="4">Break</option>
            </select>
            <button id="hbtn_trx_new">Buat Inst</button> 
            <!--
            <button id="hbtn_trx_approve">Approve Instruksi</button>
            -->
            <?php if($lvl<=5) { ?>
            <button id="hbtn_trx_edit">Ubah Inst</button> 
            <button id="hbtn_trx_cancel">Batalkan Inst</button> 
            <?php }?>
            -
            <button id="hbtn_trx_ticket">Buat Tiket</button> -
            <button id="hbtn_trx_print">Cetak</button> 
            <!--
            <button id="hbtn_trx_history">History Trx</button> 
            -->
            -
            <button id="hbtn_trx_refresh">Reload</button> 
            <input id="i_trx_list_dt" type="text" class="dtpick" style="width:80px;text-align: center;" /> &gt;=7 hari tgl valuta.
                <span id="trx_auto_refresh" style="display:none;">
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
            <button id="hbtn_user_new">Baru</button> 
            <button id="hbtn_user_edit">Ubah</button> 
            <button id="hbtn_user_del">Hapus</button> 
            <button id="hbtn_user_reset_pass">Reset Password</button>  -
            <button id="hbtn_user_refresh">Refresh</button> 
            </div>
            <div id="hbtn_pic" style="display: none;">
            <button id="hbtn_pic_search">Cari</button> - 
            <button id="hbtn_pic_new">Baru</button> 
            <button id="hbtn_pic_edit">Ubah</button>  
            <?php if($lvl<=5) { ?>
            <button id="hbtn_pic_del">Hapus</button>
            <?php } ?> -
            <button id="hbtn_pic_refresh">Refresh</button>
            </div>
            
            <div id="hbtn_client" style="display: none;">
                <button id="hbtn_client_search">Cari</button> -
                <?php if($lvl<=5) { ?>
                <button id="hbtn_client_approve">Approve</button> -
                <?php }?>
                <button id="hbtn_client_new">Baru</button> 
                <button id="hbtn_client_edit">Ubah</button>
                <?php if($lvl<=5) { ?>
                <button id="hbtn_client_del">Hapus</button> 
                <?php }?>
                -
                <button id="hbtn_client_refresh">Refresh</button>
            </div>
            <?php }?>
            <div id="hbtn_mutasi11" style="display: none;">
            <button id="hbtn_mutasi11_open_day">Proses Awal Hari</button>  
            <button id="hbtn_mutasi11_close_day">Proses Akhir Hari</button>  
            <button id="hbtn_mutasi11_p_jasgir">Buat Jasa Giro</button>  
            <?php if($lvl<=5) { ?>
            <button id="hbtn_mutasi11_cancel_close_day">Pembatalan Proses Akhir Hari</button> 
            <?php }?> -
            <button id="hbtn_mutasi11_p_mutasi">Cetak Mutasi</button>  
            <button id="hbtn_mutasi11_c_jasgir">Cetak Jasa Giro</button>  
            <button id="hbtn_mutasi11_p_rekap">Cetak Rekap Jasa Giro</button>  
            </div>
            <div id="hbtn_report11" style="display: none;">
            <button id="hbtn_report11_search">Kategori Rekap Instruksi</button>  
            <button id="hbtn_report11_save">Save Rekap Instruksi</button>  
            </div>
            <div id="hbtn_bilyet_inst" style="display: none;">
                <button id="hbtn_bilyet_inst_search">Cari</button>  -
                <?php if($itd_user_unit==2){ ?>
                <button id="hbtn_bilyet_inst_in">Bilyet Masuk</button>
                <button id="hbtn_bilyet_inst_out">Bilyet Keluar</button> 
                <button id="hbtn_bilyet_cancel">Cancel Bilyet</button> -
                <?php }?>                                                        
                <button id="hbtn_bilyet_inst_print">Cetak</button>
                <button id="hbtn_bilyet_inst_save">Save as..</button>
            </div>   
            <?php if($itd_user_unit!=2){ ?>
            <div id="hbtn_docim" style="display: none;">
                <button id="hbtn_docim_search">Cari Dokumen</button>
                <?php if($lvl<0) { ?>
                - <button id="hbtn_docim_listing">Listing Dokumen</button> 
                <?php } ?>
            </div>
            <?php }?>
            <?php if($lvl<=5) { ?>
            <div id="hbtn_mutasi11_client" style="display: none;">
                <button id="hbtn_mutasi11_client_search">Cari</button> -
                <button id="hbtn_mutasi11_client_new">Baru</button> 
                <button id="hbtn_mutasi11_client_edit">Ubah</button>
                <button id="hbtn_mutasi11_client_del">Disable</button> 
                -
                <button id="hbtn_mutasi11_client_refresh">Reload</button>
            </div>
            
            <div id="hbtn_mutasi11_coa" style="display: none;">
                <button id="hbtn_mutasi11_coa_new">Baru</button> 
                <button id="hbtn_mutasi11_coa_edit">Ubah</button>
                -
                <button id="hbtn_mutasi11_coa_refresh">Reload</button>
            </div>
            <?php }?>
            <div id="hbtn_mutasi11_jasgirmon" style="display: none;">
                Filter :
                <select id="hbtn_mutasi11_jasgirmon_filter">
                    <option value="0">By Giro Date</option>
                    <option value="1">By Balance Date</option>
                </select>
                Tanggal : 
                <input type="text" class="dtpick" id="hbtn_mutasi11_jasgirmon_dt1" style="width: 80px; text-align: center;"  /> s/d
                <input type="text" class="dtpick" id="hbtn_mutasi11_jasgirmon_dt2" style="width: 80px; text-align: center;"  /> 
                <button id="hbtn_mutasi11_jasgirmon_reload">Reload</button> 
                <button id="hbtn_mutasi11_jasgirmon_save">Save to Excel</button>  
                <?php if($lvl<=5) { ?>
                - <button id="hbtn_mutasi11_jasgirmon_del">Hapus Jasa Giro</button> 
                <?php } ?>
            </div>
            <div id="hbtn_mutasi11_balance" style="display: none;">
                &nbsp; Processor :
                <select id="hbtn_mutasi11_balance_proc">
                    <option value="ALL">ALL</option>
                </select>
                Tanggal : 
                <input type="text" class="dtpick" id="hbtn_mutasi11_balance_dt1" style="width: 80px; text-align: center;"  /> s/d
                <input type="text" class="dtpick" id="hbtn_mutasi11_balance_dt2" style="width: 80px; text-align: center;"  /> 
                <button id="hbtn_mutasi11_balance_reload">Reload</button> 
                <button id="hbtn_mutasi11_balance_save">Save to Excel</button> 
            </div>
        </div> 
    </div> 
</div> 

<div class="outer-west gw_bg">
    <ul id="west_toc">
        <?php if($itd_user_unit!=2){ ?>
        <li><a href="#" onclick="show_sections('tbl_slick_trx');">Instruksi Trx Deposito</a></li>
        <?php } ?>
        <li><a href="#" onclick="show_sections('tbl_slick_bilyet_inst');">Bilyet Instruksi Deposito</a></li>
        <li>Laporan
            <ul>
                <li><a href="#" onclick="show_sections('content_report11');">Rekap Instruksi</a></li>
            </ul>
        </li>
        <?php if($itd_user_unit!=2){ ?>
        <li>Referensi
            <ul>
                <li><a href="#" onclick="show_sections('tbl_slick_pic');">PIC</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_client');">Klien</a></li>
                <?php if($lvl<=0) { ?>
                <li><a href="#" onclick="show_sections('tbl_slick_user');">User App</a></li>
                <?php } ?>
            </ul>
        </li>
        <?php }?>
        <?php if($itd_user_unit!=2){ ?>
        <li><a href="#" onclick="show_sections('tbl_slick_docim');">Dokumen Scan</a></li>
        <li>Rekening Operasional
            <ul>
                <?php if($lvl<=5) { ?>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_client');">No Rekening</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_coa');">Kategori</a></li>
                <?php } ?>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_balance');">Rekap Balance</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_jasgirmon');">Maintenance Jasa Giro</a></li>
                <li><a href="#" onclick="show_sections('content_mutasi11');">Mutasi</a></li>
            </ul>
        </li>
        <?php } ?>
        <li><a href="#" onclick="show_dlg_change_pass();">Ubah Password</a></li>
        <li><a href="<?php echo $url;?>index.php/itd/do_logout">Logout</a></li>
    </ul>
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

<?php if($itd_user_unit!=2){ ?>
<!-- DIALOG BOX w/ FRM TRX -->
<DIV id="dialogBox_frm_trx"></DIV> 
<DIV id="dialogBox_frm_trx_search"></DIV> 
<DIV id="dialogBox_frm_trx_history"></DIV>
<DIV id="dialogBox_frm_trx_ticket"></DIV> 

<!-- DIALOG BOX w/ User -->
<DIV id="dialogBox_user"></DIV> 
<DIV id="dialogBox_user_reset_pass"></DIV> 
<?php }?>
<DIV id="dialogBox_user_change_pass"></DIV> 

<?php if($itd_user_unit!=2){ ?>
<!-- DIALOG BOX w/ pic -->
<DIV id="dialogBox_pic"></DIV> 
<DIV id="dialogBox_pic_search"></DIV> 

<!-- DIALOG BOX w/ Klien -->            
<DIV id="dialogBox_client"></DIV>  
<DIV id="dialogBox_client_search"></DIV>

<!-- DIALOG BOX w/ docim -->
<DIV id="dialogBox_docim_search"></DIV> 
<DIV id="dialogBox_docim_listing"></DIV> 
<?php }?>

<!-- DIALOG BOX w/ Bilyet -->
<DIV id="dialogBox_bilyet_inst_search"></DIV>  
<DIV id="dialogBox_bilyet_inst_in"></DIV>
<DIV id="dialogBox_bilyet_inst_out"></DIV>

<!-- DIALOG BOX w/ Report -->
<DIV id="dialogBox_report11_search"></DIV>  

<!-- DIALOG BOX w/ Mutasi -->
<DIV id="dialogBox_mutasi11_1"></DIV>  
<DIV id="dialogBox_mutasi11_2"></DIV>  
<DIV id="dialogBox_mutasi11_3"></DIV>
<DIV id="dialogBox_mutasi11_4"></DIV>

<!-- DIALOG BOX w/ Mutasi Klien -->            
<DIV id="dialogBox_mutasi11_client"></DIV>  
<DIV id="dialogBox_mutasi11_client_search"></DIV>

<!-- DIALOG BOX w/ Mutasi Coa -->            
<DIV id="dialogBox_mutasi11_coa"></DIV> 

<div id="dlg_dpicker" style="position: absolute; width: 500px; height: 200px; border: 1px solid #800000; z-index: 8000; display: none; background-color: #800000;" class="ui-widget-content"></div>

<div id="add1" style="display: none;"></div>
<form action="" id="frm_hidden_trx" style="display: none;" target="_blank" method="post"></form>
<form action="" id="frm_hidden" style="display: none;" target="_blank" method="post"></form>
</body>
</html>
