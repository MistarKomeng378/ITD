<?php if(5) { ?>
    <table width="100%">
        <tr>
            <td width="25%">Kode Reksadana</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgSubsrdClient_code"  name="dlgSubsClient_code" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>Nama Reksadana</td>
            <td>:</td>
            <td><input type="text" id="dlgSubsrdClient_name"  name="dlgSubsClient_name" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>Manager Investasi</td>
            <td>:</td>
            <td>
                <select id="dlgSubsrdClient_mi"  name="dlgSubsClient_mi" >
                </select>
            </td>
        </tr>
        <tr>
            <td>Enable</td>
            <td>:</td>
            <td>
                <select id="dlgSubsrdClient_enable"  name="dlgSubsClient_enable" >
                    <option value="1">Enable</option>
                    <option value="0">Disable</option>
                </select>
            </td>
        </tr>
    </table>                 
<?php } ?>