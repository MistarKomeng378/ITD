<?php if($lvl>-5) { ?>
    <table width="100%">
        <tr>
            <td width="30%">Client Code</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgReport11Search_client_code"  name="dlgReport11Search_client_code" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>Tanggal Valuta</td>
            <td>:</td>
            <td>                                 
            <input type="text" id="dlgReport11Search_sdate" style="width:80px;text-align:center;" value="<?php echo $today_s;?>" /> s/d
            <input type="text" id="dlgReport11Search_edate" style="width:80px;text-align:center;" value="<?php echo $today_s;?>" />
            </td>
        </tr>
        <tr>
            <td>Tipe Instruksi</td>
            <td>:</td>
            <td>
            <select id="dlgReport11Search_type">    
                <option value="0" selected>All</option>
                <option value="1">On Call</option>
                <option value="2">Time Deposit</option>
                <option value="3">Certificate of Deposit</option>
            </select>
            </td>
        </tr> 
        <tr>
            <td>Jml Hari per Tahun</td>
            <td>:</td>
            <td>
            <select id="dlgReport11Search_th">    
                <option value="360">360</option>
                <option value="365" selected>365</option>
                <option value="366">366</option>
            </select>
            </td>
        </tr> 
    </table>                 
<?php } ?>