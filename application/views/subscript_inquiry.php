<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { ?>
<div style="width: 820px; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">Pending Subscription</div>
<div style="width: 820px;  padding: 3px; border:1px solid #000058;" align="left">
    <div style="display: block;">
        <table width="100%" border="0" cellpadding="1" cellspacing="0">
            <input type="hidden" id="i_subscript_rek_id_h" value="0">
            <input type="hidden" id="i_subscript_bank_h" value="0">
            <input type="hidden" id="i_subscript_client_h" value="0">
            <tr>
                <td colspan="5">
                    <table border="0">
                        <tr>
                            <td width="1%">Klien</td>
                            <td width="1%">Nama Klien</td>
                            <td width="1%">Bank</td>
                            <td width="1%">Nama Bank</td>
                            <td>Rekening</td>
                        </tr>
                        <tr>
                            <td><input type="text" id="i_subscript_client" style="width:50px;text-align: center;"  /></td>
                            <td><input type="text" id="i_subscript_client_name" style="width:260px;text-align: left;"  readonly /></td>
                            <td><input type="text" id="i_subscript_bank" style="width:50px;text-align: center;" readonly /></td>
                            <td><input type="text" id="i_subscript_bank_name" style="width:260px;text-align: left;" readonly /></td>
                            <td><input type="text" id="i_subscript_rek" style="width:110px;text-align: left;" readonly  /></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div id="tbl_slick_subs" style="height: 220px;border:1px solid #808080"></div>
    <div align="right" style="border:1px solid #808080">
        Total Pending : <input type="text" id="i_subscript_total_pending" style="text-align: right;" readonly />
        &nbsp; &nbsp; &nbsp; &nbsp; 
        Total Buku : <input type="text" id="i_subscript_total_buku" style="text-align: right;" readonly />
    </div>     
    <fieldset>
    <legend>Report Saldo Pending</legend>
    <table width="100%" cellpadding="0" cellspacing="2" border="0">
        <tr>
            <td align="right">Tanggal</td>
            <td align="right">Total Pending</td>
            <td align="right">Saldo Hiport</td>
            <td align="right">Pending+Hiport</td>
            <td align="right">Saldo Rekening</td>
            <td align="right">Selisih</td>
        </tr>
        <tr>
            <td align="right"><input type="text" id="i_subscript_hist_dt" style="width:65px;text-align: center;" class="dtpick"  /></td>
            <td align="right"><input type="text" id="i_subscript_hist_pending" style="text-align: right;" readonly /></td>
            <td align="right"><input type="text" id="i_subscript_hist_hiport" style="text-align: right;" readonly/></td>
            <td align="right"><input type="text" id="i_subscript_hist_pending_hiport" style="text-align: right;" readonly /></td>
            <td align="right"><input type="text" id="i_subscript_hist_rekening" style="text-align: right;" readonly /></td>
            <td align="right"><input type="text" id="i_subscript_hist_selisih" style="text-align: right;" readonly /></td>        
        </tr>
        <tr>
            <td colspan="7"><b>Saldo pending sebelumnya</b></td>
        </tr>
        <tr>
            <td align="right"><input type="text" id="i_subscript_hist_dt1" style="width:65px;text-align: center;" readonly  /></td>
            <td align="right"><input type="text" id="i_subscript_hist_pending1" style="text-align: right;" readonly /></td>
            <td align="right"><input type="text" id="i_subscript_hist_hiport1" style="text-align: right;" readonly/></td>
            <td align="right"><input type="text" id="i_subscript_hist_pending_hiport1" style="text-align: right;" readonly /></td>
            <td align="right"><input type="text" id="i_subscript_hist_rekening1" style="text-align: right;" readonly /></td>
            <td align="right"><input type="text" id="i_subscript_hist_selisih1" style="text-align: right;" readonly /></td>
        </tr>
    </table>
    </fieldset>
</div>
<?php } ?>
<?php } ?>