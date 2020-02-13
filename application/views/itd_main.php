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
    <script type="text/javascript" src="<?php echo $url;?>js/slick.dataview.js"></script>

        
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
    <?php if( ($itd_user_unit==1 || $itd_user_unit==0)  && $lvl!=0){ ?>
        <script type="text/javascript" src="<?php echo $url;?>js/client.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/client_dlg.js"></script>   
        <script type="text/javascript" src="<?php echo $url;?>js/client_dlg_search.js"></script>   
        <script type="text/javascript" src="<?php echo $url;?>js/pic.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/pic_dlg.js"></script> 
        <script type="text/javascript" src="<?php echo $url;?>js/pic_dlg_search.js"></script> 
        <script type="text/javascript" src="<?php echo $url;?>js/docim.js"></script> 
        <script type="text/javascript" src="<?php echo $url;?>js/docim_dlg_search.js"></script> 
        <script type="text/javascript" src="<?php echo $url;?>js/docim_dlg_listing.js"></script> 
        <?php if($lvl<=5) { ?>
        <script type="text/javascript" src="<?php echo $url;?>js/client_group.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/client_group_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mail.js"></script>
        <?php  } ?>
        
        <script type="text/javascript" src="<?php echo $url;?>js/trx.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/trx_search_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg_ticket.js"></script> 
        <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg_history.js"></script>    
        <script type="text/javascript" src="<?php echo $url;?>js/trx_dlg_approve.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/trx_duedate.js"></script>
        
        <script type="text/javascript" src="<?php echo $url;?>js/trx_nfs.js"></script>
    <?php } ?> 
    <?php if($lvl<=0) { ?>
        <script type="text/javascript" src="<?php echo $url;?>js/user.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/user_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/user_par.js"></script>
    <?php } ?>
    <script type="text/javascript" src="<?php echo $url;?>js/pass_dlg.js"></script>
    <script type="text/javascript" src="<?php echo $url;?>js/pass.js"></script>
    <?php if( ($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0)  && $lvl!=0){ ?>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_search_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_in_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/bilyet_inst_out_dlg.js"></script>
    <?php } ?> 
    <script type="text/javascript" src="<?php echo $url;?>js/dPicker.js"></script>    
    <script type="text/javascript" src="<?php echo $url;?>js/printPage.js"></script>
    
    <?php if( ($itd_user_unit==1 || $itd_user_unit==0)  && $lvl!=0){ ?>
        <script type="text/javascript" src="<?php echo $url;?>js/itd_report11.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/itd_report11_dlg_search.js"></script>
        
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg1.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg2.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg3.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_dlg4.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_jasgirmon.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_bf.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_bf_dlg.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_balance.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_rekap.js"></script>
        <?php if($lvl<=5) { ?>
            <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_client.js"></script>
            <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_client_dlg.js"></script>
            <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_client_dlg_search.js"></script> 
            <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_coa.js"></script>
            <script type="text/javascript" src="<?php echo $url;?>js/mutasi11_coa_dlg.js"></script>
        <?php } ?>
        <script type="text/javascript" src="<?php echo $url;?>js/subs.js"></script>        
        <script type="text/javascript" src="<?php echo $url;?>js/subs_save_dlg.js"></script>        
        <script type="text/javascript" src="<?php echo $url;?>js/subs_client.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/subs_rekap.js"></script>
        <!-- Subscript -->
        <script type="text/javascript" src="<?php echo $url;?>js/subsrd.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/subsrd_mi.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/subsrd_bank.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/subsrd_client.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/subsrd_sa.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/subsrd_acc.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/subsrd_rekap.js"></script>
        <script type="text/javascript" src="<?php echo $url;?>js/baltrx_os.js"></script>
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
                                                             
        <?php if( ($itd_user_unit==1 ||  $itd_user_unit==0) && $lvl!=0){ ?>
            initiate_trx(); 
            initiate_trx_nfs(); 
            initiate_pic();
            initiate_client();
            initiate_docim();
            initiate_trx_duedate();
            
            initiate_report11();
            initiate_mutasi11();
            initiate_mutasi11_jasgirmon();
            initiate_mutasi11_bf();
            initiate_mutasi11_balance();
            initiate_mutasi11_rekap();
            <?php if($lvl<=5) { ?>
                initiate_client_group();
                initiate_mutasi11_client();
                initiate_mutasi11_coa();
                initiate_mail();
            <?php } ?>
            initiate_subs();
            initiate_subs_client();
            initiate_subs_rekap();
            create_dlg_subs_save();
            
             initiate_subsrd();
            initiate_subsrd_mi();
            initiate_subsrd_bank();
            initiate_subsrd_client();
            initiate_subsrd_sa();
            initiate_subsrd_acc();
            initiate_subsrd_rekap();
            initiate_baltrx_os();
        <?php } ?>
        initiate_pass();
        <?php if($lvl<=0) { ?>
            initiate_user();
            initiate_user_parameter();        
        <?php }?>
        <?php if( ($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0)  && $lvl!=0){ ?>
            initiate_bilyet_inst();            
            //refresh_bilyet_status_count();
            refresh_bilyet_status_count(); 
        <?php } ?>
        
        
        $(".dtpick").datepicker();
        $(".dtpick").datepicker( "option", "dateFormat", 'dd-mm-yy' ); 
        $(".dtpick").val(saiki);
        //$("#dialogBox_frm_trx_approval").show();
        //if(user_unit==2)
        //    show_sections('tbl_slick_bilyet_inst');
    });       
    </script>
</head> 
<body> 

<div class="outer-center">

    <div class="middle-center">

        <div class="inner-center gw_bg">
            <?php if( ($itd_user_unit==1 || $itd_user_unit==0) && $lvl!=0){ ?>
                <div id="tbl_slick_trx" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_trx_nfs" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_pic" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_client" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_docim" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_duedate" style="width: 100%; height: 100%; display: none;"></div>
                <?php  if($lvl<=5) { ?>
                <div id="tbl_slick_client_group" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_mail" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_mutasi11_client" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_mutasi11_coa" style="width: 100%; height: 100%; display: none;"></div>
                <?php }?>   
                <div id="tbl_slick_mutasi11_jasgirmon" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_mutasi11_bf" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_mutasi11_balance" style="width: 100%; height: 100%; display: none;"></div>
                <div id="content_mutasi11_rekap" style="width: 100%; height: 100%; display: none;"></div>
                <div id="content_report11" style="width: 100%; height: 100%; display: none;"></div>
                <div id="content_mutasi11" style="width: 910px; height: 500px; display: none;"></div>
                <div id="tbl_slick_baltrx_os" style="width: 100%; height: 100%; display: none;"></div>
                
            <?php }?>
            <?php if( ($itd_user_unit==1 || $itd_user_unit==0) && $lvl!=0){ ?>  
                <div id="tbl_slick_subs_client" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_subs_rekap" style="width: 100%; height: 100%; display: none;"></div>
                <div id="content_subs" style="width: 100%; height: 100%; display: none;"></div>
                
                <div id="tbl_slick_subsrd_mi" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_subsrd_bank" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_subsrd_client" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_subsrd_sa" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_subsrd_acc" style="width: 100%; height: 100%; display: none;"></div>
                <div id="tbl_slick_subsrd_rekap" style="width: 100%; height: 100%; display: none;"></div>
                <div id="content_subsrd" style="width: 100%; height: 100%; display: none;"></div>
            <?php } ?>
            
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
            <?php if(($itd_user_unit==1 || $itd_user_unit==0) && $lvl!=0){ ?>
                <!-- Buttons ITD -->
                <div id="hbtn_trx" style="display: none; vertical-align: middle;">
                    <button id="hbtn_trx_search">Cari Inst</button> 
                    -
                    <select id="hselect_trx_type">
                        <option value="1">Penempatan</option>
                        <option value="2">Perpanjangan</option>
                        <option value="3">Pencairan</option>
                        <option value="4">Break</option>
                    </select>
                    <button id="hbtn_trx_new">Buat Inst</button> 
                    <?php if($lvl<=5) { ?>
                    <button id="hbtn_trx_edit">Ubah Inst</button> 
                    <button id="hbtn_trx_cancel">Batalkan Inst</button> 
                    <?php }?>
                    -
                    <button id="hbtn_trx_ticket">Buat Tiket</button> -
                    <button id="hbtn_trx_print">Cetak</button> 
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
                    -
                    <button id="instruksi_deposito_excel">Save To Excel</button>
                </div>
                <!-- END OF Buttons ITD -->
                <div id="hbtn_trx_nfs" style="display: none; vertical-align: middle;">
                <button id="hbtn_trx_search_nfs">Cari Inst</button>           -
                <input id="i_trx_list_dt_nfs" type="text" class="dtpick" style="width:80px;text-align: center;" /> 
                <button id="hbtn_trx_get_nfs">Get data from S-INVEST</button> 
                <button id="hbtn_trx_nfs_pending">Pending data</button> 
                <?php if($lvl<=5) { ?>
                <button id="hbtn_trx_approve_nfs">Approve & Cetak</button>                 
                <?php }?>
                -
                <button id="hbtn_trx_ticket_nfs">Buat Tiket</button> 
                <button id="hbtn_trx_print_nfs">Cetak</button> 
                -
                <button id="hbtn_trx_refresh_nfs">Reload</button> 
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
                
                <?php if($lvl<=5) { ?>
                <div id="hbtn_client_group" style="display: none;">
                    <button id="hbtn_client_group_new">Baru</button> 
                    <button id="hbtn_client_group_edit">Ubah</button>
                    <button id="hbtn_client_group_del">Hapus</button> 
                    -
                    <button id="hbtn_client_group_refresh">Refresh</button>
                </div>
                <?php }?>
                <!-- Button Mutasi-->
                <div id="hbtn_mutasi11" style="display: none;">
                <button id="hbtn_mutasi11_open_day_all">Awal Hari (All Account)</button> - 
                <button id="hbtn_mutasi11_open_day">Awal Hari</button>  
                <button id="hbtn_mutasi11_close_day">Akhir Hari</button>  
                <button id="hbtn_mutasi11_p_jasgir">Buat Jasa Giro</button>  
                <?php if($lvl<=5) { ?>
                <!--ton id="hbtn_mutasi11_cancel_close_day">Batal Akhir Hari</button> -->
                <?php }?> -
                <button id="hbtn_mutasi11_p_mutasi">Cetak Mutasi</button>  
                <button id="hbtn_mutasi11_c_jasgir">Cetak Jasa Giro</button>  
                <button id="hbtn_mutasi11_p_rekap">Cetak Rekap Jasa Giro</button>  
                </div>
                <!-- End Of Button Mutasi-->
                <div id="hbtn_report11" style="display: none;">
                <button id="hbtn_report11_search">Kategori Rekap Instruksi</button>  
                <button id="hbtn_report11_save">Save Rekap Instruksi</button>  
                </div>
                <div id="hbtn_docim" style="display: none;">
                    <button id="hbtn_docim_search">Cari Dokumen</button>
                    <?php if($lvl<0) { ?>
                    - <button id="hbtn_docim_listing">Listing Dokumen</button> 
                    <?php } ?>
                </div>
                <?php if($lvl<=5) { ?>
                <div id="hbtn_mutasi11_client" style="display: none;">
                    <button id="hbtn_mutasi11_client_search">Cari</button> -
                    <button id="hbtn_mutasi11_client_new">Baru</button> 
                    <button id="hbtn_mutasi11_client_edit">Ubah</button>
                    <?php if($lvl<5) { ?>
                    <button id="hbtn_mutasi11_client_edit_rek">Ubah Kode Klien atau No Rekening</button>
                    <?php } ?>
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
                    client :
                    <select id="hbtn_mutasi11_balance_cli">
                        <option value="ALL">ALL</option>
                    </select>
                    Tanggal : 
                    <input type="text" class="dtpick" id="hbtn_mutasi11_balance_dt1" style="width: 80px; text-align: center;"  /> s/d
                    <input type="text" class="dtpick" id="hbtn_mutasi11_balance_dt2" style="width: 80px; text-align: center;"  /> 
                    <button id="hbtn_mutasi11_balance_reload">Reload</button> 
                    <button id="hbtn_mutasi11_balance_save">Save to Excel</button> 
                    -
                    <button id="hbtn_mutasi11_balance_compare_save">Compare Selisih</button>         
                </div>
                <div id="hbtn_mutasi11_rekap" style="display: none;">
                    <form action="<?php echo $url;?>/index.php/mutasi/v_rekap" target="_subsrd_rekon" method="post">
                    Tanggal :
                    <input type="text" class="dtpick" id="hbtn_mutasi11_rekap_dt" style="width: 80px; text-align: center;" name="dt1"  /> 
                    <input type="button" id="hbtn_mutasi11_rekap_reload" value="Reload" />
                    <input type="submit" id="hbtn_mutasi11_rekap_prev" value="Preview" />
                    </form>
                </div>
                <div id="hbtn_mutasi11_bf" style="display: none;">
                    &nbsp; 
                    <select id="hbtn_mutasi11_bf_coa">
                        <option value="ALL">ALL</option>
                        <option value="C007">JUAL OBLIGASI</option>
                        <option value="D005">BELI OBLIGASI</option>
                    </select>
                    <select id="hbtn_mutasi11_bf_doc">
                        <option value="-1">ALL</option>
                        <option value="1">ADA DOKUMEN</option>
                        <option value="0">BELUM ADA DOKUMEN</option>
                    </select>
                    Tanggal : 
                    <input type="text"  id="hbtn_mutasi11_bf_dt1" style="width: 80px; text-align: center;" class="dtpick"  /> s/d
                    <input type="text"  id="hbtn_mutasi11_bf_dt2" style="width: 80px; text-align: center;" class="dtpick"  /> 
                    -
                    <button id="hbtn_mutasi11_bf_reload">Reload</button> 
                    <button id="hbtn_mutasi11_bf_save">Save to Excel</button> 
                    -
                    <button id="hbtn_mutasi11_bf_edit">Ubah</button> 
                    
                     
                </div>
                <!-- Button Reksadana-->
                <div id="hbtn_subsrd" style="display: none;">
                <button id="hbtn_subsrd_open_day">Awal Hari</button>    
                <?php if($lvl<=5) { ?>
                <button id="hbtn_subsrd_close_day">Approve &amp; Close</button>
                <button id="hbtn_subsrd_cancel_close_day" disabled="disabled">Batal Akhir Hari (Accounting)</button> 
                <?php }?> 
                - <button id="hbtn_subsrd_print">Cetak Instruksi</button>  
                </div>
                <?php if($lvl<=5) { ?>
                <div id="hbtn_mail" style="display: none;">
                <button id="hbtn_mail_new">Tambah</button> 
                <button id="hbtn_mail_edit">Ubah</button> 
                <button id="hbtn_mail_del">Hapus</button> -
                <button id="hbtn_mail_refresh">Refresh</button>             
                </div>
                <div id="hbtn_subs_client" style="display: none;">
                <button id="hbtn_subs_client_add">Tambah</button>  
                <button id="hbtn_subs_client_edit">Ubah</button>  
                <button id="hbtn_subs_client_reload">Reload</button>  
                <button id="hbtn_subs_client_save">Save to Excel</button>  
                </div>
                 <div id="hbtn_subsrd_client" style="display: none;">
                <button id="hbtn_subsrd_client_add">Tambah</button>  
                <button id="hbtn_subsrd_client_edit">Ubah</button>  
                <button id="hbtn_subsrd_client_reload">Reload</button>  
                </div>
                <div id="hbtn_subsrd_mi" style="display: none;">
                <button id="hbtn_subsrd_mi_add">Tambah</button>  
                <button id="hbtn_subsrd_mi_edit">Ubah</button>  
                <button id="hbtn_subsrd_mi_reload">Reload</button>  
                </div>
                <div id="hbtn_subsrd_bank" style="display: none;">
                <button id="hbtn_subsrd_bank_add">Tambah</button>  
                <button id="hbtn_subsrd_bank_edit">Ubah</button>  
                <button id="hbtn_subsrd_bank_reload">Reload</button>  
                </div>
                <div id="hbtn_subsrd_sa" style="display: none;">
                <button id="hbtn_subsrd_sa_add">Tambah</button>  
                <button id="hbtn_subsrd_sa_edit">Ubah</button>  
                <button id="hbtn_subsrd_sa_reload">Reload</button>  
                </div>
                <div id="hbtn_subsrd_acc" style="display: none;">
                <button id="hbtn_subsrd_acc_add">Tambah</button>  
                <button id="hbtn_subsrd_acc_edit">Ubah</button>  
                <button id="hbtn_subsrd_acc_reload">Reload</button>  
                </div>
                <?php } ?>
                <div id="hbtn_subsrd" style="display: none;">
                <button id="hbtn_subsrd_open_day">Awal Hari </button>    
                <?php if($lvl<=5) { ?>
                <button id="hbtn_subsrd_close_day">Akhir Hari</button>
                <button id="hbtn_subsrd_cancel_close_day">Batal Akhir Hari</button> 
                <?php }?> 
                - <button id="hbtn_subsrd_print">Cetak Instruksi</button>  
                </div>
                <div id="hbtn_subsrd_rekap" style="display: none;"> 
                Date : <input type="text" class="dtpick" id="hbtn_subsrd_rekap_dt" style="width: 80px; text-align: center;"  />
                s/d <input type="text" class="dtpick" id="hbtn_subsrd_rekap_dt2" style="width: 80px; text-align: center;"  />
                <button id="hbtn_subsrd_rekap_reload">Reload</button>  
                <button id="hbtn_subsrd_rekap_export" >Export to Excel</button>  
                <form action="<?php echo $url."index.php/subsrd_rekap/get_excel";?>" method="post" target="_blank" id="frm_subsrd_rekap">
                <input type="hidden" id="hbtn_subsrd_rekap_dt1_h" name="s_dt" />
                <input type="hidden" id="hbtn_subsrd_rekap_dt2_h" name="s_dt2" />
                </form>
                </div>
                <div id="hbtn_baltrx_os" style="display: none;">
                    Trade Date: <input type="text" class="dtpick" id="hbtn_baltrx_os_dt" style="width: 80px; text-align: center;" name="dt"  />
                    <input type="button" id="hbtn_baltrx_os_reload"  value="Reload Data" />-
                    <input type="button" id="hbtn_baltrx_os_print"  value="Print" />
                </div>
                
                <div id="hbtn_subs_rekap" style="display: none;">
                Kode Client: <input type="text" id="hbtn_subs_rekap_ccode" style="width: 50px; text-align: center;"  />
                Tanggal Update  <input type="text" class="dtpick" id="hbtn_subs_rekap_dt1" style="width: 80px; text-align: center;"  /> s/d
                <input type="text" class="dtpick" id="hbtn_subs_rekap_dt2" style="width: 80px; text-align: center;"  />
                <!--
                Awal Periode Buku : <input type="text" class="dtpick" id="hbtn_subs_rekap_dt" style="width: 80px; text-align: center;"  />
                -->
                <button id="hbtn_subs_rekap_reload">Reload</button>  
                <button id="hbtn_subs_rekap_save">Save to Excel</button>  
                </div>
                <div id="hbtn_subs" style="display: none;">
                Tanggal Awal Periode Buku : <input type="text" class="dtpick" id="hbtn_subs_dt" style="width: 80px; text-align: center;"  />
                <button id="hbtn_subs_reload1">Reload</button>  
                <button id="hbtn_subs_save1">Download pending subscription...</button>  
                <button id="hbtn_subs_print1" style="display: none;">Cetak</button>  
                </div>
            <?php } ?>
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
                <button id="hbtn_bilyet_inst_save">Save as..</button>
            </div>   
            <?php }?>
            <?php if($lvl<=0) { ?>
            <div id="hbtn_user" style="display: none;">
                <button id="hbtn_user_new">Baru</button> 
                <button id="hbtn_user_edit">Ubah</button> 
                <button id="hbtn_user_del">Hapus</button> 
                <button id="hbtn_user_reset_pass">Reset Password</button>  -
                <button id="hbtn_user_refresh">Refresh</button>             
            </div>
            <?php } ?> 
            <?php if($lvl<=10) { ?> 
            <div id="hbtn_trx_duedate" style="display: none;">               
                <!-- Due Date:  -->
                <input type="hidden" class="dtpick" id="hbtn_trx_duedate_dt" style="width: 80px; text-align: center;"  />
                <!-- <button id="hbtn_trx_duedate_reload">Reload</button>    -->
                <!-- <span style="margin-left: 30px"></span> -->
              
                Start: <input type="text" class="dtpick" id="hbtn_trx_duedate_dt_start" style="width: 80px; text-align: center;"  />
                End: <input type="text" class="dtpick" id="hbtn_trx_duedate_dt_end" style="width: 80px; text-align: center;"  />                
                <button id="hbtn_trx_duedate_filter_reload">Reload</button>
                <button id="hbtn_trx_duedate_save_to_excel">Save to Excel</button>
               
            </div> 
            
            <?php } ?>
            
        </div> 
    </div> 
</div> 

<div class="outer-west gw_bg">
    <!-- START MENUS -->
    <ul id="west_toc">
        <?php if( ($itd_user_unit==1 || $itd_user_unit==0) && $lvl!=0){ ?>
        <li>Transaksi Deposito
            <ul>
                <li><a href="#" onclick="show_sections('tbl_slick_trx');">Instruksi Deposito</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_trx_nfs');">S-INVEST TD</a></li>
                <li><a href="#" onclick="show_sections('content_report11');">Rekap Instruksi</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_pic');">PIC</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_client');">Klien</a></li>
                <?php  if($lvl<=5) { ?> 
                <li><a href="#" onclick="show_sections('tbl_slick_client_group');">Klien Mail Group</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_mail');">Mail Sender</a></li>
                <?php }?>
                <li><a href="#" onclick="show_sections('tbl_slick_duedate');">Deposito Jatuh Tempo</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if( ($itd_user_unit==1 || $itd_user_unit==2 || $itd_user_unit==0) && $lvl!=0){ ?>
        <li>Bilyet Instruksi Deposito
            <ul>
                <li><a href="#" onclick="show_sections('tbl_slick_bilyet_inst');">Bilyet IN/ OUT</a></li>
            </ul>
        </li>
        <?php } ?>
        
        <?php if( ($itd_user_unit==1 || $itd_user_unit==0) && $lvl!=0){ ?>
        <li><a href="#" onclick="show_sections('tbl_slick_docim');">Dokumen Scan</a></li>
        <li>Rekening Operasional
            <ul>
                <?php if($lvl<=5) { ?>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_client');">No Rekening</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_coa');">Kategori</a></li>
                <?php } ?>                                                                     
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_balance');">Rekap Balance</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_jasgirmon');">Rekap Jasa Giro</a></li>
                <!--
                <li><a href="#" onclick="show_sections('tbl_slick_mutasi11_bf');">Dokumen Fee Broker</a></li>
                -->
                <li><a href="#" onclick="show_sections('content_mutasi11');">Mutasi</a></li>
                <li><a href="#" onclick="show_sections('content_mutasi11_rekap');">Summary</a></li>
            </ul>
        </li>
        <?php } ?>
        
        <?php if( ($itd_user_unit==1 || $itd_user_unit==0) && $lvl!=0){ ?>
        <li>Rekening Subscription
            <ul>
                <?php if($lvl<=5) { ?>
                <li><a href="#" onclick="show_sections('tbl_slick_subs_client');">No Rekening</a></li>
                <?php } ?>                                                                     
                <li><a href="#" onclick="show_sections('tbl_slick_subs_rekap');">Rekap Pending Subs</a></li>
                <li><a href="#" onclick="show_sections('content_subs');">Pending Subscription</a></li>
            </ul>
        </li>
        <li>Subscription Reksadana
            <ul>
                <?php if($lvl<=5) { ?>
                <li><a href="#" onclick="show_sections('tbl_slick_subsrd_mi');">MI</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_subsrd_bank');">Bank</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_subsrd_client');">Client</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_subsrd_sa');">Selling Agent</a></li>
                
                <li><a href="#" onclick="show_sections('tbl_slick_subsrd_acc');">Account</a></li>
                
                <?php } ?>                
                <li><a href="#" onclick="show_sections('content_subsrd');">Subscription</a></li>
                <li><a href="#" onclick="show_sections('tbl_slick_subsrd_rekap');">Monitoring</a></li>
            </ul>
        </li>
        <li><a href="#" onclick="show_sections('tbl_slick_baltrx_os');">Balance TRX OS</a></li>
        <?php } ?>
        
        <?php if($lvl<=0) { ?>
        <li><a href="#" onclick="show_sections('tbl_slick_user');">User App</a></li>
        <li><a href="#" onclick="show_sections('content_user_parameter');">User Parameter</a></li>
        <?php } ?>
        <li><a href="<?php echo $url;?>index.php/itd/frm_change_pass">Ubah Password</a></li>
        <li><a href="<?php echo $url;?>index.php/itd/do_logout">Logout</a></li>
    </ul>
    <!-- END OF MENUS -->
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

<?php if($itd_user_unit==1 || $itd_user_unit==0){ ?>
<!-- DIALOG BOX w/ FRM TRX -->
<DIV id="dialogBox_frm_trx"></DIV> 
<DIV id="dialogBox_frm_trx_search"></DIV> 
<DIV id="dialogBox_frm_trx_history"></DIV>
<DIV id="dialogBox_frm_trx_ticket"></DIV> 
<DIV id="dialogBox_trx_approve"></DIV> 

<DIV id="dialogBox_frm_trx_search_nfs"></DIV> 
<DIV id="dialogBox_frm_trx_history_nfs"></DIV>
<DIV id="dialogBox_frm_trx_ticket_nfs"></DIV> 
<DIV id="dialogBox_trx_approve_nfs"></DIV> 

<div id="dialogBox_mutasi_client_kode"></div>
<div id="alert_send_to_mutasi"></div>

<div id="dialogBox_pending_data"></div>

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
