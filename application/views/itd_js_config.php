<?php if($r_login) { ?>
var uri="<?php echo $url;?>";
var lvl=<?php echo $lvl;?>;
var user_unit=<?php echo $itd_user_unit;?>;
var user_id='<?php echo $uid;?>';
var dlmt = "_";   
<?php
$today = getdate();
//echo "var saiki='{$today["year"]}-{$today["mon"]}-{$today["mday"]}';\n";
echo "var saiki='" . (substr('00' . $today["mday"],-2)) . "-" . (substr('00' . $today["mon"],-2)) . "-{$today["year"]}';\n";
?>
var uri_dlg_client = "<?php echo $url . "index.php/itd_dlg/v_client";?>";
var uri_dlg_client_search = "<?php echo $url . "index.php/itd_dlg/v_client_search";?>";
var uri_dlg_pic = "<?php echo $url . "index.php/itd_dlg/v_pic";?>";
var uri_dlg_pic_search = "<?php echo $url . "index.php/itd_dlg/v_pic_search";?>";
var uri_dlg_trx = "<?php echo $url . "index.php/itd_dlg/v_trx";?>";
var uri_dlg_trx_search = "<?php echo $url . "index.php/itd_dlg/v_trx_search";?>";
var uri_dlg_trx_ticket = "<?php echo $url . "index.php/itd_dlg/v_trx_ticket";?>";
var uri_dlg_user = "<?php echo $url . "index.php/itd_dlg/v_user";?>";
var uri_dlg_bilyet_inst_search = "<?php echo $url . "index.php/itd_dlg/v_bilyet_inst_search";?>";
var uri_dlg_bilyet_inst_in = "<?php echo $url . "index.php/itd_dlg/v_bilyet_inst_in";?>";
var uri_dlg_bilyet_inst_out = "<?php echo $url . "index.php/itd_dlg/v_bilyet_inst_out";?>";
var uri_dlg_trx_history = "<?php echo $url . "index.php/itd_dlg/v_trx_history";?>";
var uri_dlg_trx_approve = "<?php echo $url . "index.php/itd_dlg/v_trx_approve";?>";

var uri_dlg_docim_search = "<?php echo $url . "index.php/docim/v_docim_search";?>";
var uri_dlg_docim_listing = "<?php echo $url . "index.php/docim/v_tmp_folder";?>";

var uri_report11 = "<?php echo $url . "index.php/itd_report/v_report/1/1";?>";
var uri_dlg_report11_search = "<?php echo $url . "index.php/itd_report_dlg/v_dlg_report_search/1/1";?>";
var uri_dlg_report11_save = "<?php echo $url . "index.php/itd_report_dlg/report11_search_save/";?>";

var uri_mutasi11 = "<?php echo $url . "index.php/mutasi/v_mutasi";?>";
var uri_mutasi11_dlg1 = "<?php echo $url . "index.php/mutasi_dlg/v_1";?>";
var uri_mutasi11_dlg2 = "<?php echo $url . "index.php/mutasi_dlg/v_2";?>";
var uri_mutasi11_dlg3 = "<?php echo $url . "index.php/mutasi_dlg/v_3";?>";
var uri_mutasi11_dlg4 = "<?php echo $url . "index.php/mutasi_dlg/v_4";?>";
var uri_dlg_mutasi11_client = "<?php echo $url . "index.php/mutasi_client_dlg/v_client";?>";
var uri_dlg_mutasi11_coa = "<?php echo $url . "index.php/mutasi_coa_dlg/v_coa";?>";
var uri_dlg_mutasi11_client_search = "<?php echo $url . "index.php/mutasi_client_dlg/v_client_search";?>";
var uri_dlg_mutasi11_bf = "<?php echo $url . "index.php/mutasi_bf_dlg/v_bf";?>";


var uri_subs = "<?php echo $url . "index.php/subscript/v_subscript";?>";
var uri_subs_client_dlg = "<?php echo $url . "index.php/subscript_client/v_dlg";?>";
var uri_subs_save_dlg = "<?php echo $url . "index.php/subscript/v_save_dlg";?>";

var uri_subsrd = "<?php echo $url . "index.php/subsrd/";?>";
var uri_subsrd_dlg = "<?php echo $url . "index.php/subsrd/v_subsrd";?>";

var uri_subsrd_mi = "<?php echo $url . "index.php/subsrd_mi/";?>";
var uri_subsrd_mi_dlg = "<?php echo $url . "index.php/subsrd_mi/v_dlg";?>";
var uri_subsrd_bank = "<?php echo $url . "index.php/subsrd_bank/";?>";
var uri_subsrd_bank_dlg = "<?php echo $url . "index.php/subsrd_bank/v_dlg";?>";
var uri_subsrd_client = "<?php echo $url . "index.php/subsrd_client/";?>";
var uri_subsrd_client_dlg = "<?php echo $url . "index.php/subsrd_client/v_dlg";?>";
var uri_subsrd_sa = "<?php echo $url . "index.php/subsrd_sa/";?>";
var uri_subsrd_sa_dlg = "<?php echo $url . "index.php/subsrd_sa/v_dlg";?>";
var uri_subsrd_acc = "<?php echo $url . "index.php/subsrd_acc/";?>";
var uri_subsrd_acc_dlg = "<?php echo $url . "index.php/subsrd_acc/v_dlg";?>";
var uri_subsrd_rekap = "<?php echo $url . "index.php/subsrd_rekap/";?>";

var uri_subsrd_pay = "<?php echo $url . "index.php/subsrd_pay/";?>";
var uri_subsrdrekon = "<?php echo $url . "index.php/subsrd_rekon/";?>";

var uri_dlg_tc5 = "<?php echo $url . "index.php/tc5/v_tc5_dlg";?>";
var uri_user_parameter = "<?php echo $url . "index.php/user_parameter/";?>";

var uri_dlg_client_group = "<?php echo $url . "index.php/itd_dlg/v_client_group";?>";

function check_login()
{
    var obj_get_session=$.get(uri+'index.php/itd/check_session',function(data_session)
    {       
        if (data_session==='0')
        {
            alert("Session is expired!");
            window.location.assign(uri);
        }
    });
    t=setTimeout("check_login()",120000);
}
$(function(){
    check_login();
});

<?php } ?>
