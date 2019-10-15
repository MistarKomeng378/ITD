<?php if($lvl>-5) { ?>
    <table width="100%">
        <tr>
            <td  width="20%">Client Code</td>
            <td  width="1%">:</td>
            <td>
                <input type="text" id="dlgTrx_client_code"  name="dlgTrx_client_code" style="width:50px;" />
                <span id="s_dlgTrx_client_code"></span>
            </td>
        </tr>
        <tr>
            <td>Tipe Deposito</td>
            <td>:</td>
            <td>
            <select id="dlgTrx_type" name="dlgTrx_type">
                <option value="1">Call Deposit</option>
                <option value="2">Time Deposit</option>           
                <option value="3">Certificate of Deposit</option>
            </select>
            </td>
        </tr>
        <tr>
            <td>Periode</td>
            <td>:</td>
            <td>
                <input type="text" id="dlgTrx_s_dt"  name="dlgTrx_s_dt" style="width:80px;text-align: center;"   class="dtpick" /> -
                <input type="text" id="dlgTrx_e_dt"  name="dlgTrx_e_dt" style="width:80px;text-align: center;"   class="dtpick" /> (dd-mm-yyyy)
            </td>
        </tr>
    </table>                 
<?php } ?>