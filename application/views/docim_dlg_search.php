<?php if($lvl>-5) { ?>
    <table width="100%">
        <tr>
            <td width="30%">Client Code</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgDocim_client_code"  name="dlgDocim_client_code" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>Fund ID</td>
            <td>:</td>
            <td><input type="text" id="dlgDocim_fund"  name="dlgDocim_fund" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>Bagian</td>
            <td>:</td>
            <td>
            <select id="dlgDocim_bagian">
                <option value="">ALL</option>
                <option value="FA">Fund Admin</option>
                <option value="CSNR">FAS</option>
                <option value="CSR">Discre</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Tanggal Scan</td>
            <td>:</td>
            <td>                                 
            <input type="text" id="dlgDocim_scan_sdate" style="width:80px;text-align:center;" /> s/d
            <input type="text" id="dlgDocim_scan_edate" style="width:80px;text-align:center;" />
            </td>
        </tr>
        <tr>
            <td>Tanggal Instruksi</td>
            <td>:</td>
            <td>                                 
            <input type="text" id="dlgDocim_inst_sdate" style="width:80px;text-align:center;" /> s/d
            <input type="text" id="dlgDocim_inst_edate" style="width:80px;text-align:center;" />
            </td>
        </tr>
    </table>                 
<?php } ?>
