<?php if($lvl>-5) { ?>
    <table width="100%"> 
        <tr>
            <td width="35%">Kepada</td>
            <td width="1%">:</td>
            <td><span id="dlgBilOut_to"></span></td>
        </tr>
        <tr>
            <td>No Rekening</td>
            <td>:</td>
            <td><span id="dlgBilOut_client_acc"></span></td>
        </tr>
        <tr>
            <td>Client Name</td>
            <td>:</td>
            <td><span id="dlgBilOut_client_name"></span></td>
        </tr>
         <tr>
            <td>Rate</td>
            <td>:</td>
            <td><span id="dlgBilOut_rate"></span></td>
        </tr>
         <tr>
            <td>Tipe Transaksi</td>
            <td>:</td>
            <td><span id="dlgBilOut_type"></span></td>
        </tr>
        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td><span id="dlgBilOut_nominal"></span></td>
        </tr>
        <tr>
            <td>Tanggal Valuta</td>
            <td>:</td>
            <td><span id="dlgBilOut_val_dt"></span></td>
        </tr>
        <tr>
            <td>Tanggal Jatuh Tempo</td>
            <td>:</td>
            <td><span id="dlgBilOut_due_dt"></span></td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td>Tanggal Bilyet IN</td>
            <td>:</td>
            <td><span id="dlgBilOut_dt_in"></span></td>
        </tr>
        <tr>
            <td>Nomor Bilyet</td>
            <td>:</td>
            <td><input type="text" id="dlgBilOut_no" /></td>
        </tr>
        <tr>
            <td>Tanggal Out</td>
            <td>:</td>
            <td><input type="text" id="dlgBilOut_dt" name="dlgBilOut_dt" style="width:80px;text-align: center;"   class="dtpick" /> (dd-mm-yyyy)</td>
        </tr>
        <tr>
            <td valign="top">Keterangan</td>
            <td valign="top">:</td>
            <td><textarea id="dlgBilOut_desc"  name="dlgBilOut_desc" cols="30" rows="3"></textarea></td>
        </tr>
    </table>                 
<?php } ?>