<?php if($lvl>-5) { ?>
    <table width="100%"> 
        <tr>
            <td width="35%">Kepada</td>
            <td width="1%">:</td>
            <td><span id="dlgBilIn_to"></span></td>
        </tr>
        <tr>
            <td>Nomor Rekening</td>
            <td>:</td>
            <td><span id="dlgBilIn_client_acc"></span></td>
        </tr>
        <tr>
            <td>Nama Klien</td>
            <td>:</td>
            <td><span id="dlgBilIn_client_name"></span></td>
        </tr>
         <tr>
            <td>Rate</td>
            <td>:</td>
            <td><span id="dlgBilIn_rate"></span></td>
        </tr>
         <tr>
            <td>Tipe Transaksi</td>
            <td>:</td>
            <td><span id="dlgBilIn_type"></span></td>
        </tr>
        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td><span id="dlgBilIn_nominal"></span></td>
        </tr>
        <tr>
            <td>Tanggal Valuta</td>
            <td>:</td>
            <td><span id="dlgBilIn_val_dt"></span></td>
        </tr>
        <tr>
            <td>Tanggal Jatuh Tempo</td>
            <td>:</td>
            <td><span id="dlgBilIn_due_dt"></span></td>
        </tr>
        <tr>
            <td>Tanggal In</td>
            <td>:</td>
            <td><input type="text" id="dlgBilIn_dt" name="dlgBilIn_dt" style="width:80px;text-align: center;"   class="dtpick" /> (dd-mm-yyyy)</td>
        </tr>
        <tr>
            <td>Nomor Bilyet</td>
            <td>:</td>
            <td><input type="text" id="dlgBilIn_no"  name="dlgBilIn_no" style="width:180px;" /></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input type="checkbox" id="dlgBilIn_oncall"  name="dlgBilIn_oncall" value="1" /> Bilyet Langsung keluar</td>
        </tr>
        <tr>
            <td valign="top">Keterangan</td>
            <td valign="top">:</td>
            <td><textarea id="dlgBilIn_desc"  name="dlgBilIn_desc" cols="30" rows="3"></textarea></td>
        </tr>
    </table>                 
<?php } ?>