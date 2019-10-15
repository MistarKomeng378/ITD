<?php if($lvl>-5) { ?>
    <table width="100%">
        <tr>
            <td  width="35%">Client Code</td>
            <td  width="1%">:</td>
            <td><input type="text" id="dlgBil_client_code"  name="dlgBil_client_code" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>No Bilyet</td>
            <td>:</td>
            <td><input type="text" id="dlgBil_no"  name="dlgBil_no" style="width:180px;" /></td>
        </tr> 
        <tr>
            <td>Kepada (Bank To)</td>
            <td>:</td>
            <td><input type="text" id="dlgBil_to"  name="dlgBil_to" style="width:180px;" /></td>
        </tr>
        <tr>
            <td>Client Name</td>
            <td>:</td>
            <td><input type="text" id="dlgBil_client_name"  name="dlgBil_client_name" style="width:180px;" /></td>
        </tr>
        <input type="hidden" id="dlgBil_bank_name"  name="dlgBil_bank_name" />
        <!--
        <tr>
            <td>Nama Bank</td>
            <td>:</td>
            <td><input type="text" id="dlgBil_bank_name"  name="dlgBil_bank_name" style="width:180px;" /></td>
        </tr>
        -->
         <tr>
            <td>Tanggal Valuta</td>
            <td>:</td>
            <td><input type="text" id="dlgBil_val_dt"  name="dlgBil_val_dt" style="width:80px;text-align: center;"   class="dtpick" /> (dd-mm-yyyy)</td>
        </tr>
         <tr>
            <td>Tanggal Jatuh Tempo</td>
            <td>:</td>
            <td><input type="text" id="dlgBil_due_dt"  name="dlgBil_due_dt" style="width:80px;text-align: center;"   class="dtpick" /> (dd-mm-yyyy)</td>
        </tr>
        <tr>
            <td>Nominal</td>
            <td>:</td>
            <td><input type="text" id="dlgBil_nominal"  name="dlgBil_nominal" style="width:100px;" /></td>
        </tr>
        <tr>
            <td>Bilyet In/ Out</td>
            <td>:</td>
            <td>
            <select id="dlgBil_type" name="dlgBil_type">
                <option value="0">Belum Diterima</option>
                <option value="1">IN</option>
                <option value="2">OUT</option>
                <option value="3">Belum Diterima Atau OUT</option>
                <option value="100">ALL</option>
            </select>
            </td>
        </tr>
    </table>                 
<?php } ?>