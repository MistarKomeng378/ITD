<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { ?>

<div style="width: 100%; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">
Subscription Reksadana
</div>
<div style="width: 100%;  padding: 3px; border:1px solid #000058;" align="left">
    <div style="display: block;">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <input type="hidden" id="i_subsrd_trx_id" value="0">
            <tr>
                <td colspan="6">
                    <table width="100%" border="0">
                        <tr>
                            <td width="1%">Klien</td>
                            <td width="1%">Nama Reksadana</td>
                            <td width="1%">Last Date</td>  
                            <td>Last Status</td>  
                        </tr>
                        <tr>
                            <td><input type="text" id="i_subsrd_trx_client_code" style="width:60px;text-align: center;"  /></td>
                            <td><input type="text" id="i_subsrd_trx_client_name" style="width:320px;text-align: left;" readonly  /></td>
                            <td><input type="text" id="i_subsrd_trx_client_last_date" style="width:90px;text-align: center;" readonly  /></td>
                            <td><input type="text" id="i_subsrd_trx_client_status" style="width:90px;text-align: center;" readonly  /></td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td width="1%">Tanggal</td>
                <td width="1%">Selling Agent</td>
                <td width="1%">Keterangan</td>
                <td width="1%">Nominal</td>
                <td width="1%"></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" id="i_subsrd_trx_client_dt" style="width:65px;text-align: center;" class="dtpick"  /></td>
                <td>
                    <select id="i_subsrd_trx_coa">
                    </select>
                </td>
                <td><input type="text" id="i_subsrd_trx_desc" style="width:160px;"  /></td>
                <td><input type="text" id="i_subsrd_trx_nominal" style="width:90px;text-align: right;"  /></td>
                <td><input type="text" id="i_subsrd_trx_nominal_a" style="width:110px;text-align: right;" readonly /></td>
                <td>
                <div>
                    <input type="button" value="Tambah" id="b_subsrd_trx_add" />
                    <input type="button" value="Ubah" id="b_subsrd_trx_edit" style="display: none;" />
                    <input type="button" value="Hapus" id="b_subsrd_trx_del" style="display: none;" />
                    <input type="button" value="Batal" id="b_subsrd_trx_cancel" style="display: none;" />
                </div>
                </td>
            </tr>
        </table>
    </div>
    <div id="tbl_slick_subsrd_trx" style="height: 150px;"></div>
    <div style="display:block; border: 1px solid #580058;margin:5px; padding: 3px; font-weight: bold; font-size: 120%;" align="center">
        <span id="s_subsrd_trx_dc">D= 000,000,000.00 *** K= 000,000,000,000.00</span>
    </div>
    <div>
        <table width="100%" cellpadding="0" cellspacing="2" border="0">
            <tr>
                <td  width="50%"  align="right"><b><span id="s_subsrd_trx_last_dt">Last Date</span></b></td>
                <td align="right"><b><span id="s_subsrd_trx_current_dt">Current Date</span></b></td>
            </tr>
            <tr>
                <td align="right">Status : <input type="text" id="i_subsrd_trx_status1" style="text-align: right;" readonly /></td>
                <td align="right">Status : <input type="text" id="i_subsrd_trx_status2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td colspan="2" height="1"></td>
            </tr>
            <tr>
                <td align="right">Opening Balance : <input type="text" id="i_subsrd_trx_obal1" style="text-align: right;" readonly /></td>
                <td align="right">Opening Balance : <input type="text" id="i_subsrd_trx_obal2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right">Total Transaction : <input type="text" id="i_subsrd_trx_tbal1" style="text-align: right;" readonly /></td>
                <td align="right">Total Transaction : <input type="text" id="i_subsrd_trx_tbal2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right">Closing Balance : <input type="text" id="i_subsrd_trx_cbal1" style="text-align: right;" readonly /></td>
                <td align="right">Closing Balance : <input type="text" id="i_subsrd_trx_cbal2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right" valign="top">GS Balance : <input type="text" id="i_subsrd_trx_gbal1" style="text-align: right;" readonly /></td>
                <td align="right" valign="top">
                    GS Balance : <input type="text" id="i_subsrd_trx_gbal2" style="text-align: right;" readonly /><br /><span id="s_subsrd_trx_gbal2" style="display:none;"></span>
                </td>
            </tr>
            <tr>
                <td align="right">Selisih : <input type="text" id="i_subsrd_trx_sel1" style="text-align: right;" readonly /></td>
                <td align="right">Selisih : <input type="text" id="i_subsrd_trx_sel2" style="text-align: right;" readonly /></td>
            </tr>
            <tr>
                <td align="right">
                    <table width="100%" border="0">
                        <tr>
                            <td valign="top" align="right">Remark:</td>
                            <td valign="top" align="right"  width="1%">
                                <textarea cols="50" rows="5" id="i_subsrd_trx_remark1"  readonly></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="right">
                    <table width="100%" border="0">
                        <tr>
                            <td valign="top" align="right">Remark:</td>
                            <td valign="top" align="right"  width="1%">
                                <textarea cols="50" rows="5" id="i_subsrd_trx_remark2" readonly></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div style="display:block; border: 1px solid #580058;margin:5px; padding: 0px; ; overflow: scroll;" >
        <table width="100%" bgcolor="#C0C0C0">
            <tr bgcolor="#F0F0F0" style="font-weight: bold;">
                <th>BJB</th>
                <th>BNI</th>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td align="right">0.00.0..0.0</td>
                <td align="right">000.0.0.0.0</td>
            </tr>
            <tr style="font-weight: bold;" bgcolor="#F0F0F0">
                <td align="right">000.000.00</td>
                <td align="right">000.000000</td>
            </tr>
        </table>
    </div>
</div>

<?php } ?>
<?php } ?>