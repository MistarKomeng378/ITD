<?php if(5) { ?>
    <table width="100%">
        <tr>
            <td width="25%">COA No</td>
            <td width="1%">:</td>
            <td><input type="text" id="dlgM11coa_no"  name="dlgM11coa_no" style="width:80px;" /></td>
        </tr>
        <tr>
            <td>Description</td>
            <td>:</td>
            <td><input type="text" id="dlgM11coa_desc"  name="dlgM11coa_desc" style="width:280px;" /></td>
        </tr>
        <tr>
            <td>D/C</td>
            <td>:</td>
            <td><select id="dlgM11coa_dc"  name="dlgM11coa_dc">
                <option value="C">Credit</option>
                <option value="D">Debet</option>
            </select></td>
        </tr>
        <tr>
            <td>Enable</td>
            <td>:</td>
            <td><select id="dlgM11coa_enable">
                <option value="1">Enable</option>
                <option value="0">Disable</option>
            </select></td>
        </tr>
        <tr>
            <td>Order</td>
            <td>:</td>
            <td><input type="text" id="dlgM11coa_order"  name="dlgM11coa_order" style="width:40px;text-align: right;" value="1000" /></td>
        </tr>
    </table>                 
<?php } ?>