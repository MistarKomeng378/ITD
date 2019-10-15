<?php if($lvl>-5) { ?>
<?php if($lvl!=2) { ?>

<div style="width: 100%; padding: 3px; background: #E0E0E0; font-weight: bold; border:1px solid #000058;" align="left">Mutasi Jasa Giro</div>
<div style="width: 100%;  padding: 3px; border:1px solid #000058;" align="left">
    <div style="display: block;">
        <input type="hidden" id="i_mutasi11_trx_id" value="0">
        <table width="100%" border="0">
            <tr>
                <td width="1%">Klien</td>
                <td width="1%">Rekening</td>
                <td width="1%">Atas Nama</td>
                <td width="1%">Last Date</td>  
                <td>Last Date Status</td>  
            </tr>
            <tr>
                <td><input type="text" id="i_mutasi11_client_code" style="width:60px;text-align: center;"  /></td>
                <td><input type="text" id="i_mutasi11_rek" style="width:120px;text-align: center;" readonly /></td>
                <td><input type="text" id="i_mutasi11_client_name" style="width:320px;text-align: left;" readonly  /></td>
                <td><input type="text" id="i_mutasi11_client_last_date" style="width:90px;text-align: center;" readonly  /></td>
                <td><input type="text" id="i_mutasi11_client_status" style="width:90px;text-align: center;" readonly  /></td>
            </tr>
        </table>
        <input type="hidden" id="i_mutasi11_dstatus" value="0">
        <table width="100%" border="0" cellpadding="2" cellspacing="0">
            <tr>
                <td colspan="8" style="border-bottom: 1px dotted #969696;"></td>
            </tr>
            <tr>
                <td width="1%">Tanggal</td>
                <td width="85">Status</td> 
                <td width="1%">Kategori</td>
                <td width="1%">D/C</td>
                <td width="1%">Keterangan</td>
                <td width="1%">Nominal</td>
                <td width="1%"></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" id="i_mutasi11_client_dt" style="width:65px;text-align: center;" class="dtpick"  /></td>
                <td><span id="s_mutasi11_dstatus" style="font-weight: bold;"></span></td>
                <td>
                    <select id="i_mutasi11_coa">
                    </select>
                </td>
                <td>
                    <select id="i_mutasi11_dc">
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </td>
                <td><input type="text" id="i_mutasi11_desc" style="width:110px;" readonly  /></td>
                <td><input type="text" id="i_mutasi11_nominal" style="width:90px;text-align: right;" readonly /></td>
                <td><input type="text" id="i_mutasi11_nominal_a" style="width:100px;text-align: right;" readonly /></td>
                <td>
                <div>
                    <input type="button" value="Tambah" id="b_mutasi11_add" />
                    <input type="button" value="Ubah" id="b_mutasi11_edit" style="display: none;" />
                    <input type="button" value="Hapus" id="b_mutasi11_del" style="display: none;" />
                    <input type="button" value="Batal" id="b_mutasi11_cancel" style="display: none;" />
                </div>
                </td>
            </tr>
        </table>
    </div>
    <div id="tbl_slick_mutasi11" style="height: 150px;"></div>
    <div style="display:block; border: 1px solid #580058;margin:5px; padding: 3px; font-weight: bold; font-size: 120%;" align="center">
        <span id="s_mutasi11_dc">D= 000,000,000.00 *** K= 000,000,000,000.00</span>
    </div>
    <div>
        <table width="100%" cellpadding="0" cellspacing="2" border="0">
            <tr>
                <td  width="50%"  align="right"><b><span id="s_mutasi11_last_dt">Last Date</span></b></td>
                <td align="right"><b><span id="s_mutasi11_current_dt">Current Date</span></b></td>
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
                                <textarea cols="50" rows="5" id="i_mutasi11_remark1"  readonly></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
                <td align="right">
                    <table width="100%" border="0">
                        <tr>
                            <td valign="top" align="right">Remark:</td>
                            <td valign="top" align="right"  width="1%">
                                <textarea cols="50" rows="5" id="i_mutasi11_remark2" readonly></textarea>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div style="display:block; border: 1px solid #580058;margin:5px; padding: 3px; font-weight: bold; font-size: 120%;" align="center">
        <span id="s_mutasi11_mon">
        Tanggal : , Status "Open": 0 Rekening, Status "Closed": 0 Rekening, <br />Balance status "Closed" dengan "Closing Balance">=Rp 100jt: 0 Rekening <br />
        Rekening yang dikenai Jasa Giro: 0 Rekening, Jasa giro yang telah dibuat: 0 Rekening
        </span>
    </div>
</div>

<?php } ?>
<?php } ?>