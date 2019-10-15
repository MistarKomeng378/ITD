
<div style="width: 760px; margin: 0 auto;padding:0; background-color: #FFFFFF;">
<table width="100%" bgcolor="#969696" cellpadding="0" cellspacing="1">
    <tr bgcolor="#ffffff">
        <td width="50%" valign="top">
            <table width="100%">
                <tr>
                    <td width="100" valign="top">Kepada</td>
                    <td width="1" valign="top">:</td>
                    <td valign="top"><textarea cols="20" rows="2" style="width: 300px; height: 26px;" id="_subsrd_dlg_pay_e_to"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">Up.</td>
                    <td valign="top">:</td>
                    <td valign="top"><textarea cols="20" rows="2" style="width: 300px; height: 26px;" id="_subsrd_dlg_pay_e_up"></textarea></td>
                </tr>
                <tr>
                    <td valign="top">No. Telp</td>
                    <td valign="top">:</td>
                    <td valign="top"><input type="text" style="width: 300px;" id="_subsrd_dlg_pay_e_telp" /></td>
                </tr>
                <tr>
                    <td valign="top">No. Fax</td>
                    <td valign="top">:</td>
                    <td valign="top"><input type="text" style="width: 300px;" id="_subsrd_dlg_pay_e_fax" /></td>
                </tr>
            </table>
        </td>
        <td width="50%" valign="top">
            <table width="100%">
                <tr>
                    <td width="100" valign="top">No. Ref</td>
                    <td width="1" valign="top">:</td>
                    <td valign="top"><span  id="_subsrd_dlg_pay_e_ref"></span></td>
                </tr>
                <tr>
                    <td valign="top">Dari</td>
                    <td valign="top">:</td>
                    <td valign="top"><span id="_subsrd_dlg_pay_e_from"></span></td>
                </tr>
                <tr>
                    <td valign="top">No. Telp</td>
                    <td valign="top">:</td>
                    <td valign="top"><span id="_subsrd_dlg_pay_e_from_telp"></span></td>
                </tr>
                <tr>
                    <td valign="top">No. Fax</td>
                    <td valign="top">:</td>
                    <td valign="top"><span id="_subsrd_dlg_pay_e_from_fax"></span></td>
                </tr>
                <tr>
                    <td valign="top">Tanggal</td>
                    <td valign="top">:</td>
                    <td valign="top"><input type="text" style="width: 80px; text-align: center;"  id="_subsrd_dlg_pay_e_dt" /></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<br />
Mohon untuk dilakukan Transfer Dana dari rekening : 
( via : 
<select id="_subsrd_dlg_pay_via">
    <option value="RTGS">RTGS</option>
    <option value="Kliring" selected>Kliring</option>
    <option value="Pemindahbukuan">Pemindahbukuan</option>
</select>
)
<br /><input type="text" style="width: 600px;" id="_subsrd_dlg_pay_remark" /> <br /> <br/>
<table width="100%"  cellpadding="2" style="border: 1px solid #969696;">
    <tr bgcolor="#ffffff">
        <td width="120">Nama Rekening</td>
        <td width="1">:</td>
        <td><input type="text" id="_subsrd_dlg_pay_src_name" style="width: 400px;" /></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>No. Rekening</td>
        <td>:</td>
        <td><span id="_subsrd_dlg_pay_src_no"></span></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Txn Date</td>
        <td>:</td>
        <td><input type="text" style="width: 80px; text-align: center;"  id="_subsrd_dlg_pay_txn_dt" /></td>
    </tr>
</table> 
Ke :
<br />
<table width="100%" cellpadding="2" style="border: 1px solid #969696;">
    <tr bgcolor="#ffffff">
        <td width="120">Nama Rekening</td>
        <td width="1">:</td>
        <td><input type="text" id="_subsrd_dlg_pay_dst_name" style="width: 400px;"></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>No. Rekening</td>
        <td>:</td>
        <td><span id="_subsrd_dlg_pay_dst_no"></span></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Nama Bank</td>
        <td>:</td>
        <td><span id="_subsrd_dlg_pay_dst_bank"></span></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Jumlah</td>
        <td>:</td>
        <td>Rp. <span id="_subsrd_dlg_pay_nominal"></span></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td valign="top">Terbilang</td>
        <td valign="top">:</td>
        <td><span id="_subsrd_dlg_pay_terbilang"></span></td>
    </tr>
    <tr bgcolor="#ffffff">
        <td>Keterangan</td>
        <td>:</td>
        <td>PENGAKUAN SUBS TGL <span id="_subsrd_dlg_pay_subs_date"></span></td>
    </tr>
</table>
<br /><input type="text" style="width: 600px;" id="_subsrd_dlg_pay_info" />