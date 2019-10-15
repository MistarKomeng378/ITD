<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { ?>

<div style="width: 100%; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">Mutasi Jasa Giro</div>
<div style="width: 100%;  padding: 3px; border:1px solid #000058;" align="left">
    <div style="display: block;">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <input type="hidden" id="i_mutasi11_trx_id" value="0">
            <tr>
                <td colspan="3">
                    <table width="100%" border="0">
                        <tr>
                            <td width="1%">Klien</td>
                            <td width="1%">Rekening</td>
                            <td width="1%">Atas Nama</td>
                            <td width="1%">Last Date</td>  
                            <td>Last Status</td>  
                        </tr>
                        <tr>
                            <td><input type="text" id="i_mutasi11_client_code" style="width:60px;text-align: center;"  /></td>
                            <td><input type="text" id="i_mutasi11_rek" style="width:120px;text-align: center;" readonly /></td>
                            <td><input type="text" id="i_mutasi11_client_name" style="width:320px;text-align: left;" readonly  /></td>
                            <td><input type="text" id="i_mutasi11_client_last_date" style="width:90px;text-align: center;" readonly  /></td>
                            <td><input type="text" id="i_mutasi11_client_status" style="width:90px;text-align: center;" readonly  /></td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td width="1%">Tanggal</td>
                <td width="1%">:</td>
                <td><input type="text" id="i_mutasi11_client_dt" style="width:65px;text-align: center;" class="dtpick"  /></td>
            </tr>
        </table>
    </div>
    <div id="tbl_slick_mutasi11" style="height: 200px;"></div>
    <div style="display:block; border: 1px solid #580058;margin:5px; padding: 3px; font-weight: bold; font-size: 120%;" align="center">
        <span id="s_mutasi11_dc">K= 000,000,000.00 *** D= 000,000,000,000.00</span>
    </div>
    <div>
        <table width="100%" cellpadding="0" cellspacing="2" border="0">
            <tr>
                <td  width="50%"  align="right"><b><span id="s_mutasi11_last_dt">Previous Balance Date</span></b></td>
                <td align="right"><b><span id="s_mutasi11_current_dt">On Date</span></b></td>
            </tr>
            <tr>
                <td align="right">Status : <input type="text" id="i_mutasi11_status1" style="text-align: right;" readonly /></td>
                <td align="right">Status : <input type="text" id="i_mutasi11_status2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td colspan="2" height="1"></td>
            </tr>
            <tr>
                <td align="right">Opening Balance : <input type="text" id="i_mutasi11_obal1" style="text-align: right;" readonly /></td>
                <td align="right">Opening Balance : <input type="text" id="i_mutasi11_obal2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right">Total Transaction : <input type="text" id="i_mutasi11_tbal1" style="text-align: right;" readonly /></td>
                <td align="right">Total Transaction : <input type="text" id="i_mutasi11_tbal2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right">Closing Balance : <input type="text" id="i_mutasi11_cbal1" style="text-align: right;" readonly /></td>
                <td align="right">Closing Balance : <input type="text" id="i_mutasi11_cbal2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right" valign="top">GS Balance : <input type="text" id="i_mutasi11_gbal1" style="text-align: right;" readonly /></td>
                <td align="right" valign="top">
                    GS Balance : <input type="text" id="i_mutasi11_gbal2" style="text-align: right;" readonly /><br /><span id="s_mutasi11_gbal2" style="display:none;"></span>
                </td>
            </tr>
            <tr>
                <td align="right">Selisih : <input type="text" id="i_mutasi11_sel1" style="text-align: right;" readonly /></td>
                <td align="right">Selisih : <input type="text" id="i_mutasi11_sel2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right">Closed By : <input type="text" id="i_mutasi11_c_by1" readonly /></td>
                <td align="right">Closed By : <input type="text" id="i_mutasi11_c_by2" readonly /></td>
            </tr>
            <tr>
                <td align="right">Closed Date : <input type="text" id="i_mutasi11_c_dt1" readonly /></td>
                <td align="right">Closed Date : <input type="text" id="i_mutasi11_c_dt2" readonly /></td>
            </tr>                                                                      
            <tr>
                <td align="right">Closed Time : <input type="text" id="i_mutasi11_c_time1" readonly /></td>
                <td align="right">Closed Time : <input type="text" id="i_mutasi11_c_time2" readonly /></td>
            </tr>
            <tr>
                <td align="right">
                    <table width="100%" border="0">
                        <tr>
                            <td valign="top" align="right">Remark:</td>
                            <td valign="top" align="right"  width="1%">
                                <textarea cols="50" rows="4" id="i_mutasi11_remark1"  readonly></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="right">
                    <table width="100%" border="0">
                        <tr>
                            <td valign="top" align="right">Remark:</td>
                            <td valign="top" align="right"  width="1%">
                                <textarea cols="50" rows="4" id="i_mutasi11_remark2" readonly></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php } ?>
<?php } ?>
